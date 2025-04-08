<?php
$produk = $db->get_row("SELECT * FROM tb_produk WHERE id_produk='$_GET[id_produk]'");
?>

<div class="panel panel-default">
    <div class="panel-heading">
    <span>
        <strong>Data Galeri &raquo; <?= $produk->nama_produk ?></strong>
                <a class="btn btn-primary btn-xs" href="?m=galeri_tambah&id_produk=<?= $_GET['id_produk'] ?>"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
    </span>
    </div>
    <div class="panel-body">
        <table id="datatables" class="table table-bordered table-hover table-striped table-condensed" width="100%">
            <thead>
                <tr class="nw">
                    <th>No</th>
                    <th>Nama produk</th>
                    <th>Gambar</th>
                    <th>Nama Galeri</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php
            $q = esc_field($_GET['q']);
            $pg = new Paging();
            $limit = 25;
            $offset = $pg->get_offset($limit, $_GET['page']);

            $rows = $db->get_results("SELECT g.*, t.nama_produk 
            FROM tb_galeri g INNER JOIN tb_produk t ON t.id_produk=g.id_produk
            WHERE nama_produk LIKE '%$q%' AND g.id_produk='$produk->id_produk' ORDER BY nama_produk LIMIT $offset, $limit");

            $no = $offset;

            $jumrec = $db->get_var("SELECT COUNT(*) 
            FROM tb_galeri g INNER JOIN tb_produk t ON t.id_produk=g.id_produk 
            WHERE nama_produk LIKE '%$q%'");

            foreach ($rows as $row) :
            ?>
                <tr>
                    <td><?= ++$no ?></td>
                    <td><?= $row->nama_produk ?></td>
                    <td><img class="thumbnail" src="../assets/images/galeri/small_<?= $row->gambar ?>" height="60" /></td>
                    <td><?= $row->nama_galeri ?></td>
                    <td class="nw">
                        <a class="btn btn-xs btn-warning" href="?m=galeri_ubah&ID=<?= $row->id_galeri ?>&id_produk=<?= $_GET['id_produk'] ?>"><span class="glyphicon glyphicon-edit"></span> Ubah</a>
                        <a class="btn btn-xs btn-danger" href="aksi.php?act=galeri_hapus&ID=<?= $row->id_galeri ?>&id_produk=<?= $_GET['id_produk'] ?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span> Hapus</a>
                    </td>
                </tr>
            <?php endforeach;    ?>
        </table>
    </div>
</div>