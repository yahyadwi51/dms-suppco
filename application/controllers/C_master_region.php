<?php
class c_master_region extends CI_Controller
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

    $this->load->model('model_regional');
  }
  public function index()
  {
    $id = $this->session->userdata('id');
    $query_region = $this->db->query("SELECT * FROM `tb_regional_n2`");
    $data['regional'] = $query_region->result_array();
    // Mengenkripsi id_dokumen sebelum mengirimkannya ke view
    foreach ($data['regional'] as &$regional) {
      $regional['encrypted_id'] = $this->encryption->encrypt($regional['id_regional']);
      // Menghapus karakter yang tidak diinginkan
      $regional['encrypted_id'] = strtr($regional['encrypted_id'], array('/' => '=='));
        }
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('master_regional', $data);
    $this->load->view('templates/footer');
  }
  public function form_master_regional()
  {

    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('tambah-master_regional');
    $this->load->view('templates/footer');
    
  }
  public function tambah_regional()
  {
    $nama_regional = $this->input->post('nama_regional');

    $existing_regional = $this->model_regional->cek_data($nama_regional);


    if ($existing_regional->num_rows() > 0) {
      // Data sudah ada, tampilkan pesan kesalahan atau lakukan tindakan sesuai kebutuhan Anda
      // $data['error_message'] = "Data media_simpan sudah ada dalam database.";
      // $this->load->view('error_view', $data); // Gantilah 'error_view' dengan view yang sesuai
      $this->session->set_flashdata('something3', 'Pesan Terkirim');
  } else {
      // Data belum ada, simpan data ke database
      $data = array(
        'nama_regional' => $nama_regional,
      );
      $this->model_regional->tambah_region($data, 'tb_regional_n2');
      $this->session->set_flashdata('something', 'Pesan Terkirim');
  }  
    redirect('c_master_region/index');
  }
  public function edit_region($id)
  {
    // Mengembalikan karakter-karakter yang dihilangkan sebelumnya
    $id = str_replace(array('=='), array('/'), $id);
    $id = $this->encryption->decrypt($id);
    $where = array('id_regional' => $id);
    $data['regional'] = $this->model_regional->edit_region($where, 'tb_regional_n2')->result();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('edit-master_regional', $data);
    $this->load->view('templates/footer');
  }
  public function update_region()
  {
    $id       = $this->input->post('id');
    $nama_regional = $this->input->post('nama_regional');

    $data = array(
      'nama_regional' => $nama_regional
    );
    $where = array('id_regional' => $id);
    $this->model_regional->update_region($where, $data, 'tb_regional_n2');
    $this->session->set_flashdata('something1', 'Pesan Terkirim');
    redirect('c_master_region/index');
  }
  public function delete($id)
  {
    // Mengembalikan karakter-karakter yang dihilangkan sebelumnya
    $id = str_replace(array('=='), array('/'), $id);
    $id = $this->encryption->decrypt($id);
    $this->db->query("DELETE FROM `tb_regional_n2` WHERE `tb_regional_n2`.`id_regional` = '$id'");
    $this->session->set_flashdata('something2', 'Pesan Terkirim');
    redirect('c_master_region/index');
  }
}