<?php
class C_gap_pengelolaan_kebun extends CI_Controller{
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
        $query_pengolaan_kebun= $this->db->query("SELECT *, tb_master_bagian.id_bagian FROM gap_pengelolaan_kebun
        LEFT JOIN tb_master_bagian ON gap_pengelolaan_kebun.id_kebun = tb_master_bagian.id_bagian
        WHERE gap_pengelolaan_kebun.status = '0' ORDER BY id_olah_keb DESC");
      }else{
        $query_pengolaan_kebun= $this->db->query("SELECT *, tb_master_bagian.id_bagian FROM gap_pengelolaan_kebun
        LEFT JOIN tb_master_bagian ON gap_pengelolaan_kebun.id_kebun = tb_master_bagian.id_bagian
        WHERE gap_pengelolaan_kebun.status = '0' ORDER BY id_olah_keb DESC");
      }
      $query_jenis_kerjasama = $this->db->query("SELECT * FROM gap_master_kerjasama");
      $data['jenis_kerjasama'] = $query_jenis_kerjasama->result_array();
      $query_objek_kerjasama = $this->db->query("SELECT * FROM gap_master_objek_kerjasama");
      $data['objek_kerjasama'] = $query_objek_kerjasama->result_array();
      $data['user'] = $this->model_dokumen->tampil_data_user()->result_array();
      $data['pengolaan_kebun'] = $query_pengolaan_kebun->result_array();
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar');
      $this->load->view('gap_pengolaan_kebun',$data);
      $this->load->view('templates/footer');
    
  }
  public function form_pengelolaan_kebun()
  { 
    $id_bagian = $this->session->userdata('bagian');
    $query_kerjasama= $this->db->query("SELECT * FROM gap_master_kerjasama ");
    $query_objek_kerjasama= $this->db->query("SELECT * FROM gap_master_objek_kerjasama ");
    $data['kebun'] = $this->model_dokumen->tampil_data_kebun()->result();
    $data['objek_kerjasama'] = $query_objek_kerjasama->result_array();
    $data['kerjasama'] = $query_kerjasama->result_array();
    $this->load->view('tambah-gap_pengolaan_kebun',$data);
  }

  public function tambah_pengelolaan_kebun()
  {
    $no_perjanjian = $this->input->post('no_perjanjian');
    $id_kebun = $this->input->post('id_kebun');

    $select = $this->db->select('nama_bagian');
    $nama_kebun = $select->get("tb_master_bagian WHERE id_bagian = '$id_kebun' ");
    $data = $nama_kebun->result_array();
    foreach ($data as $nk) : {
      $nama_kebun = $nk['nama_bagian'];
    }
    endforeach;

    $kerjasama = $this->input->post('kerjasama');
    $jenis_kerjasama = $this->input->post('jenis_kerjasama');
    $mitra = $this->input->post('mitra');
    $luas = $this->input->post('luas');
    $tk_long = $this->input->post('tk_long');
    $tk_lat = $this->input->post('tk_lat');
    $nilai_kompensasi = $this->input->post('nilai_kompensasi');
    $objek_kerjasama = $this->input->post('objek_kerjasama');
    $tanggal_perjanjian = $this->input->post('tanggal_perjanjian');
    $tanggal_akhir_perjanjian = $this->input->post('tanggal_akhir_perjanjian');
    $cnvrt_tanggal_perjanjian = date('Y-m-d', strtotime($tanggal_perjanjian));
    $cnvrt_tanggal_akhir_perjanjian = date('Y-m-d', strtotime($tanggal_akhir_perjanjian));
    $jangka_waktu = $this->input->post('jangka_waktu');
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
      'no_perjanjian' => $no_perjanjian,
      'id_kebun' => $id_kebun,
      'nama_kebun' => $nama_kebun,
      'kerjasama' => $kerjasama,
      'jenis_kerjasama' => $jenis_kerjasama,
      'mitra' => $mitra,
      'luas' => $luas,
      'tk_long' => $tk_long,
      'tk_lat' => $tk_lat,
      'nilai_kompensasi' => $nilai_kompensasi,
      'objek_kerjasama' => $objek_kerjasama,
      'tanggal_perjanjian' => $cnvrt_tanggal_perjanjian,
      'tanggal_akhir_perjanjian' => $cnvrt_tanggal_akhir_perjanjian,
      'jangka_waktu' => $jangka_waktu,
      'kondisi_saat_ini' => $kondisi_saat_ini,
      'keterangan' => $keterangan,
      'upload_dokumen' => $upload_dokumen
    );

