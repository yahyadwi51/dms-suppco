<!DOCTYPE html>
<html><head>
</head><body>
<?php 

header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=Perkara.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>
    <table border="1">
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
	
    
    
    