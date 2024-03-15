<style>
.btnku {
  border: none;
  outline: none;
  margin: 5px 7px;
  padding: 2px 6px;
  background-color: #ffc107;
  cursor: pointer;
  color: white;
  font-size: 18px;
}
.active, .btnku:hover {
  background-color: #d39e00;
  color: black;
}
.activedd, .btnku:hover {
  background-color: #d39e00;
  color: black;
}
</style>
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
<script>
function changeText() {
  x = document.getElementById("mySelect");
  x.options[x.selectedIndex].text = "Melon";
}
</script>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Infrastruktur Pendukung</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item ">Infrastruktur Pendukung</li>
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
                            <a href="<?php echo base_url() ?>c_gap_infrastruktur_pendukung/form_infra_pend"><button type="button" class="btn btn-block btn-success btn-s">Tambah </button></a>
                            </div>
                            <div class="col-md-2 mb-3">
                              <div class="btn-group">
                                <button type="button" class="btn btn-info">Export</button>
                                <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                  <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                  <a class="dropdown-item" href="<?php echo base_url() ?>c_laporan_gap_analysis/excel_infrastruktur_pendukung">Excel</a>
                                  <a class="dropdown-item" href="<?php echo base_url() ?>c_laporan_gap_analysis/pdf_infrastruktur_pendukung">PDF</a>
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
                        <div id="myDIV" class="keys row mb-5">
                            <button type="button" id="defaultawal" class="btn-s col-sm-2 col-md-2 btnku" style="" value='1' onfocus="document.getElementById('filter').value=''" onclick='tabbutton(this)'>Infrastruktur Pengelolaan Kebun </button>
                            <button type="button" id="defaultdua"  class="btn-s col-sm-2 col-md-2 btnku" value='2' onfocus="document.getElementById('filter').value=''" onclick='tabbutton(this)'>Fasilitas Umum </button>
                            <button type="button" id="defaulttiga" class="btn-s col-sm-2 col-md-2 btnku" value='3' onfocus="document.getElementById('filter').value=''" onclick='tabbutton(this)'>Fasilitas Sosial </button>
                        </div>
                      <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                          <th>#</th>
                          <th>Kebun</th>
                          <th><span id="demo">Infrastruktur Pengelolaan Kebun</span></th>
                          <th>Kondisi saat ini</th>
                          <th>Jumlah/Unit</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php
                              $no=0;
                              foreach ($infrastruktur_pendukung as $ip) :
                              $no++;
                            ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $ip['nama_kebun'] ?></td>
                                <td><?php echo $ip['nama_infra'] ?></td>
                                <td>
                                <?php
                                    $id_detail = $ip['id_infra_pen'];

                                    $update_kondisi= $this->db->query("SELECT * FROM gap_histori_infrastruktur_pendukung WHERE id_infra_pen= $id_detail  ORDER BY tanggal_update DESC LIMIT 1");
                                    $data['update_kondisi'] = $update_kondisi->result_array();
                                    if(count($data['update_kondisi'])>0){
                                      if ($data['update_kondisi'][0]['histori_kondisi_saat_ini'] != '') {
                                        echo $data['update_kondisi'][0]['histori_kondisi_saat_ini'] ;
                                      }
                                    }else {
                                      echo $ip['kondisi_saat_ini'];

                                    }
                                  ?>
                                </td>
                                <td><?php echo $ip['jumlah'] ?></td>
                              <td>
                                <?php echo anchor('c_gap_infrastruktur_pendukung/form_detail_infra_pend/'.$ip['id_infra_pen'], '<button type="button" class="btn btn-warning btn-sm mb-2" title="Detail"><i class="fas fa-exclamation-circle" style="color:white;"></i></button>') ?>
                                <?php echo anchor('c_gap_infrastruktur_pendukung/edit_infra_pend/'.$ip['id_infra_pen'], '<button type="button" class="btn btn-primary btn-sm mb-2" title="Edit"><i class="far fa-edit"></i></button>') ?>
                                <button type="button" class="btn btn-danger btn-sm mb-2" data-toggle="modal" data-target="#modalhapus" title="Non Aktif" name="<?= $ip['id_infra_pen'];?>" onClick="reply_click1(this.name)"><i class="far fa-times-circle"></i></button>
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
  
  <div class="modal fade" id="modalhapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="<?= base_url().'c_gap_infrastruktur_pendukung/nonaktif/'?>" method="post">
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
        <form action="<?= base_url().'c_gap_infrastruktur_pendukung/aktif/'?>" method="post">
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
        var status_surat  = $("#status_surat").val();
        
        // // var kbButtons = document.getElementById("myDIV")[1].getElementsByClassName("btnku");
        // var tes = document.getElementsByClassName("keys");
        // var kbButtons = tes.getElementsByTagName("button");
        // var qqq = tes.getElementsByClassName("active");

        // var header = document.getElementById("myDIV");
        // var defaulttab = document.getElementById("defaultawal");
        // var btns = document.getElementsByClassName("btnku");

        // for (var i = 0; i < btns.length; i++) {
        //   // console.log("bbb")
        //   if(btns[0].className == "activedd"){
        //     if(btns[0].id == "defaultawal"){
        //       var button = 1;
        //     }
        //     else if (btns[0].id == "defaultdua"){
        //       var button = 2;
        //     }
        //     else{
        //       var button = 3;
        //     }
        //   }
        //   else if(btns[i].className == "active"){
        //     if(btns[i].id == "defaultawal"){
        //       var button = 1;
        //     }
        //     else if (btns[i].id == "defaultdua"){
        //       var button = 2;
        //     }
        //     else{
        //       var button = 3;
        //     }
        //   }
        // }

        // console.log(button);

        $.ajax({
          url : "<?php echo base_url('c_gap_infrastruktur_pendukung/load_status_surat') ?>",
          data: "status_surat=" +status_surat,
          success:function(data){
            $('#example2 tbody').html(data);
          }
        })
      } 

      function tabbutton(objButton){
        var valuebutton = objButton.value;
        
        if (valuebutton == '1') {
            document.getElementById("demo").innerHTML = "Infrastruktur Pengelolaan Kebun";
        }
        if (valuebutton == '2') {
            document.getElementById("demo").innerHTML = "Fasilitas Umum";
        } 
        if (valuebutton == '3') {
            document.getElementById("demo").innerHTML = "Fasilitas Sosial";
        } 
        
        $('#status_surat option').prop('selected', function() {
        return this.defaultSelected;
        });
        
        $.ajax({
          url : "<?php echo base_url('c_gap_infrastruktur_pendukung/load_tabbutton') ?>",
          data: "valuebutton=" +valuebutton,
          success:function(data){
            $('#example2 tbody').html(data);
          }
        })
      } 
      
      
    </script>

    <script>
    // Add active class to the current button (highlight it)

    var header = document.getElementById("myDIV");
    var defaulttab = document.getElementById("defaultawal");
    var btns = header.getElementsByClassName("btnku");
    $( "#defaultawal" ).addClass( "activedd" );
    for (var i = 0; i < btns.length; i++) {
      btns[i].addEventListener("click", function() {
      $( "#defaultawal" ).removeClass( "activedd" );
      var current = document.getElementsByClassName("active");
      current[0].className = current[0].className.replace(" active", "");
      this.className += " active";
      });
    }
    </script>