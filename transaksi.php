<?php 
  $page = "transaksi";
  include('./template/header.php');

  ?>
      <div class="content" style="min-height: 80vh;">
        <div class="row">
          <div class="col-md-8">
            <div class="card ">
              <div class="card-header ">
              </div>
              <div class="card-body ">
                <table id="example" class="display table table-bordered" style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 10px;">No</th>
                            <th>Waktu & Tanggal</th>
                            <th>Berkas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                          $no = 1;
                          $sql = "SELECT * FROM `transaksi` ORDER BY `tgl_waktu_transaksi` DESC LIMIT 1000";
                          $result = mysqli_query($conn, $sql);
                          while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td>
                                <?php
                                    $date = $row['tgl_waktu_transaksi'];
                                    $date = explode(" ",$date);
                                    $new_date = tgl_indo($date[0]) . " (" . $date[1] . ")";

                                    echo $new_date;
                                ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-info btn-sm ml-2" data-toggle="modal" data-target="#berkas-<?=$row['id_transaksi']?>">
                                    <i class="nc-icon nc-single-copy-04"> Transaksi</i>
                                </button>
                            </td>
                        </tr>
                        <!-- Modal -->
                        <div class="modal fade" id="berkas-<?=$row['id_transaksi']?>" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-body">
                                <iframe src="./data-transaksi/<?=$row['berkas']?>" width="100%" height="700px"></iframe>
                              </div>
                            </div>
                          </div>
                        </div>
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
