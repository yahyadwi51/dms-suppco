<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DMS SuppCo</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet"
    href="<?php echo base_url() ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet"
    href="<?php echo base_url() ?>assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet"
    href="<?php echo base_url() ?>assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">


</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <!-- Notifications Dropdown Menu -->

        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <?php
            $id = $this->session->userdata('id');
            $bagian = $this->session->userdata('id_bagian');
            $username = $this->session->userdata('username');
            $role_id = $this->session->userdata('role_id');
            $id_region = $this->session->userdata('id_region');

            if ($role_id == '5') {
              $query_notifikasi = $this->db->query("SELECT request_dokumen.id as id_req, hkm_dokumen_dms.id_dokumen as id_dokumen, hkm_dokumen_dms.nama_dokumen as nama_dokumen FROM request_dokumen JOIN hkm_dokumen_dms ON hkm_dokumen_dms.id_dokumen = request_dokumen.id_dokumen JOIN tb_regional_n2 ON tb_regional_n2.nama_regional = request_dokumen.nama_regional WHERE status_req = 'Request'");

              $jumlah_query_notifikasi = $this->db->query("SELECT COUNT(*) AS total_notif FROM request_dokumen JOIN hkm_dokumen_dms ON hkm_dokumen_dms.id_dokumen = request_dokumen.id_dokumen JOIN tb_regional_n2 ON tb_regional_n2.nama_regional = request_dokumen.nama_regional WHERE status_req = 'Request'");

              $data['notifikasi_reminder'] = $query_notifikasi->result_array();
              $data['jumlah_notifikasi_reminder'] = $jumlah_query_notifikasi->result_array();
            } 
            
            else if ($role_id == '3') {
              $query_notifikasi = $this->db->query("SELECT request_dokumen.id as id_req, hkm_dokumen_dms.id_dokumen as id_dokumen, hkm_dokumen_dms.nama_dokumen as nama_dokumen FROM request_dokumen JOIN hkm_dokumen_dms ON hkm_dokumen_dms.id_dokumen = request_dokumen.id_dokumen JOIN tb_regional_n2 ON tb_regional_n2.nama_regional = request_dokumen.nama_regional WHERE tb_regional_n2.id_regional='$id_region' AND status_req = 'Request'");

              $jumlah_query_notifikasi = $this->db->query("SELECT COUNT(*) AS total_notif FROM request_dokumen JOIN hkm_dokumen_dms ON hkm_dokumen_dms.id_dokumen = request_dokumen.id_dokumen JOIN tb_regional_n2 ON tb_regional_n2.nama_regional = request_dokumen.nama_regional WHERE tb_regional_n2.id_regional='$id_region' AND status_req = 'Request'");

              $data['notifikasi_reminder'] = $query_notifikasi->result_array();
              $data['jumlah_notifikasi_reminder'] = $jumlah_query_notifikasi->result_array();
            }
            
            else {
              $query_notifikasi = $this->db->query("SELECT request_dokumen.id as id_req, hkm_dokumen_dms.id_dokumen as id_dokumen, hkm_dokumen_dms.nama_dokumen as nama_dokumen, status_req  FROM request_dokumen JOIN hkm_dokumen_dms ON hkm_dokumen_dms.id_dokumen = request_dokumen.id_dokumen JOIN tb_regional_n2 ON tb_regional_n2.nama_regional = request_dokumen.nama_regional WHERE username ='$username' AND is_read='0' AND tb_regional_n2.id_regional='$id_region' AND tanggal_down is null AND (status_req = 'Approve' OR status_req = 'Tolak')");

              $jumlah_query_notifikasi = $this->db->query("SELECT COUNT(*) AS total_notif FROM request_dokumen JOIN hkm_dokumen_dms ON hkm_dokumen_dms.id_dokumen = request_dokumen.id_dokumen JOIN tb_regional_n2 ON tb_regional_n2.nama_regional = request_dokumen.nama_regional WHERE username ='$username' AND is_read='0' AND tb_regional_n2.id_regional='$id_region' AND tanggal_down is null AND (status_req = 'Approve' OR status_req = 'Tolak')");

              $data['notifikasi_reminder'] = $query_notifikasi->result_array();
              $data['jumlah_notifikasi_reminder'] = $jumlah_query_notifikasi->result_array();

            }
            foreach ($data['jumlah_notifikasi_reminder'] as $dd):
              ?>
              <?php if ($dd['total_notif'] == 0) {
                ?>
                <span class="badge badge-info navbar-badge">
                  <?php
              } else {
                ?>
                  <span class="badge badge-warning navbar-badge">
                  <?php } ?>
                  <?php echo $dd['total_notif'] ?>
                <?php endforeach; ?>
              </span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">
              <?php
              foreach ($data['jumlah_notifikasi_reminder'] as $dd):
                ?>
                <?php echo $dd['total_notif'] ?>
              <?php endforeach; ?> Notifications</br> Request Cetak Dokumen
            </span>
            <div class="dropdown-divider"></div>
            <?php
            foreach ($data['notifikasi_reminder'] as $ddd):
              ?>
              <?php if ($role_id == '5' || $role_id == '3') {
                $id_req = $this->encryption->encrypt($ddd['id_req']);
                $id_reqq = strtr($id_req, array('/' => '=='));
                ?>
                <a href="<?= base_url('c_pengelolah_dokumen_dms/persetujuan_request/' . $id_reqq) ?>" class="dropdown-item">
                  <?php echo $ddd['nama_dokumen'] ?>
                  <span class="float-right text-muted text-sm">Nama Dokumen</span>
                </a>
              <?php } else {
                $id_req = $this->encryption->encrypt($ddd['id_req']);
                $id_reqq = strtr($id_req, array('/' => '=='));

                $id_doc = $this->encryption->encrypt($ddd['id_dokumen']);
                $id_docc = strtr($id_doc, array('/' => '=='));
                ?>
                <a href="<?= base_url('c_pengelolah_dokumen_dms/mark_notification_as_read/' . $id_reqq . '/' . $id_docc) ?>"
                  class="dropdown-item">
                  <?php echo $ddd['nama_dokumen'] ?>
                  <span class="float-right text-muted text-sm"> di
                    <?php echo $ddd['status_req'] ?>
                  </span>
                </a>
              <?php } ?>

            <?php endforeach; ?>
            <div class="dropdown-divider"></div>
            <a href="<?= base_url('c_pengelolah_dokumen_dms/list_req_doc') ?>" class="dropdown-item dropdown-footer">See
              All Notifications</a>

          </div>
        </li>
        <?php if ($this->session->userdata('username')) { ?>
          <li class="nav-item mt-2">
            <div> Selamat Datang <span style="font-weight: bold;">
                <?php echo $this->session->userdata('username') ?>
              </span><span style="font-weight: bold;">
                (
                <?php
                $data['master_bagian'] = $this->model_dokumen->tampil_data_bagian_kebun()->result();
                $id = $this->session->userdata('id');
                $bagian = $this->session->userdata('id_bagian');

                foreach ($data['master_bagian'] as $nh):
                  if ($nh->id_bagian == $bagian) {
                    echo $nh->nama_bagian;
                  }
                endforeach;
                ?>)
              </span></div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <div class="image">
                <img src="<?php echo base_url() ?>/profil/foto_profil.png" class="img-circle elevation-2" width="30"
                  height="30" alt="User Image">
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="min-width: 150px;">
              <a href="<?= base_url('c_master_user/edit_user_profil/' . $id) ?>" class="dropdown-item">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Edit Profil
                  </h3>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a href="<?= base_url('auth/logout') ?>" class="dropdown-item">
                <div class="media-body">
                  <h3 class="dropdown-item-title" style="color:red">
                    Logout
                  </h3>
                </div>
              </a>
              <div class="dropdown-divider"></div>
            </div>
          </li>
        <?php } else { ?>
          <li class="nav-item mt-2">
            <?php echo anchor('auth/login', 'Login'); ?>
          </li>
        <?php } ?>
      </ul>
    </nav>
    <!-- /.navbar -->