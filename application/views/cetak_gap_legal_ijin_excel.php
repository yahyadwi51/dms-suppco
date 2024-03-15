<!DOCTYPE html>
<html><head>
</head><body>
<?php 

header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=Legalitas dan Perijinan.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>
    <table border="1">
    <tr>
        
        <th>#</th>
        <th>Kebun</th>
        <th>No KTUN</th>
        <th>Tanggal Terbit</th>
        <th>Tanggal Berakhir</th>
        <th>Kondisi saat ini</th>
    </tr>
        <?php
            $no=0;
            foreach ($legal_ijin as $li) :
            $no++;
        ?>
        <tr>
            <td><?php echo $no ?></td>
            <td><?php echo $li['nama_bagian'] ?></td>
            <td><?php echo $li['no_ktun'] ?></td>
            <td><?php echo $li['tanggal_terbit'] ?></td>
            <td><?php echo $li['tanggal_berakhir'] ?></td>
            <td><?php echo $li['kondisi_saat_ini'] ?></td>
        </tr>
        <?php endforeach; ?>
</table>
</body></html>
	
    
    
    