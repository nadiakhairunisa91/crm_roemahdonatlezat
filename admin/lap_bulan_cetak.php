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
$awal = ($_GET['awal']) ? $_GET['awal'] : date('Y-m-01');
$akhir = ($_GET['akhir']) ? $_GET['akhir'] : date('Y-m-d');
?>
<h1>Laporan Penjualan Bulanan <small>(<?= tgl_indo($awal) ?> s/d <?= tgl_indo($akhir) ?>)</small></h1>
<table id="datatables" class="table table-bordered table-hover table-striped table-condensed" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Periode</th>
            <th>produk</th>
            <th>Jumlah</th>
            <th>Total</th>
        </tr>
    </thead>
    <?php
    $q = esc_field($_GET['q']);
    $pg = new Paging;
    $batas = 100;
    $offset = $pg->get_offset($batas, $_GET['page']);
    $where = " AND o.tanggal>='$awal' AND o.tanggal<='$akhir'";

    $from = "FROM tb_detail d INNER JOIN tb_produk p ON p.id_produk=d.id_produk INNER JOIN tb_order o ON o.id_order=d.id_order";
    $rows = $db->get_results("SELECT MAX(o.tanggal) AS tanggal, p.id_produk, nama_produk, SUM(jumlah) AS jumlah, SUM(jumlah * d.harga) AS total $from WHERE 1 $where GROUP BY YEAR(o.tanggal), MONTH(o.tanggal), p.id_produk");

    $no = $offset;
    $jumlah = 0;
    $total = 0;
    $periode = '';
    foreach ($rows as $row) :
        $jumlah += $row->jumlah;
        $total += $row->total; ?>
        <tr>
            <td><?= ++$no ?></td>
            <td><?= $periode != $row->tanggal ? date('F Y', strtotime($row->tanggal)) : '' ?></td>
            <td><?= $row->nama_produk ?></td>
            <td><?= number_format($row->jumlah) ?></td>
            <td><?= rp($row->total) ?></td>
        </tr>
    <?php $periode = $row->tanggal;
    endforeach ?>
    <tfoot>
        <tr>
            <td colspan="3">Total</td>
            <td><?= number_format($jumlah) ?></td>
            <td><?= rp($total) ?></td>
        </tr>
    </tfoot>
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