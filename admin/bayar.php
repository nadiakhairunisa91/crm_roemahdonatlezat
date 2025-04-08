<div class="panel panel-default">
    <div class="panel-heading">
        <span>
            <strong>Data Konfirmasi Pembayaran</strong>
        </span>
        <form class="form-inline">
            <input type="hidden" name="m" value="bayar" />
            <div class="form-group">
                <input class="form-control input-sm" type="text" name="q" value="<?= $_GET['q'] ?>" />
            </div>
            <div class="form-group">
                <button class="btn btn-success btn-sm"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
                </div>
            </form>
        </div>
        <div class="panel-body">
            <table id="datatables" class="table table-bordered table-hover table-striped table-condensed" width="100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Bukti Bayar</th>
                        <th>Atas Nama</th>
                        <th>Tanggal Pesan</th>
                        <th>Pelanggan</th>
                        <th>Kota</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <?php
                $pg = new Paging;
                $batas = 100;
                $posisi = $pg->get_offset($batas, $_GET['page']);
                $q = esc_field($_GET['q']);

                $from = "FROM tb_order p 
                INNER JOIN tb_pelanggan k ON k.id_pelanggan=p.id_pelanggan 
                INNER JOIN tb_kota kt ON kt.ID=p.kota_kirim
                INNER JOIN tb_detail d ON d.id_order=p.id_order
                INNER JOIN tb_bayar b ON b.id_order=p.id_order";

                $where .= " AND k.nama_pelanggan LIKE '%$q%'";
                $where .= " AND p.status='Pending'";

                $rows = $db->get_results("SELECT b.gambar, b.nama, p.id_order, p.tanggal, k.nama_pelanggan, kt.nama_kota, p.status, p.grantotal
                    $from WHERE 1 $where GROUP BY p.id_order LIMIT $posisi, $batas");
                $no = $posisi;
                foreach ($rows as $row) : ?>
                <tr>
                    <td><?= ++$no ?></td>
                    <td><img class="thumbnail" src="../assets/images/bukti_bayar/<?= $row->gambar ?>" width="100px" /></td>
                    <td><?= $row->nama ?></td>
                    <td><?= tgl_indo($row->tanggal) ?></td>
                    <td><?= $row->nama_pelanggan ?></td>
                    <td><?= $row->nama_kota ?></td>
                    <td>Rp <?= number_format($row->grantotal) ?></td>
                    <td style="white-space: nowrap;">
                        <a class="btn btn-xs btn-warning" href="?m=order_detail&ID=<?= $row->id_order ?>"><span class="glyphicon glyphicon-edit"></span> Detail</a>
                    </td>
                </tr>
            <?php endforeach;
            ?>
        </table>
    </div>
</div>