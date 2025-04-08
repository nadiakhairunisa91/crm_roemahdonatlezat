<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Daftar</strong>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (isset($_SESSION['pub_id']))
                    redirect_js('index.php?m=member');

                if ($_POST) include 'aksi.php';
                ?>
                <form action='?m=daftar' class='' method='post'>
                    <div class="form-group">
                        <label>Nama <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type='text' name='nama_pelanggan' value='<?= $_POST['nama_pelanggan'] ?>' size='30' />
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <?= get_jk_radio($_POST['jk']) ?>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control input-sm" name='alamat'><?= $_POST['alamat'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Kota</label>
                        <input class="form-control input-sm" type='text' name='nama_kota' value='<?= $_POST['nama_kota'] ?>' />
                    </div>
                    <div class="form-group">
                        <label>Telepon <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="text" name="telepon" value="<?= $row->telepon ?>" />
                    </div>
                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type='text' name='email' value='<?= $_POST['email'] ?>' />
                    </div>
                    <div class="form-group">
                        <label>Password <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type='password' name='pass1' value='<?= $_POST['pass1'] ?>' />
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type='password' name='pass2' value='<?= $_POST['pass2'] ?>' />
                    </div>
                    <button class="btn btn-primary btn-sm">Daftar</button>
                </form>
            </div>
        </div>
    </div>
</div>