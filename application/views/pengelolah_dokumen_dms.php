<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Data Dokumen</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"> Manajemen DMS</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content mb-5">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-md-12 mb-3">
                                <div class="row">
                                    <?php
                                    $role = $this->session->userdata('role_id');
                                    $item_dok = $this->session->userdata('item_dok');
                                    ?>
                                    <?php
                                    if ($role == 5) { ?>
                                        <?php
                                        if ($item_dok == 'internal') { ?>
                                            <a href="<?php echo base_url() ?>c_pengelolah_dokumen_dms/form_data_dokumen_int"
                                                class="col-md-2"><button type="button"
                                                    class="btn btn-block btn-info btn-xs col-md-12">Tambah Dokumen
                                                    Internal</button></a>
                                            <?php
                                        } else if ($item_dok == 'eksternal') { ?>
                                                <a href="<?php echo base_url() ?>c_pengelolah_dokumen_dms/form_data_dokumen_eks"
                                                    class="col-md-2"><button type="button"
                                                        class="btn btn-block btn-info btn-xs col-md-12">Tambah Dokumen
                                                        Eksternal</button></a>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    }
                                    ?>

                                </div>

                            </div>
                            <section class="content">
                                <div class="row">
                                    <div class="col-12" id="accordion">
                                        <div class="card card-info card-outline">
                                            <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
                                                <div class="card-header">
                                                    <h2 class="card-title w-100">
                                                        Advanced Search Form
                                                        </h4>
                                                </div>
                                            </a>
                                            <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    <!-- Advanced Search Form -->
                                                    <form id="advanceSearchForm">
                                                        <!-- /.card-header -->
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="namaDokumenInput">Nama
                                                                            Dokumen</label>
                                                                        <input type="text" class="form-control"
                                                                            id="namaDokumenInput"
                                                                            name="namaDokumenInput">
                                                                    </div>
                                                                    <!-- /.form-group -->

                                                                    <div class="form-group">
                                                                        <label for="nomorDokumenInput">Nomor
                                                                            Dokumen</label>
                                                                        <input type="text" class="form-control"
                                                                            id="nomorDokumenInput"
                                                                            name="nomorDokumenInput">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="jenisDokumenInput">Jenis
                                                                            Dokumen</label>
                                                                        <select class="form-control"
                                                                            style="width: 100%;"
                                                                            name="jenisDokumenInput"
                                                                            id="jenisDokumenInput">
                                                                            <option value=""></option>
                                                                            <?php foreach ($jenis_dokumen as $jd): ?>
                                                                                <option
                                                                                    value="<?php echo $jd->nama_jenis_dokumen; ?>">
                                                                                    <?php echo $jd->nama_jenis_dokumen ?>
                                                                                </option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>

                                                                </div>
                                                                <!-- /.col -->
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="tentangInput">Tentang</label>
                                                                        <input type="text" class="form-control"
                                                                            id="tentangInput" name="tentangInput">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="min-date">Range Tanggal
                                                                            Awal:</label>
                                                                        <input type="date" id="min-date"
                                                                            class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="max-date">Tanggal Akhir:</label>
                                                                        <input type="date" id="max-date"
                                                                            class="form-control">
                                                                    </div>
                                                                </div>
                                                                <!-- /.col -->

                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="StatusInput">Status</label>
                                                                        <select class="form-control"
                                                                            style="width: 100%;" name="StatusInput"
                                                                            id="StatusInput">
                                                                            <option value="">
                                                                            </option>
                                                                            <option value="Dokumen Aktif">Dokumen Aktif
                                                                            </option>
                                                                            <option value="Dokumen Non-Aktif">Dokumen
                                                                                Non-Aktif
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <!-- /.form-group -->

                                                                    <div class="form-group">
                                                                        <label for="level_dokInput">Level
                                                                            Dokumen</label>
                                                                        <select class="form-control"
                                                                            style="width: 100%;" name="level_dokInput"
                                                                            id="level_dokInput">
                                                                            <option value="">
                                                                            </option>
                                                                            <option value="1">1
                                                                            </option>
                                                                            <option value="2">2
                                                                            </option>
                                                                            <option value="3">3
                                                                            </option>
                                                                            <option value="4">4
                                                                            </option>
                                                                            <option value="5">5
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <!-- /.form-group -->
                                                                </div>
                                                                <!-- /.col -->

                                                            </div>
                                                            <!-- /.row -->

                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <button class="btn btn-info" type="submit"
                                                                            id="advancedSearchBtn">
                                                                            Search</button>
                                                                        <button class="btn btn-info" type="button"
                                                                            id="resetBtn">Reset</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- /.row -->

                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <table id="table1" class="table table-bordered table-hover" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No urut</th>
                                        <th style="width: 15%">Nama Dokumen</th>
                                        <th>Nomor Dokumen</th>
                                        <th>Jenis Dokumen</th>
                                        <th>Tanggal Terbit</th>
                                        <th style="width: 20%">Tentang</th>
                                        <th>Akses</th>
                                        <th>Status Perubahan</th>
                                        <th>Item Dokumen</th>
                                        <th>Status</th>
                                        <th>Level Dokumen</th>
                                        <th>Revisi</th>
                                        <th>Metode Index</th>
                                        <th>Lama Simpan</th>
                                        <?php $role = $this->session->userdata('role_id'); ?>
                                        <?php
                                        if ($role == 5) { ?>
                                            <th>Action</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $username = $this->session->userdata('username');
                                    $bagian = $this->session->userdata('id_bagian');
                                    $nomor = 0;
                                    foreach ($data_dokumen as $row):
                                        $nomor++; // Increment nomor urut pada setiap iterasi
                                        ?>
                                        <tr>
                                            <td>
                                                <?= $nomor ?>
                                            </td>
                                            <td><a href="<?= base_url() ?>c_pengelolah_dokumen_dms/detail_dum/<?= $row['encrypted_id'] ?>"
                                                    style="color:orange;font-weight:bold;">
                                                    <?= $row['nama_dokumen'] ?>
                                                </a>
                                            </td>
                                            <td>
                                                <?= $row['no_dokumen'] ?>
                                            </td>
                                            <td>
                                                <?= $row['nama_jenis_dokumen'] ?>
                                            </td>
                                            <td>
                                                <?php $conv_tanggal = $row['tgl_terbit'];
                                                // $date = date('d M Y', strtotime($conv_tanggal));
                                                echo $conv_tanggal; ?>
                                            </td>
                                            <td style=" word-wrap: break-word;max-width: 100px;">
                                                <?= $row['tentang'] ?>
                                            </td>

                                            <td>
                                                <?php $str = $row['akses_for'];
                                                $str2 = explode(",", $str);
                                                $str1 = explode(",", $str);
                                                $jumlahdata = count($str1);

                                                foreach ($data_bagian as $databag): ?>
                                                    <?php
                                                    if ($jumlahdata > 3) {
                                                        for ($i = 0; $i < 3; $i++) {
                                                            $no = $i + 1;
                                                            if ($databag->kode == $str1[$i]) {
                                                                if ($jumlahdata == 1) {
                                                                    echo $databag->nama_bagian;
                                                                } else {
                                                                    if ($str1[$i] == $str1[2]) {
                                                                        echo $no . '. ' . $databag->nama_bagian . '...<br>';
                                                                    } else {
                                                                        echo $no . '. ' . $databag->nama_bagian . '<br>';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        for ($i = 0; $i < $jumlahdata; $i++) {
                                                            $no = $i + 1;
                                                            if ($databag->kode == $str1[$i]) {
                                                                if ($jumlahdata == 1) {
                                                                    echo $databag->nama_bagian;
                                                                } else {
                                                                    echo $no . '. ' . $databag->nama_bagian . '<br>';
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                <?php endforeach; ?>
                                            </td>

                                            <td>
                                                <?php
                                                if ($item_dok == 'internal') {
                                                    if ($role == 5 || $role == 6) {
                                                        $dataFound = false; // Menyimpan informasi apakah data ditemukan
                                            
                                                        foreach ($query_dokstatus as $databag) {
                                                            if ($row['id_dokumen'] == $databag['id_dokumen']) {
                                                                if ($databag['status'] != 'Baru') {
                                                                    $id_dkmm = $this->encryption->encrypt($databag['id_dokumen_status']);
                                                                    $id_dkm = strtr($id_dkmm, array('/' => '=='));
                                                                    echo $databag['status'] . ' : '; ?>
                                                                    <a href="<?php echo base_url(); ?>c_pengelolah_dokumen_dms/detail_dum/<?= $id_dkm ?>"
                                                                        style="color:orange;font-weight:bold;">
                                                                        <?php
                                                                        $jumlahdata1 = count($dokumen_master);
                                                                        for ($i = 0; $i < $jumlahdata1; $i++) {
                                                                            if ($databag['id_dokumen_status'] == $dokumen_master[$i]['id_dokumen']) {
                                                                                echo $dokumen_master[$i]['nama_dokumen'] . '<br>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </a>
                                                                    <?php
                                                                    $dataFound = true; // Data yang memenuhi kondisi ditemukan
                                                                }
                                                            }
                                                        }

                                                        if (!$dataFound) {
                                                            echo 'Dokumen Baru';
                                                        }
                                                    }
                                                    if ($role == 4 || $role == 3 || $role == 2 || $role == 1) {
                                                        foreach ($query_dok_reg as $dokrek):
                                                            if ($row['id_dokumen'] == $dokrek['id_dokumen']) {
                                                                if ($dokrek['status'] == 'Baru') {
                                                                    echo 'DOKUMEN BARU';
                                                                } else {
                                                                    echo $dokrek['status'] . ' : '; ?>
                                                                    <?php
                                                                    $jumlahdata1 = count($dokumen_master);
                                                                    for ($i = 0; $i < $jumlahdata1; $i++) {
                                                                        if ($dokrek['id_dokumen_status'] == $dokumen_master[$i]['id_dokumen']) {
                                                                            echo $dokumen_master[$i]['nama_dokumen'] . '<br>';
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        endforeach;
                                                    }
                                                } else if ($item_dok == 'eksternal') {
                                                    if ($role == 5 || $role == 6) {
                                                        $dataFound = false; // Menyimpan informasi apakah data ditemukan
                                                        foreach ($query_dokstatus as $databag) {
                                                            if ($row['id_dokumen'] == $databag['id_dokumen']) {
                                                                if ($databag['status'] != 'Baru') {
                                                                    $id_dkmm = $this->encryption->encrypt($databag['id_dokumen_status']);
                                                                    $id_dkm = strtr($id_dkmm, array('/' => '=='));
                                                                    echo $databag['status'] . ' : '; ?>
                                                                        <a href="<?php echo base_url(); ?>c_pengelolah_dokumen_dms/detail_dum/<?= $id_dkm ?>"
                                                                            style="color:orange;font-weight:bold;">
                                                                            <?php
                                                                            $jumlahdata1 = count($dokumen_master);
                                                                            for ($i = 0; $i < $jumlahdata1; $i++) {
                                                                                if ($databag['id_dokumen_status'] == $dokumen_master[$i]['id_dokumen']) {
                                                                                    echo $dokumen_master[$i]['nama_dokumen'] . '<br>';
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </a>
                                                                        <?php
                                                                        $dataFound = true; // Data yang memenuhi kondisi ditemukan
                                                                }
                                                            }
                                                        }

                                                        if (!$dataFound) {
                                                            echo 'Dokumen Baru';
                                                        }
                                                    }
                                                    if ($role == 4 || $role == 3 || $role == 2 || $role == 1) {
                                                        foreach ($query_dok_reg as $dokrek):
                                                            if ($row['id_dokumen'] == $dokrek['id_dokumen']) {
                                                                if ($dokrek['status'] == 'Baru') {
                                                                    echo 'DOKUMEN BARU';
                                                                } else {
                                                                    echo $dokrek['status'] . ' : '; ?>
                                                                        <?php
                                                                        $jumlahdata1 = count($dokumen_master);
                                                                        for ($i = 0; $i < $jumlahdata1; $i++) {
                                                                            if ($dokrek['id_dokumen_status'] == $dokumen_master[$i]['id_dokumen']) {
                                                                                echo $dokumen_master[$i]['nama_dokumen'] . '<br>';
                                                                            }
                                                                        }
                                                                }
                                                            }
                                                        endforeach;
                                                    }
                                                }
                                                ?>
                                                </a>
                                            </td>

                                            <td style=" word-wrap: break-word;max-width: 100px;">
                                                <?= $row['item_dokumen'] ?>
                                            </td>
                                            <td style=" word-wrap: break-word;max-width: 100px;">
                                                <?= $row['status_dok'] ?>
                                            </td>
                                            <td>
                                                <?= $row['id_level_dok'] ?>
                                            </td>
                                            <td>
                                                <?= $row['status_rev'] ?>
                                            </td>
                                            <td>
                                                <?= $row['metode_indeks'] ?>
                                            </td>
                                            <td>
                                                <?php
                                                $lama_simpan_awal = $row['lama_simpan_awal'];
                                                $lama_simpan_akhir = $row['lama_simpan_akhir'];

                                                if ($lama_simpan_awal === '0000-00-00' || $lama_simpan_akhir === '0000-00-00' || empty($lama_simpan_awal) || empty($lama_simpan_akhir)) {
                                                    echo "Tanpa Batasan Waktu";
                                                } else {
                                                    $awal = new DateTime($lama_simpan_awal);
                                                    $akhir = new DateTime($lama_simpan_akhir);
                                                    $diff = $akhir->diff($awal);
                                                    echo $hasil = $diff->y . " tahun " . $diff->m . " bulan " . $diff->d . " hari";
                                                }
                                                ?>
                                            </td>
                                            <?php $role = $this->session->userdata('role_id'); ?>
                                            <?php
                                            if ($role == 5) { ?>
                                                <td>

                                                    <?php
                                                    if ($item_dok == 'internal') { ?>
                                                        <?php echo anchor('c_pengelolah_dokumen_dms/edit_data_dokumen_int/' . $row['encrypted_id'], '<button type="button" class="btn btn-primary btn-sm mt-2"  title="Edit"><i class="far fa-edit"></i></button>') ?>
                                                        <?php
                                                    } else if ($item_dok == 'eksternal') { ?>
                                                        <?php echo anchor('c_pengelolah_dokumen_dms/edit_data_dokumen_eks/' . $row['encrypted_id'], '<button type="button" class="btn btn-primary btn-sm mt-2"  title="Edit"><i class="far fa-edit"></i></button>') ?>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                            <?php } ?>
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

<?php if ($this->session->flashdata('something1')) { ?>
    <script>
        $(document).ready(function () {
            swal("Data berhasil diubah", "", "success");
        });
    </script>
<?php } ?>

<?php if ($this->session->flashdata('something0')) { ?>
    <script>
        $(document).ready(function () {
            swal("Data berhasil diubah", "", "success");
        });
    </script>
<?php } ?>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url() . 'c_download_dokumen/generatekodeunikjdih' ?>" method="post">
                    <div class="form-group">
                        <input type="hidden" id="myText" name="id" value="">
                        <label for="message-text" class="col-form-label">Keperluan:</label>
                        <textarea class="form-control" id="message-text" name="keterangan"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Dapatkan Kode Unik</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url() . 'c_download_dokumen/generatekodeunikjdih' ?>" method="post">
                    <div class="form-group">
                        <input type="hidden" id="myText" name="id" value="">
                        <label for="message-text" class="col-form-label">Keperluan:</label>
                        <textarea class="form-control" id="message-text" name="keterangan"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Dapatkan Kode Unik</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    var data = $('.dts1 span').text();
    // alert(data);
    if (data == "") {
        $(".dts1").text("Dokumen baru");
    }
    function reply_click(clicked_id) {
        document.getElementById("myText").value = clicked_id;
    }
</script>


<!-- <script>
    $(function () {
        $('#table1').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

    })
</script> -->

<script type="text/javascript">
    // Periksa flashdata yang mengindikasikan status operasi hapus
    var deleteStatus = "<?php echo $this->session->flashdata('delete_status'); ?>";

    // Fungsi untuk menampilkan switch alert berdasarkan flashdata
    function showSwitchAlert() {
        switch (deleteStatus) {
            case 'success':
                alert("Data berhasil dihapus!");
                break;
            case 'failed':
                alert("Data tidak ditemukan atau gagal dihapus.");
                break;
        }
    }

    // Panggil fungsi saat halaman dimuat
    window.onload = showSwitchAlert;
</script>

<?php if ($this->session->flashdata('success_message')) { ?>
    <script>
        $(document).ready(function () {
            swal("Dokumen Berhasil diupload", "", "success");
        });
    </script>
<?php } ?>

<?php if ($this->session->flashdata('success_edit_message')) { ?>
    <script>
        $(document).ready(function () {
            swal("Data Berhasil diedit", "", "info");
        });
    </script>
<?php } ?>

<?php if ($this->session->flashdata('success_edit_message1')) { ?>
    <script>
        $(document).ready(function () {
            swal("Data Berhasil diedit", "", "info");
        });
    </script>
<?php } ?>

<!-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        const advanceSearchForm = document.getElementById("advanceSearchForm");
        const advancedSearchBtn = document.getElementById("advancedSearchBtn");

        advanceSearchForm.addEventListener("submit", function (event) {
            event.preventDefault();

            // Get values from input fields and convert them to lowercase
            const namaDokumen = document.getElementById("namaDokumenInput").value.toLowerCase();
            const nomorDokumen = document.getElementById("nomorDokumenInput").value.toLowerCase();
            const jenisDokumen = document.getElementById("jenisDokumenInput").value.toLowerCase();
            const tentang = document.getElementById("tentangInput").value.toLowerCase();
            const status = document.getElementById("StatusInput").value.toLowerCase();
            const itemDokumen = document.getElementById("itemDokumenInput").value.toLowerCase();

            // Perform advanced search based on the input values
            const tableRows = document.querySelectorAll("#table1 tbody tr");

            tableRows.forEach((row) => {
                const namaDokumenCell = row.querySelector("td:nth-child(1)").textContent.toLowerCase();
                const nomorDokumenCell = row.querySelector("td:nth-child(2)").textContent.toLowerCase();
                const jenisDokumenCell = row.querySelector("td:nth-child(3)").textContent.toLowerCase();
                const tentangCell = row.querySelector("td:nth-child(5)").textContent.toLowerCase();
                const statusCell = row.querySelector("td:nth-child(9)").textContent.toLowerCase();
                const itemDokumengCell = row.querySelector("td:nth-child(8)").textContent.toLowerCase();

                // Sample filtering logic (case-insensitive)
                if (
                    namaDokumenCell.includes(namaDokumen) &&
                    nomorDokumenCell.includes(nomorDokumen) &&
                    jenisDokumenCell.includes(jenisDokumen) &&
                    tentangCell.includes(tentang) &&
                    statusCell.includes(status) &&
                    itemDokumengCell.includes(itemDokumen)
                ) {
                    row.style.display = "table-row"; // Show matching rows
                } else {
                    row.style.display = "none"; // Hide non-matching rows
                }
            });
        });

        // Handle Reset
        const resetBtn = document.getElementById("resetBtn");
        resetBtn.addEventListener("click", function () {
            advanceSearchForm.reset(); // Reset the form fields
            const tableRows = document.querySelectorAll("#table1 tbody tr");
            tableRows.forEach((row) => (row.style.display = "table-row")); // Show all rows after resetting
        });
    });
</script> -->

<script>
    $(document).ready(function () {
        const table = $('#table1').DataTable({
            "responsive": true,
            "ordering": "descending",
        });

        const advanceSearchForm = document.getElementById("advanceSearchForm");
        const resetBtn = document.getElementById("resetBtn");

        advanceSearchForm.addEventListener("submit", function (event) {
            event.preventDefault();

            const namaDokumen = document.getElementById("namaDokumenInput").value;
            const nomorDokumen = document.getElementById("nomorDokumenInput").value;
            const jenisDokumen = document.getElementById("jenisDokumenInput").value;
            const tentang = document.getElementById("tentangInput").value;
            const status = document.getElementById("StatusInput").value;
            const level_dok = document.getElementById("level_dokInput").value;

            table
                .columns(1)
                .search(namaDokumen)
                .columns(2)
                .search(nomorDokumen)
                .columns(3)
                .search(jenisDokumen)
                .columns(5)
                .search(tentang)
                .columns(9)
                .search(status, true, false)
                .columns(10)
                .search(level_dok, true, false)
                .columns(8)
                .draw();
        });

        resetBtn.addEventListener("click", function () {
            advanceSearchForm.reset();
            table.search("").columns().search("").draw();
        });
    });
</script>



<script type="text/javascript">
    $(document).ready(function () {
        // Inisialisasi DataTables
        var dataTable = $('#table1').DataTable();

        // Fungsi untuk mereset filter
        function resetFilter() {
            $('#min-date').val('');
            $('#max-date').val('');
            dataTable.draw();
        }

        // Tambahkan filter Date Range untuk kolom tanggal
        $('#min-date, #max-date').on('change', function () {
            dataTable.draw();
        });

        // Definisikan custom filter function untuk kolom tanggal
        $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                var minDate = $('#min-date').val();
                var maxDate = $('#max-date').val();
                var currentDate = data[4]; // Kolom ke-5 merupakan kolom tanggal

                if ((minDate === '' || currentDate >= minDate) && (maxDate === '' || currentDate <= maxDate)) {
                    return true;
                }

                return false;
            }
        );

        // Tombol reset untuk menghapus filter
        $('#resetBtn').on('click', function () {
            resetFilter();
        });
    });
</script>