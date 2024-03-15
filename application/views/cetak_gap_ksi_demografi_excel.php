<!DOCTYPE html>
<html><head>
</head><body>
<?php 

header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=KSI_Demografi.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>
                    <table id="example2" class="table table-bordered table-hover">
                              <tr>
                                  <td rowspan="2" >Tanggal</td>
                                  <td colspan="2" align="center">SD</td>
                                  <td colspan="2" align="center">SMP</td>
                                  <td colspan="2" align="center">SMA</td>
                                  <td colspan="2" align="center">D3/D4/S1</td>
                                  <td colspan="2" align="center">S2</td>
                                  <td colspan="2" align="center">Jumlah</td>
                              </tr>
                              <tr>
                                  <td>Laki-laki</td>
                                  <td>Perempuan</td>
                                  <td>Laki-laki</td>
                                  <td>Perempuan</td>
                                  <td>Laki-laki</td>
                                  <td>Perempuan</td>
                                  <td>Laki-laki</td>
                                  <td>Perempuan</td>
                                  <td>Laki-laki</td>
                                  <td>Perempuan</td>
                                  <td>Laki-laki</td>
                                  <td>Perempuan</td>
                              </tr>
                              
                              <?php
                                $no=0;
                                foreach ($detail_demografi as $ip) :
                                $no++;
                              ?>
                              <tr>
                                  <td width="20%"><?php echo $ip['tanggal']?></td>
                                  <td><?php echo $ip['sd_l']?></td>
                                  <td><?php echo $ip['sd_p']?></td>
                                  <td><?php echo $ip['smp_l']?></td>
                                  <td><?php echo $ip['smp_p']?></td>
                                  <td><?php echo $ip['sma_l']?></td>
                                  <td><?php echo $ip['sma_p']?></td>
                                  <td><?php echo $ip['sarjana_l']?></td>
                                  <td><?php echo $ip['sarjana_p']?></td>
                                  <td><?php echo $ip['s2_l']?></td>
                                  <td><?php echo $ip['s2_p']?></td>
                                  <td><?php 
                                      $jumlaki = $ip['sd_l'] + $ip['smp_l'] + $ip['sma_l'] + $ip['sarjana_l'] + $ip['s2_l']  ;
                                      echo $jumlaki?></td>
                                  <td><?php 
                                      $jumperem = $ip['sd_p'] + $ip['smp_p'] + $ip['sma_p'] + $ip['sarjana_p'] + $ip['s2_p']  ; 
                                      echo $jumperem?></td>
                              </tr>
                              <?php endforeach; ?>
                            
                              
                        </table>
</body></html>
	
    
    
    