
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Master Hak Atas Tanah</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Master Atas Tanah</li>
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
                        <div class="col-md-2 mb-3">
                            <a href="<?php echo base_url() ?>c_master_hgu/form_hgu"><button type="button" class="btn btn-block btn-info btn-xs">Tambah Hak Atas Tanah</button></a>
                        </div>
                      <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                          <th>#</th>
                          <th>Jenis Hak Atas Tanah</th>
                          <th>Nomor Hak Atas Tanah</th>
                          <th>Lokasi Kebun</th>
                          <th>Koordinat</th>
                          <th>upload kml</th>
                          <th>Keterangan</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                              $no=0;
                              foreach ($jenis_hgu as $jendok) :
                              $no++;
                            ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $jendok['jenis_hat'] ?></td>
                                <td><?php echo $jendok['nomor_hgu'] ?></td>
                                <td><?php echo $jendok['lokasi_kebun'] ?></td>
                                <td>
                                  <?php 
                                    $koordinat        = $jendok['koordinat'];
                                    $koordinat2       = explode("-",$koordinat);
                                    $jumlahkoordinat  = count($koordinat2);
                                    $patok            = $jendok['patok'];
                                    $patok2           = explode("-",$patok);
                                    $jumlahpatok      = count($patok2);

                                    for($i=0; $i<$jumlahpatok; $i++){
                                      echo $patok2[$i] . ' = ' . $koordinat2[$i] . ' <br>';
                                    }
                                   ?>
                                  
                                </td>
                                <td><form action="<?php echo base_url().'C_tampil_peta_hgu'?>"  method="post"><input type="hidden" name="kml_layer" value="<?php echo $jendok['upload_kml'] ?>"/> <button type="submit" class="btn" style="color:blue;"><?php echo $jendok['upload_kml'] ?></button></form></td>
                                <td><?php echo $jendok['ket'] ?></td>
                                <td>
                                <?php echo anchor('c_master_hgu/detail_hgu/'.$jendok['id_hgu'], '<button type="button" class="btn  btn-warning btn-sm" title="Detail"><i class="fas fa-exclamation-circle" style="color:white;"></i></button>') ?>
                                <?php echo anchor('c_master_hgu/edit_hgu/'.$jendok['id_hgu'], '<button type="button" class="btn  btn-primary btn-sm" title="Edit"><i class="far fa-edit"></i></button>') ?>
                                <button type="button" class="btn  btn-danger btn-sm " name="<?php echo $jendok['id_hgu'] ?> " onClick="reply_click1(this.name)" data-toggle="modal" data-target="#hapus_data"><i class="fas fa-trash" title="Hapus"></i></button>
                              </td>
                            </tr>
                            <?php endforeach; ?>
                            
                        </tbody>
                        
                      </table>
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
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Status Perpanjang </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                Nama Dokumen : <span style="color: red;">7 Hari Lagi</span> 
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak Diperpanjang</button>
                <button onclick="window.location.href='edit-data_dokumen.html';" type="button" class="btn btn-primary">Memperbarui masa Aktif</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="hapus_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
              <form action="<?php echo base_url(). 'c_master_hgu/delete'?>" method="post">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                      <input type="hidden" id="id_delete" name="id_delete" value="">
                      <h5 class="modal-title" id="exampleModalLabel">Apakah Anda yakin untuk menghapus user tersebut ?</h5>
                      </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-danger">Hapus</button>
              </div>
              </form>
          </div>
        </div>
    </div>
    <script type="text/javascript">
      function reply_click1(clicked_id)
      {
          document.getElementById("id_delete").value = clicked_id;
      }
    </script>
    <?php if ($this->session->flashdata('something')) { ?>
    <script>
    $(document).ready(function() {
      swal("Data berhasil Ditambah", "", "success");
    });
    </script>

    <?php } ?>
    <?php if ($this->session->flashdata('something1')) { ?>
    <script>
    $(document).ready(function() {
      swal("Data berhasil Diubah", "", "success");
    });
    </script>

    <?php } ?>
    <?php if ($this->session->flashdata('something2')) { ?>
    <script>
    $(document).ready(function() {
      swal("Data berhasil di Hapus", "", "success");
    });
    </script>

    <?php } ?>