    // print_r($data);
    // die();

    $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'gap_pengelolaan_kebun');
    $this->session->set_flashdata('something', 'Pesan Terkirim');

    redirect('c_gap_pengelolaan_kebun/index');
  }

  
  public function edit_pengelolaan_kebun($id)
  {
    $id_bagian = $this->session->userdata('bagian');
    $where = array('id_olah_keb' =>$id);
    $data['legal_ijin'] = $this->model_jenis_dokumen->edit_jenis_dokumen($where,'gap_pengelolaan_kebun')->result();
    $query_kerjasama= $this->db->query("SELECT * FROM gap_master_kerjasama ");
    $query_objek_kerjasama= $this->db->query("SELECT * FROM gap_master_objek_kerjasama ");
    $query_hgu= $this->db->query("SELECT * FROM gap_master_hgu WHERE lokasi_kebun = '$id_bagian'");
    
    $query_kebun= $this->db->query("SELECT tb_master_bagian.nama_bagian, gap_pengelolaan_kebun.id_kebun FROM tb_master_bagian 
      LEFT JOIN gap_pengelolaan_kebun ON gap_pengelolaan_kebun.id_kebun = tb_master_bagian.id_bagian
      WHERE gap_pengelolaan_kebun.id_olah_keb = '$id' ");
    
    $data['kebun'] = $query_kebun->result();
    // print_r($data['kebun']);
    // die();

    $data['pilihkebun'] = $this->model_dokumen->tampil_data_kebun()->result();
    $data['objek_kerjasama'] = $query_objek_kerjasama->result_array();
    $data['kerjasama'] = $query_kerjasama->result_array();
    $data['nomor_hgu'] = $query_hgu->result_array();
    $this->load->view('edit-gap_pengolaan_kebun',$data);
  }



  public function update_pengelolaan_kebun()
  {
    $id = $this->input->post('id');
    $no_perjanjian = $this->input->post('no_perjanjian');
    $kerjasama = $this->input->post('kerjasama');
    $jenis_kerjasama = $this->input->post('jenis_kerjasama');
    $id_kebun = $this->input->post('id_kebun');
    $mitra = $this->input->post('mitra');
    $luas = $this->input->post('luas');
    $tk_long = $this->input->post('tk_long');
    $tk_lat = $this->input->post('tk_lat');
    $nilai_kompensasi = $this->input->post('nilai_kompensasi');
    $objek_kerjasama = $this->input->post('objek_kerjasama');
    $tanggal_perjanjian = $this->input->post('tanggal_perjanjian');
    $tanggal_akhir_perjanjian = $this->input->post('tanggal_akhir_perjanjian');
    $cnvrt_tanggal_perjanjian = date('Y-m-d', strtotime($tanggal_perjanjian));
    $cnvrt_tanggal_akhir_perjanjian = date('Y-m-d', strtotime($tanggal_akhir_perjanjian));
    $jangka_waktu = $this->input->post('jangka_waktu');
    $kondisi_saat_ini = $this->input->post('kondisi_saat_ini');
    $keterangan = $this->input->post('keterangan');
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
            'nama_kebun' => $nama_kebun,
            'no_perjanjian' => $no_perjanjian,
            'kerjasama' => $kerjasama,
            'jenis_kerjasama' => $jenis_kerjasama,
            'mitra' => $mitra,
            'id_kebun' => $id_kebun,
            'luas' => $luas,
            'tk_long' => $tk_long,
            'tk_lat' => $tk_lat,
            'nilai_kompensasi' => $nilai_kompensasi,
            'objek_kerjasama' => $objek_kerjasama,
            'tanggal_perjanjian' => $cnvrt_tanggal_perjanjian,
            'tanggal_akhir_perjanjian' => $cnvrt_tanggal_akhir_perjanjian,
            'jangka_waktu' => $jangka_waktu,
            'kondisi_saat_ini' => $kondisi_saat_ini,
            'keterangan' => $keterangan,
            'upload_dokumen' => $upload_dokument
        );
        // print_r($data);
        // die();
        $where = array('id_olah_keb' => $id);
        $this->model_dokumen->update_dokumen($where,$data,'gap_pengelolaan_kebun');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');

        redirect('c_gap_pengelolaan_kebun/index');
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
            'nama_kebun' => $nama_kebun,
            'no_perjanjian' => $no_perjanjian,
            'id_kebun' => $id_kebun,
            'kerjasama' => $kerjasama,
            'jenis_kerjasama' => $jenis_kerjasama,
            'mitra' => $mitra,
            'luas' => $luas,
            'tk_long' => $tk_long,
            'tk_lat' => $tk_lat,
            'nilai_kompensasi' => $nilai_kompensasi,
            'objek_kerjasama' => $objek_kerjasama,
            'tanggal_perjanjian' => $cnvrt_tanggal_perjanjian,
            'tanggal_akhir_perjanjian' => $cnvrt_tanggal_akhir_perjanjian,
            'jangka_waktu' => $jangka_waktu,
            'kondisi_saat_ini' => $kondisi_saat_ini,
            'keterangan' => $keterangan,
            'upload_dokumen' => $upload_dokumen
        );
        // print_r($data);
        // die();
        $where = array('id_olah_keb' => $id);
        $this->model_dokumen->update_dokumen($where,$data,'gap_pengelolaan_kebun');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');

        redirect('c_gap_pengelolaan_kebun/index');
      }  
  }

  public function nonaktif()
	{     
    $id_delete = $this->input->post('id_delete');

        $status       = '1';

        $data = array(
            'status' => $status
        );
        $where = array('id_olah_keb' => $id_delete);
        $this->model_dokumen->update_dokumen($where,$data,'gap_pengelolaan_kebun');
    $this->session->set_flashdata('something2', 'Pesan Terkirim');

        redirect('c_gap_pengelolaan_kebun/index');
  }
  public function aktif()
	{
        $id_delete = $this->input->post('id_delete');

        $status       = '0';

        $data = array(
            'status' => $status
        );
        $where = array('id_olah_keb' => $id_delete);
        $this->model_dokumen->update_dokumen($where,$data,'gap_pengelolaan_kebun');
      $this->session->set_flashdata('something3', 'Pesan Terkirim');

        redirect('c_gap_pengelolaan_kebun/index');
  }
    
  public function load_status_surat()
  {
      $status_surat = $_GET['status_surat'];
      $idkebun = $this->session->userdata('id');
      $username = $this->session->userdata('username');
      
      if ($status_surat == 'aktif' && $username == 'admin') {
        $query_pengolaan_kebun= $this->db->query("SELECT * FROM gap_pengelolaan_kebun WHERE status='0'  ");
        $data['pengolaan_kebun'] = $query_pengolaan_kebun->result_array();
        
      }elseif ($status_surat == 'aktif' && $username != 'admin') {
          $query_pengolaan_kebun= $this->db->query("SELECT * FROM gap_pengelolaan_kebun WHERE status='0' AND id_kebun='$idkebun'");
          $data['pengolaan_kebun'] = $query_pengolaan_kebun->result_array();
          
      }elseif ($status_surat == 'nonaktif' && $username == 'admin') {
          $query_pengolaan_kebun= $this->db->query("SELECT * FROM gap_pengelolaan_kebun WHERE status='1' ");
          $data['pengolaan_kebun'] = $query_pengolaan_kebun->result_array();
          
      }elseif ($status_surat == 'nonaktif' && $username != 'admin') {
        $query_pengolaan_kebun= $this->db->query("SELECT * FROM gap_pengelolaan_kebun WHERE status='1' AND id_kebun='$idkebun'");
        $data['pengolaan_kebun'] = $query_pengolaan_kebun->result_array();
        
      }   
      
        $no=0;
        foreach ($data['pengolaan_kebun'] as $pk) :
        $no++;
        ?>
        <tr>
            <td><?php echo $no ?></td>
            <td><?php echo $pk['nama_kebun'] ?></td>
            <td><?php echo $pk['no_perjanjian'] ?></td>
            <td><?php echo $pk['kerjasama'] ?></td>
            <td><?php echo $pk['jenis_kerjasama'] ?></td>
            <td><?php echo $pk['mitra'] ?></td>
            <td><?php echo $pk['objek_kerjasama'] ?></td>
            <td><?php echo $pk['nilai_kompensasi'] ?></td>
            <td><?php echo $pk['tanggal_perjanjian'] ?></td>
            <td><?php echo $pk['tanggal_akhir_perjanjian'] ?></td>
            <td><?php echo $pk['kondisi_saat_ini'] ?></td>
            <td>
            <?php 
              if ($pk['status'] == '0') {
                  ?>
                <?php echo anchor('c_gap_pengelolaan_kebun/form_detail_pengelolaan_kebun/'.$pk['id_olah_keb'], '<button type="button" class="btn  btn-warning btn-sm mb-2" title="Detail"><i class="fas fa-exclamation-circle" style="color:white;"></i></button>') ?>
                <?php echo anchor('c_gap_pengelolaan_kebun/edit_pengelolaan_kebun/'.$pk['id_olah_keb'], '<button type="button" class="btn  btn-primary btn-sm mb-2" title="Edit"><i class="far fa-edit"></i></button>') ?>
                <button type="button" class="btn  btn-danger btn-sm mb-2" data-toggle="modal" data-target="#modalhapus" title="Non Aktif" name="<?= $pk['id_olah_keb'];?>" onClick="reply_click1(this.name)"><i class="far fa-times-circle"></i></button>
                <?php }elseif ($pk['status'] == '1') {?>
                  <button type="button" class="btn  btn-success btn-sm mb-2 " data-toggle="modal" data-target="#modalaktif" title="Aktif" name="<?= $pk['id_olah_keb'];?>" onClick="reply_click(this.name)"><i class="far fa-times-circle"></i></button>
                <?php } ?>
            </td>
        </tr>
        <?php endforeach; ?><?php
      
                          
  }
  public function form_detail_pengelolaan_kebun($id)
  {
    $where = array('id_olah_keb' =>$id);

    $detail_pengelolah_kebun = $this->db->query("SELECT *,gap_pengelolaan_kebun.keterangan AS ketpengkeb  FROM gap_pengelolaan_kebun 
      LEFT JOIN gap_master_kerjasama ON gap_pengelolaan_kebun.jenis_kerjasama = gap_master_kerjasama.id_kerjasama
      LEFT JOIN gap_master_objek_kerjasama ON gap_pengelolaan_kebun.objek_kerjasama = gap_master_objek_kerjasama.id_objek_kerjasama
      LEFT JOIN tb_master_bagian ON gap_pengelolaan_kebun.id_kebun = tb_master_bagian.id_bagian
    WHERE gap_pengelolaan_kebun.id_olah_keb = '$id'");
    $data['pengelolaan_kebun'] = $detail_pengelolah_kebun->result_array();
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_pengelolaan_kebun 
    WHERE gap_histori_pengelolaan_kebun.id_peng_keb = '$id' ORDER BY id_histori_peng_keb DESC ");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar');
      $this->load->view('detail-gap_pengolaan_kebun',$data);
      $this->load->view('templates/footer');
  }
  
  public function tambah_detail_pengelolaan_kebun()
  {
    $histori_kondisi_saat_ini = $this->input->post('histori_kondisi_saat_ini');
    $tanggal_update = $this->input->post('tanggal_update');
    $cnvrt_tanggal_update = date('Y-m-d', strtotime($tanggal_update));
    $id_olah_keb = $this->input->post('id_olah_keb');
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
        'id_peng_keb' => $id_olah_keb,
        'histori_upload_dokumen' => $cvt_histori_upload_dokumen
    );
    $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'gap_histori_pengelolaan_kebun');
        $this->session->set_flashdata('something', 'Pesan Terkirim');
        redirect('c_gap_pengelolaan_kebun/form_detail_pengelolaan_kebun/'.$id_olah_keb);
  }
  public function update_detail_pengelolaan_kebun()
  {
    $histori_kondisi_saat_ini = $this->input->post('histori_kondisi_saat_ini');
    $tanggal_update = $this->input->post('tanggal_update');
    $cnvrt_tanggal_update = date('Y-m-d', strtotime($tanggal_update));
    $id_histori_peng_keb = $this->input->post('id_histori_peng_keb');
    $id_peng_keb = $this->input->post('id_peng_keb');
    $histori_upload_dokumen = $_FILES['histori_upload_dokumen']['name'];
    $cvt_histori_upload_dokumen = implode(",", $histori_upload_dokumen);
    $upload_dokument = $this->input->post('upload_dokument');
    if ($histori_upload_dokumen[0] == null) {
        $data = array(
          'histori_kondisi_saat_ini' => $histori_kondisi_saat_ini,
          'tanggal_update' => $cnvrt_tanggal_update,
          'histori_upload_dokumen' => $upload_dokument
        );
        $where = array('id_histori_peng_keb' => $id_histori_peng_keb);
        $this->model_dokumen->update_dokumen($where,$data,'gap_histori_pengelolaan_kebun');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');
        redirect('c_gap_pengelolaan_kebun/form_detail_pengelolaan_kebun/'.$id_peng_keb);
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
        $where = array('id_histori_peng_keb' => $id_histori_peng_keb);
        $this->model_dokumen->update_dokumen($where,$data,'gap_histori_pengelolaan_kebun');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');
        redirect('c_gap_pengelolaan_kebun/form_detail_pengelolaan_kebun/'.$id_peng_keb);
      }
    
  }
}