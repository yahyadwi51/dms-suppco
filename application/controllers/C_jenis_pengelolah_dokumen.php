<?php
class C_jenis_pengelolah_dokumen extends CI_Controller
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
    $query_dokumen = $this->db->query("SELECT * FROM `hkm_master_jenis_dokumen`");
    $data['jenis_dokumen'] = $query_dokumen->result_array();
    // Mengenkripsi id_dokumen sebelum mengirimkannya ke view
    foreach ($data['jenis_dokumen'] as &$jenis) {
      $jenis['encrypted_id'] = $this->encryption->encrypt($jenis['id_jenis_dokumen']);
      // Menghapus karakter yang tidak diinginkan
    $jenis['encrypted_id'] = strtr($jenis['encrypted_id'], array('/' => '=='));
  }
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('master_jenis_pengelolah_dokumen', $data);
    $this->load->view('templates/footer');
  }
  public function form_jenis_dokumen()
  {
    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('tambah-master_jenis_pengelolah_dokumen');
    $this->load->view('templates/footer');
  }
  public function tambah_jenis_dokumen()
  {
    $nama_jenis_dokumen = $this->input->post('nama_jenis_dokumen');
    $status_jenis_dokumen = $this->input->post('status_jenis_dokumen');
    $keterangan = $this->input->post('keterangan');
    $item_dokumen = $this->input->post('item_dokumen');

    $existing_jenis = $this->db->query("SELECT * FROM `hkm_master_jenis_dokumen` WHERE nama_jenis_dokumen = '$nama_jenis_dokumen'");

    if ($existing_jenis->num_rows() > 0) {
      // Data sudah ada, tampilkan pesan kesalahan atau lakukan tindakan sesuai kebutuhan Anda
      // $data['error_message'] = "Data media_simpan sudah ada dalam database.";
      // $this->load->view('error_view', $data); // Gantilah 'error_view' dengan view yang sesuai
      $this->session->set_flashdata('something3', 'Pesan Terkirim');
  } else {
      // Data belum ada, simpan data ke database
      $data = array(
        'nama_jenis_dokumen' => $nama_jenis_dokumen,
        'status_jenis_dokumen' => $status_jenis_dokumen,
        'keterangan' => $keterangan,
        'item_dokumen' => $item_dokumen
      );
      $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'hkm_master_jenis_dokumen');
      $this->session->set_flashdata('something', 'Pesan Terkirim');
  }  
    redirect('c_jenis_pengelolah_dokumen/index');
  }
  public function edit_jenis_dokumen($id)
  {
    // Mengembalikan karakter-karakter yang dihilangkan sebelumnya
    $id = str_replace(array('=='), array('/'), $id);
    $id = $this->encryption->decrypt($id);
    $where = array('id_jenis_dokumen' => $id);
    $data['jenis_dokumen'] = $this->model_jenis_dokumen->edit_jenis_dokumen($where, 'hkm_master_jenis_dokumen')->result();

    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('edit-master_jenis_pengelolah_dokumen', $data);
    $this->load->view('templates/footer');
  }
  public function update_jenis_dokumen()
  {
    $id       = $this->input->post('id');
    $nama_jenis_dokumen = $this->input->post('nama_jenis_dokumen');
    $status_jenis_dokumen = $this->input->post('status_jenis_dokumen');
    $keterangan = $this->input->post('keterangan');
    $item_dokumen = $this->input->post('item_dokumen');

    $data = array(
      'nama_jenis_dokumen' => $nama_jenis_dokumen,
      'status_jenis_dokumen' => $status_jenis_dokumen,
      'keterangan' => $keterangan,
      'item_dokumen' => $item_dokumen
    );
    $where = array('id_jenis_dokumen' => $id);
    $this->model_dokumen->update_dokumen($where, $data, 'hkm_master_jenis_dokumen');
    $this->session->set_flashdata('something1', 'Pesan Terkirim');
    redirect('c_jenis_pengelolah_dokumen/index');
  }
  public function delete($id)
  {
    // Mengembalikan karakter-karakter yang dihilangkan sebelumnya
    $id = str_replace(array('=='), array('/'), $id);
    $id = $this->encryption->decrypt($id);
    $this->db->query("DELETE FROM hkm_master_jenis_dokumen WHERE id_jenis_dokumen = '$id'");
    $this->session->set_flashdata('something2', 'Pesan Terkirim');
    redirect('c_jenis_pengelolah_dokumen/index');
  }
}