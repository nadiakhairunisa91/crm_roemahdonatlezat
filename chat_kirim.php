<?php
session_start();
require_once('koneksi.php');

if (!isset($_SESSION['pub_id'])) {
    die("Anda harus login untuk mengirim pesan.");
}

$id_pelanggan = $_SESSION['pub_id'];
$isi_chat = trim($_POST['isi_chat']);

if ($isi_chat === "") {
    die("Pesan tidak boleh kosong!");
}

// Gunakan prepared statement untuk keamanan
$query = $mysqli->prepare("INSERT INTO tb_chat (id_pelanggan, isi_chat, balasan_admin, is_viewed, waktu) VALUES (?, ?, NULL, 0, NOW())");
$query->bind_param("is", $id_pelanggan, $isi_chat);

if ($query->execute()) {
    echo "Pesan Anda sudah dikirim! Kami akan segera membalasnya 😊";
} else {
    echo "Gagal mengirim pesan. Silakan coba lagi!";
}

$query->close();
$mysqli->close();
?>