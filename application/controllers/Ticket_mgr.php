<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ticket_mgr extends CI_Controller
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

	public function detail_approve_mgr($id)
    {
        //User harus MGR, tidak boleh role user lain
        if ($this->session->userdata('level') == "MGR") {
            //Menyusun template Detail Ticket yang belum di-approve
            $data['title']    = "Detail Tiket";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticketMgr/detailApproveMgr";

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
        } else {
            //Bagian ini jika role yang mengakses tidak sama dengan admin
            //Akan dibawa ke Controller Errorpage
            redirect('Errorpage');
        }
    }

	//List Assignment
	public function list_tugas_mgr()
	{
		//User harus MGR, tidak boleh role user lain
		if ($this->session->userdata('level') == "MGR") {
			//Menyusun template List Assignment
			$data['title'] 	  = "Daftar Ticket";
			$data['desc']     = "Daftar semua tiket yang diajukan.";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "ticketMgr/listTugasMgr";

			//Session
			$id_dept 	= $this->session->userdata('id_dept');
			$id_user 	= $this->session->userdata('id_user');

			//get data
			$data['tugasMgr'] = $this->model->list_ticket_mgr($id_user)->result();
            //var_dump($data['tugasMgr']);

			//Load template
			$this->load->view('template', $data);
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan Teknisi
			//Akan dibawa ke Controller Errorpage
			redirect('Errorpage');
		}
	}

	public function assign_to_mgr($id)
    {
        if ($this->session->userdata('level') == "MGR") {
            //Menyusun template Detail Ticket yang belum di-approve
            $data['title']    = "Set Assign To";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticketMgr/assignto";

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
            ////Dropdown pilih prioritas, menggunakan model (dropdown_prioritas), nama prioritas ditampung pada 'dd_prioritas', data yang akan di simpan adalah id_prioritas dan akan ditampung pada 'id_prioritas'
            //$data['dd_prioritas'] = $this->model->dropdown_prioritas();
            //$data['id_prioritas'] = "";

            //Dropdown pilih Teknisi, menggunakan model (dropdown_teknisi), nama teknisi ditampung pada 'dd_teknisi', dan data yang akan di simpan adalah id_user dengan level teknisi, data akan ditampung pada 'id_teknisi'
            $data['dd_spv_tech'] = $this->model->dropdown_spv_tech();
            $data['id_spv_tech'] = "";

            //Load template
            $this->load->view('template', $data);
        } else {
            //Bagian ini jika role yang mengakses tidak sama dengan admin
            //Akan dibawa ke Controller Errorpage
            redirect('Errorpage');
        }
    }

	public function approveMgr($id)
    {
        //User harus MGR, tidak boleh role user lain
		if ($this->session->userdata('level') == "MGR") {
			//Proses me-approve ticket, menggunakan model (approve) dengan parameter id_ticket yang akan di-approve
			$this->model->approveMgr($id);
            //Set pemberitahuan bahwa tiket berhasil ditugaskan ke teknisi
            $this->session->set_flashdata('status', 'Ditugaskan');
			//Kembali ke halaman List approvel ticket (list_approve)
			redirect('ticket_mgr/list_tugas_mgr');
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan MGR
			//Akan dibawa ke Controller Errorpage
			redirect('Errorpage');
		}
    }


    public function detail_reject($id)
    {
        //User harus MGR, tidak boleh role user lain
        if ($this->session->userdata('level') == "MGR") {
            //Menyusun template Detail Ticket yang akan di-reject
            $data['title']    = "Tolak Tiket";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticketMgr/detailreject";

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

    public function detail_noted($id)
    {
        //User harus MGR, tidak boleh role user lain
        if ($this->session->userdata('level') == "MGR") {
            //Menyusun template Detail Ticket yang akan di-noted
            $data['title']    = "Kembalikan Tiket";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticketMgr/detailNote";

            //Session
            $id_dept = $this->session->userdata('id_dept');
            $id_user = $this->session->userdata('id_user');

            //Detail setiap tiket yang akan di-noted, get dari model (detail_ticket) dengan parameter id_ticket, data akan ditampung dalam parameter 'detail'
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
            //User harus MGR, tidak boleh role user lain
            if ($this->session->userdata('level') == "MGR") {
                //Menyusun template Detail Ticket yang akan di-reject
                $data['title']    = "Tolak Tiket";
                $data['navbar']   = "navbar";
                $data['sidebar']  = "sidebar";
                $data['body']     = "ticketMgr/detailreject";

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
            //User harus MGR, tidak boleh role user lain
            if ($this->session->userdata('level') == "MGR") {
                //Proses me-reject ticket, menggunakan model (reject) dengan parameter id_ticket yang akan di-reject
                $this->model->reject($id, $alasan);
                //Memanggil fungsi kirim email dari MGR ke user
                //$this->model->emailreject($id);
                //Set pemberitahuan bahwa ticket berhasil di-reject
                $this->session->set_flashdata('status', 'Ditolak');
                //Kembali ke halaman List approvel ticket (list_approve)
                redirect('ticket_mgr/list_tugas_mgr');
            } else {
                //Bagian ini jika role yang mengakses tidak sama dengan SPV
                //Akan dibawa ke Controller Errorpage
                redirect('Errorpage');
            }
        }
    }

	public function noted($id)
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
            //User harus MGR, tidak boleh role user lain
            if ($this->session->userdata('level') == "MGR") {
                //Menyusun template Detail Ticket yang akan di-noted
                $data['title']    = "Kembalikan Tiket";
                $data['navbar']   = "navbar";
                $data['sidebar']  = "sidebar";
                $data['body']     = "ticketMgr/detailnote";

                //Session
                $id_dept = $this->session->userdata('id_dept');
                $id_user = $this->session->userdata('id_user');

                //Detail setiap tiket yang akan di-noted, get dari model (detail_ticket) dengan parameter id_ticket, data akan ditampung dalam parameter 'detail'
                $data['detail'] = $this->model->detail_ticket($id)->row_array();

                //Load template
                $this->load->view('template', $data);
            } else {
                //Bagian ini jika role yang mengakses tidak sama dengan admin
                //Akan dibawa ke Controller Errorpage
                redirect('Errorpage');
            }
        } else {
            //User harus MGR, tidak boleh role user lain
            if ($this->session->userdata('level') == "MGR") {
                //Proses me-noted ticket, menggunakan model (noted) dengan parameter id_ticket yang akan di-noted
                $this->model->noted($id, $alasan);
                //Memanggil fungsi kirim email dari MGR ke user
                //$this->model->emailnoted($id);
                //Set pemberitahuan bahwa ticket berhasil di-noted
                $this->session->set_flashdata('status', 'Dikembalikan');
                //Kembali ke halaman List approvel ticket (list_approve)
                redirect('ticket_mgr/list_tugas_mgr');
            } else {
                //Bagian ini jika role yang mengakses tidak sama dengan SPV
                //Akan dibawa ke Controller Errorpage
                redirect('Errorpage');
            }
        }
    }


}
