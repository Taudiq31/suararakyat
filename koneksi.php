<?php
$host = "sql305.infinityfree.com";         // MySQL Hostname
$user = "if0_39538123";                    // MySQL Username
$pass = "dJCPGyyprtWK5";                   // Ganti dengan password asli (jangan pakai *************)
$db   = "if0_39538123_suara_db";           // Nama database yang terdaftar

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}
?>
