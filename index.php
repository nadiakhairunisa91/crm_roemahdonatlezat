<?php
include "functions.php";
$id_pelanggan = $_SESSION['id_pelanggan'];
$total_keranjang = $db->get_var("SELECT COUNT(*) FROM tb_temp WHERE session_id='$sid'");
$unreadCount = $db->get_var("SELECT COUNT(*) FROM tb_chat WHERE is_viewed = 0 AND id_pelanggan = '$id_pelanggan'");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="assets/images/rumah.png" />

    <title><?= get_options('web_name') ?></title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/general.css" rel="stylesheet" />
    <link href="assets/css/public.css" rel="stylesheet" />

    <!-- <datatables> -->
    <link rel="stylesheet" href="assets/datatables/css/dataTables.bootstrap.min.css"> 
    <link rel="stylesheet" href="assets/datatables/css/responsive.bootstrap.min.css">
    <!-- <end datatables> -->

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap3-typeahead.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.listing').hover(function() {
                $(this).addClass('bg-info');
            },
            function() {
                $(this).removeClass('bg-info');
            });
        });
    </script>
    <style>
        body {
            background-color: #ffffff; /* Latar belakang putih */
            color: #333; /* Warna teks gelap */
        }
        .notification {
      background-color: red;
      color: white;
      border-radius: 50%;
      padding: 3px 8px;
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

        .chat-bubble {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff; /* Warna biru untuk chat */
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 30px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .chat-modal {
            display: none; /* Sembunyikan modal secara default */
            position: fixed;
            bottom: 80px; /* Jarak dari bawah */
            right: 20px; /* Jarak dari kanan */
            width: 300px; /* Lebar modal */
            height: 400px; /* Tinggi modal */
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            display: flex;
        }

        .pagination {
            margin: 0;
        }
    </style>
</head>

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
                    <a class="navbar-brand <?=($mod=='home') ? 'active' : ''?>" href="?"><span><img src="assets/images/rumah.png" width="40px;" style="margin-top:-8px;"> <?= get_options('web_name') ?> </span></a>
                </div>
                <div class="hidden-lg hidden-md hidden-sm">
                    <a class="navbar-brand <?=($mod=='home') ? 'active' : ''?>" href="?"><span><img src="assets/images/rumah.png" width="40px;" style="margin-top:-8px;"> <?= get_options('web_name') ?></span></a>
                </div>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-th"></span> Kategori <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <?php foreach ($db->get_results("SELECT * FROM tb_kategori") as $row) : ?>
                                <li><a href="?m=produk&id_kategori=<?= $row->id_kategori ?>"><span class="glyphicon glyphicon-chevron-right"></span> <?= $row->nama_kategori ?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                    <li>
      <a href="?m=chat_pelanggan">
        <span class="glyphicon glyphicon-lg glyphicon-comment"></span> Chat 
      </a>
    </li>                    <li><a href="?m=produk"><span class="glyphicon glyphicon-lg glyphicon-inbox"></span> Produk</a></li>
                    <li><a href="?m=kontak"><span class="glyphicon glyphicon-lg glyphicon-phone"></span> Kontak Kami</a></li>
                    <li><a href="?m=caraorder"><span class="glyphicon glyphicon-lg glyphicon-question-sign"></span> Bantuan</a></li>
                </ul>
                <form class="navbar-form navbar-right" role="form">
                    <input type="hidden" value="produk" name="m" />
                    <div class="form-group">
                        <input type="text" class="form-control search-input" name="q" placeholder="Pencarian..." value="<?= $_GET['q'] ?>" />
                    </div>
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="?m=keranjang"><span class="glyphicon glyphicon-shopping-cart"></span> Keranjang <span class="badge"><?= $total_keranjang ?></span></a></li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </nav>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <?php include 'left.php' ?>
                </div>
                <div class="col-md-9">
                    <?php
                    if (file_exists($mod . '.php'))
                        include $mod . '.php';
                    else
                        include 'home.php';
                    ?>
                </div>
            </div>
        </div>
      
        <footer class="footer bg-primary">
            <div class="container text-center">
                <p>
                    Copyright &copy; 2025
                </p>
            </div>
        </footer>

        <!-- <SCRIPT DATATABLES> -->
        <script type="text/javascript" src="assets/datatables/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="assets/datatables/js/dataTables.bootstrap.min.js"></script> 
        <script type="text/javascript" src="assets/datatables/js/dataTables.responsive.min.js"></script> 

        <script type="text/javascript">
          $(document).ready(function() {
            $('#datatables').DataTable({
              responsive: true
          });
        });
    </script>  
    <!-- END SCRIPT DATATABLES -->
</body>

</html>