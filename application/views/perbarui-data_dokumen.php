<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/dropzone/min/dropzone.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/adminlte.min.css">
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url() ?>c_data_dokumen" class="brand-link" align="center">
    <span class="brand-text font-weight-light">JASINFO <b>PTPN XII</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <!-- <li class="nav-item ">
            <a href="<?php echo base_url() ?>c_index" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li> -->
          <li class="nav-item ">
            <a href="<?php echo base_url() ?>c_data_dokumen" class="nav-link ">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Data Dokumen
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>


  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-12 mt-3">
                <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Perbarui Data Dokumen</h3>
                      <div style="position: absolute;right: 8px;top: 8px;">
                      <!-- <button type="button" class="btn btn-block bg-gradient-secondary btn-sm" data-toggle="modal" data-target="#exampleModalCenter">Perbarui Masa Aktif</button> -->
                    </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <?php foreach ($data_dokumen as $dd) :?>
                    <form onsubmit="return Validate(this);" action="<?php echo base_url(). 'c_data_dokumen/tambah_perbarui_data_dokumen' ?>" method="post" enctype="multipart/form-data">
                      <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Nama Dokumen</label>
                          <input type="hidden" name="id_dokumen" class="form-control" value="<?php echo $dd->id ?>" >
                          <input type="text" class="form-control" id="exampleInputEmail1"  value="<?php echo $dd->nama_dokumen ?>" name="nama_dokumen" readonly>
                        </div>
                        <div class="form-group">
                            <label>Jenis Dokumen</label>
                            <select class="form-control select2" style="width: 100%;" name="jenis_dok" disabled="disabled"> 
                              <?php foreach ($jenis_dokumen as $jd) : ?>
                                <option data-id="<?php foreach ($data_dokumen as $dd) : ?><?php echo $dd->durasi_tahun ?> <?php echo $dd->durasi_bulan ?> <?php echo $dd->durasi_tgl ?><?php endforeach; ?>" value="<?php echo $jd->id;?>"
                                          <?php 
                                            if ($jd->id == $dd->jenis_dok) {
                                              echo "selected";
                                            }
                                        ?>>
                                        <?php echo $jd->nama_jenis_dokumen?> 
                                </option>
                              <?php endforeach; ?>
                            </select>
                        </div>
                              <div class="row">
                                <div class="col-12">
                                    <span>* Durasi Pengingat</span>
                                </div>
                                <div class="input-group mb-3 col-3">
                                  <input type="number" class="form-control" id="durasi_tahun" onKeyPress="if(this.value.length==2) return false;"  name="drs_tahun" readonly>
                                  <div class="input-group-append">
                                    <span class="input-group-text">Tahun</span>
                                  </div>
                                </div>
                                <div class="input-group mb-3 col-3">
                                <input type="number" class="form-control"  id="durasi_bulan" onKeyPress="if(this.value.length==2) return false;"  name="drs_bulan" readonly>
                                  <div class="input-group-append">
                                    <span class="input-group-text">Bulan</span> 
                                  </div>
                                </div>
                                  
                                <div class="input-group mb-3 col-3">
                                  <input type="number" class="form-control"  id="durasi_hari" onKeyPress="if(this.value.length==2) return false;" name="drs_hari" readonly>
                                  <div class="input-group-append">
                                    <span class="input-group-text">Hari</span>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                            <label>Bagian/Kebun</label>
                            <?php 
                                $role_id = $this->session->userdata('role_id');
                                $username = $this->session->userdata('username');
                                $bagian = $this->session->userdata('bagian');
                                $query_dokumen = $this->db->query("SELECT * FROM tb_master_bagian WHERE id_bagian ='$bagian'");
                                $data['datamasterbagian'] = $query_dokumen->result_array();
                                // print_r( $data['datamasterbagian']);
                                // die();
                                if($role_id == 1){
                                ?>
                            <select class="form-control select2" style="width: 100%;" disabled="disabled" name="bag_or_keb">
                            
                              <?php foreach ($master_bagian as $bk) : ?>
                                <option value="<?php echo $bk->id_bagian;?>" 
                                        <?php 
                                            if ($bk->id_bagian == $dd->bag_or_keb) {
                                              echo "selected";
                                            }
                                        ?>>
                                        <?php echo $bk->nama_bagian?></option>
                              <?php endforeach; ?>
                            </select>
                            <?php
                                }elseif($role_id != 1){
                            ?>
                             <input type="hidden" class="form-control" id="exampleInputEmail1" name="bag_or_keb" value="<?php echo $data['datamasterbagian'][0]['id_bagian'] ?> " >
                             <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $data['datamasterbagian'][0]['nama_bagian'] ?> " readonly>
                           
                                <?php }?>
                        </div>
                        <div class="form-group">
                            <label>PIC</label>
                            <select class="form-control select2" style="width: 100%;" name="pic" disabled="disabled">
                                <option selected>- Pilih PIC - </option>
                                <?php foreach ($user as $usr) : ?>
                                    <option value="<?php echo $usr->id;?>" <?php 
                                            if ($usr->id == $dd->pic) {
                                              echo "selected";
                                            }
                                        ?>>
                                      <?php echo $usr->username?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- <div class="form-group">
                            <label for="exampleInputEmail1">PIC</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="pic" value="<?php echo $dd->pic ?>" readonly>
                        </div> -->
                        
                        <div class="form-group">
                            <label>Masa aktif Baru:</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="far fa-calendar-alt"></i>
                                </span>
                              </div>
                              <input type="text" class="form-control float-right" id="reservation" value="<?php echo date('d/m/Y', strtotime($dd->masa_aktif_awal))." - ".date('d/m/Y', strtotime($dd->masa_aktif_akhir)) ?>"  name="masa_aktif">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group" hidden>
                            <label>Masa aktif:</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="far fa-calendar-alt"></i>
                                </span>
                              </div>
                              <input type="text" class="form-control float-right" id="reservation" value="<?php echo date('d/m/Y', strtotime($dd->masa_aktif_awal))." - ".date('d/m/Y', strtotime($dd->masa_aktif_akhir)) ?>"  name="masa_aktif_lama">
                            </div>
                            <!-- /.input group -->
                        </div>
                        <div class="form-group">
                            <label>Memberikan Akses ke</label>
                            <select class="select2bs4" multiple="multiple" style="width: 100%;" name="akses_for[]" data-live-search="true" disabled="disabled" multiple required>
                            <?php foreach ($master_bagian as $usr) : ?>
                                    <option value="<?php echo $usr->id_bagian;?>" 
                                      <?php 
                                          $str = $dd->akses_for;
                                          $akses = explode(",",$str);
                                          if (in_array($usr->id_bagian, $akses)) {
                                            echo "selected";
                                          }
                                      ?> >
                                      <?php echo $usr->nama_bagian?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                          </div>
                        <div class="form-group">
                          <label for="exampleInputFile">Upload Dokumen</label>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="exampleInputFile" name="upload_dokumen" value="<?php echo $dd->upload_dokumen ?>" required>
                              <input type="text" class="custom-file-input" id="exampleInputFile" name="upload_dokument" value="<?php echo $dd->upload_dokumen ?>">
                              <label class="custom-file-label" for="exampleInputFile"><?php echo $dd->upload_dokumen ?></label>
                            </div>
                            <div class="input-group-append">
                              <span class="input-group-text">*jpg,pdf,png</span>
                            </div>
                          </div>
                        </div>
                        
                      </div>
                      <!-- /.card-body -->
      
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                      </div>
                    </form>
                    <?php endforeach; ?>
                  </div>
            </div>
            
          <!-- ./col -->
          
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <div class="row">
    <div class="col-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Dokumen</th>
                    <th>Jenis Dokumen</th>
                    <th>Bagian/Kebun</th>
                    <th>PIC</th>
                    <th>Masa Aktif Lama</th>
                    <th>Upload Dokumen</th>
                    <th>Log Pembaruan</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                            $no=0;
                            foreach ($histori_data_dokumen as $hdd) :
                            $no++;
                    ?>
                    <tr>
                        <td><?php echo $no ?></td>
                        <td><?php echo $hdd['nama_dokumen'] ?></td>
                        <td><?php echo $hdd['nama_jenis_dokumen'] ?></td>
                        <td><?php echo $hdd['nama_bagian'] ?></td>
                        <td><?php echo $hdd['pic'] ?></td>
                        <td><?php echo $hdd['masa_aktif_awal_lama'] ?>- <?php echo $hdd['masa_aktif_akhir_lama'] ?></td>
                        <td><?php echo $hdd['upload_dokumen_lama'] ?></td>
                        <td><?php echo $cnvrt_masa_aktif_awal = date('d-m-Y', strtotime($hdd['log'])); ?></td>
                        <td>
                        <?php 
                        if($hdd['upload_dokumen_lama'] != '')
                        {
                          echo '<form action="'. base_url() . 'c_data_dokumen/lakukan_download_pemilik/' .  $hdd['upload_dokumen_lama'] .'/'.$hdd['iddok'].'"method="post">';
                        }
                        else{
                          echo '<form action="'. base_url() . 'c_data_dokumen/lakukan_download_pemilik/0/'. $hdd['iddok'].'"method="post">';
                        }
                        ?>
                          
                              <div class="input-group input-group-sm mt-2">
                                  <span class="input-group-append">
                                      <button type="submit" class="btn bg-gradient-success btn-sm" title="Download"><i
                                              class="fas fa-download"></i></button>
                                  </span>
                              </div>
                          </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                
              </table>
            </div>
            <!-- /.card-body -->
          </div>
    </div>
