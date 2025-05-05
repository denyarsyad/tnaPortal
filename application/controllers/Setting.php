<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


class Setting extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//Meload model
		$this->load->model('Main_model', 'model');

		//Jika session tidak ditemukan
		if (!$this->session->userdata('id_user')) {
			//Kembali ke halaman Login
			$this->session->set_flashdata('status1', 'expired');
			redirect('login');
		}
	}

	function file_upload()
	{
		$this->form_validation->set_message('file_upload', 'Silahkan pilih file untuk diupload.');
		if (empty($_FILES['value_setting']['name'])) {
			return true;
		} else {
			return true;
		}
	}

	public function index()
	{
		//User harus admin, tidak boleh role user lain
		if ($this->session->userdata('level') == "Admin") {
			//Menyusun template List Pengaturan
			$data['title'] 	  = "Pengaturan";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "setting/index";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			//Daftar semua setting, get dari model (setting), data akan ditampung dalam parameter 'setting'
			$data['setting'] = $this->model->setting()->result();

			//Load template
			$this->load->view('template', $data);
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan admin
			//Akan dibawa ke Controller Errorpage 
			redirect('Errorpage');
		}
	}

	public function edit($id)
	{
		//User harus admin, tidak boleh role user lain
		if ($this->session->userdata('level') == "Admin") {
			//Menyusun template Edit Pengaturan
			$data['title'] 	  = "Edit Pengaturan";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "setting/edit";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			//Get data setting yang akan diedit sesuai dengan id yang kita pilih, get dari model (getsetting)
			$data['setting'] = $this->model->getsetting($id)->row_array();
			//Load template
			$this->load->view('template', $data);
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan admin
			//Akan dibawa ke Controller Errorpage
			redirect('Errorpage');
		}
	}

	public function update($id)
	{
		//Form validasi untuk value_setting dengan nama validasi = value_setting
		$this->form_validation->set_rules(
			'value_setting',
			'Value_Setting',
			'required',
			array(
				'required' => '<strong>Gagal!</strong> Field harus diisi.',
			)
		);

		//Kondisi jika saat proses update tidak memenuhi syarat validasi akan dikembalikan ke halaman edit value_setting
		if ($this->form_validation->run() == FALSE) {
			//User harus admin, tidak boleh role user lain
			if ($this->session->userdata('level') == "Admin") {
				//Menyusun template Edit Pengaturan
				$data['title'] 	  = "Edit Pengaturan";
				$data['navbar']   = "navbar";
				$data['sidebar']  = "sidebar";
				$data['body']     = "setting/edit";

				//Session
				$id_dept = $this->session->userdata('id_dept');
				$id_user = $this->session->userdata('id_user');

				//Get data setting yang akan diedit sesuai dengan id yang kita pilih, get dari model (getsetting)
				$data['setting'] = $this->model->getsetting($id)->row_array();
				//Load template
				$this->load->view('template', $data);
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan admin
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		} else {
			//Bagian ini jika validasi dipenuhi, maka berhasil update value_setting
			//User harus admin, tidak boleh role user lain
			if ($this->session->userdata('level') == "Admin") {
				//Data value_setting ditampung dalam bentuk array
				$data = array(
					'value_setting' => $this->input->post('value_setting'),
					'updated_at' => date('Y-m-d H:i:s')
				);

				//Query update data yang ditampung ke dalam database. tersimpan ditabel setting
				$this->db->where('id', $id);
				$this->db->update('settings', $data);

				//Set pemberitahuan bahwa data setting berhasil diupdate
				$this->session->set_flashdata('status', 'Diperbarui');
				//Kembali ke halaman setting (index)
				redirect('setting');
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan admin
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		}
	}

	public function upload($id)
	{
		//User harus admin, tidak boleh role user lain
		if ($this->session->userdata('level') == "Admin") {
			//Menyusun template Edit Pengaturan
			$data['title'] 	  = "Edit Pengaturan";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "setting/upload";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			//Get data setting yang akan diedit sesuai dengan id yang kita pilih, get dari model (getsetting)
			$data['setting'] = $this->model->getsetting($id)->row_array();
			$data['error'] = "";
			//Load template
			$this->load->view('template', $data);
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan admin
			//Akan dibawa ke Controller Errorpage
			redirect('Errorpage');
		}
	}

	public function upload_file($id)
	{
		//Form validasi untuk value_setting dengan nama validasi = value_setting
		$this->form_validation->set_rules(
			'value_setting',
			'Value_Setting',
			'callback_file_upload',
		);

		//Kondisi jika saat proses update tidak memenuhi syarat validasi akan dikembalikan ke halaman edit value_setting
		if ($this->form_validation->run() == FALSE) {
			//User harus admin, tidak boleh role user lain
			if ($this->session->userdata('level') == "Admin") {
				//Menyusun template Edit Pengaturan
				$data['title'] 	  = "Edit Pengaturan";
				$data['navbar']   = "navbar";
				$data['sidebar']  = "sidebar";
				$data['body']     = "setting/upload";

				//Session
				$id_dept = $this->session->userdata('id_dept');
				$id_user = $this->session->userdata('id_user');

				//Get data setting yang akan diedit sesuai dengan id yang kita pilih, get dari model (getsetting)
				$data['setting'] = $this->model->getsetting($id)->row_array();
				$data['error'] = "";
				//Load template
				$this->load->view('template', $data);
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan admin
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		} else {
			//Bagian ini jika validasi dipenuhi, maka berhasil update value_setting
			//User harus admin, tidak boleh role user lain
			if ($this->session->userdata('level') == "Admin") {
				//Konfigurasi Upload Gambar
				$config['upload_path'] 		= './assets/img/';		//Folder untuk menyimpan gambar
				$config['allowed_types'] 	= 'gif|jpg|jpeg|png|pdf';	//Tipe file yang diizinkan
				$config['max_size'] 		= '25600';			//Ukuran maksimum file gambar yang diizinkan
				$config['max_width']        = '0';				//Ukuran lebar maks. 0 menandakan ga ada batas
				$config['max_height']       = '0';				//Ukuran tinggi maks. 0 menandakan ga ada batas
				//Memanggil library upload pada codeigniter dan menyimpan konfirguasi
				$this->load->library('upload', $config);
				//Jika upload gambar tidak sesuai dengan konfigurasi di atas, maka upload gambar gagal, dan kembali ke halaman Create ticket
				if (!$this->upload->do_upload('value_setting')) {
					//Menyusun template Edit Pengaturan
					$data['title'] 	  = "Edit Pengaturan";
					$data['navbar']   = "navbar";
					$data['sidebar']  = "sidebar";
					$data['body']     = "setting/upload";

					//Session
					$id_dept = $this->session->userdata('id_dept');
					$id_user = $this->session->userdata('id_user');

					//Get data setting yang akan diedit sesuai dengan id yang kita pilih, get dari model (getsetting)
					$data['setting'] = $this->model->getsetting($id)->row_array();
					$data['error'] = $this->upload->display_errors();
					//Load template
					$this->load->view('template', $data);
				} else {
					$gambar = $this->upload->data();

					//Data value_setting ditampung dalam bentuk array
					$data = array(
						'value_setting' => $gambar['file_name'],
						'updated_at' => date('Y-m-d H:i:s')
					);

					//Query update data yang ditampung ke dalam database. tersimpan ditabel setting
					$this->db->where('id', $id);
					$this->db->update('settings', $data);

					//Set pemberitahuan bahwa data setting berhasil diupdate
					$this->session->set_flashdata('status', 'Diperbarui');
					//Kembali ke halaman setting (index)
					redirect('setting');
				}
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan admin
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		}
	}
}
