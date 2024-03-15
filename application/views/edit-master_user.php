<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
        href="<?php echo base_url() ?>assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="<?php echo base_url() ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet"
        href="<?php echo base_url() ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet"
        href="<?php echo base_url() ?>assets/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/dropzone/min/dropzone.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/adminlte.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?php echo base_url() ?>c_data_dokumen" class="brand-link" align="center">
            <span class="brand-text font-weight-light">JASINFO <b>PTPN XII</b></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <!-- <li class="nav-item ">
            <a href="<?php echo base_url() ?>c_index" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li> -->
                        <li class="nav-item ">
                            <a href="<?php echo base_url() ?>c_master_user" class="nav-link ">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>
                                    Master User
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Master User</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <?php foreach ($user as $jd) : ?>
                                <form action="<?php echo base_url() . 'c_master_user/update_user/' ?>" method="post">
                                    <div class="card-body">
                                        <button type="button" data-toggle="modal" data-target="#exampleModalCenter"
                                            class="btn btn-block btn-outline-primary">Ganti
                                            Password</button>
                                        <div class="row">
                                            <div class="form-group col-6">
                                                <input type="hidden" class="form-control" id="exampleInputEmail1"
                                                    placeholder="Masukkan Jenis Dokumen" name="id"
                                                    value="<?php echo $jd->id ?>">
                                                <label for="exampleInputEmail1">Username</label>
                                                <input type="text" class="form-control" id="exampleInputEmail1"
                                                    placeholder="" name="username" value="<?php echo $jd->username ?>">
                                            </div>

                                            <div class="form-group col-6" >
                                                <label>Role</label>
                                                <select class="form-control select2" style="width: 100%;" name="role_id"
                                                    value="<?php echo $jd->role_id ?>">
                                                    <?php foreach ($role as $r) : ?>
                                                    <option value="<?php echo $r->id; ?>" <?php
                                                                    if ($r->id == $jd->role_id) {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>
                                                        <?php echo $r->role ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label>Bagian</label>
                                                <select class="form-control select2" style="width: 100%;" name="bagian">
                                                    <?php foreach ($bagian as $r) : ?>
                                                    <option value="<?php echo $r->id_bagian; ?>" <?php
                                                                    if ($r->id_bagian == $jd->bagian) {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>
                                                        <?php echo $r->nama_bagian ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="exampleInputEmail1">Nomor Telepon</label>
                                                <input type="text" class="form-control" id="nomortelpon"
                                                    name="no_telp" value="<?php echo $jd->no_telp ?>" data-toggle="modal" data-target="#nomor_telfon" readonly>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="exampleInputEmail1">ID Telegram</label>
                                                <input type="text" class="form-control" 
                                                    name="id_telegram" value="<?php echo $jd->id_telegram ?>" data-toggle="modal" data-target="#idtelgram" readonly>
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="exampleInputEmail1">Email</label>
                                                <input type="text" class="form-control" id="email_edit"
                                                    name="email" value="<?php echo $jd->email ?>" data-toggle="modal" data-target="#idemail" readonly>
                                            </div>
                                            <div class="form-group col-5">
                                            </div>
                                            <!-- select -->
                                            <div class="form-group col-2">
                                                <label>Status User</label>
                                                <select class="custom-select" name="is_active">
                                                    <option value="1" <?= $jd->is_active == "1" ? "selected" : null ?>>Aktif
                                                    </option>
                                                    <option value="0" <?= $jd->is_active == "0" ? "selected" : null ?>>Non
                                                        Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>

                                </form>
                                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <form action="<?php echo base_url() . 'c_master_user/change_password/' ?>"
                                                method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Ganti
                                                        Password</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" id="myText" name="id_ganti_pass"
                                                        value="<?php echo $jd->id ?>">
                                                        <div class="form-group">
                                                        <label for="exampleInputEmail1">Password</label>
                                                        <input type="password" class="form-control" name="password" id="txtPassword">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Confirm Password</label>
                                                        <input type="password" class="form-control" id="txtConfirmPassword">
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" id="btnSubmit" class="btn btn-primary">Ganti</button>
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Batal</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
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
        <div class="modal fade" id="nomor_telfon" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Ganti
                                Nomor Telfon</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <?php 
                        $datatelp = explode(",",$jd->no_telp); 
                         foreach ($datatelp as $key => $dt) : 
                            if ($key >= 1 ) {
                            ?>
                               <div class='form-group'><div class='row' style='margin-left:0px'><input type='text' class='form-control col-10' name='authors[]' id='idtel1' value="<?= $dt?>"><input class='btn btn-danger col-1' type='button' value='-' onclick=remove_file(this); style='width:40px;height:40px;margin-left:3px;'></div></div>
                           <?php }else{ ?>
                               <div class="form-group">
                                   <input type="text" class="form-control" name="authors[]" id="author1"
                                       data-method="<?= $dt?>" value="<?= $dt?>">
                               </div>
                           <?php }endforeach;?>
                                
                            <div class="file_div1">
                            </div>
                                <div class="form-group">
                                    <input class="btn btn-primary mt-1" type="button" onclick="add_file1();" value="+" style="width:40px;height:40px;margin-bottom:10px">
                                    
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="getnotelps()">Ganti</button>
                            <button type="button" class="btn btn-danger" 
                                data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="idtelgram" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Ganti
                                ID Telegram</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <?php 
                        $datatel = explode(",",$jd->id_telegram); 
                         foreach ($datatel as $key => $dt) : 
                            if ($key >= 1 ) {
                         ?>
                            <div class='form-group'><div class='row' style='margin-left:0px'><input type='text' class='form-control col-10' name='authors[]' id='idtel1'  value="<?= $dt?>"><input class='btn btn-danger col-1' type='button' value='-' onclick=remove_file(this); style='width:40px;height:40px;margin-left:3px;'></div></div>
                        <?php }else{ ?>
                            <div class="form-group">
                                <input type="text" class="form-control" name="idtel[]" id="idtel1"
                                    data-method="<?= $dt?>" value="<?= $dt?>">
                            </div>
                        <?php }endforeach;?>
                        <div class="file_div2">
                            </div>
                                <div class="form-group">
                                    <input class="btn btn-primary mt-1" type="button" onclick="add_file2();" value="+" style="width:40px;height:40px;margin-bottom:10px">
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="getid_tel()">Ganti</button>
                            <button type="button" class="btn btn-danger" 
                                data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="idemail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Ganti
                                Email</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <?php 
                        $datamail = explode(",",$jd->email); 
                         foreach ($datamail as $key => $dt) : 
                            if ($key >= 1 ) {
                                ?>
                             <div class='form-group'><div class='row' style='margin-left:0px'><input type='text' class='form-control col-10' name='idemail[]' id='idemail1'  value="<?= $dt?>"><input class='btn btn-danger col-1' type='button' value='-' onclick=remove_file(this); style='width:40px;height:40px;margin-left:3px;'></div></div>
                            <?php }else{ ?>
                            <div class="form-group">
                                <input type="text" class="form-control" name="idemail[]" id="idemail1"
                                   data-method="<?= $dt?>" value="<?= $dt?>">
                            </div>
                        <?php }endforeach;?>
                        <div class="file_div3">
                            </div>
                                <div class="form-group">
                                    <input class="btn btn-primary mt-1" type="button" onclick="add_file3();" value="+" style="width:40px;height:40px;margin-bottom:10px">
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="getid_email()">Ganti</button>
                            <button type="button" class="btn btn-danger" 
                                data-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2021 <a href="<?= base_url();?>">JASINF0</a>.</strong>
            All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <script type="text/javascript">
        $(function () {
            $("#btnSubmit").click(function () {
                var password = $("#txtPassword").val();
                var confirmPassword = $("#txtConfirmPassword").val();
                if (password != confirmPassword) {
                    swal("Password tidak cocok", "", "error");
                    return false;
                }
                return true;
            });
        });
    </script>
    <script type="text/javascript">
      function add_file1()
      {
      $(".file_div1").append("<div class='form-group'><div class='row' style='margin-left:0px'><input type='text' class='form-control col-10' name='authors[]' id='author1'><input class='btn btn-danger col-1' type='button' value='-' onclick=remove_file(this); style='width:40px;height:40px;margin-left:3px;'></div></div>");
      }
      function remove_file()
      {
      $(ele).parent().remove();
      }
    </script>
    <script type="text/javascript">
      function add_file2()
      {
      $(".file_div2").append("<div class='form-group'><div class='row' style='margin-left:0px'><input type='text' class='form-control col-10' name='authors[]' id='idtel1'><input class='btn btn-danger col-1' type='button' value='-' onclick=remove_file(this); style='width:40px;height:40px;margin-left:3px;'></div></div>");
      }
      function remove_file(ele)
      {
      $(ele).parent().remove();
      }
    </script>
    <script type="text/javascript">
      function add_file3()
      {
      $(".file_div3").append("<div class='form-group'><div class='row' style='margin-left:0px'><input type='text' class='form-control col-10' name='authors[]' id='idemail1idtel1'><input class='btn btn-danger col-1' type='button' value='-' onclick=remove_file(this); style='width:40px;height:40px;margin-left:3px'></div></div>");
      }
      function remove_file(ele)
      {
      $(ele).parent().remove();
      }
    </script>
    <?php if ($this->session->flashdata('something1')) { ?>
    <script>
    $(document).ready(function() {
        swal("Password Berhasil di Ubah", "", "success");
    });
    </script>

    <?php } ?>
    <script>
    function getnotelps(){
        var authors = $('input[id^="author"]').map(function() {
    return this.value;
    }).get();
    var myVal=authors; 
    // alert(myVal);
    $("input[name='no_telp").val(myVal);
    }
    </script>
    <script>
    function getid_tel(){
        var authors = $('input[id^="idtel"]').map(function() {
        return this.value;
        }).get();
        var myVal=authors; 
        // alert(myVal);
        $("input[name='id_telegram").val(myVal);
        }
    </script>
    <script>
    function getid_email(){
        var authors = $('input[id^="idemail"]').map(function() {
        return this.value;
        }).get();
        var myVal=authors; 
        // alert(myVal);
        $("input[name='email").val(myVal);
        }
    </script>
    <!-- jQuery -->
    <script src="<?php echo base_url() ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url() ?>assets/plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="<?php echo base_url() ?>assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js">
    </script>
    <!-- InputMask -->
    <script src="<?php echo base_url() ?>assets/plugins/moment/moment.min.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="<?php echo base_url() ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="<?php echo base_url() ?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?php echo base_url() ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js">
    </script>
    <!-- Bootstrap Switch -->
    <script src="<?php echo base_url() ?>assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- BS-Stepper -->
    <script src="<?php echo base_url() ?>assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- dropzonejs -->
    <script src="<?php echo base_url() ?>assets/plugins/dropzone/min/dropzone.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url() ?>assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url() ?>assets/dist/js/demo.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script>
    $(function() {
        bsCustomFileInput.init();
    });
    </script>
    <script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {
            'placeholder': 'mm/dd/yyyy'
        })
        //Money Euro
        $('[data-mask]').inputmask()

        //Date range picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });
        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                    'MMMM D, YYYY'))
            }
        )

        //Timepicker
        $('#timepicker').datetimepicker({
            format: 'LT'
        })

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        });

        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });

    })
    // BS-Stepper Init
    document.addEventListener('DOMContentLoaded', function() {
        window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    });

    // DropzoneJS Demo Code Start
    Dropzone.autoDiscover = false;

    // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    var previewNode = document.querySelector("#template");
    previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);

    var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
        url: "/target-url", // Set the url
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        previewTemplate: previewTemplate,
        autoQueue: false, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews", // Define the container to display the previews
        clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
    });

    myDropzone.on("addedfile", function(file) {
        // Hookup the start button
        file.previewElement.querySelector(".start").onclick = function() {
            myDropzone.enqueueFile(file);
        };
    });

    // Update the total progress bar
    myDropzone.on("totaluploadprogress", function(progress) {
        document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
    });

    myDropzone.on("sending", function(file) {
        // Show the total progress bar when upload starts
        document.querySelector("#total-progress").style.opacity = "1";
        // And disable the start button
        file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
    });

    // Hide the total progress bar when nothing's uploading anymore
    myDropzone.on("queuecomplete", function(progress) {
        document.querySelector("#total-progress").style.opacity = "0";
    });

    // Setup the buttons for all transfers
    // The "add files" button doesn't need to be setup because the config
    // `clickable` has already been specified.
    document.querySelector("#actions .start").onclick = function() {
        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
    };
    document.querySelector("#actions .cancel").onclick = function() {
        myDropzone.removeAllFiles(true);
    };
    // DropzoneJS Demo Code End
    </script>
</body>

</html>