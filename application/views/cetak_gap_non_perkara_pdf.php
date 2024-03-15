<!DOCTYPE html>
<html><head>
</head><body>
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                          <th>#</th>
                          <th>Subjek</th>
                          <th>Waktu</th>
                          <th>Lokasi</th>
                          <th>Kondisi saat ini</th>
                          <th>upaya</th>
                        </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php
                              $no=0;
                              foreach ($non_perkara as $pk) :
                              $no++;
                            ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $pk['subjek'] ?></td>
                                <td><?php echo $pk['waktu'] ?></td>
                                <td><?php echo $pk['lokasi'] ?></td>
                                <td><?php echo $pk['kondisi_saat_ini'] ?></td>
                                <td><?php echo $pk['upaya'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                            
                        </tbody>
                        
                    </table>
</body></html>
	
    
    
    