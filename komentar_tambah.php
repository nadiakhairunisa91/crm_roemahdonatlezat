<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Tambah Komentar</strong>
    </div>
    <?php
    $row = get_detail($_GET['id_detail']);
    ?>
    <div class="panel-body">
        <form method="post">
            <div class="row">
                <div class="col-sm-12">
                    <input type="hidden" name="id_detail" value="<?= $row->id_detail ?>" />
                    <?php if ($_POST) include 'aksi.php' ?>
                    <div class="form-group">
                        <label>Nama produk</label>
                        <input class="form-control input-sm" type="text" name="nama_produk" value="<?= $row->nama_produk ?>" readonly />
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input class="form-control input-sm" type="text" name="harga" value="<?= rp($row->harga) ?>" readonly />
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <input class="form-control input-sm" type="text" name="jumlah" value="<?= $row->jumlah ?>" readonly />
                    </div>
                    <div class="form-group">
                        <label>Subtotal</label>
                        <input class="form-control input-sm" type="text" name="subtotal" value="<?= rp($row->subtotal) ?>" readonly />
                    </div>
                    <div class="form-group">
                        <label>Berikan Bintang <span class="text-danger">*</span></label>
                        <select class="form-control input-sm" name="bintang">
                            <option value=""></option>
                            <?= get_bintang_option(set_value('bintang', $row->bintang)) ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Berikan Komentar (Optional)</label>
                        <textarea class="form-control input-sm" name="isi_komentar"><?= set_value('isi_komentar', $row->isi_komentar) ?></textarea>
                    </div>
                    <button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                    <a class="btn btn-danger btn-sm" href="?m=komentar"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>