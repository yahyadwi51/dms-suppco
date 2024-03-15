<style>
    table {
      width: 500px;
      border: none;
      border-top: 1px solid #EEEEEE;
      font-family: arial, sans-serif;
      border-collapse: collapse;
    }

    

    .extendtable {
      background-color: #fff;
      border: none;
      cursor: pointer;
      display: grid;
      zoom: 80%;
      grid-template-columns: repeat(8, 1fr);
      justify-content: flex-start;
    }


    .expanded-row-content {
      border-top: none;
      display: grid;
      grid-column: 1/-1;
      justify-content: flex-start;
      color: #AEB1B3;
      font-size: 13px;
      background-color: #fff;
    }

    .hide-row {
      display: none;
    }
  </style>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Laporan Dokumen</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Laporan Dokumen</li>
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
                  <div class="col-md-12 mb-3">
                    <div class="row">
                        <div class="form-group col-md-12 ">
                          <label>Filter Berdasarkan:</label>
                          <div class="col-md-4">
                            <div class="input-group">
                              <input type="text" class="form-control float-right" placeholder="Tanggal"  id="reservation">
                            </div>
                          </div>
                          <!-- /.input group -->
                        </div><br>
                        <div class="col-md-12">
                          <div class="form-group col-md-4">
                            <select class="select2 " multiple="multiple" data-placeholder="Jenis Dokumen" style="width: 100%;" id="jenis_dokumen">
                            <?php foreach ($master_jenis_dokumen as $jd) : ?>
                                <option value="<?php echo $jd['id'];?>">
                                        <?php echo $jd['nama_jenis_dokumen']?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group col-md-4">
                            <select class="select2 " multiple="multiple" data-placeholder="Bagian Pemilik" style="width: 100%;" id="bag_pemilik">
                                <?php foreach ($master_bagian as $usr) : ?>
                                    <option value="<?php echo $usr->id_bagian;?>" >
                                      <?php echo $usr->nama_bagian?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group col-md-4">
                            <select class="select2 " multiple="multiple" data-placeholder="Status Dokumen" style="width: 100%;" id="status_dokumen">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Akan kadaluarsa">Akan kadaluarsa</option>
                                    <option value="Kadaluarsa">Kadaluarsa</option>
                            </select>
                          </div>
                        </div>
                          <div style="position:absolute; right: 0;">
                          
                                  <?php 
                                   $id = $this->session->userdata('id');
                                    if($id != 1){
                                  ?>
                            <div class="col-sm-12 mt-3">
                                <!-- radio -->
                                <label>Tampilkan Berdasarkan :</label>
                                <div class="form-group">
                                  <div class="custom-control custom-radio">
                                    <input class="custom-control-input cekdokumen" type="radio" id="customRadio1" name="customRadio" value="" checked>
                                    <label for="customRadio1" class="custom-control-label">Semua Dokumen</label>
                                  </div>
                                  <div class="custom-control custom-radio">
                                    <input class="custom-control-input cekdokumen" type="radio" id="customRadio2" name="customRadio" value="<?php echo $this->session->userdata('bagian')?>">
                                    <label for="customRadio2" class="custom-control-label">Dokumen Sendiri</label>
                                  </div>
                                  <div class="custom-control custom-radio">
                                    <input class="custom-control-input cekdokumen" type="radio" id="customRadio3" name="customRadio" value="<?php echo $this->session->userdata('bagian')?>">
                                    <label for="customRadio3" class="custom-control-label">Dokumen yang di beri akses</label>
                                  </div>
                                  <div class="custom-control custom-radio">
                                    <input class="custom-control-input cekdokumen" type="radio" id="customRadio4" name="customRadio" value="<?php echo $this->session->userdata('id')?>">
                                    <label for="customRadio4" class="custom-control-label">Pic Utama</label>
                                  </div>
                                </div>
                            </div>
                            <?php }?>
                          </div>
                    </div>
                    <form action="<?php echo base_url() ?>c_laporan/printpdf/" method="post" style="display: inline;">
                      <input type="hidden" name="ctk_statusdokumen" value="">
                      <input type="hidden" name="ctk_reservasion" value="">
                      <input type="hidden" name="ctk_jenis_dokumen" value="">
                      <input type="hidden" name="ctk_bag_pemilik" value="">
                      <input type="hidden" name="ctk_customRadio2" value="">
                      <input type="hidden" name="ctk_customRadio3" value="">
                      <input type="hidden" name="ctk_customRadio4" value="">
                      <button type="submit" class="btn  btn-danger">PDF</button>
                    </form>
                    <form action="<?php echo base_url() ?>c_laporan/printexcel/" method="post" style="display: inline;">
                      <input type="hidden" name="ctk_statusdokumen" value="">
                      <input type="hidden" name="ctk_reservasion" value="">
                      <input type="hidden" name="ctk_jenis_dokumen" value="">
                      <input type="hidden" name="ctk_bag_pemilik" value="">
                      <input type="hidden" name="ctk_customRadio2" value="">
                      <input type="hidden" name="ctk_customRadio3" value="">
                      <input type="hidden" name="ctk_customRadio4" value="">
                      <button type="submit" class="btn  btn-success">Excel</button>
                    </form>
                  </div>
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                    <tr class="extendtable">
                        <th>#</th>
                        <th>Nama Dokumen</th>
                        <th>Jenis Dokumen</th>
                        <th>Bagian/Kebun</th>
                        <th>PIC</th>
                        <th>Masa Aktif</th>
                        <th>Akses</th>
                        <th>status</th>
                    </tr>
                    </thead>
                    <tbody>
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
<script>
    const toggleRow = (element) => {
      element.getElementsByClassName('expanded-row-content')[0].classList.toggle('hide-row');
    }
  </script>
