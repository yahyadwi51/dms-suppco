<?php

require 'rotation.php';
class PDF extends PDF_Rotate
{
  protected $_outerText1; // dynamic text
  protected $_outerText2;
  protected $_outerText3;
  protected $_outerText4;

  function setWaterText($txt1 = "", $txt2 = "", $txt3 = "", $txt4 = "")
  {
    $this->_outerText1 = $txt1;
    $this->_outerText2 = $txt2;
    $this->_outerText3 = $txt3;
    $this->_outerText4 = $txt4;
    // $this->SetAlpha(0.5);
  }


  function Header()
  {
    //Put the watermark
    $this->SetFont('Arial', '', 50);
    $this->SetTextColor(255, 200, 200);
    $this->SetAlpha(0.8);
    $this->RotatedText(29, 170, $this->_outerText1, 45);
    $this->RotatedText(20, 240, $this->_outerText2, 45);
    $this->SetFont('Arial', '', 10);
    $this->RotatedText(5, 290, $this->_outerText3, 90);
    $this->RotatedText(10, 290, $this->_outerText4, 90);
    // $this->SetAlpha(0.5);
  }

  function RotatedText($x, $y, $txt, $angle)
  {
    //Text rotated around its origin
    $this->Rotate($angle, $x, $y);
    $this->Text($x, $y, $txt);
    $this->Rotate(0);
    // $this->SetAlpha(0.5);
  }
  public function RotateClockWise()
  {
    // $this->Rotate(270, 100, 145);
    $this->Rotate(270, 95, 110);
  }

  // public function RotateCounterClockWise()
  // {
  //     $this->Rotate(90, (210/2), (210/2));
  // }

}


date_default_timezone_set('Asia/Jakarta');
$tglsekarang = date("Y-m-d H:i:s");
$thun = date("Y");
$enter = "&nbsp";
$id = $this->session->userdata('id');
$username = $this->session->userdata('username');
$tts = "Copyright @ PT. APN " . $thun . ". Seluruh hak cipta. ";
$tts2 = "Ini adalah dokumen RAHASIA. Setiap penyalinan, redistribusi atau transmisi ulang dari setiap bagian dari dokumen ini tanpa persetujuan tertulis dari PTPN 1 dilarang";

foreach ($data_dokumen as $row): {
    $file = FCPATH . "uploads/" . $row['upload_dokumen'];
    $pass = $row['password'];
  }
  $text_image = 'assets/img/tt.png';
  $pdf = new PDF();

  if (file_exists($file)) {
    $pagecount = $pdf->setSourceFile($file);
  } else {
    return FALSE;
  }
  $MAC = exec('getmac');

  // Storing 'getmac' value in $MAC
  $MAC = strtok($MAC, ' ');
  $ip = "(" . $tglsekarang . ") ";
  $pdf->setWaterText($username, $ip, $tts, $tts2);

  /* loop for multipage pdf */
  for($i=1; $i <= $pagecount; $i++) 
      { 
        $tpl = $pdf->importPage($i);   
        $size = $pdf->getTemplateSize($tpl); 
        $orientation = ($size['h'] > $size['w']) ? 'P' : 'L';
        if ($orientation == "P") 
        {
          $pdf->addPage(); 
           //Put the watermark 
          $xxx_final = ($size['width']+150); 
          $yyy_final = ($size['height']+4); 
          $pdf->Image($text_image, $xxx_final, $yyy_final, 0, 0, 'png'); 
        } 
        else 
        {
          $pdf->addPage(); 
          $xxx_final = ($size['width']+150); 
          $yyy_final = ($size['height']+4); 
          $pdf->Image($text_image, $xxx_final, $yyy_final, 0, 0, 'png'); 
          $pdf->RotateClockWise();
        }   
        $pdf->useTemplate($tpl, 1, 1, 0, 0, TRUE);  
      }
  // ========================================================
      // PHP program for deleting all
// file from a folder

// Folder path to be flushed
$folder_path = "uploads/temp/down/";

// List of name of files inside
// specified folder
$files = glob($folder_path . '/*');

