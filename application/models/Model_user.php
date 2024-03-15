<?php
class Model_user extends CI_Model{
  public function tampil_data(){
    return $this->db->get('tb_user');
  }
  public function tambah_user($data,$tables){
      $this->db->insert($tables,$data);
  }
  public function edit_user($where,$tables){
    return $this->db->get_where($tables,$where);
  }
  public function update_user($where,$data,$tables){
      $this->db->where($where);
      $this->db->update($tables,$data);
  }
  public function hapus_user($where,$tables){
    $this->db->where($where);
    $this->db->delete($tables);
  }
  function get_role(){
    $query = $this->db->get('tb_role');
    return $query;  
}
public function get_user_with_bagian($where)
    {
        $this->db->select('tb_user.*, tb_master_bagian.*');
        $this->db->from('tb_user');
        $this->db->join('tb_master_bagian', 'tb_user.id_bagian = tb_master_bagian.id_bagian');
        $this->db->where($where);
        return $this->db->get()->result();
    }

}
 ?>
