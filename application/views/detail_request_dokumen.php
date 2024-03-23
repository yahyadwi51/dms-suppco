<?php

require 'rotation.php';
class PDF extends PDF_Rotate
{
    protected $_outerText1; // dynamic text
    protected $_outerText2;
    protected $_outerText3;
    protected $_outerText4;

    public function setWaterText($txt1 = "", $txt2 = "", $txt3 = "", $txt4 = "")
    {
        $this->_outerText1 = $txt1;
        $this->_outerText2 = $txt2;
        $this->_outerText3 = $txt3;
        $this->_outerText4 = $txt4;
        // $this->SetAlpha(0.5);
    }

    public function Header()
    {
        //Put the watermark
        $this->SetFont('Arial', '', 40);
        $this->SetTextColor(255, 200, 200);
        $this->SetAlpha(0.8);
        $this->RotatedText(29, 170, $this->_outerText1, 45);
        $this->RotatedText(20, 240, $this->_outerText2, 45);
        $this->SetFont('Arial', '', 10);
        $this->RotatedText(5, 290, $this->_outerText3, 90);
        $this->RotatedText(10, 290, $this->_outerText4, 90);
        // $this->SetAlpha(0.5);
    }

    public function RotatedText($x, $y, $txt, $angle)
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
$tts = "Copyright @ PTPN 1 " . $thun . ". Seluruh hak cipta. ";
$tts2 = "Ini adalah dokumen RAHASIA. Setiap penyalinan, redistribusi atau transmisi ulang dari setiap bagian dari dokumen ini tanpa persetujuan tertulis dari PTPN 1 dilarang";

foreach ($data_dokumen as $row): {
        $file = FCPATH . "uploads/" . $row['upload_dokumen'];
        $pass = $row['password'];
    }

    $pdf = new PDF();

    if (file_exists($file)) {
        $pagecount = $pdf->setSourceFile($file);
    } else {
        return false;
    }
    $MAC = exec('getmac');

    // Storing 'getmac' value in $MAC
    $MAC = strtok($MAC, ' ');
    $ip = "(" . $tglsekarang . ") ";
    $pdf->setWaterText($username, $ip, $tts, $tts2);

    /* loop for multipage pdf */
    for ($i = 1; $i <= $pagecount; $i++) {
        $tpl = $pdf->importPage($i);
        $size = $pdf->getTemplateSize($tpl);
        $orientation = ($size['h'] > $size['w']) ? 'P' : 'L';
        if ($orientation == "P") {
            $pdf->addPage();
        } else {
            $pdf->addPage();
            $pdf->RotateClockWise();
        }
        $pdf->useTemplate($tpl, 1, 1, 0, 0, true);
    }

    $nama = "uploads/temp/" . $username;
    $pdf->Output(FCPATH . $nama, 'F'); //save to a local file with the name given by filename (may include a path)

    $text_image = 'assets/img/tt.png';
    $pdf2 = new PDF();
    $file2 = FCPATH . "uploads/temp/" . $username;
    if (file_exists($file2)) {
        $pagecount2 = $pdf2->setSourceFile($file2);
    } else {
        return false;
    }
    for ($i = 1; $i <= $pagecount2; $i++) {
        $tpl2 = $pdf2->importPage($i);
        $size2 = $pdf2->getTemplateSize($tpl2);

        $pdf2->addPage();
        //Put the watermark
        $xxx_final = ($size2['width'] + 150);
        $yyy_final = ($size2['height'] + 4);
        $pdf2->Image($text_image, $xxx_final, $yyy_final, 0, 0, 'png');
        $pdf2->useTemplate($tpl2, 1, 1, 0, 0, true);
    }
    $nama2 = "uploads/temp/down/" . $username;
    // $nama2="uploads/temp/".$username;

