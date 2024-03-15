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
                  <h3 class="card-title">Tambah Data Dokumen</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                
                 
                
                <div class="card-body">
                    <div class="form-group">
                    
                    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-default">
                    Tambah Data Massal
                    </button>

                    <form onsubmit="return Validate(this);" action="<?php echo base_url() . 'c_pengelolah_dokumen_dms/tambah_data_dokumen_dms' ?>" method="post" enctype="multipart/form-data">
                    <?php foreach ($id_dok_akhir as $id_akhir) : ?>
                    <?= form_open() ?>
                    <input type="hidden" name="id_dok_akhir" value="<?php echo $id_akhir->id_dokumen ?>">
                    <?php endforeach; ?>   
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
                              <?php if($item_dok=='internal'){ ?>
                               <?php foreach ($data_dokumen_lama as $jd) : ?>
                                  <option value="<?php echo $jd->id_dokumen;?>">
                                          <?php echo $jd->nama_dokumen?>
                                  </option>
                                <?php endforeach; ?>
                              <?php } ?>
                              <?php if($item_dok=='eksternal'){ ?>
                               <?php foreach ($data_dokumen_lama as $jd) : ?>
                                  <option value="<?php echo $jd->id_dokumen;?>">
                                          <?php echo $jd->nama_dokumen?>
                                  </option>
                                <?php endforeach; ?>
                              <?php } ?>
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
                    <!-- <div class="form-group">
                        <label for="exampleInputEmail1">Jenis Dokumen</label>
                        <div class="form-inline mt-3"> -->
                            <!-- radio for Dokumen Internal -->
                            <!-- <div class="custom-control custom-radio mr-4">
                                <input class="custom-control-input cekdokumen" type="radio" id="customRadioInternal" name="customRadio" value="" checked>
                                <label for="customRadioInternal" class="custom-control-label">Dokumen Internal</label>
                            </div> -->
                            
                            <!-- radio for Dokumen External -->
                            <!-- <div class="custom-control custom-radio">
                                <input class="custom-control-input cekdokumen" type="radio" id="customRadioEksternal" name="customRadio" value="<?php echo $this->session->userdata('bagian')?>">
                                <label for="customRadioEksternal" class="custom-control-label">Dokumen Eksternal</label>
                            </div>
                        </div>
                    </div> -->


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

                   <!-- Level Dokumen -->
                    <div class="form-group">
                      <label>Level Dokumen</label>
                      <select class="form-control" name="level_dokumen" required>
                            <option value="">Pilih Level Dokumen</option>
                                <?php foreach ($level_dokumen as $status_dok) : ?>
                                    <option value="
                                    <?php echo $status_dok['id_level_dok']; ?>">
                                    <?php echo $status_dok['status_level_dok']; ?>
                                  </option>
                                <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Nomor Dokumen -->
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nomor Dokumen</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" name="nomor_dokumen" required>
                    </div>
                    <!-- Tanggal Terbit Dokumen -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal Terbit Dokumen</label>
                        <input type="date" class="form-control" id="inputTanggal1" name="tanggal_terbit">
                    </div>
                    <!-- Tanggal Tetap Dokumen -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tanggal Ditetapkan Dokumen</label>
                        <input type="date" class="form-control" id="inputTanggal1" name="tanggal_tetap">
                    </div>
                    <script>
                        // Mengambil elemen input tanggal
                        const inputTanggal1 = document.getElementById('inputTanggal1');

                        // Mendapatkan tanggal saat ini
                        const today = new Date().toISOString().split('T')[0];

                        // Set nilai atribut 'value' input tanggal menjadi tanggal saat ini
                        inputTanggal1.value = today;
                    </script>

                    <div class="form-group">
                      <label>Status Dokumen</label>
                      <select class="form-control select2" style="width: 100%;" name="status_dok" id="status_dok">
                        <option value="Dokumen Aktif">Aktif</option>
                        <option value="Dokumen Non-Aktif">Non-Aktif</option>
                      </select>
                    </div>

                    <!-- Nama Dokumen -->
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nama Dokumen</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" name="nama_dokumen" required>
                    </div>

                    <!-- Bagian Region Dokumen -->

                    <?php 
                      if($role == 5)
                      {
                        ?>
                        <!-- Bagian Region Dokumen -->
                        <div class="form-group">
                          <label>Region</label>
                          <select class="select2"  data-placeholder="" style="width: 100%;" name="region" required id="region">
                                <option value="">Pilih Nama Region</option>
                                    <?php foreach ($regionuser as $reguser) : ?>
                                        <option value="<?php echo $reguser['id_regional']; ?>"> <?php echo $reguser['nama_regional']; ?> </option>
                                    <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Bagian Penerbit Dokumen -->
                        <div class="form-group">
                            <label>Bagian Penerbit</label>
                            <select class="form-control" name="bag_penerbit" required id="bagian">
                                  
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
                                                  $('#bagian').append('<option value="">Pilih Bagian</option>');
                                                  $.each(response, function(index, value) {
                                                      $('#bagian').append('<option value="' + value.id_bagian + '">' + value.nama_bagian + '</option>');
                                                  });
                                              }
                                          });
                                      } else {
                                          $('#bagian').empty();
                                          
                                          $('#bagian').append('<option value="">Pilih Bagian</option>');
                                      }
                                  });

                              });
                          </script>

                      <?php 
                      }
                    ?>
                    <!-- Status Rvisi Dokumen -->
                    <div class="form-group">
                        <label for="exampleInputEmail1">Status Revisi</label>
                        <div class="form-inline">
                            <input type="text" class="form-control mr-2" id="inputStatusRev" name="status_rev">
                            <input type="date" class="form-control" id="inputTanggal2" name="tanggal_rev">
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
                        inputTanggal.value = today;
                    </script>

                    <script>
                        // Mengambil elemen input tanggal
                        const inputTanggal2 = document.getElementById('inputTanggal2');

                        // Mendapatkan tanggal saat ini
                        const today = new Date().toISOString().split('T')[0];

                        // Set nilai atribut 'value' input tanggal menjadi tanggal saat ini
                        inputTanggal2.value = today;
                    </script>

                    <!-- Metode Indeks Dokumen -->
                    <div class="form-group">
                      <label for="exampleInputEmail1">Metode Indeks</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" name="indeks_dokumen" required>
                    </div>
                    <!-- Media Simpan Dokumen -->
                    <div class="form-group">
                      <label>Media Simpan Dokumen</label>
                      <select class="form-control" name="media_spmn" required>
                            <option value="">Pilih Media Simpan </option>
                                <?php foreach ($media_spmn as $simpan) : ?>
                                    <option value="
                                    <?php echo $simpan['id_media_simpan_dok']; ?>">
                                    <?php echo $simpan['media_simpan']; ?>
                                  </option>
                                <?php endforeach; ?>
                        </select>
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
                          <input type="date" class="form-control" id="inputtglsimpanAwal" name="tglSimpanawal">
                        </div>
                        <div class="col">
                          <input type="date" class="form-control" id="inputtglsimpanAkhir" name="tglSimpanakhir">
                        </div>
                      </div>
                    </div>

                    <script>
                      // Mengambil elemen radio button
                      const simpan_tak_hingga = document.getElementById('simpan_tak_hingga');
                      const simpan_manual = document.getElementById('simpan_manual');

                      const inputtglsimpanAwal = document.getElementById('inputtglsimpanAwal');
                      const inputtglsimpanAkhir = document.getElementById('inputtglsimpanAkhir');

                      // Menambahkan event listener untuk memantau perubahan pada elemen radio button
                      simpan_tak_hingga.addEventListener('change', function () {
                          if (simpan_tak_hingga.checked) {
                              inputtglsimpanAwal.style.display = 'none';
                              inputtglsimpanAkhir.style.display = 'none';
                          }
                      });

                      simpan_manual.addEventListener('change', function () {
                          if (simpan_manual.checked) {
                              inputtglsimpanAwal.style.display = 'block';
                              inputtglsimpanAkhir.style.display = 'block';
                          }
                      });
                  </script>

                    <script>
                        // Mengambil elemen input tanggal
                        const inputtglsimpanAwal = document.getElementById('inputtglsimpanAwal');

                        // Mendapatkan tanggal saat ini
                        const today = new Date().toISOString().split('T')[0];

                        // Set nilai atribut 'value' input tanggal menjadi tanggal saat ini
                        inputtglsimpanAwal.value = today;
                    </script>

                    <script>
                        // Mengambil elemen input tanggal
                        const inputtglsimpanAkhir = document.getElementById('inputtglsimpanAkhir');

                        // Mendapatkan tanggal saat ini
                        const today = new Date().toISOString().split('T')[0];

                        // Set nilai atribut 'value' input tanggal menjadi tanggal saat ini
                        inputtglsimpanAkhir.value = today;
                    </script>
                    <!-- <div class="form-group">
                      <label for="exampleInputEmail1">Nomor</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" name="nama_dokumen" required>
                    </div> -->
                    <!-- <div class="form-group">
                      <label>Tanggal Ditetapkan:</label>
                      <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="tanggal_penetapan" value="<?= set_value('tanggal_penetapan') ?>" autocomplete="off" required />
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div> -->


                    <?php
                    if ($item_dok=='internal') { ?>
                      <div class="form-group">
                      <label>Jenis Dokumen Internal</label>
                      <select class="form-control select2" style="width: 100%;" name="jenis_dok" required>
                        <?php foreach ($jenis_dok_int as $jdi) : ?>
                          <option value="<?php echo $jdi->id_jenis_dokumen; ?>">
                            <?php echo $jdi->nama_jenis_dokumen ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <?php
                    }
                    else if($item_dok=='eksternal'){ ?>
                     <div class="form-group">
                        <label>Jenis Dokumen Eksternal</label>
                        <select class="form-control select2" style="width: 100%;" name="jenis_dok" required>
                          <?php foreach ($jenis_dok_eks as $jde) : ?>
                            <option value="<?php echo $jde->id_jenis_dokumen; ?>">
                              <?php echo $jde->nama_jenis_dokumen ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    <?php
                    }
                    ?>
                    
                    <div class="form-group">
                      <label for="inputDescription">Tentang</label>
                      <textarea id="inputDescription" class="form-control" rows="4" name="tentang"></textarea>
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
                                <option value="<?php echo $jd->kode; ?>">
                                    <?php echo $jd->nama_bagian ?> - <?php echo $jd->nama_regional ?> ( kode : <?php echo $jd->kode; ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputFile">Upload Dokumen</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="exampleInputFile" name="upload_dokumen" accept=".pdf" required>
                          <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                        </div>
                        <div class="input-group-append">
                          <span class="input-group-text">*pdf</span>
                        </div>
                      </div>
                    </div>

                    <script>
                      // Cek apakah file yang diunggah adalah PDF setelah tombol "Browse" ditekan
                      document.getElementById('exampleInputFile').addEventListener('change', function() {
                        const fileInput = this;
                        const allowedExtensions = /(\.pdf)$/i;

                        // Ambil nama file yang diunggah
                        const fileName = fileInput.value.split("\\").pop();

                        // Cek apakah nama file memiliki ekstensi yang diizinkan (PDF)
                        if (!allowedExtensions.exec(fileName)) {
                          // Tampilkan pesan alert
                          alert('Hanya file PDF yang diperbolehkan untuk diunggah.');
                          // Reset input file agar pengguna dapat memilih kembali
                          fileInput.value = '';
                          return false;
                        }
                      });
                    </script>

                    
                    <!-- Pass Dokumen -->
                    <div class="form-group">
                      <label>Apakah menggunakan password?</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="password_option" id="passwordOptionYes" value="1">
                        <label class="form-check-label" for="passwordOptionYes">Ya</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="password_option" id="passwordOptionNo" value="0" checked>
                        <label class="form-check-label" for="passwordOptionNo">Tidak</label>
                      </div>
                    </div>

                  <div class="form-group" id="passwordInputWrapper" style="display:none;">
                      <label for="exampleInputPassword">Password Dokumen</label>
                      <input type="text" class="form-control" id="exampleInputPassword" name="password_dok">
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
                    <button type="submit" class="btn btn-primary" onclick="one_click_bro('true');">Simpan</button>
                  </div>
                  <?= form_close() ?>
                </form>
              </div>
                      
              <?php if($item_dok=='internal'){ ?>
              <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Tambah Data Massal Dokumen Internal</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form method="post" action="<?= base_url('c_import_excel_doc/importData') ?>" enctype="multipart/form-data">
                      <div class="modal-body">
                        <div class="mb-3">
                          <label>Upload List Dokumen</label>
                          <input type="file" class="form-control" name="file_excel" accept=".xlsx" required>
                          <input type="text" name="item_dok_massal" value="dokumen_internal" hidden>
                          Download <a href="https://docs.google.com/spreadsheets/d/1PJl8QnaiK55K1yskVu-LedokkyEzFjGH/edit?usp=drive_link&ouid=118251321661051075663&rtpof=true&sd=true" target="_blank">
                          Template Upload Data Massal Dokumen Internal</a>
                        </div>
                        <div class="mb-3">
                        <label>Upload File PDF Dokumen</label>
                        <input class="form-control" name="pdf[]" id="formFileMultiple" type="file" accept=".pdf" multiple>
                        </div>
                        <input type="submit" class="btn btn-success" name="upload" value="Submit">
                        <input type="reset" class="btn btn-danger" value="Batal" >
                      </div>
                      
                        <div class="modal-footer justify-content-between">
                          </form>
                        </div>
                  </div>
              </div>

              <?php
               }
              else if($item_dok=='eksternal'){ ?>
               <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Tambah Data Massal Dokumen Eksternal</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form method="post" action="<?= base_url('c_import_excel_doc/importData') ?>" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                          <label>Upload List Dokumen</label>
                          <input type="file" class="form-control" name="file_excel" accept=".xlsx" required>
                          <input type="text" name="item_dok_massal" value="dokumen_eksternal" hidden>
                          Download <a href="https://docs.google.com/spreadsheets/d/1hPZoqRfmBUXLEmbP37wEFXAh14tDgWoB/edit#gid=2022141532" target="_blank">
                          Template Upload Data Massal Dokumen Eksternal</a>
                        </div>
                        <div class="mb-3">
                        <label>Upload File PDF Dokumen</label>
                        <input class="form-control" name="pdf[]" id="formFileMultiple" type="file" accept=".pdf" multiple>
                        </div>
                        <input type="submit" class="btn btn-success" name="upload" value="Submit">
                        <input type="reset" class="btn btn-danger" value="Batal" >
                      </div>
                      
                        <div class="modal-footer justify-content-between">
                          </form>
                        </div>
                  </div>
              </div>
              <?php
               }
              ?>


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

    <?php if ($this->session->flashdata('error_message')) { ?>
    <script>
    $(document).ready(function() {
      swal("Data gagal diupload karena perbedaan versi PDF", "", "error");
    });
    </script>
    <?php } ?>

</body>

</html>