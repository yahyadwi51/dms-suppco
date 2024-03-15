<?php
    class C_notifikasi_send extends CI_Controller
    {
        public function index()
        {
            $query_notif = $this->db->query("SELECT *,tb_dokumen.id AS iddkm FROM tb_dokumen 
            LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
            LEFT JOIN tb_master_jenis_dok ON tb_dokumen.jenis_dok = tb_master_jenis_dok.id");
            $data['query_notif'] = $query_notif->result_array();
            foreach ($data['query_notif'] as $row) :
            $notelp = $row['no_telp'];
            $expiredtanggal = date('d-m-Y', strtotime($row['masa_aktif_akhir']));
            $nama_dok = $row['nama_dokumen'];
            $pengingat = $row['pengingat'];
            $result = preg_replace('~^[0\D]++|\D++~', '', $notelp);
            if($pengingat == '1'){
            $url = "http://122.50.7.30/masking/send_post.php";
            $rows = array(
            'username' => 'ptpn12_sms',
            'password' => 'ptpn2022',
            'hp' => '62' . $result,
            'message' => 'Dokumen : '.$nama_dok.' Anda Akan habis pada tanggal : ' .$expiredtanggal
            );
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($rows));
            curl_setopt($curl, CURLOPT_HEADER, FALSE);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
            curl_setopt($curl, CURLOPT_TIMEOUT, 60);
            $htm = curl_exec($curl);
            if (curl_errno($curl) !== 0) {
            error_log('cURL error when connecting to ' . $url . ': ' . curl_error($curl));
            }
            curl_close($curl);
            print_r($htm);
            if ($htm != '0') {
            $this->session->set_flashdata('something', 'Pesan Terkirim');
            }
            echo $nama_dok." ".$expiredtanggal;
            }

            endforeach;
            
        }
        public function sendMessage(){
                $query_notif = $this->db->query("SELECT *,tb_dokumen.id AS iddkm FROM tb_dokumen 
                LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
                LEFT JOIN tb_master_jenis_dok ON tb_dokumen.jenis_dok = tb_master_jenis_dok.id");
                $data['query_notif'] = $query_notif->result_array();
                foreach ($data['query_notif'] as $row) :
                $expiredtanggal = date('d-m-Y', strtotime($row['masa_aktif_akhir']));
                $nama_dok = $row['nama_dokumen'];
                $pengingat = $row['pengingat'];
                $id_telegram = $row['id_telegram'];
                
                if($pengingat == '1'){
                    $message_text = "Dokumen : $nama_dok Anda Akan habis pada tanggal : $expiredtanggal";
                    $pesan = urlencode($message_text);
                    $token = "bot"."1456403973:AAEBKXDsE2Etl9GOiJjyLt3dtfHZmQYqI3w";
                    $chat_id = $id_telegram;
                    $proxy = "";
                    
                    $url = "https://api.telegram.org/$token/sendMessage?parse_mode=markdown&chat_id=$chat_id&text=$pesan";
                    
                    $ch = curl_init();
                        
                    if($proxy==""){
                        $optArray = array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_CAINFO => "C:\cacert.pem"	
                        );
                    }
                    else{ 
                        $optArray = array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_PROXY => "$proxy",
                            CURLOPT_CAINFO => "C:\cacert.pem"	
                        );	
                    }
                        
                    curl_setopt_array($ch, $optArray);
                    $result = curl_exec($ch);
                    $err = curl_error($ch);
                    curl_close($ch);	
                        
                    if($err<>"") echo "Error: $err";
                    else echo "Pesan Terkirim";
                }

            endforeach;
        }
    }