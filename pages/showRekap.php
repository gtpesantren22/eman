<?php
session_start();
require '../function.php';
$level = $_SESSION['level'];

$bulan = $_POST['bulan'];
$tahun = $_POST['tahun'];

$bulanIni = date('m');
$tahunIni = date('Y');
$bulanArr = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

if ($bulan && $bulan != '') {
    $komplekLk = mysqli_query($conn, "SELECT tb_santri.komplek, COUNT(komplek) AS jml FROM tb_santri JOIN pulang ON tb_santri.nis=pulang.nis WHERE MONTH(STR_TO_DATE(tgl_pulang, '%m/%d/%Y')) = '$bulan' AND YEAR(STR_TO_DATE(tgl_pulang, '%m/%d/%Y')) = '$tahun' AND tb_santri.jkl = 'Laki-laki' GROUP BY komplek ORDER BY komplek ASC");
    $komplekPr = mysqli_query($conn, "SELECT tb_santri.komplek, COUNT(komplek) AS jml FROM tb_santri JOIN pulang ON tb_santri.nis=pulang.nis WHERE MONTH(STR_TO_DATE(tgl_pulang, '%m/%d/%Y')) = '$bulan' AND YEAR(STR_TO_DATE(tgl_pulang, '%m/%d/%Y')) = '$tahun' AND tb_santri.jkl = 'Perempuan' GROUP BY komplek ORDER BY komplek ASC");

    $rankLk = mysqli_query($conn, "SELECT tb_santri.nama, tb_santri.k_formal, tb_santri.t_formal, COUNT(pulang.nis) AS jml FROM tb_santri JOIN pulang ON tb_santri.nis=pulang.nis WHERE MONTH(STR_TO_DATE(tgl_pulang, '%m/%d/%Y')) = '$bulan' AND YEAR(STR_TO_DATE(tgl_pulang, '%m/%d/%Y')) = '$tahun' AND tb_santri.jkl = 'Laki-laki' GROUP BY pulang.nis ORDER BY jml DESC, tb_santri.nama ASC LIMIT 10");
    $rankPr = mysqli_query($conn, "SELECT tb_santri.nama, tb_santri.k_formal, tb_santri.t_formal, COUNT(pulang.nis) AS jml FROM tb_santri JOIN pulang ON tb_santri.nis=pulang.nis WHERE MONTH(STR_TO_DATE(tgl_pulang, '%m/%d/%Y')) = '$bulan' AND YEAR(STR_TO_DATE(tgl_pulang, '%m/%d/%Y')) = '$tahun' AND tb_santri.jkl = 'Perempuan' GROUP BY pulang.nis ORDER BY jml DESC, tb_santri.nama ASC LIMIT 10");

    $rekapInfo = $bulanArr[(int)$bulan] . ' ' . $tahun;
} else {
    $komplekLk = mysqli_query($conn, "SELECT tb_santri.komplek, COUNT(komplek) AS jml FROM tb_santri JOIN pulang ON tb_santri.nis=pulang.nis WHERE MONTH(STR_TO_DATE(tgl_pulang, '%m/%d/%Y')) = '$bulanIni' AND YEAR(STR_TO_DATE(tgl_pulang, '%m/%d/%Y')) = '$tahunIni' AND tb_santri.jkl = 'Laki-laki' GROUP BY komplek ORDER BY komplek ASC");
    $komplekPr = mysqli_query($conn, "SELECT tb_santri.komplek, COUNT(komplek) AS jml FROM tb_santri JOIN pulang ON tb_santri.nis=pulang.nis WHERE MONTH(STR_TO_DATE(tgl_pulang, '%m/%d/%Y')) = '$bulanIni' AND YEAR(STR_TO_DATE(tgl_pulang, '%m/%d/%Y')) = '$tahunIni' AND tb_santri.jkl = 'Perempuan' GROUP BY komplek ORDER BY komplek ASC");

    $rankLk = mysqli_query($conn, "SELECT tb_santri.nama, tb_santri.k_formal, tb_santri.t_formal, COUNT(pulang.nis) AS jml FROM tb_santri JOIN pulang ON tb_santri.nis=pulang.nis WHERE MONTH(STR_TO_DATE(tgl_pulang, '%m/%d/%Y')) = '$bulanIni' AND YEAR(STR_TO_DATE(tgl_pulang, '%m/%d/%Y')) = '$tahunIni' AND tb_santri.jkl = 'Laki-laki' GROUP BY pulang.nis ORDER BY jml DESC, tb_santri.nama ASC LIMIT 10");
    $rankPr = mysqli_query($conn, "SELECT tb_santri.nama, tb_santri.k_formal, tb_santri.t_formal, COUNT(pulang.nis) AS jml FROM tb_santri JOIN pulang ON tb_santri.nis=pulang.nis WHERE MONTH(STR_TO_DATE(tgl_pulang, '%m/%d/%Y')) = '$bulanIni' AND YEAR(STR_TO_DATE(tgl_pulang, '%m/%d/%Y')) = '$tahunIni' AND tb_santri.jkl = 'Perempuan' GROUP BY pulang.nis ORDER BY jml DESC, tb_santri.nama ASC LIMIT 10");

    $rekapInfo = $bulanArr[(int)$bulanIni] . ' ' . $tahunIni;
}

