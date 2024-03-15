<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use CodeIgniter\HTTP\RequestInterface;


class c_import_excel_doc extends CI_Controller{

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

  public function uploadPDF()
    {
        
        $files = $this->request->getFiles('pdf');
        var_dump($this->request->getFiles());
        $uploadPath = WRITEPATH . 'uploads/'; // Direktori untuk menyimpan file

        foreach ($files as $file)
        {
            if ($file->isValid() && !$file->hasMoved())
            {
                // Salin file ke direktori uploads tanpa mengubah namanya
                $file->move($uploadPath, $file->getName());
            }

            redirect('c_pengelolah_dokumen_dms/doc_internal');
        }
        
        
    }

  public function importData() {
    $this->load->library('upload');
    $item_dok_massal = $this->input->post('item_dok_massal');

  
    if ($this->input->post('upload')) {
        
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'xlsx|pdf';
        

      
        $this->upload->initialize($config);

        $files = $_FILES['pdf'];

        // Loop melalui semua file PDF yang diunggah
        $file_count = count($files['name']);
        for ($i = 0; $i < $file_count; $i++) {
            $_FILES['pdf']['name'] = $files['name'][$i];
            $_FILES['pdf']['type'] = $files['type'][$i];
            $_FILES['pdf']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['pdf']['error'] = $files['error'][$i];
            $_FILES['pdf']['size'] = $files['size'][$i];
            
            $this->upload->do_upload('pdf');
        }

        if ($this->upload->do_upload('file_excel')) {
            $fileData = $this->upload->data();
            $filePath = './uploads/'.$fileData['file_name'];
            
            // Menggunakan PhpSpreadsheet untuk membaca data Excel
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            // Baris awal yang ingin Anda mulai baca (misalnya, mulai dari baris ke-4)
            $startRow = 4;

            $nomor_urut = $this->db->query('SELECT MAX(id_dokumen) AS last_nomor_urut FROM hkm_dokumen_dms')
                                 ->row()->last_nomor_urut;

            $startIndukDokumen = $nomor_urut+1;

            $excelData = array();
            foreach ($worksheet->getRowIterator($startRow) as $row) {
                $rowData = array();

                foreach ($row->getCellIterator() as $cell) {
                    $rowData[] = $cell->getValue();
                }

                // Simpan data hanya jika ada data pada baris ini
                if (!empty(array_filter($rowData))) {
                    $excelData[] = $rowData;
                }
            }

            if($item_dok_massal == 'dokumen_internal')
            {
                $jenis_dokumen = 'Dokumen Internal';
                $redirectPath = 'c_pengelolah_dokumen_dms/doc_internal'; // Redirect ke halaman internal
            }
            else if($item_dok_massal == 'dokumen_eksternal')
            {
                $jenis_dokumen = 'Dokumen Eksternal';
                $redirectPath = 'c_pengelolah_dokumen_dms/doc_external'; // Redirect ke halaman eksternal
            }
                foreach ($excelData as $row) {
                    $akses_for = $row[4];
                    $region = $row[13];
                    $tgl_terbit = null; // Inisialisasi tanggal terbit dengan null
                    $tgl_tetap = null; // Inisialisasi tanggal tetap dengan null

                    if($akses_for=='ABGN'){
                        $allbagian = $this->db->query("SELECT kode FROM `tb_master_bagian`")->result();
                              foreach ($allbagian as $all_bagian) {
                                if ($all_bagian->kode) {
                                  $data_allbagian[] = $all_bagian->kode;
                                }
                              }
                        $all_kebun = $data_allbagian;
                        $akses_for = $all_kebun;
                    }
                    else{
                        //selain ABGN bisa diupload
                        $akses_for = explode(',', $row[4]);
                    }


                    if($region=='ARGN'){
                        $allreg = $this->db->select('id_regional')->get('tb_regional_n2')->result();
                              foreach ($allreg as $allregion) {
                                if ($allregion->id_regional) {
                                  $data_allregion[] = $allregion->id_regional;
                                }
                              }
                        $all_region = $data_allregion;
                        $region = $all_region;
                    }
                    else{
                        //selain ARGN bisa diupload
                        $region  = explode(',', $row[13]);
                    }

                    // Cek apakah sel Excel yang berisi tanggal terbit tidak kosong
                    if (!empty($row[5])) {
                        // Ambil nilai sel Excel yang berisi tanggal terbit
                        $excelDate = $row[5];

                        // Ubah nilai sel Excel yang berisi tanggal terbit menjadi objek DateTime
                        $tgl_terbit = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelDate)->format('Y-m-d');
                    }

                    // Cek apakah sel Excel yang berisi tanggal tetap tidak kosong
                    if (!empty($row[6])) {
                        // Ambil nilai sel Excel yang berisi tanggal tetap
                        $excelDate = $row[6];

                        // Ubah nilai sel Excel yang berisi tanggal tetap menjadi objek DateTime
                        $tgl_tetap = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelDate)->format('Y-m-d');
                    }
                    
                    $data = array(
                        'nama_dokumen' => $row[0], // Sesuaikan dengan kolom Excel Anda
                        'item_dokumen' => $jenis_dokumen,
                        'status_dok' => 'Dokumen Aktif',
                        'status_rev' => $row[1],
                        'jenis_dokumen' => $row[2],
                        'induk_dokumen' => $startIndukDokumen++,
                        'tentang' => $row[3],
                        'akses_for' => implode(",", $akses_for),
                        'tgl_terbit' => $tgl_terbit, // Gunakan tanggal yang sudah diubah formatnya
                        'tgl_tetap' => $tgl_tetap, // Gunakan tanggal yang sudah diubah formatnya
                        'upload_dokumen' => $row[7],
                        'password' => $this->encryption->encrypt($row[8]),
                        'id_level_dok' => $row[9],
                        'id_media_simpan_dok' => $row[10],
                        'no_dokumen' => $row[11],
                        'metode_indeks' => $row[12],
                        'id_regional' => implode(",", $region),
                        'bagian_penerbit' => $row[14],
                        // ... tambahkan kolom lain sesuai kebutuhan
                    );
    
                    // Memasukkan data ke database
                    $this->db->insert('hkm_dokumen_dms', $data); // Ganti 'nama_tabel' sesuai dengan nama tabel Anda
                }
                unlink($filePath);
            // Tampilkan pesan sukses jika perlu
            redirect($redirectPath);

        } else {
            // Tampilkan pesan error jika ada masalah dengan unggahan
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('tambah-pengelolah_dokumen_dms', $error);
        }
    }
}



