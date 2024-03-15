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
            <a href="<?php echo base_url() ?>C_gap_pengelolaan_kebun" class="nav-link ">
            <i class="nav-icon fab fa-buffer"></i>
              <p>
              Pengelolaan Kebun
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-12 mt-3">
                <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Edit Pengelolaan Kebun</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <?php foreach ($legal_ijin as $li) :?>
                    <form onsubmit="return Validate(this);" action="<?php echo base_url(). 'c_gap_pengelolaan_kebun/update_pengelolaan_kebun' ?>" method="post" enctype="multipart/form-data">
                      <div class="card-body">
                        <div class="row"> 
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nomor Perjanjian</label>
                                    <input type="hidden" class="form-control" id="exampleInputEmail1"  name="id" value="<?php echo $li->id_olah_keb ?>">
                                    <input type="text" class="form-control" id="exampleInputEmail1"  name="no_perjanjian" value="<?php echo $li->no_perjanjian ?>">
                                </div>
                            </div>
                            <div class="col-md-6"> 
                            <div class="form-group">
                                <label>Kebun</label>
                                <?php 
                                    $id_kebun = $this->session->userdata('bagian');
                                    $username = $this->session->userdata('username');
                                    $query_dokumen = $this->db->query("SELECT * FROM tb_user WHERE bagian ='$id_kebun'");
                                    $data['datakebun'] = $query_dokumen->result_array();

                                    if($username == 'admin'){
                                    ?>
                                    <div class="form-group">
                                      <select class="form-control select2" style="width: 100%;" name="id_kebun" required>
                                      <?php foreach ($kebun as $kb) : ?>
                                      <option selected value="<?php echo $kb->id_kebun; ?>"><?php echo $kb->nama_bagian ?><option>
                                      <?php endforeach; ?> 
                                      <?php foreach ($pilihkebun as $jd) : ?>
                                        <option value="<?php echo $jd->id_bagian; ?>" >
                                          <?php echo $jd->nama_bagian ?>
                                        </option>
                                      <?php endforeach; ?>
                                      </select>
                                    </div>
                                <?php
                                    }elseif($username != 'admin'){
                                ?>
                                  <input type="hidden" class="form-control" id="exampleInputEmail1" name="id_kebun" value="<?php echo $data['datakebun'][0]['bagian'] ?>" readonly>
                                  <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $data['datakebun'][0]['username'] ?> " readonly>
                                <?php }?>
                            </div>
                            </div>
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Kerjasama</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"  name="kerjasama" value="<?php echo $li->kerjasama ?>">
                                </div>
                            </div> 
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Jenis Kerjasama</label>
                                        <select class="form-control select2" style="width: 100%;" name="jenis_kerjasama" value="<?php echo $li->jenis_kerjasama ?>">
                                        <option selected>- Pilih Kerjasama - </option>
                                            <?php foreach ($kerjasama as $k) : ?>
                                                <option value="<?php echo $k['id_kerjasama'];?>"<?php 
                                                if ($k['id_kerjasama'] == $li->jenis_kerjasama) {
                                                    echo "selected";
                                                  }
                                                ?>>
                                                <?php echo $k['nama']?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                </div>
                            </div> 
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Mitra</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"  name="mitra" value="<?php echo $li->mitra ?>">
                                </div>
                            </div> 
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Luas(Ha)</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1"  name="luas" value="<?php echo $li->luas ?>">
                                </div>
                            </div> 
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Titik Koordinat Longitude</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1"  name="tk_long" value="<?php echo $li->tk_long ?>">
                                </div>
                            </div> 
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Titik Koordinat Latitude</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"  name="tk_lat" value="<?php echo $li->tk_lat ?>">
                                </div>
                            </div> 
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nilai Kompensasi</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1"  name="nilai_kompensasi" value="<?php echo $li->nilai_kompensasi ?>">
                                </div>
                            </div> 
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Objek Kerjasama</label>
                                        <select class="form-control select2" style="width: 100%;" name="objek_kerjasama" value="<?php echo $li->objek_kerjasama ?>">
                                        <option selected>- Pilih Objek Kerjasama - </option>
                                            <?php foreach ($objek_kerjasama as $ok) : ?>
                                                <option value="<?php echo $ok['id_objek_kerjasama'];?>" <?php 
                                                if ($ok['id_objek_kerjasama'] == $li->objek_kerjasama) {
                                                    echo "selected";
                                                  }
                                                ?>>
                                                <?php echo $ok['nama_objek_kerjasama']?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                </div>
                            </div> 
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Tanggal Perjanjian</label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="tanggal_perjanjian" value="<?php echo date('d-m-Y', strtotime($li->tanggal_perjanjian)) ?>" required/>
                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                </div>
                            </div> 
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Tanggal Berakhir Perjanjian</label>
                                        <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate1" name="tanggal_akhir_perjanjian" value="<?php echo date('d-m-Y', strtotime($li->tanggal_akhir_perjanjian)) ?>" required/>
                                            <div class="input-group-append" data-target="#reservationdate1" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                </div>
                            </div> 
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Jangka Waktu <span style="color:red;">(Tahun)</span></label>
                                    <input type="number" class="form-control" id="exampleInputEmail1"  name="jangka_waktu" value="<?php echo $li->jangka_waktu ?>">
                                </div>
                            </div> 
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label for="inputDescription">Kondisi Saat Ini</label>
                                    <textarea id="inputDescription" class="form-control" rows="4" name="kondisi_saat_ini"><?php echo $li->kondisi_saat_ini ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label for="inputDescription">Keterangan</label>
                                    <textarea id="inputDescription" class="form-control" rows="4" name="keterangan"><?php echo $li->keterangan ?></textarea>
                                </div>
                            </div> 
                            <div class="col-md-6"> 
                              <div class="form-group">
                                  <label for="exampleInputFile">Upload Dokumen </label>
                                  <div class="input-group">
                                  <div class="custom-file">
                                      <input type="file" class="custom-file-input" id="exampleInputFile" name="upload_dokumen">
                                      <input type="text" class="custom-file-input" id="exampleInputFile" value="<?php echo $li->upload_dokumen ?>" name="upload_dokument">
                                      <label class="custom-file-label" for="exampleInputFile"><?php echo $li->upload_dokumen ?></label>
                                  </div>
                                  <div class="input-group-append">
                                      <span class="input-group-text">kml,pdf</span>
                                  </div>
                                  </div>
                              </div>
                            </div> 
                            
                        </div>
                            
                      </div>
                      <!-- /.card-body -->
      
                      <div class="card-footer">
                        <button  type="submit" class="btn btn-primary">Simpan</button>
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2021 <a href="<?= base_url();?>">Jasinfo</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">

    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
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
$(function () {
  bsCustomFileInput.init();
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
      $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
      //Money Euro
      $('[data-mask]').inputmask()
  
      //Date range picker
      $('#reservationdate').datetimepicker({
          format: 'DD-MM-YYYY'
      });
      $('#reservationdate1').datetimepicker({
          format: 'DD-MM-YYYY'
      });
      //Date range picker
      $('#reservation').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        }
      )
      $('#reservation1').daterangepicker({
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
          format: 'MM/DD/YYYY hh:mm A'
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
</body>
</html>
