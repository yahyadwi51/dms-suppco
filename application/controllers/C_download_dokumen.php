<?php
error_reporting(0);
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
use setasign\Fpdi\PdfParser\StreamReader;

class C_download_dokumen extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('role_id') == '') {
      $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          Anda Belum Login
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>');
      redirect('auth');
      parent::__construct();
      $this->load->helper(array('url', 'download'));
    }
  }
  

  // public function index()
  // {
  //   $id_pengakses = $this->session->userdata('id');
  //   $query_download_dokumen = $this->db->query("SELECT *,tb_dokumen.id AS iddkm FROM tb_dokumen 
  //     LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
  //     LEFT JOIN tb_master_jenis_dok ON tb_dokumen.jenis_dok = tb_master_jenis_dok.id
  //     WHERE tb_dokumen.akses_for LIKE '%$id_pengakses%'");
  //   $data['data_download_dokumen'] = $query_download_dokumen->result_array();
  //   $this->load->view('templates/header', $data);
  //   $this->load->view('templates/sidebar');
  //   $this->load->view('download_dokumen', $data);
  //   $this->load->view('templates/footer');
  // }

  public function generatekodeunik()
  {
    $this->load->helper('string');
    $this->load->library('user_agent');
    $TOKEN = '3dccc869f03e7b';
    $data['browser'] = $this->agent->browser();
    $data['os'] = $this->agent->platform();
    $data['ip_address'] = $this->input->ip_address();
    $MAC = exec('getmac');
    $MAC = strtok($MAC, ' ');
    $id = $this->session->userdata('id');
    $ip = $data['ip_address'];
    // $lacak_user = file_get_contents('http://ipinfo.io/'. $ip.'?token='.$TOKEN);
    $lacak_user = file_get_contents('https://ipinfo.io/?token='.$TOKEN.'');
    $lacak = json_decode($lacak_user);
    $browser = $data['browser'];
    $os = $data['os'];
    $kota = $lacak->city;
    $daerah = $lacak->region;
    $negara = $lacak->country;
    $lokasi = $lacak->loc;
    $zonawaktu = $lacak->timezone;
    $id       = $this->input->post('id');
    $nama_peminta   = $this->session->userdata('username');
    $telpon   = $this->session->userdata('no_telp');
    $no_telp        = $this->input->post('no_telp');
    $notelp = substr_replace($no_telp,'',0,1);
    $id_telegram     = $this->input->post('id_telegram');
    $keterangan     = $this->input->post('keterangan');
    $nama_dokumen   = $this->input->post('nama_dokumen');
    $kode_generate  = random_string('alnum', 12);
    $status = "Request";

    $cari_bag_dokumen = $this->db->query("SELECT bag_or_keb FROM `tb_dokumen` where id = $id ")
    ->result();
    foreach ($cari_bag_dokumen as $value)
    $bag_or_keb = $value->bag_or_keb;

    $cari_email_bagian = $this->db->query("SELECT email FROM `tb_user` where bagian = $bag_or_keb ")
    ->result();
    foreach ($cari_email_bagian as $value)
    $email = $value->email;

    // print_r($email);
    // die();
    

    // sms saat ada peminta
    $url = "http://103.16.199.187/masking/send_post.php";
    $rows = array(
      'username' => 'ptpn12_sms ',
      'password' => '123456789',
      'hp' => '62' . $notelp,
      'message' =>  $nama_peminta.' meminta kode unik untuk mengunduh dokumen : '. $nama_dokumen . '\n\ndengan keterangan: '.$keterangan .'.\n\nBerikut kode unik yang dapat diberikan: '.$kode_generate.'. \n\nPastikan kode tersebut diberikan hanya kepada peminta dokumen karena merupakan informasi rahasia.',
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
    if ($htm != '0') {
      $this->session->set_flashdata('something1', 'Pesan Terkirim');
    }
    // sms saat ada peminta
    // Telegram send
    // $message_text = "$nama_peminta Meminta Kode unik untuk mengunduh dokumen: *$nama_dokumen* \n\ndengan keterangan: $keterangan. \n\nBerikut kode unik yang dapat diberikan: *$kode_generate*. \n\nPastikan kode tersebut diberikan hanya kepada peminta dokumen karena merupakan informasi rahasia.";
    // $pesan = urlencode($message_text);
    // $token = "bot"."1456403973:AAEBKXDsE2Etl9GOiJjyLt3dtfHZmQYqI3w";
    // $chat_id = $id_telegram;
    // $proxy = "";
    
    // $url = "https://api.telegram.org/$token/sendMessage?parse_mode=markdown&chat_id=$chat_id&text=$pesan";
    
    // $ch = curl_init();
        
    // if($proxy==""){
    //     $optArray = array(
    //         CURLOPT_URL => $url,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_CAINFO => './telegram/cacert.pem'	
    //     );
    // }
    // else{ 
    //     $optArray = array(
    //         CURLOPT_URL => $url,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_PROXY => "$proxy",
    //         CURLOPT_CAINFO => './telegram/cacert.pem'	
    //     );	
    // }
        
    // curl_setopt_array($ch, $optArray);
    // $result = curl_exec($ch);
    // $err = curl_error($ch);
    // curl_close($ch);	
        
    // if($err<>"") echo "Error: $err";
    // else echo "Pesan Terkirim";

    // Telegram send
    $data1 = array(
      'os'    =>$os,
      'kota'    =>$kota,
      'daerah'    =>$daerah,
      'negara'    =>$negara,
      'lokasi'    =>$lokasi,
      'zonawaktu'    =>$zonawaktu,
      'id_dokumen'    => $id,
      'keterangan' => $keterangan,
      'status'    => $status,
      'kode_unik' => $kode_generate,
      'peminta' => $nama_peminta,
      'ip' => $ip,
      'nomor_peminta' => $telpon,
      'browser' => $browser,
      'mac' => $MAC
    );    

    $this->model_dokumen->tambah_dokumen($data1, 'histori_download_dokumen');
    
    $this->load->library('PHPMailer_load'); 
		$mail = $this->phpmailer_load->load(); 
		$mail->isSMTP();
		$mail->Host = ('mail.ptpn12.com'); 
		$mail->SMTPAuth = true; 
		$mail->Username = 'jasinfo@ptpn12.com';
		$mail->Password = 'rolasptpn12';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)   
		);
		
		$mail->setFrom('jasinfo@ptpn12.com', 'Aplikasi Jasinfo');
		$mail->addAddress($email); 
		$mail->Subject = "Permintaan Download Dokumen"; 
		$mail->msgHtml("
			<h3></h3><hr>
      <b>$nama_peminta</b> meminta kode unik untuk mengunduh dokumen : <b> $nama_dokumen </b>
      <br>
      Dengan keterangan : $keterangan.
      <br>
      Berikut kode unik yang dapat diberikan : <b>$kode_generate</b> 
      <br>
      <br>
      Pastikan kode tersebut diberikan hanya kepada peminta dokumen karena merupakan informasi rahasia.
			"); 

		if (!$mail->send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					redirect('c_pengelolah_dokumen');
				}

  }

  public function generatekodeunikjdih()
  {
    $this->load->helper('string');
    $this->load->library('user_agent');
    $TOKEN = '3dccc869f03e7b';
    $data['browser'] = $this->agent->browser();
    $data['os'] = $this->agent->platform();
    $data['ip_address'] = $this->input->ip_address();
    $MAC = exec('getmac');
    $MAC = strtok($MAC, ' ');
    $id = $this->session->userdata('id');
    $ip = $data['ip_address'];
    // $lacak_user = file_get_contents('http://ipinfo.io/'. $ip.'?token='.$TOKEN);
    $lacak_user = file_get_contents('https://ipinfo.io/?token='.$TOKEN.'');
    $lacak = json_decode($lacak_user);
    $browser = $data['browser'];
    $os = $data['os'];
    $kota = $lacak->city;
    $daerah = $lacak->region;
    $negara = $lacak->country;
    $lokasi = $lacak->loc;
    $zonawaktu = $lacak->timezone;
    $id       = $this->input->post('id');

    $nama_peminta   = $this->session->userdata('username');
    $telpon   = $this->session->userdata('no_telp');
    $no_telp        = $this->input->post('no_telp');
    $notelp = substr_replace($no_telp,'',0,1);
    $id_telegram     = $this->input->post('id_telegram');
    $keterangan     = $this->input->post('keterangan');
    $kode_generate  = random_string('alnum', 12);
    $status = "Request";

    $cari_nama_dokumen = $this->db->query("SELECT nama_dokumen FROM `hkm_dokumen` where id_dokumen = $id ")
    ->result();
    foreach ($cari_nama_dokumen as $value)
    $nama_dokumen = $value->nama_dokumen;

    // print_r($nama_dokumen);
    // die();

    // sms saat ada peminta
    $url = "http://103.16.199.187/masking/send_post.php";
    $rows = array(
      'username' => 'ptpn12_sms ',
      'password' => '123456789',
      'hp' => '62' . $notelp,
      'message' =>  $nama_peminta.' meminta kode unik untuk mengunduh dokumen : '. $nama_dokumen . '\n\ndengan keterangan: '.$keterangan .'.\n\nBerikut kode unik yang dapat diberikan: '.$kode_generate.'. \n\nPastikan kode tersebut diberikan hanya kepada peminta dokumen karena merupakan informasi rahasia.',
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
    if ($htm != '0') {
      $this->session->set_flashdata('something1', 'Pesan Terkirim');
    }
    // sms saat ada peminta
    // Telegram send
    // $message_text = "$nama_peminta Meminta Kode unik untuk mengunduh dokumen: *$nama_dokumen* \n\ndengan keterangan: $keterangan. \n\nBerikut kode unik yang dapat diberikan: *$kode_generate*. \n\nPastikan kode tersebut diberikan hanya kepada peminta dokumen karena merupakan informasi rahasia.";
    // $pesan = urlencode($message_text);
    // $token = "bot"."1456403973:AAEBKXDsE2Etl9GOiJjyLt3dtfHZmQYqI3w";
    // $chat_id = $id_telegram;
    // $proxy = "";
    
    // $url = "https://api.telegram.org/$token/sendMessage?parse_mode=markdown&chat_id=$chat_id&text=$pesan";
    
    // $ch = curl_init();
        
    // if($proxy==""){
    //     $optArray = array(
    //         CURLOPT_URL => $url,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_CAINFO => './telegram/cacert.pem'	
    //     );
    // }
    // else{ 
    //     $optArray = array(
    //         CURLOPT_URL => $url,
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_PROXY => "$proxy",
    //         CURLOPT_CAINFO => './telegram/cacert.pem'	
    //     );	
    // }
        
    // curl_setopt_array($ch, $optArray);
    // $result = curl_exec($ch);
    // $err = curl_error($ch);
    // curl_close($ch);	
        
    // if($err<>"") echo "Error: $err";
    // else echo "Pesan Terkirim";

    // Telegram send
    $data1 = array(
      'os'    =>$os,
      'kota'    =>$kota,
      'daerah'    =>$daerah,
      'negara'    =>$negara,
      'lokasi'    =>$lokasi,
      'zonawaktu'    =>$zonawaktu,
      'id_dokumen'    => $id,
      'keterangan' => $keterangan,
      'status'    => $status,
      'kode_unik' => $kode_generate,
      'peminta' => $nama_peminta,
      'ip' => $ip,
      'nomor_peminta' => $telpon,
      'browser' => $browser,
      'mac' => $MAC
    );

    $this->model_dokumen->tambah_dokumen($data1, 'histori_download_jdih');

    $this->load->library('PHPMailer_load'); 
		$mail = $this->phpmailer_load->load(); 
		$mail->isSMTP();  
		$mail->Host = ('mail.ptpn12.com'); 
		$mail->SMTPAuth = true; 
		$mail->Username = 'jasinfo@ptpn12.com';
		$mail->Password = 'rolasptpn12';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		
		$mail->setFrom('jasinfo@ptpn12.com', 'Aplikasi Jasinfo');
		$mail->addAddress('sekper@ptpn12.com'); 
		$mail->Subject = "Permintaan Download Dokumen JDIH"; 
		$mail->msgHtml("
			<h3></h3><hr>
      <b>$nama_peminta</b> meminta kode unik untuk mengunduh dokumen : <b> $nama_dokumen </b>
      <br>
      Dengan keterangan : $keterangan.
      <br>
      Berikut kode unik yang dapat diberikan : <b>$kode_generate</b> 
      <br>
      <br>
      Pastikan kode tersebut diberikan hanya kepada peminta dokumen karena merupakan informasi rahasia.
			"); 

		if (!$mail->send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					redirect('c_pengelolah_dokumen');
				} 
    
  }

  
  public function detail_download_dokumen()
  {
    $id_pengakses = $this->session->userdata('id');
    $username = $this->session->userdata('username');
    $query_download_dokumen = $this->db->query("SELECT *,tb_dokumen.id AS iddkm,histori_download_dokumen.keterangan AS ketum,histori_download_dokumen.status AS status_down FROM tb_dokumen 
      LEFT JOIN tb_master_jenis_dok ON tb_dokumen.jenis_dok = tb_master_jenis_dok.id
      LEFT JOIN histori_download_dokumen ON tb_dokumen.id = histori_download_dokumen.id_dokumen
      LEFT JOIN tb_master_bagian ON tb_dokumen.bag_or_keb = tb_master_bagian.id_bagian
      WHERE histori_download_dokumen.peminta LIKE '%$username%' && histori_download_dokumen.status != 'Berhasil'  ORDER BY iddkm DESC");
   
    $data['detail_download_dokumen'] = $query_download_dokumen->result_array();
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('detail-download_dokumen', $data);
    $this->load->view('templates/footer');
  }

  public function detail_download_jdih()
  {
    $id_pengakses = $this->session->userdata('id');
    $username = $this->session->userdata('username');
    $query_download_dokumen = $this->db->query("SELECT *,hkm_dokumen.id_dokumen AS iddkm,histori_download_jdih.keterangan AS ketum,histori_download_jdih.status AS status_down FROM hkm_dokumen 
      LEFT JOIN hkm_master_jenis_dokumen ON hkm_dokumen.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen
      LEFT JOIN histori_download_jdih ON hkm_dokumen.id_dokumen = histori_download_jdih.id_dokumen
      LEFT JOIN tb_master_bagian ON hkm_dokumen.user_upload = tb_master_bagian.id_bagian
      WHERE histori_download_jdih.peminta LIKE '%$username%' && histori_download_jdih.status != 'Berhasil'  ORDER BY iddkm DESC");
   
    $data['detail_download_jdih'] = $query_download_dokumen->result_array();
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('detail-download_jdih', $data);
    $this->load->view('templates/footer');
  }

  public function lakukan_download($data_dokumen)
  {
    $datadok = $data_dokumen;
    $kode_unik = $this->input->post('kode_unik');
    $getkode_unik = $this->input->post('getkode_unik');
    $idhistori = $this->input->post('idhistori');
    date_default_timezone_set("Asia/Jakarta");
    $tanggal_download = date("d-m-Y h:i:sa");
    $waktu = date("h:i:sa");
    $username = $this->session->userdata('username');
    if ($datadok == '') {
      $this->session->set_flashdata('something1', 'Pesan Terkirim');
      redirect('c_download_dokumen/detail_download_dokumen');
    }
    if ($kode_unik == $getkode_unik) {

      $data1 = array(
        'tanggal_download'    => $tanggal_download,
        'status'    => 'Berhasil'
      );
      $where1 = array('id' => $idhistori);
      $this->model_dokumen->update_dokumen($where1, $data1, 'histori_download_dokumen');
      require_once(APPPATH.'libraries/fpdf/fpdf.php');
      require_once(APPPATH.'libraries/fpdi/FPDI/src/autoload.php');
      //Set the source PDF file
      $pdf = new Fpdi();

   
      // menampilkan hasil curl
      $fileContent = file_get_contents(base_url('uploads/'.$datadok));
      $pageCount = $pdf->setSourceFile(StreamReader::createByString($fileContent));
      
      for ($i=1; $i <= $pageCount; $i++) { 
        $pageId = $pdf->importPage($i, PdfReader\PageBoundaries::MEDIA_BOX);
        $pdf->addPage();
        $pdf->SetY(55);
        $pdf->SetX(10);;
        $pdf->setTextColor(255,192,203);
          $pdf->RotateText(15, 210, $username.' | '.$tanggal_download.' | '.$waktu, 45);
          $pdf->RotateText2(80, 170,' Dokumen salinan ', 45);
          $pdf->RotateText3(10, 10, $username.' | '.$tanggal_download.' | '.$waktu.' | Dokumen salinan', 0);
        $pdf->useImportedPage($pageId, 10, 10, 190);

        // $pdf->setText(10);
        
        //Select Arial italic 8
        //Print centered cell with a text in it
        
      }
      
      $pdf->Output('D', $datadok);
    
    } else if ($getkode_unik = '') {
      echo '
      <script>
      alert("Kode Kosong"); 
      location.replace ("'.base_url().'c_download_dokumen/detail_download_dokumen")
      </script>';
    } else {
      echo '<script>
      alert("Kode salah"); 
      location.replace ("'.base_url().'c_download_dokumen/detail_download_dokumen")
      </script>';
    }
  }

  public function lakukan_download_jdih($data_dokumen)
  {
    $datadok = $data_dokumen;
    $kode_unik = $this->input->post('kode_unik');
    $getkode_unik = $this->input->post('getkode_unik');
    $idhistori = $this->input->post('idhistori');
    date_default_timezone_set("Asia/Jakarta");
    $tanggal_download = date("d-m-Y h:i:sa");
    $waktu = date("h:i:sa");
    // print_r($tanggal_download);
    // die();
    $username = $this->session->userdata('username');
    if ($datadok == '') {
      $this->session->set_flashdata('something1', 'Pesan Terkirim');
      redirect('c_download_dokumen/detail_download_jdih');
    }
    if ($kode_unik == $getkode_unik) {
     
      $data1 = array(
        'tanggal_download'    => $tanggal_download,
        'status'    => 'Berhasil'
      );

      $where1 = array('id' => $idhistori);
      $this->model_dokumen->update_dokumen($where1, $data1, 'histori_download_jdih');
      require_once(APPPATH.'libraries/fpdf/fpdf.php');
      require_once(APPPATH.'libraries/fpdi/FPDI/src/autoload.php');
      //Set the source PDF file
      $pdf = new Fpdi();

      // menampilkan hasil curl


      $fileContent = file_get_contents(base_url('uploads/'.$datadok));
      $pageCount = $pdf->setSourceFile(StreamReader::createByString($fileContent));


      for ($i=1; $i <= $pageCount; $i++) { 
        $pageId = $pdf->importPage($i, PdfReader\PageBoundaries::MEDIA_BOX);
        $pdf->addPage();
        $pdf->SetY(55);
        $pdf->SetX(10);
        $pdf->setTextColor(255,192,203);
        $pdf->RotateText(15, 210, $username.' | '.$tanggal_download.' | '.$waktu, 45);
        $pdf->RotateText2(80, 170,' Dokumen salinan ', 45);
        $pdf->RotateText3(10, 10, $username.' | '.$tanggal_download.' | '.$waktu.' | Dokumen salinan', 0);
        $pdf->useImportedPage($pageId, 10, 10, 190);

        // $pdf->setText(10);
        
        //Select Arial italic 8
        //Print centered cell with a text in it
      }
      
      $pdf->Output('D', $datadok);

    } else if ($getkode_unik = '') {
      echo '
      <script>
      alert("Kode Kosong"); 
      location.replace ("'.base_url().'c_download_dokumen/detail_download_jdih")
      </script>';
    } else {
      echo '<script>
      alert("Kode salah"); 
      location.replace ("'.base_url().'c_download_dokumen/detail_download_jdih")
      </script>';
    }
  }
  
  public function lakukan_download_pemilik($data_dokumen)
  {
    $this->load->helper('download');
    
    if($data_dokumen ==  ''){
      $this->session->set_flashdata('something2', 'Pesan Terkirim');
      redirect('c_data_dokumen');
    }else {
      force_download('uploads/' . $data_dokumen, NULL);
    }
    
  }
}