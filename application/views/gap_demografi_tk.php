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
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Demografi Tenaga Kerja</h1>
          </div><!-- /.col -->
          <div class="col-sm-3">
            <div class="form-group">
                        <?php 
                        $id_kebun = $this->session->userdata('bagian');
                        $username = $this->session->userdata('username');
                        $query_dokumen = $this->db->query("SELECT * FROM tb_master_bagian WHERE id_bagian ='$id_kebun'");
                        $data['datakebun'] = $query_dokumen->result_array();
                        // print_r( $data['datamasterbagian']);
                        // die();
                        if($username == 'admin'){
                        ?>
                      <select class="custom-select" id="id_kebun" >
                                <option selected disabled>- Pilih Kebun - </option>
                                <?php foreach ($kebun as $usr) : ?>
                                    <option value="<?php echo $usr['id_bagian'];?>">
                                      <?php echo $usr['nama_bagian']?>
                                    </option>
                                <?php endforeach; ?>
                      </select>
                <?php
                        }elseif($username != 'admin'){
                    ?>
                    <input type="hidden" class="form-control" id="exampleInputEmail1" name="id_kebun" value="<?php echo $data['datakebun'][0]['id_bagian'] ?> " readonly>
                    <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $data['datakebun'][0]['nama_bagian'] ?> " readonly>
                  
                        <?php }?>
                
            </div>
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
                  <?php 
                  $role_id = $this->session->userdata('role_id') ;
                  if ($role_id == '1') {
                    echo '<div class="card" id="tampildatawal">';
                  }else { 
                    ?>
                <div class="card">
                <?php } ?>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                        <?php
                        if ($role_id == '1') {
                          echo '<h1>Kebun</h1> <div class="col-sm-8 col-md-8"></div>';
                        }else {
                        ?>
                          <h1>Kebun <?php
                                    $data['master_bagian'] = $this->model_dokumen->tampil_data_bagian_kebun()->result(); 
                                    $id = $this->session->userdata('id') ;
                                    $bagian = $this->session->userdata('bagian') ;
                                    foreach ($data['master_bagian'] as $nh) : 
                                          if ($nh->id_bagian == $bagian) {
                                              echo $nh->nama_bagian;
                                            }
                                      endforeach; 

                                      ?>
                          </h1>
                          <div class="col-sm-6 col-md-6"></div>
                          <?php }?>
                        

                          <div class="col-sm-2 md-2">
                            <div class="btn-group">
                              <button type="button" class="btn btn-info">Export</button>
                              <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="<?php echo base_url() ?>c_laporan_gap_analysis/excel_demografi">Excel</a>
                                <a class="dropdown-item" href="<?php echo base_url() ?>c_laporan_gap_analysis/pdf_demografi">PDF</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="scrollmenu">
                      <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td rowspan="2">No.</td>
                                <td rowspan="2">Jenis Tenaga Kerja</td>
                                <td colspan="2" align="center">SD</td>
                                <td colspan="2" align="center">SMP</td>
                                <td colspan="2" align="center">SMA</td>
                                <td colspan="2" align="center">D3/D4/S1</td>
                                <td colspan="2" align="center">S2</td>
                                <td colspan="2" align="center">Jumlah</td>
                                <td rowspan="2" align="center">Action</td>
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
                        </thead>
                            <tbody>
                          
                            <?php
                              $no=0;
                              foreach ($karywantetapkeb as $ip) :
                              $no++;
                            ?>
                            <tr>
                                <td>1.</td>
                                <td>Karyawan Tetap</td>
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
                                <td>
                                <?php echo anchor('c_demografi_tenaga_kerja/detail_demografi/'.$ip['id_demografi_t_k'], '<button type="button" class="btn  btn-warning btn-sm mb-2" title="Edit"><i class="fas fa-info-circle" style="color:white;"></i></button>') ?>
                                <?php echo anchor('c_demografi_tenaga_kerja/edit_demografi/'.$ip['id_demografi_t_k'], '<button type="button" class="btn  btn-primary btn-sm mb-2" title="Edit"><i class="far fa-edit"></i></button>') ?>
                              </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php
                              $no=0;
                              foreach ($pktwkeb as $ip) :
                              $no++;
                            ?>
                            <tr>
                                <td>2.</td>
                                <td>PKWT</td>
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
                                <td>
                                <?php echo anchor('c_demografi_tenaga_kerja/detail_demografi/'.$ip['id_demografi_t_k'], '<button type="button" class="btn  btn-warning btn-sm mb-2" title="Edit"><i class="fas fa-info-circle" style="color:white;"></i></button>') ?>
                                <?php echo anchor('c_demografi_tenaga_kerja/edit_demografi/'.$ip['id_demografi_t_k'], '<button type="button" class="btn  btn-primary btn-sm mb-2" title="Edit"><i class="far fa-edit"></i></button>') ?>
                              </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php
                              $no=0;
                              foreach ($hariankeb as $ip) :
                              $no++;
                            ?>
                            <tr>
                                <td>3.</td>
                                <td>Harian Lepas</td>
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
                                <td>
                                <?php echo anchor('c_demografi_tenaga_kerja/detail_demografi/'.$ip['id_demografi_t_k'], '<button type="button" class="btn  btn-warning btn-sm mb-2" title="Edit"><i class="fas fa-info-circle" style="color:white;"></i></button>') ?>
                                <?php echo anchor('c_demografi_tenaga_kerja/edit_demografi/'.$ip['id_demografi_t_k'], '<button type="button" class="btn  btn-primary btn-sm mb-2" title="Edit"><i class="far fa-edit"></i></button>') ?>
                              </td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>

                      </table>
                     </div>
                      
                    </div>
                    <!-- /.card-body -->
                </div>

                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                        <h1>Pabrik (Jika ada)</h1>
                            <div class="col-sm-5 col-md-5"></div>

                        </div>
                        <div class="scrollmenu">
                      <table id="example3" class="table table-bordered table-hover">
                            <tr>
                                <td rowspan="2">No.</td>
                                <td rowspan="2">Jenis Tenaga Kerja</td>
                                <td colspan="2">SD</td>
                                <td colspan="2">SMP</td>
                                <td colspan="2">SMA</td>
                                <td colspan="2">D3/D4/S1</td>
                                <td colspan="2">S2</td>
                                <td colspan="2">Jumlah</td>
                                <td rowspan="2">Action</td>
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
                              foreach ($karywantetappab as $ip) :
                              $no++;
                            ?>
                            <tr>
                                <td>1.</td>
                                <td>Karyawan Tetap</td>
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
                                <td>
                                <?php echo anchor('c_demografi_tenaga_kerja/detail_demografi/'.$ip['id_demografi_t_k'], '<button type="button" class="btn  btn-warning btn-sm mb-2" title="Edit"><i class="fas fa-info-circle" style="color:white;"></i></button>') ?>
                                <?php echo anchor('c_demografi_tenaga_kerja/edit_demografi/'.$ip['id_demografi_t_k'], '<button type="button" class="btn  btn-primary btn-sm mb-2" title="Edit"><i class="far fa-edit"></i></button>') ?>
                              </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php
                              $no=0;
                              foreach ($pktwpab as $ip) :
                              $no++;
                            ?>
                            <tr>
                                <td>2.</td>
                                <td>PKWT</td>
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
                                <td>
                                <?php echo anchor('c_demografi_tenaga_kerja/detail_demografi/'.$ip['id_demografi_t_k'], '<button type="button" class="btn  btn-warning btn-sm mb-2" title="Edit"><i class="fas fa-info-circle" style="color:white;"></i></button>') ?>
                                <?php echo anchor('c_demografi_tenaga_kerja/edit_demografi/'.$ip['id_demografi_t_k'], '<button type="button" class="btn  btn-primary btn-sm mb-2" title="Edit"><i class="far fa-edit"></i></button>') ?>
                              </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php
                              $no=0;
                              foreach ($harianpab as $ip) :
                              $no++;
                            ?>
                            <tr>
                                <td>3.</td>
                                <td>Harian Lepas</td>
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
                                <td>
                                <?php echo anchor('c_demografi_tenaga_kerja/detail_demografi/'.$ip['id_demografi_t_k'], '<button type="button" class="btn  btn-warning btn-sm mb-2" title="Edit"><i class="fas fa-info-circle" style="color:white;"></i></button>') ?>
                                <?php echo anchor('c_demografi_tenaga_kerja/edit_demografi/'.$ip['id_demografi_t_k'], '<button type="button" class="btn  btn-primary btn-sm mb-2" title="Edit"><i class="far fa-edit"></i></button>') ?>
                              </td>
                            </tr>
                            <?php endforeach; ?>
                      </table>
                              </div>
                      
                    </div>
                    <!-- /.card-body -->
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
      $('#tampildatawal').hide();
      $(document).ready(function(){
        $("#id_kebun").change(function(){
            status_surat();
        })
      })


      function status_surat(){
        var id_kebun = $("#id_kebun").val();
        $.ajax({
          url : "<?php echo base_url('c_demografi_tenaga_kerja/load_status_surat') ?>",
          data: "id_kebun=" +id_kebun,
          success:function(data){
            var tes = data;
            $('#example2 tbody').html(data);
            $('#tampildatawal').show();

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