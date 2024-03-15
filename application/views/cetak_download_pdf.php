<!DOCTYPE html>
<html><head>
</head><body>
    <table border="1">
    <tr>
        
        <th>No</th>
        <th>Tanggal Input</th>
        <th>Peminta</th>
        <th>Status</th>
        <th>Keperluan</th>
        <th>tanggal Download</th>
        <th>Kode Unik</th>
    </tr>
    <?php
            $no=1;
            foreach ($data_download_dokumen as $ddd) :
                
        ?>
        <tr>
            <td><?php echo $no++ ?></td>
            <td><?php echo $ddd['log'] ?></td>
            <td><?php echo $ddd['peminta'] ?></td>
            <td><?php echo $ddd['status'] ?></td>
            <td><?php echo $ddd['keterangan'] ?></td> 
            <td><?php 
            if( $ddd['tanggal_download'] != ''){
                echo date('d/m/Y', strtotime($ddd['tanggal_download']));
              }?>
            </td> 
            <td><?php echo $ddd['kode_unik'] ?></td>
            
        </tr>
        <?php endforeach; ?>
</table>
</body></html>
	
    
    
    