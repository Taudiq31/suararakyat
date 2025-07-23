<?php
require('fpdf/fpdf.php');
include '../koneksi.php';

$id = $_GET['id'] ?? 0;

$query = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Laporan Pengaduan', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, 'Judul:', 0, 0);
$pdf->Cell(0, 10, $data['judul'], 0, 1);

$pdf->Cell(50, 10, 'Tanggal:', 0, 0);
$pdf->Cell(0, 10, $data['tanggal'], 0, 1);

$pdf->Cell(50, 10, 'Isi:', 0, 0);
$pdf->MultiCell(0, 10, $data['isi']);

$pdf->Cell(50, 10, 'Status:', 0, 0);
$pdf->Cell(0, 10, $data['status'], 0, 1);

$pdf->Output();
?>