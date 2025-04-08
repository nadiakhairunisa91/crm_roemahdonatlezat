<?php
session_start();
require_once('koneksi.php');

global $mysqli;

if (!isset($_SESSION['pub_id'])) {
    die("Anda harus login untuk mengakses chat.");
}

$id_pelanggan = $_SESSION['pub_id'];

// Ambil chat dari database
$query = "SELECT * FROM tb_chat WHERE id_pelanggan = ? ORDER BY waktu ASC";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $id_pelanggan);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error dalam query: " . $mysqli->error);
}

// Update status pesan menjadi dilihat
$updateQuery = "UPDATE tb_chat SET is_viewed = 1 WHERE id_pelanggan = ? AND is_viewed = 0";
$updateStmt = $mysqli->prepare($updateQuery);
$updateStmt->bind_param("i", $id_pelanggan);
$updateStmt->execute();

// Gaya CSS untuk chat
echo "<style>
    .chat-container { width: 100%; margin: auto; font-family: Arial, sans-serif; }
    .chat { max-width: 70%; padding: 10px; border-radius: 10px; margin: 5px 0; display: inline-block; word-wrap: break-word; }
    .admin { background-color: green; color: white; text-align: left; float: left; clear: both; }
    .pelanggan { background-color: blue; color: white; text-align: right; float: right; clear: both; }
    .belum-dibalas { background-color: gray !important; }
</style>";

echo "<div class='chat-container'>";

$unansweredCount = 0; // Hitung jumlah balasan yang belum dilihat

while ($row = $result->fetch_assoc()) {
    // Jika ada balasan admin, tampilkan chat pelanggan dalam warna biru
    // Jika belum dibalas, chat pelanggan berwarna abu-abu
    $pelangganClass = ($row['balasan_admin']) ? "pelanggan" : "pelanggan belum-dibalas";

    // Menampilkan chat pelanggan
    echo "<p class='chat $pelangganClass'><strong>Anda:</strong> " . htmlspecialchars($row['isi_chat']) . "</p>";

    // Menampilkan chat admin jika sudah ada balasan
    if ($row['balasan_admin']) {
        echo "<p class='chat admin'><strong>Admin:</strong> " . htmlspecialchars($row['balasan_admin']) . "</p>";
    } else {
        $unansweredCount++; // Hitung balasan yang belum dilihat
    }
}

echo "</div>";
?>