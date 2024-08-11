<?php
require 'function.php';
$nis = $_GET['nis'];
$id = $_GET['id'];
$r = query("SELECT * FROM tb_santri WHERE nis = '$nis' ")[0];
$r2 = query("SELECT * FROM pelanggaran WHERE id = $id ")[0];

mysqli_query($conn, "DROP VIEW IF EXISTS v_pulang ");
mysqli_query($conn, "DROP VIEW IF EXISTS v_telat ");
mysqli_query($conn, "CREATE VIEW v_pulang AS SELECT nis,tujuan, keperluan, tgl_pulang, wajib_kembali, tgl_kembali, syarat, ket, penulis FROM `pulang` WHERE nis = $nis ");
mysqli_query($conn, "CREATE VIEW v_telat AS SELECT * FROM pelanggaran WHERE nis = $nis ");

$data = mysqli_query($conn, "SELECT a.*, b.* FROM v_telat a JOIN v_pulang b ON a.tanggal=b.tgl_kembali WHERE a.stts = 'Belum Ditangani' ");

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
                                        <br /> <?= $r['komplek'] . " - " . $r['kamar'] ?></p>
                                </address>
                            </div>
                        </div>
                    </div>
                    <ul class="chat-list">
                        <!--chat Row -->
                        <!--<li class="chat-item">-->
                        <!--    <div class="chat-content">-->
                        <!--        <h6 class="font-medium">Kasus</h6>-->
                        <!--        <div class="box bg-light-info"><?= $r2['kasus'] ?>-->
                        <!--        </div>-->
                        <!--    </div>-->

                        <!--    <div class="chat-content">-->
                        <!--        <h6 class="font-medium">Kronologis</h6>-->
                        <!--        <div class="box bg-light-info"><?= $r2['kronologis'] ?>-->
                        <!--        </div>-->
                        <!--    </div>-->

                        <!--    <div class="chat-content">-->
                        <!--        <h6 class="font-medium">Tanggal</h6>-->
                        <!--        <div class="box bg-light-info">-->
                        <!--            <?= tanggal_indo($r2['tanggal'], true); ?>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--    <div class="chat-content">-->
                        <!--        <h6 class="font-medium">Tempat</h6>-->
                        <!--        <div class="box bg-light-info">-->
                        <!--            <?= $r2['tempat']; ?>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--    <div class="chat-content">-->
                        <!--        <h6 class="font-medium">Keterangan</h6>-->
                        <!--        <div class="box bg-light-info"> <?= $r2['ket']; ?>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--    <div class="chat-content">-->
                        <!--        <h6 class="font-medium">Sanksi</h6>-->
                        <!--        <div class="box bg-light-info"> <?= $r2['sanksi']; ?>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--    <div class="chat-content">-->
                        <!--        <h6 class="font-medium">Yang Menangani</h6>-->
                        <!--        <div class="box bg-light-info"> <?= $r2['pj']; ?>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--    <div class="chat-content">-->
                        <!--        <h6 class="font-medium">Status</h6>-->
                        <!--        <div class="box bg-light-info"> <?= $r2['stts']; ?>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--    <hr>-->
                        <!--    <div class="chat-content">-->
                        <!--        <a href="<?= 'index.php?link=pages/pelanggaran/edit&id=' . $id . '&nis=' . $nis ?>"><button-->
                        <!--                class=" btn btn-warning"><span class="fa fa-edit"></span> Edit</button></a>-->
                        <!--    </div>-->
                        <!--</li>-->
                        <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kasus</th>
                                    <th>Wajib Kembali</th>
                                    <th>Kembalinya</th>
                                    <th>Lama telat</th>
                                    <th>Stts</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($data as $r) : ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $r["kasus"]; ?> </td>
                                    <td><?= date("d-m-Y", strtotime($r["wajib_kembali"])); ?> </td>
                                    <td><?= date("d-m-Y", strtotime($r["tgl_kembali"])); ?> </td>
                                    <td><label class="badge badge-primary"><?php 
                                                $awal = date('Y-m-d', strtotime($r["wajib_kembali"]));
                                                $akhir = date('Y-m-d', strtotime($r["tgl_kembali"]));
                                                $diff  = date_diff(date_create($akhir), date_create($awal));
                                                $beda = $diff->format('%a'); 
                                                echo $beda . ' hari'?></label> </td>
                                    <td><span class="badge badge-pill badge-dark"><?= $ket = $r["stts"]; ?></span></td>
                                    <td><a href="<?= 'index.php?link=pages/pelanggaran/edit&id=' . $id . '&nis=' . $nis ?>"><button 
                                        class=" btn btn-warning"><span class="fa fa-edit"></span> Edit</button></a>
                                        <?php if ($level == 'admin') { ?>
                                        <a href="<?= 'index.php?link=pages/pelanggaran/del&id=' . $r['id']; ?>"
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
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>