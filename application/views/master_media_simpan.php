
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Master Media Simpan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Media Simpan</li>
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
                            <a href="<?php echo base_url() ?>c_media_simpan/form_media_simpan"><button type="button" class="btn btn-block btn-info btn-xs">Tambah Media Simpan</button></a>
                        </div>
                      <table id="table1" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                          <th style="width: 2%">#</th>
                          <th>Media Simpan</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                              $no=0;
                              foreach ($media_simpan as $medsim) :
                              $no++;
                            ?>
                            <tr>
                                <td align="center"><?php echo $no ?></td>
                                <td><?php echo $medsim['media_simpan'] ?></td>
                              <td>
                                <?php echo anchor('c_media_simpan/edit_media/'.$medsim['encrypted_id'], '<button type="button" class="btn  btn-primary btn-sm"><i class="far fa-edit" title="Edit"></i></button>') ?>
                                <button class="warn-delete btn btn-danger btn-sm" medsim-id-delete="<?php echo $medsim['encrypted_id']; ?>" medsim-delete="<?php echo $medsim['media_simpan']; ?>" onclick="handleResetClick(event)">
                                    <i class="fas fa-trash" title="Delete"></i>
                                </button>
                              </td>
                            </tr>
                            <?php endforeach; ?>
                            
                        </tbody>
                        
                      </table>
                    </div>
                    <!-- /.card-body -->
                    <!-- TOMBOL DELETE -->
                    <script>
                            $(document).ready(function() {
                            $('.warn-delete').click(function() {
                                var medsimId = $(this).attr('medsim-id-delete');
                                var medsim = $(this).attr('medsim-delete').toUpperCase();

                                swal({
                                    title: 'Konfirmasi Penghapusan Media Simpan',
                                    text: 'Apakah Anda yakin ingin menghapus Media Simpan ' + medsim + '?',
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: 'Ya, Hapus!',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.value) {
                                        // Redirect to the delete URL
                                        var deleteUrl = new URL('c_media_simpan/delete/' + medsimId, '<?php echo base_url() ?>');
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
      swal("Media Simpan Sudah Ada", "", "error");
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