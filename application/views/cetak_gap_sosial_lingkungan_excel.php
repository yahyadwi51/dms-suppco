<!DOCTYPE html>
<html><head>
</head><body>
<?php 

header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=Sosial dan Lingkungan.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>
    <table border="1">
    <tr>
        
        <th>#</th>
        <th>LSM/Tokoh Masyarakat/Instansi</th>
        <th>Lokasi</th>
        <th>Kondisi Selama 10 Tahun Terakhir</th>
        <th>Kondisi Saat Ini</th>
        <th>Keterangan</th>
        <th>Tanggal</th>
    </tr>
        <?php
            $no=0;
            foreach ($sosial_lingkungan as $pk) :
            $no++;
        ?>
        <tr>
            <td><?php echo $no ?></td>
            <td><?php echo $pk['namaLSM'] ?></td>
            <td><?php echo $pk['lokasi'] ?></td>
            <td><?php echo $pk['kondisi_10thn_terakhir'] ?></td>
            <td><?php echo $pk['kondisi_saat_ini'] ?></td>
            <td><?php echo $pk['keterangan'] ?></td>
            <td><?php echo $pk['tanggal'] ?></td>
        </tr>
        <?php endforeach; ?>
</table>
</body></html>
	
    
    
    