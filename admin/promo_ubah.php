<?php
$row = $db->get_row("SELECT * FROM tb_promo WHERE id_promo='$_GET[ID]'");
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Ubah promo</strong>
    </div>
    <div class="panel-body">
        <form method="post">
            <div class="row">
                <div class="col-sm-12">
                    <?php if ($_POST) include 'aksi.php' ?>
                    <div class="form-group">
                        <label>Kode Promo <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="text" name="kode_promo" value="<?= set_value('kode_promo', $row->kode_promo) ?>" readonly />
                    </div>
                    <div class="form-group">
                        <label>Promo <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="text" name="nama_promo" value="<?= set_value('nama_promo', $row->nama_promo) ?>" />
                    </div>
                    <div class="form-group">
                        <label>Diskon <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="text" name="diskon_promo" value="<?= set_value('diskon_promo', $row->diskon_promo) ?>" />
                    </div>
                    <div class="form-group">
                        <label>Minimal Balanja <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="text" name="minimal_belanja" value="<?= set_value('minimal_belanja', $row->minimal_belanja) ?>" />
                    </div>
                   
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input class="form-control input-sm" type="text" name="ket_promo" value="<?= set_value('ket_promo', $row->ket_promo) ?>" />
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <?= get_status_promo_radio(set_value('status_promo', $row->status_promo)) ?>
                    </div>
                    <button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                    <a class="btn btn-danger btn-sm" href="?m=promo"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>