<?php
class model_userdms extends CI_Model{
  public function tampil_data(){
    return $this->db->get('tb_user');
  }
  public function tambah_userdms($data,$tables){
      $this->db->insert($tables,$data);
  }
  public function edit_userdms($where,$tables){
    return $this->db->get_where($tables,$where);
  }
  public function update_userdms($where,$data,$tables){
      $this->db->where($where);
      $this->db->update($tables,$data);
  }
  // public function hapus_region($where,$tables){
  //   $this->db->where($where);
  //   $this->db->delete($tables);
  // } 
  public function cek_data($username) {
    $this->db->where('username', $username);
    return $this->db->get('tb_user'); 
  }
}
?>
