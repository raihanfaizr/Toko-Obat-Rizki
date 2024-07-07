<?php 
  $page = "add-stok";
  include('./template/header.php');
  ?>
      <div class="content" style="min-height: 80vh;">
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header ">
                <div class="text-right">
                  
                </div>
              </div>
              <div class="card-body ">
                <div class="row">
                    <div class="col-10">
                        <table id="example" class="display table table-bordered" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th style="width: 10px;">No</th>
                                    <th>Nama Barang</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $sql = "SELECT nama_obat, SUM(stok_obat) AS stok_obat FROM `stok-obat` WHERE stok_obat > 0 AND `status` = 'tersedia' GROUP BY nama_obat ORDER BY tgl_kadaluarsa";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_assoc($result)){
                                ?>
                                <tr>
                                    <td><?=$no?></td>
                                    <td><?=$row['nama_obat']?></td>
                                    <td><strong><?=$row['stok_obat']?></strong></td>
                                </tr>
                                <?php
                                $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-2 text-center">
                        <a class="btn btn-secondary" href="./add-stok.php">Kembali</a>
                    </div>
                </div>
                
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
