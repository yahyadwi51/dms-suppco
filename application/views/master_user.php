<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Master User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Master User</li>
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
                                <a href="<?php echo base_url() ?>c_master_user/form_user"><button type="button"
                                        class="btn btn-block btn-info btn-xs">Tambah User</button></a>
                            </div>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Bagian/Unit</th>
                                        <th>Role</th>
                                        <th>Nomor Telfon</th>
                                        <th>Email</th>
                                        <th>ID Telegram</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    foreach ($data_user as $du) :
                                        $no++;
                                    ?>
                                    <tr>
                                        <td><?php echo $no ?></td>
                                        <td><?php echo $du['username'] ?></td>
                                        <td><?php echo $du['nama_bagian'] ?></td>
                                        <td><?php echo $du['role'] ?></td>
                                        <td><?php echo $du['no_telp'] ?></td>
                                        <td><?php echo $du['email'] ?></td>
                                        <td><?php echo $du['id_telegram'] ?></td>
                                        <td>
                                            <div class="row">
                                            <div class="col-md-6">
                                                <?php echo anchor('c_master_user/edit_user/' . $du['id_user'], '<button type="button" class="btn  btn-primary btn-sm"><i class="far fa-edit" title="Edit"></i></button>') ?>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" class="btn  btn-danger btn-sm " name="<?php echo $du['id_user'] ?> " onClick="reply_click1(this.name)" data-toggle="modal" data-target="#hapus_dokumen"><i class="fas fa-trash" title="Hapus"></i></button>
                                            </div>
                                            </div>
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
                                                <form action="<?php echo base_url(). 'c_master_user/delete'?>" method="post">
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
      swal("Data berhasil ditambahkan", "", "success");
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