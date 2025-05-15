<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


class Incident_pic extends CI_Controller
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
		if (empty($_FILES['filefoto']['name'])) {
			return true;
		} else {
			return true;
		}
	}

	//Incident
	public function index()
	{
		//User harus SPV, tidak boleh role user lain
		$level = ["User", "SPV"];
		if (in_array($this->session->userdata('level'), $level)) {
			//Menyusun template Incident
			$data['title'] 	  = "Daftar Incident";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "incidentPic/listIncident";

			//Session
			$id_dept 	 = $this->session->userdata('id_dept');
			$id_user 	 = $this->session->userdata('id_user');
			//$target_dept = $this->model->getTargetDept()->result();

			//Daftar semua incident yang di input
			$data['ticket'] = $this->model->picIncident($id_dept)->result();

			//Load template
			$this->load->view('template', $data);
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan SPV
			//Akan dibawa ke Controller Errorpage
			redirect('Errorpage');
		}
	}


	public function detail_update($id)
	{
		$level = ["User", "SPV"];
		if (in_array($this->session->userdata('level'), $level)) {
			//Menyusun template Detail ticket
			$data['title']    = "Update Progress";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "incidentPic/detailupdate";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			//Detail setiap tiket yang dikerjakan, get dari model (detail_incident_spv) berdasarkan id_incident, data akan ditampung dalam parameter 'detail'
			$data['detail'] = $this->model->detail_incident_spv($id)->row_array();

			//Tracking setiap tiket, get dari model (tracking_ticket) berdasarkan id_incident, data akan ditampung dalam parameter 'tracking'
			//$data['tracking'] = $this->model->tracking_ticket($id)->result();

			//Message setiap tiket, get dari model (ticket_message) berdasarkan id_incident, data akan ditampung dalam parameter 'message'
			$data['message'] = $this->model->message_ticket($id)->result();

			//Load template
			$this->load->view('template', $data);
		} else {
			redirect('Errorpage');
		}
	}

	public function update_progress($id)
	{
		//Form validasi untuk deskripsi dengan nama validasi = desk
		$this->form_validation->set_rules(
			'desk',
			'Desk',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Deskripsikan Progress Pekerjaan Anda.'
			)
		);

		$this->form_validation->set_rules(
			'progress',
			'Progress',
			'required|greater_than[0]',
			array(
				'required' => '<strong>Failed!</strong> Progress harus dipilih.'
			)
		);

		$this->form_validation->set_rules(
			'signed',
			'Signature',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Tanda Tangan harus dibuat.'
			)
		);

		//Form validasi untuk deskripsi dengan nama validasi = fileupdate
		$this->form_validation->set_rules(
			'fileupdate',
			'File_update',
			'callback_file_upload'
		);

		//Kondisi jika saat proses update tidak memenuhi syarat validasi akan dikembalikan ke halaman update progress
		if ($this->form_validation->run() == FALSE) {
			//Validasi dept
			$dept = ["2", "8", "11"]; //IT/GA/HSE
			if (in_array($this->session->userdata('id_dept'), $dept)) {
				//Menyusun template Detail ticket
				$data['title']    = "Update Progress";
				$data['navbar']   = "navbar";
				$data['sidebar']  = "sidebar";
				$data['body']     = "incidentPic/detailupdate";

				//Session
				$id_dept = $this->session->userdata('id_dept');
				$id_user = $this->session->userdata('id_user');

				//Detail setiap tiket yang dikerjakan, get dari model (detail_incident_spv) berdasarkan id_ticket, data akan ditampung dalam parameter 'detail'
				$data['detail'] = $this->model->detail_incident_spv($id)->row_array();

				//Tracking setiap tiket, get dari model (tracking_ticket) berdasarkan id_ticket, data akan ditampung dalam parameter 'tracking'
				//$data['tracking'] = $this->model->tracking_ticket($id)->result();

				//Load template
				$this->load->view('template', $data);
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan Teknisi
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		} else {
			//Bagian ini jika validasi terpenuhi
			//User harus dari dept IT/HSE/GA
			if (in_array($this->session->userdata('id_dept'), $dept)) {
				//Proses update incident, menggunakan model (update) dengan parameter id_incident yang akan di-update
				$this->model->update_progress_incident($id);

				//$this->model->emailselesai($id);
				//Set pemberitahuan bahwa incident berhasil di-update
				$this->session->set_flashdata('status', 'Diperbarui');
				//Kembali ke halaman List incident (Assignment Incident)
				redirect('incident_pic/index');
			} else {
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		}
	}


	public function submitMessage($id)
	{
		//Form validasi untuk deskripsi dengan nama validasi = problem_detail
		$this->form_validation->set_rules(
			'message',
			'Message',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		//Form validasi untuk deskripsi dengan nama validasi = problem_detail
		$this->form_validation->set_rules(
			'filefoto',
			'File_foto',
			''
		);

		//Kondisi jika proses buat tiket tidak memenuhi syarat validasi akan dikembalikan ke form buat tiket
		if ($this->form_validation->run() == FALSE) {
			//User harus User, tidak boleh role user lain
			if ($this->session->userdata('level') == "User") {
				//Menyusun template Buat ticket
				$data['title'] 	  = "Detail Tiket";
				$data['navbar']   = "navbar";
				$data['sidebar']  = "sidebar";
				$data['body']     = "ticketUser/detail";

				//Session
				$id_dept 	= $this->session->userdata('id_dept');
				$id_user 	= $this->session->userdata('id_user');

				//Detail setiap tiket, get dari model (detail_ticket) berdasarkan id_ticket, data akan ditampung dalam parameter 'detail'
				$data['detail'] = $this->model->detail_ticket($id)->row_array();

				//Tracking setiap tiket, get dari model (tracking_ticket) berdasarkan id_ticket, data akan ditampung dalam parameter 'tracking'
				$data['tracking'] = $this->model->tracking_ticket($id)->result();

				//Message setiap tiket, get dari model (ticket_message) berdasarkan id_ticket, data akan ditampung dalam parameter 'message'
				$data['message'] = $this->model->message_ticket($id)->result();

				//Load template
				$this->load->view('template', $data);
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan User
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		} else {
			//Bagian ini jika validasi dipenuhi untuk membuat ticket
			//Session
			$id_user 	= $this->session->userdata('id_user');

			//Tanggal
			$date       = date("Y-m-d H:i:s");

			//Konfigurasi Upload Gambar
			$config['upload_path'] 		= './uploads/';		//Folder untuk menyimpan gambar
			$config['allowed_types'] 	= 'gif|jpg|jpeg|png';	//Tipe file yang diizinkan
			$config['max_size'] 		= '25600';			//Ukuran maksimum file gambar yang diizinkan
			$config['max_width']        = '0';				//Ukuran lebar maks. 0 menandakan ga ada batas
			$config['max_height']       = '0';				//Ukuran tinggi maks. 0 menandakan ga ada batas

			//Memanggil library upload pada codeigniter dan menyimpan konfirguasi
			$this->load->library('upload', $config);

			if ($_FILES['filefoto']['name'] != "") {
				//Jika upload gambar tidak sesuai dengan konfigurasi di atas, maka upload gambar gagal, dan kembali ke halaman Create ticket
				if (!$this->upload->do_upload('filefoto')) {
					$this->session->set_flashdata('status', 'Error');
					redirect('ticket_user/detail/' . $id);
				} else {
					//Bagian ini jika file gambar sesuai dengan konfirgurasi di atas
					//Menampung file gambar ke variable 'gambar'
					$gambar = $this->upload->data();

					//Data message ditampung dalam bentuk array
					$datamessage = array(
						'id_ticket'  => $id,
						'tanggal'    => $date,
						'status'     => 1,
						'message'  	 => htmlspecialchars($this->input->post('message')),
						'id_user'    => $id_user,
						'filefoto'	 => $gambar['file_name'],
					);

					//Query insert data ticket_message yang ditampung ke dalam database. tersimpan ditabel ticket_message
					$this->db->insert('ticket_message', $datamessage);

					//Memanggil fungsi kirim email dari user ke admin
					$this->model->emailmessageticket($id);

					//Set pemberitahuan bahwa data tiket berhasil dibuat
					$this->session->set_flashdata('status', 'Success');
					//Dialihkan ke halaman my ticket
					redirect('ticket_user/detail/' . $id);
				}
			} else {
				//Bagian ini jika file gambar sesuai dengan konfirgurasi di atas
				//Menampung file gambar ke variable 'gambar'
				$gambar = $this->upload->data();

				//Data message ditampung dalam bentuk array
				$datamessage = array(
					'id_ticket'  => $id,
					'tanggal'    => $date,
					'status'     => 1,
					'message'  	 => htmlspecialchars($this->input->post('message')),
					'id_user'    => $id_user,
				);

				//Query insert data ticket_message yang ditampung ke dalam database. tersimpan ditabel ticket_message
				$this->db->insert('ticket_message', $datamessage);

				//Memanggil fungsi kirim email dari user ke admin
				$this->model->emailmessageticket($id);

				//Set pemberitahuan bahwa data tiket berhasil dibuat
				$this->session->set_flashdata('status', 'Success');
				//Dialihkan ke halaman my ticket
				redirect('ticket_user/detail/' . $id);
			}
		}
	}

}
