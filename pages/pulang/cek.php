<?php
require 'function.php';
$santri =  query("SELECT * FROM pulang ORDER by nis ASC");

if (isset($_POST["save"])) {
    if (add_pulang($_POST) > 0) {
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
            <h4 class="page-title">Tambah Data Pulang</h4>
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
                            <label class="col-md-2 m-t-15">Pilih Nama</label>
                            <div class="col-md-10">
                                <select class="select2 form-control custom-select" name="nama" style="width: 100%;"
                                    required>
                                    <option>Select</option>
                                    <?php
                                    if ($level == 'admin') {
                                        $th = mysqli_query($conn, "SELECT * FROM tb_santri");
                                    } elseif ($level == 'putra') {
                                        $th = mysqli_query($conn, "SELECT * FROM tb_santri WHERE jkl = 'Laki-laki' ");
                                    } else {
                                        $th = mysqli_query($conn, "SELECT * FROM tb_santri WHERE jkl = 'Perempuan' ");
                                    }
                                    $no = 0;
                                    while ($thn = mysqli_fetch_array($th)) {
                                        $no++;
                                    ?>
                                    <option value="<?= $thn['nis'] ?>"><?= $thn['nama'] ?>
                                        (<?= $thn['k_formal'] . " " . $thn['t_formal'] ?>)
                                    </option>
                                    <?php
                                    }
                                    ?>
                                </select>
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
                        $nis = $_POST['nama'];
                        $sn = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_santri WHERE nis = '$nis' "));
                        $pl = query("SELECT * FROM pulang WHERE nis = '$nis' ");
                        $jp = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pulang WHERE nis = '$nis' "));
                        $pl1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT MIN(tgl_pulang) AS min FROM pulang WHERE nis = '$nis' "));
                        $pl2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT MAX(tgl_pulang) AS max FROM pulang WHERE nis = '$nis' "));

                        $kos = array("-", "Ny. Jamilah", "Gus Zaini", "Ny. Farihah", "Ny. Zahro", "Ny. Sa'adah", "Ny. Mamjudah", "Ny. Naily Z", "Ny. Lathifah");
                    ?>
                    <form action="" method="post">
                        <input type="hidden" name="nis" value="<?= $nis; ?>">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="pull-left">
                                    <address>
                                        <h3> &nbsp;<b class="text-danger"><?= $sn['nama']; ?></b></h3>
                                        <p class="text-muted m-l-5 font-bold">
                                            <?= $sn['tempat'] . ", " . $sn['tanggal']; ?>
                                            <br /> <?= $sn['desa'] . " - " . $sn['kec'] . " - " . $sn['kab'] ?>
                                            <br />
                                            <?= $sn['k_formal'] . " " . $sn['t_formal'] . " / " . $sn['k_madin'] . " " . $sn['r_madin'] ?>
                                            <br /> <?= $sn['komplek'] . " - " . $sn['kamar'] ?>
                                            <br /> Dekos ke - <?= $kos[$sn['t_kos']]; ?></p>
                                    </address>
                                </div>
                            </div>
                        </div>
                        <span class="badge badge-secondary">jumlah pulang : <?= $jp; ?> kali</span>
                        <?php if (isset($pl1['min']) && isset($pl2['max'])) { ?>
                        <span class="badge badge-success">Dari :
                            <?= tanggal_indo($pl1['min']) . " s/d " . tanggal_indo($pl2['max']); ?></span>
                        <?php } ?>
                        <hr>
                        <!-- Comment Row -->
                        <?php $i = 1; ?>
                        <?php foreach ($pl as $r) : ?>
                        <div class="comment-widgets scrollable">
                            <div class="d-flex flex-row comment-row m-t-0">
                                <div class="comment-text w-100">
                                    <h6 class="font-bold">
                                        <?= $r['tujuan'] . " - " . $r['keperluan'] ?></h6>
                                    <span class="m-b-15 d-block"><?= tanggal_indo($r['tgl_pulang'], true); ?>
                                        s/d
                                        <?= tanggal_indo($r['wajib_kembali'], true); ?> </span>
                                    <div class="comment-footer">
                                        <?php
                                                $ket = $r["ket"];
                                                $now = explode("/", date("d/m/Y"));
                                                $now1 = $now[0] + $now[1] + $now[2];

                                                $p = explode("/", $r["tgl_pulang"]);
                                                $p1 = $p[0] + $p[1] + $p[2];

                                                $w = explode("/", $r["wajib_kembali"]);
                                                $w1 = $w[0] + $w[1] + $w[2];

                                                if ($r["tgl_kembali"] == '-') {
                                                    $k = $r["tgl_kembali"];
                                                } else {
                                                    $k = $r["tgl_kembali"];
                                                    $k1 = explode("/", $r["tgl_kembali"]);
                                                    $k2 = $k1[0] + $k1[1] + $k1[2];
                                                }

                                                if (($now1 < $w1) && ($k == '-')) {
                                                    echo "<label class='label label-warning float-right'><span class='fa fa-home'></span> masih dirumah
                        </label>";
                                                } elseif (($now1 >= $w1) && ($k == '-')) {
                                                    echo "<label class='label label-danger float-right'><span class='fas fa-bullhorn'></span> harus kembali
                        </label>";
                                                } elseif ($ket == 1 && $k != '-') {
                                                    echo "<label class='label label-danger float-right'><span class='fas fa-window-close'></span> telat kembali
                        </label>";
                                                } elseif ($ket == 2 && $k != '-') {
                                                    echo "<label class='label label-success float-right'><span class='fa fa-check'></span> pondok
                        </label>";
                                                }
                                                ?>
                                        <a
                                            href="<?= 'index.php?link=pages/pulang/detail&nis=' . $r['nis'] . '&id=' . $r['id']; ?>"><button
                                                type="button" class="btn btn-cyan btn-sm"><span
                                                    class="fas fa-list-alt"></span>
                                                Detail</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $i++; ?>
                        <?php endforeach; ?>
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>