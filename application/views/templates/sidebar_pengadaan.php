<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url() ?>c_data_dokumen" class="brand-link" align="center">
        <span class="brand-text font-weight-light">JASINFO <b>PTPN XII</b></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <div>
            <div class="brand-link">
            <span class="brand-text font-weight-light">Menu  <span class="brand-text font-weight-light" style="font-size:12px;">Jasinfo Jampel</span></span>
            </div>
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
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
                    <a href="<?php echo base_url() ?>c_data_dokumen" class="nav-link <?php if($this->uri->segment(1)=="c_data_dokumen" || $this->uri->segment(2)=="detail_download_dokumen"){echo 'active';}?>">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Data Dokumen
                        </p>
                    </a>
                </li>
                <?php
                    $role_id = $this->session->userdata('role_id');
                    if ($role_id == 1) { ?>
                <li class="nav-item ">
                    <a href="<?php echo base_url() ?>c_master_jenis_dokumen" class="nav-link <?php if($this->uri->segment(1)=="c_master_jenis_dokumen"){echo 'active';}?>">
                        <i class="nav-icon fab fa-buffer"></i>
                        <p>
                            Master Jenis Dokumen
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="<?php echo base_url() ?>c_master_user/master_bagian" class="nav-link <?php if($this->uri->segment(1)=="c_master_user" && $this->uri->segment(2)=="master_bagian"){echo 'active';}?>">
                        <i class="nav-icon fab fa-buffer"></i>
                        <p>
                            Master Bagian
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="<?php echo base_url() ?>c_master_user" class="nav-link <?php if($this->uri->segment(1)=="c_master_user" && $this->uri->segment(2)==""){echo 'active';}?>">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                            Master User
                        </p>
                    </a>
                </li>
                <?php } ?>
                <!-- <li class="nav-item">
                    <a href="<?php echo base_url() ?>c_download_dokumen" class="nav-link ">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Download dokumen
                    </p>
                    </a>
                </li> -->
          
                <li class="nav-item <?php if($this->uri->segment(1)=="c_laporan"){echo 'menu-open';}?>">
                    <a href="#" class="nav-link <?php if($this->uri->segment(1)=="c_laporan"){echo 'active';}?>">
                        <i class="nav-icon fas fa-scroll"></i>
                        <p>
                            Laporan
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url() ?>c_laporan/laporan_dokumen" class="nav-link <?php if($this->uri->segment(2)=="laporan_dokumen"){echo 'active';}?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Dokumen</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url() ?>c_laporan/laporan_download" class="nav-link <?php if($this->uri->segment(2)=="laporan_download"){echo 'active';}?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Download</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            
            </div>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>