<!DOCTYPE html>
<html><head>
</head><body>
<?php 

header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=KSI Non Perkara.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>
<table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                          <th>#</th>
                          <th>Kondisi Saat Ini</th>
                          <th>Tanggal Update</th>
                          <th>Upload Dokumen</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                              $no=0;
                              foreach ($kondisi_saat_ini as $ksi) :
                              $no++;
                            ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $ksi['histori_kondisi_saat_ini'] ?></td>
                                <td><?php echo $ksi['tanggal_update'] ?></td>
                                <td><?php echo $ksi['histori_upload_dokumen'] ?></td>
                                
                            </tr>
                            <?php endforeach; ?>
                            
                        </tbody>
                        
                      </table>
</body></html>
	
    
    
    