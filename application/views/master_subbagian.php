
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Master Data Sub-Bagian</h1>
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
    <section class="content mb-5">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="col-md-2 mb-3">
                            <a href="<?php echo base_url() ?>c_master_subbagian/form_master_subbagian"><button type="button" class="btn btn-block btn-info btn-xs">Tambah Data Subbagian</button></a>
                        </div>
                      <table id="table1" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                          <th style="width: 2%">#</th>
                          <th>Nama Sub Bagian</th>
                          <th>Nama Bagian</th>
                          <th>Nama Region</th>
                          <th>Keterangan</th>
                          <th>Kode</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                              $no=0;
                              foreach ($subbagian as $sbgn) :
                              $no++;
                            ?>
                            <tr>
                                <td align="center"><?php echo $no ?></td>
                                <td><?php echo $sbgn['nama_sub_bag'] ?></td>
                                <td>
                                    <?php
                                      $nama_bagian= ''; // Variabel untuk menyimpan nama_bagian
                                      foreach ($bagsubag as $bagsub) :
                                        if ($bagsub['idbgn'] == $sbgn['id_bagian']) {
                                              $nama_bagian = $bagsub['nama_bagian']; // Simpan nama_bagian dalam variabel
                                              break; // Keluar dari perulangan karena sudah mendapatkan nama_bagian
                                            }
                                      endforeach;
                                      echo $nama_bagian; // Tampilkan nama_bagian di dalam <td>
                                    ?>
                                </td>
                                <td><?php
                                      $nama_region= ''; // Variabel untuk menyimpan nama_region
                                      foreach ($regionsubag as $regsub) :
                                        if ($regsub['idrgn'] == $sbgn['id_region']) {
                                              $nama_region = $regsub['nama_regional']; // Simpan nama_region dalam variabel
                                              break; // Keluar dari perulangan karena sudah mendapatkan nama_region
                                            }
                                      endforeach;
                                      echo $nama_region; // Tampilkan nama_region di dalam <td>
                                    ?></td>
                                <td><?php echo $sbgn['keterangan'] ?></td>
                                <td><?php echo $sbgn['kode'] ?></td>
                                <td><?php echo $sbgn['status'] ?></td>
                              <td>
                                <?php echo anchor('c_master_subbagian/edit_subbagian/'.$sbgn['encrypted_id'], '<button type="button" class="btn  btn-primary btn-sm"><i class="far fa-edit" title="Edit"></i></button>') ?>
                                <button class="warn-delete btn btn-danger btn-sm" subag-id-delete="<?php echo $sbgn['encrypted_id']; ?>" subag-delete="<?php echo $sbgn['nama_sub_bag']; ?>" onclick="handleResetClick(event)">
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
                                var subagId = $(this).attr('subag-id-delete');
                                var subag = $(this).attr('subag-delete').toUpperCase();

                                swal({
                                    title: 'Konfirmasi Penghapusan Subbagian',
                                    text: 'Apakah Anda yakin ingin menghapus Subbagian ' + subag + '?',
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: 'Ya, Hapus!',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.value) {
                                        // Redirect to the delete URL
                                        var deleteUrl = new URL('c_master_subbagian/delete_subbagian/' + subagId, '<?php echo base_url() ?>');
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
      swal("Data Subbagian Sudah Ada", "", "error");
    });
    </script>
    <?php } ?>