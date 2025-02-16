<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
PT. ITSHOP BISNIS DIGITAL
Toko Online: ITSHOP Purwokerto (Tokopedia.com/itshoppwt, Shopee.co.id/itshoppwt, Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
Created: 12-2022
Modified: 06-2023
*/

class Backup extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Meload model
        $this->load->model('Main_model', 'model');
        $this->load->model('BackupData_model', 'backup');
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

    /**
     * Show Backup DB page
     *
     */
    public function index()
    {
        //User harus admin, tidak boleh role user lain
		if($this->session->userdata('level') == "Admin"){
			//Menyusun template List Backup
			$data['title'] 	  = "Backup Database";
			$data['navbar']   = "navbar";
			$data['sidebar']  = "sidebar";
			$data['body']     = "backup/index";

        	//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			//Load template
			$this->load->view('template', $data);
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan admin
			//Akan dibawa ke Controller Errorpage 
			redirect('Errorpage');
		}

    
    }

    public function backup_list()
    {
        $list = $this->backup->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $value) {
            $no++;
            $row = array();
            $row[] = $value->file_name;
            $row[] = '<a href="' . "" . base_url() . $value->file_path . "" . '" title="">' . "" . $value->file_path . "" . '</a>';
            $row[] = $value->created_at;

            //add html for action
            $row[] = '<a class="btn btn-danger btn-circle btn-sm" href="#" title="Hapus" onClick="delete_backup(' . "'" . $value->id_backup . "'" . ')"><i class="fa fa-trash"></i></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->backup->count_all(),
            "recordsFiltered" => $this->backup->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function backup_save()
    {
        $tanggal = date('Ymd-His');
        $namaFile = 'backup-' . $tanggal . '.sql.zip';
        $pathFile = 'files/backup';
        $this->load->dbutil();
        $backup = $this->dbutil->backup();
        // Load the file helper and write the file to your server
        $this->load->helper('file');
        write_file($pathFile . '/' . $namaFile, $backup);

        $input = array(
            'file_name' => $namaFile,
            'file_path' => $pathFile . '/' . $namaFile,
            'created_at' => date('Y-m-d H:i:s')
        );

        $save = $this->model->insert('backup', $input);

        echo json_encode(array("status" => TRUE));
    }

    public function backup_delete($id)
    {
        $query = $this->backup->get_by_id($id);
        unlink($query->file_path);

        $this->backup->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
