<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mbilling extends CI_Model{

    public function get(){
        return $this->db->get('pembayaran');
    }
    public function get_join_laporan($mulaiTgl, $sampaiTgl)
	{
		$query = "SELECT spp.*, siswa.nis, siswa.nama, siswa.kelas FROM spp INNER JOIN siswa ON siswa.id_siswa = spp.id_siswa WHERE tgl_bayar BETWEEN '$mulaiTgl' AND '$sampaiTgl' ORDER BY tgl_bayar ASC";
		return $this->db->query($query);
	}
    public function get_where($table, $where)
	{
		return $this->db->get_where($table, $where);
	}
    public function get_join_where($table, $where)
	{
		$this->db->join('siswa', 'siswa.id_siswa = spp.id_siswa');
		return $this->db->get_where($table, $where);
	}
    public function ambil_data($id){
        $this->db->where('id', $id);
        return $this->db->get('spp')->result();
    }
    public function insert_data($data,$table){
        $this->db->insert($table,$data);
    }
    public function update_data($where,$data,$table){
        $this->db->where($where);
        $this->db->update($table,$data);
    }
    public function update_where($table, $data, $where)
	{
		$this->db->where($where);
		$this->db->update($table, $data);
	}
    public function delete_data($where,$table){
        $this->db->where($where);
        $this->db->delete($table);
    }
    public function sum_pembayaran(){
        $this->db->select_sum('jumlah_bayar');
        $query = $this->db->get('pembayaran');
        if($query->num_rows()>0){
            return $query->row()->jumlah_bayar;
        }
        else{
            return 0;
        }
    }
    public function sum_tunggakan(){
        $this->db->select_sum('tunggakan');
        $query = $this->db->get('pembayaran');
        if($query->num_rows()>0){
            return $query->row()->tunggakan;
        }
        else{
            return 0;
        }
    }
    public function jumlah_tunggakan($id){
        $this->db->select_sum('tunggakan');
        $this->db->where('username', $id);
        $query = $this->db->get('pembayaran');
        if($query->num_rows()>0){
            return $query->row()->tunggakan;
        }
        else{
            return 0;
        }
    }
}