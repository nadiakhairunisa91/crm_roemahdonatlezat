<?php
$row = $db->get_row("SELECT * FROM tb_admin WHERE id_admin='$_GET[ID]'");
?>
<h1>Ubah Admin</h1>
<form method="post">
    <div class="row">
        <div class="col-sm-6">
            <?php if ($_POST) include 'aksi.php' ?>
            <div class="form-group">
                <label>Nama Admin <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama_admin" value="<?= $row->nama_admin ?>" />
            </div>
            <div class="form-group">
                <label>User <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="user" value="<?= $row->user ?>" />
            </div>
            <div class="form-group">
                <label>Password</label>
                <input class="form-control" type="password" name="pass" />
                <p>Kosongkan jika tidak ingin mengubah password.</p>
            </div>
            <div class="form-group">
                <label>Level <span class="text-danger">*</span></label>
                <?= get_level_radio($row->level) ?>
            </div>
            <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
            <a class="btn btn-danger" href="?m=admin"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
        </div>
    </div>
</form>