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
    <style>
        input,
textarea {
  border: 1px solid #eeeeee;
  box-sizing: border-box;
  margin: 0;
  outline: none;
  padding: 10px;
}

input[type="button"] {
  -webkit-appearance: button;
  cursor: pointer;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
}

.input-group {
  clear: both;
  margin: 15px 0;
  position: relative;
}

.input-group input[type='button'] {
  background-color: #eeeeee;
  min-width: 38px;
  width: auto;
  transition: all 300ms ease;
}

.input-group .button-minus,
.input-group .button-plus {
  font-weight: bold;
  height: 38px;
  padding: 0;
  width: 38px;
  position: relative;
}

.input-group .quantity-field {
  position: relative;
  height: 38px;
  left: -6px;
  text-align: center;
  width: 62px;
  display: inline-block;
  font-size: 13px;
  margin: 0 0 5px;
  resize: vertical;
}

.button-plus {
  left: -13px;
}

input[type="number"] {
  -moz-appearance: textfield;
  -webkit-appearance: none;
}

    </style>
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
         
          <li class="nav-item ">
            <a href="<?php echo base_url() ?>c_demografi_tenaga_kerja" class="nav-link ">
            <i class="nav-icon fab fa-buffer"></i>
              <p>
                 Demografi Tenaga Kerja
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
                    
                    
                    <!-- /.card-header -->
                    <!-- form start -->
                    <?php foreach ($data_demograf as $jd) :?>
                    <form onsubmit="return Validate(this);" action="<?php echo base_url(). 'c_demografi_tenaga_kerja/update_demografi' ?>" method="post">
                      <div class="card-body">
                          <div class="card-header">
                              <?php 
                              if ($jd->id_demografi_t_k == '1') {?>
                                  <h3> Edit Karyawan Tetap</h3>
                                  <h4><b>Kebun</b></h4>
                              <?php }elseif($jd->id_demografi_t_k == '2') {?>
                                  <h3> Edit PKWT</h3>
                                  <h4><b>Kebun</b></h4>
                              <?php }elseif($jd->id_demografi_t_k == '3') {?>
                                  <h3> Edit Harian Lepas</h3>
                                  <h4><b>Kebun</b></h4>
                              <?php }elseif($jd->id_demografi_t_k == '4') {?>
                                  <h3> Edit karyawan Tetap</h3>
                                  <h4><b>Pabrik</b></h4>
                              <?php }elseif($jd->id_demografi_t_k == '5') {?>
                                  <h3> Edit PKWT</h3>
                                  <h4><b>Pabrik</b></h4>
                              <?php }elseif($jd->id_demografi_t_k == '6') {?>
                                  <h3> Edit Harian Lepas</h3>
                                  <h4><b>pabrik</b></h4>
                              <?php } ?>
                        </div>
                        <div class="col-md-3"> 
                            <div class="form-group">
                                <label>Tanggal Pembaruan Data</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="tanggal"  required/>
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                            </div>
                        </div> 
                        <div class="form-group">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-4 "></div>
                                    <div class="col-4 "><label for="exampleInputEmail1">SD</label></div>
                                    <div class="col-4 "></div>
                                </div>
                                <div class="row">
                                    <div class="col-6 mt-3">
                                        <label for="exampleInputEmail1">Laki Laki</label>
                                        <div class="input-group">
                                            <input type="button" value="-" class="button-minus" onclick="decrementValue(1)">
                                            <input type="number"  step="1" max="100" value="<?= $jd->sd_l ; ?>" name="sd_l" id="number1" class="quantity-field">
                                            <input type="button" value="+" class="button-plus" onclick="incrementValue(1)">
                                        </div>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label for="exampleInputEmail1">Perempuan</label>
                                        <div class="input-group">
                                            <input type="button" value="-" class="button-minus" onclick="decrementValue(2)">
                                            <input type="number" step="1" max="100" value="<?= $jd->sd_p ; ?>" name="sd_p" id="number2" class="quantity-field" >
                                            <input type="button" value="+" class="button-plus"onclick="incrementValue(2)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-4 "></div>
                                    <div class="col-4 "><label for="exampleInputEmail1">SMP</label></div>
                                    <div class="col-4 "></div>
                                </div>
                                <div class="row">
                                    <div class="col-6 mt-3">
                                        <label for="exampleInputEmail1">Laki Laki</label>
                                        <div class="input-group">
                                            <input type="button" value="-" class="button-minus" onclick="decrementValue(3)">
                                            <input type="number" step="1" max="" value="<?= $jd->smp_l ; ?>" name="smp_l" id="number3" class="quantity-field">
                                            <input type="button" value="+" class="button-plus"  onclick="incrementValue(3)">
                                        </div>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label for="exampleInputEmail1">Perempuan</label>
                                        <div class="input-group">
                                            <input type="button" value="-" class="button-minus" onclick="decrementValue(4)">
                                            <input type="number" step="1" max="" value="<?= $jd->smp_p ; ?>" name="smp_p" id="number4" class="quantity-field" >
                                            <input type="button" value="+" class="button-plus"  onclick="incrementValue(4)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-4 "></div>
                                    <div class="col-4 "><label for="exampleInputEmail1">SMA</label></div>
                                    <div class="col-4 "></div>
                                </div>
                                <div class="row">
                                    <div class="col-6 mt-3">
                                        <label for="exampleInputEmail1">Laki Laki</label>
                                        <div class="input-group">
                                            <input type="button" value="-" class="button-minus" onclick="decrementValue(5)">
                                            <input type="number" step="1" max="" value="<?= $jd->sma_l ; ?>" name="sma_l" id="number5" class="quantity-field">
                                            <input type="button" value="+" class="button-plus" onclick="incrementValue(5)">
                                        </div>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label for="exampleInputEmail1">Perempuan</label>
                                        <div class="input-group">
                                            <input type="button" value="-" class="button-minus" onclick="decrementValue(6)">
                                            <input type="number" step="1" max="" value="<?= $jd->sma_p ; ?>" name="sma_p" id="number6" class="quantity-field" >
                                            <input type="button" value="+" class="button-plus"  onclick="incrementValue(6)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-4 "></div>
                                    <div class="col-4 "><label for="exampleInputEmail1">D3/D4/S1</label></div>
                                    <div class="col-4 "></div>
                                </div>
                                <div class="row">
                                    <div class="col-6 mt-3">
                                        <label for="exampleInputEmail1">Laki Laki</label>
                                        <div class="input-group">
                                            <input type="button" value="-" class="button-minus" onclick="decrementValue(7)">
                                            <input type="number" step="1" max="" value="<?= $jd->sarjana_l ; ?>" name="sarjana_l" id="number7" class="quantity-field">
                                            <input type="button" value="+" class="button-plus"  onclick="incrementValue(7)">
                                        </div>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label for="exampleInputEmail1">Perempuan</label>
                                        <div class="input-group">
                                            <input type="button" value="-" class="button-minus" onclick="decrementValue(8)">
                                            <input type="number" step="1" max="" value="<?= $jd->sarjana_p ; ?>" name="sarjana_p" id="number8" class="quantity-field" >
                                            <input type="button" value="+" class="button-plus"  onclick="incrementValue(8)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-4 "></div>
                                    <div class="col-4 "><label for="exampleInputEmail1">S2</label></div>
                                    <div class="col-4 "></div>
                                </div>
                                <div class="row">
                                    <div class="col-6 mt-3">
                                        <label for="exampleInputEmail1">Laki Laki</label>
                                        <div class="input-group">
                                            <input type="button" value="-" class="button-minus" onclick="decrementValue(9)">
                                            <input type="number" step="1" max="" value="<?= $jd->s2_l ; ?>" name="s2_l" id="number9" class="quantity-field">
                                            <input type="button" value="+" class="button-plus"  onclick="incrementValue(9)">
                                        </div>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <label for="exampleInputEmail1">Perempuan</label>
                                        <div class="input-group">
                                            <input type="button" value="-" class="button-minus" onclick="decrementValue(10)">
                                            <input type="number" step="1" max="" value="<?= $jd->s2_p ; ?>" name="s2_p" id="number10" class="quantity-field" >
                                            <input type="button" value="+" class="button-plus" onclick="incrementValue(10)">
                                        </div>
                                </div>
                            </div>
                              <input type="hidden" class="form-control" id="exampleInputEmail1"  name="id_demografi_t_k" value="<?php echo $jd->id_demografi_t_k ?>">
                              <input type="hidden" class="form-control" id="exampleInputEmail1"  name="id_jenis_t_n" value="<?php echo $jd->id_jenis_t_n ?>">
                          
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



<<script type="text/javascript">
function incrementValue(tes)
{   
    var value = parseInt(document.getElementById('number'+tes).value, 10);
    value = isNaN(value) ? 0 : value;
    if(value<1000){
        value++;
            document.getElementById('number'+tes).value = value;
    }
}
function decrementValue(tes)
{
    var value = parseInt(document.getElementById('number'+tes).value, 10);
    value = isNaN(value) ? 0 : value;
    if(value>1){
        value--;
            document.getElementById('number'+tes).value = value;
    }

}
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
          format: 'L'
      });
      //Date range picker
      $('#reservation').daterangepicker()
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
