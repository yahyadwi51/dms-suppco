<!DOCTYPE html>
<html><head>
</head><body>
<table id="example2" class="table table-bordered table-hover">
                                <tr>
                                <th>#</th>
                                <th>No HGU</th>
                                <th>Kebun</th>
                                <th>Hak Atas Tanah</th>
                                <th>Tanah Belum Digarap</th>
                                <th>Okupasi</th>
                                <th>Tumpang Tindih</th>
                                <th>Kondisi Saat ini</th>
                                <th>Permasalahan Lain</th>
                                </tr>
                                    <?php
                                    $no=0;
                                    foreach ($pertanahan as $key => $li) :
                                    $no++;
                                    ?>
                                    <tr>
                                        <td><?php echo $no ?></td>
                                        <td><?php echo $li['no_hgu'] ?></td>
                                        <td><?php echo $li['nama_bagian'] ?></td>
                                        <td><?php echo $li['hak_atas_tanah'] ?></td>
                                        <?php
                                        $id_pert = $li['id_pertanahan'];
                                        $query_ket_pertanahan= $this->db->query("SELECT *  FROM gap_kat_pertanahan
                                          WHERE id_pertanahan = '$id_pert'");
                                            $data['ket_tanah'] = $query_ket_pertanahan->result_array();
                                            $jumlah =  count($data['ket_tanah']);
                                         foreach ( $data['ket_tanah'] as $nh) : ?>
                                        
                                          
                                        <td>
                                        
                                          <?php 
                                            if ($nh['id_pertanahan'] == $li['id_pertanahan'] && $nh['kat']== '1') {
                                          ?>
                                          
                                          Luas :<?php echo $nh['luas'] ?><br>Tanggal Terjadi : <?php if( $nh['tanggal_terjadi'] == '0000-00-00'){echo '-';}else{echo $nh['tanggal_terjadi'];} ?><br>Latitude : <?php echo $nh['latitude'] ?><br>Longitude : <?php echo $nh['longitude'] ?><br> Komoditi : <?php echo $nh['komoditi'] ?>
                                         
                                            <?php }else{ ?>
                                              Luas :<?php echo $nh['luas'] ?><br>Tanggal Terjadi : <?php echo $nh['tanggal_terjadi'] ?><br>Latitude : <?php echo $nh['latitude'] ?><br>Longitude : <?php echo $nh['longitude'] ?><br>Subjek : <?php echo $nh['subjek'] ?><br>Kerugian : <?php echo $nh['kerugian'] ?><br> Komoditi : <?php echo $nh['komoditi'] ?>
                                            <?php } ?>
                                              
                                        </td>
                                        <?php endforeach;?>
                                        <?php
                                        if ($jumlah == 5) {
                                      ?>
                                      <script>
                                        
                                            $(".div_<?=$key?>").hide();
                                        
                                      </script>
                                      <?php }if ($jumlah == '4') { ?>
                                        <script>
                                        
                                        $(".div_<?=$key?>").show();
                                        
                                      </script>
                                        <?php } ?>

                                    </tr>
                                    <?php endforeach;  ?>
                                    
                                
                            </table>
</body></html>
	
    
    
    