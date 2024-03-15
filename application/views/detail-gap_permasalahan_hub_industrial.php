<style>
.btnku {
  border: none;
  outline: none;
  margin: 3px 2px;
  padding: 10px 16px;
  background-color: #FFFFFF;
  cursor: pointer;
  color: black;
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
            <h1 class="m-0 text-dark">Permasalahan hubungan industrial</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item">Permasalahan hubungan industrial</li>
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
                            <div class="col-md-10 mb-3">
                                <h1 class="m-0 text-dark">Detail Data</h1>
                                <table>
                                    <thead>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no=0;
                                        foreach ($permasalahan as $li) :
                                        $no++;
                                        ?>
                                        <tr>
                                        <th width="100">Subjek</th><td id width="600">: <?php echo $li['subjek'] ?></td>
                                        <th width="100">Kondisi saat ini</th><td width="600">: <?php echo $li['kondisi_saat_ini'] ?></td>
                                        <th></th><td width="200"><button type="button" class="btn-warning btn-l col-sm-12 col-md-12 ml-3" style="color:white" data-toggle="modal" data-target="#modal-closing" >Ubah Status </button></td>
                                        </tr>
                                        <tr>
                                        <th>Lokasi</th> <td>: <?php echo $li['lokasi'] ?></td>
                                        <th>Kerugian</th> <td>: <?php echo $li['kerugian'] ?></td>
                                        </tr>
                                        <tr>
                                        <th>Waktu</th><td>: <?php $newDate1 = date("d-m-Y", strtotime($li['waktu'])); echo $newDate1 ;?></td>
                                        <th>Upaya Penyelesaian</th><td>: <?php echo $li['upaya_penyelesaian'] ?></td>
                                        </tr>
                                        <tr>
                                        <th>Status</th><td>: <?php 
                                        if($li['status'] == '0' ){
                                            echo 'Proses';
                                        }elseif ($li['status'] == '1') {
                                            echo 'Close';
                                        }   ?></td>
                                        <th>Keterangan</th><td>: <?php echo $li['keterangan'] ?></td>
                                        </tr>
                                        
                                       
                                        <?php endforeach; ?>
                                        
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                        <div class="row mb-2">
                            
                            <div class="col-md-10 mb-3">
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-lg">
                                Tambah data
                                </button>
                                <!-- <a href="<?php echo base_url() ?>c_gap_legal_ijin/form_legal_ijin"><button type="button" class="btn btn-block btn-success btn-s">Tambah </button></a> -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-3 ">
                            <!-- select -->
                              <div id="myDIV" class="form-group">
                                <button type="button"  id="defaultawal" class=" btn-lg btnku"  onfocus="document.getElementById('filter').value=''" value='1' onclick='tabbutton(this)'>Kondisi Terkini </button>
                                <button type="button" class="btn-lg btnku"  onfocus="document.getElementById('filter').value=''" value='2' onclick='tabbutton(this)'>Upaya Penyelesaian </button>
                                <!-- <button type="button" class="btn-lg btnku"  onfocus="document.getElementById('filter').value=''" value='3' onclick='tabbutton(this)'>Upaya Penyelesaian </button> -->
                              </div>
                            </div>
                            <div class="col-md-2 mb-3">
                            </div>
                            <div class="col-md-2 mb-3">
                            <!-- select -->
                                <div class="form-group">
                                    <select class="custom-select mt-3" id="dynamic_select">
                                        <option selected disabled>Export</option>
                                        <option value="<?php echo base_url() ?>c_laporan_gap_analysis/excel_ksi_phi/<?php echo $li['id_permasalahan'] ?>">Excel</option>
                                        <option value="<?php echo base_url() ?>c_laporan_gap_analysis/pdf_ksi_phi/<?php echo $li['id_permasalahan'] ?>">PDF</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                      <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                          <th>#</th>
                          <th>Kondisi Saat Ini</th>
                          <th>Tanggal Update</th>
                          <th>Upload Dokumen</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                              $no=0;
                              foreach ($kondisi_saat_ini as $ksi) :
                              $no++;
                            ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $ksi['histori_kondisi_saat_ini'] ?></td>
                                <td><?php $newDate = date("d-m-Y", strtotime($ksi['tanggal_update'])); echo $newDate ;?></td>
                                <td><?php echo $ksi['histori_upload_dokumen'] ?></td>
                                <td><a href="<?php echo base_url()?>c_gap_permasalahan_hub_industrial/form_edit_detail_permasalahan_hub_industrial/<?php echo $ksi['id_histori_permasalahan'] ?>"><button type="button" class="btn  btn-primary btn-sm"  title="Edit"><i class="far fa-edit"></i></button></a></td>
                               
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
    <!-- Modal Edit -->
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Kondisi saat ini</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form onsubmit="return Validate(this);" action="<?php echo base_url() ?>c_gap_permasalahan_hub_industrial/tambah_detail_permasalahan_hub_industrial"  method="post" enctype="multipart/form-data">
            <div class="modal-body">
            <?php
            $no=0;
            foreach ($permasalahan as $li) :
            $no++;
            ?>
            <input type="hidden" class="form-control" id="id_pms"  name="id_permasalahan" value="<?php echo $li['id_permasalahan'] ?>">
            <?php endforeach; ?>
                <div class="form-group">
                    <select class="custom-select" id="drbss" name="tab">
                        <option selected disabled> - Pilih Menu - </option>
                        <option value="1">Kondisi Saat ini</option>
                        <option value="2">Upaya Penyelesaian</option>
                    </select>
                </div>
                <div class="form-group">
                    <label id="demo">Kondisi Saat Ini</label>
                    <textarea id="inputDescription" class="form-control" rows="4" name="histori_kondisi_saat_ini"></textarea>
                </div>
                <div class="form-group">
                    <label>Tanggal</label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="tanggal_update" required/>
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                </div>
                <div class="file_div">
                  <div class="form-group">
                    <label for="exampleInputFile">Upload Dokumen</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input"   id="cv" name="histori_upload_dokumen[]" multiple>
                        <label class="custom-file-label" ></label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">jpg,png,pdf</span>
                      </div>
                    </div>
                    <!-- <input class="btn btn-primary" type="button" onclick="add_file();" value="+" style="width:40px;height:40px;margin-bottom:10px"> -->
                  </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Modal Edit -->
    <!-- Modal Edit -->
    <div class="modal fade" id="modal-closing">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Closing</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form onsubmit="return Validate(this);" action="<?php echo base_url() ?>c_gap_permasalahan_hub_industrial/closing"  method="post" enctype="multipart/form-data">
            <div class="modal-body">
            <?php
            $no=0;
            foreach ($permasalahan as $li) :
            $no++;
            ?>
            <input type="hidden" class="form-control" id="id_pms"  name="id_permasalahan" value="<?php echo $li['id_permasalahan'] ?>">
            <?php endforeach; ?>
                <div class="form-group">
                    <label id="demo1">Kondisi Saat Ini</label>
                    <textarea id="inputDescription" class="form-control" rows="4" name="histori_kondisi_saat_ini"></textarea>
                </div>
                <div class="form-group">
                    <label>Tanggal</label>
                        <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate1" name="tanggal_update" required/>
                            <div class="input-group-append" data-target="#reservationdate1" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                </div>
                <div class="file_div">
                  <div class="form-group">
                    <label for="exampleInputFile">Upload Dokumen</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input"   id="cv" name="histori_upload_dokumen[]" multiple>
                        <label class="custom-file-label" ></label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">jpg,png,pdf</span>
                      </div>
                    </div>
                    <!-- <input class="btn btn-primary" type="button" onclick="add_file();" value="+" style="width:40px;height:40px;margin-bottom:10px"> -->
                  </div>
                </div>
                <input type="hidden" class="form-control" id="myText6" name="upload_dokument" >
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Modal Edit -->
    <script>
      var _validFileExtensions = [".jpg", ".jpeg", ".pdf", ".png"]; 
      function Validate(oForm) {
          var arrInputs = oForm.getElementsByTagName("input");
          for (var i = 0; i < arrInputs.length; i++) {
              var oInput = arrInputs[i];
              if (oInput.type == "file") {
                  var sFileName = oInput.value;
                  if (sFileName.length > 0) {
                      var blnValid = false;
                      for (var j = 0; j < _validFileExtensions.length; j++) {
                          var sCurExtension = _validFileExtensions[j];
                          if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                              blnValid = true;
                              break;
                          }
                      }
                      
                      if (!blnValid) {
                          alert("Format upload harus : " + _validFileExtensions.join(", "));
                          return false;
                      }
                  }
              }
          }
        
          return true;
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
      swal("Closing", "", "success");
    });
    </script>

    <?php } ?>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#drbss").change(function(){
            var status_surat = $("#drbss").val();
        if (status_surat == '1') {
            document.getElementById("demo").innerHTML = "Kondisi Saat Ini";
        }
        if (status_surat == '2') {
            document.getElementById("demo").innerHTML = "Upaya Penyelesaian";
        }
        })
      })
      $(document).ready(function(){
        $("#drbss1").change(function(){
            var status_surat = $("#drbss1").val();
        if (status_surat == '1') {
            document.getElementById("demo1").innerHTML = "Kondisi Saat Ini";
        }
        if (status_surat == '2') {
            document.getElementById("demo1").innerHTML = "Upaya Penyelesaian";
        }
        })
      })

      
    </script>
