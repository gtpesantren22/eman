<?php
require 'function.php';
$santri =  query("SELECT * FROM pulang ORDER by nis ASC");

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
                    <form id="form-cari">
                        <div class="form-group row">
                            <label class="col-md-2 m-t-15">Pilih Nama</label>
                            <div class="col-md-10">
                                <select class="select2 form-control custom-select" id="nis" name="nama" style="width: 100%;"
                                    required>
                                    <option>Select</option>
                                    <?php
                                    if ($level == 'admin') {
                                        $th = mysqli_query($conn, "SELECT * FROM tb_santri WHERE aktif = 'Y' ");
                                    } elseif ($level == 'putra') {
                                        $th = mysqli_query($conn, "SELECT * FROM tb_santri WHERE jkl = 'Laki-laki' AND aktif = 'Y' ");
                                    } else {
                                        $th = mysqli_query($conn, "SELECT * FROM tb_santri WHERE jkl = 'Perempuan' AND  aktif = 'Y'");
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
                                        class="fa fa-car"></span> Cek</button>
                                <button class="btn btn-warning "><span class="fas fas-logout"></span> Keluar</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div id="tampil-hasil"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/libs/jquery/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Ketika QR code dipindai dan diinput ke field
        $('#form-cari').on('submit', function() {
            event.preventDefault();
            $('#tampil-hasil').empty();
            var nis = $('#nis').val();

            // Kirim data ke server menggunakan AJAX
            $.ajax({
                url: 'tampildetail.php',
                type: 'POST',
                data: {
                    nis: nis
                },
                success: function(response) {
                    // Tampilkan hasil respon dari server
                    $('#tampil-hasil').html(response);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
<script>
    let qrcode = '';
    document.addEventListener('keypress', function(event) {
        // Ketika karakter "Enter" diterima, proses input sebagai satu kesatuan QR code
        if (event.key === 'Enter') {
            $('#tampil-hasil').empty();
            // Kirim QR code ke server menggunakan AJAX
            $.ajax({
                url: 'tampildetail.php',
                type: 'POST',
                data: {
                    nis: qrcode
                },
                success: function(response) {
                    // Tampilkan hasil respon dari server
                    $('#tampil-hasil').html(response);
                }
            });

            // Reset variabel untuk pemindaian berikutnya
            qrcode = '';
        } else {
            // Tambahkan setiap karakter yang diketikkan ke variabel qrcode
            qrcode += event.key;
        }
    });
</script>