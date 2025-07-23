<?php
include 'koneksi.php';
$result = mysqli_query($conn, "SELECT * FROM pengaduan ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PETUGAS: SUARA RAKYAT!</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans">

  <!-- SIDEBAR -->
  <aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-red-700 text-white shadow-lg z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
    <div class="flex items-center justify-between p-4 font-bold text-xl border-b border-red-500">
      SUARA RAKYAT
      <button id="closeSidebar" class="md:hidden text-white">&times;</button>
    </div>
    <nav class="mt-4 space-y-2">
      <a href="#" class="block px-4 py-2 hover:bg-red-600">Dashboard</a>
    </nav>
    <div class="absolute bottom-4 w-full px-4">
      <button onclick="logout()" class="w-full bg-white text-red-700 py-2 rounded hover:bg-gray-100 font-semibold">
        Keluar
      </button>
    </div>
  </aside>

  <!-- NAVBAR -->
  <nav id="navbar" class="bg-red-700 text-white px-6 py-3 shadow flex justify-between items-center md:ml-64 hidden">
    <div class="flex items-center gap-2">
      <button id="toggleSidebar" class="md:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
      <span class="font-bold text-lg">SUARA RAKYAT - <span id="dashboardTitle">PETUGAS</span></span>
    </div>
    <span id="userRole" class="text-sm font-medium"></span>
  </nav>

  <!-- LOGIN FORM -->
  <div id="login-form" class="bg-white p-8 rounded shadow-md w-full max-w-sm mx-auto mt-24">
    <h2 class="text-2xl font-bold mb-6 text-center text-red-700">Login Petugas</h2>
    <div class="mb-4">
      <label class="block mb-1 font-semibold">Username</label>
      <input id="username" type="text" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-red-300" />
    </div>
    <div class="mb-6">
      <label class="block mb-1 font-semibold">Password</label>
      <input id="password" type="password" class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:ring-red-300" />
    </div>
    <button onclick="login()" class="bg-red-600 text-white w-full py-2 rounded hover:bg-red-700 font-semibold">Masuk</button>
  </div>

  <!-- DASHBOARD -->
  <div id="dashboard" class="hidden md:ml-64">
    <main class="p-6">
      <h2 class="text-2xl font-bold text-red-700 mb-4">Daftar Laporan Masuk</h2>

      <!-- TABEL DARI DATABASE -->
      <div class="overflow-x-auto bg-white rounded shadow p-4">
        <table class="w-full text-sm">
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
          <tbody class="divide-y divide-gray-200">
            <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td class="p-2"><?= $no++ ?></td>
                <td class="p-2"><?= htmlspecialchars($row['judul']) ?></td>
                <td class="p-2"><?= htmlspecialchars($row['isi']) ?></td>
                <td class="p-2"><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
                <td class="p-2"><?= htmlspecialchars($row['status'] ?? '-') ?></td>
                <td class="p-2"><?= htmlspecialchars($row['tanggapan'] ?? '-') ?></td>
                <td class="p-2 space-x-1">
                  <button onclick="bukaFormTanggapan(<?= $row['id'] ?>, '<?= htmlspecialchars($row['judul']) ?>', '<?= htmlspecialchars($row['isi']) ?>', '<?= htmlspecialchars($row['tanggapan']) ?>', '<?= $row['status'] ?>')" class="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs">Tanggapan</button>
                  <a href="update_status.php?id=<?= $row['id'] ?>&status=verifikasi" class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs">Verifikasi</a>
                  <a href="update_status.php?id=<?= $row['id'] ?>&status=validasi" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-xs">Validasi</a>
                  <a href="update_status.php?id=<?= $row['id'] ?>&status=cancel" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">Cancel</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>

  <!-- MODAL FORM TANGGAPAN -->
  <div id="tanggapanModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
      <h3 class="text-xl font-bold mb-4" id="modalJudul">Tanggapan</h3>
      <p><strong>Isi Laporan:</strong> <span id="modalIsi"></span></p>
      <form method="POST" action="update_tanggapan.php">
        <input type="hidden" name="id" id="modalId">
        <textarea name="tanggapan" id="modalTanggapan" class="w-full border mt-2 p-2 rounded" placeholder="Tanggapan..." required></textarea>
        <select name="status" id="modalStatus" class="w-full border mt-2 p-2 rounded">
          <option value="Belum Diproses">Belum Diproses</option>
          <option value="Diproses">Diproses</option>
          <option value="Selesai">Selesai</option>
        </select>
        <div class="mt-4 flex justify-end gap-2">
          <button type="button" onclick="tutupFormTanggapan()" class="bg-gray-400 text-white px-4 py-1 rounded">Batal</button>
          <button type="submit" class="bg-red-600 text-white px-4 py-1 rounded">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- SCRIPT -->
  <script>
    const loginForm = document.getElementById("login-form");
    const dashboard = document.getElementById("dashboard");
    const navbar = document.getElementById("navbar");
    const sidebar = document.getElementById("sidebar");

    document.addEventListener("DOMContentLoaded", () => {
      const role = localStorage.getItem("loginRole");
      if (role === "petugas") {
        tampilDashboard(role);
      } else {
        tampilLogin();
      }
    });

    function login() {
      const username = document.getElementById("username").value.trim();
      const password = document.getElementById("password").value.trim();
      if (username === "petugas" && password === "123") {
        localStorage.setItem("loginRole", "petugas");
        tampilDashboard("petugas");
      } else {
        alert("Username atau password salah.");
      }
    }

    function logout() {
      localStorage.removeItem("loginRole");
      tampilLogin();
    }

    function tampilLogin() {
      loginForm.style.display = "block";
      dashboard.style.display = "none";
      navbar.style.display = "none";
    }

    function tampilDashboard(role) {
      document.getElementById("userRole").textContent = `Login sebagai: ${role.toUpperCase()}`;
      document.getElementById("dashboardTitle").textContent = "PETUGAS";
      loginForm.style.display = "none";
      dashboard.style.display = "block";
      navbar.style.display = "flex";
    }

    function bukaFormTanggapan(id, judul, isi, tanggapan, status) {
      document.getElementById('modalId').value = id;
      document.getElementById('modalJudul').textContent = `Tanggapan untuk: ${judul}`;
      document.getElementById('modalIsi').textContent = isi;
      document.getElementById('modalTanggapan').value = tanggapan;
      document.getElementById('modalStatus').value = status;
      document.getElementById('tanggapanModal').classList.remove('hidden');
    }

    function tutupFormTanggapan() {
      document.getElementById('tanggapanModal').classList.add('hidden');
    }

    document.getElementById("toggleSidebar")?.addEventListener("click", () => {
      sidebar.classList.remove("-translate-x-full");
      sidebar.classList.add("translate-x-0");
    });

    document.getElementById("closeSidebar")?.addEventListener("click", () => {
      sidebar.classList.add("-translate-x-full");
    });

    document.addEventListener("click", (e) => {
      if (!sidebar.contains(e.target) && !document.getElementById("toggleSidebar").contains(e.target) && window.innerWidth < 768) {
        sidebar.classList.add("-translate-x-full");
      }
    });
  </script>
</body>
</html>
