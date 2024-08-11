<?php
require 'function.php';

?>

<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Cek Data Pelanggaran</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Library</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pilih Data</h5>
                    <form action="" method="post">
                        <div class="form-group row">
                            <label class="col-md-2 m-t-15">Pilih Tanggal</label>
                            <div class="col-md-5">
                                <input type="text" name="dari" class="form-control is-valid" id="datepicker-autoclose"
                                    required autocomplete="off">
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="sampai" class="form-control is-valid"
                                    id="datepicker-autoclose2" required autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 "></label>
                            <div class="col-md-10">
                                <button class="btn btn-primary " name="cek" type="submit"><span
                                        class="fa fa-search"></span> Cek</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <?php if (isset($_POST['cek'])) {
                        $dari = $_POST['dari'];
                        $sampai = $_POST['sampai'];

                        if ($level == 'admin') {
                            $santri =  query("SELECT a.id, a.nis, a.kasus, a.tanggal, a.stts, b.nama, b.k_formal, b.t_formal, b.k_madin, b.r_madin, b.kamar, b.komplek FROM pelanggaran AS a INNER JOIN tb_santri AS b ON a.nis=b.nis WHERE a.tanggal BETWEEN '$dari' AND '$sampai' ");
                            $data2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pelanggaran WHERE tanggal BETWEEN '$dari' AND '$sampai' "));
                        } elseif ($level == 'putra') {
                            $santri =  query("SELECT a.id, a.nis, a.kasus, a.tanggal, a.stts, b.nama, b.k_formal, b.t_formal, b.k_madin, b.r_madin, b.kamar, b.komplek FROM pelanggaran AS a INNER JOIN tb_santri AS b ON a.nis=b.nis WHERE b.jkl = 'Laki-laki' AND a.tanggal BETWEEN '$dari' AND '$sampai'");
                            $data2 = mysqli_num_rows(mysqli_query($conn, "SELECT a.nis, b.jkl FROM pelanggaran AS a INNER JOIN tb_santri AS b ON a.nis=b.nis WHERE a.tanggal BETWEEN '$dari' AND '$sampai' AND b.jkl = 'Laki-laki'"));
                        } else {
                            $santri =  query("SELECT a.id, a.nis, a.kasus, a.tanggal, a.stts, b.nama, b.k_formal, b.t_formal, b.k_madin, b.r_madin, b.kamar, b.komplek FROM pelanggaran AS a INNER JOIN tb_santri AS b ON a.nis=b.nis WHERE b.jkl = 'Perempuan' AND a.tanggal BETWEEN '$dari' AND '$sampai'");
                            $data2 = mysqli_num_rows(mysqli_query($conn, "SELECT a.nis, b.jkl FROM pelanggaran AS a INNER JOIN tb_santri AS b ON a.nis=b.nis WHERE a.tanggal BETWEEN '$dari' AND '$sampai' AND b.jkl = 'Perempuan'"));
                        }

                    ?>
                    Jumlah Data : <span class="badge badge-secondary"><?= $data2; ?>
                        pelanggaran</span><br>
                    Dari tanggal : <span class="badge badge-info"><?= tanggal_indo($dari); ?></span> s/d
                    <span class="badge badge-info"><?= tanggal_indo($sampai); ?></span>
                    <br>
                    <br>
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kasus</th>
                                    <th>Kls/Kamar</th>
                                    <th>Tanggal</th>
                                    <th>Stts</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($santri as $r) : ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $r["nama"]; ?> </td>
                                    <td><?= $r["kasus"]; ?> </td>
                                    <td><label class="badge badge-primary"><?= $r["k_formal"]; ?>
                                            <?= $r["t_formal"]; ?> / <?= $r["k_madin"]; ?>
                                            <?= $r["r_madin"]; ?></label> <label
                                            class="badge badge-warning"><?= $r["kamar"]; ?> /
                                            <?= $r["komplek"]; ?></label> </td>
                                    <td><?= date("d-m-Y", strtotime($r["tanggal"])); ?> </td>
                                    <td><span class="badge badge-pill badge-dark"><?= $ket = $r["stts"]; ?></span></td>
                                    <td><a
                                            href="<?= 'index.php?link=pages/pelanggaran/detail&nis=' . $r['nis'] . '&id=' . $r['id']; ?>"><button
                                                class="btn btn-success btn-sm"><span class="fa fa-search"></span>
                                                Detail</button></a>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>