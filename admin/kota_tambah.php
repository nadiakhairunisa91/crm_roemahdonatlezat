<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Tambah Data Ongkos Kirim</strong>
    </div>
    <div class="panel-body">
        <form method="post">
            <div class="row">
                <div class="col-sm-6">
                    <?php if ($_POST) include 'aksi.php' ?>
                    <div class="form-group">
                        <label>Nama Kota <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="text" name="nama_kota" value="<?= $_POST['nama_kota'] ?>" />
                    </div>
                    <div class="form-group">
                        <label>Ongkos Kirim <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="text" name="ongkos_kirim" value="<?= $_POST['ongkos_kirim'] ?>" />
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                        <a class="btn btn-danger btn-sm" href="?m=kota"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>