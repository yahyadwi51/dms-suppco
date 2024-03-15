<?php
class C_master_lsm extends CI_Controller{
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
      $id                 = $this->session->userdata('id');
      $query_dokumen      = $this->db->query("SELECT * FROM `gap_master_lsm`");
      $data['jenis_lsm']  = $query_dokumen->result_array();
      
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar');
      $this->load->view('master_lsm',$data);
      $this->load->view('templates/footer');
  }

  public function form_lsm()
  { 
    $data['kebun'] = $this->model_dokumen->tampil_data_kebun()->result();
    $this->load->view('tambah-master_lsm', $data);
  }

  public function tambah_lsm()
  {
    $nama_lsm   = $this->input->post('nama_lsm');
    $kebun      = $this->input->post('kebun');
    $lokasi_lsm = $this->input->post('lokasi_lsm');
    $pic        = $this->input->post('pic');
    $alamat     = $this->input->post('alamat');
    
    $data = array(
      'nama_lsm' => $nama_lsm,
      'kebun' => $kebun,
      'lokasi_lsm' => $lokasi_lsm,
      'pic' => $pic,
      'alamat' => $alamat
    );

    $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'gap_master_lsm');
    $this->session->set_flashdata('something', 'Pesan Terkirim');
    
    redirect('c_master_lsm/index');
  }

  public function edit_lsm($id)
  {
    $where          = array('id_lsm' =>$id);

    $data['kebun']  = $this->model_dokumen->tampil_data_kebun()->result();
    $data['lsm']    = $this->model_jenis_dokumen->edit_jenis_dokumen($where,'gap_master_lsm')->result();

    $this->load->view('edit-master_lsm', $data);
  }

  public function update_lsm()
  {
    $id         = $this->input->post('id_lsm');
    $nama_lsm   = $this->input->post('nama_lsm');
    $kebun      = $this->input->post('kebun');
    $lokasi_lsm = $this->input->post('lokasi_lsm');
    $pic        = $this->input->post('pic');
    $alamat     = $this->input->post('alamat');
    $data       = array(
                    'nama_lsm' => $nama_lsm,
                    'kebun' => $kebun,
                    'lokasi_lsm' => $lokasi_lsm,
                    'pic' => $pic,
                    'alamat' => $alamat
                  );
    $where      = array('id_lsm' => $id);

    $this->model_dokumen->update_dokumen($where,$data,'gap_master_lsm');
    $this->session->set_flashdata('something1', 'Pesan Terkirim');

    redirect('c_master_lsm/index');
  }

  public function delete()
	{
    $id_delete = $this->input->post('id_delete');

    $this->db->query("DELETE FROM gap_master_lsm WHERE id_lsm = '$id_delete'");
    $this->session->set_flashdata('something2', 'Pesan Terkirim');

    redirect('c_master_lsm/index');
	}

}