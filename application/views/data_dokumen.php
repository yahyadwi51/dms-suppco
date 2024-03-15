
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Data Dokumen</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Data Dokumen</li>
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
                        
                          <a href="<?php echo base_url() ?>c_data_dokumen/form_data_dokumen" class="col-md-2"><button type="button" class="btn btn-block btn-info btn-xs col-md-12">Tambah Dokumen</button></a>
                          <a href="<?php echo base_url();?>c_download_dokumen/detail_download_dokumen" class="col-md-3"><button type="button" class="btn btn-block btn-info btn-xs">Request Download Dokumen</button></a>
                          <div style="position: absolute;right: 0;"><a href="<?php echo base_url() ?>c_data_dokumen/permintaan_download"><button type="button" class="btn btn-block btn-info btn-xs">Permintaan Download 
                            <span class="badge bg-success">  
                                <?php
                                  foreach ($jumlahnotifikasi as $dd) :
                                ?>
                                  <?php echo $dd['jn']?>
                                <?php endforeach; ?>
                                  </span></button></a>
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
                        <div class="form-group mt-3">
                          <label>Filter Berdasarkan:</label>
                          <div class="col-md-4">
                            <div class="input-group">
                              <input type="text" class="form-control float-right" placeholder="Tanggal" id="reservation">
                            </div>
                          </div>
                          <!-- /.input group -->
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <select class="select2 " multiple="multiple" data-placeholder="Jenis Dokumen" style="width: 100%;" id="jenis_dokumen">
                            <?php foreach ($master_jenis_dokumen as $jd) : ?>
                                <option value="<?php echo $jd['id'];?>">
                                        <?php echo $jd['nama_jenis_dokumen']?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <select class="select2 " multiple="multiple" data-placeholder="Bagian Pemilik" style="width: 100%;" id="bag_pemilik">
                            <?php foreach ($master_bagian as $usr) : ?>
                                    <option value="<?php echo $usr->id_bagian;?>" >
                                      <?php echo $usr->nama_bagian?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <select class="select2 " multiple="multiple" data-placeholder="Status Dokumen" style="width: 100%;" id="status_dokumen">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Akan kadaluarsa">Akan kadaluarsa</option>
                                    <option value="Kadaluarsa">Kadaluarsa</option>
                            </select>
                          </div>
                        </div>
                    </div>
                      <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Dokumen</th>
                            <th>Jenis Dokumen</th><p id="result"></p>
                            <th>Bagian/Kebun</th>
                            <th>PIC</th>
                            <th>Masa Aktif</th>
                            <th>Akses</th>
                            <th>Status</th>
                            <th>Action</th>
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
    
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Verifikasi</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="<?php echo base_url(). 'c_download_dokumen/generatekodeunik' ?>" method="post">
                <div class="form-group">
                    <input type="hidden" id="myText" name="id" value="">
                    <input type="hidden" id="myText1" name="nama_dokumen" value="">
                    <input type="hidden" id="myText2" name="no_telp" value="">
                    <input type="hidden" id="myText3" name="id_telegram" value="">
                    <label for="message-text" class="col-form-label">Keperluan:</label>
                    <textarea class="form-control" id="message-text" name="keterangan" ></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Dapatkan Kode Unik</button>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade" id="hapus_dokumen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form action="<?php echo base_url(). 'c_data_dokumen/delete' ?>" method="post">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                      <input type="hidden" id="id_delete" name="id" value="">
                      <h5 class="modal-title" id="exampleModalLabel">Apakah Anda yakin untuk menghapus dokumen tersebut ?</h5>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
              </div>
            </form>
          </div>
        </div>
    </div>
    
    <?php if ($this->session->flashdata('something')) { ?>
    <script>
    $(document).ready(function() {
      swal("Data Berhasil Ditambahkan", "", "success");

    });
    </script>

    <?php } ?>
    <?php if ($this->session->flashdata('something1')) { ?>
    <script>
    $(document).ready(function() {
      swal("Permintaan Download Telah Terkirim", "", "success");

    });
    </script>

    <?php } ?>
    <?php if ($this->session->flashdata('something2')) { ?>
    <script>
    $(document).ready(function() {
      swal("Dokumen Kosong", "", "error");

    });
    </script>

    <?php } ?>
    <?php if ($this->session->flashdata('something3')) { ?>
    <script>
    $(document).ready(function() {
      swal("Data berhasil dihapus", "", "success");

    });
    </script>

    <?php } ?>
    <?php if ($this->session->flashdata('something4')) { ?>
    <script>
    $(document).ready(function() {
      swal("Data berhasil diubah", "", "success");
    });
    </script>

    <?php } ?>
   
    <script type="text/javascript">
      function reply_click(clicked_id)
      {
        var res = clicked_id.split(",");
          document.getElementById("myText").value = res[0];
          document.getElementById("myText1").value = res[1];
          document.getElementById("myText2").value = res[2];
          document.getElementById("myText3").value = res[3];
      }
    </script>
    <script type="text/javascript">
      function reply_click1(clicked_id)
      {
          document.getElementById("id_delete").value = clicked_id;
      }
    </script>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#status_dokumen").change(function(){
          status_dokumen();
        })
      })
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
      function status_dokumen(){
        var status_dokumen = $("#status_dokumen").val();
        var reservation = $("#reservation").val();
        var jenis_dokumen = $("#jenis_dokumen").val();
        var bag_pemilik = $("#bag_pemilik").val();
        var customRadio2='';
        var customRadio3='';
        var customRadio4='';
        if ($("#customRadio2").is(':checked')) {
          var customRadio2 = $("#customRadio2").val();
        }else if($("#customRadio3").is(':checked')){
          var customRadio3 = $("#customRadio3").val();
        }else if($("#customRadio4").is(':checked')){
          var customRadio4 = $("#customRadio4").val();
        }
        
        $.ajax({
          url : "<?php echo base_url('c_data_dokumen/load_jenis_data_dokumen') ?>",
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
            if ($("#customRadio2").is(':checked')) {
              var customRadio2 = $("#customRadio2").val();
            }else if($("#customRadio3").is(':checked')){
              var customRadio3 = $("#customRadio3").val();
            }else if($("#customRadio4").is(':checked')){
              var customRadio4 = $("#customRadio4").val();
            }
            $.ajax({
              url : "<?php echo base_url('c_data_dokumen/load_jenis_data_dokumen') ?>",
              data: "status_dokumen=" +status_dokumen+"&reservation=" +reservation+"&jenis_dokumen=" +jenis_dokumen+"&bag_pemilik=" +bag_pemilik+"&customRadio2=" +customRadio2+"&customRadio3=" +customRadio3+"&customRadio4=" +customRadio4 ,
              success:function(data){
                $('#example2 tbody').html(data);
              }
            })
        })
      })
      $(document).ready(function(){
        $("#customRadio1").change(function(){
            var status_dokumen = $("#status_dokumen").val();
            var reservation = $("#reservation").val();
            var jenis_dokumen = $("#jenis_dokumen").val();
            var bag_pemilik = $("#bag_pemilik").val();
            $.ajax({
              url : "<?php echo base_url('c_data_dokumen/load_jenis_data_dokumen') ?>",
              data: "status_dokumen=" +status_dokumen+"&reservation=" +reservation+"&jenis_dokumen=" +jenis_dokumen+"&bag_pemilik=" +bag_pemilik ,
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
          if ($("#customRadio2").is(':checked')) {
            var customRadio2 = $("#customRadio2").val();
          }else if($("#customRadio3").is(':checked')){
            var customRadio3 = $("#customRadio3").val();
          }else if($("#customRadio4").is(':checked')){
            var customRadio4 = $("#customRadio4").val();
          }
            $.ajax({
              url : "<?php echo base_url('c_data_dokumen/load_jenis_data_dokumen') ?>",
              data: "status_dokumen=" +status_dokumen+"&reservation=" +reservation+"&jenis_dokumen=" +jenis_dokumen+"&bag_pemilik=" +bag_pemilik+"&customRadio2=" +customRadio2+"&customRadio3=" +customRadio3+"&customRadio4=" +customRadio4 ,
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
          if ($("#customRadio2").is(':checked')) {
            var customRadio2 = $("#customRadio2").val();
          }else if($("#customRadio3").is(':checked')){
            var customRadio3 = $("#customRadio3").val();
          }else if($("#customRadio4").is(':checked')){
            var customRadio4 = $("#customRadio4").val();
          }
            $.ajax({
              url : "<?php echo base_url('c_data_dokumen/load_jenis_data_dokumen') ?>",
              data: "status_dokumen=" +status_dokumen+"&reservation=" +reservation+"&jenis_dokumen=" +jenis_dokumen+"&bag_pemilik=" +bag_pemilik+"&customRadio2=" +customRadio2+"&customRadio3=" +customRadio3+"&customRadio4=" +customRadio4 ,
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
        if ($("#customRadio2").is(':checked')) {
          var customRadio2 = $("#customRadio2").val();
        }else if($("#customRadio3").is(':checked')){
          var customRadio3 = $("#customRadio3").val();
        }else if($("#customRadio4").is(':checked')){
          var customRadio4 = $("#customRadio4").val();
        }
        $.ajax({
          url : "<?php echo base_url('c_data_dokumen/load_jenis_data_dokumen') ?>",
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
        if ($("#customRadio2").is(':checked')) {
          var customRadio2 = $("#customRadio2").val();
        }else if($("#customRadio3").is(':checked')){
          var customRadio3 = $("#customRadio3").val();
        }else if($("#customRadio4").is(':checked')){
          var customRadio4 = $("#customRadio4").val();
        }
        $.ajax({
          url : "<?php echo base_url('c_data_dokumen/load_jenis_data_dokumen') ?>",
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
        if ($("#customRadio2").is(':checked')) {
          var customRadio2 = $("#customRadio2").val();
        }else if($("#customRadio3").is(':checked')){
          var customRadio3 = $("#customRadio3").val();
        }else if($("#customRadio4").is(':checked')){
          var customRadio4 = $("#customRadio4").val();
        }
        $.ajax({
          url : "<?php echo base_url('c_data_dokumen/load_jenis_data_dokumen') ?>",
          data: "status_dokumen=" +status_dokumen+"&reservation=" +reservation+"&jenis_dokumen=" +jenis_dokumen+"&bag_pemilik=" +bag_pemilik+"&customRadio2=" +customRadio2+"&customRadio3=" +customRadio3+"&customRadio4=" +customRadio4,
          success:function(data){
            $('#example2 tbody').html(data);
          }
        })
      } 
    </script>
    