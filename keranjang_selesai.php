<?php
$pelanggan = get_pelanggan($IDP);
if (!$pelanggan) {
    alert("Anda harus login untuk checkout!");
    redirect_js('index.php?m=login');
}
?>
<div class="panel panel-default">
    <div class="panel-heading">Detail Order produk</div>
    <div class="panel-body">
        <table class="table table-bordered table-condensed" width="100%">
            <tr>
                <td>Nama</td>
                <td><?= $pelanggan->nama_pelanggan ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td><?= $pelanggan->alamat ?></td>
            </tr>
            <tr>
                <td>Kota</td>
                <td><?= $pelanggan->nama_kota ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?= $pelanggan->email ?></td>
            </tr>
            <tr>
                <td>Telepon</td>
                <td><?= $pelanggan->telepon ?></td>
            </tr>
        </table>

        <table class="table table-bordered table-condensed" width="100%">
            <tr>
                <th>No</th>
                <th>Nama produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Diskon</th>
                <th>Subtotal</th>
            </tr>
            <?php
            $rows = $db->get_results("SELECT * FROM tb_temp t INNER JOIN tb_produk b ON b.id_produk=t.id_produk WHERE session_id='$sid'");
            if (!$rows) {
                alert('Keranjang belanja masih kosong!');
                redirect_js("index.php?m=keranjang");
            }
            $no = 1;
            $total = 0;
            $poin_temp = 0;
            foreach ($rows as $row) {
                $diskon = ($row->diskon / 100) * $row->harga;
                $subtotal = ($row->harga - $diskon) * $row->jumlah;
                $total += $subtotal;
                $poin_temp = $row->poin_temp;
                echo "
                <tr>
                    <td align='center'>$no<input type='hidden' name='ID[$no]' value='$row->id_temp'/></td>
                    <td>$row->nama_produk</td>                    
                    <td>$row->jumlah</td>
                    <td>" . rp($row->harga) . "</td>
                    <td>" . ($row->diskon) . "% => " . rp($diskon) . "</td>
                    <td>" . rp($subtotal) . "</td>
                </tr>";
                $no++;
            }

            // Menghitung Kode Promo
            $kode_promo = set_value('kode_promo', $db->get_var("SELECT kode_promo FROM tb_temp WHERE session_id='$sid'"));
            $promo = $db->get_row("SELECT * FROM tb_promo WHERE kode_promo='$kode_promo'");
            $diskon_promo = $promo->diskon_promo / 100 * $total;

            // Menghitung diskon poin
            $diskon_poin_persen = $poin_temp / $POIN_KELIPATAN;
            $diskon_poin_rp = round($diskon_poin_persen * $POIN_RP);

            // Menghitung diskon bertingkat
            $diskon_bertahap_persen = 0;
            if ($total >= 300000) {
                $diskon_bertahap_persen = floor(($total - 300000) / 100000) * 5 + 5; // 5% untuk 300 ribu dan tambahan 5% setiap 100 ribu
            }
            $diskon_bertahap_rp = ($diskon_bertahap_persen / 100) * $total;

            // Menghitung grantotal
            $grantotal = $total - $diskon_poin_rp - $diskon_promo - $diskon_bertahap_rp;
            ?>
            <tr>
                <td colspan="5">Total</td>
                <td><?= rp($total) ?></td>
            </tr>
            <tr>
                <td colspan="5">Kode Promo</td>
                <td><?= rp($diskon_promo) ?></td>
            </tr>
            <tr>
                <td colspan="5">Diskon Poin</td>
                <td><?= rp($diskon_poin_rp) ?></td>
            </tr>
            <tr>
                <td colspan="5">Diskon Bertingkat (<?= $diskon_bertahap_persen ?>%)</td>
                <td><?= rp($diskon_bertahap_rp) ?></td>
            </tr>
            <tr>
                <td colspan="5">Grantotal</td>
                <td><?= rp($grantotal) ?></td>
            </tr>
        </table>
    </div>
    <div class="panel-body">
        <?php if ($_POST) include 'aksi.php'; ?>
        <form class="form-horizontal" method="post">
            <input type="hidden" name="total" value="<?= $total ?>">
            <input type="hidden" name="kode_promo" value="<?= $kode_promo ?>">
            <input type="hidden" name="diskon_promo" value="<?= $diskon_promo ?>">
            <input type="hidden" name="diskon_poin_persen" value="<?= $diskon_poin_persen ?>" />
            <input type="hidden" name="diskon_poin_rp" value="<?= $diskon_poin_rp ?>" />
            <input type="hidden" name="diskon_bertahap_rp" value="<?= $diskon_bertahap_rp ?>" />
            <input type="hidden" name="poin_diskon" value="<?= $poin_temp ?>" />
            <div class="form-group">
                <label class="col-sm-3 control-label">Kota <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <select class="form-control input-sm" name="kota">
                        <option value="">--Pilih Kota--</option>
                        <?= get_kota_option($_POST['kota']) ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Alamat kirim<span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <textarea class="form-control input-sm" name="alamat"><?= $pelanggan->alamat ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Metode Bayar <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <select class="form-control input-sm" name="metode_bayar">
                        <option value="">--Pilih Metode--</option>
                        <?= get_metode_bayar_option($_POST['kota']) ?>
                    </select>
                </div>
            </div>
            <button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-ok"></span> Checkout</button>
        </form>
    </div>
</div>