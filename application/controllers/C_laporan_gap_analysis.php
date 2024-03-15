<?php
error_reporting(0);

class C_laporan_gap_analysis extends CI_Controller{
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
  public function excel_legal_ijin()
  {   
    $id = $this->session->userdata('id');
    $query_legal_ijin= $this->db->query("SELECT *, tb_master_bagian.id_bagian FROM gap_legal_ijin
      LEFT JOIN tb_master_bagian ON gap_legal_ijin.id_kebun = tb_master_bagian.id_bagian
      WHERE gap_legal_ijin.status = '0' ORDER BY id_legal_ijin DESC");
    $query_notifikasi = $this->db->query("SELECT *,tb_dokumen.id AS iddkm FROM tb_dokumen 
    LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
    WHERE tb_dokumen.id_user = '$id' && pengingat = '1'");
    $jumlah_query_notifikasi = $this->db->query("SELECT *,COUNT(tb_dokumen.id) AS jn FROM tb_dokumen 
    LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
    WHERE tb_dokumen.id_user = '$id' && pengingat = '1'");
    $data['notifikasi_reminder'] = $query_notifikasi->result_array();
    $data['jumlah_notifikasi_reminder'] = $jumlah_query_notifikasi->result_array();
    $data['legal_ijin'] = $query_legal_ijin->result_array();
    $this->load->view('cetak_gap_legal_ijin_excel', $data);
  }
  public function pdf_legal_ijin()
  {   
    $this->load->library('dompdf_gen');

    $query_legal_ijin= $this->db->query("SELECT *, tb_master_bagian.id_bagian FROM gap_legal_ijin
      LEFT JOIN tb_master_bagian ON gap_legal_ijin.id_kebun = tb_master_bagian.id_bagian
      WHERE gap_legal_ijin.status = '0' ORDER BY id_legal_ijin DESC");
    $data['legal_ijin'] = $query_legal_ijin->result_array();
    $this->load->view('cetak_gap_legal_ijin_pdf', $data);
    
    $html = $this->output->get_output();
    $this->dompdf->load_html($html);
    $this->dompdf->render();
    $this->dompdf->stream("Legalitas dan Perijinan.pdf");
  }
  public function excel_pengelolaan_kebun()
  {   
    $id = $this->session->userdata('id');
    $query_pengolaan_kebun= $this->db->query("SELECT *, tb_master_bagian.id_bagian FROM gap_pengelolaan_kebun
      LEFT JOIN tb_master_bagian ON gap_pengelolaan_kebun.id_kebun = tb_master_bagian.id_bagian
      WHERE gap_pengelolaan_kebun.status = '0' ORDER BY id_olah_keb DESC");
    $query_notifikasi = $this->db->query("SELECT *,tb_dokumen.id AS iddkm FROM tb_dokumen 
    LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
    WHERE tb_dokumen.id_user = '$id' && pengingat = '1'");
    $jumlah_query_notifikasi = $this->db->query("SELECT COUNT(*) AS jn FROM tb_dokumen 
    LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
    WHERE tb_dokumen.id_user = '$id' && pengingat = '1'");
    $data['notifikasi_reminder'] = $query_notifikasi->result_array();
    $data['jumlah_notifikasi_reminder'] = $jumlah_query_notifikasi->result_array();
    $data['pengelolaan_kebun'] = $query_pengolaan_kebun->result_array();
    $this->load->view('cetak_gap_pengelolaan_kebun_excel', $data);
  }
  public function pdf_pengelolaan_kebun()
  {   
    $this->load->library('dompdf_gen');
    $id = $this->session->userdata('id');
    $pengelolaan_kebun= $this->db->query("SELECT *, tb_master_bagian.id_bagian FROM gap_pengelolaan_kebun
      LEFT JOIN tb_master_bagian ON gap_pengelolaan_kebun.id_kebun = tb_master_bagian.id_bagian
      WHERE gap_pengelolaan_kebun.status = '0' ORDER BY id_olah_keb DESC");
    $query_notifikasi = $this->db->query("SELECT *,tb_dokumen.id AS iddkm FROM tb_dokumen 
    LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
    WHERE tb_dokumen.id_user = '$id' && pengingat = '1'");
    $jumlah_query_notifikasi = $this->db->query("SELECT *,COUNT(tb_dokumen.id) AS jn FROM tb_dokumen 
    LEFT JOIN tb_user ON tb_dokumen.id_user = tb_user.id
    WHERE tb_dokumen.id_user = '$id' && pengingat = '1'");
    $data['notifikasi_reminder'] = $query_notifikasi->result_array();
    $data['jumlah_notifikasi_reminder'] = $jumlah_query_notifikasi->result_array();
    $data['pengelolaan_kebun'] = $pengelolaan_kebun->result_array();
    $this->load->view('cetak_gap_pengelolaan_kebun_pdf', $data);
    
    $html = $this->output->get_output();
    $this->dompdf->load_html($html);
    $this->dompdf->render();
    $this->dompdf->stream("Pengelolaan Kebun.pdf");
  }
  public function pdf_permasalahan_hub_industri()
  {   
    $this->load->library('dompdf_gen');
    $id = $this->session->userdata('id');
    $query_prmslhan_hub_industrial= $this->db->query("SELECT * FROM gap_prmslhan_hub_industrial ");
    $data['prmslhan_hub_industrial'] = $query_prmslhan_hub_industrial->result_array();
    $this->load->view('cetak_gap_permasalahan_hub_industri_pdf', $data);
    
    $html = $this->output->get_output();
    $this->dompdf->load_html($html);
    $this->dompdf->render();
    $this->dompdf->stream("Permasalahan Hubungan Industrial.pdf");
  }
  public function excel_permasalahan_hub_industri()
  {   
    $id = $this->session->userdata('id');
    $query_prmslhan_hub_industrial= $this->db->query("SELECT * FROM gap_prmslhan_hub_industrial ");
    $data['prmslhan_hub_industrial'] = $query_prmslhan_hub_industrial->result_array();
    $this->load->view('cetak_gap_permasalahan_hub_industri_excel', $data);
  }
  public function pdf_sosial_lingkungan()
  {   
    $this->load->library('dompdf_gen');
    $id = $this->session->userdata('id');
    $query_sosial_lingkungan= $this->db->query("SELECT *,gap_master_lsm.nama_lsm AS namaLSM  FROM gap_sosial_lingkungan
    LEFT JOIN gap_master_lsm ON gap_sosial_lingkungan.nama_lsm = gap_master_lsm.id_lsm 
    WHERE status='0'");
    $data['sosial_lingkungan'] = $query_sosial_lingkungan->result_array();
    $this->load->view('cetak_gap_sosial_lingkungan_pdf', $data);
    
    $html = $this->output->get_output();
    $this->dompdf->load_html($html);
    $this->dompdf->render();
    $this->dompdf->stream("Sosial dan Lingkungan.pdf");
  }
  public function excel_sosial_lingkungan()
  {   
    $id = $this->session->userdata('id');
    $query_prmslhan_hub_industrial= $this->db->query("SELECT *,gap_master_lsm.nama_lsm AS namaLSM  FROM gap_sosial_lingkungan
    LEFT JOIN gap_master_lsm ON gap_sosial_lingkungan.nama_lsm = gap_master_lsm.id_lsm 
    WHERE status='0'");
    $data['sosial_lingkungan'] = $query_prmslhan_hub_industrial->result_array();
    $this->load->view('cetak_gap_sosial_lingkungan_excel', $data);
  }

  public function pdf_perkara()
  {   
    $this->load->library('dompdf_gen');
    $id = $this->session->userdata('id');
    $query_perkara= $this->db->query("SELECT * FROM gap_perkara
      WHERE status='0'");
      $data['perkara'] = $query_perkara->result_array();
    $this->load->view('cetak_gap_perkara_pdf', $data);
    
    $html = $this->output->get_output();
    $this->dompdf->load_html($html);
    $this->dompdf->render();
    $this->dompdf->stream("Perkara.pdf");
  }
  public function excel_perkara()
  {   
    $id = $this->session->userdata('id');
    $query_perkara= $this->db->query("SELECT * FROM gap_perkara
      WHERE status='0'");
      $data['perkara'] = $query_perkara->result_array();
    $this->load->view('cetak_gap_perkara_excel', $data);
  }

  public function pdf_perkara_lainnya()
  {   
    $this->load->library('dompdf_gen');
    $id = $this->session->userdata('id');
    $query_perkara= $this->db->query("SELECT * FROM gap_perkara_lainnya
      WHERE status='0'");
      $data['perkara'] = $query_perkara->result_array();
    $this->load->view('cetak_gap_perkara_lainnya_pdf', $data);
    
    $html = $this->output->get_output();
    $this->dompdf->load_html($html);
    $this->dompdf->render();
    $this->dompdf->stream("Perkara Lainnya.pdf");
  }
  public function excel_perkara_lainnya()
  {   
    $id = $this->session->userdata('id');
    $query_perkara= $this->db->query("SELECT * FROM gap_perkara_lainnya
      WHERE status='0'");
      $data['perkara'] = $query_perkara->result_array();
    $this->load->view('cetak_gap_perkara_lainnya_excel', $data);
  }

  public function pdf_non_perkara()
  {   
    $this->load->library('dompdf_gen');
    $id = $this->session->userdata('id');
    $query_non_perkara= $this->db->query("SELECT * FROM gap_non_perkara
      WHERE status='0'");
      $data['non_perkara'] = $query_non_perkara->result_array();
    $this->load->view('cetak_gap_non_perkara_pdf', $data);
    
    $html = $this->output->get_output();
    $this->dompdf->load_html($html);
    $this->dompdf->render();
    $this->dompdf->stream("Non Perkara.pdf");
  }
  public function excel_non_perkara()
  {   
    $query_non_perkara= $this->db->query("SELECT * FROM gap_non_perkara
      WHERE status='0'");
      $data['non_perkara'] = $query_non_perkara->result_array();
    $this->load->view('cetak_gap_non_perkara_excel', $data);
  }
  public function pdf_infrastruktur_pendukung()
  {   
    $this->load->library('dompdf_gen');
    $id = $this->session->userdata('id');
    $query_infrastruktur_pendukung= $this->db->query("SELECT *, tb_master_bagian.id_bagian FROM gap_infrastruktur_pendukung
      LEFT JOIN tb_master_bagian ON gap_infrastruktur_pendukung.id_kebun = tb_master_bagian.id_bagian
      WHERE gap_infrastruktur_pendukung.status = '0'");
    $data['infrastruktur_pendukung'] = $query_infrastruktur_pendukung->result_array();
    $this->load->view('cetak_gap_infrastruktur_pendukung_pdf', $data);
    
    $html = $this->output->get_output();
    $this->dompdf->load_html($html);
    $this->dompdf->render();
    $this->dompdf->stream("Infrastruktur Pendukung.pdf");
  }
  public function excel_infrastruktur_pendukung()
  {   
    $query_infrastruktur_pendukung= $this->db->query("SELECT *, tb_master_bagian.id_bagian FROM gap_infrastruktur_pendukung
      LEFT JOIN tb_master_bagian ON gap_infrastruktur_pendukung.id_kebun = tb_master_bagian.id_bagian
      WHERE gap_infrastruktur_pendukung.status = '0'");
    $data['infrastruktur_pendukung'] = $query_infrastruktur_pendukung->result_array();
    $this->load->view('cetak_gap_infrastruktur_pendukung_excel', $data);
  }
  public function pdf_ksi_infrastruktur_pendukung($id)
  {   
    $this->load->library('dompdf_gen');
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_infrastruktur_pendukung 
    WHERE id_infra_pen = '$id' ORDER BY id_histori_infra_pen DESC ");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();

    $this->load->view('cetak_gap_ksi_infra_pend_pdf', $data);
    
    $html = $this->output->get_output();
    $this->dompdf->load_html($html);
    $this->dompdf->render();
    $this->dompdf->stream("KSI_Infrastruktur Pendukung.pdf");
  }
  public function excel_ksi_infrastruktur_pendukung($id)
  {   
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_infrastruktur_pendukung 
    WHERE id_infra_pen = '$id' ORDER BY id_histori_infra_pen DESC ");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();
    $this->load->view('cetak_gap_ksi_infra_pend_excel', $data);
  }
  public function pdf_ksi_legal_ijin($id)
  {   
    $this->load->library('dompdf_gen');
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_legal_ijin 
    WHERE gap_histori_legal_ijin.id_legal_ijin = '$id' ORDER BY id_histori_li DESC ");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();

    $this->load->view('cetak_gap_ksi_legal_ijin_pdf', $data);
    
    $html = $this->output->get_output();
    $this->dompdf->load_html($html);
    $this->dompdf->render();
    $this->dompdf->stream("KSI Legalitas dan Perijinan.pdf");
  }
  public function excel_ksi_legal_ijin($id)
  {   
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_legal_ijin 
    WHERE gap_histori_legal_ijin.id_legal_ijin = '$id' ORDER BY id_histori_li DESC ");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();
    $this->load->view('cetak_gap_ksi_legal_ijin_excel', $data);
  }
  public function pdf_pertanahan()
  {   
    $this->load->library('dompdf_gen');
    $query_pertanahan= $this->db->query("SELECT *, tb_master_bagian.id_bagian FROM gap_pertanahan
      LEFT JOIN tb_master_bagian ON gap_pertanahan.id_kebun = tb_master_bagian.id_bagian
      WHERE gap_pertanahan.status = '0'
      ORDER BY id_pertanahan DESC");
    $data['pertanahan'] = $query_pertanahan->result_array();

    $this->load->view('cetak_gap_pertanahan_pdf', $data);
    
    $html = $this->output->get_output();
    $this->dompdf->load_html($html);
    $this->dompdf->render();
    $this->dompdf->stream("Pertanahan.pdf");
  }
  public function excel_pertanahan()
  {   
    $query_pertanahan= $this->db->query("SELECT *, tb_master_bagian.id_bagian FROM gap_pertanahan
      LEFT JOIN tb_master_bagian ON gap_pertanahan.id_kebun = tb_master_bagian.id_bagian
      WHERE gap_pertanahan.status = '0'
      ORDER BY id_pertanahan DESC");
    $data['pertanahan'] = $query_pertanahan->result_array();
    $this->load->view('cetak_gap_pertanahan_excel', $data);
  }
  public function pdf_ksi_pengelolaan_kebun($id)
  {   
    $this->load->library('dompdf_gen');
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_pengelolaan_kebun 
    WHERE gap_histori_pengelolaan_kebun.id_peng_keb = '$id' ORDER BY id_histori_peng_keb DESC ");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();

    $this->load->view('cetak_gap_ksi_pengelolaan_kebun_pdf', $data);
    
    $html = $this->output->get_output();
    $this->dompdf->load_html($html);
    $this->dompdf->render();
    $this->dompdf->stream("KSI Pengelolaan Kebun.pdf");
  }
  public function excel_ksi_pengelolaan_kebun($id)
  {   
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_pengelolaan_kebun 
    WHERE gap_histori_pengelolaan_kebun.id_peng_keb = '$id' ORDER BY id_histori_peng_keb DESC ");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();
    $this->load->view('cetak_gap_ksi_pengelolaan_kebun_excel', $data);
  }
  public function pdf_ksi_perkara($id)
  {   
    $this->load->library('dompdf_gen');
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_perkara 
    WHERE gap_histori_perkara.id_perkara = '$id' ORDER BY id_histori_perkara DESC");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();

    $this->load->view('cetak_gap_ksi_perkara_pdf', $data);
    
    $html = $this->output->get_output();
    $this->dompdf->load_html($html);
    $this->dompdf->render();
    $this->dompdf->stream("KSI Perkara.pdf");
  }
  public function excel_ksi_perkara($id)
  {   
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_perkara 
    WHERE gap_histori_perkara.id_perkara = '$id' ORDER BY id_histori_perkara DESC");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();
    $this->load->view('cetak_gap_ksi_perkara_excel', $data);
  }

  public function pdf_ksi_perkara_lainnya($id)
  {   
    $this->load->library('dompdf_gen');
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_perkara_lainnya 
    WHERE gap_histori_perkara_lainnya.id_perkara_lainnya = '$id' ORDER BY id_histori_perkara_lainnya DESC");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();

    $this->load->view('cetak_gap_ksi_perkara_lainnya_pdf', $data);
    
    $html = $this->output->get_output();
    $this->dompdf->load_html($html);
    $this->dompdf->render();
    $this->dompdf->stream("KSI Perkara Lainnya.pdf");
  }
  public function excel_ksi_perkara_lainnya($id)
  {   
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_perkara_lainnya 
    WHERE gap_histori_perkara_lainnya.id_perkara_lainnya = '$id' ORDER BY id_histori_perkara_lainnya DESC");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();
    $this->load->view('cetak_gap_ksi_perkara_lainnya_excel', $data);
  }

  public function pdf_ksi_phi($id_permasalahan)
  {   
    $this->load->library('dompdf_gen');
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_prmslhan_hub_industrial 
    WHERE id_permasalahan = '$id_permasalahan' ORDER BY id_histori_permasalahan DESC");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();

    $this->load->view('cetak_gap_ksi_phi_pdf', $data);
    
    $html = $this->output->get_output();
    $this->dompdf->load_html($html);
    $this->dompdf->render();
    $this->dompdf->stream("KSI Permasalahan Hubungan Industrial.pdf");
  }
  public function excel_ksi_phi($id_permasalahan)
  {   
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_prmslhan_hub_industrial 
    WHERE id_permasalahan = '$id_permasalahan' ORDER BY id_histori_permasalahan DESC");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();
    $this->load->view('cetak_gap_ksi_phi_excel', $data);
  }

  public function pdf_ksi_sosial_lingkungan($id)
  {   
    $this->load->library('dompdf_gen');
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_sos_ling 
    WHERE gap_histori_sos_ling.id_sos_lik = '$id' ORDER BY id_histori_sos_ling DESC");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();

    $this->load->view('cetak_gap_ksi_sosling_pdf', $data);
    
    $html = $this->output->get_output();
    $this->dompdf->load_html($html);
    $this->dompdf->render();
    $this->dompdf->stream("KSI Sosial dan Lingkungan.pdf");
  }
  public function excel_ksi_sosial_lingkungan($id)
  {   
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_sos_ling 
    WHERE gap_histori_sos_ling.id_sos_lik = '$id' ORDER BY id_histori_sos_ling DESC");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();
    $this->load->view('cetak_gap_ksi_sosling_excel', $data);
  }
  
  public function pdf_ksi_non_perkara($id)
  {   
    $this->load->library('dompdf_gen');
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_non_perkara 
    WHERE id_non_pekara = '$id' ORDER BY id_histori_non_perkara DESC");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();

    $this->load->view('cetak_gap_ksi_non_perkara_pdf', $data);
    
    $html = $this->output->get_output();
    $this->dompdf->load_html($html);
    $this->dompdf->render();
    $this->dompdf->stream("KSI Non Perkara.pdf");
  }
  public function excel_ksi_non_perkara($id)
  {   
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_non_perkara 
    WHERE id_non_pekara = '$id' ORDER BY id_histori_non_perkara DESC");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();
    $this->load->view('cetak_gap_ksi_non_perkara_excel', $data);
  }

  public function pdf_ksi_pertanahan($id)
  {   
    $this->load->library('dompdf_gen');
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_pertanahan 
    WHERE gap_histori_pertanahan.id_pertanahan = '$id' ORDER BY id_histori_pertanahan DESC ");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();

    $this->load->view('cetak_gap_ksi_pertanahana_pdf', $data);
    
    $html = $this->output->get_output();
    $this->dompdf->load_html($html);
    $this->dompdf->render();
    $this->dompdf->stream("KSI Pertanahan.pdf");
  }
  public function excel_ksi_pertanahan($id)
  {   
    $kondisi_saat_ini = $this->db->query("SELECT * FROM gap_histori_pertanahan 
    WHERE gap_histori_pertanahan.id_pertanahan = '$id' ORDER BY id_histori_pertanahan DESC ");
    $data['kondisi_saat_ini'] = $kondisi_saat_ini->result_array();
    $this->load->view('cetak_gap_ksi_pertanahan_excel', $data);
  }

  public function pdf_demografi()
  {   
    $this->load->library('dompdf_gen');
    $karywantetapkeb = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_demografi_t_k = '1'");
    $pktwkeb = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_demografi_t_k = '2'");
    $hariankeb = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_demografi_t_k = '3'");
    $karywantetappab = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_demografi_t_k = '4'");
    $pktwpab = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_demografi_t_k = '5'");
    $harianpab = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_demografi_t_k = '6'");

    $data['karywantetapkeb'] = $karywantetapkeb->result_array();
    $data['pktwkeb'] = $pktwkeb->result_array();
    $data['hariankeb'] = $hariankeb->result_array();
    $data['karywantetappab'] = $karywantetappab->result_array();
    $data['pktwpab'] = $pktwpab->result_array();
    $data['harianpab'] = $harianpab->result_array();
    $query_kebun= $this->db->query("SELECT * FROM tb_user ");
    $data['kebun'] = $query_kebun->result_array();
    $this->load->view('cetak_gap_demografi_pdf', $data);
    
    $html = $this->output->get_output();
    $this->dompdf->load_html($html);
    $this->dompdf->set_paper("A4", "landscape");
    $this->dompdf->render();
    $this->dompdf->stream("Demografi.pdf", array("Attachment" => 0));
  }
  public function excel_demografi()
  {   
    $karywantetapkeb = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_demografi_t_k = '1'");
    $pktwkeb = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_demografi_t_k = '2'");
    $hariankeb = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_demografi_t_k = '3'");
    $karywantetappab = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_demografi_t_k = '4'");
    $pktwpab = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_demografi_t_k = '5'");
    $harianpab = $this->db->query("SELECT * FROM `gap_demografi_t_k` WHERE id_demografi_t_k = '6'");

    $data['karywantetapkeb'] = $karywantetapkeb->result_array();
    $data['pktwkeb'] = $pktwkeb->result_array();
    $data['hariankeb'] = $hariankeb->result_array();
    $data['karywantetappab'] = $karywantetappab->result_array();
    $data['pktwpab'] = $pktwpab->result_array();
    $data['harianpab'] = $harianpab->result_array();
    $query_kebun= $this->db->query("SELECT * FROM tb_user ");
    $data['kebun'] = $query_kebun->result_array();
    $this->load->view('cetak_gap_demografi_excel', $data);
  }

  public function pdf_ksi_demografi($id_demo)
  {   
    $this->load->library('dompdf_gen');
    $dtl_demo = $this->db->query("SELECT * FROM `gap_histori_demografi` WHERE id_demografi_t_k = $id_demo");
    $data['detail_demografi'] = $dtl_demo->result_array();
    $this->load->view('cetak_gap_ksi_demografi_pdf', $data);
    
    $html = $this->output->get_output();
    $this->dompdf->load_html($html);
    $this->dompdf->set_paper("A4", "landscape");
    $this->dompdf->render();
    $this->dompdf->stream("Demografi.pdf", array("Attachment" => 0));
  }
  public function excel_ksi_demografi($id_demo)
  {   
    $dtl_demo = $this->db->query("SELECT * FROM `gap_histori_demografi` WHERE id_demografi_t_k = $id_demo");
    $data['detail_demografi'] = $dtl_demo->result_array();
    $this->load->view('cetak_gap_ksi_demografi_excel', $data);
  }
  
}