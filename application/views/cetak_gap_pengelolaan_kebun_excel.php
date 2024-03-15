<!DOCTYPE html>
<html><head>
</head><body>
<?php 

header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=Pengelolaan Kebun.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>
    <table border="1">
    <tr>
        
        <th>#</th>
        <th>Kebun</th>
        <th>No Perjanjian</th>
        <th>Kerjasama</th>
        <th>Jenis Kerjasama</th>
        <th>Mitra</th>
        <th>Objek Kerjasama</th>
        <th>Nilai Kompensasi</th>
        <th>Tanggal Perjanjian</th>
        <th>Tanggal Berakhir</th>
    </tr>
        <?php
            $no=0;
            foreach ($pengelolaan_kebun as $pk) :
            $no++;
        ?>
        <tr>
            <td><?php echo $no ?></td>
            <td><?php echo $pk['nama_bagian'] ?></td>
            <td><?php echo $pk['no_perjanjian'] ?></td>
            <td><?php echo $pk['kerjasama'] ?></td>
            <td><?php echo $pk['jenis_kerjasama'] ?></td>
            <td><?php echo $pk['mitra'] ?></td>
            <td><?php echo $pk['objek_kerjasama'] ?></td>
            <td><?php echo $pk['nilai_kompensasi'] ?></td>
            <td><?php echo $pk['tanggal_perjanjian'] ?></td>
            <td><?php echo $pk['tanggal_akhir_perjanjian'] ?></td>
        </tr>
        <?php endforeach; ?>
</table>
</body></html>
	
    
    
    