
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Download Data Dokumen</h1>
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
                        <div class="col-md-3 mb-3">
                            <a href="<?php echo base_url();?>c_download_dokumen/detail_download_dokumen"><button type="button" class="btn btn-block btn-info btn-xs">Request Download Dokumen</button></a>
                        </div>
                        
                      <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Dokumen</th>
                            <th>Jenis Dokumen</th>
                            <th>Bagian/Kebun</th>
                            <th>PIC</th>
                            <th>Masa Aktif</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no=0;
                                foreach ($data_download_dokumen as $ddd) :
                                $no++;
                            ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $ddd['nama_dokumen'] ?></td>
                                <td><?php echo $ddd['nama_jenis_dokumen'] ?></td>
                                <td><?php echo $ddd['username'] ?></td>
                                <td><?php echo $ddd['pic'] ?></td>
                                <td><?php echo $ddd['masa_aktif'] ?></td>
                                <td>
                                <button type="button" id="<?php echo $ddd['iddkm']?>" onClick="reply_click(this.id)" class="btn btn-block bg-gradient-success" data-toggle="modal" data-target="#exampleModal">Download</button>
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
              <form action="<?php echo base_url(). 'c_download_dokumen/generatekodeunik' ?>" method="post">
                <div class="form-group">
                    <input type="hidden" id="myText" name="id" value="clicked_id">
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
<script type="text/javascript">
  function reply_click(clicked_id)
  {
      document.getElementById("myText").value = clicked_id;
  }
</script>