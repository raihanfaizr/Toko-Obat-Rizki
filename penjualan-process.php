<?php
session_start();
if(!isset($_SESSION['admin'])){
  header("location:login.php");
  die;
}

include('./koneksi.php');

date_default_timezone_set('Asia/Jakarta');

if (isset($_POST['deal'])){
    // data
    $datetime = $_POST['datetime'];
    $total = $_POST['total'];
    $bayar = $_POST['bayar'];
    $kembali = $_POST['kembali'];
    $nama_obat = $_POST['nama_obat'];
    $tgl_kadaluarsa = $_POST['tgl_kadaluarsa'];
    $qty = $_POST['qty'];
    $harga_jual = $_POST['harga_jual'];
    $subtotal_harga_jual = $_POST['subtotal_harga_jual'];
    $pendapatan = $_POST['pendapatan'];

    // nama berkas from datetime
    $dt = explode(" ",$datetime);
    $dt[0] = explode("-",$dt[0]);
    $dt[0] = implode("",$dt[0]);
    $dt[1] = explode(":",$dt[1]);
    $dt[1] = implode("",$dt[1]);
    $nama_berkas = implode("",$dt) . ".pdf";

    // iterasi / banyak data barang yang ingin dijual
    $data = count($nama_obat);
    
    // mulai print ================================================================================== //
    require("./vendor/setasign/fpdf/fpdf.php");

    $pdf=new FPDF();
    $pdf->AddPage();

    // margin
    $pdf->SetLeftMargin(10);
    $pdf->SetRightMargin(10);

    $w = $pdf->GetPageWidth() - 20;  // Width of Current Page
    $h = $pdf->GetPageHeight(); // Height of Current Page

    // header
    $pdf->SetFont('Arial','B',16);
    $pdf->MultiCell(0, 10, 'TOKO OBAT RIZKI', 0, 'C');
    $pdf->MultiCell(0, 10, 'JL RAYA STASIUN BOJONGGEDE', 0, 'C');
    $pdf->SetFont('Arial','',12);
    $pdf->MultiCell(0, 10, $datetime, 'B', 'C');

    // body title
    $pdf->SetFont('Arial','B',12);
    $pdf->MultiCell(0, 3, '');
    $pdf->Cell(($w/12) * 6 , 10, 'Nama Barang', 0, 0, 'C');
    $pdf->Cell(($w/12) * 2 , 10, 'Qty', 0, 0, 'C');
    $pdf->Cell(($w/12) * 2 , 10, 'Harga', 0, 0, 'C');
    $pdf->Cell(($w/12) * 2 , 10, 'Subtotal', 0, 0, 'C');
    $pdf->MultiCell(0, 10, '');
    
    // body
    $pdf->SetFont('Arial','',12);
    for($i = 0; $i<$data; $i++) {
        $pdf->Cell(($w/12) * 6 , 10, '   '.$nama_obat[$i], 0, 0, 'L');
        $pdf->Cell(($w/12) * 2 , 10, $qty[$i], 0, 0, 'C');
        $pdf->Cell(($w/12) * 2 , 10, number_format($harga_jual[$i], 0, "", "."), 0, 0, 'C');
        $pdf->Cell(($w/12) * 2 , 10, number_format($subtotal_harga_jual[$i], 0, "", "."), 0, 0, 'C');
        $pdf->MultiCell(0, 7, '');    
    }

    // total 
    $pdf->SetFont('Arial','B',12);
    $pdf->MultiCell(0, 7, '');
    $pdf->Cell(($w/12) * 9, 10, 'Total', 'T', 0, 'R');
    $pdf->Cell(($w/12) * 1 , 10, '', 'T');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(($w/12) * 2 , 10, $total, 'T', 0, 'C');
    
    // pembayaran
    $pdf->SetFont('Arial','B',12);
    $pdf->MultiCell(0, 7, '');
    $pdf->Cell(($w/12) * 9, 10, 'Pembayaran', '', 0, 'R');
    $pdf->Cell(($w/12) * 1 , 10, '', '');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(($w/12) * 2 , 10, $bayar, '', 0, 'C');

    // Kembali
    $pdf->SetFont('Arial','B',12);
    $pdf->MultiCell(0, 7, '');
    $pdf->Cell(($w/12) * 9, 10, 'Kembali', '', 0, 'R');
    $pdf->Cell(($w/12) * 1 , 10, '', '');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(($w/12) * 2 , 10, $kembali, '', 0, 'C');

    // $new_berkas = './data-transaksi/' . $nama_berkas;
    $pdf->Output('F', './data-transaksi/' . $nama_berkas);
    // end print ================================================================================== //

    // mulai crud database ================================================================================== //
    for ($i = 0; $i < $data; $i++) {
        // insert db log
        $sql1 = "INSERT INTO `log` VALUES ('', '$nama_obat[$i]', '$tgl_kadaluarsa[$i]', '$qty[$i]', 'terjual', '$pendapatan[$i]', '$datetime')";
        $result1 = mysqli_query($conn, $sql1);

        // update stok
        $sql2 = "UPDATE `stok-obat` SET `stok_obat` = `stok_obat` - $qty[$i] WHERE `nama_obat` = '$nama_obat[$i]' AND `tgl_kadaluarsa` = '$tgl_kadaluarsa[$i]'";
        $result2 = mysqli_query($conn, $sql2);
    }

    
    if (mysqli_affected_rows($conn) > 0) {
        // insert db transaksi
        $sql3 = "INSERT INTO `transaksi` VALUES ('', '$datetime', '$nama_berkas')";
        $result3 = mysqli_query($conn, $sql3);
        
        // hapus data di tabel tmp-penjualan
        $sql = "DELETE FROM `tmp-penjualan`";
        $result = mysqli_query($conn, $sql);

        // hapus data stok yang sudah 0
        $sql0 = "DELETE FROM `stok-obat` WHERE `stok_obat` = 0";
        $result0 = mysqli_query($conn, $sql0);

        echo "<script>alert('Pesanan berhasil! Data penjualan akan tersimpan kedalam database');window.location.href='./penjualan.php'</script>";
        die;
    }

    }



?>