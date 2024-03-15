<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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
              <li class="breadcrumb-item active">Infrastruktur Pendukung</li>
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
                            <div class="col-md-5 mb-3">
                                <h1 class="m-0 text-dark">Detail Data</h1>
                                <table width="1000">
                                    <tbody>
                                        <?php
                                        $no=0;
                                        foreach ($infra_pend as $li) :
                                        $no++;
                                        ?>
                                        <tr>
                                        <th width="100">Kebun</th><td width="500">: <?php echo $li['nama_bagian'] ?></td>
                                        </tr>
                                        <tr>
                                        <th width="100">Jenis Infrastruktur</th><td width="500">: <?php $jnsinfra =  $li['jenis_infrastruktur'] ;
                                         if ($jnsinfra == 1 ){
                                             echo 'Infrastruktur Pengelolaan Kebun';
                                            }elseif ($jnsinfra == 2) {
                                            echo 'Fasilitas Umum';
                                            }elseif ($jnsinfra == 3) {
                                                echo 'Fasilitas Sosial';
                                            }?>
                                         </td>
                                        </tr>
                                        <tr>
                                        <th width="100">Nama data</th> <td width="500">: <?php echo $li['nama_infra'] ?></td>
                                        </tr>
                                        <tr>
                                        <th width="100">Kondisi saat ini</th><td width="500">: <?php echo $li['jumlah'] ?></td>
                                        </tr>
                                        <tr>
                                        <th width="100">Keterangan</th><td width="500">: <?php echo $li['kondisi_saat_ini'] ?></td>
                                        </tr>
                                        <tr>
                                        <th width="100">Luas Tanah</th><td width="500">: <?php echo $li['luas_tanah'] ?> m<sup>2</sup></td>
                                        </tr>
                                        <tr>
                                        <th width="100">Luas Bangunan</th><td width="500">: <?php echo $li['luas_bangunan'] ?> m<sup>2</sup></td>
                                        </tr>
                                        <tr>
                                        <th width="100">Jumlah / unit</th><td width="500">: <?php echo $li['jumlah'] ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        
                                    </tbody>
                                    
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 mb-3">
                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-lg">
                                Tambah Kondisi
                                </button>
                                <!-- <a href="<?php echo base_url() ?>c_gap_legal_ijin/form_legal_ijin"><button type="button" class="btn btn-block btn-success btn-s">Tambah </button></a> -->
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <select class="custom-select" id="dynamic_select">
                                        <option selected disabled>Export</option>
                                        <option value="<?php echo base_url() ?>c_laporan_gap_analysis/excel_ksi_infrastruktur_pendukung/ <?php echo $li['id_infra_pen'] ?>">Excel</option>
                                        <option value="<?php echo base_url() ?>c_laporan_gap_analysis/pdf_ksi_infrastruktur_pendukung/ <?php echo $li['id_infra_pen'] ?>">PDF</option>
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
                                <td><button type="button" class="btn  btn-primary btn-sm" id="<?php echo $ksi['histori_upload_dokumen'] ?>" value="<?php echo $ksi['id_histori_infra_pen'] ?>,<?php echo $ksi['id_infra_pen'] ?>,<?php echo $ksi['histori_kondisi_saat_ini'] ?>,<?php $date=date_create($ksi['tanggal_update']);$formattgl = date_format($date,"d-m-Y");echo $formattgl; ?>" onClick="kirimupdate(this.value,this.id)" data-toggle="modal" data-target="#modal-edit" title="Edit"><i class="far fa-edit"></i></button></td>
                                
                            </tr>
                            <?php endforeach; ?>
                            
                        </tbody>
                        
                      </table>
                    </div>
                    <!-- /.card-body -->
                  </div>
            </div>
          <!-- ./col -->
          <!-- Modal Edit -->
          <div class="modal fade" id="modal-edit">
              <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <div class="modal-header">
                  <h4 class="modal-title">Update Kondisi saat ini</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  <form  id="qual" onsubmit="return Validate(this);" action="<?php echo base_url() ?>c_gap_infrastruktur_pendukung/update_detail_infra_pend"  method="post" enctype="multipart/form-data">
                  <div class="modal-body">
                  <input type="hidden" class="form-control"  name="id_histori_infra_pen" id="myText1">
                  <input type="hidden" class="form-control"  name="id_infra_pen" id="myText2">
                      <div class="form-group">
                          <label for="inputDescription">Kondisi Saat Ini</label>
                          <textarea class="form-control" rows="4" id="myText3" name="histori_kondisi_saat_ini"></textarea>
                      </div>
                      <div class="form-group">
                          <label>Tanggal</label>
                              <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                  <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="tanggal_update" id="myText4"  required/>
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
                              <label class="custom-file-label" id="myText5"></label>
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
                  <button type="submit" class="btn btn-primary">Ubah</button>
                  </div>
                  </form><script>document.foo.submit();</script>
              </div>
              <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
          </div>
          <!-- Modal Edit -->
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
            <form    onsubmit="return Validate(this);" id="qual" action="<?php echo base_url() ?>c_gap_infrastruktur_pendukung/tambah_detail_infra_pend"  z-index="-1" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                  <?php
                  $no=0;
                  foreach ($infra_pend as $li) :
                  $no++;
                  ?>
                  <input type="hidden" class="form-control"  name="id_infra_pen" value="<?php echo $li['id_infra_pen'] ?>">
                  <?php endforeach; ?>
                <div class="form-group">
                    <label for="inputDescription">Kondisi Saat Ini</label>
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
                    <label>Upload Dokumen</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input"  id="cv" name="histori_upload_dokumen[]" multiple>
                        <label class="custom-file-label" id="myText5"></label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">jpg,png,pdf</span>
                      </div>
                    </div>
                    <!-- <input class="btn btn-primary" type="button" onclick="add_file();" value="+" style="width:40px;height:40px;margin-top:10px"> -->
                  </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button class="btn btn-primary">Tambah Data</button>
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
    <script type="text/javascript">
      function add_file()
      {
      $(".file_div").append('<div class="form-group"><label>Upload Dokumen</label><div class="input-group"><div class="custom-file"><input type="file" class="custom-file-input"  name="histori_upload_dokumen[]" ><label class="custom-file-label" id="myText5"></label></div><div class="input-group-append"><span class="input-group-text">jpg,png,pdf</span></div></div><input class="btn btn-danger" type="button"  value="-" onclick=remove_file(this); style="width:40px;height:40px;margin-top:10px"></div>');
     
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
        document.getElementById("myText5").innerHTML = resx;

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
    $("#qual").submit( function(submitEvent) {
    var fileSize = document.getElementById("cv").files[0];
    var sizeInMb = (fileSize.size/1024)/1024;
    var sizeLimit= 2;
    if (sizeInMb > sizeLimit) {
        alert('File harus berukuran dibawah 5MB');
        return false;
    }
    
    var filename = $("#cv").val();
    var extension = filename.replace(/^.*\./, '');
    if (extension == filename) {
        extension = '';
    } else {
        extension = extension.toLowerCase();
    }
    switch (extension) {
        case 'pdf':
        case 'doc':
        case 'docx':
            $("#qual").submit(function(e){
                $("#qual").unbind('submit').submit()
            });
            break;
            
        default:
            alert('Format file harus : jpg/png/pdf')
            return false;
    }
});
</script>