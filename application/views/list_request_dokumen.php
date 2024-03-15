<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">List Request Dokumen</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">List Request Dokumen</li>
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
              <div class="material-datatables">
                <table id="table_list_request_dokumen" class="table table-bordered table-striped" width="100%"
                  style="width:100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Username</th>
                      <th>No. Dokumen</th>
                      <th>Judul Dokumen</th>
                      <th>Tanggal Request</th>
                      <th>Tanggal Download</th>
                      <th>Sub Bagian</th>
                      <th>Bagian</th>
                      <th>Regional</th>
                      <th>Status Request</th>
                      <th>Approve/Reject By</th>
                      <?php
                      $role = $this->session->userdata('role_id');
                      if ($role == 5 || $role == 4 || $role == 3) { ?>
                        <th>Action</th>
                      <?php } ?>

                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- ./col -->
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>