<?php
session_start();
if(!isset($_SESSION['admin'])){
  header("location:login.php");
  die;
}

include('./koneksi.php');

date_default_timezone_set('Asia/Jakarta');
function my_getdate(){
  return date("Y-m-d H:i:s");
}

function select_sjgk($table, $name, $value = ''){
  global $conn;
  $sql = "SELECT * FROM `$table`";
  $result = mysqli_query($conn,$sql);
  $out = "<option value='$value'>$name</option>";

  while($row = mysqli_fetch_array($result)){
    $out = $out . "<option value='$row[1]'>$row[1]</option>";
  }

  return $out;
}

function stok_obat($table, $name, $value = ''){
  global $conn;
  $sql = "SELECT * FROM `$table`";
  $result = mysqli_query($conn,$sql);
  $out = "<option value='$value'>$name</option>";

  while($row = mysqli_fetch_array($result)){
    $out = $out . "<option value='$row[1]'>$row[1] ($row[2])</option>";
  }

  return $out;
}

function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

// update data obat yang sudah kadaluarsa
$tgl_now = date("Y-m-d");
$sqlk = "UPDATE `stok-obat` SET `status` = 'kadaluarsa' WHERE `tgl_kadaluarsa` < '$tgl_now'";
$resultk = mysqli_query($conn, $sqlk);

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <!-- <link rel="icon" type="image/png" href="./assets/img/favicon.png"> -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Toko Obat
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="./assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <!-- fontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- DataTables -->
  <link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet">
  <!-- Selectize -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
    integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />

  <!-- inside css -->
  <style>
    .selectize-control.single .selectize-input, .selectize-dropdown.single{
      background-image: none;
      padding: .375rem .75rem;
      background-color: #FFFFFF;
      border-radius: 4px;
      border-color: #343a40!important;
    }

    .selectize-dropdown, .selectize-input, .selectize-input input {
      font-size: 14px;
    }

    .selectize-dropdown .active:not(.selected) {
        background: cadetblue;
        color: #fff;
    }
  </style>
</head>

<body class="">
<div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
      <div class="logo">
        
        <a href="" class="simple-text logo-normal ml-2">
          Toko Obat Rizki
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <p class="ml-4 text-secondary"><b>Info</b></p>
          <li class="<?=$page == 'index' ? 'active' : ''?>">
            <a href="./index.php">
              <i class="nc-icon nc-bank"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <p class="ml-4 mt-2 text-secondary"><b>Barang & Stok</b></p>
          <li class="<?=$page == 'add-barang' ? 'active' : ''?>">
            <a href="./add-barang.php">
              <i class="nc-icon nc-tile-56"></i>
              <p>Tambah Obat</p>
            </a>
          </li>
          <li class="<?=$page == 'add-stok' ? 'active' : ''?>">
            <a href="./add-stok.php">
              <i class="nc-icon nc-box"></i>
              <p>Tambah Stok</p>
            </a>
          </li>
          <li class="<?=$page == 'obat-bermasalah' ? 'active' : ''?>">
            <a href="./obat-bermasalah.php">
              <i class="nc-icon nc-basket"></i>
              <p>
                Obat Bermasalah 
                <?php
                  $sql = "SELECT COUNT(`nama_obat`) AS nama_obat FROM `stok-obat` WHERE `status` <> 'tersedia'";
                  $result = mysqli_query($conn,$sql);
                  while($row = mysqli_fetch_assoc($result)){
                    $jumlah = $row['nama_obat'];
                  }
                  if ($jumlah > 0) {
                    echo "<span class='badge badge-danger ml-1'>$jumlah</span>";
                  }
                ?>
              </p>
            </a>
          </li>
          <li class="<?=$page == 'transaksi' ? 'active' : ''?>">
            <a href="./transaksi.php">
              <i class="nc-icon nc-single-copy-04"></i>
              <p>Transaksi</p>
            </a>
          </li>
          <li class="<?=$page == 'log' ? 'active' : ''?>">
            <a href="./log.php">
              <i class="nc-icon nc-bullet-list-67"></i>
              <p>Log</p>
            </a>
          </li>
          <p class="ml-4 mt-2 text-secondary"><b>Jenis, Golongan & Kategori</b></p>
          <li class="<?=$page == 'satuan-obat' ? 'active' : ''?>">
            <a href="./satuan-obat.php">
              <i class="nc-icon nc-app"></i>
              <p>Satuan Obat</p>
            </a>
          </li>
          <li class="<?=$page == 'jenis-obat' ? 'active' : ''?>">
            <a href="./jenis-obat.php">
              <i class="nc-icon nc-app"></i>
              <p>Jenis Obat</p>
            </a>
          </li>
          <li class="<?=$page == 'golongan-obat' ? 'active' : ''?>">
            <a href="./golongan-obat.php">
              <i class="nc-icon nc-app"></i>
              <p>Golongan Obat</p>
            </a>
          </li>
          <li class="<?=$page == 'kategori-obat' ? 'active' : ''?>">
            <a href="./kategori-obat.php">
              <i class="nc-icon nc-app"></i>
              <p>Kategori Obat</p>
            </a>
          </li>
          <p class="ml-4 mt-2 text-secondary"><b>Halaman Penjualan</b></p>
          <li class="<?=$page == 'penjualan' ? 'active' : ''?>">
            <a href="./penjualan.php">
              <i class="nc-icon nc-bag-16"></i>
              <p>Penjualan</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:;">Aplikasi Penjualan dan Inventaris Toko Obat</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="nc-icon nc-circle-10"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="./user.php"><i class="nc-icon nc-single-02"></i> User</a>
                  <a class="dropdown-item" href="./logout.php"><i class="nc-icon nc-button-power"></i> Logout</a>
                  <!-- <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a> -->
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->