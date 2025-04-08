
<div class="panel panel-default">
    <div class="panel-heading">
     <span>
         <strong>Data produk</strong>
         <a class="btn btn-primary btn-xs" href="?m=produk_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah</a>

         <a class="btn btn-default btn-xs" href="cetak.php?m=produk&q=<?= $_GET['q'] ?>&kategori=<?= $_GET['id_kategori'] ?>" target="_blank"><span class="glyphicon glyphicon-print"></span> Cetak</a>
     </span>  
 </div>
 <div class="panel-body">
    <table id="datatables" class="table table-bordered table-hover table-striped table-condensed" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stock</th>
                <th>Diskon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        
        <?php
        $pg = new Paging;
        $batas = 100;
        $posisi = $pg->get_offset($batas, $_GET['page']);
        $q = esc_field($_GET['q']);

        $from = " FROM tb_produk b LEFT JOIN tb_kategori k ON k.id_kategori=b.id_kategori";

        $where = " AND nama_produk LIKE '%$q%'";
        $rows = $db->get_results("SELECT b.*, k.nama_kategori $from 
        	WHERE 1 $where ORDER BY id_produk LIMIT $posisi, $batas");

        $jumrec = $db->get_var("SELECT COUNT(*) $from  WHERE 1 $where");

        $no = $posisi;
        foreach ($rows as $row) : ?>
        <tr>
            <td><?php echo ++$no ?></td>
            <td><img class="thumbnail" src="<?= produk_image($row->gambar, true, true) ?>" height="100" /></td>
            <td><?php echo $row->nama_produk ?></td>
            <td><?php echo $row->nama_kategori ?></td>
            <td><?php echo number_format($row->harga) ?></td>
            <td><?= $row->stock ?></td>
            <td><?= $row->diskon ?>%</td>
            <td style="white-space: nowrap;">
                <a class="btn btn-xs btn-info" href="?m=galeri&id_produk=<?= $row->id_produk ?>"><span class="glyphicon glyphicon-camera"></span> Gallery</a>
                <a class="btn btn-xs btn-warning" href="?m=produk_ubah&ID=<?php echo $row->id_produk ?>"><span class="glyphicon glyphicon-edit"></span> Ubah</a>
                <a class="btn btn-xs btn-danger" href="aksi.php?m=produk_hapus&ID=<?php echo $row->id_produk ?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span> Hapus</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</div>
</div>
