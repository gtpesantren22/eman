<?php

session_start();
$_SESSION = [];
session_destroy();
session_unset();

require 'function.php';
$user = $_SESSION['user'];

date_default_timezone_set('Asia/Jakarta');
$ldate = date('Y-m-d H:i:s', time());
mysqli_query($conn, "UPDATE userlog  SET logout = '$ldate' WHERE username = '$user' ORDER BY id DESC LIMIT 1");

echo '<script language="javascript"> document.location="index.php";</script>';

?>
<!-- Akhir -->