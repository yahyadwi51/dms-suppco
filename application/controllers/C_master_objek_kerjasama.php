<?php
class C_master_objek_kerjasama extends CI_Controller{
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
      $query_dokumen = $this->db->query("SELECT * FROM `gap_master_objek_kerjasama`");
      $data['jenis_objek_kerjasama'] = $query_dokumen->result_array();
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar');
      $this->load->view('master_objek_kerjasama',$data);
      $this->load->view('templates/footer');
    
  }
  public function form_objek_kerjasama()
  { 
    $this->load->view('tambah-master_objek_kerjasama');
  }
  public function tambah_objek_kerjasama()
  {
    $nama_objek_kerjasama = $this->input->post('nama_objek_kerjasama');
    $keterangan = $this->input->post('keterangan');
    
    $data = array(
      'nama_objek_kerjasama' => $nama_objek_kerjasama,
      'keterangan' => $keterangan
    );
    $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'gap_master_objek_kerjasama');
    $this->session->set_flashdata('something', 'Pesan Terkirim');
    redirect('c_master_objek_kerjasama/index');
  }
  public function edit_objek_kerjasama($id)
  {
    $where = array('id_objek_kerjasama' =>$id);
    $data['objek_kerjasama'] = $this->model_jenis_dokumen->edit_jenis_dokumen($where,'gap_master_objek_kerjasama')->result();
    
    $this->load->view('edit-master_objek_kerjasama',$data);
  }
  public function update_objek_kerjasama()
  {
    $id       = $this->input->post('id_objek_kerjasama');
    $nama_objek_kerjasama = $this->input->post('nama_objek_kerjasama');
    $keterangan = $this->input->post('keterangan');
    
    $data = array(
      'nama_objek_kerjasama' => $nama_objek_kerjasama,
      'keterangan' => $keterangan
    );
    $where = array('id_objek_kerjasama' => $id);
    $this->model_dokumen->update_dokumen($where,$data,'gap_master_objek_kerjasama');
    $this->session->set_flashdata('something1', 'Pesan Terkirim');
    redirect('c_master_objek_kerjasama');
  }
  public function delete()
	{
    $id_delete = $this->input->post('id_delete');
    $this->db->query("DELETE FROM gap_master_objek_kerjasama WHERE id_objek_kerjasama = '$id_delete'");
    $this->session->set_flashdata('something2', 'Pesan Terkirim');
    redirect('c_master_objek_kerjasama/index');
	}

}