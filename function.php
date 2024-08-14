<?php

//Koneksi
$dbUser = "root";
$dbPass = "";
$dbName = "bendahara";
$dbHost = "localhost";
$conn = mysqli_connect("localhost", "root", "", "db_eman");
// $conn = mysqli_connect("localhost", "u9048253_dwk", "PesantrenDWKIT2021", "u9048253_eman");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function add_pulang($data)
{
    global $conn;
    $nis = $data['nis'];
    $isi = htmlspecialchars(mysqli_real_escape_string($conn, $data['isi']));
    $tujuan = htmlspecialchars(mysqli_real_escape_string($conn, $data['tujuan']));
    $keperluan = htmlspecialchars(mysqli_real_escape_string($conn, $data['keperluan']));
    $tgl_pulang = htmlspecialchars(mysqli_real_escape_string($conn, $data['tgl_pulang']));
    $wajib_kembali = htmlspecialchars(mysqli_real_escape_string($conn, $data['wajib_kembali']));

    if ($wajib_kembali == '') {
        $wajib = "Tak dibatasi";
    } else {
        $wajib = $wajib_kembali;
    }

    mysqli_query($conn, "INSERT INTO pulang(nis, tujuan, keperluan, tgl_pulang, wajib_kembali, tgl_kembali, syarat, ket, penulis) VALUES('$nis', '$tujuan', '$keperluan', '$tgl_pulang', '$wajib', '-', '-', 0, '$isi') ");
    mysqli_affected_rows($conn);
}

function edit_pulang($data)
{
    global $conn;
    $id = $data['id'];
    $tujuan = htmlspecialchars(mysqli_real_escape_string($conn, $data['tujuan']));
    $keperluan = htmlspecialchars(mysqli_real_escape_string($conn, $data['keperluan']));
    $tgl_pulang = htmlspecialchars(mysqli_real_escape_string($conn, $data['tgl_pulang']));
    $wajib_kembali = htmlspecialchars(mysqli_real_escape_string($conn, $data['wajib_kembali']));

    mysqli_query($conn, "UPDATE pulang SET tujuan = '$tujuan', keperluan = '$keperluan', tgl_pulang = '$tgl_pulang', wajib_kembali = '$wajib_kembali' WHERE id = $id");
    mysqli_affected_rows($conn);
}

function balek($data)
{
    global $conn;
    $id = $data['id'];
    $nis = $data['nis'];
    $wajib_kembali = $data['wajib_kembali'];
    $tgl_kembali = htmlspecialchars(mysqli_real_escape_string($conn, $data['tgl_kembali']));
    $syarat = htmlspecialchars(mysqli_real_escape_string($conn, $data['syarat']));

    $w = explode("/", $wajib_kembali);
    //$w1 = $w[0] + $w[1] + $w[2];
    $w1 = date('Y-m-d', strtotime($wajib_kembali));

    $k = explode("/", $tgl_kembali);
    //$k1 = $k[0] + $k[1] + $k[2];
    $k1 = date('Y-m-d', strtotime($tgl_kembali));

    if ($wajib_kembali == 'Tak dibatasi') {
        $ket = 2;
    } elseif (strtotime($k1) > strtotime($w1)) {
        $ket = 1;
    } else {
        $ket = 2;
    }

    if ($ket == 1) {
        mysqli_query($conn, "INSERT INTO pelanggaran VALUES('', '$nis', 'Telat Kembali', 'Telat Kembali ke pondok', '$tgl_kembali', 'Pondok', '-', '-', '-', 'Belum ditangani') ");
    }

    mysqli_query($conn, "UPDATE pulang SET tgl_kembali = '$tgl_kembali', syarat = '$syarat', ket = $ket WHERE id = $id ");

    mysqli_affected_rows($conn);
}

function del_pulang($id)
{
    global $conn;
    mysqli_query($conn,  "DELETE FROM syahriah WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function tanggal_indo($tanggal, $cetak_hari = false)
{
    $hari = array(
        1 =>    'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
        'Ahad'
    );

    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $split       = explode('/', $tanggal);
    $tgl_indo = $split[1] . ' ' . $bulan[(int)$split[0]] . ' ' . $split[2];

    if ($cetak_hari) {
        $num = date('N', strtotime($tanggal));
        return $hari[$num] . ', ' . $tgl_indo;
    }
    return $tgl_indo;
}


function add_pel($data)
{
    global $conn;
    $nis = $data['nis'];
    $kasus = htmlspecialchars(mysqli_real_escape_string($conn, $data['kasus']));
    $kronologis = htmlspecialchars(mysqli_real_escape_string($conn, $data['kronologis']));
    $tgl = htmlspecialchars(mysqli_real_escape_string($conn, $data['tgl']));
    $tempat = htmlspecialchars(mysqli_real_escape_string($conn, $data['tempat']));
    $ket = htmlspecialchars(mysqli_real_escape_string($conn, $data['ket']));
    $pj = htmlspecialchars(mysqli_real_escape_string($conn, $data['pj']));
    $sanksi = htmlspecialchars(mysqli_real_escape_string($conn, $data['sanksi']));

    if ($pj == '') {
        $stts = 'Belum ditangani';
    } else {
        $stts = 'Sudah ditangani';
    }
    //$stts = htmlspecialchars(mysqli_real_escape_string($conn, $data['stts']));

    mysqli_query($conn, "INSERT INTO pelanggaran VALUES('', '$nis', '$kasus', '$kronologis', '$tgl', '$tempat', '$ket', '$sanksi', '$pj', '$stts') ");
    mysqli_affected_rows($conn);
}

function edit_pel($data)
{
    global $conn;
    $id = $data['id'];
    $kasus = htmlspecialchars(mysqli_real_escape_string($conn, $data['kasus']));
    $kronologis = htmlspecialchars(mysqli_real_escape_string($conn, $data['kronologis']));
    $tgl = htmlspecialchars(mysqli_real_escape_string($conn, $data['tgl']));
    $tempat = htmlspecialchars(mysqli_real_escape_string($conn, $data['tempat']));
    $ket = htmlspecialchars(mysqli_real_escape_string($conn, $data['ket']));
    $pj = htmlspecialchars(mysqli_real_escape_string($conn, $data['pj']));
    $stts = htmlspecialchars(mysqli_real_escape_string($conn, $data['stts']));
    $sanksi = htmlspecialchars(mysqli_real_escape_string($conn, $data['sanksi']));

    mysqli_query($conn, "UPDATE pelanggaran SET kasus = '$kasus', kronologis = '$kronologis', tanggal = '$tgl', tempat = '$tempat', ket = '$ket',  sanksi = '$sanksi', pj = '$pj', stts = '$stts' WHERE id = $id");
    mysqli_affected_rows($conn);
}
?>

<!-- akhir -->