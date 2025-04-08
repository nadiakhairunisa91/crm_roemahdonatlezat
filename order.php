<div class="panel panel-default">
    <div class="panel-heading">
        <strong><span class="glyphicon glyphicon-shopping-cart"></span> Order Saya</strong>
        <form class="form-inline">
            <input type="hidden" name="m" value="order" />
            <div class="form-group">
                <select name="status" class="form-control input-sm">
                    <option value="">Semua Status</option>
                    <?= get_status_order_option($_GET['status']) ?>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-success btn-xs"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
                </div>
            </form>
        </div>
        <div class="panel-body">
            <table id="datatables" class="table table-bordered table-h%ver table-striped table-condensed" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Pemesanan</th>
                        <th>Tanggal</th>
                        <th>Kota</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <?php
                $pg = new Paging;
                $batas = 100;
                $posisi = $pg->get_offset($batas, $_GET['page']);
                $where = "p.id_pelanggan='$_SESSION[pub_id]'";
                $q = esc_field($_GET['q']);
                if ($_GET['status'])
                    $where .= " AND p.status='$_GET[status]'";

                $rows = $db->get_results("SELECT p.id_order, p.tanggal, kt.nama_kota, p.status, p.grantotal, p.metode_bayar
                    FROM tb_order p 
                    INNER JOIN tb_pelanggan k ON k.id_pelanggan=p.id_pelanggan 
                    INNER JOIN tb_kota kt ON kt.ID=p.kota_kirim
                    WHERE  $where
                    GROUP BY p.id_order
                    LIMIT $posisi, $batas");
                $no = $posisi;
                foreach ($rows as $row) : ?>
                <tr>
                    <td><?= ++$no ?></td>
                    <td><?= $row->id_order ?></td>
                    <td><?= tgl_indo($row->tanggal) ?></td>
                    <td><?= $row->nama_kota ?></td>
                    <td>Rp <?= number_format($row->grantotal) ?></td>
                    <td><?= $row->metode_bayar ?></td>
                    <td><?= $row->status ?></td>
                    <td style="white-space: nowrap;">
                        <a class="btn btn-xs btn-warning" href="?m=order_detail&ID=<?= $row->id_order ?>"><span class="glyphicon glyphicon-search"></span> Detail</a>
                        <?php if ($row->status == 'New') : ?>
                            <!-- <a class="btn btn-xs btn-info" href="?m=order_konfirmasi&ID=<?= $row->id_order ?>"><span class="glyphicon glyphicon-usd"></span> Konfirmasi</a> -->
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>