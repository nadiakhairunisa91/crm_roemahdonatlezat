<div class="panel panel-default">
    <div class="panel-heading">
        <h4><span class="glyphicon glyphicon-user"></span><strong> Akun Saya</strong></h4>
    </div>
    <div class="panel-body">
        <?php
        if (empty($_SESSION['pub_id']))
            redirect_js("index.php?m=login");

        $row = $db->get_row("SELECT * FROM tb_pelanggan WHERE id_pelanggan='$_SESSION[pub_id]'");
        ?>
        <div class="row">
            <div class="col-sm-6">
                <h5><span class="glyphicon glyphicon-search"></span> <strong>Data Pribadi</strong></h5>
                <form method="post" action="?m=member&act=member_update_profile&ID=<?= $_GET['ID'] ?>" enctype="multipart/form-data">
                    <?php if ($_POST && $act == 'member_update_profile') include 'aksi.php' ?>
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
                        <button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-save"></span> Simpan Data Pribadi</button>
                    </div>
                </form>
            </div>
            <div class="col-sm-6">
                <h5><span class="glyphicon glyphicon-log-in"></span> <strong>Data Login</strong></h5>
                <?php if ($_POST && $act == 'member_ubah_password') include 'aksi.php' ?>
                <form method="post" action="?m=member&act=member_ubah_password&ID=<?= $_GET['ID'] ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control input-sm" type="text" name="email" disabled="" value="<?= $row->email ?>" />
                        <p class="help-block">Email tidak boleh diubah</p>
                    </div>
                    <div class="form-group">
                        <label>Password Lama <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="password" name="password1" />
                        <p class="help-block">Masukkan password lama.</p>
                    </div>
                    <div class="form-group">
                        <label>Password Baru <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="password" name="password2" />
                        <p class="help-block">Masukkan password baru.</p>
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="password" name="password3" />
                        <p class="help-block">Masukkan ulang password baru.</p>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-save"></span> Ubah Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>