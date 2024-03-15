<?php
class C_laporan_doc extends CI_Controller
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
    $this->load->model('model_dokumen');
  }

  public function index()
  {
    $data['jenis_dokumen'] = $this->model_dokumen->tampil_data_jenis_pengelolah_dokumen_internal()->result();
    $data['media_spmn'] = $this->model_dokumen->tampil_data_media_simpan()->result();

    // Lakukan pemrosesan form ketika form dikirimkan
    if ($this->input->post('tampil')) {
      // Ambil data dari form (jenis_dokumen, item_dokumen, dll.)
      $jenisDokumen = $this->input->post('jenis_dokumen');
      $itemDokumen = $this->input->post('item_dokumen');
      $statusDok = $this->input->post('status_dok');
      $levelDok = $this->input->post('level_dok');
      $mediaSimpan = $this->input->post('media_simpan');
      $tanggalAwal = $this->input->post('tanggal_awal');
      $tanggalAkhir = $this->input->post('tanggal_akhir');

      // Lakukan query ke database dengan filter yang diterapkan
      $data['results'] = $this->model_dokumen->getDataFiltered($jenisDokumen, $itemDokumen, $statusDok, $levelDok, $mediaSimpan, $tanggalAwal, $tanggalAkhir);
      // echo $this->db->last_query(); // Cetak query SQL
      // var_dump($data['results']); // Mencetak isi variabel $data['results']


    }

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('laporan_doc', $data);
    $this->load->view('templates/footer');
  }
}