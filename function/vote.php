<?php
header('Content-Type: application/json');
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../config/koneksi.php';

if (!isset($_POST['post_id'], $_POST['vote_type'])) {
    ob_clean();
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$post_id = intval($_POST['post_id']);
$vote_type = $_POST['vote_type'];

if ($vote_type === 'up') {
    $query = "UPDATE post SET vote = vote + 1 WHERE id = ?";
} elseif ($vote_type === 'down') {
    $query = "UPDATE post SET vote = vote - 1 WHERE id = ?";
} else {
    ob_clean();
    echo json_encode(['error' => 'Invalid vote type']);
    exit;
}

$stmt = mysqli_prepare($link, $query);
if (!$stmt) {
    ob_clean();
    echo json_encode(['error' => 'Prepare failed']);
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $post_id);
if (!mysqli_stmt_execute($stmt)) {
    ob_clean();
    echo json_encode(['error' => 'Execute failed']);
    exit;
}

$stmt2 = mysqli_prepare($link, "SELECT vote FROM post WHERE id = ?");
if (!$stmt2) {
    ob_clean();
    echo json_encode(['error' => 'Prepare select failed']);
    exit;
}

mysqli_stmt_bind_param($stmt2, "i", $post_id);
mysqli_stmt_execute($stmt2);
$result = mysqli_stmt_get_result($stmt2);
$row = mysqli_fetch_assoc($result);

if ($row) {
    ob_clean();
    echo json_encode(['success' => true, 'new_vote' => (int)$row['vote']]);
} else {
    ob_clean();
    echo json_encode(['error' => 'Vote updated but fetch failed']);
}
exit;
