<?php
require 'function.php';
$nama = $_SESSION['nama'];
$level = $_SESSION['level'];

$jml = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_santri"));
$p_pa = mysqli_num_rows(mysqli_query($conn, "SELECT a.ket, b.jkl FROM pulang AS a INNER JOIN tb_santri AS b ON a.nis=b.nis WHERE a.ket = 0 AND b.jkl =  'Laki-laki' "));
$p_pi = mysqli_num_rows(mysqli_query($conn, "SELECT a.ket, b.jkl FROM pulang AS a INNER JOIN tb_santri AS b ON a.nis=b.nis WHERE a.ket = 0 AND b.jkl =  'Perempuan' "));
$lang = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pelanggaran"));

$bulanArr = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
$thnArr = mysqli_query($conn, "SELECT YEAR(STR_TO_DATE(tgl_pulang, '%m/%d/%Y')) AS tahunJai FROM pulang GROUP BY tahunJai ORDER BY tahunJai DESC");

?>
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Dashboard</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<div class="container-fluid">
    <div class="row">
        <!-- Column -->
        <div class="col-md-12">
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Selamat Datang, <?= $nama; ?></h4>
                <p>di Aplikasi Keamanan PonPes Darul Lughah Wal Karomah v1.0</p>
                <hr>
                <p class="mb-0">Anda Login sebagai </p><b>Pengurus <?= $level; ?></b>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-cyan text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-account-multiple"></i></h1>
                    <h6 class="text-white">Jumlah Santri : <?= $jml; ?> santri</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-success text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-car"></i></h1>
                    <h6 class="text-white">Santri Pulang : <?= $p_pa; ?> (putra)</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-warning text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-car"></i></h1>
                    <h6 class="text-white">Santri Pulang : <?= $p_pi; ?> (putri)</h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-hover">
                <div class="box bg-danger text-center">
                    <h1 class="font-light text-white"><i class="mdi mdi-border-outside"></i></h1>
                    <h6 class="text-white">Data Pelanggaran : <?= $lang; ?></h6>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- $lembaga = -->
        <div class="col-md-12">
            <div class="alert alert-light" role="alert">
                <form action="" method="post" id="ganti-tahun">

                    <div class="form-group row">
                        <div class="col-md-5">
                            <select name="" id="bulan" class="form-control">
                                <option value="">-pilih bulan-</option>
                                <?php for ($i = 0; $i <= 11; $i++): ?>
                                    <option value="<?= $i; ?>"><?= $bulanArr[$i]; ?></option>
                                <?php endfor ?>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <select name="" id="tahun" class="form-control">
                                <option value="">-pilih tahun-</option>
                                <?php while ($th = mysqli_fetch_object($thnArr)): ?>
                                    <option value="<?= $th->tahunJai; ?>"><?= $th->tahunJai; ?></option>
                                <?php endwhile ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary" name="cek" type="submit"><span class="fa fa-search"></span> Cek</button>
                        </div>
                    </div>
                </form>
                <div id="show-rekap"></div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
</div>

<!-- <div class="col-md-12">
    <div class="alert alert-light" role="alert">
        <div class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User Email</th>
                        <th>User IP </th>
                        <th>Login Time</th>
                        <th>Logout Time </th>
                        <th>Status </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php
                    $ww = mysqli_query($conn, "select * from userlog");
                    while ($row = mysqli_fetch_assoc($ww)) { ?>
                        <tr>
                            <td><?= $i; ?></td>
                            <td><?= htmlentities($row['username']); ?></td>
                            <td><?= htmlentities($row['userip']); ?></td>
                            <td> <?= htmlentities($row['loginTime']); ?></td>
                            <td><?= htmlentities($row['logout']); ?></td>
                            <td><?= $row['status']; ?></td>
                        </tr>
                        <?php $i++; ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div> -->
<script src="assets/libs/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            type: "POST",
            url: "pages/showRekap.php",
            dataType: 'html',
            data: {
                "bulan": "",
                "tahun": "",
            },
            success: function(data) {
                $('#show-rekap').html(data);
            },
            error: function(xhr, status, error) {
                alert(xhr.responseText);
            }
        })

        $('#ganti-tahun').on('submit', function(e) {
            e.preventDefault()

            var bulan = $('#bulan').val();
            var tahun = $('#tahun').val();
            $.ajax({
                type: "POST",
                url: "pages/showRekap.php",
                dataType: 'html',
                data: {
                    "bulan": bulan,
                    "tahun": tahun,
                },
                success: function(data) {
                    $('#show-rekap').html(data);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            })
        })
    })
</script>