<?= show_msg() ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <strong><span class="glyphicon glyphicon-bitcoin"></span> Data Poin</strong>
    </div>
    <div class="panel-body">
        <table id="datatables" class="table table-bordered table-hover table-striped table-condensed" width="100%">
            <thead>
                <tr class="nw">
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>ID Pemesanan</th>
                </tr>
            </thead>
            <?php
            $q = esc_field($_GET['q']);
            $pg = new Paging();
            $limit = 100;
            $offset = $pg->get_offset($limit, $_GET['page']);
            $from = " FROM tb_poin p";
            $where = " WHERE (ket_poin LIKE '%$q%') AND p.id_pelanggan='$_SESSION[pub_id]'";
            $rows = $db->get_results("SELECT * $from $where ORDER BY tanggal_poin DESC LIMIT $offset, $limit");
            $no = $offset;
            $jumrec = $db->get_var("SELECT COUNT(*) $from $where");

            update_poin($_SESSION['pub_id']);

            foreach ($rows as $row) : ?>
            <tr>
                <td><?= ++$no ?></td>
                <td><?= $row->tanggal_poin ?></td>
                <td><?= $row->jumlah_poin ?></td>
                <td><?= $row->ket_poin ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<div class="panel-footer">
  <blockquote>
    <?php
    $row = $db->get_row("SELECT * FROM tb_pelanggan WHERE id_pelanggan='$_SESSION[pub_id]'");
    ?>
    Poin Masuk: <?= $row->poin_in ?><br />
    Poin Keluar: <?= $row->poin_out ?><br />
    Total: <?= $row->poin_in + $row->poin_out ?><br />
</blockquote>
</div>
</div>