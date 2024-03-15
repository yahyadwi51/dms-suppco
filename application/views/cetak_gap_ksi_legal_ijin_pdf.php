<!DOCTYPE html>
<html><head>
</head><body>
<table id="example2" class="table table-bordered table-hover">
                        <tr>
                          <th>#</th>
                          <th>Kondisi Saat Ini</th>
                          <th>Tanggal Update</th>
                          <th>Upload Dokumen</th>
                          
                        </tr>
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
                            
                        
                      </table>
</body></html>
	
    
    
    