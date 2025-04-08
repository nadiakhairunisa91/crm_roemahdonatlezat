<?php
function set_value($key = null, $default = null)
{
    global $_POST;
    if (isset($_POST[$key]))
        return $_POST[$key];

    if (isset($_GET[$key]))
        return $_GET[$key];

    return $default;
}

function kode_oto($field, $table, $prefix, $length)
{
    global $db;
    $var = $db->get_var("SELECT $field FROM $table WHERE $field REGEXP '{$prefix}[0-9]{{$length}}' ORDER BY $field DESC");
    if ($var) {
        return $prefix . substr(str_repeat('0', $length) . (substr($var, -$length) + 1), -$length);
    } else {
        return $prefix . str_repeat('0', $length - 1) . 1;
    }
}

function print_msg($msg, $type = 'danger')
{
    echo ('<div class="alert alert-' . $type . ' alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>' . $msg . '</div>');
}

function get_jk_radio($selected)
{
    $array = array('Laki-laki', 'Perempuan');
    $a = '';
    foreach ($array as $arr) {
        if ($arr == $selected)
            $a .= "<label class='radio-inline'>
                  <input type='radio' name='jk' value='$arr' checked> $arr
                </label>";
        else
            $a .= "<label class='radio-inline'>
                  <input type='radio' name='jk' value='$arr'> $arr
                </label>";
    }
    return '<div class="radio">' . $a . '</div>';
}

function get_level_radio($selected)
{
    $array = array('Administrator', 'Pemilik');
    $a = '';
    foreach ($array as $arr) {
        if ($arr == $selected)
            $a .= "<label class='radio-inline'>
                  <input type='radio' name='level' value='$arr' checked> $arr
                </label>";
        else
            $a .= "<label class='radio-inline'>
                  <input type='radio' name='level' value='$arr'> $arr
                </label>";
    }
    return '<div class="radio">' . $a . '</div>';
}

function get_produk_option($selected = 0)
{
    global $db;
    $rows = $db->get_results("SELECT * FROM tb_produk ORDER BY nama_produk");
    $a = '';
    foreach ($rows as $row) {
        if ($row->id_produk == $selected)
            $a .= "<option value='$row->id_produk' selected>$row->nama_produk</option>";
        else
            $a .= "<option value='$row->id_produk'>$row->nama_produk</option>";
    }
    return $a;
}

function get_kategori_option($selected = 0)
{
    global $db;
    $rows = $db->get_results("SELECT * FROM tb_kategori ORDER BY nama_kategori");
    $a = '';
    foreach ($rows as $row) {
        if ($row->id_kategori == $selected)
            $a .= "<option value='$row->id_kategori' selected>$row->nama_kategori</option>";
        else
            $a .= "<option value='$row->id_kategori'>$row->nama_kategori</option>";
    }
    return $a;
}

function get_user_option($selected = 0)
{
    global $db;
    $rows = $db->get_results("SELECT * FROM tb_user ORDER BY nama");
    $a = '';
    foreach ($rows as $row) {
        if ($row->ID == $selected)
            $a .= "<option value='$row->ID' selected>$row->nama</option>";
        else
            $a .= "<option value='$row->ID'>$row->nama</option>";
    }
    return $a;
}

function get_status_order_option($pilih = '')
{
    $array = array('New', 'Pending', 'Dikirim', 'Selesai', 'Cancel');
    $a = '';
    foreach ($array as $val) {
        if ($val == $pilih)
            $a .= "<option value='$val' selected>$val</option>";
        else
            $a .= "<option value='$val'>$val</option>";
    }
    return $a;
}
function get_bintang_option($pilih = '')
{
    $array = array(
        '1' => 'Bintang 1',
        '2' => 'Bintang 2',
        '3' => 'Bintang 3',
        '4' => 'Bintang 4',
        '5' => 'Bintang 5',
    );
    $a = '';
    foreach ($array as $key => $val) {
        if ($key == $pilih)
            $a .= "<option value='$key' selected>$val</option>";
        else
            $a .= "<option value='$key'>$val</option>";
    }
    return $a;
}


function get_kota_option($selected = '')
{
    global $db;
    $rows = $db->get_results("SELECT * FROM tb_kota ORDER BY nama_kota");
    $a = '';
    foreach ($rows as $row) {
        if ($row->ID == $selected)
            $a .= "<option value='$row->ID' selected>$row->nama_kota [Rp " . number_format($row->ongkos_kirim) . "]</option>";
        else
            $a .= "<option value='$row->ID'>$row->nama_kota [Rp " . number_format($row->ongkos_kirim) . "]</option>";
    }
    return $a;
}

function get_metode_bayar_option($selected = '')
{
    $status = array(
        'Transfer' => 'Transfer  no  rekening  (1791861739172638)',
        'Cash on Delivery' => 'Cash on Delivery',
        'Indomaret' => 'Indomaret',
        'Dana' => 'Dana (081260443486)',


    );
    $a = '';
    foreach ($status as $key => $value) {
        if ($key == $selected)
            $a .= "<option value='$key' selected>$value</option>";
        else
            $a .= "<option value='$key'>$value</option>";
    }
    return $a;
}

function get_order_option($selected = '')
{
    $status = array(
        'id_produk DESC' => 'Terbaru',
        'total DESC' => 'Terpopuler',
        'harga' => 'Harga Terendah',
        'harga DESC' => 'Harga Tertinggi',
    );
    $a = '';
    foreach ($status as $key => $value) {
        if ($key == $selected)
            $a .= "<option value='$key' selected>$value</option>";
        else
            $a .= "<option value='$key'>$value</option>";
    }
    return $a;
}
