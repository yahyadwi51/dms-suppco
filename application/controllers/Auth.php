<?php
class Auth extends CI_Controller
{
  public function index()
  {
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');
    if ($this->form_validation->run() == FALSE) {
      $this->load->view('login/login');
    } else {
      $this->_login();
    }
  }
  private function _login()
  {
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    $user = $this->db->get_where('tb_user', ['username' => $username])->row_array();

    if ($user) {
      if ($user['is_active'] == 1) {
        if (password_verify($password, $user['password'])) {
          $this->session->set_userdata('id', $user['id']);
          $this->session->set_userdata('username', $user['username']);
          $this->session->set_userdata('role_id', $user['role_id']);
          $this->session->set_userdata('id_region', $user['id_region']);
          $this->session->set_userdata('no_telp', $user['no_telp']);
          $this->session->set_userdata('id_bagian', $user['id_bagian']);

          $username = $user['username'];
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

          $aktivitas = "Login";
          $data = array(
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


          switch ($user['role_id']) {
            case 1:
              redirect('c_dashboard');
              break;
            case 2:
              redirect('c_dashboard');
              break;
            case 3:
              redirect('c_dashboard');
              break;
            case 4:
              redirect('c_dashboard');
              break;
            case 5:
              redirect('c_dashboard');
              break;
            case 6:
              redirect('c_dashboard');
              break;
            default:
              break;
          }
        } else {
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert" style=" margin-left:20%;margin-right: 20%;">Password Salah </div>');
          redirect('auth');
        }
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert" style=" margin-left:20%;margin-right: 20%;">username belum di aktifasi </div>');
        redirect('auth');
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert" style=" margin-left:20%;margin-right: 20%;">username tidak terdaftar </div>');
      redirect('auth');
    }
  }
  public function logout()
  {
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

    $aktivitas = "Logout";
    $data = array(
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

    $this->session->sess_destroy();
    redirect('auth');
  }
}