</div>
    <!-- /.content -->
  </div>

  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" action="<?php echo base_url(). 'c_data_dokumen/tambah_histori_data_dokumen'?>" method="post" enctype="multipart/form-data">
        <div class="modal-content">
              <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle">Status Perpanjang </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
              </div>
                <?php foreach ($data_dokumen as $dd) :?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Masa aktif:</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="far fa-calendar-alt"></i>
                            </span>
                          </div>
                          <input type="hidden" class="form-control float-right" value="<?php echo $dd->id ?>" name="id_dokumen">
                          <input type="text" class="form-control float-right"  value="<?php echo date('d/m/Y', strtotime($dd->masa_aktif_awal))." - ".date('d/m/Y', strtotime($dd->masa_aktif_akhir)) ?>"  id="reservation1" name="pembaruan_tanggal">
                        </div>
                        <!-- /.input group -->
                    </div>
                </div>
                <?php endforeach; ?>
              <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Perbarui</button>
              </div>
          </div>
        </form>   
    </div>
  </div>


  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2020 <a href="https://jasinfo.ptpn12.com">Jasinfo</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0-pre
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

<!-- ./wrapper -->

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
  <?php if ($this->session->flashdata('something1')) { ?>
<script>
    swal("Data Upload Dokumen Kosong", "Anda Tidak Bisa Mendownload", "error");
</script>
<?php } ?>
<?php if ($this->session->flashdata('something5')) { ?>
    <script>
      swal("Dokumen Berhasil Diperbarui", "", "success");
    </script>

    <?php } ?>
