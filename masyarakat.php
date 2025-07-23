<?php
session_start();
include 'koneksi.php';

// Cek apakah sudah login
if (!isset($_SESSION['id']) || !isset($_SESSION['nama'])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SUARA RAKYAT!</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-red-600 min-h-screen font-sans">

  <!-- HEADER -->
  <header class="w-full bg-red-700 p-4 text-white flex justify-between items-center shadow">
    <div class="text-2xl font-bold">SUARA RAKYAT!</div>
    <div>
      <span class="mr-4">Halo, <?= htmlspecialchars($_SESSION['nama']); ?>!</span>
      <a href="logout.php" class="bg-white text-red-700 font-semibold px-4 py-2 rounded">Logout</a>
    </div>
  </header>

  <!-- NOTIFIKASI -->
  <?php if (isset($_SESSION['notif'])): ?>
    <div id="notifBox" class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4 max-w-xl mx-auto mt-4 text-center">
      <?= htmlspecialchars($_SESSION['notif']); ?>
    </div>
    <script>
      setTimeout(() => {
        const box = document.getElementById('notifBox');
        if (box) box.style.display = 'none';
      }, 4000);
    </script>
    <?php unset($_SESSION['notif']); ?>
  <?php endif; ?>

  <!-- FORM PENGADUAN -->
  <section class="flex flex-col items-center text-white py-10">
    <h1 class="text-3xl font-bold mb-2 text-center">Pusat Layanan Pengaduan dan Aspirasi Rakyat Indonesia</h1>
    <p class="mb-6 text-center">Sampaikan laporan Anda langsung kepada instansi pemerintah berwenang</p>

    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl text-black">
      <h2 class="text-xl font-bold mb-4">Sampaikan Laporan Anda</h2>
      <form action="simpan_pengaduan.php" method="POST" enctype="multipart/form-data" class="space-y-4">

        <!-- Klasifikasi -->
        <div class="flex gap-4">
          <label><input type="radio" name="klasifikasi" value="Pengaduan" class="accent-red-600" checked> <span class="ml-2">Pengaduan</span></label>
          <label><input type="radio" name="klasifikasi" value="Aspirasi" class="accent-red-600"> <span class="ml-2">Aspirasi</span></label>
          <label><input type="radio" name="klasifikasi" value="Permintaan Informasi" class="accent-red-600"> <span class="ml-2">Permintaan Informasi</span></label>
        </div>

        <!-- Judul dan Isi -->
        <input type="text" name="judul" placeholder="Judul Laporan *" class="w-full border rounded p-2" required />
        <textarea name="isi" placeholder="Isi Laporan *" class="w-full border rounded p-2" rows="4" required></textarea>

        <!-- Tanggal dan Lokasi -->
        <div class="grid md:grid-cols-2 gap-4">
          <input type="date" name="tanggal" class="w-full border rounded p-2" required />
          <input type="text" name="lokasi" placeholder="Lokasi Kejadian *" class="w-full border rounded p-2" required />
        </div>

        <!-- Instansi -->
        <select name="instansi" class="w-full border rounded p-2" required>
          <option value="">Pilih Instansi Tujuan *</option>
          <option value="kepolisian">Kepolisian Negara Republik Indonesia (POLRI)</option>
          <option value="kpk">Komisi Pemberantasan Korupsi (KPK)</option>
          <option value="kemendagri">Kementerian Dalam Negeri (Kemendagri)</option>
          <option value="kemenag">Kementerian Agama (Kemenag)</option>
          <option value="bpn">Badan Pertanahan Nasional (BPN)</option>
        </select>

        <!-- Kategori -->
        <select name="kategori" class="w-full border rounded p-2">
          <option value="">Pilih Kategori Laporan</option>
          <option value="kriminalitas">Kriminalitas / Keamanan</option>
          <option value="korupsi">Korupsi</option>
          <option value="kesehatan">Pelayanan Kesehatan / BPJS</option>
          <option value="sosial">Bantuan Sosial / Kesejahteraan</option>
          <option value="pemerintahan">Pungli / Pelayanan Pemerintah Daerah</option>
        </select>

        <!-- Upload Foto -->
        <input type="file" name="foto" class="w-full border rounded p-2" />

        <!-- Checkbox -->
        <div class="flex items-center space-x-4">
          <label><input type="checkbox" name="anonim" class="mr-2"> Anonim</label>
          <label><input type="checkbox" name="rahasia" class="mr-2"> Rahasia</label>
        </div>

        <!-- Tombol -->
        <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded font-semibold w-full">Lapor</button>
      </form>
    </div>
  </section>

</body>
</html>
