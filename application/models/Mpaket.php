<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpaket extends CI_Model{

    public function get(){
        return $this->db->get('paket');
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
}