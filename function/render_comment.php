<?php
if (!isset($postId)) {
    die('postId belum di-set dari file utama');
}

require_once '../../config/koneksi.php';


function getComments($link, $postId) {
    $query = "SELECT c.*, a.username 
              FROM comment c 
              JOIN account a ON c.owner = a.id 
              WHERE c.comment_at = ? 
              ORDER BY c.created_at ASC";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $postId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $comments = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $comments[] = $row;
    }
    return $comments;
}

function renderComments($link, $postId) {
    $comments = getComments($link, $postId);
    foreach ($comments as $comment) {
        echo '<div class="bg-white rounded-md shadow p-4 mb-4">';
        echo '  <div class="flex items-start space-x-3">';
        echo '    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-bold">' . strtoupper(substr($comment['username'], 0, 1)) . '</div>';
        echo '    <div class="flex-1">';
        echo '      <div class="flex justify-between">';
        echo '        <span class="font-semibold text-blue-600">' . htmlspecialchars($comment['username']) . '</span>';
        echo '        <span class="text-sm text-gray-500">' . htmlspecialchars($comment['created_at']) . '</span>';
        echo '      </div>';
        echo '      <p class="text-gray-700 mt-2">' . nl2br(htmlspecialchars($comment['body'])) . '</p>';
        echo '    </div>';
        echo '  </div>';
        echo '</div>';
    }
}

function countComments($link, $postId) {
    $query = "SELECT COUNT(*) FROM comment WHERE comment_at = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "i", $postId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    return $count;
}

// Hitung dan tampilkan jumlah komentar
$totalComments = countComments($link, $postId);
echo "<p class='text-gray-700 mb-4'>Total komentar: <strong>$totalComments</strong></p>";

// Tampilkan semua komentar
renderComments($link, $postId);
?>
