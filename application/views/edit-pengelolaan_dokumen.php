<!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/adminlte.min.css">
  <?php 
  $role = $this->session->userdata('role_id');
  $id_region = $this->session->userdata('id_region');
  $item_dok = $this->session->userdata('item_dok');
  ?>


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
                      <h3 class="card-title">Edit Data Dokumen</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <?php foreach ($data_dokumen as $row) : ?>
                    <form onsubmit="return Validate(this);" action="<?php echo base_url(). 'c_pengelolah_dokumen_dms/update_data_dokumen_dms' ?>" method="post" enctype="multipart/form-data">
                      <div class="card-body">
                      <input type="hidden" name="id" class="form-control" value="<?php echo $row->dkm_awal ?>" >
                      <input type="hidden" name="id_proses" class="form-control" value="<?php echo $row->id_proses ?>" >

                      <!-- OPSI EDIT STATUS PADA DMS TIDAK DITAMPILKAN  -->
                        <!-- <div class="form-group" hidden>
                            <label>Status</label>
                            <select class="form-control select2" style="width: 100%;" name="status" id="myselect">
                                <option value="Baru" <?= $row->statuss == "Baru" ? "selected" :null ?>>Baru</option>
                                <option value="Mencabut" <?= $row->statuss == "Mencabut" ? "selected" :null ?>>Mencabut</option>
                                <option value="Mengubah" <?= $row->statuss == "Mengubah" ? "selected" :null ?>>Mengubah</option>
                                <option value="Dicabut" <?= $row->statuss == "Dicabut" ? "selected" :null ?>>Dicabut</option>
                                <option value="Diubah" <?= $row->statuss == "Diubah" ? "selected" :null ?>>Diubah</option>
                            </select>
                        </div>
                        <div class="form-group" id="cabutubah"> 
                            <label>Dokumen Lama</label>
                            <select class="form-control select2" style="width: 100%;" name="dokumen_lama">
                              <option readonly>- Pilih data -  </option>
                                <?php foreach ($data_dokumen_lama as $jd) : ?>
                                  <option value="<?php echo $jd->id_dokumen;?>"
                                    <?php 
                                        if ($jd->id_dokumen == $row->id_dokumen_status) {
                                            echo "selected";
                                        }
                                    ?>>
                                          <?php echo $jd->nama_dokumen?>
                                  </option>
                                <?php endforeach; ?>
                            </select>
                        </div> -->

                        
                        <div class="form-group">
                          <label for="exampleInputEmail1">Nama Dokumen</label>
                          <input type="text" class="form-control" name="nama_dokumen" value="<?= $row->nama_dokumen ?>">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Nomor Dokumen</label>
                          <input type="text" class="form-control" name="nomor_dokumen" value="<?= $row->no_dokumen ?>">
                        </div>
                        
                        <div class="form-group">
                            <label>Status Dokumen</label>
                            <select class="form-control select2" style="width: 100%;" name="status_dok" id="status_dok">
                                <option value="Dokumen Aktif" <?php echo ($row->status_dok === 'Dokumen Aktif') ? 'selected' : ''; ?>>Aktif</option>
                                <option value="Dokumen Non-Aktif" <?php echo ($row->status_dok === 'Dokumen Non-Aktif') ? 'selected' : ''; ?>>Non-Aktif</option>
                            </select>
                        </div>
                        
                        <?php
                          if ($item_dok=='internal') { ?>
                            <div class="form-group">
                              <label>Item Dokumen</label>
                              <select class="form-control select2" style="width: 100%;" name="item_dok" id="item_dok">
                                <option value="Dokumen Internal" selected readonly>Dokumen Internal</option>
                              </select>
                            </div>
                          <?php
                          }
                          else if($item_dok=='eksternal'){ ?>
                          <div class="form-group">
                              <label>Item Dokumen</label>
                              <select class="form-control select2" style="width: 100%;" name="item_dok" id="item_dok">  
                                <option value="Dokumen Eksternal">Dokumen Eksternal</option>
                              </select>
                            </div>
                          <?php
                          }
                          ?>

                        <div class="form-group">
                            <label>Level Dokumen</label>
                            <select class="form-control select2" style="width: 100%;" name="level_dok" required>
                                <?php foreach ($level_dok as $level) : ?>
                                    <option value="<?php echo $level->id_lvl; ?>" <?php if ($level->id_lvl == $row->id_level_dok) echo "selected"; ?>>
                                        <?php echo $level->status_level_dok ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- <div class="form-group">
                          <label>Region</label>
                          <select class="form-control" name="region" required id="region">
                                <option value="">Pilih Nama Region</option>
                                    <?php foreach ($regionuser as $reguser) : ?>
                                        <option value="<?php echo $reguser['id_regional']; ?>"> <?php echo $reguser['nama_regional']; ?> </option>
                                    <?php endforeach; ?>
                            </select>
                        </div> -->

                        <?php
                        // Deklarasikan variabel $selectedAllRegion
                        $selectedAllRegion = false;
                        if (in_array($row->id_regional, [1, 2, 3, 4, 5, 6, 13])) {
                            // Jika $row->id_regional ada dalam array, tandai "ALL REGION" sebagai selected
                            $selectedAllRegion = true;
                        }
                        ?>

                        <div class="form-group">
                            <label>Region</label>
                            <select class="form-control" name="region" required id="region" required>
                                <option value="">Pilih Nama Region</option>
                                <option value="99" <?php if ($selectedAllRegion) echo "selected"; ?>>All Region</option>
                                <?php foreach ($regionuser as $reguser) : ?>
                                    <option value="<?php echo $reguser['id_regional']; ?>" <?php if ($reguser['id_regional'] == $row->id_regional) echo "selected"; ?>>
                                        <?php echo $reguser['nama_regional'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Media Simpan</label>
                            <select class="form-control select2" style="width: 100%;" name="medsim" required>
                                <?php foreach ($media_simpan as $medsim) : ?>
                                    <option value="<?php echo $medsim->id_medsim; ?>" <?php if ($medsim->id_medsim == $row->id_media_simpan_dok) echo "selected"; ?>>
                                        <?php echo $medsim->media_simpan ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Tanggal Terbit Dokumen -->
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal Diterbitkan Dokumen</label>
                            <input type="date" class="form-control" id="inputTanggal1" name="tanggal_penerbitan" value="<?= $row->tgl_terbit ?>">
                        </div>

                        <!-- Tanggal Tetap Dokumen -->
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal Ditetapkan Dokumen</label>
                            <input type="date" class="form-control" id="inputTanggal1" name="tanggal_penetapan" value="<?= $row->tgl_tetap ?>">
                        </div>

                        <!-- Lama Simpan Dokumen -->
                        <div class="form-group">
                            <label for="exampleInputEmail1">Lama Simpan Dokumen</label>
                            <div class="radio-container">
                              <label>
                                <div class="form-check">
                                  <input class="form-check-input" type="radio" name="durasi_simpan" id="simpan_tak_hingga" value="1">
                                  <label class="form-check-label" for="simpan_tak_hingga">Sampai Masa Berlaku</label>
                                </div>
                              </label>
                              <label>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="durasi_simpan" id="simpan_manual" value="0" checked>
                                <label class="form-check-label" for="simpan_manual">Manual</label>
                              </div>
                              </label>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <input type="date" class="form-control" id="inputtglsimpanAwal" name="tglSimpanawal" value="<?= $row->lama_simpan_awal ?>">
                                </div>
                                <div class="col">
                                    <input type="date" class="form-control" id="inputtglsimpanAkhir" name="tglSimpanakhir" value="<?= $row->lama_simpan_akhir ?>">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Status Revisi Dokumen -->
                        <div class="form-group">
                            <label for="exampleInputEmail1">Status Revisi</label>
                            <div class="form-inline">
                                <!-- Input untuk status revisi -->
                                <input type="text" class="form-control mr-2" id="inputStatusRev" name="status_rev" value="<?= explode('/',$row->status_rev)[0] ?>">

                                <!-- Input untuk tanggal revisi -->
                                <input type="date" class="form-control" id="inputTanggal2" name="tanggal_rev" value="<?= explode('/', $row->status_rev)[1] ?>">
                            </div>
                        </div>

                    <script>
                        // Fungsi untuk menghasilkan nomor revisi secara otomatis
                        function generateRevNumber() {
                            // Mendapatkan nomor terakhir dari localStorage atau mengeset ke 0 jika belum ada
                            let lastRevNumber = parseInt(localStorage.getItem('lastRevNumber')) || 0;

                            // Generate nomor secara urut dalam format R-00
                            const formattedRevNumber = lastRevNumber.toString().padStart(2, '0');
                            const generatedRevNumber = 'R-' + formattedRevNumber;

                            return generatedRevNumber;
                        }

                        // Mengambil elemen input status_revisi
                        const inputStatusRev = document.getElementById('inputStatusRev');

                        // Menampilkan nomor terbaru pada elemen input status_rev saat halaman dimuat
                        inputStatusRev.value = generateRevNumber();

                        // Event listener untuk memperbarui nomor revisi jika ada perubahan data
                        document.getElementById('inputTanggal2').addEventListener('change', () => {
                            inputStatusRev.value = generateRevNumber();
                        });

                        // Mendapatkan tanggal saat ini
                        const today = new Date().toISOString().split('T')[0];

                        // Set nilai atribut 'value' input tanggal menjadi tanggal saat ini
                        inputTanggal2.value = today;
                    </script>

                        <div class="form-group">
                            <label>Jenis Dokumen</label>
                            <select class="form-control select2" style="width: 100%;" name="jenis_dok" required>
                            <?php foreach ($jenis_dokumen as $jd) : ?>
                                <option value="<?php echo $jd->id_jenis_dokumen;?>"
                                <?php 
                                    if ($jd->id_jenis_dokumen == $row->jenis_dokumen) {
                                        echo "selected";
                                    }
                                ?>>
                                        <?php echo $jd->nama_jenis_dokumen?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Metode Indeks</label>
                          <input type="text" class="form-control" name="metode_indeks" value="<?= $row->metode_indeks ?>">
                        </div>

                        <div class="form-group">
                            <label for="inputDescription">Tentang</label>
                            <textarea id="inputDescription" class="form-control" rows="4" name="tentang"><?= $row->tentang ?></textarea>
                        </div>


                        <div class="form-group">
                      <label>Memberikan Akses ke</label>
                        <?php
                          $specialCodes = [];
                          $regional1 = [];
                          $regional2 = [];
                          $regional3 = [];
                          $regional4 = [];
                          $regional5 = [];
                          $regional6 = [];
                          $normalCodes = [];

                          foreach ($master_bagian as $jd) {

                            
                              if ($jd->kode === 'ABGN') {
                                  $specialCodes[] = $jd;
                              } 
                              else if ($jd->id_region === '1'){
                                $regional1[] = $jd;
                              }
                              else if ($jd->id_region === '2'){
                                $regional2[] = $jd;
                              }
                              else if ($jd->id_region === '3'){
                                $regional3[] = $jd;
                              }
                              else if ($jd->id_region === '4'){
                                $regional4[] = $jd;
                              }
                              else if ($jd->id_region === '5'){
                                $regional5[] = $jd;
                              }
                              else if ($jd->id_region === '6'){
                                $regional6[] = $jd;
                              }
                              else {
                                  $normalCodes[] = $jd;
                              }
                          }

                          usort($normalCodes, function ($a, $b) {
                              return strcmp($a->kode, $b->kode);
                          });

                          $sortedMasterBagian = array_merge( $specialCodes, $regional1, $regional2, $regional3, $regional4, $regional5, $regional6, $normalCodes);
                        ?>
                        <!-- Tampilkan data yang sudah diurutkan -->
                        <select class="select2" multiple="multiple" data-placeholder="" style="width: 100%;" name="akses_for[]" required>
                            <?php foreach ($sortedMasterBagian as $jd) : ?>
                                <option value="<?php echo $jd->kode; ?>"
                                    <?php 
                                          $str = $row->akses_for;
                                          $akses = explode(",",$str);
                                          if (in_array($jd->kode, $akses)) {
                                            echo "selected";
                                          }
                                      ?> >
                                    <?php echo $jd->nama_bagian ?> - <?php echo $jd->nama_regional ?> ( kode : <?php echo $jd->kode; ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                        
                        <!-- <div class="form-group" >
                            <label>Memberikan Akses ke</label>
                            <select class="select2" multiple="multiple" data-placeholder="" style="width: 100%;" name="akses_for[]" value="value="<?= $row->akses_for ?>"">
                            <?php foreach ($master_bagian as $usr) : ?>
                                    <option value="<?php echo $usr->kode;?>" 
                                      <?php 
                                          $str = $row->akses_for;
                                          $akses = explode(",",$str);
                                          if (in_array($usr->kode, $akses)) {
                                            echo "selected";
                                          }
                                      ?> >
                                      <?php echo $usr->nama_bagian ?> - <?php echo $usr->nama_regional ?> ( kode : <?php echo $usr->kode; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div> -->

                        <div class="form-group">
                          <label for="exampleInputFile">Upload Dokumen</label>
                          <div class="input-group">
                            <div class="custom-file">
                            <input type="file" class="custom-file-input" id="exampleInputFile" name="upload_dokumen" accept=".pdf" value="<?php echo $row->upload_dokumen ?>">
                              <input type="text" class="custom-file-input" id="exampleInputFile" name="upload_dokument" accept=".pdf" value="<?php echo $row->upload_dokumen ?>">
                              <label class="custom-file-label" for="exampleInputFile"><?php echo $row->upload_dokumen ?></label>
                            </div>
                            <div class="input-group-append">
                              <span class="input-group-text">*pdf</span>
                            </div>
                          </div>
                        </div>
                       <!-- Pass Dokumen -->
                        <div class="form-group">
                          <label>Edit password?</label>
                          <div class="form-check">
                              <input class="form-check-input" type="radio" name="password_option" id="passwordOptionYes" value="1">
                              <label class="form-check-label" for="passwordOptionYes">Ya</label>
                          </div>
                          <div class="form-check">
                              <input class="form-check-input" type="radio" name="password_option" id="passwordOptionNo" value="0" checked>
                              <label class="form-check-label" for="passwordOptionNo">
                                  Tidak
                              </label>
                          </div>
                      </div>

                      <div class="form-group" id="passwordInputWrapper" style="display:none;">
                          <label for="exampleInputPassword">Password Dokumen</label>
                          <input type="text" class="form-control" id="exampleInputPassword" name="password_dok" value="<?= $this->encryption->decrypt($row->password) ?>">
                      </div>

                      <script>
                          // Mengambil elemen radio button
                          const passwordOptionYes = document.getElementById('passwordOptionYes');
                          const passwordOptionNo = document.getElementById('passwordOptionNo');

                          // Mengambil elemen input password
                          const passwordInputWrapper = document.getElementById('passwordInputWrapper');

                          // Menambahkan event listener untuk memantau perubahan pada elemen radio button
                          passwordOptionYes.addEventListener('change', function () {
                              if (passwordOptionYes.checked) {
                                  passwordInputWrapper.style.display = 'block';
                              } else {
                                  passwordInputWrapper.style.display = 'none';
                              }
                          });

                          passwordOptionNo.addEventListener('change', function () {
                              if (passwordOptionNo.checked) {
                                  passwordInputWrapper.style.display = 'none';
                              } else {
                                  passwordInputWrapper.style.display = 'block';
                              }
                          });
                      </script>
                      <!-- /.card-body -->
      
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary" >Simpan</button>
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
        format: 'DD-MM-YYYY'
      });
      //Date range picker
      $('#reservation').daterangepicker(
        {
        timePicker: true,
        timePickerIncrement: 30,
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
  <script>
    $(document).ready(function(){
      $("#cabutubah").hide();
        $("#myselect").change(function(){
          var status = $( "#myselect option:selected" ).text();
          if(status != 'Baru'){
            $("#cabutubah").show();
            $("#jenisdokumen").hide();
            $("#aksesuntuk").hide();
            $("#pic").hide();
            $("#nama_dokumen").hide();
          }
          else {
            $("#cabutubah").hide();
            $("#jenisdokumen").show();
            $("#aksesuntuk").show();
            $("#pic").show();
            $("#nama_dokumen").show();
          }
            
        })
      })
    
  </script>
</body>
</html>
