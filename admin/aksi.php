<?php
session_start();
require_once('../functions.php');

/** ========== BARANG ========== */
if ($mod == 'produk_tambah') {
    $id_kategori = $_POST['id_kategori'];
    $nama_produk = $_POST['nama_produk'];
    $gambar = $_FILES['gambar'];
    $harga = $_POST['harga'];
    $stock = $_POST['stock'];
    $diskon = $_POST['diskon'];
    $keterangan = $_POST['keterangan'];

    if ($nama_produk == '' || $gambar['name'] == '') {
        print_msg("Field bertanda * harus diisi");
    } else {
        $gbr = upload_produk($gambar);

        $db->query("INSERT INTO tb_produk (id_kategori, nama_produk, harga, stock, diskon, gambar, keterangan)
                    VALUES('$id_kategori', '$nama_produk', '$harga', '$stock', '$diskon', '$gbr', '$keterangan')");
        redirect_js('index.php?m=produk');
    }
} elseif ($mod == 'produk_ubah') {
    $id_kategori = $_POST['id_kategori'];
    $nama_produk = $_POST['nama_produk'];
    $gambar = $_FILES['gambar'];
    $harga = $_POST['harga'];
    $stock = $_POST['stock'];
    $diskon = $_POST['diskon'];
    $keterangan = $_POST['keterangan'];

    if ($nama_produk == '')
        print_msg("Field bertanda * harus diisi");
    else {
        if ($gambar['name'] == '') {
            $sql_gambar = '';
        } else {
            hapus_gambar_produk($_GET['ID']);
            $gbr = upload_produk($gambar);
            $sql_gambar = "gambar='$gbr',";
        }
        $db->query("UPDATE tb_produk SET 
            id_kategori='$id_kategori',
            nama_produk='$nama_produk',
            harga='$harga',
            diskon='$diskon',
            stock='$stock',
            $sql_gambar
            keterangan='$keterangan'
        WHERE id_produk='$_GET[ID]'");
        redirect_js('index.php?m=produk');
    }
} elseif ($mod == 'produk_hapus') {
    hapus_gambar_produk($_GET['ID']);
    $db->query("DELETE FROM tb_produk WHERE id_produk = '$_GET[ID]'");
    header('location:index.php?m=produk');
}
/** GALERI */
elseif ($mod == 'galeri_tambah') {
    $id_produk = $_GET['id_produk'];
    $gambar = $_FILES['gambar'];
    $nama_galeri = $_POST['nama_galeri'];
    $ket_galeri = $_POST['ket_galeri'];

    if ($id_produk == '' || $gambar['name'] == '')
        print_msg("Field bertanda * tidak boleh kosong!");
    else {
        $file_name = rand(1000, 9999) . parse_file_name($gambar['name']);

        $img = new SimpleImage($gambar['tmp_name']);
        $img->best_fit(800, 600);
        $img->save('../assets/images/galeri/' . $file_name);
        $img->best_fit(180, 180);
        $img->save('../assets/images/galeri/small_' . $file_name);

        $db->query("INSERT INTO tb_galeri (id_produk, gambar, nama_galeri, ket_galeri) 
                VALUES('$id_produk', '$file_name', '$nama_galeri', '$ket_galeri')");
        redirect_js("index.php?m=galeri&id_produk=$id_produk");
    }
} else if ($mod == 'galeri_ubah') {
    $id_produk = $_GET['id_produk'];
    $gambar = $_FILES['gambar'];
    $nama_galeri = $_POST['nama_galeri'];
    $ket_galeri = $_POST['ket_galeri'];

    if ($id_produk == '')
        print_msg("Field bertanda * tidak boleh kosong!");
    else {
        if ($gambar['tmp_name'] != '') {
            hapus_galeri($_GET['ID']);
            $file_name = rand(1000, 9999) . parse_file_name($gambar['name']);
            $img = new SimpleImage($gambar['tmp_name']);
            $img->best_fit(800, 600);
            $img->save('../assets/images/galeri/' . $file_name);
            $img->best_fit(180, 180);
            $img->save('../assets/images/galeri/small_' . $file_name);
            $sql_gambar = ", gambar='$file_name'";
        }
        $db->query("UPDATE tb_galeri SET id_produk='$id_produk', nama_galeri='$nama_galeri' $sql_gambar, ket_galeri='$ket_galeri' WHERE id_galeri='$_GET[ID]'");
        redirect_js("index.php?m=galeri&id_produk=$id_produk");
    }
} else if ($act == 'galeri_hapus') {
    hapus_galeri($_GET['ID']);
    $db->query("DELETE FROM tb_galeri WHERE id_galeri='$_GET[ID]'");
    header("location:index.php?m=galeri&id_produk=$_GET[id_produk]");
}
/** ========== KONSUMEN ========== */
elseif ($mod == 'pelanggan_ubah') {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];
    $nama_kota = $_POST['nama_kota'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    if ($nama_pelanggan == '' || $jk == '' || $alamat == '' || $nama_kota == '' ||  $telepon == '') {
        print_msg("Field bertanda * harus diisi");
    } else {
        $password = ($password == '') ? '' : "`password`='$password',";

        $db->query("UPDATE tb_pelanggan SET 
                nama_pelanggan='$nama_pelanggan', 
                $password
                jenis_kelamin='$jk',
                alamat='$alamat',
                nama_kota='$nama_kota',
                telepon='$telepon'                                        
            WHERE id_pelanggan='$_GET[ID]'");
        redirect_js('index.php?m=pelanggan');
    }
} elseif ($mod == 'pelanggan_hapus') {

    $db->query("DELETE FROM tb_pelanggan WHERE id_pelanggan = '$_GET[ID]'");
    header('location:index.php?m=pelanggan');
}

/** ========== ADMIN ========== */
elseif ($mod == 'admin_tambah') {
    $nama_admin = $_POST['nama_admin'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $level = $_POST['level'];

    $user_exist = $db->get_var("SELECT * FROM tb_admin WHERE user='$user'");

    if ($nama_admin == '' || $user == '' || $pass == '' || $level == '') {
        print_msg("Field bertanda * harus diisi");
    } elseif ($user_exist) {
        print_msg("User sudah terdaftar.");
    } else {
        $db->query("INSERT INTO tb_admin (nama_admin, user, pass, level)
                    VALUES('$nama_admin', '$user', '$pass', '$level')");
        redirect_js('index.php?m=admin');
    }
} elseif ($mod == 'admin_ubah') {
    $nama_admin = $_POST['nama_admin'];
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $level = $_POST['level'];

    $user_exist = $db->get_var("SELECT * FROM tb_admin WHERE user='$user' AND id_admin<>'$_GET[ID]'");

    if ($nama_admin == '' || $user == '' || $level == '') {
        print_msg("Field bertanda * harus diisi");
    } elseif ($user_exist) {
        print_msg("User sudah terdaftar.");
    } else {
        if ($pass != '')
            $pass = ($pass == '') ? '' : ", pass=MD5('$pass')";

        $db->query("UPDATE tb_admin SET nama_admin='$nama_admin', user='$user' $pass, level='$level' WHERE id_admin='$_GET[ID]'");
        redirect_js('index.php?m=admin');
    }
} elseif ($mod == 'admin_hapus') {

    $db->query("DELETE FROM tb_admin WHERE id_admin = '$_GET[ID]'");
    header('location:index.php?m=admin');
} elseif ($mod == 'kategori_tambah') {
    $nama_kategori = $_POST['nama_kategori'];

    if ($nama_kategori == '') {
        print_msg("Field bertanda * harus diisi");
    } else {
        $db->query("INSERT INTO tb_kategori (nama_kategori)
                    VALUES('$nama_kategori')");
        redirect_js('index.php?m=kategori');
    }
} elseif ($mod == 'kategori_ubah') {
    $nama_kategori = $_POST['nama_kategori'];

    if ($nama_kategori == '') {
        print_msg("Field bertanda * harus diisi");
    } else {
        $db->query("UPDATE tb_kategori SET nama_kategori='$nama_kategori' WHERE id_kategori='$_GET[ID]'");
        redirect_js('index.php?m=kategori');
    }
} elseif ($mod == 'kategori_hapus') {
    $db->query("DELETE FROM tb_kategori WHERE id_kategori = '$_GET[ID]'");
    header('location:index.php?m=kategori');
} elseif ($mod == 'promo_tambah') {
    $kode_promo = $_POST['kode_promo'];
    $nama_promo = $_POST['nama_promo'];
    $diskon_promo = $_POST['diskon_promo'];
    $minimal_belanja = $_POST['minimal_belanja'];
    $ket_promo = $_POST['ket_promo'];
    $status_promo = $_POST['status_promo'];

    if ($kode_promo == '' || $nama_promo == '' || $diskon_promo == '' || $minimal_belanja == '' || $ket_promo == '' || $status_promo == '') {
        print_msg("Field bertanda * harus diisi");
    } else {
        $db->query("INSERT INTO tb_promo (kode_promo, nama_promo, diskon_promo, minimal_belanja, ket_promo, status_promo) VALUES('$kode_promo', '$nama_promo', '$diskon_promo', '$minimal_belanja', '$ket_promo','$status_promo')");
        redirect_js('index.php?m=promo');
    }
} elseif ($mod == 'promo_ubah') {
    $nama_promo = $_POST['nama_promo'];
    $nama_promo = $_POST['nama_promo'];
    $diskon_promo = $_POST['diskon_promo'];
    $minimal_belanja = $_POST['minimal_belanja'];
    $ket_promo = $_POST['ket_promo'];
    $status_promo = $_POST['status_promo'];

    if ($nama_promo == '' || $diskon_promo == '' || $minimal_belanja == '' || $ket_promo == '' || $status_promo == '') {
        print_msg("Field bertanda * harus diisi");
    } else {
        $db->query("UPDATE tb_promo SET nama_promo='$nama_promo', diskon_promo='$diskon_promo', minimal_belanja='$minimal_belanja', ket_promo='$ket_promo', status_promo='$status_promo' WHERE id_promo='$_GET[ID]'");
        redirect_js('index.php?m=promo');
    }
} elseif ($mod == 'promo_hapus') {
    $db->query("DELETE FROM tb_promo WHERE id_promo = '$_GET[ID]'");
    header('location:index.php?m=promo');
} elseif ($mod == 'kota_tambah') {
    $nama_kota = $_POST['nama_kota'];
    $ongkos_kirim = $_POST['ongkos_kirim'];

    if ($nama_kota == '' || $ongkos_kirim == '') {
        print_msg("Field bertanda * harus diisi");
    } else {
        $db->query("INSERT INTO tb_kota (nama_kota, ongkos_kirim)
                    VALUES('$nama_kota', '$ongkos_kirim')");
        redirect_js('index.php?m=kota');
    }
} elseif ($mod == 'kota_ubah') {
    $nama_kota = $_POST['nama_kota'];
    $ongkos_kirim = $_POST['ongkos_kirim'];

    if ($nama_kota == '' || $ongkos_kirim == '') {
        print_msg("Field bertanda * harus diisi");
    } else {
        $db->query("UPDATE tb_kota SET nama_kota='$nama_kota', ongkos_kirim='$ongkos_kirim' WHERE ID='$_GET[ID]'");
        redirect_js('index.php?m=kota');
    }
} elseif ($mod == 'kota_hapus') {

    $db->query("DELETE FROM tb_kota WHERE ID = '$_GET[ID]'");
    header('location:index.php?m=kota');
} elseif ($mod == 'admin_ubah_password') {
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $pass3 = $_POST['pass3'];

    $pass_correct = $db->get_var("SELECT * FROM tb_admin WHERE id_admin='$_SESSION[adm_id]' AND pass=MD5('$pass1')");

    if ($pass1 == '' || $pass2 == '' || $pass3 == '') {
        print_msg("Field bertanda * harus diisi");
    } elseif (!$pass_correct) {
        print_msg("Password lama yang anda masukkan salah.");
    } elseif ($pass2 != $pass3) {
        print_msg("Password baru dan konfirmasi password baru harus sama.");
    } else {
        $db->query("UPDATE tb_admin SET pass=MD5('$pass2') WHERE id_admin='$_SESSION[adm_id]'");
        print_msg("Password baru berhasil disimpan.", 'success');
    }
}
/** ========== ORDER ========== */
elseif ($act == 'order_konfirmasi') {
    $db->query("UPDATE tb_order SET status='Dikirim' WHERE id_order='$_GET[ID]'");
    $db->query("UPDATE tb_bayar SET status='OK' WHERE id_order='$_GET[ID]'");
    header("location:index.php?m=order_detail&ID=$_GET[ID]");
} elseif ($act == 'order_kirim') {
    $db->query("UPDATE tb_order SET status='Dikirim' WHERE id_order='$_GET[ID]'");
    header("location:index.php?m=order_detail&ID=$_GET[ID]");
} elseif ($mod == 'komentar_balas') {
    $balasan = $_POST['balasan'];

    if ($balasan == '') {
        print_msg("Field bertanda * harus diisi");
    } else {
        $db->query("UPDATE tb_komentar SET balasan='$balasan' WHERE id_komentar='$_GET[ID]'");
        redirect_js('index.php?m=komentar');
    }
}


/** ========== KONTAK  ========== */
elseif ($mod == 'kontak') {
    update_options('kontak', $_POST['kontak']);
    print_msg("Data tersimpan.", 'success');
}

/** ========== CARAPESAN  ========== */
elseif ($mod == 'caraorder') {
    update_options('caraorder', $_POST['caraorder']);
    print_msg("Data tersimpan.", 'success');
} else if ($act == 'logout') {
    unset($_SESSION['adm_id'], $_SESSION['adm_nama'], $_SESSION['adm_username'], $_SESSION['level']);
    header('location:index.php');
}

function upload_produk($gambar)
{
    $lokasi_file    = $gambar['tmp_name'];
    $nama_file      = parse_file_name($gambar['name']);
    $acak           = rand(1000, 999);
    $nama_file_unik = $acak . $nama_file;

    $vdir_upload = "../assets/images/produk/";
    $vfile_upload = $vdir_upload . $nama_file_unik;

    move_uploaded_file($lokasi_file, $vfile_upload);

    $image = new SimpleImage;
    $image->load($vfile_upload);
    $image->best_fit(300, 300);
    $image->save($vdir_upload . "small_$nama_file_unik");
    return $nama_file_unik;
}

function hapus_gambar_produk($ID)
{
    global $db;
    $gambar = $db->get_var("SELECT gambar FROM tb_produk WHERE id_produk='$ID'");
    if (!empty($gambar)) {
        $gambar1 = "../assets/images/produk/$gambar";
        $gambar2 = "../assets/images/produk/small_$gambar";
        if (file_exists($gambar1) && is_file($gambar1))
            unlink($gambar1);
        if (file_exists($gambar2) && is_file($gambar2))
            unlink($gambar2);
    }
}
function hapus_galeri($ID)
{
    global $db;
    $row = $db->get_row("SELECT gambar FROM tb_galeri WHERE id_galeri='$ID'");
    if ($row) {
        $file1 = '../assets/images/galeri/' . $row->gambar;
        $file2 = '../assets/images/galeri/small_' . $row->gambar;
        if (is_file($file1))
            unlink($file1);
        if (is_file($file2))
            unlink($file2);
    }
}
