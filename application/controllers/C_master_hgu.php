<?php
class C_master_hgu extends CI_Controller{
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
    $query_dokumen      = $this->db->query("SELECT *,gap_master_hgu.keterangan AS ket FROM gap_master_hgu 
      LEFT JOIN tb_master_bagian ON gap_master_hgu.lokasi_kebun = tb_master_bagian.id_bagian 
      ORDER BY gap_master_hgu.id_hgu DESC ");
    $data['jenis_hgu']  = $query_dokumen->result_array();

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar');
    $this->load->view('master_hgu',$data);
    $this->load->view('templates/footer');
  }

  public function detail_hgu($id)
  {
    $query_dokumen  = $this->db->query("SELECT * FROM gap_master_hgu WHERE id_hgu = $id ORDER BY id_hgu DESC");
    $data['hgu']    = $query_dokumen->result();

    $this->load->view('detail-master_hgu',$data);
  }

  public function form_hgu()
  { 
    $query_dokumen        = $this->model_dokumen->tampil_data_kebun();
    $data['master_kebun'] = $query_dokumen->result();

    $this->load->view('tambah-master_hgu',$data);
  }

  public function tambah_hgu()
  {
    $nomor_hgu    = $this->input->post('nomor_hgu');
    $jenis_hat    = $this->input->post('jenis_hat');
    $id_kebun     = $this->input->post('lokasi_kebun');

    $lokasi_kebun = $this->input->post('lokasi_kebun');
      $kebun      =  $this->db->query("SELECT nama_bagian FROM tb_master_bagian WHERE id_bagian = $lokasi_kebun")->result();
      foreach($kebun as $kbn)
      $array[] = $kbn->nama_bagian;
    $lokasi_kebun = $kbn->nama_bagian;

    $idprov     = $this->input->post('id_provinsi');
    $idkab      = $this->input->post('id_kabupaten');
    $idkec      = $this->input->post('id_kecamatan');
    $idkel      = $this->input->post('id_kelurahan');
    
    $provinsi   = $this->input->post('provinsi');
    $kabupaten  = $this->input->post('kabupaten');
    $kecamatan  = $this->input->post('kecamatan');
    $kelurahan  = $this->input->post('kelurahan');
    
    $p          = $_POST['patok'];
    $k          = $_POST['koordinat'];
    $kp         = $_POST['ket_patok'];
    $keterangan = $this->input->post('keterangan');
    $upload_kml = $_FILES['upload_kml']['name'];

    $patok      = implode("-", $p);
    $koordinat  = implode("-", $k);
    $ket_patok  = implode("-", $kp);

    $jumlah = count($upload_kml);
    for ($i=0; $i < $jumlah; $i++) { 
      $gantinama[] = date('His').$upload_kml[$i];
    }

    $cvt_upload_kml = implode(",", $gantinama);
    $date = new DateTime();
    $format_file = array("jpg", "png", "pdf","xls");
    $path = "uploads/"; // Lokasi folder untuk menampung file
    $count = 0;
    if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
      // Loop $_FILES to exeicute all files
      foreach ($_FILES['upload_kml']['name'] as $f => $name) {     
          if ($_FILES['upload_kml']['error'][$f] == 4) {
              continue; // Skip file if any error found
          }	       
          if ($_FILES['upload_kml']['error'][$f] == 0) {	           
                    $destinationFileName = date('His').$name;
                  if(move_uploaded_file($_FILES["upload_kml"]["tmp_name"][$f], $path.$destinationFileName))
                  $count++; // Number of successfully uploaded file
          }
          
      }
    }

    $data = array(
      'jenis_hat'     => $jenis_hat,
      'nomor_hgu'     => $nomor_hgu,
      'id_kebun'      => $id_kebun,
      'lokasi_kebun'  => $lokasi_kebun,
      'id_prov'       => $idprov,
      'provinsi'      => $provinsi,
      'id_kab'        => $idkab,
      'kabupaten'     => $kabupaten,
      'id_kec'        => $idkec,
      'kecamatan'     => $kecamatan,
      'id_kel'        => $idkel,
      'kelurahan'     => $kelurahan,
      'koordinat'     => $koordinat,
      'patok'         => $patok,
      'ket_patok'     => $ket_patok,
      'keterangan'    => $keterangan,
      'upload_kml'    => $cvt_upload_kml
    );

