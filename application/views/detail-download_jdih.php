
  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Detail Download Data JDIH</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content ">
      <div class="container-fluid" >
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body" id="repres">
                      <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Bagian Pemilik</th>
                            <th>Dokumen</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Nama File</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no=0;
                                foreach ($detail_download_jdih as $ddd) :
                                $no++;
                            ?>
                            <tr>
                                <td style="width: 10%;"><?php echo $no ?></td>
                                <td style="width: 10%;"><?php echo $ddd['nama_bagian'] ?></td>
                                <td style="width: 10%;"><?php echo $ddd['nama_dokumen'] ?></td>
                                <td style="width: 10%;"><?php echo date('d-m-Y', strtotime($ddd['log']));?></td>
                                <td style="width: 10%;"><?php echo $ddd['status_down'] ?></td>
                                <td style="width: 10%;"><?php echo $ddd['ketum'] ?></td>
                                <td style="width: 10%;"><?php echo $ddd['upload_dokumen'] ?></td>
                                <td>
                                    <form action="<?php echo base_url(). 'c_download_dokumen/lakukan_download_jdih/'.$ddd['upload_dokumen'] ?>" method="post" >
                                      <div class="input-group input-group-sm">
                                        <input type="hidden" class="form-control"  name="getkode_unik" value="<?php echo $ddd['kode_unik']?>">
                                        <input type="hidden" class="form-control"  name="idhistori" value="<?php echo $ddd['id']?>">
                                        <input type="text" class="form-control" placeholder="Masukkan Kode Unik" name="kode_unik" <?=$ddd['status_down'] == "Ditolak" ? "disabled" :null ?>>
                                        <span class="input-group-append">
                                        <button type="submit" id="sijidown<?php echo $ddd['id'] ?>" onclick="myFunction()" class="btn btn-info btn-flat" <?=$ddd['status_down'] == "Ditolak" ? "disabled" :null ?>>Download</button>
                                        </span>
                                      </div>
                                    </form>
                                    <script>
                                      $(document).ready(function(){
                                        $("#sijidown<?php echo $ddd['id'] ?>").one("click", function(){
                                          $(this).attr('hidden', true); 
                                        });
                                      });
                                      </script>
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
    <?php if ($this->session->flashdata('something1')) { ?>
    <script>
    $(document).ready(function() {
      swal("Data Dokumen Kosong", "", "error");
    });
    </script>

    <?php } ?>
