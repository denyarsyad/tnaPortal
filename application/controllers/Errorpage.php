<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
PT. ITSHOP BISNIS DIGITAL
Toko Online: ITSHOP Purwokerto (Tokopedia.com/itshoppwt, Shopee.co.id/itshoppwt, Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
Created: 12-2022
Modified: 06-2023
*/

class Errorpage extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//Meload model
		$this->load->model('Main_model', 'model');
		//Jika session tidak ditemukan
		if (!$this->session->userdata('id_user')) {
			$this->session->set_flashdata('status1', 'expired');
			redirect('login');
		}
	}

	public function index()
	{
		//Menyusun template
		$data['title'] 	  = "Error. Page that you requested are forbidden";
		$data['navbar']   = "navbar";
		$data['sidebar']  = "sidebar";
		$data['body']     = "error";

		//Session
		$id_dept = $this->session->userdata('id_dept');
		$id_user = $this->session->userdata('id_user');

		//Load template
		$this->load->view('template', $data);
	}
}
