<?php
class model_subbagian extends CI_Model{
  public function tampil_data(){
    return $this->db->get('tb_sub_bagian');
  }
  public function tambah_subbagian($data,$tables){
      $this->db->insert($tables,$data);
  }
  public function edit_subbagian($where,$tables){
    return $this->db->get_where($tables,$where);
  }
  public function update_subbagian($where,$data,$tables){
      $this->db->where($where);
      $this->db->update($tables,$data);
  }
  // public function hapus_region($where,$tables){
  //   $this->db->where($where);
  //   $this->db->delete($tables);
  // }
  public function cek_data($nama_subbagian) {
    $this->db->where('nama_sub_bag', $nama_subbagian);
    return $this->db->get('tb_sub_bagian'); 
  }
}
?>
