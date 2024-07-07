<?php 
  $page = "user";
  include('./template/header.php');

  if(isset($_POST['simpan'])){
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $id = htmlspecialchars($_POST['id']);

    $sql = "UPDATE `user` SET `username` = '$username', `password` = PASSWORD('$password') WHERE `id_user` = 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
      echo "<script>alert('Data berhasil di ubah');window.location.href='./user.php'</script>";
      die;
    } else {
      echo "<script>alert('Data gagal di ubah');window.location.href='./user.php'</script>";
      die;
    }
  }
?>
      <div class="content" style="min-height: 80vh;">
        <div class="row">
          <div class="col-md-12">
            <div class="card p-3" style="width: 600px;">
              <div class="card-header">
                <h4 class="mt-2"><i class="nc-icon nc-single-02"></i> Ubah Username & Password</h4>
              </div>
              <div class="card-body">
                <form action="" method="post">
                    <?php
                    $sql = "SELECT * FROM `user`";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <input type="text" hidden value="<?=$row['id_user']?>" name="id">
                    <label for="" style="font-size: 14px;" class="text-dark"><b>Username</b></label>
                    <input type="text" class="form-control border-dark" name="username" value="<?=$row['username']?>" required><br>
                    <label for="" style="font-size: 14px;" class="text-dark"><b>Password</b></label>
                    <input type="password" class="form-control border-dark" name="password" required><br>
                    <?php
                    }
                    ?>
                    <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                </form>
              </div>
            </div>
          </div>
        </div>        
      </div>
<?php include('./template/footer.php');?>