<script>

function tabbutton(objButton){
        var valuebutton = objButton.value;
        var id_permasalahan = $("#id_pms").val();
        $.ajax({
          url : "<?php echo base_url('c_gap_permasalahan_hub_industrial/load_tabbutton') ?>",
          data: "valuebutton=" +valuebutton+"&id_permasalahan="+id_permasalahan,
          success:function(data){
            $('#example2 tbody').html(data);
          }
        })
      } 
</script>
<script type="text/javascript">
    function add_file()
    {
    $(".file_div").append(" <div><input type='file' name='histori_upload_dokumen[]'><input class='btn btn-danger' type='button' value='-' onclick=remove_file(this); style='width:40px;height:40px;margin-left:3px;margin-bottom:10px'></div>");
    }
    function remove_file(ele)
    {
    $(ele).parent().remove();
    }
    </script>
     <script type="text/javascript">
      function kirimupdate(z,x){
        var str = z ;
        var res = str.split(",");
        var strx = x ;
        var resx = strx.split(",");
        document.getElementById("myText1").value = res[0];
        document.getElementById("myText2").value = res[1];
        document.getElementById("myText3").value = res[2];
        document.getElementById("myText4").value = res[3];
        document.getElementById("myText6").value = resx;
        document.getElementById("myText5").value = resx;

      }
    </script>
        <script>
        $(function(){
          // bind change event to select
          $('#dynamic_select').on('change', function () {
              var url = $(this).val(); // get selected value
              if (url) { // require a URL
                  window.location = url; // redirect
              }
              return false;
          });
        });
    </script>
    <script>
    // Add active class to the current button (highlight it)
    var defaulttab = document.getElementById("defaultawal");
    var header = document.getElementById("myDIV");
    var btns = header.getElementsByClassName("btnku");
    $( "#defaultawal" ).addClass( "activedd" );
    for (var i = 0; i <= btns.length; i++) {
      btns[i].addEventListener("click", function() {
    $( "#defaultawal" ).removeClass( "activedd" );
        
      var current = document.getElementsByClassName("active");
      current[0].className = current[0].className.replace(" active", "");
      this.className += " active";
      });
    }
    </script>