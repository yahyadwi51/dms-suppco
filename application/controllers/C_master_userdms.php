<?php
class c_master_userdms extends CI_Controller
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

    $this->load->model('model_userdms');
  }

  public function index()
  {
    $sesi_region = $this->session->userdata('id_region');

    $region_user = [];
    $bagian_user = [];
    $subbagian_user = [];
    $role_user = [];

    if ($sesi_region == 13) {
      $query_user = $this->db->get('tb_user');
    } else if ($sesi_region != 13) {
      switch ($sesi_region) {
        case 1:
        case 2:
        case 3:
        case 4:
        case 5:
        case 6:
          $query_user = $query_user = $this->db->where('id_region', $sesi_region)->get('tb_user');
          break;
      }
    }

    $region_user = $this->db->select('*, tb_regional_n2.id_regional AS idrgn')
      ->from('tb_regional_n2')
      ->join('tb_user', 'tb_user.id_region = tb_regional_n2.id_regional', 'left')
      ->get();

    $bagian_user = $this->db->select('*, tb_master_bagian.id_bagian AS idbgn')
      ->from('tb_master_bagian')
      ->join('tb_user', 'tb_user.id_bagian = tb_master_bagian.id_bagian', 'left')
      ->get();

    $subbagian_user = $this->db->select('*, tb_sub_bagian.id_sub_bag AS idsub')
      ->from('tb_sub_bagian')
      ->join('tb_user', 'tb_user.id_sub_bagian = tb_sub_bagian.id_sub_bag', 'left')
      ->get();

    $role_user = $this->db->select('*, tb_role.id AS id_role')
      ->from('tb_role')
      ->join('tb_user', 'tb_user.role_id = tb_role.id', 'left')
      ->get();

    $id = $this->session->userdata('id');

    $data['role_user'] = $role_user->result_array();
    $data['regionuser'] = is_object($region_user) ? $region_user->result_array() : [];
    $data['bagianuser'] = is_object($bagian_user) ? $bagian_user->result_array() : [];
    $data['subbagianuser'] = is_object($subbagian_user) ? $subbagian_user->result_array() : [];
    $data['user'] = $query_user->result_array();

    // Mengenkripsi id_dokumen sebelum mengirimkannya ke view
    foreach ($data['user'] as &$user) {
      $user['encrypted_id'] = $this->encryption->encrypt($user['id']);
      // Menghapus karakter yang tidak diinginkan
      $user['encrypted_id'] = strtr($user['encrypted_id'], array('/' => '=='));
    }

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('master_userdms', $data);
    $this->load->view('templates/footer');
  }

  public function form_master_userdms($id = null)
  {

    $sesi_region = $this->session->userdata('id_region');

    //var_dump($sesi_bagian);

    $region_user_ho = [];
    $bagian_user = [];
    $region_user = [];

    if ($sesi_region == 13) {

      $region_user_query1 = $this->db->get('tb_regional_n2');
      $region_user_ho = $region_user_query1->result_array();

    } else if ($sesi_region != 13) {
      $this->db->where('id_regional', $sesi_region);
      $region_user_query = $this->db->get('tb_regional_n2');
      $region_user = $region_user_query->result_array();

      $this->db->where('id_region', $sesi_region);
      $bagian_user_query = $this->db->get('tb_master_bagian');
      $bagian_user = $bagian_user_query->result_array();

    }

    // var_dump($sub_bagian_user);

    $data['regionuserho'] = $region_user_ho;

    $data['baguser'] = $bagian_user;
    $data['regionuser'] = $region_user;

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('tambah-master_userdms', $data);
    $this->load->view('templates/footer');
  }

  public function get_bagian_by_region($region_id)
  {
    $this->load->database(); // Load database if not autoloaded

    $this->db->where('id_region', $region_id);
    $bagian = $this->db->get('tb_master_bagian')->result();

    echo json_encode($bagian);
  }


  public function get_role_by_region($region_id)
  {
    $this->load->database(); // Load database if not autoloaded

    if ($region_id != 13) {
      $this->db->where('peruntukan', 1);
      $role = $this->db->get('tb_role')->result();
    } else {
      $this->db->where('peruntukan', 0);
      $role = $this->db->get('tb_role')->result();
    }
    echo json_encode($role);
  }


  public function get_subbagian_by_bagian($section_id)
  {
    $this->load->database(); // Load database if not autoloaded

    $this->db->where('id_bagian', $section_id);
    $subbagian = $this->db->get('tb_sub_bagian')->result();

    echo json_encode($subbagian);
  }

  public function tambah_userdms()
  {
    $username = $this->input->post('username');
    $role = $this->input->post('role');
    $status = $this->input->post('status');
    $ktsnd = $this->input->post('ktsnd');
    $subbagian = $this->input->post('subbagian');
    $bagian = $this->input->post('bagian');
    $region = $this->input->post('region');
    $id_tele = implode(', ', $this->input->post('id_telegram[]'));
    $no_telp = implode(', ', $this->input->post('no_telp[]'));
    $email = implode(', ', $this->input->post('email[]'));

    $hashedktsnd = password_hash($ktsnd, PASSWORD_DEFAULT);

    $existing_user = $this->model_userdms->cek_data($username);
    if ($existing_user->num_rows() > 0) {
      // Data sudah ada, tampilkan pesan kesalahan atau lakukan tindakan sesuai kebutuhan Anda
      // $data['error_message'] = "Data media_simpan sudah ada dalam database.";
      // $this->load->view('error_view', $data); // Gantilah 'error_view' dengan view yang sesuai
      $this->session->set_flashdata('something4', 'Pesan Terkirim');
  } else {
      // Data belum ada, simpan data ke database
      $data = array(
        'is_active' => (int) $status,
        'username' => $username,
        'role_id' => $role,
        'password' => $hashedktsnd,
        'id_bagian' => $bagian,
        'id_sub_bagian' => $subbagian,
        'id_region' => $region,
        'id_telegram' => $id_tele,
        'no_telp' => $no_telp,
        'email' => $email
      );
      $this->model_userdms->tambah_userdms($data, 'tb_user');
      $this->session->set_flashdata('something', 'Pesan Terkirim');
  }   
    redirect('c_master_userdms/index');
  }

  public function edit_userdms($id)
  {

    $sesi_region = $this->session->userdata('id_region');
    // Mengembalikan karakter-karakter yang dihilangkan sebelumnya
    $id = str_replace(array('=='), array('/'), $id);
    $id = $this->encryption->decrypt($id);


    $region_user_ho = [];
    $bagian_user = [];
    $region_user = [];

    if ($sesi_region == 13) {

      $region_user_query1 = $this->db->get('tb_regional_n2');
      $region_user_ho = $region_user_query1->result_array();

      $user_role_query = $this->db->get('tb_role');
      $user_role = $user_role_query->result_array();

      $bagian_user_query = $this->db->get('tb_master_bagian');
      $bagian_user = $bagian_user_query->result_array();

      $sub_bagian_user_query = $this->db->get('tb_sub_bagian');
      $sub_bagian_user = $sub_bagian_user_query->result_array();

    } else if ($sesi_region != 13) {
      $this->db->where('id_regional', $sesi_region);
      $region_user_query = $this->db->get('tb_regional_n2');
      $region_user = $region_user_query->result_array();

      $this->db->where('id_region', $sesi_region);
      $bagian_user_query = $this->db->get('tb_master_bagian');
      $bagian_user = $bagian_user_query->result_array();

    }

    $where = array('id' => $id);

    $data['user_role'] = $user_role;
    $data['regionuserho'] = $region_user_ho;
    $data['baguser'] = $bagian_user;
    $data['subbaguser'] = $sub_bagian_user;
    $data['regionuser'] = $region_user;
    $data['user'] = $this->model_userdms->edit_userdms($where, 'tb_user')->result();

    // var_dump($data['user']);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('edit-master_userdms', $data);
    $this->load->view('templates/footer');

  }

  public function update_userdms()
  {
    $id = $this->input->post('id');
    $username = $this->input->post('username');
    $role = $this->input->post('role');
    $status = $this->input->post('status');
    $subbagian = $this->input->post('subbagian');
    $bagian = $this->input->post('bagian');
    $region = $this->input->post('region');
    $id_telegram = $this->input->post('id_telegram[]');
    $no_telp = $this->input->post('no_telp[]');
    $email = $this->input->post('email[]');

    $id_tele_cleaned = array_filter($id_telegram, function ($value) {
      return $value !== '';
    });
    $no_telp_cleaned = array_filter($no_telp, function ($value) {
      return $value !== '';
    });
    $email_cleaned = array_filter($email, function ($value) {
      return $value !== '';
    });

    $id_tele_clean = implode(', ', $id_tele_cleaned);
    $no_telp_clean = implode(', ', $no_telp_cleaned);
    $email_clean = implode(', ', $email_cleaned);

    $data = array(
      'is_active' => (int) $status,
      'username' => $username,
      'role_id' => $role,
      'id_bagian' => $bagian,
      'id_sub_bagian' => $subbagian,
      'id_region' => $region,
      'id_telegram' => $id_tele_clean,
      'no_telp' => $no_telp_clean,
      'email' => $email_clean
    );

    $where = array('id' => $id);
    $this->model_userdms->update_userdms($where, $data, 'tb_user');
    $this->session->set_flashdata('something1', 'Pesan Terkirim');
    redirect('c_master_userdms/index');
  }

  public function delete_userdms($id)
  {
    // Mengembalikan karakter-karakter yang dihilangkan sebelumnya
    $id = str_replace(array('=='), array('/'), $id);
    $id = $this->encryption->decrypt($id);

    $this->db->query("DELETE FROM `tb_user` WHERE `tb_user`.`id` = '$id'");
    $this->session->set_flashdata('something2', 'Pesan Terkirim');
    redirect('c_master_userdms/index');
  }

  public function reset_userdms($userId)
  {
    // Mengembalikan karakter-karakter yang dihilangkan sebelumnya
    $userId = str_replace(array('=='), array('/'), $userId);
    $userId = $this->encryption->decrypt($userId);

    $newPassword = password_hash("123456", PASSWORD_DEFAULT);
    $data = array(
      'password' => $newPassword
    );

    $this->db->where('id', $userId);
    $this->db->update('tb_user', $data);
    $this->session->set_flashdata('something3', 'Pesan Terkirim');

    redirect('c_master_userdms/index');
  }

}