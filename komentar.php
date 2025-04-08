<div class="panel panel-default">
    <div class="panel-heading">
    <strong><span class="glyphicon glyphicon-shopping-cart"></span> Review Saya</strong>
        <form class="form-inline">
            <input type="hidden" name="m" value="komentar" />
            <div class="form-group">
                <select name="status" class="form-control input-sm">
                    <option value="">Semua Status</option>
                    <?= get_status_order_option($_GET['status']) ?>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-success btn-xs"><span class="glyphicon glyphicon-refresh"></span> Refresh</button>
            </div>
        </form>
    </div>
    <div class="panel-body">
    <table id="datatables" class="table table-bordered table-hover table-striped table-condensed" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Order</th>
                <th>Tanggal Order</th>
                <th>produk</th>
                <th>Bintang</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <?php
        $pg = new Paging;
        $batas = 100;
        $posisi = $pg->get_offset($batas, $_GET['page']);
        $where = "p.id_pelanggan='$_SESSION[pub_id]' AND p.status IN('Selesai', 'Reviewed')";
        $q = esc_field($_GET['q']);
        if ($_GET['status'])
            $where .= " AND p.status='$_GET[status]'";

        $rows = $db->get_results("SELECT *
    FROM tb_komentar k 
    	RIGHT JOIN tb_detail d ON d.id_detail=k.id_detail  
        INNER JOIN tb_produk b ON b.id_produk=d.id_produk 
        INNER JOIN tb_order p ON p.id_order=d.id_order
        INNER JOIN tb_pelanggan k2 ON k2.id_pelanggan=p.id_pelanggan
    WHERE  $where
    GROUP BY p.id_order
    LIMIT $posisi, $batas");
        $no = $posisi;
        foreach ($rows as $row) : ?>
            <tr>
                <td><?= ++$no ?></td>
                <td><?= $row->id_order ?></td>
                <td><?= tgl_indo($row->tanggal) ?></td>
                <td><?= $row->nama_produk ?></td>
                <td><?= $row->bintang ?></td>
                <td style="white-space: nowrap;">
                    <a class="btn btn-xs btn-warning" href="?m=order_detail&ID=<?= $row->id_order ?>"><span class="glyphicon glyphicon-search"></span> Detail</a>
                    <?php if (!$row->reviewed) : ?>
                        <a class="btn btn-xs btn-info" href="?m=komentar_tambah&id_detail=<?= $row->id_detail ?>"><span class="glyphicon glyphicon-comment"></span> Review</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach;
        ?>
    </table>
</div>
</div>