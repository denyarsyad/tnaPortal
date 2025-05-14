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

	//Buat Incident
	public function buat()
	{
		//User harus SPV, tidak boleh role user lain
		if ($this->session->userdata('level') == "SPV") {
			//Menyusun template Buat incident
			$data['title'] 	  = "Input Incident";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "incidentSpv/buatIncident";

			//Session
			$id_dept 	= $this->session->userdata('id_dept');
			$id_user 	= $this->session->userdata('id_user');

			//Get kode incident yang akan digunakan sebagai id_incident menggunakan model(getkodeincident)
			$data['ticket'] = $this->model->getkodeticket();

			//Mengambil semua data profile user yang sedang login menggunakan model (profile)
			$data['profile'] = $this->model->profile($id_user)->row_array();

			//Dropdown pilih target, menggunakan model (dropdown_target), nama target ditampung pada 'dd_target', data yang akan di simpan adalah id_target dan akan ditampung pada 'id_target'
			$data['dd_dept'] = $this->model->dropdown_target();
			$data['id_dept'] = "";

			$data['error'] = "";

			//Load template
			$this->load->view('template', $data);
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan SPV
			//Akan dibawa ke Controller Errorpage
			redirect('Errorpage');
		}
	}

	public function submit()
	{
		//Form validasi untuk ketgori dengan nama validasi = id_kategori
		// $this->form_validation->set_rules(
		// 	'id_incident',
		// 	'Id_incident',
		// 	'required',
		// 	array(
		// 		'required' => '<strong>Failed!</strong> Incident Harus dipilih.'
		// 	)
		// );

		//Form validasi untuk subject dengan nama validasi = problem_summary
		$this->form_validation->set_rules(
			'problem',
			'problem',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		//Form validasi untuk deskripsi dengan nama validasi = path_photo
		$this->form_validation->set_rules(
			'path_photo',
			'Path_photo',
			'callback_file_upload'
		);


		//Kondisi jika proses buat incident tidak memenuhi syarat validasi akan dikembalikan ke form buat incident
		if ($this->form_validation->run() == FALSE) {
			//User harus User, tidak boleh role user lain
			if ($this->session->userdata('level') == "SPV") {
				//Menyusun template Buat incident
				$data['title'] 	  = "Buat Incidentxxx";
				$data['navbar']   = "navbar";
				$data['sidebar']  = "sidebar";
				$data['body']     = "incidentSpv/buatIncident";

				//Session
				$id_dept 	= $this->session->userdata('id_dept');
				$id_user 	= $this->session->userdata('id_user');

				//Get kode incident yang akan digunakan sebagai id_incident menggunakan model(getkodeIncident)
				$data['incident'] = $this->model->getkodeIncident();

				//Mengambil semua data profile user yang sedang login menggunakan model (profile)
				$data['profile'] = $this->model->profile($id_user)->row_array();

				//Dropdown pilih dept, menggunakan model (dropdown_dept), nama dept ditampung pada 'dd_dept', data yang akan di simpan adalah id_dept dan akan ditampung pada 'id_dept'
				$data['dd_dept'] = $this->model->dropdown_target();
				$data['id_dept'] = "";

				$data['error'] = "";

				//Load template
				$this->load->view('template', $data);
			} else {
				//Bagian ini jika role yang mengakses tidak sama dengan User
				//Akan dibawa ke Controller Errorpage
				redirect('Errorpage');
			}
		} else {
			//Bagian ini jika validasi dipenuhi untuk membuat incident
			//Session
			$id_user 	= $this->session->userdata('id_user');

			//Get kode incident yang akan digunakan sebagai id_incident menggunakan model(getkodeIncidentNew)
			$ticket 	= $this->model->getkodeIncidentNew($id_user);

			$date       = date("Y-m-d  H:i:s");

			//Konfigurasi Upload Gambar
			$config['upload_path'] 		= './uploads/';		//Folder untuk menyimpan gambar
			$config['allowed_types'] 	= 'gif|jpg|jpeg|png|pdf'; //Tipe file yang diizinkan
			$config['max_size'] 		= '25600';			//Ukuran maksimum file gambar yang diizinkan
			$config['max_width']        = '0';				//Ukuran lebar maks. 0 menandakan ga ada batas
			$config['max_height']       = '0';				//Ukuran tinggi maks. 0 menandakan ga ada batas

			//Memanggil library upload pada codeigniter dan menyimpan konfirguasi
			$this->load->library('upload', $config);
			//Jika upload gambar tidak sesuai dengan konfigurasi di atas, maka upload gambar gagal, dan kembali ke halaman Create incident
			if (!$this->upload->do_upload('path_photo')) {

				if ($_FILES['path_photo']['error'] != 4) {
					//Menyusun template Buat incident
					$data['title'] 	  = "Buat Incident";
					$data['navbar']   = "navbar";
					$data['sidebar']  = "sidebar";
					$data['body']     = "incident/buatIncident";
					//Session
					$id_dept 	= $this->session->userdata('id_dept');
					$id_user 	= $this->session->userdata('id_user');

					//Get kode incident yang akan digunakan sebagai id_incident menggunakan model(getkodeincident)
					$data['incident'] = $this->model->getkodeIncident();

					//Mengambil semua data profile user yang sedang login menggunakan model (profile)
					$data['profile'] = $this->model->profile($id_user)->row_array();

					//Dropdown pilih dept, menggunakan model (dropdown_dept), nama dept ditampung pada 'dd_dept', data yang akan di simpan adalah id_dept dan akan ditampung pada 'id_dept'
					$data['dd_dept'] = $this->model->dropdown_target();
					$data['id_dept'] = "";

					$data['error'] = $this->upload->display_errors();

					$this->load->view('template', $data);
				} else {
					$data = array(
						'id_incident'			=> $ticket,
						'date_incident'			=> $date,
						'target_dept'			=> $this->input->post('id_dept'),
						'problem'				=> ucfirst($this->input->post('problem')),
						'status'    			=> 'R',
						'path_photo'			=> 'no-image.jpg',
						'id_input'				=> $id_user,
						'add_id'				=> $id_user,
						'add_date'				=> $date
					);

					// $kat      = $this->input->post('id_kategori');
					// $subkat   = $this->input->post('id_sub_kategori');
					// $row      = $this->model->getkategori($kat)->row();
					// $key      = $this->db->query("SELECT * FROM kategori_sub WHERE id_sub_kategori = '$subkat'")->row();

					//Data tracking ditampung dalam bentuk array
					// $datatracking = array(
					// 	'id_ticket'  => $ticket,
					// 	'tanggal'    => date("Y-m-d H:i:s"),
					// 	'status'     => "Ticket Submited. Kategori: " . $row->nama_kategori . "(" . $key->nama_sub_kategori . ")",
					// 	'deskripsi'  => ucfirst($this->input->post('problem_detail')),
					// 	'id_user'    => $id_user
					// );

					//Query insert data ticket yang ditampung ke dalam database. tersimpan ditabel ticket
					$this->db->insert('incident', $data);
					//Query insert data tarcking yang ditampung ke dalam database. tersimpan ditabel tracking
					// $this->db->insert('tracking', $datatracking);

					//Memanggil fungsi kirim email dari user ke admin
					// $this->model->emailbuatticket($ticket);

					//Set pemberitahuan bahwa data tiket berhasil dibuat
					$this->session->set_flashdata('status', 'Dikirim');

					//Dialihkan ke halaman my ticket
					redirect('incident');
				}
			} else {
				//Bagian ini jika file gambar sesuai dengan konfirgurasi di atas
				//Menampung file gambar ke variable 'gambar'
				$gambar = $this->upload->data();
				//Data ticket ditampung dalam bentuk array
				$data = array(
					'id_incident'			=> $ticket,
					'date_incident'			=> $date,
					'target_dept'			=> $this->input->post('id_dept'),
					'problem'				=> ucfirst($this->input->post('problem')),
					'status'    			=> 'R',
					'path_photo'			=> $gambar['file_name'],
					'id_input'				=> $id_user,
					'add_id'				=> $id_user,
					'add_date'				=> $date
				);

				// $kat      = $this->input->post('id_kategori');
				// $subkat   = $this->input->post('id_sub_kategori');
				// $row      = $this->model->getkategori($kat)->row();
				// $key      = $this->db->query("SELECT * FROM kategori_sub WHERE id_sub_kategori = '$subkat'")->row();

				//Data tracking ditampung dalam bentuk array
				// $datatracking = array(
				// 	'id_ticket'  => $ticket,
				// 	'tanggal'    => date("Y-m-d H:i:s"),
				// 	'status'     => "Ticket Submited. Kategori: " . $row->nama_kategori . "(" . $key->nama_sub_kategori . ")",
				// 	'deskripsi'  => ucfirst($this->input->post('problem_detail')),
				// 	'id_user'    => $id_user
				// );

				//Query insert data ticket yang ditampung ke dalam database. tersimpan ditabel ticket
				$this->db->insert('incident', $data);
				//Query insert data tarcking yang ditampung ke dalam database. tersimpan ditabel tracking
				// $this->db->insert('tracking', $datatracking);

				//Memanggil fungsi kirim email dari user ke admin
				// $this->model->emailbuatticket($ticket);

				//Set pemberitahuan bahwa data tiket berhasil dibuat
				$this->session->set_flashdata('status', 'Dikirim');

				//Dialihkan ke halaman my ticket
				redirect('incident');
			}
		}
	}

	public function detail($id)
	{
		//User harus SPV, tidak boleh role user lain
		if ($this->session->userdata('level') == "SPV") {
			//Menyusun template Detail Incident
			$data['title'] 	  = "Detail Incident";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "incidentSpv/detail";

			//Session
			$id_dept 	= $this->session->userdata('id_dept');
			$id_user 	= $this->session->userdata('id_user');

			//Detail setiap incident, get dari model (detail_incident) berdasarkan id_incident, data akan ditampung dalam parameter 'detail'
			$data['detail'] = $this->model->detail_incident_spv($id)->row_array();

			////GET STATUS
			//$data['status'] = $this->model->getStatus($id)->result();

			//Tracking setiap incident, get dari model (tracking_incident) berdasarkan id_incident, data akan ditampung dalam parameter 'tracking'
			//$data['tracking'] = $this->model->tracking_incident($id)->result();

			//Message setiap incident, get dari model (incident_message) berdasarkan id_incident, data akan ditampung dalam parameter 'message'
			$data['message'] = $this->model->message_ticket($id)->result();

			//Load template
			$this->load->view('template', $data);
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan SPV
			//Akan dibawa ke Controller Errorpage
			redirect('Errorpage');
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

	//approve and reject
	public function approveSpv($id)
    {
        //User harus SPV, tidak boleh role user lain
		if ($this->session->userdata('level') == "SPV") {
			//Proses me-approve ticket, menggunakan model (approve) dengan parameter id_incident yang akan di-approve
			$this->model->approveIncidentSpv($id);
            //Set pemberitahuan bahwa tiket berhasil ditugaskan ke teknisi
            $this->session->set_flashdata('status', 'Ditugaskan');
			//Kembali ke halaman List approvel incident (list_approve)
			redirect('incident_spv/index');
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan SPV
			//Akan dibawa ke Controller Errorpage
			redirect('Errorpage');
		}
    }


    public function detail_reject($id)
    {
        //User harus SPV, tidak boleh role user lain
        if ($this->session->userdata('level') == "SPV") {
            //Menyusun template Detail Incident yang akan di-reject
            $data['title']    = "Tolak Incdident";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "incidentSpv/detailreject";

            //Session
            $id_dept = $this->session->userdata('id_dept');
            $id_user = $this->session->userdata('id_user');

            //Detail setiap tiket yang akan di-reject, get dari model (detail_incident) dengan parameter id_incident, data akan ditampung dalam parameter 'detail'
            $data['detail'] = $this->model->detail_incident($id)->row_array();

            //Load template
            $this->load->view('template', $data);
        } else {
            //Bagian ini jika role yang mengakses tidak sama dengan SPV
            //Akan dibawa ke Controller Errorpage
            redirect('Errorpage');
        }
    }

	public function reject($id)
    {
        $alasan  = $this->input->post('message');
        //Form validasi untuk message yang akan di kirim ke email user
        $this->form_validation->set_rules(
            'message',
            'Message',
            'required',
            array(
                'required' => '<strong>Failed!</strong> Alasan Harus diisi.'
            )
        );

        if ($this->form_validation->run() == FALSE) {
            //User harus SPV, tidak boleh role user lain
            if ($this->session->userdata('level') == "SPV") {
                //Menyusun template Detail Ticket yang akan di-reject
                $data['title']    = "Tolak Incident";
                $data['navbar']   = "navbar";
                $data['sidebar']  = "sidebar";
                $data['body']     = "incidentSpv/detailreject";

                //Session
                $id_dept = $this->session->userdata('id_dept');
                $id_user = $this->session->userdata('id_user');

                //Detail setiap incident yang akan di-reject, get dari model (detail_incident) dengan parameter id_incident, data akan ditampung dalam parameter 'detail'
                $data['detail'] = $this->model->detail_incident($id)->row_array();

                //Load template
                $this->load->view('template', $data);
            } else {
                //Bagian ini jika role yang mengakses tidak sama dengan SPV
                //Akan dibawa ke Controller Errorpage
                redirect('Errorpage');
            }
        } else {
            //User harus SPV, tidak boleh role user lain
            if ($this->session->userdata('level') == "SPV") {
                //Proses me-reject ticket, menggunakan model (reject) dengan parameter id_incident yang akan di-reject
                $this->model->rejectIncident($id, $alasan);
                //Memanggil fungsi kirim email dari SPV ke user
                //$this->model->emailreject($id);
                //Set pemberitahuan bahwa ticket berhasil di-reject
                $this->session->set_flashdata('status', 'Ditolak');
                //Kembali ke halaman List approvel ticket (list_approve)
                redirect('incident_spv/index');
            } else {
                //Bagian ini jika role yang mengakses tidak sama dengan SPV
                //Akan dibawa ke Controller Errorpage
                redirect('Errorpage');
            }
        }
    }

}
