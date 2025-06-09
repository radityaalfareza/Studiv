<?php

$host = "sql307.infinityfree.com";
$user = "if0_39118074";
$paswd = "Heyakid157";
$name = "if0_39118074_studiv";

$link = mysqli_connect($host, $user, $paswd, $name);

if (!$link) {
    die("Koneksi dengan database gagal: " . mysqli_connect_errno() . "-" . mysqli_connect_error());
}
?>
<!-- require_once 'config/koneksi.php'; -->