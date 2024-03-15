<?php 

header("Content-type: application/octet-stream");

header("Content-Disposition: attachment; filename=Laporan Hukum.xls");

header("Pragma: no-cache");

header("Expires: 0");

?>
 <table id="example3" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Dokumen</th>
                            <th>Bagian</th>
                            <th>Jenis Dokumen</th>
                            <th>Status</th>
                            <th>Tanggal Upload</th>
                            <th>Akses</th>
                        </tr>
                        </thead>
                        <tbody>
                       <?php $no=0;
                                foreach ( $data_dokumen as $dd) :
                                $no++;
                            ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td><?php echo $dd['nama_dokumen'] ?></td>
                                <td><?php echo $dd['username'] ?></td>
                                <td><?php echo $dd['nama_jenis_dokumen'] ?></td>
                                <td><?php echo $dd['status'] ?></td>
                                <td><?php echo $dd['tanggal'] ?></td>
                                <td>
                                <?php foreach ($user as $usr) : ?>
                                    <?php  $str = $dd['akses_for'];
                                            $str1 = explode(",",$str);
                                            $jumlahdata = count($str1);
                                            for ($i=0; $i < $jumlahdata; $i++) { 
                                                if ($usr->id == $str1[$i]) {
                                                echo '-'.$usr->username.'<br>';
                                                }
                                            }
                                            
                                        ?> 
                                        <?php endforeach; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        
</table>
</body></html>
	
    
    
    