<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['account_id'])) {
    echo json_encode(["success" => false, "error" => "Unauthorized"]);
    exit;
}

$account_id = $_SESSION['account_id'];
$post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
$vote_type = $_POST['vote_type'] ?? '';

if (!in_array($vote_type, ['up', 'down'])) {
    echo json_encode(["success" => false, "error" => "Invalid vote type"]);
    exit;
}

// Cek apakah user sudah pernah vote
$stmt = mysqli_prepare($link, "SELECT vote_type FROM vote WHERE account_id = ? AND post_id = ?");
mysqli_stmt_bind_param($stmt, "ii", $account_id, $post_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $existing_vote);
$has_vote = mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$vote_cleared = false;

if (!$has_vote) {
    // Belum pernah vote -> insert
    $stmt = mysqli_prepare($link, "INSERT INTO vote (account_id, post_id, vote_type) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iis", $account_id, $post_id, $vote_type);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Update vote count +1 atau -1
    $delta = ($vote_type === 'up') ? 1 : -1;
    mysqli_query($link, "UPDATE post SET vote = vote + ($delta) WHERE id = $post_id");
} elseif ($existing_vote === $vote_type) {
    // Vote ulang tipe sama -> hapus
    $stmt = mysqli_prepare($link, "DELETE FROM vote WHERE account_id = ? AND post_id = ?");
    mysqli_stmt_bind_param($stmt, "ii", $account_id, $post_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Kurangi vote
    $delta = ($vote_type === 'up') ? -1 : 1;
    mysqli_query($link, "UPDATE post SET vote = vote + ($delta) WHERE id = $post_id");
    $vote_cleared = true;
} else {
    // Vote beda tipe -> update
    $stmt = mysqli_prepare($link, "UPDATE vote SET vote_type = ? WHERE account_id = ? AND post_id = ?");
    mysqli_stmt_bind_param($stmt, "sii", $vote_type, $account_id, $post_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Ubah vote: dari up ke down (-2) atau sebaliknya (+2)
    $delta = ($vote_type === 'up') ? 2 : -2;
    mysqli_query($link, "UPDATE post SET vote = vote + ($delta) WHERE id = $post_id");
}

// Ambil vote terbaru
$result = mysqli_query($link, "SELECT vote FROM post WHERE id = $post_id");
$row = mysqli_fetch_assoc($result);
$new_vote = $row['vote'] ?? 0;

ob_clean();
echo json_encode([
    "success" => true,
    "new_vote" => $new_vote,
    "vote_cleared" => $vote_cleared
]);

?>
