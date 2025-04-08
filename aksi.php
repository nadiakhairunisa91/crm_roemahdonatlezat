<?php
require_once('functions.php');
if ($mod == 'keranjang_tambah') {
    if (empty($_GET['ID']) || !is_numeric($_GET['ID'])) {
        echo "<script>alert('ID produk tidak valid.'); window.location='index.php?m=produk';</script>";
        exit;
    }

    $stok = $db->get_var("SELECT stock FROM tb_produk WHERE id_produk='$_GET[ID]'");

    if ($stok == 0) {
        echo "<script>window.alert('Stok Habis'); window.location=('index.php?m=produk')</script>";
    } else {
        $temp = $db->get_row("SELECT id_temp FROM tb_temp WHERE id_produk='$_GET[ID]' AND session_id='$sid'");

        if (!$temp) {
            $db->query("INSERT INTO tb_temp (id_produk, jumlah, session_id, tgl_temp, jam_temp, stok_temp)
                VALUES ('$_GET[ID]', 1, '$sid', NOW(), NOW(), '$stok')");
        } else {
            $db->query("UPDATE tb_temp SET jumlah = jumlah + 1 WHERE session_id ='$sid' AND id_produk='$_GET[ID]'");
        }
        header('location:index.php?m=keranjang');
    }
} elseif ($mod == 'keranjang') {
    $id_temp        = $_POST['ID'];
    $jml_data       = count($id_temp);
    $jumlah    = $_POST['jml'];
    if ($_POST['apply_coupon']) {
        $promo = $db->get_row("SELECT * FROM tb_promo WHERE kode_promo='$kode_promo'");
        if ($promo) {
            $db->query("UPDATE tb_temp SET kode_promo='$kode_promo' WHERE session_id='$sid'");
            print_msg("Diskon berhasil ditambahkan!", 'success');
        } else {
            $db->query("UPDATE tb_temp SET kode_promo='' WHERE session_id='$sid'");
            print_msg("promo tidak ditemukan!");
        }
    } else if ($_POST['update']) {
        $err = false;
        for ($i = 1; $i <= $jml_data; $i++) {
            $row = $db->get_row("SELECT stok_temp FROM tb_temp WHERE id_temp='" . $id_temp[$i] . "'");

            if ($jumlah[$i] > $row->stok_temp) {
                $err = true;
                print_msg('Jumlah yang dibeli melebihi stok yang ada');
            } elseif ($jumlah[$i] < 1) {
                $err = true;
                print_msg('Jumlah harus lebih dari 0');
            } else {
                $db->query("UPDATE tb_temp SET jumlah = '" . $jumlah[$i] . "'
                    WHERE id_temp = '" . $id_temp[$i] . "'");
            }
        }
        if (!$err) print_msg("Keranjang berhasil diupdate", 'success');
    } else if ($_POST['update_poin']) {
        $poin_temp        = $_POST['poin_temp'];
        $pelanggan = $db->get_row("SELECT * FROM tb_pelanggan WHERE id_pelanggan='$IDP'");
        $total_poin = $pelanggan->poin_in + $pelanggan->poin_out;

        if ($poin_temp > $total_poin) {
            print_msg('Poin yang ada masukkan melebihi total poin yang anda miliki!');
            $db->query("UPDATE tb_temp SET poin_temp=0 WHERE session_id='$sid'");
        } elseif ($poin_temp < $POIN_KELIPATAN) {
            print_msg('Minimal poin yang bisa digunakan adalah ' . $POIN_KELIPATAN . ' untuk mendapat 1 persen diskon.');
            $db->query("UPDATE tb_temp SET poin_temp=0 WHERE session_id='$sid'");
        } else {
            $diskon_persen = floor($poin_temp / $POIN_KELIPATAN);
            $poin_temp = $diskon_persen * $POIN_KELIPATAN;
            $db->query("UPDATE tb_temp SET poin_temp='$poin_temp' WHERE session_id='$sid'");
            print_msg("Poin berhasil diterapkan!", 'success');
        }
    }
} elseif ($mod == 'keranjang_hapus') {
    $db->query("DELETE FROM tb_temp WHERE id_temp='$_GET[ID]'");
    header('location:index.php?m=keranjang');
} elseif ($mod == 'keranjang_selesai') {
    $kota = $_POST['kota'];
    $alamat = $_POST['alamat'];
    $metode_bayar = $_POST['metode_bayar'];

    $diskon_bertahap_persen = 0;
    if ($total >= 300000) {
    $diskon_bertahap_persen = floor(($total - 300000) / 100000) * 5 + 5; // 5% untuk 300 ribu dan tambahan 5% setiap 100 ribu
    }
    $diskon_bertahap_rp = ($diskon_bertahap_persen / 100) * $total;

    if ($kota == '' || $alamat == '' || $metode_bayar == '')
        print_msg("Field bertanda * harus diisi.");
    else {
        $ongkos_kirim = $db->get_var("SELECT ongkos_kirim FROM tb_kota WHERE ID='$kota'");
        $total = $_POST['total'];
        $kode_promo = $_POST['kode_promo'];
        $diskon_promo = $_POST['diskon_promo'] * 1;
        $poin_diskon = $_POST['poin_diskon'];
        $diskon_poin_persen = $_POST['diskon_poin_persen'];
        $diskon_poin_rp = $_POST['diskon_poin_rp'];
        $diskon_bertahap_persen = $_POST['diskon_bertahap_persen'];
        $diskon_bertahap_rp = $_POST['diskon_bertahap_rp'];
        $grantotal = $total - $diskon_promo -  $diskon_bertahap_rp - $diskon_poin_rp + $ongkos_kirim;

        $kode_bayar = rand(10000000, 99999999);
        $db->query("INSERT INTO tb_order ( id_order, id_pelanggan, tanggal, alamat_kirim, kota_kirim, ongkos_kirim, total, diskon_promo, kode_promo, grantotal, status, metode_bayar, kode_bayar, poin_diskon,  diskon_poin_persen, diskon_poin_rp, diskon_bertahap_persen, diskon_bertahap_rp)
            VALUES (NULL, '$_SESSION[pub_id]', NOW(), '$alamat', '$kota', '$ongkos_kirim', '$total', '$diskon_promo', '$kode_promo', '$grantotal', 'New', '$metode_bayar', '$kode_bayar', '$poin_diskon', '$diskon_poin_persen', '$diskon_poin_rp', '$diskon_bertahap_persen', '$diskon_bertahap_rp') ");

        $id_order = $db->insert_id;

        if ($poin_diskon > 0) {
            $db->query("INSERT INTO tb_poin (id_pelanggan, tanggal_poin, ref_poin, jumlah_poin, ket_poin) VALUES ('$IDP', NOW(), '$id_order', -$poin_diskon, 'Diskon pemesanan $id_order')");
            update_poin($IDP);
        }

        $db->query("INSERT INTO tb_detail (id_order, id_produk, harga, diskon_detail, jumlah, subtotal) SELECT '$id_order', t.id_produk, b.harga, b.diskon/100 * b.harga, t.jumlah, (100-b.diskon)/100 * b.harga * t.jumlah 
            FROM tb_temp t INNER JOIN tb_produk b ON b.id_produk=t.id_produk 
            WHERE session_id='$sid'");

        $rows = $db->get_results("SELECT * FROM tb_temp WHERE session_id='$sid'");
        foreach ($rows as $row) {
            $jumlah = $row->jumlah * 1;
            $db->query("UPDATE tb_produk SET stock = stock-$jumlah WHERE id_produk='$row->id_produk'");
        }

        $db->query("DELETE FROM tb_temp WHERE session_id='$sid'");
        redirect_js("index.php?m=order_detail&ID=$id_order");
    }
} elseif ($mod == 'order_konfirmasi') {
    $nama = $_POST['nama'];
    $gambar = $_FILES['gambar'];

    if ($nama == '' || $gambar['name'] == '')
        print_msg('Field yang bertanda * harus diisi.');
    elseif ($gambar['type'] != 'image/jpeg' && $gambar['type'] != 'image/png')
        print_msg('Bukti harus dalam bentuk gambar (*.jpg, *.png).');
    else {
        $nama_file = rand(10, 99) . parse_file_name($gambar['name']);
        move_uploaded_file($gambar['tmp_name'], 'assets/images/bukti_bayar/' . $nama_file);

        $db->query("INSERT INTO tb_bayar (id_order, tanggal, nama, gambar)
            VALUES ('$_GET[ID]', NOW(), '$nama', '$nama_file')");
        $db->query("UPDATE tb_order SET status='Pending' WHERE id_order='$_GET[ID]'");

        redirect_js("index.php?m=order_detail&ID=$_GET[ID]");
    }
}

/** ========== MEMBER ==========*/
elseif ($mod == 'daftar') {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];
    $nama_kota = $_POST['nama_kota'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];

    if ($nama_pelanggan == '' || $email == '' || $pass1 == '' || $pass2 == '') {
        print_msg("Field bertanda * harus diisi");
    } else {
        $db->query("INSERT INTO tb_pelanggan (nama_pelanggan, password, jenis_kelamin, alamat, nama_kota,  telepon, email)
            VALUES('$nama_pelanggan', '$pass1', '$jk', '$alamat', '$nama_kota',  '$telepon', '$email')");
        print_msg("Pendaftaran berhasil. Silahkan <a href='?m=login'>login</a>.", 'success');
    }
} else if ($mod == 'login') {
    $email      = $_POST['email'];
    $password   = $_POST['password'];

    $row = $db->get_row("SELECT * FROM tb_pelanggan WHERE email='$email' AND password='$password'");
    if (!$row) {
        print_msg("<p>Salah kombinasi email dan password.</p>");
    } else {
        $_SESSION['pub_id'] = $row->id_pelanggan;
        $_SESSION['pub_nama'] = $row->nama_pelanggan;
        redirect_js('index.php?m=member');
    }
}
elseif ($act == 'member_update_profile') {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];
    $nama_kota = $_POST['nama_kota'];
    $telepon = $_POST['telepon'];

    if ($nama_pelanggan == '') {
        print_msg("Field bertanda * harus diisi");
    } else {
        $db->query("UPDATE tb_pelanggan SET nama_pelanggan='$nama_pelanggan', jenis_kelamin ='$jk', alamat='$alamat', nama_kota='$nama_kota',  telepon='$telepon' WHERE id_pelanggan='$_SESSION[pub_id]'");
        print_msg("Update data profil berhasil.", 'success');
        redirect_js('index.php?m=member');
    }
}

else if ($act == 'member_ubah_password') {
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $password3 = $_POST['password3'];

    $pass_correct = $db->get_row("SELECT * FROM tb_pelanggan WHERE id_pelanggan='$_SESSION[pub_id]' AND password='$password1'");

    if ($password1 == '' || $password2 == '' || $password3 == '')
        print_msg('Field bertanda * tidak boleh kosong.');
    elseif (!$pass_correct)
        print_msg('Password lama salah.');
    elseif ($password2 != $password3)
        print_msg('Pasword baru dan konfirmasi password baru tidak sama.');
    elseif (strlen($password2) < 4 || strlen($password2) > 16)
        print_msg('Pasword baru harus 4-16 karakter.');
    else {
        $db->query("UPDATE tb_pelanggan SET password='$password2' WHERE id_pelanggan='$_SESSION[pub_id]'");
        print_msg("Password berhasil diubah.", 'success');
    }
} else if ($act == 'logout') {
    unset($_SESSION['pub_id'], $_SESSION['pub_nama']);
    header("location:index.php?m=member");
} else if ($act == 'order_cancel') {
    $db->query("UPDATE tb_order SET status='Cancel' WHERE id_order='$_GET[ID]'");
    $rows = $db->get_results("SELECT * FROM tb_detail WHERE id_order='$_GET[ID]'");
    foreach ($rows as $row) {
        $jumlah = $row->jumlah * 1;
        $db->query("UPDATE tb_produk SET stock=stock + $jumlah WHERE id_produk='$row->id_produk'");
    }
    header("location:index.php?m=order_detail&ID=$_GET[ID]");
} else if ($act == 'order_selesai') {
    tambah_poin($_GET['ID']);
    $db->query("UPDATE tb_order SET status='Selesai' WHERE id_order='$_GET[ID]'");
    header("location:index.php?m=order_detail&ID=$_GET[ID]");
} else if ($act == 'order_indomaret') {
    $db->query("UPDATE tb_order SET status='Pending' WHERE id_order='$_GET[ID]'");
    header("location:index.php?m=order_detail&ID=$_GET[ID]");
} elseif ($mod == 'komentar_tambah') {
    $id_detail = $_POST['id_detail'];
    $bintang = $_POST['bintang'];
    $isi_komentar = $_POST['isi_komentar'];

    if ($id_detail == '' || $bintang == '') {
        print_msg("Field bertanda * harus diisi");
    } else {
        $db->query("INSERT INTO tb_komentar (id_detail, bintang, isi_komentar, tanggal_komentar) VALUES('$id_detail', '$bintang', '$isi_komentar', NOW())");
        $db->query("UPDATE tb_detail SET reviewed=1 WHERE id_detail='$id_detail'");
        redirect_js('index.php?m=komentar');
    }
}
// === FITUR CHAT PELANGGAN ===
else if ($mod == 'chat_kirim') {
    if (!isset($_SESSION['pub_id'])) {
        die("Anda harus login untuk mengirim pesan.");
    }

    $id_pelanggan = $_SESSION['pub_id'];
    $isi_chat = trim($_POST['isi_chat']);

    if ($isi_chat === "") {
        die("Pesan tidak boleh kosong!");
    }

    $query = "INSERT INTO tb_chat (id_pelanggan, isi_chat, waktu) VALUES (?, ?, NOW())";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("is", $id_pelanggan, $isi_chat);
    $stmt->execute();
    $stmt->close();
}

// === BALASAN ADMIN ===
else if ($mod == 'chat_balas') {
    if (!isset($_SESSION['adm_id'])) {
        die("Hanya admin yang dapat membalas pesan.");
    }

    $id_chat = $_POST['id_chat'];
    $balasan_admin = trim($_POST['balasan_admin']);

    if ($balasan_admin === "") {
        die("Balasan tidak boleh kosong!");
    }

    $query = "UPDATE tb_chat SET balasan_admin = ?, waktu = NOW() WHERE id_chat = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("si", $balasan_admin, $id_chat);
    $stmt->execute();
    $stmt->close();
    header("Location: chat_admin.php");
    exit();
}

// === BALAS PESAN ADMIN ===
else if ($mod == 'chat_balasan') {
    if (!isset($_SESSION['adm_id'])) {
        die("Hanya admin yang dapat mengakses halaman ini.");
    }

    $id_chat = intval($_POST['id_chat']);
    $balasan_admin = trim($_POST['balasan_admin']);

    if ($balasan_admin === "") {
        die("Balasan tidak boleh kosong!");
    }

    $query = "UPDATE tb_chat SET balasan_admin = ?, waktu = NOW() WHERE id_chat = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("si", $balasan_admin, $id_chat);

    if ($stmt->execute()) {
        echo "Balasan terkirim!";
    } else {
        echo "Gagal mengirim balasan!";
    }

    $stmt->close();
}
