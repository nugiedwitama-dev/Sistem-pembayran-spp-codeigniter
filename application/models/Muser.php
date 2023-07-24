<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Muser extends CI_Model{

    public function get(){
        return $this->db->get('user');
    }
    public function ambil_data($id){
        $this->db->where('username', $id);
        return $this->db->get('user')->row();
    }
    public function insert_data($data,$table){
        $this->db->insert($table,$data);
    }
    public function update_data($where,$data,$table){
        $this->db->where($where);
        $this->db->update($table,$data);
    }
    public function update($table, $pk, $id, $data)
    {
        $this->db->where($pk, $id);
        return $this->db->update($table, $data);
    }
    public function delete_data($where,$table){
        $this->db->where($where);
        $this->db->delete($table);
    }
    public function get_profile(){
        $email = $this->session->userdata('user');
        return $this->db->query("select * from user where email='$email'");
    }
    public function sum_pengguna(){
        $query = $this->db->get('user');
        if($query->num_rows()>0){
            return $query->num_rows();
        }
        else{
            return 0;
        }
    }

}