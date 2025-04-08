<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Detail Pemesanan</strong>
    </div>
    <?php
    $order = get_order($_GET['ID']);
    ?>
    <div class="panel-body">
        <p>
            <a class="btn btn-primary btn-sm" href="?m=order"><span class="glyphicon glyphicon-search"></span> Lihat semua pemesanan</a>
            <?php if ($order->status == 'New') : ?>
                <?php if ($order->metode_bayar == 'Transfer' || $order->metode_bayar == 'Indomaret' || $order->metode_bayar == 'Dana') : ?>
                    <a class="btn btn-success btn-sm" href="?m=order_konfirmasi&ID=<?= $_GET['ID'] ?>"><span class="glyphicon glyphicon-usd"></span> Konfirmasi Transfer</a>
                <?php endif ?>
                <a class="btn btn-danger btn-sm" href="aksi.php?act=order_cancel&ID=<?= $_GET['ID'] ?>" onclick="return confirm('Cancel order?')"><span class="glyphicon glyphicon-trash"></span> Cancel Order</a>
            <?php endif ?>
            <?php if ($order->status == 'Dikirim') : ?>
                <a class="btn btn-info btn-sm" href="aksi.php?act=order_selesai&ID=<?= $_GET['ID'] ?>" onclick="return confirm('Konfirmasi produk diterima?')"><span class="glyphicon glyphicon-check"></span> Konfirmasi produk Diterima</a>
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
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Nama produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Diskon</th>
                <th class="text-right">Subtotal</th>
            </tr>
            <?php
            $rows = get_order_detail($_GET['ID']);
            foreach ($rows as $row) :
                $total += $row->subtotal;
            ?>
            <tr>
                <td><?= ++$no ?></td>
                <td><?= $row->nama_produk ?></td>
                <td><?= $row->jumlah ?></td>
                <td>Rp <?= number_format($row->harga) ?></td>
                <td> <?=$row->diskon ?>% => Rp <?= number_format($row->diskon_detail) ?></td>
                <td class="text-right">Rp <?= number_format($row->subtotal) ?></td>
            </tr>
        <?php endforeach;
        $ongkos_kirim =  $order->ongkos_kirim;
        ?>
        <tr>
            <td class="text-right" colspan="5">Total</td>
            <td class="text-right">Rp <?= number_format($order->total) ?></td>
        </tr>
        <tr>
            <td class="text-right" colspan="5">Kode Promo</td>
            <td class="text-right">Rp <?= number_format($order->diskon_promo) ?></td>
        </tr>
       
        <tr>
            <td class="text-right" colspan="5">Diskon Bertahap </td>
            <td class="text-right">Rp <?= number_format($order-> diskon_bertahap_rp) ?></td>
        </tr>
        <tr>
            <td class="text-right" colspan="5">Diskon Poin</td>
            <td class="text-right">Rp <?= number_format($order->diskon_poin_rp) ?></td>
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
        <?php if ($order->metode_bayar == 'Indomaret') : ?>
            <tr>
                <td class="text-right" colspan="5">Kode Bayar</td>
                <td class="text-right"><?= kode_bayar($order->kode_bayar) ?></td>
            </tr>
        <?php endif ?>
    </table>
</div>
</div>