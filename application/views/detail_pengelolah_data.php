<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">DMS SuppCo</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">


        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <?php
        foreach ($data_dokumen as $row) :
        ?>
          <div class="row">
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
              <div class="row">
                <div class="col-12">
                  <h4><i class="far fa-question-circle"></i> Detail</h4>
                  <table class="table table-bordered table-striped">
                    <tr>
                      <td>Jenis Dokumen</td>
                      <td><?= $row['nama_jenis_dokumen'] ?></td>
                    </tr>
                    <tr>
                      <td>Nomor</td>
                      <td><?= $row['nama_dokumen'] ?></td>
                    </tr>
                    <tr>
                      <td>Tanggal ditetapkan</td>
                      <td><?php $conv_tanggal = $row['tanggal_penetapan'];
                          $date = date('d M Y', strtotime($conv_tanggal));
                          echo $date; ?></td>
                    </tr>
                    <tr>
                      <td>Tanggal unggah</td>
                      <td><?php $conv_tanggal = $row['log'];
                          $date = date('d M Y', strtotime($conv_tanggal));
                          echo $date; ?></td>
                    </tr>
                    <tr>
                      <td>Status</td>
                      <td>
                        <?php
                        foreach ($query_dokstatus as $databag) :

                          if ($row['id_dokumen'] == $databag['id_dokumen']) {
                            if ($databag['status'] == 'Baru') {
                              echo '';
                            } else {
                              echo $databag['status'] . ' : '; ?>
                              <a href="<?php echo base_url(); ?>c_pengelolah_dokumen/detail_dum/<?= $databag['id_dokumen_status'] ?>" style="color:orange;font-weight:bold;">
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
                            <?php endforeach; ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Akses</td>
                      <td>
                      <?php $str = $row['akses_for'];
                        $str2 = explode(",", $str);
                        $jumlahdata2 = count($str2);
                        
                        if (($val = array_search("AKBN", $str2)) !== false){
                          $str1 = array_diff($str2, array('GGT','JTR','KDL','KLG','KLK','KLR','KLS','KLT','MLS','PSW','SBJ','SGL','BLW','BSR','GLT','KBL','KLJ','KLN','KYM','MBL','PCA','REN','SBT','SIL','ZEEL','BGL','BNT','GGB','KLB','KNO','NPW','PSR','TRS','WRI'));
                          $jumlahdata = count($str1);
                        }
                        elseif (($val = array_search("ABGN", $str2)) !== false){
                            $str1 = array_diff($str2, array('12','21','11','22','31','32','33','13','34'));
                            $jumlahdata = count($str1);
                        }
                        elseif (($val = array_search("AB&K", $str2)) !== false){
                            $str1 = array_diff($str2, array('GGT','JTR','KDL','KLG','KLK','KLR','KLS','KLT','MLS','PSW','SBJ','SGL','BLW','BSR','GLT','KBL','KLJ','KLN','KYM','MBL','PCA','REN','SBT','SIL','ZEEL','BGL','BNT','GGB','KLB','KNO','NPW','PSR','TRS','WRI','12','21','11','22','31','32','33','13','34'));
                            $jumlahdata = count($str1);
                        }
                        else{
                            $str1 = explode(",", $str);
                            $jumlahdata = count($str1);
                        }
                        foreach ($data_bagian as $databag) : ?>
                            <?php
                                for ($i = 0; $i < $jumlahdata; $i++) {
                                    $no = $i + 1 ;
                                    if ($databag->kode == $str1[$i]) {
                                        if ($jumlahdata == 1) {
                                            echo $databag->nama_bagian;
                                        }else {
                                            echo $no.'. ' . $databag->nama_bagian . '<br>';
                                        }
                                    }
                                }
                                ?>
                            <?php endforeach; ?>

                            
                      </td>
                    </tr>

                  </table>

                </div>
              </div>
            </div>

            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
              <div class=" alert alert-danger alert-dismissible right">
                <h5><i class="icon fas fa-exclamation-triangle"></i> Perhatian !</h5>
                <p> Dokumen ini hanya untuk Kepentingan PTPN 12. </p>
              </div>
              <button type="submit" id="<?php echo $row['id_dokumen']?>" onClick="reply_click(this.id)" class="btn bg-gradient-success btn-sm mt-2" title="Download" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-download">  Download</i></button>
              <h3 class="text-muted"> <?= $row['nama_dokumen'] ?> TANGGAL <?php $conv_tanggal = $row['tanggal_penetapan'];
                                                                          $date = date('d M Y', strtotime($conv_tanggal));
                                                                          echo $date; ?></h3>
              <p class="text-muted"><?= $row['tentang'] ?></p>
              <br>
            </div>
          </div>
        <?php endforeach; ?>

      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url().'c_download_dokumen/generatekodeunikjdih' ?>" method="post">
                    <div class="form-group">
                        <input type="hidden" id="myText" name="id" value="">
                        <label for="message-text" class="col-form-label">Keperluan:</label>
                        <textarea class="form-control" id="message-text" name="keterangan" ></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Dapatkan Kode Unik</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    var data = $('.dts1 span').text();
    // alert(data);
    if (data == "") {
        $(".dts1").text("Dokumen baru");
    }
    function reply_click(clicked_id)
    {
        document.getElementById("myText").value = clicked_id;
    }
</script>