
<?php
$tanggal1 = ($_GET['tanggal1']) ? $_GET['tanggal1'] : date('Y-m-01');
$tanggal2 = ($_GET['tanggal2']) ? $_GET['tanggal2'] : date('Y-m-d');
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <span>
            <strong>Data Pemesanan</strong>   
        </span>
        <form class="form-inline">
            <input type="hidden" name="m" value="order" />
            <div class="form-group">
                <select name="status" class="form-control input-sm">
                    <option value="">Semua Status</option>
                    <?= get_status_order_option($_GET['status']) ?>
                </select>
            </div>
            <div class="form-group">
                <input class="form-control input-sm" type="date" name="tanggal1" value="<?= $tanggal1 ?>" />
            </div>
            <div class="form-group">
                <input class="form-control input-sm" type="date" name="tanggal2" value="<?= $tanggal2 ?>" />
            </div>
            <div class="form-group">
                <button class="btn btn-success btn-sm"><span class="glyphicon glyphicon-refresh"></span> Refresh</button>
            </div>
            <div class="form-group">
                <a class="btn btn-default btn-sm" href="cetak.php?m=order&status=<?= $_GET['status'] ?>&tanggal1=<?= $tanggal1 ?>&tanggal2=<?= $tanggal2 ?>" target="_blank"><span class="glyphicon glyphicon-print"></span> Cetak</a>
            </div>
        </form>
    </div>
    <div class="panel-body">
        <table id="datatables" class="table table-bordered table-hover table-striped table-condensed" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Pemesanan</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Kota</th>
                    <th>Total</th>
                    <th>Metode</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php
            $pg = new Paging;
            $batas = 1000;
            $posisi = $pg->get_offset($batas, $_GET['page']);
            $where = " AND p.tanggal>='$tanggal1' AND p.tanggal<='$tanggal2'";
            $q = esc_field($_GET['q']);
            if ($_GET['status'])
                $where .= " AND p.status='$_GET[status]'";

            $rows = $db->get_results("SELECT p.id_order, p.tanggal, k.nama_pelanggan, kt.nama_kota, p.status, p.grantotal, p.metode_bayar
                FROM tb_order p 
                INNER JOIN tb_pelanggan k ON k.id_pelanggan=p.id_pelanggan 
                INNER JOIN tb_kota kt ON kt.ID=p.kota_kirim
                WHERE 1 $where
                GROUP BY p.id_order
                LIMIT $posisi, $batas");
            $no = $posisi;
            foreach ($rows as $row) : ?>
            <tr>
                <td><?= ++$no ?></td>
                <td><?= $row->id_order ?></td>
                <td><?= tgl_indo($row->tanggal) ?></td>
                <td><?= $row->nama_pelanggan ?></td>
                <td><?= $row->nama_kota ?></td>
                <td>Rp <?= number_format($row->grantotal) ?></td>
                <td><?= $row->metode_bayar ?></td>
                <td><?= $row->status ?></td>
                <td style="white-space: nowrap;">
                    <a class="btn btn-xs btn-warning" href="?m=order_detail&ID=<?= $row->id_order ?>"><span class="glyphicon glyphicon-edit"></span> Detail</a>
                </td>
            </tr>
        <?php endforeach;
        ?>
    </table>
</div>
</div>