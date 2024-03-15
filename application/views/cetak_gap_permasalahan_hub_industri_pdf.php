<!DOCTYPE html>
<html><head>
</head><body>
<table id="example3" class="table table-bordered table-hover" border="1">
                        <tr>
                            <th>#</th>
                            <th>Subjek</th>
                            <th>Waktu</th>
                            <th>Lokasi</th>
                            <th>Kerugian</th>
                            <th>Kondisi Terkini</th>
                            <th>Upaya Penyelesaian</th>
                            <th>Keterangan</th>
                            <th>status</th>
                        </tr>
                        <?php
                            $no=0;
                            foreach ($prmslhan_hub_industrial as $pk) :
                            $no++;
                        ?>
                        <tr>
                            <td><?php echo $no ?></td>
                            <td><?php echo $pk['subjek'] ?></td>
                            <td><?php echo $pk['waktu'] ?></td>
                            <td><?php echo $pk['lokasi'] ?></td>
                            <td><?php echo $pk['kerugian'] ?></td>
                            <td><?php echo $pk['kondisi_saat_ini'] ?></td>
                            <td><?php echo $pk['upaya_penyelesaian'] ?></td>
                            <td><?php echo $pk['keterangan'] ?></td>
                            <td><?php 
                            if($pk['status'] == '0' ){
                                echo 'Proses';
                            }elseif ($pk['status'] == '1') {
                                echo 'Close';
                            } ?></td>
                        </tr>
                        <?php endforeach; ?>
                        
</table>
</body></html>
	
    
    
    