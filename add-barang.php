<?php 
  $page = "add-barang";
  include('./template/header.php');

  if(isset($_POST['tambah'])){
    $nama_obat = htmlspecialchars($_POST['nama-obat']);
    $satuan = htmlspecialchars($_POST['satuan']);
    $harga_beli = htmlspecialchars($_POST['harga-beli']);
    $harga_jual = htmlspecialchars($_POST['harga-jual']);
    $stok_minimal = htmlspecialchars($_POST['stok-minimal']);
    $jenis_obat = htmlspecialchars($_POST['jenis-obat']);
    $kategori = htmlspecialchars($_POST['kategori']);
    $golongan = htmlspecialchars($_POST['golongan']);
    $date = my_getdate();

    // cek on database
    $sqlcek = "SELECT * FROM `obat` WHERE nama_obat = '$nama_obat'";
    $resultcek = mysqli_query($conn, $sqlcek);
    if (mysqli_num_rows($resultcek) > 0){
      echo "<script>alert('Data sudah terdaftar dalam database, tidak bisa memasukkan data yang sama');window.location.href='./add-barang.php'</script>";
      die;
    }

    $sql = "INSERT INTO `obat` VALUES ('', '$nama_obat', '$satuan', '$harga_beli', '$harga_jual', '$stok_minimal', '$jenis_obat', '$kategori', '$golongan', '$date', '$date')";
    $result = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
      echo "<script>alert('Data berhasil di input');window.location.href='./add-barang.php'</script>";
      die;
    } else {
      echo "<script>alert('Data gagal di input');window.location.href='./add-barang.php'</script>";
      die;
    }
  }

  if(isset($_POST['edit'])){
    $id = htmlspecialchars($_POST['id']);
    $satuan = htmlspecialchars($_POST['satuan']);
    $stok_minimal = htmlspecialchars($_POST['stok-minimal']);
    $harga_beli = htmlspecialchars($_POST['harga-beli']);
    $harga_jual = htmlspecialchars($_POST['harga-jual']);
    $jenis_obat = htmlspecialchars($_POST['jenis-obat']);
    $kategori = htmlspecialchars($_POST['kategori']);
    $golongan = htmlspecialchars($_POST['golongan']);
    $date = my_getdate();

    $sql = "UPDATE `obat` SET `satuan`='$satuan',
                              `harga_beli`='$harga_beli',
                              `harga_jual`='$harga_jual',
                              `stok_minimal`='$stok_minimal',
                              `jenis_obat`='$jenis_obat',
                              `kategori`='$kategori',
                              `golongan`='$golongan',
                              `last_updated`='$date' WHERE `id_obat` = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
      echo "<script>alert('Data berhasil di ubah');window.location.href='./add-barang.php'</script>";
      die;
    } else {
      echo "<script>alert('Data gagal di ubah');window.location.href='./add-barang.php'</script>";
      die;
    }
  }

  if(isset($_POST['hapus'])){
    $nama_obat = htmlspecialchars($_POST['nama-obat']);
    $id = htmlspecialchars($_POST['id']);

    // cek apakah masih ada stok obat
    $sqlcek = "SELECT * FROM `stok-obat` WHERE `nama_obat` = '$nama_obat' AND `stok_obat` <> 0";
    $resultcek = mysqli_query($conn, $sqlcek);

    if (mysqli_num_rows($resultcek)){
      echo "<script>alert('Stok obat masih tersedia, tidak bisa menghapus data');window.location.href='./add-barang.php'</script>";
      die;
    }

    $sql = "DELETE FROM `obat` WHERE `id_obat` = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
      echo "<script>alert('Data berhasil di hapus');window.location.href='./add-barang.php'</script>";
      die;
    } else {
      echo "<script>alert('Data gagal di hapus');window.location.href='./add-barang.php'</script>";
      die;
    }
  }
