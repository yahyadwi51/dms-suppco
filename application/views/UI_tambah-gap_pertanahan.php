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
            <a href="<?php echo base_url() ?>c_gap_pertanahan" class="nav-link ">
            <i class="nav-icon fab fa-buffer"></i>
              <p>
              Pertanahan
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
                      <h3 class="card-title">Tambah Pertanahan</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form onsubmit="return Validate(this);" action="<?php echo base_url(). 'c_gap_pertanahan/tambah_pertanahan' ?>" method="post" enctype="multipart/form-data">
                      <div class="card-body">
                            
                            <div class="form-group">
                                <label>Nomor HGU</label>
                                    <select class="form-control select2" style="width: 100%;" name="no_hgu">
                                    <option selected>- Pilih HGU - </option>
                                        <?php foreach ($master_hgu as $nh) : ?>
                                            <option value="<?php echo $nh['nomor_hgu'];?>">
                                            <?php echo $nh['nomor_hgu']?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                            </div>
                            <div class="form-group">
                                <label>Kebun</label>
                                <?php 
                                    $id_kebun = $this->session->userdata('id');
                                    $username = $this->session->userdata('username');
                                    $query_dokumen = $this->db->query("SELECT * FROM tb_user WHERE id ='$id_kebun'");
                                    $data['datakebun'] = $query_dokumen->result_array();
                                    // print_r( $data['datamasterbagian']);
                                    // die();
                                    if($username == 'admin'){
                                    ?>
                                    <select class="form-control select2" style="width: 100%;" name="id_kebun">
                                    <option selected>- Pilih Kebun - </option>
                                    <?php foreach ($kebun as $usr) : ?>
                                        <option value="<?php echo $usr['id'];?>">
                                          <?php echo $usr['username']?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php
                                    }elseif($username != 'admin'){
                                ?>
                                <input type="hidden" class="form-control" id="exampleInputEmail1" name="id_kebun" value="<?php echo $data['datakebun'][0]['id'] ?> " readonly>
                                <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $data['datakebun'][0]['username'] ?> " readonly>
                              
                                    <?php }?>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hak Atas Tanah</label>
                                <input type="text" class="form-control"   name="hak_atas_tanah">
                            </div>                        
                            <ul class="nav nav-tabs nav-justified md-tabs indigo" id="myTabJust" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab-just" data-toggle="tab" href="#home-just" role="tab" aria-controls="home-just"
                                    aria-selected="true"><span style="" >Tanah Belum digarap</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab-just" data-toggle="tab" href="#profile-just" role="tab" aria-controls="profile-just"
                                    aria-selected="false">Okupasi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab-just" data-toggle="tab" href="#contact-just" role="tab" aria-controls="contact-just"
                                    aria-selected="false">Tumpang Tindih</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="permasalahan-tab-just" data-toggle="tab" href="#permasalahan-just" role="tab" aria-controls="contact-just"
                                    aria-selected="false">Permasalahan Lain</a>
                                </li>
                            </ul>
                            <div class="tab-content card pt-5" id="myTabContentJust">
                                <div class="tab-pane fade show active" id="home-just" role="tabpanel" aria-labelledby="home-tab-just">
                                    <div class="card-header">
                                        <h5 class="m-0">Tanah Belum Digarap</h5>
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" value="1" name="id_tanah[]">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="inputDescription">Luas(Ha)</label>
                                                <input type="number" class="form-control"   name="luas[]" value="-">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Tanggal Terjadi</label>
                                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="tanggal_terjadi[]" value="<?php echo date('y-m-d');?>"/>
                                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputEmail1">Latitude</label>
                                                <input type="text" class="form-control"   name="latitude[]" value="-">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputEmail1">Longitude</label>
                                                <input type="text" class="form-control"   name="longitude[]" value="-">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDescription">Komoditi</label>
                                            <input type="text" class="form-control"   name="komoditi[]" value="-">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDescription">Kondisi Saat Ini</label>
                                            <input type="text" class="form-control"   name="kondisi_saat_ini[]" value="-">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile-just" role="tabpanel" aria-labelledby="profile-tab-just">
                                    <div class="card-header">
                                        <h5 class="m-0">Okupasi</h5>
                                    </div>
                                    <div class="card-body">
                                    <input type="hidden" value="2" name="id_tanah[]">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="inputDescription">Luas(Ha)</label>
                                                <input type="number" class="form-control"   name="luas[]">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Tanggal Terjadi</label>
                                                    <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                                                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate2" name="tanggal_terjadi[]" />
                                                        <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputEmail1">Latitude</label>
                                                <input type="text" class="form-control"   name="latitude[]">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputEmail1">Longitude</label>
                                                <input type="text" class="form-control"   name="longitude[]">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Subjek/Pelaku/Instansi Terkait</label>
                                            <select class="select2bs4" multiple="multiple" data-placeholder="" style="width: 100%;" name="subjek[]" required>
                                            <?php foreach ($master_lsm as $nh) : ?>
                                                    <option value="<?php echo $nh['id_lsm'];?>">
                                                    <?php echo  $nh['nama_lsm']?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDescription">Kerugian</label>
                                            <input type="text" class="form-control"   name="kerugian[]">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDescription">Komoditi</label>
                                            <input type="text" class="form-control"   name="komoditi[]">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDescription">Kondisi Saat Ini</label>
                                            <input type="text" class="form-control"   name="kondisi_saat_ini[]" value="-">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="contact-just" role="tabpanel" aria-labelledby="contact-tab-just">
                                    <div class="card-header">
                                        <h5 class="m-0">Tumpang Tindih</h5>
                                    </div>
                                    <div class="card-body">
                                    <input type="hidden" value="3" name="id_tanah[]">
                                        <div class="row">
                                            <div class="form-group  col-md-6">
                                                <label for="inputDescription">Luas(Ha)</label>
                                                <input type="number" class="form-control"   name="luas[]">
                                            </div>
                                            <div class="form-group  col-md-6">
                                                <label>Tanggal Terjadi</label>
                                                    <div class="input-group date" id="reservationdate3" data-target-input="nearest">
                                                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate3" name="tanggal_terjadi[]" />
                                                        <div class="input-group-append" data-target="#reservationdate3" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputEmail1">Latitude</label>
                                                <input type="text" class="form-control"   name="latitude[]">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputEmail1">Longitude</label>
                                                <input type="text" class="form-control"   name="longitude[]">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Subjek/Pelaku/Instansi Terkait</label>
                                            <select class="select2bs4" multiple="multiple" data-placeholder="" style="width: 100%;" name="subjek[]" required>
                                            <?php foreach ($master_lsm as $nh) : ?>
                                                    <option value="<?php echo $nh['id_lsm'];?>">
                                                    <?php echo  $nh['nama_lsm']?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDescription">Kerugian</label>
                                            <input type="text" class="form-control"   name="kerugian[]">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDescription">Komoditi</label>
                                            <input type="text" class="form-control"   name="komoditi[]">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDescription">Kondisi Saat Ini</label>
                                            <input type="text" class="form-control"   name="kondisi_saat_ini[]" value="-">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="permasalahan-just" role="tabpanel" aria-labelledby="permasalahan-tab-just">
                                    <div class="card-header">
                                        <h5 class="m-0">Permasalahan Lain</h5>
                                    </div>
                                    <div class="card-body">
                                    <input type="hidden" value="4" name="id_tanah[]">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="inputDescription">Luas(Ha)</label>
                                                <input type="number" class="form-control"   name="luas[]">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Tanggal Terjadi</label>
                                                    <div class="input-group date" id="reservationdate5" data-target-input="nearest">
                                                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate5" name="tanggal_terjadi[]" />
                                                        <div class="input-group-append" data-target="#reservationdate5" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputEmail1">Latitude</label>
                                                <input type="text" class="form-control"   name="latitude[]">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="exampleInputEmail1">Longitude</label>
                                                <input type="text" class="form-control"   name="longitude[]">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Subjek/Pelaku/Instansi Terkait</label>
                                                <select class="form-control select2" style="width: 100%;" name="subjek[]">
                                                <option value="" selected>- Pilih Subjek/Pelaku/Instansi Terkait - </option>
                                                    <?php foreach ($master_lsm as $nh) : ?>
                                                        <option value="<?php echo $nh['id_lsm'];?>">
                                                        <?php echo $nh['nama_lsm']?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDescription">Kerugian</label>
                                            <input type="text" class="form-control"   name="kerugian[]">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDescription">Komoditi</label>
                                            <input type="text" class="form-control"   name="komoditi[]">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDescription">Kondisi Saat Ini</label>
                                            <input type="text" class="form-control"   name="kondisi_saat_ini[]" value="-">
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
<script>
    document.getElementById('div1').style.display ='none';
    function show1(){
    document.getElementById('div1').style.display ='block';
    }
    function show2(){
    document.getElementById('div1').style.display = 'none';
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
          format: 'YYYY-MM-DD'
      });
      $('#reservationdate2').datetimepicker({
          format: 'YYYY-MM-DD'
      });
      $('#reservationdate3').datetimepicker({
          format: 'YYYY-MM-DD'
      });
      $('#reservationdate4').datetimepicker({
          format: 'YYYY-MM-DD'
      });
      $('#reservationdate5').datetimepicker({
          format: 'YYYY-MM-DD'
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
