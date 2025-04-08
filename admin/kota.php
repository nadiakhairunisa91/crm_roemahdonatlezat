<div class="panel panel-default">
    <div class="panel-heading">
       <span>
           <strong>Data Ongkos Kirim</strong>
           <a class="btn btn-primary btn-xs" href="?m=kota_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
       </span>
   </div>
   <div class="panel-body">
       <table id="datatables" class="table table-bordered table-hover table-striped table-condensed" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kota</th>
                <th>Ongkos Kirim</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <?php
        $pg = new Paging;
        $batas = 999;
        $posisi = $pg->get_offset($batas, $_GET['page']);

        $q = esc_field($_GET['q']);
        $rows = $db->get_results("SELECT * FROM tb_kota WHERE nama_kota LIKE '%$q%' ORDER BY nama_kota LIMIT $posisi, $batas");
        $no = $posisi;
        foreach ($rows as $row) : ?>
        <tr>
            <td><?= ++$no ?></td>
            <td><?= $row->nama_kota ?></td>
            <td>Rp <?= number_format($row->ongkos_kirim) ?></td>
            <td style="white-space: nowrap;">
            <a class="btn btn-xs btn-warning" href="?m=kota_ubah&ID=<?= $row->ID ?>"><span class="glyphicon glyphicon-edit"></span> Ubah</a>
                <a class="btn btn-xs btn-danger" href="aksi.php?m=kota_hapus&ID=<?= $row->ID ?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span> Hapus</a>
            </td>
        </tr>
    <?php endforeach;
    ?>
</table>
</div>
</div>