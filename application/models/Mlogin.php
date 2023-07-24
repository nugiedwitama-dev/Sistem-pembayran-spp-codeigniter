<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mlogin extends CI_Model{

	public function get_where($table, $where)
	{
		return $this->db->get_where($table, $where);
	
    }
    public function get($table, $data = null, $where = null)
    {
        if ($data != null) {
            return $this->db->get_where($table, $data)->row_array();
        } else {
            return $this->db->get_where($table, $where)->result_array();
        }
    }

    function query_validasi_email($email){
        $result = $this->db->query("SELECT * FROM user WHERE email='$email' LIMIT 1");
        return $result;
    }
    function query_validasi_password($email,$password){
        $result = $this->db->query("SELECT * FROM user WHERE email='$email' AND password=MD5('$password') LIMIT 1");
        return $result;
    }
}