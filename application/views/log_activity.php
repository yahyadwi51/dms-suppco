<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Log Activity</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Log Activity</li>
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
      <!-- Default box -->
      <div class="row">
        <div class="card card-primary col-lg-12 col-md-12">
          <div class="card-header">
            <h3 class="card-title">Log Activity</h3>
          </div>
          <div class="card-body">
            <div class="material-datatables">
              <table id="table1" class="table table-bordered table-hover" width="100%" style="width:100%">
                <thead>
                  <tr>
                    <th style="width: 2%">#</th>
                    <th>User</th>
                    <th>Aktivitas</th>
                    <th>Dokumen</th>
                    <th>Waktu</th>
                    <th>IP</th>
                    <th>Selengkapnya</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Table rows will be loaded using AJAX -->
                </tbody>
              </table>

              <!-- Modal -->
              <div class="modal fade" id="detailModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalCenterTitle">Log Activity</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="modalBody">
                      <!-- Modal content will be loaded using AJAX -->
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>

            </div>

          </div>
          <!-- /.card-body -->
          <!-- <div class="card-footer">
                  Footer
                </div> -->
          <!-- /.card-footer-->
        </div>
        <!-- /.card -->


  </section>
  <!-- /.content -->
</div>

<script>
  $(document).ready(function () {
    $('#table1').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "ajax": {
        "url": '<?php echo base_url('C_log_activity/load_log_data'); ?>',
        "type": 'GET',
        "dataType": 'json',
        "dataSrc": ""
      },
      "columns": [
        {
          "data": null,
          "render": function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
          },
          "orderable": false,
          "className": "text-center"
        },
        {
          "data": "username",
          "render": function (data, type, row) {
            return '<a href="#" class="btn btn-danger btn-sm">' + data + '</a>';
          }
        },
        {
          "data": "aktivitas",
          "render": function (data, type, row) {
            return '<a href="#" class="btn btn-warning btn-sm">' + data + '</a>';
          }
        },
        {
          "data": "nama_dokumen",
          "render": function (data, type, row) {
            if (data === null) {
              return "-";
            } else {
              return '<a href="#" class="btn btn-danger btn-sm">' + data + '</a>';
            }
          },
          "className": "text-center"
        },
        {
          "data": "tgl",
          "render": function (data, type, row) {
            return '<a href="#" class="btn btn-warning btn-sm">' + data + '</a>';
          }
        },
        {
          "data": "ip",
          "render": function (data, type, row) {
            return '<a href="#" class="btn btn-danger btn-sm">' + data + '</a>';
          },
          "className": "text-center"
        },
        {
          "data": null,
          "render": function (data, type, row) {
            return '<button type="button" class="btn btn-warning btn-sm mt-2 showDetailBtn" data-logid="' + row.id_log + '" title="Detail"><i class="fas fa-info-circle" style="color: white;"></i></button>';
          },
          "className": "text-right"
        }

      ]
    });

    $(document).on('click', '.showDetailBtn', function () {
      var logId = $(this).data('logid');

      $.ajax({
        type: 'GET',
        url: '<?php echo base_url('C_log_activity/load_log_detail'); ?>/' + logId,
        success: function (data) {
          $('#modalBody').html(data);
          $('#detailModal').modal('show');
        }
      });
    });
  });
</script>