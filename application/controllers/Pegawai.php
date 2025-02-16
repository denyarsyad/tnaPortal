<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
PT. ITSHOP BISNIS DIGITAL
Toko Online: ITSHOP Purwokerto (Tokopedia.com/itshoppwt, Shopee.co.id/itshoppwt, Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
Created: 12-2022
Modified: 06-2023
*/

class Pegawai extends CI_Controller
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
			//Menyusun template List pegawai
			$data['title'] 	  = "Pegawai";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "pegawai/index";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			//Daftar semua pegawai, get dari model (pegawai), data akan ditampung dalam parameter 'pegawai'
			$data['pegawai'] = $this->model->pegawai()->result();

			//Dropdown pilih jabatan, menggunakan model (dropdown_jabatan), nama pegawai ditampung pada 'dd_jabatan', data yang akan di simpan adalah id_jabatan dan akan ditampung pada 'id_jabatan'
			$data['dd_jabatan'] = $this->model->dropdown_jabatan();
			$data['id_jabatan'] = "";

			//Dropdown pilih departemen, menggunakan model (dropdown_departemen), nama departemen ditampung pada 'dd_departemen', data yang akan di simpan adalah id_departemen dan akan ditampung pada 'id_departemen'
			$data['dd_departemen'] = $this->model->dropdown_departemen();
			$data['id_departemen'] = "";

			//Dropdown pilih sub departemen, menggunakan model (dropdown_bagian_departemen), nama departemen ditampung pada 'dd_bagian_departemen', data yang akan di simpan adalah id_bagian_departemen dan akan ditampung pada 'id_bagian_departemen'
			$data['dd_bagian_departemen'] = $this->model->dropdown_bagian_departemen('');
			$data['id_bagian_departemen'] = "";

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
		//Form validasi untuk nik dengan nama validasi = nik
		$this->form_validation->set_rules(
			'nik',
			'Nik',
			'required|is_unique[pegawai.nik]',
			array(
				'required' => '<strong>Gagal!</strong> Field harus diisi.',
				'is_unique' => '<strong>Error!</strong> Nomor ID Pegawai sudah ada.'
			)
		);

		//Form validasi untuk nama dengan nama validasi = nama
		$this->form_validation->set_rules(
			'nama',
			'Nama',
			'required',
			array(
				'required' => '<strong>Gagal!</strong> Field harus diisi.'
			)
		);

		//Form validasi untuk email dengan nama validasi = email
		$this->form_validation->set_rules(
			'email',
			'Email',
			'required',
			array(
				'required' => '<strong>Gagal!</strong> Field harus diisi.'
			)
		);

		//Form validasi untuk dropdown id_jabatan dengan nama validasi = id_jabatan
		$this->form_validation->set_rules(
			'id_jabatan',
			'Id_jabatan',
			'required',
			array(
				'required' => '<strong>Gagal!</strong> Field harus diisi.'
			)
		);

		//Form validasi untuk dropdown id_departemen dengan nama validasi = id_departemen
		$this->form_validation->set_rules(
			'id_departemen',
			'Id_departemen',
			'required',
			array(
				'required' => '<strong>Gagal!</strong> Field harus diisi.'
			)
		);

		//Form validasi untuk dropdown sub departemen dengan nama validasi = id_bagian_departemen
		$this->form_validation->set_rules(
			'id_bagian_departemen',
			'Id_bagian_departemen',
			'required',
			array(
				'required' => '<strong>Gagal!</strong> Field harus diisi.'
			)
		);

		//Kondisi jika proses tambah pegawai tidak memenuhi syarat validasi akan dikembalikan ke form tambah pegawai
		if ($this->form_validation->run() == FALSE) {
			//User harus admin, tidak boleh role user lain
			if ($this->session->userdata('level') == "Admin") {
				//Menyusun template List pegawai dengan form tambah pegawai
				$data['title'] 	  = "Pegawai";
				$data['navbar']   = "navbar";
				$data['sidebar']  = "sidebar";
				$data['modal_show'] = "$('#modal-fade').modal('show');";
				$data['body']     = "pegawai/index";

				//Session
				$id_dept = $this->session->userdata('id_dept');
				$id_user = $this->session->userdata('id_user');

				//Daftar semua pegawai, get dari model (pegawai), data akan ditampung dalam parameter 'pegawai'
				$data['pegawai'] = $this->model->pegawai()->result();

				//Dropdown pilih jabatan, menggunakan model (dropdown_jabatan), nama jabatan ditampung pada 'dd_jabatan', data yang akan di simpan adalah id_jabatan dan akan ditampung pada 'id_jabatan'
				$data['dd_jabatan'] = $this->model->dropdown_jabatan();
				$data['id_jabatan'] = "";

				//Dropdown pilih departemen, menggunakan model (dropdown_departemen), nama departemen ditampung pada 'dd_departemen', data yang akan di simpan adalah id_departemen dan akan ditampung pada 'id_departemen'
				$data['dd_departemen'] = $this->model->dropdown_departemen();
				$data['id_departemen'] = "";

				//Dropdown pilih sub departemen, menggunakan model (dropdown_bagian_departemen), nama departemen ditampung pada 'dd_bagian_departemen', data yang akan di simpan adalah id_bagian_departemen dan akan ditampung pada 'id_bagian_departemen'
				$data['dd_bagian_departemen'] = $this->model->dropdown_bagian_departemen('');
				$data['id_bagian_departemen'] = "";

				//Load template
				$this->load->view('template', $data);
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan admin
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		} else {
			//Bagian ini jika validasi dipenuhi, maka berhasil menambah pegawai
			//Data pegawai ditampung dalam bentuk array
			$data = array(
				'nik'            => $this->input->post('nik'),
				'nama'           => ucfirst($this->input->post('nama')),
				'email'          => trim($this->input->post('email')),
				'telp'          => trim($this->input->post('telp')),
				'id_jabatan'     => $this->input->post('id_jabatan'),
				'id_bagian_dept' => $this->input->post('id_bagian_departemen')
			);

			//Query insert data yang ditampung ke dalam database. tersimpan ditabel pegawai
			$this->db->insert('pegawai', $data);

			//Set pemberitahuan bahwa data pegawai berhasil ditambahkan
			$this->session->set_flashdata('status', 'Ditambahkan');
			//Kembali ke halaman pegawai (index)
			redirect('pegawai');
		}
	}

	public function hapus($id)
	{
		//Menghapus data dengan kondisi jika $id sama dengan nik yang kita pilih
		//Query menghapus data pada tabel pegawai berdasarkan nik
		$this->db->where('nik', $id);
		$this->db->delete('pegawai');

		//Set pemberitahuan bahwa data pegawai berhasil dihapus
		$this->session->set_flashdata('status', 'Dihapus');
		//Kembali ke halaman pegawai (index)
		redirect('pegawai');
	}

	public function edit($id)
	{
		//User harus admin, tidak boleh role user lain
		if ($this->session->userdata('level') == "Admin") {
			//Menyusun template Edit pegawai
			$data['title'] 	  = "Edit Pegawai";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "pegawai/edit";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			//Query untuk mengambil data pegawai yang akan diedit, query ditampung dalam variabel '$row' untuk memanggil setiap data pada 1 orang pegawai
			$row = $this->model->profile($id)->row();

			//mengambil data nik yang sesuai dengan $id yang dipilih dan ditampung pada variabel $data dengan nama = nik
			$data['nik'] 				  = $id;
			//mengambil data nama pegawai melalui query $row dan ditampung pada variabel $data dengan nama = nama
			$data['nama'] 				  = $row->nama;
			//mengambil data email pegawai melalui query $row dan ditampung pada variabel $data dengan nama = email
			$data['email'] 				  = $row->email;
			$data['telp'] 				  = $row->telp;
			//Dropdown pilih jabatan, menggunakan model (dropdown_jabatan), nama jabatan ditampung pada 'dd_jabatan', dan mengambil id_jabatan melalui $row dan ditampung pada variabel $data dengan nama = id_jabatan
			$data['dd_jabatan'] 		  = $this->model->dropdown_jabatan();
			$data['id_jabatan'] 		  = $row->id_jabatan;
			//Dropdown pilih departemen, menggunakan model (dropdown_departemen), nama departemen ditampung pada 'dd_departemen', dan mengambil id_departemen melalui $row dan ditampung pada variabel $data dengan nama = id_departemen
			$data['dd_departemen'] 		  = $this->model->dropdown_departemen();
			$data['id_departemen'] 		  = $row->id_dept;
			//Dropdown pilih sub departemen, menggunakan model (dropdown_bagian_departemen) dengan mengikuti id_departemen yang dipilih, nama jabatan ditampung pada 'dd_bagian_departemen', dan mengambil id_bagian_departemen melalui $row dan ditampung pada variabel $data dengan nama = id_bagian_departemen
			$data['dd_bagian_departemen'] = $this->model->dropdown_bagian_departemen($row->id_dept);
			$data['id_bagian_departemen'] = $row->id_bagian_dept;

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
		//Form validasi untuk nama dengan nama validasi = nama
		$this->form_validation->set_rules(
			'nama',
			'Nama',
			'required',
			array(
				'required' => '<strong>Gagal!</strong> Field harus diisi.'
			)
		);

		//Form validasi untuk email dengan nama validasi = email
		$this->form_validation->set_rules(
			'email',
			'Email',
			'required',
			array(
				'required' => '<strong>Gagal!</strong> Field harus diisi.'
			)
		);

		//Form validasi untuk id_jabatan dengan nama validasi = id_jabatan
		$this->form_validation->set_rules(
			'id_jabatan',
			'Id_jabatan',
			'required',
			array(
				'required' => '<strong>Gagal!</strong> Field harus diisi.'
			)
		);

		//Form validasi untuk id_departemen dengan nama validasi = id_departemen
		$this->form_validation->set_rules(
			'id_departemen',
			'Id_departemen',
			'required',
			array(
				'required' => '<strong>Gagal!</strong> Field harus diisi.'
			)
		);

		//Form validasi untuk id_bagian_departemen dengan nama validasi = id_bagian_departemen
		$this->form_validation->set_rules(
			'id_bagian_departemen',
			'Id_bagian_departemen',
			'required',
			array(
				'required' => '<strong>Gagal!</strong> Field harus diisi.'
			)
		);

		//Kondisi jika saat proses update tidak memenuhi syarat validasi akan dikembalikan ke halaman edit pegawai
		if ($this->form_validation->run() == FALSE) {
			//User harus admin, tidak boleh role user lain
			if ($this->session->userdata('level') == "Admin") {
				//Menyusun template Edit pegawai
				$data['title'] 	  = "Edit Pegawai";
				$data['navbar']   = "navbar";
				$data['sidebar']  = "sidebar";
				$data['body']     = "pegawai/edit";

				//Session
				$id_dept = $this->session->userdata('id_dept');
				$id_user = $this->session->userdata('id_user');

				//Query untuk mengambil data pegawai yang akan diedit, query ditampung dalam variabel '$row' untuk memanggil setiap data pada 1 orang pegawai
				$row = $this->model->profile($id)->row();

				//mengambil data nik yang sesuai dengan $id yang dipilih dan ditampung pada variabel $data dengan nama = nik
				$data['nik'] 				  = $id;
				//mengambil data nama pegawai melalui query $row dan ditampung pada variabel $data dengan nama = nama
				$data['nama'] 				  = $row->nama;
				//mengambil data email pegawai melalui query $row dan ditampung pada variabel $data dengan nama = email
				$data['email'] 				  = $row->email;
				//Dropdown pilih jabatan, menggunakan model (dropdown_jabatan), nama jabatan ditampung pada 'dd_jabatan', dan mengambil id_jabatan melalui $row dan ditampung pada variabel $data dengan nama = id_jabatan
				$data['dd_jabatan'] 		  = $this->model->dropdown_jabatan();
				$data['id_jabatan'] 		  = $row->id_jabatan;
				//Dropdown pilih departemen, menggunakan model (dropdown_departemen), nama departemen ditampung pada 'dd_departemen', dan mengambil id_departemen melalui $row dan ditampung pada variabel $data dengan nama = id_departemen
				$data['dd_departemen'] 		  = $this->model->dropdown_departemen();
				$data['id_departemen'] 		  = $row->id_dept;
				//Dropdown pilih sub departemen, menggunakan model (dropdown_bagian_departemen) dengan mengikuti id_departemen yang dipilih, nama jabatan ditampung pada 'dd_bagian_departemen', dan mengambil id_bagian_departemen melalui $row dan ditampung pada variabel $data dengan nama = id_bagian_departemen
				$data['dd_bagian_departemen'] = $this->model->dropdown_bagian_departemen($row->id_dept);
				$data['id_bagian_departemen'] = $row->id_bagian_dept;

				//Load template
				$this->load->view('template', $data);
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan admin
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		} else {
			//Bagian ini jika validasi dipenuhi, maka berhasil update pegawai
			//User harus admin, tidak boleh role user lain
			if ($this->session->userdata('level') == "Admin") {
				//Data pegawai ditampung dalam bentuk array
				$data = array(
					'nama'           => ucfirst($this->input->post('nama')),
					'email'          => trim($this->input->post('email')),
					'telp'          => trim($this->input->post('telp')),
					'id_jabatan'     => $this->input->post('id_jabatan'),
					'id_bagian_dept' => $this->input->post('id_bagian_departemen')
				);

				//Query update data yang ditampung ke dalam database. tersimpan ditabel pegawai
				$this->db->where('nik', $id);
				$this->db->update('pegawai', $data);

				//Set pemberitahuan bahwa data pegawai berhasil diupdate
				$this->session->set_flashdata('status', 'Diperbarui');
				//Kembali ke halaman pegawai (index)
				redirect('pegawai');
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan admin
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		}
	}
}
