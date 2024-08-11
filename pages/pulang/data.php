<?php
require 'function.php';
if ($level == 'admin') {
    $santri =  query("SELECT a.id, a.nis, a.tgl_pulang, a.wajib_kembali, a.tgl_kembali, a.ket, b.nama, b.k_formal, b.t_formal, b.k_madin, b.r_madin FROM pulang AS a INNER JOIN tb_santri AS b ON a.nis=b.nis WHERE a.ket = 0 ORDER by a.wajib_kembali ASC");
} elseif ($level == 'putra') {
    $santri =  query("SELECT a.id, a.nis, a.tgl_pulang, a.wajib_kembali, a.tgl_kembali, a.ket, b.nama, b.k_formal, b.t_formal, b.k_madin, b.r_madin FROM pulang AS a INNER JOIN tb_santri AS b ON a.nis=b.nis WHERE jkl = 'Laki-laki' AND a.ket = 0 ORDER by a.wajib_kembali ASC");
} else {
    $santri =  query("SELECT a.id, a.nis, a.tgl_pulang, a.wajib_kembali, a.tgl_kembali, a.ket, b.nama, b.k_formal, b.t_formal, b.k_madin, b.r_madin FROM pulang AS a INNER JOIN tb_santri AS b ON a.nis=b.nis WHERE jkl = 'Perempuan' AND a.ket = 0 ORDER by a.wajib_kembali ASC");
}
?>

<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Data Pulang Santri</h4>
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
                    <a href="index.php?link=pages/pulang/add"><button class="btn btn-success float-left"><span
                                class="fas fa-plus-circle"></span> Tambah
                            Data</button></a>
                    <a href="index.php?link=pages/pulang/cek"><button class="btn btn-info float-left"><span
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
                </div>
            </div>
        </div>
    </div>
</div>