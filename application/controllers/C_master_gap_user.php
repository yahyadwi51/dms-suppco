<?php
class C_master_gap_user extends CI_Controller
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
    $data_user = $this->db->query("SELECT *,tb_user.id AS id_user FROM tb_user 
      LEFT JOIN tb_role ON tb_user.role_id = tb_role.id
      LEFT JOIN tb_master_bagian ON tb_user.bagian = tb_master_bagian.id_bagian");
    $data['data_user'] = $data_user->result_array();
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('master_gap_user', $data);
    $this->load->view('templates/footer');
  }
  public function form_user()
  {
    $data['role'] = $this->model_dokumen->tampil_data_role()->result();
    $this->load->view('tambah-master_gap_user', $data);
  }
  public function tambah_user()
  {
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    $role_id = $this->input->post('role_id');
    $no_telp = $this->input->post('no_telp');

    $data = array(
      'username' => $username,
      'password' => password_hash($password, PASSWORD_DEFAULT),
      'role_id' => $role_id,
      'date_created' => time(),
      'is_active' => 1,
      'no_telp' => $no_telp
    );
    $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'tb_user');
    redirect('c_master_gap_user/index');
  }
  public function edit_user($id)
  {
    $where = array('id' => $id);
    $data['role'] = $this->model_dokumen->tampil_data_role()->result();
    $data['user'] = $this->model_jenis_dokumen->edit_jenis_dokumen($where, 'tb_user')->result();

    $this->load->view('edit-master_gap_user', $data);
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
    redirect('c_master_gap_user/edit_user/' . $id_pass);
  }
  public function update_user()
  {
    $id       = $this->input->post('id');
    $username = $this->input->post('username');
    $is_active = $this->input->post('is_active');
    $role_id = $this->input->post('role_id');
    $no_telp = $this->input->post('no_telp');
    $data = array(
      'username' => $username,
      'role_id' => $role_id,
      'is_active' => $is_active,
      'no_telp' => $no_telp
    );
    $where = array('id' => $id);
    $this->model_dokumen->update_dokumen($where, $data, 'tb_user');
    redirect('c_master_gap_user/index');
  }
  public function delete($id)
  {
    $this->db->query("DELETE FROM `reminder_dok`.`tb_user` WHERE `tb_user`.`id` = '$id'");
    redirect('c_master_gap_user/index');
  }
  public function master_bagian()
  {
    $id = $this->session->userdata('id');
    $master_bag = $this->db->query("SELECT * FROM tb_master_bagian");
    $data['master_bagian'] = $master_bag->result_array();
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('master_bagian', $data);
    $this->load->view('templates/footer');
  }
  public function form_bagian()
  {
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
    redirect('c_master_user/master_bagian');
  }
  public function edit_bagian($id)
  {
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
    redirect('c_master_user/master_bagian');
  }
}