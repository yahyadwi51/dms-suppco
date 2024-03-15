<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
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
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>
                <?php echo $total_dashboard[0]['total_dokumen']; ?>
              </h3>

              <p>Dokumen</p>
            </div>
            <div class="icon">
              <i class="ion ion-document-text"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>
                <?php echo $total_dashboard[0]['total_regional']; ?>
              </h3>

              <p>Regional</p>
            </div>
            <div class="icon">
              <i class="ion ion-briefcase"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>
                <?php echo $total_dashboard[0]['total_bagian']; ?>
              </h3>

              <p>Devisi/Bagian</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-stalker"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>
                <?php echo $total_dashboard[0]['total_user']; ?>
              </h3>

              <p>User</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
      </div>

      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Jumlah Dokumen</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div id="total_dokumen"></div>
                <script>
                  Highcharts.chart('total_dokumen', {
                    chart: {
                      plotBackgroundColor: null,
                      plotBorderWidth: null,
                      plotShadow: false,
                      type: 'pie'
                    },
                    title: {
                      text: 'Jumlah Dokumen',
                      align: 'center'
                    },
                    tooltip: {
                      pointFormat: '{series.name} : <b>{point.y} Dokumen</b>' // Mengubah format tooltip untuk menampilkan nilai asli
                    },
                    plotOptions: {
                      pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                          enabled: true,
                          format: '{point.name} : {point.y} Dokumen' // Mengubah format dataLabels untuk menampilkan nilai asli
                        },
                        showInLegend: true
                      }
                    },
                    series: [{
                      name: 'Jumlah',
                      colorByPoint: true,
                      data: <?php echo $chartDataJSONDok; ?>
                    }]
                });
                </script>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Dokumen Paling Banyak dilihat</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div id="dokumen_view"></div>
                <script>
                  // Data dummy untuk contoh
                  var data = <?php echo $chartDataJSONView_terbanyak; ?>

                  // Konfigurasi chart
                  var options = {
                    chart: {
                      type: 'bar'
                    },
                    title: {
                      text: 'Dokumen Terbanyak Dilihat'
                    },
                    xAxis: {
                      categories: data.map(function (item) {
                        return item.name;
                      })
                    },
                    yAxis: {
                      title: {
                        text: 'Jumlah Dilihat'
                      }
                    },
                    legend: {
                      enabled: false
                    },
                    series: [{
                      name: 'Dilihat',
                      data: data.map(function (item) {
                        return item.views;
                      })
                    }]
                  };

                  // Membuat chart
                  Highcharts.chart('dokumen_view', options);
                </script>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card card-danger mb-5">
              <div class="card-header">
                <h3 class="card-title">Dokumen Terakhir di Akses Pengguna</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="material-datatables">
                  <table id="table1" class="display" class="table table-bordered table-striped table-hover"
                    cellspacing="0" width="100%" style="width:100%">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Documents</th>
                        <th>Waktu</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 0;
                      foreach ($view_akses as $va):
                        $no++;
                        ?>
                        <tr>
                          <td>
                            <?php echo $no ?>
                          </td>
                          <td>
                            <a href="#" class="btn btn-warning btn-sm">
                              <?php echo $va['nama_dokumen'] ?>
                            </a>
                          </td>
                          <td align="right">
                            <a href="#" class="btn btn-danger btn-sm">
                              <?php echo $va['tgl'] ?>
                            </a>
                          </td>
                        </tr>
                      <?php endforeach; ?>

                    </tbody>

                  </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- Lanjut Sini -->

          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-6">

            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Jumlah User</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div id="total_user_regional"></div>
                <script>
                  Highcharts.chart('total_user_regional', {
                    chart: {
                      plotBackgroundColor: null,
                      plotBorderWidth: null,
                      plotShadow: false,
                      type: 'pie'
                    },
                    title: {
                      text: 'Jumlah User',
                      align: 'center'
                    },
                    tooltip: {
                      pointFormat: '{series.name} : <b>{point.y} User</b>' // Mengubah format tooltip untuk menampilkan nilai asli
                    },
                    plotOptions: {
                      pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                          enabled: true,
                          format: '{point.name} : {point.y} User' // Mengubah format dataLabels untuk menampilkan nilai asli
                        },
                        showInLegend: true
                      }
                    },
                    series: [{
                      name: 'Jumlah',
                      colorByPoint: true,
                      data: <?php echo $chartDataJSONUser; ?>
                    }]
                });
                </script>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Dokumen Paling Banyak Diunduh</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div id="dokumen_download"></div>
                <script>
                  // Data dummy untuk contoh
                  var data = <?php echo $chartDataJSONdownload_terbanyak; ?>

                  // Konfigurasi chart
                  var options = {
                    chart: {
                      type: 'bar'
                    },
                    title: {
                      text: 'Dokumen Terbanyak Diunduh'
                    },
                    xAxis: {
                      categories: data.map(function (item) {
                        return item.name;
                      })
                    },
                    yAxis: {
                      title: {
                        text: 'Jumlah Diunduh'
                      }
                    },
                    legend: {
                      enabled: false
                    },
                    series: [{
                      name: 'Diunduh',
                      data: data.map(function (item) {
                        return item.views;
                      })
                    }]
                  };

                  // Membuat chart
                  Highcharts.chart('dokumen_download', options);
                </script>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card card-info mb-5">
              <div class="card-header">
                <h3 class="card-title">Informasi Pengguna</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="card bg-light d-flex flex-fill">
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-7">
                        <?php foreach ($user as $row_user) { ?>
                          </br>
                          <h2 class="lead"><b>
                              <?php echo $row_user->username ?>
                            </b></h2>
                          <p class="text-muted text-sm"><b>Bagian : </b>
                            <?php echo $row_user->nama_bagian ?>
                          </p>
                          <ul class="ml-4 mb-0 fa-ul text-muted">
                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span> Email:
                              <?php echo $row_user->email ?>
                            </li>
                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Phone :
                              <?php echo $row_user->no_telp ?>
                            </li>
                          </ul>
                        <?php } ?>
                      </div>
                      <div class="col-5 text-center">
                        <img src="<?php echo base_url() ?>/profil/foto_profil.png" width="128" height="128"
                          alt="user-avatar" class="img-circle img-fluid">
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="text-right">
                      <a href="<?= base_url('c_master_user/edit_user_profil/' . $id) ?>" class="btn btn-sm btn-primary">
                        <i class="fas fa-user"></i> Edit Profile
                      </a>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <!-- <div class="card-footer">
          Footer
        </div> -->
                <!-- /.card-footer-->
              </div>


            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- Lanjut Sini -->
        </div>
        <!-- /.col (RIGHT) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->

  </section>
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
    $('#table2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      'scrollX': true
    })
    $('#table3').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      'scrollX': true
    })

  })
</script>