?>
      <div class="content" style="min-height: 80vh;">
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header ">
                <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Tambah Barang</button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <form action="" method="post">
                        <div class="modal-header">
                          <h5 class="modal-title">Tambah Barang</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <h6>Nama Obat</h6>
                          <div class="row">
                            <div class="col-12">
                              <input class="form-control border-dark" type="text" name="nama-obat" placeholder="Nama Obat">
                            </div>
                          </div><br>
                          <div class="row">
                            <div class="col-6">
                              <h6>Satuan</h6>
                              <div class="row">
                                <div class="col-12">
                                  <select name="satuan" class="form-control border-dark">
                                    <?=select_sjgk("satuan-obat", "Satuan")?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-6">
                              <h6>Stok Minimal</h6>
                              <div class="row">
                                <div class="col-8">
                                  <input class="form-control border-dark" type="number" name="stok-minimal" placeholder="0" style="height: 32px;">
                                </div>
                              </div>
                            </div>
                          </div><br>
                          <h6>Harga Beli</h6>
                          <div class="row">
                            <div class="col-2 text-right">
                              <input type="text" value="Rp." disabled class="form-control uang">
                            </div>
                            <div class="col-8">
                              <input class="form-control border-dark" type="text" name="harga-beli" placeholder="Harga Beli">
                            </div>
                          </div><br>
                          <h6>Harga Jual</h6>
                          <div class="row">
                            <div class="col-2 text-right">
                              <input type="text" value="Rp." disabled class="form-control uang">
                            </div>
                            <div class="col-8">
                              <input class="form-control border-dark" type="text" name="harga-jual" placeholder="Harga Jual">
                            </div>
                          </div><br>
                          <h6>Jenis Obat</h6>
                          <div class="row">
                            <div class="col-12">
                              <select name="jenis" class="form-control border-dark">
                                <?=select_sjgk("jenis-obat", "Jenis")?>
                              </select>
                            </div>
                          </div><br>
                          <h6>Kategori</h6>
                          <div class="row">
                            <div class="col-12">
                              <select name="kategori" class="form-control border-dark">
                                <?=select_sjgk("kategori-obat", "Kategori")?>
                              </select>
                            </div>
                          </div><br>
                          <h6>Golongan</h6>
                          <div class="row">
                            <div class="col-12">
                              <select name="golongan" class="form-control border-dark">
                                <?=select_sjgk("golongan-obat", "Golongan")?>
                              </select>
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
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Min Stok</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Jenis Obat</th>
                            <th>Gol</th>
                            <th>Kategori</th>
                            <th style="width: 80px;">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                          <?php
                          $no = 1;
                          $sql = "SELECT * FROM `obat`";
                          $result = mysqli_query($conn, $sql);
                          while($row = mysqli_fetch_assoc($result)){
                          ?>
                        <tr>
                            <td><?=$no?></td>
                            <td><?=$row['nama_obat']?></td>
                            <td class="text-center"><?=$row['satuan']?></td>
                            <td class="text-center"><?=$row['stok_minimal']?></td>
                            <td class="text-center"><?=$row['harga_beli']?></td>
                            <td class="text-center"><?=$row['harga_jual']?></td>
                            <td class="text-center"><?=$row['jenis_obat']?></td>
                            <td class="text-center"><?=$row['golongan']?></td>
                            <td class="text-center"><?=$row['kategori']?></td>
                            <td class="text-center">
                              <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#edit-<?=$row['id_obat']?>"><i class="fa-solid fa-pen"></i></button>
                              <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#hapus-<?=$row['id_obat']?>"><i class="fa-solid fa-trash"></i></button>
                            </td>
                            <!-- Edit Modal -->
                            <div class="modal fade" id="edit-<?=$row['id_obat']?>" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <form action="" method="post">
                                    <div class="modal-header">
                                      <h5 class="modal-title">Edit Obat</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <h6>Nama Obat</h6>
                                      <div class="row">
                                        <div class="col-12">
                                          <input type="text" value="<?=$row['id_obat']?>" name="id" hidden>
                                          <input class="form-control" type="text" name="nama-obat" placeholder="Nama Obat" value="<?=$row['nama_obat']?>" disabled>
                                        </div>
                                      </div><br>
                                      <div class="row">
                                        <div class="col-6">
                                          <h6>Satuan</h6>
                                          <div class="row">
                                            <div class="col-12">
                                              <select name="satuan" class="form-control border-dark">
                                                <?=select_sjgk("satuan-obat", $row['satuan'], $row['satuan'])?>
                                              </select>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-6">
                                          <h6>Stok Minimal</h6>
                                          <div class="row">
                                            <div class="col-8">
                                              <input class="form-control border-dark" type="number" name="stok-minimal" placeholder="0" value="<?=$row['stok_minimal']?>" style="height: 32px;">
                                            </div>
                                          </div>
                                        </div>
                                      </div><br>
                                      <h6>Harga Beli</h6>
                                      <div class="row">
                                        <div class="col-2 text-right">
                                          <input type="text" value="Rp." disabled class="form-control">
                                        </div>
                                        <div class="col-8">
                                          <input class="form-control border-dark" type="text" name="harga-beli" placeholder="Harga Beli" value="<?=$row['harga_beli']?>">
                                        </div>
                                      </div><br>
                                      <h6>Harga Jual</h6>
                                      <div class="row">
                                        <div class="col-2 text-right">
                                          <input type="text" value="Rp." disabled class="form-control">
                                        </div>
                                        <div class="col-8">
                                          <input class="form-control border-dark" type="text" name="harga-jual" placeholder="Harga Jual" value="<?=$row['harga_jual']?>">
                                        </div>
                                      </div><br>
                                      <h6>Jenis Obat</h6>
                                      <div class="row">
                                        <div class="col-12">
                                          <select name="jenis-obat" class="form-control border-dark">
                                            <?=select_sjgk("jenis-obat", $row['jenis_obat'], $row['jenis_obat'])?>
                                          </select>
                                        </div>
                                      </div><br>
                                      <h6>Kategori</h6>
                                      <div class="row">
                                        <div class="col-12">
                                          <select name="kategori" class="form-control border-dark">
                                            <?=select_sjgk("kategori-obat", $row['kategori'], $row['kategori'])?>
                                          </select>
                                        </div>
                                      </div><br>
                                      <h6>Golongan</h6>
                                      <div class="row">
                                        <div class="col-12">
                                          <select name="golongan" class="form-control border-dark">
                                            <?=select_sjgk("golongan-obat", $row['golongan'], $row['golongan'])?>
                                          </select>
                                        </div>
                                      </div><br>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="submit" class="btn btn-success" name="edit">Edit</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <!-- Hapus Modal -->
                            <div class="modal fade" id="hapus-<?=$row['id_obat']?>" tabindex="-1" role="dialog" aria-hidden="true">
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
                                          <h6>Satuan</h6>
                                        </div>
                                        <div class="col-1">
                                          <h6>:</h6>
                                        </div>
                                        <div class="col-6">
                                          <p><?=$row['satuan']?></p>
                                        </div>
                                      </div>
                                      <p>Data akan dihapus, data <strong>tidak dapat dikembalikan</strong> setelah di hapus. Apakah anda yakin?</p>
                                    </div>
                                    <div class="modal-footer">
                                      <input type="text" value="<?=$row['nama_obat']?>" hidden name="nama-obat">
                                      <input type="text" value="<?=$row['id_obat']?>" hidden name="id">
                                      <button type="submit" class="btn btn-danger" name="hapus">Hapus</button>
                                    </div>
                                  </form>
                                </div>
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

    // var input = document.getElementById('input-rupiah');
    // input.addEventListener('keyup', function(e)
    // {
    //   var 	number_string = bilangan.replace(/[^,\d]/g, '').toString(),
    //     split	= number_string.split(','),
    //     sisa 	= split[0].length % 3,
    //     rupiah 	= split[0].substr(0, sisa),
    //     ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
        
    //   if (ribuan) {
    //     separator = sisa ? '.' : '';
    //     rupiah += separator + ribuan.join('.');
    //   }
      
    //   rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    //   return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    // });
  </script>

