<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
PT. ITSHOP BISNIS DIGITAL
Toko Online: ITSHOP Purwokerto (Tokopedia.com/itshoppwt, Shopee.co.id/itshoppwt, Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
Created: 12-2022
Modified: 06-2023
*/

class Jabatan extends CI_Controller
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

	public function index()
	{
		//User harus admin, tidak boleh role user lain
		if ($this->session->userdata('level') == "Admin") {
			//Menyusun template List jabatan
			$data['title'] 	  = "Jabatan";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "jabatan/index";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			//Daftar semua jabatan, get dari model (jabatan), data akan ditampung dalam parameter 'jabatan'
			$data['jabatan'] = $this->model->jabatan()->result();

			//Load template
			$this->load->view('template', $data);
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan admin
			//Akan dibawa ke Controller Errorpage 
			redirect('Errorpage');
		}
	}

	public function tambah()
	{
		//Form validasi untuk nama jabatan dengan nama validasi = nama_jabatan
		$this->form_validation->set_rules(
			'nama_jabatan',
			'Nama_jabatan',
			'required|is_unique[jabatan.nama_jabatan]',
			array(
				'required' => '<strong>Gagal!</strong> Field harus diisi.',
				'is_unique' => '<strong>Failed!</strong> Jabatan Sudah ada.'
			)
		);

		//Kondisi jika proses tambah tidak memenuhi syarat validasi akan dikembalikan ke form tambah jabatan
		if ($this->form_validation->run() == FALSE) {
			//User harus admin, tidak boleh role user lain
			if ($this->session->userdata('level') == "Admin") {
				//Menyusun template List jabatan dengan form tambah jabatan
				$data['title'] 	  	= "Jabatan";
				$data['navbar']   	= "navbar";
				$data['sidebar']  	= "sidebar";
				$data['modal_show'] = "$('#modal-fade').modal('show');";
				$data['body']     	= "jabatan/index";

				//Session
				$id_dept = $this->session->userdata('id_dept');
				$id_user = $this->session->userdata('id_user');

				//Daftar semua jabatan, get dari model (jabatan), data akan ditampung dalam parameter 'jabatan'
				$data['jabatan'] = $this->model->jabatan()->result();

				//Load template
				$this->load->view('template', $data);
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan admin
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		} else {
			//Bagian ini jika validasi dipenuhi, maka berhasil menambah Jabatan
			//Data jabatan ditampung dalam bentuk array
			$data = array(
				'nama_jabatan' => ucfirst($this->input->post('nama_jabatan'))
			);

			//Query insert data yang ditampung ke dalam database. tersimpan ditabel jabatan
			$this->db->insert('jabatan', $data);

			//Set pemberitahuan bahwa data jabatan berhasil ditambahkan
			$this->session->set_flashdata('status', 'Ditambahkan');
			//Kembali ke halaman jabatan (index)
			redirect('jabatan');
		}
	}

	public function hapus($id)
	{
		//Menghapus data dengan kondisi jika $id sama dengan id_jabatan yang kita pilih
		//Query menghapus data pada tabel jabatan berdasarkan id_jabatan
		$this->db->where('id_jabatan', $id);
		$this->db->delete('jabatan');

		//Set pemberitahuan bahwa data jabatan berhasil dihapus
		$this->session->set_flashdata('status', 'Dihapus');
		//Kembali ke halaman jabatan (index)
		redirect('jabatan');
	}

	public function edit($id)
	{
		//User harus admin, tidak boleh role user lain
		if ($this->session->userdata('level') == "Admin") {
			//Menyusun template Edit jabatan
			$data['title'] 	  = "Edit Jabatan";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "jabatan/edit";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			//Get data jabatan yang akan diedit sesuai dengan id yang kita pilih, get dari model (getjabatan)
			$data['jabatan'] = $this->model->getjabatan($id)->row_array();

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
		//Form validasi untuk nama jabatan dengan nama validasi = nama_jabatan
		$this->form_validation->set_rules(
			'nama_jabatan',
			'Nama_jabatan',
			'required',
			array(
				'required' => '<strong>Gagal!</strong> Field harus diisi.',
				'is_unique' => '<strong>Error!</strong> Jabatan sudah ada.'
			)
		);

		//Kondisi jika saat proses update tidak memenuhi syarat validasi akan dikembalikan ke halaman edit jabatan
		if ($this->form_validation->run() == FALSE) {
			//User harus admin, tidak boleh role user lain
			if ($this->session->userdata('level') == "Admin") {
				//Menyusun template Edit jabatan
				$data['title'] 	  = "Edit Jabatan";
				$data['navbar']   = "navbar";
				$data['sidebar']  = "sidebar";
				$data['body']     = "jabatan/edit";

				//Session
				$id_dept = $this->session->userdata('id_dept');
				$id_user = $this->session->userdata('id_user');

				//Get data jabatan yang akan diedit sesuai dengan id yang kita pilih, get dari model (getjabatan)
				$data['jabatan'] = $this->model->getjabatan($id)->row_array();
				//Load template
				$this->load->view('template', $data);
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan admin
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		} else {
			//Bagian ini jika validasi dipenuhi, maka berhasil update jabatan
			//User harus admin, tidak boleh role user lain
			if ($this->session->userdata('level') == "Admin") {
				//Data jabatan ditampung dalam bentuk array
				$data = array(
					'nama_jabatan' => ucfirst($this->input->post('nama_jabatan'))
				);

				//Query update data yang ditampung ke dalam database. tersimpan ditabel jabatan
				$this->db->where('id_jabatan', $id);
				$this->db->update('jabatan', $data);

				//Set pemberitahuan bahwa data departemen berhasil diupdate
				$this->session->set_flashdata('status', 'Diperbarui');
				//Kembali ke halaman jabatan (index)
				redirect('jabatan');
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan admin
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		}
	}
}
