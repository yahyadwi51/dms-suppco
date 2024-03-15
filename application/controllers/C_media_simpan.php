<?php
class c_media_simpan extends CI_Controller
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

    $this->load->model('model_media_simpan');
  }

  public function index()
  {
    $id = $this->session->userdata('id');
    $query_media = $this->model_media_simpan->tampil_data();
    $data['media_simpan'] = $query_media->result_array();
    // Mengenkripsi id_dokumen sebelum mengirimkannya ke view
    foreach ($data['media_simpan'] as &$media) {
    $media['encrypted_id'] = $this->encryption->encrypt($media['id_media_simpan_dok']);
    // Menghapus karakter yang tidak diinginkan
    $media['encrypted_id'] = strtr($media['encrypted_id'], array('/' => '=='));
      }
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('master_media_simpan', $data);
    $this->load->view('templates/footer');
  }
  public function form_media_simpan()
  {
    $query_media = $this->model_media_simpan->tampil_data();
    $data['media_simpan'] = $query_media->result_array();

    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('tambah-media_simpan');
    $this->load->view('templates/footer');
  }
  public function tambah_media()
  {
    $media_simpan = $this->input->post('media_simpan');
    $existing_media = $this->model_media_simpan->cek_data($media_simpan);

    if ($existing_media->num_rows() > 0) {
        // Data sudah ada, tampilkan pesan kesalahan atau lakukan tindakan sesuai kebutuhan Anda
        // $data['error_message'] = "Data media_simpan sudah ada dalam database.";
        // $this->load->view('error_view', $data); // Gantilah 'error_view' dengan view yang sesuai
        $this->session->set_flashdata('something3', 'Pesan Terkirim');
    } else {
        // Data belum ada, simpan data ke database
        $data = array(
          'media_simpan' => $media_simpan,
        );
        $this->model_media_simpan->tambah_media_simpan($data, 'master_media_simpan');
        $this->session->set_flashdata('something', 'Pesan Terkirim');
    }  
    redirect('c_media_simpan/index');
  }
  public function edit_media($id)
  {
    // Mengembalikan karakter-karakter yang dihilangkan sebelumnya
    $id = str_replace(array('=='), array('/'), $id);
    $id = $this->encryption->decrypt($id);
    $where = array('id_media_simpan_dok' => $id);
    $data['media_simpan'] = $this->model_media_simpan->edit_media_simpan($where, 'master_media_simpan')->result();

    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('edit-media_simpan', $data);
    $this->load->view('templates/footer');
  }
  public function update_media()
  {
    $id       = $this->input->post('id');
    $media_simpan = $this->input->post('media_simpan');

    $data = array(
      'media_simpan' => $media_simpan
    );
    $where = array('id_media_simpan_dok' => $id);
    $this->model_media_simpan->update_media_simpan($where, $data, 'master_media_simpan');
    $this->session->set_flashdata('something1', 'Pesan Terkirim');
    redirect('c_media_simpan/index');
  }
  public function delete($id)
  {
    // Mengembalikan karakter-karakter yang dihilangkan sebelumnya
    $id = str_replace(array('=='), array('/'), $id);
    $id = $this->encryption->decrypt($id);
    $where = array('id_media_simpan_dok' => $id);
    $this->model_media_simpan->hapus_media_simpan($where, 'master_media_simpan');
    $this->session->set_flashdata('something2', 'Pesan Terkirim');
    redirect('c_media_simpan/index');
  }
}