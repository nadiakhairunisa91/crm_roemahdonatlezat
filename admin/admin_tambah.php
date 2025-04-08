<h1>Tambah Admin</h1>
<form method="post">
    <div class="row">
        <div class="col-sm-6">
            <?php if ($_POST) include 'aksi.php' ?>
            <div class="form-group">
                <label>Nama Admin <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama_admin" value="<?= $_POST['nama_admin'] ?>" />
            </div>
            <div class="form-group">
                <label>User <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="user" value="<?= $_POST['user'] ?>" />
            </div>
            <div class="form-group">
                <label>Password <span class="text-danger">*</span></label>
                <input class="form-control" type="password" name="pass" />
            </div>
            <div class="form-group">
                <label>Level <span class="text-danger">*</span></label>
                <?= get_level_radio($_POST['level']) ?>
            </div>
            <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
            <a class="btn btn-danger" href="?m=admin"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
        </div>
    </div>
</form>