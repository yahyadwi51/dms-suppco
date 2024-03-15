<?php
error_reporting(0);
use Dompdf\Dompdf;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
use setasign\Fpdi\PdfParser\StreamReader;

class C_pengelolah_dokumen extends CI_Controller
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
    }
  }

  public function index()
  {
    $id = $this->session->userdata('id');
    $bagian = $this->session->userdata('id_bagian');
    $username = $this->session->userdata('username');

    if($username == 'admin' || $username == 'adminsekper'){
      $query_dokumen = $this->db->query("SELECT *,hkm_dokumen_dms.id_dokumen AS id_dkm_awal FROM `hkm_dokumen_dms`
        LEFT JOIN tb_master_bagian ON hkm_dokumen_dms.user_upload = tb_master_bagian.id_bagian
        LEFT JOIN hkm_master_jenis_dokumen ON hkm_dokumen_dms.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen
        WHERE hkm_dokumen_dms.user_upload = 3 ORDER BY id_dkm_awal DESC");
    }
    else {
      $kode = $this->db->query("SELECT * FROM `tb_master_bagian` WHERE tb_master_bagian.id_bagian = '$bagian'")->result();
      foreach($kode as $kd)
      $array[] = $kd->kode;
  
      $query_dokumen = $this->db->query("SELECT *,hkm_dokumen_dms.id_dokumen AS id_dkm_awal FROM `hkm_dokumen_dms`
        LEFT JOIN tb_master_bagian ON hkm_dokumen_dms.user_upload = tb_master_bagian.id_bagian
        LEFT JOIN hkm_master_jenis_dokumen ON hkm_dokumen_dms.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen
        WHERE hkm_dokumen_dms.user_upload = '$bagian' OR hkm_dokumen_dms.akses_for LIKE '%$kd->kode%' ORDER BY id_dkm_awal DESC");
    }

    $query_permintaan_download = $this->db->query("SELECT COUNT(*) AS jn FROM hkm_dokumen_dms 
      LEFT JOIN hkm_master_jenis_dokumen ON hkm_dokumen_dms.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen
      LEFT JOIN histori_download_jdih ON hkm_dokumen_dms.id_dokumen = histori_download_jdih.id_dokumen
      LEFT JOIN tb_user ON hkm_dokumen_dms.akses_for = tb_user.id
      WHERE histori_download_jdih.status = 'Request'");

    $data['user'] = $this->model_dokumen->tampil_data_user()->result();
    $data['jumlahnotifikasi'] = $query_permintaan_download->result_array();
    $data['data_dokumen'] = $query_dokumen->result_array();
    $query_akses = $this->db->query("SELECT * FROM `tb_master_bagian` ");
    $query_dokstatus = $this->db->query("SELECT * FROM `hkm_dokumen_proses` ORDER BY id_proses DESC ");
    $query_dokumen_master = $this->db->query("SELECT * FROM `hkm_dokumen_dms` ");
    $data['dokumen_master'] = $query_dokumen_master->result_array();
    $data['data_bagian'] = $query_akses->result();

    $data['query_dokstatus'] = $query_dokstatus->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('pengelolah_dokumen', $data);
    $this->load->view('templates/footer');
  }

  public function detail_dum($id_dkm)
  {
    $query_dokumen_master = $this->db->query("SELECT * FROM `hkm_dokumen_dms` ");
    $data['dokumen_master'] = $query_dokumen_master->result_array();

    $query_dokumen = $this->db->query("SELECT * FROM `hkm_dokumen_dms`
    LEFT JOIN hkm_master_jenis_dokumen ON hkm_dokumen_dms.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen
    WHERE hkm_dokumen_dms.id_dokumen = '$id_dkm' ");
    $data['data_dokumen'] = $query_dokumen->result_array();

    $query_dokstatus = $this->db->query("SELECT * FROM `hkm_dokumen_proses` 
    LEFT JOIN hkm_dokumen_dms ON hkm_dokumen_proses.id_dokumen = hkm_dokumen_dms.id_dokumen ORDER BY id_proses DESC ");
    $data['query_dokstatus'] = $query_dokstatus->result_array();

    $query_akses = $this->db->query("SELECT * FROM `tb_master_bagian` ");
    $data['data_bagian'] = $query_akses->result();

    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('detail_pengelolah_data_apn', $data);
    $this->load->view('templates/footer');


    $username = $this->session->userdata('username');
    date_default_timezone_set('Asia/Jakarta');
    $tgl = date('Y-m-d H:i:s');

    $this->load->helper('string');
    $this->load->library('user_agent');
    $TOKEN = '3dccc869f03e7b';
    $data['browser'] = $this->agent->browser();
    $data['os'] = $this->agent->platform();
    $MAC = exec('getmac');
    $MAC = strtok($MAC, ' ');
    // $lacak_user = file_get_contents('http://ipinfo.io/'. $ip.'?token='.$TOKEN);
    $lacak_user = file_get_contents('https://ipinfo.io/?token='.$TOKEN.'');
    $lacak = json_decode($lacak_user);
    $browser = $data['browser'];
    $os = $data['os'];
    $kota = $lacak->city;
    $ip = $lacak->ip;;
    $daerah = $lacak->region;
    $negara = $lacak->country;
    $lokasi = $lacak->loc;
    $zonawaktu = $lacak->timezone;

    $aktivitas = "View";
    $data = array(
      'id_dokumen' => $id_dkm,
      'username' => $username,
      'tgl' => $tgl,
      'ip' => $ip,
      'os'    =>$os,
      'kota'    =>$kota,
      'daerah'    =>$daerah,
      'negara'    =>$negara,
      'lokasi'    =>$lokasi,
      'zonawaktu'    =>$zonawaktu,
      'browser' => $browser,
      'mac' => $MAC,
      'aktivitas' => $aktivitas
    );
    $this->model_auth->tambah_log($data, 'tb_log');

  }

  public function form_data_dokumen()
  {
    $this->session->set_userdata('halaman', 'data_jdih');

    $query_dokumen = $this->db->query("SELECT * FROM `hkm_dokumen`");
    $id_dok_akhir = $this->db->query("SELECT id_dokumen FROM `hkm_dokumen` ORDER BY id_dokumen desc limit 1");
    $data['id_dok_akhir'] = $id_dok_akhir->result();
    $data['data_dokumen_lama'] = $query_dokumen->result();
    $data['master_bagian'] = $this->model_dokumen->tampil_data_bagian_kebun()->result();
    $data['jenis_dokumen'] = $this->model_dokumen->tampil_data_jenis_pengelolah_dokumen()->result();
    $data['user'] = $this->model_dokumen->tampil_data_user()->result();

    $allbagian = $this->db->query("SELECT * FROM `tb_master_bagian` WHERE id_bagian BETWEEN 3 AND 16");
    $allkebun = $this->db->query("SELECT * FROM `tb_master_bagian` WHERE id_bagian BETWEEN 18 AND 51");
    $allbk = $this->db->query("SELECT * FROM `tb_master_bagian` WHERE id_bagian BETWEEN 3 AND 51");
    $data['all_bagian'] = $allbagian->result();
    $data['all_kebun'] = $allkebun->result();
    $data['all_bk'] = $allbk->result();

    $this->load->view('tambah-pengelolah_dokumen', $data);
  }

  public function form_data_dokumen_error()
  {
    $this->session->set_userdata('halaman', 'data_jdih');

    $query_dokumen = $this->db->query("SELECT * FROM `hkm_dokumen`");
    $id_dok_akhir = $this->db->query("SELECT id_dokumen FROM `hkm_dokumen` ORDER BY id_dokumen desc limit 1");
    $data['id_dok_akhir'] = $id_dok_akhir->result();
    $data['data_dokumen_lama'] = $query_dokumen->result();
    $data['master_bagian'] = $this->model_dokumen->tampil_data_bagian_kebun()->result();
    $data['jenis_dokumen'] = $this->model_dokumen->tampil_data_jenis_pengelolah_dokumen()->result();
    $data['user'] = $this->model_dokumen->tampil_data_user()->result();

    $allbagian = $this->db->query("SELECT * FROM `tb_master_bagian` WHERE id_bagian BETWEEN 3 AND 16");
    $allkebun = $this->db->query("SELECT * FROM `tb_master_bagian` WHERE id_bagian BETWEEN 18 AND 51");
    $allbk = $this->db->query("SELECT * FROM `tb_master_bagian` WHERE id_bagian BETWEEN 3 AND 51");
    $data['all_bagian'] = $allbagian->result();
    $data['all_kebun'] = $allkebun->result();
    $data['all_bk'] = $allbk->result();

    $this->load->view('tambah-pengelolah_dokumen_error', $data);
  }

  public function permintaan_download_jdih()
  {
    $id_pem_dokumen = $this->session->userdata('id');
    $query_download_jdih = $this->db->query("SELECT *,hkm_dokumen.id_dokumen AS iddkm,histori_download_jdih.id AS idhistori FROM hkm_dokumen 
    LEFT JOIN histori_download_jdih ON hkm_dokumen.id_dokumen = histori_download_jdih.id_dokumen
    LEFT JOIN tb_user ON hkm_dokumen.akses_for = tb_user.id
    WHERE histori_download_jdih.status != '' ORDER BY idhistori DESC");
    
    $data['data_download_jdih'] = $query_download_jdih->result_array();
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('permintaan_download_jdih', $data);
    $this->load->view('templates/footer');
  }

  public function tolak_permintaan_download_jdih()
  {
    $idhistori            = $this->input->post('idhistori');
    $kode_generate  = '-';
    $status         = 'Ditolak';
    $data1 = array(
      'status'    => $status,
      'kode_unik' => $kode_generate
    );
    $where1 = array('id' => $idhistori);
    $this->model_dokumen->update_dokumen($where1, $data1, 'histori_download_jdih');
    $this->session->set_flashdata('something1', 'Pesan Terkirim');
    redirect('c_pengelolah_dokumen/permintaan_download_jdih');
  }

  public function tambah_data_dokumen()
  {
    $id = $this->session->userdata('id');
    $nama_dokumen = $this->input->post('nama_dokumen');
    $bagian = $this->input->post('bagian');
    $jenis_dok = $this->input->post('jenis_dok');
    $tentang = $this->input->post('tentang');
    $id_dok_akhir = $this->input->post('id_dok_akhir');
    $tanggal_penetapan = $this->input->post('tanggal_penetapan');
    $cvt_tanggal_penetapan = date('Y-m-d', strtotime($tanggal_penetapan));
    $dokumen_lama = $this->input->post('dokumen_lama');
    
    $upload_dokumen = $_FILES['upload_dokumen']['name'];
    
    $induk_dokumen = $id_dok_akhir + 1;
    $akses_for = $_POST['akses_for'];
    $status = $this->input->post('status');

    foreach ($akses_for as $key ) {
      if($key == 'AKBN'){
        // $akses_for = $_POST['akses_for'];
        // if (($val = array_search($key, $akses_for)) !== false){
        //   unset($akses_for[$val]);
        // }
        $allkebun = $this->db->query("SELECT kode FROM `tb_master_bagian` WHERE id_bagian BETWEEN 18 AND 51")->result();
        foreach($allkebun as $all_kebun){
          if($all_kebun->kode){
            $data_allkebun[] = $all_kebun->kode;
          }
        }
        $all_kebun = array_merge($akses_for, $data_allkebun);
        $akses_for = $all_kebun;
      }

      elseif ($key == 'ABGN') {
        // $akses_for = $_POST['akses_for'];
        // if (($val = array_search($key, $akses_for)) !== false){
        //   unset($akses_for[$val]);
        // }
        $allbagian = $this->db->query("SELECT kode FROM `tb_master_bagian` WHERE id_bagian BETWEEN 3 AND 16")->result();
        foreach($allbagian as $all_bagian){
          if($all_bagian->kode){
            $data_allbagian[] = $all_bagian->kode;
          }
        }
        $all_kebun = array_merge($akses_for, $data_allbagian);
        $akses_for = $all_kebun;
      }

      elseif ($key == 'AB&K') {
        // $akses_for = $_POST['akses_for'];
        // if (($val = array_search($key, $akses_for)) !== false){
        //   unset($akses_for[$val]);
        // }
        $allbk = $this->db->query("SELECT kode FROM `tb_master_bagian` WHERE id_bagian BETWEEN 3 AND 51")->result();
        foreach($allbk as $all_bk){
          if($all_bk->kode){
            $data_allbk[] = $all_bk->kode;
          }
        }
        $all_kebun = array_merge($akses_for, $data_allbk);
        $akses_for = $all_kebun;
      }
      else {
        $akses_for = $_POST['akses_for'];
      }
    }

      
    if ($upload_dokumen = '') {
    } else {
      $config['upload_path'] = './uploads';
      $config['allowed_types'] = 'jpg|pdf|png';

      $this->load->library('upload', $config);
      if (!$this->upload->do_upload('upload_dokumen')) {
        echo "Gambar Gagal Upload !";
      } else {
        $upload_dokumen = $this->upload->data('file_name');
      }
    }

    $data_session = array(
      'user_upload' => $bagian,
      'nama_dokumen' => $nama_dokumen,
      'jenis_dokumen' => $jenis_dok,
      'tentang' => $tentang,
      'induk_dokumen' => $induk_dokumen,
      'tanggal_penetapan' => $cvt_tanggal_penetapan,
      'akses_for' => implode(",", $akses_for),
      'upload_dokumen' => $upload_dokumen
    );
    $this->session->set_userdata($data_session);

    // CHECK TYPE PDF
    require_once(APPPATH.'libraries/fpdf/fpdf.php');
    require_once(APPPATH.'libraries/fpdi/FPDI/src/autoload.php');
    //Set the source PDF file
    $pdf = new Fpdi();

    // menampilkan hasil curl
    $fileContent = file_get_contents(base_url('uploads/'.$upload_dokumen));
    $pageCount = $pdf->setSourceFile(StreamReader::createByString($fileContent));
    

    if ($status == 'Baru') {
      $data = array(
        'user_upload' => $bagian,
        'nama_dokumen' => $nama_dokumen,
        'jenis_dokumen' => $jenis_dok,
        'tentang' => $tentang,
        'induk_dokumen' => $induk_dokumen,
        'tanggal_penetapan' => $cvt_tanggal_penetapan,
        'akses_for' => implode(",", $akses_for),
        'upload_dokumen' => $upload_dokumen
      );

      $this->model_dokumen->tambah_dokumen($data, 'hkm_dokumen');
      $last_id = $this->db->insert_id();
      $data1 = array(
        'id_dokumen' => $last_id,
        'id_dokumen_status' => $dokumen_lama,
        'status' => $status
      );
      
      // $this->model_dokumen->tambah_dokumen($data1, 'hkm_dokumen_proses');
      redirect('c_pengelolah_dokumen/index');

    } elseif ($status == 'Mencabut') {
      $cari_induk_dokumen = $this->db->query("SELECT induk_dokumen FROM `hkm_dokumen` where id_dokumen = $dokumen_lama ")
      ->result();
      foreach ($cari_induk_dokumen as $value)
      $array[] = $value->induk_dokumen;

      $id_mencabut = $this->db->query("SELECT id_dokumen FROM `hkm_dokumen` where induk_dokumen = $value->induk_dokumen ")
      ->result_array();
      
      $data = array(
        'user_upload' => $bagian,
        'nama_dokumen' => $nama_dokumen,
        'jenis_dokumen' => $jenis_dok,
        'tentang' => $tentang,
        'induk_dokumen' => $value->induk_dokumen,
        'tanggal_penetapan' => $cvt_tanggal_penetapan,
        'akses_for' => implode(",", $akses_for),
        'upload_dokumen' => $upload_dokumen
      );

      $this->model_dokumen->tambah_dokumen($data, 'hkm_dokumen');

      $last_id = $this->db->insert_id();
      $result = array();
      foreach($id_mencabut AS $key => $row){
      $data1[] = array(
        'id_dokumen' => $last_id,
        'id_dokumen_status' => $row['id_dokumen'],
        'status' => $status
       );
      }

      $this->db->insert_batch('hkm_dokumen_proses', $data1);

      $result = array();
      foreach($id_mencabut AS $key => $rows){
      $data2[] = array(
        'id_dokumen' => $rows['id_dokumen'],
        'id_dokumen_status' => $last_id,
        'status' => 'Dicabut'
       );
      }

      $this->db->insert_batch('hkm_dokumen_proses', $data2);
      redirect('c_pengelolah_dokumen/index');

    } elseif ($status == 'Dicabut') {

      $cari_induk_dokumen = $this->db->query("SELECT induk_dokumen FROM `hkm_dokumen` where id_dokumen = $dokumen_lama ")
      ->result();
      foreach ($cari_induk_dokumen as $value)
      $array[] = $value->induk_dokumen;

      $id_mencabut = $this->db->query("SELECT id_dokumen FROM `hkm_dokumen` where induk_dokumen = $value->induk_dokumen ")
      ->result_array();

      $data = array(
        'user_upload' => $bagian,
        'nama_dokumen' => $nama_dokumen,
        'jenis_dokumen' => $jenis_dok,
        'tentang' => $tentang,
        'induk_dokumen' => $value->induk_dokumen,
        'tanggal_penetapan' => $cvt_tanggal_penetapan,
        'akses_for' => implode(",", $akses_for),
        'upload_dokumen' => $upload_dokumen
      );
      $this->model_dokumen->tambah_dokumen($data, 'hkm_dokumen');

      $last_id = $this->db->insert_id();
      $result = array();
      foreach($id_mencabut AS $key => $row){
      $data1[] = array(
        'id_dokumen' => $last_id,
        'id_dokumen_status' => $row['id_dokumen'],
        'status' => $status
       );
      }
      
      $this->db->insert_batch('hkm_dokumen_proses', $data1);

      $result = array();
      foreach($id_mencabut AS $key => $rows){
      $data2[] = array(
        'id_dokumen' => $rows['id_dokumen'],
        'id_dokumen_status' => $last_id,
        'status' => 'Mencabut'
       );
      }
      $this->db->insert_batch('hkm_dokumen_proses', $data2);

      redirect('c_pengelolah_dokumen/index');
      
    } elseif ($status == 'Mengubah') {

      $cari_induk_dokumen = $this->db->query("SELECT induk_dokumen FROM `hkm_dokumen` where id_dokumen = $dokumen_lama ")
      ->result();
      foreach ($cari_induk_dokumen as $value)
      $array[] = $value->induk_dokumen;

      $id_mencabut = $this->db->query("SELECT id_dokumen FROM `hkm_dokumen` where induk_dokumen = $value->induk_dokumen ")
      ->result_array();

      $data = array(
        'user_upload' => $bagian,
        'nama_dokumen' => $nama_dokumen,
        'jenis_dokumen' => $jenis_dok,
        'tentang' => $tentang,
        'induk_dokumen' => $value->induk_dokumen,
        'tanggal_penetapan' => $cvt_tanggal_penetapan,
        'akses_for' => implode(",", $akses_for),
        'upload_dokumen' => $upload_dokumen
      );
      $this->model_dokumen->tambah_dokumen($data, 'hkm_dokumen');

      $last_id = $this->db->insert_id();
      $result = array();
      foreach($id_mencabut AS $key => $row){
      $data1[] = array(
        'id_dokumen' => $last_id,
        'id_dokumen_status' => $row['id_dokumen'],
        'status' => $status
       );
      }
      
      $this->db->insert_batch('hkm_dokumen_proses', $data1);
      
      foreach($id_mencabut AS $key => $rows){
        $data2[] = array(
          'id_dokumen' => $rows['id_dokumen'],
          'id_dokumen_status' => $last_id,
          'status' => 'Diubah'
         );
        }

      $this->db->insert_batch('hkm_dokumen_proses', $data2);
      
      redirect('c_pengelolah_dokumen/index');

    } elseif ($status == 'Diubah') {

      $cari_induk_dokumen = $this->db->query("SELECT induk_dokumen FROM `hkm_dokumen` where id_dokumen = $dokumen_lama ")
      ->result();
      foreach ($cari_induk_dokumen as $value)
      $array[] = $value->induk_dokumen;

      $id_mencabut = $this->db->query("SELECT id_dokumen FROM `hkm_dokumen` where induk_dokumen = $value->induk_dokumen ")
      ->result_array();

      $data = array(
        'user_upload' => $bagian,
        'nama_dokumen' => $nama_dokumen,
        'jenis_dokumen' => $jenis_dok,
        'tentang' => $tentang,
        'induk_dokumen' => $value->induk_dokumen,
        'tanggal_penetapan' => $cvt_tanggal_penetapan,
        'akses_for' => implode(",", $akses_for),
        'upload_dokumen' => $upload_dokumen
      );
      $this->model_dokumen->tambah_dokumen($data, 'hkm_dokumen');
      
      $last_id = $this->db->insert_id();
      $result = array();
      foreach($id_mencabut AS $key => $row){
      $data1[] = array(
        'id_dokumen' => $last_id,
        'id_dokumen_status' => $row['id_dokumen'],
        'status' => $status
       );
      }
      $this->db->insert_batch('hkm_dokumen_proses', $data1);

      foreach($id_mencabut AS $key => $rows){
        $data2[] = array(
          'id_dokumen' => $rows['id_dokumen'],
          'id_dokumen_status' => $last_id,
          'status' => 'Mengubah'
        );
      }
      $this->db->insert_batch('hkm_dokumen_proses', $data2);
      redirect('c_pengelolah_dokumen/index');
    } 
    
    elseif ($status == 'Kombinasi') {
      $status = $this->input->post('status_kombinasi');
      $dokumen_lama = $this->input->post('dokumen_lama_kombinasi');
      $count = count($status);

      $data = array(
        'user_upload' => $bagian,
        'nama_dokumen' => $nama_dokumen,
        'jenis_dokumen' => $jenis_dok,
        'tentang' => $tentang,
        'induk_dokumen' => $induk_dokumen,
        'tanggal_penetapan' => $cvt_tanggal_penetapan,
        'akses_for' => implode(",", $akses_for),
        'upload_dokumen' => $upload_dokumen
      );

      $this->model_dokumen->tambah_dokumen($data, 'hkm_dokumen');
      $last_id = $this->db->insert_id();

      for ($k=0; $k < $count; $k++){ 
        $last_id_kombinasi = $last_id;
        $status_kombinasi = $status[$k];
        $dokumen_lama_kombinasi = $dokumen_lama[$k];

        // INDUK DOKUMEN
        $cari_induk_dokumen = $this->db->query("SELECT induk_dokumen FROM `hkm_dokumen` where id_dokumen = $dokumen_lama_kombinasi")->result();
        foreach ($cari_induk_dokumen as $value)
        $array[] = $value->induk_dokumen;

        // ID MENCABUT
        $id_mencabut = $this->db->query("SELECT id_dokumen FROM `hkm_dokumen` where induk_dokumen = $value->induk_dokumen")->result_array();

        // SIMPAN PROSES 1 
        foreach($id_mencabut AS $key => $row){
          $data1[$count] = array(
            'id_dokumen' => $last_id_kombinasi,
            'id_dokumen_status' => $row['id_dokumen'],
            'status' => $status_kombinasi
          );
          $this->db->insert_batch('hkm_dokumen_proses', $data1);
        }
    
        //SIMPAN PROSES 2
        if($status_kombinasi == "Mencabut"){
          foreach($id_mencabut AS $key => $rows){
            $data2[$count] = array(
              'id_dokumen' => $rows['id_dokumen'],
              'id_dokumen_status' => $last_id_kombinasi,
              'status' => 'Dicabut'
            );
            $this->db->insert_batch('hkm_dokumen_proses', $data2);
          }
        }

        elseif ($status_kombinasi == "Dicabut") {
          foreach($id_mencabut AS $key => $rows){
            $data2[$count] = array(
              'id_dokumen' => $rows['id_dokumen'],
              'id_dokumen_status' => $last_id_kombinasi,
              'status' => 'Mencabut'
            );
            $this->db->insert_batch('hkm_dokumen_proses', $data2);
          }
        } 

        elseif ($status_kombinasi == "Mengubah"){
            foreach($id_mencabut AS $key => $rows){
            $data2[$count] = array(
              'id_dokumen' => $rows['id_dokumen'],
              'id_dokumen_status' => $last_id_kombinasi,
              'status' => 'Diubah'
            );
            $this->db->insert_batch('hkm_dokumen_proses', $data2);
          }
        }

        elseif ($status_kombinasi == "Diubah"){
          foreach($id_mencabut AS $key => $rows){
            $data2[$count] = array(
              'id_dokumen' => $rows['id_dokumen'],
              'id_dokumen_status' => $last_id,
              'status' => 'Mengubah'
            );
            $this->db->insert_batch('hkm_dokumen_proses', $data2);
          }
        }
        $id_mencabut = $this->db->query("SELECT id_dokumen FROM `hkm_dokumen` where induk_dokumen = $value->induk_dokumen")->result_array();
          foreach($id_mencabut AS $key => $row){
          $updateinduk[] = array(
            'id_dokumen' => $row['id_dokumen'],
            'induk_dokumen' => $induk_dokumen
          );
        }

        $this->db->update_batch('hkm_dokumen',$updateinduk, 'id_dokumen');
      }
      
      redirect('c_pengelolah_dokumen/index');
    }

  }

  public function lakukan_download($data_dokumen)
  {
    $this->load->helper('download');

    if ($data_dokumen ==  '') {
      echo 'gagal';
    } else {
      force_download('uploads/' . $data_dokumen, NULL);
    }
  }

  public function edit_data_dokumen($id_dokumen)
  {
      $bagian = $this->session->userdata('bagian');
      $query_edit_dokumen = $this->db->query("SELECT *,hkm_dokumen.id_dokumen AS dkm_awal, hkm_dokumen_proses.status AS statuss  FROM `hkm_dokumen`
        LEFT JOIN hkm_master_jenis_dokumen ON hkm_dokumen.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen
        LEFT JOIN hkm_dokumen_proses ON hkm_dokumen.id_dokumen = hkm_dokumen_proses.id_dokumen_status
        LEFT JOIN tb_master_bagian ON hkm_dokumen.user_upload = tb_master_bagian.id_bagian
        WHERE hkm_dokumen.id_dokumen = '$id_dokumen'
        ORDER BY hkm_dokumen.id_dokumen DESC LIMIT 1");

      if ($bagian == 0) {
        $query_dokumen = $this->db->query("SELECT * FROM `hkm_dokumen`");
      }else {
        $query_dokumen = $this->db->query("SELECT * FROM `hkm_dokumen` WHERE user_upload = '$bagian'");
      }

      $data['data_dokumen_lama'] = $query_dokumen->result();
      $data['data_dokumen'] = $query_edit_dokumen->result();
      $data['master_bagian'] = $this->model_dokumen->tampil_data_bagian_kebun()->result();
      $data['jenis_dokumen'] = $this->model_dokumen->tampil_data_jenis_pengelolah_dokumen()->result();
      $data['user'] = $this->model_dokumen->tampil_data_user()->result();
      $this->load->view('edit-pengelolaan_dokumen',$data);
  }

  public function update_data_dokumen()
  {
    $id       = $this->session->userdata('bagian');
    $id_dokumen = $this->input->post('id');
    $nama_dokumen = $this->input->post('nama_dokumen');
    $jenis_dok = $this->input->post('jenis_dok');
    $pic = $this->input->post('pic');
    // $status = $this->input->post('status');
    $tanggal = date('Y/m/d');
    $akses_for = $_POST['akses_for'];
    foreach ($akses_for as $key ) {
      if($key == 'AKBN'){
        // $akses_for = $_POST['akses_for'];
        // if (($val = array_search($key, $akses_for)) !== false){
        //   unset($akses_for[$val]);
        // }
        $allkebun = $this->db->query("SELECT kode FROM `tb_master_bagian` WHERE id_bagian BETWEEN 18 AND 51")->result();
        foreach($allkebun as $all_kebun){
          if($all_kebun->kode){
            $data_allkebun[] = $all_kebun->kode;
          }
        }
        $all_kebun = array_merge($akses_for, $data_allkebun);
        $akses_for = $all_kebun;
      }

      elseif ($key == 'ABGN') {
        // $akses_for = $_POST['akses_for'];
        // if (($val = array_search($key, $akses_for)) !== false){
        //   unset($akses_for[$val]);
        // }
        $allbagian = $this->db->query("SELECT kode FROM `tb_master_bagian` WHERE id_bagian BETWEEN 3 AND 16")->result();
        foreach($allbagian as $all_bagian){
          if($all_bagian->kode){
            $data_allbagian[] = $all_bagian->kode;
          }
        }
        $all_kebun = array_merge($akses_for, $data_allbagian);
        $akses_for = $all_kebun;
      }

      elseif ($key == 'AB&K') {
        // $akses_for = $_POST['akses_for'];
        // if (($val = array_search($key, $akses_for)) !== false){
        //   unset($akses_for[$val]);
        // }
        $allbk = $this->db->query("SELECT kode FROM `tb_master_bagian` WHERE id_bagian BETWEEN 3 AND 51")->result();
        foreach($allbk as $all_bk){
          if($all_bk->kode){
            $data_allbk[] = $all_bk->kode;
          }
        }
        $all_kebun = array_merge($akses_for, $data_allbk);
        $akses_for = $all_kebun;
      }
      else {
        $akses_for = $_POST['akses_for'];
      }
    }
    
    $upload_dokument = $this->input->post('upload_dokument');
    $upload_dokumen = $_FILES['upload_dokumen']['name'];

    if ($upload_dokumen == null) {
      $data = array(
        'user_upload' => $id,
        'nama_dokumen' => $nama_dokumen,
        'jenis_dokumen' => $jenis_dok,
        'pic' => $pic,
        // 'status' => $status,
        'tanggal_penetapan' => $tanggal,
        'akses_for' => implode(",", $akses_for),
        'upload_dokumen' => $upload_dokument
      );
      $where = array('id_dokumen' => $id_dokumen);
      $this->model_dokumen->update_dokumen($where, $data, 'hkm_dokumen');
      redirect('c_pengelolah_dokumen/edit_data_dokumen/' . $id_dokumen);
    } else {
      $config['upload_path'] = './uploads';
      $config['allowed_types'] = '*';

      $this->load->library('upload', $config);
      if (!$this->upload->do_upload('upload_dokumen')) {
        echo "Gambar Gagal Upload !";
      } else {
        $upload_dokumen = $this->upload->data('file_name');
      }
      $data = array(
        'user_upload' => $id,
        'nama_dokumen' => $nama_dokumen,
        'jenis_dokumen' => $jenis_dok,
        'pic' => $pic,
        // 'status' => $status,
        'tanggal_penetapan' => $tanggal,
        'akses_for' => implode(",", $akses_for),
        'upload_dokumen' => $upload_dokumen
      );
      $where = array('id_dokumen' => $id_dokumen);
      $this->model_dokumen->update_dokumen($where, $data, 'hkm_dokumen');
      redirect('c_pengelolah_dokumen/edit_data_dokumen/' . $id_dokumen);
    }
  }

  public function delete($id)
  {
    $this->db->query("DELETE FROM `reminder_dok`.`hkm_dokumen` WHERE `hkm_dokumen`.`id_dokumen` = '$id'");
    redirect('c_pengelolah_dokumen/index');
  }

  public function lakukan_download_pemilik($data_dokumen, $id_dok)
  {
    $this->load->library('user_agent');
    $data['browser'] = $this->agent->browser();
    $data['os'] = $this->agent->platform();
    $data['ip_address'] = $this->input->ip_address();
    $MAC = exec('getmac');
    $MAC = strtok($MAC, ' ');
    $id = $this->session->userdata('id');
    $ip = $data['ip_address'];
    $browser = $data['browser'];
    $data = array(
      'id_dokumen' => $id_dok,
      'user_download' => $id,
      'ip' => $ip,
      'browser' => $browser,
      'mac' => $MAC
    );
    $this->model_dokumen->tambah_dokumen($data, 'hkm_dokumen_download');
    $this->load->helper('download');
    $datadok = $data_dokumen;
    force_download('uploads/' . $datadok, NULL);
  }

  public function kirim_email()
  {
    $config = [
      'mailtype' => 'html',
      'charset' => 'iso-8859-1',
      'protocol' => 'smtp',
      'smtp_host' => 'ssl://smtp.googlemail.com',
      'smtp_user' => 'fajarhansyah6@gmail.com',
      'smtp_pass' => 'supragtr2019',
      'smtp_port' => 465

    ];
    $this->load->library('email', $config);
    $this->email->initialize($config);

    $this->email->from('fajarhansyah6@gmail.com');
    $this->email->set_newline("\r\n");
    $this->email->to('fajarhansyah1@gmail.com');
    $this->email->subject('Coba tes');
    $this->email->message('tes aja');

    if ($this->email->send()) {
      $this->session->set_flashdata('something', 'Email Terkirim');
      redirect('c_pengelolah_dokumen/index');
    } else {
      show_error($this->email->print_debugger());
    }
  }

  public function lakukan_download_doc()
  {

    // $this->model_dokumen->tambah_dokumen($data, 'hkm_dokumen_download');
    // // $this->load->helper('download');

    // $datadok = $data_dokumen;
    // force_download('uploads/' . $datadok, NULL);

    $i=$this->input;
    $origFile = $i->post('url1');
    $destFile = $i->post('url2');
    $id = $i->post('id');
    $query_dokumen = $this->db->query("SELECT * FROM `hkm_dokumen_dms`WHERE hkm_dokumen_dms.id_dokumen = '$id' ");
    $data['data_dokumen'] = $query_dokumen->result_array();
    $data=array('origFile'=>$i->post('url1'),
                    'destFile'=>$i->post('url2'),
                    'id'=>$id,
                    'data'=>$data['data_dokumen'],
                  );
    $this->load->view('make_pass', $data);

    $username = $this->session->userdata('username');
    date_default_timezone_set('Asia/Jakarta');
    $tgl = date('Y-m-d H:i:s');

    $this->load->helper('string');
    $this->load->library('user_agent');
    $TOKEN = '3dccc869f03e7b';
    $data['browser'] = $this->agent->browser();
    $data['os'] = $this->agent->platform();
    $MAC = exec('getmac');
    $MAC = strtok($MAC, ' ');
    // $lacak_user = file_get_contents('http://ipinfo.io/'. $ip.'?token='.$TOKEN);
    $lacak_user = file_get_contents('https://ipinfo.io/?token='.$TOKEN.'');
    $lacak = json_decode($lacak_user);
    $browser = $data['browser'];
    $os = $data['os'];
    $kota = $lacak->city;
    $ip = $lacak->ip;;
    $daerah = $lacak->region;
    $negara = $lacak->country;
    $lokasi = $lacak->loc;
    $zonawaktu = $lacak->timezone;

    $aktivitas = "Download";
    $data = array(
      'id_dokumen' => $id,
      'username' => $username,
      'tgl' => $tgl,
      'ip' => $ip,
      'os'    =>$os,
      'kota'    =>$kota,
      'daerah'    =>$daerah,
      'negara'    =>$negara,
      'lokasi'    =>$lokasi,
      'zonawaktu'    =>$zonawaktu,
      'browser' => $browser,
      'mac' => $MAC,
      'aktivitas' => $aktivitas
    );
    $this->model_auth->tambah_log($data, 'tb_log');
    // $this->load->view('index1');

  }
}
