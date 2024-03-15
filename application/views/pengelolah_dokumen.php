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
                                    <?php
                                    $id = $this->session->userdata('id');
                                    ?>
                                    <?php
                                    if ($id == 2) { ?>
                                        <a href="<?php echo base_url() ?>c_pengelolah_dokumen/form_data_dokumen" class="col-md-2"><button type="button" class="btn btn-block btn-info btn-xs col-md-12">Tambah Dokumen</button></a>
                                        <a href="<?php echo base_url();?>c_download_dokumen/detail_download_jdih" class="col-md-3"><button type="button" class="btn btn-block btn-info btn-xs">Request Download Dokumen</button></a>
                                        <div style="position: absolute;right: 0;">
                                            <a href="<?php echo base_url() ?>c_pengelolah_dokumen/permintaan_download_jdih">
                                                <button type="button" class="btn btn-block btn-info btn-xs">Permintaan Download 
                                                    <span class="badge bg-success">  
                                                    <?php
                                                        foreach ($jumlahnotifikasi as $dd) :
                                                    ?>
                                                        <?php echo $dd['jn']?>
                                                    <?php endforeach; ?>
                                                    </span>
                                                </button>
                                            </a>
                                        </div>
                                    <?php
                                    } else if($id == 5){ ?>
                                        <a href="<?php echo base_url() ?>c_pengelolah_dokumen/form_data_dokumen" class="col-md-2"><button type="button" class="btn btn-block btn-info btn-xs col-md-12">Tambah Dokumen</button></a>
                                        <a href="<?php echo base_url();?>c_download_dokumen/detail_download_jdih" class="col-md-3"><button type="button" class="btn btn-block btn-info btn-xs">Request Download Dokumen</button></a>
                                    <?php
                                    }
                                     else {
                                    ?>
                                        <a href="<?php echo base_url();?>c_download_dokumen/detail_download_jdih" class="col-md-3"><button type="button" class="btn btn-block btn-info btn-xs">Request Download Dokumen</button></a>
                                    <?php
                                    }
                                    ?>

                                </div>

                            </div>
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <!-- <th>Bagian</th> -->
                                        <th style="width: 12%">Tanggal Penetapan</th>
                                        <th style="width: 40%">Tentang</th>
                                        <th style="width: 10%">Akses</th>
                                        <th style="width: 40%">Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $username = $this->session->userdata('username');
                                    $bagian = $this->session->userdata('bagian');
                                    foreach ($data_dokumen as $row) :
                                    ?>
                                        <tr>
                                            <td><a href="<?= base_url() ?>c_pengelolah_dokumen/detail_dum/<?= $row['id_dokumen'] ?>" style="color:orange;font-weight:bold;"><?= $row['nama_dokumen'] ?></a></td>
                                            <!-- <td><?= $row['nama_bagian'] ?></td> -->
                                            <td><?php $conv_tanggal = $row['tanggal_penetapan'];
                                                $date = date('d M Y', strtotime($conv_tanggal));
                                                echo $date; ?></td>
                                            <td style=" word-wrap: break-word;max-width: 100px;"> <?= $row['tentang'] ?></td>
                                            <td>
                                            <?php $str = $row['akses_for'];
                                                $str2 = explode(",", $str);

                                                if (($val = array_search("AKBN", $str2)) !== false){
                                                    $str1 = array_diff($str2, array('GGT','JTR','KDL','KLG','KLK','KLR','KLS','KLT','MLS','PSW','SBJ','SGL','BLW','BSR','GLT','KBL','KLJ','KLN','KYM','MBL','PCA','REN','SBT','SIL','ZEEL','BGL','BNT','GGB','KLB','KNO','NPW','PSR','TRS','WRI'));
                                                    $jumlahdata = count($str1);
                                                }
                                                elseif (($val = array_search("ABGN", $str2)) !== false){
                                                    $str1 = array_diff($str2, array('12','21','11','22','31','32','33','13','34'));
                                                    $jumlahdata = count($str1);
                                                }
                                                elseif (($val = array_search("AB&K", $str2)) !== false){
                                                    $str1 = array_diff($str2, array('GGT','JTR','KDL','KLG','KLK','KLR','KLS','KLT','MLS','PSW','SBJ','SGL','BLW','BSR','GLT','KBL','KLJ','KLN','KYM','MBL','PCA','REN','SBT','SIL','ZEEL','BGL','BNT','GGB','KLB','KNO','NPW','PSR','TRS','WRI','12','21','11','22','31','32','33','13','34'));
                                                    $jumlahdata = count($str1);
                                                }
                                                else{
                                                    $str1 = explode(",", $str);
                                                    $jumlahdata = count($str1);
                                                }

                                                foreach ($data_bagian as $databag) : ?>
                                                    <?php
                                                        if($jumlahdata > 3){
                                                            for ($i = 0; $i < 3; $i++) {
                                                                $no = $i + 1 ;
                                                                if ($databag->kode == $str1[$i]) {
                                                                    if ($jumlahdata == 1) {
                                                                        echo $databag->nama_bagian;
                                                                    }else {
                                                                        if($str1[$i] == $str1[2]){
                                                                            echo $no.'. ' . $databag->nama_bagian . '...<br>';    
                                                                        }
                                                                        else{
                                                                            echo $no.'. ' . $databag->nama_bagian . '<br>';
                                                                        }
                                                                    }
                                                                }
                                                            }    
                                                        }
                                                        else {
                                                            for ($i = 0; $i < $jumlahdata; $i++) {
                                                            $no = $i + 1 ;
                                                                if ($databag->kode == $str1[$i]) {
                                                                    if ($jumlahdata == 1) {
                                                                        echo $databag->nama_bagian;
                                                                    }else {
                                                                        echo $no.'. ' . $databag->nama_bagian . '<br>';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                <?php endforeach; ?>
                                                
                                            </td>
                                            
                                            <td>

                                                <?php
                                                foreach ($query_dokstatus as $databag) :

                                                    if ($row['id_dokumen'] == $databag['id_dokumen']) {
                                                        if ($databag['status'] == 'Baru') {
                                                            echo '';
                                                        } else {
                                                            echo $databag['status'] . ' : '; ?>
                                                            <a href="<?php echo base_url(); ?>c_pengelolah_dokumen/detail_dum/<?= $databag['id_dokumen_status'] ?>" style="color:orange;font-weight:bold;">
                                                        <?php
                                                            $jumlahdata1 = count($dokumen_master);
                                                            for ($i = 0; $i < $jumlahdata1; $i++) {
                                                                if ($databag['id_dokumen_status'] == $dokumen_master[$i]['id_dokumen']) {
                                                                    echo $dokumen_master[$i]['nama_dokumen'] . '<br>';
                                                                }
                                                            }
                                                        }
                                                    }
                                                        ?>
                                                            </a>
                                                        <?php endforeach; ?>
                                            <td>
                                                <?php if ($row['user_upload'] == $bagian) { ?>
                                                    <?php echo anchor('c_pengelolah_dokumen/edit_data_dokumen/' . $row['id_dokumen'], '<button type="button" class="btn btn-primary btn-sm mt-2"  title="Edit"><i class="far fa-edit"></i></button>') ?>
                                                    <button type="submit" id="<?php echo $row['id_dokumen']?>" onClick="reply_click(this.id)" class="btn bg-gradient-success btn-sm mt-2" title="Download" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-download"></i></button>
                                                <?php }  
                                                else if ($username == 'adminsekper') { ?>
                                                    <?php echo anchor('c_pengelolah_dokumen/edit_data_dokumen/'.$row['id_dokumen'], '<button type="button" class="btn btn-primary btn-sm mt-2"  title="Edit"><i class="far fa-edit"></i></button>') ?>
                                                    <?php echo anchor('c_pengelolah_dokumen/lakukan_download/'.$row['upload_dokumen'], '<button type="submit" class="btn bg-gradient-success btn-sm mt-2" title="Download"><i class="fas fa-download"></i></button>') ?>
                                                <?php } 
                                                else if ($username == 'admin') { ?>
                                                    <?php echo anchor('c_pengelolah_dokumen/edit_data_dokumen/' . $row['id_dokumen'], '<button type="button" class="btn btn-primary btn-sm mt-2"  title="Edit"><i class="far fa-edit"></i></button>') ?>
                                                    <button type="submit" id="<?php echo $row['id_dokumen']?>" onClick="reply_click(this.id)" class="btn bg-gradient-success btn-sm mt-2" title="Download" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-download"></i></button>
                                                <?php } 
                                                else { ?>
                                                    <button type="submit" id="<?php echo $row['id_dokumen']?>" onClick="reply_click(this.id)" class="btn bg-gradient-success btn-sm mt-2" title="Download" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-download"></i></button>
                                                <?php } ?>
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

<?php if ($this->session->flashdata('something')) { ?>
    <script>
        $(document).ready(function() {
            swal("Email Berhasil terkirim", "", "success");
        });
    </script>

<?php } ?>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url(). 'c_download_dokumen/generatekodeunikjdih' ?>" method="post">
                    <div class="form-group">
                        <input type="hidden" id="myText" name="id" value="">
                        <label for="message-text" class="col-form-label">Keperluan:</label>
                        <textarea class="form-control" id="message-text" name="keterangan" ></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Dapatkan Kode Unik</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url(). 'c_download_dokumen/generatekodeunikjdih' ?>" method="post">
                    <div class="form-group">
                        <input type="hidden" id="myText" name="id" value="">
                        <label for="message-text" class="col-form-label">Keperluan:</label>
                        <textarea class="form-control" id="message-text" name="keterangan" ></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Dapatkan Kode Unik</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    var data = $('.dts1 span').text();
    // alert(data);
    if (data == "") {
        $(".dts1").text("Dokumen baru");
    }
    function reply_click(clicked_id)
    {
        document.getElementById("myText").value = clicked_id;
    }
</script>