    $pdf2->Output(FCPATH . $nama2, 'F'); //save to a local file with the name given by filename (may include a path)
    $url_file2 = base_url() . $nama2;
    $url_file = base_url() . $nama;
    $ss = $nama;
    $ss2 = $nama2;
endforeach;

// include 'make_pass.php';
// =========================================

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
            <div class="card-header">
              <h3 class="card-title">Detail Permintaan Dokumen</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                    class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                    class="fas fa-remove"></i></button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <!-- ----------------------- -->
                <div class="col-12">
                  <?php
foreach ($data_req_dok as $row_dok): {
        //   echo $row['nama_dokumen'];}
        //   // endforeach;

        ?>
		                      <table class="table table-bordered table-striped" style="width:100%">
		                        <tr>
		                          <td style="width:30%">Username Request</td>
		                          <td style="width:70%">
		                            <?=$row_dok['username']?>
		                          </td>
		                        </tr>
		                        <tr>
		                          <td>Keperluan Cetak Dokumen Request</td>
		                          <td>
		                            <?=$row_dok['keperluan']?>
		                          </td>
		                        </tr>
		                        <tr>
		                          <td>Sub Bagian Request</td>
		                          <td>
		                            <?=$row_dok['nama_subbag']?>
		                          </td>
		                        </tr>
		                        <tr>
		                          <td>Bagian Request</td>
		                          <td>
		                            <?=$row_dok['nama_bagian']?>
		                          </td>
		                        </tr>
		                        <tr>
		                          <td>Regional Request</td>
		                          <td>
		                            <?=$row_dok['nama_regional']?>
		                          </td>
		                        </tr>
		                      </table>
		                      <?php
    // if($row_dok['tanggal_down']=="")
        // {
        //   echo form_open_multipart('c_pengelolah_dokumen_dms/setujui_req_dok');
        //   echo '<input type="hidden" name="id_req" value="'.$row_dok['id'].'"/>';
        //   echo '<input type="submit" name="submit" class="btn btn-danger text-white form-control-feedback view_password col-12" value="Setujui Permintaan" ></br></br></form>';
        // }
        // else
        // {
        //   echo '<input type="button" name="button" class="btn btn-success text-white form-control-feedback view_password col-12" value="Permintaan Telah Disetujui" ></br></br>';
        // }
        ?>
		                      <!-- <input type="button" name="button" class="btn btn-danger text-white form-control-feedback view_password col-12" value="Setujui Permintaan" ></br></br> -->
		                    </div>

		                    <div class="col-6">
		                      <table class="table table-bordered table-striped" style="width:100%">
		                        <tr>
		                          <td style="width:30%">Tanggal Request</td>
		                          <td style="width:70%">
		                            <?=$row_dok['tanggal_req']?>
		                          </td>
		                        </tr>
		                        <tr>
		                          <td>IP Request</td>
		                          <td>
		                            <?=$row_dok['ip_req']?>
		                          </td>
		                        </tr>
		                        <tr>
		                          <td>MAC Request</td>
		                          <td>
		                            <?=$row_dok['mac_req']?>
		                          </td>
		                        </tr>
		                        <tr>
		                          <td>Browser Request</td>
		                          <td>
		                            <?=$row_dok['browser_req']?>
		                          </td>
		                        </tr>
		                        <tr>
		                          <td>OS Request</td>
		                          <td>
		                            <?=$row_dok['os_req']?>
		                          </td>
		                        </tr>
		                        <tr>
		                          <td>Kota Request</td>
		                          <td>
		                            <?=$row_dok['kota_req']?>
		                          </td>
		                        </tr>
		                        <tr>
		                          <td>Daerah Request</td>
		                          <td>
		                            <?=$row_dok['daerah_req']?>
		                          </td>
		                        </tr>
		                        <tr>
		                          <td>Negara Request</td>
		                          <td>
		                            <?=$row_dok['negara_req']?>
		                          </td>
		                        </tr>
		                        <tr>
		                          <td>Lokasi Request</td>
		                          <td>
		                            <?=$row_dok['lokasi_req']?>
		                          </td>
		                        </tr>
		                      </table>
		                    </div>

		                    <div class="col-6">
		                      <table class="table table-bordered table-striped" style="width:100%">
		                        <tr>
		                          <td style="width:30%">Tanggal Download</td>
		                          <td style="width:70%">
		                            <?=$row_dok['tanggal_down']?>
		                          </td>
		                        </tr>
		                        <tr>
		                          <td>IP Download</td>
		                          <td>
		                            <?=$row_dok['ip_down']?>
		                          </td>
		                        </tr>
		                        <tr>
		                          <td>MAC Download</td>
		                          <td>
		                            <?=$row_dok['mac_down']?>
		                          </td>
		                        </tr>
		                        <tr>
		                          <td>Browser Download</td>
		                          <td>
		                            <?=$row_dok['browser_down']?>
		                          </td>
		                        </tr>
		                        <tr>
		                          <td>OS Download</td>
		                          <td>
		                            <?=$row_dok['os_down']?>
		                          </td>
		                        </tr>
		                        <tr>
		                          <td>Kota Download</td>
		                          <td>
		                            <?=$row_dok['kota_down']?>
		                          </td>
		                        </tr>
		                        <tr>
		                          <td>Daerah Download</td>
		                          <td>
		                            <?=$row_dok['daerah_down']?>
		                          </td>
		                        </tr>
		                        <tr>
		                          <td>Negara Download</td>
		                          <td>
		                            <?=$row_dok['negara_down']?>
		                          </td>
		                        </tr>
		                        <tr>
		                          <td>Lokasi Download</td>
		                          <td>
		                            <?=$row_dok['lokasi_down']?>
		                          </td>
		                        </tr>

		                      </table>
		                    <?php
    }endforeach;?>
                </div>


              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
              <h3 class="card-title">Detail Dokumen</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                    class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                    class="fas fa-remove"></i></button>
              </div>
            </div>
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
                        <?=$row['nama_jenis_dokumen']?>
                      </td>
                    </tr>
                    <tr>
                      <td>Nomor</td>
                      <td>
                        <?=$row['nama_dokumen']?>
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
                        <?php endforeach;?>
                      </td>
                    </tr>
                    <tr>
                      <td>Tanggal ditetapkan</td>
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
echo $date;?>
                      </td>
                    </tr>
                    <tr>
                      <td>Status</td>
                      <td>
                        <?php
foreach ($query_dokstatus as $databag):

