<?php
require('fpdf/fpdf.php');
include 'koneksi.php';

// Buat PDF
$pdf = new FPDF();
$pdf->AddPage();

// Tanggal cetak
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, 'Dicetak pada: ' . date('d-m-Y'), 0, 1, 'R');
$pdf->Ln(5);

// Judul
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'LAPORAN PENGADUAN', 0, 1, 'C');
$pdf->Ln(5);

// Header Tabel
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(220, 53, 69); // merah ala Tailwind
$pdf->SetTextColor(255);
$pdf->Cell(10, 10, 'No', 1, 0, 'C', true);
$pdf->Cell(50, 10, 'Judul', 1, 0, 'C', true);
$pdf->Cell(90, 10, 'Isi Laporan', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Status', 1, 1, 'C', true);

// Isi Tabel
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0);
$no = 1;
$query = mysqli_query($conn, "SELECT * FROM pengaduan ORDER BY tanggal DESC");
while ($row = mysqli_fetch_assoc($query)) {
    $pdf->Cell(10, 10, $no++, 1, 0, 'C');
    $pdf->Cell(50, 10, substr($row['judul'], 0, 30), 1, 0);
    $pdf->Cell(90, 10, substr($row['isi'], 0, 60), 1, 0);
    $pdf->Cell(40, 10, $row['status'], 1, 1);
}

// Footer tanda tangan
$pdf->Ln(15);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 6, 'Mengetahui,', 0, 1, 'R');
$pdf->Cell(0, 6, 'Admin Suara Rakyat', 0, 1, 'R');
$pdf->Ln(20);
$pdf->Cell(0, 6, '(________________)', 0, 1, 'R');

$pdf->Output();
?>
