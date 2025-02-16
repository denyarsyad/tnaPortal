<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
PT. ITSHOP BISNIS DIGITAL
Toko Online: ITSHOP Purwokerto (Tokopedia.com/itshoppwt, Shopee.co.id/itshoppwt, Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
Created: 12-2022
Modified: 06-2023
*/

class Login extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		//Meload model
		$this->load->model('Main_model', 'model');
	}

	public function index()
	{
		//Jika session tidak sama kosong (tidak sama dengan null)
		if ($this->session->userdata('id_user')) {
			//Masuk ke halaman Dashboard
			redirect('dashboard');
		} else {
			//Jika session kosong, kembali ke halaman Login
			$this->load->view('login');
		}
	}

	public function loginProses()
	{
		//Form validasi untuk username dengan nama validasi = username
		$this->form_validation->set_rules(
			'username',
			'Username',
			'required',
			array(
				'required' => '<strong>Error!</strong> Username Harus diisi.'
			)
		);

		//Form validasi untuk password dengan nama validasi = password
		$this->form_validation->set_rules(
			'password',
			'Password',
			'required',
			array(
				'required' => '<strong>Error!</strong> Password Harus diisi.'
			)
		);

		//Kondisi jika proses login tidak memenuhi syarat validasi akan dikembalikan ke halaman login
		if ($this->form_validation->run() == FALSE) {
			//Kembali ke halaman Login
			$this->load->view('login');
		} else {
			//Bagian ini jika validasi dipenuhi, maka berhasil login
			//Input username
			$username = $this->input->post('username');
			//Input password
			$password = md5($this->input->post('password'));

			//Pengecekan User
			$akses = $this->db->query("SELECT A.id_user, A.username, A.level, B.nama,
				B.id_jabatan, B.email, B.telp, C.id_dept FROM user A 
				LEFT JOIN pegawai B ON B.nik = A.username
				LEFT JOIN departemen_bagian C ON C.id_bagian_dept = B.id_bagian_dept
				WHERE A.username = '$username' AND A.password = '$password' 
				OR B.email = '$username' AND A.password = '$password'
				OR B.telp = '$username' AND A.password = '$password'");

			//Kondisi jika user terdapat pada database, maka semua data user yang di-select pada query 'akses' akan disimpan ke dalam session
			if ($akses->num_rows() == 1) {
				//Setiap data user yang di-select pada query 'akses' di tampung pada variabel $data
				foreach ($akses->result_array() as $data) {
					//variabel session dengan nama 'id' menampung data id_user
					$session['id']	 		= $data['id_user'];
					//variabel session dengan id_user 'id' menampung data username
					$session['id_user'] 	= $data['username'];
					//variabel session dengan nama 'nama' menampung data nama
					$session['nama'] 		= $data['nama'];
					//variabel session dengan nama 'level' menampung data level
					$session['level'] 		= $data['level'];
					//variabel session dengan nama 'id_jabatan' menampung data id_jabatan
					$session['id_jabatan'] 	= $data['id_jabatan'];
					//variabel session dengan nama 'id_dept' menampung data id_dept
					$session['id_dept'] 	= $data['id_dept'];
					//variabel session dengan nama 'email' menampung data email
					$session['email'] 		= $data['email'];

					//Semua variabel session yang diatas akan ditampung ke dalam variabel session yang akan dipakai pada controller lain
					$this->session->set_userdata($session);
					//Dialihkan ke halaman Dashboard
					redirect('dashboard');
				}
			} else {
				//Set pemberitahuan bahwa login tidak berhasil
				$this->session->set_flashdata('status', 'Salah');
				//Kembali ke halaman login
				redirect('login');
			}
		}
	}

	public function logout()
	{
		//Session yang sedang login akan dihancukan dalam proses logout
		$this->session->sess_destroy();
		//Kembali ke halaman login
		redirect('login');
	}
}
