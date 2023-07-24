<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller{
    function __construct(){
        parent::__construct();
        if($this->session->userdata('logged') !=TRUE){
            $url=base_url('auth');
            redirect($url);  
        };
    }
    public function index(){
        $user = $this->Muser->ambil_data($this->session->userdata['name']);
        $data = [
            'title' => 'Home',
            'current_page' => 'home',
            'username' => $user->username,
            'role' => $user->user_akses,

        ];
        $this->load->view('siswa/templates/header',$data);
        $this->load->view('siswa/index');
        $this->load->view('siswa/templates/footer');
    }
    public function histori(){
        $data['title'] = 'Histori Pembayaran';
        $data['current_page'] = "histori";
        $data['siswas'] = $this->db->query("select * from siswa")->result();
		$data['user'] = $this->Mlogin->get_where('user', ['id' => $this->session->userdata('id')])->row_array();

		$this->form_validation->set_rules('nis', 'NIS', 'required|trim', ['required' => 'NIS wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
            $this->load->view('siswa/templates/header',$data);
            $this->load->view('siswa/data_spp');
            $this->load->view('siswa/templates/footer');
		} else {
			$this->cariHistori();
		}
	}
    public function cariHistori(){
            $data['title'] = 'Data SPP';
            $data['current_page'] = "spp";
            $data['user'] = $this->Mlogin->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
            $nis = $this->input->post('nis', true);
            $where = ['nis' => $nis];
            $data['siswa'] = $this->Mbilling->get_where('siswa', $where)->row_array();
            $data['siswas'] = $this->db->query("select * from siswa")->result();
            $idSiswa = $data['siswa']['id_siswa'];
    
            if($data['siswa'] == null) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> NIS Siswa <strong>'. $nis .'</strong> Tidak Terdaftar.</div>');
                redirect('home/data_spp');
            }
    
            $where = $idSiswa;
            $data['spp'] = $this->db->query("select * from spp where id_siswa='$where' and ket='lunas' or ket='cicilan'")->result_array();
            $this->load->view('siswa/templates/header',$data);
            $this->load->view('siswa/histori');
            $this->load->view('siswa/templates/footer');
        }
    
    public function data_spp(){
        $data['title'] = 'Data SPP';
        $data['current_page'] = "data_spp";
        $data['siswas'] = $this->db->query("select * from siswa")->result();
		$data['user'] = $this->Mlogin->get_where('user', ['id' => $this->session->userdata('id')])->row_array();

		$this->form_validation->set_rules('nis', 'NIS', 'required|trim', ['required' => 'NIS wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
            $this->load->view('siswa/templates/header',$data);
            $this->load->view('siswa/data_spp');
            $this->load->view('siswa/templates/footer');
		} else {
			$this->cariTransaksi();
		}
	}
    public function cariTransaksi(){
            $data['title'] = 'Data SPP';
            $data['current_page'] = "spp";
            $data['user'] = $this->Mlogin->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
            $nis = $this->input->post('nis', true);
            $where = ['nis' => $nis];
            $data['siswa'] = $this->Mbilling->get_where('siswa', $where)->row_array();
            $data['siswas'] = $this->db->query("select * from siswa")->result();
            $idSiswa = $data['siswa']['id_siswa'];
    
            if($data['siswa'] == null) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> NIS Siswa <strong>'. $nis .'</strong> Tidak Terdaftar.</div>');
                redirect('home/data_spp');
            }
    
            $where = ['id_siswa' => $idSiswa];
            $data['spp'] = $this->Mbilling->get_where('spp', $where)->result_array();
            $this->load->view('siswa/templates/header',$data);
            $this->load->view('siswa/data_spp');
            $this->load->view('siswa/templates/footer');
        }
        public function profile(){
            $where = $this->session->userdata('id');
            $data = [
                'title' => 'Profile',
                'current_page' => 'profile'
            ];
            $data['profile'] = $this->db->query("select * from user where id='$where'")->result();
            $this->load->view('siswa/templates/header',$data);
            $this->load->view('siswa/profil');
            $this->load->view('siswa/templates/footer');
        }
    
}