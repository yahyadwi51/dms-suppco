<!DOCTYPE html>
<html><head>
</head><body>
<table id="example3" class="table table-bordered table-hover" border="1">
                        <tr>
                            <th>#</th>
                            <th>Kebun</th>
                            <th>Subjek</th>
                            <th>Waktu</th>
                            <th>Lokasi</th>
                            <th>Kondisi saat ini</th>
                            <th>upaya</th>
                            <th>keterangan</th>
                        </tr>
                        <?php
                            $no=0;
                            foreach ($perkara as $pk) :
                            $no++;
                        ?>
                        <tr>
                            <td><?php echo $no ?></td>
                            <td><?php echo $pk['nama_kebun'] ?></td>
                            <td><?php echo $pk['subjek'] ?></td>
                            <td><?php echo $pk['waktu'] ?></td>
                            <td><?php echo $pk['lokasi'] ?></td>
                            <td><?php echo $pk['kondisi_saat_ini'] ?></td>
                            <td><?php echo $pk['upaya'] ?></td>
                            <td><?php echo $pk['keterangan'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                        
</table>
</body></html>
	
    
    
    