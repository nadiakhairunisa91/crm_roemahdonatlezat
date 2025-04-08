<?php
$row = $db->get_row("SELECT * FROM tb_admin WHERE id_admin='$_SESSION[adm_id]'");
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Ubah Password</strong>
    </div>
    <div class="panel-body">
        <form method="post">
            <div class="row">
                <div class="col-sm-12">
                    <?php if ($_POST) include 'aksi.php' ?>
                    <div class="form-group">
                        <label>User <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="text" name="user" disabled="" value="<?= $row->user ?>" />
                    </div>
                    <div class="form-group">
                        <label>Password Lama<span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="password" name="pass1" />
                    </div>
                    <div class="form-group">
                        <label>Password Baru<span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="password" name="pass2" />
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password Baru<span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="password" name="pass3" />
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-save"></span> Ubah Password</button>
                        <a class="btn btn-danger btn-sm" href="?m=admin"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>