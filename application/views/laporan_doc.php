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

                            <section class="content">
                                <?php
                                // mengecek data hasil submit dari form filter
                                // jika tidak ada data yang dikirim (tombol tampilkan belum diklik) 
                                if (!isset($_POST['tampil'])) { ?>
                                    <div class="page-inner mt--5">
                                        <div class="card">
                                            <div class="card-header">
                                                <!-- judul form -->
                                                <div class="card-title">Filter Data Dokumen</div>
                                            </div>
                                            <!-- form filter data -->
                                            <div class="card-body">
                                                <form action="?module=laporan_dokumen" method="post"
                                                    class="needs-validation" novalidate>
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>Jenis Dokumen </label>
                                                                <select id="jenis_dokumen" name="jenis_dokumen"
                                                                    class="form-control" autocomplete="off">
                                                                    <option selected disabled value="">-- Pilih --</option>
                                                                    <?php foreach ($jenis_dokumen as $jd): ?>
                                                                        <option value="<?php echo $jd->id_jenis_dokumen; ?>">
                                                                            <?php echo $jd->nama_jenis_dokumen ?>
                                                                        </option>
                                                                    <?php endforeach; ?>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>Item Dokumen </label>
                                                                <select id="item_dokumen" name="item_dokumen"
                                                                    class="form-control" autocomplete="off">
                                                                    <option selected disabled value="">-- Pilih --</option>
                                                                    <option value='Dokumen Internal'>
                                                                        Dokumen Internal
                                                                    </option>
                                                                    <option value='Dokumen Eksternal'>
                                                                        Dokumen Eksternal
                                                                    </option>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>Status Dokumen</label>
                                                                <select id="status_dok" name="status_dok"
                                                                    class="form-control" autocomplete="off" required>
                                                                    <option selected disabled value="">-- Pilih --</option>
                                                                    <option value='Dokumen Aktif'>
                                                                        Dokumen Aktif
                                                                    </option>
                                                                    <option value='Dokumen Non-Aktif'>
                                                                        Dokumen Non-Aktif
                                                                    </option>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>Level Dokumen</label>
                                                                <select id="level_dok" name="level_dok" class="form-control"
                                                                    autocomplete="off" required>
                                                                    <option selected disabled value="">-- Pilih --</option>
                                                                    <option value='1'>
                                                                        1
                                                                    </option>
                                                                    <option value='2'>
                                                                        2
                                                                    </option>
                                                                    <option value='3'>
                                                                        3
                                                                    </option>
                                                                    <option value='4'>
                                                                        4
                                                                    </option>
                                                                    <option value='5'>
                                                                        5
                                                                    </option>

                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>Media Simpan Dokumen</label>
                                                                <select id="media_simpan" name="media_simpan"
                                                                    class="form-control" autocomplete="off" required>
                                                                    <option selected disabled value="">-- Pilih --</option>
                                                                    <?php foreach ($media_spmn as $ms): ?>
                                                                        <option value="<?php echo $ms->id_media_simpan_dok; ?>">
                                                                            <?php echo $ms->media_simpan ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>Range Tanggal Awal</label>
                                                                <input type="date" class="form-control" id="tanggal_awal"
                                                                    name="tanggal_awal">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>Range Tanggal Akhir</label>
                                                                <input type="date" class="form-control" id="tanggal_akhir"
                                                                    name="tanggal_akhir">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="form-group pt-1">
                                                                <!-- tombol tampil data -->
                                                                <input type="submit" name="tampil" value="Tampilkan"
                                                                    class="btn btn-secondary btn-round btn-block mt-4">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                // jika ada data yang dikirim (tombol tampilkan diklik)
                                else {
                                    // // ambil data hasil submit dari form filter
                                    // $jenis_dokumen = $_POST['jenis_dokumen'];
                                    // $tanggal_awal = $_POST['tanggal_awal'];
                                    // $tanggal_akhir = $_POST['tanggal_akhir'];
                                    // $data_filter_doc = mysqli_query($mysqli, "SELECT id_barang, nama_barang FROM tbl_barang WHERE id_barang='" . $stok . "'")
                                    //     or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                                    // $datastok = mysqli_fetch_array($stokok);
                                
                                    ?>
                                    <div class="page-inner mt--5">
                                        <div class="card">
                                            <div class="card-header">
                                                <!-- judul form -->
                                                <div class="card-title">Filter Data Dokumen</div>
                                            </div>
                                            <!-- form filter data -->
                                            <div class="card-body">
                                                <form action="?module=laporan_dokumen" method="post"
                                                    class="needs-validation" novalidate>
                                                    <div class="row">
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>Jenis Dokumen </label>
                                                                <select id="jenis_dokumen" name="jenis_dokumen"
                                                                    class="form-control" autocomplete="off">
                                                                    <option value="" selected disabled>-- Pilih --</option>
                                                                    <?php foreach ($jenis_dokumen as $jd): ?>
                                                                        <option value="<?php echo $jd->id_jenis_dokumen; ?>"
                                                                            <?php if (isset($_POST['jenis_dokumen']) && $jd->id_jenis_dokumen == $_POST['jenis_dokumen'])
                                                                                echo 'selected'; ?>>
                                                                            <?php echo $jd->nama_jenis_dokumen ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>

                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>Item Dokumen </label>
                                                                <select id="item_dokumen" name="item_dokumen" class="form-control" autocomplete="off">
    <option value="" selected disabled>-- Pilih --</option>
    <option value='Dokumen Internal'
        <?php if (isset($_POST['item_dokumen']) && $_POST['item_dokumen'] === 'Dokumen Internal') echo 'selected'; ?>>
        Dokumen Internal
    </option>
    <option value='Dokumen Eksternal'
        <?php if (isset($_POST['item_dokumen']) && $_POST['item_dokumen'] === 'Dokumen Eksternal') echo 'selected'; ?>>
        Dokumen Eksternal
    </option>
</select>

                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>Status Dokumen</label>
                                                                <select id="status_dok" name="status_dok" class="form-control" autocomplete="off">
    <option value="" selected disabled>-- Pilih --</option>
    <option value='Dokumen Aktif'
        <?php if (isset($_POST['status_dok']) && $_POST['status_dok'] === 'Dokumen Aktif') echo 'selected'; ?>>
        Dokumen Aktif
    </option>
    <option value='Dokumen Non-Aktif'
        <?php if (isset($_POST['status_dok']) && $_POST['status_dok'] === 'Dokumen Non-Aktif') echo 'selected'; ?>>
        Dokumen Non-Aktif
    </option>
</select>

                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>Level Dokumen</label>
                                                                <select id="level_dok" name="level_dok" class="form-control" autocomplete="off">
    <option value="" selected disabled>-- Pilih --</option>
    <option value='1' <?php if (isset($_POST['level_dok']) && $_POST['level_dok'] === '1') echo 'selected'; ?>>1</option>
    <option value='2' <?php if (isset($_POST['level_dok']) && $_POST['level_dok'] === '2') echo 'selected'; ?>>2</option>
    <option value='3' <?php if (isset($_POST['level_dok']) && $_POST['level_dok'] === '3') echo 'selected'; ?>>3</option>
    <option value='4' <?php if (isset($_POST['level_dok']) && $_POST['level_dok'] === '4') echo 'selected'; ?>>4</option>
    <option value='5' <?php if (isset($_POST['level_dok']) && $_POST['level_dok'] === '5') echo 'selected'; ?>>5</option>
</select>

                                                            </div>
                                                        </div>


                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>Media Simpan Dokumen</label>
                                                                <select id="media_simpan" name="media_simpan" class="form-control" autocomplete="off">
    <option value="" selected disabled>-- Pilih --</option>
    <?php foreach ($media_spmn as $ms): ?>
        <option value="<?php echo $ms->id_media_simpan_dok; ?>"
            <?php if (isset($_POST['media_simpan']) && $_POST['media_simpan'] === $ms->id_media_simpan_dok) echo 'selected'; ?>>
            <?php echo $ms->media_simpan ?>
        </option>
    <?php endforeach; ?>
</select>

                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>Range Tanggal Awal</label>
                                                                <input type="date" class="form-control" id="tanggal_awal"
                                                                    name="tanggal_awal">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>Range Tanggal Akhir</label>
                                                                <input type="date" class="form-control" id="tanggal_akhir"
                                                                    name="tanggal_akhir">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="form-group pt-1">
                                                                <!-- tombol tampil data -->
                                                                <input type="submit" name="tampil" value="Tampilkan"
                                                                    class="btn btn-secondary btn-round btn-block mt-4">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="form-group pt-1">
                                                                <!-- tombol tampil data -->
                                                                <a href="<?php echo base_url() ?>c_laporan_doc"><button type="button"
                                                    class="btn btn-info btn-round btn-block mt-4">Reset Filter</button></a>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <!-- Tampilkan hasil data dalam tabel -->
                                            <div class="card-header">
                                                <div class="card-title"><i class="fas fa-file-alt mr-2"></i> Laporan Dokumen
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="basic-datatables"
                                                        class="display table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">No.</th>
                                                                <th class="text-center">Nomor Dokumen</th>
                                                                <th class="text-center">Nama Dokumen</th>
                                                                <th class="text-center">Item Dokumen</th>
                                                                <th class="text-center">Jenis Dokumen</th>
                                                                <th class="text-center">Tanggal Terbit</th>
                                                                <th class="text-center">Tentang</th>
                                                                <th class="text-center">Status</th>
                                                                <th class="text-center">Level Dokumen</th>
                                                                <th class="text-center">Revisi</th>
                                                                <th class="text-center">Metode Index</th>
                                                                <th class="text-center">Lama Simpan</th>
                                                                <th class="text-center">Media Simpan</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (isset($results) && !empty($results)) {
                                                                $no = 1;
                                                                foreach ($results as $row) { ?>
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            <?php echo $no++; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $row->no_dokumen; ?>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <?php echo $row->nama_dokumen; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $row->item_dokumen; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $row->nama_jenis_dokumen; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $row->tgl_terbit; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $row->tentang; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $row->status_dok; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $row->id_level_dok; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $row->status_rev; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $row->metode_indeks; ?>
                                                                        </td>
                                                                        <td>
                                                                        <?php
                        $lama_simpan_awal = $row->lama_simpan_awal;
                        $lama_simpan_akhir = $row->lama_simpan_akhir ;

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
                                                                        <td>
                                                                            <?php echo $row->media_simpan; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php }
                                                            } else { ?>
                                                                <tr>
                                                                    <td colspan="10" class="text-center">Tidak ada data yang
                                                                        cocok.</td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } ?>
                            </section>
                            <!-- /.content -->
                        </div>


                        <!-- Tambahkan kode JavaScript ini di bawah bagian tampilan tabel -->
                        <script>
                            $(document).ready(function () {
                                var table = $('#basic-datatables').DataTable({
                                    dom: 'Bfrtip',
                                    searching: false,
                                    buttons: [
                                        {
                                            extend: 'excel',
                                            className: 'btn btn-success',
                                            text: '<i class="fa fa-file-excel mr-2"></i> Export Excel', // Menambahkan ikon dan teks pada tombol Excel
                                        },
                                        {
                                            extend: 'pdf',
                                            className: 'btn btn-warning',
                                            title: 'Laporan Dokumen',
                                            filename: 'laporan_dokumen',
                                            customize: function (doc) {
                                                // Mengatur orientasi dan ukuran halaman
                                                doc.pageOrientation = 'landscape';
                                                doc.pageSize = 'Legal'; // Mengatur ukuran halaman menjadi A4

                                                // doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                                            },
                                            text: '<i class="fa fa-file-pdf mr-2"></i> Cetak PDF', // Menambahkan ikon dan teks pada tombol PDF
                                        }
                                    ],
                                    // Konfigurasi lainnya
                                    
                                });
                            });

                        </script>