<?php error_reporting(0); ?>
<style>
div.scrollmenu {
  overflow: auto;
  white-space: nowrap;
}

div.scrollmenu a {
  display: inline-block;
  color: white;
  text-align: center;
  padding: 14px;
  text-decoration: none;
}

div.scrollmenu a:hover {
  background-color: #777;
}
</style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-8">
          <?php 
                $demograff = $detail_demografi[0]['id_demografi_t_k'];
                if ($demograff == '1' || $demograff == '2' || $demograff == '3') {
                    echo '<h1 class="m-0 text-dark">Demografi Tenaga Kerja</h1>';
                }elseif ($demograff == '4' || $demograff == '5' || $demograff == '6') {
                    echo '<h1 class="m-0 text-dark">Pabrik</h1>';
                }else {
                    echo '<h1>Belum Ada Perubahan Data</h1>';
                }
                ?>
          </div>
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Demografi Tenaga Kerja</li>
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
              
                <div class="card-body">
                          <div class="row">
                              <?php 
                              $datajenis = $detail_demografi[0]['id_demografi_t_k'];
                              if ($datajenis == '1') {
                                  echo '<h1>Karyawan Tetap</h1>';
                              }elseif ($datajenis == '2') {
                                  echo '<h1>PKWT</h1>';
                              }elseif ($datajenis == '3') {
                                  echo '<h1>Harian Lepas</h1>';
                              }elseif ($datajenis == '4') {
                                  echo '<h1>Karyawan Tetap</h1>';
                              }elseif ($datajenis == '5') {
                                  echo '<h1>PKWT</h1>';
                              }elseif ($datajenis == '6') {
                                  echo '<h1>Harian Lepas</h1>';
                              }
                              ?>
                          
                              <div class="col-sm-6 col-md-6 ml-5"></div>
                              <div class="col-sm-2 md-2">
                                <div class="btn-group">
                                  <button type="button" class="btn btn-info">Export</button>
                                  <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                  </button>
                                  <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="<?php echo base_url() ?>c_laporan_gap_analysis/excel_ksi_demografi/<?= $detail_demografi[0]['id_demografi_t_k'];?>">Excel</a>
                                    <a class="dropdown-item" href="<?php echo base_url() ?>c_laporan_gap_analysis/pdf_ksi_demografi/<?= $detail_demografi[0]['id_demografi_t_k'];?>">PDF</a>
                                  </div>
                                </div>
                              </div>
                          <div class="scrollmenu">
                        <table id="example2" class="table table-bordered table-hover">
                              <tr>
                                  <td rowspan="2" >Tanggal</td>
                                  <td colspan="2" align="center">SD</td>
                                  <td colspan="2" align="center">SMP</td>
                                  <td colspan="2" align="center">SMA</td>
                                  <td colspan="2" align="center">D3/D4/S1</td>
                                  <td colspan="2" align="center">S2</td>
                                  <td colspan="2" align="center">Jumlah</td>
                              </tr>
                              <tr>
                                  <td>Laki-laki</td>
                                  <td>Perempuan</td>
                                  <td>Laki-laki</td>
                                  <td>Perempuan</td>
                                  <td>Laki-laki</td>
                                  <td>Perempuan</td>
                                  <td>Laki-laki</td>
                                  <td>Perempuan</td>
                                  <td>Laki-laki</td>
                                  <td>Perempuan</td>
                                  <td>Laki-laki</td>
                                  <td>Perempuan</td>
                              </tr>
                              
                              <?php
                                $no=0;
                                foreach ($detail_demografi as $ip) :
                                $no++;
                              ?>
                              <tr>
                                  <td width="20%"><?php $newDate = date("d-m-Y", strtotime($ip['tanggal'])); echo $newDate ;?></td>
                                  <td><?php echo $ip['sd_l']?></td>
                                  <td><?php echo $ip['sd_p']?></td>
                                  <td><?php echo $ip['smp_l']?></td>
                                  <td><?php echo $ip['smp_p']?></td>
                                  <td><?php echo $ip['sma_l']?></td>
                                  <td><?php echo $ip['sma_p']?></td>
                                  <td><?php echo $ip['sarjana_l']?></td>
                                  <td><?php echo $ip['sarjana_p']?></td>
                                  <td><?php echo $ip['s2_l']?></td>
                                  <td><?php echo $ip['s2_p']?></td>
                                  <td><?php 
                                      $jumlaki = $ip['sd_l'] + $ip['smp_l'] + $ip['sma_l'] + $ip['sarjana_l'] + $ip['s2_l']  ;
                                      echo $jumlaki?></td>
                                  <td><?php 
                                      $jumperem = $ip['sd_p'] + $ip['smp_p'] + $ip['sma_p'] + $ip['sarjana_p'] + $ip['s2_p']  ; 
                                      echo $jumperem?></td>
                              </tr>
                              <?php endforeach; ?>
                            
                              
                        </table>
                      </div>
                        
                      </div>
                  
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
  <script type="text/javascript">
      $(document).ready(function(){
        $("#status_surat").change(function(){
            status_surat();
        })
      })


      function status_surat(){
        var status_surat = $("#status_surat").val();
        $.ajax({
          url : "<?php echo base_url('c_gap_legal_ijin/load_status_surat') ?>",
          data: "status_surat=" +status_surat,
          success:function(data){
            $('#example2 tbody').html(data);
          }
        })
      } 
      
    </script>
  <?php if ($this->session->flashdata('something1')) { ?>
    <script>
    $(document).ready(function() {
      swal("Data berhasil Diubah", "", "success");
    });
    </script>

    <?php } ?>