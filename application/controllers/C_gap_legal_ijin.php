<?php
class C_gap_legal_ijin extends CI_Controller{
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
      $username = $this->session->userdata('username');
      if ($username == 'admin') {
        $query_legal_ijin= $this->db->query("SELECT *, tb_master_bagian.id_bagian FROM gap_legal_ijin
          LEFT JOIN tb_master_bagian ON gap_legal_ijin.id_kebun = tb_master_bagian.id_bagian
          WHERE gap_legal_ijin.status = '0' ORDER BY id_legal_ijin DESC");
      }else{
        $query_legal_ijin= $this->db->query("SELECT *, tb_master_bagian.id_bagian FROM gap_legal_ijin
          LEFT JOIN tb_master_bagian ON gap_legal_ijin.id_kebun = tb_master_bagian.id_bagian
          WHERE gap_legal_ijin.status = '0' ORDER BY id_legal_ijin DESC");
      }
      $data['user'] = $this->model_dokumen->tampil_data_user()->result_array();
      $data['legal_ijin'] = $query_legal_ijin->result_array();
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar');
      $this->load->view('gap_legalitas_dan_perijinan',$data);
      $this->load->view('templates/footer');
    
  }
  public function form_legal_ijin()
  { 
    $id_bagian = $this->session->userdata('bagian');
    $query_jenis_kepatuhan= $this->db->query("SELECT * FROM gap_jenis_kepatuhan ");
    $data['kebun'] = $this->model_dokumen->tampil_data_kebun()->result();
    $data['jenis_kepatuhan'] = $query_jenis_kepatuhan->result_array();
    $this->load->view('tambah-gap_legalitas_dan_perijinan',$data);
  }

  public function tambah_legal_ijin()
  {
    $no_ktun = $this->input->post('no_ktun');
    $id_kebun = $this->input->post('id_kebun');

    $select = $this->db->select('nama_bagian');
    $nama_kebun = $select->get("tb_master_bagian WHERE id_bagian = '$id_kebun' ");
    $data = $nama_kebun->result_array();
    foreach ($data as $nk) : {
      $nama_kebun = $nk['nama_bagian'];
    }
    endforeach;

    $kabupaten = $this->input->post('kabupaten');
    $tanggal_terbit = $this->input->post('tanggal_terbit');
    $tanggal_berakhir = $this->input->post('tanggal_berakhir');
    $kondisi_saat_ini = $this->input->post('kondisi_saat_ini');
    $cnvrt_tanggal_terbit = date('Y-m-d', strtotime($tanggal_terbit));
    $cnvrt_tanggal_berakhir = date('Y-m-d', strtotime($tanggal_berakhir));
    $keterangan = $this->input->post('keterangan');
    $jenis_kepatuhan = $this->input->post('jenis_kepatuhan');

    $upload_dokumen = $_FILES['upload_dokumen']['name'];
      if($upload_dokumen =''){
        
      }else{
        $config['upload_path'] = './uploads';
        $config['allowed_types'] = '*';
  
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('upload_dokumen')) {
          echo "Gambar Gagal Upload !";
        }else {
          $upload_dokumen=$this->upload->data('file_name');
        }
      }
    $data = array(
      'no_ktun' => $no_ktun,
      'id_kebun' => $id_kebun,
      'nama_kebun' => $nama_kebun,
      'kabupaten' => $kabupaten,
      'tanggal_terbit' => $cnvrt_tanggal_terbit,
      'tanggal_berakhir' => $cnvrt_tanggal_berakhir,
      'kondisi_saat_ini' => $kondisi_saat_ini,
      'keterangan' => $keterangan,
      'jenis_kepatuhan' => $jenis_kepatuhan,
      'upload_dokumen' => $upload_dokumen
    );
    $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'gap_legal_ijin');
    $this->session->set_flashdata('something', 'Pesan Terkirim');
    redirect('c_gap_legal_ijin/index');
  }

  public function edit_legal_ijin($id)
  {
    $id_bagian = $this->session->userdata('bagian');
    $where = array('id_legal_ijin' =>$id);
    $data['legal_ijin'] = $this->model_jenis_dokumen->edit_jenis_dokumen($where,'gap_legal_ijin')->result()
    ;
    $query_jenis_kepatuhan= $this->db->query("SELECT * FROM gap_jenis_kepatuhan ");
    $data['jenis_kepatuhan'] = $query_jenis_kepatuhan->result();
    
    $query_kebun= $this->db->query("SELECT tb_master_bagian.nama_bagian, gap_legal_ijin.id_kebun FROM tb_master_bagian 
      LEFT JOIN gap_legal_ijin ON tb_master_bagian.id_bagian = gap_legal_ijin.id_kebun
      WHERE gap_legal_ijin.id_legal_ijin = '$id' ");
      
    $data['kebun'] = $query_kebun->result();
    $data['pilihkebun'] = $this->model_dokumen->tampil_data_kebun()->result();
    $this->load->view('edit-gap_legalitas_dan_perijinan',$data);
  }

  public function update_legal_ijin()
  {
    $id       = $this->input->post('id');
    $id_kebun = $this->input->post('id_kebun');
    $kabupaten = $this->input->post('kabupaten');
    $no_ktun = $this->input->post('no_ktun');
    $tanggal_terbit = $this->input->post('tanggal_terbit');
    $tanggal_berakhir = $this->input->post('tanggal_berakhir');
    $kondisi_saat_ini = $this->input->post('kondisi_saat_ini');
    $cnvrt_tanggal_terbit = date('Y-m-d', strtotime($tanggal_terbit));
    $cnvrt_tanggal_berakhir = date('Y-m-d', strtotime($tanggal_berakhir));
    $keterangan = $this->input->post('keterangan');
    $jenis_kepatuhan = $this->input->post('jenis_kepatuhan');
    $upload_dokument = $this->input->post('upload_dokument');
    $upload_dokumen = $_FILES['upload_dokumen']['name'];

    $select = $this->db->select('nama_bagian');
    $nama_kebun = $select->get("tb_master_bagian WHERE id_bagian = '$id_kebun' ");
    $data = $nama_kebun->result_array();
    foreach ($data as $nk) : {
      $nama_kebun = $nk['nama_bagian'];
    }
    endforeach;

    if ($upload_dokumen == null) {
        $data = array(
            'id_kebun' => $id_kebun,
            'kabupaten' => $kabupaten,
            'nama_kebun' => $nama_kebun,
            'no_ktun' => $no_ktun,
            'tanggal_terbit' => $cnvrt_tanggal_terbit,
            'tanggal_berakhir' => $cnvrt_tanggal_berakhir,
            'kondisi_saat_ini' => $kondisi_saat_ini,
            'keterangan' => $keterangan,
            'jenis_kepatuhan' => $jenis_kepatuhan,
            'upload_dokumen' => $upload_dokument
        );
        $where = array('id_legal_ijin' => $id);
        $this->model_dokumen->update_dokumen($where,$data,'gap_legal_ijin');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');

        redirect('c_gap_legal_ijin/index');
    }else {
        $config['upload_path'] = './uploads';
        $config['allowed_types'] = '*';

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('upload_dokumen')) {
          echo "Gambar Gagal Upload !";
        } else {
          $upload_dokumen = $this->upload->data('file_name');
        }
        $data = array(
            'id_kebun' => $id_kebun,
            'kabupaten' => $kabupaten,
            'no_ktun' => $no_ktun,
            'tanggal_terbit' => $cnvrt_tanggal_terbit,
            'tanggal_berakhir' => $cnvrt_tanggal_berakhir,
            'kondisi_saat_ini' => $kondisi_saat_ini,
            'keterangan' => $keterangan,
            'jenis_kepatuhan' => $jenis_kepatuhan,
            'upload_dokumen' => $upload_dokumen
        );
        $where = array('id_legal_ijin' => $id);
        $this->model_dokumen->update_dokumen($where,$data,'gap_legal_ijin');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');

        redirect('c_gap_legal_ijin/index');
      }
    
  }
  public function nonaktif()
	{
    $id_delete = $this->input->post('id_delete');

        $status       = '1';

        $data = array(
            'status' => $status
        );
        $where = array('id_legal_ijin' => $id_delete);
        $this->model_dokumen->update_dokumen($where,$data,'gap_legal_ijin');
        $this->session->set_flashdata('something2', 'Pesan Terkirim');
        redirect('c_gap_legal_ijin/index');
  }
  public function aktif()
	{
        $id_delete = $this->input->post('id_delete');

        $status       = '0';

        $data = array(
            'status' => $status
        );
        $where = array('id_legal_ijin' => $id_delete);
        $this->model_dokumen->update_dokumen($where,$data,'gap_legal_ijin');
        $this->session->set_flashdata('something3', 'Pesan Terkirim');

        redirect('c_gap_legal_ijin/index');
  }
    
  public function load_status_surat()
  {
      $status_surat = $_GET['status_surat'];
      $idkebun = $this->session->userdata('id');
      $username = $this->session->userdata('username');
          
      if ($status_surat == 'aktif' && $username == 'admin') {
          $query_legal_ijin= $this->db->query("SELECT * FROM gap_legal_ijin WHERE status='0'  ");
          $data['legal_ijin'] = $query_legal_ijin->result_array();
          
      }elseif ($status_surat == 'aktif' && $username != 'admin') {
          $query_legal_ijin= $this->db->query("SELECT * FROM gap_legal_ijin WHERE status='0' AND id_kebun='$idkebun'");
          $data['legal_ijin'] = $query_legal_ijin->result_array();
          
      }elseif ($status_surat == 'nonaktif' && $username == 'admin') {
          $query_legal_ijin= $this->db->query("SELECT * FROM gap_legal_ijin WHERE status='1' ");
          $data['legal_ijin'] = $query_legal_ijin->result_array();
          
      }elseif ($status_surat == 'nonaktif' && $username != 'admin') {
        $query_legal_ijin= $this->db->query("SELECT * FROM gap_legal_ijin WHERE status='1' AND id_kebun='$idkebun'");
        $data['legal_ijin'] = $query_legal_ijin->result_array();
        
      }
          $no=0;
          foreach ($data['legal_ijin'] as $li) :
          $no++;
          ?>
          <tr>
              <td><?php echo $no ?></td>
              <td><?php echo $li['nama_kebun'] ?></td>
              <td><?php echo $li['no_ktun'] ?></td>
              <td><?php echo $li['tanggal_terbit'] ?></td>
              <td><?php echo $li['tanggal_berakhir'] ?></td>
              <td><?php echo $li['kondisi_saat_ini'] ?></td>
              <td>
              <?php 
              if ($li['status'] == '0') {
                ?>
                <?php echo anchor('c_gap_legal_ijin/form_detail_legal_ijin/'.$li['id_legal_ijin'], '<button type="button" class="btn  btn-warning btn-sm" title="Detail"><i class="fas fa-exclamation-circle" style="color:white;"></i></button>') ?>
                <?php echo anchor('c_gap_legal_ijin/edit_legal_ijin/'.$li['id_legal_ijin'], '<button type="button" class="btn  btn-primary btn-sm" title="Edit"><i class="far fa-edit"></i></button>') ?>
                <button type="button" class="btn  btn-danger btn-sm " data-toggle="modal" data-target="#modalhapus" title="Non Aktif" name="<?= $li['id_legal_ijin'];?>" onClick="reply_click1(this.name)"><i class="far fa-times-circle"></i></button>
                <?php }
              elseif ($li['status'] == '1') {
                ?>
                  <button type="button" class="btn btn-success btn-sm " data-toggle="modal" data-target="#modalaktif" title="Aktif" name="<?= $li['id_legal_ijin'];?>" onClick="reply_click(this.name)"><i class="far fa-times-circle"></i></button>
                <?php } ?>
              </td>
          </tr>
          <?php endforeach; ?><?php

                          
  }
  public function form_detail_legal_ijin($id)
  {
    $where = array('id_legal_ijin' =>$id);
    $detaillegalijin = $this->db->query("SELECT * FROM gap_legal_ijin 
      LEFT JOIN gap_jenis_kepatuhan ON gap_legal_ijin.jenis_kepatuhan = gap_jenis_kepatuhan.id_jen_kep
      WHERE gap_legal_ijin.id_legal_ijin = '$id' ORDER BY gap_legal_ijin.id_legal_ijin DESC");
    $data['legal_ijin'] = $detaillegalijin->result_array();
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_legal_ijin 
      WHERE gap_histori_legal_ijin.id_legal_ijin = '$id' ORDER BY id_histori_li DESC ");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();
    $query_jenis_kepatuhan= $this->db->query("SELECT * FROM gap_jenis_kepatuhan ");
    $data['jenis_kepatuhan'] = $query_jenis_kepatuhan->result();
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar');
      $this->load->view('detail-gap_legalitas_dan_perijinan',$data);
      $this->load->view('templates/footer');
  }

  public function tambah_detail_legal_ijin()
  {
    $histori_kondisi_saat_ini = $this->input->post('histori_kondisi_saat_ini');
    $tanggal_update = $this->input->post('tanggal_update');
    $cnvrt_tanggal_update = date('Y-m-d', strtotime($tanggal_update));
    $id_legal_ijin = $this->input->post('id_legal_ijin');
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
        'id_legal_ijin' => $id_legal_ijin,
        'histori_upload_dokumen' =>  $cvt_histori_upload_dokumen
    );
    $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'gap_histori_legal_ijin');
        $this->session->set_flashdata('something', 'Pesan Terkirim');
        redirect('c_gap_legal_ijin/form_detail_legal_ijin/'.$id_legal_ijin);
  }
  
  public function update_detail_legal_ijin()
  {
    $histori_kondisi_saat_ini = $this->input->post('histori_kondisi_saat_ini');
    $tanggal_update = $this->input->post('tanggal_update');
    $cnvrt_tanggal_update = date('Y-m-d', strtotime($tanggal_update));
    $id_histori_li = $this->input->post('id_histori_li');
    $id_legal_ijin = $this->input->post('id_legal_ijin');
    $histori_upload_dokumen = $_FILES['histori_upload_dokumen']['name'];
    $upload_dokument = $this->input->post('upload_dokument');
    if ($histori_upload_dokumen[0] == null) {
        $data = array(
          'histori_kondisi_saat_ini' => $histori_kondisi_saat_ini,
          'tanggal_update' => $cnvrt_tanggal_update,
          'histori_upload_dokumen' => $upload_dokument,
          'id_legal_ijin' => $id_legal_ijin
          
        );
        $where = array('id_histori_li' => $id_histori_li);
        $this->model_dokumen->update_dokumen($where,$data,'gap_histori_legal_ijin');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');
        redirect('c_gap_legal_ijin/form_detail_legal_ijin/'.$id_legal_ijin);
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
          'id_legal_ijin' => $id_legal_ijin,
          'histori_upload_dokumen' => $cvt_histori_upload_dokumen
        );
        $where = array('id_histori_li' => $id_histori_li);
        $this->model_dokumen->update_dokumen($where,$data,'gap_histori_legal_ijin');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');
        redirect('c_gap_legal_ijin/form_detail_legal_ijin/'.$id_legal_ijin);
      }
    
  }
}