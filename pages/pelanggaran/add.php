<?php
require 'function.php';
$santri =  query("SELECT * FROM pelanggaran ORDER by nis ASC");
if (isset($_POST["save"])) {
    if (add_pel($_POST) > 0) {
        echo "
        <script>
            window.location.href = 'index.php?link=pages/pelanggaran/data';
        </script>  
";
    } else {
        echo "
        <script>
            window.location.href = 'index.php?link=pages/pelanggaran/data';
        </script>   
";
    }
}
?>

<!-- ============================================================== -->
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Tambah Data Pelanggaran</h4>
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
                                            <br /> <?= $sn['komplek'] . " - " . $sn['kamar'] ?></p>
                                    </address>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 ">Kasus</label>
                            <div class="col-md-10">
                                <textarea class="form-control is-invalid" name="kasus" id="validationServer01"
                                    required></textarea>
                            </div>
                            <label class="col-md-2 ">Kronologis</label>
                            <div class="col-md-10">
                                <textarea class="form-control is-invalid" name="kronologis" id="validationServer01"
                                    required></textarea>
                            </div>
                            <label class="col-md-2 ">Tanggal</label>
                            <div class="col-md-10">
                                <input type="text" name="tgl" class="form-control is-invalid" id="datepicker-autoclose"
                                    required autocomplete="off">
                            </div>
                            <label class="col-md-2 ">Tempat</label>
                            <div class="col-md-10">
                                <input type="text" name="tempat" class="form-control is-invalid" required
                                    autocomplete="off">
                            </div>
                            <label class="col-md-2 ">Keterangan</label>
                            <div class="col-md-10">
                                <textarea class="form-control is-invalid" name="ket" id="validationServer01"></textarea>
                            </div>
                            <label class="col-md-2 ">Sanksi</label>
                            <div class="col-md-10">
                                <input type="text" name="sanksi" class="form-control is-invalid" autocomplete="off">
                                <div class="invalid-feedback">
                                    * harap kosongi jika belum ditangani
                                </div>
                            </div>
                            <label class="col-md-2 ">Yang Menanganani</label>
                            <div class="col-md-10">
                                <input type="text" name="pj" class="form-control is-invalid" autocomplete="off">
                                <div class="invalid-feedback">
                                    * harap kosongi jika belum ditangani
                                </div>
                            </div>
                            <br>
                            <br>
                            <label class="col-md-2 "></label>
                            <div class="col-md-10">
                                <button class="btn btn-danger " name="save" type="submit"><span
                                        class="fa fa-check"></span>
                                    Simpan</button>
                            </div>
                        </div>
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>