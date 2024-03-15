<?php
class Model_jenis_dokumen extends CI_Model{
  public function tampil_data(){
    return $this->db->get('tb_master_jenis_dok');
  }
  public function tambah_jenis_dokumen($data,$tables){
      $this->db->insert($tables,$data);
  }
  public function edit_jenis_dokumen($where,$tables){
    return $this->db->get_where($tables,$where);
  }
  public function update_jenis_dokumen($where,$data,$tables){
      $this->db->where($where);
      $this->db->update($tables,$data);
  }
  public function hapus_jenis_dokumen($where,$tables){
    $this->db->where($where);
    $this->db->delete($tables);
  }
}
 ?>
