<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Konfirmasi Transfer</strong>
    </div>
    <div class="panel-body">
        <?php
        $order = get_order($_GET['ID']);
        ?>
        <table class="table table-bordered table-condensed" width="100%">
            <tr>
                <td>ID Pesan</td>
                <td><?= $order->id_order ?></td>
            </tr>
            <tr>
                <td>Pelanggan</td>
                <td><?= $order->nama_pelanggan ?></td>
            </tr>
            <tr>
                <td>Tanggal Pesan</td>
                <td><?= tgl_indo($order->tanggal) ?></td>
            </tr>
            <tr>
                <td>Alamat Kirim</td>
                <td><?= $order->alamat_kirim ?></td>
            </tr>
            <tr>
                <td>Kota Kirim</td>
                <td><?= $order->nama_kota ?></td>
            </tr>
           
            <tr>
                <td>Grantotal</td>
                <td>Rp <?= number_format($order->grantotal) ?></td>
            </tr>
            <tr>
                <td>Metode Bayar</td>
                <td><?= $order->metode_bayar ?></td>
            </tr>
            <?php if ($order->metode_bayar == 'Indomaret') : ?>
                <tr>
                    <td>Kode Bayar</td>
                    <td><?= kode_bayar($order->kode_bayar) ?></td>
                </tr>
            <?php endif ?>
            <tr>
                <td>Status</td>
                <td><?= $order->status ?></td>
            </tr>
        </table>
        <div class="row">
        <div class="col-sm-12">
                <?php
                if ($_POST) include 'aksi.php';
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Nama Pemilik Rekening (Nama Pelanggan) <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="text" name="nama" value="<?= $_POST['atas_nama'] ?>" />
                    </div>
                    <div class="form-group">
                        <label>Bukti Pembayaran <span class="text-danger">*</span></label>
                        <input class="form-control input-sm" type="file" name="gambar" />
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-check"></span> Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>