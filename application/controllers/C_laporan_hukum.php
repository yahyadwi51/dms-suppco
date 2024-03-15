<?php
error_reporting(0);
class C_laporan_hukum extends CI_Controller
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
    $query_dokumen = $this->db->query("SELECT *,hkm_dokumen.id_dokumen AS id_dkm_awal FROM `hkm_dokumen`
        LEFT JOIN tb_user ON hkm_dokumen.user_upload = tb_user.id
        LEFT JOIN hkm_master_jenis_dokumen ON hkm_dokumen.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen
        WHERE hkm_dokumen.user_upload = '$bagian' OR hkm_dokumen.akses_for LIKE '%$id%' ORDER BY id_dkm_awal DESC");
    $data['user'] = $this->model_dokumen->tampil_data_user()->result();
    $data['jenis_dokumen'] = $this->model_dokumen->tampil_data_jenis_pengelolah_dokumen()->result();
    $data['data_dokumen'] = $query_dokumen->result_array();
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar');
    $this->load->view('laporan_hukum', $data);
    $this->load->view('templates/footer');
  }
  public function load_laporan_hukum()
  {
    $jenis_dokumen = $_GET['jenis_dokumen'];
    $bag_pemilik = $_GET['bag_pemilik'];
    $reservation = $_GET['reservation'];
    $id = $this->session->userdata('id');
    $data['user'] = $this->model_dokumen->tampil_data_user()->result();
    $tanggal = explode(" - ", $reservation);
    $format_tgl_awal = $tanggal[0];
    $format_tgl_akhir = $tanggal[1];

    $check_where = false;
    $where = "WHERE hkm_dokumen.user_upload = '$id' OR hkm_dokumen.akses_for LIKE '%$id%' ";
    if (!empty($jenis_dokumen)) {
      $jenis_dokumens = explode(",", $jenis_dokumen);
      $jumlahdata = count($jenis_dokumens);
      $check_js = false;
      foreach ($jenis_dokumens as $jdkm) {
        if ($check_where) {
          if ($check_js) {
            $where = $where . "OR (hkm_dokumen.jenis_dokumen = '$jdkm' AND hkm_dokumen.user_upload = '$id') OR (hkm_dokumen.jenis_dokumen = '$jdkm' AND hkm_dokumen.akses_for LIKE '%$id%') ";
          } else {
            $where = $where . " AND (hkm_dokumen.jenis_dokumen = '$jdkm'  ";
            $check_js = true;
          }
        } else {
          $check_where = true;
          $check_js = true;
          $where = "WHERE ((hkm_dokumen.jenis_dokumen = '$jdkm' AND hkm_dokumen.user_upload = '$id') OR (hkm_dokumen.jenis_dokumen = '$jdkm' AND hkm_dokumen.akses_for LIKE '%$id%') ";
        }
      }
      $where = $where . ')';
    }
    if (!empty($bag_pemilik)) {
      $bag_pemiliks = explode(",", $bag_pemilik);
      $check_bp = false;
      foreach ($bag_pemiliks as $jdkm) {
        if ($check_where) {
          if ($check_bp) {
            $where = $where . "OR (hkm_dokumen.user_upload = '$jdkm' ) OR (hkm_dokumen.user_upload = '$jdkm' AND hkm_dokumen.akses_for LIKE '%$id%') ";
          } else {
            $check_bp = true;
            $where = $where . "AND (hkm_dokumen.user_upload = '$jdkm' ";
          }
        } else {
          $check_where = true;
          $check_bp = true;
          $where = "WHERE (hkm_dokumen.user_upload = '$jdkm') OR (hkm_dokumen.user_upload = '$jdkm' AND hkm_dokumen.akses_for LIKE '%$id%' ";
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
        $crv_tgl_awal = str_replace("/", "-", $format_tgl_awal);
        $crv_tgl_akhir = str_replace("/", "-", $format_tgl_akhir);
        if ($check_where) {
          if ($check_rs) {
            $where = $where . "OR ((hkm_dokumen.tanggal BETWEEN '$crv_tgl_awal' AND '$crv_tgl_akhir')  AND (hkm_dokumen.user_upload = '$id'))  ";
          } else {
            $check_rs = true;
            $where = $where . "AND ((hkm_dokumen.tanggal BETWEEN '$crv_tgl_awal' AND '$crv_tgl_akhir') AND (hkm_dokumen.user_upload = '$id')";
          }
        } else {
          $check_where = true;
          $check_rs = true;
          $where = "WHERE ((hkm_dokumen.user_upload = '$id') OR (hkm_dokumen.akses_for LIKE '%$id%' )) AND ((hkm_dokumen.tanggal BETWEEN '$crv_tgl_awal' AND '$crv_tgl_akhir') ";
        }
        $where = $where . ')';
      }
    }
    $query_dokumen = $this->db->query("SELECT * FROM `hkm_dokumen`
              LEFT JOIN tb_user ON hkm_dokumen.user_upload = tb_user.id
              LEFT JOIN hkm_master_jenis_dokumen ON hkm_dokumen.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen
               $where ");
    // echo $where;die();
    $data1['data_dokumen'] = $query_dokumen->result_array();
    //   echo json_encode($data1['data_dokumen']);
    //   die();
    $no = 0;
    foreach ($data1['data_dokumen'] as $dd) :
      $no++;
?>
<tr>
    <td><?php echo $no ?></td>
    <td><?php echo $dd['nama_dokumen'] ?></td>
    <td><?php echo $dd['username'] ?></td>
    <td><?php echo $dd['nama_jenis_dokumen'] ?></td>
    <td><?php echo $dd['status'] ?></td>
    <td><?php echo $dd['tanggal'] ?></td>
    <td>
        <?php foreach ($data['user'] as $usr) : ?>
        <?php $str = $dd['akses_for'];
            $str1 = explode(",", $str);
            $jumlahdata = count($str1);
            for ($i = 0; $i < $jumlahdata; $i++) {
              if ($usr->id == $str1[$i]) {
                echo '-' . $usr->username . '<br>';
              }
            }

            ?>
        <?php endforeach; ?>
    </td>
</tr>
<?php endforeach; ?><?php
                        }
                        public function printexcel()
                        {
                          $jenis_dokumen = $this->input->post('ctk_jenis_dokumen');
                          $bag_pemilik = $this->input->post('ctk_bag_pemilik');
                          $reservation = $this->input->post('ctk_reservasion');
                          $id = $this->session->userdata('id');
                          $data['user'] = $this->model_dokumen->tampil_data_user()->result();
                          $tanggal = explode(" - ", $reservation);
                          $format_tgl_awal = $tanggal[0];
                          $format_tgl_akhir = $tanggal[1];

                          $check_where = false;
                          $where = "WHERE hkm_dokumen.user_upload = '$id' OR hkm_dokumen.akses_for LIKE '%$id%' ";
                          if (!empty($jenis_dokumen)) {
                            $jenis_dokumens = explode(",", $jenis_dokumen);
                            $jumlahdata = count($jenis_dokumens);
                            $check_js = false;
                            foreach ($jenis_dokumens as $jdkm) {
                              if ($check_where) {
                                if ($check_js) {
                                  $where = $where . "OR (hkm_dokumen.jenis_dokumen = '$jdkm' AND hkm_dokumen.user_upload = '$id') OR (hkm_dokumen.jenis_dokumen = '$jdkm' AND hkm_dokumen.akses_for LIKE '%$id%') ";
                                } else {
                                  $where = $where . " AND (hkm_dokumen.jenis_dokumen = '$jdkm'  ";
                                  $check_js = true;
                                }
                              } else {
                                $check_where = true;
                                $check_js = true;
                                $where = "WHERE ((hkm_dokumen.jenis_dokumen = '$jdkm' AND hkm_dokumen.user_upload = '$id') OR (hkm_dokumen.jenis_dokumen = '$jdkm' AND hkm_dokumen.akses_for LIKE '%$id%') ";
                              }
                            }
                            $where = $where . ')';
                          }
                          if (!empty($bag_pemilik)) {
                            $bag_pemiliks = explode(",", $bag_pemilik);
                            $check_bp = false;
                            foreach ($bag_pemiliks as $jdkm) {
                              if ($check_where) {
                                if ($check_bp) {
                                  $where = $where . "OR (hkm_dokumen.user_upload = '$jdkm' ) OR (hkm_dokumen.user_upload = '$jdkm' AND hkm_dokumen.akses_for LIKE '%$id%') ";
                                } else {
                                  $check_bp = true;
                                  $where = $where . "AND (hkm_dokumen.user_upload = '$jdkm' ";
                                }
                              } else {
                                $check_where = true;
                                $check_bp = true;
                                $where = "WHERE (hkm_dokumen.user_upload = '$jdkm') OR (hkm_dokumen.user_upload = '$jdkm' AND hkm_dokumen.akses_for LIKE '%$id%' ";
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
                              $crv_tgl_awal = str_replace("/", "-", $format_tgl_awal);
                              $crv_tgl_akhir = str_replace("/", "-", $format_tgl_akhir);
                              if ($check_where) {
                                if ($check_rs) {
                                  $where = $where . "OR ((hkm_dokumen.tanggal BETWEEN '$crv_tgl_awal' AND '$crv_tgl_akhir')  AND (hkm_dokumen.user_upload = '$id'))  ";
                                } else {
                                  $check_rs = true;
                                  $where = $where . "AND ((hkm_dokumen.tanggal BETWEEN '$crv_tgl_awal' AND '$crv_tgl_akhir') AND (hkm_dokumen.user_upload = '$id')";
                                }
                              } else {
                                $check_where = true;
                                $check_rs = true;
                                $where = "WHERE ((hkm_dokumen.user_upload = '$id') OR (hkm_dokumen.akses_for LIKE '%$id%' )) AND ((hkm_dokumen.tanggal BETWEEN '$crv_tgl_awal' AND '$crv_tgl_akhir') ";
                              }
                              $where = $where . ')';
                            }
                          }
                          $query_dokumen = $this->db->query("SELECT * FROM `hkm_dokumen`
                LEFT JOIN tb_user ON hkm_dokumen.user_upload = tb_user.id
                LEFT JOIN hkm_master_jenis_dokumen ON hkm_dokumen.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen
                $where ");
                          // echo $where;die();
                          $data1['data_dokumen'] = $query_dokumen->result_array();
                          $data1['user'] = $this->model_dokumen->tampil_data_user()->result();
                          // echo json_encode($data1['data_dokumen']);
                          // die();
                          $this->load->view('cetak_hukum_excel', $data1);
                        }
                        public function printpdf()
                        {
                          $this->load->library('dompdf_gen');
                          $jenis_dokumen = $this->input->post('ctk_jenis_dokumen');
                          $bag_pemilik = $this->input->post('ctk_bag_pemilik');
                          $reservation = $this->input->post('ctk_reservasion');
                          $id = $this->session->userdata('id');
                          $data['user'] = $this->model_dokumen->tampil_data_user()->result();
                          $tanggal = explode(" - ", $reservation);
                          $format_tgl_awal = $tanggal[0];
                          $format_tgl_akhir = $tanggal[1];

                          $check_where = false;
                          $where = "WHERE hkm_dokumen.user_upload = '$id' OR hkm_dokumen.akses_for LIKE '%$id%' ";
                          if (!empty($jenis_dokumen)) {
                            $jenis_dokumens = explode(",", $jenis_dokumen);
                            $jumlahdata = count($jenis_dokumens);
                            $check_js = false;
                            foreach ($jenis_dokumens as $jdkm) {
                              if ($check_where) {
                                if ($check_js) {
                                  $where = $where . "OR (hkm_dokumen.jenis_dokumen = '$jdkm' AND hkm_dokumen.user_upload = '$id') OR (hkm_dokumen.jenis_dokumen = '$jdkm' AND hkm_dokumen.akses_for LIKE '%$id%') ";
                                } else {
                                  $where = $where . " AND (hkm_dokumen.jenis_dokumen = '$jdkm'  ";
                                  $check_js = true;
                                }
                              } else {
                                $check_where = true;
                                $check_js = true;
                                $where = "WHERE ((hkm_dokumen.jenis_dokumen = '$jdkm' AND hkm_dokumen.user_upload = '$id') OR (hkm_dokumen.jenis_dokumen = '$jdkm' AND hkm_dokumen.akses_for LIKE '%$id%') ";
                              }
                            }
                            $where = $where . ')';
                          }
                          if (!empty($bag_pemilik)) {
                            $bag_pemiliks = explode(",", $bag_pemilik);
                            $check_bp = false;
                            foreach ($bag_pemiliks as $jdkm) {
                              if ($check_where) {
                                if ($check_bp) {
                                  $where = $where . "OR (hkm_dokumen.user_upload = '$jdkm' ) OR (hkm_dokumen.user_upload = '$jdkm' AND hkm_dokumen.akses_for LIKE '%$id%') ";
                                } else {
                                  $check_bp = true;
                                  $where = $where . "AND (hkm_dokumen.user_upload = '$jdkm' ";
                                }
                              } else {
                                $check_where = true;
                                $check_bp = true;
                                $where = "WHERE (hkm_dokumen.user_upload = '$jdkm') OR (hkm_dokumen.user_upload = '$jdkm' AND hkm_dokumen.akses_for LIKE '%$id%' ";
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
                              $crv_tgl_awal = str_replace("/", "-", $format_tgl_awal);
                              $crv_tgl_akhir = str_replace("/", "-", $format_tgl_akhir);
                              if ($check_where) {
                                if ($check_rs) {
                                  $where = $where . "OR ((hkm_dokumen.tanggal BETWEEN '$crv_tgl_awal' AND '$crv_tgl_akhir')  AND (hkm_dokumen.user_upload = '$id'))  ";
                                } else {
                                  $check_rs = true;
                                  $where = $where . "AND ((hkm_dokumen.tanggal BETWEEN '$crv_tgl_awal' AND '$crv_tgl_akhir') AND (hkm_dokumen.user_upload = '$id')";
                                }
                              } else {
                                $check_where = true;
                                $check_rs = true;
                                $where = "WHERE ((hkm_dokumen.user_upload = '$id') OR (hkm_dokumen.akses_for LIKE '%$id%' )) AND ((hkm_dokumen.tanggal BETWEEN '$crv_tgl_awal' AND '$crv_tgl_akhir') ";
                              }
                              $where = $where . ')';
                            }
                          }
                          $query_dokumen = $this->db->query("SELECT * FROM `hkm_dokumen`
              LEFT JOIN tb_user ON hkm_dokumen.user_upload = tb_user.id
              LEFT JOIN hkm_master_jenis_dokumen ON hkm_dokumen.jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen
              $where ");
                          // echo $where;die();
                          $data1['data_dokumen'] = $query_dokumen->result_array();
                          $data1['user'] = $this->model_dokumen->tampil_data_user()->result();
                          // echo json_encode($data1['data_dokumen']);
                          // die();
                          $this->load->view('cetak_hukum_pdf', $data1);
                          $html = $this->output->get_output();
                          $this->dompdf->load_html($html);
                          $this->dompdf->render();
                          $this->dompdf->stream("cetak_dokumen_hukum.pdf");
                        }
                      }
                          ?>