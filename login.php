<?php
session_start();
include('./koneksi.php');

if(isset($_SESSION['admin'])){
    header("location:index.php");
    die;
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM `user` WHERE `username` = '$username' and `password` = PASSWORD('$password')";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0){
        $_SESSION['admin'] = "ok";
        echo "<script>alert('Selamat Datang');window.location.href='./index.php'</script>";
        die;
    }else{
        echo "<script>alert('Username / Password salah');window.location.href='./login.php'</script>";
        die;
    }
}

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
  </style>
</head>

<body class="">
<div class="wrapper ">
    
    <div class="main-panel w-100">
      <div class="content" style="min-height: 80vh;">
        <div class="card text-center m-auto" style="width: 500px;">
            <div class="card-body">
                <form action="" method="post">
                    <br>
                    <h2 class=""><i class="fa-solid fa-pills" style="font-size: 70px;"></i></h2>
                    <h3>Website Toko Obat Rizki</h3>
                    <b>Username</b>
                    <input class="form-control m-auto border-dark" type="text" name="username" style="width: 300px;"><br>
                    <b>Password</b>
                    <input class="form-control m-auto border-dark" type="password" name="password" style="width: 300px;"><br>
                    <button type="submit" class="btn btn-primary" name="login">Login</button>
                </form>
            </div>
        </div>
      </div>
<?php include('./template/footer.php');?>
  