// Delete all the files of the list
foreach ($files as $file) {
  if (is_file($file)) {
    // Deleting the given file
    unlink($file);
  }
}
  // ========================================================
  $nama = "uploads/temp/" . $username;
  // $nama2 = "uploads/temp/down/" . $username;
  $nama2 = "uploads/temp/down/" . $row['upload_dokumen'];
  // $nama2="uploads/temp/".$username;
  $pdf->Output(FCPATH . $nama, 'F'); //save to a local file with the name given by filename (may include a path)
  $pdf->Output(FCPATH . $nama2, 'F'); //save to a local file with the name given by filename (may include a path)
  $url_file2 = base_url() . $nama2;
  $url_file = base_url() . $nama;
  $ss = $nama;
  $ss2 = $nama2;
endforeach;

// include 'make_pass.php';
// =========================================
?>

<?php
$role = $this->session->userdata('role_id');
$item_dok = $this->session->userdata('item_dok');
?>

<!-- AJAX -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/flipbook.style.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/flipbook.style.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/font-awesome.css">
<script src="<?php echo base_url() ?>assets/js/flipbook.min.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    $("#read").flipBook({
      //Layout Setting
      pdfUrl: '<?php echo $url_file ?>',
      lightBox: true,
      layout: 3,
      currentPage: { vAlign: "bottom", hAlign: "left" },
      // BTN SETTING
      btnShare: { enabled: false },
      btnPrint: {
        // hideOnMobile:true
        enabled: false
      },
      btnDownloadPages: {
        enabled: false
      },
      btnDownloadPdf: {
        forceDownload: false,
        enabled: false,
      },

      skinBackground: 'rgb(255,153,51)',
      btnColor: 'rgb(255,255,255)',
      sideBtnColor: 'rrgb(255,255,255)',
      sideBtnSize: 60,
      sideBtnBackground: "rgba(0,0,0,.7)",
      sideBtnRadius: 60,
      btnSound: { vAlign: "top", hAlign: "left" },
      btnAutoplay: { vAlign: "top", hAlign: "left" },

    });
  })
</script>

<script>
  $(document).ready(function () {
    // Tambahkan event listener untuk menangani aksi ketika tombol ditekan
    $("#read").click(function () {
      var documentId = $("#documentId").val();
      // Kirim permintaan AJAX ke controller saat tombol ditekan
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('c_pengelolah_dokumen_dms/rekam_log_view'); ?>",
        data: { id: documentId },
        success: function (response) {
          // Proses respons dari controller jika diperlukan
          console.log(response);
        },
        error: function () {
          console.log("Terjadi kesalahan dalam mengirim permintaan.");
        }
      });
    });
  });
</script>

<!--=====================================================t -->

<!-- ===================================================== -->

<style>
  body {
    background-color: #f6f6f6;
  }

  #author {
    font-size: 15px;
    font-weight: bold;
    color: #0186c9;
  }

  #date {
    margin-left: 10px;
    font-size: 15px;
    color: #819196;
  }

  #size {
    font-size: 15px;
    color: #819196;
  }

  #description {
    margin-top: 20px;
    font-weight: lighter;
  }

  .bs-example {
    margin: 20px;
  }

  .icon-input-btn {
    display: inline-block;
    position: relative;
  }

  .icon-input-btn input[type="submit"] {
    padding-left: 2em;
  }

  .icon-input-btn .fa {
    display: inline-block;
    position: absolute;
    left: 0.95em;
    top: 40%;
  }

  .view_password {
    cursor: pointer !important;
    pointer-events: auto;
  }
</style>
<script>
  $(document).ready(function () {
    $(".icon-input-btn").each(function () {
      var btnFont = $(this).find(".btn").css("font-size");
      var btnColor = $(this).find(".btn").css("color");
      $(this).find(".fa").css({ 'font-size': btnFont, 'color': btnColor });
    });
  });
