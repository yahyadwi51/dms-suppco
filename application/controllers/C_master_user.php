<?php
class C_master_user extends CI_Controller
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
  }
  public function index()
  {
    $id = $this->session->userdata('id');
    $data_user = $this->db->query("SELECT *,tb_user.id AS id_user FROM tb_user 
      LEFT JOIN tb_role ON tb_user.role_id = tb_role.id
      LEFT JOIN tb_master_bagian ON tb_user.bagian = tb_master_bagian.id_bagian");
    $data['data_user'] = $data_user->result_array();
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('master_user', $data);
    $this->load->view('templates/footer');
  }
  public function form_user()
  {
    $data_bagian = $this->db->query("SELECT * FROM tb_master_bagian");
    $data['bagian'] = $data_bagian->result();
    $data['role'] = $this->model_dokumen->tampil_data_role()->result();
    $this->load->view('tambah-master_user', $data);
  }
  public function tambah_user()
  {
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    $role_id = $this->input->post('role_id');
    $bagian = $this->input->post('bagian');
    $email = $_POST['email'];
    $id_telegram = $_POST['id_telegram'];
    $no_telp = $_POST['no_telp'] ;
    $data = array(
      'username' => $username,
      'password' => password_hash($password, PASSWORD_DEFAULT),
      'role_id' => $role_id,
      'bagian' => $bagian,
      'date_created' => time(),
      'is_active' => 1,
      'no_telp' => implode(",", $no_telp),
      'email' => implode(",", $email),
      'id_telegram' => implode(",", $id_telegram)
    );
    $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'tb_user');
    $this->session->set_flashdata('something', 'Pesan Terkirim');

    redirect('c_master_user/index');
  }
  public function edit_user($id)
  {
    $where = array('id' => $id);
    $data_bagian = $this->db->query("SELECT * FROM tb_master_bagian");
    $data['bagian'] = $data_bagian->result();
    $data['role'] = $this->model_dokumen->tampil_data_role()->result();
    $data['user'] = $this->model_jenis_dokumen->edit_jenis_dokumen($where, 'tb_user')->result();

    $this->load->view('edit-master_user', $data);
  }
  public function change_password()
  {
    $id_pass       = $this->input->post('id_ganti_pass');
    $password = $this->input->post('password');
    $data = array(
      'password' => password_hash($password, PASSWORD_DEFAULT)
    );
    $where = array('id' => $id_pass);
    $this->model_dokumen->update_dokumen($where, $data, 'tb_user');
    $this->session->set_flashdata('something1', 'Berhasil di Ubah');
    redirect('c_master_user/edit_user/' . $id_pass);
  }
  public function update_user()
  {
    $id       = $this->input->post('id');
    $username = $this->input->post('username');
    $is_active = $this->input->post('is_active');
    $bagian = $this->input->post('bagian');
    $role_id = $this->input->post('role_id');
    $email =$this->input->post('email');
    $id_telegram = $this->input->post('id_telegram');
    $no_telp = $this->input->post('no_telp') ;
    $data = array(
      'username' => $username,
      'role_id' => $role_id,
      'bagian' => $bagian,
      'is_active' => $is_active,
      'no_telp' => $no_telp,
      'email' => $email,
      'id_telegram' => $id_telegram
    );
    $where = array('id' => $id);
    $this->model_dokumen->update_dokumen($where, $data, 'tb_user');
    $this->session->set_flashdata('something1', 'Pesan Terkirim');

    redirect('c_master_user/index');
  }
  public function delete()
  {
    $id_delete = $this->input->post('id_delete');
    $this->db->query("DELETE FROM tb_user WHERE id = '$id_delete'");
    $this->session->set_flashdata('something2', 'Pesan Terkirim');

    redirect('c_master_user/index');
  }

