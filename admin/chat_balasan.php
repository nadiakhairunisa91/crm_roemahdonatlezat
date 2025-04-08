<?php
include '../koneksi.php';
session_start();

// Pastikan hanya admin yang bisa mengakses halaman ini
if (!isset($_SESSION['adm_id'])) {
    die("Hanya admin yang dapat mengakses halaman ini.");
}

// Ambil ID pelanggan dari URL
$id_pelanggan = isset($_GET['id_pelanggan']) ? intval($_GET['id_pelanggan']) : 0;

// Ambil semua chat dari pelanggan tertentu
$query_chat = "SELECT * FROM tb_chat WHERE id_pelanggan = $id_pelanggan ORDER BY waktu ASC"; // Mengurutkan berdasarkan waktu ASC
$chat_result = $mysqli->query($query_chat);
if (!$chat_result) {
    die("Query gagal: " . $mysqli->error);
}

// Jika form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_chat = intval($_POST['id_chat']);
    $balasan = $mysqli->real_escape_string($_POST['balasan']);

    // Update balasan admin
    $update = "UPDATE tb_chat SET balasan_admin = '$balasan' WHERE id_chat = $id_chat";
    if ($mysqli->query($update)) {
        echo "<script>alert('Balasan berhasil dikirim!'); window.location='chat_balasan.php?id_pelanggan=$id_pelanggan';</script>";
    } else {
        echo "<script>alert('Gagal mengirim balasan.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Balasan Pelanggan #<?= $id_pelanggan; ?></title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        .header {
        margin: 0; /* Menghilangkan margin untuk judul */
        padding: 5px; /* Mengatur padding untuk header */
        background-color: #007bff;
        color: white;
        border-radius: 10px 10px 0 0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        text-align: center; /* Menyelaraskan teks ke tengah */
    }
        .chat-container {
            flex: 1;
            margin-top: 0;
            border-radius: 0 0 10px 10px;
            background-color: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
            display: flex;
            flex-direction: column;
        }
        .card-body {
            max-height: 400px; /* Set a maximum height for scrolling */
            overflow-y: auto; /* Enable scrolling */
            display: flex;
            flex-direction: column; /* Keep messages in column */
            padding: 15px;
        }
        .chat-message {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 10px;
            width: fit-content;
            max-width: 80%;
            position: relative;
        }
        .chat-message.admin {
            background-color: #d4edda;
            text-align: right;
            align-self: flex-end; /* Align admin messages to the right */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .chat-message.customer {
            background-color: #cce5ff;
            text-align: left;
            align-self: flex-start; /* Align customer messages to the left */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .input-area {
            padding: 10px;
            background-color: #ffffff;
            border-top: 1px solid #ddd;
        }
        .btn {
            border-radius: 40px;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .btn-back {
            margin-bottom: 20px;
        }
    </style>
    <script>
        function selectChat(id_chat) {
            document.getElementById('selected_chat_id').value = id_chat;
            document.getElementById('balasan').focus();
        }
    </script>
</head>
<a href="index.php?m=chat_admin" class="btn btn-secondary btn-lg btn-block mt-3">Kembali ke Menu Utama</a>

<body>
    <div class="container">
        <br>
        <div class="header">
            <h3>Percakapan dengan Pelanggan #<?= $id_pelanggan; ?></h3></div>
        <div class="chat-container">
            <div class="card-body">
                <?php while ($chat = $chat_result->fetch_assoc()): ?>
                    <div class="chat-message customer">
                        <strong>Pelanggan:</strong> <?= htmlspecialchars($chat['isi_chat']); ?>
                        <button class="btn btn-primary btn-sm mt-2" onclick="selectChat(<?= $chat['id_chat']; ?>)">Balas
                        </div>
                    <div class="chat-message admin">
                        <strong>Balasan Admin:</strong> <?= htmlspecialchars($chat['balasan_admin'] ?? 'Belum dibalas'); ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        <div class="input-area">
            <form method="post">
                <input type="hidden" name="id_chat" id="selected_chat_id" value="">
                <textarea name="balasan" id="balasan" class="form-control" placeholder="Ketik balasan di sini..." required></textarea> <br>
               <button type="submit" class="btn btn-success mt-2">Kirim Balasan</button>
            </form>