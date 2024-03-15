<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Data Dokumen Hukum</h1>
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
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-md-12 mb-3">
                                <div class="row">
                                    <a href="<?php echo base_url() ?>c_pengelolah_dokumen/form_data_dokumen"
                                        class="col-md-2"><button type="button"
                                            class="btn btn-block btn-info btn-xs col-md-12">Tambah Dokumen</button></a>
                                </div>

                            </div>
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Dokumen</th>
                                        <th>Bagian</th>
                                        <th>Jenis Dokumen</th>
                                        <th>Status</th>
                                        <th>Tanggal Upload</th>
                                        <th>Akses</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    foreach ($data_dokumen as $dd) :
                                        $no++;
                                    ?>
                                    <tr>
                                        <td><?php echo $no ?></td>
                                        <td><?php echo $dd['nama_dokumen'] ?></td>
                                        <td><?php echo $dd['username'] ?></td>
                                        <td><?php echo $dd['nama_jenis_dokumen'] ?></td>
                                        <td><?php echo $dd['status'] ?></td>
                                        <td><?php echo $dd['tanggal'] ?></td>
                                        <td>
                                            <?php foreach ($user as $usr) : ?>
                                            <?php $str = $dd['akses_for'];
                                            $str1 = explode(",", $str);
                                            $jumlahdata = count($str1);
                                            for ($i = 0; $i < $jumlahdata; $i++) {
                                                if ($usr->id == $str1[$i]) {
                                                echo '-' . $usr->username . '<br>';
                                                }
                                            }

                                            ?>
                                            <?php endforeach; ?>
                                        </td>
                                        <td>
                                            <?php echo anchor('c_pengelolah_dokumen/detail_dokumen/' . $dd['id_dokumen'], '<button type="button" class="btn  btn-warning btn-sm mt-2"  title="Detail"><i class="fas fa-info-circle" style="color: white;"></i></button>') ?>
                                            <?php echo anchor('c_pengelolah_dokumen/edit_data_dokumen/' . $dd['id_dokumen'], '<button type="button" class="btn btn-primary btn-sm mt-2"  title="Edit"><i class="far fa-edit"></i></button>') ?>
                                            <?php echo anchor('c_pengelolah_dokumen/kirim_email', '<button type="button" class="btn btn-dark btn-sm mt-2"  title="Kirim Email"><i class="fas fa-envelope-square"></i></button>') ?>
                                            <?php echo anchor('c_pengelolah_dokumen/lakukan_download_pemilik/' . $dd['upload_dokumen'] . '/' . $dd['id_dokumen'], '<button type="submit" class="btn bg-gradient-success btn-sm mt-2" title="Download"><i class="fas fa-download"></i></button>') ?>
                                            <?php echo anchor('c_pengelolah_dokumen/delete/' . $dd['id_dokumen'], '<button type="button" class="btn  btn-danger btn-sm mt-2" title="Hapus"><i class="fas fa-trash"></i></button>') ?>
                                        </td>
                                        <!-- Modal detail -->
                                        <div class="modal fade" id="detailmodal<?php echo $dd['id_dokumen'] ?>"
                                            tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle">Identitas
                                                            Pengunduh </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php echo $dd['nama_dokumen'] ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

<?php if ($this->session->flashdata('something')) { ?>
<script>
$(document).ready(function() {
    swal("Email Berhasil terkirim", "", "success");
});
</script>

<?php } ?>