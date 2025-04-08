<?php
$row = $db->get_row("SELECT * FROM tb_pelanggan WHERE id_pelanggan='$_GET[ID]'");
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Ubah Pelanggan</strong>
    </div>
    <div class="panel-body">
        <form method="post">
            <div class="row">
                <div class="col-sm-12">
                    <?php if ($_POST) include 'aksi.php' ?>
                    <div class="form-group">
                        <label>Nama Pelanggan <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="text" name="nama_pelanggan" value="<?= $row->nama_pelanggan ?>" />
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <?= get_jk_radio($row->jenis_kelamin) ?>
                    </div>
                    <div class="form-group">
                        <label>Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control input-sm" name="alamat"><?= $row->alamat ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Nama Kota <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="text" name="nama_kota" value="<?= $row->nama_kota ?>" />
                    </div>
                    <div class="form-group">
                        <label>Telepon <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="text" name="telepon" value="<?= $row->telepon ?>" />
                    </div>
                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="text" name="email" disabled="" value="<?= $row->email ?>" />
                        <p>Email tidak boleh diubah</p>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control input-sm" type="password" name="password" />
                        <p>Kosongkan jika tidak ingin mengubah password.</p>
                    </div>
                    <button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                    <a class="btn btn-danger btn-sm" href="?m=pelanggan"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
