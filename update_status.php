<?php
include 'koneksi.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];

    // Update status di database
    $query = "UPDATE pengaduan SET status='$status' WHERE id=$id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: petugas.php"); // Kembali ke dashboard petugas
        exit();
    } else {
        echo "Gagal memperbarui status.";
    }
} else {
    echo "ID atau status tidak ditemukan.";
}
?>