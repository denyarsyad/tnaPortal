<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
PT. ITSHOP BISNIS DIGITAL
Toko Online: ITSHOP Purwokerto (Tokopedia.com/itshoppwt, Shopee.co.id/itshoppwt, Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
Created: 12-2022
Modified: 06-2023
*/

class Departemen extends CI_Controller
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
			//Menyusun template List Departemen
			$data['title'] 	  = "Departemen";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "departemen/index";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			//Daftar semua departemen, get dari model (departemen), data akan ditampung dalam parameter 'departemen'
			$data['departemen'] = $this->model->departemen()->result();

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
		//Form validasi untuk nama departemen dengan nama validasi = nama_dept
		$this->form_validation->set_rules(
			'nama_dept',
			'Nama_dept',
			'required|is_unique[departemen.nama_dept]',
			array(
				'required' => '<strong>Failed!</strong> Field harus diisi.',
				'is_unique' => '<strong>Error!</strong> Nama Departemen sudah ada.'
			)
		);

		//Kondisi jika proses tambah tidak memenuhi syarat validasi akan dikembalikan ke form tambah departemen
		if ($this->form_validation->run() == FALSE) {
			//User harus admin, tidak boleh role user lain
			if ($this->session->userdata('level') == "Admin") {
				//Menyusun template List Departemen dengan form tambah departemen
				$data['title'] 	  = "Departemen";
				$data['navbar']   = "navbar";
				$data['sidebar']  = "sidebar";
				$data['modal_show'] = "$('#modal-fade').modal('show');";
				$data['body']     = "departemen/index";

				//Session
				$id_dept = $this->session->userdata('id_dept');
				$id_user = $this->session->userdata('id_user');

				//Daftar semua departemen, get dari model (departemen), data akan ditampung dalam parameter 'departemen'
				$data['departemen'] = $this->model->departemen()->result();

				//Load template
				$this->load->view('template', $data);
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan admin
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		} else {
			//Bagian ini jika validasi dipenuhi, maka berhasil menambah departemen
			//Data departemen ditampung dalam bentuk array
			$data = array(
				'nama_dept' => ucfirst($this->input->post('nama_dept'))
			);

			//Query insert data yang ditampung ke dalam database. tersimpan ditabel departemen
			$this->db->insert('departemen', $data);

			//Set pemberitahuan bahwa data departemen berhasil ditambahkan
			$this->session->set_flashdata('status', 'Ditambahkan');
			//Kembali ke halaman departemen (index)
			redirect('departemen');
		}
	}

	public function hapus($id)
	{
		//Menghapus data dengan kondisi jika $id sama dengan id_dept yang kita pilih
		//Query menghapus data pada tabel departemen berdasarkan id_dept
		$this->db->where('id_dept', $id);
		$this->db->delete('departemen');

		//Set pemberitahuan bahwa data departemen berhasil dihapus
		$this->session->set_flashdata('status', 'Dihapus');
		//Kembali ke halaman departemen (index)
		redirect('departemen');
	}

	public function edit($id)
	{
		//User harus admin, tidak boleh role user lain
		if ($this->session->userdata('level') == "Admin") {
			//Menyusun template Edit departemen
			$data['title'] 	  = "Edit Departemen";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "departemen/edit";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			//Get data departemen yang akan diedit sesuai dengan id yang kita pilih, get dari model (getdepartemen)
			$data['departemen'] = $this->model->getdepartemen($id)->row_array();
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
		//Form validasi untuk nama departemen dengan nama validasi = nama_dept
		$this->form_validation->set_rules(
			'nama_dept',
			'Nama_dept',
			'required|is_unique[departemen.nama_dept]',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.',
				'is_unique' => '<strong>Error!</strong> Nama Departemen sudah ada.'
			)
		);

		//Kondisi jika saat proses update tidak memenuhi syarat validasi akan dikembalikan ke halaman edit departemen
		if ($this->form_validation->run() == FALSE) {
			//User harus admin, tidak boleh role user lain
			if ($this->session->userdata('level') == "Admin") {
				//Menyusun template Edit departemen
				$data['title'] 	  = "Edit Departemen";
				$data['navbar']   = "navbar";
				$data['sidebar']  = "sidebar";
				$data['body']     = "departemen/edit";

				//Session
				$id_dept = $this->session->userdata('id_dept');
				$id_user = $this->session->userdata('id_user');

				//Get data departemen yang akan diedit sesuai dengan id yang kita pilih, get dari model (getdepartemen)
				$data['departemen'] = $this->model->getdepartemen($id)->row_array();

				//Load template
				$this->load->view('template', $data);
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan admin
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		} else {
			//Bagian ini jika validasi dipenuhi, maka berhasil update departemen
			//User harus admin, tidak boleh role user lain
			if ($this->session->userdata('level') == "Admin") {
				//Data departemen ditampung dalam bentuk array
				$data = array(
					'nama_dept' => ucfirst($this->input->post('nama_dept'))
				);

				//Query update data yang ditampung ke dalam database. tersimpan ditabel departemen
				$this->db->where('id_dept', $id);
				$this->db->update('departemen', $data);

				//Set pemberitahuan bahwa data departemen berhasil diupdate
				$this->session->set_flashdata('status', 'Diperbarui');
				//Kembali ke halaman departemen (index)
				redirect('departemen');
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan admin
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		}
	}
}
