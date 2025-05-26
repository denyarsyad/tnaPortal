<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ticket_mgrd extends CI_Controller
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

    public function detail_approve($id, $status)
    {
        //User harus MGRD, tidak boleh role user lain
        if ($this->session->userdata('level') == "MGRD" && $status != 10) {
            //Menyusun template Detail Ticket yang belum di-approve
            $data['title']    = "Detail Tiket";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticketMgrDept/detailapprove";

            //Session
            $id_dept = $this->session->userdata('id_dept');
            $id_user = $this->session->userdata('id_user');

            //Detail setiap tiket yang belum di-approve, get dari model (detail_ticket) dengan parameter id_ticket, data akan ditampung dalam parameter 'detail'
            $data['detail'] = $this->model->detail_ticket($id)->row_array();

            //Tracking setiap tiket, get dari model (tracking_ticket) berdasarkan id_ticket, data akan ditampung dalam parameter 'tracking'
            $data['tracking'] = $this->model->tracking_ticket($id)->result();

            //Message setiap tiket, get dari model (ticket_message) berdasarkan id_ticket, data akan ditampung dalam parameter 'message'
            $data['message'] = $this->model->message_ticket($id)->result();

            //Load template
            $this->load->view('template', $data);
        } else if ($this->session->userdata('level') == "MGRD" && $status == 10) {
				 $data['title']    = "Detail Tiket #" . $id;
             $data['navbar']   = "navbar";
             $data['sidebar']  = "sidebar";
             $data['body']     = "ticketMgrDept/editticket";

             //Session
             $id_dept = $this->session->userdata('id_dept');
             $id_user = $this->session->userdata('id_user');

             //Detail setiap tiket yang belum di-approve, get dari model (detail_ticket) dengan parameter id_ticket, data akan ditampung dalam parameter 'detail'
             $data['detail'] = $this->model->detail_ticket($id)->row_array();
				 $data['dd_kategori'] = $this->model->dropdown_kategori();
				 $data['id_kategori'] = "";

				 $data['dd_sub_kategori'] = $this->model->dropdown_sub_kategori('');
				 $data['id_sub_kategori'] = "";

				 $data['dd_lokasi'] = $this->model->dropdown_lokasi();
				 $data['id_lokasi'] = "";

				$this->load->view('template', $data);
		  } else {
            //Bagian ini jika role yang mengakses tidak sama dengan admin
            //Akan dibawa ke Controller Errorpage
            redirect('Errorpage');
        }
    }

    //List Approve
    public function index_tugas()
    {
        //User harus MGRD, tidak boleh role user lain
        if ($this->session->userdata('level') == "MGRD") {
            //Menyusun template List Approve
            $data['title']       = "Daftar Ticket";
            $data['desc']     = "Daftar semua tiket yang diajukan untuk Anda.";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticketMgrDept/listtugas";

            //Session
            $id_dept     = $this->session->userdata('id_dept');
            $id_user     = $this->session->userdata('id_user');

            //get data
            $data['tugas'] = $this->model->list_ticket_mgrd($id_user)->result();

            //Load template
            $this->load->view('template', $data);
        } else {
            //Bagian ini jika role yang mengakses tidak sama dengan SPV
            //Akan dibawa ke Controller Errorpage
            redirect('Errorpage');
        }
    }

    public function set_prioritas($id)
    {
        if ($this->session->userdata('level') == "MGRD") {
            //Menyusun template Detail Ticket yang belum di-approve
            $data['title']    = "Set Prioritas Pengajuan";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticketMgrDept/setprioritas";

            //Session
            $id_dept = $this->session->userdata('id_dept');
            $id_user = $this->session->userdata('id_user');

            $nama   = $this->input->post('nama');
            $email  = $this->input->post('email');

            //Detail setiap tiket yang belum di-approve, get dari model (detail_ticket) dengan parameter id_ticket, data akan ditampung dalam parameter 'detail'
            $data['detail'] = $this->model->detail_ticket($id)->row_array();

            //Tracking setiap tiket, get dari model (tracking_ticket) berdasarkan id_ticket, data akan ditampung dalam parameter 'tracking'
            $data['tracking'] = $this->model->tracking_ticket($id)->result();

            $row = $this->model->detail_ticket($id)->row();
            //Dropdown pilih prioritas, menggunakan model (dropdown_prioritas), nama prioritas ditampung pada 'dd_prioritas', data yang akan di simpan adalah id_prioritas dan akan ditampung pada 'id_prioritas'
            $data['dd_prioritas'] = $this->model->dropdown_prioritas();
            $data['id_prioritas'] = "";

            //Dropdown pilih Teknisi, menggunakan model (dropdown_teknisi), nama teknisi ditampung pada 'dd_teknisi', dan data yang akan di simpan adalah id_user dengan level teknisi, data akan ditampung pada 'id_teknisi'
            $data['dd_teknisi'] = $this->model->dropdown_teknisi();
            $data['id_teknisi'] = "";

            //Load template
            $this->load->view('template', $data);
        } else {
            //Bagian ini jika role yang mengakses tidak sama dengan admin
            //Akan dibawa ke Controller Errorpage
            redirect('Errorpage');
        }
    }

    public function approveMgrd($id)
    {
        //User harus MGRD, tidak boleh role user lain
        if ($this->session->userdata('level') == "MGRD") {
            //Proses me-approve ticket, menggunakan model (approve) dengan parameter id_ticket yang akan di-approve
            $this->model->approveMgrd($id);
            //Set pemberitahuan bahwa tiket berhasil ditugaskan ke teknisi
            $this->session->set_flashdata('status', 'Di Approve');
            //Kembali ke halaman List approvel ticket (list_approve)
            redirect('ticket_mgrd/index_tugas');
        } else {
            //Bagian ini jika role yang mengakses tidak sama dengan MGRD
            //Akan dibawa ke Controller Errorpage
            redirect('Errorpage');
        }
    }


    public function detail_reject($id)
    {
        //User harus MGRD, tidak boleh role user lain
        if ($this->session->userdata('level') == "MGRD") {
            //Menyusun template Detail Ticket yang akan di-reject
            $data['title']    = "Tolak Tiket";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticketMgrDept/detailreject";

            //Session
            $id_dept = $this->session->userdata('id_dept');
            $id_user = $this->session->userdata('id_user');

            //Detail setiap tiket yang akan di-reject, get dari model (detail_ticket) dengan parameter id_ticket, data akan ditampung dalam parameter 'detail'
            $data['detail'] = $this->model->detail_ticket($id)->row_array();

            //Load template
            $this->load->view('template', $data);
        } else {
            //Bagian ini jika role yang mengakses tidak sama dengan admin
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
            //User harus MGRD, tidak boleh role user lain
            if ($this->session->userdata('level') == "MGRD") {
                //Menyusun template Detail Ticket yang akan di-reject
                $data['title']    = "Tolak Tiket";
                $data['navbar']   = "navbar";
                $data['sidebar']  = "sidebar";
                $data['body']     = "ticketMgrDept/detailreject";

                //Session
                $id_dept = $this->session->userdata('id_dept');
                $id_user = $this->session->userdata('id_user');

                //Detail setiap tiket yang akan di-reject, get dari model (detail_ticket) dengan parameter id_ticket, data akan ditampung dalam parameter 'detail'
                $data['detail'] = $this->model->detail_ticket($id)->row_array();

                //Load template
                $this->load->view('template', $data);
            } else {
                //Bagian ini jika role yang mengakses tidak sama dengan admin
                //Akan dibawa ke Controller Errorpage
                redirect('Errorpage');
            }
        } else {
            //User harus MGRD, tidak boleh role user lain
            if ($this->session->userdata('level') == "MGRD") {
                //Proses me-reject ticket, menggunakan model (reject) dengan parameter id_ticket yang akan di-reject
                $this->model->reject($id, $alasan);
                //Memanggil fungsi kirim email dari MGRD ke user
                //$this->model->emailreject($id);
                //Set pemberitahuan bahwa ticket berhasil di-reject
                $this->session->set_flashdata('status', 'Ditolak');
                //Kembali ke halaman List approvel ticket (list_approve)
                redirect('ticket_mgrd/index_tugas');
            } else {
                //Bagian ini jika role yang mengakses tidak sama dengan SPV
                //Akan dibawa ke Controller Errorpage
                redirect('Errorpage');
            }
        }
    }

    //Buat Ticket 2025.05.20
	public function buat()
	{
		if ($this->session->userdata('level') == "MGRD") {
			//Menyusun template Buat ticket
			$data['title'] 	  = "Buat Tiket";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "ticketMgrDept/buatticket";

			//Session
			$id_dept 	= $this->session->userdata('id_dept');
			$id_user 	= $this->session->userdata('id_user');

			//Get kode ticket yang akan digunakan sebagai id_ticket menggunakan model(getkodeticket)
			$data['ticket'] = $this->model->getkodeticket();

			//Mengambil semua data profile user yang sedang login menggunakan model (profile)
			$data['profile'] = $this->model->profile($id_user)->row_array();

			//Dropdown pilih kategori, menggunakan model (dropdown_kategori), nama kategori ditampung pada 'dd_kategori', data yang akan di simpan adalah id_kategori dan akan ditampung pada 'id_kategori'
			$data['dd_kategori'] = $this->model->dropdown_kategori();
			$data['id_kategori'] = "";

			//Dropdown pilih sub kategori, menggunakan model (dropdown_sub_kategori), nama kategori ditampung pada 'dd_sub_kategori', data yang akan di simpan adalah id_sub_kategori dan akan ditampung pada 'id_sub_kategori'
			$data['dd_sub_kategori'] = $this->model->dropdown_sub_kategori('');
			$data['id_sub_kategori'] = "";

			//Dropdown pilih lokasi, menggunakan model (dropdown_lokasi), nama kondisi ditampung pada 'dd_lokasi', data yang akan di simpan adalah id_lokasi dan akan ditampung pada 'id_lokasi'
			$data['dd_lokasi'] = $this->model->dropdown_lokasi();
			$data['id_lokasi'] = "";

			$data['error'] = "";

			//Load template
			$this->load->view('template', $data);
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan User
			//Akan dibawa ke Controller Errorpage
			redirect('Errorpage');
		}
	}

    public function submit()
	{
		//Form validasi untuk ketgori dengan nama validasi = id_kategori
		$this->form_validation->set_rules(
			'id_kategori',
			'Id_kategori',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Kategori Harus dipilih.'
			)
		);

		//Form validasi untuk sub kategori dengan nama validasi = id_sub_kategori
		$this->form_validation->set_rules(
			'id_sub_kategori',
			'id_sub_kategori',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Sub Kategori Harus dipilih.'
			)
		);

		//Form validasi untuk lokasi dengan nama validasi = lokasi
		$this->form_validation->set_rules(
			'id_lokasi',
			'Id_lokasi',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Lokasi Harus dipilih.'
			)
		);
		//Form validasi untuk subject dengan nama validasi = due_date
		$this->form_validation->set_rules(
            'due_date',
            'due_date',
            'required',
            array(
                'required' => '<strong>Failed!</strong> Field Harus diisi.'
            )
		);
		//Form validasi untuk subject dengan nama validasi = due_date
		$this->form_validation->set_rules(
			'due_date',
			'due_date',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);
		//Form validasi untuk subject dengan nama validasi = problem_summary
		$this->form_validation->set_rules(
			'problem_summary',
			'Problem_summary',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		//Form validasi untuk deskripsi dengan nama validasi = problem_detail
		$this->form_validation->set_rules(
			'problem_detail',
			'Problem_detail',
			'required',
			array(
				'required' => '<strong>Failed!</strong> Field Harus diisi.'
			)
		);

		//Form validasi untuk deskripsi dengan nama validasi = filefoto
		$this->form_validation->set_rules(
			'filefoto',
			'File_foto',
			'callback_file_upload'
		);

		//Kondisi jika proses buat tiket tidak memenuhi syarat validasi akan dikembalikan ke form buat tiket
		if ($this->form_validation->run() == FALSE) {
			if ($this->session->userdata('level') == "MGRD") {
				//Menyusun template Buat ticket
				$data['title'] 	  = "Buat Tiket";
				$data['navbar']   = "navbar";
				$data['sidebar']  = "sidebar";
				$data['body']     = "ticketMgrDept/buatticket";

				//Session
				$id_dept 	= $this->session->userdata('id_dept');
				$id_user 	= $this->session->userdata('id_user');

				//Get kode ticket yang akan digunakan sebagai id_ticket menggunakan model(getkodeticket)
				$data['ticket'] = $this->model->getkodeticket();

				//Mengambil semua data profile user yang sedang login menggunakan model (profile)
				$data['profile'] = $this->model->profile($id_user)->row_array();

				//Dropdown pilih kategori, menggunakan model (dropdown_kategori), nama kategori ditampung pada 'dd_kategori', data yang akan di simpan adalah id_kategori dan akan ditampung pada 'id_kategori'
				$data['dd_kategori'] = $this->model->dropdown_kategori();
				$data['id_kategori'] = "";

				//Dropdown pilih sub kategori, menggunakan model (dropdown_sub_kategori), nama kategori ditampung pada 'dd_sub_kategori', data yang akan di simpan adalah id_sub_kategori dan akan ditampung pada 'id_sub_kategori'
				$data['dd_sub_kategori'] = $this->model->dropdown_sub_kategori('');
				$data['id_sub_kategori'] = "";

				//Dropdown pilih lokasi, menggunakan model (dropdown_lokasi), nama kondisi ditampung pada 'dd_lokasi', data yang akan di simpan adalah id_lokasi dan akan ditampung pada 'id_lokasi'
				$data['dd_lokasi'] = $this->model->dropdown_lokasi();
				$data['id_lokasi'] = "";

				$data['error'] = "";

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

			//Get kode ticket yang akan digunakan sebagai id_ticket menggunakan model(getkodeticketnew)
			$ticket 	= $this->model->getkodeticketnew();
			$date       = date("Y-m-d  H:i:s");

			//Konfigurasi Upload Gambar
			$config['upload_path'] 		= './uploads/';		//Folder untuk menyimpan gambar
			$config['allowed_types'] 	= 'gif|jpg|jpeg|png|pdf';	//Tipe file yang diizinkan
			$config['max_size'] 		= '25600';			//Ukuran maksimum file gambar yang diizinkan
			$config['max_width']        = '0';				//Ukuran lebar maks. 0 menandakan ga ada batas
			$config['max_height']       = '0';				//Ukuran tinggi maks. 0 menandakan ga ada batas

			//Memanggil library upload pada codeigniter dan menyimpan konfirguasi
			$this->load->library('upload', $config);
			//Jika upload gambar tidak sesuai dengan konfigurasi di atas, maka upload gambar gagal, dan kembali ke halaman Create ticket
			if (!$this->upload->do_upload('filefoto')) {
				//$this->session->set_flashdata('status', 'Error');
				//redirect('ticket_user/buat');

				if ($_FILES['filefoto']['error'] != 4) {
					//Menyusun template Buat ticket
					$data['title'] 	  = "Buat Tiket";
					$data['navbar']   = "navbar";
					$data['sidebar']  = "sidebar";
					$data['body']     = "ticketMgrDept/buatticket";
					//Session
					$id_dept 	= $this->session->userdata('id_dept');
					$id_user 	= $this->session->userdata('id_user');

					//Get kode ticket yang akan digunakan sebagai id_ticket menggunakan model(getkodeticket)
					$data['ticket'] = $this->model->getkodeticket();

					//Mengambil semua data profile user yang sedang login menggunakan model (profile)
					$data['profile'] = $this->model->profile($id_user)->row_array();

					//Dropdown pilih kategori, menggunakan model (dropdown_kategori), nama kategori ditampung pada 'dd_kategori', data yang akan di simpan adalah id_kategori dan akan ditampung pada 'id_kategori'
					$data['dd_kategori'] = $this->model->dropdown_kategori();
					$data['id_kategori'] = "";

					//Dropdown pilih sub kategori, menggunakan model (dropdown_sub_kategori), nama kategori ditampung pada 'dd_sub_kategori', data yang akan di simpan adalah id_sub_kategori dan akan ditampung pada 'id_sub_kategori'
					$data['dd_sub_kategori'] = $this->model->dropdown_sub_kategori('');
					$data['id_sub_kategori'] = "";

					//Dropdown pilih lokasi, menggunakan model (dropdown_lokasi), nama kondisi ditampung pada 'dd_lokasi', data yang akan di simpan adalah id_lokasi dan akan ditampung pada 'id_lokasi'
					$data['dd_lokasi'] = $this->model->dropdown_lokasi();
					$data['id_lokasi'] = "";

					$data['error'] = $this->upload->display_errors();

					$this->load->view('template', $data);
				} else {
					$data = array(
						'id_ticket'			=> $ticket,
						'tanggal'			=> $date,
						'last_update'		=> date("Y-m-d H:i:s"),
						'reported'			=> $id_user,
						'id_sub_kategori' 	=> $this->input->post('id_sub_kategori'),
						'due_date'			=> ucfirst($this->input->post('due_date')),
						'problem_summary'	=> ucfirst($this->input->post('problem_summary')),
						'problem_detail'	=> ucfirst($this->input->post('problem_detail')),
						'status'    		=> 11,
						'progress'			=> 0,
						'filefoto'			=> 'no-image.jpg',
						'id_lokasi'			=> $this->input->post('id_lokasi')
					);

					$kat      = $this->input->post('id_kategori');
					$subkat   = $this->input->post('id_sub_kategori');
					$row      = $this->model->getkategori($kat)->row();
					$key      = $this->db->query("SELECT * FROM kategori_sub WHERE id_sub_kategori = '$subkat'")->row();

					//Data tracking ditampung dalam bentuk array
					$datatracking = array(
						'id_ticket'  => $ticket,
						'tanggal'    => date("Y-m-d H:i:s"),
						'status'     => "Ticket Submited and Approved. Kategori: " . $row->nama_kategori . "(" . $key->nama_sub_kategori . ")",
						'deskripsi'  => ucfirst($this->input->post('problem_detail')),
						'id_user'    => $id_user
					);

					//Query insert data ticket yang ditampung ke dalam database. tersimpan ditabel ticket
					$this->db->insert('ticket', $data);
					//Query insert data tarcking yang ditampung ke dalam database. tersimpan ditabel tracking
					$this->db->insert('tracking', $datatracking);

					//Memanggil fungsi kirim email dari user ke admin
					//$this->model->emailbuatticket($ticket);

					//Set pemberitahuan bahwa data tiket berhasil dibuat
					$this->session->set_flashdata('status', 'Dikirim');

					//Dialihkan ke halaman my ticket
					redirect('ticket_mgrd/index_tugas');
				}
			} else {
				//Bagian ini jika file gambar sesuai dengan konfirgurasi di atas
				//Menampung file gambar ke variable 'gambar'
				$gambar = $this->upload->data();
				//Data ticket ditampung dalam bentuk array
				$data = array(
					'id_ticket'			=> $ticket,
					'tanggal'			=> $date,
					'last_update'		=> date("Y-m-d H:i:s"),
					'reported'			=> $id_user,
					'id_sub_kategori' 	=> $this->input->post('id_sub_kategori'),
					'due_date'			=> ucfirst($this->input->post('due_date')),
					'problem_summary'	=> ucfirst($this->input->post('problem_summary')),
					'problem_detail'	=> ucfirst($this->input->post('problem_detail')),
					'status'    		=> 11,
					'progress'			=> 0,
					'filefoto'			=> $gambar['file_name'],
					'id_lokasi'			=> $this->input->post('id_lokasi')
				);

				$kat      = $this->input->post('id_kategori');
				$subkat   = $this->input->post('id_sub_kategori');
				$row      = $this->model->getkategori($kat)->row();
				$key      = $this->db->query("SELECT * FROM kategori_sub WHERE id_sub_kategori = '$subkat'")->row();

				//Data tracking ditampung dalam bentuk array
				$datatracking = array(
					'id_ticket'  => $ticket,
					'tanggal'    => date("Y-m-d H:i:s"),
					'status'     => "Ticket Submited and Approved. Kategori: " . $row->nama_kategori . "(" . $key->nama_sub_kategori . ")",
					'deskripsi'  => ucfirst($this->input->post('problem_detail')),
					'id_user'    => $id_user
				);

				//Query insert data ticket yang ditampung ke dalam database. tersimpan ditabel ticket
				$this->db->insert('ticket', $data);
				//Query insert data tarcking yang ditampung ke dalam database. tersimpan ditabel tracking
				$this->db->insert('tracking', $datatracking);

				//Memanggil fungsi kirim email dari user ke admin
				//$this->model->emailbuatticket($ticket);

				//Set pemberitahuan bahwa data tiket berhasil dibuat
				$this->session->set_flashdata('status', 'Dikirim');

				//Dialihkan ke halaman my ticket
				redirect('ticket_mgrd/index_tugas');
			}
		}
	}
}