<script type="text/javascript">
      $(document).ready(function(){
        $("#jenis_dokumen").change(function(){
          jenis_dkm();
        })
      })
      $(document).ready(function(){
        $("#bag_pemilik").change(function(){
          bag_keb();
        })
      })
      $(document).ready(function(){
        $("#reservation").change(function(){
          reservation1();
        })
      })
      $(document).ready(function(){
        $("#status_dokumen").change(function(){
          status_dokumen();
        })
      })
      function status_dokumen(){
        var status_dokumen = $("#status_dokumen").val();
        var reservation = $("#reservation").val();
        var jenis_dokumen = $("#jenis_dokumen").val();
        var bag_pemilik = $("#bag_pemilik").val();
        var customRadio2='';
        var customRadio3='';
        var customRadio4='';
        $(function() {
              $("input[name=ctk_statusdokumen]").val(status_dokumen);
              $("input[name=ctk_reservasion]").val(reservation);
              $("input[name=ctk_jenis_dokumen]").val(jenis_dokumen);
              $("input[name=ctk_bag_pemilik]").val(bag_pemilik);
              $("input[name=ctk_customRadio2]").val(customRadio2);
              $("input[name=ctk_customRadio3]").val(customRadio3);
              $("input[name=ctk_customRadio4]").val(customRadio4);
            });
        if ($("#customRadio2").is(':checked')) {
          var customRadio2 = $("#customRadio2").val();
        }else if($("#customRadio3").is(':checked')){
          var customRadio3 = $("#customRadio3").val();
        }else if($("#customRadio4").is(':checked')){
          var customRadio4 = $("#customRadio4").val();
        }
        
        $.ajax({
          url : "<?php echo base_url('c_laporan/load_jenis_data_dokumen') ?>",
          data: "status_dokumen=" +status_dokumen+"&reservation=" +reservation+"&jenis_dokumen=" +jenis_dokumen+"&bag_pemilik=" +bag_pemilik+"&customRadio2=" +customRadio2+"&customRadio3=" +customRadio3+"&customRadio4=" +customRadio4,
          success:function(data){
            $('#example2 tbody').html(data);
          }
        })
      } 
      $(document).ready(function(){
        $("#customRadio2").change(function(){
            var status_dokumen = $("#status_dokumen").val();
            var reservation = $("#reservation").val();
            var jenis_dokumen = $("#jenis_dokumen").val();
            var bag_pemilik = $("#bag_pemilik").val();
            var customRadio2='';
            var customRadio3='';
            var customRadio4='';
            $(function() {
              $("input[name=ctk_statusdokumen]").val(status_dokumen);
              $("input[name=ctk_reservasion]").val(reservation);
              $("input[name=ctk_jenis_dokumen]").val(jenis_dokumen);
              $("input[name=ctk_bag_pemilik]").val(bag_pemilik);
              $("input[name=ctk_customRadio2]").val(customRadio2);
              $("input[name=ctk_customRadio3]").val(customRadio3);
              $("input[name=ctk_customRadio4]").val(customRadio4);
            });
            if ($("#customRadio2").is(':checked')) {
              var customRadio2 = $("#customRadio2").val();
            }else if($("#customRadio3").is(':checked')){
              var customRadio3 = $("#customRadio3").val();
            }else if($("#customRadio4").is(':checked')){
              var customRadio4 = $("#customRadio4").val();
            }
            $.ajax({
              url : "<?php echo base_url('c_laporan/load_jenis_data_dokumen') ?>",
              data: "status_dokumen=" +status_dokumen+"&reservation=" +reservation+"&jenis_dokumen=" +jenis_dokumen+"&bag_pemilik=" +bag_pemilik+"&customRadio2=" +customRadio2+"&customRadio3=" +customRadio3+"&customRadio4=" +customRadio4,
              success:function(data){
                $('#example2 tbody').html(data);
                
              }
            })
        })
      })
      $(document).ready(function(){
        $("#customRadio1").change(function(){
            var reservation = $("#reservation").val();
            var jenis_dokumen = $("#jenis_dokumen").val();
            var bag_pemilik = $("#bag_pemilik").val();
            $.ajax({
              url : "<?php echo base_url('c_laporan/load_jenis_data_dokumen') ?>",
              data: "reservation=" +reservation+"&jenis_dokumen=" +jenis_dokumen+"&bag_pemilik=" +bag_pemilik ,
              success:function(data){
                $('#example2 tbody').html(data);
                
              }
            })
        })
      })
      $(document).ready(function(){
        $("#customRadio3").change(function(){
          var status_dokumen = $("#status_dokumen").val();
          var reservation = $("#reservation").val();
          var jenis_dokumen = $("#jenis_dokumen").val();
          var bag_pemilik = $("#bag_pemilik").val();
          var customRadio2='';
          var customRadio3='';
          var customRadio4='';
          $(function() {
              $("input[name=ctk_reservasion]").val(reservation);
              $("input[name=ctk_statusdokumen]").val(status_dokumen);
              $("input[name=ctk_jenis_dokumen]").val(jenis_dokumen);
              $("input[name=ctk_bag_pemilik]").val(bag_pemilik);
              $("input[name=ctk_customRadio2]").val(customRadio2);
              $("input[name=ctk_customRadio3]").val(customRadio3);
              $("input[name=ctk_customRadio4]").val(customRadio4);
            });
          if ($("#customRadio2").is(':checked')) {
            var customRadio2 = $("#customRadio2").val();
          }else if($("#customRadio3").is(':checked')){
            var customRadio3 = $("#customRadio3").val();
          }else if($("#customRadio4").is(':checked')){
              var customRadio4 = $("#customRadio4").val();
            }
            $.ajax({
              url : "<?php echo base_url('c_laporan/load_jenis_data_dokumen') ?>",
              data: "status_dokumen=" +status_dokumen+"&reservation=" +reservation+"&jenis_dokumen=" +jenis_dokumen+"&bag_pemilik=" +bag_pemilik+"&customRadio2=" +customRadio2+"&customRadio3=" +customRadio3+"&customRadio4=" +customRadio4,
              success:function(data){
                $('#example2 tbody').html(data);
                
              }
            })
        })
      })
      $(document).ready(function(){
        $("#customRadio4").change(function(){
          var status_dokumen = $("#status_dokumen").val();
          var reservation = $("#reservation").val();
          var jenis_dokumen = $("#jenis_dokumen").val();
          var bag_pemilik = $("#bag_pemilik").val();
          var customRadio2='';
          var customRadio3='';
          var customRadio4='';
          $(function() {
              $("input[name=ctk_statusdokumen]").val(status_dokumen);
              $("input[name=ctk_reservasion]").val(reservation);
              $("input[name=ctk_jenis_dokumen]").val(jenis_dokumen);
              $("input[name=ctk_bag_pemilik]").val(bag_pemilik);
              $("input[name=ctk_customRadio2]").val(customRadio2);
              $("input[name=ctk_customRadio3]").val(customRadio3);
              $("input[name=ctk_customRadio4]").val(customRadio4);
            });
          if ($("#customRadio2").is(':checked')) {
            var customRadio2 = $("#customRadio2").val();
          }else if($("#customRadio3").is(':checked')){
            var customRadio3 = $("#customRadio3").val();
          }else if($("#customRadio4").is(':checked')){
            var customRadio4 = $("#customRadio4").val();
          }
            $.ajax({
              url : "<?php echo base_url('c_laporan/load_jenis_data_dokumen') ?>",
              data: "status_dokumen=" +status_dokumen+"&reservation=" +reservation+"&jenis_dokumen=" +jenis_dokumen+"&bag_pemilik=" +bag_pemilik+"&customRadio2=" +customRadio2+"&customRadio3=" +customRadio3+"&customRadio4=" +customRadio4,
              success:function(data){
                $('#example2 tbody').html(data);
              }
            })
        })
      })

      function jenis_dkm(){
        var status_dokumen = $("#status_dokumen").val();
        var reservation = $("#reservation").val();
        var jenis_dokumen = $("#jenis_dokumen").val();
        var bag_pemilik = $("#bag_pemilik").val();
        var customRadio2='';
        var customRadio3='';
        var customRadio4='';
        $(function() {
              $("input[name=ctk_reservasion]").val(reservation);
              $("input[name=ctk_statusdokumen]").val(status_dokumen);
              $("input[name=ctk_jenis_dokumen]").val(jenis_dokumen);
              $("input[name=ctk_bag_pemilik]").val(bag_pemilik);
              $("input[name=ctk_customRadio2]").val(customRadio2);
              $("input[name=ctk_customRadio3]").val(customRadio3);
              $("input[name=ctk_customRadio4]").val(customRadio4);
            });
        if ($("#customRadio2").is(':checked')) {
          var customRadio2 = $("#customRadio2").val();
        }else if($("#customRadio3").is(':checked')){
          var customRadio3 = $("#customRadio3").val();
        }else if($("#customRadio4").is(':checked')){
              var customRadio4 = $("#customRadio4").val();
            }
        $.ajax({
          url : "<?php echo base_url('c_laporan/load_jenis_data_dokumen') ?>",
          data: "status_dokumen=" +status_dokumen+"&reservation=" +reservation+"&jenis_dokumen=" +jenis_dokumen+"&bag_pemilik=" +bag_pemilik+"&customRadio2=" +customRadio2+"&customRadio3=" +customRadio3+"&customRadio4=" +customRadio4,
          success:function(data){
            $('#example2 tbody').html(data);
            
          }
        })
      } 
      function bag_keb(){
        var status_dokumen = $("#status_dokumen").val();
        var reservation = $("#reservation").val();
        var jenis_dokumen = $("#jenis_dokumen").val();
        var bag_pemilik = $("#bag_pemilik").val();
        var customRadio2='';
        var customRadio3='';
        var customRadio4='';
        $(function() {
              $("input[name=ctk_reservasion]").val(reservation);
              $("input[name=ctk_statusdokumen]").val(status_dokumen);
              $("input[name=ctk_jenis_dokumen]").val(jenis_dokumen);
              $("input[name=ctk_bag_pemilik]").val(bag_pemilik);
              $("input[name=ctk_customRadio2]").val(customRadio2);
              $("input[name=ctk_customRadio3]").val(customRadio3);
              $("input[name=ctk_customRadio4]").val(customRadio4);
            });
        if ($("#customRadio2").is(':checked')) {
          var customRadio2 = $("#customRadio2").val();
        }else if($("#customRadio3").is(':checked')){
          var customRadio3 = $("#customRadio3").val();
        }else if($("#customRadio4").is(':checked')){
              var customRadio4 = $("#customRadio4").val();
            }
        $.ajax({
          url : "<?php echo base_url('c_laporan/load_jenis_data_dokumen') ?>",
          data: "status_dokumen=" +status_dokumen+"&reservation=" +reservation+"&jenis_dokumen=" +jenis_dokumen+"&bag_pemilik=" +bag_pemilik+"&customRadio2=" +customRadio2+"&customRadio3=" +customRadio3+"&customRadio4=" +customRadio4,
          success:function(data){
            $('#example2 tbody').html(data);
           
          }
        })
      } 
      function reservation1(){
        var status_dokumen = $("#status_dokumen").val();
        var reservation = $("#reservation").val();
        var jenis_dokumen = $("#jenis_dokumen").val();
        var bag_pemilik = $("#bag_pemilik").val();
        var customRadio2='';
        var customRadio3='';
        var customRadio4='';
        $(function() {
              $("input[name=ctk_reservasion]").val(reservation);
              $("input[name=ctk_statusdokumen]").val(status_dokumen);
              $("input[name=ctk_jenis_dokumen]").val(jenis_dokumen);
              $("input[name=ctk_bag_pemilik]").val(bag_pemilik);
              $("input[name=ctk_customRadio2]").val(customRadio2);
              $("input[name=ctk_customRadio3]").val(customRadio3);
              $("input[name=ctk_customRadio4]").val(customRadio4);
            });
        if ($("#customRadio2").is(':checked')) {
          var customRadio2 = $("#customRadio2").val();
        }else if($("#customRadio3").is(':checked')){
          var customRadio3 = $("#customRadio3").val();
        }else if($("#customRadio4").is(':checked')){
              var customRadio4 = $("#customRadio4").val();
            }
        $.ajax({
          url : "<?php echo base_url('c_laporan/load_jenis_data_dokumen') ?>",
          data: "status_dokumen=" +status_dokumen+"&reservation=" +reservation+"&jenis_dokumen=" +jenis_dokumen+"&bag_pemilik=" +bag_pemilik+"&customRadio2=" +customRadio2+"&customRadio3=" +customRadio3+"&customRadio4=" +customRadio4,
          success:function(data){
            $('#example2 tbody').html(data);
            
          }
        })
      } 
    </script>