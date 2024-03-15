<?php
error_reporting(0);
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
use setasign\Fpdi\PdfParser\StreamReader;


class C_data_dokumen extends CI_Controller
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
    $nama = $this->session->userdata('username');
    $role_id = $this->session->userdata('role_id');

    $query_dokumen = $this->db->query("SELECT *,tb_dokumen.id AS iddkm FROM tb_dokumen 
      LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
      LEFT JOIN tb_master_bagian ON tb_dokumen.bag_or_keb = tb_master_bagian.id_bagian
      LEFT JOIN tb_master_jenis_dok ON tb_dokumen.jenis_dok = tb_master_jenis_dok.id
      WHERE tb_dokumen.bag_or_keb = '$bagian' AND tb_dokumen.akses_for LIKE '%$id%'  ORDER BY iddkm DESC");
    $query_permintaan_download = $this->db->query("SELECT COUNT(*) AS jn FROM tb_dokumen 
      LEFT JOIN tb_master_jenis_dok ON tb_dokumen.jenis_dok = tb_master_jenis_dok.id
      LEFT JOIN histori_download_dokumen ON tb_dokumen.id = histori_download_dokumen.id_dokumen
      LEFT JOIN tb_user ON tb_dokumen.akses_for = tb_user.id
      WHERE tb_dokumen.id_user = '$id' && histori_download_dokumen.status = 'Request'");
    
    $master_jenis_dokumen = $this->db->query("SELECT * FROM `tb_master_jenis_dok`");
    $data['master_jenis_dokumen'] = $master_jenis_dokumen->result_array();
    $data['master_bagian'] = $this->model_dokumen->tampil_data_bagian_kebun()->result();

    $data['data_dokumen'] = $query_dokumen->result_array();
    $data['jumlahnotifikasi'] = $query_permintaan_download->result_array();
    $data['user'] = $this->model_dokumen->tampil_data_user()->result();
    $query_notif = $this->db->query("SELECT *,tb_dokumen.id AS iddkm FROM tb_dokumen 
      LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id");
    $data1['query_notif'] = $query_notif->result_array();
    foreach ($data1['query_notif'] as $row) {
      $id_dkm = $row['iddkm'];
      $format_tgl = date('d-m-Y', strtotime($row['masa_aktif_akhir']));
      $hari = $row['durasi_tgl'];
      $bulan = $row['durasi_bulan'];
      $tahun = $row['durasi_tahun'];
      $tgl1    = $format_tgl;
      $tgl2    = date('d-m-Y', strtotime('-' . $hari . ' days', strtotime($tgl1)));
      $tgl3    = date('d-m-Y', strtotime('-' . $bulan . ' month', strtotime($tgl2)));
      $tgl4    = date('d-m-Y', strtotime('-' . $tahun . ' year', strtotime($tgl3)));
      $skrng   = date("d-m-Y");
      // print_r ($row['nama_dokumen'].'/');
      // print_r ($tgl4.'/');
      // print_r ($skrng.'<br>');
      if ($row['akses_for'] == $bagian && $row['notif_hak_akses'] == '0'){
        $notifikasi  = '1';
        $datahakakses = array(
          'notif_hak_akses' => $notifikasi,
        );
        $where = array('id' => $id_dkm);
        $this->model_dokumen->update_dokumen($where, $datahakakses, 'tb_dokumen');
      }
      if ($row['pic'] == $id && $row['notif_pic'] == '0' && $row['pengingat'] == '1'){
        $notifikasi  = '1';
        $datahakakses = array(
          'notif_pic' => $notifikasi,
        );
        $where = array('id' => $id_dkm);
        $this->model_dokumen->update_dokumen($where, $datahakakses, 'tb_dokumen');
      }
      if (strtotime($tgl4) <= strtotime($skrng) ) {
        $pengingat  = '1';
        $data3 = array(
          'pengingat' => $pengingat,
          'status_dokumen' => 'Akan kadaluarsa'
        );
        $where = array('id' => $id_dkm);
        $this->model_dokumen->update_dokumen($where, $data3, 'tb_dokumen');
      }elseif (strtotime($format_tgl) <= strtotime($skrng) ) {
        $pengingat  = '2';
        $data3 = array(
          'pengingat' => $pengingat,
          'status_dokumen' => 'Kadaluarsa'
        );
        $where = array('id' => $id_dkm);
        $this->model_dokumen->update_dokumen($where, $data3, 'tb_dokumen');
      }

      if (strtotime($tgl4) > strtotime($skrng) ){
        $pengingat  = '0';
        $data3 = array(
          'pengingat' => $pengingat,
          'status_dokumen' => 'Aktif'
        );
        $where = array('id' => $id_dkm);
        $this->model_dokumen->update_dokumen($where, $data3, 'tb_dokumen');
      }elseif (strtotime($format_tgl) <= strtotime($skrng) ) {
        $pengingat  = '2';
        $data3 = array(
          'pengingat' => $pengingat,
          'status_dokumen' => 'Kadaluarsa'
        );
        $where = array('id' => $id_dkm);
        $this->model_dokumen->update_dokumen($where, $data3, 'tb_dokumen');
      } 
    }


    $this->load->view('templates/header', $data);
    if($role_id == 3){
      $this->load->view('templates/sidebar_pengadaan');
    } else{
      $this->load->view('templates/sidebar');
    }
    $this->load->view('data_dokumen', $data);
    $this->load->view('templates/footer');
  }

  public function load_jenis_data_dokumen()
  {

    $status_dokumen = $_GET['status_dokumen'];
    $jenis_dokumen = $_GET['jenis_dokumen'];
    $bag_pemilik = $_GET['bag_pemilik'];
    $reservation = $_GET['reservation'];
    $id = $this->session->userdata('id');
    $nama = $this->session->userdata('username');
    $bagian = $this->session->userdata('bagian');
    $master_jenis_dokumen = $this->db->query("SELECT * FROM `tb_master_jenis_dok`");
    $data['master_jenis_dokumen'] = $master_jenis_dokumen->result_array();
    $data['master_bagian'] = $this->model_dokumen->tampil_data_bagian_kebun()->result_array();
    $query_dokumen1 = $this->db->query("SELECT * FROM tb_master_bagian");
    $data['datamasterbagian'] = $query_dokumen1->result();
    $data2['user'] = $this->model_dokumen->tampil_data_user()->result();

    $tanggal = explode(" - ", $reservation);
    $format_tgl_awal = $tanggal[0];
    $format_tgl_akhir = $tanggal[1];

    $customRadio1 = $_GET['customRadio1'];
    $customRadio2 = $_GET['customRadio2'];
    $customRadio3 = $_GET['customRadio3'];
    $customRadio4 = $_GET['customRadio4'];
    // print_r($customRadio2);
    // print_r($id);
    // die();
    $check_where = false;
    if($id == 1){
      $where = "";
    }else{
      $where = "WHERE tb_dokumen.bag_or_keb = '$bagian' OR tb_dokumen.akses_for LIKE '%$bagian%' OR tb_dokumen.pic = '$id' ";
    }
    if (!empty($customRadio1) || !empty($customRadio2) || !empty($customRadio3)|| !empty($customRadio4)) {
      if (!empty($customRadio2)) {
        $check_where = true;
        $where = "WHERE tb_dokumen.bag_or_keb = '$customRadio2'";
      }
      if (!empty($customRadio3)) {
        $check_where = true;
        $where = "WHERE tb_dokumen.akses_for LIKE '%$customRadio3%'";
      }
      if (!empty($customRadio4)) {
        $check_where = true;
        $where = "WHERE tb_dokumen.pic = '$customRadio4' && tb_dokumen.bag_or_keb != '$bagian'";
      }
    }
    if (!empty($jenis_dokumen)) {
      $jenis_dokumens = explode(",", $jenis_dokumen);
      $jumlahdata = count($jenis_dokumens);
      $check_js = false;
      foreach ($jenis_dokumens as $jdkm) {
        if ($check_where) {
          if ($check_js) {
            $where = $where . "OR (tb_dokumen.jenis_dok = '$jdkm' AND tb_dokumen.bag_or_keb = '$bagian') OR (tb_dokumen.jenis_dok = '$jdkm' AND tb_dokumen.akses_for LIKE '%$bagian%') OR (tb_dokumen.jenis_dok = '$jdkm' AND tb_dokumen.pic = '$id')";
          } else {
            $where = $where . " AND (tb_dokumen.jenis_dok = '$jdkm'  ";
            $check_js = true;
          }
        } else {
          $check_where = true;
          $check_js = true;
          $where = "WHERE ((tb_dokumen.jenis_dok = '$jdkm' AND tb_dokumen.bag_or_keb = '$bagian') OR (tb_dokumen.jenis_dok = '$jdkm' AND tb_dokumen.akses_for LIKE '%$bagian%') OR (tb_dokumen.jenis_dok = '$jdkm' AND tb_dokumen.pic = '$id') ";
        }
      }
      $where = $where . ')';
    }
    if (!empty($status_dokumen)) {
      $status_dokumens = explode(",", $status_dokumen);
      $check_bp = false;
      foreach ($status_dokumens as $jdkm) {
        if ($check_where) {
          if ($check_bp) {
            $where = $where . "OR (tb_dokumen.status_dokumen = '$jdkm' AND tb_dokumen.bag_or_keb = '$bagian') OR (tb_dokumen.status_dokumen = '$jdkm' AND tb_dokumen.akses_for LIKE '%$bagian%') ";
          } else {
            $check_bp = true;
            $where = $where . "AND (tb_dokumen.status_dokumen = '$jdkm' ";
          }
        } else {
          $check_where = true;
          $check_bp = true;
          $where = "WHERE ((tb_dokumen.status_dokumen = '$jdkm' AND tb_dokumen.bag_or_keb = '$bagian') OR (tb_dokumen.status_dokumen = '$jdkm' AND tb_dokumen.akses_for LIKE '%$bagian%') OR (tb_dokumen.status_dokumen = '$jdkm' AND tb_dokumen.pic = '$id')";
        }
      };
      $where = $where . ')';
    }
    if (!empty($bag_pemilik)) {
      $bag_pemiliks = explode(",", $bag_pemilik);
      $check_bp = false;
      foreach ($bag_pemiliks as $jdkm) {
        if ($check_where) {
          if ($check_bp) {
            $where = $where . "OR (tb_dokumen.bag_or_keb = '$jdkm' AND tb_dokumen.id_user = '$id') OR (tb_dokumen.bag_or_keb = '$jdkm' AND tb_dokumen.akses_for LIKE '%$bagian%') ";
          } else {
            $check_bp = true;
            $where = $where . "AND (tb_dokumen.bag_or_keb = '$jdkm' ";
          }
        } else {
          $check_where = true;
          $check_bp = true;
          $where = "WHERE (tb_dokumen.bag_or_keb = '$jdkm' AND tb_dokumen.bag_or_keb = '$bagian') OR (tb_dokumen.bag_or_keb = '$jdkm' AND tb_dokumen.akses_for LIKE '%$bagian%' ";
        }
      };
      $where = $where . ')';
    }
    if (!empty($reservation)) {
      $now = date("d/m/Y");
      $check_rs = false;
      if ($now == $format_tgl_awal && $now == $format_tgl_akhir) {
        # code...
      } else {
        $replc1 = str_replace("/", "-", $format_tgl_awal);
        $replc2 = str_replace("/", "-", $format_tgl_akhir);
        $crv_tgl_awal = date('Y-m-d', strtotime($replc1));
        $crv_tgl_akhir = date('Y-m-d', strtotime($replc2));
        if ($check_where) {
          if ($check_rs) {
            $where = $where . "OR ((tb_dokumen.masa_aktif_awal BETWEEN '$crv_tgl_awal' AND '$crv_tgl_akhir') OR (tb_dokumen.masa_aktif_akhir BETWEEN '$crv_tgl_awal' AND '$crv_tgl_akhir') AND tb_dokumen.bag_or_keb = '$bagian')  ";
          } else {
            $check_rs = true;
            $where = $where . "AND ((tb_dokumen.masa_aktif_awal BETWEEN '$crv_tgl_awal' AND '$crv_tgl_akhir') OR (tb_dokumen.masa_aktif_akhir BETWEEN '$crv_tgl_awal' AND '$crv_tgl_akhir') ";
          }
        } else {
          $check_where = true;
          $check_rs = true;
          $where = "WHERE (tb_dokumen.bag_or_keb = '$bagian' OR tb_dokumen.akses_for LIKE '%$bagian%' ) AND ((tb_dokumen.masa_aktif_awal BETWEEN '$crv_tgl_awal' AND '$crv_tgl_akhir') OR (tb_dokumen.masa_aktif_akhir BETWEEN '$crv_tgl_awal' AND '$crv_tgl_akhir') ";
        }
        $where = $where . ')';
      }
    }
    $query_dokumen = $this->db->query("SELECT *,tb_dokumen.id AS iddkm FROM tb_dokumen 
      LEFT JOIN tb_master_bagian ON tb_dokumen.bag_or_keb = tb_master_bagian.id_bagian
      LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
      LEFT JOIN tb_master_jenis_dok ON tb_dokumen.jenis_dok = tb_master_jenis_dok.id
      $where ORDER BY iddkm DESC ");
    // echo $where;die();
    $data1['data_dokumen'] = $query_dokumen->result_array();
    $no = 1;
    foreach ($data1['data_dokumen'] as $dd) :
?>
<tr>
    <td><?php echo $no++ ?></td>
    <td><?php echo $dd['nama_dokumen'] ?></td>
    <td><?php echo $dd['nama_jenis_dokumen'] ?></td>
    <td><?php echo $dd['nama_bagian'] ?></td>
    <td>
    <?php foreach ($data2['user'] as $usr) : ?>
        <?php $str =  $dd['pic'];
            $str1 = explode(",", $str);
            $jumlahdata = count($str1);
            for ($i = 0; $i < $jumlahdata; $i++) {
              if ($usr->id == $str1[$i]) {
                echo  $usr->username . '<br>';
              }
            }

            ?>
        <?php endforeach; ?>
    </td>
    <td>
        <?php
          echo  date('d/m/Y', strtotime($dd['masa_aktif_awal']));
          echo ' - ';
          echo date('d/m/Y', strtotime($dd['masa_aktif_akhir']));
          ?>
    </td>

    <td>
        <?php foreach ($data['datamasterbagian'] as $usr) : ?>
        <?php $str = $dd['akses_for'];
            $str1 = explode(",", $str);
            $jumlahdata = count($str1);
            for ($i = 0; $i < $jumlahdata; $i++) {
              if ($usr->id_bagian == $str1[$i]) {
                echo '-' . $usr->nama_bagian . '<br>';
              }
            }

            ?>
        <?php endforeach; ?>
    </td>
    <td><?php echo $dd['status_dokumen'] ?></td>
    <td>
        <?php
          $id = $this->session->userdata('id');
          $bagianfilter = $this->session->userdata('bagian');
          // print_r ('.'.$id.'.');
          // print_r ('.'.$dd['pic'].'.');
          // print_r ('.'.$bagianfilter.'.');
          // print_r ('.'.$dd['bag_or_keb'].'.');
          if ($dd['id_user'] == $id || $dd['bag_or_keb'] == $bagianfilter || $id == '1') {
          ?>
        <?php echo anchor('c_data_dokumen/edit_data_dokumen/' . $dd['iddkm'], '<button type="button" class="btn btn-primary btn-sm mt-2"><i class="far fa-edit" title="Edit"></i></button>') ?><br>
        <?php echo anchor('c_data_dokumen/perbarui_data_dokumen/' . $dd['iddkm'], '<button type="button" class="btn btn-warning btn-sm mt-2" title="Perbarui Masa Aktif"><i class="fas fa-sync" style="color:white;"></i></button>') ?>
        <form action="<?php echo base_url() . 'c_download_dokumen/lakukan_download_pemilik/' . $dd['upload_dokumen'] ?>"
            method="post">
            <div class="input-group input-group-sm mt-2">
                <span class="input-group-append">
                    <button type="submit" class="btn bg-gradient-success btn-sm" title="Download"><i class="fas fa-download"></i></button>
                </span>
            </div>
        </form>
        <button type="button" class="btn  btn-danger btn-sm mt-2" name="<?php echo $dd['iddkm'] ?> " title="Hapus" data-toggle="modal" data-target="#hapus_dokumen" onClick="reply_click1(this.name)"><i class="fas fa-trash"></i></button>
        <?php } elseif($dd['pic'] == $id && $dd['bag_or_keb'] != $bagianfilter){?>
          <button type="button" name="<?php echo $dd['iddkm'] ?>,<?php echo $dd['nama_dokumen'] ?>,<?php echo $dd['no_telp'] ?>,<?php echo $dd['id_telegram'] ?>" onClick="reply_click(this.name)"
            class="btn  bg-gradient-secondary btn-sm mt-2" data-toggle="modal" title="Download"
            data-target="#exampleModal"><i class="fas fa-download"></i></button>
        <?php }else { ?>
        <button type="button" name="<?php echo $dd['iddkm'] ?>,<?php echo $dd['nama_dokumen'] ?>,<?php echo $dd['no_telp'] ?>,<?php echo $dd['id_telegram'] ?>" onClick="reply_click(this.name)"
            class="btn  bg-gradient-success btn-sm mt-2" data-toggle="modal" title="Download"
            data-target="#exampleModal"><i class="fas fa-download"></i></button>
        <?php } ?>
    </td>
</tr>
<?php endforeach; ?><?php
                        }

                        public function form_data_dokumen()
                        {
                          $this->session->set_userdata('halaman', 'data_dokumen');

                          $semua_master_bagian = $this->db->query("SELECT * FROM `tb_master_bagian` where id_bagian != '91' ");
                          $data['master_bagian'] = $semua_master_bagian->result();

                          $jaminan_pelaksana = $this->db->query("SELECT * FROM `tb_master_jenis_dok` where id = '12' ");
                          $data['jampel'] = $jaminan_pelaksana->result();

                          // $jenis_semua_dokumen =  $this->db->query("SELECT * FROM `tb_master_jenis_dok` where id != '12' ");
                          $jenis_semua_dokumen =  $this->db->query("SELECT * FROM `tb_master_jenis_dok`");
                          $data['jenis_dokumen'] = $jenis_semua_dokumen->result();

                          $user_jaminan_pelaksana = $this->db->query("SELECT * FROM `tb_user` where id = '93' ");
                          $data['user_jampel'] = $user_jaminan_pelaksana->result();

                          $semua_user = $this->db->query("SELECT * FROM `tb_user` where id != '93' ");
                          $data['user'] = $semua_user->result();

                          $this->load->view('tambah-data_dokumen', $data);
                        }

                        public function form_data_dokumen_error()
                        {
                          $semua_master_bagian = $this->db->query("SELECT * FROM `tb_master_bagian` where id_bagian != '91' ");
                          $data['master_bagian'] = $semua_master_bagian->result();

                          $jaminan_pelaksana = $this->db->query("SELECT * FROM `tb_master_jenis_dok` where id = '12' ");
                          $data['jampel'] = $jaminan_pelaksana->result();

                          $jenis_semua_dokumen =  $this->db->query("SELECT * FROM `tb_master_jenis_dok` where id != '12' ");
                          $data['jenis_dokumen'] = $jenis_semua_dokumen->result();

                          $user_jaminan_pelaksana = $this->db->query("SELECT * FROM `tb_user` where id = '93' ");
                          $data['user_jampel'] = $user_jaminan_pelaksana->result();

                          $semua_user = $this->db->query("SELECT * FROM `tb_user` where id != '93' ");
                          $data['user'] = $semua_user->result();

                          
                          $this->load->view('tambah-data_dokumen_error', $data);
                        }

                        public function handling_file()
                        {
                          $halaman = $this->session->userdata('halaman');

                          if($halaman == 'data_dokumen'){
                            redirect('c_data_dokumen/form_data_dokumen_error');
                          }
                          else{
                            redirect('c_pengelolah_dokumen_dms/form_data_dokumen_error');
                          }
                        }
                        
                        public function tambah_data_dokumen()
                        {
                          $username = $this->session->userdata('username');
                          $id = $this->session->userdata('id');
                          $role_id = $this->session->userdata('role_id');
                          $bagian = $this->session->userdata('bagian');
                          
                          $cs = $this->input->post('cs');
                          $nama_dokumen = $this->input->post('nama_dokumen');
                          $jenis_dok = $this->input->post('jenis_dok');
                          $bag_or_keb = $this->input->post('bag_or_keb');
                          $drs_tahun = $this->input->post('drs_tahun');
                          $drs_bulan = $this->input->post('drs_bulan');
                          $drs_hari = $this->input->post('drs_hari');
                          $masa_aktif = $this->input->post('masa_aktif');
                          $masa_aktif_pisah = explode(" - ", $masa_aktif);
                          $masa_aktif_awal = $masa_aktif_pisah[0];
                          $masa_aktif_akhir = $masa_aktif_pisah[1];
                          $replc1 = str_replace("/", "-", $masa_aktif_awal);
                          $replc2 = str_replace("/", "-", $masa_aktif_akhir);
                          $cnvrt_masa_aktif_awal = date('Y-m-d', strtotime($replc1));
                          $cnvrt_masa_aktif_akhir = date('Y-m-d', strtotime($replc2));
                          $pic = $this->input->post('pic');
                          $akses_for = $_POST['akses_for'];
                            
                            if ($role_id == 1) {
                            
                            $upload_dokumen = $_FILES['upload_dokumen']['name'];

                            if ($upload_dokumen = '') {
                            } else {
                              $config['upload_path'] = './uploads';
                              $config['allowed_types'] = 'jpg|pdf|png';

                              $this->load->library('upload', $config);
                              if (!$this->upload->do_upload('upload_dokumen')) {
                                echo "Gambar Gagal Upload !";
                              } else {
                                $upload_dokumen = $this->upload->data('file_name');
                              }
                            }

                            $data_session = array(
                              'id_user' => $id,
                              'nama_dokumen' => $nama_dokumen,
                              'bag_or_keb' => $bag_or_keb,
                              'jenis_dok' => $jenis_dok,
                              'masa_aktif' => $masa_aktif,
                              'masa_aktif_awal' => $cnvrt_masa_aktif_awal,
                              'masa_aktif_akhir' => $cnvrt_masa_aktif_akhir,
                              'pic' => $pic,
                              'cs' => $cs,
                              'durasi_tahun' => $drs_tahun,
                              'durasi_bulan' => $drs_bulan,
                              'durasi_tgl' => $drs_hari,
                              'status_dokumen' => 'Aktif',
                              'akses_for' => $akses_for,
                              'upload_dokumen' => $upload_dokumen
                            );
                            $this->session->set_userdata($data_session);
                            
                            require_once(APPPATH.'libraries/fpdf/fpdf.php');
                            require_once(APPPATH.'libraries/fpdi/FPDI/src/autoload.php');
                            //Set the source PDF file
                            $pdf = new Fpdi();

                            // menampilkan hasil curl
                            $fileContent = file_get_contents(base_url('uploads/'.$upload_dokumen));
                            $pageCount = $pdf->setSourceFile(StreamReader::createByString($fileContent));
  
                            $data1 = array(
                              'id_user' => $id,
                              'nama_dokumen' => $nama_dokumen,
                              'bag_or_keb' => $bag_or_keb,
                              'jenis_dok' => $jenis_dok,
                              'masa_aktif_awal' => $cnvrt_masa_aktif_awal,
                              'masa_aktif_akhir' => $cnvrt_masa_aktif_akhir,
                              'pic' => $pic,
                              'cs' => $cs,
                              'durasi_tahun' => $drs_tahun,
                              'durasi_bulan' => $drs_bulan,
                              'durasi_tgl' => $drs_hari,
                              'status_dokumen' => 'Aktif',
                              'akses_for' => implode(",", $akses_for),
                              'upload_dokumen' => $upload_dokumen
                            );
                            $this->model_dokumen->tambah_dokumen($data1, 'tb_dokumen');
                            $this->session->set_flashdata('something', 'Pesan Terkirim');
                            redirect('c_data_dokumen/index');
                          } 
                          elseif ($role_id != 1) {

                            $upload_dokumen = $_FILES['upload_dokumen']['name'];
                            if ($upload_dokumen = '') {
                            } else {
                              $config['upload_path'] = './uploads';
                              $config['allowed_types'] = '*';

                              $this->load->library('upload', $config);
                              if (!$this->upload->do_upload('upload_dokumen')) {
                                echo "Gambar Gagal Upload !";
                              } else {
                                $upload_dokumen = $this->upload->data('file_name');
                              }
                            }

                            $data_session = array(
                              'id_user' => $id,
                              'nama_dokumen' => $nama_dokumen,
                              'bag_or_keb' => $bag_or_keb,
                              'jenis_dok' => $jenis_dok,
                              'masa_aktif' => $masa_aktif,
                              'masa_aktif_awal' => $cnvrt_masa_aktif_awal,
                              'masa_aktif_akhir' => $cnvrt_masa_aktif_akhir,
                              'pic' => $pic,
                              'cs' => $cs,
                              'durasi_tahun' => $drs_tahun,
                              'durasi_bulan' => $drs_bulan,
                              'durasi_tgl' => $drs_hari,
                              'status_dokumen' => 'Aktif',
                              'akses_for' => $akses_for,
                              'upload_dokumen' => $upload_dokumen
                            );
                            $this->session->set_userdata($data_session);
                            
                            require_once(APPPATH.'libraries/fpdf/fpdf.php');
                            require_once(APPPATH.'libraries/fpdi/FPDI/src/autoload.php');
                            //Set the source PDF file
                            $pdf = new Fpdi();

                            // menampilkan hasil curl
                            $fileContent = file_get_contents(base_url('uploads/'.$upload_dokumen));
                            $pageCount = $pdf->setSourceFile(StreamReader::createByString($fileContent));

                            $data1 = array(
                              'id_user' => $id,
                              'nama_dokumen' => $nama_dokumen,
                              'bag_or_keb' => $bag_or_keb,
                              'jenis_dok' => $jenis_dok,
                              'masa_aktif_awal' => $cnvrt_masa_aktif_awal,
                              'masa_aktif_akhir' => $cnvrt_masa_aktif_akhir,
                              'pic' => $pic,
                              'cs' => $cs,
                              'durasi_tahun' => $drs_tahun,
                              'durasi_bulan' => $drs_bulan,
                              'durasi_tgl' => $drs_hari,
                              'status_dokumen' => 'Aktif',
                              'akses_for' => implode(",", $akses_for),
                              'upload_dokumen' => $upload_dokumen
                            );
                            $this->model_dokumen->tambah_dokumen($data1, 'tb_dokumen');
                            // $id_dokumen_baru = $this->db->insert_id();
                            // foreach ($akses_for as $key => $value) {
                            //   $notifdiberi_akses = $this->db->query("SELECT *,tb_dokumen.id AS iddkm FROM tb_dokumen 
                            //   LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
                            //   WHERE tb_dokumen.id = '$id_dokumen_baru'");
                            //   $data['notifakses'] = $notifdiberi_akses->result_array();
                            // }
                            // $cek_akses = $data['notifakses'][0]['akses_for'];
                            // $akses_notif = explode(",",$cek_akses);
                            // $pic_notif = $data['notifakses'][0]['pic'];
                            // $notifpic = $this->db->query("SELECT * FROM tb_user
                            // WHERE id = '$pic_notif'");
                            // $data['notifpic'] = $notifpic->result_array();

                            // $picnotelp = $data['notifpic'][0]['no_telp'];
                            // $pic_id_teleg = $data['notifpic'][0]['id_telegram'];
                            // $result22 = preg_replace('~^[0\D]++|\D++~', '', $picnotelp);
                            //  // sms pic
                            //  $url = "http://103.16.199.187/masking/send_post.php";
                            //  $rows = array(
                            //    'username' => 'ptpn12_sms ',
                            //    'password' => '123456789',
                            //    'hp' => '62' . $result22,
                            //    'message' => ' Anda telah dijadikan PIC dokumen '.$nama_dokumen.' oleh '. $username
                            //  );
                            //  $curl = curl_init();
                            //  curl_setopt($curl, CURLOPT_URL, $url);
                            //  curl_setopt($curl, CURLOPT_POST, TRUE);
                            //  curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
                            //  curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($rows));
                            //  curl_setopt($curl, CURLOPT_HEADER, FALSE);
                            //  curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
                            //  curl_setopt($curl, CURLOPT_TIMEOUT, 60);
                            //  $htm = curl_exec($curl);
                            //  if (curl_errno($curl) !== 0) {
                            //    error_log('cURL error when connecting to ' . $url . ': ' . curl_error($curl));
                            //  }
                            //  curl_close($curl);
                            //  print_r($htm);
                            //  if ($htm != '0') {
                            //    $this->session->set_flashdata('something', 'Pesan Terkirim');
                            //  }
                             // sms pic
                              // Telegram send
                              // $message_text = "Anda telah dijadikan PIC dokumen $nama_dokumen oleh $username";
                              // $pesan = urlencode($message_text);
                              // $token = "bot"."1456403973:AAEBKXDsE2Etl9GOiJjyLt3dtfHZmQYqI3w";
                              // $chat_id = $pic_id_teleg;
                              // $proxy = "";

                              // $url = "https://api.telegram.org/$token/sendMessage?parse_mode=markdown&chat_id=$chat_id&text=$pesan";

                              // $ch = curl_init();
                                  
                              // if($proxy==""){
                              //     $optArray = array(
                              //         CURLOPT_URL => $url,
                              //         CURLOPT_RETURNTRANSFER => true,
                              //         CURLOPT_CAINFO => './telegram/cacert.pem'
                              //     );
                              // }
                              // else{ 
                              //     $optArray = array(
                              //         CURLOPT_URL => $url,
                              //         CURLOPT_RETURNTRANSFER => true,
                              //         CURLOPT_PROXY => "$proxy",
                              //         CURLOPT_CAINFO => './telegram/cacert.pem'		
                              //     );	
                              // }
                                  
                              // curl_setopt_array($ch, $optArray);
                              // $result = curl_exec($ch);
                              // $err = curl_error($ch);
                              // curl_close($ch);	
                                  
                              // if($err<>"") echo "Error: $err";
                              // else echo "Pesan Terkirim";

                              // Telegram send
                            // foreach ($akses_notif as $key => $value) {
                            //   $notif = $this->db->query("SELECT * FROM tb_user
                            //   WHERE bagian = '$value'");
                            //   $data['notif'] = $notif->result_array();
                            //   $nama_dokumen = $data['notif'][0]['nama_dokumen'];
                            //   $notelp = $data['notif'][0]['no_telp'];
                            //   $id_telegram = $data['notif'][0]['id_telegram'];
                            //   $result = preg_replace('~^[0\D]++|\D++~', '', $notelp);
                            //    // sms saat ada peminta
                            // $url = "http://103.16.199.187/masking/send_post.php";
                            // $rows = array(
                            //   'username' => 'ptpn12_sms ',
                            //   'password' => '123456789',
                            //   'hp' => '62' . $result,
                            //   'message' => ' Anda telah diberikan akses dokumen'.$nama_dokumen.' oleh '. $username
                            // );
                            // $curl = curl_init();
                            // curl_setopt($curl, CURLOPT_URL, $url);
                            // curl_setopt($curl, CURLOPT_POST, TRUE);
                            // curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
                            // curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($rows));
                            // curl_setopt($curl, CURLOPT_HEADER, FALSE);
                            // curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
                            // curl_setopt($curl, CURLOPT_TIMEOUT, 60);
                            // $htm = curl_exec($curl);
                            // if (curl_errno($curl) !== 0) {
                            //   error_log('cURL error when connecting to ' . $url . ': ' . curl_error($curl));
                            // }
                            // curl_close($curl);
                            // print_r($htm);
                            // if ($htm != '0') {
                            //   $this->session->set_flashdata('something', 'Pesan Terkirim');
                            // }
                            // sms saat ada peminta
                            // Telegram send
                            // $message_text = "Anda telah diberikan akses dokumen $nama_dokumen oleh $username";
                            // $pesan = urlencode($message_text);
                            // $token = "bot"."1456403973:AAEBKXDsE2Etl9GOiJjyLt3dtfHZmQYqI3w";
                            // $chat_id = $id_telegram;
                            // $proxy = "";
                            
                            // $url = "https://api.telegram.org/$token/sendMessage?parse_mode=markdown&chat_id=$chat_id&text=$pesan";
                            
                            // $ch = curl_init();
                                
                            // if($proxy==""){
                            //     $optArray = array(
                            //         CURLOPT_URL => $url,
                            //         CURLOPT_RETURNTRANSFER => true,
                            //         CURLOPT_CAINFO => './telegram/cacert.pem'
                            //     );
                            // }
                            // else{ 
                            //     $optArray = array(
                            //         CURLOPT_URL => $url,
                            //         CURLOPT_RETURNTRANSFER => true,
                            //         CURLOPT_PROXY => "$proxy",
                            //         CURLOPT_CAINFO => './telegram/cacert.pem'	
                            //     );	
                            // }
                                
                            // curl_setopt_array($ch, $optArray);
                            // $result = curl_exec($ch);
                            // $err = curl_error($ch);
                            // curl_close($ch);	
                                
                            // if($err<>"") echo "Error: $err";
                            // else echo "Pesan Terkirim";
                            // Telegram send
                            // }
                            redirect('c_data_dokumen/index');
                          }
                        }

                        public function tambah_histori_data_dokumen()
                        {
                          $id_dokumen = $this->input->post('id_dokumen');
                          $masa_aktif = $this->input->post('pembaruan_tanggal');
                          $masa_aktif_pisah = explode(" - ", $masa_aktif);
                          $masa_aktif_awal = $masa_aktif_pisah[0];
                          $masa_aktif_akhir = $masa_aktif_pisah[1];
                          $replc1 = str_replace("/", "-", $masa_aktif_awal);
                          $replc2 = str_replace("/", "-", $masa_aktif_akhir);
                          $cnvrt_masa_aktif_awal = date('Y-m-d', strtotime($replc1));
                          $cnvrt_masa_aktif_akhir = date('Y-m-d', strtotime($replc2));
                          $data1 = array(
                            'id_dokumen' => $id_dokumen
                          );
                          $data2 = array(
                            'masa_aktif_awal' => $cnvrt_masa_aktif_awal,
                            'masa_aktif_akhir' => $cnvrt_masa_aktif_akhir,
                            'pengingat' => '0'

                          );
                          $where = array('id' => $id_dokumen);
                          $this->model_dokumen->tambah_dokumen($data1, 'histori_pembarui_dokumen');
                          $this->model_dokumen->update_dokumen($where, $data2, 'tb_dokumen');

                          redirect('c_data_dokumen/edit_data_dokumen/' . $id_dokumen);
                        }

                        public function edit_data_dokumen($id)
                        {
                          $where = array('id' => $id);
                          $data['data_dokumen'] = $this->model_dokumen->edit_dokumen($where, 'tb_dokumen')->result();
                          $data['jenis_dokumen'] = $this->model_dokumen->tampil_data_jenis_dokumen()->result();
                          $data['master_bagian'] = $this->model_dokumen->tampil_data_bagian_kebun()->result();

                          $data['user'] = $this->model_dokumen->tampil_data_user()->result();
                          $nama = $this->session->userdata('username');
                          $query_dokumen = $this->db->query("SELECT * FROM tb_user 
                            LEFT JOIN tb_dokumen ON tb_user.id = tb_dokumen.id_user
                            LEFT JOIN histori_pembarui_dokumen ON tb_dokumen.id = histori_pembarui_dokumen.id_dokumen
                            LEFT JOIN tb_master_jenis_dok ON tb_dokumen.jenis_dok = tb_master_jenis_dok.id
                            WHERE tb_user.username = '$nama' && histori_pembarui_dokumen.id_dokumen = '$id'");
                          $data['histori_data_dokumen'] = $query_dokumen->result_array();

                          $this->load->view('edit-data_dokumen', $data);
                        }

                        public function update_data_dokumen()
                        {
                          $id       = $this->input->post('id');
                          $nama_dokumen = $this->input->post('nama_dokumen');
                          $bag_or_keb = $this->input->post('bag_or_keb');
                          $jenis_dok = $this->input->post('jenis_dok');
                          $drs_tahun = $this->input->post('drs_tahun');
                          $drs_bulan = $this->input->post('drs_bulan');
                          $drs_hari = $this->input->post('drs_hari');
                          $masa_aktif = $this->input->post('masa_aktif');
                          $masa_aktif_pisah = explode(" - ", $masa_aktif);
                          $masa_aktif_awal = $masa_aktif_pisah[0];
                          $masa_aktif_akhir = $masa_aktif_pisah[1];
                          $replc1 = str_replace("/", "-", $masa_aktif_awal);
                          $replc2 = str_replace("/", "-", $masa_aktif_akhir);
                          $cnvrt_masa_aktif_awal = date('Y-m-d', strtotime($replc1));
                          $cnvrt_masa_aktif_akhir = date('Y-m-d', strtotime($replc2));
                          $pic = $this->input->post('pic');
                          $cs = $this->input->post('cs');
                          $akses_for = $_POST['akses_for'];
                          $upload_dokument = $this->input->post('upload_dokument');
                          $upload_dokumen = $_FILES['upload_dokumen']['name'];
                          if ($upload_dokumen == null) {
                            $data = array(
                              'nama_dokumen' => $nama_dokumen,
                              'bag_or_keb' => $bag_or_keb,
                              'jenis_dok' => $jenis_dok,
                              'masa_aktif_awal' => $cnvrt_masa_aktif_awal,
                              'masa_aktif_akhir' => $cnvrt_masa_aktif_akhir,
                              'pic' => $pic,
                              'cs' => $cs,
                              'durasi_tahun' => $drs_tahun,
                              'durasi_bulan' => $drs_bulan,
                              'durasi_tgl' => $drs_hari,
                              'akses_for' => implode(",", $akses_for),
                              'upload_dokumen' => $upload_dokument
                            );
                            $where = array('id' => $id);
                            $this->model_dokumen->update_dokumen($where, $data, 'tb_dokumen');
                            $this->session->set_flashdata('something4', 'Pesan Terkirim');
                            redirect('c_data_dokumen');
                          } else {
                            $config['upload_path'] = './uploads';
                            $config['allowed_types'] = '*';

                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload('upload_dokumen')) {
                              echo "Gambar Gagal Upload !";
                            } else {
                              $upload_dokumen = $this->upload->data('file_name');
                            }
                            $data = array(
                              'nama_dokumen' => $nama_dokumen,
                              'bag_or_keb' => $bag_or_keb,
                              'jenis_dok' => $jenis_dok,
                              'masa_aktif_awal' => $cnvrt_masa_aktif_awal,
                              'masa_aktif_akhir' => $cnvrt_masa_aktif_akhir,
                              'cs' => $cs,
                              'durasi_tahun' => $drs_tahun,
                              'durasi_bulan' => $drs_bulan,
                              'durasi_tgl' => $drs_hari,
                              'akses_for' => implode(",", $akses_for),
                              'upload_dokumen' => $upload_dokumen
                            );
                            $where = array('id' => $id);
                            $this->model_dokumen->update_dokumen($where, $data, 'tb_dokumen');
                            $this->session->set_flashdata('something4', 'Pesan Terkirim');
                            redirect('c_data_dokumen');
                          }
                        }

                        public function delete()
                        {
                          $id = $this->input->post('id');

                          $this->db->query("DELETE FROM tb_dokumen WHERE id = '$id'");
                          $this->db->query("DELETE FROM histori_download_dokumen WHERE id_dokumen = '$id'");
                          $this->db->query("DELETE FROM histori_pembarui_dokumen WHERE id_dokumen = '$id'");
                          $this->session->set_flashdata('something3', 'Pesan Terkirim');
                          redirect('c_data_dokumen/index');
                        }

                        public function permintaan_download()
                        {
                          $id_pem_dokumen = $this->session->userdata('id');
                          $query_download_dokumen = $this->db->query("SELECT *,tb_dokumen.id AS iddkm,histori_download_dokumen.id AS idhistori FROM tb_dokumen 
                          LEFT JOIN histori_download_dokumen ON tb_dokumen.id = histori_download_dokumen.id_dokumen
                          LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
                          WHERE tb_dokumen.id_user = '$id_pem_dokumen' && histori_download_dokumen.status != '' ORDER BY idhistori DESC");
                          
                          $data['data_download_dokumen'] = $query_download_dokumen->result_array();
                          $this->load->view('templates/header', $data);
                          $this->load->view('templates/sidebar');
                          $this->load->view('permintaan_download', $data);
                          $this->load->view('templates/footer');
                        }

                        public function tolak_permintaan_download()
                        {
                          $idhistori            = $this->input->post('idhistori');
                          $kode_generate  = '-';
                          $status         = 'Ditolak';
                          $data1 = array(
                            'status'    => $status,
                            'kode_unik' => $kode_generate
                          );
                          $where1 = array('id' => $idhistori);
                          $this->model_dokumen->update_dokumen($where1, $data1, 'histori_download_dokumen');
                          $this->session->set_flashdata('something1', 'Pesan Terkirim');
                          redirect('c_data_dokumen/permintaan_download');
                        }
                        
                        public function modal_statusperpanjang()
                        {
                          $dataperubahan = $this->input->post('iddokumens');
                          $query_dokumen = $this->db->query("SELECT *,tb_dokumen.id AS iddkm FROM tb_dokumen 
                          LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
                          LEFT JOIN tb_master_jenis_dok ON tb_dokumen.jenis_dok = tb_master_jenis_dok.id
                          WHERE tb_dokumen.id = '$dataperubahan' && pengingat = '1'");
                          $data['perubahandokumen'] = $query_dokumen->result_array();
                          foreach ($data as $row) {
                            echo $row[0]['nama_dokumen'] . ' : ';
                            $str = $row[0]['masa_aktif_akhir'];
                            $format_tgl = $str;
                            $hari = $row[0]['durasi_tgl'];
                            $bulan = $row[0]['durasi_bulan'];
                            $tahun = $row[0]['durasi_tahun'];
                            $tgl1    = $format_tgl;
                            $tgl2    = date('d-m-Y', strtotime('-' . $hari . 'days', strtotime($tgl1)));
                            $tgl3    = date('d-m-Y', strtotime('-' . $bulan . 'month', strtotime($tgl2)));
                            $tgl4    = date('d-m-Y', strtotime('-' . $tahun . 'year', strtotime($tgl3)));
                            $awal  = date_create();
                            $akhir = date_create($tgl1);
                            $interval = $akhir->diff($awal);
                            echo $interval->format('<span style="color: red;"> %y Tahun, %m Bulan, %d Hari lagi</span>');
                            echo '</div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak Diperbarui</button>
                            <a href="' . base_url() . 'c_data_dokumen/perbarui_data_dokumen/' . $dataperubahan . '#exampleModalCenter' . '"><button  type="button" class="btn btn-primary">Memperbarui masa Aktif</button></a>
                            </div>';
                            // echo $interval->format('%a total days')."\n"; 
                          }
                        }

                        public function modal_akses_for()
                        {
                          $dataperubahan = $this->input->post('iddokumens');
                          $query_dokumen = $this->db->query("SELECT *,tb_dokumen.id AS iddkm FROM tb_dokumen 
                          LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
                          LEFT JOIN tb_master_jenis_dok ON tb_dokumen.jenis_dok = tb_master_jenis_dok.id
                          WHERE tb_dokumen.id = '$dataperubahan' && notif_hak_akses = '1'");
                          $data['perubahandokumen'] = $query_dokumen->result_array();
                          foreach ($data['perubahandokumen'] as $row) {
                            echo '<p>Anda telah diberikan akses oleh <b>'.$row['username'].'</b> atas dokumen: <span style="color:green;">'.$row['nama_dokumen'].'</span></p>';
                            echo '</div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <a href="' . base_url() . 'c_data_dokumen/tandai_sudah_dibaca_akses/' . $dataperubahan.'"><button  type="button" class="btn btn-primary">Tandai sudah dilihat</button></a>
                            </div>';
                            // echo $interval->format('%a total days')."\n"; 
                          }
                        }

                        public function modal_pic()
                        {
                          $dataperubahan = $this->input->post('iddokumens');
                          $query_dokumen = $this->db->query("SELECT *,tb_dokumen.id AS iddkm FROM tb_dokumen 
                          LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
                          LEFT JOIN tb_master_jenis_dok ON tb_dokumen.jenis_dok = tb_master_jenis_dok.id
                          WHERE tb_dokumen.id = '$dataperubahan' && notif_pic = '1'");
                          $data['perubahandokumen'] = $query_dokumen->result_array();
                          foreach ($data as $row) {
                            echo $row[0]['nama_dokumen'] . ' : ';
                            $str = $row[0]['masa_aktif_akhir'];
                            $format_tgl = $str;
                            $hari = $row[0]['durasi_tgl'];
                            $bulan = $row[0]['durasi_bulan'];
                            $tahun = $row[0]['durasi_tahun'];
                            $tgl1    = $format_tgl;
                            $tgl2    = date('d-m-Y', strtotime('-' . $hari . 'days', strtotime($tgl1)));
                            $tgl3    = date('d-m-Y', strtotime('-' . $bulan . 'month', strtotime($tgl2)));
                            $tgl4    = date('d-m-Y', strtotime('-' . $tahun . 'year', strtotime($tgl3)));
                            $awal  = date_create();
                            $akhir = date_create($tgl1);
                            $interval = $akhir->diff($awal);
                            echo $interval->format('<span style="color: red;"> %y Tahun, %m Bulan, %d Hari lagi</span>');
                            echo '</div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <a href="' . base_url() . 'c_data_dokumen/tandai_sudah_dibaca_pic/' . $dataperubahan . '"><button  type="button" class="btn btn-primary">Tandai sudah dilihat</button></a>
                            </div>';
                            // echo $interval->format('%a total days')."\n"; 
                          }
                        }

                        public function tandai_sudah_dibaca_akses($id_dokumen){
                          $data = array(
                            'notif_hak_akses' => '2'
                          );
                          $where = array('id' => $id_dokumen);
                          $this->model_dokumen->update_dokumen($where, $data, 'tb_dokumen');
                          redirect('c_data_dokumen');
                        }

                        public function tandai_sudah_dibaca_pic($id_dokumen){
                          $data = array(
                            'notif_pic' => '2'
                          );
                          $where = array('id' => $id_dokumen);
                          $this->model_dokumen->update_dokumen($where, $data, 'tb_dokumen');
                          redirect('c_data_dokumen');
                        }

                        public function sendsms()
                        {
                          $notelp            = $this->input->post('notelp');
                          $pesan            = $this->input->post('pesan');
                          $url = "http://103.16.199.187/masking/send_post.php";
                          $rows = array(
                            'username' => 'ptpn12_sms ',
                            'password' => '123456789',
                            'hp' => '62' . $notelp,
                            'message' => 'Kode unik Anda adalah  ' . $pesan . '. \n\nSilahkan masukkan kode tersebut untuk mendownload dokumen permintaan anda'
                          );
                          $curl = curl_init();
                          curl_setopt($curl, CURLOPT_URL, $url);
                          curl_setopt($curl, CURLOPT_POST, TRUE);
                          curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
                          curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($rows));
                          curl_setopt($curl, CURLOPT_HEADER, FALSE);
                          curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
                          curl_setopt($curl, CURLOPT_TIMEOUT, 60);
                          $htm = curl_exec($curl);
                          if (curl_errno($curl) !== 0) {
                            error_log('cURL error when connecting to ' . $url . ': ' . curl_error($curl));
                          }
                          curl_close($curl);
                          print_r($htm);
                          if ($htm != '0') {
                            $this->session->set_flashdata('something', 'Pesan Terkirim');
                            redirect('c_data_dokumen/permintaan_download');
                          }
                        }

                        public function perbarui_data_dokumen($id)
                        {
                          $where = array('id' => $id);
                          $data['data_dokumen'] = $this->model_dokumen->edit_dokumen($where, 'tb_dokumen')->result();
                          $data['jenis_dokumen'] = $this->model_dokumen->tampil_data_jenis_dokumen()->result();
                          $data['master_bagian'] = $this->model_dokumen->tampil_data_bagian_kebun()->result();

                          $data['user'] = $this->model_dokumen->tampil_data_user()->result();
                          $nama = $this->session->userdata('username');
                          $query_dokumen = $this->db->query("SELECT *,histori_pembarui_dokumen.id AS idhistori,tb_dokumen.id AS iddok FROM tb_dokumen 
                          LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
                          LEFT JOIN histori_pembarui_dokumen ON tb_dokumen.id = histori_pembarui_dokumen.id_dokumen
                          LEFT JOIN tb_master_jenis_dok ON tb_dokumen.jenis_dok = tb_master_jenis_dok.id
                          LEFT JOIN tb_master_bagian ON tb_dokumen.bag_or_keb = tb_master_bagian.id_bagian
                          WHERE histori_pembarui_dokumen.id_dokumen = '$id' ORDER BY idhistori DESC");
                          $data['histori_data_dokumen'] = $query_dokumen->result_array();

                          $this->load->view('perbarui-data_dokumen', $data);
                        }

                        public function tambah_perbarui_data_dokumen()
                        {
                          $id_dokumen = $this->input->post('id_dokumen');
                          $masa_aktif = $this->input->post('masa_aktif');
                          $upload_dokumen_lama = $this->input->post('upload_dokument');
                          $masa_aktif_lama = $this->input->post('masa_aktif_lama');
                          $masa_aktif_pisah = explode(" - ", $masa_aktif);
                          $masa_aktif_pisah_lama = explode(" - ", $masa_aktif_lama);
                          $masa_aktif_awal = $masa_aktif_pisah[0];
                          $masa_aktif_akhir = $masa_aktif_pisah[1];
                          $masa_aktif_awal_lama = $masa_aktif_pisah_lama[0];
                          $masa_aktif_akhir_lama = $masa_aktif_pisah_lama[1];
                          $replc1 = str_replace("/", "-", $masa_aktif_awal);
                          $replc2 = str_replace("/", "-", $masa_aktif_akhir);
                          $replc1_lama = str_replace("/", "-", $masa_aktif_awal_lama);
                          $replc2_lama = str_replace("/", "-", $masa_aktif_akhir_lama);
                          $cnvrt_masa_aktif_awal = date('Y-m-d', strtotime($replc1));
                          $cnvrt_masa_aktif_akhir = date('Y-m-d', strtotime($replc2));
                          $cnvrt_masa_aktif_awal_lama = date('Y-m-d', strtotime($replc1_lama));
                          $cnvrt_masa_aktif_akhir_lama = date('Y-m-d', strtotime($replc2_lama));
                          $upload_dokumen = $_FILES['upload_dokumen']['name'];
                          $config['upload_path'] = './uploads';
                          $config['allowed_types'] = '*';

                          $this->load->library('upload', $config);
                          if (!$this->upload->do_upload('upload_dokumen')) {
                            echo "Gambar Gagal Upload !";
                          } else {
                            $upload_dokumen = $this->upload->data('file_name');
                          }
                          $data1 = array(
                            'masa_aktif_awal_lama' => $cnvrt_masa_aktif_awal_lama,
                            'masa_aktif_akhir_lama' => $cnvrt_masa_aktif_akhir_lama,
                            'upload_dokumen_lama' => $upload_dokumen_lama,
                            'id_dokumen' => $id_dokumen
                          );
                          $data2 = array(
                            'masa_aktif_awal' => $cnvrt_masa_aktif_awal,
                            'masa_aktif_akhir' => $cnvrt_masa_aktif_akhir,
                            'upload_dokumen' => $upload_dokumen,
                            'status_dokumen' => 'Aktif',
                            'pengingat' => '0',
                            'notif_pic' => '0'

                          );
                          $where = array('id' => $id_dokumen);
                          $this->model_dokumen->tambah_dokumen($data1, 'histori_pembarui_dokumen');
                          $this->model_dokumen->update_dokumen($where, $data2, 'tb_dokumen');
                          $this->session->set_flashdata('something5', 'Pesan Terkirim');

                          redirect('c_data_dokumen/perbarui_data_dokumen/' . $id_dokumen);
                        }

                        public function hapusdokumen($id)
                        {
                          $data = array(
                            'upload_dokumen' => ''
                          );
                          $where = array('id' => $id);
                          $this->model_dokumen->update_dokumen($where, $data, 'tb_dokumen');
                          redirect('c_data_dokumen/edit_data_dokumen/' . $id);
                        }

                        public function lakukan_download_pemilik($data_dokumen,$idhist)
                        {
                          $this->load->helper('download');
                          
                          if($data_dokumen ==  '0'){
                            $this->session->set_flashdata('something1', 'Pesan Terkirim');
                            redirect('c_data_dokumen/perbarui_data_dokumen/'.$idhist);
                          }else {
                            force_download('uploads/' . $data_dokumen, NULL);
                          }
                          
                        }
                        
}
                          ?>