<?php
require_once "config/koneksi.php";
session_start();

if (!isset($_SESSION['account_id'])) {
    header("Location: halaman_login.php");
    exit();
}

$owner_id = $_SESSION['account_id'];

if (!isset($_GET['post_id']) || !is_numeric($_GET['post_id'])) {
    // Jika post_id tidak valid, redirect ke halaman post
    header("Location: all_posts.php");
    exit();
}

$post_id = intval($_GET['post_id']);

// Cek apakah post dengan id ini milik user yang login
$query_check = "SELECT id FROM post WHERE id = ? AND owner = ?";
$stmt_check = mysqli_prepare($link, $query_check);
mysqli_stmt_bind_param($stmt_check, "ii", $post_id, $owner_id);
mysqli_stmt_execute($stmt_check);
mysqli_stmt_store_result($stmt_check);

if (mysqli_stmt_num_rows($stmt_check) === 0) {
    // Post tidak ditemukan atau bukan milik user
    mysqli_stmt_close($stmt_check);
    header("Location: my_posts.php?error=notfound");
    exit();
}

mysqli_stmt_close($stmt_check);

// Hapus post
$query_delete = "DELETE FROM post WHERE id = ? AND owner = ?";
$stmt_delete = mysqli_prepare($link, $query_delete);
mysqli_stmt_bind_param($stmt_delete, "ii", $post_id, $owner_id);

if (mysqli_stmt_execute($stmt_delete)) {
    mysqli_stmt_close($stmt_delete);
    // Redirect ke halaman post dengan pesan sukses
    header("Location: all_posts.php?success=deleted");
    exit();
} else {
    mysqli_stmt_close($stmt_delete);
    // Jika gagal hapus
    header("Location: all_posts.php?error=deletefail");
    exit();
}
