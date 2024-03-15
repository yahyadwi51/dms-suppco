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
  <!-- Library Selectize -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

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
          <?php 
          $role_id = $this->session->userdata('role_id');
          if($role_id == 1){ ?>
          <li class="nav-item ">
            <a href="<?php echo base_url() ?>c_master_hgu" class="nav-link ">
            <i class="nav-icon fab fa-buffer"></i>
              <p>
              Master HGU
              </p>
            </a>
          </li>
          <?php }?>
          
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
                      <h3 class="card-title">Tambah Hak Atas Tanah</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form  id="qual" action="<?php echo base_url(). 'c_master_hgu/tambah_hgu' ?>" method="post" enctype="multipart/form-data">
                      <div class="card-body">
                        <div class="form-group">
                            <label>Jenis Hak Atas Tanah</label>
                                <select class="form-control select2" style="width: 100%;" name="jenis_hat" required>
                                <option value="0" selected>- Pilih Jenis Hak Atas Tanah - </option>
                                <option value="Hak Pakai">Hak Pakai</option>
                                <option value="Hak Guna Usaha">Hak Guna Usaha</option>
                                <option value="Hak Guna Bangunan">Hak Guna Bangunan</option>
                                <option value="Hak Pengelolaan">Hak Pengelolaan</option>
                            </select>
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Nomor Hak Atas Tanah</label>
                          <input type="text" class="form-control" id="exampleInputEmail1"  name="nomor_hgu" required>
                        </div>

                        <div class="form-group">
                            <label>Lokasi Kebun</label>
                                <select class="form-control sel" style="width: 100%;" name="lokasi_kebun" id="lokasi" placeholder="- Pilih Kebun -" required>
                                <option selected></option>
                                <?php foreach ($master_kebun as $usr) : ?>
                                    <option id="<?php echo $usr->id_bagian;?>" value="<?php echo $usr->id_bagian;?>">
                                      <?php echo $usr->nama_bagian?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
        
                        <div class="form-group">
                            <label>Provinsi</label>
                            <select class="form-control select2" style="width: 100%;" name="provinsi" id="provinsi" required>
                            </select>
                            <input type="hidden" class="form-control" id="idprov"  name="id_provinsi" required>
                        </div>

                        <div class="form-group" id="kab">
                            <label>Kab/Kota</label>
                            <select class="form-control select2" style="width: 100%;" name="kabupaten" id="kabupaten" required>
                            </select>
                            <input type="hidden" class="form-control" id="idkab"  name="id_kabupaten" required>
                        </div>
                        
                        <div class="form-group" id="kec">
                            <label>Kecamatan</label>
                            <select class="form-control select2" style="width: 100%;" name="kecamatan" id="kecamatan" required>
                            </select>
                            <input type="hidden" class="form-control" id="idkec"  name="id_kecamatan" required>
                        </div>

                        <div class="form-group" id="kel">
                            <label>Kelurahan/Desa</label>
                              <select class="form-control select2" style="width: 100%;" name="kelurahan" id="kelurahan" required>
                            </select>
                            <input type="hidden" class="form-control" id="idkel"  name="id_kelurahan" required>
                        </div>

                        <div id="kombinasi">
                          <div class="row baru-data row-status">
                            <div class="col-md-2">
                              <div class="form-group">
                                <label>Nama Patok 1</label>
                                <input type="text" class="form-control" style="width: 100%;" name="patok[]" value="Patok 1" required>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group"> 
                                <label>Titik Koordinat 1</label>
                                <input type="text" class="form-control" style="width: 100%;" name="koordinat[]" required>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group"> 
                                <label>Keterangan</label>
                                <input type="text" class="form-control" style="width: 100%;" name="ket_patok[]">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <label style="color:white;">Action</label>
                              <div class="form-group">
                                <button type="button" class="btn btn-success btn-sm btn-tambah mt-1" title="Tambah" id="tambah_status"><i class="fa fa-plus"></i></button>
                                <button type="button" class="btn btn-danger btn-sm btn-hapus mt-1" title="Hapus" style="display:none;"><i class="fa fa-times"></i></button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="exampleInputFile">Upload KML</label>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input"  id="cv" name="upload_kml[]" multiple>
                              <label class="custom-file-label">Masukkan File KML</label>
                            </div>
                            <div class="input-group-append">
                              <span class="input-group-text">kml</span>
                            </div>
                          </div>
                          <!-- <input class="btn btn-primary" type="button" onclick="add_file();" value="+" style="width:40px;height:40px;margin-bottom:10px"> -->
                        </div>
                        <div class="form-group">
                            <label for="inputDescription">Keterangan</label>
                            <textarea id="inputDescription" class="form-control" rows="4" name="keterangan"></textarea>
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
    $("#qual").submit( function(submitEvent) {
    var fileSize = document.getElementById("cv").files[0];
    var sizeInMb = (fileSize.size/1024)/1024;
    var sizeLimit= 2;
    if (sizeInMb > sizeLimit) {
        alert('File harus berukuran dibawah 5MB');
        return false;
    }
    
    var filename = $("#cv").val();
    var extension = filename.replace(/^.*\./, '');
    if (extension == filename) {
        extension = '';
    } else {
        extension = extension.toLowerCase();
    }
    switch (extension) {
        case 'kml':
            $("#qual").submit(function(e){
                $("#qual").unbind('submit').submit()
            });
            break;
            
        default:
            alert('Format file harus : kml')
            return false;
    }
});
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
<!-- Library Selectize -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
<script>
    $(function () {
      // Initialize Select2 Elements
      $('.select2').select2()
  
      // Initialize Select2 Elements
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

  <script>
    $('.sel').selectize({ normalize: true });

    $(document).ready(function() { 
      // $("#kec").hide();
      // $("#kab").hide();
      // $("#kel").hide();

      fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json`)
      .then((response) => response.json())
      .then((provinces) => {
        let provinsi = '';
        
        provinsi += `<option selected>- Pilih Provinsi - </option>`;

        provinces.forEach(prov => [
          provinsi += `
          <option value="${prov.name}" title="${prov.id}">${prov.name}</option>`
        ]);
        
        document.querySelector("#provinsi").innerHTML = provinsi;
      });
      
      $("#provinsi").change(function() {
        var x = document.getElementById("provinsi").selectedIndex;
        var getIdProvinsi = document.getElementById("provinsi")[x].title;
        $("#idprov").val(getIdProvinsi);

        // console.log(getIdProvinsi);
        
        $("#kab").show();
        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${getIdProvinsi}.json`)
        .then((response) => response.json())
        .then((regencies) => {
          let kabupaten = '';
          kabupaten += `<option selected>- Pilih Kabupaten/Kota - </option>`;

          regencies.forEach(kab => [
            kabupaten += `
            <option value="${kab.name}" title="${kab.id}">${kab.name}</option>
            `
          ]);
          document.querySelector("#kabupaten").innerHTML = kabupaten;
        });
      });

      $("#kabupaten").change(function() {
        var kab = document.getElementById("kabupaten").selectedIndex;
        var getIdKabupaten = document.getElementById("kabupaten")[kab].title;
        $("#idkab").val(getIdKabupaten);

        $("#kec").show();
        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${getIdKabupaten}.json`)
        .then((response) => response.json())
        .then((districts) => {
          let kecamatan = '';
          kecamatan += `<option selected>- Pilih Kecamatan - </option>`;

          districts.forEach(kec => [
            kecamatan += `
            <option value="${kec.name}" title="${kec.id}">${kec.name}</option>
            `
          ]);
          document.querySelector("#kecamatan").innerHTML = kecamatan;
        });
      })
      
      $("#kecamatan").change(function() {
        var kec = document.getElementById("kecamatan").selectedIndex;
        var getIdKecamatan = document.getElementById("kecamatan")[kec].title;
        $("#idkec").val(getIdKecamatan);

        $("#kel").show();
        fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${getIdKecamatan}.json`)
        .then((response) => response.json())
        .then((villages) => {
          let kelurahan = '';
          kelurahan += `<option selected>- Pilih Kelurahan - </option>`;

          villages.forEach(kel => [
            kelurahan += `
            <option value="${kel.name}" title="${kel.id}">${kel.name}</option>
            `
          ]);
          document.querySelector("#kelurahan").innerHTML = kelurahan;
        });
      })

      $("#kelurahan").change(function() {
        var kel = document.getElementById("kelurahan").selectedIndex;
        var getIdKelurahan = document.getElementById("kelurahan")[kel].title;
        $("#idkel").val(getIdKelurahan);
      })
      
    });

    var no = 1;

    function addForm(no){
      var addRow = `
        <div class="row baru-data`+no+` row-status">
          <div class="col-md-2">
            <div class="form-group">
              <label>Nama Patok `+no+`</label>
              <input type="text" class="form-control" style="width: 100%;" name="patok[]" value="Patok `+no+`" required>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group"> 
              <label>Titik Koordinat `+no+`</label>
              <input type="text" class="form-control" style="width: 100%;" name="koordinat[]" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group"> 
              <label>Keterangan</label>
              <input type="text" class="form-control" style="width: 100%;" name="ket_patok[]">
            </div>
          </div>
          <div class="col-md-4">
            <label style="color:white;">Action</label>
            <div class="form-group">
              <button type="button" class="btn btn-success btn-sm btn-tambah mt-1" title="Tambah" id="tambah_status"><i class="fa fa-plus"></i></button>
              <button type="button" class="btn btn-danger btn-sm btn-hapus mt-1" title="Hapus" id="`+no+`"><i class="fa fa-times"></i></button>
            </div>
          </div>
        </div>
        `
      $("#kombinasi").append(addRow);
    }

    $("#kombinasi").on("click", ".btn-tambah", function(){
      no++;
      addForm(no);
      $(this).css("display","none");
      var valtes = $(this).parent().find(".btn-hapus").css("display","none");
    })
    

    $("#kombinasi").on('click', '.btn-hapus', function(){
      no--;
      var button_id = $(this).attr("id");
      var btn = (button_id)-1;
      var row = ($(".row-status").length)-1; 
      $('.baru-data'+button_id+'').remove();
      
      $(".btn-tambah").find('.baru-data'+row+'').css("display","");
      console.log(row);
      console.log(btn);
      if(row != 1){
        $('.baru-data'+btn+'').find(".btn-tambah").css("display","");
        $('.baru-data'+btn+'').find(".btn-hapus").css("display","");
      } 
      else{
        $(".btn-tambah").css("display","");
        $(".btn-hapus").css("display","none");
      }
    });

  </script>
</body>
</html>
