<?php
session_start();

$GEMINI_API_KEY; 

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['prompt']) || empty($input['prompt'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Prompt is required']);
    exit;
}

$userPrompt = $input['prompt'];

$gemini_api_endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $GEMINI_API_KEY;

$postData = json_encode([
    'contents' => [
        [
            'parts' => [
                [
                    'text' => $userPrompt
                ]
            ]
        ]
    ]
]);

$options = [
    'http' => [
        'header'  => "Content-Type: application/json\r\n",
        'method'  => 'POST',
        'content' => $postData,
        'ignore_errors' => true // Important to get response headers (including status code) even on HTTP errors
    ]
];
$context  = stream_context_create($options);

// Make the request
$responseContent = @file_get_contents($gemini_api_endpoint, false, $context);

// Get response headers to extract status code
$statusCode = 0;
if (isset($http_response_header)) { // $http_response_header is populated by file_get_contents()
    preg_match('{HTTP\/\S+\s(\d{3})}', $http_response_header[0], $match);
    $statusCode = $match[1];
}

// ----------- End of Modified Section -----------

if ($responseContent === FALSE) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to connect to Gemini API or read response. Check allow_url_fopen setting.']);
    exit;
}

if ($statusCode != 200) {
    http_response_code($statusCode);
    echo json_encode(['error' => 'Gemini API Error', 'status_code' => $statusCode, 'raw_response' => $responseContent]);
    exit;
}

$result = json_decode($responseContent, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(500);
    echo json_encode(['error' => 'Response not valid JSON', 'raw_response' => $responseContent]);
    exit;
}

if (isset($result['candidates']) && isset($result['candidates'][0]['content']['parts'][0]['text'])) {
    $aiContent = $result['candidates'][0]['content']['parts'][0]['text'];

    // Gemini API response usually doesn't include Markdown bolding like Hugging Face's router did,
    // but you can keep this line if you anticipate it or other unwanted characters.
    $cleanedContent = str_replace('**', '', $aiContent); 

    echo json_encode(['choices' => [['message' => ['content' => $cleanedContent]]]]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Unexpected response format from Gemini API', 'raw_response' => $result]);
}

?>