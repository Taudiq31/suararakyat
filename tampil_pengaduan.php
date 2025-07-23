<?php
include 'koneksi.php';

$sql = "SELECT * FROM pengaduan ORDER BY waktu DESC";
$result = mysqli_query($conn, $sql);

$no = 1;
?>

<table class="table-auto w-full text-sm text-left">
  <thead class="bg-red-700 text-white">
    <tr>
      <th class="px-4 py-2">No</th>
      <th class="px-4 py-2">Judul</th>
      <th class="px-4 py-2">Isi</th>
      <th class="px-4 py-2">Tanggal</th>
      <th class="px-4 py-2">Status</th>
      <th class="px-4 py-2">Tanggapan</th>
      <th class="px-4 py-2">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>       
      <tr class="bg-white border-b">
        <td class="px-4 py-2"><?= $no++ ?></td>
        <td class="px-4 py-2"><?= htmlspecialchars($row['judul']) ?></td>
        <td class="px-4 py-2"><?= htmlspecialchars($row['isi']) ?></td>
        <td class="px-4 py-2"><?= date("d-m-Y", strtotime($row['waktu'])) ?></td>
        <td class="px-4 py-2"><?= htmlspecialchars($row['status']) ?></td>
        <td class="px-4 py-2"><?= $row['tanggapan'] ? htmlspecialchars($row['tanggapan']) : '-' ?></td>
        <td class="px-4 py-2 space-x-1">
          <a href="update_status.php?id=<?= $row['id'] ?>&status=Verifikasi" class="bg-blue-500 text-white px-2 py-1 rounded text-xs">Verifikasi</a>
          <a href="update_status.php?id=<?= $row['id'] ?>&status=Validasi" class="bg-green-500 text-white px-2 py-1 rounded text-xs">Validasi</a>
          <a href="form_tanggapan.php?id=<?= $row['id'] ?>" class="bg-yellow-400 text-black px-2 py-1 rounded text-xs">Tanggapan</a>
          <a href="update_status.php?id=<?= $row['id'] ?>&status=Ditolak" class="bg-gray-500 text-white px-2 py-1 rounded text-xs">Cancel</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
