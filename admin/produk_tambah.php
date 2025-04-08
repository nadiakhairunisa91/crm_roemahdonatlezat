<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Tambah produk</strong>
    </div>
    <div class="panel-body">
        <form method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-6">
                    <?php if ($_POST) include 'aksi.php' ?>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control input-sm" name="id_kategori">
                            <?= get_kategori_option(set_value('id_kategori')) ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama produk <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="text" name="nama_produk" value="<?= $_POST['nama_produk'] ?>" />
                    </div>
                    <div class="form-group">
                        <label>Gambar <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="file" name="gambar" accept="image/*" />
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input class="form-control input-sm" type="text" name="harga" value="<?= $_POST['harga'] ?>" />
                    </div>
                    <div class="form-group">
                        <label>Stock</label>
                        <input class="form-control input-sm" type="text" name="stock" value="<?= $_POST['stock'] ?>" />
                    </div>
                    <div class="form-group">
                        <label>Diskon (%)</label>
                        <input class="form-control input-sm" type="text" name="diskon" value="<?= $_POST['diskon'] ?>" />
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                        <a class="btn btn-danger btn-sm" href="?m=produk"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control input-sm mce" name="keterangan"><?= $_POST['keterangan'] ?></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>