<?php
class Model_dokumen extends CI_Model
{
  // var $table = 'v_sop';
  var $table = 'v_dokumen_request';
  var $column_order = array('username', 'no_dokumen', 'nama_dokumen', 'tanggal_req', 'status_req', 'appr_rjc'); //set column field database for datatable orderable
  var $column_search = array('username', 'no_dokumen', 'nama_dokumen', 'tanggal_req', 'status_req', 'appr_rjc'); //set column field database for datatable searchable 
  var $order = array('tanggal_req' => 'desc'); // default order 

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  public function tampil_data()
  {
    return $this->db->get('tb_dokumen');
  }
  public function tampil_data_jenis_dokumen()
  {
    return $this->db->get('tb_master_jenis_dok');
  }

  public function tampil_data_media_simpan()
  {
    return $this->db->get('master_media_simpan');
  }

  public function tampil_data_jenis_pengelolah_dokumen_internal()
  {
    $this->db->where('item_dokumen', 'Internal');
    return $this->db->get('hkm_master_jenis_dokumen');
  }

  public function tampil_data_jenis_pengelolah_dokumen_eksternal()
  {
    $this->db->where('item_dokumen', 'Eksternal');
    return $this->db->get('hkm_master_jenis_dokumen');
  }

  public function tampil_data_bagian_kebun()
  {
    $this->db->select('*');
    $this->db->from('tb_master_bagian');
    $this->db->join('tb_regional_n2', 'tb_master_bagian.id_region = tb_regional_n2.id_regional', 'left');
    return $this->db->get();

  }
  public function tampil_data_user()
  {
    return $this->db->get('tb_user');
  }
  public function tampil_data_role()
  {
    return $this->db->get('tb_role');
  }
  public function tampil_data_kebun()
  {
    ;
    $this->db->where('id_bagian BETWEEN 18 AND 51');
    return $this->db->get('tb_master_bagian');
  }
  public function tambah_dokumen($data, $tables)
  {
    $this->db->insert($tables, $data);
  }
  public function tambah_histori_dokumen($data, $tables)
  {
    $this->db->insert($tables, $data);
  }
  public function edit_dokumen($where, $tables)
  {
    return $this->db->get_where($tables, $where);
  }
  public function update_dokumen($where, $data, $tables)
  {
    $this->db->where($where);
    $this->db->update($tables, $data);
  }
  public function hapus_dokumen($where, $tables)
  {
    $this->db->where($where);
    $this->db->delete($tables);
  }

  public function tambah_request($data, $tables)
  {
    $this->db->insert($tables, $data);
  }

  public function update_request($where, $data, $tables)
  {
    $this->db->where($where);
    $this->db->update($tables, $data);
  }

  private function _get_datatables_query()
  {

    $this->db->from($this->table);

    $i = 0;

    foreach ($this->column_search as $item) // loop column 
    {
      if ($_POST['search']['value']) // if datatable send POST for search
      {

        if ($i === 0) // first loop
        {
          $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
          $this->db->like($item, $_POST['search']['value']);
        } else {
          $this->db->or_like($item, $_POST['search']['value']);
        }

        if (count($this->column_search) - 1 == $i) //last loop
          $this->db->group_end(); //close bracket
      }
      $i++;
    }

    if (isset($_POST['order'])) // here order processing
    {
      $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } else if (isset($this->order)) {
      $order = $this->order;
      $this->db->order_by(key($order), $order[key($order)]);
    }
  }

  function get_datatables()
  {
    $role_id = $this->session->userdata('role_id');
    $username = $this->session->userdata('username');

    $this->_get_datatables_query();
    if ($_POST['length'] != -1)
      $this->db->limit($_POST['length'], $_POST['start']);
    if ($role_id == 6 || $role_id == 5 || $role_id == 3) {
    } else {
      $this->db->where('username', $username); //UNTUK WHERE
    }
    $query = $this->db->get();
    return $query->result();
  }

  function count_filtered()
  {
    // $id_user        = $this->session->userdata('id_user');
    //     $user_aktif     = $this->user_model->detail($id_user);
    $this->_get_datatables_query();
    // $this->db->where('user_to',$id_user);//UNTUK WHERE
    $query = $this->db->get();
    return $query->num_rows();
  }

  public function count_all()
  {
    // $id_user        = $this->session->userdata('id_user');
    //     $user_aktif     = $this->user_model->detail($id_user);
    $this->db->from($this->table);
    // $this->db->where('status','aktif');//UNTUK WHERE
    return $this->db->count_all_results();
  }

