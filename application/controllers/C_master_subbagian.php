<?php
class c_master_subbagian extends CI_Controller
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

    $this->load->model('model_subbagian');
  }
  public function index()
  {
    $sesi_region = $this->session->userdata('id_region');
    $id = $this->session->userdata('id');

    $region_subbagian = $this->db->query("SELECT *,tb_regional_n2.id_regional AS idrgn FROM tb_regional_n2 
    LEFT JOIN tb_sub_bagian ON tb_sub_bagian.id_region = tb_regional_n2.id_regional");

    $bagian_subbagian = $this->db->query("SELECT *,tb_master_bagian.id_bagian AS idbgn FROM tb_master_bagian 
    LEFT JOIN tb_sub_bagian ON tb_sub_bagian.id_bagian = tb_master_bagian.id_bagian ");

    if($sesi_region == 13){
      $query_subag = $this->db->get('tb_sub_bagian');
    }
    else if($sesi_region != 13){
      $query_subag = $this->db->get_where('tb_sub_bagian', ['id_region' => $sesi_region]);
    }
  
    $data['subbagian'] = $query_subag->result_array();
    $data['regionsubag'] = $region_subbagian->result_array();
    $data['bagsubag'] = $bagian_subbagian->result_array();

    // Mengenkripsi id_dokumen sebelum mengirimkannya ke view
    foreach ($data['subbagian'] as &$subbagian) {
      $subbagian['encrypted_id'] = $this->encryption->encrypt($subbagian['id_sub_bag']);
      // Menghapus karakter yang tidak diinginkan
      $subbagian['encrypted_id'] = strtr($subbagian['encrypted_id'], array('/' => '=='));
        }

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('master_subbagian', $data);
    $this->load->view('templates/footer');
  }

  public function form_master_subbagian($id=null)
  {
    $sesi_region = $this->session->userdata('id_region');

    $regionsubag_query = $this->db->query("SELECT * FROM tb_regional_n2");
    $regionsubag = $regionsubag_query->result_array();

    if($sesi_region == 13){
      $bagsubag_query = $this->db->query("SELECT * FROM tb_master_bagian");
    }
    else if($sesi_region != 13){
      $bagsubag_query = $this->db->query("SELECT * FROM tb_master_bagian WHERE tb_master_bagian.id_region = $sesi_region");
    }
    
    $bagsubag = $bagsubag_query->result_array();

    $data['regionsubag'] = $regionsubag;
    $data['bagsubag'] = $bagsubag;
    $where = array('id_sub_bagian' => $id);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('tambah-master_subbagian', $data);
    $this->load->view('templates/footer');
  }

  public function tambah_subbagian()
  {
    $nama_subbagian = $this->input->post('nama_subbagian');
    $nama_bagian = $this->input->post('nama_bagian');
    $nama_region = $this->input->post('nama_region');
    $keterangan = $this->input->post('keterangan');
    $kode = $this->input->post('kode');
    $status = $this->input->post('status');

    $existing_subag = $this->model_subbagian->cek_data($nama_subbagian);

    if ($existing_subag->num_rows() > 0) {
      // Data sudah ada, tampilkan pesan kesalahan atau lakukan tindakan sesuai kebutuhan Anda
      // $data['error_message'] = "Data media_simpan sudah ada dalam database.";
      // $this->load->view('error_view', $data); // Gantilah 'error_view' dengan view yang sesuai
      $this->session->set_flashdata('something3', 'Pesan Terkirim');
  } else {
      // Data belum ada, simpan data ke database
      $data = array(
        'nama_sub_bag' => $nama_subbagian,
        'id_bagian' => $nama_bagian,
        'id_region' => $nama_region,
        'kode' => $kode,
        'keterangan' => $keterangan,
        'status' => $status
      );
      $this->model_subbagian->tambah_subbagian($data, 'tb_sub_bagian');
      $this->session->set_flashdata('something', 'Pesan Terkirim');
  } 
    redirect('c_master_subbagian/index');
  }

  public function edit_subbagian($id)
  {
    // Mengembalikan karakter-karakter yang dihilangkan sebelumnya
    $id = str_replace(array('=='), array('/'), $id);
    $id = $this->encryption->decrypt($id);
    $where = array('id_sub_bag' => $id);

    $data['region_subbagian'] = $this->db->query("SELECT DISTINCT id_regional, nama_regional FROM tb_regional_n2 
    LEFT JOIN tb_sub_bagian ON tb_sub_bagian.id_region = tb_regional_n2.id_regional")->result();

    $data['bagian_subbagian'] = $this->db->query("SELECT DISTINCT  tb_master_bagian.id_bagian AS id_bagian , nama_bagian, tb_master_bagian.id_region AS id_reg FROM tb_master_bagian 
    LEFT JOIN tb_sub_bagian ON tb_sub_bagian.id_bagian = tb_master_bagian.id_bagian")->result();

    $data['subbagian'] = $this->model_subbagian->edit_subbagian($where, 'tb_sub_bagian')->result();


    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('edit-master_subbagian', $data);
    $this->load->view('templates/footer');
  }

  public function update_subbagian()
  {
    $id       = $this->input->post('id');
    $nama_subbagian = $this->input->post('nama_subbagian');
    $nama_bagian = $this->input->post('nama_bagian');
    $nama_region = $this->input->post('nama_region');
    $keterangan = $this->input->post('keterangan');
    $kode = $this->input->post('kode');
    $status = $this->input->post('status');

    $data = array(
      'nama_sub_bag' => $nama_subbagian,
      'id_bagian' => $nama_bagian,
      'id_region' => $nama_region,
      'kode' => $kode,
      'keterangan' => $keterangan,
      'status' => $status
    );

    $where = array('id_sub_bag' => $id);
    $this->model_subbagian->update_subbagian($where, $data, 'tb_sub_bagian');
    $this->session->set_flashdata('something1', 'Pesan Terkirim');
    redirect('c_master_subbagian/index');
  }

  public function delete_subbagian($id)
  {
    // Mengembalikan karakter-karakter yang dihilangkan sebelumnya
    $id = str_replace(array('=='), array('/'), $id);
    $id = $this->encryption->decrypt($id);
    
    $this->db->query("DELETE FROM `tb_sub_bagian` WHERE `tb_sub_bagian`.`id_sub_bag` = '$id'");
    $this->session->set_flashdata('something2', 'Pesan Terkirim');
    redirect('c_master_subbagian/index');
  }
}