<?php
require 'function.php';
$id = $_GET['id'];

$sql = mysqli_query($conn, "DELETE FROM pelanggaran WHERE id = $id ");

if ($sql) {
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

?>

<!-- OK -->