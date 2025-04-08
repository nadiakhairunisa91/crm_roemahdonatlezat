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

<h1>Laporan Data produk</h1>
<table width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Gambar</th>
            <th>Nama produk</th>
            <th>Harga</th>
            <th>Stock</th>
            <th>Diskon</th>
        </tr>
    </thead>
    <?php
    $q = esc_field($_GET['q']);

    $rows = $db->get_results("SELECT b.* FROM tb_produk b
	WHERE 1 $where AND nama_produk LIKE '%$q%' ORDER BY id_produk");
    $no = $posisi;
    foreach ($rows as $row) : ?>
        <tr>
            <td><?php echo ++$no ?></td>
            <td><img class="thumbnail" src="<?= produk_image($row->gambar, true, true) ?>" height="100" /></td>
            <td><?php echo $row->nama_produk ?></td>
            <td><?php echo number_format($row->harga) ?></td>
            <td><?= $row->stock ?></td>
            <td><?= $row->diskon ?>%</td>
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