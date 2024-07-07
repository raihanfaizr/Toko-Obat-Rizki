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


// Data Persiapan
$sql = "SELECT SUM(subtotal_harga_jual) AS total FROM `tmp-penjualan`";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_assoc($result)){
  $total = number_format($row['total'],0,"",".");
  $total_value = $row['total'];
}

// Submit Form
if(isset($_POST['add-barang'])){
  $nb = $_POST['nama-barang'];
  $qty = $_POST['qty'];

  $data_baru = explode('|', $nb);
  $tgl_kadaluarsa = $data_baru[0];
  $nama_barang = $data_baru[1];

  $sql = "SELECT * FROM `obat` WHERE nama_obat = '$nama_barang'";
  $result = mysqli_query($conn, $sql);
  while($row = mysqli_fetch_assoc($result)){
    $harga_jual = $row['harga_jual'];
    $harga_beli = $row['harga_beli'];
  }

  $subtotal_beli = $harga_beli * $qty;
  $subtotal_jual = $harga_jual * $qty;

  $sql = "INSERT INTO `tmp-penjualan` VALUES ('', '$tgl_kadaluarsa', '$nama_barang', '$qty', '$harga_beli', '$harga_jual', '$subtotal_beli', '$subtotal_jual')";
  $result = mysqli_query($conn, $sql);

  header("location:./penjualan.php");
  die;
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $sql = "DELETE FROM `tmp-penjualan` WHERE `id_tmp_penjualan` = '$id'";
  $result = mysqli_query($conn, $sql);

  header("location:./penjualan.php");
  die;
}

if (isset($_GET['batal'])) {
  $sql = "DELETE FROM `tmp-penjualan`";
  $result = mysqli_query($conn, $sql);

  header("location:./penjualan.php");
  die;
}

if (isset($_POST['validasi'])) {
  if ($total == 0 || $_POST['bayar'] == "") {
    header("location:./penjualan.php");
    die;
  }
  $bayar_value = $_POST['bayar'];
  $bayar = number_format($bayar_value,0,"",".");

  if ($bayar_value < $total_value) {
    echo "<script>alert('Uang yang dibayarkan kurang. Tidak dapat melakukan pemesanan');window.location.href='./penjualan.php'</script>";
    die;
  }else{
    $muncul = "true";
  }
}

// if (isset($_POST['deal'])) {
//   $datetime = $_POST['datetime'];
//   $nama_obat = $_POST['nama_obat'];
//   $tgl_kadaluarsa = $_POST['tgl_kadaluarsa'];
//   $qty = $_POST['qty'];
//   $pendapatan = $_POST['pendapatan'];

//   $data = count($nama_obat);

//   for($i = 0; $i<$data; $i++) {
//     $sql1 = "INSERT INTO `log` VALUES ('', '$nama_obat[$i]', '$tgl_kadaluarsa[$i]', '$qty[$i]', 'terjual', '$pendapatan[$i]', '$datetime')";
//     $result1 = mysqli_query($conn, $sql1);

//     $sql2 = "UPDATE `stok-obat` SET `stok_obat` = `stok_obat` - $qty[$i] WHERE `nama_obat` = '$nama_obat[$i]' AND `tgl_kadaluarsa` = '$tgl_kadaluarsa[$i]'";
//     $result2 = mysqli_query($conn, $sql2);
//   }

//   if (mysqli_affected_rows($conn) > 0) {
//     // hapus data di tabel tmp-penjualan
//     $sql = "DELETE FROM `tmp-penjualan`";
//     $result = mysqli_query($conn, $sql);

//     // hapus data stok yang sudah 0
//     $sql0 = "DELETE FROM `stok-obat` WHERE `stok_obat` = 0";
//     $result0 = mysqli_query($conn, $sql0);

//     echo "<script>alert('Pesanan berhasil! Data penjualan akan tersimpan kedalam database');window.location.href='./penjualan.php'</script>";
//     die;
//   }
// }

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
  <!-- TomSelect -->
  <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
  <style>
    .ts-control{
      border: solid 1px black;
      height: 30px;
      padding: 6px 12px;
    }

    .ts-dropdown .active{
      background-color:cadetblue;
      color: #fff;
    }

    /* print by web browser */
    /* .print{
      display: none;
    }

    @media print{
      .wrapper{
        display: none!important;
      }

      .show{
        background-color: rgb(255, 255, 255, 0);
      }

      .print{
        font-family: Arial, Helvetica, sans-serif!important;
        color: black!important;
        display: block;
      }
    } */
  </style>
</head>

