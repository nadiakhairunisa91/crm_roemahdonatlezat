<?php include 'left_user.php' ?>
<?php
$rows = $db->get_results("SELECT b.id_produk, b.harga, b.gambar, b.nama_produk, b.id_kategori, k.nama_kategori, b.stock, SUM(d.jumlah) AS total 
    FROM tb_produk b LEFT JOIN tb_kategori k ON k.id_kategori=b.id_kategori LEFT JOIN tb_detail d ON b.id_produk=d.id_produk 
    WHERE stock>0
    GROUP BY b.id_produk
    ORDER BY rand() DESC
    LIMIT 2");

    foreach ($rows as $row) : ?>
    <div class="listing">
        <div class="thumbnail">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="caption">
                        <a class="label label-info pull-right" href="?m=produk&id_kategori=<?= $row->id_kategori ?>"><?= $row->nama_kategori ?></a>
                        <strong>
                            <a href="?m=produk_detail&ID=<?= $row->id_produk ?>"><?= $row->nama_produk ?></a>
                        </strong>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="text-center"><?= show_rating($row->bintang_total) ?></div>
                    <a href="?m=produk_detail&ID=<?= $row->id_produk ?>">
                        <img width="100%" src="<?= produk_image($row->gambar) ?>" alt="<?= $row->nama_produk ?>" />
                    </a>
                </div>
                <div class="panel-footer">
                    <div class="caption">
                        <p>
                            <?=($row->stock>0)?'<span class="label label-success">'.$row->stock.' Tersedia</span>':'<span class="label label-danger">Stok habis</span>'?>
                            <span class="pull-right text-success"> <strong><strike>Rp.<?=number_format($row->harga)?> </strike></strong> <small> (Disc.<b><?=$row->diskon?>%)</b></small></span>

                            <span class="pull-right text-success"><strong>Rp.<?=number_format($row->harga - ($row->diskon/100 * $row->harga))?></strong></span>
                        </p>
                        <a class="btn btn-sm <?= ($row->stock > 0) ? 'btn-primary' : 'disabled btn-default' ?>" href="aksi.php?m=keranjang_tambah&ID=<?= $row->id_produk ?>"><span class="glyphicon glyphicon-shopping-cart"></span> Tambah Keranjang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>