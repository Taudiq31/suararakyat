<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
  echo "ID tidak ditemukan!";
  exit;
}

$id = intval($_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id = $id");

if (!$query || mysqli_num_rows($query) == 0) {
  echo "Data tidak ditemukan!";
  exit;
}

$data = mysqli_fetch_assoc($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $tanggapan = mysqli_real_escape_string($conn, $_POST['tanggapan']);
  $status = mysqli_real_escape_string($conn, $_POST['status']);

  $update = mysqli_query($conn, "UPDATE pengaduan SET tanggapan='$tanggapan', status='$status' WHERE id=$id");

  if ($update) {
    echo "<script>alert('Tanggapan berhasil disimpan.'); window.location.href='admin.php';</script>";
  } else {
    echo "Gagal menyimpan tanggapan.";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Tanggapan</title>
  <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="bg-white p-8 rounded shadow w-full max-w-lg">
    <h2 class="text-2xl font-bold mb-4 text-red-700">Tanggapan untuk: <?= htmlspecialchars($data['judul']) ?></h2>
    <form method="POST">
      <div class="mb-4">
        <label class="block mb-1 font-semibold">Isi Laporan:</label>
        <p class="bg-gray-100 p-2 rounded"><?= nl2br(htmlspecialchars($data['isi'])) ?></p>
      </div>
      <div class="mb-4">
        <label class="block mb-1 font-semibold">Tanggapan:</label>
        <textarea name="tanggapan" class="w-full p-2 border rounded"><?= htmlspecialchars($data['tanggapan']) ?></textarea>
      </div>
      <div class="mb-4">
        <label class="block mb-1 font-semibold">Status:</label>
        <select name="status" class="w-full p-2 border rounded">
          <option value="Belum Diproses" <?= $data['status'] === 'Belum Diproses' ? 'selected' : '' ?>>Belum Diproses</option>
          <option value="Diproses" <?= $data['status'] === 'Diproses' ? 'selected' : '' ?>>Diproses</option>
          <option value="Selesai" <?= $data['status'] === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
        </select>
      </div>
      <div class="flex justify-end">
        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 font-semibold">Simpan</button>
      </div>
    </form>
  </div>
</body>
</html>