<body>
<!-- print by web browser -->
<!-- <div class="print">
  <div class="row"> -->
    <!-- Header -->
    <!-- <div class="col-12 text-center"><h2>TOKO OBAT RIZKI</h2></div>
    <div class="col-12 text-center"><h2>JL RAYA STASIUN BOJONGGEDE</h2></div>
    <hr class="w-100" style="border: solid 1px black;">

    <div class="col-6"><h4><b>Barang</b></h4></div>
    <div class="col-2 text-center"><h4><b>Qty</b></h4></div>
    <div class="col-2 text-center"><h4><b>Harga</b></h4></div>
    <div class="col-2 text-center"><h4><b>Subtotal</b></h4></div> -->
    <!-- End Header -->

    <!-- Barang -->
    <!-- <div class="col-6"><h4 class="my-1">Panadol</h4></div>
    <div class="col-2 text-center"><h4 class="my-1">3</h4></div>
    <div class="col-2 text-center"><h4 class="my-1">15.000</h4></div>
    <div class="col-2 text-center"><h4 class="my-1">45.000</h4></div>

    <div class="col-6"><h4 class="my-1">Panadol</h4></div>
    <div class="col-2 text-center"><h4 class="my-1">2</h4></div>
    <div class="col-2 text-center"><h4 class="my-1">15.000</h4></div>
    <div class="col-2 text-center"><h4 class="my-1">4.500.000</h4></div> -->
    <!-- End Barang -->
    
    <!-- <hr class="w-100" style="border: solid 1px black;">
    <div class="col-10 text-right pr-5"><h4 class="my-1"><b>Total</b></h4></div>
    <div class="col-2 text-center"><h4 class="my-1">4.500.000</h4></div>
    
    <div class="col-10 text-right pr-5"><h4 class="my-1"><b>Pembayaran</b></h4></div>
    <div class="col-2 text-center"><h4 class="my-1">4.500.000</h4></div>
    
    <div class="col-10 text-right pr-5"><h4 class="my-1"><b>Kembali</b></h4></div>
    <div class="col-2 text-center"><h4 class="my-1">4.500.000</h4></div>

  </div>
