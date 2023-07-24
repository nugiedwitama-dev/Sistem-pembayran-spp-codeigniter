<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Msiswa extends CI_Model{

    public function get(){
        return $this->db->get('siswa');
    }
    public function get_where($table, $where)
	{
		return $this->db->get_where($table, $where);
	}
    public function get_join(){
        $query = "SELECT spp.*, siswa.nis, siswa.nama, siswa.telp FROM spp INNER JOIN siswa ON siswa.id_siswa = spp.id_siswa";
		return $this->db->query($query);
    }
    public function getMax($table, $field, $kode = null)
    {
        $this->db->select_max($field);
        if ($kode != null) {
            $this->db->like($field, $kode, 'after');
        }
        return $this->db->get($table)->row_array()[$field];
    }
	public function insert_data($table, $data)
	{
		$this->db->insert($table, $data);
	}
    public function update($table, $data)
	{
		$this->db->update($table, $data);
	}
    public function delete_data($where,$table){
        $this->db->where($where);
        $this->db->delete($table);
    }
    public function sum_siswa(){
        $query = $this->db->get('siswa');
        if($query->num_rows()>0){
            return $query->num_rows();
        }
        else{
            return 0;
        }
    }

}