    if ($row['id_dokumen'] == $databag['id_dokumen']) {
        if ($databag['status'] == 'Baru') {
            echo '';
        } else {
            echo $databag['status'] . ' : ';?>
		                              <a href="<?php echo base_url(); ?>c_pengelolah_dokumen/detail_dum/<?=$databag['id_dokumen_status']?>"
		                                style="color:orange;font-weight:bold;">
		                                <?php
    $jumlahdata1 = count($dokumen_master);
            for ($i = 0; $i < $jumlahdata1; $i++) {
                if ($databag['id_dokumen_status'] == $dokumen_master[$i]['id_dokumen']) {
                    echo $dokumen_master[$i]['nama_dokumen'] . '<br>';
                }
            }
        }
    }
    ?>
		                          </a>
		                        <?php endforeach;?>
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
foreach ($data_bagian as $databag): ?>
                          <?php
for ($i = 0; $i < $jumlahdata; $i++) {
    $no = $i + 1;
    if ($databag->kode == $str1[$i]) {
        if ($jumlahdata == 1) {
            echo $databag->nama_bagian;
        } else {
            echo $no . '. ' . $databag->nama_bagian . '<br>';
        }
    }
}
?>
                        <?php endforeach;?>


                      </td>
                    </tr>
                    <tr>
                      <td>Tentang</td>
                      <td>
                        <?=$row['tentang']?>
                      </td>
                    </tr>
                    <tr>
                      <td>Password Dokumen</td>
                      <td>
                        <input type="password" class="col-md-3" id="password" value="<?=$row['decrypt_password']?>"
                          disabled>&nbsp;<input type="button" name="button"
                          class="btn btn-primary text-white form-control-feedback view_password" value="Password">&nbsp;

                      </td>
                    </tr>
                    <tr>
                      <td>Media Simpan</td>
                      <td>
                        <?=$row['media_simpan']?>
                      </td>
                    </tr>
                    <tr>
                      <td>Lama Simpan
                        <!-- <input type="submit"  value="Reload" onClick="document.location.reload(true)"> -->
                      </td>
                      <td>
                        <?php

echo "Tanggal Awal: " . $row['lama_simpan_awal'];
echo "<br>Tanggal Akhir: " . $row['lama_simpan_akhir'];
$awal = new DateTime($row['lama_simpan_awal']);
$akhir = new DateTime($row['lama_simpan_akhir']);
$diff = $akhir->diff($awal);
echo "<br><b><i>" . $hasil = $diff->y . " tahun " . $diff->m . " bulan " . $diff->d . " hari";
?>

                      </td>
                    </tr>
                  </table>
                </div>
              </div>

              <?php
// if($row_dok['tanggal_down']=="" && $row_dok['status_req']=="Request")
// {
//   echo form_open_multipart('c_pengelolah_dokumen_dms/setujui_req_dok');
//   echo '<input type="hidden" name="id_req" value="'.$row_dok['id'].'"/>';
//   echo '<input type="submit" name="submit" class="btn btn-danger text-white form-control-feedback  col-12" value="Setujui Permintaan" ></br></br></form>';
// }
// elseif($row_dok['tanggal_down']=="" && $row_dok['status_req']=="Approve")
// {
//   echo '<input type="button" name="button2" class="btn btn-warning text-white form-control-feedback  col-12" value="Permintaan Telah Disetujui" ></br></br>';
// }
// else
// {
//   echo '<input type="button" name="button1" class="btn btn-success text-white form-control-feedback  col-12" value="Permintaan Telah Disetujui" ></br></br>';
// }
?>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- ./col -->
          <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
              <h3 class="card-title">Persetujuan?</h3>
              <div class="card-tools">
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <!-- ----------------------- -->
                <div class="col-12">

                  <?php if ($row_dok['status_req'] == "Approve"): ?>
                    <div class="form-group">
                      <button type="button" class="btn btn-success text-white form-control-feedback col-12"
                        disabled>Permintaan Telah Disetujui</button>
                    </div>
                    <br> <br>
                  <?php elseif ($row_dok['status_req'] == "Tolak"): ?>
                    <div class="form-group">
                      <button type="button" class="btn btn-success text-white form-control-feedback col-12" disabled>
                        Permintaan Telah Ditolak
                      </button>
                    </div>
                    <br> <br>
                  <?php else: ?>
                    <?=form_open_multipart('c_pengelolah_dokumen_dms/setujui_req_dok')?>
                    <input type="hidden" name="id_req" value="<?=$row_dok['id']?>" />
                    <div class="form-group">
                      <button type="submit" name="persetujuan" value="Approve"
                        class="btn btn-primary text-white form-control-feedback col-12">Setujui Permintaan</button>
                      <br> <br>
                      <button type="submit" name="persetujuan" value="Tolak"
                        class="btn btn-danger text-white form-control-feedback col-12">Tolak Permintaan</button>
                    </div>
                    </form>
                    <br> <br>
                  <?php endif;?>
                  <!-- /.card-body -->
                </div>
              </div>


            </div>
            <!-- /.card-body -->
          </div>
        </div>
      </div>
    </div>
    <!-- ./col -->

</div>
<!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

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