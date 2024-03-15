<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Data Dokumen Hukum</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
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
                            <div class="col-md-12 mb-3">
                                <div class="row">
                                    <div class="form-group col-md-12 ">
                                        <label>Filter Berdasarkan:</label>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <input type="text" class="form-control float-right" value=""
                                                    id="reservation">
                                            </div>
                                        </div>
                                        <!-- /.input group -->
                                    </div><br>
                                    <div class="col-md-12">
                                        <div class="form-group col-md-4">
                                            <select class="select2 " multiple="multiple"
                                                data-placeholder="Jenis Dokumen" style="width: 100%;"
                                                id="jenis_dokumen">
                                                <?php foreach ($jenis_dokumen as $jd) : ?>
                                                <option value="<?php echo $jd->id_jenis_dokumen; ?>">
                                                    <?php echo $jd->nama_jenis_dokumen ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group col-md-4">
                                            <select class="select2 " multiple="multiple"
                                                data-placeholder="Bagian Pemilik" style="width: 100%;" id="bag_pemilik">
                                                <?php foreach ($user as $usr) : ?>
                                                <option value="<?php echo $usr->id; ?>">
                                                    <?php echo $usr->username ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <form action="<?php echo base_url() ?>c_laporan_hukum/printpdf/" class="mb-"
                                    method="post" style="display: inline;" title="Cetak PDF">
                                    <input type="hidden" name="ctk_reservasion" value="">
                                    <input type="hidden" name="ctk_jenis_dokumen" value="">
                                    <input type="hidden" name="ctk_bag_pemilik" value="">
                                    <button type="submit" class="btn  btn-danger">PDF</button>
                                </form>
                                <form action="<?php echo base_url() ?>c_laporan_hukum/printexcel/" method="post"
                                    style="display: inline;" title="Cetak Excel">
                                    <input type="hidden" name="ctk_reservasion" value="">
                                    <input type="hidden" name="ctk_jenis_dokumen" value="">
                                    <input type="hidden" name="ctk_bag_pemilik" value="">
                                    <button type="submit" class="btn  btn-success">Excel</button>
                                </form>
                            </div>
                            <table id="example3" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Dokumen</th>
                                        <th>Bagian</th>
                                        <th>Jenis Dokumen</th>
                                        <th>Status</th>
                                        <th>Tanggal Upload</th>
                                        <th>Akses</th>
                                    </tr>
                                </thead>
                                <tbody>
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

<script type="text/javascript">
$(document).ready(function() {
    $("#jenis_dokumen").change(function() {
        jenis_dkm();
    })
})
$(document).ready(function() {
    $("#bag_pemilik").change(function() {
        bag_keb();
    })
})
$(document).ready(function() {
    $("#reservation").change(function() {
        reservation1();
    })
})

function jenis_dkm() {
    var reservation = $("#reservation").val();
    var jenis_dokumen = $("#jenis_dokumen").val();
    var bag_pemilik = $("#bag_pemilik").val();
    console.log(jenis_dokumen);
    $(function() {
        $("input[name=ctk_reservasion]").val(reservation);
        $("input[name=ctk_jenis_dokumen]").val(jenis_dokumen);
        $("input[name=ctk_bag_pemilik]").val(bag_pemilik);
    });
    if ($("#customRadio2").is(':checked')) {
        var customRadio2 = $("#customRadio2").val();
    } else if ($("#customRadio3").is(':checked')) {
        var customRadio3 = $("#customRadio3").val();
    };
    $.ajax({
        url: "<?php echo base_url('c_laporan_hukum/load_laporan_hukum') ?>",
        data: "reservation=" + reservation + "&jenis_dokumen=" + jenis_dokumen + "&bag_pemilik=" + bag_pemilik,
        success: function(data) {
            $('tbody').html(data);

        }
    })
}

function bag_keb() {
    var reservation = $("#reservation").val();
    var jenis_dokumen = $("#jenis_dokumen").val();
    var bag_pemilik = $("#bag_pemilik").val();
    $(function() {
        $("input[name=ctk_reservasion]").val(reservation);
        $("input[name=ctk_jenis_dokumen]").val(jenis_dokumen);
        $("input[name=ctk_bag_pemilik]").val(bag_pemilik);
    });
    if ($("#customRadio2").is(':checked')) {
        var customRadio2 = $("#customRadio2").val();
    } else if ($("#customRadio3").is(':checked')) {
        var customRadio3 = $("#customRadio3").val();
    };
    $.ajax({
        url: "<?php echo base_url('c_laporan_hukum/load_laporan_hukum') ?>",
        data: "reservation=" + reservation + "&jenis_dokumen=" + jenis_dokumen + "&bag_pemilik=" + bag_pemilik,
        success: function(data) {
            $(' tbody').html(data);

        }
    })
}

function reservation1() {
    var reservation = $("#reservation").val();
    var jenis_dokumen = $("#jenis_dokumen").val();
    var bag_pemilik = $("#bag_pemilik").val();
    $(function() {
        $("input[name=ctk_reservasion]").val(reservation);
        $("input[name=ctk_jenis_dokumen]").val(jenis_dokumen);
        $("input[name=ctk_bag_pemilik]").val(bag_pemilik);
    });
    if ($("#customRadio2").is(':checked')) {
        var customRadio2 = $("#customRadio2").val();
    } else if ($("#customRadio3").is(':checked')) {
        var customRadio3 = $("#customRadio3").val();
    };
    $.ajax({
        url: "<?php echo base_url('c_laporan_hukum/load_laporan_hukum') ?>",
        data: "reservation=" + reservation + "&jenis_dokumen=" + jenis_dokumen + "&bag_pemilik=" + bag_pemilik,
        success: function(data) {
            $('tbody').html(data);

        }
    })
}
</script>