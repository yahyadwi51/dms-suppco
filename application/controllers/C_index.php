<?php
class C_index extends CI_Controller{
  public function __construct(){
    parent::__construct();
    if($this->session->userdata('role_id') == ''){
      $this->session->set_flashdata('pesan','<div class="alert alert-danger alert-dismissible fade show" role="alert">
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
      $query_notifikasi = $this->db->query("SELECT *,tb_dokumen.id AS iddkm FROM tb_dokumen 
      LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
      WHERE tb_dokumen.id_user = '$id' && pengingat = '1'");
      $jumlah_query_notifikasi = $this->db->query("SELECT *,COUNT(tb_dokumen.id) AS jn FROM tb_dokumen 
      LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
      WHERE tb_dokumen.id_user = '$id' && pengingat = '1'");
      $data['notifikasi_reminder'] = $query_notifikasi->result_array();
      $data['jumlah_notifikasi_reminder'] = $jumlah_query_notifikasi->result_array();
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar');
      $this->load->view('index');
      $this->load->view('templates/footer');
    
  }

}
 ?>
