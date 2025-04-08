<p>Selamat datang <strong><?= $_SESSION['adm_nama'] ?></strong>.</p>

<div class="row">
    <div class="col-md-3">
        <div class="panel panel-primary">
            <div class="panel-heading">Data produk</div>
            <div class="panel-body">
                <div style="font-size: 30px;"><span class="glyphicon glyphicon-th"></span> <?= $db->get_var("SELECT COUNT(*) FROM tb_produk") ?></div>
            </div>
            <div class="panel-footer">
                <a href="?m=produk">Selengkapnya &raquo;</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-success">
            <div class="panel-heading">Data Pelanggan</div>
            <div class="panel-body">
                <div style="font-size: 30px;"><span class="glyphicon glyphicon-th-list"></span> <?= $db->get_var("SELECT COUNT(*) FROM tb_pelanggan") ?></div>
            </div>
            <div class="panel-footer">
                <a href="?m=pelanggan">Selengkapnya &raquo;</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-warning">
            <div class="panel-heading">Jumlah Order</div>
            <div class="panel-body">
                <div style="font-size: 30px;"><span class="glyphicon glyphicon-th-large"></span> <?= $db->get_var("SELECT COUNT(DISTINCT id_order) FROM tb_order") ?></div>
            </div>
            <div class="panel-footer">
                <a href="?m=order">Selengkapnya &raquo;</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="panel panel-info">
            <div class="panel-heading">Order Baru</div>
            <div class="panel-body">
                <div style="font-size: 30px;"><span class="glyphicon glyphicon-star"></span> <?= $db->get_var("SELECT COUNT(DISTINCT id_order) FROM tb_order WHERE status='New'") ?></div>
            </div>
            <div class="panel-footer">
                <a href="?m=order&status=New">Selengkapnya &raquo;</a>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-info">
    <div class="panel-heading">
        Grafik Penjualan Per Bulan
    </div>
    <div class="panel-body">
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>

        <figure class="highcharts-figure">
            <div id="container"></div>
        </figure>
        <?php
        $rows = $db->get_results("SELECT MONTH(tanggal) AS bulan, YEAR(tanggal) AS tahun, SUM(total) AS total FROM tb_order GROUP BY YEAR(tanggal), MONTH(tanggal) LIMIT 12");
        $categories = array();
        $data = array();
        foreach ($rows as $row) {
            $categories[] = "$row->bulan-$row->tahun";
            $data[] = $row->total * 1;
        }
        ?>
        <script>
            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Grafik Penjualan 12 Bulan Terakhir'
                },
                xAxis: {
                    categories: <?= json_encode($categories) ?>,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Total (Rp)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>Rp {point.y:,.0f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Total',
                    data: <?= json_encode($data) ?>
                }]
            });
        </script>
    </div>
</div>