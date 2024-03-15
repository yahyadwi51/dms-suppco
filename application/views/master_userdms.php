<?php
$sesi_region = $this->session->userdata('id_region');
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Master Data User DMS</h1>
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
                <a href="<?php echo base_url() ?>c_master_userdms/form_master_userdms"><button type="button"
                    class="btn btn-block btn-info btn-xs">Tambah Data User</button></a>
              </div>
              <table id="table1" class="table table-bordered table-hover">
                <thead>
                  <?php
                  if ($sesi_region == 13) {
                    ?>
                    <tr>
                      <th>#</th>
                      <th>Nama User</th>
                      <th>Role</th>
                      <th>Nama Sub Bagian</th>
                      <th>Nama Bagian</th>
                      <th>Nama Region</th>
                      <th>No. Telepon</th>
                      <th>ID Telegram</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  <?php } ?>

                  <?php
                  if ($sesi_region != 13) {
                    ?>
                    <tr>
                      <th>#</th>
                      <th>Nama User</th>
                      <th>Role</th>
                      <th>Nama Sub Bagian</th>
                      <th>Nama Bagian</th>
                      <th>No. Telepon</th>
                      <th>ID Telegram</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th style="width: 120px;">Action</th>
                    </tr>
                  <?php } ?>
                </thead>

                <tbody>

                  <?php
                  $no = 0;
                  foreach ($user as $user):
                    $no++;
                    ?>
                    <tr>
                      <td>
                        <?php echo $no ?>
                      </td>
                      <td>
                        <?php echo $user['username'] ?>
                      </td>
                      <td>
                        <?php
                        $nama_role = '';
                        foreach ($role_user as $rolus):
                          if ($rolus['id_role'] == $user['role_id']) {
                            $nama_role = $rolus['role'];
                            break;
                          }
                        endforeach;
                        echo $nama_role;
                        ?>
                      </td>
                      <td>
                        <?php
                        $nama_subbagian = '';
                        foreach ($subbagianuser as $subuser):
                          if ($subuser['idsub'] == $user['id_sub_bagian']) {
                            $nama_subbagian = $subuser['nama_sub_bag'];
                            break;
                          }
                        endforeach;
                        echo $nama_subbagian;
                        ?>
                      </td>
                      <td>
                        <?php
                        $nama_bagian = '';
                        foreach ($bagianuser as $baguser):
                          if ($baguser['idbgn'] == $user['id_bagian']) {
                            $nama_bagian = $baguser['nama_bagian'];
                            break;
                          }
                        endforeach;
                        echo $nama_bagian;
                        ?>
                      </td>
                      <td>
                        <?php
                        $nama_region = '';
                        foreach ($regionuser as $reguser):
                          if ($reguser['idrgn'] == $user['id_region']) {
                            $nama_region = $reguser['nama_regional'];
                            break;
                          }
                        endforeach;
                        echo $nama_region;
                        ?>
                      </td>
                      <td>
                        <?php echo $user['no_telp'] ?>
                      </td>
                      <td>
                        <?php echo $user['id_telegram'] ?>
                      </td>
                      <td>
                        <?php echo $user['email'] ?>
                      </td>
                      <td>
                        <?php

                        if ($user['is_active'] == 1) {
                          echo "aktif";
                        } else {
                          echo "non-aktif";

                        } ?>
                      </td>
                      <td style="width: 120px;">
                        <?php echo anchor('c_master_userdms/edit_userdms/' . $user['encrypted_id'], '<button type="button" class="btn  btn-primary btn-sm"><i class="far fa-edit" title="Edit"></i></button>') ?>
                        <button class="warn-reset btn btn-warning btn-sm"
                          user-id-reset="<?php echo $user['encrypted_id']; ?>"
                          username-reset="<?php echo $user['username']; ?>" onclick="handleResetClick(event)">
                          <i class="fas fa-key" title="Reset"></i>
                        </button>
                        <button class="warn-delete btn btn-danger btn-sm"
                          user-id-delete="<?php echo $user['encrypted_id']; ?>"
                          username-delete="<?php echo $user['username']; ?>" onclick="handleResetClick(event)">
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
              $(document).ready(function () {
                $('.warn-reset').click(function () {
                  var userId = $(this).attr('user-id-reset');
                  var username = $(this).attr('username-reset').toUpperCase();

                  swal({
                    title: 'Konfirmasi Reset Kata Sandi Default (123456)',
                    text: 'Apakah Anda yakin ingin mereset kata sandi untuk pengguna ' + username + ' ? ',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Reset!',
                    cancelButtonText: 'Batal'
                  }).then((result) => {
                    if (result.value) {
                      // Redirect to the reset URL
                      var resetUrl = new URL('c_master_userdms/reset_userdms/' + userId, '<?php echo base_url() ?>');
                      window.location.href = resetUrl.href;
                    }
                  });
                });

                $('.warn-delete').click(function () {
                  var userId = $(this).attr('user-id-delete');
                  var username = $(this).attr('username-delete').toUpperCase();

                  swal({
                    title: 'Konfirmasi Penghapusan Pengguna',
                    text: 'Apakah Anda yakin ingin menghapus pengguna ' + username + '?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                  }).then((result) => {
                    if (result.value) {
                      // Redirect to the delete URL
                      var deleteUrl = new URL('c_master_userdms/delete_userdms/' + userId, '<?php echo base_url() ?>');
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
      'paging': true,
      'lengthChange': true,
      'searching': true,
      'ordering': true,
      'info': true,
      'autoWidth': true,
      'scrollX': true
    })
  })
</script>

<?php if ($this->session->flashdata('something')) { ?>
  <script>
    $(document).ready(function () {
      swal("Data berhasil ditambah", "", "success");
    });
  </script>
<?php } ?>

<?php if ($this->session->flashdata('something1')) { ?>
  <script>
    $(document).ready(function () {
      swal("Data berhasil diubah", "", "success");
    });
  </script>
<?php } ?>

<?php if ($this->session->flashdata('something2')) { ?>
  <script>
    $(document).ready(function () {
      swal("Data berhasil dihapus", "", "success");
    });
  </script>
<?php } ?>

<?php if ($this->session->flashdata('something3')) { ?>
  <script>
    $(document).ready(function () {
      swal("Data berhasil di-reset", "", "success");
    });
  </script>
<?php } ?>

<?php if ($this->session->flashdata('something4')) { ?>
  <script>
    $(document).ready(function () {
      swal("Data User Sudah Ada", "", "error");
    });
  </script>
<?php } ?>