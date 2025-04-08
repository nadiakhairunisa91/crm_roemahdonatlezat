<?php
$row = $db->get_row("SELECT * FROM tb_galeri WHERE id_galeri='$_GET[ID]'");
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Ubah Galeri</strong>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <?php if ($_POST) include 'aksi.php' ?>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Gambar</label>
                        <input class="form-control input-sm" type="file" name="gambar" />
                        <p class="help-block">Kosongkan jika tidak mengubah gambar</p>
                        <img class="thumbnail" src="../assets/images/galeri/small_<?= $row->gambar ?>" height="60" />
                    </div>
                    <div class="form-group">
                        <label>Nama Galeri</label>
                        <input class="form-control input-sm" type="text" name="nama_galeri" value="<?= $row->nama_galeri ?>" />
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="mce" name="ket_galeri"><?= $row->ket_galeri ?></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                        <a class="btn btn-danger btn-sm" href="?m=galeri&id_produk=<?= $_GET['id_produk'] ?>"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>