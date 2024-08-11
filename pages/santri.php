<?php
require 'function.php';
$santri =  query("SELECT * FROM tb_santri WHERE aktif = 'Y' ORDER by nis ASC");
?>

<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Data Santri</h4>
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
                    <h5 class="card-title">Basic Datatable</h5>
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Kamar</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($santri as $r) : ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $r["nis"]; ?> </td>
                                        <td><?= $r["nama"]; ?> </td>
                                        <td><?= $r["k_formal"]; ?> <?= $r["t_formal"]; ?> / <?= $r["k_madin"]; ?>
                                            <?= $r["r_madin"]; ?> </td>
                                        <td><?= $r["komplek"]; ?> / <?= $r["kamar"]; ?> </td>
                                        <td><a href="<?= 'index.php?link=pages/cek_santri&nis=' . $r['nis']; ?>"><button
                                                    class="btn btn-success btn-sm"><span class="fa fa-search"></span>
                                                    Cek</button></a></td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>