</div> -->
<div class="wrapper ">
    
    <div class="main-panel w-100">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;">Aplikasi Penjualan dan Inventaris Toko Obat</a>
          </div>
          
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <li class="nav-item btn-rotate dropdown">
                <a class="nav-link btn btn-sm btn-danger" href="./index.php">
                  <i class="nc-icon nc-bank"></i> Dashboard
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content" style="min-height: 80vh;">
        <div class="row">
          <div class="col-8">
            <div class="card card-stats">
            <div class="card-header">
                <h5 class="card-title">Tambah Barang</h5>
                <form action="" method="post">
                  <div class="row">
                    <div class="col-7">
                      Masukan nama barang :
                      <select name="nama-barang" id="nama-barang" autofocus required>
                        <option value="">Cari Barang</option>
                        <?php
                          $no = 1;
                          $sql = "SELECT * FROM `stok-obat` WHERE `status` = 'tersedia' AND `stok_obat` <> 0 ORDER BY tgl_kadaluarsa";
                          $result = mysqli_query($conn, $sql);
                          while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <option value="<?=$row['tgl_kadaluarsa'].'|'.$row['nama_obat']?>">
                          <?=$row['tgl_kadaluarsa'].' | '.$row['nama_obat'].' ('.$row['stok_obat'].')'?>
                        </option>
                        <?php
                          $no++;
                          };
                        ?>
                      </select>
                      <script>new TomSelect('#nama-barang',{create:false});</script>
                    </div>
                    <div class="col-3">
                      Jumlah : 
                      <input class="form-control border-dark" type="number" min="1" max="1000" name="qty" value="1">
                    </div>
                    <div class="col-2 mt-2 text-center">
                      <button class="btn btn-success" type="submit" name="add-barang">Add</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="card-body pt-0">
                <hr>
                <table class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th class="text-center">Nama Barang</th>
                      <th class="text-center">Jumlah</th>
                      <th class="text-center">Harga</th>
                      <th class="text-center">Subtotal</th>
                      <th style="width: 150px;"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $sql = "SELECT * FROM `tmp-penjualan`";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <tr>
                      <td><?=$no?></td>
                      <td><?=$row['nama_obat']?></td>
                      <td class="text-center"><?=$row['qty']?></td>
                      <td class="text-center"><?=number_format($row['harga_jual'],0,"",".")?></td>
                      <td class="text-center"><?=number_format($row['subtotal_harga_jual'],0,"",".")?></td>
                      <td class="text-center">
                        <a href="./penjualan.php?id=<?=$row['id_tmp_penjualan']?>" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></a>
                      </td>
                    </tr>
                    <?php
                    $no++;
                    };
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-4">
            <div class="card card-stats p-4 bg-dark">
              <div class="row">
                <h4 class="col-4 m-0 text-light text-right"><b>Total :</b></h4>
                <div class="col-2 text-secondary text-right text-light">Rp.</div>
                <div class="col-6 text-secondary">
                  <h3 class="m-0 text-light"><?=$total?></h3>
                </div>
              </div>
            </div>
            <div class="card card-stats">

              <form action="" method="post" class="m-4">
                <p style="font-size: 16px;"><i class="nc-icon nc-money-coins mr-2" style="font-size: 20px;"></i><b>Pembayaran</b></p>
                <div class="row justify-content-center">
                  <div class="col-2">
                    <input type="text" class="form-control" disabled value="Rp." style="width: 100%;">
                  </div>
                  <div class="col-10 pl-0">
                    <input type="text" name="bayar" class="form-control border-dark px-2" placeholder="Masukan Nominal" autocomplete="off"><br>
                  </div>
                  <div class="col-6">
                    <button type="button" class="btn btn-outline-danger" style="width: 100%;" data-toggle="modal" data-target="#batalkan">
                      Batalkan
                    </button>
                  </div>
                  <div class="col-6">
                    <button type="submit" name="validasi" class="btn btn-primary" style="width: 100%; border: solid 2px #51cbce;">
                      Bayar
                    </button>
                  </div>
                </div>
              </form>

              <!-- Modal Batalkan -->
              <div class="modal fade" id="batalkan" tabindex="-1" role="dialog" aria-labelledby="batalkanTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Batalkan Pesanan</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <P>Apakah anda yakin ingin membatalkan pesanan?. Data ini akan dihapus dan tidak dapat dikembalikan</P>
                    </div>
                    <div class="modal-footer">
                      <a href="./penjualan.php?batal=true" class="btn btn-danger mr-4">Batalkan</a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Modal Bayar -->
              <div class="modal fade" id="bayar" tabindex="-1" role="dialog" aria-labelledby="bayarTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header border-dark">
                      <h5 class="modal-title" id="exampleModalLongTitle">Detail Pesanan</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="row">
                        <?php
                          $datetime = date("Y-m-d H:i:s");
                        ?>
                        <div class="col-12 mb-0"><b>Waktu : </b><?=$datetime?></div>
                        <div class="col-12"><hr class="border-dark mb-2 mt-2" style="width: 100%;"></div>

                        <div class="col-6 mb-2 text-center"><b>Barang</b></div>
                        <div class="col-2 mb-2 text-center"><b>Qty</b></div>
                        <div class="col-4 mb-2 text-center"><b>Subtotal</b></div>
                        <div class="col-12"><hr class="border-dark mt-0" style="width: 100%;"></div>

                        <?php
                          $sql = "SELECT * FROM `tmp-penjualan`";
                          $result = mysqli_query($conn, $sql);
                          while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <div class="col-6 pl-4"><?=$row['nama_obat']?></div>
                        <div class="col-2 text-center"><?=$row['qty']?></div>
                        <div class="col-4 text-center"><?=number_format($row['subtotal_harga_jual'],0,"",".")?></div>
                        <?php
                          }
                        ?>
                        
                        <div class="col-12"><hr class="border-dark" style="width: 100%;"></div>
                        <div class="col-4"></div>
                        <div class="col-4 text-right"><b>Total</b></div>
                        <div class="col-4 text-center"><?=$total?></div>
                        <div class="col-4"></div>
                        <div class="col-4 text-right"><b>Pembayaran</b></div>
                        <div class="col-4 text-center"><?=$bayar?></div>
                        <div class="col-4"></div>
                        <div class="col-4 text-right"><b>Kembali</b></div>
                        <div class="col-4 text-center"><?=number_format($bayar_value - $total_value, 0, "", ".")?></div>
                      </div>
                    </div>
                    <div class="modal-footer border-dark">
                      <form action="./penjualan-process.php" method="post">
                        <!-- buat print fpdf -->
                        <input type="text" name="datetime" value="<?=$datetime?>" hidden>
                        <input type="text" name="total" value="<?=$total?>" hidden>
                        <input type="text" name="bayar" value="<?=$bayar?>" hidden>
                        <input type="text" name="kembali" value="<?=number_format($bayar_value - $total_value, 0, "", ".")?>" hidden>
                        <?php
                          $sql = "SELECT * FROM `tmp-penjualan`";
                          $result = mysqli_query($conn, $sql);
                          while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <input type="text" name="nama_obat[]" value="<?=$row['nama_obat']?>" hidden>
                        <input type="text" name="tgl_kadaluarsa[]" value="<?=$row['tgl_kadaluarsa']?>" hidden>
                        <input type="text" name="qty[]" value="<?=$row['qty']?>" hidden>
                        <input type="text" name="harga_jual[]" value="<?=$row['harga_jual']?>" hidden>
                        <input type="text" name="subtotal_harga_jual[]" value="<?=$row['subtotal_harga_jual']?>" hidden>
                        <input type="text" name="pendapatan[]" value="<?=$row['subtotal_harga_jual'] - $row['subtotal_harga_beli']?>" hidden>
                        <?php
                          }
                        ?>
                        <!-- <button onclick="window.print()" class="btn btn-info mr-4">Print Struk</button> -->
                        <button type="submit" name="deal" class="btn btn-primary mr-4">Bayar</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
<?php include('./template/footer.php');?>
  <?php
  if (isset($muncul)) {
    echo("<script>$('#bayar').modal('show');</script>");
  }
  ?>
  
