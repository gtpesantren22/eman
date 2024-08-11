<?php
require 'function.php';
if ($level == 'admin') {
    $santri =  query("SELECT a.id, a.nis, a.kasus, a.tanggal, a.stts, a.sanksi, a.pj, b.nama, b.k_formal, b.t_formal, b.k_madin, b.r_madin, b.kamar, b.komplek FROM pelanggaran AS a INNER JOIN tb_santri AS b ON a.nis=b.nis WHERE a.sanksi = '-' AND a.pj = '-' AND kasus = 'Telat Kembali' GROUP BY a.nis");
} elseif ($level == 'putra') {
    $santri =  query("SELECT a.id, a.nis, a.kasus, a.tanggal, a.stts, a.sanksi, a.pj, b.nama, b.k_formal, b.t_formal, b.k_madin, b.r_madin, b.kamar, b.komplek FROM pelanggaran AS a INNER JOIN tb_santri AS b ON a.nis=b.nis WHERE jkl = 'Laki-laki' AND a.sanksi = '-' AND a.pj = '-' AND kasus = 'Telat Kembali' GROUP BY a.nis");
} else {
    $santri =  query("SELECT a.id, a.nis, a.kasus, a.tanggal, a.stts, a.sanksi, a.pj, b.nama, b.k_formal, b.t_formal, b.k_madin, b.r_madin, b.kamar, b.komplek FROM pelanggaran AS a INNER JOIN tb_santri AS b ON a.nis=b.nis WHERE jkl = 'Perempuan' AND a.sanksi = '-' AND a.pj = '-' AND kasus = 'Telat Kembali' GROUP BY a.nis");
}
?>

<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Data Pelanggaran Santri</h4>
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
                    <a href="index.php?link=pages/pelanggaran/add"><button class="btn btn-success float-left"><span
                                class="fas fa-plus-circle"></span> Tambah
                            Data</button></a>
                    <a href="index.php?link=pages/pelanggaran/cek"><button class="btn btn-info float-left"><span
                                class="fas fa-search"></span> Cek Santri</button></a>
                    <br>
                    <br>
                    <hr>
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kasus</th>
                                    <th>Kls/Kamar</th>
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
                                    <!--<td><?= date("d-m-Y", strtotime($r["tanggal"])); ?> </td>-->
                                    <td><span class="badge badge-pill badge-dark"><?= $ket = $r["stts"]; ?></span></td>
                                    <td><a
                                            href="<?= 'index.php?link=pages/pelanggaran/detail&nis=' . $r['nis'] . '&id=' . $r['id']; ?>"><button
                                                class="btn btn-success btn-sm"><span class="fa fa-search"></span>
                                                Detail</button></a>
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
                </div>
            </div>
        </div>
    </div>
</div>