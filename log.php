<?php 
  $page = "log";
  include('./template/header.php');

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
                            <th>Waktu & Tanggal</th>
                            <th>Nama Barang</th>
                            <th>Tgl Kadaluarsa</th>
                            <th>Qty</th>
                            <th style="width: 150px;">Status</th>
                            <th>Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          $no = 1;
                          $sql = "SELECT * FROM `log` ORDER BY `created_at` DESC LIMIT 1000";
                          $result = mysqli_query($conn, $sql);
                          while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td><?=$row['created_at']?></td>
                            <td><?=$row['nama_obat']?></td>
                            <td><?=tgl_indo($row['tgl_kadaluarsa'])?></td>
                            <td><?=$row['qty']?></td>
                            <td><?=$row['status']?></td>
                            <td>
                                <?="Rp. ". number_format($row['pendapatan'],0,"",".")?>
                                <?php
                                    if ($row['pendapatan'] < 0) {
                                      echo "<i class='nc-icon nc-simple-delete bg-danger text-light p-1 rounded-circle ml-1'></i>";
                                    }elseif ($row['pendapatan'] == 0) {
                                      echo "";
                                    }else {
                                      echo "<i class='nc-icon nc-simple-add bg-success text-light p-1 rounded-circle ml-1'></i>";
                                    }
                                ?>
                            </td>
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
