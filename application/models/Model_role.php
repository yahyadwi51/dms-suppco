<?php
class model_role extends CI_Model{
  public function tampil_data(){
    return $this->db->get('tb_role');
  }
  public function tambah_role($data,$tables){
      $this->db->insert($tables,$data);
  }
  public function edit_role($where,$tables){
    return $this->db->get_where($tables,$where);
  }
  public function update_role($where,$data,$tables){
      $this->db->where($where);
      $this->db->update($tables,$data);
  }
  // public function hapus_region($where,$tables){
  //   $this->db->where($where);
  //   $this->db->delete($tables);
  // }
}
 ?>
