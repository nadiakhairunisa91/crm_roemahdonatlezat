<div class="panel panel-default">
    <div class="panel-heading">
        <span>
            <strong>Komentar Pelanggan</strong>
        </span>
    </div>
    <div class="panel-body">
        <table id="datatables" class="table table-bordered table-hover table-striped table-condensed" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Order</th>
                    <th>produk</th>
                    <th>Bintang</th>
                    <th>Pelanggan</th>
                    <th>Komentar</th>
                    <th>Balasan Admin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php
            $pg = new Paging;
            $batas = 100;
            $posisi = $pg->get_offset($batas, $_GET['page']);
            $q = esc_field($_GET['q']);
            $where = " AND nama_produk LIKE '%$q%'";

            $from = "FROM tb_komentar k 
            INNER JOIN tb_detail d ON d.id_detail=k.id_detail  
            INNER JOIN tb_produk b ON b.id_produk=d.id_produk 
            INNER JOIN tb_order p ON p.id_order=d.id_order
            INNER JOIN tb_pelanggan k2 ON k2.id_pelanggan=p.id_pelanggan";

            $rows = $db->get_results("SELECT * $from WHERE 1 $where GROUP BY p.id_order LIMIT $posisi, $batas");
            $no = $posisi;
            foreach ($rows as $row) : ?>
            <tr>
                <td><?= ++$no ?></td>
                <td><?= tgl_indo($row->tanggal_komentar) ?></td>
                <td><?= $row->nama_produk ?></td>
                <td><?= $row->bintang ?></td>
                <td><?= $row->nama_pelanggan ?></td>
                <td><?= $row->isi_komentar ?></td>
                <td><?= $row->balasan ?></td>
                <td style="white-space: nowrap;">
                    <a class="btn btn-xs btn-primary" href="?m=komentar_balas&ID=<?= $row->id_komentar ?>"><span class="glyphicon glyphicon-comment"></span> Balas</a>
                    <a class="btn btn-xs btn-info" href="../index.php?m=produk_detail&ID=<?= $row->id_produk ?>#komentar" target="_blank"><span class="glyphicon glyphicon-search"></span> Lihat</a>
                </td>
            </tr>
        <?php endforeach;
        ?>
    </table>
</div>
</div>