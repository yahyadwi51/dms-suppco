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
            <li class="nav-item ">
              <a href="<?php echo base_url() ?>c_pengelolah_dokumen" class="nav-link ">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Pengelolah Dokumen
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
    <div class="content-wrapper" style="margin-right: 250px">
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-12 mt-3">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Tambah Data Dokumen</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                
                <form onsubmit="return Validate(this);" action="<?php echo base_url() . 'c_pengelolah_dokumen/tambah_data_dokumen' ?>" method="post" enctype="multipart/form-data">
                <?php foreach ($id_dok_akhir as $id_akhir) : ?>
                  <?= form_open() ?>
                  <input type="hidden" name="id_dok_akhir" value="<?php echo $id_akhir->id_dokumen ?>">
                  <?php endforeach; ?>  
                <div class="card-body">
                    <div class="form-group">
                      <label>Status</label>
                      <select class="form-control select2" style="width: 100%;" name="status" id="myselect">
                        <option value="Baru">Baru</option>
                        <option value="Mencabut">Mencabut</option>
                        <option value="Mengubah">Mengubah</option>
                        <option value="Kombinasi">Kombinasi</option>
                      </select>
                    </div>
                    <div id="kombinasi">
                      <div class="row baru-data row-status">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Status Kombinasi</label>
                            <select class="form-control select2" style="width: 100%;" name="status_kombinasi[]" id="myselect2">
                              <option>- Pilih Status -</option>
                              <option value="Mencabut">Mencabut</option>
                              <option value="Mengubah">Mengubah</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group"> 
                            <label>Dokumen Lama</label>
                            <select class="form-control select2" style="width: 100%;" name="dokumen_lama_kombinasi[]" required>
                              <option readonly>- Pilih data -  </option>
                                <?php foreach ($data_dokumen_lama as $jd) : ?>
                                  <option value="<?php echo $jd->id_dokumen;?>">
                                          <?php echo $jd->nama_dokumen?>
                                  </option>
                                <?php endforeach; ?>
                            </select>
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

                    <div class="form-group" id="cabutubah">
                      <label>Dokumen Lama</label>
                      <select class="form-control select2" style="width: 100%;" name="dokumen_lama" required>
                        <option readonly>- Pilih data - </option>
                        <?php foreach ($data_dokumen_lama as $jd) : ?>
                          <option value="<?php echo $jd->id_dokumen; ?>">
                            <?php echo $jd->nama_dokumen ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <!-- Jenis Dokumen -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Jenis Dokumen</label>
                        <div class="form-inline mt-3">
                            <!-- radio for Dokumen Internal -->
                            <div class="custom-control custom-radio mr-4">
                                <input class="custom-control-input cekdokumen" type="radio" id="customRadio1" name="customRadio" value="" checked>
                                <label for="customRadio1" class="custom-control-label">Dokumen Internal</label>
                            </div>
                            
                            <!-- radio for Dokumen External -->
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input cekdokumen" type="radio" id="customRadio2" name="customRadio" value="<?php echo $this->session->userdata('bagian')?>">
                                <label for="customRadio2" class="custom-control-label">Dokumen External</label>
                            </div>
                        </div>
                    </div>
                    <!-- Level Dokumen -->
                    <div class="form-group">
                      <label>Level Dokumen</label>
                      <select class="form-control select2" style="width: 100%;" name="status" id="myselect">
                        <option value="Baru">Baru</option>
                        <option value="Mencabut">Mencabut</option>
                        <option value="Mengubah">Mengubah</option>
                        <option value="Kombinasi">Kombinasi</option>
                      </select>
                    </div>
                    <!-- Nomor Dokumen -->
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nomor Dokumen</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" name="nomor_dokumen" required>
                    </div>
                    <!-- Tanggal Terbit Dokumen -->
                    <div class="form-group">
                      <label>Tanggal Terbit Dokumen:</label>
                      <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="tanggal_terbit" value="<?= set_value('tanggal_terbit') ?>" autocomplete="off" required />
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                    <!-- Judul Dokumen -->
                    <div class="form-group">
                      <label for="exampleInputEmail1">Judul Dokumen</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" name="judul_dokumen" required>
                    </div>
                    <!-- Bagian Penerbit Dokumen -->
                    <div class="form-group">
                      <label>Bagian Penerbit</label>
                      <select class="form-control select2" style="width: 100%;" name="status" id="myselect">
                        <option value="Baru">Baru</option>
                        <option value="Mencabut">Mencabut</option>
                        <option value="Mengubah">Mengubah</option>
                        <option value="Kombinasi">Kombinasi</option>
                      </select>
                    </div>
                    <!-- Status Rvisi Dokumen -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Status Revisi</label>
                        <div class="form-inline">
                            <input type="text" class="form-control mr-2" id="inputJudul1" name="status_rev" required>
                            <input type="date" class="form-control" id="inputTanggal" name="tanggal_rev" required>
                        </div>
                    </div>

                    <script>
                        // Mengambil elemen input tanggal
                        const inputTanggal = document.getElementById('inputTanggal');

                        // Mendapatkan tanggal saat ini
                        const today = new Date().toISOString().split('T')[0];

                        // Set nilai atribut 'value' input tanggal menjadi tanggal saat ini
                        inputTanggal.value = today;
                    </script>

                    <!-- Metode Indeks Dokumen -->
                    <div class="form-group">
                      <label for="exampleInputEmail1">Metode Indeks</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" name="indeks_dokumen" required>
                    </div>
                    <!-- Media Simpan Dokumen -->
                    <div class="form-group">
                      <label for="exampleInputEmail1">Media Simpan Dokumen</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" name="media_simpan_dokumen" required>
                    </div>
                    <!-- Lama Simpan Dokumen -->
                    <div class="form-group">
                            <label>Lama Simpan</label>
          
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="far fa-calendar-alt"></i>
                                </span>
                              </div>
                              <input type="text" class="form-control float-right" id="reservation" name="masa_aktif">
                            </div>
                            <!-- /.input group -->
                          </div>

                    <div class="form-group" id="cabutubah">
                      <label>Dokumen Lama</label>
                      <select class="form-control select2" style="width: 100%;" name="dokumen_lama" required>
                        <option readonly>- Pilih data - </option>
                        <?php foreach ($data_dokumen_lama as $jd) : ?>
                          <option value="<?php echo $jd->id_dokumen; ?>">
                            <?php echo $jd->nama_dokumen ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputEmail1">Nomor</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" name="nama_dokumen" required>
                    </div>
                    <?php
                    $bagian = $this->session->userdata('bagian');
                    if ($bagian == 0) {
                    ?>
                      <div class="form-group">
                        <label>Bagian</label>
                        <select class="form-control select2" style="width: 100%;" name="bagian" required>
                          <option readonly>- Pilih Bagian - </option>
                          <?php foreach ($master_bagian as $jd) : ?>
                            <option value="<?php echo $jd->kode; ?>">
                              <?php echo $jd->nama_bagian ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    <?php } else {
                    ?>
                      <input type="hidden" name="bagian" value="<?= $this->session->userdata('bagian'); ?>" />
                    <?php } ?>

                    <div class="form-group">
                      <label>Tanggal Ditetapkan:</label>
                      <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="tanggal_penetapan" value="<?= set_value('tanggal_penetapan') ?>" autocomplete="off" required />
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label>Jenis Dokumen</label>
                      <select class="form-control select2" style="width: 100%;" name="jenis_dok" required>
                        <?php foreach ($jenis_dokumen as $jd) : ?>
                          <option value="<?php echo $jd->id_jenis_dokumen; ?>">
                            <?php echo $jd->nama_jenis_dokumen ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="inputDescription">Tentang</label>
                      <textarea id="inputDescription" class="form-control" rows="4" name="tentang"></textarea>
                    </div>

                    <div class="form-group">
                      <label>Memberikan Akses ke</label>
                      <select class="select2bs4" multiple="multiple" data-placeholder="" style="width: 100%;" name="akses_for[]" required>
                        <?php foreach ($master_bagian as $jd) : ?>
                          <option value="<?php echo $jd->kode; ?>">
                            <?php echo $jd->nama_bagian ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputFile">Upload Dokumen</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="exampleInputFile" name="upload_dokumen" required>
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                        <div class="input-group-append">
                          <span class="input-group-text">*jpg,pdf,png</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary" onclick="one_click_bro('true');">Simpan</button>
                  </div>
                  <?= form_close() ?>
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
      <strong>Copyright &copy; 2021 <a href="<?= base_url(); ?>">Jasinfo</a>.</strong>
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
    $(function() {
      bsCustomFileInput.init();
    });
  </script>
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
    $(function() {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })

      //Datemask dd/mm/yyyy
      $('#datemask').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
      })
      //Datemask2 mm/dd/yyyy
      $('#datemask2').inputmask('dd/mm/yyyy', {
        'placeholder': 'dd/mm/yyyy'
      })
      //Money Euro
      $('[data-mask]').inputmask()

      //Date range picker
      $('#reservationdate').datetimepicker({
        format: 'DD-MM-YYYY'
      });
      //Date range picker
      $('#reservation').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
          format: 'DD/MM/YYYY'
        }
      })
      //Date range picker with time picker
      $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        locale: {
          format: 'MM/DD/YYYY hh:mm A'
        }
      })
      //Date range as a button
      $('#daterange-btn').daterangepicker({
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function(start, end) {
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

      $("input[data-bootstrap-switch]").each(function() {
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
      });

    })
    // BS-Stepper Init
    document.addEventListener('DOMContentLoaded', function() {
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
      file.previewElement.querySelector(".start").onclick = function() {
        myDropzone.enqueueFile(file);
      };
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
    $(document).ready(function() {
      $("#cabutubah").hide();
      $("#kombinasi").hide();
      $("#myselect").change(function() {
        var status = $("#myselect option:selected").text();
        console.log(status);
        if (status != 'Baru') {
          if( status != 'Kombinasi'){
            $("#cabutubah").show();
            $("#kombinasi").hide();
            $("#jenisdokumen").hide();
            $("#aksesuntuk").hide();
            $("#pic").hide();
            $("#nama_dokumen").hide();
          }
          else {
            $("#kombinasi").show();
            $("#cabutubah").hide();
            $("#jenisdokumen").hide();
            $("#aksesuntuk").hide();
            $("#pic").hide();
            $("#nama_dokumen").hide();
          }  
        } else {
          $("#cabutubah").hide();
          $("#kombinasi").hide();
          $("#jenisdokumen").show();
          $("#aksesuntuk").show();
          $("#pic").show();
          $("#nama_dokumen").show();
        }
      })
    });

    var no = 1;

    function addForm(no){
      var addRow = `
        <div class="row form-group baru-data`+no+` row-status">
          <div class="col-md-4">
            <div class="form-group">
              <label>Status Kombinasi</label>
              <select class="form-control select2`+no+`" style="width: 100%;" name="status_kombinasi[]">
                <option>- Pilih Status -</option>
                <option value="Mencabut">Mencabut</option>
                <option value="Mengubah">Mengubah</option>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group"> 
              <label>Dokumen Lama</label>
              <select class="form-control select2`+no+`" style="width: 100%;" name="dokumen_lama_kombinasi[]" required>
                <option readonly>- Pilih data -  </option>
                  <?php foreach ($data_dokumen_lama as $jd) : ?>
                    <option value="<?php echo $jd->id_dokumen;?>">
                            <?php echo $jd->nama_dokumen?>
                    </option>
                  <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <label style="color:white;">Action</label>
            <div class="form-group">
              <button type="button" class="btn btn-success btn-sm btn-tambah mt-1" title="Tambah"><i class="fa fa-plus"></i></button>
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
      $('.select2'+no+'').select2();
      var valtes = $(this).parent().find(".btn-hapus").css("display","none");
    })
    

    $("#kombinasi").on('click', '.btn-hapus', function(){
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