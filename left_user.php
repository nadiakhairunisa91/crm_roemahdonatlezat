<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title"><?= (isset($_SESSION['pub_id'])) ? $_SESSION['pub_nama'] : 'Member Area' ?></h4>
    </div>
    <?php if (isset($_SESSION['pub_id'])) : ?>
        <div class="list-group">
            <li class="list-group-item"><a href='?m=order'><span class="glyphicon glyphicon-shopping-cart"></span> Order Saya</a></li>
            <li class="list-group-item"><a href='?m=komentar'><span class="glyphicon glyphicon-comment"></span> Review</a></li>
            <li class="list-group-item"><a href='?m=poin'><span class="glyphicon glyphicon-signal"></span> Poin</a></li>
            <li class="list-group-item"><a href='?m=member'><span class="glyphicon glyphicon-user"></span> Akun</a></li>
            <li class="list-group-item"><a href="aksi.php?act=logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        </div>
    <?php else : ?>
        <div class="list-group">
            <li class="list-group-item"><a href='?m=login'><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <li class="list-group-item"><a href='?m=daftar'><span class="glyphicon glyphicon-registration-mark"></span> Daftar</a></li>
        </div>
    <?php endif ?>
</div>