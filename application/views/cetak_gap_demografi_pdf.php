<!DOCTYPE html>
<html><head>
</head><body>              
                        <h1>Kebun Keseluruhan</h1>
                        <table  border="1">
                            <tr>
                                <td rowspan="2">No.</td>
                                <td rowspan="2">Jenis Tenaga Kerja</td>
                                <td colspan="2">SD</td>
                                <td colspan="2">SMP</td>
                                <td colspan="2">SMA</td>
                                <td colspan="2">D3/D4/S1</td>
                                <td colspan="2">S2</td>
                                <td colspan="2">Jumlah</td>
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
                              foreach ($karywantetapkeb as $ip) :
                              $no++;
                            ?>
                            <tr>
                                <td>1.</td>
                                <td>Karyawan Tetap</td>
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
                            <?php
                              $no=0;
                              foreach ($pktwkeb as $ip) :
                              $no++;
                            ?>
                            <tr>
                                <td>2.</td>
                                <td>PKWT</td>
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
                            <?php
                              $no=0;
                              foreach ($hariankeb as $ip) :
                              $no++;
                            ?>
                            <tr>
                                <td>3.</td>
                                <td>Harian Lepas</td>
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
                      <br><br><br><br><br><br><br><br>
                      <h1>Pabrik (Jika Ada)</h1>
                      <table class="table table-bordered table-hover" border="1">
                            <tr>
                                <td rowspan="2">No.</td>
                                <td rowspan="2">Jenis Tenaga Kerja</td>
                                <td colspan="2">SD</td>
                                <td colspan="2">SMP</td>
                                <td colspan="2">SMA</td>
                                <td colspan="2">D3/D4/S1</td>
                                <td colspan="2">S2</td>
                                <td colspan="2">Jumlah</td>
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
                              foreach ($karywantetappab as $ip) :
                              $no++;
                            ?>
                            <tr>
                                <td>1.</td>
                                <td>Karyawan Tetap</td>
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
                            <?php
                              $no=0;
                              foreach ($pktwpab as $ip) :
                              $no++;
                            ?>
                            <tr>
                                <td>2.</td>
                                <td>PKWT</td>
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
                            <?php
                              $no=0;
                              foreach ($harianpab as $ip) :
                              $no++;
                            ?>
                            <tr>
                                <td>3.</td>
                                <td>Harian Lepas</td>
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
	
    
    
    