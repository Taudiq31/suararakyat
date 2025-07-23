<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ADMIN: SUARA RAKYAT!</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans">
  <nav class="bg-red-700 text-white px-6 py-3 shadow flex justify-between items-center">
    <div class="flex items-center gap-2">
      <span class="font-bold text-lg">SUARA RAKYAT - ADMIN</span>
    </div>
    <button onclick="logout()" class="bg-white text-red-700 px-3 py-1 rounded hover:bg-gray-100 text-sm font-semibold">Keluar</button>
  </nav>

  <main class="p-6">
    <h2 class="text-2xl font-bold text-red-700 mb-4">Daftar Laporan Pengaduan</h2>
    <div class="overflow-x-auto">
      <table class="w-full bg-white rounded shadow text-sm">
        <thead class="bg-red-600 text-white">
          <tr>
            <th class="p-2 text-left">No</th>
            <th class="p-2 text-left">Judul</th>
            <th class="p-2 text-left">Isi</th>
            <th class="p-2 text-left">Tanggal</th>
            <th class="p-2 text-left">Status</th>
            <th class="p-2 text-left">Tanggapan</th>
            <th class="p-2 text-left">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            include 'koneksi.php';
            $no = 1;
            $sql = mysqli_query($conn, "SELECT * FROM pengaduan ORDER BY tanggal DESC");
            while ($data = mysqli_fetch_assoc($sql)) {
              echo "<tr class='border-b'>";
              echo "<td class='p-2'>" . $no++ . "</td>";
              echo "<td class='p-2'>" . htmlspecialchars($data['judul']) . "</td>";
              echo "<td class='p-2'>" . htmlspecialchars($data['isi']) . "</td>";
              echo "<td class='p-2'>" . date('d-m-Y', strtotime($data['tanggal'])) . "</td>";
              echo "<td class='p-2'>" . htmlspecialchars($data['status']) . "</td>";
              echo "<td class='p-2'>" . ($data['tanggapan'] ? htmlspecialchars($data['tanggapan']) : '-') . "</td>";
              echo "<td class='p-2 space-x-1'>";

              // Tombol Hapus
              echo "<a href='hapus_pengaduan.php?id=" . $data['id'] . "' onclick='return confirm(\"Yakin ingin menghapus?\")' class='bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs'>Hapus</a> ";

              // Jika belum ada tanggapan → tampilkan tombol Tanggapi
              if (empty($data['tanggapan'])) {
                echo "<a href='form_tanggapan.php?id=" . $data['id'] . "' class='bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs'>Tanggapi</a>";
              } else {
                // Jika sudah ada tanggapan → tampilkan tombol PDF
                echo "<a href='cetak_pengaduan.php?id=" . $data['id'] . "' target='_blank' class='bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs'>PDF</a>";
              }

              echo "</td></tr>";
            }
          ?>
        </tbody>
      </table>
    </div>
  </main>

  <script>
    function logout() {
      alert("Anda telah keluar.");
      window.location.href = 'login.html';
    }
  </script>
</body>
</html>
