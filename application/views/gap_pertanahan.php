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
            <h1 class="m-0 text-dark">Pertanahan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Pertanahan</li>
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
                                <a href="<?php echo base_url() ?>c_gap_pertanahan/form_pertanahan"><button type="button" class="btn btn-block btn-success btn-s">Tambah </button></a>
                            </div>
                            <div class="col-md-2 mb-3">
                              <div class="btn-group">
                                <button type="button" class="btn btn-info">Export</button>
                                <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                  <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                  <a class="dropdown-item" href="<?php echo base_url() ?>c_laporan_gap_analysis/excel_pertanahan">Excel</a>
                                  <a class="dropdown-item" href="<?php echo base_url() ?>c_laporan_gap_analysis/pdf_pertanahan">PDF</a>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-6 col-md-6"></div>
                            <div class="col-sm-2 col-md-2">
                            <!-- select -->
                                <div class="form-group">
                                    <select class="custom-select" id="status_surat">
                                        <option  value="aktif">Aktif</option>
                                        <option  value="nonaktif">Non Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-sm-2 col-md-2">
                                  <div class="form-group">
                                    <input type="text" id="filter" class="form-control" placeholder="Pencarian ...">
                                  </div>
                            </div> -->
                        </div>
                            <div class="scrollmenu">
                              <table id="example2"  class="table table-bordered table-hover">
                                  <thead>
                                  <tr>
                                  <th>#</th>
                                  <th style="width:5px">No Hak Atas Tanah</th>
                                  <th>Kebun</th>
                                  <th style="width:50%">Uraian</th>
                                  <th>Areal Konsesi/Cadangan/Tunggu</th>
                                  <th>Okupasi</th>
                                  <th>Tumpang Tindih</th>
                                  <th>Permasalahan Lain</th>
                                  <th>Action</th>
                                  </tr>
                                  </thead>
                                  <tbody id="myTable">
                                      <?php
                                      $no=0;
                                      foreach ($pertanahan as $key => $li) :
                                      $no++;
                                      ?>
                                      <tr>
                                          <td rowspan="9"><?php echo $no ?></td>
                                          <td rowspan="9"><?php $sub_kalimat = substr($li['no_hgu'],0,25); echo $sub_kalimat ?>...</td>
                                          <td  rowspan="9">
                                          <?php echo $li['nama_bagian'] ?>
                                              <?php
                                                $id_pert = $li['id_pertanahan'];
                                                $query_ket_pertanahan= $this->db->query("SELECT *  FROM gap_kat_pertanahan
                                                  WHERE id_pertanahan = '$id_pert' ORDER BY tanggal_terjadi DESC ");
                                                    $data['ket_tanah'] = $query_ket_pertanahan->result_array();
                                                    $jumlah =  count($data['ket_tanah']);
                                                    $luas_tanah1= $this->db->query("SELECT *  FROM gap_kat_pertanahan
                                                    WHERE id_pertanahan = '$id_pert' AND kat = '1' ORDER BY `tanggal_terjadi` DESC LIMIT 1");
                                                    $data['luas_tanah1'] = $luas_tanah1->result_array();
                                                    $luas_tanah2= $this->db->query("SELECT *  FROM gap_kat_pertanahan
                                                    WHERE id_pertanahan = '$id_pert' AND kat = '2' ORDER BY `tanggal_terjadi` DESC LIMIT 1");
                                                    $data['luas_tanah2'] = $luas_tanah2->result_array();
                                                    $luas_tanah3= $this->db->query("SELECT *  FROM gap_kat_pertanahan
                                                    WHERE id_pertanahan = '$id_pert' AND kat = '3' ORDER BY `tanggal_terjadi` DESC LIMIT 1");
                                                    $data['luas_tanah3'] = $luas_tanah3->result_array();
                                                    $luas_tanah4= $this->db->query("SELECT *  FROM gap_kat_pertanahan
                                                    WHERE id_pertanahan = '$id_pert' AND kat = '4' ORDER BY `tanggal_terjadi` DESC LIMIT 1");
                                                    $data['luas_tanah4'] = $luas_tanah4->result_array();   
                                              ?>

                                              <tr><td>Kategorisasi :</td>
                                                <td>
                                                  <?php if($data['luas_tanah1']){
                                                      print_r($data['luas_tanah1'][0]['kategorisasi']);
                                                    }else {
                                                      echo '-';
                                                    }?>
                                                </td>
                                                <td>
                                                  <?php if($data['luas_tanah2']){
                                                      print_r($data['luas_tanah2'][0]['kategorisasi']);
                                                    }?>
                                                </td>
                                                <td>
                                                  <?php if($data['luas_tanah3']){
                                                      print_r($data['luas_tanah3'][0]['kategorisasi']);
                                                    }?>
                                                </td>
                                                <td>
                                                  <?php if($data['luas_tanah4']){
                                                      print_r($data['luas_tanah4'][0]['kategorisasi']);
                                                    }?>
                                                </td>
                                                <td rowspan="9">
                                                  <?php echo anchor('c_gap_pertanahan/form_detail_pertanahan/'.$li['id_pertanahan'], '<button type="button" class="btn  btn-warning btn-sm mb-2" title="Detail"><i class="fas fa-exclamation-circle" style="color:white;"></i></button>') ?>
                                                  <?php echo anchor('c_gap_pertanahan/edit_pertanahan/'.$li['id_pertanahan'], '<button type="button" class="btn  btn-primary btn-sm mb-2" title="Edit"><i class="far fa-edit"></i></button>') ?>
                                                  <button type="button" class="btn  btn-danger btn-sm mb-2 ml-3" data-toggle="modal" data-target="#modalhapus" title="Non Aktif" name="<?= $li['id_pertanahan'];?>" onClick="reply_click1(this.name)"><i class="far fa-times-circle"></i></button>
                                                </td>
                                              </tr>
                                              
                                              <tr>
                                                <td>Luas :</td>
                                                <td>
                                                <?php if($data['luas_tanah1']){
                                                        print_r($data['luas_tanah1'][0]['luas']);
                                                      }else {
                                                        echo '-';
                                                      }
                                                      ?>
                                                </td>
                                                <td>
                                                <?php if($data['luas_tanah2']){
                                                        print_r($data['luas_tanah2'][0]['luas']);
                                                      }?>
                                                </td>
                                                <td>
                                                <?php if($data['luas_tanah3']){
                                                        print_r($data['luas_tanah3'][0]['luas']);
                                                      }?>
                                                </td>
                                                <td>
                                                <?php if($data['luas_tanah4']){
                                                        print_r($data['luas_tanah4'][0]['luas']);
                                                      }?>
                                                </td>
                                              </tr>

                                              <tr><td>Tanggal Terjadi :</td> 
                                              <td>
                                               <?php if($data['luas_tanah1']){
                                                      print_r($data['luas_tanah1'][0]['tanggal_terjadi']);
                                                    }else {
                                                      echo '-';
                                                    }?>
                                               </td>
                                               <td>
                                               <?php if($data['luas_tanah2']){
                                                      print_r($data['luas_tanah2'][0]['tanggal_terjadi']);
                                                    }?>
                                               </td>
                                               <td>
                                               <?php if($data['luas_tanah3']){
                                                      print_r($data['luas_tanah3'][0]['tanggal_terjadi']);
                                                    }?>
                                               </td>
                                               <td>
                                               <?php if($data['luas_tanah4']){
                                                      print_r($data['luas_tanah4'][0]['tanggal_terjadi']);
                                                    }?>
                                               </td>
                                              </tr>
                                              <tr><td>Latitude  :  </td>
                                              <td>
                                               <?php if($data['luas_tanah1']){
                                                      print_r($data['luas_tanah1'][0]['latitude']);
                                                    }else {
                                                      echo '-';
                                                    }?>
                                               </td>
                                               <td>
                                               <?php if($data['luas_tanah2']){
                                                      print_r($data['luas_tanah2'][0]['latitude']);
                                                    }?>
                                               </td>
                                               <td>
                                               <?php if($data['luas_tanah3']){
                                                      print_r($data['luas_tanah3'][0]['latitude']);
                                                    }?>
                                               </td>
                                               <td>
                                               <?php if($data['luas_tanah4']){
                                                      print_r($data['luas_tanah4'][0]['latitude']);
                                                    }?>
                                               </td>
                                              </tr>
                                              <tr><td>Longitude :  </td>
                                              <td>
                                               <?php if($data['luas_tanah1']){
                                                      print_r($data['luas_tanah1'][0]['longitude']);
                                                    }else {
                                                      echo '-';
                                                    }?>
                                               </td>
                                               <td>
                                               <?php if($data['luas_tanah2']){
                                                      print_r($data['luas_tanah2'][0]['longitude']);
                                                    }?>
                                               </td>
                                               <td>
                                               <?php if($data['luas_tanah3']){
                                                      print_r($data['luas_tanah3'][0]['longitude']);
                                                    }?>
                                               </td>
                                               <td>
                                               <?php if($data['luas_tanah4']){
                                                      print_r($data['luas_tanah4'][0]['longitude']);
                                                    }?>
                                               </td>
                                              </tr>
                                              <tr><td>Subjek  :  </td>
                                              <td>
                                               <?php if($data['luas_tanah1']){
                                                      print_r($data['luas_tanah1'][0]['subjek']);
                                                    }else {
                                                      echo '-';
                                                    }?>
                                               </td>
                                               <td>
                                               <?php if($data['luas_tanah2']){
                                                      print_r($data['luas_tanah2'][0]['subjek']);
                                                    }?>
                                               </td>
                                               <td>
                                               <?php if($data['luas_tanah3']){
                                                      print_r($data['luas_tanah3'][0]['subjek']);
                                                    }?>
                                               </td>
                                               <td>
                                               <?php if($data['luas_tanah4']){
                                                      print_r($data['luas_tanah4'][0]['subjek']);
                                                    }?>
                                               </td>
                                              </tr>
                                              <tr><td>Kerugian  :  </td>
                                              <td>
                                               <?php if($data['luas_tanah1']){
                                                      print_r($data['luas_tanah1'][0]['kerugian']);
                                                    }else {
                                                      echo '-';
                                                    }?>
                                               </td>
                                               <td>
                                               <?php if($data['luas_tanah2']){
                                                      print_r($data['luas_tanah2'][0]['kerugian']);
                                                    }?>
                                               </td>
                                               <td>
                                               <?php if($data['luas_tanah3']){
                                                      print_r($data['luas_tanah3'][0]['kerugian']);
                                                    }?>
                                               </td>
                                               <td>
                                               <?php if($data['luas_tanah4']){
                                                      print_r($data['luas_tanah4'][0]['kerugian']);
                                                    }?>
                                               </td>
                                              </tr>
                                              <tr><td>Komoditi  :  </td>
                                              <td>
                                               <?php if($data['luas_tanah1']){
                                                      print_r($data['luas_tanah1'][0]['komoditi']);
                                                    }else {
                                                      echo '-';
                                                    }?>
                                               </td>
                                               <td>
                                               <?php if($data['luas_tanah2']){
                                                      print_r($data['luas_tanah2'][0]['komoditi']);
                                                    }?>
                                               </td>
                                               <td>
                                               <?php if($data['luas_tanah3']){
                                                      print_r($data['luas_tanah3'][0]['komoditi']);
                                                    }?>
                                               </td>
                                               <td>
                                               <?php if($data['luas_tanah4']){
                                                      print_r($data['luas_tanah4'][0]['komoditi']);
                                                    }?>
                                               </td>
                                              </tr>
                                          
                                      </tr> 
                                          <?php
                                          if ($jumlah == 4) {
                                        ?>
                                        <script>
                                          
                                              $(".div_<?=$key?>").hide();
                                          
                                        </script>
                                        <?php }if ($jumlah == 3) { ?>
                                          <script>
                                          
                                          $(".div_<?=$key?>").show();
                                          
                                        </script>
                                          <?php } ?>

                                      
                                      <?php endforeach;  ?>
                                      
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
        <form action="<?= base_url().'c_gap_pertanahan/nonaktif/'?>" method="post">
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
        <form action="<?= base_url().'c_gap_pertanahan/aktif/'?>" method="post">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal Aktif</h5>
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
          url : "<?php echo base_url('c_gap_pertanahan/load_status_surat') ?>",
          data: "status_surat=" +status_surat,
          success:function(data){
            $('#example2 tbody').html(data);
          }
        })
      } 
      
    </script>
    