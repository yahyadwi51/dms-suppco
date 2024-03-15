<?php

use PhpOffice\PhpSpreadsheet\IOFactory;


class c_import_excel_media_simpan extends CI_Controller{

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

  public function importData() 
  {
    $item_media_simpan_massal = $this->input->post('item_media_simpan_massal');
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
                foreach ($excelData as $row) 
                {
                    
                    $data = array(
                        'media_simpan' => $row[0], // Sesuaikan dengan kolom Excel Anda
                    );
    
                    // Memasukkan data ke database
                    $this->db->insert('master_media_simpan', $data); // Ganti 'nama_tabel' sesuai dengan nama tabel Anda
                }
            // Tampilkan pesan sukses jika perlu
            redirect('c_media_simpan');
        } else {
            // Tampilkan pesan error jika ada masalah dengan unggahan
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('c_media_simpan', $error);
        }
    }
}
}