<?php 
  $page = "index";
  include('./template/header.php');
  $date = date("Y-m-d");

  function bulan($tanggal){
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
   
    return $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
  }
?>
      <div class="content" style="min-height: 80vh;">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-money-coins text-success"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Keuntungan</p>
                      <?php
                        $bulan = date("Y-m");
                        $sql = "SELECT SUM(pendapatan) AS pendapatan FROM `log` WHERE `created_at` LIKE '$bulan%'";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($result)){
                          $pendapatan = $row['pendapatan'];
                        }
                      ?>
                      <p class="card-title">Rp <?=number_format($pendapatan,0,"",".")?><p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <div class="row">
                    <div class="col-8">
                      <i class="fa fa-calendar-o"></i>
                      <b>Periode : </b><?=bulan(date("Y-m"))?>
                    </div>
                    <div class="col-4 text-right">
                    <?php
                          if ($pendapatan < 0) {
                            echo "<i class='nc-icon nc-simple-delete bg-danger text-light p-1 rounded-circle ml-1'></i>";
                          }else{
                            echo "<i class='nc-icon nc-simple-add bg-success text-light p-1 rounded-circle ml-1'></i>";
                          }
                        ?>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-bag-16 text-danger"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Barang Terjual</p>
                      <?php
                        $bulan = date("Y-m");
                        $sql = "SELECT SUM(qty) AS qty FROM `log` WHERE `created_at` LIKE '$bulan%'";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($result)){
                          $qty = $row['qty'];
                        }
                      ?>
                      <p class="card-title"><?=$qty?><p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-calendar-o"></i>
                  <b>Periode : </b><?=bulan(date("Y-m"))?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-favourite-28 text-primary"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">reminder</p>
                      <p class="card-title">
                        <div class="badge badge-danger">
                          <?php
                          // reminder tgl kadaluarsa
                          $sql = "SELECT COUNT(nama_obat) AS nama_obat FROM `stok-obat` WHERE `tgl_kadaluarsa` >= '$date' AND `tgl_kadaluarsa` < (SELECT DATE_SUB('$date', INTERVAL -60 DAY)) AND `stok_obat` <> 0";
                          $result = mysqli_query($conn, $sql);
                          while($row = mysqli_fetch_assoc($result)){
                            $reminder1 = $row['nama_obat'];
                          }

                          // reminder stok barang
                          $sql = "SELECT so.nama_obat, so.status, SUM(so.stok_obat) AS stok_obat, o.stok_minimal FROM `stok-obat` so, `obat` o WHERE o.nama_obat = so.nama_obat AND so.status = 'tersedia' GROUP BY so.nama_obat";
                          $result = mysqli_query($conn, $sql);
                          $reminder2 = 0;
                          while($row = mysqli_fetch_assoc($result)){
                            if($row['stok_obat'] <= $row['stok_minimal']){
                              $reminder2++;
                            }
                          }

                          echo $reminder1 + $reminder2;
                          ?>
                        </div> Barang
                      <p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer pb-2">
                <hr>
                <div class="stats text-right">
                  <!-- Button trigger modal -->
                  <button type="button" class="badge badge-info" data-toggle="modal" data-target="#reminderCenter" style="text-transform: none;">
                    <i class="fa fa-info text-primary py-1 px-2 bg-light rounded-circle" style="font-size: 12px;"></i> Click here for details
                  </button>
                  <!-- Modal -->
                  <div class="modal fade" id="reminderCenter" tabindex="-1" role="dialog" aria-labelledby="reminderCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title text-dark">Reminder</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="text-center text-dark">
                            <h6>--- Kadaluarsa (60 Hari) ---</h6>
                            <hr style="border-top: 2px solid black;">
                          </div>
                          <table class="table text-left">
                            <thead>
                              <tr>
                                <th>Nama Barang</th>
                                <th class="text-center">Stok</th>
                                <th>Tgl Kadaluarsa</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $sql = "SELECT nama_obat, stok_obat, tgl_kadaluarsa, DATEDIFF(tgl_kadaluarsa, '$date') AS datediff FROM `stok-obat` WHERE DATEDIFF(tgl_kadaluarsa, '$date') <= 60 AND `stok_obat` <> 0";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_assoc($result)){
                              ?>
                              <tr>
                                <td><?=$row['nama_obat']?></td>
                                <td class="text-center"><?=$row['stok_obat']?></td>
                                <td><?=$row['tgl_kadaluarsa']?> | <b class="text-danger">(<?=$row['datediff']?> Hari Lagi)</b></td>
                              </tr>
                              <?php
                                }
                              ?>
                            </tbody>
                          </table>

                          <br>

                          <div class="text-center text-dark">
                            <h6>--- Stok Barang ---</h6>
                            <hr style="border-top: 2px solid black;">
                          </div>
                          <table class="table text-left">
                            <thead>
                              <tr>
                                <th>Nama Barang</th>
                                <th class="text-center">Min Stok</th>
                                <th class="text-center">Stok Saat Ini</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $sql = "SELECT so.nama_obat, so.status, SUM(so.stok_obat) AS stok_obat, o.stok_minimal FROM `stok-obat` so, `obat` o WHERE o.nama_obat = so.nama_obat AND so.status = 'tersedia' GROUP BY so.nama_obat";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_assoc($result)){
                              ?>
                              <tr>
                                <?php
                                if($row['stok_obat'] <= $row['stok_minimal']){

                                ?>
                                <td><?=$row['nama_obat']?></td>
                                <td class="text-center"><?=$row['stok_minimal']?></td>
                                <td class="text-center text-danger"><b><?=$row['stok_obat']?></b></td>
                                <?php

                                }
                                ?>
                              </tr>
                              <?php
                                }
                              ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title">Grafik Pendapatan ( <?=bulan(date("Y-m"))?> )</h5>
              </div>
              <div class="card-body ">
                <canvas id="speedChart" width="400" height="100"></canvas>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <i class="fa fa-history"></i> Updated at (<?=date("Y-m-d H:i:s")?>)
                </div>
              </div>
            </div>
          </div>
        </div>        
      </div>
<?php include('./template/footer.php');?>
  <script>
    var speedCanvas = document.getElementById("speedChart");

    var dataFirst = {
      data: [
      <?php
        $iteration = 1;
        while ($iteration <= 31) {
          $iteration_padded = sprintf("%02d", $iteration);
          $sql = "SELECT SUM(pendapatan) AS pendapatan FROM `log` WHERE `created_at` LIKE '$bulan-$iteration_padded%'";
          $result = mysqli_query($conn, $sql);
          while($row = mysqli_fetch_assoc($result)){
            echo $row['pendapatan'] .",";
          }
          $iteration++;
        }
      ?> 
      ],
      // data: [-10, 19, 15, 20, 30, 40, 40, 50, 25, 30, 50, 700,],
      fill: false,
      borderColor: '#fbc658',
      backgroundColor: 'transparent',
      pointBorderColor: '#fbc658',
      pointRadius: 4,
      pointHoverRadius: 4,
      pointBorderWidth: 8,
    };

    var speedData = {
      labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"],
      datasets: [dataFirst]
    };

    var chartOptions = {
      legend: {
        display: false,
        position: 'top'
      }
    };

    var lineChart = new Chart(speedCanvas, {
      type: 'line',
      hover: false,
      data: speedData,
      options: chartOptions
    });
  </script>
