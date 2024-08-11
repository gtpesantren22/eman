<?php
require 'function.php';

?>

<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Cek Data Pulang Santri</h4>
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
                            $santri =  query("SELECT a.id, a.nis, a.tgl_pulang, a.wajib_kembali, a.tgl_kembali, a.ket, b.nama, b.k_formal, b.t_formal, b.k_madin, b.r_madin FROM pulang AS a INNER JOIN tb_santri AS b ON a.nis=b.nis WHERE a.tgl_pulang BETWEEN '$dari' AND '$sampai' ORDER by ket ASC");
                            $data2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pulang WHERE tgl_pulang BETWEEN '$dari' AND '$sampai' "));
                        } elseif ($level == 'putra') {
                            $santri =  query("SELECT a.id, a.nis, a.tgl_pulang, a.wajib_kembali, a.tgl_kembali, a.ket, b.nama, b.k_formal, b.t_formal, b.k_madin, b.r_madin FROM pulang AS a INNER JOIN tb_santri AS b ON a.nis=b.nis WHERE jkl = 'Laki-laki' AND a.tgl_pulang BETWEEN '$dari' AND '$sampai' ORDER by ket ASC");
                            $data2 = mysqli_num_rows(mysqli_query($conn, "SELECT a.nis, b.jkl FROM pulang AS a INNER JOIN tb_santri AS b ON a.nis=b.nis WHERE tgl_pulang BETWEEN '$dari' AND '$sampai' AND b.jkl = 'Laki-laki'"));
                        } else {
                            $santri =  query("SELECT a.id, a.nis, a.tgl_pulang, a.wajib_kembali, a.tgl_kembali, a.ket, b.nama, b.k_formal, b.t_formal, b.k_madin, b.r_madin FROM pulang AS a INNER JOIN tb_santri AS b ON a.nis=b.nis WHERE jkl = 'Perempuan' AND a.tgl_pulang BETWEEN '$dari' AND '$sampai' ORDER by ket ASC");
                            $data2 = mysqli_num_rows(mysqli_query($conn, "SELECT a.nis, b.jkl FROM pulang AS a INNER JOIN tb_santri AS b ON a.nis=b.nis WHERE tgl_pulang BETWEEN '$dari' AND '$sampai' AND b.jkl = 'Perempuan' "));
                        }

                    ?>
                    Jumlah Data : <span class="badge badge-secondary"><?= $data2; ?>
                        data</span><br>
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
                                    <th>Kelas</th>
                                    <th>Tgl Pulang</th>
                                    <th>Ket</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($santri as $r) : ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $r["nama"]; ?> </td>
                                    <td><label class="badge badge-primary"><?= $r["k_formal"]; ?>
                                            <?= $r["t_formal"]; ?></label> / <label
                                            class="badge badge-warning"><?= $r["k_madin"]; ?>
                                            <?= $r["r_madin"]; ?></label> </td>
                                    <td><?= date("d-m-Y", strtotime($r["tgl_pulang"])); ?> </td>
                                    <td><?php
                                                $ket = $r["ket"];
                                                $now = explode("/", date("d/m/Y"));
                                                //$now1 = $now[0] + $now[1] + $now[2];
                                                $now1 = date("Y-m-d");

                                                $p = explode("/", $r["tgl_pulang"]);
                                                $p1 = $p[0] + $p[1] + $p[2];

                                                $w = explode("/", $r["wajib_kembali"]);
                                                //$w1 = $w[0] + $w[1] + $w[2];
                                                $w1 = date('Y-m-d', strtotime($r["wajib_kembali"]));

                                                $k = $r["tgl_kembali"];

                                                if ($r["wajib_kembali"] == 'Tak dibatasi' && $k == '-') {
                                                    echo "<span class='fa fa-home' style='color: orange;'> dirumah</span>";
                                                } elseif (strtotime($now1) < strtotime($w1) && $k == '-') {
                                                    echo "<span class='fa fa-home' style='color: orange;'> dirumah</span>";
                                                } elseif (strtotime($now1) >= strtotime($w1) && $k == '-') {
                                                    $awal = date('Y-m-d', strtotime($r["wajib_kembali"]));
                                                    $akhir = date('Y-m-d');
                                                    $diff  = date_diff(date_create($akhir), date_create($awal));
                                                    $beda = $diff->format('%a');
                                                    echo "<span class='fas fa-bullhorn' style='color: red;'> harus kembali (" . $beda . " hari)</span>";
                                                } elseif ($ket == 1 && $k != '-') {
                                                    echo "<span class='fas fa-window-close' style='color: red;'> telat</span>";
                                                } elseif ($ket == 2 && $k != '-') {
                                                    echo "<span class='fa fa-check' style='color: green;'> pondok</span>";
                                                }

                                                ?> </td>
                                    <td><a
                                            href="<?= 'index.php?link=pages/pulang/detail&nis=' . $r['nis'] . '&id=' . $r['id']; ?>"><button
                                                class="btn btn-success btn-sm"><span class="fa fa-search"></span>
                                                Detail</button></a>
                                        <?php if ($level == 'admin') { ?>
                                        <a href="<?= 'index.php?link=pages/pulang/del&id=' . $r['id']; ?>"
                                            onclick="return confirm('Yakin Akan dihapus ?')"><button
                                                class="btn btn-danger btn-sm"><span class="fa fa-trash"></span>
                                                Hapus</button></a>
                                        <?php } ?>
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