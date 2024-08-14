<?php
include 'function.php';
$nis = $_POST['nis'];
$sn = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_santri WHERE nis = '$nis' "));
$kos = array("-", "Ny. Jamilah", "Gus Zaini", "Ny. Farihah", "Ny. Zahro", "Ny. Sa'adah", "Ny. Mamjudah", "Ny. Naily Z", "Ny. Lathifah");

if (isset($_POST["save"])) {
    if (add_pulang($_POST) > 0) {
        echo "
        <script>
        alert('Data Berhasil Ditambahkan');
            window.location.href = 'index.php?link=pages/pulang/data';
        </script>  
";
    } else {
        echo "
        <script>
        alert('Data Gagal Ditambahkan');
            window.location.href = 'index.php?link=pages/pulang/data';
        </script>   
";
    }
}

?>
<form action="" method="post">
    <input type="hidden" name="nis" value="<?= $nis; ?>">
    <input type="hidden" name="isi" value="<?= $_SESSION['nama']; ?>">
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
                        <br /> Dekos ke - <?= $kos[$sn['t_kos']]; ?>
                    </p>
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
            <input type="text" name="tgl_pulang" class="form-control is-valid" id="datepicker-autoclose" required autocomplete="off">
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