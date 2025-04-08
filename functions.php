<?php
error_reporting(~E_NOTICE);
session_start();
date_default_timezone_set('Etc/GMT-8');

define('ABSPATH', dirname(__FILE__));

include ABSPATH . '/config.php';
include ABSPATH . '/includes/db.php';
$db = new DB($config['server'], $config['username'], $config['password'], $config['database_name']);
include ABSPATH . '/includes/template.php';
include ABSPATH . '/includes/paging.php';
include ABSPATH . '/includes/SimpleImage.php';

$mod = $_GET['m'];
$act = $_GET['act'];

$sid = session_id();
$IDP = $_SESSION['pub_id'] * 1;
$POIN_BELANJA = 100000;
$POIN_KELIPATAN = 1;
$POIN_RP = 5000;


function get_order($ID)
{
    global $db;
    return $db->get_row("SELECT * FROM tb_order p INNER JOIN tb_pelanggan k ON k.id_pelanggan=p.id_pelanggan INNER JOIN tb_kota kt ON kt.ID=p.kota_kirim 
        WHERE id_order='$_GET[ID]'");
}

function get_order_detail($ID)
{
    global $db;
    return $db->get_results("SELECT d.id_produk, b.nama_produk, b.diskon, d.harga, d.diskon_detail, d.jumlah, d.subtotal
        FROM tb_detail d INNER JOIN tb_produk b ON b.id_produk=d.id_produk WHERE id_order='$ID'");
}

function get_detail($id_detail)
{
    global $db;
    $row = $db->get_row("SELECT d.*, b.nama_produk FROM tb_detail d INNER JOIN tb_produk b ON b.id_produk=d.id_produk LEFT JOIN tb_komentar k ON k.id_detail=d.id_detail WHERE d.id_detail='$id_detail'");
    return $row;
}

function tambah_poin()
{
    global $db, $POIN_BELANJA;
    $order = get_order($_GET['ID']);
    $total = $order->total;
    $total_poin = floor($total / $POIN_BELANJA);

    if ($total_poin > 0)
        $db->query("INSERT INTO tb_poin (id_pelanggan, tanggal_poin, ref_poin, jumlah_poin, ket_poin) VALUES ('$order->id_pelanggan', NOW(), '$order->id_order', '$total_poin', 'Pemesanan $order->id_order')");
    update_poin($order->id_pelanggan);
}
// del_old_order();
function update_poin($id_pelanggan)
{
    global $db;
    $in = $db->get_var("SELECT SUM(jumlah_poin) AS total FROM tb_poin WHERE id_pelanggan='$id_pelanggan' AND jumlah_poin > 0");
    $out = $db->get_var("SELECT SUM(jumlah_poin) AS total FROM tb_poin WHERE id_pelanggan='$id_pelanggan' AND jumlah_poin < 0");
    $db->query("UPDATE tb_pelanggan SET poin_in='$in', poin_out='$out' WHERE id_pelanggan='$id_pelanggan'");
}
function get_pelanggan($ID = '')
{
    global $db;
    return $db->get_row("SELECT * FROM tb_pelanggan p WHERE p.id_pelanggan='$ID'");
}
function alert($msg)
{
    echo '<script type="text/javascript">alert("' . $msg . '");</script>';
}
function kode_bayar($kode_bayar)
{
    $arr = str_split($kode_bayar);
    $a = 1;
    $str = "";
    foreach ($arr as $key => $val) {
        $str .= $val;
        if ($a % 3 == 0) $str .= " ";
        $a++;
    }
    return $str;
}



function update_bintang($id_produk)
{
    global $db;
    $var = $db->get_var("SELECT AVG(bintang) FROM tb_komentar k INNER JOIN tb_detail d ON k.id_detail=k.id_detail WHERE d.id_produk='$id_produk'") * 1;
    $db->query("UPDATE tb_produk SET bintang_total='$var' WHERE id_produk='$id_produk'");
}

function show_rating($rating = 0)
{
    $str = '';
    for ($a = 1; $a <= 5; $a++) {
        if ($a <= $rating) {
            $str .= '<span style="color: orange; font-size:larger">&#9734;</span>';
        } else {
            $str .= '<span class="text-muted">&#9734;</span>';
        }
    }
    return $str;
}

function get_produk($id_produk)
{
    global $db;
    $row = $db->get_row("SELECT * FROM tb_produk b LEFT JOIN tb_komentar k ON k.id_produk=b.id_produk WHERE b.id_produk='$id_produk'");
    return $row;
}

function parse_file_name($nama_file)
{
    $nama_file      = str_replace(array('/', '"', "'", '', ' ', '(', ')'), '-', $nama_file);
    $nama_file      = str_replace(array('---', '--'), '', $nama_file);
    return $nama_file;
}

function produk_image($image, $thumbail = true, $admin = false)
{
    $file = $image;

    if ($thumbail)
        $file = "small_" . $file;
    if ($admin)
        $pref = "../";

    $url =   $pref . "assets/images/produk/" . $file;
    if (file_exists($url) && is_file($url))
        return $url;
    return $pref . "assets/images/no_image.png";
}

function rp($number)
{
    return "Rp " . number_format($number, 0, ',', '.');
}
function get_status_promo_radio($selected)
{
    $arr = array('Aktif' => 'Aktif', 'NonAktif' => 'NonAktif');
    $a = '';
    foreach ($arr as $key => $val) {
        if ($key == $selected)
            $a .= "<label class='radio-inline'>
        <input type='radio' name='status_promo' value='$key' checked> $val
    </label>";
    else
        $a .= "<label class='radio-inline'>
    <input type='radio' name='status_promo' value='$key'> $val
</label>";
}
return '<div class="radio">' . $a . '</div>';
}
function del_old_order()
{
    global $db;
    /*$day = get_options('min_day_deleted') * 1;    
    $rows = $db->get_results("SELECT d.id_produk, d.jumlah, p.tanggal, p.id_order 
        FROM tb_detail d INNER JOIN tb_order p ON p.id_order=d.id_order
        WHERE p.status='New' AND p.tanggal< NOW() - INTERVAL $day DAY ;");
    
    $ID = array(0);
    foreach($rows as $row){
        $jumlah = $row->jumlah * 1;
        $db->query("UPDATE tb_produk SET stock=stock + $jumlah WHERE id_produk='$row->id_produk'");
        $ID[] = $row->id_order;
    }
    $db->query("DELETE FROM tb_order WHERE id_order IN (".implode(',',$ID).")");
    $db->query("DELETE FROM tb_detail WHERE id_order IN (".implode(',',$ID).")");*/
    $db->query("DELETE FROM tb_temp WHERE tgl_temp < NOW() - INTERVAL 1 DAY");
}

function tgl_indo($date, $time = false)
{
    $dt = explode(' ', $date);

    $tanggal = explode('-', $dt[0]);

    $array_bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $bulan = $array_bulan[$tanggal[1] * 1];

    return $tanggal[2] . ' ' . $bulan . ' ' . $tanggal[0];
}

function esc_field($str)
{
    return addslashes($str);
}

function get_options($option_name)
{
    global $db;
    return $db->get_var("SELECT option_value FROM tb_options WHERE option_name='$option_name'");
}

function update_options($option_name, $option_value)
{
    global $db;
    return $db->query("UPDATE tb_options SET option_value='$option_value' WHERE option_name='$option_name'");
}

function show_msg()
{
    if ($_SESSION['message'])
        print_msg($_SESSION[message][msg], $_SESSION[message][type]);
    unset($_SESSION['message']);
}

function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function ses_id()
{
    return session_id();
}

function redirect_js($url)
{
    echo '<script type="text/javascript">window.location.replace("' . $url . '");</script>';
}

function print_error($msg)
{
    die('<!DOCTYPE html>
        <html>
        <head><title>Error</title>
            <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
            <link href="../assets/css/bootstrap.min.css" rel="stylesheet"/>
            <body>
                <div class="container" style="margin:20px auto; width:400px">
                    <p class="alert alert-warning">' . $msg . ' <a href="javascript:history.back(-1)">Kembali</a></p>

                </div>
            </body>
            </html>');
}
