<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller{
    function __construct(){
        parent::__construct();
        if($this->session->userdata('logged') !=TRUE){
            $url=base_url('auth');
            redirect($url);  
        }
        if($this->session->userdata('access') == 'siswa'){
            $url=base_url('auth');
            redirect($url); 
        $userId = $this->Mlogin->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        }
    }
    public function index(){
        $data = 
        [
            'title' => 'Dashboard',
            'current_page' => 'dashboard',
            'total' => $this->Mspp->sum_pembayaran(),
            'pengguna' => $this->Muser->sum_pengguna(),
            'jumlah_siswa' => $this->Msiswa->sum_siswa(),
            'tunggakan' => $this->db->query("select sum(nominal) from spp where ket='cicilan'")->result(),
            'billing' => $this->Mspp->get()->result(),
            'transaksi' => $this->db->query("select * from spp s, siswa sis where ket='lunas' and s.id_siswa = sis.id_siswa ORDER BY tgl_bayar LIMIT 5")->result(),
            'nunggak' =>  $this->db->query("select * from spp s, siswa sis where ket='cicilan' and s.id_siswa = sis.id_siswa ORDER BY tgl_bayar LIMIT 5")->result(),
            'galbay' => $this->db->query("select * from spp s, siswa sis where ket='belum_bayar' and s.id_siswa = sis.id_siswa ORDER BY tgl_bayar LIMIT 5")->result(),
        ];
        $this->load->view('admin/templates/header',$data);
        $this->load->view('admin/dashboard',);
        $this->load->view('admin/templates/footer');
    }
    public function siswa(){
        $data['title'] = 'Siswa';
        $data['current_page'] = 'siswa';
		$data['user'] = $this->Mlogin->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$data['siswa'] = $this->Msiswa->get('siswa')->result_array();
		$data['kelas'] = $this->Mwali->get('wali_kelas')->result_array();
        // Mengenerate ID Siswa
        $kode_terakhir = $this->Msiswa->getMax('siswa', 'id_siswa');
        $kode_tambah = substr($kode_terakhir, -6, 6);
        $kode_tambah++;
        $number = str_pad($kode_tambah, 6, '0', STR_PAD_LEFT);
        $data['id_siswa'] = 'S-' . $number;
		$this->form_validation->set_rules('nama', 'Nama Siswa', 'required|trim', ['required' => 'Nama Siswa wajib di isi!.']);
		$this->form_validation->set_rules('kelas', 'Kelas', 'required|trim', ['required' => 'Kelas wajib di isi!.']);
		$this->form_validation->set_rules('alamat', 'Kelas', 'required|trim', ['required' => 'Kelas wajib di isi!.']);
		$this->form_validation->set_rules('telp', 'Kelas', 'required|trim', ['required' => 'Kelas wajib di isi!.']);
		$this->form_validation->set_rules('nis', 'NIS', 'required|trim', ['required' => 'NIS wajib di isi!.']);
		$this->form_validation->set_rules('tahun_ajaran', 'Tahun Ajaran', 'required|trim', ['required' => 'Tahun Ajaran wajib di isi!.']);
		$this->form_validation->set_rules('biaya', 'Biaya', 'required|trim', ['required' => 'Biaya wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
			$this->load->view('admin/templates/header', $data);
			$this->load->view('admin/siswa/index', $data);
			$this->load->view('admin/templates/footer');
		} else {
			$biaya = html_escape($this->input->post('biaya', true));
			$data = [
				'id_siswa' => html_escape($this->input->post('id_siswa', true)),
				'nis' => html_escape($this->input->post('nis', true)),
				'nama' => html_escape($this->input->post('nama', true)),
				'kelas' => html_escape($this->input->post('kelas', true)),
				'alamat' => html_escape($this->input->post('alamat', true)),
				'telp' => html_escape($this->input->post('telp', true)),
				'tahun_ajaran' => html_escape($this->input->post('tahun_ajaran', true)),
				'biaya' => $biaya,
			];

			$AwalJatuhTempo = $this->input->post('jatuh_tempo', true);

			// Tampil bulan berdasarkan bhs indonesia
			$bulanIndo = [
				'01' => 'Januari',
				'02' => 'Februari',
				'03' => 'Maret',
				'04' => 'April',
				'05' => 'Mei',
				'06' => 'Juni',
				'07' => 'Juli',
				'08' => 'Agustus',
				'09' => 'September',
				'10' => 'Oktober',
				'11' => 'November',
				'12' => 'Desember'
			];

			// tambah data siswa
			$tbSiswa = $this->db->insert('siswa', $data);
			// if(!$tbSiswa) {
			// 	$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Wali Kelas Berhasil Ditambahkan.</div>');
			// 	redirect('admin/siswa');
			// }

			// Amil data DB siswa berdasarkan id_siswa
			$this->db->limit(1);
			$this->db->order_by('id_siswa', 'desc');
			$siswa = $this->db->get('siswa')->row_array();
			$idSiswa = $siswa['id_siswa'];
            $id_user = $this->Mlogin->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
            $id = $id_user['id'];

			// tagihan (12 bulan dimulai dari Juli 2023 dan menyimpan tagihan ditabel spp)
			for($i = 0; $i < 12; $i++) {
				// membuat tgl jatuh tempo nya setiap tanggal 10
				$jatuhTempo = date('Y-m-d', strtotime("+$i month", strtotime($AwalJatuhTempo)));
				$bulan = $bulanIndo[date('m', strtotime($jatuhTempo))] . " " . date('Y', strtotime($jatuhTempo));

				$data = [
					'id_siswa' => $idSiswa,
					'jatuh_tempo' => $jatuhTempo,
					'bulan' => $bulan,
					'nominal' => $biaya,
                    'ket' => 'belum_bayar',
					'id' => $id
				];
				$this->Msiswa->insert_data('spp', $data);
			}


			
			$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Siswa Berhasil Ditambahkan.</div>');
			redirect('dashboard/siswa');
		}

    }
    public function ubahSiswa($id)
	{
		$data['user'] = $this->Mlogin->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$where = ['id_siswa' => $id];
		$data['siswa'] = $this->Msiswa->get_where('siswa', $where)->row_array();
		$data['kelas'] = $this->Mwali->get('wali_kelas')->result_array();
		$data['title'] = 'Ubah Data Siswa ' . $data['siswa']['nama'];
        $data['current_page'] = 'kelas';

		// Rules Form
		$this->form_validation->set_rules('nama', 'Nama Siswa', 'required|trim', ['required' => 'Nama Siswa wajib di isi!.']);
		$this->form_validation->set_rules('kelas', 'Kelas', 'required|trim', ['required' => 'Kelas wajib di isi!.']);
		$this->form_validation->set_rules('nis', 'NIS', 'required|trim', ['required' => 'NIS wajib di isi!.']);
		$this->form_validation->set_rules('tahun_ajaran', 'Tahun Ajaran', 'required|trim', ['required' => 'Tahun Ajaran wajib di isi!.']);
		$this->form_validation->set_rules('biaya', 'Biaya', 'required|trim', ['required' => 'Biaya wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
			$this->load->view('admin/templates/header', $data);
			$this->load->view('admin/siswa/update', $data);
			$this->load->view('admin/templates/footer');
		} else {
			$this->ubahDataSiswa();
		}
    }
    public function ubahDataSiswa()
	{
		$idSiswa = $this->input->post('id_siswa');
		$data = [
			'nis' => html_escape($this->input->post('nis', true)),
			'nama' => html_escape($this->input->post('nama', true)),
			'kelas' => html_escape($this->input->post('kelas', true)),
			'tahun_ajaran' => html_escape($this->input->post('tahun_ajaran', true)),
			'biaya' => html_escape($this->input->post('biaya', true))
		];
		$this->db->where('id_siswa', $idSiswa);
		$this->Msiswa->update('siswa', $data);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Siswa Berhasil Diubah.</div>');
		redirect('dashboard/siswa');
	}

    public function siswa_delete($id){
        $where = array('id_siswa' =>$id);
        $this->Msiswa->delete_data($where,'siswa');
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show" role="alert">
        Data siswa berhasil di hapus
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>');
        redirect('dashboard/siswa');
    }
     public function sendwa($id_siswa){
        $query = $this->db->query("SELECT sp.id_spp,sp.jatuh_tempo,sp.bulan,sp.nominal, s.nama, s.telp FROM spp sp, siswa s WHERE sp.id_siswa='$id_siswa'");
		
        if($query->num_rows() > 0) {
            $result = $query->result(); 
            foreach( $result as $row)
            {
        $tagihan = $row->nominal-$row->jumlah_bayar;
        $target = "$row->telp|$row->nama|$row->bulan|$row->nominal|$row->jatuh_tempo";
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'target' => $target,
            'message' => 'Informasi SPP Bulanan! Siswa dengan Nama {name} Tagihan SPP anda bulan {var1} adalah Rp. {var2}, mohon dibayarkan sebelum tanggal {var3} Terimakasih, Sistem Informasi SPP PKBM BUDI UTAMA.', 
            'delay' => '2', 
            'countryCode' => '62', //optional
        ),
        CURLOPT_HTTPHEADER => array(
            'Authorization: vR6GidYJFKSIfq37+IXq' //change TOKEN to your actual token
        ),
        ));
        $response = curl_exec($curl);

        curl_close($curl);
     echo $response; 
     $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show" role="alert">
     Notifikasi berhasil terkirim!
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </button>
   </div>');
     redirect('dashboard/siswa');
     }
 }
 }
    public function wali()
    {
        $data['title'] = 'Wali Kelas';
        $data['current_page'] = 'kelas';
		$data['user'] = $this->Mlogin->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$data['guruWali'] = $this->Mwali->get_join('guru', 'wali_kelas')->result_array();
		$data['guru'] = $this->Mwali->get('guru')->result_array();
		$this->form_validation->set_rules('nama', 'Nama Wali Kelas', 'required|trim', ['required' => 'Nama Wali Kelas wajib di isi!.']);
		$this->form_validation->set_rules('kelas', 'Kelas', 'required|trim', ['required' => 'Kelas wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
			$this->load->view('admin/templates/header', $data);
			$this->load->view('admin/kelas/index');
			$this->load->view('admin/templates/footer');
		} else {
			$data = [
				'kelas' => html_escape($this->input->post('kelas', true)),
				'id_guru' => html_escape($this->input->post('nama', true))
			];
			$this->Mwali->insert('wali_kelas', $data);
			$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Wali Kelas Berhasil Ditambahkan.</div>');
			redirect('dashboard/wali');
		}
    }
    public function ubahWali($id_kelas)
    {
        $data['user'] = $this->Mlogin->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $data['current_page'] = 'kelas';
		$data['guruWali'] = $this->db->query("select * from wali_kelas where id_kelas='$id_kelas'")->result();
		$data['guru'] = $this->Mwali->get('guru')->result_array();
		$data['title'] = 'Ubah Data Kelas ';
		$this->form_validation->set_rules('nama', 'Nama Guru', 'required|trim', ['required' => 'Nama guru wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
			$this->load->view('admin/templates/header', $data);
			$this->load->view('admin/kelas/update');
			$this->load->view('admin/templates/footer');
		} else {
			$this->ubahDataWali();
		}
    }
    public function ubahDataWali()
	{
		$kelas = $this->input->post('kelas');
		$data = [
			'id_guru' => html_escape($this->input->post('nama', true))
		];
		$this->db->where('kelas', $kelas);
		$this->Mwali->update('wali_kelas', $data);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Wali Kelas Berhasil Diubah.</div>');
		redirect('dashboard/wali');
	}

	public function hapusWali($id_kelas)
	{
		$this->db->delete('wali_kelas', ['id_kelas' => $id_kelas]);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-trash"></i> Data Wali Kelas Berhasil Dihapus.</div>');
		redirect('dashboard/wali');
	}
    public function guru(){
        $data['title'] = 'Guru';
        $data['current_page'] = 'guru';
		$data['user'] = $this->Mlogin->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$data['guru'] = $this->Mguru->get('guru')->result_array();
		$this->form_validation->set_rules('nama', 'Nama Guru', 'required|trim', ['required' => 'Nama guru wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
			$this->load->view('admin/templates/header', $data);
			$this->load->view('admin/guru/index');
			$this->load->view('admin/templates/footer');
		} else {
			$data = [
				'nama_guru' => html_escape($this->input->post('nama', true))
			];
			$this->Mguru->insert('guru', $data);
			$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Guru Berhasil Ditambahkan.</div>');
			redirect('dashboard/guru');
		}
    }
    public function getguruid()
	{
		echo json_encode($this->Mguru->getGuruId($_POST['id']));
	}
    public function ubahGuru($id)
	{
		$data['user'] = $this->Mlogin->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$where = ['id_guru' => $id];
		$data['guru'] = $this->Mguru->get_where('guru', $where)->row_array();
		$data['title'] = 'Ubah Data Guru ' . $data['guru']['nama_guru'];
        $data['current_page'] = 'guru';
		$this->form_validation->set_rules('nama', 'Nama Guru', 'required|trim', ['required' => 'Nama guru wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
			$this->load->view('admin/templates/header', $data);
			$this->load->view('admin/guru/update', $data);
			$this->load->view('admin/templates/footer');
		} else {
			$this->ubahDataGuru();
			
		}

	}
    public function ubahDataGuru()
	{
		$idGuru = $this->input->post('id_guru');
		$data = [
			'nama_guru' => html_escape($this->input->post('nama', true))
		];
		$this->db->where('id_guru', $idGuru);
		$this->Mguru->update('guru', $data);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> Data Guru Berhasil Diubah.</div>');
		redirect('dashboard/guru');
	}
    public function guru_delete($id){
        
        $this->db->delete('guru', ['id_guru' => $id]);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-trash"></i> Data Guru Berhasil Dihapus.</div>');
        redirect('dashboard/guru');
        
    }
    public function billing()
	{
		$data['title'] = 'Transaksi';
        $data['current_page'] = "billing";
        $data['siswas'] = $this->db->query("select * from siswa")->result();
		$data['user'] = $this->Mlogin->get_where('user', ['id' => $this->session->userdata('id')])->row_array();

		$this->form_validation->set_rules('nis', 'NIS', 'required|trim', ['required' => 'NIS wajib di isi!.']);
		if($this->form_validation->run() == FALSE) {
            $this->load->view('admin/templates/header',$data);
            $this->load->view('admin/billing/index');
            $this->load->view('admin/templates/footer');
		} else {
			$this->cariTransaksi();
		}
	}
    public function cariTransaksi(){
            $data['title'] = 'Transaksi';
            $data['current_page'] = "billing";
            $data['user'] = $this->Mlogin->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
            $nis = $this->input->post('nis', true);
            $where = ['nis' => $nis];
            $data['siswas'] = $this->db->query("select * from siswa")->result();
            $data['siswa'] = $this->Mbilling->get_where('siswa', $where)->row_array();
            $idSiswa = $data['siswa']['id_siswa'];
    
            if($data['siswa'] == null) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert"><i class="fas fa-info-circle"></i> NIS Siswa <strong>'. $nis .'</strong> Tidak Terdaftar.</div>');
                redirect('dashboard/billing');
            }
    
            $where = ['id_siswa' => $idSiswa];
            $data['spp'] = $this->Mbilling->get_where('spp', $where)->result_array();
            $this->load->view('admin/templates/header',$data);
            $this->load->view('admin/billing/index');
            $this->load->view('admin/templates/footer');
        }
        public function bayar($nis, $id)
	{
		$hariIini = date('Y-m-d');
		$today = date('ymd');

		// membuat no bayar acak

        $kode = date('ymd');
        $kode_terakhir = $this->Mspp->getMax('spp', 'no_bayar', $kode);
        $kode_tambah = substr($kode_terakhir, -5, 5);
        $kode_tambah++;
        $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
        $no_bayar = $kode . $number;
		$where = ['id_spp' => $id];
		$data = [
			'no_bayar' => $no_bayar,
			'tgl_bayar' => $hariIini,
			'ket' => 'lunas'
		];
		$this->Mbilling->update_where('spp', $data, $where);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> NIM <strong>'. $nis .'</strong> SPP <strong>'. $noUrutBayarSelanjutnya .'</strong> Berhasil Di Bayar.</div>');
            redirect('dashboard/billing');
	}
    public function cicil($nis, $id)
	{
		$hariIini = date('Y-m-d');
		$today = date('ymd');

		// membuat no bayar acak

        $kode = date('ymd');
        $kode_terakhir = $this->Mspp->getMax('spp', 'no_bayar', $kode);
        $kode_tambah = substr($kode_terakhir, -5, 5);
        $kode_tambah++;
        $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
        $no_bayar = $kode . $number;
		$where = ['id_spp' => $id];
		$data = [
			'no_bayar' => $no_bayar,
			'tgl_bayar' => $hariIini,
			'ket' => 'cicilan'
		];
		$this->Mbilling->update_where('spp', $data, $where);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> NIM <strong>'. $nis .'</strong> SPP <strong>'. $noUrutBayarSelanjutnya .'</strong> Berhasil Di Bayar.</div>');
            redirect('dashboard/billing');
	}
    public function batal($nis, $idSpp)
	{
		$where = ['id_spp' => $idSpp];
		$data = [
			'no_bayar' => null,
			'tgl_bayar' => null,
			'ket' => 'belum_bayar'
		];
		$this->Mbilling->update_where('spp', $data, $where);
		$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert"><i class="fas fa-info-circle"></i> NIM <strong>'. $nis .'</strong> SPP Berhasil Di Bayar.</div>');
		redirect('dashboard/billing');
	}
    public function cetak($nis, $idSpp)
	{
		$where = ['nis' => $nis];
		$data['siswa'] = $this->Mbilling->get_where('siswa', $where)->row_array();
        $data['current_page'] = "billing";
		$data['title'] = 'Laporan ' . $data['siswa']['nama'];
		$where = ['id_spp' => $idSpp];
		$data['bayar'] = $this->Mbilling->get_join_where('spp', $where)->result_array();
        $this->load->view('admin/templates/header',$data);
        $this->load->view('admin/billing/cetak_laporan_pembayaran');
        $this->load->view('admin/templates/footer');
    }
    public function laporan(){
		$data['user'] = $this->Mlogin->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
		$data['title'] = 'Laporan';
        $data['current_page'] = 'laporan';
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/laporan/index');
		$this->load->view('admin/templates/footer');

    }

    public function laporan_guru(){ 
        $data['title'] = 'Laporan Guru';
		$data['guru'] = $this->db->get('guru')->result_array();
        $data['current_page'] = 'laporan';
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/laporan/laporan_guru');
		$this->load->view('admin/templates/footer');
        
    }
    public function laporan_siswa(){
        $data['title'] = 'Laporan Siswa';
        $data['current_page'] = 'laporan';
		$data['siswa'] = $this->db->get('siswa')->result_array();
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/laporan/laporan_siswa');
		$this->load->view('admin/templates/footer');
    }
    public function laporan_pembayaran(){
		$mulaiTgl = $this->input->post('mulai_tgl');
		$sampaiTgl = $this->input->post('sampai_tgl');
		$data = [
			'mulaiTgl' => $mulaiTgl,
			'sampaiTgl' => $sampaiTgl,
            'current_page' => 'laporan'
		];
		$data['title'] = 'Laporan Pembayaran';
		$data['bayar'] = $this->Mbilling->get_join_laporan($mulaiTgl, $sampaiTgl)->result_array();
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/laporan/laporan_pembayaran');
		$this->load->view('admin/templates/footer');
    }
    public function laporan_excel(){
		$data = [
            'current_page' => 'laporan',
			'mulaiTgl' => $mulaiTgl,
			'sampaiTgl' => $sampaiTgl
		];
		$data['title'] = 'Laporan Excel Pembayaran';
		$data['bayar'] = $this->Mbilling->get_join_laporan($mulaiTgl, $sampaiTgl)->result_array();
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/laporan/laporan_pembayaran_excel', $data);
		$this->load->view('admin/templates/footer');
    }
    public function laporan_tunggakan(){
        $data['title'] = 'Laporan Tunggakan Pemabayaran';
        $data['current_page'] = 'laporan';
		$where = [
			'ket' => 'belum_bayar'
		];
		$data['tunggakan'] = $this->Mbilling->get_join_where('spp', $where)->result_array();
		$this->load->view('admin/templates/header', $data);
		$this->load->view('admin/laporan/laporan_tunggakan', $data);
		$this->load->view('admin/templates/footer');
	
    }
  
    public function spp(){
        $data = 
        [
            'title' => 'Data SPP',
            'current_page' => 'spp',
            'spp' => $this->Mspp->get_join()->result()
        ];
        $this->load->view('admin/templates/header',$data);
        $this->load->view('admin/spp/index');
        $this->load->view('admin/templates/footer');        
    }
    public function spp_update($id_spp){
        $data['title'] = "Update Spp";
        $data['current_page'] = "spp";
        $data['spp'] = $this->db->query("select * from spp p where p.id_spp='$id_spp'")->result();
        $data['siswa'] = $this->Msiswa->get()->result();
        $this->load->view('admin/templates/header',$data);
        $this->load->view('admin/spp/update');
        $this->load->view('admin/templates/footer');
    }
    public function spp_update_aksi(){
        $id_spp = $this->input->post('id_spp');
        $this->_spp_rules();
        if($this->form_validation->run() == FALSE){
            $this->spp_update($id_spp);
        }else{
            $id_siswa = $this->input->post('id_siswa');
            $jatuh_tempo = $this->input->post('jatuh_tempo');
            $bulan = $this->input->post('bulan');
            $no_bayar = $this->input->post('no_bayar');
            $tgl_bayar = $this->input->post('tgl_bayar');
            $nominal = $this->input->post('nominal');
            $ket = $this->input->post('ket');
    
            $data = array(
            'id_siswa' => $id_siswa,
            'jatuh_tempo' => $jatuh_tempo,
            'bulan' => $bulan,
            'no_bayar' => $no_bayar,
            'tgl_bayar' => $tgl_bayar,
            'nominal' => $nominal,
            'ket' => $ket,
            );
            $where = array(
                'id_spp' => $id_spp
            );
            $this->Mspp->update_data($where,$data,'spp');
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show" role="alert">
                Data spp berhasil di update
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
            redirect('dashboard/spp');
        }
    }
    public function spp_delete($id_spp){
        $where = array('id_spp' =>$id_paket);
        $this->Mspp->delete_data($where,'spp');
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show" role="alert">
        Data spp berhasil di hapus
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect('dashboard/spp');
    }
    public function _spp_rules(){
        $this->form_validation->set_rules('id_siswa','id_siswa','required',[
            'required' => 'Siswa wajib diisi!'
        ]);
        $this->form_validation->set_rules('jatuh_tempo','jatuh_tempo','required',[
            'required' => 'Jatuh Tempo wajib diisi!'
        ]);
        $this->form_validation->set_rules('bulan','bulan','required',[
            'required' => 'Bulan wajib diisi!'
        ]);
        $this->form_validation->set_rules('no_bayar','no_bayar','required',[
            'required' => 'No Bayar wajib diisi!'
        ]);
        $this->form_validation->set_rules('tgl_bayar','tgl_bayar','required',[
            'required' => 'Tanggal Bayar wajib diisi!'
        ]);
        $this->form_validation->set_rules('nominal','nominal','required',[
            'required' => 'Nominal wajib diisi!'
        ]);
        $this->form_validation->set_rules('ket','ket','required',[
            'required' => 'Keterangan wajib diisi!'
        ]);
    }
    public function user_management(){
        $data = 
        [
            'title' => 'User Management',
            'current_page' => 'user_management',
            'user' => $this->Muser->get()->result()
        ];
        $this->load->view('admin/templates/header',$data);
        $this->load->view('admin/user/index');
        $this->load->view('admin/templates/footer');  
    }
    public function user_insert(){
        $data = 
        [
            'title' => 'User Insert',
            'current_page' => 'user_management',
        ];
        $this->load->view('admin/templates/header',$data);
        $this->load->view('admin/user/insert');
        $this->load->view('admin/templates/footer');  
    }
    public function user_insert_aksi(){
        $this->_user_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->user_insert();
        } else {
            $nama_user = $this->input->post('username');
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $user_akses = $this->input->post('user_akses');
            $user_status = $this->input->post('user_status');
            $data = array(
                'nama_user' => $nama_user,
                'username' => $username,
                'email' => $email,
                'password' => MD5($password),
                'foto' => 'default.jpg',
                'user_akses' => $user_akses,
                'user_status' => $user_status,
            );
            $this->Muser->insert_data($data,'user');
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Data user berhasil di tambahkan
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>');                 
            redirect('dashboard/user_management');
        }               
    }
    public function user_update($id){
        $data['title'] = "Update User";
        $data['current_page'] = "user_management";
        $data['user'] = $this->db->query("select * from user p where p.id='$id'")->result();
        $this->load->view('admin/templates/header',$data);
        $this->load->view('admin/user/update');
        $this->load->view('admin/templates/footer');
    }
    public function user_update_aksi(){
        $id = $this->input->post('id');
        $this->_user_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->user_update();
        } else {
            $id_petugas = $this->input->post('id_petugas');
            $nama_user = $this->input->post('username');
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post(md5('password'));
            $user_akses = $this->input->post('user_akses');
            $user_status = $this->input->post('user_status');
            $data = array(
                'id_petugas' => $id_petugas,
                'nama_user' => $nama_user,
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'user_akses' => $user_akses,
                'user_status' => $user_status,
            );
            $where = array(
                'id' => $id
            );
            $this->Muser->update_data($where,$data,'user');
            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Data user berhasil di update
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>');                 
            redirect('dashboard/user_management');
        }               
    }
    public function user_delete($id){
        $where = array('id' =>$id);
        $this->Mspp->delete_data($where,'user');
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show" role="alert">
        Data user berhasil di hapus
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect('dashboard/user_management');
    }
    public function user_activate($id){
    $user_akses = 1;
    $query = $this->db->query("select user_status from user where id='$id'");
    if($query->result() == $user_akses){
        $data = array(
            'user_status' => 2
        );
        $where = array(
            'id' => $id
        );
        $this->Muser->update_data($where,$data,'user');
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show" role="alert">
        Status user berhasil di perbarui
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect('dashboard/user_management');
    } else{
        $data = array(
            'user_status' => 1
        );
        $where = array(
            'id' => $id
        );
        $this->Muser->update_data($where,$data,'user');
        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show" role="alert">
        Status user berhasil di perbarui
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>');
        redirect('dashboard/user_management');
    }

    }
    public function _user_rules(){
        $this->form_validation->set_rules('username','username','required',[
            'required' => 'Username wajib diisi!'
        ]);
        $this->form_validation->set_rules('email','email','required',[
            'required' => 'Email wajib diisi!'
        ]);
        $this->form_validation->set_rules('password','password','required',[
            'required' => 'Password wajib diisi!'
        ]);
        $this->form_validation->set_rules('user_akses','user_akses','required',[
            'required' => 'User Akses wajib diisi!'
        ]);
        $this->form_validation->set_rules('user_status','user_status','required',[
            'required' => 'User Status wajib diisi!'
        ]);
    }
    public function profile(){
        $data['title'] = "Profile";
        $data['current_page'] = 'profile';
        $data['user'] = $this->Mlogin->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
        $this->load->view('admin/templates/header',$data);
        $this->load->view('admin/profile/index');
        $this->load->view('admin/templates/footer');  
    }
    private function _config()
    {
        $config['upload_path']      = ".dist/assets/img/avatar";
        $config['allowed_types']    = 'gif|jpg|jpeg|png';
        $config['encrypt_name']     = TRUE;
        $config['max_size']         = '2048';

        $this->load->library('upload', $config);
    }
    public function setting()
    {
        
        $this->_config();
        $this->form_validation->set_rules('username', 'Username', 'required|trim|alpha_numeric');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('nama_user', 'Nama', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = "Profile";
            $data['current_page'] = 'profile';
            $data['user'] = $this->Mlogin->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
            $this->load->view('admin/templates/header',$data);
            $this->load->view('admin/profile/setting');
            $this->load->view('admin/templates/footer'); 
        } else {
            $input = $this->input->post(null, true);
            if (empty($_FILES['foto']['nama_user'])) {
                $insert = $this->Muser->update('user', 'id', $input['id'], $input);
                if ($insert) {
                    $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Status user berhasil di perbarui
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>');
                } else {
                    $this->session->set_flashdata('msg','<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Status user gagal di perbarui
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>');
                }
                redirect('dashboard/setting');
            } else {
                if ($this->upload->do_upload('foto') == false) {
                    echo $this->upload->display_errors();
                    die;
                } else {
                    if (userdata('foto') != 'default.jpg') {
                        $old_image = FCPATH . '.dist/assets/img/avatar/' . $user['foto'];
                        if (!unlink($old_image)) {
                            $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Status user berhasil di perbarui
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>');
                            redirect('dashboard/setting');
                        }
                    }

                    $input['foto'] = $this->upload->data('file_name');
                    $update = $this->Muser->update('user', 'id', $input['id'], $input);
                    if ($update) {
                        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Status user berhasil di perbarui
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>');
                    } else {
                        $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Status user gagal di perbarui
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                        </div>');
                    }
                    redirect('dashboard/setting');
                }
                
            }
        }
    }
    public function ubahpassword()
    {
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|trim|min_length[3]|differs[password_lama]');
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'matches[password_baru]');

        if ($this->form_validation->run() == false) {
            $data['title'] = "Ubah Password";
            $data['current_page'] = "profile";
            $data['user'] = $this->Mlogin->get_where('user', ['id' => $this->session->userdata('id')])->row_array();
            $this->load->view('admin/templates/header',$data);
            $this->load->view('admin/profile/ubahpassword');
            $this->load->view('admin/templates/footer'); 
        } else {
                $id = $this->input->post('id');
                $new_pass = $this->input->post('password_baru');
                $data = [
                    'password' => md5($new_pass)
                ];
                $where = [
                    'id' => $id
                ];
                $query = $this->Muser->update_data($where,$data,'user');
                    $this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Password berhasil di perbarui
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>');
                
                
            redirect('dashboard/ubahpassword');
        }
    }

}