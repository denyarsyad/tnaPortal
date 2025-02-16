<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
PT. ITSHOP BISNIS DIGITAL
Toko Online: ITSHOP Purwokerto (Tokopedia.com/itshoppwt, Shopee.co.id/itshoppwt, Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
Created: 12-2022
Modified: 06-2023
*/

class Prioritas extends CI_Controller
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
			//Menyusun template List prioritas
			$data['title'] 	  = "Prioritas";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "prioritas/index";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			//Daftar semua prioritas, get dari model (prioritas), data akan ditampung dalam parameter 'prioritas'
			$data['prioritas'] = $this->model->prioritas()->result();

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
		//Form validasi untuk nama prioritas dengan nama validasi = nama_prioritas
		$this->form_validation->set_rules(
			'nama_prioritas',
			'Nama_prioritas',
			'required|is_unique[prioritas.nama_prioritas]',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.',
				'is_unique' => '<strong>Error!</strong> Prioritas sudah ada.'
			)
		);

		//Form validasi untuk waktu resolusi dengan nama validasi = waktu_respon
		$this->form_validation->set_rules(
			'waktu_respon',
			'Waktu_respon',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		//prioritas jika proses tambah tidak memenuhi syarat validasi akan dikembalikan ke form tambah prioritas
		if ($this->form_validation->run() == FALSE) {
			//User harus admin, tidak boleh role user lain
			if ($this->session->userdata('level') == "Admin") {
				//Menyusun template List prioritas
				$data['title'] 	  = "Prioritas";
				$data['navbar']   = "navbar";
				$data['sidebar']  = "sidebar";
				$data['modal_show'] = "$('#modal-fade').modal('show');";
				$data['body']     = "prioritas/index";

				//Session
				$id_dept = $this->session->userdata('id_dept');
				$id_user = $this->session->userdata('id_user');

				//Daftar semua prioritas, get dari model (prioritas), data akan ditampung dalam parameter 'prioritas'
				$data['prioritas'] = $this->model->prioritas()->result();

				//Load template
				$this->load->view('template', $data);
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan admin
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		} else {
			//Bagian ini jika validasi dipenuhi, maka berhasil menambah prioritas
			//Data kondis ditampung dalam bentuk array
			$data = array(
				'nama_prioritas' => ucfirst($this->input->post('nama_prioritas')),
				'waktu_respon' => $this->input->post('waktu_respon'),
				'warna'		   => strtoupper($this->input->post('warna'))
			);

			//Query insert data yang ditampung ke dalam database. tersimpan ditabel prioritas
			$this->db->insert('prioritas', $data);

			//Set pemberitahuan bahwa data prioritas berhasil ditambahkan
			$this->session->set_flashdata('status', 'Ditambahkan');
			//Kembali ke halaman prioritas (index)
			redirect('prioritas');
		}
	}

	public function hapus($id)
	{
		//Menghapus data dengan prioritas jika $id sama dengan id_prioritas yang kita pilih
		//Query menghapus data pada tabel prioritas berdasarkan id_prioritas
		$this->db->where('id_prioritas', $id);
		$this->db->delete('prioritas');

		//Set pemberitahuan bahwa data prioritas berhasil dihapus
		$this->session->set_flashdata('status', 'Dihapus');
		//Kembali ke halaman prioritas (index)
		redirect('prioritas');
	}

	public function edit($id)
	{
		//User harus admin, tidak boleh role user lain
		if ($this->session->userdata('level') == "Admin") {
			//Menyusun template edit prioritas
			$data['title'] 	  = "Edit Priority";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "prioritas/edit";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			//Get data prioritas yang akan diedit sesuai dengan id yang kita pilih, get dari model (getprioritas)
			$data['prioritas'] = $this->model->getprioritas($id)->row_array();
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
		//Form validasi untuk nama prioritas dengan nama validasi = nama_prioritas
		$this->form_validation->set_rules(
			'nama_prioritas',
			'Nama_prioritas',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.',
				'is_unique' => '<strong>Error!</strong> Prioritas sudah ada.'
			)
		);

		//Form validasi untuk waktu resolusi dengan nama validasi = waktu_respon
		$this->form_validation->set_rules(
			'waktu_respon',
			'Waktu_respon',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		//prioritas jika proses edit tidak memenuhi syarat validasi akan dikembalikan ke form edit prioritas
		if ($this->form_validation->run() == FALSE) {
			//User harus admin, tidak boleh role user lain
			if ($this->session->userdata('level') == "Admin") {
				//Menyusun template edit prioritas
				$data['title'] 	  = "Edit Priority";
				$data['navbar']   = "navbar";
				$data['sidebar']  = "sidebar";
				$data['body']     = "prioritas/edit";

				//Session
				$id_dept = $this->session->userdata('id_dept');
				$id_user = $this->session->userdata('id_user');

				//Get data prioritas yang akan diedit sesuai dengan id yang kita pilih, get dari model (getprioritas)
				$data['prioritas'] = $this->model->getprioritas($id)->row_array();
				//Load template
				$this->load->view('template', $data);
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan admin
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		} else {
			//Bagian ini jika validasi dipenuhi, maka berhasil update prioritas
			//User harus admin, tidak boleh role user lain
			if ($this->session->userdata('level') == "Admin") {
				//Data prioritas ditampung dalam bentuk array
				$data = array(
					'nama_prioritas' => ucfirst($this->input->post('nama_prioritas')),
					'waktu_respon' => $this->input->post('waktu_respon'),
					'warna'		   => strtoupper($this->input->post('warna'))
				);

				//Query update data yang ditampung ke dalam database. tersimpan ditabel prioritas
				$this->db->where('id_prioritas', $id);
				$this->db->update('prioritas', $data);

				//Set pemberitahuan bahwa data prioritas berhasil diupdate
				$this->session->set_flashdata('status', 'Diperbarui');
				//Kembali ke halaman prioritas (index)
				redirect('prioritas');
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan admin
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		}
	}
}
