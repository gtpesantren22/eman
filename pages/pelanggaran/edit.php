<?php
require 'function.php';
$nis = $_GET['nis'];
$id = $_GET['id'];
$r = query("SELECT * FROM tb_santri WHERE nis = '$nis' ")[0];
$r2 = query("SELECT * FROM pelanggaran WHERE id = $id ")[0];

if (isset($_POST["edit"])) {
    if (edit_pel($_POST) > 0) {
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
            <h4 class="page-title">Edit Data pelanggaran</h4>
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
                                    <br /> <?= $r['komplek'] . " - " . $r['kamar'] ?></p>
                            </address>
                        </div>
                    </div>
                </div>
                <form action="" method="post">
                    <input type="hidden" name="id" value="<?= $id; ?>">
                    <div class="form-group row">
                        <label class="col-md-2 ">Kasus</label>
                        <div class="col-md-10">
                            <textarea class="form-control is-invalid" name="kasus" id="validationServer01"
                                required><?= $r2['kasus'] ?></textarea>
                        </div>
                        <label class="col-md-2 ">Kronologis</label>
                        <div class="col-md-10">
                            <textarea class="form-control is-invalid" name="kronologis" id="validationServer01"
                                required><?= $r2['kronologis'] ?></textarea>
                        </div>
                        <label class="col-md-2 ">Tanggal</label>
                        <div class="col-md-10">
                            <input type="text" name="tgl" class="form-control is-invalid" id="datepicker-autoclose"
                                required autocomplete="off" value="<?= $r2['tanggal'] ?>">
                        </div>
                        <label class="col-md-2 ">Tempat</label>
                        <div class="col-md-10">
                            <input type="text" name="tempat" class="form-control is-invalid" required autocomplete="off"
                                value="<?= $r2['tempat'] ?>">
                        </div>
                        <label class="col-md-2 ">Keterangan</label>
                        <div class="col-md-10">
                            <textarea class="form-control is-invalid" name="ket"
                                id="validationServer01"><?= $r2['ket'] ?></textarea>
                        </div>
                        <label class="col-md-2 ">Sanksi</label>
                        <div class="col-md-10">
                            <input type="text" name="sanksi" class="form-control is-invalid" autocomplete="off"
                                value="<?= $r2['sanksi'] ?>">
                            <div class="invalid-feedback">
                                * harap kosongi jika belum ditangani
                            </div>
                        </div>
                        <label class="col-md-2 ">Yang Menanganani</label>
                        <div class="col-md-10">
                            <input type="text" name="pj" class="form-control is-invalid" autocomplete="off"
                                value="<?= $r2['pj'] ?>">
                            <div class="invalid-feedback">
                                * harap kosongi jika belum ditangani
                            </div>
                        </div>
                        <label class="col-md-2 ">Status</label>
                        <div class="col-md-10">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="customControlValidation1"
                                    name="stts" required value="Sudah ditangani"
                                    <?php if ($r2['stts'] == 'Sudah ditangani') echo 'checked' ?>>
                                <label class="custom-control-label" for="customControlValidation1">Sudah
                                    ditangani <span class="fa fa-check"></span></label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="customControlValidation2"
                                    name="stts" required value="Belum ditangani"
                                    <?php if ($r2['stts'] == 'Belum ditangani') echo 'checked' ?>>
                                <label class="custom-control-label" for="customControlValidation2">Belum
                                    ditangani <span class="far fa-times-circle"></span></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 "></label>
                            <div class="col-md-10">
                                <button class="btn btn-success " name="edit" type="submit"><span
                                        class="fa fa-check"></span>
                                    Simpan Edit</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>