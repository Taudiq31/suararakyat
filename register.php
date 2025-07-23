<?php
require 'koneksi.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = $_POST["nama"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $konfirmasi = $_POST["konfirmasi"];

  if ($password !== $konfirmasi) {
    $error = "Kata sandi tidak cocok!";
  } else {
    $cek = mysqli_query($conn, "SELECT * FROM masyarakat WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
      $error = "Email sudah digunakan!";
    } else {
      $simpan = mysqli_query($conn, "INSERT INTO masyarakat (nama, email, password) VALUES ('$nama', '$email', '$password')");
      if ($simpan) {
        $_SESSION["nama"] = $nama;
        header("Location: masyarakat.php");
        exit();
      } else {
        $error = "Gagal mendaftar. Silakan coba lagi.";
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar - Suara Rakyat</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-red-600 min-h-screen flex items-center justify-center">

  <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold text-center text-red-700 mb-6">Daftar Akun SUARA RAKYAT!</h2>

    <?php if (isset($error)) : ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <?= htmlspecialchars($error); ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <input type="text" name="nama" placeholder="Nama Lengkap" required class="w-full p-2 border rounded" />
      <input type="email" name="email" placeholder="Email" required class="w-full p-2 border rounded" />
      <input type="password" name="password" placeholder="Kata Sandi" required class="w-full p-2 border rounded" />
      <input type="password" name="konfirmasi" placeholder="Ulangi Kata Sandi" required class="w-full p-2 border rounded" />
      <button type="submit" class="w-full bg-red-600 text-white font-semibold py-2 rounded">Daftar</button>
      <p class="text-sm text-center mt-2">Sudah punya akun? <a href="login.php" class="text-red-600 font-semibold">Masuk</a></p>
    </form>
  </div>

</body>
</html>
