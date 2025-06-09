<?php
require_once '../config/koneksi.php'; // sesuaikan path
session_start();

header('Content-Type: application/json');

// Ambil data POST
$postId = isset($_POST['postId']) ? (int)$_POST['postId'] : 0;
$commentBody = trim($_POST['commentBody'] ?? '');
$replyTo = isset($_POST['replyTo']) && is_numeric($_POST['replyTo']) ? (int)$_POST['replyTo'] : null;

// Owner sementara, nanti bisa dari session login
$owner_id = $_SESSION['account_id'];

if ($postId <= 0 || empty($commentBody)) {
    echo json_encode(['success' => false, 'error' => 'Data komentar tidak lengkap']);
    exit;
}

// Cek post exist
$post_check = mysqli_prepare($link, "SELECT id FROM post WHERE id = ?");
mysqli_stmt_bind_param($post_check, "i", $postId);
mysqli_stmt_execute($post_check);
mysqli_stmt_store_result($post_check);
if (mysqli_stmt_num_rows($post_check) === 0) {
    echo json_encode(['success' => false, 'error' => 'Post tidak ditemukan']);
    exit;
}
mysqli_stmt_close($post_check);

// Insert komentar
if ($replyTo) {
    // Insert comment with parent (reply)
    $stmt = mysqli_prepare($link, "INSERT INTO comment (owner, body, comment_at, parent) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "isii", $owner_id, $commentBody, $postId, $replyTo);
} else {
    // Insert comment biasa tanpa parent
    $stmt = mysqli_prepare($link, "INSERT INTO comment (owner, body, comment_at) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "isi", $owner_id, $commentBody, $postId);
}

if (!mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => false, 'error' => 'Gagal menyimpan komentar']);
    exit;
}

$comment_id = mysqli_insert_id($link);

// Ambil info komentar baru dengan username dan waktu
$comment_query = mysqli_prepare($link,
    "SELECT c.id, c.body, c.created_at, a.username FROM comment c
     JOIN account a ON c.owner = a.id WHERE c.id = ?");
mysqli_stmt_bind_param($comment_query, "i", $comment_id);
mysqli_stmt_execute($comment_query);
mysqli_stmt_bind_result($comment_query, $id, $body, $created_at, $username);
mysqli_stmt_fetch($comment_query);
mysqli_stmt_close($comment_query);

echo json_encode([
    'success' => true,
    'comment' => [
        'id' => $id,
        'body' => htmlspecialchars($body),
        'created_at' => $created_at,
        'username' => htmlspecialchars($username),
    ]
]);
exit;
?>