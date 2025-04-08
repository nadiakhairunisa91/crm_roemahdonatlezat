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

<h1>Laporan Data Pelanggan</h1>
<table width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>Kota</th>
            <th>Telepon</th>
            <th>Email</th>
        </tr>
    </thead>
    <?php
    $q = esc_field($_GET['q']);
    $rows = $db->get_results("SELECT * FROM tb_pelanggan WHERE nama_pelanggan LIKE '%$q%' ORDER BY id_pelanggan");
    $no = 0;
    foreach ($rows as $row) : ?>
    <tr>
        <td><?= ++$no ?></td>
        <td><?= $row->nama_pelanggan ?></td>
        <td><?= $row->jenis_kelamin ?></td>
        <td><?= $row->alamat ?></td>
        <td><?= $row->nama_kota ?></td>
        <td><?= $row->telepon ?></td>
        <td><?= $row->email ?></td>
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