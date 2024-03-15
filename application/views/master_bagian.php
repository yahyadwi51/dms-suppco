<?php
$sesi_region = $this->session->userdata('id_region');
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Master Bagian / Divisi</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Master Bagian / Divisi</li>
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
                                <?php if ($role_id == 4) : ?>
                                    <a href="<?php echo base_url() ?>c_master_user/form_bagianDMS">
                                <?php endif; ?>
                                <?php if ($role_id == 6) : ?>
                                    <a href="<?php echo base_url() ?>c_master_user/form_bagianDMS">
                                <?php endif; ?>
                                    <button type="button" class="btn btn-block btn-info btn-s">Tambah Bagian / Divisi</button>
                                    </a>
                            </div>

                            <!-- form bagian biasa -->
                            <?php if (isset($show_formBiasa) && $show_formBiasa) : ?>
                            <table id="table2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 2%">#</th>
                                        <th>Nama Bagian/Unit</th>
                                        <th>Kode</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    foreach ($master_bagian as $mb) :
                                        $no++;
                                    ?>
                                    <tr>
                                        <td align="center"><?php echo $no ?></td>
                                        <td><?php echo $mb['nama_bagian'] ?></td>
                                        <td><?php echo $mb['kode'] ?></td>
                                        <td><?php echo $mb['keterangan'] ?></td>
                                        <td><?php echo $mb['status'] ?></td>
                                        <td>
                                            <?php echo anchor('c_master_user/edit_bagian/' . $mb['id_bagian'], '<button type="button" class="btn btn-primary btn-sm"><i class="far fa-edit" title="Edit"></i></button>') ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php endif; ?>

                            <!-- form bagian DMS SuppCO -->
                            <?php if (isset($show_formDMS) && $show_formDMS) : ?>
                            <table id="table1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 2%">#</th>
                                        <th>Nama Bagian / Divisi</th>
                                        <th>Kode</th>
                                        <th>Region</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    foreach ($master_bagian as $mb) :
                                        $no++;
                                    ?>
                                    <tr>
                                        <td align="center"><?php echo $no ?></td>
                                        <td><?php echo $mb['nama_bagian'] ?></td>
                                        <td><?php echo $mb['kode'] ?></td>
                                        <td>
                                            <?php
                                            $nama_regional = ''; // Variabel untuk menyimpan nama_regional
                                            foreach ($regionbagian as $regbag) :
                                                if ($regbag['idrgn'] == $mb['id_region']) {
                                                    $nama_regional = $regbag['nama_regional']; // Simpan nama_regional dalam variabel
                                                    break; // Keluar dari perulangan karena sudah mendapatkan nama_regional
                                                }
                                            endforeach;
                                            echo $nama_regional; // Tampilkan nama_regional di dalam <td>
                                            ?>
                                        </td>
                                        <td><?php echo $mb['keterangan'] ?></td>
                                        <td><?php echo $mb['status'] ?></td>
                                        <td>

                                        <?php if ($role_id == 6) : ?>
                                            <?php echo anchor('c_master_user/edit_bagianDMS/' . $mb['encrypted_id'], '<button type="button" class="btn btn-primary btn-sm"><i class="far fa-edit" title="Edit"></i></button>') ?>
                                            <button class="warn-delete btn btn-danger btn-sm" bagian-id-delete="<?php echo $mb['encrypted_id']; ?>" bagian-delete="<?php echo $mb['nama_bagian']; ?>" onclick="handleResetClick(event)">
                                                <i class="fas fa-trash" title="Delete"></i>
                                            </button>
                                        <?php endif; ?>

                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php endif; ?>
                        </div>
                        <!-- /.card-body -->
                        <script>
                             $(document).ready(function() {
                            $('.warn-delete').click(function() {
                                var bagianId = $(this).attr('bagian-id-delete');
                                var bagian = $(this).attr('bagian-delete').toUpperCase();

                                swal({
                                    title: 'Konfirmasi Penghapusan Bagian',
                                    text: 'Apakah Anda yakin ingin menghapus Bagian ' + bagian + '?',
                                    type: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: 'Ya, Hapus!',
                                    cancelButtonText: 'Batal'
                                }).then((result) => {
                                    if (result.value) {
                                        // Redirect to the delete URL
                                        var deleteUrl = new URL('c_master_user/deleteDMS/' + bagianId, '<?php echo base_url() ?>');
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
    swal("Data Bagian Sudah Ada", "", "error");
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
    $('#table2').DataTable({
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