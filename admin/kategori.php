<div class="panel panel-default">
    <div class="panel-heading">
        <span>
            <strong>Data Kategori</strong>
            <a class="btn btn-primary btn-xs" href="?m=kategori_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
        </span>
    </div>
    <div class="panel-body">
        <table id="datatables" class="table table-bordered table-hover table-striped table-condensed" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php
            $pg = new Paging;
            $batas = 100;
            $posisi = $pg->get_offset($batas, $_GET['page']);

            $q = esc_field($_GET['q']);
            $rows = $db->get_results("SELECT * FROM tb_kategori WHERE nama_kategori LIKE '%$q%' ORDER BY nama_kategori LIMIT $posisi, $batas");
            $no = $posisi;
            foreach ($rows as $row) : ?>
            <tr>
                <td><?= ++$no ?></td>
                <td><?= $row->nama_kategori ?></td>
                <td style="white-space: nowrap;">
                    <a class="btn btn-xs btn-warning" href="?m=kategori_ubah&ID=<?= $row->id_kategori ?>"><span class="glyphicon glyphicon-edit"></span> Ubah</a>
                    <a class="btn btn-xs btn-danger" href="aksi.php?m=kategori_hapus&ID=<?= $row->id_kategori ?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span> Hapus</a>
                </td>
            </tr>
        <?php endforeach;
        ?>
    </table>
</div>
</div>