</script>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Detail Dokumen</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Detail Dokumen</li>
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
              <div class="row">
                <div class="col-md-3">
                  <?php
                  foreach ($data_dokumen as $row): {
                      //   echo $row['nama_dokumen'];}
                      //   // endforeach;
                      $ids = $row['id_dokumen'];
                      ?>
                      <img src="<?php echo base_url() ?>assets/img/dms-.png" class="w-100 book-1">
                      <?php
                      echo form_open_multipart('c_pengelolah_dokumen_dms/lakukan_download_doc');
                      echo '<div class="button">';
                      echo '<a id="read" class="btn btn-primary mt-2 text-white">Baca PDF <i class="fas fa-book-reader fa-lg"></i></a>&nbsp';
                      echo '<input type="hidden" name="url1" value="' . $ss . '"/>';
                      echo '<input type="hidden" name="url2" value="' . $ss2 . '"/>';
                      echo '<input type="hidden" name="id" value="' . $ids . '"/>';
                      echo '<input type="hidden" name="nmnm" value="' . $row['upload_dokumen'] . '"/>';
                      echo '<input type="hidden" name="id" id="documentId" value="' . $row['id_dokumen'] . '"/>';
                      echo '<span class="icon-input-btn">
                              <i class="fa fa-file-pdf"></i> <input type="submit" name="submit" class="btn btn-success mt-2 text-white fa-input" value="Unduh File PDF" ></span></div>';
                      echo '</form>';
                      ?>
                    </div>
                    <div class="col-md-9 mt-3">
                      <!-- Info -->

                      <h3 id="title">Judul:
                        <?php echo $row['no_dokumen']; ?> -
                        <?php echo $row['nama_dokumen'];
                    }
                  endforeach; ?>
                  </h3>
                  <table class="table table-bordered table-striped" style="width:100%">
                    <tr>
                      <td style="width:20%">Jenis Dokumen</td>
                      <td style="width:80%">
                        <?= $row['nama_jenis_dokumen'] ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Nomor</td>
                      <td>
                        <?= $row['nama_dokumen'] ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Region</td>
                      <td>
                        <!-- <?php $id_regional = $row['id_regional'];
                        $id_reg = explode(",", $id_regional);
                        if (count(array_diff($id_reg, [1, 2, 3, 4, 5, 6, 13])) == 0) {
                          echo 'All Region & HO';
                        } else {
                          echo $id_reg;
                        } ?> -->



                        <?php $str = $row['id_regional'];

                        $str1 = explode(",", $str);
                        $jumlahdata = count($str1);
                        // }
                        $no = 1; // Deklarasi $no di luar perulangan foreach
                        foreach ($data_regional as $datareg):
                          for ($i = 0; $i < $jumlahdata; $i++) {
                            if ($datareg->id_regional == $str1[$i]) {
                              if ($jumlahdata == 1) {
                                echo $datareg->nama_regional;
                              } else {
                                echo $no . '. ' . $datareg->nama_regional . '<br>';
                                $no++; // Increment $no setiap kali data dicetak
                              }
                            }
                          }
                          ?>
                        <?php endforeach; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Bagian Penerbit</td>
                      <td>
                        <?php $str = $row['bagian_penerbit'];
                        $str2 = explode(",", $str);
                        $jumlahdata2 = count($str2);

                        $str1 = explode(",", $str);
                        $jumlahdata = count($str1);
                        // }
                        foreach ($data_bagian as $databag): ?>
                          <?php
                          for ($i = 0; $i < $jumlahdata; $i++) {
                            $no = $i + 1;
                            if ($databag->id_bagian == $str1[$i]) {
                              if ($jumlahdata == 1) {
                                echo $databag->nama_bagian;
                              } else {
                                echo $no . '. ' . $databag->nama_bagian . '<br>';
                              }
                            }
                          }
                          ?>
                        <?php endforeach; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Tanggal ditetapkan</td>
                      <td>
                        <?php $conv_tanggal = $row['tgl_tetap'];
                        $date = date('d M Y', strtotime($conv_tanggal));
                        echo $date;
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Tanggal diterbitkan</td>
                      <td>
                        <?php $conv_tanggal = $row['tgl_terbit'];
                        $date = date('d M Y', strtotime($conv_tanggal));
                        echo $date;
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Tanggal unggah</td>
                      <td>
                        <?php $conv_tanggal = $row['log'];
                        $date = date('d M Y', strtotime($conv_tanggal));
                        echo $date; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Jumlah Dokumen Dibaca</td>
                      <td>
                        <?php foreach ($view_down_doc as $view_down_doc):
                          $baca = $view_down_doc['jumlah_view'];
                          $down = $view_down_doc['jumlah_download'];
                        endforeach;
                        echo $baca . ' kali dibaca'; ?>
                      </td>
                    </tr>

                    <tr>
                      <td>Jumlah Dokumen Diunduh</td>
                      <td>
                        <?php echo $down . ' kali didownload'; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Status Perubahan</td>
                      <td>
                        <?php
                        foreach ($query_dokstatus as $databag):
                          $id_proses = $databag['id_dokumen'];
                          if ($row['id_dokumen'] == $databag['id_dokumen']) {
                            if ($databag['status'] == 'Mencabut' || $databag['status'] == 'Mengubah' || $databag['status'] == 'Kombinasi' || $databag['status'] == 'Diubah' || $databag['status'] == 'Dicabut') {
                              $id_dkmm = $this->encryption->encrypt($databag['id_dokumen_status']);
                              $id_dkm = strtr($id_dkmm, array('/' => '=='));
                              echo $databag['status'] . ' : '; ?>
                              <a href="<?php echo base_url(); ?>c_pengelolah_dokumen_dms/detail_dum/<?= $id_dkm ?>"
                                style="color:orange;font-weight:bold;">
                                <?php
                                $jumlahdata1 = count($dokumen_master);
                                for ($i = 0; $i < $jumlahdata1; $i++) {
                                  if ($databag['id_dokumen_status'] == $dokumen_master[$i]['id_dokumen']) {
                                    echo $dokumen_master[$i]['nama_dokumen'] . '<br>';
                                  }
                                }
                                $foundMatchingStatus = true;
                            }
                          }


                          ?>
                          </a>
                        <?php endforeach;
                        if (!$foundMatchingStatus) {
                          echo 'Dokumen Baru';
                        }
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Akses</td>
                      <td>
                        <?php $str = $row['akses_for'];
                        $str2 = explode(",", $str);
                        $jumlahdata2 = count($str2);

                        $str1 = explode(",", $str);
                        $jumlahdata = count($str1);
                        // }
                        $no = 1; // Deklarasi $no di luar perulangan foreach
                        foreach ($data_bagian as $databag):
                          for ($i = 0; $i < $jumlahdata; $i++) {
                            if ($databag->kode == $str1[$i]) {
                              if ($databag->nama_bagian != "All Bagian") {
                                if ($jumlahdata == 1) {
                                  echo $databag->nama_bagian . ' - ' . $databag->nama_regional;
                                } else {
                                  echo $no . '. ' . $databag->nama_bagian . ' - ' . $databag->nama_regional . '<br>';
                                  $no++; // Increment $no setiap kali data dicetak
                                }
                              }
                            }
                          }
                          ?>
                        <?php endforeach; ?>


                      </td>
                    </tr>
                    <tr>
                      <td>Tentang</td>
                      <td>
                        <?= $row['tentang'] ?>
                      </td>
                    </tr>
                    <tr>
                      <?php if ($role == 5) { ?>
                        <td>Password Dokumen</td>
                      <?php } ?>
                      <?php if ($role != 5) { ?>
                        <td>Request Cetak Dokumen</td>
                      <?php } ?>

                      <td>

                        <?php if ($role == 5) { ?>
                          <!-- <input type="password" class="form-control col-md-6" id="password" value="<?= $row['password'] ?>" disabled>||<input type="button" name="button" class="btn btn-danger text-white form-control-feedback view_password" value="Password" > -->
                          <input type="password" class="col-md-3" id="password" value="<?= $row['decrypt_password'] ?>"
                            disabled>&nbsp;<input type="button" name="button"
                            class="btn btn-primary text-white form-control-feedback view_password" value="Password">
                        <?php } ?>

                        &nbsp;
                        <?php
                        foreach ($data_req as $dareq):
                          $sts_req = $dareq['status_req'];
                          $tgl_down = $dareq['tanggal_down'];
                          $id_request = $dareq['id'];
                        endforeach;

                        if ($sts_req == "Request" && $tgl_down == "") {
                          echo '<span class="icon-input-btn">';
                          echo '<a class="btn btn-warning text-white form-control-feedback"> Permintaan Cetak Dokumen Masih Di Proses</a></span>';
                        } elseif ($sts_req == "Approve" && $tgl_down == "") {
                          // echo '<a data-toggle="modal" data-target="#tambah-data" class="btn btn-success text-white form-control-feedback">Cetak Dokumen</a>';
                          echo form_open_multipart('c_pengelolah_dokumen_dms/lakukan_cetak_doc');
                          ?>
                          <input type="password" class="col-md-3" id="password" value="<?= $row['decrypt_password'] ?>"
                            disabled>&nbsp;<input type="button" name="button"
                            class="btn btn-primary text-white form-control-feedback view_password" value="Password">

                          <?php
                          echo '<input type="hidden" name="url1" value="' . $ss . '"/>';
                          echo '<input type="hidden" name="url2" value="' . $ss2 . '"/>';
                          echo '<input type="hidden" name="id" value="' . $ids . '"/>';
                          echo '<input type="hidden" name="nmnm" value="' . $row['upload_dokumen'] . '"/>';
                          echo '<input type="hidden" name="id_req" value="' . $id_request . '"/>';
                          echo '<input type="hidden" name="aprove" value="Approve"/>';
                          echo '<span class="icon-input-btn">
                                    <i class="fa fa-file-pdf"></i> <input type="submit" name="submit" class="btn btn-success mt-2 text-white fa-input" value="Permintaan Cetak Dokumen Disetujui" onClick="document.location.reload(true)"></span>';
                          echo '</form>';
                        } else {
                          echo '<span class="icon-input-btn">';
                          echo '<a data-toggle="modal" data-target="#tambah-data" class="btn btn-danger text-white form-control-feedback">Request Cetak Dokumen</a></span>';
                        }
                        ?>
                        <!-- <a data-toggle="modal" data-target="#tambah-data" class="btn btn-warning text-white form-control-feedback">Request Cetak</a> -->
                        <!-- <span class="fa fa-eye-slash form-control-feedback view_password"></span> -->
                      </td>
                    </tr>
                    <tr>
                      <td>Media Simpan </td>
                      <td>
                        <?= $row['media_simpan'] ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Lama Simpan</td>
                      <td>
                        <?php
                        $lama_simpan_awal = $row['lama_simpan_awal'];
                        $lama_simpan_akhir = $row['lama_simpan_akhir'];

                        if ($lama_simpan_awal === '0000-00-00' || $lama_simpan_akhir === '0000-00-00' || empty($lama_simpan_awal) || empty($lama_simpan_akhir)) {
                          echo "Tanpa Batasan Waktu";
                        } else {
                          $awal = new DateTime($lama_simpan_awal);
                          $akhir = new DateTime($lama_simpan_akhir);
                          $diff = $akhir->diff($awal);
                          echo "Tanggal Awal: " . $lama_simpan_awal;
                          echo "<br>Tanggal Akhir: " . $lama_simpan_akhir;
                          echo "<br><b><i>" . $hasil = $diff->y . " tahun " . $diff->m . " bulan " . $diff->d . " hari";
                        }
                        ?>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- ./col -->
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

