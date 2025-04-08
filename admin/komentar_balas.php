<?php
$row = $db->get_row("SELECT * FROM tb_komentar WHERE id_komentar='$_GET[ID]'");
?>
<div class="panel panel-default">
<div class="panel-heading">
    <strong>Balas Komentar</strong>
</div>
<div class="panel-body">
<form method="post">
    <div class="row">
        <div class="col-sm-12">
            <?php if ($_POST) include 'aksi.php' ?>
            <div class="form-group">
                <label>Komentar</label>
                <textarea class="form-control input-sm" name="isi_komentar" readonly><?= $row->isi_komentar ?></textarea>
            </div>
            <div class="form-group">
                <label>Balasan <span class="text-danger">*</span></label>
                <textarea class="form-control input-sm" name="balasan"><?= $row->balasan ?></textarea>
            </div>
            <button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-save"></span> Simpan</button>
            <a class="btn btn-danger btn-sm" href="?m=komentar"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
        </div>
    </div>
</form>
</div>
</div>