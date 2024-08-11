<?php
require 'function.php';
$nis = $_GET['nis'];
$id = $_GET['id'];
$r = query("SELECT * FROM tb_santri WHERE nis = '$nis' ")[0];
$r2 = query("SELECT * FROM pulang WHERE id = $id ")[0];

$kos = array("-", "Ny. Jamilah", "Gus Zaini", "Ny. Farihah", "Ny. Zahro", "Ny. Sa'adah", "Ny. Mamjudah", "Ny. Naily Z", "Ny. Lathifah");

if (isset($_POST["edit"])) {
    if (edit_pulang($_POST) > 0) {
        echo "
        <script>
            window.location.href = 'index.php?link=pages/pulang/data';
        </script>  
";
    } else {
        echo "
        <script>
            window.location.href = 'index.php?link=pages/pulang/data';
        </script>   
";
    }
}
?>
<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Cek Data Santri</h4>
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
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">NIS : <?= $nis; ?></h4>
                <!--chat Row -->
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="pull-left">
                            <address>
                                <h3> &nbsp;<b class="text-danger"><?= $r['nama']; ?></b></h3>
                                <p class="text-muted m-l-5 font-bold">
                                    <?= $r['tempat'] . ", " . $r['tanggal']; ?>
                                    <br /> <?= $r['desa'] . " - " . $r['kec'] . " - " . $r['kab'] ?>
                                    <br />
                                    <?= $r['k_formal'] . " " . $r['t_formal'] . " / " . $r['k_madin'] . " " . $r['r_madin'] ?>
                                    <br /> <?= $r['komplek'] . " - " . $r['kamar'] ?>
                                    <br /> Dekos ke - <?= $kos[$r['t_kos']]; ?></p>
                            </address>
                        </div>
                    </div>
                </div>
                <?php
                $ket = $r2["ket"];
                $now = explode("/", date("d/m/Y"));
                //$now1 = $now[0] + $now[1] + $now[2];
                $now1 = date("Y-m-d");

                $p = explode("/", $r2["tgl_pulang"]);
                $p1 = $p[0] + $p[1] + $p[2];

                $w = explode("/", $r2["wajib_kembali"]);
                //$w1 = $w[0] + $w[1] + $w[2];
                $w1 = date("Y-m-d", strtotime($r2["wajib_kembali"]));

                if ($r2["tgl_kembali"] == '-') {
                    $k = $r2["tgl_kembali"];
                } else {
                    $k = $r2["tgl_kembali"];
                    $k1 = explode("/", $r2["tgl_kembali"]);
                    $k2 = date("Y-m-d", strtotime($r2["tgl_kembali"]));
                }

                if ($r2["wajib_kembali"] == 'Tak dibatasi' && $k == '-') {
                    echo "<label class='label label-warning float-right'><span class='fa fa-home'></span> masih dirumah
                    </label>";
                } elseif (strtotime($now1) < strtotime($w1) && $k == '-') {
                    echo "<label class='label label-warning float-right'><span class='fa fa-home'></span> masih dirumah
                        </label>";
                } elseif (strtotime($now1) >= strtotime($w1) && $k == '-') {
                    $awal = date('Y-m-d', strtotime($r2["wajib_kembali"]));
                    $akhir = date('Y-m-d');
                    $diff  = date_diff(date_create($akhir), date_create($awal));
                    $beda = $diff->format('%a');
                    echo "<label class='label label-danger float-right'><span class='fas fa-bullhorn'></span> harus kembali
                        </label>";
                    echo "<label class='label label-primary float-right'></span> telat : " . $beda . " hari
                        </label>";
                } elseif ($ket == 1 && $k != '-') {
                    echo "<label class='label label-danger float-right'><span class='fas fa-window-close'></span> telat kembali
                        </label>";
                } elseif ($ket == 2 && $k != '-') {
                    echo "<label class='label label-success float-right'><span class='fa fa-check'></span> pondok
                        </label>";
                }

                ?>
                <?php if ($ket == 1) {
                    $k2 = date('Y-m-d', strtotime($r2["tgl_kembali"]));
                    $awal  = new DateTime($w1);
                    $akhir = new DateTime($k2);
                    $diff  = date_diff(date_create($k2), date_create($w1));
                    $beda = $diff->format('%a');
                ?>
                <label class="label label-primary float-right" style="font-size: 15px;">Estimasi keterlambatan :
                    <?= $beda ?>
                    hari</label>
                <?php } ?>
                <br>
                <br>
                <hr>
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?= $id; ?>">
                    <div class="form-group row">
                        <label class="col-md-2 ">Tujuan</label>
                        <div class="col-md-10">
                            <input type="text" name="tujuan" class="form-control is-valid" id="validationServer01"
                                required value="<?= $r2['tujuan'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 ">Keperluan</label>
                        <div class="col-md-10">
                            <textarea class="form-control is-valid" name="keperluan"
                                id="validationServer01"><?= $r2['keperluan'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 ">Tgl Pulang</label>
                        <div class="col-md-10">
                            <input type="text" name="tgl_pulang" class="form-control is-valid" id="datepicker-autoclose"
                                required autocomplete="off" value="<?= $r2['tgl_pulang'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 ">Wajib Kembali</label>
                        <div class="col-md-10">
                            <input type="text" name="wajib_kembali" class="form-control is-valid"
                                id="datepicker-autoclose2" required autocomplete="off"
                                value="<?= $r2['wajib_kembali'] ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 "></label>
                        <div class="col-md-10">
                            <button class="btn btn-success " name="edit" type="submit"><span class="fa fa-check"></span>
                                Simpan Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>