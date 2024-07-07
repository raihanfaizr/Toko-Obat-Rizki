<?php 
  $page = "obat-bermasalah";
  include('./template/header.php');

  if (isset($_POST['buang'])) {
    $datetime = date("Y-m-d H:i:s");
    $nama_obat = $_POST['nama-obat'];
    $tgl_kadaluarsa = $_POST['tgl-kadaluarsa'];
    $qty = $_POST['qty'];
    $status = $_POST['status'];
    $pendapatan = 0 - $_POST['pendapatan'];
    
    $sql1 = "INSERT INTO `log` VALUES ('', '$nama_obat', '$tgl_kadaluarsa', '$qty', '$status', '$pendapatan', '$datetime')";
    $result1 = mysqli_query($conn, $sql1);

    $sql2 = "DELETE FROM `stok-obat` WHERE `nama_obat` = '$nama_obat' AND `tgl_kadaluarsa` = '$tgl_kadaluarsa' AND `status` = '$status'";
    $result = mysqli_query($conn, $sql2);

    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>alert('Data telah dibuang! Record Data akan tersimpan kedalam database');window.location.href='./obat-bermasalah.php'</script>";
        die;
    }
  }

  ?>
      <div class="content" style="min-height: 80vh;">
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header ">
              </div>
              <div class="card-body ">
                <table id="example" class="display table table-bordered" style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 10px;">No</th>
                            <th>Tgl Kadaluarsa</th>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          $no = 1;
                          $sql = "SELECT so.nama_obat, so.stok_obat, so.tgl_kadaluarsa, so.status, so.id_stok, o.satuan, o.harga_beli FROM `stok-obat` so, `obat` o 
                                  WHERE so.nama_obat = o.nama_obat AND so.status <> 'tersedia' ORDER BY so.tgl_kadaluarsa";
                          $result = mysqli_query($conn, $sql);
                          while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td><?=tgl_indo($row['tgl_kadaluarsa'])?></td>
                            <td><?=$row['nama_obat']?></td>
                            <td><strong><?=$row['stok_obat']?></strong></td>
                            <td><?=$row['status']?></td>
                            <td>
                              <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#buang-<?=$row['id_stok']?>">Buang</button>
                            </td>
                            <!-- Edit Modal -->
                            <div class="modal fade" id="buang-<?=$row['id_stok']?>" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <form action="" method="post">
                                    <div class="modal-header">
                                      <h5 class="modal-title">Buang Obat</h5>
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
                                      <div class="row">
                                        <div class="col-5">
                                          <h6>Status</h6>
                                        </div>
                                        <div class="col-1">
                                          <h6>:</h6>
                                        </div>
                                        <div class="col-6">
                                          <p><?=$row['status']?></p>
                                        </div>
                                      </div>
                                      <hr>
                                      <div class="row">
                                        <div class="col-3">
                                          <h6>Jumlah</h6>
                                          <input class="form-control" type="number" name="qty" value="<?=$row['stok_obat']?>" min="1" disabled>
                                        </div>
                                        <div class="col-9">
                                          <h6>Kerugian</h6>
                                          <div class="row">
                                            <div class="col-3">
                                              <input class="form-control " type="text" value="Rp."  disabled>
                                            </div>
                                            <div class="col-9 pl-0">
                                              <input type="text" class="form-control border-dark" name="pendapatan" value="<?=$row['stok_obat'] * $row['harga_beli']?>">
                                            </div> 
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <input type="number" name="qty" value="<?=$row['stok_obat']?>" hidden>
                                      <input type="text" name="nama-obat" value="<?=$row['nama_obat']?>" hidden>
                                      <input type="text" name="tgl-kadaluarsa" value="<?=$row['tgl_kadaluarsa']?>" hidden>
                                      <input type="text" name="status" value="<?=$row['status']?>" hidden>
                                      <button type="submit" class="btn btn-danger" name="buang">Buang</button>
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
