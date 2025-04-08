<div class="panel panel-default">
    <div class="panel-heading">
     <span>
         <strong>Data Admin</strong>
         <a class="btn btn-primary btn-xs" href="?m=admin_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
         <a class="btn btn-default btn-xs" href="cetak.php?m=admin&q=<?= $_GET['q'] ?>" target="_blank"><span class="glyphicon glyphicon-print"></span> Cetak</a>
     </span>
 </div>
 <div class="panel-body">
    <table id="datatables" class="table table-bordered table-hover table-striped table-condensed" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Admin</th>
                <th>User</th>
                <th>Level</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <?php
        $pg = new Paging;
        $batas = 100;
        $posisi = $pg->get_offset($batas, $_GET['page']);

        $q = esc_field($_GET['q']);
        $rows = $db->get_results("SELECT * FROM tb_admin WHERE nama_admin LIKE '%$q%' GROUP BY id_admin ORDER BY nama_admin LIMIT $posisi, $batas");
        $no = $posisi;
        foreach ($rows as $row) : ?>
        <tr>
            <td><?php echo ++$no ?></td>
            <td><?php echo $row->nama_admin ?></td>
            <td><?php echo $row->user ?></td>
            <td><?php echo $row->level ?></td>
            <td style="white-space: nowrap;">
                <a class="btn btn-xs btn-warning" href="?m=admin_ubah&ID=<?php echo $row->id_admin ?>"><span class="glyphicon glyphicon-edit"></span> Ubah</a>
                <a class="btn btn-xs btn-danger" href="aksi.php?m=admin_hapus&ID=<?php echo $row->id_admin ?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span> Hapus</a>
            </td>
        </tr>
    <?php endforeach;
    ?>
</table>
</div>
</div>