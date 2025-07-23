<?php
session_start();
require 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}

// Ambil data dari form
$id_user     = $_SESSION['id'];
$klasifikasi = $_POST['klasifikasi'] ?? '';
$judul       = $_POST['judul'] ?? '';
$isi         = $_POST['isi'] ?? '';
$tanggal     = $_POST['tanggal'] ?? '';
$lokasi      = $_POST['lokasi'] ?? '';
$instansi    = $_POST['instansi'] ?? '';
$kategori    = $_POST['kategori'] ?? '';
$anonim      = isset($_POST['anonim']) ? 1 : 0;
$rahasia     = isset($_POST['rahasia']) ? 1 : 0;

$foto_name = '';
if (!empty($_FILES['foto']['name']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
  $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
  $foto_tmp  = $_FILES['foto']['tmp_name'];
  $foto_ext  = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

  if (in_array($foto_ext, $allowed_ext)) {
    $foto_name = time() . "_" . uniqid() . "." . $foto_ext;
    move_uploaded_file($foto_tmp, "uploads/" . $foto_name);
  } else {
    $_SESSION['notif'] = "❌ Format gambar tidak didukung.";
    header("Location: masyarakat.php");
    exit();
  }
}

// Simpan data ke database
$stmt = $conn->prepare("INSERT INTO pengaduan 
(id_user, klasifikasi, judul, isi, tanggal, lokasi, instansi, kategori, foto, anonim, rahasia) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if ($stmt) {
  $stmt->bind_param("issssssssii",
    $id_user, $klasifikasi, $judul, $isi, $tanggal, $lokasi,
    $instansi, $kategori, $foto_name, $anonim, $rahasia
  );

  if ($stmt->execute()) {
    $_SESSION['notif'] = "✅ Laporan berhasil dikirim!";
  } else {
    $_SESSION['notif'] = "❌ Gagal menyimpan laporan: " . $stmt->error;
  }

  $stmt->close();
} else {
  $_SESSION['notif'] = "❌ Terjadi kesalahan saat mempersiapkan query.";
}

$conn->close();
header("Location: masyarakat.php");
exit();
?>
