<div class="panel panel-default">
    <div class="panel-heading">
        <span>
            <strong> Data promo </strong>
            <a class="btn btn-primary btn-xs" href="?m=promo_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
        </span>
    </div>
    <div class="panel-body">
        <table id="datatables" class="table table-bordered table-hover table-striped table-condensed" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode promo</th>
                    <th>Promo</th>
                    <th>Diskon</th>
                    <th>Minimal Belanja</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $pg = new Paging;
            $batas = 100;
            $posisi = $pg->get_offset($batas, $_GET['page']);

            $q = esc_field($_GET['q']);
            $rows = $db->get_results("SELECT * FROM tb_promo WHERE nama_promo LIKE '%$q%' ORDER BY nama_promo LIMIT $posisi, $batas");
            $no = $posisi;

            // Periksa apakah ada data yang ditemukan
            if ($rows) {
                foreach ($rows as $row) : ?>
                    <tr>
                        <td><?= ++$no ?></td>
                        <td><?= $row->kode_promo ?></td>
                        <td><?= $row->nama_promo ?></td>
                        <td><?= $row->diskon_promo ?>%</td>
                        <td><?= rp($row->minimal_belanja) ?></td> <!-- Tampilkan minimal belanja -->
                        <td><?= $row->ket_promo ?></td>
                        <td><?= $row->status_promo ?></td>
                        <td style="white-space: nowrap;">
                            <a class="btn btn-xs btn-warning" href="?m=promo_ubah&ID=<?= $row->id_promo ?>"><span class="glyphicon glyphicon-edit"></span> Ubah</a>
                            <a class="btn btn-xs btn-danger" href="aksi.php?m=promo_hapus&ID=<?= $row->id_promo ?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span> Hapus</a>
                        </td>
                    </tr>
                <?php endforeach;
            } else {
                // Jika tidak ada data, tampilkan pesan
                echo '<tr><td colspan="9" class="text-center">Tidak ada data yang ditemukan.</td></tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
</div>