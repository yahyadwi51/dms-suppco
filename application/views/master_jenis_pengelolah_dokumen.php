
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
              <li class="breadcrumb-item active">Jenis Dokumen</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content mb-5">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="col-md-2 mb-3">
                            <a href="<?php echo base_url() ?>c_jenis_pengelolah_dokumen/form_jenis_dokumen"><button type="button" class="btn btn-block btn-info btn-xs">Tambah Jenis Dokumen</button></a>
                        </div>
                      <table id="table1" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                          <th style="width: 2%">#</th>
                          <th>Nama Jenis Dokumen</th>
                          <th>Status</th>
                          <th>Keterangan</th>
                          <th>Item Dokumen</th>
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
                                <td align="center"><?php echo $no ?></td>
                                <td><?php echo $jendok['nama_jenis_dokumen'] ?></td>
                                <td><?php echo $jendok['status_jenis_dokumen'] ?></td>
                                <td><?php echo $jendok['keterangan'] ?></td>
                                <td><?php echo $jendok['item_dokumen'] ?></td>
                              <td>
                                <?php echo anchor('c_jenis_pengelolah_dokumen/edit_jenis_dokumen/'.$jendok['encrypted_id'], '<button type="button" class="btn  btn-primary btn-sm"><i class="far fa-edit" title="Edit"></i></button>') ?>
                                <button class="warn-delete btn btn-danger btn-sm" jenisdok-id-delete="<?php echo $jendok['encrypted_id']; ?>" jenisdok-delete="<?php echo $jendok['nama_jenis_dokumen'] ?>" onclick="handleResetClick(event)">
                                    <i class="fas fa-trash" title="Delete"></i>
                                </button>
                              </td>
                            </tr>
                            <?php endforeach; ?>
                            
                        </tbody>
                        
                      </table>
                    </div>
                    <!-- /.card-body -->

                    <script>
                             $(document).ready(function() {
                            $('.warn-delete').click(function() {
                                var jenisdokId = $(this).attr('jenisdok-id-delete');
                                var jenisdok = $(this).attr('jenisdok-delete').toUpperCase();

                                swal({
                                    title: 'Konfirmasi Penghapusan JenisDokumen',
                                    text: 'Apakah Anda yakin ingin menghapus Jenis Dokumen ' + jenisdok + '?',
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: 'Ya, Hapus!',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.value) {
                                        // Redirect to the delete URL
                                        var deleteUrl = new URL('c_jenis_pengelolah_dokumen/delete/' + jenisdokId, '<?php echo base_url() ?>');
                                        window.location.href = deleteUrl.href;
                                    }
                                });
                            });
                        });
                      </script>

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

    <?php if ($this->session->flashdata('something3')) { ?>
    <script>
    $(document).ready(function() {
      swal("Data Jenis Dokumen Sudah Ada", "", "error");
    });
    </script>
    <?php } ?>
    
  <script>
  $(function () {
    $('#table1').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  })
  </script>