<?php
class model_regional extends CI_Model{
  public function tampil_data(){
    return $this->db->get('tb_regional_n2');
  }
  public function tambah_region($data,$tables){
      $this->db->insert($tables,$data);
  }
  public function edit_region($where,$tables){
    return $this->db->get_where($tables,$where);
  }
  public function update_region($where,$data,$tables){
      $this->db->where($where);
      $this->db->update($tables,$data);
  }
  // public function hapus_region($where,$tables){
  //   $this->db->where($where);
  //   $this->db->delete($tables);
  // }

  public function cek_data($nama_regional) {
    $this->db->where('nama_regional', $nama_regional);
    return $this->db->get('tb_regional_n2'); 
}
}
 ?>
