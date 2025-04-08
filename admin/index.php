<?php
include('../functions.php');
if (empty($_SESSION['adm_username']))
    header('location:login.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="../assets/images/rumah.png" />
    <title>Admin &raquo; <?= get_options('web_name') ?></title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/general.css" rel="stylesheet" />
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: "textarea.mce",
            plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        });
    </script>
    <!-- <datatables> -->
    <link rel="stylesheet" href="../assets/datatables/css/dataTables.bootstrap.min.css"> 
    <link rel="stylesheet" href="../assets/datatables/css/responsive.bootstrap.min.css">
    <!-- <end datatables> -->
</head>
<style>
      body {
            background-color: #ffffff; /* Latar belakang putih */
            color: #333; /* Warna teks gelap */
        }

        .navbar {
            background-color: #0056b3; /* Warna navbar biru tua */
        }

        .navbar a {
            color: #ffffff; /* Warna teks di navbar */
        }

        .navbar a:hover {
            color: #ffc107; /* Warna teks saat hover di navbar */
        }

        .footer {
            background-color: #343a40; /* Warna footer abu-abu gelap */
            color: white; /* Warna teks di footer */
        }

       
</style>
<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                 <div class="hidden-xs">
                    <a class="navbar-brand <?=($mod=='home') ? 'active' : ''?>" href="?"><span><img src="../assets/images/rumah.png" width="40px;" style="margin-top:-8px;"> <?= get_options('web_name') ?> </span></a>
                </div>
                <div class="hidden-lg hidden-md hidden-sm">
                    <a class="navbar-brand <?=($mod=='home') ? 'active' : ''?>" href="?"><span><img src="../assets/images/rumah.png" width="40px;" style="margin-top:-8px;"> <?= get_options('web_name') ?></span></a>
                </div>
            </div>
            <div id="navbar" class="navbar-collapse collapse">

                <?php if ($_SESSION['level']=='Administrator'): ?>
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-th"></span> Master <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="?m=kategori"><span class="glyphicon glyphicon-th-large"></span> Kategori</a></li>
                                <li><a href="?m=produk"><span class="glyphicon glyphicon-th"></span> produk</a></li>
                                <li class="<?= ($mod == 'pelanggan') ? 'active' : '' ?>"><a href="?m=pelanggan"><span class="glyphicon glyphicon-credit-card"></span> Pelanggan</a></li>
                                <li class="<?= ($mod == 'promo') ? 'active' : '' ?>"><a href="?m=promo"><span class="glyphicon glyphicon-th-list"></span> promo</a></li>
                            </ul>
                        </li>

                        <?php
                        // Menghitung jumlah pesan yang belum dibalas
                        $total_unanswered = $db->get_var("SELECT COUNT(*) FROM tb_chat WHERE balasan_admin IS NULL");
                        $total_unanswered = ($total_unanswered) ? '<span class="badge">' . $total_unanswered . '</span>' : '';
                        $total_order = $db->get_var("SELECT COUNT(*) FROM tb_order WHERE STATUS='New'");
                        $total_order = ($total_order) ? '<span class="badge">' . $total_order . '</span>' : '';
                        $total_bayar = $db->get_var("SELECT COUNT(*) FROM tb_order WHERE STATUS='Pending'");
                        $total_bayar = ($total_bayar) ? '<span class="badge">' . $total_bayar . '</span>' : '';
                        ?>
                        <li><a href="?m=chat_admin"><span class="glyphicon glyphicon-lg glyphicon-comment"></span> Chat <?= $total_unanswered ?></a></li>
                      <li><a href="?m=order"><span class="glyphicon glyphicon-shopping-cart"></span> Order <?= $total_order ?></a></li>
                        <li><a href="?m=bayar"><span class="glyphicon glyphicon-shopping-cart"></span> Pembayaran <?= $total_bayar ?></a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-th"></span> Utilitas <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li class="<?= ($mod == 'caraorder') ? 'active' : '' ?>"><a href="?m=caraorder"><span class="glyphicon glyphicon-question-sign"></span> Cara Pesan</a></li>
                                <li class="<?= ($mod == 'kontak') ? 'active' : '' ?>"><a href="?m=kontak"><span class="glyphicon glyphicon-phone"></span> Kontak</a></li>
                                <li><a href="?m=komentar"><span class="glyphicon glyphicon-comment"></span> Komentar </a></li>
                            </ul>
                        </li>
                        <li><a href="?m=admin"><span class="glyphicon glyphicon-user"></span> Admin</a></li>
                        <li><a href="?m=kota"><span class="glyphicon glyphicon-usd"></span> Ongkos Kirim</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-signal"></span> Laporan <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="?m=lap_produk">Laporan Penjualan produk</a></li>
                                <li class="divider"></li>
                                <li><a href="?m=lap_hari">Laporan Penjualan Harian</a></li>
                                <li><a href="?m=lap_minggu">Laporan Penjualan Mingguan</a></li>
                                <li><a href="?m=lap_bulan">Laporan Penjualan Bulanan</a></li>
                                <li><a href="?m=lap_tahun">Laporan Penjualan Tahunan</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?= $_SESSION['adm_nama'] ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="../" target="_blank"><span class="glyphicon glyphicon-search"></span> Lihat Web</a></li>
                                <li><a href="?m=admin_ubah_password"><span class="glyphicon glyphicon-edit"></span> Ubah Password</a></li>
                                <li><a href="aksi.php?act=logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php endif ?>

                <?php if ($_SESSION['level']=='Pemilik'): ?>
                  <ul class="nav navbar-nav">
                    <li><a href="?m=minuman"><span class="glyphicon glyphicon-th"></span> Minuman</a></li>
                    <li class="<?= ($mod == 'pelanggan') ? 'active' : '' ?>"><a href="?m=pelanggan"><span class="glyphicon glyphicon-credit-card"></span> Pelanggan</a></li>

                    <li><a href="?m=order"><span class="glyphicon glyphicon-shopping-cart"></span> Order <?= $total_order ?></a></li>
                    <li><a href="?m=komentar"><span class="glyphicon glyphicon-comment"></span> Komentar </a></li>
                    <?php
                    $total_order = $db->get_var("SELECT COUNT(*) FROM tb_order WHERE STATUS='New'");
                    $total_order = ($total_order) ? '<span class="badge">' . $total_order . '</span>' : '';
                    $total_bayar = $db->get_var("SELECT COUNT(*) FROM tb_order WHERE STATUS='Pending'");
                    $total_bayar = ($total_bayar) ? '<span class="badge">' . $total_bayar . '</span>' : '';
                    ?>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-signal"></span> Laporan <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="?m=lap_minuman">Laporan Penjualan Minuman</a></li>
                            <li><a href="?m=lap_minuman_detail">Laporan Penjualan Minuman Detail</a></li>
                            <li class="divider"></li>
                            <li><a href="?m=lap_hari">Laporan Penjualan Harian</a></li>
                            <li><a href="?m=lap_minggu">Laporan Penjualan Mingguan</a></li>
                            <li><a href="?m=lap_bulan">Laporan Penjualan Bulanan</a></li>
                            <li><a href="?m=lap_tahun">Laporan Penjualan Tahunan</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?= $_SESSION['adm_nama'] ?> <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="../" target="_blank"><span class="glyphicon glyphicon-search"></span> Lihat Web</a></li>
                            <li><a href="?m=admin_ubah_password"><span class="glyphicon glyphicon-edit"></span> Ubah Password</a></li>
                            <li><a href="aksi.php?act=logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            <?php endif ?>

        </div>
    </div>
</nav>
<div class="container-fluid">
    <?php
    if (file_exists($mod . '.php'))
        include $mod . '.php';
    else
        include 'home.php';
    ?>
</div>
<footer class="footer bg-primary">
    <div class="container text-center">
        <p>
            Copyright &copy; 2025 <?= get_options('web_name') ?>
        </p>
    </div>
</footer>



<!-- <SCRIPT DATATABLES> -->
<script type="text/javascript" src="../assets/datatables/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../assets/datatables/js/dataTables.bootstrap.min.js"></script> 
<script type="text/javascript" src="../assets/datatables/js/dataTables.responsive.min.js"></script> 

<script type="text/javascript">
  $(document).ready(function() {
    $('#datatables').DataTable({
      responsive: true
  });
} );
</script>  
<!-- END SCRIPT DATATABLES -->

</body>

</html>