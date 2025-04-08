<?php

$kode_promo = set_value('kode_promo', $db->get_var("SELECT kode_promo FROM tb_temp WHERE session_id='$sid'"));

if ($_POST) include 'aksi.php';

$pelanggan = $db->get_row("SELECT * FROM tb_pelanggan WHERE id_pelanggan='$IDP'");
if (!$pelanggan) {
    print_msg('Silahkan login untuk bisa menggunakan poin!');
}
$rows = $db->get_results("SELECT * FROM tb_temp t         
        INNER JOIN tb_produk b ON b.id_produk=t.id_produk 
    WHERE session_id='$sid'
    ORDER BY id_temp DESC");

if (!$rows) :
    alert('Keranjang Belanja Masih Kosong');
    redirect_js('index.php?m=produk');
else : ?>
    <blockquote>
        Total Poin: <?= $pelanggan->poin_in + $pelanggan->poin_out ?><br />
    </blockquote>
    <?= print_msg(
        "1. Anda bisa memperoleh diskon bertingkat 5% apabila melakukan pembelian di atas Rp.300.000 <br>" .
        "2. Anda bisa memperoleh kelipatan 1 poin dengan melakukan pembelian Rp100.000 ke atas <br>" .
        "3. Anda bisa memperoleh tambahan diskon " . rp($POIN_RP) . " dari total jual setiap kelipatan $POIN_KELIPATAN poin.", 
        'info'
    ) ?>

    <form method="post">
        <table class="table table-bordered table-striped table-hover table-condensed" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama produk</th>
                    <th>Hapus</th>
                    <th>Qty</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Diskon</th>
                    <th class="text-right">Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $promo = $db->get_row("SELECT * FROM tb_promo WHERE kode_promo='$kode_promo'");
                $no = 1;
                $poin_temp = 0;
                $total = 0;
                $diskon_poin_persen = 0;
                $diskon_poin_rp = 0;
                $grantotal = 0;

                foreach ($rows as $row) :
                    $harga = $row->harga;
                    $diskon_rp = $row->harga * $row->diskon / 100;
                    $subtotal = ($harga - $diskon_rp) * $row->jumlah;
                    $total += $subtotal;
                    $poin_temp = $row->poin_temp;
                ?>
                    <tr>
                        <td><?= $no ?><input type="hidden" name="ID[<?= $no ?>]" value="<?= $row->id_temp ?>" /></td>
                        <td><img class="thumbnail" width="70" src="assets/images/produk/small_<?= $row->gambar ?>" /></td>
                        <td><?= $row->nama_produk ?></td>
                        <td><a class="btn btn-danger btn-xs" href="aksi.php?m=keranjang_hapus&ID=<?= $row->id_temp ?>" onclick="return confirm('Hapus item?')"><span class="glyphicon glyphicon-trash"></span></a></td>
                        <td><input class="form-control input-sm aw" type="text" name='jml[<?= $no ?>]' value="<?= $row->jumlah ?>" size="2" /></td>
                        <td class="text-right nw"><?= rp($harga) ?></td>
                        <td class="text-right nw"><?= $row->diskon;?>% => <?= rp($diskon_rp) ?></td>
                        <td class="text-right nw"><?= rp($subtotal) ?></td>
                    </tr>
                <?php $no++;
                endforeach;

                // Menghitung diskon poin
                $diskon_poin_persen = $poin_temp / $POIN_KELIPATAN;
                $diskon_poin_rp = $diskon_poin_persen * $POIN_RP;

                // Menghitung Kode Promo
                $diskon_promo = 0;
                $minimal_belanja = $promo->minimal_belanja ?? 0; // Ambil nilai minimal_belanja dari promo
                if ($promo && $promo->diskon_promo > 0 && $total >= $minimal_belanja) {
                    $diskon_promo = ($promo->diskon_promo / 100) * $total;
                }

                // Menghitung diskon bertingkat
                $diskon_bertahap_persen = 0;
                if ($total >= 300000) {
                    $diskon_bertahap_persen = floor(($total - 300000) / 100000) * 5 + 5; // 5% untuk 300 ribu dan tambahan 5% setiap 100 ribu
                }
                $diskon_bertahap_rp = ($diskon_bertahap_persen / 100) * $total;

                // Menghitung grantotal
                $grantotal = $total - $diskon_poin_rp - $diskon_promo - $diskon_bertahap_rp;
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" class="text-right">Total</td>
                    <td class="text-right nw"><?= rp($total) ?></td>
                </tr>
                <tr>
                    <td class="form-inline" colspan="5">
                        <input class="form-control input-sm" name="kode_promo" value="<?= $kode_promo ?>" />
                        <button class="btn btn-warning btn-sm" name="apply_coupon" value="1">
                            <span class="glyphicon glyphicon-check"></span> Input Kode Promo
                        </button> <?= $ket_promo ?>
                    </td>
                    <td colspan="2" align="right">Kode Promo (<?= $promo->diskon_promo ?>%)</td>
                    <td class="text-right nw"><?= rp($diskon_promo) ?></td>
                </tr>
                <tr>
                    <td class="form-inline" colspan="5">
                        <input class="form-control input-sm" type="number" name="poin_temp" value="<?= $poin_temp ?>" />
                        <button class="btn btn-warning btn-sm" type="submit" name="update_poin" value="1">
                            <span class="glyphicon glyphicon-check"></span> Terapkan Poin
                        </button>
                    </td>
                    <td colspan="2" class="text-right">Diskon Poin (<?= $diskon_poin_persen ?> * <?= rp($POIN_RP) ?>)</td>
                    <td class="text-right nw"><?= rp($diskon_poin_rp) ?></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">Diskon Bertingkat (<?= $diskon_bertahap_persen ?>%)</td>
                    <td class="text-right nw">-<?= rp($diskon_bertahap_rp) ?></td>
                </tr>
                <tr>
                    <td colspan="7" class="text-right">Grantotal</td>
                    <td class="text-right nw"><?= rp($grantotal) ?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <a class="btn btn-primary btn-sm" href="?m=produk">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Lanjutkan
                        </a>
                    </td>
                    <td colspan="2">
                        <button class="btn btn-info btn-sm" type="submit" name="update" value="1">
                            <span class="glyphicon glyphicon-refresh"></span> Update
                        </button>
                    </td>
                    <td class="form-inline" colspan="3"></td>
                    <td colspan="3" class="text-right">
                        <a class="btn btn-success btn-sm" href="?m=keranjang_selesai">
                            <span class="glyphicon glyphicon-check"></span> Selesai
                        </a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
    *) Apabila Anda mengubah jumlah (<b>Qty</b>), jangan lupa tekan tombol <b>Update</b>.<br />
<?php endif ?>