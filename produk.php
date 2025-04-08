<?php


$where = " AND b.nama_produk LIKE '%$_GET[q]%'";
if ($_GET['min'] != '')
    $where .= " AND b.harga >='$_GET[min]'";
if ($_GET['mak'] != '')
    $where .= " AND b.harga <='$_GET[mak]'";
if ($_GET['id_kategori']) {
    $kategori = $db->get_row("SELECT * FROM tb_kategori WHERE id_kategori='$_GET[id_kategori]'");
    $judul .= " " . $kategori->nama_kategori;
    $where .= " AND b.id_kategori ='$_GET[id_kategori]'";
}
if ($_GET['q'])
    $judul .= ' "<small>' . $_GET['q'] . '</small>"';
?>

<div class="row">
    <div class="panel">
        <div class="panel-body">
            <form action="?" class="form-inline">
                <input type="hidden" name="m" value="produk" />
                <div class="form-group">
                    <select class="form-control input-sm" name="id_kategori">
                        <option value="">Semua Kategori</option>
                        <?= get_kategori_option(set_value('id_kategori')) ?>
                    </select>
                </div>
                <div class="form-group">
                    <input class="form-control input-sm search-input" type="text" name="q" value="<?= $_GET['q'] ?>" autocomplete="off" placeholder="Cari di sini" />
                </div>
                <div class="form-group">
                    <input class="form-control input-sm" type="text" name="min" value="<?= $_GET['min'] ?>" placeholder="Min harga" size="6" />
                </div>
                <div class="form-group">
                    <input class="form-control input-sm" type="text" name="mak" value="<?= $_GET['mak'] ?>" placeholder="Mak harga" size="6" />
                </div>
                <div class="form-group">
                    <select class="form-control input-sm" name="sort">
                        <?= get_order_option($_GET['sort']) ?>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                </div>
            </form>
        </div>
    </div>
    <?php
    $pg     = new Paging;
    $batas  = 6;
    $posisi = $pg->get_offset($batas, $_GET['page']);

    $order = strtolower($_GET['sort']);
    if (in_array($order, array('total desc', 'harga', 'harga desc')))
        $order = "ORDER BY " . $order;
    else
        $order = 'ORDER BY id_produk DESC';

    $sql = "SELECT b.*, k.nama_kategori, (SELECT COUNT(*) FROM tb_detail d WHERE d.id_produk=b.id_produk) AS total FROM tb_produk b LEFT JOIN tb_kategori k ON k.id_kategori=b.id_kategori WHERE 1 $where";


    $jumrec = count($db->get_results($sql));
    $sql .= " $order LIMIT $posisi, $batas";

    $rows = $db->get_results($sql);

    $paging = $pg->get_link("m=produk&min=$_GET[min]&mak=$_GET[mak]&q=$_GET[q]&sort=$_GET[sort]&page=", $jumrec, $batas, $_GET['page']);
    if ($rows) :
        $no = 0;
    foreach ($rows as $row) : ?>
    <div class="col-sm-4">
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
            <?php if ($row->diskon > 0): ?>
                <span class="pull-right text-success"> <strong><strike>Rp.<?=number_format($row->harga)?> </strike></strong> <small> (Disc.<b><?=$row->diskon?>%)</b></small></span>
                <span class="pull-right text-success"><strong>Rp.<?=number_format($row->harga - ($row->diskon/100 * $row->harga))?></strong></span>
            <?php else: ?>
                <span class="pull-right text-success"><strong>Rp.<?=number_format($row->harga)?></strong></span>
            <?php endif; ?>
        </p>
        <a class="btn btn-sm  <?= ($row->stock > 0) ? 'btn-primary btn-sm' : 'disabled btn-default btn-sm' ?>" href="aksi.php?m=keranjang_tambah&ID=<?= $row->id_produk ?>"><span class="glyphicon glyphicon-shopping-cart"></span> Tambah Keranjang</a>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $no++;
    if ($no % 3 == 0) {
        echo '</div><div class="row">';
    }
    endforeach;
    else :
        echo "<p>Data produk tidak ditemukan</p>";
    endif;
    ?>
</div>
<ul class="pagination"><?= $paging ?></ul>