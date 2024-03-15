<?php
class Model_auth extends CI_Model{
  public function cek_login(){
    $username = set_value('username');
    $password = set_value('password');

    // $this->load->library('encrypt');

    // $encrypted_string = $this->encrypt->encode($password);

    // $plaintext_string = $this->encrypt->decode("kuAKt3kSoZX5O9jN+JpjbVbXS88qFP/BSGlbSCEvqCMyAChd8sB54hso0SUfy3vstAXVjjXnmLso6ZLbov+A2A==");

    $result   = $this->db->where('username',$username)
                         ->where('password',$password)
                         ->limit(1)
                         ->get('tb_user');
    if($result->num_rows() > 0){
      return $result->row();
    }else {
      return array();
    }
  }

  public function tambah_log($data,$tables){
    $this->db->insert($tables,$data);
}
}