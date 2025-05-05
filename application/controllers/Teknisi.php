<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/* class Teknisi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Main_model', 'model');
		if (!$this->session->userdata('id_user')) {
			$this->session->set_flashdata('status1', 'expired');
			redirect('login');
		}
	}

	public function index()
	{
		//template
		$data['title'] 	  = "Teknisi";
		$data['navbar']   = "navbar";
		$data['sidebar']  = "sidebar";
		$data['body']     = "teknisi/index";

        //sesi
		$id_dept = $this->session->userdata('id_dept');
		$id_user = $this->session->userdata('id_user');

		//daftar semua teknisi
		$data['teknisi'] = $this->model->getTeknisi()->result();

		//dropdown pegawai
		$data['dd_pegawai'] = $this->model->dropdown_pegawai();
        $data['id_pegawai'] = "";

		$this->load->view('template', $data);
	}

	public function tambah()
	{
		$getkodeteknisi = $this->model->getkodeteknisi();
		$getkodeuser = $this->model->getkodeuser();

		$data = array(
			'id_teknisi' => $getkodeteknisi,
			'nik'        => $this->input->post('id_pegawai')
     	);

     	$datauser = array(
			'id_user' 	=> $getkodeuser,
			'username'  => $this->input->post('id_pegawai'),
			'password'  => md5($this->input->post('password')),
			'level'  	=> "TEKNISI"
     	);

     	$this->db->insert('teknisi', $data);
     	$this->db->insert('user', $datauser);

		$this->session->set_flashdata('status','1');
		redirect('Teknisi');
	}

	public function hapus($id)
	{
		$this->db->where('id_teknisi', $id);
        $this->db->delete('teknisi');

        $this->db->where('id_user', $id);
        $this->db->delete('user');
        
        $this->session->set_flashdata('status_del','1');
        redirect('Teknisi');
	}
} */