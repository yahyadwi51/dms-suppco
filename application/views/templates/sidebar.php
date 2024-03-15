<?php
$bagian = $this->session->userdata('bagian');
$allkebun = $this->db->query("SELECT id_bagian FROM `tb_master_bagian` WHERE id_bagian BETWEEN 18 AND 51")->result();
foreach ($allkebun as $all_kebun) {
    if ($all_kebun->id_bagian) {
        $data_allkebun[] = $all_kebun->id_bagian;
    }
}

// print_r($data_allkebun);
// die();
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url() ?>" class="brand-link" align="center">
        <span class="brand-text font-weight-light">DMS <b>SuppCo</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <!-- DMS SUPPCO POKOKEEE -->
            <div>
                <div class="brand-link">
                    <span class="brand-text font-weight-light">Dashboard</span>
                </div>
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a href="<?php echo base_url() ?>c_dashboard" class="nav-link <?php if ($this->uri->segment(1) == "c_dashboard") {
                               echo 'active';
                           } ?>">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                </ul>

                <?php
                $role_id = $this->session->userdata('role_id');
                if ($role_id == 6 || $role_id == 5 || $role_id == 4) { ?>
                    <div class="brand-link">
                        <span class="brand-text font-weight-light">Master Data <span class="brand-text font-weight-light"
                                style="font-size:12px;">DMS SuppCo</span></span>
                    </div>
                <?php } ?>

                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <?php
                    $role_id = $this->session->userdata('role_id');
                    if ($role_id == 5) { ?>
                        <li class="nav-item">
                            <a href="<?php echo base_url() ?>c_media_simpan" class="nav-link <?php if ($this->uri->segment(1) == "c_media_simpan") {
                                   echo 'active';
                               } ?>">
                                <i class="nav-icon fab fa-buffer"></i>
                                <p>
                                    Master Media Simpan
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php
                    $role_id = $this->session->userdata('role_id');
                    if ($role_id == 5) { ?>
                        <li class="nav-item">
                            <a href="<?php echo base_url() ?>c_jenis_pengelolah_dokumen" class="nav-link <?php if ($this->uri->segment(1) == "c_jenis_pengelolah_dokumen") {
                                   echo 'active';
                               } ?>">
                                <i class="nav-icon fab fa-buffer"></i>
                                <p>
                                    Master Jenis Dokumen
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <!-- <?php
                    $role_id = $this->session->userdata('role_id');
                    if ($role_id == 6) { ?>
                        <li class="nav-item">
                            <a href="<?php echo base_url() ?>c_master_role" class="nav-link <?php if ($this->uri->segment(1) == "c_master_role") {
                                   echo 'active';
                               } ?>">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>
                                    Detail Role User
                                </p>
                            </a>
                        </li>
                    <?php } ?> -->
                    <?php
                    $role_id = $this->session->userdata('role_id');
                    if ($role_id == 6) { ?>
                        <li class="nav-item">
                            <a href="<?php echo base_url() ?>c_master_region" class="nav-link <?php if ($this->uri->segment(1) == "c_master_region") {
                                   echo 'active';
                               } ?>">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>
                                    Master Region
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php
                    $role_id = $this->session->userdata('role_id');
                    if ($role_id == 6 || $role_id == 4) { ?>
                        <li class="nav-item">
                            <a href="<?php echo base_url() ?>c_master_user/master_bagianDMS" class="nav-link <?php if ($this->uri->segment(1) == "c_master_user") {
                                   echo 'active';
                               } ?>">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>
                                    Master Bagian / Divisi
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php
                    $role_id = $this->session->userdata('role_id');
                    if ($role_id == 6 || $role_id == 4) { ?>
                        <li class="nav-item">
                            <a href="<?php echo base_url() ?>c_master_subbagian" class="nav-link <?php if ($this->uri->segment(1) == "c_master_subbagian") {
                                   echo 'active';
                               } ?>">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>
                                    Master Sub-Bagian
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                    <?php
                    $role_id = $this->session->userdata('role_id');
                    if ($role_id == 6 || $role_id == 4) { ?>
                        <li class="nav-item">
                            <a href="<?php echo base_url() ?>c_master_userdms" class="nav-link <?php if ($this->uri->segment(1) == "c_master_userdms") {
                                   echo 'active';
                               } ?>">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>
                                    Master User DMS
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <?php
                $role_id = $this->session->userdata('role_id');
                if ($role_id == 6 || $role_id == 5 || $role_id == 4 || $role_id == 3 || $role_id == 2 || $role_id == 1) { ?>
                    <div class="brand-link">
                        <span class="brand-text font-weight-light">Doc Management</span>
                    </div>
                <?php } ?>
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">

                    <?php
                        $role_id = $this->session->userdata('role_id');
                        if ($role_id == 6 || $role_id == 5 || $role_id == 4 || $role_id == 3 || $role_id == 2 || $role_id == 1) {
                            ?>
                            
                            <li class="nav-item ">
                                <a href="<?php echo base_url() ?>c_pengelolah_dokumen_dms/doc_internal" class="nav-link <?php if($this->uri->segment(1) == "c_pengelolah_dokumen_dms" && $this->uri->segment(2)=="doc_internal"){echo 'active';}?>">
                                    <i class="nav-icon fas fa-scroll"></i>
                                    <p>
                                        Dokumen Internal
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="<?php echo base_url() ?>c_pengelolah_dokumen_dms/doc_external" class="nav-link <?php if($this->uri->segment(1) == "c_pengelolah_dokumen_dms" && $this->uri->segment(2)=="doc_external"){echo 'active';}?>">
                                    <i class="nav-icon fas fa-scroll"></i>
                                    <p>
                                        Dokumen Eksternal
                                    </p>
                                </a>
                            </li>

                        <?php } ?>
                    <?php
                    $role_id = $this->session->userdata('role_id');
                    if ($role_id == 6 || $role_id == 5 || $role_id == 4 || $role_id == 3 || $role_id == 2 || $role_id == 1) { ?>
                        <li class="nav-item ">
                            <a href="<?php echo base_url() ?>c_pengelolah_dokumen_dms/list_req_doc" class="nav-link <?php if ($this->uri->segment(1) == "c_pengelolah_dokumen_dms" && $this->uri->segment(2) == "list_req_doc") {
                                   echo 'active';
                               } ?>">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>
                                    Master Request Dokumen
                                </p>
                            </a>
                        </li>
                    <?php } ?>

                    <?php
                    $role_id = $this->session->userdata('role_id');
                    if ($role_id == 6 || $role_id == 5 || $role_id == 4 || $role_id == 3 || $role_id == 2 || $role_id == 1) { ?>
                        <li class="nav-item">
                            <a href="<?php echo base_url() ?>c_log_activity" class="nav-link <?php if ($this->uri->segment(1) == "c_log_activity") {
                                   echo 'active';
                               } ?>">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Log Activity
                                </p>
                            </a>
                        </li>
                    <?php } ?>

                    <?php
                    $role_id = $this->session->userdata('role_id');
                    if ($role_id == 5 || $role_id == 3) { ?>
                        <li class="nav-item">
                            <a href="<?php echo base_url() ?>c_laporan_doc" class="nav-link <?php if ($this->uri->segment(1) == "c_laporan_doc") {
                                   echo 'active';
                               } ?>">
                                <i class="nav-icon fas fa-scroll"></i>
                                <p>
                                    Laporan
                                </p>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
