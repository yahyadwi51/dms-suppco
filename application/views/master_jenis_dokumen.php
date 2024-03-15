
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Master Jenis Dokumen</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Master jenis dokumen</li>
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
                            <a href="<?php echo base_url() ?>c_master_jenis_dokumen/form_jenis_dokumen"><button type="button" class="btn btn-block btn-info btn-xs">Tambah Jenis Dokumen</button></a>
                        </div>
                      <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                          <th>#</th>
                          <th>Nama Jenis Dokumen</th>
                          <th>Reminder</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                              $no=0;
                              foreach ($jenis_dokumen as $jendok) :
                              $no++;
                            ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $jendok['nama_jenis_dokumen'] ?></td>
                                <td>
                                  <?php echo $jendok['durasi_tahun'] ?> Tahun :
                                  <?php echo $jendok['durasi_bulan'] ?> Bulan : 
                                  <?php echo $jendok['durasi_tgl'] ?> Hari
                                </td>
                              <td>
                              <?php echo anchor('c_master_jenis_dokumen/edit_jenis_dokumen/'.$jendok['id'], '<button type="button" class="btn  btn-primary btn-sm" title="Edit"><i class="far fa-edit"></i></button>') ?>
                                <button type="button" class="btn  btn-danger btn-sm " name="<?php echo $jendok['id'] ?> " onClick="reply_click1(this.name)" data-toggle="modal" data-target="#hapus_data" title="Hapus"><i class="fas fa-trash"></i></button>
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
                                        <div class="modal fade" id="hapus_dokumen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form action="<?php echo base_url(). 'c_master_jenis_dokumen/delete'?>" method="post">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <input type="hidden" id="id_delete" name="id_delete" value="">
                                                        <h5 class="modal-title" id="exampleModalLabel">Apakah Anda yakin untuk menghapus jenis dokumen tersebut ?</h5>
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
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
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
      swal("Data berhasil ditambah", "", "success");
    });
    </script>

    <?php } ?>
    <?php if ($this->session->flashdata('something1')) { ?>
    <script>
    $(document).ready(function() {
      swal("Data berhasil diubah", "", "success");
    });
    </script>

    <?php } ?>
    <?php if ($this->session->flashdata('something2')) { ?>
    <script>
    $(document).ready(function() {
      swal("Data berhasil dihapus", "", "success");
    });
    </script>

    <?php } ?>