<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
PT. ITSHOP BISNIS DIGITAL
Toko Online: ITSHOP Purwokerto (Tokopedia.com/itshoppwt, Shopee.co.id/itshoppwt, Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
Created: 12-2022
Modified: 02-2025
*/

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Meload model
        $this->load->model('Main_model', 'model');
        //Jika session tidak ditemukan
        if (!$this->session->userdata('id_user')) {
            //Kembali ke halaman Login
            $this->session->set_flashdata("msg", "<div class='alert alert-info'>
       		<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
       	    <strong><span class='glyphicon glyphicon-remove-sign'></span></strong> 
       	    Silahkan masuk terlebih dahulu.</div>");
            redirect('login');
        }
    }

    public function index()
    {
        //Template dashboard
        $data['title']      = "Dashboard";
        $data['navbar']     = "navbar";
        $data['sidebar']    = "sidebar";
        //Dashboard Admin
        if ($this->session->userdata('level') == "Admin") {
            $data['body']         = "dashboard/dashboard";
        //Dashboard Teknisi
        } else if ($this->session->userdata('level') == "Technician") {
            $data['body']         = "dashboard/dashboard_teknisi";
        //Dashboard User
        } else if ($this->session->userdata('level') == "User") {
            $data['body']         = "dashboard/dashboard_user";
        }

        //Session
        $id_dept = $this->session->userdata('id_dept');
        $id_user = $this->session->userdata('id_user');

        //Papan Pengumuman
        $data['datainformasi'] = $this->model->informasi()->result();
        $data['jmldatainformasi'] = $this->model->informasi()->num_rows();

        //Dashboard Admin
        //Jumlah Tiket
        $data['jml_ticket']         = $this->model->getTicket()->num_rows();
        //Jumlah tiket yang ditolak Admin
        $data['jml_reject']         = $this->model->getStatusTicket(0)->num_rows();
        //Jumlah tiket yang butuh persetujuan Admin
        $jmlnew = $this->db->query("SELECT COUNT(id_ticket) AS jml_new FROM ticket WHERE status IN (1,2)")->row();
        $data['jml_new']           = $jmlnew->jml_new;
        //Jumlah tiket yang belum memilih teknisi
        $data['jml_choose']         = $this->model->getStatusTicket(1)->num_rows();
        //Jumlah tiket yang butuh persetujuan teknisi
        $data['jml_approve_tek']    = $this->model->getStatusTicket(3)->num_rows();
        //Jumlah tiket yang sedang dikerjakan
        $data['jml_process']        = $this->model->getStatusTicket(4)->num_rows();
        //Jumlah tiket yang sedang dipending
        $data['jml_pending']        = $this->model->getStatusTicket(5)->num_rows();
        //Jumlah tiket selesai
        $jmldone = $this->db->query("SELECT COUNT(id_ticket) AS jml_done FROM ticket WHERE status IN (6,7)")->row();
        $data['jml_done']           = $jmldone->jml_done;

        //Resume ticket Baru Admin
        $data['ticket']        = $this->model->approve_ticket()->result();

        //Papan Teknisi
        $data['teknisi']            = $this->model->getTek()->result();
        
        $data['lbl_subkat']         = $this->model->Bar_Ticket()->result();
        $data['lbl_prioritas']        = $this->model->pie_prioritas()->result();
        $data['lbl_perbulan']       = $this->model->line_bulan()->result();
        $data['lbl_status']       = $this->model->pie_status()->result();

        //Dashboard Teknisi
        //Jumlah tiket setiap teknisi
        $tek_assign = $this->db->query("SELECT COUNT(id_ticket) AS jlm_tekassign FROM ticket WHERE teknisi = '$id_user'")->row();
        $data['tekassign'] = $tek_assign->jlm_tekassign;
        //Jumlah tiket yang perlu di approve tiap teknisi
        $tek_approve = $this->db->query("SELECT COUNT(id_ticket) AS jlm_tekapprove FROM ticket WHERE status = 3 AND teknisi = '$id_user'")->row();
        $data['tekapprove'] = $tek_approve->jlm_tekapprove;
        //Jumlah tiket yang dikerjakan tiap teknisi
        $tek_kerja   = $this->db->query("SELECT COUNT(id_ticket) AS jlm_tekkerja FROM ticket WHERE status = 4 AND teknisi = '$id_user'")->row();
        $data['tekkerja'] = $tek_kerja->jlm_tekkerja;
        //Jumlah tiket yang dipending tiap teknisi
        $tek_pending = $this->db->query("SELECT COUNT(id_ticket) AS jlm_tekpending FROM ticket WHERE status = 5 AND teknisi = '$id_user'")->row();
        $data['tekpending'] = $tek_pending->jlm_tekpending;
        //Jumlah tiket yang selesai dikerjakan tiap teknisi
        $tek_selesai = $this->db->query("SELECT COUNT(id_ticket) AS jlm_tekselesai FROM ticket WHERE status IN (6,7) AND teknisi = '$id_user'")->row();
        $data['tekselesai'] = $tek_selesai->jlm_tekselesai;

        //Resume ticket teknisi
        $data['datatickettek']  = $this->model->allassignment($id_user)->result();
        $data['jmltugas']       = $this->model->allassignment($id_user)->num_rows();

        //Dashboard Pegawai
        //Jumlah semua ticket
        $user_ticket = $this->db->query("SELECT COUNT(id_ticket) AS jlm_userticket FROM ticket WHERE reported = '$id_user'")->row();
        $data['userticket'] = $user_ticket->jlm_userticket;
        //Jumlah ticket yang sudah diapprove
        $user_approve = $this->db->query("SELECT COUNT(id_ticket) AS jlm_userapprove FROM ticket WHERE reported = '$id_user' AND status = 1")->row();
        $data['userapprove'] = $user_approve->jlm_userapprove;
        //Jumlah ticket yang di reject
        $user_reject = $this->db->query("SELECT COUNT(id_ticket) AS jlm_userreject FROM ticket WHERE reported = '$id_user' AND status = 0")->row();
        $data['userreject'] = $user_reject->jlm_userreject;
        //Jumlah ticket yang sedang proses
        $user_process = $this->db->query("SELECT COUNT(id_ticket) AS jlm_userprocess FROM ticket WHERE reported = '$id_user' AND status = 4")->row();
        $data['userprocess'] = $user_process->jlm_userprocess;
        //Jumlah ticket yang sedang di pending
        $user_pending = $this->db->query("SELECT COUNT(id_ticket) AS jlm_userpending FROM ticket WHERE reported = '$id_user' AND status = 5")->row();
        $data['userpending'] = $user_pending->jlm_userpending;
        //Jumlah ticket yang selesai
        $user_done = $this->db->query("SELECT COUNT(id_ticket) AS jlm_userdone FROM ticket WHERE reported = '$id_user' AND status = 6")->row();
        $data['userdone'] = $user_done->jlm_userdone;

        //Resume ticket User
        $data['dataticketuser']         = $this->model->myticket($id_user)->result();

        $this->load->view('template', $data);
    }

    public function notifikasi() {
        //Jumlah tiket yang butuh persetujuan Admin
        $jmlnew = $this->db->query("SELECT COUNT(id_ticket) AS jml_new FROM ticket WHERE status IN (1,2)")->row();
        $data['jml_new'] = $jmlnew->jml_new;
        $limit = 5;
        $data['ticket'] = $this->model->new_ticket($limit)->result();
        //var_dump($this->db->last_query());die;
        echo json_encode($data);
    }
}
