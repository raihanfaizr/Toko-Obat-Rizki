<?php 
  $page = "add-stok";
  include('./template/header.php');

  if(isset($_POST['tambah'])){
    $nama_obat = htmlspecialchars($_POST['nama-obat']);
    $tgl_kadaluarsa = htmlspecialchars($_POST['tgl-kadaluarsa']);
    $stok = htmlspecialchars($_POST['stok']);
    $date = my_getdate();

    // cek on database
    $sqlcek = "SELECT * FROM `stok-obat` WHERE nama_obat = '$nama_obat' AND tgl_kadaluarsa = '$tgl_kadaluarsa' AND `status` = 'tersedia'";
    $resultcek = mysqli_query($conn, $sqlcek);

    if (mysqli_num_rows($resultcek) > 0){
      
      while ($row = mysqli_fetch_assoc($resultcek)){
        $id = $row['id_stok'];
        $stok_terdahulu = $row['stok_obat'];
      }
      $stok = $stok + $stok_terdahulu;

      $sql = "UPDATE `stok-obat` SET `stok_obat`='$stok', `last_updated`='$date' WHERE `id_stok` = $id";
      $result = mysqli_query($conn, $sql);
      
      if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Data berhasil di input');window.location.href='./add-stok.php'</script>";
        die;
      } else {
        echo "<script>alert('Data gagal di input');window.location.href='./add-stok.php'</script>";
        die;
      }
    }

    // tambah baru
    $sql = "INSERT INTO `stok-obat` VALUES ('', '$nama_obat', '$stok', '$tgl_kadaluarsa', 'tersedia', '$date', '$date')";
    $result = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
      echo "<script>alert('Data berhasil di input');window.location.href='./add-stok.php'</script>";
      die;
    } else {
      echo "<script>alert('Data gagal di input');window.location.href='./add-stok.php'</script>";
      die;
    }

  }
  
  if(isset($_POST['edit'])){
    $nama_obat = htmlspecialchars($_POST['nama-obat']);
    $tgl_kadaluarsa = htmlspecialchars($_POST['tgl-kadaluarsa']);
    $status = htmlspecialchars($_POST['status']);
    $stok_saat_ini = htmlspecialchars($_POST['stok-saat-ini']);
    $stok = htmlspecialchars($_POST['stok']);
    $date = my_getdate();

    // mengurangi jumlah stok yang tersedia
    $stok_tersedia = $stok_saat_ini - $stok;
    $sqlstok = "UPDATE `stok-obat` SET `stok_obat`='$stok_tersedia',
                                  `last_updated`='$date' WHERE 
                                  nama_obat = '$nama_obat' AND tgl_kadaluarsa = '$tgl_kadaluarsa' AND `status` = 'tersedia'";
    $result = mysqli_query($conn, $sqlstok);


    // cek on database
    $sqlcek = "SELECT * FROM `stok-obat` WHERE nama_obat = '$nama_obat' AND tgl_kadaluarsa = '$tgl_kadaluarsa' AND `status` = '$status'";
    $resultcek = mysqli_query($conn, $sqlcek);

    if (mysqli_num_rows($resultcek) > 0){
      
      while ($row = mysqli_fetch_assoc($resultcek)){
        $id = $row['id_stok'];
        $stok_terdahulu = $row['stok_obat'];
      }
      $stok = $stok + $stok_terdahulu;

      $sql = "UPDATE `stok-obat` SET `stok_obat`='$stok', `last_updated`='$date' WHERE `id_stok` = $id";
      $result = mysqli_query($conn, $sql);
      
      if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Data berhasil di ubah');window.location.href='./add-stok.php'</script>";
        die;
      } else {
        echo "<script>alert('Data gagal di ubah');window.location.href='./add-stok.php'</script>";
        die;
      }
    }

    // tambah baru
    $sql = "INSERT INTO `stok-obat` VALUES ('', '$nama_obat', '$stok', '$tgl_kadaluarsa', '$status', '$date', '$date')";
    $result = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
      echo "<script>alert('Data berhasil di ubah');window.location.href='./add-stok.php'</script>";
      die;
    } else {
      echo "<script>alert('Data gagal di ubah');window.location.href='./add-stok.php'</script>";
      die;
    }

  }

  if(isset($_POST['hapus'])){
    $id = htmlspecialchars($_POST['id']);
    $sql = "DELETE FROM `stok-obat` WHERE `id_stok` = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
      echo "<script>alert('Data berhasil di hapus');window.location.href='./add-stok.php'</script>";
      die;
    } else {
      echo "<script>alert('Data gagal di hapus');window.location.href='./add-stok.php'</script>";
      die;
    }
  }
  ?>
      <div class="content" style="min-height: 80vh;">
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header ">
                <div class="row">
                  <div class="col-6">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Tambah Stok</button>
                  </div>
                  <div class="col-6 text-right">
                    <a class="btn btn-secondary" href="./persediaan.php">Lihat Lebih Sedikit</a>
                  </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <form action="" method="post">
                        <div class="modal-header">
                          <h5 class="modal-title">Tambah Stok</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <h6>Nama Obat</h6>
                          <div class="row">
                            <div class="col-12">
                              <select name="nama-obat" id="selectize" required>
                                <?=stok_obat("obat", "Nama Obat")?>
                              </select>
                            </div>
                          </div><br>
                          <div class="row">
                            <div class="col-6">
                              <h6>Tgl Kadaluarsa</h6>
                              <div class="row">
                                <div class="col-12">
                                  <input type="date" name="tgl-kadaluarsa" class="form-control border-dark" required>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <h6>Stok</h6>
                              <div class="row">
                                <div class="col-6">
                                  <input type="number" name="stok" class="form-control border-dark" placeholder="0" autocomplete="off" required>
                                </div>
                              </div>
                            </div>
                          </div>
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
                            <th>Tgl Kadaluarsa</th>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          $no = 1;
                          $sql = "SELECT so.nama_obat, so.stok_obat, so.tgl_kadaluarsa, so.status, so.id_stok, o.satuan FROM `stok-obat` so, `obat` o 
                                  WHERE so.nama_obat = o.nama_obat AND so.stok_obat <> 0 AND so.status = 'tersedia' ORDER BY so.tgl_kadaluarsa";
                          $result = mysqli_query($conn, $sql);
                          while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td><?=tgl_indo($row['tgl_kadaluarsa'])?></td>
                            <td><?=$row['nama_obat']?></td>
                            <td><strong><?=$row['stok_obat']?></strong></td>
                            <td>
                              <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#edit-<?=$row['id_stok']?>">Edit Status</button>
                              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#hapus-<?=$row['id_stok']?>"><i class="fa-solid fa-trash"></i></button>
                            </td>
                            <!-- Edit Modal -->
                            <div class="modal fade" id="edit-<?=$row['id_stok']?>" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <form action="" method="post">
                                    <div class="modal-header">
                                      <h5 class="modal-title">Edit Stok</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="row">
                                        <div class="col-5">
                                          <h6>Nama Obat</h6>
                                        </div>
                                        <div class="col-1">
                                          <h6>:</h6>
                                        </div>
                                        <div class="col-6">
                                          <p><?=$row['nama_obat']?></p>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-5">
                                          <h6>Satuan</h6>
                                        </div>
                                        <div class="col-1">
                                          <h6>:</h6>
                                        </div>
                                        <div class="col-6">
                                          <p><?=$row['satuan']?></p>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-5">
                                          <h6>Tgl Kadaluarsa</h6>
                                        </div>
                                        <div class="col-1">
                                          <h6>:</h6>
                                        </div>
                                        <div class="col-6">
                                          <p><?=tgl_indo($row['tgl_kadaluarsa'])?></p>
                                        </div>
                                      </div>
                                      <hr>
                                      <div class="row">
                                        <div class="col-6">
                                          <h6>Status</h6>
                                          <select class="form-control border-dark" name="status" required>
                                            <option value="">tersedia</option>
                                            <option value="rusak">rusak</option>
                                          </select>
                                        </div>
                                        <div class="col-6">
                                          <h6>Jumlah Stok</h6>
                                          <div class="row">
                                            <div class="col-8">
                                              <input class="form-control border-dark" type="number" name="stok" value="<?=$row['stok_obat']?>" min="1" max="<?=$row['stok_obat']?>" required autocomplete="off">
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <input type="text" name="nama-obat" value="<?=$row['nama_obat']?>" hidden>
                                      <input type="text" name="tgl-kadaluarsa" value="<?=$row['tgl_kadaluarsa']?>" hidden>
                                      <input type="text" name="stok-saat-ini" value="<?=$row['stok_obat']?>" hidden>
                                      <button type="submit" class="btn btn-danger" name="edit">Edit</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <!-- Hapus Modal -->
                            <div class="modal fade" id="hapus-<?=$row['id_stok']?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                          <h6>Nama Obat</h6>
                                        </div>
                                        <div class="col-1">
                                          <h6>:</h6>
                                        </div>
                                        <div class="col-6">
                                          <p><?=$row['nama_obat']?></p>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-5">
                                          <h6>Tgl Kadaluarsa</h6>
                                        </div>
                                        <div class="col-1">
                                          <h6>:</h6>
                                        </div>
                                        <div class="col-6">
                                          <p><?=tgl_indo($row['tgl_kadaluarsa'])?></p>
                                        </div>
                                      </div>
                                      <p>Data akan dihapus, data <strong>tidak akan ter-record</strong> kedalam perhitungan penjualan. Apakah anda yakin?</p>
                                    </div>
                                    <div class="modal-footer">
                                      <input type="text" value="<?=$row['id_stok']?>" hidden name="id">
                                      <button type="submit" class="btn btn-primary" name="hapus">Hapus</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                        </tr>
                        <?php
                          $no++;
                          }
                        ?>
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

    $('#selectize').selectize();
  </script>
