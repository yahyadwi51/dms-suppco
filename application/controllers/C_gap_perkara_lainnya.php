<?php
class c_gap_perkara_lainnya extends CI_Controller{
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
    // Menu Perkara Lainnya masih menunggu waktu untuk launcing 
    // Ubah kondisi dibawah menjadi 0 jika menu perkara dan perkara lainnya sudah tahap launching
    $text = "Perkara Lainnya";
    $this->session->set_userdata('maintenance', $text);  
    $maintenance = 1;

    if($maintenance == 0){
      $id = $this->session->userdata('bagian');
      $username = $this->session->userdata('username');
      if ($username == 'admin' || $username == 'sekper') {
        $query_perkara= $this->db->query("SELECT *, tb_master_bagian.id_bagian FROM gap_perkara_lainnya
          LEFT JOIN tb_master_bagian ON gap_perkara_lainnya.id_kebun = tb_master_bagian.id_bagian
          WHERE gap_perkara_lainnya.status = '0' ORDER BY id_perkara_lainnya DESC");
      }else{
        $query_perkara= $this->db->query("SELECT *, tb_master_bagian.id_bagian FROM gap_perkara_lainnya
          LEFT JOIN tb_master_bagian ON gap_perkara_lainnya.id_kebun = tb_master_bagian.id_bagian
          WHERE gap_perkara_lainnya.status = '0' AND gap_perkara_lainnya.id_kebun = '$id' ORDER BY id_perkara_lainnya DESC");
        $select = $this->db->select('nama_bagian');
        $nama_kebun = $select->get("tb_master_bagian WHERE id_bagian = '$id' ");
        $data['namakebun'] = $nama_kebun->result_array();
      }
      $data['user'] = $this->model_dokumen->tampil_data_user()->result_array();
      $data['perkara'] = $query_perkara->result_array();
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar');
      $this->load->view('gap_perkara_lainnya',$data);
      $this->load->view('templates/footer');
    }
    else{
      $data['maintenance'] = $this->session->userdata('maintenance');
      $this->load->view('templates/header');
      $this->load->view('templates/sidebar');
      $this->load->view('maintenance', $data);
      $this->load->view('templates/footer');
    }

  }

  public function form_perkara()
  {
    $id_bagian = $this->session->userdata('bagian');
    $query_kebun= $this->db->query("SELECT * FROM tb_user ");
    $data['kebun'] = $this->model_dokumen->tampil_data_kebun()->result();
    $this->load->view('tambah-gap_perkara_lainnya',$data);
  }

  public function tambah_perkara()
  {
    $id_kebun = $this->input->post('id_kebun');
    $subjek = $this->input->post('subjek');
    $waktu = $this->input->post('waktu');
    $cnvrt_waktu = date('Y-m-d', strtotime($waktu));
    $lokasi = $this->input->post('lokasi');
    $kondisi_saat_ini = $this->input->post('kondisi_saat_ini');
    $upaya = $this->input->post('upaya');
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
      'subjek' => $subjek,
      'id_kebun' => $id_kebun,
      'waktu' => $cnvrt_waktu,
      'lokasi' => $lokasi,
      'upaya' => $upaya,
      'kondisi_saat_ini' => $kondisi_saat_ini,
      'keterangan' => $keterangan
    );
    $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'gap_perkara_lainnya');
    $this->session->set_flashdata('something', 'Pesan Terkirim');
    redirect('c_gap_perkara_lainnya/index');
  }

  public function edit_perkara($id)
  {
    $id_bagian = $this->session->userdata('bagian');
    $where = array('id_perkara_lainnya' =>$id);
    $data['perkara'] = $this->model_jenis_dokumen->edit_jenis_dokumen($where,'gap_perkara_lainnya')->result();
    
    $query_kebun= $this->db->query("SELECT tb_master_bagian.nama_bagian, gap_perkara_lainnya.id_kebun FROM tb_master_bagian 
      LEFT JOIN gap_perkara_lainnya ON tb_master_bagian.id_bagian = gap_perkara_lainnya.id_kebun
      WHERE gap_perkara_lainnya.id_perkara_lainnya = '$id' ");
    $data['kebun'] = $query_kebun->result();

    $data['pilihkebun'] = $this->model_dokumen->tampil_data_kebun()->result();
    $this->load->view('edit-gap_perkara_lainnya',$data);
  }

  public function update_perkara()
  {
    $id = $this->input->post('id');
    $id_kebun = $this->input->post('id_kebun');
    $subjek = $this->input->post('subjek');
    $waktu = $this->input->post('waktu');
    $cnvrt_waktu = date('Y-m-d', strtotime($waktu));
    $lokasi = $this->input->post('lokasi');
    $kondisi_saat_ini = $this->input->post('kondisi_saat_ini');
    $upaya = $this->input->post('upaya');
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
        'subjek' => $subjek,
        'waktu' => $cnvrt_waktu,
        'id_kebun' => $id_kebun,
        'lokasi' => $lokasi,
        'upaya' => $upaya,
        'kondisi_saat_ini' => $kondisi_saat_ini,
        'keterangan' => $keterangan
    );
        $where = array('id_perkara_lainnya' => $id);
        $this->model_dokumen->update_dokumen($where,$data,'gap_perkara_lainnya');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');
        redirect('c_gap_perkara_lainnya/index');
  }

  public function nonaktif()
	{
        $status       = '1';
        $id_delete = $this->input->post('id_delete');

        $data = array(
            'status' => $status
        );
        $where = array('id_perkara_lainnya' => $id_delete);
        $this->model_dokumen->update_dokumen($where,$data,'gap_perkara_lainnya');
        $this->session->set_flashdata('something2', 'Pesan Terkirim');
        redirect('c_gap_perkara_lainnya/index');
  }

  public function aktif()
	{
    $id_delete = $this->input->post('id_delete');
    $status       = '0';

        $data = array(
            'status' => $status
        );
        $where = array('id_perkara_lainnya' => $id_delete);
        $this->model_dokumen->update_dokumen($where,$data,'gap_perkara_lainnya');
        $this->session->set_flashdata('something3', 'Pesan Terkirim');
        redirect('c_gap_perkara_lainnya/index');
  }
    
  public function load_status_surat()
  {
      $status_surat = $_GET['status_surat'];
      $idkebun = $this->session->userdata('bagian');
      $username = $this->session->userdata('username');
          
      if ($status_surat == 'aktif' && $username == 'admin') {
          $query_perkara= $this->db->query("SELECT * FROM gap_perkara_lainnya WHERE status='0'  ");
          $data['perkara'] = $query_perkara->result_array();
          
      }elseif ($status_surat == 'aktif' && $username != 'admin') {
          $query_perkara= $this->db->query("SELECT * FROM gap_perkara_lainnya WHERE status='0' AND id_kebun='$idkebun'");
          $data['perkara'] = $query_perkara->result_array();
          
      }elseif ($status_surat == 'nonaktif' && $username == 'admin') {
          $query_perkara= $this->db->query("SELECT * FROM gap_perkara_lainnya WHERE status='1' ");
          $data['perkara'] = $query_perkara->result_array();
          
      }elseif ($status_surat == 'nonaktif' && $username != 'admin') {
        $query_perkara= $this->db->query("SELECT * FROM gap_perkara_lainnya WHERE status='1' AND id_kebun='$idkebun'");
        $data['perkara'] = $query_perkara->result_array();
        
      }
        $no=0;
        foreach ($data['perkara'] as $pk) :
        $no++;
        ?>
        <tr>
             <td><?php echo $no ?></td>
            <td><?php echo $pk['nama_kebun'] ?></td>
            <td><?php echo $pk['subjek'] ?></td>
            <td><?php echo $pk['waktu'] ?></td>
            <td><?php echo $pk['lokasi'] ?></td>
            <td><?php echo $pk['kondisi_saat_ini'] ?></td>
            <td><?php echo $pk['upaya'] ?></td>
            <td><?php echo $pk['keterangan'] ?></td>
        <td>
            <?php 
              if ($pk['status'] == '0') {
                  ?>
                <?php echo anchor('c_gap_perkara_lainnya/form_detail_perkara/'.$pk['id_perkara_lainnya'], '<button type="button" class="btn  btn-warning btn-sm mb-2" title="Detail"><i class="fas fa-exclamation-circle" style="color:white;"></i></button>') ?>
                <?php echo anchor('c_gap_perkara_lainnya/edit_perkara/'.$pk['id_perkara_lainnya'], '<button type="button" class="btn  btn-primary btn-sm mb-2" title="Edit"><i class="far fa-edit"></i></button>') ?>
                <button type="button" class="btn  btn-danger btn-sm mb-2" data-toggle="modal" data-target="#modalhapus" title="Non Aktif" name="<?= $pk['id_perkara_lainnya'];?>" onClick="reply_click1(this.name)"><i class="far fa-times-circle"></i></button>
                <?php }elseif ($pk['status'] == '1') {?>
                  <button type="button" class="btn  btn-success btn-sm " data-toggle="modal" data-target="#modalaktif" title="Aktif" name="<?= $pk['id_perkara_lainnya'];?>" onClick="reply_click(this.name)"><i class="far fa-times-circle"></i></button>
                <?php } ?>
            </td>
        </tr>
        <?php endforeach; ?><?php                          
  }
  
  public function form_detail_perkara($id)
  {
    $detail_perkara = $this->db->query("SELECT * FROM gap_perkara_lainnya
    WHERE  gap_perkara_lainnya.id_perkara_lainnya = '$id'");
    $data['perkara'] = $detail_perkara->result_array();
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_perkara_lainnya 
    WHERE gap_histori_perkara_lainnya.id_perkara_lainnya = '$id' ORDER BY id_histori_perkara_lainnya DESC");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar');
      $this->load->view('detail-gap_perkara_lainnya',$data);
      $this->load->view('templates/footer');
  }

  public function tambah_detail_perkara()
  {
    $histori_kondisi_saat_ini = $this->input->post('histori_kondisi_saat_ini');
    $tanggal_update = $this->input->post('tanggal_update');
    $cnvrt_tanggal_update = date('Y-m-d', strtotime($tanggal_update));
    $id_perkara_lainnya = $this->input->post('id_perkara_lainnya');
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
        'id_perkara_lainnya' => $id_perkara_lainnya,
        'histori_upload_dokumen' => $cvt_histori_upload_dokumen
    );
    $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'gap_histori_perkara_lainnya');
        $this->session->set_flashdata('something', 'Pesan Terkirim');
        redirect('c_gap_perkara_lainnya/form_detail_perkara/'.$id_perkara_lainnya);
  }

  public function update_detail_perkara()
  {
    $histori_kondisi_saat_ini = $this->input->post('histori_kondisi_saat_ini');
    $tanggal_update = $this->input->post('tanggal_update');
    $cnvrt_tanggal_update = date('Y-m-d', strtotime($tanggal_update));
    $id_histori_perkara_lainnya = $this->input->post('id_histori_perkara_lainnya');
    $id_perkara_lainnya = $this->input->post('id_perkara_lainnya');
    $histori_upload_dokumen = $_FILES['histori_upload_dokumen']['name'];
    $cvt_histori_upload_dokumen = implode(",", $histori_upload_dokumen);
    $upload_dokument = $this->input->post('upload_dokument');
    if ($histori_upload_dokumen[0] == null) {
        $data = array(
          'histori_kondisi_saat_ini' => $histori_kondisi_saat_ini,
          'tanggal_update' => $cnvrt_tanggal_update,
          'histori_upload_dokumen' => $upload_dokument
        );
        $where = array('id_histori_perkara_lainnya' => $id_histori_perkara_lainnya);
        $this->model_dokumen->update_dokumen($where,$data,'gap_histori_perkara_lainnya');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');
        redirect('c_gap_perkara_lainnya/form_detail_perkara/'.$id_perkara_lainnya);
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
        $where = array('id_histori_perkara_lainnya' => $id_histori_perkara_lainnya);
        $this->model_dokumen->update_dokumen($where,$data,'gap_histori_perkara_lainnya');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');
        redirect('c_gap_perkara_lainnya/form_detail_perkara/'.$id_perkara_lainnya);
      }
    
  }
}