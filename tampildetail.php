<?php
session_start();
require 'function.php';
$nis = $_POST['nis'];
$sn = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_santri WHERE nis = '$nis' "));
$kos = array("-", "Ny. Jamilah", "Gus Zaini", "Ny. Farihah", "Ny. Zahro", "Ny. Sa'adah", "Ny. Mamjudah", "Ny. Naily Z", "Ny. Lathifah", "Ny. Umi Kultsum");


?>
<form action="" method="post">
    <input type="hidden" name="nisOk" value="<?= $nis; ?>">
    <input type="hidden" name="isi" value="<?= $_SESSION['nama']; ?>">
    <div class="form-group row">
        <div class="col-md-5">
            <div class="pull-left">
                <address>
                    <h3> &nbsp;<b class="text-danger"><?= $sn['nama']; ?></b></h3>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td>Tetala</td>
                            <td>: <?= $sn['tempat'] . ", " . $sn['tanggal']; ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: <?= $sn['desa'] . " - " . $sn['kec'] . " - " . $sn['kab'] ?></td>
                        </tr>
                        <tr>
                            <td>Kelas</td>
                            <td>: <?= $sn['k_formal'] . " " . $sn['t_formal'] . " / " . $sn['k_madin'] . " " . $sn['r_madin'] ?></td>
                        </tr>
                        <tr>
                            <td>Komplek</td>
                            <td>: <?= $sn['komplek'] . " - " . $sn['kamar'] ?></td>
                        </tr>
                        <tr>
                            <td>Dekosan</td>
                            <td>: Dekos ke - <?= $kos[$sn['t_kos']]; ?></td>
                        </tr>
                        <tr>
                            <td>Bapak</td>
                            <td>: <?= $sn['bapak'] ?></td>
                        </tr>
                        <tr>
                            <td>Ibu</td>
                            <td>: <?= $sn['ibu'] ?></td>
                        </tr>
                    </table>
                </address>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 ">NIS</label>
        <div class="col-md-10">
            <input type="text" name="nis" class="form-control is-valid" id="validationServer01"
                required value="<?= $nis; ?>">
        </div>
        <label class="col-md-2 ">Tgl Pulang</label>
        <div class="col-md-10">
            <input type="text" name="tgl_pulang" class="form-control is-valid" id="datepicker-autoclose" required value="<?= date('m/d/Y') ?>">
        </div>
        <label class="col-md-2 ">Tujuan</label>
        <div class="col-md-10">
            <input type="text" name="tujuan" class="form-control is-valid" id="validationServer01"
                required>
        </div>
        <label class="col-md-2 ">Keperluan</label>
        <div class="col-md-10">
            <textarea class="form-control is-valid" name="keperluan"
                id="validationServer01"></textarea>
        </div>
        <label class="col-md-2 ">Wajib Kembali</label>
        <div class="col-md-10">
            <input type="text" name="wajib_kembali" class="form-control is-valid"
                id="datepicker-autoclose2" autocomplete="off">
            <div class="valid-feedback">
                * harap DIKOSONGI jika pulangnya tidak terbatas
            </div>
        </div>
        <label class="col-md-2 ">Nama Penjemput</label>
        <div class="col-md-10">
            <input type="text" name="penjemput" class="form-control is-valid" id="validationServer01"
                required>
        </div>
        <label class="col-md-2 ">Status Penjemput</label>
        <div class="col-md-10">
            <input type="text" name="status" class="form-control is-valid" id="validationServer01"
                required>
        </div>
        <label class="col-md-2 ">Bukti</label>
        <div class="col-md-10">
            <input type="text" name="bukti" class="form-control is-valid" id="validationServer01"
                required>
        </div>
        <label class="col-md-2 ">PJ</label>
        <div class="col-md-10">
            <input type="text" name="pj" class="form-control is-valid" id="validationServer01"
                required>
        </div>
        <label class="col-md-2 ">Uang Administrasi</label>
        <div class="col-md-10">
            <input type="text" name="administrasi" class="form-control is-valid" id="validationServer01"
                required>
        </div>

        <br>
        <br>
        <br>
        <label class="col-md-2 "></label>
        <div class="col-md-10">
            <button class="btn btn-success " name="save" type="submit"><span
                    class="fa fa-check"></span>
                Simpan</button>
        </div>
    </div>
</form>

<script src="assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });
    jQuery('#datepicker-autoclose2').datepicker({
        autoclose: true,
        todayHighlight: true
    });
</script>