<?php
include 'config.php';
$rows = $db->get_results("SELECT * FROM tb_produk WHERE nama_produk LIKE '%$_GET[q]%' LIMIT 7");
$a = array();
foreach ($rows as $row) {
    $a[] = $row->nama_produk;
}
echo json_encode($a);