//  ===== PENGATURAN TERKAIT BAGIAN royancilek ====

  public function master_bagian()
  {
    $id = $this->session->userdata('id');
    $query_notifikasi = $this->db->query("SELECT *,tb_dokumen.id AS iddkm FROM tb_dokumen 
      LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
      WHERE tb_dokumen.id_user = '$id' && pengingat = '1'");
    $jumlah_query_notifikasi = $this->db->query("SELECT COUNT(*) AS jn FROM tb_dokumen 
      LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
      WHERE tb_dokumen.id_user = '$id' && pengingat = '1'");
    $master_bag = $this->db->query("SELECT * FROM tb_master_bagian");

    $data['show_formBiasa'] = true;
    $data['role_id'] = $this->session->userdata('role_id');
    $data['master_bagian'] = $master_bag->result_array();

    $data['notifikasi_reminder'] = $query_notifikasi->result_array();
    $data['jumlah_notifikasi_reminder'] = $jumlah_query_notifikasi->result_array();
    
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('master_bagian', $data);
    $this->load->view('templates/footer');
  }
  public function form_bagian()
  {
    $data['show_form'] = true;
    $data['role'] = $this->model_dokumen->tampil_data_role()->result();
    $this->load->view('tambah-master_bagian', $data);
  }
  public function tambah_bagian()
  {
    $nama_bagian = $this->input->post('nama_bagian');
    $kode = $this->input->post('kode');
    $keterangan = $this->input->post('keterangan');
    $status = $this->input->post('status');

    $data = array(
      'nama_bagian' => $nama_bagian,
      'kode' => $kode,
      'keterangan' => $keterangan,
      'status' => $status
    );
    $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'tb_master_bagian');
    $this->session->set_flashdata('something', 'Pesan Terkirim');

    redirect('c_master_user/master_bagian');
  }
  public function edit_bagian($id)
  {
    $data['show_form_edit_biasa'] = true;
    $where = array('id_bagian' => $id);
    $data['role'] = $this->model_dokumen->tampil_data_role()->result();
    $data['bagian'] = $this->model_jenis_dokumen->edit_jenis_dokumen($where, 'tb_master_bagian')->result();

    $this->load->view('edit-master_bagian', $data);
  }
  public function update_bagian()
  {
    $id       = $this->input->post('id');
    $nama_bagian = $this->input->post('nama_bagian');
    $kode = $this->input->post('kode');
    $keterangan = $this->input->post('keterangan');
    $status = $this->input->post('status');
    $data = array(
      'nama_bagian' => $nama_bagian,
      'kode' => $kode,
      'keterangan' => $keterangan,
      'status' => $status
    );
    $where = array('id_bagian' => $id);
    $this->model_dokumen->update_dokumen($where, $data, 'tb_master_bagian');
    $this->session->set_flashdata('something1', 'Pesan Terkirim');

    redirect('c_master_user/master_bagian');
  }
  public function edit_user_profil($id)
  {
    $where = array('id' => $id);
    $data_bagian = $this->db->query("SELECT * FROM tb_master_bagian");
    $data['bagian'] = $data_bagian->result();
    $data['role'] = $this->model_dokumen->tampil_data_role()->result();
    $data['user'] = $this->model_jenis_dokumen->edit_jenis_dokumen($where, 'tb_user')->result();

    $this->load->view('edit-master_user_profil', $data);
  }
  public function update_user_profil()
  {
    $id       = $this->input->post('id');
    $username = $this->input->post('username');
    $email =$this->input->post('email');
    $id_telegram = $this->input->post('id_telegram');
    $no_telp = $this->input->post('no_telp') ;
    $data = array(
      'username' => $username,
      'no_telp' => $no_telp,
      'email' => $email,
      'id_telegram' => $id_telegram
    );
    $where = array('id' => $id);
    $this->model_dokumen->update_dokumen($where, $data, 'tb_user');
    $this->session->set_flashdata('something1', 'Pesan Terkirim');

    redirect('c_dashboard');
  }
  public function change_password_profil()
  {
    $id_pass       = $this->input->post('id_ganti_pass');
    $password = $this->input->post('password');
    $data = array(
      'password' => password_hash($password, PASSWORD_DEFAULT)
    );
    $where = array('id' => $id_pass);
    $this->model_dokumen->update_dokumen($where, $data, 'tb_user');
    $this->session->set_flashdata('something1', 'Berhasil di Ubah');
    redirect('c_master_user/edit_user_profil/' . $id_pass);
  }


  //  ===== PENGATURAN TERKAIT BAGIAN DMS SUPPCO royancilek ====

  public function master_bagianDMS()
  {
    $sesi_region = $this->session->userdata('id_region');
    $id = $this->session->userdata('id');

    $query_notifikasi = $this->db->query("SELECT *,tb_dokumen.id AS iddkm FROM tb_dokumen 
      LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
      WHERE tb_dokumen.id_user = '$id' && pengingat = '1'");

    $jumlah_query_notifikasi = $this->db->query("SELECT COUNT(*) AS jn FROM tb_dokumen 
      LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
      WHERE tb_dokumen.id_user = '$id' && pengingat = '1'");

    $regionbagian = $this->db->query("SELECT *,tb_regional_n2.id_regional AS idrgn FROM tb_regional_n2 
    LEFT JOIN tb_master_bagian ON tb_master_bagian.id_region = tb_regional_n2.id_regional ");

    if($sesi_region == 13){
      $master_bag = $this->db->get('tb_master_bagian');
    }
    else if($sesi_region != 13){
      $master_bag = $this->db->get_where('tb_master_bagian', ['id_region' => $sesi_region]);
    }
  
    $data['role_id'] = $this->session->userdata('role_id');
    $data['show_formDMS'] = true;
    $data['master_bagian'] = $master_bag->result_array();

    // Mengenkripsi id_dokumen sebelum mengirimkannya ke view
    foreach ($data['master_bagian'] as &$master_bagian) {
      $master_bagian['encrypted_id'] = $this->encryption->encrypt($master_bagian['id_bagian']);
      // Menghapus karakter yang tidak diinginkan
      $master_bagian['encrypted_id'] = strtr($master_bagian['encrypted_id'], array('/' => '=='));
        }

        
    $data['regionbagian'] = $regionbagian->result_array();
    $data['notifikasi_reminder'] = $query_notifikasi->result_array();
    $data['jumlah_notifikasi_reminder'] = $jumlah_query_notifikasi->result_array();

    //var_dump($regionbagian);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('master_bagian', $data);
    $this->load->view('templates/footer');
  }
  public function form_bagianDMS()
  {
    $regionbagian_query = $this->db->query("SELECT * FROM tb_regional_n2");
    $regionbagian = $regionbagian_query->result_array();

    $data['show_form'] = true;
    $data['role_id'] = $this->session->userdata('role_id');
    $data['role'] = $this->model_dokumen->tampil_data_role()->result();
    $data['regionbagian'] = $regionbagian;


    
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('tambah-master_bagian', $data);
    $this->load->view('templates/footer');

    
  }
  public function tambah_bagianDMS()
  {
    $nama_bagian = $this->input->post('nama_bagian');
    $nama_region = $this->input->post('nama_region');
    $kode = $this->input->post('kode');
    $keterangan = $this->input->post('keterangan');
    $status = $this->input->post('status');


    $existing_bagian = $this->db->query("SELECT * FROM `tb_master_bagian` WHERE nama_bagian = '$nama_bagian'");


    if ($existing_bagian->num_rows() > 0) {
      // Data sudah ada, tampilkan pesan kesalahan atau lakukan tindakan sesuai kebutuhan Anda
      // $data['error_message'] = "Data media_simpan sudah ada dalam database.";
      // $this->load->view('error_view', $data); // Gantilah 'error_view' dengan view yang sesuai
      $this->session->set_flashdata('something3', 'Pesan Terkirim');
  } else {
      // Data belum ada, simpan data ke database
      $data = array(
        'nama_bagian' => $nama_bagian,
        'id_region' => $nama_region,
        'kode' => $kode,
        'keterangan' => $keterangan,
        'status' => $status
      );
      $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'tb_master_bagian');
      $this->session->set_flashdata('something', 'Pesan Terkirim');
  }  
    redirect('c_master_user/master_bagianDMS');
  }

  public function edit_bagianDMS($id)
  {
      // Mengembalikan karakter-karakter yang dihilangkan sebelumnya
      $id = str_replace(array('=='), array('/'), $id);
      $id = $this->encryption->decrypt($id);

      $regionbagian = $this->db->query("SELECT *, tb_regional_n2.id_regional AS idrgn FROM tb_regional_n2 
      LEFT JOIN tb_master_bagian ON tb_master_bagian.id_region = tb_regional_n2.id_regional
      GROUP BY tb_regional_n2.id_regional");
  
      $data['regionbagian'] = $regionbagian->result_array();
      $data['show_form_edit_DMS'] = true;
      $where = array('id_bagian' => $id);
      $data['role_id'] = $this->session->userdata('role_id');
      $data['bagian'] = $this->model_jenis_dokumen->edit_jenis_dokumen($where, 'tb_master_bagian')->result_array(); // Ubah menjadi result_array()
  
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar');
      $this->load->view('edit-master_bagian', $data);
      $this->load->view('templates/footer');
  }
  public function update_bagianDMS()
  {
    $id       = $this->input->post('id');
    $nama_bagian = $this->input->post('nama_bagian');
    $nama_region = $this->input->post('nama_region');
    $kode = $this->input->post('kode');
    $keterangan = $this->input->post('keterangan');
    $status = $this->input->post('status');

    $data = array(
      'nama_bagian' => $nama_bagian,
      'id_region' => $nama_region,
      'kode' => $kode,
      'keterangan' => $keterangan,
      'status' => $status
    );
    $where = array('id_bagian' => $id);
    $this->model_dokumen->update_dokumen($where, $data, 'tb_master_bagian');
    $this->session->set_flashdata('something1', 'Pesan Terkirim');

    redirect('c_master_user/master_bagianDMS');
  }

  public function deleteDMS($id)
  {
    // Mengembalikan karakter-karakter yang dihilangkan sebelumnya
    $id = str_replace(array('=='), array('/'), $id);
    $id = $this->encryption->decrypt($id);
      
    $this->db->query("DELETE FROM `tb_master_bagian` WHERE `tb_master_bagian`.`id_bagian` = '$id'");
    $this->session->set_flashdata('something2', 'Pesan Terkirim');

    redirect('c_master_user/master_bagianDMS');
  }
  
}