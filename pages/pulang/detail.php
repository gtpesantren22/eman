<?php
require 'function.php';
$nis = $_GET['nis'];
$id = $_GET['id'];
$r = query("SELECT * FROM tb_santri WHERE nis = '$nis' ")[0];
$r2 = query("SELECT * FROM pulang WHERE id = $id ")[0];

$kos = array("-", "Ny. Jamilah", "Gus Zaini", "Ny. Farihah", "Ny. Zahro", "Ny. Sa'adah", "Ny. Mamjudah", "Ny. Naily Z", "Ny. Lathifah");

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
    <div class="row">
        <div class="col-12">
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
                    $w1 = date('Y-m-d', strtotime($r2["wajib_kembali"]));

                    if ($r2["tgl_kembali"] == '-') {
                        $k = $r2["tgl_kembali"];
                    } else {
                        $k = $r2["tgl_kembali"];
                        $k1 = explode("/", $r2["tgl_kembali"]);
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
                        <?= $beda; ?>
                        hari</label>
                    <?php } ?>
                    <br>
                    <br>
                    <hr>
                    <ul class="chat-list">
                        <!--chat Row -->
                        <li class="chat-item">
                            <div class="chat-content">
                                <h6 class="font-medium">Tujuan Pulang</h6>
                                <div class="box bg-light-info"><?= $r2['tujuan'] ?></div>
                            </div>

                            <div class="chat-content">
                                <h6 class="font-medium">Keperluan</h6>
                                <div class="box bg-light-info"><?= $r2['keperluan'] ?>
                                </div>
                            </div>

                            <div class="chat-content">
                                <h6 class="font-medium">Tgl Pulang</h6>
                                <div class="box bg-light-info">
                                    <?= tanggal_indo($r2['tgl_pulang'], true); ?>
                                </div>
                            </div>
                            <div class="chat-content">
                                <h6 class="font-medium">Wajib Kembali</h6>
                                <div class="box bg-light-info">
                                    <?php
                                    if ($r2['wajib_kembali'] == 'Tak dibatasi') {
                                        echo $r2['wajib_kembali'];
                                    } else {
                                        echo tanggal_indo($r2['wajib_kembali'], true);
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="chat-content">
                                <h6 class="font-medium">Tgl Kembali</h6>
                                <?php if ($r2['tgl_kembali'] == '-') { ?>
                                <div class="box bg-light-info"> <?= $r2['tgl_kembali']; ?>
                                </div>
                                <?php } else { ?>
                                <div class="box bg-light-info"> <?= tanggal_indo($r2['tgl_kembali'], true); ?>
                                </div>
                                <?php } ?>
                            </div>
                            <hr>
                            <div class="chat-content">
                                <a href="<?= 'index.php?link=pages/pulang/edit&id=' . $id . '&nis=' . $nis ?>"><button
                                        class=" btn btn-warning"><span class="fa fa-edit"></span> Edit</button></a>
                                <?php if ($r2['tgl_kembali'] == '-') { ?>
                                <a href="<?= 'index.php?link=pages/pulang/balek&id=' . $id . '&nis=' . $nis ?>"><button
                                        class="btn btn-success"><span class="fas fa-diagnoses"></span>
                                        Balek Pondok</button></a>
                                <?php } else { ?>
                                <button class="btn btn-success" disabled><span class="fas fa-diagnoses"></span>
                                    Balek Pondok</button>
                                <?php } ?>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>