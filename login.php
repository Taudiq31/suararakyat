<?php
session_start();
require 'koneksi.php';

// Cek apakah sudah login
if (isset($_SESSION['id'])) {
  header("Location: masyarakat.php");
  exit();
}

$error = "";

// Jika form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"] ?? '';
  $password = $_POST["password"] ?? '';

  // Cek ke database
  $stmt = $conn->prepare("SELECT * FROM masyarakat WHERE email = ? AND password = ?");
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    $_SESSION["id"] = $user["id"];
    $_SESSION["nama"] = $user["nama"];
    header("Location: masyarakat.php");
    exit();
  } else {
    $error = "Email atau password salah!";
  }

  $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Login - Suara Rakyat</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-red-600 min-h-screen flex items-center justify-center">
  <div class="bg-white p-8 rounded shadow max-w-md w-full">
    <h2 class="text-2xl font-bold text-red-700 text-center mb-4">Login Masyarakat</h2>

    <?php if (!empty($error)): ?>
      <div class="bg-red-100 text-red-700 border border-red-400 p-3 rounded mb-4">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <input type="email" name="email" placeholder="Email" required class="w-full border rounded p-2" />
      <input type="password" name="password" placeholder="Kata Sandi" required class="w-full border rounded p-2" />
      <button type="submit" class="w-full bg-red-600 text-white font-semibold py-2 rounded hover:bg-red-700">Masuk</button>
      <p class="text-sm text-center mt-2">Belum punya akun? <a href="register.php" class="text-red-600">Daftar</a></p>
    </form>
  </div>
</body>
</html>