<!-- jQuery -->
<script src="<?php echo base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url() ?>assets/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="<?php echo base_url() ?>assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="<?php echo base_url() ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url() ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="<?php echo base_url() ?>assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="<?php echo base_url() ?>assets/plugins/dropzone/min/dropzone.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url() ?>assets/dist/js/demo.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
var _validFileExtensions = [".jpg", ".jpeg", ".pdf", ".png"]; 
function Validate(oForm) {
    var arrInputs = oForm.getElementsByTagName("input");
    for (var i = 0; i < arrInputs.length; i++) {
        var oInput = arrInputs[i];
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }
                
                if (!blnValid) {
                    alert("Format upload harus : " + _validFileExtensions.join(", "));
                    return false;
                }
            }
        }
    }
  
    return true;
}
</script>
<script>
$(function () {
  bsCustomFileInput.init();
});
$('#jns_dok').ready(function(){
  var data_tgl = $(this).find(':selected').data('id');
    var explode = data_tgl.split(" ");
    $("#durasi_tahun").val(explode[0]);
    $("#durasi_bulan").val(explode[1]);
    $("#durasi_hari").val(explode[2]);
});
$('#jns_dok').change(function(){
    var data_tgl = $(this).find(':selected').data('id');
    var explode = data_tgl.split(" ");
    $("#durasi_tahun").val(explode[0]);
    $("#durasi_bulan").val(explode[1]);
    $("#durasi_hari").val(explode[2]);
});
</script>
<script>
$(document).ready(function() { 
    $("#select2-search__field").select2({ width: '70px' });           
});
</script>
<script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()
  
      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
  
      //Datemask dd/mm/yyyy
      $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
      //Datemask2 mm/dd/yyyy
      $('#datemask2').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
      //Money Euro
      $('[data-mask]').inputmask()
  
      //Date range picker
      $('#reservationdate').datetimepicker({
          format: 'L'
      });
      //Date range picker
      $('#reservation').daterangepicker({
        locale: {
          format: 'DD/MM/YYYY'
        }
      })
      $('#reservation1').daterangepicker(
        {
          locale: {
            format: 'DD/MM/YYYY'
          }
        }
      )
      //Date range picker with time picker
      $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
          format: 'DD/MM/YYYY hh:mm A'
        }
      })
      //Date range as a button
      $('#daterange-btn').daterangepicker(
        {
          ranges   : {
            'Today'       : [moment(), moment()],
            'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month'  : [moment().startOf('month'), moment().endOf('month')],
            'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate  : moment()
        },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
      )
  
      //Timepicker
      $('#timepicker').datetimepicker({
        format: 'LT'
      })
  
      //Bootstrap Duallistbox
      $('.duallistbox').bootstrapDualListbox()
  
      //Colorpicker
      $('.my-colorpicker1').colorpicker()
      //color picker with addon
      $('.my-colorpicker2').colorpicker()
  
      $('.my-colorpicker2').on('colorpickerChange', function(event) {
        $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
      });
  
      $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
      });
  
    })
    // BS-Stepper Init
    document.addEventListener('DOMContentLoaded', function () {
      window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    });
  
    // DropzoneJS Demo Code Start
    Dropzone.autoDiscover = false;
  
    // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    var previewNode = document.querySelector("#template");
    previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);
  
    var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
      url: "/target-url", // Set the url
      thumbnailWidth: 80,
      thumbnailHeight: 80,
      parallelUploads: 20,
      previewTemplate: previewTemplate,
      autoQueue: false, // Make sure the files aren't queued until manually added
      previewsContainer: "#previews", // Define the container to display the previews
      clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
    });
  
    myDropzone.on("addedfile", function(file) {
      // Hookup the start button
      file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
    });
  
    // Update the total progress bar
    myDropzone.on("totaluploadprogress", function(progress) {
      document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
    });
  
    myDropzone.on("sending", function(file) {
      // Show the total progress bar when upload starts
      document.querySelector("#total-progress").style.opacity = "1";
      // And disable the start button
      file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
    });
  
    // Hide the total progress bar when nothing's uploading anymore
    myDropzone.on("queuecomplete", function(progress) {
      document.querySelector("#total-progress").style.opacity = "0";
    });
  
    // Setup the buttons for all transfers
    // The "add files" button doesn't need to be setup because the config
    // `clickable` has already been specified.
    document.querySelector("#actions .start").onclick = function() {
      myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
    };
    document.querySelector("#actions .cancel").onclick = function() {
      myDropzone.removeAllFiles(true);
    };
    // DropzoneJS Demo Code End
  </script>
    <script type="text/javascript">
     $(document).ready(function() {
      var iddkm = $("input[name=id]").val();
    // get the current URL
    var url = $(location).attr('href');
    // if the URL ends with the anchor #portfolioModal93 then we want to open the modal
    if(url == '<?php echo base_url()?>c_data_dokumen/edit_data_dokumen/'+iddkm+'#exampleModalCenter') {
        $('#exampleModalCenter').modal('show');
    }
    });
</script>
</body>
</html>
