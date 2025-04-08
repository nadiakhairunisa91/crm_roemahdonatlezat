<?php
$row = $db->get_row("SELECT * FROM tb_produk WHERE id_produk='$_GET[ID]'");
update_bintang($_GET['ID']);
?>
<div class="panel panel-default">
<div class="panel-heading">
    <strong><?= $row->nama_produk ?></strong>
</div>
<div class="panel-body">
<div class="row">
    <div class="col-md-5">
        <div class="thumbnail">
            <a href="<?= produk_image($row->gambar) ?>">
                <img src="<?= produk_image($row->gambar) ?>" alt="<?= $row->nama_produk ?>" />
            </a>
            <div class="caption">
            <p>
    <?= ($row->stock > 0) ? '<span class="label label-success">' . $row->stock . ' Tersedia</span>' : '<span class="label label-danger">Stok habis</span>' ?>
    <span class="pull-right text-success">
        <?php if ($row->diskon > 0): ?>
            <strong><strike>Rp.<?= number_format($row->harga) ?></strike></strong>
            <small>(Disc.<b><?= $row->diskon ?>%</b>)</small>
        <?php endif; ?>
        <strong>Rp.<?= number_format($row->harga - ($row->diskon / 100 * $row->harga)) ?></strong>
    </span>
</p>
            <a class="btn btn-sm <?= ($row->stock > 0) ? 'btn-primary' : 'disabled btn-default' ?>" href="aksi.php?m=keranjang_tambah&ID=<?= $row->id_produk ?>"><span class="glyphicon glyphicon-shopping-cart"></span> Tambah Keranjang</a>
        </div>
    </div>
    <strong>Galeri</strong>
    <div class="row">
        <?php
        $rows = $db->get_results("SELECT * FROM tb_galeri WHERE id_produk='$_GET[ID]'");
        foreach ($rows as $r) : ?>
        <div class="col-lg-3 col-md-4 col-xs-6 thumb">
            <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="<?= $r->nama_galeri ?>" data-caption="<?= strip_tags($r->ket_galeri) ?>" data-image="assets/images/galeri/<?= $r->gambar ?>" data-target="#image-gallery">
                <img src="assets/images/galeri/small_<?= $r->gambar ?>" title="<?= $r->nama_galeri ?>" />
            </a>
        </div>
    <?php endforeach ?>
</div>
</div>
<div class="col-md-7">
    <strong>Detail produk</strong>
    <?= $row->keterangan ?>
</div>
</div>
<hr />
<div class="row">
    <div class="col-md-6">
        <strong id="komentar">Review Pembeli</strong>
        <?php
        $rows = $db->get_results("SELECT * FROM tb_komentar k INNER JOIN tb_detail d ON d.id_detail=k.id_detail INNER JOIN tb_order p ON p.id_order=d.id_order INNER JOIN tb_pelanggan k2 ON k2.id_pelanggan=p.id_pelanggan WHERE d.id_produk='$_GET[ID]'");
        foreach ($rows as $row) : ?>
        <div class="media">
            <div class="media-left">
                <a href="#">
                    <img class="media-object" src="assets/images/no_image.png" alt="Pembeli" height="50">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading"><?= $row->nama_pelanggan ?></h4>
                <p><?= show_rating($row->bintang) ?></p>
                <p><?= $row->isi_komentar ?></p>
                <?php if ($row->balasan) : ?>
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="assets/images/admin.png" alt="Pembeli" height="50">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">Admin</h4>
                            <p><?= $row->balasan ?></p>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    <?php endforeach ?>
</div>
</div>
<div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="image-gallery-title"></h4>
            </div>
            <div class="modal-body">
                <img id="image-gallery-image" class="img-responsive" src="">
            </div>
            <div class="modal-footer">

                <div class="col-md-2">
                    <button type="button" class="btn btn-primary" id="show-previous-image">Previous</button>
                </div>

                <div class="col-md-8 text-justify" id="image-gallery-caption">
                    This text will be overwritten by jQuery
                </div>

                <div class="col-md-2">
                    <button type="button" id="show-next-image" class="btn btn-default">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        loadGallery(true, 'a.thumbnail');

        //This function disables buttons when needed
        function disableButtons(counter_max, counter_current) {
            $('#show-previous-image, #show-next-image').show();
            if (counter_max == counter_current) {
                $('#show-next-image').hide();
            } else if (counter_current == 1) {
                $('#show-previous-image').hide();
            }
        }

        /**
         *
         * @param setIDs        Sets IDs when DOM is loaded. If using a PHP counter, set to false.
         * @param setClickAttr  Sets the attribute for the click handler.
         */

         function loadGallery(setIDs, setClickAttr) {
            var current_image,
            selector,
            counter = 0;

            $('#show-next-image, #show-previous-image').click(function() {
                if ($(this).attr('id') == 'show-previous-image') {
                    current_image--;
                } else {
                    current_image++;
                }

                selector = $('[data-image-id="' + current_image + '"]');
                updateGallery(selector);
            });

            function updateGallery(selector) {
                var $sel = selector;
                current_image = $sel.data('image-id');
                $('#image-gallery-caption').text($sel.data('caption'));
                $('#image-gallery-title').text($sel.data('title'));
                $('#image-gallery-image').attr('src', $sel.data('image'));
                disableButtons(counter, $sel.data('image-id'));
            }

            if (setIDs == true) {
                $('[data-image-id]').each(function() {
                    counter++;
                    $(this).attr('data-image-id', counter);
                });
            }
            $(setClickAttr).on('click', function() {
                updateGallery($(this));
            });
        }
    });
</script>