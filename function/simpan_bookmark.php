<?php
session_start();
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = intval($_POST['post_id']);
    $account_id = $_SESSION['account_id'];  // lebih aman ambil dari session daripada form input

    // Cek apakah bookmark sudah ada
    $cek_sql = "SELECT * FROM bookmark WHERE account_id = ? AND post_id = ?";
    $stmt = mysqli_prepare($link, $cek_sql);
    mysqli_stmt_bind_param($stmt, "ii", $account_id, $post_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        // Insert bookmark baru
        $insert_sql = "INSERT INTO bookmark (account_id, post_id, created_at) VALUES (?, ?, NOW())";
        $stmt_insert = mysqli_prepare($link, $insert_sql);
        mysqli_stmt_bind_param($stmt_insert, "ii", $account_id, $post_id);
        mysqli_stmt_execute($stmt_insert);
        mysqli_stmt_close($stmt_insert);
    }
    mysqli_stmt_close($stmt);

    // Setelah selesai simpan, redirect ke bookmark.php
    header("Location: ../bookmark.php");
    exit;
} else {
    header("Location: ../beranda.php");
    exit;
}
