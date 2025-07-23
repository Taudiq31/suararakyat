<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // pastikan ID adalah angka

    $sql = "DELETE FROM pengaduan WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Gagal menghapus data.";
    }
} else {
    echo "ID tidak ditemukan.";
}
?>
