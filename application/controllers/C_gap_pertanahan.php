<?php
class C_gap_pertanahan extends CI_Controller{
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
      $bagian = $this->session->userdata('bagian');
      $username = $this->session->userdata('username');
      if ($username == 'admin') {
        $query_pertanahan= $this->db->query("SELECT *, tb_master_bagian.id_bagian FROM gap_pertanahan
          LEFT JOIN tb_master_bagian ON gap_pertanahan.id_kebun = tb_master_bagian.id_bagian
          WHERE gap_pertanahan.status = '0'
          ORDER BY id_pertanahan DESC");
      }else{
        $query_pertanahan= $this->db->query("SELECT *, tb_master_bagian.id_bagian FROM gap_pertanahan
          LEFT JOIN tb_master_bagian ON gap_pertanahan.id_kebun = tb_master_bagian.id_bagian
          WHERE gap_pertanahan.status = '0' AND gap_pertanahan.id_kebun = '$bagian'
          ORDER BY id_pertanahan DESC");
      }
      $query_kebun= $this->db->query("SELECT * FROM tb_master_bagian ");
      $data['master_kebun'] = $query_kebun->result_array();
      $data['user'] = $this->model_dokumen->tampil_data_user()->result_array();
      $data['pertanahan'] = $query_pertanahan->result_array();
      // print_r($data['pertanahan']);
      // die();
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar');
      $this->load->view('gap_pertanahan',$data);
      $this->load->view('templates/footer');
    
  }
  public function form_pertanahan()
  { 
    $id_bagian = $this->session->userdata('bagian');
    // print_r($id_bagian);
    // die();
    $username = $this->session->userdata('username');
    $query_lsm= $this->db->query("SELECT * FROM gap_master_lsm ");
    $data['master_lsm'] = $query_lsm->result_array();
    if($username == 'admin'){
      $query_hgu= $this->db->query("SELECT * FROM gap_master_hgu ");
    } else {
      $query_hgu= $this->db->query("SELECT * FROM gap_master_hgu WHERE id_kebun = '$id_bagian'");
    }
    $data['master_hgu'] = $query_hgu->result_array();
    $data['kebun'] = $this->model_dokumen->tampil_data_kebun()->result();
    $this->load->view('tambah-gap_pertanahan',$data);
  }
  
  public function tambah_pertanahan()
  {
    $no_hgu = $this->input->post('no_hgu');
    $id_kebun = $this->input->post('id_kebun');
    $luas = $_POST['luas'];
    $tanggal_terjadi = $_POST['tanggal_terjadi'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $subjek = $_POST['subjek'];
    $kerugian = $_POST['kerugian'];
    $komoditi = $_POST['komoditi'];
    $id_tanah = $_POST['id_tanah'];
    $tanah_belum_digarap = $_POST['tanah_belum_digarap'];
    $kategorisasi = $_POST['kategorisasi'];
    $data = array(
      'no_hgu' => $no_hgu,
      'id_kebun' => $id_kebun
    );
    $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'gap_pertanahan');
    $id_kat_pertanahan = $this->db->insert_id();
    foreach ($id_tanah as $key => $value) {
      if($key == 0){
        
        if ($tanah_belum_digarap==1) {
          $data1 = array(
            'luas' => $luas[$key],
            'tanggal_terjadi' => $tanggal_terjadi[$key],
            'latitude' => $latitude[$key],
            'longitude' => $longitude[$key],
            'komoditi' => $komoditi[$key],
            'kat' => $value,
            'id_pertanahan' => $id_kat_pertanahan,
            'kategorisasi' => $kategorisasi
          );
          $this->model_jenis_dokumen->tambah_jenis_dokumen($data1,'gap_kat_pertanahan');
        }elseif ($tanah_belum_digarap==2) {
          $data1 = array(
            'luas' => '-',
            'tanggal_terjadi' => '-',
            'latitude' => '-',
            'longitude' => '-',
            'komoditi' => '-',
            'kat' => '-',
            'id_pertanahan' => $id_kat_pertanahan
          );
          $this->model_jenis_dokumen->tambah_jenis_dokumen($data1,'gap_kat_pertanahan');
        }
      }else {
        $data1 = array(
          'luas' => $luas[$key],
          'tanggal_terjadi' => $tanggal_terjadi[$key],
          'latitude' => $latitude[$key],
          'longitude' => $longitude[$key],
          'subjek' => $subjek[$key-1],
          'kerugian' => $kerugian[$key-1],
          'komoditi' => $komoditi[$key],
          'kat' => $value,
          'id_pertanahan' => $id_kat_pertanahan
        );
        $this->model_jenis_dokumen->tambah_jenis_dokumen($data1,'gap_kat_pertanahan');
      }
     
    }
    
    redirect('c_gap_pertanahan/index');
    
  }
  public function edit_pertanahan($id_pertanahan)
  {
    $id_bagian = $this->session->userdata('bagian');
    $username = $this->session->userdata('username');

    $query_lsm= $this->db->query("SELECT * FROM gap_master_lsm ");
    $data['master_lsm'] = $query_lsm->result_array();
    if ($username == 'admin') {
      $query_hgu= $this->db->query("SELECT * FROM gap_master_hgu ");
      $data['master_hgu'] = $query_hgu->result();
    }else {
      $query_hgu= $this->db->query("SELECT * FROM gap_master_hgu WHERE lokasi_kebun = '$id_bagian'");
    $data['master_hgu'] = $query_hgu->result();
    }
    $where = array('id_pertanahan' =>$id_pertanahan);

    $query_kebun= $this->db->query("SELECT tb_master_bagian.nama_bagian, gap_pertanahan.id_kebun FROM tb_master_bagian 
      LEFT JOIN gap_pertanahan ON tb_master_bagian.id_bagian = gap_pertanahan.id_kebun
      WHERE gap_pertanahan.id_pertanahan = '$id_pertanahan' ");

    $data['kebun'] = $query_kebun->result();
    $data['pilihkebun'] = $this->model_dokumen->tampil_data_kebun()->result();
    $data['pertanahan'] = $this->model_jenis_dokumen->edit_jenis_dokumen($where,'gap_pertanahan')->result();
    $this->load->view('edit-gap_pertanahan',$data);
  }
  public function update_pertanahan()
  {
    $id_kat_tanah = $this->input->post('id_kat_tanah');
    $id_pertanahan = $this->input->post('id_pertanahan');
    $id_kebun = $this->input->post('id_kebun');
    $no_hgu = $this->input->post('no_hgu');
    $id_tanah = $_POST['id_tanah'];
    $data = array(
      'id_kebun' => $id_kebun,
      'no_hgu' => $no_hgu
    );
        $where = array('id_pertanahan' => $id_pertanahan);
        $this->model_dokumen->update_dokumen($where,$data,'gap_pertanahan');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');

        redirect('c_gap_pertanahan/index');
  }
  public function nonaktif()
	{
        $status       = '1';
        $id_delete = $this->input->post('id_delete');

        $data = array(
            'status' => $status
        );
        $where = array('id_pertanahan' => $id_delete);
        $this->model_dokumen->update_dokumen($where,$data,'gap_pertanahan');
        $this->session->set_flashdata('something2', 'Pesan Terkirim');

        redirect('c_gap_pertanahan/index');
  }
  public function aktif()
	{
        $status       = '0';
        $id_delete = $this->input->post('id_delete');

        $data = array(
            'status' => $status
        );
        $where = array('id_pertanahan' => $id_delete);
        $this->model_dokumen->update_dokumen($where,$data,'gap_pertanahan');
        $this->session->set_flashdata('something3', 'Pesan Terkirim');
        redirect('c_gap_pertanahan/index');
  }
  public function load_status_surat()
  {
      $status_surat = $_GET['status_surat'];
      $idkebun = $this->session->userdata('bagian');
      $username = $this->session->userdata('username');
      
      if ($status_surat == 'aktif' && $username == 'admin') {
        $query_pertanahan= $this->db->query("SELECT * FROM gap_pertanahan WHERE status='0' ORDER BY id_pertanahan DESC ");
        $query_kebun = $this->db->query("SELECT nama_bagian FROM tb_master_bagian WHERE id_bagian = '$idkebun'");
        $data['kebun'] = $query_kebun->result_array();
        $data['pertanahan'] = $query_pertanahan->result_array();
          
      }elseif ($status_surat == 'aktif' && $username != 'admin') {
          $query_pertanahan= $this->db->query("SELECT * FROM gap_pertanahan WHERE status='0' AND id_kebun='$idkebun' ORDER BY id_pertanahan DESC");
          $query_kebun = $this->db->query("SELECT nama_bagian FROM tb_master_bagian WHERE id_bagian = '$idkebun'");
          $data['kebun'] = $query_kebun->result_array();
          $data['pertanahan'] = $query_pertanahan->result_array();
          
      }elseif ($status_surat == 'nonaktif' && $username == 'admin') {
          $query_pertanahan= $this->db->query("SELECT * FROM gap_pertanahan WHERE status='1' ORDER BY id_pertanahan DESC");
          $query_kebun = $this->db->query("SELECT nama_bagian FROM tb_master_bagian WHERE id_bagian = '$idkebun'");
          $data['kebun'] = $query_kebun->result_array();
          $data['pertanahan'] = $query_pertanahan->result_array();
          
      }elseif ($status_surat == 'nonaktif' && $username != 'admin') {
        $query_pertanahan= $this->db->query("SELECT * FROM gap_pertanahan WHERE status='1' AND id_kebun='$idkebun' ORDER BY id_pertanahan DESC");
        $query_kebun = $this->db->query("SELECT nama_bagian FROM tb_master_bagian WHERE id_bagian = '$idkebun'");
        $data['kebun'] = $query_kebun->result_array();
        $data['pertanahan'] = $query_pertanahan->result_array();
        
      }    

      $data['user'] = $this->model_dokumen->tampil_data_user()->result_array();

      $no=0;
      foreach ($data['pertanahan'] as $key => $li) :
      $no++;
      ?>
      <tr >
          <td rowspan="8"><?php echo $no ?></td>
          <td rowspan="8"><?php $sub_kalimat = substr($li['no_hgu'],0,25); echo $sub_kalimat ?>...</td>
          <td  rowspan="8">
            <?php 
            foreach ($data['kebun'] as $pt) :
              echo $pt['nama_bagian'];
            endforeach;

            // $kebun = count($data['user']);
            // for ($i=0; $i < $kebun; $i++) { 
            //   if ( $data['user'][$i]['id'] == $li['id_kebun']) {
            //     echo $data['user'][$i]['username'];
            //   }
            // }
            ?>
          </td>
              <tr><td>Luas :</td> 
                <td class="div_<?=$key?>">-</td>
                <?php
                $id_pert = $li['id_pertanahan'];
                $query_ket_pertanahan= $this->db->query("SELECT *  FROM gap_kat_pertanahan
                  WHERE id_pertanahan = '$id_pert'");
                    $data['ket_tanah'] = $query_ket_pertanahan->result_array();
                    $jumlah =  count($data['ket_tanah']);
                foreach ( $data['ket_tanah'] as $nh) : ?>
                  <td>
                    <?php 
                      if ($nh['id_pertanahan'] == $li['id_pertanahan'] && $nh['kat']== '1') {
                    ?>
                    
                    <?php echo $nh['luas'] ?>
                  
                      <?php }else{ ?>
                        <?php echo $nh['luas'] ?>
                      <?php } ?> 
                  </td>
                <?php endforeach;?>
                <?php if ( $li['status'] == 0) {
                 ?>
                <td rowspan="8">
                  <?php echo anchor('c_gap_pertanahan/form_detail_pertanahan/'.$li['id_pertanahan'], '<button type="button" class="btn  btn-warning btn-sm mb-2" title="Detail"><i class="fas fa-exclamation-circle" style="color:white;"></i></button>') ?>
                  <?php echo anchor('c_gap_pertanahan/edit_pertanahan/'.$li['id_pertanahan'], '<button type="button" class="btn  btn-primary btn-sm mb-2" title="Edit"><i class="far fa-edit"></i></button>') ?>
                  <button type="button" class="btn  btn-danger btn-sm mb-2 ml-3" data-toggle="modal" data-target="#modalhapus" title="Non Aktif" name="<?= $li['id_pertanahan'];?>" onClick="reply_click1(this.name)"><i class="far fa-times-circle"></i></button>
                </td>
                <?php }else { ?>
                <td rowspan="8">
                 <button type="button" class="btn  btn-success btn-sm " data-toggle="modal" data-target="#modalaktif" title=" Aktif" name="<?= $li['id_pertanahan'];?>" onClick="reply_click(this.name)"><i class="far fa-times-circle"></i></button>
                </td>
                <?php } ?>

              </tr>
              <tr><td>Tanggal Terjadi :</td> 
                <td class="div_<?=$key?>">-</td>
                <?php foreach ( $data['ket_tanah'] as $nh) : ?>
                  <td>
                    <?php 
                      if ($nh['id_pertanahan'] == $li['id_pertanahan'] && $nh['kat']== '1') {
                    ?>
                    
                    <?php echo $nh['tanggal_terjadi'] ?>
                  
                      <?php }else{ ?>
                        <?php echo $nh['tanggal_terjadi'] ?>
                      <?php } ?> 
                  </td>
                <?php endforeach;?>
              </tr>
              <tr><td>Latitude  :  </td>
                <td class="div_<?=$key?>">-</td>
                <?php foreach ( $data['ket_tanah'] as $nh) : ?>
                  <td>
                    <?php 
                      if ($nh['id_pertanahan'] == $li['id_pertanahan'] && $nh['kat']== '1') {
                    ?>
                    
                    <?php echo $nh['latitude'] ?>
                  
                      <?php }else{ ?>
                        <?php echo $nh['latitude'] ?>
                      <?php } ?> 
                  </td>
                <?php endforeach;?>
              </tr>
              <tr><td>Longitude :  </td>
                <td class="div_<?=$key?>">-</td>
                <?php foreach ( $data['ket_tanah'] as $nh) : ?>
                  <td>
                    <?php 
                      if ($nh['id_pertanahan'] == $li['id_pertanahan'] && $nh['kat']== '1') {
                    ?>
                    
                    <?php echo $nh['longitude'] ?>
                  
                      <?php }else{ ?>
                        <?php echo $nh['longitude'] ?>
                      <?php } ?> 
                  </td>
                <?php endforeach;?>
              </tr>
              <tr><td>Subjek  :  </td>
                <td class="div_<?=$key?>">-</td>
                <?php foreach ( $data['ket_tanah'] as $nh) : ?>
                  <td>
                    <?php 
                      if ($nh['id_pertanahan'] == $li['id_pertanahan'] && $nh['kat']== '1') {
                    ?>
                    
                    <?php echo $nh['subjek'] ?>
                  
                      <?php }else{ ?>
                        <?php echo $nh['subjek'] ?>
                      <?php } ?> 
                  </td>
                <?php endforeach;?>
              </tr>
              <tr><td>Kerugian  :  </td>
                <td class="div_<?=$key?>">-</td>
                <?php foreach ( $data['ket_tanah'] as $nh) : ?>
                  <td>
                    <?php 
                      if ($nh['id_pertanahan'] == $li['id_pertanahan'] && $nh['kat']== '1') {
                    ?>
                    
                    <?php echo $nh['kerugian'] ?>
                  
                      <?php }else{ ?>
                        <?php echo $nh['kerugian'] ?>
                      <?php } ?> 
                  </td>
                <?php endforeach;?>
              </tr>
              <tr><td>Komoditi  :  </td>
                <td class="div_<?=$key?>">-</td>
                <?php foreach ( $data['ket_tanah'] as $nh) : ?>
                  <td>
                    <?php 
                      if ($nh['id_pertanahan'] == $li['id_pertanahan'] && $nh['kat']== '1') {
                    ?>
                    
                    <?php echo $nh['komoditi'] ?>
                  
                      <?php }else{ ?>
                        <?php echo $nh['komoditi'] ?>
                      <?php } ?> 
                  </td>
                <?php endforeach;?>
              </tr>
           
      </tr> 
      

      
          
          <?php
          if ($jumlah == 4) {
        ?>
        <script>
          
              $(".div_<?=$key?>").hide();
          
        </script>
        <?php }if ($jumlah == 3) { ?>
          <script>
          
          $(".div_<?=$key?>").show();
          
        </script>
          <?php } ?>

      
      <?php endforeach;

                          
  }
  public function form_detail_pertanahan($id)
  {
    $detailpertanahan = $this->db->query("SELECT * FROM gap_pertanahan 
    LEFT JOIN gap_kat_pertanahan ON gap_pertanahan.id_pertanahan = gap_kat_pertanahan.id_pertanahan
    WHERE gap_pertanahan.id_pertanahan = '$id' ORDER BY gap_pertanahan.id_pertanahan DESC");
    $data['pertanahan'] = $detailpertanahan->result_array();
    $kondisi_saat_ini_tbd = $this->db->query("SELECT * FROM gap_kat_pertanahan 
    WHERE id_pertanahan = '$id' AND kat = '1' ORDER BY id_kat_tanah DESC ");
    $kondisi_saat_ini_o = $this->db->query("SELECT * FROM gap_kat_pertanahan 
    WHERE id_pertanahan = '$id' AND kat = '2' ORDER BY id_kat_tanah DESC ");
    $kondisi_saat_ini_tt = $this->db->query("SELECT * FROM gap_kat_pertanahan 
    WHERE id_pertanahan = '$id' AND kat = '3' ORDER BY id_kat_tanah DESC ");
    $kondisi_saat_ini_pl = $this->db->query("SELECT * FROM gap_kat_pertanahan 
    WHERE id_pertanahan = '$id' AND kat = '4' ORDER BY id_kat_tanah DESC ");
    $data['kondisi_saat_ini_tbd'] = $kondisi_saat_ini_tbd->result_array();
    $data['kondisi_saat_ini_o'] = $kondisi_saat_ini_o->result_array();
    $data['kondisi_saat_ini_tt'] = $kondisi_saat_ini_tt->result_array();
    $data['kondisi_saat_ini_pl'] = $kondisi_saat_ini_pl->result_array();
    $query_hgu= $this->db->query("SELECT * FROM gap_master_hgu ");
    $data['nomor_hgu'] = $query_hgu->result_array();
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar');
      $this->load->view('detail-gap_pertanahan',$data);
      $this->load->view('templates/footer');
  }
  public function tambah_detail_pertanahan()
  {
    $luas = $this->input->post('luas');
    $tanggal_terjadi = $this->input->post('tanggal_terjadi');
    $latitude = $this->input->post('latitude');
    $longitude = $this->input->post('longitude');
    $subjek = $this->input->post('subjek');
    $kerugian = $this->input->post('kerugian');
    $komoditi = $this->input->post('komoditi');
    $kondisi_saat_ini = $this->input->post('kondisi_saat_ini');
    $ket = $this->input->post('ket');
    $cnvrt_tanggal_update = date('Y-m-d', strtotime($tanggal_terjadi));
    $id_pertanahan = $this->input->post('id_pertanahan');
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
      'luas' => $luas,
      'tanggal_terjadi' => $cnvrt_tanggal_update,
      'latitude' => $latitude,
      'longitude' => $longitude,
      'subjek' => $subjek,
      'kerugian' => $kerugian,
      'komoditi' => $komoditi,
      'kat' => $ket,
      'kondisi_saat_ini' => $kondisi_saat_ini,
      'upload_dokumen' =>  $upload_dokumen,
      'id_pertanahan' => $id_pertanahan
    );
        $this->model_jenis_dokumen->tambah_jenis_dokumen($data, 'gap_kat_pertanahan');
        $this->session->set_flashdata('something', 'Pesan Terkirim');
        redirect('c_gap_pertanahan/form_detail_pertanahan/'.$id_pertanahan);
  }
  public function update_detail_pertanahan()
  {
    $id_kat_tanah = $this->input->post('id_kat_tanah');
    $luas = $this->input->post('luas');
    $tanggal_terjadi = $this->input->post('tanggal_terjadi');
    $latitude = $this->input->post('latitude');
    $longitude = $this->input->post('longitude');
    $subjek = $this->input->post('subjek');
    $kerugian = $this->input->post('kerugian');
    $komoditi = $this->input->post('komoditi');
    $kondisi_saat_ini = $this->input->post('kondisi_saat_ini');
    $kat = $this->input->post('kat');
    $cnvrt_tanggal_update = date('Y-m-d', strtotime($tanggal_terjadi));
    $id_pertanahan = $this->input->post('id_pertanahan');
    $upload_dokumen = $_FILES['upload_dokumen']['name'];
    $cvt_upload_dokumen = implode(",", $upload_dokumen);
    $upload_dokument = $this->input->post('upload_dokument');
    if ($upload_dokumen[0] == null) {
        $data = array(
          'luas' => $luas,
          'tanggal_terjadi' => $cnvrt_tanggal_update,
          'latitude' => $latitude,
          'longitude' => $longitude,
          'subjek' => $subjek,
          'kerugian' => $kerugian,
          'komoditi' => $komoditi,
          'kat' => $kat,
          'kondisi_saat_ini' => $kondisi_saat_ini,
          'upload_dokumen' =>  $upload_dokument,
          'id_pertanahan' => $id_pertanahan
        );
        $where = array('id_kat_tanah' => $id_kat_tanah);
        $this->model_dokumen->update_dokumen($where,$data,'gap_kat_pertanahan');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');
        redirect('c_gap_pertanahan/form_detail_pertanahan/'.$id_pertanahan);
    }else {
      $jumlah = count($upload_dokumen);
      for ($i=0; $i < $jumlah; $i++) { 
        $gantinama[] = date('His').$upload_dokumen[$i];
      }
      $cvt_upload_dokumen = implode(",", $gantinama);
      $date = new DateTime();
      $format_file = array("jpg", "png", "pdf","xls");
      $path = "uploads/"; // Lokasi folder untuk menampung file
      $count = 0;
      if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
        // Loop $_FILES to exeicute all files
        foreach ($_FILES['upload_dokumen']['name'] as $f => $name) {     
            if ($_FILES['upload_dokumen']['error'][$f] == 4) {
                continue; // Skip file if any error found
            }	       
            if ($_FILES['upload_dokumen']['error'][$f] == 0) {	           
                      $destinationFileName = date('His').$name;
                    if(move_uploaded_file($_FILES["upload_dokumen"]["tmp_name"][$f], $path.$destinationFileName))
                    $count++; // Number of successfully uploaded file
            }
            
        }
      }
      $data = array(
        'luas' => $luas,
        'tanggal_terjadi' => $cnvrt_tanggal_update,
        'latitude' => $latitude,
        'longitude' => $longitude,
        'subjek' => $subjek,
        'kerugian' => $kerugian,
        'komoditi' => $komoditi,
        'kat' => $kat,
        'kondisi_saat_ini' => $kondisi_saat_ini,
        'upload_dokumen' =>  $upload_dokumen,
        'id_pertanahan' => $id_pertanahan
      );
        $where = array('id_kat_tanah' => $id_kat_tanah);
        $this->model_dokumen->update_dokumen($where,$data,'gap_kat_pertanahan');
        $this->session->set_flashdata('something1', 'Pesan Terkirim');
        redirect('c_gap_pertanahan/form_detail_pertanahan/'.$id_pertanahan);
      }
    
  }
  public function salin_data_detail()
  {
    $tab_mana = $this->input->post('tab_mana');
    $id_pertanahan = $this->input->post('id_pertanahan');
    $salin_data = $this->db->query("SELECT * FROM gap_kat_pertanahan 
    WHERE id_pertanahan = '$id_pertanahan' AND kat = '$tab_mana' ORDER BY id_kat_tanah DESC ");
    $data['salin_data'] = $salin_data->result_array();

    echo json_encode($data['salin_data']);
  }
  function get_subjek(){
    $datasubjek = $this->db->query("SELECT * FROM gap_master_lsm ");
    $data['data_subjek'] = $datasubjek->result();
    echo json_encode($data);
}
  
}