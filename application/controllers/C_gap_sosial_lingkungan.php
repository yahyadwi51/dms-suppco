<?php
class C_gap_sosial_lingkungan extends CI_Controller{
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
      $id = $this->session->userdata('bagian');
      $username = $this->session->userdata('username');
      if ($username == 'admin' || $username == 'sekper') {
        $query_sosial_lingkungan= $this->db->query("SELECT  *,gap_master_lsm.nama_lsm AS namaLSM FROM gap_sosial_lingkungan LEFT JOIN gap_master_lsm ON gap_sosial_lingkungan.nama_lsm = gap_master_lsm.id_lsm 
        WHERE status='0' ORDER BY id_sos_lik DESC");
      }else{
        $query_sosial_lingkungan= $this->db->query("SELECT  *,gap_master_lsm.nama_lsm AS namaLSM FROM gap_sosial_lingkungan LEFT JOIN gap_master_lsm ON gap_sosial_lingkungan.nama_lsm = gap_master_lsm.id_lsm 
        WHERE status='0' && id_kebun='$id' ORDER BY id_sos_lik DESC");
      }
      
      $data['user'] = $this->model_dokumen->tampil_data_user()->result_array();
      $data['sosial_lingkungan'] = $query_sosial_lingkungan->result_array();
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar');
      $this->load->view('gap_sosial_lingkungan',$data);
      $this->load->view('templates/footer');
    
  }

  public function form_sosial_lingkungan()
  { 
    $query_hgu= $this->db->query("SELECT * FROM gap_master_lsm ");
    $data['master_lsm'] = $query_hgu->result_array();
    $data['kebun'] = $this->model_dokumen->tampil_data_kebun()->result();
    $this->load->view('tambah-gap_sosial_lingkungan',$data);
  }

  public function tambah_sosial_lingkungan()
  {
    $nama_lsm = $this->input->post('nama_lsm');
    $lokasi = $this->input->post('lokasi');
    $id_kebun = $this->input->post('id_kebun');
    $tanggal = $this->input->post('tanggal');
    $cnvrt_tanggal = date('Y-m-d', strtotime($tanggal));
    $kondisi_saat_ini = $this->input->post('kondisi_saat_ini');
    $kondisi_10thn_terakhir = $this->input->post('kondisi_10thn_terakhir');
    $keterangan = $this->input->post('keterangan');

    $select = $this->db->select('nama_bagian');
    $nama_kebun = $select->get("tb_master_bagian WHERE id_bagian = '$id_kebun' ");
    $data = $nama_kebun->result_array();
    foreach ($data as $nk) : {
      $nama_kebun = $nk['nama_bagian'];
    }
    endforeach;

    $data = array(
      'nama_kebun' => $nama_kebun,
      'nama_lsm' => $nama_lsm,
      'lokasi' => $lokasi,
      'id_kebun' => $id_kebun,
      'tanggal' => $cnvrt_tanggal,
      'kondisi_saat_ini' => $kondisi_saat_ini,
      'kondisi_10thn_terakhir' => $kondisi_10thn_terakhir,
      'keterangan' => $keterangan
    );
    $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'gap_sosial_lingkungan');
    $this->session->set_flashdata('something', 'Pesan Terkirim');

    redirect('c_gap_sosial_lingkungan/index');
  }
  public function edit_sosial_lingkungan($id)
  {

    $query_hgu= $this->db->query("SELECT * FROM gap_master_lsm ");
    $data['master_lsm'] = $query_hgu->result_array();
    $where = array('id_sos_lik' =>$id);

    $query_kebun= $this->db->query("SELECT tb_master_bagian.nama_bagian, gap_legal_ijin.id_kebun FROM tb_master_bagian 
      LEFT JOIN gap_legal_ijin ON tb_master_bagian.id_bagian = gap_legal_ijin.id_kebun
      WHERE gap_legal_ijin.id_legal_ijin = '$id' ");
    $data['kebun'] = $query_kebun->result();
    
    $data['pilihkebun'] = $this->model_dokumen->tampil_data_kebun()->result();
    
    $data['sosial_lingkungan'] = $this->model_jenis_dokumen->edit_jenis_dokumen($where,'gap_sosial_lingkungan')->result();
    $this->load->view('edit-gap_sosial_lingkungan',$data);
  }
  public function update_sosial_lingkungan()
  {
    $id = $this->input->post('id');
    $nama_lsm = $this->input->post('nama_lsm');
    $lokasi = $this->input->post('lokasi');
    $id_kebun = $this->input->post('id_kebun');
    $tanggal = $this->input->post('tanggal');
    $cnvrt_tanggal = date('Y-m-d', strtotime($tanggal));
    $kondisi_saat_ini = $this->input->post('kondisi_saat_ini');
    $kondisi_10thn_terakhir = $this->input->post('kondisi_10thn_terakhir');
    $keterangan = $this->input->post('keterangan');

    $select = $this->db->select('nama_bagian');
    $nama_kebun = $select->get("tb_master_bagian WHERE id_bagian = '$id_kebun' ");
    $data = $nama_kebun->result_array();
    foreach ($data as $nk) : {
      $nama_kebun = $nk['nama_bagian'];
    }
    endforeach;

    $data = array(
      'nama_kebun' => $nama_kebun,
      'nama_lsm' => $nama_lsm,
      'id_kebun' => $id_kebun,
      'lokasi' => $lokasi,
      'tanggal' => $cnvrt_tanggal,
      'kondisi_saat_ini' => $kondisi_saat_ini,
      'kondisi_10thn_terakhir' => $kondisi_10thn_terakhir,
      'keterangan' => $keterangan
    );
        $where = array('id_sos_lik' => $id);
        $this->model_dokumen->update_dokumen($where,$data,'gap_sosial_lingkungan');
    $this->session->set_flashdata('something1', 'Pesan Terkirim');

        redirect('c_gap_sosial_lingkungan/index');
  }

  public function nonaktif()
	{
        $status       = '1';
        $id_delete = $this->input->post('id_delete');

        $data = array(
            'status' => $status
        );
        $where = array('id_sos_lik' => $id_delete);
        $this->model_dokumen->update_dokumen($where,$data,'gap_sosial_lingkungan');
        $this->session->set_flashdata('something2', 'Pesan Terkirim');
        redirect('c_gap_sosial_lingkungan/index');
  }


  public function aktif()
	{
        $id_delete = $this->input->post('id_delete');

        $status       = '0';

        $data = array(
            'status' => $status
        );
        $where = array('id_sos_lik' => $id_delete);
        $this->model_dokumen->update_dokumen($where,$data,'gap_sosial_lingkungan');
    $this->session->set_flashdata('something3', 'Pesan Terkirim');

        redirect('c_gap_sosial_lingkungan/index');
  }
    
  public function load_status_surat()
  {
      $status_surat = $_GET['status_surat'];
      $idkebun = $this->session->userdata('bagian');
      $username = $this->session->userdata('username');
      
      if ($status_surat == 'aktif' && $username == 'admin') {
        $query_sosial_lingkungan= $this->db->query("SELECT *,gap_master_lsm.nama_lsm AS namaLSM  FROM gap_sosial_lingkungan 
        LEFT JOIN gap_master_lsm ON gap_sosial_lingkungan.nama_lsm = gap_master_lsm.id_lsm 
        WHERE status='0'");
        $data['legal_ijin'] = $query_sosial_lingkungan->result_array();
          
      }elseif ($status_surat == 'aktif' && $username != 'admin') {
          $query_sosial_lingkungan= $this->db->query("SELECT *,gap_master_lsm.nama_lsm AS namaLSM  FROM gap_sosial_lingkungan 
          LEFT JOIN gap_master_lsm ON gap_sosial_lingkungan.nama_lsm = gap_master_lsm.id_lsm 
          WHERE status='0' AND id_kebun='$idkebun'");
          $data['legal_ijin'] = $query_sosial_lingkungan->result_array();
          
      }elseif ($status_surat == 'nonaktif' && $username == 'admin') {
          $query_sosial_lingkungan= $this->db->query("SELECT * FROM gap_sosial_lingkungan 
          LEFT JOIN gap_master_lsm ON gap_sosial_lingkungan.nama_lsm = gap_master_lsm.id_lsm 
          WHERE gap_sosial_lingkungan.status='1' ");
          $data['legal_ijin'] = $query_sosial_lingkungan->result_array();
          // print_r($data['legal_ijin']);
          // die();
          
      }elseif ($status_surat == 'nonaktif' && $username != 'admin') {
        $query_sosial_lingkungan= $this->db->query("SELECT *,gap_master_lsm.nama_lsm AS namaLSM  FROM gap_sosial_lingkungan 
        LEFT JOIN gap_master_lsm ON gap_sosial_lingkungan.nama_lsm = gap_master_lsm.id_lsm 
        WHERE status='1' AND id_kebun='$idkebun'");
        $data['legal_ijin'] = $query_sosial_lingkungan->result_array();
        
      } 
        $no=0;
        foreach ($data['legal_ijin'] as $pk) :
        $no++;
        ?>
        <tr>
            <td><?php echo $no ?></td>
            <td><?php echo $pk['nama_lsm'] ?></td>
            <td><?php echo $pk['nama_kebun'] ?></td>
            <td><?php echo $pk['lokasi'] ?></td>
            <td><?php echo $pk['kondisi_10thn_terakhir'] ?></td>
            <td><?php echo $pk['kondisi_saat_ini'] ?></td>
            <td><?php echo $pk['tanggal'] ?></td>
            <td>
            <?php 
              if ($pk['status'] == '0') {
                  ?>
                <?php echo anchor('c_gap_sosial_lingkungan/form_detail_pengelolaan_kebun/'.$pk['id_sos_lik'], '<button type="button" class="btn  btn-warning btn-sm mb-2" title="Detail"><i class="fas fa-exclamation-circle" style="color:white;"></i></button>') ?>
                <?php echo anchor('c_gap_sosial_lingkungan/edit_pengelolaan_kebun/'.$pk['id_sos_lik'], '<button type="button" class="btn  btn-primary btn-sm mb-2" title="Edit"><i class="far fa-edit"></i></button>') ?>
                <button type="button" class="btn  btn-danger btn-sm mb-2" data-toggle="modal" data-target="#modalhapus" title="Non Aktif" name="<?= $pk['id_sos_lik'];?>" onClick="reply_click1(this.name)"><i class="far fa-times-circle"></i></button>

                <?php }elseif ($pk['status'] == '1') {?>
                  <button type="button" class="btn  btn-success btn-sm mb-2" data-toggle="modal" data-target="#modalaktif" title="Aktif" name="<?= $pk['id_sos_lik'];?>" onClick="reply_click(this.name)"><i class="far fa-times-circle"></i></button>

                <?php } ?>
            </td>
        </tr>
        <?php endforeach; ?><?php
      
                          
  }
  public function form_detail_sosial_lingkungan($id)
  {

    $detail_sosial_lingkungan = $this->db->query("SELECT *,gap_master_lsm.nama_lsm AS namaLSM  FROM gap_sosial_lingkungan
    LEFT JOIN gap_master_lsm ON gap_sosial_lingkungan.nama_lsm = gap_master_lsm.id_lsm 
    WHERE  gap_sosial_lingkungan.id_sos_lik = '$id'");
    $data['sosial_lingkungan'] = $detail_sosial_lingkungan->result_array();
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_sos_ling 
    WHERE gap_histori_sos_ling.id_sos_lik = '$id' ORDER BY id_histori_sos_ling DESC");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar');
      $this->load->view('detail-gap_sosial_lingkungan',$data);
      $this->load->view('templates/footer');
  }
  public function tambah_detail_sosial_lingkungan()
  {
    $histori_kondisi_saat_ini = $this->input->post('histori_kondisi_saat_ini');
    $tanggal_update = $this->input->post('tanggal_update');
    $cnvrt_tanggal_update = date('Y-m-d', strtotime($tanggal_update));
    $id_sos_lik = $this->input->post('id_sos_lik');
    $histori_upload_dokumen = $_FILES['histori_upload_dokumen']['name'];
    $jumlah = count($histori_upload_dokumen);
      for ($i=0; $i < $jumlah; $i++) { 
        $gantinama[] = date('His').$histori_upload_dokumen[$i];
      }
      $cvt_histori_upload_dokumen = implode(",", $gantinama);
      $date = new DateTime();
      $format_file = array("jpg", "png", "pdf","xls");
      $path = "uploads/"; // Lokasi folder untuk menampung file
      $count = 0;
      if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
        // Loop $_FILES to exeicute all files
        foreach ($_FILES['histori_upload_dokumen']['name'] as $f => $name) {     
            if ($_FILES['histori_upload_dokumen']['error'][$f] == 4) {
                continue; // Skip file if any error found
            }	       
            if ($_FILES['histori_upload_dokumen']['error'][$f] == 0) {	           
                      $destinationFileName = date('His').$name;
                    if(move_uploaded_file($_FILES["histori_upload_dokumen"]["tmp_name"][$f], $path.$destinationFileName))
                    $count++; // Number of successfully uploaded file
            }
            
        }
      }
    $data = array(
        'histori_kondisi_saat_ini' => $histori_kondisi_saat_ini,
        'tanggal_update' => $cnvrt_tanggal_update,
        'id_sos_lik' => $id_sos_lik,
        'histori_upload_dokumen' => $cvt_histori_upload_dokumen
    );
    $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'gap_histori_sos_ling');
        $this->session->set_flashdata('something', 'Pesan Terkirim');
        redirect('c_gap_sosial_lingkungan/form_detail_sosial_lingkungan/'.$id_sos_lik);
  }
  public function update_detail_sosial_lingkungan()
  {
    $histori_kondisi_saat_ini = $this->input->post('histori_kondisi_saat_ini');
    $tanggal_update = $this->input->post('tanggal_update');
    $cnvrt_tanggal_update = date('Y-m-d', strtotime($tanggal_update));
    $id_histori_sos_ling = $this->input->post('id_histori_sos_ling');
    $id_sos_lik = $this->input->post('id_sos_lik');
    $histori_upload_dokumen = $_FILES['histori_upload_dokumen']['name'];
    $upload_dokument = $this->input->post('upload_dokument');
    if ($histori_upload_dokumen[0] == null) {
        $data = array(
          'histori_kondisi_saat_ini' => $histori_kondisi_saat_ini,
          'tanggal_update' => $cnvrt_tanggal_update,
          'histori_upload_dokumen' => $upload_dokument
        );
        $where = array('id_histori_sos_ling' => $id_histori_sos_ling);
        $this->model_dokumen->update_dokumen($where,$data,'gap_histori_sos_ling');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');
        redirect('c_gap_sosial_lingkungan/form_detail_sosial_lingkungan/'.$id_sos_lik);
    }else {
      $jumlah = count($histori_upload_dokumen);
      for ($i=0; $i < $jumlah; $i++) { 
        $gantinama[] = date('His').$histori_upload_dokumen[$i];
      }
      $cvt_histori_upload_dokumen = implode(",", $gantinama);
      $date = new DateTime();
      $format_file = array("jpg", "png", "pdf","xls");
      $path = "uploads/"; // Lokasi folder untuk menampung file
      $count = 0;
      if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
        // Loop $_FILES to exeicute all files
        foreach ($_FILES['histori_upload_dokumen']['name'] as $f => $name) {     
            if ($_FILES['histori_upload_dokumen']['error'][$f] == 4) {
                continue; // Skip file if any error found
            }	       
            if ($_FILES['histori_upload_dokumen']['error'][$f] == 0) {	           
                      $destinationFileName = date('His').$name;
                    if(move_uploaded_file($_FILES["histori_upload_dokumen"]["tmp_name"][$f], $path.$destinationFileName))
                    $count++; // Number of successfully uploaded file
            }
            
        }
      }
        $data = array(
          'histori_kondisi_saat_ini' => $histori_kondisi_saat_ini,
          'tanggal_update' => $cnvrt_tanggal_update,
          'histori_upload_dokumen' => $cvt_histori_upload_dokumen
        );
        $where = array('id_histori_sos_ling' => $id_histori_sos_ling);
        $this->model_dokumen->update_dokumen($where,$data,'gap_histori_sos_ling');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');
        redirect('c_gap_sosial_lingkungan/form_detail_sosial_lingkungan/'.$id_sos_lik);
      }
    
  }
}