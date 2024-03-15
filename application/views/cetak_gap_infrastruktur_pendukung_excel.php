<!DOCTYPE html>
<html><head>
</head><body>
<?php 

header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=Infrastruktur Pendukung.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                          <th>#</th>
                          <th>Kebun</th>
                          <th><span id="demo">Infrastruktur Pengelolaan Kebun</span></th>
                          <th>Kondisi saat ini</th>
                          <th>Jumlah/Unit</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php
                              $no=0;
                              foreach ($infrastruktur_pendukung as $ip) :
                              $no++;
                            ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $ip['nama_bagian'] ?></td>
                                <td><?php echo $ip['nama_infra'] ?></td>
                                <td><?php echo $ip['kondisi_saat_ini'] ?></td>
                                <td><?php echo $ip['jumlah'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                            
                        </tbody>
                        
                    </table>
</body></html>
	
    
    
    