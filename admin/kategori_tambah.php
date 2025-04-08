<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Tambah Kategori</strong>
    </div>
    <div class="panel-body">
        <form method="post">
            <div class="row">
                <div class="col-sm-12">
                    <?php if ($_POST) include 'aksi.php' ?>
                    <div class="form-group">
                        <label>Nama Kategori <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="text" name="nama_kategori" value="<?= $_POST['nama_kategori'] ?>" />
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                        <a class="btn btn-danger btn-sm" href="?m=kategori"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>