  public function getDataFiltered($jenisDokumen, $itemDokumen, $statusDok, $levelDok, $mediaSimpan, $tanggalAwal, $tanggalAkhir)
  {
    // Lakukan query ke database
    $this->db->select('*');
    $this->db->from('hkm_dokumen_dms'); // Tabel utama

    // Gabungkan dengan tabel master_media_simpan menggunakan LEFT JOIN
    $this->db->join('master_media_simpan', 'master_media_simpan.id_media_simpan_dok = hkm_dokumen_dms.id_media_simpan_dok', 'left');

    // Gabungkan dengan tabel hkm_master_jenis_dokumen menggunakan INNER JOIN berdasarkan id_jenis_dokumen
    $this->db->join('hkm_master_jenis_dokumen', 'hkm_master_jenis_dokumen.id_jenis_dokumen = hkm_dokumen_dms.jenis_dokumen', 'inner');

    // Jika tidak ada parameter filter yang diisi, tidak perlu menambahkan kondisi WHERE
    if (!empty($jenisDokumen) || !empty($itemDokumen) || !empty($statusDok) || !empty($levelDok) || !empty($mediaSimpan) || (!empty($tanggalAwal) && !empty($tanggalAkhir))) {
      $this->db->group_start(); // Mulai grup kondisi AND

      if (!empty($jenisDokumen)) {
        $this->db->where('hkm_master_jenis_dokumen.id_jenis_dokumen', $jenisDokumen);
      }

      if (!empty($itemDokumen)) {
        $this->db->where('hkm_dokumen_dms.item_dokumen', $itemDokumen);
      }

      if (!empty($statusDok)) {
        $this->db->where('status_dok', $statusDok);
      }

      if (!empty($levelDok)) {
        $this->db->where('id_level_dok', $levelDok);
      }

      if (!empty($mediaSimpan)) {
        $this->db->where('hkm_dokumen_dms.id_media_simpan_dok', $mediaSimpan);
      }

      if (!empty($tanggalAwal) && !empty($tanggalAkhir)) {
        // Tambahkan kondisi WHERE untuk rentang tanggal_terbit
        $this->db->where('tgl_terbit >=', $tanggalAwal);
        $this->db->where('tgl_terbit <=', $tanggalAkhir);
      }

      $this->db->group_end(); // Akhiri grup kondisi AND
    }

    // Tambahkan klausa ORDER BY
    $this->db->order_by('status_dok', 'ASC');
    $this->db->order_by('id_level_dok', 'ASC');
    $this->db->order_by('id_dokumen', 'DESC');

    $query = $this->db->get();

    return $query->result();
  }



  // public function getDataFiltered($jenisDokumen, $itemDokumen, $statusDok, $levelDok, $mediaSimpan, $tanggalAwal, $tanggalAkhir)
  // {
  //   // Lakukan query ke database
  //   $this->db->select('*');
  //   $this->db->from('hkm_dokumen_dms'); // Tabel utama

  //   // Gabungkan dengan tabel master_media_simpan menggunakan LEFT JOIN
  //   $this->db->join('master_media_simpan', 'master_media_simpan.id_media_simpan_dok = hkm_dokumen_dms.id_media_simpan_dok', 'left');

  //   // Gabungkan dengan tabel hkm_master_jenis_dokumen menggunakan INNER JOIN berdasarkan id_jenis_dokumen
  //   $this->db->join('hkm_master_jenis_dokumen', 'hkm_master_jenis_dokumen.id_jenis_dokumen = hkm_dokumen_dms.jenis_dokumen', 'inner');

  //   // Jika tidak ada parameter filter yang diisi, tidak perlu menambahkan kondisi WHERE
  //   if (!empty($jenisDokumen) || !empty($itemDokumen) || !empty($statusDok) || !empty($levelDok) || !empty($mediaSimpan) || (!empty($tanggalAwal) && !empty($tanggalAkhir))) {
  //     $this->db->group_start(); // Mulai grup kondisi AND

  //     if (!empty($jenisDokumen)) {
  //       $this->db->where('hkm_master_jenis_dokumen.id_jenis_dokumen', $jenisDokumen);
  //     }

  //     if (!empty($itemDokumen)) {
  //       $this->db->where('hkm_dokumen_dms.item_dokumen', $itemDokumen);
  //     }

  //     if (!empty($statusDok)) {
  //       $this->db->where('status_dok', $statusDok);
  //     }

  //     if (!empty($levelDok)) {
  //       $this->db->where('id_level_dok', $levelDok);
  //     }

  //     if (!empty($mediaSimpan)) {
  //       $this->db->where('hkm_dokumen_dms.id_media_simpan_dok', $mediaSimpan);
  //     }

  //     if (!empty($tanggalAwal) && !empty($tanggalAkhir)) {
  //       // Tambahkan kondisi WHERE untuk rentang tanggal_terbit
  //       $this->db->where('tgl_terbit>=', $tanggalAwal);
  //       $this->db->where('tgl_terbit<=', $tanggalAkhir);
  //     }

  //     $this->db->group_end(); // Akhiri grup kondisi AND
  //   }

  //   $query = $this->db->get();

  //   return $query->result();
  // }






}
?>