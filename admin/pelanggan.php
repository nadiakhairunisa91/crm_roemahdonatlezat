<div class="panel panel-default">
    <div class="panel-heading">
       <strong>Data Pelanggan</strong>
   </div>
   <div class="panel-body">
    <table id="datatables" class="table table-bordered table-hover table-striped table-condensed" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Kota</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <?php
        $pg = new Paging;
        $batas = 250;
        $posisi = $pg->get_offset($batas, $_GET['page']);

        $q = esc_field($_GET['q']);
        $rows = $db->get_results("SELECT * FROM tb_pelanggan WHERE nama_pelanggan LIKE '%$q%' ORDER BY id_pelanggan LIMIT $posisi, $batas");
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
            <td style="white-space: nowrap;">
                <a class="btn btn-xs btn-warning" href="?m=pelanggan_ubah&ID=<?= $row->id_pelanggan ?>"><span class="glyphicon glyphicon-edit"></span> Ubah</a>
                <a class="btn btn-xs btn-danger" href="aksi.php?m=pelanggan_hapus&ID=<?= $row->id_pelanggan ?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span> Hapus</a>
            </td>
        </tr>
    <?php endforeach;
    ?>
</table>
</div>
</div>