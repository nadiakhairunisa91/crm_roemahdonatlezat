<table class="noborder">
  <tr>
    <br>
    <td width="136" rowspan="3" align="center"><img src="../assets/images/rumah.png" width="90" height="90"></td>
    <td width="883" align="center">&nbsp;</td>
    <td width="26" rowspan="6">&nbsp;</td>
</tr>

<tr>
    <td align="left">
      <span align="left" style="font-size:20px;"><strong>ROEMAH DONAT LEZAT</strong></span><br> Jl. Diponegoro No.364, Kisaran <br>
      Telp. 0812-6044-3486, 
      <hr>
  </td>
</tr>   
</table>

<h1>Laporan Data Admin</h1>
<table width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Admin</th>
            <th>User</th>
            <th>Level</th>
        </tr>
    </thead>
    <?php
    $q = esc_field($_GET['q']);
    $rows = $db->get_results("SELECT * FROM tb_admin ORDER BY nama_admin");
    $no = $posisi;
    foreach ($rows as $row) : ?>
        <tr>
            <td><?php echo ++$no ?></td>
            <td><?php echo $row->nama_admin ?></td>
            <td><?php echo $row->user ?></td>
            <td><?php echo $row->level ?></td>
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