<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


class Email extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//Meload model
		$this->load->model('Main_model', 'model');
	}

	public function index()
	{
		//User harus User, tidak boleh role user lain
		//Menyusun template Detail Ticket
		$data['header']   = "header";
		$data['body']     = "email";

		//Detail setiap tiket, get dari model (detail_ticket) berdasarkan id_ticket, data akan ditampung dalam parameter 'detail'
		$data['detail'] = $this->model->detail_ticket($id)->row_array();

		//Tracking setiap tiket, get dari model (tracking_ticket) berdasarkan id_ticket, data akan ditampung dalam parameter 'tracking'
		$data['tracking'] = $this->model->tracking_ticket($id)->result();

		//Load template
		$this->load->view('template', $data);
	}
}
