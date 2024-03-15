<?php
class C_dashboard extends CI_Controller{
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
      $id   = $this->session->userdata('id');
      $username   = $this->session->userdata('username');
      $id_bagian = $this->session->userdata('id_bagian');
      $query_total_dashboard     = $this->db->query("SELECT 
                                                        (SELECT COUNT(username) FROM tb_user) AS total_user,
                                                        (SELECT COUNT(id_dokumen) FROM hkm_dokumen_dms) AS total_dokumen,
                                                        (SELECT COUNT(id_bagian) FROM tb_master_bagian) AS total_bagian,
                                                        (SELECT COUNT(id_regional) FROM tb_regional_n2) AS total_regional");
      $data['total_dashboard']  = $query_total_dashboard->result_array();
      $data['id'] = $id;
      // $where = array('id' => $id);
      // $data['user'] = $this->model_user->edit_user($where, 'tb_user')->result();
      // $data['master_bagian'] = $this->model_dokumen->tampil_data_bagian_kebun()->result();
      $where = array('tb_user.id' => $id,
                     'tb_user.id_bagian' => $id_bagian); // Ganti some_column dan some_value dengan kriteria yang sesuai
      $data['user'] = $this->model_user->get_user_with_bagian($where);
      

      $query_view_terbanyak   = $this->db->query("SELECT nama_dokumen, 
                                                        (SELECT COUNT(id_dokumen) FROM tb_log WHERE id_dokumen = hkm_dokumen_dms.id_dokumen AND aktivitas = 'View') 
                                                        AS jumlah FROM hkm_dokumen_dms ORDER BY jumlah DESC LIMIT 5");
      $data['view_terbanyak']  = $query_view_terbanyak->result_array();


         // Mengubah data menjadi format yang dapat digunakan oleh Highcharts
         $chartDataView_terbanyak = [];
         foreach ($data['view_terbanyak'] as $row) {
         $chartDataView_terbanyak[] = [
         'name' => $row['nama_dokumen'],
         'views' => intval($row['jumlah'])
         ];
         }
 
         // Mengonversi data menjadi format JSON
         $chartDataJSONView_terbanyak = json_encode($chartDataView_terbanyak);
 
         // Menyertakan data JSON dalam view
         $data['chartDataJSONView_terbanyak'] = $chartDataJSONView_terbanyak;



         $query_download_terbanyak   = $this->db->query("SELECT nama_dokumen, 
                                                          (SELECT COUNT(id_dokumen) FROM tb_log WHERE id_dokumen = hkm_dokumen_dms.id_dokumen AND aktivitas = 'Download') 
                                                           AS jumlah FROM hkm_dokumen_dms ORDER BY jumlah DESC LIMIT 5");
          $data['download_terbanyak']  = $query_download_terbanyak->result_array();


          // Mengubah data menjadi format yang dapat digunakan oleh Highcharts
          $chartDatadownload_terbanyak = [];
          foreach ($data['download_terbanyak'] as $row) {
          $chartDatadownload_terbanyak[] = [
          'name' => $row['nama_dokumen'],
          'views' => intval($row['jumlah'])
          ];
          }

          // Mengonversi data menjadi format JSON
          $chartDataJSONdownload_terbanyak = json_encode($chartDatadownload_terbanyak);

          // Menyertakan data JSON dalam view
          $data['chartDataJSONdownload_terbanyak'] = $chartDataJSONdownload_terbanyak;   



      $query_view_akses   = $this->db->query("SELECT hkm_dokumen_dms.id_dokumen, hkm_dokumen_dms.nama_dokumen, tb_log.tgl 
                                                      FROM tb_log JOIN hkm_dokumen_dms ON tb_log.id_dokumen = hkm_dokumen_dms.id_dokumen 
                                                      WHERE tb_log.aktivitas = 'view' AND username = '$username' ORDER BY tgl DESC LIMIT 5");
      $data['view_akses']  = $query_view_akses->result_array();





      $query_view_user_regional   = $this->db->query("SELECT nama_regional, 
                                                        (SELECT COUNT(id_region) FROM tb_user WHERE id_region = tb_regional_n2.id_regional) 
                                                        AS jumlah FROM tb_regional_n2");
      $data['view_user_regional']  = $query_view_user_regional->result_array();

      // Mengubah data menjadi format yang dapat digunakan oleh Highcharts
        $chartDataUser = [];
        foreach ($data['view_user_regional'] as $row) {
            $chartDataUser[] = [
                'name' => $row['nama_regional'],
                'y' => intval($row['jumlah'])
            ];
        }

        // Mengonversi data menjadi format JSON
        $chartDataJSONUser = json_encode($chartDataUser);

        // Menyertakan data JSON dalam view
        $data['chartDataJSONUser'] = $chartDataJSONUser;



        $query_view_dokumen  = $this->db->query("SELECT nama_jenis_dokumen, 
                                                                (SELECT COUNT(jenis_dokumen) FROM hkm_dokumen_dms 
                                                                WHERE jenis_dokumen = hkm_master_jenis_dokumen.id_jenis_dokumen) 
                                                                AS jumlah FROM hkm_master_jenis_dokumen");
        $data['view_dokumen']  = $query_view_dokumen->result_array();

        // Mengubah data menjadi format yang dapat digunakan oleh Highcharts
        $chartDataDok = [];
        foreach ($data['view_dokumen'] as $row) {
        $chartDataDok[] = [
        'name' => $row['nama_jenis_dokumen'],
        'y' => intval($row['jumlah'])
        ];
        }

        // Mengonversi data menjadi format JSON
        $chartDataJSONDok = json_encode($chartDataDok);

        // Menyertakan data JSON dalam view
        $data['chartDataJSONDok'] = $chartDataJSONDok;



      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar');
      $this->load->view('dashboard',$data);
      $this->load->view('templates/footer');
  }
  

}