<?php
$sesi_region = $this->session->userdata('id_region');
?>

<!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/adminlte.min.css">

  
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
                      <h3 class="card-title">Tambah User DMS</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?php echo base_url(). 'c_master_userdms/tambah_userdms' ?>" method="post">
                      <div class="card-body">
                        <div class="row">
                          <div class="form-group col-6">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Masukkan Username" name="username">
                          </div>
                          
                        <!-- UNTUK HO -->
                         <?php if($sesi_region == 13){ ?>

                          <div class="form-group col-6">
                              <label>Role</label>
                              <select class="form-control" name="role" id="role">
                                  <option value="">Pilih Nama Role</option>
                              </select>
                          </div>

                          <div class="form-group col-6">
                            <label>Region</label>
                              <select class="form-control select2" style="width: 100%;" name="region" id="region">
                              <option value="">Pilih Nama Region</option>
                              <?php foreach ($regionuserho as $reguserho) : ?>
                                  <option value="<?php echo $reguserho['id_regional'] ;?>">
                                          <?php echo $reguserho['nama_regional']?>
                                  </option>
                                <?php endforeach; ?>
                              </select>
                          </div>

                          <div class="form-group col-6">
                              <label>Nama Bagian</label>
                              <select class="form-control" name="bagian" id="bagian">
                                  <option value="">Pilih Nama Bagian</option>
                              </select>
                          </div>


                          <div class="form-group col-6">
                              <label>Nama Sub-Bagian</label>
                              <select class="form-control" name="subbagian" id="subbagian">
                                  <option value="">Pilih Nama Sub-Bagian</option>
                              </select>
                          </div>

                          <script>
                               $(document).ready(function() {
                                  $('#region').change(function() {
                                      var region_id = $(this).val();
                                      if (region_id !== '') {
                                          // Ambil data bagian berdasarkan id region yang dipilih
                                          $.ajax({
                                              url: '<?php echo base_url("c_master_userdms/get_bagian_by_region"); ?>/' + region_id,
                                              type: 'get',
                                              dataType: 'json',
                                              success: function(response) {
                                                  $('#bagian').empty();
                                                  $('#subbagian').empty();
                                                  $('#bagian').append('<option value="">Pilih Bagian</option>');
                                                  $.each(response, function(index, value) {
                                                      $('#bagian').append('<option value="' + value.id_bagian + '">' + value.nama_bagian + '</option>');
                                                  });
                                              }
                                          });
                                      } else {
                                          $('#bagian').empty();
                                          $('#subbagian').empty();
                                          $('#bagian').append('<option value="">Pilih Bagian</option>');
                                      }
                                  });

                                  $('#region').change(function() {
                                      var region_id = $(this).val();
                                      if (region_id !== '') {
                                          // Ambil data bagian berdasarkan id region yang dipilih
                                          $.ajax({
                                              url: '<?php echo base_url("c_master_userdms/get_role_by_region"); ?>/' + region_id,
                                              type: 'get',
                                              dataType: 'json',
                                              success: function(response) {
                                                  $('#role').empty();
                                                  $('#role').append('<option value="">Pilih Nama Role</option>');
                                                  $.each(response, function(index, value) {
                                                      $('#role').append('<option value="' + value.id + '">' + value.role + '</option>');
                                                  });
                                              }
                                          });
                                      } else {
                                          $('#role').empty();
                                          $('#role').append('<option value="">Pilih Nama Role</option>');
                                      }
                                  });


                                  $('#bagian').change(function() {
                                      var section_id = $(this).val();
                                      if (section_id !== '') {
                                          // Ambil data sub bagian berdasarkan id bagian yang dipilih
                                          $.ajax({
                                              url: '<?php echo base_url("c_master_userdms/get_subbagian_by_bagian"); ?>/' + section_id,
                                              type: 'get',
                                              dataType: 'json',
                                              success: function(response) {
                                                  $('#subbagian').empty();
                                                  $('#subbagian').append('<option value="">Pilih Sub Bagian</option>');
                                                  $.each(response, function(index, value) {
                                                      $('#subbagian').append('<option value="' + value.id_sub_bag + '">' + value.nama_sub_bag + '</option>');
                                                  });
                                              }
                                          });
                                      } else {
                                          $('#subbagian').empty();
                                          $('#subbagian').append('<option value="">Pilih Sub Bagian</option>');
                                      }
                                  });
                              });
                          </script>
                          <?php }?>


                          <!-- UNTUK REGIONAL -->
                          <?php if($sesi_region != 13){ ?>

                            <div class="form-group col-6">
                              <label>Role</label>
                              <select class="form-control" name="role" id="role">
                                  <option value="">Pilih Nama Role</option>
                              </select>
                          </div>

                          <div class="form-group col-6">
                            <label>Region</label>
                              <select class="form-control select2" style="width: 100%;" name="region" id="region" disabled>
                              <?php foreach ($regionuser as $reguser) : ?>
                                <option value="<?php echo $reguser['id_regional'] ;?>"><?php echo $reguser['nama_regional']?></option>
                              <?php endforeach; ?>
                              </select>
                              <input type="hidden" name="region" value="<?php echo $reguser['id_regional']; ?>">
                          </div>

                            <div class="form-group col-6">
                              <label>Nama Bagian</label>
                              <select class="form-control" style="width: 100%;" name="bagian" id="bagian">
                                  <option value="">Pilih Nama Bagian</option>
                                  <?php foreach ($baguser as $baguser) : ?>
                                  <option value="<?php echo $baguser['id_bagian'] ;?>">
                                          <?php echo $baguser['nama_bagian']?>
                                  </option>
                                <?php endforeach; ?>
                              </select>
                          </div>

                          <div class="form-group col-6">
                              <label>Nama Sub-Bagian</label>
                              <select class="form-control" name="subbagian" id="subbagian">
                                  <option value="">Pilih Nama Sub-Bagian</option>
                              </select>
                          </div>

                          <script>
                              $(document).ready(function() {
                                if ($('#region').prop('disabled')) {
                                          // Ambil data role saat halaman dimuat
                                          var region_id = $('#region').val();
                                          if (region_id !== '') {
                                              $.ajax({
                                                  url: '<?php echo base_url("c_master_userdms/get_role_by_region"); ?>/' + region_id,
                                                  type: 'get',
                                                  dataType: 'json',
                                                  success: function(response) {
                                                      $('#role').empty();
                                                      $('#role').append('<option value="">Pilih Nama Role</option>');
                                                      $.each(response, function(index, value) {
                                                          $('#role').append('<option value="' + value.id + '">' + value.role + '</option>');
                                                      });
                                                  }
                                              });
                                          } else {
                                              $('#role').empty();
                                              $('#role').append('<option value="">Pilih Nama Role</option>');
                                          }
                                      }
                                  });

                              $('#bagian').change(function() {
                                      var section_id = $(this).val();
                                      if (section_id !== '') {
                                          // Ambil data sub bagian berdasarkan id bagian yang dipilih
                                          $.ajax({
                                              url: '<?php echo base_url("c_master_userdms/get_subbagian_by_bagian"); ?>/' + section_id,
                                              type: 'get',
                                              dataType: 'json',
                                              success: function(response) {
                                                  $('#subbagian').empty();
                                                  $('#subbagian').append('<option value="">Pilih Sub Bagian</option>');
                                                  $.each(response, function(index, value) {
                                                      $('#subbagian').append('<option value="' + value.id_sub_bag + '">' + value.nama_sub_bag + '</option>');
                                                  });
                                              }
                                          });
                                      } else {
                                          $('#subbagian').empty();
                                          $('#subbagian').append('<option value="">Pilih Sub Bagian</option>');
                                      }
                                  });
                          </script>

                         <?php }?>

                          <div class="form-group col-6">
                            <label>Status</label>
                              <select class="form-control select2" style="width: 100%;" name="status">
                                  <option value="1">Active</option>
                                  <option value="0">Non-Active</option>
                              </select>
                          </div>
                      <div class="form-group col-4">
                            <label for="exampleInputEmail1">ID Telegram</label>
                            <div class="file_div1">
                              <div>
                              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="id_telegram[]">
                                <input class="btn btn-primary mt-1" type="button" onclick="add_file1();" value="+" style="width:40px;height:40px;margin-bottom:10px">
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-4">
                            <label for="exampleInputEmail1">Nomor Telepon</label>
                            <div class="file_div2">
                              <div>
                              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="no_telp[]">
                                <input class="btn btn-primary mt-1" type="button" onclick="add_file2();" value="+" style="width:40px;height:40px;margin-bottom:10px">
                              </div>
                            </div>
                          </div>
                          <div class="form-group col-4">
                            <label for="exampleInputEmail1">Email</label>
                            <div class="file_div3">
                              <div>
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="" name="email[]">
                                <input class="btn btn-primary mt-1" type="button" onclick="add_file3();" value="+" style="width:40px;height:40px;margin-bottom:10px">
                              </div>
                            </div>
                          </div>
                        </div>
                      <!-- /.card-body -->
                      <input type="hidden" name="ktsnd" value="123456">
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
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
      <script type="text/javascript">
      function add_file1()
      {
      $(".file_div1").append(" <div><input type='text' class='form-control' id='exampleInputEmail1' name='id_telegram[]'><input class='btn btn-danger mt-1' type='button' value='-' onclick=remove_file1(this); style='width:40px;height:40px;margin-left:3px;margin-bottom:10px'></div>");
      }
      function remove_file1(ele)
      {
      $(ele).parent().remove();
      }
    </script>
    <script type="text/javascript">
      function add_file2()
      {
      $(".file_div2").append(" <div><input type='text' class='form-control' id='exampleInputEmail1' name='no_telp[]'><input class='btn btn-danger mt-1' type='button' value='-' onclick=remove_file2(this); style='width:40px;height:40px;margin-left:3px;margin-bottom:10px'></div>");
      }
      function remove_file2(ele)
      {
      $(ele).parent().remove();
      }
    </script>
    <script type="text/javascript">
      function add_file3()
      {
      $(".file_div3").append(" <div><input type='text' class='form-control' id='exampleInputEmail1' name='email[]'><input class='btn btn-danger mt-1' type='button' value='-' onclick=remove_file3(this); style='width:40px;height:40px;margin-left:3px;margin-bottom:10px'></div>");
      }
      function remove_file3(ele)
      {
      $(ele).parent().remove();
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
