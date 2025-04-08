<div class="panel panel-default">
<div class="panel-heading">
<strong>Detail Pemesanan</strong>
</div>
<div class="panel-body">
<?php
$order = get_order($_GET['ID']);
?>
<p>
    <a class="btn btn-primary btn-sm" href="?m=order"><span class="glyphicon glyphicon-search"></span> Lihat semua pemesanan</a>
    <?php if ($order->metode_bayar == 'Cash on Delivery' && $order->status == 'New') : ?>
        <a class="btn btn-info" href="aksi.php?act=order_kirim&ID=<?= $_GET['ID'] ?>" onclick="return confirm('Konfirmasi pengiriman COD?')"><span class="glyphicon glyphicon-check"></span> Konfirmasi Pengiriman COD</a>
    <?php endif ?>

     <?php if ($order->metode_bayar == 'Indomaret' && $order->status == 'Pending') : ?>
        <a class="btn btn-info" href="aksi.php?act=order_kirim&ID=<?= $_GET['ID'] ?>" onclick="return confirm('Konfirmasi pengiriman?')"><span class="glyphicon glyphicon-check"></span> Konfirmasi Pengiriman</a>
    <?php endif ?> 
</p>
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
        <td><?= $order->nama_kota ?> (Rp <?= number_format($order->ongkos_kirim) ?>)</td>
    </tr>
   
    <tr>
        <td>Status</td>
        <td><?= $order->status ?></td>
    </tr>
</table>
<table class="table table-bordered table-condensed" width="100%">
    <tr>
        <th>No</th>
        <th>Nama produk</th>
        <th>Jumlah</th>
        <th>Harga</th>
        <th>Diskon</th>
        <th class="text-right">Subtotal</th>
    </tr>
    <?php
    $rows = $db->get_results("SELECT d.id_produk, b.nama_produk, d.harga, d.diskon_detail, d.jumlah, d.subtotal
        FROM tb_detail d INNER JOIN tb_produk b ON b.id_produk=d.id_produk WHERE id_order='$_GET[ID]'");

    foreach ($rows as $row) :
        $total += $row->subtotal;
    ?>
        <tr>
            <td><?= ++$no ?></td>
            <td><?= $row->nama_produk ?></td>
            <td><?= $row->jumlah ?></td>
            <td>Rp <?= number_format($row->harga) ?></td>
            <td>Rp <?= number_format($row->diskon_detail) ?></td>
            <td class="text-right">Rp <?= number_format($row->subtotal) ?></td>
        </tr>
    <?php endforeach;
    $ongkos_kirim =  $order->ongkos_kirim;
    ?>
    <tr>
        <td class="text-right" colspan="5">Total</td>
        <td class="text-right">Rp <?= number_format($total) ?></td>
    </tr>
    <tr>
        <td class="text-right" colspan="5">Kode Promo</td>
        <td class="text-right">Rp <?= number_format($order->diskon_promo) ?></td>
    </tr>
    
    <tr>
        <td class="text-right" colspan="5">Diskon poin</td>
        <td class="text-right">Rp <?= number_format($order->diskon_poin_rp) ?></td>
    </tr>
    <tr>
        <td class="text-right" colspan="5">Diskon Bertahap</td>
        <td class="text-right">Rp <?= number_format($order->diskon_bertahap_rp) ?></td>
    </tr>
    <tr>
        <td class="text-right" colspan="5">Ongkos Kirim</td>
        <td class="text-right">Rp <?= number_format($ongkos_kirim) ?></td>
    </tr>
    <tr>
        <td class="text-right" colspan="5">Grandtotal</td>
        <td class="text-right">Rp <?= number_format($order->grantotal) ?></td>
    </tr>
    <tr>
        <td class="text-right" colspan="5">Metode Bayar</td>
        <td class="text-right"><?= $order->metode_bayar ?></td>
    </tr>
</table>
<?php if ($order->metode_bayar == 'Transfer' || $order->metode_bayar == 'Indomaret' || $order->metode_bayar == 'Dana') : ?>
    <strong>Konfirmasi Pembayaran</strong>
    <?php
    if ($order->status == 'New' || $order->status == 'Cancel') : ?>
        <p>Pembayaran pemesanan ini belum dikonfirmasi oleh pelanggan.</p>
    <?php else :
        $bayar = $db->get_row("SELECT * FROM tb_bayar WHERE id_order='$_GET[ID]'");
    ?>
        <table class="table table-bordered table-condensed" width="100%">
            <tr>
                <td>Atas Nama</td>
                <td><?= $bayar->nama ?></td>
            </tr>
            <tr>
                <td>Bukti Bayar</td>
                <td>
                    <a href="../assets/images/bukti_bayar/<?= $bayar->gambar ?>" target="_blank">
                        <img class="thumbnail" src="../assets/images/bukti_bayar/<?= $bayar->gambar ?>" width="100" />
                    </a>
                </td>
            </tr>
        </table>
        <?php if ($bayar->status == '') : ?>
            <a class="btn btn-primary btn-sm" href="aksi.php?act=order_konfirmasi&ID=<?= $_GET['ID'] ?>" onclick="return confirm('Konfirmasi pembayaran???')"><span class="glyphicon glyphicon-check"></span> Konfirmasi</a>
        <?php else : ?>
            <p>Pemesanan sudah terkonfirmasi.</p>
        <?php endif; ?>
    <?php endif ?>
<?php endif ?>
</div>
</div>