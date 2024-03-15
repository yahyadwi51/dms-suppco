<?php
class c_master_role extends CI_Controller
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

    $this->load->model('model_role');
  }
  public function index()
  {
    $id = $this->session->userdata('id');
    $query_role = $this->db->get('tb_role');
    $data['role'] = $query_role->result_array();
    // Mengenkripsi id_dokumen sebelum mengirimkannya ke view
    foreach ($data['role'] as &$role) {
      $role['encrypted_id'] = $this->encryption->encrypt($role['id']);
      // Menghapus karakter yang tidak diinginkan
      $role['encrypted_id'] = strtr($role['encrypted_id'], array('/' => '=='));
        }
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('master_role', $data);
    $this->load->view('templates/footer');
  }
  public function form_master_role()
  {
    $this->load->view('templates/header');
    $this->load->view('tambah-master_role');
    $this->load->view('templates/sidebar');
    $this->load->view('templates/footer');
  }
  // public function tambah_role()
  // {
  //   $nama_role = $this->input->post('nama_role');

  //   $data = array(
  //     'role' => $nama_role,
  //   );
  //   $this->model_role->tambah_role($data, 'tb_role');
  //   $this->session->set_flashdata('something', 'Pesan Terkirim');
  //   redirect('c_master_role/index');
  // }
  public function detail_role($id)
  {
    $id = str_replace(array('=='), array('/'), $id);
    $id = $this->encryption->decrypt($id);

    $where = array('id' => $id);
    $data['role'] = $this->model_role->edit_role($where, 'tb_role')->result();


    $this->load->view('templates/header');
    $this->load->view('detail-master_role', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('templates/footer');
    
  }
  // public function update_role()
  // {
  //   $id = $this->input->post('id');
  //   $nama_role = $this->input->post('nama_role');

  //   $data = array(
  //     'role' => $nama_role
  //   );
  //   $where = array('id' => $id);
  //   $this->model_role->update_role($where, $data, 'tb_role');
  //   $this->session->set_flashdata('something1', 'Pesan Terkirim');
  //   redirect('c_master_role/index');
  // }
  // public function delete($id)
  // {
  //   $id = str_replace(array('=='), array('/'), $id);
  //   $id = $this->encryption->decrypt($id);
  //   $this->db->where('id', $id);
  //   $this->db->delete('tb_role');
  //   $this->session->set_flashdata('something2', 'Pesan Terkirim');
  //   redirect('c_master_role/index');
  // }
}