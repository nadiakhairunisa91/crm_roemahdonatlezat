<?php
$awal = ($_GET['awal']) ? $_GET['awal'] : date('Y-m-01');
$akhir = ($_GET['akhir']) ? $_GET['akhir'] : date('Y-m-d');
?>


<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Laporan Penjualan Tahunan <small>(<?= tgl_indo($awal) ?> s/d <?= tgl_indo($akhir) ?>)</small></strong>

        <form class="form-inline">
            <input type="hidden" name="m" value="lap_tahun" />
            <div class="form-group">
                <input class="form-control input-sm" type="date" name="awal" value="<?= $awal ?>" />
            </div>
            <div class="form-group">
                <input class="form-control input-sm" type="date" name="akhir" value="<?= $akhir ?>" />
            </div>
            <div class="form-group">
                <button class="btn btn-success btn-sm"><span class="glyphicon glyphicon-refresh"></span> Refresh</button>
            </div>
            <div class="form-group">
                <a class="btn btn-default btn-sm" href="cetak.php?m=lap_tahun&awal=<?= $awal ?>&akhir=<?= $akhir ?>" target="_blank"><span class="glyphicon glyphicon-print"></span> Cetak</a>
            </div>
        </form>
    </div>
    <div class="panel-body">
        <table id="datatables" class="table table-bordered table-hover table-striped table-condensed" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Periode</th>
                    <th>produk</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                </tr>
            </thead>
            <?php
            $q = esc_field($_GET['q']);
            $pg = new Paging;
            $batas = 1000;
            $offset = $pg->get_offset($batas, $_GET['page']);
            $where = " AND o.tanggal>='$awal' AND o.tanggal<='$akhir'";

            $from = "FROM tb_detail d INNER JOIN tb_produk p ON p.id_produk=d.id_produk INNER JOIN tb_order o ON o.id_order=d.id_order";
            $rows = $db->get_results("SELECT MAX(o.tanggal) AS tanggal, p.id_produk, nama_produk, SUM(jumlah) AS jumlah, SUM(jumlah * d.harga) AS total $from WHERE 1 $where GROUP BY YEAR(o.tanggal), p.id_produk LIMIT $offset, $batas");

            $no = $offset;
            $periode = '';
            foreach ($rows as $row) : ?>
            <tr>
                <td><?= ++$no ?></td>
                <td><?= $periode != $row->tanggal ? date('Y', strtotime($row->tanggal)) : '' ?></td>
                <td><?= $row->nama_produk ?></td>
                <td><?= number_format($row->jumlah) ?></td>
                <td><?= rp($row->total) ?></td>
            </tr>
            <?php $periode = $row->tanggal;
            endforeach ?>
        </table>
    </div>
</div>