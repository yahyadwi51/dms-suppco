

  <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/adminlte.min.css">
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
                            <div class="col-md-4 mb-3">
                                <h1 class="m-0 text-dark">Detail Data</h1>
                                <table width="1000">
                                    <tbody>
                                        <?php
                                        ?>
                                        <tr>
                                        <th width="100">No Hak Atas Tanah</th><td width="500">: <?php echo $pertanahan[0]['no_hgu'] ?></td>
                                        </tr>
                                        <tr>
                                        <th width="100">Kebun</th><td width="500">: 
                                        <?php
                                          $data['master_bagian'] = $this->model_dokumen->tampil_data_bagian_kebun()->result(); 
                                          $id = $this->session->userdata('id') ;
                                            
                                          foreach ($data['master_bagian'] as $nh) : 
                                                if ($nh->id_bagian == $pertanahan[0]['id_kebun']) {
                                                    echo $nh->nama_bagian;
                                                  }
                                            endforeach; 
                                            ?></td>
                                        </tr>
                                        <tr>
                                        </tr>
                                       
                                        
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
                            <!-- <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    <select class="custom-select" id="dynamic_select">
                                        <option selected disabled>Export</option>
                                        <option value="<?php echo base_url() ?>c_laporan_gap_analysis/excel_ksi_pertanahan/<?php echo $pertanahan[0]['id_pertanahan'] ?>">Excel</option>
                                        <option value="<?php echo base_url() ?>c_laporan_gap_analysis/pdf_ksi_pertanahan/<?php echo $pertanahan[0]['id_pertanahan'] ?>">PDF</option>
                                    </select>
                                </div>
                            </div> -->
                        </div>
                        <ul class="nav nav-tabs nav-justified md-tabs indigo" id="myTabJust" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tanahbelumdigaraptab" data-toggle="tab" href="#tanahbelumdigarap" role="tab" aria-controls="tanahbelumdigarap"
                                    aria-selected="true"><span style="" >Tanah Belum digarap</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="okupasitab" data-toggle="tab" href="#okupasi" role="tab" aria-controls="okupasi"
                                    aria-selected="false">Okupasi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tumpangtindihtab" data-toggle="tab" href="#tumpangtindih" role="tab" aria-controls="tumpangtindih"
                                    aria-selected="false">Tumpang Tindih</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="permasalahanlaintab" data-toggle="tab" href="#permasalahanlain" role="tab" aria-controls="permasalahanlain"
                                    aria-selected="false">Permasalahan Lain</a>
                                </li>
                            </ul>
                        <div class="tab-content card pt-5" id="myTabContentJust">
                          <div class="tab-pane fade show active" id="tanahbelumdigarap" role="tabpanel" aria-labelledby="tanahbelumdigaraptab">
                            <table id="example2" class="table table-bordered table-hover">
                              <thead>
                              <tr>
                                <th>#</th>
                                <th>Luas</th>
                                <th>Tanggal Terjadi</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Komoditi</th>
                                <th>Kondisi Saat Ini</th>
                                <th>Action</th>
                              </tr>
                              </thead>
                              <tbody>
                                  <?php
                                    $no=0;
                                    foreach ($kondisi_saat_ini_tbd as $ksi) :
                                    $no++;
                                  ?>
                                  <tr>
                                      <td><?php echo $no ?></td>
                                      <td><?php echo $ksi['luas'] ?></td>
                                      <td><?php echo $ksi['tanggal_terjadi'] ?></td>
                                      <td><?php echo $ksi['latitude'] ?></td>
                                      <td><?php echo $ksi['longitude'] ?></td>
                                      <td><?php echo $ksi['komoditi'] ?></td>
                                      <td><?php echo $ksi['kondisi_saat_ini'] ?></td>
                                      <td><button type="button" class="btn  btn-primary btn-sm" id="<?php echo $ksi['id_kat_tanah'] ?>" value="<?php echo $ksi['id_pertanahan'] ?>,<?php echo $ksi['luas'] ?>,<?php echo $ksi['tanggal_terjadi'] ?>,<?php echo $ksi['latitude'] ?>,<?php echo $ksi['longitude'] ?>,<?php echo $ksi['subjek'] ?>,<?php echo $ksi['kerugian'] ?>,<?php echo $ksi['komoditi'] ?>,<?php echo $ksi['kondisi_saat_ini'] ?>,<?php echo $ksi['upload_dokumen'] ?>,<?php echo $ksi['kat'] ?>" onClick="kirimupdate(this.value,this.id)" data-toggle="modal" data-target="#modal-edit" title="Edit"><i class="far fa-edit"></i></button></td>
                                    
                                  </tr>
                                  <?php endforeach; ?>
                                  
                              </tbody>
                              
                            </table>
                          </div>
                          <div class="tab-pane fade" id="okupasi" role="tabpanel" aria-labelledby="okupasitab">
                            <table id="example2" class="table table-bordered table-hover">
                              <thead>
                              <tr>
                                <th>#</th>
                                <th>Luas</th>
                                <th>Tanggal Terjadi</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Subjek</th>
                                <th>Kerugian</th>
                                <th>Komoditi</th>
                                <th>Kondisi Saat Ini</th>
                                <th>Action</th>
                              </tr>
                              </thead>
                              <tbody>
                                  <?php
                                    $no=0;
                                    foreach ($kondisi_saat_ini_o as $ksi) :
                                    $no++;
                                  ?>
                                  <tr>
                                      <td><?php echo $no ?></td>
                                      <td><?php echo $ksi['luas'] ?></td>
                                      <td><?php echo $ksi['tanggal_terjadi'] ?></td>
                                      <td><?php echo $ksi['latitude'] ?></td>
                                      <td><?php echo $ksi['longitude'] ?></td>
                                      <td><?php echo $ksi['subjek'] ?></td>
                                      <td><?php echo $ksi['kerugian'] ?></td>
                                      <td><?php echo $ksi['komoditi'] ?></td>
                                      <td><?php echo $ksi['kondisi_saat_ini'] ?></td>
                                      <!-- <td><button type="button" class="btn  btn-primary btn-sm" id="<?php echo $ksi['histori_upload_dokumen'] ?>" value="<?php echo $ksi['id_histori_pertanahan'] ?>,<?php echo $ksi['id_pertanahan'] ?>,<?php echo $ksi['histori_kondisi_saat_ini'] ?>,<?php echo $ksi['tanggal_update'] ?>" onClick="kirimupdate(this.value,this.id)" data-toggle="modal" data-target="#modal-edit" title="Edit"><i class="far fa-edit"></i></button></td> -->
                                      <td><button type="button" class="btn  btn-primary btn-sm" id="<?php echo $ksi['id_kat_tanah'] ?>" value="<?php echo $ksi['id_pertanahan'] ?>,<?php echo $ksi['luas'] ?>,<?php echo $ksi['tanggal_terjadi'] ?>,<?php echo $ksi['latitude'] ?>,<?php echo $ksi['longitude'] ?>,<?php echo $ksi['subjek'] ?>,<?php echo $ksi['kerugian'] ?>,<?php echo $ksi['komoditi'] ?>,<?php echo $ksi['kondisi_saat_ini'] ?>,<?php echo $ksi['upload_dokumen'] ?>,<?php echo $ksi['kat'] ?>" onClick="kirimupdate(this.value,this.id)" data-toggle="modal" data-target="#modal-edit" title="Edit"><i class="far fa-edit"></i></button></td>
                                    
                                  </tr>
                                  <?php endforeach; ?>
                                  
                              </tbody>
                              
                            </table>
                          </div>
                          <div class="tab-pane fade" id="tumpangtindih" role="tabpanel" aria-labelledby="tumpangtindihtab">
                            <table id="example2" class="table table-bordered table-hover">
                              <thead>
                              <tr>
                                <th>#</th>
                                <th>Luas</th>
                                <th>Tanggal Terjadi</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Subjek</th>
                                <th>Kerugian</th>
                                <th>Komoditi</th>
                                <th>Kondisi Saat Ini</th>
                                <th>Action</th>
                              </tr>
                              </thead>
                              <tbody>
                                  <?php
                                    $no=0;
                                    foreach ($kondisi_saat_ini_tt as $ksi) :
                                    $no++;
                                  ?>
                                  <tr>
                                      <td><?php echo $no ?></td>
                                      <td><?php echo $ksi['luas'] ?></td>
                                      <td><?php echo $ksi['tanggal_terjadi'] ?></td>
                                      <td><?php echo $ksi['latitude'] ?></td>
                                      <td><?php echo $ksi['longitude'] ?></td>
                                      <td><?php echo $ksi['subjek'] ?></td>
                                      <td><?php echo $ksi['kerugian'] ?></td>
                                      <td><?php echo $ksi['komoditi'] ?></td>
                                      <td><?php echo $ksi['kondisi_saat_ini'] ?></td>
                                      <!-- <td><button type="button" class="btn  btn-primary btn-sm" id="<?php echo $ksi['histori_upload_dokumen'] ?>" value="<?php echo $ksi['id_histori_pertanahan'] ?>,<?php echo $ksi['id_pertanahan'] ?>,<?php echo $ksi['histori_kondisi_saat_ini'] ?>,<?php echo $ksi['tanggal_update'] ?>" onClick="kirimupdate(this.value,this.id)" data-toggle="modal" data-target="#modal-edit" title="Edit"><i class="far fa-edit"></i></button></td> -->
                                      <td><button type="button" class="btn  btn-primary btn-sm" id="<?php echo $ksi['id_kat_tanah'] ?>" value="<?php echo $ksi['id_pertanahan'] ?>,<?php echo $ksi['luas'] ?>,<?php echo $ksi['tanggal_terjadi'] ?>,<?php echo $ksi['latitude'] ?>,<?php echo $ksi['longitude'] ?>,<?php echo $ksi['subjek'] ?>,<?php echo $ksi['kerugian'] ?>,<?php echo $ksi['komoditi'] ?>,<?php echo $ksi['kondisi_saat_ini'] ?>,<?php echo $ksi['upload_dokumen'] ?>,<?php echo $ksi['kat'] ?>" onClick="kirimupdate(this.value,this.id)" data-toggle="modal" data-target="#modal-edit" title="Edit"><i class="far fa-edit"></i></button></td>
                                    
                                  </tr>
                                  <?php endforeach; ?>
                                  
                              </tbody>
                              
                            </table>
                          </div>
                          <div class="tab-pane fade" id="permasalahanlain" role="tabpanel" aria-labelledby="permasalahanlaintab">
                            <table id="example2" class="table table-bordered table-hover">
                              <thead>
                              <tr>
                                <th>#</th>
                                <th>Luas</th>
                                <th>Tanggal Terjadi</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Subjek</th>
                                <th>Kerugian</th>
                                <th>Komoditi</th>
                                <th>Kondisi Saat Ini</th>
                                <th>Action</th>
                              </tr>
                              </thead>
                              <tbody>
                                  <?php
                                    $no=0;
                                    foreach ($kondisi_saat_ini_pl as $ksi) :
                                    $no++;
                                  ?>
                                  <tr>
                                      <td><?php echo $no ?></td>
                                      <td><?php echo $ksi['luas'] ?></td>
                                      <td><?php echo $ksi['tanggal_terjadi'] ?></td>
                                      <td><?php echo $ksi['latitude'] ?></td>
                                      <td><?php echo $ksi['longitude'] ?></td>
                                      <td><?php echo $ksi['subjek'] ?></td>
                                      <td><?php echo $ksi['kerugian'] ?></td>
                                      <td><?php echo $ksi['komoditi'] ?></td>
                                      <td><?php echo $ksi['kondisi_saat_ini'] ?></td>
                                      <!-- <td><button type="button" class="btn  btn-primary btn-sm" id="<?php echo $ksi['histori_upload_dokumen'] ?>" value="<?php echo $ksi['id_histori_pertanahan'] ?>,<?php echo $ksi['id_pertanahan'] ?>,<?php echo $ksi['histori_kondisi_saat_ini'] ?>,<?php echo $ksi['tanggal_update'] ?>" onClick="kirimupdate(this.value,this.id)" data-toggle="modal" data-target="#modal-edit" title="Edit"><i class="far fa-edit"></i></button></td> -->
                                      <td><button type="button" class="btn  btn-primary btn-sm" id="<?php echo $ksi['id_kat_tanah'] ?>" value="<?php echo $ksi['id_pertanahan'] ?>,<?php echo $ksi['luas'] ?>,<?php echo $ksi['tanggal_terjadi'] ?>,<?php echo $ksi['latitude'] ?>,<?php echo $ksi['longitude'] ?>,<?php echo $ksi['subjek'] ?>,<?php echo $ksi['kerugian'] ?>,<?php echo $ksi['komoditi'] ?>,<?php echo $ksi['kondisi_saat_ini'] ?>,<?php echo $ksi['upload_dokumen'] ?>,<?php echo $ksi['kat'] ?>" onClick="kirimupdate(this.value,this.id)" data-toggle="modal" data-target="#modal-edit" title="Edit"><i class="far fa-edit"></i></button></td>
                                    
                                  </tr>
                                  <?php endforeach; ?>
                                  
                              </tbody>
                              
                            </table>
                          </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                  </div>
            </div>
          <!-- ./col -->
          <!-- modal edit -->
  <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title">Update Kondisi saat ini</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
          </div>
          <form onsubmit="return Validate(this);" action="<?php echo base_url() ?>c_gap_pertanahan/update_detail_pertanahan"  method="post" enctype="multipart/form-data">
          <div class="modal-body">
          <input type="hidden" class="form-control"  name="id_kat_tanah" id="id_kat_tanah">
          <input type="hidden" class="form-control"  name="id_pertanahan" id="dataedit1">
          <input type="hidden" class="form-control"  name="kat" id="dataedit12">
          <div id="tidak_salin">
                  <div class="form-group">
                      <label for="inputDescription">Luas(Ha)</label>
                      <input type="number" class="form-control"   id="dataedit2" name="luas">
                  </div>
                  <div class="form-group">
                      <label>Tanggal Terjadi</label>
                          <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate1" id="dataedit3" name="tanggal_terjadi" required/>
                              <div class="input-group-append" data-target="#reservationdate1" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
                  </div>
                  <div class="form-group">
                      <label for="inputDescription">Latitude</label>
                      <input type="text" class="form-control"  id="dataedit4" name="latitude">
                  </div>
                  <div class="form-group">
                      <label for="inputDescription">Longitude</label>
                      <input type="text" class="form-control"  id="dataedit5" name="longitude">
                  </div>
                  
                  <div class="form-group" id="edithilangkan1">
                      <label>Subjek</label>
                      <select class="form-control select2 dbsub" style="width: 100%;" id="dataedit6" name="subjek" required>
                      </select>
                  </div>
                  <div class="form-group " id="edithilangkan2" >
                      <label for="inputDescription">Kerugian</label>
                      <input type="text" class="form-control" id="dataedit7" name="kerugian">
                  </div>
                  <div class="form-group ">
                      <label for="inputDescription">Komoditi</label>
                      <input type="text" class="form-control" id="dataedit8"  name="komoditi">
                  </div>
                  <div class="form-group">
                      <label for="inputDescription">Kondisi Saat Ini</label>
                      <textarea class="form-control" rows="4" id="dataedit9" name="kondisi_saat_ini"></textarea>
                  </div>
                  <div class="form-group">
                      <label for="exampleInputFile">Upload Dokumen</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input"   name="upload_dokumen" >
                          <label class="custom-file-label"  id="dataedit10"></label>
                        </div>
                        <div class="input-group-append">
                          <span class="input-group-text">jpg,png,pdf</span>
                        </div>
                      </div>
                  </div>
                </div>
              
              <input type="hidden" class="form-control" id="dataedit11" name="upload_dokument" >
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
          <!-- ./col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  
    <!-- Modal Tambah -->
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Data </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form onsubmit="return Validate(this);" action="<?php echo base_url() ?>c_gap_pertanahan/tambah_detail_pertanahan"  method="post" enctype="multipart/form-data">
            <div class="modal-body">
              <input type="hidden" class="form-control idper"  name="id_pertanahan" value="<?php echo $pertanahan[0]['id_pertanahan'] ?>">
                <div class="form-group">
                    <label>Jenis Infrastruktur</label>
                        <select class="form-control select2" style="width: 100%;" name="ket" id="myselect">
                            <option selected value="" readonly>- Pilih Jenis Infrastruktur - </option>
                            <option value="1">Tanah Belum digarap</option>
                            <option value="2">Okupasi</option>
                            <option value="3">Tumpang Tindih</option>
                            <option value="4">Permasalahan Lain</option>
                        </select>
                </div>
                <div class="row">
                    <!-- checkbox -->
                    <div class="form-group col-md-2">
                        <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio1"  value="kosong" name="salindata" checked>
                        <label for="customRadio1" class="custom-control-label">Baru</label>
                        </div>
                    </div>
                    <div class="form-group col-md-5">
                        <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio2" value="salin" name="salindata">
                        <label for="customRadio2" class="custom-control-label">Salin dari data terbaru</label>
                        </div>
                    </div>
                </div>
                <div id="tidak_salin">
                  <div class="form-group">
                      <label for="inputDescription">Luas(Ha)</label>
                      <input type="number" class="form-control"   id="sluas" name="luas">
                  </div>
                  <div class="form-group">
                      <label>Tanggal Terjadi</label>
                          <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate1" id="stanggal_terjadi" name="tanggal_terjadi" required/>
                              <div class="input-group-append" data-target="#reservationdate1" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
                  </div>
                  <div class="form-group">
                      <label for="inputDescription">Latitude</label>
                      <input type="text" class="form-control"  id="slatitude" name="latitude">
                  </div>
                  <div class="form-group">
                      <label for="inputDescription">Longitude</label>
                      <input type="text" class="form-control"  id="slongitude" name="longitude">
                  </div>
                
                  <div class="form-group sese" id="hilangkan1">
                      <label>Subjek</label>
                      <select class="form-control select2 dbsub" style="width: 100%;" id="ssubjek" name="subjek" value="" required>
                          <option value=""></option>
                      </select>
                  </div>
                  <div class="form-group " id="hilangkan2" >
                      <label for="inputDescription">Kerugian</label>
                      <input type="text" class="form-control" id="skerugian" name="kerugian">
                  </div>
                  <div class="form-group ">
                      <label for="inputDescription">Komoditi</label>
                      <input type="text" class="form-control" id="skomoditi"  name="komoditi">
                  </div>
                  <div class="form-group">
                      <label for="inputDescription">Kondisi Saat Ini</label>
                      <textarea class="form-control" rows="4" id="skondisi_saat_ini" name="kondisi_saat_ini"></textarea>
                  </div>
                  <div class="form-group">
                      <label for="exampleInputFile">Upload Dokumen</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input"  id="supload_dokumen" name="upload_dokumen" >
                          <label class="custom-file-label" id="nameuploaddok"></label>
                        </div>
                        <div class="input-group-append">
                          <span class="input-group-text">jpg,png,pdf</span>
                        </div>
                      </div>
                  </div>
                </div>
                
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>

            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Modal Edit -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script type='text/javascript'>
  $(document).ready(function(){
   $('input[name=salindata],#myselect').change(function(){
    var tab_mana = $('select[name=ket] option').filter(':selected').val();
    var id_pertanahan = $(".idper").val();
    var radiovalue = $( 'input[name=salindata]:checked' ).val();
    if (radiovalue == 'kosong') {
        $('#sluas').val('');
         $('#stanggal_terjadi').val('');
         $('#slatitude').val('');
         $('#slongitude').val('');
         $('#ssubjek').val('');
         $('#skerugian').val('');
         $('#skomoditi').val('');
         $('#skondisi_saat_ini').val('');
         $("textarea[name='kondisi_saat_ini.skondisi_saat_ini']").val('')
         $('#nameuploaddok').html('');
    }else{
     $.ajax({
     url:'<?=base_url()?>/c_gap_pertanahan/salin_data_detail',
     method: 'post',
     data: {tab_mana: tab_mana, id_pertanahan: id_pertanahan},
     dataType: 'json',
     success: function(response){
          var len = response.length;
          if(len > 0){
            // Read values
            var luas = response[0].luas;
            var luas = response[0].luas;
            var tanggal_terjadi = response[0].tanggal_terjadi;
            var latitude = response[0].latitude;
            var longitude = response[0].longitude;
            var subjek = response[0].subjek;
            var kerugian = response[0].kerugian;
            var komoditi = response[0].komoditi;
            var kondisi_saat_ini = response[0].kondisi_saat_ini;
            var upload_dokumen = response[0].upload_dokumen;
            $(document).ready(function() {
              swal("Anda memilih data terbaru pada Tanggal Terjadi " + tanggal_terjadi + " dengan Subjek  "+ subjek, "", "success");

            });
            $('#sluas').val(luas);
            $('#stanggal_terjadi').val(tanggal_terjadi);
            $('#slatitude').val(latitude);
            $('#slongitude').val(longitude);
            $('div.sese select').val(subjek).change();
            $('#skerugian').val(kerugian);
            $('#skomoditi').val(komoditi);
            $('#skondisi_saat_ini').val(kondisi_saat_ini);
            $("textarea[name='kondisi_saat_ini.skondisi_saat_ini']").val(kondisi_saat_ini)
            $('#nameuploaddok').html(upload_dokumen);
    
          }
        }
      });                                                   
    }
    
  });
 });
 </script>
 
    <script>
    $(document).ready(function(){
        $("#myselect").change(function(){
          var status = $( "#myselect option:selected" ).text();
          if(status == 'Tanah Belum digarap'){
            $("#hilangkan1").hide();
            $("#hilangkan2").hide();
          }
          else {
            $("#hilangkan1").show();
            $("#hilangkan2").show();
            $("#edithilangkan1").show();
            $("#edithilangkan2").show();
          }
            
        });
        $( "#tanahbelumdigaraptab" ).click(function() {
          $(document).ready(function() {
            swal("Tanah Belum di Garap", "", "info");
          });
          $("#edithilangkan1").hide();
            $("#edithilangkan2").hide();
        });
        $( "#okupasitab" ).click(function() {
          $(document).ready(function() {
            swal("Okupasi", "", "info");
          });
          $("#edithilangkan1").show();
            $("#edithilangkan2").show();
        });
        $( "#tumpangtindihtab" ).click(function() {
          $(document).ready(function() {
            swal("Tumpang Tindih", "", "info");
          });
          $("#edithilangkan1").show();
            $("#edithilangkan2").show();
        });
        $( "#permasalahanlaintab" ).click(function() {
          $(document).ready(function() {
            swal("Permasalahan Lain", "", "info");
          });
          $("#edithilangkan1").show();
            $("#edithilangkan2").show();
        });
      })
    
  </script>
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
        document.getElementById("dataedit1").value = res[0];
        document.getElementById("dataedit2").value = res[1];
        document.getElementById("dataedit3").value = res[2];
        document.getElementById("dataedit4").value = res[3];
        document.getElementById("dataedit5").value = res[4];
        $('#dataedit6').val(res[5]).change();
        document.getElementById("dataedit7").value = res[6];
        document.getElementById("dataedit8").value = res[7];
        document.getElementById("dataedit9").value = res[8];
        document.getElementById("dataedit10").innerHTML = res[9];
        document.getElementById("dataedit11").value = res[9];
        document.getElementById("dataedit12").value = res[10];
        document.getElementById("id_kat_tanah").value = resx;

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
    <script type="text/javascript">
        $(document).ready(function(){
                var id=$(this).val();
                $.ajax({
                    url : "<?=base_url()?>/c_gap_pertanahan/get_subjek",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        var html = '<option value="" disabled selected>No Selected</option>';
                        var i;
                        for(i=0; i<data['data_subjek'].length; i++){
                            html += ' <option value='+data['data_subjek'][i].nama_lsm+'>'+data['data_subjek'][i].nama_lsm+'</option>';
                        }
                        $('.dbsub').html(html);
                        $('.dbsub').html(html);
 
                    }
                });
                return false;
             
        });
    </script>