<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mspp extends CI_Model{

    public function get(){
        return $this->db->get('spp');
    }
    public function getMax($table, $field, $kode = null)
    {
        $this->db->select_max($field);
        if ($kode != null) {
            $this->db->like($field, $kode, 'after');
        }
        return $this->db->get($table)->row_array()[$field];
    }
    public function get_join(){
        $query = "SELECT spp.*, siswa.nis, siswa.nama, siswa.kelas FROM spp INNER JOIN siswa ON siswa.id_siswa = spp.id_siswa";
		return $this->db->query($query);
    }
    public function insert_data($data,$table){
        $this->db->insert($table,$data);
    }
    public function update_data($where,$data,$table){
        $this->db->where($where);
        $this->db->update($table,$data);
    }
    public function delete_data($where,$table){
        $this->db->where($where);
        $this->db->delete($table);
    }
    public function sum_pembayaran(){
        $this->db->select_sum('nominal');
        $query = $this->db->get('spp');
        if($query->num_rows()>0){
            return $query->row()->nominal;
        }
        else{
            return 0;
        }
  
    }
    public function jumlah_tunggakan($id){
        $this->db->select_sum('nominal');
        $this->db->where('username', $id);
        $this->db->where('ket', 'belum_bayar');
        $query = $this->db->get('spp');
        if($query->num_rows()>0){
            return $query->row()->nominal;
        }
        else{
            return 0;
        }
    }

}