<!-- Modal Tambah -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="tambah-data" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button> -->
        <h4 class="modal-title">Form Request Cetak Dokumen</h4>
      </div>
      <!--  <form class="form-horizontal" action="<?php echo form_open_multipart('c_pengelolah_dokumen_dms/request_dokumen') ?>" method="post" enctype="multipart/form-data" role="form">-->
      <?php echo form_open_multipart('c_pengelolah_dokumen_dms/request_dokumen'); ?>
      <div class="modal-body">
        <div class="form-group">
          <label class="col-lg-2 col-sm-2 control-label">Keperluan</label>
          <div class="col-lg-12">
            <textarea class="form-control" name="keperluan" placeholder="Tuliskan Keperluan Cetak Dokumen"
              rows="8"></textarea>
            <input type="hidden" class="form-control" name="id_doc" placeholder="Tuliskan Nama"
              value="<?php echo $ids ?>">
            <input type="hidden" class="form-control" name="username" placeholder="Tuliskan Nama"
              value="<?php echo $username ?>">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-info" type="submit"> Kirim Request&nbsp;</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> Batal</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
<!-- END Modal Tambah -->

<?php ?>
<script>
  $(function () {
    // $('input').iCheck({
    //   checkboxClass: 'icheckbox_square-blue',
    //   radioClass: 'iradio_square-blue',
    //   increaseArea: '20%' /* optional */
    // });
    $('.view_password').on('click', function () {
      var x = document.getElementById("password");
      if (x.type === "password") {
        x.type = "text";
        $(this).removeClass('fa-eye-slash');
        $(this).addClass('fa-eye');
      } else {
        x.type = "password";
        $(this).removeClass('fa-eye');
        $(this).addClass('fa-eye-slash');
      }
    });
  });
</script>
<script>
  function reloadpage() {
    location.reload()
  }
</script>