public function importJenisDokumen() {
    if ($this->input->post('upload')) {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'xlsx';
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('file_excel')) {
            $fileData = $this->upload->data();
            $filePath = './uploads/'.$fileData['file_name'];

            // Menggunakan PhpSpreadsheet untuk membaca data Excel
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();

            // Baris awal yang ingin Anda mulai baca (misalnya, mulai dari baris ke-4)
            $startRow = 4;

            $nomor_urut = $this->db->query('SELECT MAX(id_jenis_dokumen) AS last_nomor_urut FROM hkm_master_jenis_dokumen')
                                 ->row()->last_nomor_urut;

            $startIndukDokumen = $nomor_urut+1;


            $excelData = array();
            foreach ($worksheet->getRowIterator($startRow) as $row) {
                $rowData = array();

                foreach ($row->getCellIterator() as $cell) {
                    $rowData[] = $cell->getValue();
                }

                // Simpan data hanya jika ada data pada baris ini
                if (!empty(array_filter($rowData))) {
                    $excelData[] = $rowData;
                }
            }

                foreach ($excelData as $row) {
                    $data = array(
                        'nama_jenis_dokumen' => $row[0], // Sesuaikan dengan kolom Excel Anda
                        'status_jenis_dokumen' => 'Dokumen Aktif',
                        'keterangan' => $row[1],
                        'item_dokumen' => $row[2],
                        // ... tambahkan kolom lain sesuai kebutuhan
                    );
    
                    // Memasukkan data ke database
                    $this->db->insert('hkm_master_jenis_dokumen', $data); // Ganti 'nama_tabel' sesuai dengan nama tabel Anda
                }
            // Tampilkan pesan sukses jika perlu
            $this->session->set_flashdata('something', 'Pesan Terkirim');
            redirect('c_jenis_pengelolah_dokumen');
        } else {
            // Tampilkan pesan error jika ada masalah dengan unggahan
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('tambah-master_jenis_pengelolah_dokumen', $error);
        }
    }
}

}