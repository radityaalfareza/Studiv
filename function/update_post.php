<?php
session_start();
require_once '../config/koneksi.php';

if (!isset($_SESSION['account_id'])) {
    header("Location: ../halaman_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = intval($_POST['post_id']);
    $community = $_POST['subreddit'];
    $title = $_POST['title'];
    $body = $_POST['text-body'];
    $image_url = $_POST['image-url'];
    $account_id = $_SESSION['account_id'];

    $query = "UPDATE post SET community = ?, title = ?, body = ?, image_url = ?, updated_at = NOW() WHERE id = ? AND owner = ?";
    $stmt = mysqli_prepare($link, $query);
    mysqli_stmt_bind_param($stmt, "ssssii", $community, $title, $body, $image_url, $post_id, $account_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../profile.php"); // atau redirect ke detail post
        exit;
    } else {
        echo "Gagal mengupdate post.";
    }
}
?>
