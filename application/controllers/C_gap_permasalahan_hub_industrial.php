<?php
class C_gap_permasalahan_hub_industrial extends CI_Controller{
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
      if ($username == 'admin') {
        $query_prmslhan_hub_industrial= $this->db->query("SELECT *,tb_master_bagian.id_bagian FROM gap_prmslhan_hub_industrial 
          LEFT JOIN tb_master_bagian ON gap_prmslhan_hub_industrial.id_kebun = tb_master_bagian.id_bagian
          WHERE gap_prmslhan_hub_industrial.status='0' 
          ORDER BY id_permasalahan DESC");
          
      }else{
        $query_prmslhan_hub_industrial= $this->db->query("SELECT *,tb_master_bagian.id_bagian FROM gap_prmslhan_hub_industrial 
          LEFT JOIN tb_master_bagian ON gap_prmslhan_hub_industrial.id_kebun = tb_master_bagian.id_bagian
          WHERE gap_prmslhan_hub_industrial.status='0' AND gap_prmslhan_hub_industrial.id_kebun='$id'
          ORDER BY id_permasalahan DESC");
      }
      $data['user'] = $this->model_dokumen->tampil_data_user()->result_array();
      $data['prmslhan_hub_industrial'] = $query_prmslhan_hub_industrial->result_array();
      
      // print_r($data['prmslhan_hub_industrial']);
      // die();
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar');
      $this->load->view('gap_permasalahan_hub_industrial',$data);
      $this->load->view('templates/footer');
    
  }
  public function form_permasalahan_hub_industrial()
  { 
    $query_kebun= $this->db->query("SELECT * FROM tb_user ");
    $data['kebun'] = $this->model_dokumen->tampil_data_kebun()->result();
    $this->load->view('tambah-gap_permasalahan_hub_industrial',$data);
  }

  public function tambah_permasalahan_hub_industrial()
  {
    $subjek = $this->input->post('subjek');
    $id_kebun = $this->input->post('id_kebun');
    $waktu = $this->input->post('waktu');
    $cnvrt_waktu = date('Y-m-d', strtotime($waktu));
    $lokasi = $this->input->post('lokasi');
    $kerugian = $this->input->post('kerugian');
    $kondisi_saat_ini = $this->input->post('kondisi_saat_ini');
    $upaya_penyelesaian = $this->input->post('upaya_penyelesaian');
    $keterangan = $this->input->post('keterangan');
    // print_r($id_kebun);
    // die();
    $data = array(
      'subjek' => $subjek,
      'waktu' => $cnvrt_waktu,
      'id_kebun' => $id_kebun,
      'lokasi' => $lokasi,
      'kerugian' => $kerugian,
      'kondisi_saat_ini' => $kondisi_saat_ini,
      'upaya_penyelesaian' => $upaya_penyelesaian,
      'keterangan' => $keterangan
    );
    $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'gap_prmslhan_hub_industrial');
    $this->session->set_flashdata('something', 'Pesan Terkirim');

    redirect('c_gap_permasalahan_hub_industrial/index');
  }
  public function edit_permasalahan_hub_industrial($id)
  {
    $where = array('id_permasalahan' =>$id);
    $data['permasalahan_hub_industrial'] = $this->model_jenis_dokumen->edit_jenis_dokumen($where,'gap_prmslhan_hub_industrial')->result();
    $query_kebun= $this->db->query("SELECT * FROM tb_user ");
    $data['kebun'] = $query_kebun->result_array();
    $this->load->view('edit-gap_permasalahan_hub_industrial',$data);
  }
  public function update_permasalahan_hub_industrial()
  {
    $id = $this->input->post('id');
    $subjek = $this->input->post('subjek');
    $id_kebun = $this->input->post('id_kebun');
    $waktu = $this->input->post('waktu');
    $cnvrt_waktu = date('Y-m-d', strtotime($waktu));
    $lokasi = $this->input->post('lokasi');
    $kerugian = $this->input->post('kerugian');
    $kondisi_saat_ini = $this->input->post('kondisi_saat_ini');
    $upaya_penyelesaian = $this->input->post('upaya_penyelesaian');
    $keterangan = $this->input->post('keterangan');
    
        $data = array(
            'subjek' => $subjek,
            'waktu' => $cnvrt_waktu,
            'lokasi' => $lokasi,
            'id_kebun' => $id_kebun,
            'kerugian' => $kerugian,
            'kondisi_saat_ini' => $kondisi_saat_ini,
            'upaya_penyelesaian' => $upaya_penyelesaian,
            'keterangan' => $keterangan
        );
        $where = array('id_permasalahan' => $id);
        $this->model_dokumen->update_dokumen($where,$data,'gap_prmslhan_hub_industrial');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');

        redirect('c_gap_permasalahan_hub_industrial/index');
      
    
  }
  public function nonaktif()
	{
    $id_delete = $this->input->post('id_delete');

        $status       = '1';

        $data = array(
            'status' => $status
        );
        $where = array('id_permasalahan' => $id_delete);
        $this->model_dokumen->update_dokumen($where,$data,'gap_prmslhan_hub_industrial');
        $this->session->set_flashdata('something2', 'Pesan Terkirim');
        redirect('c_gap_permasalahan_hub_industrial/index');
  }
  public function aktif()
	{
    $id_delete = $this->input->post('id_delete');

        $status       = '0';

        $data = array(
            'status' => $status
        );
        $where = array('id_permasalahan' => $id_delete);
        $this->model_dokumen->update_dokumen($where,$data,'gap_prmslhan_hub_industrial');
        $this->session->set_flashdata('something3', 'Pesan Terkirim');

        redirect('c_gap_permasalahan_hub_industrial/index');
  }
    
