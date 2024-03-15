<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Permintaan Download</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Permintaan Download</li>
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
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal Request</th>
                                        <th>Nama Dokumen</th>
                                        <th>Peminta</th>
                                        <th>Status</th>
                                        <th>Keperluan</th>
                                        <th>Tanggal Download</th>
                                        <th>Kode Unik</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                  $no = 0;
                  foreach ($data_download_jdih as $ddd) :
                    $no++;
                  ?>
                                    <tr>
                                        <td><?php echo $no ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($ddd['log']));
                          ?></td>
                                        <td><?php echo $ddd['nama_dokumen'] ?></td>
                                        <td><?php echo $ddd['peminta'] ?></td>
                                        <td><?php echo $ddd['status'] ?></td>
                                        <td><?php echo $ddd['keterangan'] ?></td>
                                        <td><?php
                          if ($ddd['tanggal_download'] != '') {
                            echo date('d-m-Y h:i:sa', strtotime($ddd['tanggal_download']));
                          }
                          ?></td>
                                        <td><input style="height:35px" type="text"
                                                value="<?php echo $ddd['kode_unik'] ?>" id="myInput<?php echo $no ?>"
                                                readonly></td>
                                        <td>
                                            <button type="button" class="btn  btn-warning btn-sm mt-2"
                                                data-toggle="modal"
                                                data-target="#detailmodal<?php echo $ddd['idhistori'] ?>"
                                                title="Detail"><i class="fas fa-info-circle"
                                                    style="color: white;"></i></button>
                                            <button type="button" class="btn  btn-primary btn-sm mt-2"
                                                onclick="myFunction<?php echo $no ?>()" title="Copy Code"><i
                                                    class="fas fa-copy"></i></button>
                                            <button id="<?php echo $ddd['kode_unik'] ?>"
                                                onClick="reply_click1(this.id,<?php echo $ddd['nomor_peminta'] ?>)"
                                                type="button" title="Kirim SMS" class="btn  btn-success btn-sm mt-2"
                                                data-toggle="modal" data-target="#kirimsms"><i
                                                    class="fas fa-sms"></i></button>
                                            <button id="<?php echo $ddd['iddkm'] ?>"
                                                onClick="reply_click(this.id,<?php echo $ddd['idhistori'] ?>)"
                                                type="button" class="btn  btn-danger btn-sm mt-2" data-toggle="modal"
                                                data-target="#exampleModalCenter" title="Tolak"><i
                                                    class="fas fa-window-close"></i></button>
                                            <script>
                                            function myFunction<?php echo $no ?>() {
                                                var copyText = document.getElementById("myInput<?php echo $no ?>");
                                                copyText.select();
                                                copyText.setSelectionRange(0, 99999)
                                                document.execCommand("copy");
                                            }
                                            </script>

                                        </td>
                                    </tr>
                                    <div class="modal fade" id="detailmodal<?php echo $ddd['idhistori'] ?>"
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
                                                    IP : <span style="color: red;"><?php echo $ddd['ip'] ?></span> <br>
                                                    City : <span style="color: red;"><?php echo $ddd['kota'] ?></span> <br>
                                                    Region : <span style="color: red;"><?php echo $ddd['daerah'] ?></span> <br>
                                                    Country : <span style="color: red;"><?php echo $ddd['negara'] ?></span> <br>
                                                    Loc : <span style="color: red;"><?php echo $ddd['lokasi'] ?></span> <br>
                                                    Timezone : <span style="color: red;"><?php echo $ddd['zonawaktu'] ?></span><br>
                                                    Browser : <span
                                                        style="color: red;"><?php echo $ddd['browser'] ?></span>
                                                    <br>
                                                    MAC : <span style="color: red;"><?php echo $ddd['mac'] ?></span>
                                                    <br>
                                                    Operating Sistem : <span
                                                        style="color: red;"><?php echo $ddd['os'] ?></span>
                                                    <!-- IP : <span style="color: red;">202.148.25.3</span> <br>
                                                          Hostname : <span style="color: red;">Release.dnetsurabaya.id</span> <br>
                                                          City : <span style="color: red;">Surabaya</span> <br>
                                                          Region : <span style="color: red;">East Java</span> <br>
                                                          Country : <span style="color: red;">ID</span> <br>
                                                          Loc : <span style="color: red;">-7.2474,436.5423</span> <br>
                                                          Timezone : <span style="color: red;">Asia/Jakarta</span><br> 
                                                          Browser : <span style="color: red;">Chrome</span>  -->
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="<?php echo base_url() . 'c_pengelolah_dokumen/tolak_permintaan_download_jdih/' ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Tolak Permintaan Download </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="myText" name="id" value="clicked_id">
                    <input type="hidden" id="myTex1" name="idhistori" value="clicken_name">
                    Apakah anda yakin akan menolak permintaan download
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Tolak</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="kirimsms" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo base_url() ?>c_data_dokumen/sendsms" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Penerima:</label>
                        <input type="text" class="form-control" name="notelp" id="myText2" readonly>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Kode Unik:</label>
                        <input type="text" class="form-control" name="pesan" id="myText3" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send message</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if ($this->session->flashdata('something')) { ?>
<script>
$(document).ready(function() {
    swal("Kode Unik Berhasil terkirim", "", "success");
});
</script>

<?php } ?>
<?php if ($this->session->flashdata('something1')) { ?>
<script>
$(document).ready(function() {
    swal("Permintaan download \nberhasil ditolak", "", "success");
});
</script>

<?php } ?>
<script type="text/javascript">
function reply_click(clicked_id, clicken_name) {
    document.getElementById("myText").value = clicked_id;
    document.getElementById("myTex1").value = clicken_name;
}

function reply_click1(kode_unik, notelp) {
    document.getElementById("myText2").value = notelp;
    document.getElementById("myText3").value = kode_unik;
}
</script>