    $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'gap_master_hgu');
    $this->session->set_flashdata('something', 'Pesan Terkirim');

    redirect('c_master_hgu/index');
  }

  public function edit_hgu($id)
  {
    $where                = array('id_hgu' =>$id);
    $data['hgu']          = $this->model_jenis_dokumen->edit_jenis_dokumen($where,'gap_master_hgu')->result();
    $query_dokumen        = $this->model_dokumen->tampil_data_kebun();
    $data['master_kebun'] = $query_dokumen->result();

    $this->load->view('edit-master_hgu',$data);
  }

  public function update_hgu()
  {
    $id           = $this->input->post('id_hgu');
    $jenis_hat    = $this->input->post('jenis_hat');
    $nomor_hgu    = $this->input->post('nomor_hgu');
    $id_kebun     = $this->input->post('lokasi_kebun');

    $lokasi_kebun = $this->input->post('lokasi_kebun');
    $kebun        = $this->db->query("SELECT nama_bagian FROM tb_master_bagian WHERE id_bagian = $lokasi_kebun")->result();
      foreach($kebun as $kbn)
      $array[]    = $kbn->nama_bagian;
    $lokasi_kebun = $kbn->nama_bagian;

    $idprov       = $this->input->post('id_provinsi');
    $idkab        = $this->input->post('id_kabupaten');
    $idkec        = $this->input->post('id_kecamatan');
    $idkel        = $this->input->post('id_kelurahan');

    $provinsi     = $this->input->post('provinsi');
    $kabupaten    = $this->input->post('kabupaten');
    $kecamatan    = $this->input->post('kecamatan');
    $kelurahan    = $this->input->post('kelurahan'); 
    $p            = $_POST['patok'];
    $k            = $_POST['koordinat'];
    $kp           = $_POST['ket_patok'];
    $keterangan   = $this->input->post('keterangan');
    $upload_kml   = $_FILES['upload_kml']['name'];

    $patok        = implode("-", $p);
    $koordinat    = implode("-", $k);
    $ket_patok    = implode("-", $kp);
    
    $jumlah = count($upload_kml);
    for ($i=0; $i < $jumlah; $i++) { 
      $gantinama[] = date('His').$upload_kml[$i];
    }

    $cvt_upload_kml = implode(",", $gantinama);
    $date           = new DateTime();
    $format_file    = array("jpg", "png", "pdf","xls");
    $path           = "uploads/"; // Lokasi folder untuk menampung file
    $count          = 0;

    if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
      // Loop $_FILES to exeicute all files
      foreach ($_FILES['upload_kml']['name'] as $f => $name) {     
          if ($_FILES['upload_kml']['error'][$f] == 4) {
              continue; // Skip file if any error found
          }	       
          if ($_FILES['upload_kml']['error'][$f] == 0) {	           
                    $destinationFileName = date('His').$name;
                  if(move_uploaded_file($_FILES["upload_kml"]["tmp_name"][$f], $path.$destinationFileName))
                  $count++; // Number of successfully uploaded file
          }
          
      }
    }

    $data = array(
      'jenis_hat'     => $jenis_hat,
      'nomor_hgu'     => $nomor_hgu,
      'id_kebun'      => $id_kebun,
      'lokasi_kebun'  => $lokasi_kebun,
      'id_prov'       => $idprov,
      'provinsi'      => $provinsi,
      'id_kab'        => $idkab,
      'kabupaten'     => $kabupaten,
      'id_kec'        => $idkec,
      'kecamatan'     => $kecamatan,
      'id_kel'        => $idkel,
      'kelurahan'     => $kelurahan,
      'koordinat'     => $koordinat,
      'patok'         => $patok,
      'ket_patok'     => $ket_patok,
      'keterangan'    => $keterangan,
      'upload_kml'    => $cvt_upload_kml
    );

    $where = array('id_hgu' => $id);

    $this->model_dokumen->update_dokumen($where,$data,'gap_master_hgu');
    $this->session->set_flashdata('something1', 'Pesan Terkirim');

    redirect('c_master_hgu');
  }

  public function delete()
	{
    $id_delete = $this->input->post('id_delete');

	  $this->db->query("DELETE FROM gap_master_hgu WHERE id_hgu = '$id_delete'");
    $this->session->set_flashdata('something2', 'Pesan Terkirim');

    redirect('c_master_hgu/index');
  }

  public function loadkml($id){
    $query_dokumen = $this->db->query("SELECT * FROM gap_master_hgu WHERE id_hgu = '$id'");
    $data['kml'] = $query_dokumen->result_array();
    $this->load->view('show-kml',$data);
  } 

}