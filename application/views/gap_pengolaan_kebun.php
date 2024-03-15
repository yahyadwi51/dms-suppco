<script>
$(document).ready(function(){
  $("#filter").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
<style>
div.scrollmenu {
  overflow: auto;
  white-space: nowrap;
}

div.scrollmenu a {
  display: inline-block;
  color: white;
  text-align: center;
  padding: 14px;
  text-decoration: none;
}

div.scrollmenu a:hover {
  background-color: #777;
}
</style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Kerjasama Kebun</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Kerjasama Kebun</li>
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
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <a href="<?php echo base_url() ?>c_gap_pengelolaan_kebun/form_pengelolaan_kebun"><button type="button" class="btn btn-block btn-success btn-s">Tambah </button></a>
                            </div>
                            <div class="col-md-2 mb-3">
                              <div class="btn-group">
                                <button type="button" class="btn btn-info">Export</button>
                                <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                  <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                  <a class="dropdown-item" href="<?php echo base_url() ?>c_laporan_gap_analysis/excel_pengelolaan_kebun">Excel</a>
                                  <a class="dropdown-item" href="<?php echo base_url() ?>c_laporan_gap_analysis/pdf_pengelolaan_kebun">PDF</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-4 col-md-4"></div>
                            <div class="col-sm-2 col-md-2">
                            <!-- select -->
                                <div class="form-group">
                                    <select class="custom-select" id="status_surat">
                                        <option  value="aktif">Aktif</option>
                                        <option  value="nonaktif">Non Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2 col-md-2">
                            <!-- select -->
                                  <div class="form-group">
                                    <input type="text" id="filter" class="form-control" placeholder="Pencarian ...">
                                  </div>
                            </div>
                        </div>
                        <div class="scrollmenu">
                        <table id="example2" class="table table-bordered table-hover">
                          <thead>
                          <tr>
                            <th>#</th>
                            <th>Kebun</th>
                            <th>No Perjanjian</th>
                            <th>Kerjasama</th>
                            <th>Jenis Kerjasama</th>
                            <th>Mitra</th>
                            <th>Objek Kerjasama</th>
                            <th>Nilai Kompensasi</th>
                            <th>Tanggal Perjanjian</th>
                            <th>Tanggal Berakhir</th>
                            <th>Kondisi saat ini</th>
                            <th>Action</th>
                          </tr>
                          </thead>
                          <tbody id="myTable">
                              <?php
                                $no=0;
                                foreach ($pengolaan_kebun as $pk) :
                                $no++;
                              ?>
                              <tr>
                                  <td><?php echo $no ?></td>
                                  <td><?php echo $pk['nama_bagian'] ?>
                                  <td><?php echo $pk['no_perjanjian'] ?></td>
                                  <td><?php echo $pk['kerjasama'] ?></td>
                                  <td>
                                  <?php 
                                  $jum_jenis_kerjasama = count($jenis_kerjasama);
                                  for ($i=0; $i < $jum_jenis_kerjasama; $i++) { 
                                    if ( $jenis_kerjasama[$i]['id_kerjasama'] == $pk['jenis_kerjasama']) {
                                      echo $jenis_kerjasama[$i]['nama'];
                                    }
                                  }
                                  ?>
                                  </td>
                                  <td><?php echo $pk['mitra'] ?></td>
                                  <td>
                                  <?php 
                                  $jum_objek_kerjasama = count($objek_kerjasama);
                                  for ($i=0; $i < $jum_objek_kerjasama; $i++) { 
                                    if ( $objek_kerjasama[$i]['id_objek_kerjasama'] == $pk['objek_kerjasama']) {
                                      echo $objek_kerjasama[$i]['nama_objek_kerjasama'];
                                    }
                                  }
                                  ?>
                                  </td>
                                  <td><?php echo $pk['nilai_kompensasi'] ?></td>
                                  <td><?php 
                                    $newDate = date("d-m-Y", strtotime($pk['tanggal_perjanjian']));
                                    echo $newDate ;
                                    ?></td>
                                  <td><?php 
                                    $newDate1 = date("d-m-Y", strtotime($pk['tanggal_akhir_perjanjian']));
                                    echo $newDate1 ;
                                    ?></td>
                                  <td>
                                  <?php
                                    $id_detail = $pk['id_olah_keb'];

                                    $update_kondisi= $this->db->query("SELECT * FROM gap_histori_pengelolaan_kebun WHERE id_peng_keb = $id_detail  ORDER BY tanggal_update DESC LIMIT 1");
                                    $data['update_kondisi'] = $update_kondisi->result_array();
                                    if(count($data['update_kondisi'])>0){
                                      if ($data['update_kondisi'][0]['histori_kondisi_saat_ini'] != '') {
                                        echo $data['update_kondisi'][0]['histori_kondisi_saat_ini'] ;
                                      }
                                    }else {
                                      echo $pk['kondisi_saat_ini'];

                                    }
                                  ?>
                                  </td>
                                  <td>
                                    <?php echo anchor('c_gap_pengelolaan_kebun/form_detail_pengelolaan_kebun/'.$pk['id_olah_keb'], '<button type="button" class="btn  btn-warning btn-sm mb-2" title="Detail"><i class="fas fa-exclamation-circle" style="color:white;"></i></button>') ?>
                                    <?php echo anchor('c_gap_pengelolaan_kebun/edit_pengelolaan_kebun/'.$pk['id_olah_keb'], '<button type="button" class="btn  btn-primary btn-sm mb-2" title="Edit"><i class="far fa-edit"></i></button>') ?>
                                    <button type="button" class="btn  btn-danger btn-sm ml-3 mb-2" data-toggle="modal" data-target="#modalhapus" title="Non Aktif" name="<?= $pk['id_olah_keb'];?>" onClick="reply_click1(this.name)"><i class="far fa-times-circle"></i></button>
                                  </td>
                              </tr>
                              <?php endforeach; ?>
                              
                          </tbody>
                          
                        </table>
                        </div>
                      
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
  <div class="modal fade" id="modalhapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="<?= base_url().'c_gap_pengelolaan_kebun/nonaktif/'?>" method="post">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal Hapus</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Apakah Anda yakin menonaktifkan data ini?
              <input type="hidden" id="id_delete" name="id_delete">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger">Non Aktif</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modalaktif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="<?= base_url().'c_gap_pengelolaan_kebun/aktif/'?>" method="post">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal Akti</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Apakah Anda yakin mengaktifkan data ini?
              <input type="hidden" id="id_delete_aktif" name="id_delete">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">Aktif</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modalfilter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
      function reply_click1(clicked_id)
      {
          document.getElementById("id_delete").value = clicked_id;
      }
    </script>
    <script type="text/javascript">
      function reply_click(clicked_id)
      {
          document.getElementById("id_delete_aktif").value = clicked_id;
      }
    </script>
  <?php if ($this->session->flashdata('something')) { ?>
    <script>
    $(document).ready(function() {
      swal("Data berhasil Ditambah", "", "success");
    });
    </script>

    <?php } ?>
    <?php if ($this->session->flashdata('something1')) { ?>
    <script>
    $(document).ready(function() {
      swal("Data berhasil Diubah", "", "success");
    });
    </script>

    <?php } ?>
    <?php if ($this->session->flashdata('something2')) { ?>
    <script>
    $(document).ready(function() {
      swal("Data berhasil di nonaktifkan", "", "success");
    });
    </script>

    <?php } ?>
    <?php if ($this->session->flashdata('something3')) { ?>
    <script>
    $(document).ready(function() {
      swal("Data berhasil di aktifkan", "", "success");
    });
    </script>

    <?php } ?>
  <script type="text/javascript">
      $(document).ready(function(){
        $("#status_surat").change(function(){
            status_surat();
        })
      })


      function status_surat(){
        var status_surat = $("#status_surat").val();
        $.ajax({
          url : "<?php echo base_url('c_gap_pengelolaan_kebun/load_status_surat') ?>",
          data: "status_surat=" +status_surat,
          success:function(data){
            $('#example2 tbody').html(data);
          }
        })
      } 
      
    </script>