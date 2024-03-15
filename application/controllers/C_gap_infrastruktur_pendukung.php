<?php
class C_gap_infrastruktur_pendukung extends CI_Controller{
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
        $query_infrastruktur_pendukung= $this->db->query("SELECT * FROM gap_infrastruktur_pendukung WHERE status='0' AND jenis_infrastruktur ='1' ORDER BY id_infra_pen DESC");
        // $query_infrastruktur_pendukung= $this->db->query("SELECT *, tb_master_bagian.id_bagian FROM gap_infrastruktur_pendukung
        //   LEFT JOIN tb_master_bagian ON gap_infrastruktur_pendukung.id_kebun = tb_master_bagian.id_bagian
        //   WHERE gap_infrastruktur_pendukung.status = '0' 
        //   AND gap_infrastruktur_pendukung.jenis_infrastruktur = '1' 
        //   ORDER BY id_infra_pen DESC");
      }else{
        $query_infrastruktur_pendukung= $this->db->query("SELECT * FROM gap_infrastruktur_pendukung WHERE status='0' AND id_kebun='$id' AND jenis_infrastruktur ='1'  ORDER BY id_infra_pen DESC");
        // $query_infrastruktur_pendukung= $this->db->query("SELECT *, tb_master_bagian.id_bagian FROM gap_infrastruktur_pendukung
        //   LEFT JOIN tb_master_bagian ON gap_infrastruktur_pendukung.id_kebun = tb_master_bagian.id_bagian
        //   WHERE gap_infrastruktur_pendukung.status = '0' 
        //   AND gap_infrastruktur_pendukung.id_kebun = '$id'
        //   AND gap_infrastruktur_pendukung.jenis_infrastruktur = '1' 
        //   ORDER BY id_infra_pen DESC");
      }

      $data['infrastruktur_pendukung'] = $query_infrastruktur_pendukung->result_array();
      $data['user'] = $this->model_dokumen->tampil_data_user()->result_array();
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar');
      $this->load->view('gap_infrastruktur_pendukung',$data);
      $this->load->view('templates/footer');
    
  }
  public function form_infra_pend()
  { 
    $id_bagian = $this->session->userdata('bagian');
    $data['kebun'] = $this->model_dokumen->tampil_data_kebun()->result();
    $this->load->view('tambah-gap_infrastruktur_pendukung',$data);
  }
  public function tambah_infra_pend()
  {
    $jenis_infrastruktur = $this->input->post('jenis_infrastruktur');
    $id_kebun = $this->input->post('id_kebun');

    $select = $this->db->select('nama_bagian');
    $nama_kebun = $select->get("tb_master_bagian WHERE id_bagian = '$id_kebun' ");
    $data = $nama_kebun->result_array();
    foreach ($data as $nk) : {
      $nama_kebun = $nk['nama_bagian'];
    }
    endforeach;

    $nama_infra = $this->input->post('nama_infra');
    $luas_tanah = $this->input->post('luas_tanah');
    $luas_bangunan = $this->input->post('luas_bangunan');
    $jumlah = $this->input->post('jumlah');
    $kondisi_saat_ini = $this->input->post('kondisi_saat_ini');
    $keterangan = $this->input->post('keterangan');
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
      'jenis_infrastruktur' => $jenis_infrastruktur,
      'nama_infra' => $nama_infra,
      'id_kebun' => $id_kebun,
      'nama_kebun' => $nama_kebun,
      'luas_tanah' => $luas_tanah,
      'luas_bangunan' => $luas_bangunan,
      'jumlah' => $jumlah,
      'kondisi_saat_ini' => $kondisi_saat_ini,
      'keterangan' => $keterangan,
      'upload_dokumen' => $upload_dokumen
    );
    $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'gap_infrastruktur_pendukung');
    $this->session->set_flashdata('something', 'Pesan Terkirim');
    redirect('c_gap_infrastruktur_pendukung/index');
  }

  public function edit_infra_pend($id)
  {
    $id_bagian = $this->session->userdata('bagian');
    $where = array('id_infra_pen' =>$id);
    $data['infrastruktur_pendukung'] = $this->model_jenis_dokumen->edit_jenis_dokumen($where,'gap_infrastruktur_pendukung')->result();

    $query_kebun= $this->db->query("SELECT tb_master_bagian.nama_bagian, gap_infrastruktur_pendukung.id_kebun FROM tb_master_bagian 
      LEFT JOIN gap_infrastruktur_pendukung ON tb_master_bagian.id_bagian = gap_infrastruktur_pendukung.id_kebun
      WHERE gap_infrastruktur_pendukung.id_infra_pen = '$id' ");

    $data['kebun'] = $query_kebun->result();
    $data['pilihkebun'] = $this->model_dokumen->tampil_data_kebun()->result();
    $this->load->view('edit-gap_infrastruktur_pendukung',$data);
  }

  public function update_infra_pend()
  {
    $id = $this->input->post('id');
    $jenis_infrastruktur = $this->input->post('jenis_infrastruktur');
    $id_kebun = $this->input->post('id_kebun');

    $select = $this->db->select('nama_bagian');
    $nama_kebun = $select->get("tb_master_bagian WHERE id_bagian = '$id_kebun' ");
    $data = $nama_kebun->result_array();
    foreach ($data as $nk) : {
      $nama_kebun = $nk['nama_bagian'];
    }
    endforeach;
    
    $nama_infra = $this->input->post('nama_infra');
    $luas_tanah = $this->input->post('luas_tanah');
    $luas_bangunan = $this->input->post('luas_bangunan');
    $jumlah = $this->input->post('jumlah');
    $kondisi_saat_ini = $this->input->post('kondisi_saat_ini');
    $keterangan = $this->input->post('keterangan');
    $upload_dokument = $this->input->post('upload_dokument');
    $upload_dokumen = $_FILES['upload_dokumen']['name'];
    
    if ($upload_dokumen == null) {
        $data = array(
            'jenis_infrastruktur' => $jenis_infrastruktur,
            'nama_infra' => $nama_infra,
            'nama_kebun' => $nama_kebun,
            'luas_tanah' => $luas_tanah,
            'luas_bangunan' => $luas_bangunan,
            'id_kebun' => $id_kebun,
            'jumlah' => $jumlah,
            'kondisi_saat_ini' => $kondisi_saat_ini,
            'keterangan' => $keterangan,
            'upload_dokumen' => $upload_dokument
        );
        $where = array('id_infra_pen' => $id);
        $this->model_dokumen->update_dokumen($where,$data,'gap_infrastruktur_pendukung');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');
        redirect('c_gap_infrastruktur_pendukung/index');
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
            'jenis_infrastruktur' => $jenis_infrastruktur,
            'nama_infra' => $nama_infra,
            'nama_kebun' => $nama_kebun,
            'id_kebun' => $id_kebun,
            'luas_tanah' => $luas_tanah,
            'luas_bangunan' => $luas_bangunan,
            'jumlah' => $jumlah,
            'kondisi_saat_ini' => $kondisi_saat_ini,
            'keterangan' => $keterangan,
            'upload_dokumen' => $upload_dokumen
        );
        $where = array('id_infra_pen' => $id);
        $this->model_dokumen->update_dokumen($where,$data,'gap_infrastruktur_pendukung');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');
        redirect('c_gap_infrastruktur_pendukung/index');
      }
    
  }
  public function nonaktif()
	{
    $id_delete = $this->input->post('id_delete');

        $status = 1;

        $data = array(
            'status' => $status
        );
        $where = array('id_infra_pen' => $id_delete);
        $this->model_dokumen->update_dokumen($where,$data,'gap_infrastruktur_pendukung');
        $this->session->set_flashdata('something2', 'Pesan Terkirim');
        redirect('c_gap_infrastruktur_pendukung/index');
  }
  public function aktif()
	{
    $id_delete = $this->input->post('id_delete');

        $status = 0;

        $data = array(
            'status' => $status
        );
        $where = array('id_infra_pen' => $id_delete);
        $this->model_dokumen->update_dokumen($where,$data,'gap_infrastruktur_pendukung');
        $this->session->set_flashdata('something3', 'Pesan Terkirim');
        redirect('c_gap_infrastruktur_pendukung/index');
  }
    
  public function load_status_surat(){
      $status_surat = $_GET['status_surat'];
      $idkebun      = $this->session->userdata('bagian');
      $username     = $this->session->userdata('username');
      $tabbuton     = $this->session->userdata('valuebutton');
          
      if ($status_surat == 'aktif' && $username == 'admin') {
        $query_infrastruktur_pendukung= $this->db->query("SELECT * FROM gap_infrastruktur_pendukung 
          WHERE status='0' 
          AND jenis_infrastruktur = $tabbuton 
          ORDER BY id_infra_pen DESC");
        $data['infrastruktur_pendukung'] = $query_infrastruktur_pendukung->result_array();

      }elseif ($status_surat == 'aktif' && $username != 'admin') {
        $query_infrastruktur_pendukung= $this->db->query("SELECT * FROM gap_infrastruktur_pendukung 
          WHERE status='0' AND id_kebun='$idkebun' 
          AND jenis_infrastruktur = $tabbuton 
          ORDER BY id_infra_pen DESC");
        $data['infrastruktur_pendukung'] = $query_infrastruktur_pendukung->result_array();
          
      }elseif ($status_surat == 'nonaktif' && $username == 'admin') {
        $query_infrastruktur_pendukung= $this->db->query("SELECT * FROM gap_infrastruktur_pendukung 
          WHERE status='1' AND jenis_infrastruktur = $tabbuton 
          ORDER BY id_infra_pen DESC");
        $data['infrastruktur_pendukung'] = $query_infrastruktur_pendukung->result_array();
          
      }elseif ($status_surat == 'nonaktif' && $username != 'admin') {
        $query_infrastruktur_pendukung= $this->db->query("SELECT * FROM gap_infrastruktur_pendukung 
          WHERE status='1' 
          AND id_kebun='$idkebun' AND jenis_infrastruktur = $tabbuton 
          ORDER BY id_infra_pen DESC");
        $data['infrastruktur_pendukung'] = $query_infrastruktur_pendukung->result_array();
        
      }

      $data['user'] = $this->model_dokumen->tampil_data_user()->result_array();

        $no=0;
        foreach ($data['infrastruktur_pendukung'] as $ip) :
        $no++;
        ?>
        <tr>
            <td><?php echo $no ?></td>
            <td><?php echo $ip['nama_kebun'] ?>
            <td><?php echo $ip['nama_infra'] ?></td>
            <td>
            <?php
                  $id_detail = $ip['id_infra_pen'];
                  
                  $update_kondisi= $this->db->query("SELECT * FROM gap_histori_infrastruktur_pendukung WHERE id_infra_pen= $id_detail  ORDER BY tanggal_update DESC LIMIT 1");
                  $data['update_kondisi'] = $update_kondisi->result_array();
                  if(count($data['update_kondisi'])>0){
                    if ($data['update_kondisi'][0]['histori_kondisi_saat_ini'] != '') {
                      echo $data['update_kondisi'][0]['histori_kondisi_saat_ini'] ;
                    }
                  }else {
                    echo $ip['kondisi_saat_ini'];

                  }
                ?>
            </td>
            <td><?php echo $ip['jumlah'] ?></td>
            <td>
            <?php 
              if($ip['status'] == '0') {
                ?>
                  <?php echo anchor('c_gap_infrastruktur_pendukung/form_detail_infra_pend/'.$ip['id_infra_pen'], '<button type="button" class="btn  btn-warning btn-sm mb-2" title="Detail"><i class="fas fa-exclamation-circle" style="color:white;"></i></button>') ?>
                  <?php echo anchor('c_gap_infrastruktur_pendukung/edit_infra_pend/'.$ip['id_infra_pen'], '<button type="button" class="btn  btn-primary btn-sm mb-2" title="Edit"><i class="far fa-edit"></i></button>') ?>
                  <button type="button" class="btn  btn-danger btn-sm  mb-2" data-toggle="modal" data-target="#modalhapus" title="Non Aktif" name="<?= $ip['id_infra_pen'];?>" onClick="reply_click1(this.name)"><i class="far fa-times-circle"></i></button>
                <?php 
                }elseif($ip['status'] == '1') { 
                ?>
                  <button type="button" class="btn  btn-success btn-sm  mb-2" data-toggle="modal" data-target="#modalaktif" title="Aktif" name="<?= $ip['id_infra_pen'];?>" onClick="reply_click(this.name)"><i class="far fa-times-circle"></i></button>
                <?php 
                } 
                ?>
            </td>
        </tr>
        <?php endforeach; ?><?php
  }

  public function load_tabbutton()
  {
      $valuebutton = $_GET['valuebutton'];
      $username = $this->session->userdata('username');
      $idkebun = $this->session->userdata('bagian');
      
      if ($valuebutton == '1' && $username != 'admin') {
        $this->session->set_userdata('valuebutton', '1');
        $query_infrastruktur_pendukung= $this->db->query("SELECT * FROM gap_infrastruktur_pendukung WHERE status='0' AND jenis_infrastruktur ='1' AND id_kebun='$idkebun' ORDER BY id_infra_pen DESC");
        $data['infrastruktur_pendukung'] = $query_infrastruktur_pendukung->result_array();
        
      }elseif ($valuebutton == '2' && $username != 'admin') {
        $this->session->set_userdata('valuebutton', '2');
        $query_infrastruktur_pendukung= $this->db->query("SELECT * FROM gap_infrastruktur_pendukung WHERE status='0' AND jenis_infrastruktur ='2' AND id_kebun='$idkebun' ORDER BY id_infra_pen DESC");
        $data['infrastruktur_pendukung'] = $query_infrastruktur_pendukung->result_array();
          
      }elseif ($valuebutton == '3' && $username != 'admin') {
        $this->session->set_userdata('valuebutton', '3');
        $query_infrastruktur_pendukung= $this->db->query("SELECT * FROM gap_infrastruktur_pendukung WHERE status='0' AND jenis_infrastruktur ='3' AND id_kebun='$idkebun' ORDER BY id_infra_pen DESC");
        $data['infrastruktur_pendukung'] = $query_infrastruktur_pendukung->result_array();
        
      }elseif ($valuebutton == '1' && $username == 'admin') {
        $this->session->set_userdata('valuebutton', '1');
        $query_infrastruktur_pendukung= $this->db->query("SELECT * FROM gap_infrastruktur_pendukung WHERE status='0' AND jenis_infrastruktur ='1' ORDER BY id_infra_pen DESC");
        $data['infrastruktur_pendukung'] = $query_infrastruktur_pendukung->result_array();
        
      }elseif ($valuebutton == '2' && $username == 'admin') {
        $this->session->set_userdata('valuebutton', '2');
        $query_infrastruktur_pendukung= $this->db->query("SELECT * FROM gap_infrastruktur_pendukung WHERE status='0' AND jenis_infrastruktur ='2' ORDER BY id_infra_pen DESC");
        $data['infrastruktur_pendukung'] = $query_infrastruktur_pendukung->result_array();
        
      }elseif ($valuebutton == '3' && $username == 'admin') {
        $this->session->set_userdata('valuebutton', '3');
        $query_infrastruktur_pendukung= $this->db->query("SELECT * FROM gap_infrastruktur_pendukung WHERE status='0' AND jenis_infrastruktur ='3'  ORDER BY id_infra_pen DESC");
        $data['infrastruktur_pendukung'] = $query_infrastruktur_pendukung->result_array();
      }

      $data['user'] = $this->model_dokumen->tampil_data_user()->result_array();

        $no=0;
        foreach ($data['infrastruktur_pendukung'] as $ip) :
        $no++;
        ?>
        <tr>
            <td><?php echo $no ?></td>
            <td><?php echo $ip['nama_kebun'] ?></td>
            <td><?php echo $ip['nama_infra'] ?></td>
            <td>
                <?php
                  $id_detail = $ip['id_infra_pen'];

                  $update_kondisi= $this->db->query("SELECT * FROM gap_histori_infrastruktur_pendukung WHERE id_infra_pen= $id_detail  ORDER BY tanggal_update DESC LIMIT 1");
                  $data['update_kondisi'] = $update_kondisi->result_array();
                  if(count($data['update_kondisi'])>0){
                    if ($data['update_kondisi'][0]['histori_kondisi_saat_ini'] != '') {
                      echo $data['update_kondisi'][0]['histori_kondisi_saat_ini'] ;
                    }
                  }else {
                    echo $ip['kondisi_saat_ini'];

                  }
                  

                ?>
            </td>
            <td><?php echo $ip['jumlah'] ?></td>
            <td>
            <?php 
              if($ip['status'] == '0') {
                ?>
                  <?php echo anchor('c_gap_infrastruktur_pendukung/form_detail_infra_pend/'.$ip['id_infra_pen'], '<button type="button" class="btn  btn-warning btn-sm mb-2" title="Detail"><i class="fas fa-exclamation-circle" style="color:white;"></i></button>') ?>
                  <?php echo anchor('c_gap_infrastruktur_pendukung/edit_infra_pend/'.$ip['id_infra_pen'], '<button type="button" class="btn  btn-primary btn-sm mb-2" title="Edit"><i class="far fa-edit"></i></button>') ?>
                  <button type="button" class="btn  btn-danger btn-sm  mb-2" data-toggle="modal" data-target="#modalhapus" title="Non Aktif" name="<?= $ip['id_infra_pen'];?>" onClick="reply_click1(this.name)"><i class="far fa-times-circle"></i></button>
                <?php }elseif ($ip['status'] == '1') {?>
                  <button type="button" class="btn  btn-success btn-sm  mb-2" data-toggle="modal" data-target="#modalaktif" title="Aktif" name="<?= $ip['id_infra_pen'];?>" onClick="reply_click(this.name)"><i class="far fa-times-circle-check"></i></button>
                <?php } ?>
            </td>
        </tr>
        <?php endforeach; ?><?php
      
                          
  }
  public function form_detail_infra_pend($id)
  {
    $where = array('id_infra_pen' =>$id);
    $detail_infra_pend = $this->db->query("SELECT * FROM gap_infrastruktur_pendukung 
      LEFT JOIN tb_master_bagian ON gap_infrastruktur_pendukung.id_kebun = tb_master_bagian.id_bagian
      WHERE gap_infrastruktur_pendukung.id_infra_pen = '$id' ");
    $data['infra_pend'] = $detail_infra_pend->result_array();
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_infrastruktur_pendukung 
      WHERE id_infra_pen = '$id' ORDER BY id_histori_infra_pen DESC ");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar');
      $this->load->view('detail-gap_infrastruktur_pendukung',$data);
      $this->load->view('templates/footer');
  }

  public function tambah_detail_infra_pend()
  {
    $histori_kondisi_saat_ini = $this->input->post('histori_kondisi_saat_ini');
    $tanggal_update = $this->input->post('tanggal_update');
    $cnvrt_tanggal_update = date('Y-m-d', strtotime($tanggal_update));
    $id_infra_pen = $this->input->post('id_infra_pen');
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
        'id_infra_pen' => $id_infra_pen,
        'histori_upload_dokumen' => $cvt_histori_upload_dokumen
    );
    $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'gap_histori_infrastruktur_pendukung');
        $this->session->set_flashdata('something', 'Pesan Terkirim');
        redirect('c_gap_infrastruktur_pendukung/form_detail_infra_pend/'.$id_infra_pen);
  }

  public function update_detail_infra_pend()
  {
    $histori_kondisi_saat_ini = $this->input->post('histori_kondisi_saat_ini');
    $tanggal_update = $this->input->post('tanggal_update');
    $cnvrt_tanggal_update = date('Y-m-d', strtotime($tanggal_update));
    $id_histori_infra_pen = $this->input->post('id_histori_infra_pen');
    $id_infra_pen = $this->input->post('id_infra_pen');
    $histori_upload_dokumen = $_FILES['histori_upload_dokumen']['name'];
    $upload_dokument = $this->input->post('upload_dokument');
    if ($histori_upload_dokumen[0] == null) {
        $data = array(
          'histori_kondisi_saat_ini' => $histori_kondisi_saat_ini,
          'tanggal_update' => $cnvrt_tanggal_update,
          'histori_upload_dokumen' => $upload_dokument
        );
        $where = array('id_histori_infra_pen' => $id_histori_infra_pen);
        $this->model_dokumen->update_dokumen($where,$data,'gap_histori_infrastruktur_pendukung');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');
        redirect('c_gap_infrastruktur_pendukung/form_detail_infra_pend/'.$id_infra_pen);
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
        $where = array('id_histori_infra_pen' => $id_histori_infra_pen);
        $this->model_dokumen->update_dokumen($where,$data,'gap_histori_infrastruktur_pendukung');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');
        redirect('c_gap_infrastruktur_pendukung/form_detail_infra_pend/'.$id_infra_pen);
      }
    
  }
}