<?php
include '../koneksi.php';
session_start();

// Pastikan hanya admin yang bisa mengakses halaman ini
if (!isset($_SESSION['adm_id'])) {
    die("Hanya admin yang dapat mengakses halaman ini.");
}

// Ambil daftar pelanggan yang memiliki chat
$query_pelanggan = "SELECT DISTINCT id_pelanggan FROM tb_chat ORDER BY id_pelanggan ASC";
$result_pelanggan = $mysqli->query($query_pelanggan);
if (!$result_pelanggan) {
    die("Query gagal: " . $mysqli->error);
}

// Ambil ID pelanggan dari URL
$id_pelanggan = isset($_GET['id_pelanggan']) ? intval($_GET['id_pelanggan']) : 0;

// Ambil semua chat dari pelanggan tertentu jika ID pelanggan dipilih
$chat_result = [];
if ($id_pelanggan) {
    $query_chat = "SELECT * FROM tb_chat WHERE id_pelanggan = $id_pelanggan ORDER BY waktu DESC";
    $chat_result = $mysqli->query($query_chat);
    if (!$chat_result) {
        die("Query gagal: " . $mysqli->error);
    }
}

// Menghitung jumlah pesan baru untuk semua pelanggan
$result = $mysqli->query("SELECT COUNT(*) FROM tb_chat WHERE id_pelanggan != $id_pelanggan");
if (!$result) {
    die("Query gagal: " . $mysqli->error);
}
$new_messages_count = $result->fetch_row()[0]; // Ambil nilai dari hasil query
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Pelanggan</title>
</head>
<style>
    

.footer {
    background-color: #343a40; /* Warna footer abu-abu gelap */
    color: white; /* Warna teks di footer */
    
}

/* Tambahan untuk tombol */
/* Gaya untuk judul */
h2.text-center {
    font-size: 2rem; /* Ukuran font yang lebih besar untuk judul */
    color: #007bff; /* Warna biru cerah untuk judul */
    margin-bottom: 20px; /* Jarak bawah untuk memberi ruang */
    text-transform: uppercase; /* Mengubah teks menjadi huruf kapital */
    letter-spacing: 1px; /* Jarak antar huruf */
    font-weight: bold; /* Menebalkan teks */
}

/* Gaya untuk daftar pelanggan */
.list-group {
    border-radius: 8px; /* Sudut melengkung untuk daftar */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Bayangan untuk efek kedalaman */
    background-color: #ffffff; /* Latar belakang putih untuk daftar */
}

/* Gaya untuk item daftar */
.list-group-item {
    display: flex; /* Menggunakan flexbox untuk tata letak */
    justify-content: space-between; /* Menyebar konten di antara dua sisi */
    align-items: center; /* Menyelaraskan item secara vertikal */
    padding: 15px; /* Padding yang lebih besar untuk kenyamanan */
    transition: background-color 0.3s, transform 0.3s; /* Transisi halus untuk perubahan warna latar belakang dan efek zoom */
}

/* Efek hover untuk item daftar */
.list-group-item:hover {
    background-color: #f0f8ff; /* Warna latar belakang saat hover */
    transform: translateY(-2px); /* Efek angkat saat hover */
}

/* Gaya untuk tautan dalam item daftar */
.list-group-item a {
    text-decoration: none; /* Menghapus garis bawah dari tautan */
    color: #333; /* Warna teks gelap untuk tautan */
    font-weight: 500; /* Menebalkan teks tautan */
    transition: color 0.3s; /* Transisi halus untuk perubahan warna */
}

/* Efek hover untuk tautan */
.list-group-item a:hover {
    color: #0056b3; /* Warna teks saat hover */
}

/* Gaya untuk badge */
.badge {
    background-color: #ffc107; /* Warna badge kuning */
    font-size: 0.9em; /* Ukuran font badge */
    margin-left: 10px; /* Jarak kiri untuk badge */
    padding: 5px 10px; /* Padding untuk badge */
    border-radius: 12px; /* Sudut badge melengkung */
    font-weight: bold; /* Menebalkan teks badge */
}
</style>
<body>
    <div class="container">
        <h2 class="text-center">Daftar Pelanggan</h2>
        <ul class="list-group mb-3">
            <?php while ($pelanggan = $result_pelanggan->fetch_assoc()): ?>
                <li class="list-group-item">
                    <a href="chat_balasan.php?id_pelanggan=<?= $pelanggan['id_pelanggan']; ?>">
                        Pelanggan #<?= $pelanggan['id_pelanggan']; ?>
                        <?php
                        // Hitung jumlah pesan yang belum dibalas
                        $unanswered_count_result = $mysqli->query("SELECT COUNT(*) FROM tb_chat WHERE id_pelanggan = {$pelanggan['id_pelanggan']} AND balasan_admin IS NULL");
                        if (!$unanswered_count_result) {
                            die("Query gagal: " . $mysqli->error);
                        }
                        $unanswered_count = $unanswered_count_result->fetch_row()[0]; // Ambil nilai dari hasil query

                        // Menampilkan badge untuk pesan yang belum dibalas
                        if ($unanswered_count > 0) {
                            echo '<span class="badge bg-warning">' . $unanswered_count . ' belum dibalas</span>'; // Menampilkan badge jika ada pesan yang belum dibalas
                        }
                        ?>
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>
        
    </div>
</body>
</html>