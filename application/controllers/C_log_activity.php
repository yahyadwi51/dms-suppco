<?php
class C_log_activity extends CI_Controller
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

    $this->load->view('templates/header');
    $this->load->view('templates/sidebar');
    $this->load->view('log_activity');
    $this->load->view('templates/footer');
  }


  public function load_log_data()
  {
    $id = $this->session->userdata('id');
    $username = $this->session->userdata('username');
    $role_id = $this->session->userdata('role_id');
    $id_region = $this->session->userdata('id_region');
    if ($role_id == 6) {
      // Load log data from the database
      $query = $this->db->query("SELECT hkm_dokumen_dms.nama_dokumen, tb_log.*  FROM tb_log 
                                LEFT JOIN hkm_dokumen_dms ON tb_log.id_dokumen = hkm_dokumen_dms.id_dokumen 
                                LEFT JOIN tb_user ON tb_user.username = tb_log.username ORDER BY id_log DESC LIMIT 10000");
    } else if ($role_id == 5 || $role_id == '4' || $role_id == '3') {
      $query = $this->db->query("SELECT hkm_dokumen_dms.nama_dokumen, tb_log.*  FROM tb_log 
                                LEFT JOIN hkm_dokumen_dms ON tb_log.id_dokumen = hkm_dokumen_dms.id_dokumen 
                                LEFT JOIN tb_user ON tb_user.username = tb_log.username  
                                WHERE id_region = '$id_region' ORDER BY id_log DESC LIMIT 10000");
    } else {
      $query = $this->db->query("SELECT hkm_dokumen_dms.nama_dokumen, tb_log.*  FROM tb_log 
                                LEFT JOIN hkm_dokumen_dms ON tb_log.id_dokumen = hkm_dokumen_dms.id_dokumen 
                                LEFT JOIN tb_user ON tb_user.username = tb_log.username  
                                WHERE tb_log.username = '$username' ORDER BY id_log DESC LIMIT 10000");
    }

    $log_data = $query->result_array();

    header('Content-Type: application/json');
    echo json_encode($log_data);
  }

  public function load_log_detail($logId)
  {
    // Load log details for the given logId from the database
    $query = $this->db->query("SELECT hkm_dokumen_dms.nama_dokumen, tb_log.* FROM tb_log 
                                  LEFT JOIN hkm_dokumen_dms ON tb_log.id_dokumen = hkm_dokumen_dms.id_dokumen  
                                  WHERE tb_log.id_log = $logId"); // Make sure to sanitize and validate user input

    if ($query->num_rows() > 0) {
      $log_detail = $query->row_array();

      // Generate the modal content using the fetched data
      $modalContent = '
                City : <span style="color: red;">' . $log_detail['kota'] . '</span> <br>
                Region : <span style="color: red;">' . $log_detail['daerah'] . '</span> <br>
                Country : <span style="color: red;">' . $log_detail['negara'] . '</span> <br>
                Loc : <span style="color: red;">' . $log_detail['lokasi'] . '</span> <br>
                Timezone : <span style="color: red;">' . $log_detail['zonawaktu'] . '</span><br>
                Browser : <span style="color: red;">' . $log_detail['browser'] . '</span>
                <br>
                MAC : <span style="color: red;">' . $log_detail['mac'] . '</span>
                <br>
                Operating Sistem : <span style="color: red;">' . $log_detail['os'] . '</span>';

      echo $modalContent;
    } else {
      echo 'Log detail not found.';
    }
  }

}