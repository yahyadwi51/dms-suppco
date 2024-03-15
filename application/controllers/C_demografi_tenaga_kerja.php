<?php
class C_demografi_tenaga_kerja extends CI_Controller
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
  }
  public function index()
  {
    $id = $this->session->userdata('id');
    $bagian = $this->session->userdata('bagian');
    $karywantetapkeb = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_jenis_t_n = '1' AND id_kebun = '$bagian'");
    $pktwkeb = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_jenis_t_n = '2' AND id_kebun = '$bagian'");
    $hariankeb = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_jenis_t_n = '3' AND id_kebun = '$bagian'");
    $karywantetappab = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_demografi_t_k = '4'");
    $pktwpab = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_demografi_t_k = '5'");
    $harianpab = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_demografi_t_k = '6'");

    $data['karywantetapkeb'] = $karywantetapkeb->result_array();
    $data['pktwkeb'] = $pktwkeb->result_array();
    $data['hariankeb'] = $hariankeb->result_array();
    $data['karywantetappab'] = $karywantetappab->result_array();
    $data['pktwpab'] = $pktwpab->result_array();
    $data['harianpab'] = $harianpab->result_array();
    $query_kebun= $this->db->query("SELECT * FROM tb_master_bagian ");
    $data['kebun'] = $query_kebun->result_array();
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('gap_demografi_tk', $data);
    $this->load->view('templates/footer');
  }
  public function edit_demografi($id)
  {
    $where = array('id_demografi_t_k' => $id);
    $data['data_demograf'] = $this->model_jenis_dokumen->edit_jenis_dokumen($where, 'gap_demografi_t_k')->result();

    $this->load->view('edit-gap_demografi_tk', $data);
  }
  public function update_demografi()
  {
    $id_demografi_t_k       = $this->input->post('id_demografi_t_k');

    $sd_l       = $this->input->post('sd_l');
    $sd_p       = $this->input->post('sd_p');
    $smp_l       = $this->input->post('smp_l');
    $smp_p       = $this->input->post('smp_p');
    $sma_l       = $this->input->post('sma_l');
    $sma_p       = $this->input->post('sma_p');
    $sarjana_l       = $this->input->post('sarjana_l');
    $sarjana_p       = $this->input->post('sarjana_p');
    $s2_l       = $this->input->post('s2_l');
    $s2_p       = $this->input->post('s2_p');
    $id_jenis_t_n       = $this->input->post('id_jenis_t_n');
    $tanggal       = $this->input->post('tanggal');
    $cnvrt_tanggal_update = date('Y-m-d', strtotime($tanggal));

    $data = array(
      'sd_l' => $sd_l,
      'sd_p' => $sd_p,
      'smp_l' => $smp_l,
      'smp_p' => $smp_p,
      'sma_l' => $sma_l,
      'sma_p' => $sma_p,
      'sarjana_l' => $sarjana_l,
      'sarjana_p' => $sarjana_p,
      's2_l' => $s2_l,
      's2_p' => $s2_p
    );
    $data1 = array(
        'id_demografi_t_k' => $id_demografi_t_k,
        'tanggal' => $cnvrt_tanggal_update,
        'sd_l' => $sd_l,
        'sd_p' => $sd_p,
        'smp_l' => $smp_l,
        'smp_p' => $smp_p,
        'sma_l' => $sma_l,
        'sma_p' => $sma_p,
        'sarjana_l' => $sarjana_l,
        'sarjana_p' => $sarjana_p,
        's2_l' => $s2_l,
        's2_p' => $s2_p
      );
    $where = array('id_demografi_t_k' => $id_demografi_t_k);
    $this->model_dokumen->update_dokumen($where, $data, 'gap_demografi_t_k');
    $this->model_jenis_dokumen->tambah_jenis_dokumen($data1, 'gap_histori_demografi');
    $this->session->set_flashdata('something1', 'Pesan Terkirim');
    redirect('c_demografi_tenaga_kerja/index');
    
  }
  public function detail_demografi($id_demo) {
    $dtl_demo = $this->db->query("SELECT * FROM `gap_histori_demografi` WHERE id_demografi_t_k = $id_demo");
    $data['detail_demografi'] = $dtl_demo->result_array();
    
    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('detail-demografi', $data);
    $this->load->view('templates/footer');
  }
  public function load_status_surat()
  {
      $id_kebun = $_GET['id_kebun'];
      $idkebun = $this->session->userdata('id');
      $username = $this->session->userdata('username');
      $role_id = $this->session->userdata('role_id');
          
      if ($role_id == '1') {
        $karywantetapkeb = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_jenis_t_n = '1' AND id_kebun = '$id_kebun'");
        $pktwkeb = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_jenis_t_n = '2' AND id_kebun = '$id_kebun' ");
        $hariankeb = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_jenis_t_n = '3' AND id_kebun = '$id_kebun'");
        $karywantetappab = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_jenis_t_n = '4' AND id_kebun = '$id_kebun'");
        $pktwpab = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_jenis_t_n = '5' AND id_kebun = '$id_kebun'");
        $harianpab = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_jenis_t_n = '6' AND id_kebun = '$id_kebun'");
        $data['karywantetapkeb'] = $karywantetapkeb->result_array();
        $data['pktwkeb'] = $pktwkeb->result_array();
        $data['hariankeb'] = $hariankeb->result_array();
        $data['karywantetappab'] = $karywantetappab->result_array();
        $data['pktwpab'] = $pktwpab->result_array();
        $data['harianpab'] = $harianpab->result_array();
      }else{
          $karywantetapkeb = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_jenis_t_n = '1' AND id_kebun = '$idkebun'");
          $pktwkeb = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_jenis_t_n = '2' AND id_kebun = '$idkebun' ");
          $hariankeb = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_jenis_t_n = '3' AND id_kebun = '$idkebun'");
          $karywantetappab = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_jenis_t_n = '4' AND id_kebun = '$idkebun'");
          $pktwpab = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_jenis_t_n = '5' AND id_kebun = '$idkebun'");
          $harianpab = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_jenis_t_n = '6' AND id_kebun = '$idkebun'");
          $data['karywantetapkeb'] = $karywantetapkeb->result_array();
          $data['pktwkeb'] = $pktwkeb->result_array();
          $data['hariankeb'] = $hariankeb->result_array();
          $data['karywantetappab'] = $karywantetappab->result_array();
          $data['pktwpab'] = $pktwpab->result_array();
          $data['harianpab'] = $harianpab->result_array();
      }
        $no=0;
        foreach ( $data['karywantetapkeb'] as $ip) :
        $no++;
      ?>
      <tr>
          <td>1.</td>
          <td>Karyawan Tetap</td>
          <td><?php echo $ip['sd_l']?></td>
          <td><?php echo $ip['sd_p']?></td>
          <td><?php echo $ip['smp_l']?></td>
          <td><?php echo $ip['smp_p']?></td>
          <td><?php echo $ip['sma_l']?></td>
          <td><?php echo $ip['sma_p']?></td>
          <td><?php echo $ip['sarjana_l']?></td>
          <td><?php echo $ip['sarjana_p']?></td>
          <td><?php echo $ip['s2_l']?></td>
          <td><?php echo $ip['s2_p']?></td>
          <td><?php 
              $jumlaki = $ip['sd_l'] + $ip['smp_l'] + $ip['sma_l'] + $ip['sarjana_l'] + $ip['s2_l']  ;
              echo $jumlaki?></td>
          <td><?php 
              $jumperem = $ip['sd_p'] + $ip['smp_p'] + $ip['sma_p'] + $ip['sarjana_p'] + $ip['s2_p']  ; 
              echo $jumperem?></td>
          <td>
          <?php echo anchor('c_demografi_tenaga_kerja/detail_demografi/'.$ip['id_demografi_t_k'], '<button type="button" class="btn  btn-warning btn-sm mb-2" title="Edit"><i class="fas fa-info-circle" style="color:white;"></i></button>') ?>
          <?php echo anchor('c_demografi_tenaga_kerja/edit_demografi/'.$ip['id_demografi_t_k'], '<button type="button" class="btn  btn-primary btn-sm mb-2" title="Edit"><i class="far fa-edit"></i></button>') ?>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php
        $no=0;
        foreach ($data['pktwkeb'] as $ip) :
        $no++;
      ?>
      <tr>
          <td>2.</td>
          <td>PKWT</td>
          <td><?php echo $ip['sd_l']?></td>
          <td><?php echo $ip['sd_p']?></td>
          <td><?php echo $ip['smp_l']?></td>
          <td><?php echo $ip['smp_p']?></td>
          <td><?php echo $ip['sma_l']?></td>
          <td><?php echo $ip['sma_p']?></td>
          <td><?php echo $ip['sarjana_l']?></td>
          <td><?php echo $ip['sarjana_p']?></td>
          <td><?php echo $ip['s2_l']?></td>
          <td><?php echo $ip['s2_p']?></td>
          <td><?php 
              $jumlaki = $ip['sd_l'] + $ip['smp_l'] + $ip['sma_l'] + $ip['sarjana_l'] + $ip['s2_l']  ;
              echo $jumlaki?></td>
          <td><?php 
              $jumperem = $ip['sd_p'] + $ip['smp_p'] + $ip['sma_p'] + $ip['sarjana_p'] + $ip['s2_p']  ; 
              echo $jumperem?></td>
          <td>
          <?php echo anchor('c_demografi_tenaga_kerja/detail_demografi/'.$ip['id_demografi_t_k'], '<button type="button" class="btn  btn-warning btn-sm mb-2" title="Edit"><i class="fas fa-info-circle" style="color:white;"></i></button>') ?>
          <?php echo anchor('c_demografi_tenaga_kerja/edit_demografi/'.$ip['id_demografi_t_k'], '<button type="button" class="btn  btn-primary btn-sm mb-2" title="Edit"><i class="far fa-edit"></i></button>') ?>
        </td>
      </tr>
      <?php endforeach; ?>
      <?php
        $no=0;
        foreach ($data['hariankeb'] as $ip) :
        $no++;
      ?>
      <tr>
          <td>3.</td>
          <td>Harian Lepas</td>
          <td><?php echo $ip['sd_l']?></td>
          <td><?php echo $ip['sd_p']?></td>
          <td><?php echo $ip['smp_l']?></td>
          <td><?php echo $ip['smp_p']?></td>
          <td><?php echo $ip['sma_l']?></td>
          <td><?php echo $ip['sma_p']?></td>
          <td><?php echo $ip['sarjana_l']?></td>
          <td><?php echo $ip['sarjana_p']?></td>
          <td><?php echo $ip['s2_l']?></td>
          <td><?php echo $ip['s2_p']?></td>
          <td><?php 
              $jumlaki = $ip['sd_l'] + $ip['smp_l'] + $ip['sma_l'] + $ip['sarjana_l'] + $ip['s2_l']  ;
              echo $jumlaki?></td>
          <td><?php 
              $jumperem = $ip['sd_p'] + $ip['smp_p'] + $ip['sma_p'] + $ip['sarjana_p'] + $ip['s2_p']  ; 
              echo $jumperem?></td>
          <td>
          <?php echo anchor('c_demografi_tenaga_kerja/detail_demografi/'.$ip['id_demografi_t_k'], '<button type="button" class="btn  btn-warning btn-sm mb-2" title="Edit"><i class="fas fa-info-circle" style="color:white;"></i></button>') ?>
          <?php echo anchor('c_demografi_tenaga_kerja/edit_demografi/'.$ip['id_demografi_t_k'], '<button type="button" class="btn  btn-primary btn-sm mb-2" title="Edit"><i class="far fa-edit"></i></button>') ?>
        </td>
      </tr>
      <?php endforeach; ?><?php               
  }
}