// Siapkan array untuk menampung data dari query
$no = 1;
$categories = [];
$jumlahSantri = [];
$categories2 = [];
$jumlahSantri2 = [];

while ($dtd = mysqli_fetch_assoc($komplekLk)) {
    $categories[] = $dtd['komplek'];      // Nama komplek
    $jumlahSantri[] = $dtd['jml'];        // Jumlah santri di komplek
}
while ($dtd2 = mysqli_fetch_assoc($komplekPr)) {
    $categories2[] = $dtd2['komplek'];      // Nama komplek
    $jumlahSantri2[] = $dtd2['jml'];        // Jumlah santri di komplek
}
?>
<h5>Rekap Santri Pulang Putra (<?= $rekapInfo ?>)</h5>
<div id="chart"></div>
<h5>Rekap Santri Pulang Putri (<?= $rekapInfo ?>)</h5>
<div id="chart2"></div>
<hr>
<div class="row">
    <div class="col-md-6">
        <h5>10 Terbaik Pulang Santri Putra (<?= $rekapInfo ?>)</h5>
        <table class="table table-sm">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama</td>
                    <td>Kelas</td>
                    <td>Jml</td>
                </tr>
            </thead>
            <tbody>
                <?php while ($rlk = mysqli_fetch_assoc($rankLk)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $rlk['nama'] ?></td>
                        <td><?= $rlk['k_formal'] . ' ' . $rlk['t_formal'] ?></td>
                        <td><?= $rlk['jml'] ?></td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <h5>10 Terbaik Pulang Santri Putri (<?= $rekapInfo ?>)</h5>
        <table class="table table-sm">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama</td>
                    <td>Kelas</td>
                    <td>Jml</td>
                </tr>
            </thead>
            <tbody>
                <?php while ($rlk = mysqli_fetch_assoc($rankPr)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $rlk['nama'] ?></td>
                        <td><?= $rlk['k_formal'] . ' ' . $rlk['t_formal'] ?></td>
                        <td><?= $rlk['jml'] ?></td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    var categories = <?= json_encode($categories); ?>; // Kategori nama komplek
    var jumlahSantri = <?= json_encode($jumlahSantri); ?>; // Data jumlah santri

    var options = {
        series: [{
            name: 'Santri Pulang',
            group: 'putra',
            data: jumlahSantri
        }],
        chart: {
            type: 'bar',
            height: 350,
            stacked: true,
        },
        stroke: {
            width: 1,
            colors: ['#fff']
        },
        dataLabels: {
            formatter: (val) => {
                return val
            }
        },
        plotOptions: {
            bar: {
                horizontal: false
            }
        },
        xaxis: {
            categories: categories
        },
        fill: {
            opacity: 1
        },
        colors: ['#008FFB'],
        yaxis: {
            labels: {
                formatter: (val) => {
                    return val
                }
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'left'
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>

<script>
    var categories2 = <?= json_encode($categories2); ?>; // Kategori nama komplek
    var jumlahSantri2 = <?= json_encode($jumlahSantri2); ?>; // Data jumlah santri

    var options2 = {
        series: [{
            name: 'Santri Pulang',
            group: 'putra',
            data: jumlahSantri2
        }],
        chart: {
            type: 'bar',
            height: 350,
            stacked: true,
        },
        stroke: {
            width: 1,
            colors: ['#fff']
        },
        dataLabels: {
            formatter: (val) => {
                return val
            }
        },
        plotOptions: {
            bar: {
                horizontal: false
            }
        },
        xaxis: {
            categories: categories2
        },
        fill: {
            opacity: 1
        },
        colors: ['#52C778'],
        yaxis: {
            labels: {
                formatter: (val) => {
                    return val
                }
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'left'
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart2"), options2);
    chart.render();
</script>