<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function index()
    {
        if ($this->session->userdata('logged') != TRUE) {
            $this->load->view('login');
        } else {
            $url = base_url('home');
            redirect($url);
        }
    }
    public function autentikasi()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $validasi_email = $this->Mlogin->query_validasi_email($email);
        if($validasi_email->num_rows() > 0){
            $validate_ps = $this->Mlogin->query_validasi_password($email,$password);
            if($validate_ps->num_rows() > 0){
                $x = $validate_ps->row_array();
                if($x['user_status']=='1'){
                    $this->session->set_userdata('logged',TRUE);
                    $this->session->set_userdata('user',$email);
                    $id=$x['id'];
                    if($x['user_akses']== '1'){
                        $name = $x['username'];
                        $this->session->set_userdata('access','administrator');
                        $this->session->set_userdata('id',$id);
                        $this->session->set_userdata('name',$name);
                        
                        redirect('dashboard');
                    }else if($x['user_akses']== '2'){
                        $name = $x['username'];
                        $this->session->set_userdata('access','siswa');
                        $this->session->set_userdata('id',$id);
                        $this->session->set_userdata('name',$name);
                        redirect('home');
                    }
                }else{
                    $url=base_url('auth');
                    echo $this->session->set_flashdata('msg',"<span onclick='this.parentElement.style.display='none''class='bg-danger w3-button w3-large w3-display-topright'>&times;</span>
                    <h3>Uupps!</h3>
                    <p> Akunmu nonaktif, silahkan hubungi admin!</p>
                    ");
                    redirect($url);
                }
            }else{
                $url=base_url('auth');
                echo $this->session->set_flashdata('msg',"<span onclick='this.parentElement.style.display='none''class='bg-danger w3-button w3-large w3-display-topright'>&times;</span>
                <h3>Uupps!</h3>
                <p> Password yang kamu masukan salah!</p>
                ");
                redirect($url);
            }
        }else{
            $url=base_url('auth');
            echo $this->session->set_flashdata('msg',"<span onclick='this.parentElement.style.display='none''class='w3-button w3-large w3-display-topright'>&times;</span>
            <h3>Uupps!</h3>
            <p> Email yang kamu masukan salah!</p>
            ");
            redirect($url);
        }
    }
    function logout(){
        $this->session->sess_destroy();
        $url=base_url('auth');
        
        redirect('auth');
        
    }
}
