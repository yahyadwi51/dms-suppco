<?php
class model_media_simpan extends CI_Model{
  public function tampil_data(){
    return $this->db->get('master_media_simpan');
  }
  public function tambah_media_simpan($data,$tables){
      $this->db->insert($tables,$data);
  }
  public function edit_media_simpan($where,$tables){
    return $this->db->get_where($tables,$where);
  }
  public function update_media_simpan($where,$data,$tables){
      $this->db->where($where);
      $this->db->update($tables,$data);
  }
  public function hapus_media_simpan($where,$tables){
    $this->db->where($where);
    $this->db->delete($tables);
  }
  public function cek_data($media_simpan) {
    $this->db->where('media_simpan', $media_simpan);
    return $this->db->get('master_media_simpan'); // Ganti 'nama_tabel_media_simpan' dengan nama tabel sesungguhnya
}
}
 ?>
