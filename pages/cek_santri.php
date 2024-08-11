<?php
require 'function.php';
$nis = $_GET['nis'];
$r = query("SELECT * FROM tb_santri WHERE nis = '$nis' ")[0];

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
                <div class="chat-box scrollable" style="height:475px;">
                    <!--chat Row -->
                    <ul class="chat-list">
                        <!--chat Row -->
                        <li class="chat-item">
                            <div class="chat-img"><img src="assets/images/users/1.jpg" alt="user"></div>
                            <div class="chat-content">
                                <h6 class="font-medium">Nama</h6>
                                <div class="box bg-light-info"><?= $r['nama'] ?></div>
                            </div>

                            <div class="chat-content">
                                <h6 class="font-medium">Tetala</h6>
                                <div class="box bg-light-info"><?= $r['tempat'] ?>,
                                    <?= date("d F Y", strtotime($r['tanggal'])) ?>
                                </div>
                            </div>

                            <div class="chat-content">
                                <h6 class="font-medium">Alamat</h6>
                                <div class="box bg-light-info"><?= $r['desa'] ?> - <?= $r['kec'] ?> - <?= $r['kab'] ?>
                                </div>
                            </div>

                            <div class="chat-content">
                                <h6 class="font-medium">Kelas Formal / Madin</h6>
                                <div class="box bg-light-info"><?= $r['k_formal'] ?> <?= $r['t_formal'] ?> /
                                    <?= $r['k_madin'] ?><?= $r['r_madin'] ?></div>
                            </div>

                            <div class="chat-content">
                                <h6 class="font-medium">Kamar</h6>
                                <div class="box bg-light-info"><?= $r['komplek'] ?> <?= $r['kamar'] ?></div>
                            </div>

                            <div class="chat-content">
                                <h6 class="font-medium">Nama Bapak</h6>
                                <div class="box bg-light-info"><?= $r['bapak'] ?></div>
                            </div>

                            <div class="chat-content">
                                <h6 class="font-medium">Nama Ibu</h6>
                                <div class="box bg-light-info"><?= $r['ibu'] ?></div>
                            </div>

                            <div class="chat-content">
                                <h6 class="font-medium">No. HP</h6>
                                <div class="box bg-light-info"><?= $r['hp'] ?></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>