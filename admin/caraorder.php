<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Cara Pemesanan</strong>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <?php if ($_POST) include 'aksi.php' ?>
                <form method="post">
                    <div class="form-group">
                        <textarea class="form-control input-sm mce" name="caraorder"><?= get_options('caraorder') ?></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>