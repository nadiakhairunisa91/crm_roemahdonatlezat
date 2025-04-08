<table class="noborder">
  <tr>
    <br>
    <td width="136" rowspan="3" align="center"><img src="../assets/images/rumah.png" width="90" height="90"></td>
    <td width="883" align="center">&nbsp;</td>
    <td width="26" rowspan="6">&nbsp;</td>
</tr>

<tr>
    <td align="left">
      <span align="left" style="font-size:20px;"><strong>ROEMAH DONAT LEZAT</strong></span><br> Jl. Diponegoro No.647, Kisaran  <br>
      Telp. 0812-6044-3486
      <hr>
  </td>
</tr>   
</table>

<?php
$tanggal1 = ($_GET['tanggal1']) ? $_GET['tanggal1'] : date('Y-m-01');
$tanggal2 = ($_GET['tanggal2']) ? $_GET['tanggal2'] : date('Y-m-d');
?>
<h1>Laporan Data Pemesanan (<?= tgl_indo($tanggal1) ?> s/d <?= tgl_indo($tanggal2) ?>)</h1>
<table width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>ID Pemesanan</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Kota</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>
    <?php
    $where = " AND p.tanggal>='$tanggal1' AND p.tanggal<='$tanggal2'";
    $q = esc_field($_GET['q']);
    if ($_GET['status'])
        $where .= " AND p.status='$_GET[status]'";

    $rows = $db->get_results("SELECT p.id_order, p.tanggal, k.nama_pelanggan, kt.nama_kota, p.status, p.grantotal
    FROM tb_order p 
    	INNER JOIN tb_pelanggan k ON k.id_pelanggan=p.id_pelanggan 
    	INNER JOIN tb_kota kt ON kt.ID=p.kota_kirim
    	INNER JOIN tb_detail d ON d.id_order=p.id_order    
    WHERE 1 $where
    GROUP BY p.id_order");
    $no = $posisi;
    foreach ($rows as $row) : ?>
        <tr>
            <td><?= ++$no ?></td>
            <td><?= $row->id_order ?></td>
            <td><?= tgl_indo($row->tanggal) ?></td>
            <td><?= $row->nama_pelanggan ?></td>
            <td><?= $row->nama_kota ?></td>
            <td>Rp <?= number_format($row->grantotal) ?></td>
            <td><?= $row->status ?></td>
        </tr>
    <?php endforeach ?>
</table>


<br><br>
<table width=100% class="noborder">
  <tr>
    <td colspan="2"></td>
    <td width="286"></td>
</tr>
<tr>
    <td width="230" align="center"> <br> 
    </td>
    <td width="530"></td>
    <td align="center">Mengetahui <br> 
      Pemilik</td>
  </tr>
  <tr>
      <td align="center"><br /><br /><br /><br /><br />
        <br /><br /><br /></td>
        <td>&nbsp;</td>
        <td align="center" valign="top"><br /><br /><br /><br /><br />
            <strong>  ( ..................... ) </strong> <br />
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>