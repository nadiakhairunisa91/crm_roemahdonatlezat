<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Login</strong>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12">
                <?php if ($_POST['login']) include 'aksi.php' ?>
                <form method='post' name="login">
                    <div class="form-group">
                        <input class="form-control input-sm" type='text' placeholder='Masukkan Email' name='email' />
                    </div>
                    <div class="form-group">
                        <input class="form-control input-sm" type='password' placeholder="Masukkan password" name='password' />
                    </div>
                    <div class="form-group"><button class="btn btn-primary btn-sm" name="login" value="1"><span class="glyphicon glyphicon-log-in"></span> Login</button></div>
                    <em>Belum punya akun? daftar di <a href="?m=daftar">sini</a>.</em>
                </form>
            </div>
        </div>
    </div>
</div>