  public function load_status_surat()
  {
      $status_surat = $_GET['status_surat'];
      $idkebun = $this->session->userdata('bagian');
      $username = $this->session->userdata('username');
          
      if ($status_surat == 'aktif' && $username == 'admin') {
          $query_permasalahan= $this->db->query("SELECT * FROM tb_master_bagian 
            LEFT JOIN gap_prmslhan_hub_industrial ON gap_prmslhan_hub_industrial.id_kebun = tb_master_bagian.id_bagian
            WHERE gap_prmslhan_hub_industrial.status='0'
            ORDER BY id_permasalahan DESC");
          $query_kebun = $this->db->query("SELECT nama_bagian FROM tb_master_bagian WHERE id_bagian = '$idkebun'");
          $data['kebun'] = $query_kebun->result_array();
          $data['permasalahan'] = $query_permasalahan->result_array();
          
      }elseif ($status_surat == 'aktif' && $username != 'admin') {
          $query_permasalahan= $this->db->query("SELECT * FROM gap_prmslhan_hub_industrial WHERE status='0' AND id_kebun='$idkebun'  ORDER BY id_permasalahan DESC");
          $query_kebun = $this->db->query("SELECT nama_bagian FROM tb_master_bagian WHERE id_bagian = '$idkebun'");
          $data['kebun'] = $query_kebun->result_array();
          $data['permasalahan'] = $query_permasalahan->result_array();
          
      }elseif ($status_surat == 'nonaktif' && $username == 'admin') {
          // $query_permasalahan= $this->db->query("SELECT * FROM gap_prmslhan_hub_industrial 
          // WHERE status='1' 
          // ORDER BY id_permasalahan DESC ");
          $query_permasalahan= $this->db->query("SELECT * FROM tb_master_bagian 
            LEFT JOIN gap_prmslhan_hub_industrial ON gap_prmslhan_hub_industrial.id_kebun = tb_master_bagian.id_bagian
            WHERE gap_prmslhan_hub_industrial.status='1'
            ORDER BY id_permasalahan DESC");
          $query_kebun = $this->db->query("SELECT nama_bagian FROM tb_master_bagian WHERE id_bagian = '$idkebun'");
          $data['kebun'] = $query_kebun->result_array();
          $data['permasalahan'] = $query_permasalahan->result_array();
          // print_r($data['permasalahan']);
          // die();
          
      }elseif ($status_surat == 'nonaktif' && $username != 'admin') {
        $query_permasalahan= $this->db->query("SELECT * FROM gap_prmslhan_hub_industrial WHERE status='1' AND id_kebun='$idkebun' ORDER BY id_permasalahan DESC ");
        $query_kebun = $this->db->query("SELECT nama_bagian FROM tb_master_bagian WHERE id_bagian = '$idkebun'");
        $data['kebun'] = $query_kebun->result_array();
        $data['permasalahan'] = $query_permasalahan->result_array();
        
      }   
      $no=0;
      foreach ( $data['permasalahan'] as $li) :
      $no++;
    ?>
    <tr>
        <td><?php echo $no ?></td>
        <td><?php echo $li['subjek'] ?></td>
        <td><?php 
            foreach ($data['kebun'] as $pt) :
              echo $pt['nama_bagian'];
            endforeach;
            ?>
        </td>
        <td><?php $cnvrt_waktu = date('d-m-Y', strtotime($li['waktu'])); echo $cnvrt_waktu  ?></td>
        <td><?php echo $li['lokasi'] ?></td>
        <td><?php echo $li['kondisi_saat_ini'] ?></td>
        <td><?php if ($li['status'] == '2') {
            echo 'Close';
        }else {
            echo 'Proses ';
        }  ?></td>
      <td>
        <?php 
        if ($li['status'] == '0') {
        ?>
        <?php echo anchor('c_gap_permasalahan_hub_industrial/form_detail_permasalahan_hub_industrial/'.$li['id_permasalahan'], '<button type="button" class="btn  btn-warning btn-sm" title="Detail"><i class="fas fa-exclamation-circle" style="color:white;"></i></button>') ?>
        <?php echo anchor('c_gap_permasalahan_hub_industrial/edit_permasalahan_hub_industrial/'.$li['id_permasalahan'], '<button type="button" class="btn  btn-primary btn-sm" title="Edit"><i class="far fa-edit"></i></button>') ?>
        <button type="button" class="btn  btn-danger btn-sm " data-toggle="modal" data-target="#modalhapus" title="Non Aktif" name="<?= $li['id_permasalahan'];?>" onClick="reply_click1(this.name)"><i class="far fa-times-circle"></i></button>
        <?php }elseif ($li['status'] == '1') {?>
          <button type="button" class="btn  btn-success btn-sm " data-toggle="modal" data-target="#modalaktif" title="Aktif" name="<?= $li['id_permasalahan'];?>" onClick="reply_click(this.name)"><i class="far fa-times-circle"></i></button>
        <?php } ?>
      </td>
    </tr>
    <?php endforeach; ?><?php

                          
  }
  public function form_detail_permasalahan_hub_industrial($id_permasalahan)
  {
    $id = $this->session->userdata('id');

    $detail_permasalahan = $this->db->query("SELECT * FROM gap_prmslhan_hub_industrial 
    WHERE id_permasalahan = '$id_permasalahan'");
    $data['permasalahan'] = $detail_permasalahan->result_array();
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_prmslhan_hub_industrial 
    WHERE id_permasalahan = '$id_permasalahan' AND  tab = '1' ORDER BY id_histori_permasalahan DESC");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar');
      $this->load->view('detail-gap_permasalahan_hub_industrial',$data);
      $this->load->view('templates/footer');
  }
  public function tambah_detail_permasalahan_hub_industrial()
  {
    $histori_kondisi_saat_ini = $this->input->post('histori_kondisi_saat_ini');
    $tanggal_update = $this->input->post('tanggal_update');
    $cnvrt_tanggal_update = date('Y-m-d', strtotime($tanggal_update));
    $id_permasalahan = $this->input->post('id_permasalahan');
    $tab = $this->input->post('tab');
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
        'tab' => $tab,
        'histori_kondisi_saat_ini' => $histori_kondisi_saat_ini,
        'tanggal_update' => $cnvrt_tanggal_update,
        'id_permasalahan' => $id_permasalahan,
        'histori_upload_dokumen' => $cvt_histori_upload_dokumen
    );
    $data1 = array(
      'kondisi_saat_ini' => $histori_kondisi_saat_ini
  );
    $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'gap_histori_prmslhan_hub_industrial');
    $where = array('id_permasalahan' => $id_permasalahan);
    $this->model_dokumen->update_dokumen($where,$data1,'gap_prmslhan_hub_industrial');
    $this->session->set_flashdata('something', 'Pesan Terkirim');
    redirect('c_gap_permasalahan_hub_industrial/form_detail_permasalahan_hub_industrial/'.$id_permasalahan);
  }
  public function closing()
  {
    $histori_kondisi_saat_ini = $this->input->post('histori_kondisi_saat_ini');
    $tanggal_update = $this->input->post('tanggal_update');
    $cnvrt_tanggal_update = date('Y-m-d', strtotime($tanggal_update));
    $id_permasalahan = $this->input->post('id_permasalahan');
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
        'id_permasalahan' => $id_permasalahan,
        'histori_upload_dokumen' => $cvt_histori_upload_dokumen
    );
    $data1 = array(
      'kondisi_saat_ini' => $histori_kondisi_saat_ini,
      'status' => '2'
  );
    $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'gap_histori_prmslhan_hub_industrial');
    $where = array('id_permasalahan' => $id_permasalahan);
    $this->model_dokumen->update_dokumen($where,$data1,'gap_prmslhan_hub_industrial');
        $this->session->set_flashdata('something2', 'Pesan Terkirim');
        redirect('c_gap_permasalahan_hub_industrial/form_detail_permasalahan_hub_industrial/'.$id_permasalahan);
  }
  public function load_tabbutton()
  {
      $valuebutton = $_GET['valuebutton'];
      $id_permasalahan = $_GET['id_permasalahan'];
      if ($valuebutton == '1') {
          $query_histori_permasalahan= $this->db->query("SELECT * FROM gap_histori_prmslhan_hub_industrial WHERE id_permasalahan = '$id_permasalahan' AND tab='1'");
          $data['histori_permasalahan'] = $query_histori_permasalahan->result_array();
          
      }elseif ($valuebutton == '2') {
          $query_histori_permasalahan= $this->db->query("SELECT * FROM gap_histori_prmslhan_hub_industrial WHERE id_permasalahan = '$id_permasalahan' AND tab='2'");
          $data['histori_permasalahan'] = $query_histori_permasalahan->result_array();
          
      }
        $no=0;
        foreach ( $data['histori_permasalahan'] as $ksi) :
        $no++;
      ?>
      <tr>
          <td><?php echo $no ?></td>
          <td><?php echo $ksi['histori_kondisi_saat_ini'] ?></td>
          <td><?php echo $ksi['tanggal_update'] ?></td>
          <td><?php echo $ksi['histori_upload_dokumen'] ?></td>
          <td><a href="<?php echo base_url()?>c_gap_permasalahan_hub_industrial/form_edit_detail_permasalahan_hub_industrial/<?php echo $ksi['id_histori_permasalahan'] ?>"><button type="button" class="btn  btn-primary btn-sm"  title="Edit"><i class="far fa-edit"></i></button></a></td>
          
      </tr>
      <?php endforeach; ?>
      <?php
      
                          
  }
  public function form_edit_detail_permasalahan_hub_industrial($id)
  {
    $where = array('id_histori_permasalahan' =>$id);
    $data['permasalahan_hub_industrial'] = $this->model_jenis_dokumen->edit_jenis_dokumen($where,'gap_histori_prmslhan_hub_industrial')->result();
    
    $this->load->view('edit-histori-gap_permasalahan_hub_industrial',$data);
  }
  public function update_detail_permasalahan_hub_industrial()
  {
    $histori_kondisi_saat_ini = $this->input->post('histori_kondisi_saat_ini');
    $tanggal_update = $this->input->post('tanggal_update');
    $cnvrt_tanggal_update = date('Y-m-d', strtotime($tanggal_update));
    $id_histori_permasalahan = $this->input->post('id_histori_permasalahan');
    $id_permasalahan = $this->input->post('id_permasalahan');
    $histori_upload_dokumen = $_FILES['histori_upload_dokumen']['name'];
    $cvt_histori_upload_dokumen = implode(",", $histori_upload_dokumen);
    $upload_dokument = $this->input->post('upload_dokument');
    if ($histori_upload_dokumen[0] == null) {
        $data = array(
          'histori_kondisi_saat_ini' => $histori_kondisi_saat_ini,
          'tanggal_update' => $cnvrt_tanggal_update,
          'histori_upload_dokumen' => $upload_dokument
        );
        $where = array('id_histori_permasalahan' => $id_histori_permasalahan);
        $this->model_dokumen->update_dokumen($where,$data,'gap_histori_prmslhan_hub_industrial');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');
        redirect('c_gap_permasalahan_hub_industrial/form_detail_permasalahan_hub_industrial/'.$id_permasalahan);
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
        $where = array('id_histori_permasalahan' => $id_histori_permasalahan);
        $this->model_dokumen->update_dokumen($where,$data,'gap_histori_prmslhan_hub_industrial');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');
        redirect('c_gap_permasalahan_hub_industrial/form_detail_permasalahan_hub_industrial/'.$id_permasalahan);
      }
    
  }
}