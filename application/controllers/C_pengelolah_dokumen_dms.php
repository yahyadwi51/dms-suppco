<?php
error_reporting(0);
use Dompdf\Dompdf;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
use setasign\Fpdi\PdfParser\StreamReader;

class C_pengelolah_dokumen_dms extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('encryption');
    if ($this->session->userdata('role_id') == '') {
      $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
          Anda Belum Login
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>');
      redirect('auth');
    }
    $this->load->model('model_dokumen');
  }

  public function doc_internal()
  {
    $id = $this->session->userdata('id');
    $role = $this->session->userdata('role_id');
    $bagian = $this->session->userdata('id_bagian');
    $username = $this->session->userdata('username');
    $id_region = $this->session->userdata('id_region');

    $this->session->set_userdata('item_dok', 'internal');

    // Role Admin HO (Admin DMS)
    if ($role == '6' || $role == '5') {
      $query_dokumen = $this->db->query("SELECT *,hkm_dokumen_dms.id_dokumen AS id_dkm_awal FROM `hkm_dokumen_dms`
      LEFT JOIN tb_master_bagian ON hkm_dokumen_dms.user_upload = tb_master_bagian.id_bagian
      LEFT JOIN hkm_master_jenis_dokumen ON hkm_dokumen_dms.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen
      WHERE hkm_master_jenis_dokumen.item_dokumen='Internal'  ORDER BY status_dok ASC, id_level_dok ASC, id_dkm_awal DESC");
    } else if ($role == '3' || $role == '4') {
      $query_dokumen = $this->db->query("SELECT *,hkm_dokumen_dms.id_dokumen AS id_dkm_awal FROM `hkm_dokumen_dms`
      LEFT JOIN tb_master_bagian ON hkm_dokumen_dms.user_upload = tb_master_bagian.id_bagian
      LEFT JOIN hkm_master_jenis_dokumen ON hkm_dokumen_dms.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen
      WHERE hkm_master_jenis_dokumen.item_dokumen='Internal' AND hkm_dokumen_dms.status_dok ='Dokumen Aktif' AND (hkm_dokumen_dms.id_regional LIKE '%$kd->kode%')  ORDER BY id_level_dok ASC, id_dkm_awal DESC");
    } else {
      $kode = $this->db->query("SELECT * FROM `tb_master_bagian` WHERE tb_master_bagian.id_bagian = '$bagian'")->result();
      foreach ($kode as $kd)
        $array[] = $kd->kode;

      $query_dokumen = $this->db->query("SELECT *,hkm_dokumen_dms.id_dokumen AS id_dkm_awal FROM `hkm_dokumen_dms`
      LEFT JOIN tb_master_bagian ON hkm_dokumen_dms.user_upload = tb_master_bagian.id_bagian
      LEFT JOIN hkm_master_jenis_dokumen ON hkm_dokumen_dms.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen
      WHERE hkm_master_jenis_dokumen.item_dokumen='Internal' AND hkm_dokumen_dms.status_dok ='Dokumen Aktif' AND (hkm_dokumen_dms.akses_for LIKE '%$kd->kode%')
      ORDER BY id_level_dok ASC, id_dkm_awal DESC");
    }

    $query_permintaan_download = $this->db->query("SELECT COUNT(*) AS jn FROM hkm_dokumen_dms 
      LEFT JOIN hkm_master_jenis_dokumen ON hkm_dokumen_dms.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen
      LEFT JOIN histori_download_jdih ON hkm_dokumen_dms.id_dokumen = histori_download_jdih.id_dokumen
      LEFT JOIN tb_user ON hkm_dokumen_dms.akses_for = tb_user.id
      WHERE histori_download_jdih.status = 'Request'");

    $data['user'] = $this->model_dokumen->tampil_data_user()->result();
    $data['jumlahnotifikasi'] = $query_permintaan_download->result_array();

    $data['data_dokumen'] = $query_dokumen->result_array(); // Mengenkripsi id_dokumen sebelum mengirimkannya ke view
    foreach ($data['data_dokumen'] as &$data_dokumen) {
      $data_dokumen['encrypted_id'] = $this->encryption->encrypt($data_dokumen['id_dokumen']);
      // Menghapus karakter yang tidak diinginkan
      $data_dokumen['encrypted_id'] = strtr($data_dokumen['encrypted_id'], array('/' => '=='));
    }

    $query_akses = $this->db->query("SELECT * FROM `tb_master_bagian` ");
    $query_dokstatus = $this->db->query("SELECT * FROM `hkm_dokumen_proses_dms` ORDER BY id_proses DESC ");
    $query_dokstatus_reg = $this->db->query("SELECT * FROM `hkm_dokumen_proses_dms` WHERE 'status' != 'Dicabut' OR 'status'!='Diubah' ORDER BY id_proses DESC ");

    $query_dokumen_master = $this->db->query("SELECT * FROM `hkm_dokumen_dms` ");
    $data['dokumen_master'] = $query_dokumen_master->result_array();
    $data['data_bagian'] = $query_akses->result();
    $data['jenis_dokumen'] = $this->model_dokumen->tampil_data_jenis_pengelolah_dokumen_internal()->result();

    $data['query_dokstatus'] = $query_dokstatus->result_array();
    $data['query_dok_reg'] = $query_dokstatus_reg->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('pengelolah_dokumen_dms', $data);
    $this->load->view('templates/footer');
  }


  public function doc_external()
  {
    $id = $this->session->userdata('id');
    $role = $this->session->userdata('role_id');
    $bagian = $this->session->userdata('id_bagian');
    $username = $this->session->userdata('username');
    $id_region = $this->session->userdata('id_region');

    $this->session->set_userdata('item_dok', 'internal');
    $this->session->set_userdata('item_dok', 'eksternal');


    // Role Admin HO (Admin DMS)
    if ($role == '6' || $role == '5') {
      $query_dokumen = $this->db->query("SELECT *,hkm_dokumen_dms.id_dokumen AS id_dkm_awal FROM `hkm_dokumen_dms`
      LEFT JOIN tb_master_bagian ON hkm_dokumen_dms.user_upload = tb_master_bagian.id_bagian
      LEFT JOIN hkm_master_jenis_dokumen ON hkm_dokumen_dms.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen
      WHERE hkm_master_jenis_dokumen.item_dokumen='Eksternal'  ORDER BY status_dok ASC, id_level_dok ASC, id_dkm_awal DESC");
    } else if ($role == '3' || $role == '4') {
      $query_dokumen = $this->db->query("SELECT *,hkm_dokumen_dms.id_dokumen AS id_dkm_awal FROM `hkm_dokumen_dms`
      LEFT JOIN tb_master_bagian ON hkm_dokumen_dms.user_upload = tb_master_bagian.id_bagian
      LEFT JOIN hkm_master_jenis_dokumen ON hkm_dokumen_dms.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen
      WHERE hkm_master_jenis_dokumen.item_dokumen='Eksternal' AND hkm_dokumen_dms.status_dok ='Dokumen Aktif' AND (hkm_dokumen_dms.id_regional LIKE '%$kd->kode%')  ORDER BY id_level_dok ASC, id_dkm_awal DESC");
    } else {
      $kode = $this->db->query("SELECT * FROM `tb_master_bagian` WHERE tb_master_bagian.id_bagian = '$bagian'")->result();
      foreach ($kode as $kd)
        $array[] = $kd->kode;

      $query_dokumen = $this->db->query("SELECT *,hkm_dokumen_dms.id_dokumen AS id_dkm_awal FROM `hkm_dokumen_dms`
      LEFT JOIN tb_master_bagian ON hkm_dokumen_dms.user_upload = tb_master_bagian.id_bagian
      LEFT JOIN hkm_master_jenis_dokumen ON hkm_dokumen_dms.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen
      WHERE hkm_master_jenis_dokumen.item_dokumen='Eksternal' AND hkm_dokumen_dms.status_dok ='Dokumen Aktif' AND (hkm_dokumen_dms.akses_for LIKE '%$kd->kode%')
      ORDER BY id_level_dok ASC, id_dkm_awal DESC");
    }

    $query_permintaan_download = $this->db->query("SELECT COUNT(*) AS jn FROM hkm_dokumen_dms 
      LEFT JOIN hkm_master_jenis_dokumen ON hkm_dokumen_dms.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen
      LEFT JOIN histori_download_jdih ON hkm_dokumen_dms.id_dokumen = histori_download_jdih.id_dokumen
      LEFT JOIN tb_user ON hkm_dokumen_dms.akses_for = tb_user.id
      WHERE histori_download_jdih.status = 'Request'");

    $data['user'] = $this->model_dokumen->tampil_data_user()->result();
    $data['jumlahnotifikasi'] = $query_permintaan_download->result_array();

    $data['data_dokumen'] = $query_dokumen->result_array(); // Mengenkripsi id_dokumen sebelum mengirimkannya ke view
    foreach ($data['data_dokumen'] as &$data_dokumen) {
      $data_dokumen['encrypted_id'] = $this->encryption->encrypt($data_dokumen['id_dokumen']);
      // Menghapus karakter yang tidak diinginkan
      $data_dokumen['encrypted_id'] = strtr($data_dokumen['encrypted_id'], array('/' => '=='));
    }

    $query_akses = $this->db->query("SELECT * FROM `tb_master_bagian` ");
    $query_dokstatus = $this->db->query("SELECT * FROM `hkm_dokumen_proses_dms` ORDER BY id_proses DESC ");
    $query_dokstatus_reg = $this->db->query("SELECT * FROM `hkm_dokumen_proses_dms` WHERE 'status' != 'Dicabut' OR 'status'!='Diubah' ORDER BY id_proses DESC ");

    $query_dokumen_master = $this->db->query("SELECT * FROM `hkm_dokumen_dms` ");
    $data['dokumen_master'] = $query_dokumen_master->result_array();
    $data['data_bagian'] = $query_akses->result();
    $data['jenis_dokumen'] = $this->model_dokumen->tampil_data_jenis_pengelolah_dokumen_internal()->result();

    $data['query_dokstatus'] = $query_dokstatus->result_array();
    $data['query_dok_reg'] = $query_dokstatus_reg->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('pengelolah_dokumen_dms', $data);
    $this->load->view('templates/footer');
  }

  public function detail_dum($id_dkm)
  {
    // Mengembalikan karakter-karakter yang dihilangkan sebelumnya
    $id_dkm = str_replace(array('=='), array('/'), $id_dkm);
    $id_dkm = $this->encryption->decrypt($id_dkm);

    $query_dokumen_master = $this->db->query("SELECT * FROM `hkm_dokumen_dms` ");
    $data['dokumen_master'] = $query_dokumen_master->result_array();

    $data['region_user'] = $this->db->query("SELECT DISTINCT id_regional, nama_regional FROM tb_regional_n2 
    LEFT JOIN tb_user ON tb_user.id_region = tb_regional_n2.id_regional")->result_array();

    $query_view_down_doc = $this->db->query("SELECT * FROM `v_count_view_down_doc` where id_dokumen='$id_dkm' ");
    $data['view_down_doc'] = $query_view_down_doc->result_array();

    $query_dokumen = $this->db->query("SELECT * FROM `hkm_dokumen_dms`
    LEFT JOIN hkm_master_jenis_dokumen ON hkm_dokumen_dms.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen 
    LEFT JOIN  master_media_simpan ON hkm_dokumen_dms.id_media_simpan_dok = master_media_simpan.id_media_simpan_dok
    WHERE hkm_dokumen_dms.id_dokumen = '$id_dkm' ");
    $data['data_dokumen'] = $query_dokumen->result_array();

    $query_download_dok = $this->db->query("SELECT nama_dokumen, 
    (SELECT COUNT(id_dokumen) FROM tb_log WHERE id_dokumen = hkm_dokumen_dms.id_dokumen AND hkm_dokumen_dms.id_dokumen = '$id_dkm' AND aktivitas = 'Download') AS jumlah 
    FROM hkm_dokumen_dms 
    WHERE hkm_dokumen_dms.id_dokumen = '$id_dkm'
    ORDER BY jumlah DESC 
    LIMIT 5");
    $data['download_terbanyak'] = $query_download_dok->result_array();

    $query_view_akses = $this->db->query("SELECT COUNT(tb_log.id_dokumen) AS jumlah_view
                                     FROM tb_log 
                                     JOIN hkm_dokumen_dms ON tb_log.id_dokumen = hkm_dokumen_dms.id_dokumen 
                                     WHERE tb_log.aktivitas = 'view' AND hkm_dokumen_dms.id_dokumen = '$id_dkm' 
                                     ORDER BY tb_log.tgl DESC 
                                     LIMIT 5");
    $result = $query_view_akses->row();
    $data['view_akses'] = $result->jumlah_view;

    // Mendekripsi Password sebelum mengirimkannya ke view
    foreach ($data['data_dokumen'] as &$data_dokumen) {
      // Mendekripsi password yang diambil dari database
      $decrypted_password = $this->encryption->decrypt($data_dokumen['password']);
      // Menyimpan password yang telah didekripsi ke dalam array data_dokumen
      $data_dokumen['decrypt_password'] = $decrypted_password;
    }

    // ==================================================================================
    $query_req = $this->db->query("SELECT * FROM `hkm_dokumen_dms`
    right JOIN  request_dokumen ON hkm_dokumen_dms.id_dokumen = request_dokumen.id_dokumen
    WHERE hkm_dokumen_dms.id_dokumen='$id_dkm' ");
    $data['data_req'] = $query_req->result_array();


    // Query Dokstatus
    $this->db->select('*');
    $this->db->from('hkm_dokumen_proses_dms');
    $this->db->join('hkm_dokumen_dms', 'hkm_dokumen_proses_dms.id_dokumen = hkm_dokumen_dms.id_dokumen');
    $this->db->order_by('hkm_dokumen_proses_dms.id_proses', 'DESC');
    $query_dokstatus = $this->db->get();
    $data['query_dokstatus'] = $query_dokstatus->result_array();

    // Query data_bagian  
    $this->db->select('tb_master_bagian.*, tb_regional_n2.*');
    $this->db->from('tb_master_bagian');
    $this->db->join('tb_regional_n2', 'tb_master_bagian.id_region = tb_regional_n2.id_regional');
    $query_bagian = $this->db->get();
    $data['data_bagian'] = $query_bagian->result();

    // Query data_regional
    $this->db->select('tb_regional_n2.*');
    $this->db->from('tb_regional_n2');
    $query_regional = $this->db->get();
    $data['data_regional'] = $query_regional->result();

    // print_r($data['data_regional']);
    // die();

    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('detail_pengelolah_data_apn', $data);
    $this->load->view('templates/footer');

  }

  public function rekam_log_view()
  {
    $documentId = $this->input->post('id');

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
    $lacak_user = file_get_contents('https://ipinfo.io/?token=' . $TOKEN . '');
    $lacak = json_decode($lacak_user);
    $browser = $data['browser'];
    $os = $data['os'];
    $kota = $lacak->city;
    $ip = $lacak->ip;
    ;
    $daerah = $lacak->region;
    $negara = $lacak->country;
    $lokasi = $lacak->loc;
    $zonawaktu = $lacak->timezone;

    $aktivitas = "View";
    $data = array(
      'id_dokumen' => $documentId,
      'username' => $username,
      'tgl' => $tgl,
      'ip' => $ip,
      'os' => $os,
      'kota' => $kota,
      'daerah' => $daerah,
      'negara' => $negara,
      'lokasi' => $lokasi,
      'zonawaktu' => $zonawaktu,
      'browser' => $browser,
      'mac' => $MAC,
      'aktivitas' => $aktivitas
    );
    $this->model_auth->tambah_log($data, 'tb_log');

  }

  public function form_data_dokumen_int()
  {
    $role = $this->session->userdata('role_id');
    $id_region = $this->session->userdata('id_region');
    $this->session->set_userdata('halaman', 'data_jdih');

    $region_user_query = $this->db->get('tb_regional_n2');
    $region_user = $region_user_query->result_array();

    array_push(
      $region_user,
      [
        "id_regional" => 99,
        "nama_regional" => "All Region"
      ]
    );

    $data['regionuser'] = $region_user;

    //Level Dokumen
    $level_dokumen_query = $this->db->query("SELECT * FROM `master_level_dokumen`");
    $level_dokumen = $level_dokumen_query->result_array();
    $data['level_dokumen'] = $level_dokumen;

    //Jenis Dokumen Internal
    $jenis_dokumen_int = $this->db->query("SELECT * FROM `hkm_master_jenis_dokumen` WHERE item_dokumen = 'Internal'");
    $jenis_dok_int = $jenis_dokumen_int->result();
    $data['jenis_dok_int'] = $jenis_dok_int;

    //Bagian Penerbit Dokumen
    $bag_penerbit_query = $this->db->query("SELECT * FROM `tb_master_bagian`");
    $bag_penerbit = $bag_penerbit_query->result_array();
    $data['bag_penerbit'] = $bag_penerbit;

    //Media Simpan Dokumen
    $media_spmpn_query = $this->db->query("SELECT * FROM `master_media_simpan`");
    $media_spmn = $media_spmpn_query->result_array();
    $data['media_spmn'] = $media_spmn;


    $query_dokumen = $this->db->query("SELECT * FROM `hkm_dokumen_dms` WHERE item_dokumen = 'Dokumen Internal' AND status_dok='Dokumen Aktif'");
    $id_dok_akhir = $this->db->query("SELECT id_dokumen FROM `hkm_dokumen_dms` ORDER BY id_dokumen desc limit 1");
    $data['id_dok_akhir'] = $id_dok_akhir->result();
    $data['data_dokumen_lama'] = $query_dokumen->result();
    $data['master_bagian'] = $this->model_dokumen->tampil_data_bagian_kebun()->result();
    // $data['jenis_dokumen'] = $this->model_dokumen->tampil_data_jenis_pengelolah_dokumen()->result();
    $data['user'] = $this->model_dokumen->tampil_data_user()->result();

    $allbagian = $this->db->query("SELECT * FROM `tb_master_bagian` WHERE id_bagian BETWEEN 3 AND 16");
    $allkebun = $this->db->query("SELECT * FROM `tb_master_bagian` WHERE id_bagian BETWEEN 18 AND 51");
    $allbk = $this->db->query("SELECT * FROM `tb_master_bagian` WHERE id_bagian BETWEEN 3 AND 51");
    $data['all_bagian'] = $allbagian->result();
    $data['all_kebun'] = $allkebun->result();
    $data['all_bk'] = $allbk->result();

    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('tambah-pengelolah_dokumen_dms', $data);
    $this->load->view('templates/footer');
  }

  public function form_data_dokumen_eks()
  {
    $role = $this->session->userdata('role_id');
    $id_region = $this->session->userdata('id_region');
    $this->session->set_userdata('halaman', 'data_jdih');

    $region_user_query = $this->db->get('tb_regional_n2');
    $region_user = $region_user_query->result_array();

    array_push(
      $region_user,
      [
        "id_regional" => 99,
        "nama_regional" => "All Region"
      ]
    );

    $data['regionuser'] = $region_user;

    //Level Dokumen
    $level_dokumen_query = $this->db->query("SELECT * FROM `master_level_dokumen`");
    $level_dokumen = $level_dokumen_query->result_array();
    $data['level_dokumen'] = $level_dokumen;

    //Jenis Dokumen Eksternal
    $jenis_dokumen_eks = $this->db->query("SELECT * FROM `hkm_master_jenis_dokumen` WHERE item_dokumen = 'Eksternal'");
    $jenis_dok_eks = $jenis_dokumen_eks->result();
    $data['jenis_dok_eks'] = $jenis_dok_eks;

    //Bagian Penerbit Dokumen
    $bag_penerbit_query = $this->db->query("SELECT * FROM `tb_master_bagian`");
    $bag_penerbit = $bag_penerbit_query->result_array();
    $data['bag_penerbit'] = $bag_penerbit;

    //Media Simpan Dokumen
    $media_spmpn_query = $this->db->query("SELECT * FROM `master_media_simpan`");
    $media_spmn = $media_spmpn_query->result_array();
    $data['media_spmn'] = $media_spmn;


    $query_dokumen = $this->db->query("SELECT * FROM `hkm_dokumen_dms` WHERE item_dokumen = 'Dokumen Eksternal'");
    $id_dok_akhir = $this->db->query("SELECT id_dokumen FROM `hkm_dokumen_dms` ORDER BY id_dokumen desc limit 1");
    $data['id_dok_akhir'] = $id_dok_akhir->result();
    $data['data_dokumen_lama'] = $query_dokumen->result();
    $data['master_bagian'] = $this->model_dokumen->tampil_data_bagian_kebun()->result();
    // $data['jenis_dokumen'] = $this->model_dokumen->tampil_data_jenis_pengelolah_dokumen()->result();
    $data['user'] = $this->model_dokumen->tampil_data_user()->result();

    $allbagian = $this->db->query("SELECT * FROM `tb_master_bagian` WHERE id_bagian BETWEEN 3 AND 16");
    $allkebun = $this->db->query("SELECT * FROM `tb_master_bagian` WHERE id_bagian BETWEEN 18 AND 51");
    $allbk = $this->db->query("SELECT * FROM `tb_master_bagian` WHERE id_bagian BETWEEN 3 AND 51");
    $data['all_bagian'] = $allbagian->result();
    $data['all_kebun'] = $allkebun->result();
    $data['all_bk'] = $allbk->result();

    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('tambah-pengelolah_dokumen_dms', $data);
    $this->load->view('templates/footer');
  }

  public function form_data_dokumen_error()
  {
    $this->session->set_flashdata('error_message', 'Pesan Terkirim');

    // $this->session->set_userdata('halaman', 'data_jdih');

    // $query_dokumen = $this->db->query("SELECT * FROM `hkm_dokumen_dms`");
    // $id_dok_akhir = $this->db->query("SELECT id_dokumen FROM `hkm_dokumen_dms` ORDER BY id_dokumen desc limit 1");
    // $data['id_dok_akhir'] = $id_dok_akhir->result();
    // $data['data_dokumen_lama'] = $query_dokumen->result();
    // $data['master_bagian'] = $this->model_dokumen->tampil_data_bagian_kebun()->result();
    // $data['jenis_dokumen'] = $this->model_dokumen->tampil_data_jenis_pengelolah_dokumen()->result();
    // $data['user'] = $this->model_dokumen->tampil_data_user()->result();

    // //Level Dokumen
    // $data['jenis_dokumen'] = $this->model_dokumen->tampil_data_jenis_pengelolah_dokumen()->result();

    // $allbagian = $this->db->query("SELECT * FROM `tb_master_bagian` WHERE id_bagian BETWEEN 3 AND 16");
    // $allkebun = $this->db->query("SELECT * FROM `tb_master_bagian` WHERE id_bagian BETWEEN 18 AND 51");
    // $allbk = $this->db->query("SELECT * FROM `tb_master_bagian` WHERE id_bagian BETWEEN 3 AND 51");
    // $data['all_bagian'] = $allbagian->result();
    // $data['all_kebun'] = $allkebun->result();
    // $data['all_bk'] = $allbk->result();

    redirect('c_pengelolah_dokumen_dms/form_data_dokumen_int');
  }

  public function permintaan_download_jdih()
  {
    $id_pem_dokumen = $this->session->userdata('id');
    $query_download_jdih = $this->db->query("SELECT *,hkm_dokumen_dms.id_dokumen AS iddkm,histori_download_jdih.id AS idhistori FROM hkm_dokumen_dms 
    LEFT JOIN histori_download_jdih ON hkm_dokumen_dms.id_dokumen = histori_download_jdih.id_dokumen
    LEFT JOIN tb_user ON hkm_dokumen_dms.akses_for = tb_user.id
    WHERE histori_download_jdih.status != '' ORDER BY idhistori DESC");

    $data['data_download_jdih'] = $query_download_jdih->result_array();
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('permintaan_download_jdih', $data);
    $this->load->view('templates/footer');
  }

  public function tolak_permintaan_download_jdih()
  {
    $idhistori = $this->input->post('idhistori');
    $kode_generate = '-';
    $status = 'Ditolak';
    $data1 = array(
      'status' => $status,
      'kode_unik' => $kode_generate
    );
    $where1 = array('id' => $idhistori);
    $this->model_dokumen->update_dokumen($where1, $data1, 'histori_download_jdih');
    $this->session->set_flashdata('something1', 'Pesan Terkirim');
    redirect('c_pengelolah_dokumen_dms/permintaan_download_jdih');
  }

  public function tambah_data_dokumen_dms()
  {
    $this->session->set_flashdata('success_message', 'Pesan Terkirim');
    $id = $this->session->userdata('id');
    $item_dok_param = $this->session->userdata('item_dok');
    // $bagian = $this->input->post('bagian');
    $jenis_dok = $this->input->post('jenis_dok');
    $tentang = $this->input->post('tentang');
    $id_dok_akhir = $this->input->post('id_dok_akhir');
    // $cvt_tanggal_penetapan = date('Y-m-d', strtotime($tanggal_penetapan));
    $dokumen_lama = $this->input->post('dokumen_lama');

    //JDIH Modul
    $customRadioInternal = $this->input->post('customRadioInternal');
    $customRadioEksternal = $this->input->post('customRadioEksternal');

    $level_dokumen = $this->input->post('level_dokumen');
    $nomor_dokumen = $this->input->post('nomor_dokumen');
    $tanggal_terbit = $this->input->post('tanggal_terbit');
    $tanggal_tetap = $this->input->post('tanggal_tetap');
    $nama_dokumen = $this->input->post('nama_dokumen');
    $bag_penerbit = $this->input->post('bag_penerbit');
    $indeks_dokumen = $this->input->post('indeks_dokumen');
    $media_spmn = $this->input->post('media_spmn');
    $tglSimpanawal = $this->input->post('tglSimpanawal');
    $tglSimpanakhir = $this->input->post('tglSimpanakhir');
    $item_dok = $this->input->post('item_dok');
    $password = $this->input->post('password_dok');
    $status_rev = $this->input->post('status_rev');
    $status_dok = $this->input->post('status_dok');
    $tanggal_rev = $this->input->post('tanggal_rev');

    if ($this->input->post('region') === '99') {
      $data_allreg = $this->db->select('id_regional')->get('tb_regional_n2')->result_array();
      $allregion = array_column($data_allreg, 'id_regional');
      $region = implode(",", $allregion);
    } else {
      $region = $this->input->post('region');
    }

    $status_rev_combined = $status_rev . '/' . $tanggal_rev;

    // Mengenkripsi password sebelum disimpan ke database
    $password = $this->encryption->encrypt($password);

    $upload_dokumen = $_FILES['upload_dokumen']['name'];

    $induk_dokumen = $id_dok_akhir + 1;
    $akses_for = $_POST['akses_for'];
    $status = $this->input->post('status');


    //$hashedpassword = $this->password->hash({$password});
    foreach ($akses_for as $key) {
      if ($key == 'ABGN') {
        $allbagian = $this->db->query("SELECT kode FROM `tb_master_bagian`")->result();
        foreach ($allbagian as $all_bagian) {
          if ($all_bagian->kode) {
            $data_allbagian[] = $all_bagian->kode;
          }
        }
        $all_kebun = array_merge($akses_for, $data_allbagian);
        $akses_for = $all_kebun;
      } else {
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
      // 'user_upload' => $bagian,
      'nama_dokumen' => $nama_dokumen,
      'jenis_dokumen' => $jenis_dok,
      'tentang' => $tentang,
      'induk_dokumen' => $induk_dokumen,
      'item_dokumen' => $item_dok,
      'id_level_dok' => $level_dokumen,
      'id_media_simpan_dok	' => $media_spmn,
      'no_dokumen' => $nomor_dokumen,
      'tgl_terbit' => $tanggal_terbit,
      'tgl_tetap' => $tanggal_tetap,
      'id_regional' => $region,
      'bagian_penerbit' => $bag_penerbit,
      'metode_indeks' => $indeks_dokumen,
      'lama_simpan_awal' => $tglSimpanawal,
      'lama_simpan_akhir' => $tglSimpanakhir,
      // 'tanggal_penetapan' => $cvt_tanggal_penetapan,
      'akses_for' => implode(",", $akses_for),
      'upload_dokumen' => $upload_dokumen,
      'status_rev' => $status_rev_combined,
      'status_dok' => $status_dok
    );
    $this->session->set_userdata($data_session);

    // CHECK TYPE PDF
    require_once(APPPATH . 'libraries/fpdf/fpdf.php');
    require_once(APPPATH . 'libraries/fpdi/FPDI/src/autoload.php');
    //Set the source PDF file
    $pdf = new Fpdi();

    // menampilkan hasil curl
    $fileContent = file_get_contents(base_url('uploads/' . $upload_dokumen));
    $pageCount = $pdf->setSourceFile(StreamReader::createByString($fileContent));


    if ($status == 'Baru') {
      $data = array(
        // 'user_upload' => $bagian,
        'nama_dokumen' => $nama_dokumen,
        'jenis_dokumen' => $jenis_dok,
        'tentang' => $tentang,
        'induk_dokumen' => $induk_dokumen,
        'item_dokumen' => $item_dok,
        // 'jenis_dokumen' => $jenis_dok,
        'id_level_dok' => $level_dokumen,
        'id_media_simpan_dok	' => $media_spmn,
        'no_dokumen' => $nomor_dokumen,
        'tgl_terbit' => $tanggal_terbit,
        'tgl_tetap' => $tanggal_tetap,
        'id_regional' => $region,
        'bagian_penerbit' => $bag_penerbit,
        'metode_indeks' => $indeks_dokumen,
        'lama_simpan_awal' => $tglSimpanawal,
        'lama_simpan_akhir' => $tglSimpanakhir,
        // 'tanggal_penetapan' => $cvt_tanggal_penetapan,
        'akses_for' => implode(",", $akses_for),
        'upload_dokumen' => $upload_dokumen,
        'password' => $password,
        'status_rev' => $status_rev_combined,
        'status_dok' => $status_dok
      );

      $this->model_dokumen->tambah_dokumen($data, 'hkm_dokumen_dms');
      $last_id = $this->db->insert_id();
      $data1 = array(
        'id_dokumen' => $last_id,
        'id_dokumen_status' => $dokumen_lama,
        'status' => $status
      );

      // $this->model_dokumen->tambah_dokumen($data1, 'hkm_dokumen_proses');
      // $this->session->set_userdata('status_perubahan', 'baru');

      if ($item_dok_param == 'internal') {
        redirect('c_pengelolah_dokumen_dms/doc_internal');
      } else if ($item_dok_param == 'eksternal') {
        redirect('c_pengelolah_dokumen_dms/doc_external');
      }

    } elseif ($status == 'Mencabut') {
      $cari_induk_dokumen = $this->db->query("SELECT induk_dokumen FROM `hkm_dokumen_dms` where id_dokumen = $dokumen_lama ")
        ->result();
      foreach ($cari_induk_dokumen as $value)
        $array[] = $value->induk_dokumen;

      $id_mencabut = $this->db->query("SELECT id_dokumen FROM `hkm_dokumen_dms` where induk_dokumen = $value->induk_dokumen ")
        ->result_array();

      $data = array(
        // 'user_upload' => $bagian,
        'nama_dokumen' => $nama_dokumen,
        'jenis_dokumen' => $jenis_dok,
        'tentang' => $tentang,
        'induk_dokumen' => $value->induk_dokumen,
        'item_dokumen' => $item_dok,
        'induk_dokumen' => $induk_dokumen,
        // 'jenis_dokumen' => $jenis_dok,
        'id_level_dok' => $level_dokumen,
        'id_media_simpan_dok	' => $media_spmn,
        'no_dokumen' => $nomor_dokumen,
        'tgl_terbit' => $tanggal_terbit,
        'tgl_tetap' => $tanggal_tetap,
        'id_regional' => $region,
        'bagian_penerbit' => $bag_penerbit,
        'metode_indeks' => $indeks_dokumen,
        'lama_simpan_awal' => $tglSimpanawal,
        'lama_simpan_akhir' => $tglSimpanakhir,
        // 'tanggal_penetapan' => $cvt_tanggal_penetapan,
        'akses_for' => implode(",", $akses_for),
        'upload_dokumen' => $upload_dokumen,
        'password' => $password,
        'status_rev' => $status_rev_combined,
        'status_dok' => $status_dok
      );

      $this->model_dokumen->tambah_dokumen($data, 'hkm_dokumen_dms');

      $last_id = $this->db->insert_id();
      $result = array(); foreach ($id_mencabut as $key => $row) {
        $data1[] = array(
          'id_dokumen' => $last_id,
          'id_dokumen_status' => $row['id_dokumen'],
          'status' => $status
        );
      }

      $this->db->insert_batch('hkm_dokumen_proses_dms', $data1);

      $result = array();
      foreach ($id_mencabut as $key => $rows) {
        $data2[] = array(
          'id_dokumen' => $rows['id_dokumen'],
          'id_dokumen_status' => $last_id,
          'status' => 'Dicabut'
        );
      }

      $this->db->insert_batch('hkm_dokumen_proses_dms', $data2);

      // $this->session->set_userdata('status_perubahan', 'mencabut');
      // ======================Dokumen Non-Aktif
      $data = array(
        'status_dok' => 'Dokumen Non-Aktif'
      );
      // var_dump($data);

      $where = array('id_dokumen' => $dokumen_lama);
      // var_dump($where);
      $this->model_dokumen->update_dokumen($where, $data, 'hkm_dokumen_dms');


      if ($item_dok_param == 'internal') {
        redirect('c_pengelolah_dokumen_dms/doc_internal');
      } else if ($item_dok_param == 'eksternal') {
        redirect('c_pengelolah_dokumen_dms/doc_external');
      }
    } elseif ($status == 'Dicabut') {
      $cari_induk_dokumen = $this->db->query("SELECT induk_dokumen FROM `hkm_dokumen_dms` where id_dokumen = $dokumen_lama ")
        ->result();
      foreach ($cari_induk_dokumen as $value)
        $array[] = $value->induk_dokumen;

      $id_mencabut = $this->db->query("SELECT id_dokumen FROM `hkm_dokumen_dms` where induk_dokumen = $value->induk_dokumen ")
        ->result_array();

      $data = array(
        // 'user_upload' => $bagian,
        'nama_dokumen' => $nama_dokumen,
        'jenis_dokumen' => $jenis_dok,
        'tentang' => $tentang,
        'induk_dokumen' => $value->induk_dokumen,
        'item_dokumen' => $item_dok,
        'induk_dokumen' => $induk_dokumen,
        // 'jenis_dokumen' => $jenis_dok,
        'id_level_dok' => $level_dokumen,
        'id_regional' => $region,
        'id_media_simpan_dok	' => $media_spmn,
        'no_dokumen' => $nomor_dokumen,
        'tgl_terbit' => $tanggal_terbit,
        'tgl_tetap' => $tanggal_tetap,
        'bagian_penerbit' => $bag_penerbit,
        'metode_indeks' => $indeks_dokumen,
        'lama_simpan_awal' => $tglSimpanawal,
        'lama_simpan_akhir' => $tglSimpanakhir,
        // 'tanggal_penetapan' => $cvt_tanggal_penetapan,
        'akses_for' => implode(",", $akses_for),
        'upload_dokumen' => $upload_dokumen,
        'password' => $password,
        'status_rev' => $status_rev_combined,
        'status_dok' => $status_dok
      );
      $this->model_dokumen->tambah_dokumen($data, 'hkm_dokumen_dms');

      $last_id = $this->db->insert_id();
      $result = array(); foreach ($id_mencabut as $key => $row) {
        $data1[] = array(
          'id_dokumen' => $last_id,
          'id_dokumen_status' => $row['id_dokumen'],
          'status' => $status
        );
      }

      $this->db->insert_batch('hkm_dokumen_proses_dms', $data1);

      $result = array();
      foreach ($id_mencabut as $key => $rows) {
        $data2[] = array(
          'id_dokumen' => $rows['id_dokumen'],
          'id_dokumen_status' => $last_id,
          'status' => 'Mencabut'
        );
      }

      $this->db->insert_batch('hkm_dokumen_proses_dms', $data2);
      // $this->session->set_userdata('status_perubahan', 'dicabut');
      // ======================Dokumen Non-Aktif
      $data = array(
        'status_dok' => 'Dokumen Non-Aktif'
      );
      // var_dump($data);

      $where = array('id_dokumen' => $dokumen_lama);
      // var_dump($where);
      $this->model_dokumen->update_dokumen($where, $data, 'hkm_dokumen_dms');


      if ($item_dok_param == 'internal') {
        redirect('c_pengelolah_dokumen_dms/doc_internal');
      } else if ($item_dok_param == 'eksternal') {
        redirect('c_pengelolah_dokumen_dms/doc_external');
      }
    } elseif ($status == 'Mengubah') {

      $cari_induk_dokumen = $this->db->query("SELECT induk_dokumen FROM `hkm_dokumen_dms` where id_dokumen = $dokumen_lama ")
        ->result();
      foreach ($cari_induk_dokumen as $value)
        $array[] = $value->induk_dokumen;

      $id_mencabut = $this->db->query("SELECT id_dokumen FROM `hkm_dokumen_dms` where induk_dokumen = $value->induk_dokumen ")
        ->result_array();

      $data = array(
        // 'user_upload' => $bagian,
        'nama_dokumen' => $nama_dokumen,
        'jenis_dokumen' => $jenis_dok,
        'tentang' => $tentang,
        'induk_dokumen' => $value->induk_dokumen,
        'item_dokumen' => $item_dok,
        'induk_dokumen' => $induk_dokumen,
        // 'jenis_dokumen' => $jenis_dok,
        'id_level_dok' => $level_dokumen,
        'id_media_simpan_dok	' => $media_spmn,
        'id_regional' => $region,
        'no_dokumen' => $nomor_dokumen,
        'tgl_terbit' => $tanggal_terbit,
        'tgl_tetap' => $tanggal_tetap,
        'bagian_penerbit' => $bag_penerbit,
        'metode_indeks' => $indeks_dokumen,
        'lama_simpan_awal' => $tglSimpanawal,
        'lama_simpan_akhir' => $tglSimpanakhir,
        // 'tanggal_penetapan' => $cvt_tanggal_penetapan,
        'akses_for' => implode(",", $akses_for),
        'upload_dokumen' => $upload_dokumen,
        'password' => $password,
        'status_rev' => $status_rev_combined,
        'status_dok' => $status_dok
      );
      $this->model_dokumen->tambah_dokumen($data, 'hkm_dokumen_dms');


      $last_id = $this->db->insert_id();
      $result = array(); foreach ($id_mencabut as $key => $row) {
        $data1[] = array(
          'id_dokumen' => $last_id,
          'id_dokumen_status' => $row['id_dokumen'],
          'status' => $status
        );
      }

      $this->db->insert_batch('hkm_dokumen_proses_dms', $data1);

      foreach ($id_mencabut as $key => $rows) {
        $data2[] = array(
          'id_dokumen' => $rows['id_dokumen'],
          'id_dokumen_status' => $last_id,
          'status' => 'Diubah'
        );
      }

      $this->db->insert_batch('hkm_dokumen_proses_dms', $data2);
      // $this->session->set_userdata('status_perubahan', 'mengubah');
      // ======================Dokumen Non-Aktif
      $data = array(
        'status_dok' => 'Dokumen Non-Aktif'
      );
      // var_dump($data);

      $where = array('id_dokumen' => $dokumen_lama);
      // var_dump($where);
      $this->model_dokumen->update_dokumen($where, $data, 'hkm_dokumen_dms');


      if ($item_dok_param == 'internal') {
        redirect('c_pengelolah_dokumen_dms/doc_internal');
      } else if ($item_dok_param == 'eksternal') {
        redirect('c_pengelolah_dokumen_dms/doc_external');
      }

    } elseif ($status == 'Diubah') {

      $cari_induk_dokumen = $this->db->query("SELECT induk_dokumen FROM `hkm_dokumen_dms` where id_dokumen = $dokumen_lama ")
        ->result();
      foreach ($cari_induk_dokumen as $value)
        $array[] = $value->induk_dokumen;

      $id_mencabut = $this->db->query("SELECT id_dokumen FROM `hkm_dokumen_dms` where induk_dokumen = $value->induk_dokumen ")
        ->result_array();

      $data = array(
        // 'user_upload' => $bagian,
        'nama_dokumen' => $nama_dokumen,
        'jenis_dokumen' => $jenis_dok,
        'tentang' => $tentang,
        'induk_dokumen' => $value->induk_dokumen,
        'item_dokumen' => $item_dok,
        'induk_dokumen' => $induk_dokumen,
        // 'jenis_dokumen' => $jenis_dok,
        'id_level_dok' => $level_dokumen,
        'id_media_simpan_dok	' => $media_spmn,
        'id_regional' => $region,
        'no_dokumen' => $nomor_dokumen,
        'tgl_terbit' => $tanggal_terbit,
        'tgl_tetap' => $tanggal_tetap,
        'bagian_penerbit' => $bag_penerbit,
        'metode_indeks' => $indeks_dokumen,
        'lama_simpan_awal' => $tglSimpanawal,
        'lama_simpan_akhir' => $tglSimpanakhir,
        // 'tanggal_penetapan' => $cvt_tanggal_penetapan,
        'akses_for' => implode(",", $akses_for),
        'upload_dokumen' => $upload_dokumen,
        'password' => $password,
        'status_rev' => $status_rev_combined,
        'status_dok' => $status_dok
      );
      $this->model_dokumen->tambah_dokumen($data, 'hkm_dokumen_dms');

      $last_id = $this->db->insert_id();
      $result = array(); foreach ($id_mencabut as $key => $row) {
        $data1[] = array(
          'id_dokumen' => $last_id,
          'id_dokumen_status' => $row['id_dokumen'],
          'status' => $status
        );
      }
      $this->db->insert_batch('hkm_dokumen_proses_dms', $data1);

      foreach ($id_mencabut as $key => $rows) {
        $data2[] = array(
          'id_dokumen' => $rows['id_dokumen'],
          'id_dokumen_status' => $last_id,
          'status' => 'Mengubah'
        );
      }

      $this->db->insert_batch('hkm_dokumen_proses_dms', $data2);
      // $this->session->set_userdata('status_perubahan', 'diubah');
      // ======================Dokumen Non-Aktif
      $data = array(
        'status_dok' => 'Dokumen Non-Aktif'
      );
      // var_dump($data);

      $where = array('id_dokumen' => $dokumen_lama);
      // var_dump($where);
      $this->model_dokumen->update_dokumen($where, $data, 'hkm_dokumen_dms');


      if ($item_dok_param == 'internal') {
        redirect('c_pengelolah_dokumen_dms/doc_internal');
      } else if ($item_dok_param == 'eksternal') {
        redirect('c_pengelolah_dokumen_dms/doc_external');
      }
    } elseif ($status == 'Kombinasi') {
      $status = $this->input->post('status_kombinasi');
      $dokumen_lama = $this->input->post('dokumen_lama_kombinasi');
      $count = count($status);

      $data = array(
        // 'user_upload' => $bagian,
        'nama_dokumen' => $nama_dokumen,
        'jenis_dokumen' => $jenis_dok,
        'tentang' => $tentang,
        'induk_dokumen' => $induk_dokumen,
        'item_dokumen' => $item_dok,
        // 'jenis_dokumen' => $jenis_dok,
        'id_level_dok' => $level_dokumen,
        'id_media_simpan_dok	' => $media_spmn,
        'id_regional' => $region,
        'no_dokumen' => $nomor_dokumen,
        'tgl_terbit' => $tanggal_terbit,
        'tgl_tetap' => $tanggal_tetap,
        'bagian_penerbit' => $bag_penerbit,
        'metode_indeks' => $indeks_dokumen,
        'lama_simpan_awal' => $tglSimpanawal,
        'lama_simpan_akhir' => $tglSimpanakhir,
        // 'tanggal_penetapan' => $cvt_tanggal_penetapan,
        'akses_for' => implode(",", $akses_for),
        'upload_dokumen' => $upload_dokumen,
        'password' => $password,
        'status_rev' => $status_rev_combined,
        'status_dok' => $status_dok
      );

      $this->model_dokumen->tambah_dokumen($data, 'hkm_dokumen_dms');
      $last_id = $this->db->insert_id();

      for ($k = 0; $k < $count; $k++) {
        $last_id_kombinasi = $last_id;
        $status_kombinasi = $status[$k];
        $dokumen_lama_kombinasi = $dokumen_lama[$k];

        // INDUK DOKUMEN
        $cari_induk_dokumen = $this->db->query("SELECT induk_dokumen FROM `hkm_dokumen_dms` where id_dokumen = $dokumen_lama_kombinasi")->result();
        foreach ($cari_induk_dokumen as $value)
          $array[] = $value->induk_dokumen;

        // ID MENCABUT
        $id_mencabut = $this->db->query("SELECT id_dokumen FROM `hkm_dokumen_dms` where induk_dokumen = $value->induk_dokumen")->result_array(); // SIMPAN PROSES 1 
        foreach ($id_mencabut as $key => $row) {
          $data1[$count] = array(
            'id_dokumen' => $last_id_kombinasi,
            'id_dokumen_status' => $row['id_dokumen'],
            'status' => $status_kombinasi
          );
          $this->db->insert_batch('hkm_dokumen_proses_dms', $data1);
        }

        //SIMPAN PROSES 2
        if ($status_kombinasi == "Mencabut") {
          foreach ($id_mencabut as $key => $rows) {
            $data2[$count] = array(
              'id_dokumen' => $rows['id_dokumen'],
              'id_dokumen_status' => $last_id_kombinasi,
              'status' => 'Dicabut'
            );
            $this->db->insert_batch('hkm_dokumen_proses_dms', $data2);
          }
        } elseif ($status_kombinasi == "Dicabut") {
          foreach ($id_mencabut as $key => $rows) {
            $data2[$count] = array(
              'id_dokumen' => $rows['id_dokumen'],
              'id_dokumen_status' => $last_id_kombinasi,
              'status' => 'Mencabut'
            );
            $this->db->insert_batch('hkm_dokumen_proses_dms', $data2);
          }
        } elseif ($status_kombinasi == "Mengubah") {
          foreach ($id_mencabut as $key => $rows) {
            $data2[$count] = array(
              'id_dokumen' => $rows['id_dokumen'],
              'id_dokumen_status' => $last_id_kombinasi,
              'status' => 'Diubah'
            );
            $this->db->insert_batch('hkm_dokumen_proses_dms', $data2);
          }
        } elseif ($status_kombinasi == "Diubah") {
          foreach ($id_mencabut as $key => $rows) {
            $data2[$count] = array(
              'id_dokumen' => $rows['id_dokumen'],
              'id_dokumen_status' => $last_id,
              'status' => 'Mengubah'
            );
            $this->db->insert_batch('hkm_dokumen_proses_dms', $data2);
          }
        }
        $id_mencabut = $this->db->query("SELECT id_dokumen FROM `hkm_dokumen_dms` where induk_dokumen = $value->induk_dokumen")->result_array();
        foreach ($id_mencabut as $key => $row) {
          $updateinduk[] = array(
            'id_dokumen' => $row['id_dokumen'],
            'induk_dokumen' => $induk_dokumen
          );
        }

        $this->db->update_batch('hkm_dokumen_dms', $updateinduk, 'id_dokumen');
      }

      // $this->session->set_userdata('status_perubahan', 'kombinasi');

      if ($item_dok_param == 'internal') {
        redirect('c_pengelolah_dokumen_dms/doc_internal');
      } else if ($item_dok_param == 'eksternal') {
        redirect('c_pengelolah_dokumen_dms/doc_external');
      }
    }

  }



  public function edit_data_dokumen_int($id_dokumen)
  {
    // Mengembalikan karakter-karakter yang dihilangkan sebelumnya
    $role = $this->session->userdata('role_id');
    $id_region = $this->session->userdata('id_region');
    $id_dokumen = str_replace(array('=='), array('/'), $id_dokumen);
    $id_dokumen = $this->encryption->decrypt($id_dokumen);
    $bagian = $this->session->userdata('id_bagian');

    //query builder edit dokumen
    $this->db->select('*');
    $this->db->select('hkm_dokumen_dms.id_dokumen AS dkm_awal, hkm_dokumen_proses_dms.status AS statuss');
    $this->db->from('hkm_dokumen_dms');
    $this->db->join('hkm_master_jenis_dokumen', 'hkm_dokumen_dms.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen', 'LEFT');
    $this->db->join('hkm_dokumen_proses_dms', 'hkm_dokumen_dms.id_dokumen = hkm_dokumen_proses_dms.id_dokumen_status', 'LEFT');
    $this->db->join('tb_master_bagian', 'hkm_dokumen_dms.user_upload = tb_master_bagian.id_bagian', 'LEFT');
    $this->db->join('master_level_dokumen', 'hkm_dokumen_dms.id_level_dok = master_level_dokumen.id_level_dok', 'LEFT');
    $this->db->where('hkm_dokumen_dms.id_dokumen', $id_dokumen);
    $this->db->where('hkm_master_jenis_dokumen.item_dokumen', 'internal');
    $this->db->order_by('hkm_dokumen_dms.id_dokumen', 'DESC');
    $this->db->limit(1);

    $query_edit_dokumen = $this->db->get();

    //query builder level di edit dokumen
    $this->db->select('DISTINCT(master_level_dokumen.id_level_dok) AS id_lvl, master_level_dokumen.status_level_dok');
    $this->db->from('master_level_dokumen');
    $this->db->join('hkm_dokumen_dms', 'hkm_dokumen_dms.id_level_dok = master_level_dokumen.id_level_dok', 'LEFT');
    $this->db->order_by('master_level_dokumen.status_level_dok', 'ASC');
    $query_level_dok = $this->db->get();

    //Region
    $region_user_query = $this->db->get('tb_regional_n2');
    $region_user = $region_user_query->result_array();

    // array_push($region_user,
    // [
    //   "id_regional" => 99,
    //   "nama_regional" => "All Region"
    // ]);

    $data['regionuser'] = $region_user;

    //query builder media simpan di edit dokumen
    $this->db->select('DISTINCT(master_media_simpan.id_media_simpan_dok) AS id_medsim, master_media_simpan.media_simpan');
    $this->db->from('master_media_simpan');
    $this->db->join('hkm_dokumen_dms', 'hkm_dokumen_dms.id_media_simpan_dok = master_media_simpan.id_media_simpan_dok', 'LEFT');
    $this->db->order_by('master_media_simpan.media_simpan', 'ASC');
    $query_medsim_dok = $this->db->get();

    //query builder bagian_penerbit di edit dokumen
    $this->db->select('DISTINCT(tb_master_bagian.id_bagian) AS id_bag, tb_master_bagian.nama_bagian');
    $this->db->from('tb_master_bagian');
    $this->db->join('hkm_dokumen_dms', 'hkm_dokumen_dms.bagian_penerbit = tb_master_bagian.id_bagian', 'LEFT');
    $this->db->order_by('tb_master_bagian.nama_bagian', 'ASC');
    $query_bagper_dok = $this->db->get();

    if ($bagian == 0) {
      $query_dokumen = $this->db->query("SELECT * FROM `hkm_dokumen_dms`");
    } else {
      $query_dokumen = $this->db->query("SELECT * FROM `hkm_dokumen_dms` WHERE user_upload = '$bagian'");
    }

    $data['data_dokumen_lama'] = $query_dokumen->result();
    $data['level_dok'] = $query_level_dok->result();
    $data['media_simpan'] = $query_medsim_dok->result();
    $data['penerbit'] = $query_bagper_dok->result();

    // var_dump($data['level_dok']["id_lvl"]);
    $data['data_dokumen'] = $query_edit_dokumen->result();
    //var_dump($data['data_dokumen']);
    $data['master_bagian'] = $this->model_dokumen->tampil_data_bagian_kebun()->result();
    $data['jenis_dokumen'] = $this->model_dokumen->tampil_data_jenis_pengelolah_dokumen_internal()->result();
    $data['user'] = $this->model_dokumen->tampil_data_user()->result();


    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('edit-pengelolaan_dokumen', $data);
    $this->load->view('templates/footer');
  }


  public function edit_data_dokumen_eks($id_dokumen)
  {
    // Mengembalikan karakter-karakter yang dihilangkan sebelumnya
    $role = $this->session->userdata('role_id');
    $id_region = $this->session->userdata('id_region');
    $id_dokumen = str_replace(array('=='), array('/'), $id_dokumen);
    $id_dokumen = $this->encryption->decrypt($id_dokumen);
    $bagian = $this->session->userdata('id_bagian');

    //query builder edit dokumen
    $this->db->select('*');
    $this->db->select('hkm_dokumen_dms.id_dokumen AS dkm_awal, hkm_dokumen_proses_dms.status AS statuss');
    $this->db->from('hkm_dokumen_dms');
    $this->db->join('hkm_master_jenis_dokumen', 'hkm_dokumen_dms.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen', 'LEFT');
    $this->db->join('hkm_dokumen_proses_dms', 'hkm_dokumen_dms.id_dokumen = hkm_dokumen_proses_dms.id_dokumen_status', 'LEFT');
    $this->db->join('tb_master_bagian', 'hkm_dokumen_dms.user_upload = tb_master_bagian.id_bagian', 'LEFT');
    $this->db->join('master_level_dokumen', 'hkm_dokumen_dms.id_level_dok = master_level_dokumen.id_level_dok', 'LEFT');
    $this->db->where('hkm_dokumen_dms.id_dokumen', $id_dokumen);
    $this->db->order_by('hkm_dokumen_dms.id_dokumen', 'DESC');
    $this->db->limit(1);

    $query_edit_dokumen = $this->db->get();

    //query builder level di edit dokumen
    $this->db->select('DISTINCT(master_level_dokumen.id_level_dok) AS id_lvl, master_level_dokumen.status_level_dok');
    $this->db->from('master_level_dokumen');
    $this->db->join('hkm_dokumen_dms', 'hkm_dokumen_dms.id_level_dok = master_level_dokumen.id_level_dok', 'LEFT');
    $this->db->order_by('master_level_dokumen.status_level_dok', 'ASC');
    $query_level_dok = $this->db->get();

    //Region
    $region_user_query = $this->db->get('tb_regional_n2');
    $region_user = $region_user_query->result_array();

    // array_push($region_user,
    // [
    //   "id_regional" => 99,
    //   "nama_regional" => "All Region"
    // ]);

    $data['regionuser'] = $region_user;


    //query builder media simpan di edit dokumen
    $this->db->select('DISTINCT(master_media_simpan.id_media_simpan_dok) AS id_medsim, master_media_simpan.media_simpan');
    $this->db->from('master_media_simpan');
    $this->db->join('hkm_dokumen_dms', 'hkm_dokumen_dms.id_media_simpan_dok = master_media_simpan.id_media_simpan_dok', 'LEFT');
    $this->db->order_by('master_media_simpan.media_simpan', 'ASC');
    $query_medsim_dok = $this->db->get();

    //query builder bagian_penerbit di edit dokumen
    $this->db->select('DISTINCT(tb_master_bagian.id_bagian) AS id_bag, tb_master_bagian.nama_bagian');
    $this->db->from('tb_master_bagian');
    $this->db->join('hkm_dokumen_dms', 'hkm_dokumen_dms.bagian_penerbit = tb_master_bagian.id_bagian', 'LEFT');
    $this->db->order_by('tb_master_bagian.nama_bagian', 'ASC');
    $query_bagper_dok = $this->db->get();

    if ($bagian == 0) {
      $query_dokumen = $this->db->query("SELECT * FROM `hkm_dokumen_dms`");
    } else {
      $query_dokumen = $this->db->query("SELECT * FROM `hkm_dokumen_dms` WHERE user_upload = '$bagian'");
    }

    $data['data_dokumen_lama'] = $query_dokumen->result();
    $data['level_dok'] = $query_level_dok->result();
    $data['media_simpan'] = $query_medsim_dok->result();
    $data['penerbit'] = $query_bagper_dok->result();

    // var_dump($data['level_dok']["id_lvl"]);
    $data['data_dokumen'] = $query_edit_dokumen->result();
    $data['master_bagian'] = $this->model_dokumen->tampil_data_bagian_kebun()->result();
    $data['jenis_dokumen'] = $this->model_dokumen->tampil_data_jenis_pengelolah_dokumen_eksternal()->result();
    $data['user'] = $this->model_dokumen->tampil_data_user()->result();


    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('edit-pengelolaan_dokumen', $data);
    $this->load->view('templates/footer');
  }

  public function update_data_dokumen_dms()
  {

    $id_dok_akhir = $this->input->post('id_dok_akhir');
    $induk_dokumen = $id_dok_akhir + 1;
    $item_dok_param = $this->session->userdata('item_dok');

    $id = $this->session->userdata('id_bagian');

    // $test = $this->input->post('region');
    // print_r($test);
    // die();

    if ($this->input->post('region') === '99') {
      $data_allreg = $this->db->select('id_regional')->get('tb_regional_n2')->result_array();
      $allregion = array_column($data_allreg, 'id_regional');
      $region = implode(",", $allregion);
    } else {
      $region = $this->input->post('region');
    }

    $id_dokumen = $this->input->post('id');
    $nama_dokumen = $this->input->post('nama_dokumen');
    $nomor_dokumen = $this->input->post('nomor_dokumen');
    $status_dok = $this->input->post('status_dok');
    $item_dok = $this->input->post('item_dok');
    $level_dokumen = $this->input->post('level_dok');
    $penerbit = $this->input->post('penerbit');
    $mediasimpan = $this->input->post('medsim');
    $tanggal_terbit = $this->input->post('tanggal_penerbitan');
    $tanggal_tetap = $this->input->post('tanggal_penetapan');
    $status_rev = $this->input->post('status_rev');
    $tanggal_rev = $this->input->post('tanggal_rev');
    $jendok = $this->input->post('jenis_dok');
    $metodeks = $this->input->post('metode_indeks');
    $tentang = $this->input->post('tentang');
    $akses_for = $this->input->post('akses_for');
    $upload_dokumen = $_FILES['upload_dokumen']['name'];
    $password = $this->input->post('password_dok');
    $tglSimpanawal = $this->input->post('tglSimpanawal');
    $tglSimpanakhir = $this->input->post('tglSimpanakhir');

    $status_rev_combined = $status_rev . '/' . $tanggal_rev;
    $password = $this->encryption->encrypt($password);

    foreach ($akses_for as $key) {
      if ($key == 'ABGN') {
        $allbagian = $this->db->query("SELECT kode FROM `tb_master_bagian`")->result();
        foreach ($allbagian as $all_bagian) {
          if ($all_bagian->kode) {
            $data_allbagian[] = $all_bagian->kode;
          }
        }
        $all_kebun = array_merge($akses_for, $data_allbagian);
        $akses_for = $all_kebun;
      } else {
        $akses_for = $_POST['akses_for'];
      }
    }

    $upload_dokument = $this->input->post('upload_dokument');
    $upload_dokumen = $_FILES['upload_dokumen']['name'];

    if ($upload_dokumen == null) {
      $data = array(
        // 'user_upload' => $bagian,
        'nama_dokumen' => $nama_dokumen,
        'jenis_dokumen' => $jendok,
        'tentang' => $tentang,
        'induk_dokumen' => $induk_dokumen,
        'item_dokumen' => $item_dok,
        'id_level_dok' => $level_dokumen,
        'id_regional' => $region,
        'id_media_simpan_dok	' => $mediasimpan,
        'no_dokumen' => $nomor_dokumen,
        'tgl_terbit' => $tanggal_terbit,
        'tgl_tetap' => $tanggal_tetap,
        'bagian_penerbit' => $penerbit,
        'metode_indeks' => $metodeks,
        'lama_simpan_awal' => $tglSimpanawal,
        'lama_simpan_akhir' => $tglSimpanakhir,
        'akses_for' => implode(",", $akses_for),
        'password' => $password,
        'status_rev' => $status_rev_combined,
        'status_dok' => $status_dok
      );
      $where = array('id_dokumen' => $id_dokumen);
      $this->model_dokumen->update_dokumen($where, $data, 'hkm_dokumen_dms');
      $this->session->set_flashdata('success_edit_message', 'Pesan Terkirim');

      if ($item_dok_param == 'internal') {
        redirect('c_pengelolah_dokumen_dms/doc_internal');
      } else if ($item_dok_param == 'eksternal') {
        redirect('c_pengelolah_dokumen_dms/doc_external');
      }


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
        // 'user_upload' => $bagian,
        'nama_dokumen' => $nama_dokumen,
        'jenis_dokumen' => $jendok,
        'tentang' => $tentang,
        'induk_dokumen' => $induk_dokumen,
        'item_dokumen' => $item_dok,
        'id_level_dok' => $level_dokumen,
        'id_media_simpan_dok	' => $mediasimpan,
        'no_dokumen' => $nomor_dokumen,
        'id_regional' => $region,
        'tgl_terbit' => $tanggal_terbit,
        'tgl_tetap' => $tanggal_tetap,
        'bagian_penerbit' => $penerbit,
        'metode_indeks' => $metodeks,
        'lama_simpan_awal' => $tglSimpanawal,
        'lama_simpan_akhir' => $tglSimpanakhir,
        // 'tanggal_penetapan' => $cvt_tanggal_penetapan,
        'akses_for' => implode(",", $akses_for),
        'upload_dokumen' => $upload_dokumen,
        'password' => $password,
        'status_rev' => $status_rev_combined,
        'status_dok' => $status_dok
      );
      $where = array('id_dokumen' => $id_dokumen);
      $this->model_dokumen->update_dokumen($where, $data, 'hkm_dokumen_dms');
      $this->session->set_flashdata('success_edit_message1', 'Pesan Terkirim');

      if ($item_dok_param == 'internal') {
        redirect('c_pengelolah_dokumen_dms/doc_external');
      } else if ($item_dok_param == 'eksternal') {
        redirect('c_pengelolah_dokumen_dms/doc_external');
      }
    }
  }


  // Pada fungsi delete di controller Anda
  public function delete($id_dokumen)
  {
    $id_dokumen = str_replace(array('=='), array('/'), $id_dokumen);
    $id_dokumen = $this->encryption->decrypt($id_dokumen);

    // Hapus data dari tabel
    $this->db->query("DELETE FROM `hkm_dokumen_dms` WHERE `hkm_dokumen_dms`.`id_dokumen` = ' $id_dokumen '");

    $delete_successful = $this->db->affected_rows() > 0;

    // Simpan status operasi hapus dalam flashdata
    if ($delete_successful) {
      $this->session->set_flashdata('delete_status', 'success');
    } else {
      $this->session->set_flashdata('delete_status', 'failed');
    }

    // Redirect kembali ke halaman utama setelah operasi hapus selesai
    redirect('c_pengelolah_dokumen_dms/index');
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
      redirect('c_pengelolah_dokumen_dms/index');
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

    $i = $this->input;
    $hal = $this->uri->segment(4);
    // $origFile = $i->post('url1');
    // $destFile = $i->post('url2');
    $id = $i->post('id');
    $query_dokumen = $this->db->query("SELECT * FROM `hkm_dokumen_dms`WHERE hkm_dokumen_dms.id_dokumen = '$id' ");

    // Mendekripsi Password sebelum mengirimkannya ke view
    foreach ($data['data_dokumen'] as &$data_dokumen) {
      // Mendekripsi password yang diambil dari database
      $decrypted_password = $this->encryption->decrypt($data_dokumen['password']);
    }

    $data['data_dokumen'] = $query_dokumen->result_array();
    $data = array(
      'origFile3' => $i->post('url1'),
      'destFile3' => $i->post('url2'),
      'nama_dok'  =>$i->post('nmnm'),
      'id' => $id,
      'data1' => $data['data_dokumen'],
      'pass' => $decrypted_password,
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
    $lacak_user = file_get_contents('https://ipinfo.io/?token=' . $TOKEN . '');
    $lacak = json_decode($lacak_user);
    $browser = $data['browser'];
    $os = $data['os'];
    $kota = $lacak->city;
    $ip = $lacak->ip;
    ;
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
      'os' => $os,
      'kota' => $kota,
      'daerah' => $daerah,
      'negara' => $negara,
      'lokasi' => $lokasi,
      'zonawaktu' => $zonawaktu,
      'browser' => $browser,
      'mac' => $MAC,
      'aktivitas' => $aktivitas
    );
    $this->model_auth->tambah_log($data, 'tb_log');
    // $this->load->view('index1');

  }
  public function request_dokumen()
  {
    $i = $this->input;
    $id = $i->post('id_doc');
    $keperluan = $i->post('keperluan');
    $username = $this->session->userdata('username');
    date_default_timezone_set('Asia/Jakarta');
    $tgl = date('Y-m-d H:i:s');

    $query_user = $this->db->query("SELECT tb_user.*, tb_sub_bagian.nama_sub_bag, tb_sub_bagian.kode AS kode_subbag, tb_master_bagian.nama_bagian, tb_regional_n2.nama_regional, tb_master_bagian.kode AS kode_bagian FROM tb_user
      LEFT JOIN tb_sub_bagian ON tb_user.id_sub_bagian = tb_sub_bagian.id_sub_bag
      LEFT JOIN tb_master_bagian ON tb_user.id_bagian = tb_master_bagian.id_bagian
      LEFT JOIN tb_regional_n2 ON tb_user.id_region = tb_regional_n2.id_regional 
      WHERE username='$username'");
    $data['data_user'] = $query_user->result_array();
    // var_dump($data['data_user']);
    // echo '<br>';

    foreach ($data['data_user'] as &$data_user) {
      $nama_subbag = $data_user['nama_sub_bag'];
      $kode_subbag = $data_user['kode_subbag'];
      $nama_bagian = $data_user['nama_bagian'];
      $kode_bagian = $data_user['kode_bagian'];
      $nama_regional = $data_user['nama_regional'];

    }

    $this->load->helper('string');
    $this->load->library('user_agent');
    $TOKEN = '3dccc869f03e7b';
    $data['browser'] = $this->agent->browser();
    $data['os'] = $this->agent->platform();
    $MAC = exec('getmac');
    $MAC = strtok($MAC, ' ');
    // $lacak_user = file_get_contents('http://ipinfo.io/'. $ip.'?token='.$TOKEN);
    $lacak_user = file_get_contents('https://ipinfo.io/?token=' . $TOKEN . '');
    $lacak = json_decode($lacak_user);
    $browser = $data['browser'];
    $os = $data['os'];
    $kota = $lacak->city;
    $ip = $lacak->ip;
    ;
    $daerah = $lacak->region;
    $negara = $lacak->country;
    $lokasi = $lacak->loc;
    $zonawaktu = $lacak->timezone;

    $aktivitas = "Request";
    $data = array(
      'id_dokumen' => $id,
      'keperluan' => $keperluan,
      'username' => $username,
      'tanggal_req' => $tgl,
      'ip_req' => $ip,
      'os_req' => $os,
      'kota_req' => $kota,
      'daerah_req' => $daerah,
      'negara_req' => $negara,
      'lokasi_req' => $lokasi,
      'zonawaktu_req' => $zonawaktu,
      'browser_req' => $browser,
      'mac_req' => $MAC,
      'status_req' => $aktivitas,
      'nama_subbag' => $nama_subbag,
      'kode_subbag' => $kode_subbag,
      'nama_bagian' => $nama_bagian,
      'kode_bagian' => $kode_bagian,
      'nama_regional' => $nama_regional,
    );
    // var_dump($data);
    $this->model_auth->tambah_log($data, 'request_dokumen');
    redirect('c_dashboard');
  }


  public function lakukan_cetak_doc()
  {

    // $this->model_dokumen->tambah_dokumen($data, 'hkm_dokumen_download');
    // // $this->load->helper('download');

    // $datadok = $data_dokumen;
    // force_download('uploads/' . $datadok, NULL);

    $i = $this->input;
    $hal = $this->uri->segment(4);
    // $origFile = $i->post('url1');
    // $destFile = $i->post('url2');
    $id = $i->post('id');
    $query_dokumen = $this->db->query("SELECT * FROM `hkm_dokumen_dms`WHERE hkm_dokumen_dms.id_dokumen = '$id' ");

    // Mendekripsi Password sebelum mengirimkannya ke view
    foreach ($data['data_dokumen'] as &$data_dokumen) {
      // Mendekripsi password yang diambil dari database
      $decrypted_password = $this->encryption->decrypt($data_dokumen['password']);
    }

    if ($i->post('aprove') == 'Approve') {
      $izin = 'Approve';
    }

    $req_id = $i->post('id_req');

    $data['data_dokumen'] = $query_dokumen->result_array();
    $data = array(
      'origFile3' => $i->post('url1'),
      'destFile3' => $i->post('url2'),
      'id' => $id,
      'data1' => $data['data_dokumen'],
      'pass' => $decrypted_password,
      'izin_dok' => $izin,
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
    $lacak_user = file_get_contents('https://ipinfo.io/?token=' . $TOKEN . '');
    $lacak = json_decode($lacak_user);
    $browser = $data['browser'];
    $os = $data['os'];
    $kota = $lacak->city;
    $ip = $lacak->ip;
    ;
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
      'os' => $os,
      'kota' => $kota,
      'daerah' => $daerah,
      'negara' => $negara,
      'lokasi' => $lokasi,
      'zonawaktu' => $zonawaktu,
      'browser' => $browser,
      'mac' => $MAC,
      'aktivitas' => $aktivitas
    );
    $this->model_auth->tambah_log($data, 'tb_log');

    // $aktivitas = "Request";
    $data_req = array(

      'tanggal_down' => $tgl,
      'ip_down' => $ip,
      'os_down' => $os,
      'kota_down' => $kota,
      'daerah_down' => $daerah,
      'negara_down' => $negara,
      'lokasi_down' => $lokasi,
      'zonawaktu_down' => $zonawaktu,
      'browser_down' => $browser,
      'mac_down' => $MAC,
    );
    $where1 = array('id' => $req_id);
    $this->model_dokumen->update_request($where1, $data_req, 'request_dokumen');
    // redirect('c_pengelolah_dokumen_dms/index');
    // $this->model_auth->tambah_log($data, 'request_dokumen');
    // $this->load->view('index1');

  }

  public function list_req_doc()
  {
    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('list_request_dokumen');
    $this->load->view('templates/footer');
  }

  public function ajax_list()
  {
    // $id_user        = $this->session->userdata('id_user');     
    // $user_aktif     = $this->user_model->detail($id_user);
    $list = $this->model_dokumen->get_datatables();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $pesan) {
      $no++;
      $row = array();
      $row[] = $no;
      $row[] = $pesan->username;
      $row[] = $pesan->no_dokumen;
      $row[] = $pesan->nama_dokumen;
      $row[] = $pesan->tanggal_req;
      $row[] = $pesan->tanggal_down;
      $row[] = $pesan->nama_subbag;
      $row[] = $pesan->nama_bagian;
      $row[] = $pesan->nama_regional;
      $row[] = $pesan->status_req;
      $row[] = $pesan->appr_rjct_by;
      $id_req = strtr($this->encryption->encrypt($pesan->id), array('/' => '=='));
      // Menghapus karakter yang tidak diinginkan
      // $data_dokumen['encrypted_id'] = strtr($data_dokumen['encrypted_id'], array('/' => '=='));
      if ($pesan->status_req == "Approve" && $pesan->tanggal_down <> "") {
        $row[] = '<a  href="' . base_url('c_pengelolah_dokumen_dms/persetujuan_request/' . $id_req) . '" title="Detail Request Dokumen" class="btn btn-xs btn-success margin"><i class="fas fa-list-ol"></i> Persetujuan</a>';
      } elseif ($pesan->status_req == "Approve" && $pesan->tanggal_down == "") {
        $row[] = '<a  href="' . base_url('c_pengelolah_dokumen_dms/persetujuan_request/' . $id_req) . '" title="Detail Request Dokumen" class="btn btn-xs btn-warning margin"><i class="fas fa-list-ol"></i> Persetujuan</a>';
      } else {
        $row[] = '<a  href="' . base_url('c_pengelolah_dokumen_dms/persetujuan_request/' . $id_req) . '" title="Detail Request Dokumen" class="btn btn-xs btn-danger margin"><i class="fas fa-list-ol"></i> Persetujuan</a>';
      }
      // $row[] = '<a  href="'.base_url('admin/sop/history_sop/'.$pesan->id_sop).'" title="Riwayar Revisi" class="btn btn-xs btn-danger margin"><i class="fas fa-list-ol"></i> Riwayat</a>';
      // $row[] = '<a  href="'.base_url('admin/sop/edit/'.$pesan->id_sop).'" title="Edit SOP" class="btn btn-xs btn-primary  margin"><i class="fas fa-edit"></i></a> <a  href="'.base_url('admin/sop/view_sop/'.$pesan->id_sop).'" title="Lihat SOP" class="btn btn-xs btn-success margin"><i class="fas fa-glasses"></i></a>';


      $data[] = $row;
    }

    $output = array(
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->model_dokumen->count_all(),
      "recordsFiltered" => $this->model_dokumen->count_filtered(),
      "data" => $data,
    );
    //output to json format
    echo json_encode($output);

  }

  public function persetujuan_request($id_req)
  {
    $id_req = str_replace(array('=='), array('/'), $id_req);
    $id_req = $this->encryption->decrypt($id_req);

    $query_req_dok = $this->db->query("SELECT * FROM `v_dokumen_request` WHERE id='$id_req' ");
    $data['data_req_dok'] = $query_req_dok->result_array();
    foreach ($data['data_req_dok'] as &$data_req_dok) {
      $id_doc = $data_req_dok['id_dokumen'];
    }

    $query_dokumen_master = $this->db->query("SELECT * FROM `hkm_dokumen_dms` ");
    $data['dokumen_master'] = $query_dokumen_master->result_array();

    $query_dokumen = $this->db->query("SELECT * FROM `hkm_dokumen_dms`
    LEFT JOIN hkm_master_jenis_dokumen ON hkm_dokumen_dms.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen 
    LEFT JOIN  master_media_simpan ON hkm_dokumen_dms.id_media_simpan_dok = master_media_simpan.id_media_simpan_dok
    WHERE hkm_dokumen_dms.id_dokumen = '$id_doc' ");
    $data['data_dokumen'] = $query_dokumen->result_array();

    // Mendekripsi Password sebelum mengirimkannya ke view
    foreach ($data['data_dokumen'] as &$data_dokumen) {
      // Mendekripsi password yang diambil dari database
      $decrypted_password = $this->encryption->decrypt($data_dokumen['password']);
      // Menyimpan password yang telah didekripsi ke dalam array data_dokumen
      $data_dokumen['decrypt_password'] = $decrypted_password;
    }

    // ==================================================================================
    $query_req = $this->db->query("SELECT * FROM `hkm_dokumen_dms`
    right JOIN  request_dokumen ON hkm_dokumen_dms.id_dokumen = request_dokumen.id_dokumen
    WHERE hkm_dokumen_dms.id_dokumen='$id_req' ");
    $data['data_req'] = $query_req->result_array();


    $query_dokstatus = $this->db->query("SELECT * FROM `hkm_dokumen_proses` 
    LEFT JOIN hkm_dokumen_dms ON hkm_dokumen_proses.id_dokumen = hkm_dokumen_dms.id_dokumen ORDER BY id_proses DESC ");
    $data['query_dokstatus'] = $query_dokstatus->result_array();

    $query_akses = $this->db->query("SELECT * FROM `tb_master_bagian` ");
    $data['data_bagian'] = $query_akses->result();


    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('detail_request_dokumen', $data);
    $this->load->view('templates/footer');
  }

  public function setujui_req_dok()
  {

    $username = $this->session->userdata('username');
    $i = $this->input;
    $id = $i->post('id_req');
    $sts = $i->post('persetujuan');

    $data = array(
      'status_req' => $sts,
      'appr_rjct_by' => $username
    );
    // var_dump($data);

    $where = array('id' => $id);
    // var_dump($where);
    $this->model_dokumen->update_request($where, $data, 'request_dokumen');

    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('list_request_dokumen');
    $this->load->view('templates/footer');
  }

  public function mark_notification_as_read($notification_id, $id_docc)
  {
    // Mengembalikan karakter-karakter yang dihilangkan sebelumnya
    $id_req = str_replace(array('=='), array('/'), $notification_id);
    $id_req = $this->encryption->decrypt($id_req);

    // Perbarui database untuk menandai notifikasi sebagai sudah dibaca
    // Anda perlu mengimplementasikan kueri pembaruan database di sini
    // Contohnya:
    $this->db->where('id', $id_req);
    $this->db->update('request_dokumen', array('is_read' => 1));


    // Alihkan kembali ke tautan notifikasi asli
    redirect(base_url('c_pengelolah_dokumen_dms/detail_dum/' . $id_docc));
  }


}
