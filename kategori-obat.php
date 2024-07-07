<?php 
  $page = "kategori-obat";
  include('./template/header.php');

  if(isset($_POST['tambah'])){
    $kategori_obat = htmlspecialchars($_POST['kategori-obat']);
    $catatan = htmlspecialchars($_POST['catatan']);
    $date = my_getdate();

    // cek on database
    $sqlcek = "SELECT * FROM `kategori-obat` WHERE kategori_obat = '$kategori_obat'";
    $resultcek = mysqli_query($conn, $sqlcek);
    if (mysqli_num_rows($resultcek) > 0){
      echo "<script>alert('Data sudah terdaftar dalam database, tidak bisa memasukkan data yang sama');window.location.href='./kategori-obat.php'</script>";
      die;
    }

    $sql = "INSERT INTO `kategori-obat` VALUES ('', '$kategori_obat', '$catatan', '$date', '$date')";
    $result = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
      echo "<script>alert('Data berhasil di input');window.location.href='./kategori-obat.php'</script>";
      die;
    } else {
      echo "<script>alert('Data gagal di input');window.location.href='./kategori-obat.php'</script>";
      die;
    }
  }

  if(isset($_POST['edit'])){
    $id = htmlspecialchars($_POST['id']);
    $kategori_obat = htmlspecialchars($_POST['kategori-obat']);
    $catatan = htmlspecialchars($_POST['catatan']);
    $date = my_getdate();

    $sql = "UPDATE `kategori-obat` SET `kategori_obat`='$kategori_obat',
                                     `catatan`='$catatan',
                                     `last_updated`='$date' WHERE `id_kategori` = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
      echo "<script>alert('Data berhasil di ubah');window.location.href='./kategori-obat.php'</script>";
      die;
    } else {
      echo "<script>alert('Data gagal di ubah');window.location.href='./kategori-obat.php'</script>";
      die;
    }
  }

  if(isset($_POST['hapus'])){
    $id = htmlspecialchars($_POST['id']);
    $sql = "DELETE FROM `kategori-obat` WHERE `id_kategori` = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
      echo "<script>alert('Data berhasil di hapus');window.location.href='./kategori-obat.php'</script>";
      die;
    } else {
      echo "<script>alert('Data gagal di hapus');window.location.href='./kategori-obat.php'</script>";
      die;
    }
  }
?>
      <div class="content" style="min-height: 80vh;">
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header ">
                <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Tambah Kategori Obat</button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <form action="" method="post">
                        <div class="modal-header">
                          <h5 class="modal-title">Tambah Kategori Obat</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <h6>Kategori Obat</h6>
                          <div class="row">
                            <div class="col-12">
                              <input class="form-control border-dark" type="text" name="kategori-obat" placeholder="Kategori Obat">
                            </div>
                          </div><br>
                          <h6>Catatan</h6>
                          <div class="row">
                            <div class="col-12">
                              <textarea name="catatan" class="form-control border-dark px-2 py-0" rows="4" placeholder="Catatan"></textarea>
                            </div>
                          </div><br>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary" name="tambah">Simpan</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body ">
                <table id="example" class="display table table-bordered" style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 10px;">No</th>
                            <th>Kategori Obat</th>
                            <th>Catatan</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            $no = 1;
                            $sql = "SELECT * FROM `kategori-obat`";
                            $result = mysqli_query($conn, $sql);
                            while($row = mysqli_fetch_assoc($result)){
                            ?>
                            <td><?=$no?></td>
                            <td><?=$row['kategori_obat']?></td>
                            <td><?=$row['catatan']?></td>
                            <td>
                              <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#edit-<?=$row['id_kategori']?>"><i class="fa-solid fa-pen"></i></button>
                              <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapus-<?=$row['id_kategori']?>"><i class="fa-solid fa-trash"></i></button>
                            </td>
                            <!-- Edit Modal -->
                            <div class="modal fade" id="edit-<?=$row['id_kategori']?>" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <form action="" method="post">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Kategori Obat</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <h6>Kategori Obat</h6>
                                    <div class="row">
                                        <div class="col-12">
                                        <input class="form-control border-dark" type="text" name="kategori-obat" placeholder="Kategori Obat" value="<?=$row['kategori_obat']?>">
                                        </div>
                                    </div><br>
                                    <h6>Catatan</h6>
                                    <div class="row">
                                        <div class="col-12">
                                        <textarea name="catatan" class="form-control border-dark px-2 py-0" rows="4" placeholder="Catatan"><?=$row['catatan']?></textarea>
                                        </div>
                                    </div><br>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="text" value="<?=$row['id_kategori']?>" hidden name="id">
                                        <button type="submit" class="btn btn-success" name="edit">Edit</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <!-- Hapus Modal -->
                            <div class="modal fade" id="hapus-<?=$row['id_kategori']?>" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <form action="" method="post">
                                    <div class="modal-header">
                                      <h5 class="modal-title">Hapus Obat</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="row">
                                        <div class="col-5">
                                          <h6>Kategori Obat</h6>
                                        </div>
                                        <div class="col-1">
                                          <h6>:</h6>
                                        </div>
                                        <div class="col-6">
                                          <p><strong><?=$row['kategori_obat']?></strong></p>
                                        </div>
                                      </div>
                                      <p>Data akan dihapus, data tidak akan dapat dikembalikan setelah di hapus. Apakah anda yakin?</p>
                                    </div>
                                    <div class="modal-footer">
                                      <input type="text" value="<?=$row['id_kategori']?>" hidden name="id">
                                      <button type="submit" class="btn btn-danger" name="hapus">Hapus</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php
                            $no++;
                            }
                          ?>
                        </tr>
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>        
      </div>
<?php include('./template/footer.php');?>
  <script>
    new DataTable('#example');
  </script>