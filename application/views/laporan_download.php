<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Laporan Download</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Laporan Download</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="ccol-md-12 mb-3">
                          <div class="row">
                            <div class="form-group col-md-12 ">
                              <label>Filter Berdasarkan:</label>
                              <div class="col-md-4">
                                <div class="input-group">
                                  <input type="text" class="form-control float-right"  placeholder="Tanggal" id="reservation">
                                </div>
                              </div>
                              <!-- /.input group -->
                            </div><br>
                            <div class="col-md-12">
                              <div class="form-group col-md-4">
                                <select class="select2 " multiple="multiple" data-placeholder="Status" style="width: 100%;" id="status">
                                    <option value="Ditolak">Ditolak</option>
                                    <option value="Request">Request</option>
                                    <option value="Berhasil">Berhasil</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-group col-md-4">
                                <select class="select2 " multiple="multiple" data-placeholder="Peminta" style="width: 100%;" id="peminta">
                                    <?php foreach ($user as $usr) : ?>
                                        <option value="<?php echo $usr->username;?>">
                                          <?php echo $usr->username?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <form action="<?php echo base_url() ?>c_laporan/printdownloadpdf" method="post" style="display: inline;">
                            <input type="hidden" name="ctk_reservasion" value="">
                            <input type="hidden" name="ctk_status" value="">
                            <input type="hidden" name="ctk_peminta" value="">
                            <button type="submit" class="btn  btn-danger">PDF</button>
                          </form>
                          <form action="<?php echo base_url() ?>c_laporan/printdownloadexcel/" method="post" style="display: inline;">
                            <input type="hidden" name="ctk_reservasion" value="">
                            <input type="hidden" name="ctk_status" value="">
                            <input type="hidden" name="ctk_peminta" value="">
                            <button type="submit" class="btn  btn-success">Excel</button>
                          </form>
                        </div>
                      <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal Request</th>
                                <th>Nama Dokumen</th>
                                <th>Peminta</th>
                                <th>Status</th>
                                <th>Keperluan</th>
                                <th>Tanggal Download</th>
                                <th>Kode Unik</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                    $no=1;
                                    foreach ($data_download_dokumen as $ddd) :
                                    $no++;
                                ?>
                                <tr>
                                    <td><?php echo $no ?></td>
                                    <td><?php $tglf =  $ddd['log'] ; echo date('d-m-Y', strtotime($tglf));?></td>
                                    <td><?php echo $ddd['nama_dokumen'] ?></td>
                                    <td><?php echo $ddd['peminta'] ?></td>
                                    <td><?php echo $ddd['status'] ?></td>
                                    <td><?php echo $ddd['keterangan'] ?></td> 
                                    <td>
                                      <?php 
                                      if( $ddd['tanggal_download'] != ''){
                                        echo date('d/m/Y', strtotime($ddd['tanggal_download']));
                                      }
                                      ?>
                                    </td> 
                                    <td><input  style="height:35px" type="text" value="<?php echo $ddd['kode_unik'] ?>" id="myInput<?php echo $no ?>" readonly></td>
                                    
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        
                      </table>
                      
                    </div>
                    <!-- /.card-body -->
                  </div>
            </div>
          <!-- ./col -->
          
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <script type="text/javascript">
      $(document).ready(function(){
        $("#status").change(function(){
          status();
        })
      })
      $(document).ready(function(){
        $("#peminta").change(function(){
          peminta();
        })
      })
      $(document).ready(function(){
        $("#reservation").change(function(){
          reservation1();
        })
      })

      function status(){
        var status = $("#status").val();
        var peminta = $("#peminta").val();
        var reservation = $("#reservation").val();
        $(function() {
              $("input[name=ctk_reservasion]").val(reservation);
              $("input[name=ctk_status]").val(status);
              $("input[name=ctk_peminta]").val(peminta);
            });
        $.ajax({
          url : "<?php echo base_url('c_laporan/load_download_dokumen') ?>",
          data: "status=" +status +"&peminta=" +peminta + "&reservation=" +reservation,
          success:function(data){
            $('#example1 tbody').html(data);
          }
        })
      } 
      function peminta(){
        var status = $("#status").val();
        var peminta = $("#peminta").val();
        var reservation = $("#reservation").val();
        $(function() {
              $("input[name=ctk_reservasion]").val(reservation);
              $("input[name=ctk_status]").val(status);
              $("input[name=ctk_peminta]").val(peminta);
            });
        $.ajax({
          url : "<?php echo base_url('c_laporan/load_download_dokumen') ?>",
          data: "status=" +status +"&peminta=" +peminta + "&reservation=" +reservation ,
          success:function(data){
            $('#example1 tbody').html(data);

          }
        })
      } 
      function reservation1(){
        var status = $("#status").val();
        var peminta = $("#peminta").val();
        var reservation = $("#reservation").val();
        $(function() {
              $("input[name=ctk_reservasion]").val(reservation);
              $("input[name=ctk_status]").val(status);
              $("input[name=ctk_peminta]").val(peminta);
            });
        $.ajax({
          url : "<?php echo base_url('c_laporan/load_download_dokumen') ?>",
          data: "status=" +status +"&peminta=" +peminta + "&reservation=" +reservation ,
          success:function(data){
            $('#example1 tbody').html(data);
          }
        })
      } 
      
    </script>