<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Statistik extends CI_Controller
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
		//if ($this->session->userdata('level') == "Admin") {
		if (in_array($this->session->userdata('level'), ["Admin", "MGR", "SPVU", "SPVM"])) {
			//Menyusul template dashboard
			$data['title'] 		= "Statistik &amp; Laporan";
			$data['navbar']     = "navbar";
			$data['sidebar']	= "sidebar";
			$data['body'] 		= "statistik/statistik";

			//Session
			$id_dept = $this->session->userdata('id_dept');
			$id_user = $this->session->userdata('id_user');

			$data['stat_tahun'] = $this->model->Stat_Tahun()->result();

			$data['dd_tahun'] = $this->model->pilih_tahun();
			$data['id_tahun'] = "";

			$data['dd_bulan'] = $this->model->pilih_bulan('');
			$data['id_bulan'] = "";

			$this->load->view('template', $data);
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan admin
			//Akan dibawa ke Controller Errorpage 
			redirect('Errorpage');
		}
	}

	public function report()
	{
		if ($this->session->userdata('level') == "Admin") {
			$tgl1 = $this->input->post('tgl1');
			$tgl2 = $this->input->post('tgl2');

			$report = $this->model->report($tgl1, $tgl2)->result();

			$spreadsheet = new Spreadsheet;

			$spreadsheet->getProperties()
				->setCreator("ITS")
				->setLastModifiedBy("ITS")
				->setTitle("Report of ticket")
				->setSubject("Report of ticket")
				->setDescription("Report document of ticket, generated using PHP classes.")
				->setCategory("Report document");

			$sheet = $spreadsheet->getActiveSheet();
			$sheet->setCellValue('A1', 'No');
			$sheet->setCellValue('B1', 'No. Ticket');
			$sheet->setCellValue('C1', 'Nama');
			$sheet->setCellValue('D1', 'Tanggal Submit');
			$sheet->setCellValue('E1', 'Tanggal Deadline');
			$sheet->setCellValue('F1', 'Last Update');
			$sheet->setCellValue('G1', 'Prioritas');
			$sheet->setCellValue('H1', 'Status');
			$sheet->setCellValue('I1', 'Lokasi');
			$sheet->setCellValue('J1', 'Kategori');
			$sheet->setCellValue('K1', 'Sub Kategori');
			$sheet->setCellValue('L1', 'Teknisi');
			$sheet->setCellValue('M1', 'Work Detail');
			$sheet->setCellValue('N1', 'Progress');
			$sheet->setCellValue('O1', 'Tanggal Proses');
			$sheet->setCellValue('P1', 'Solved');

			$nomor = 1;
			$baris = 2;
			$status = "";

			foreach ($report as $key) {
				if ($key->status == 0) {
					$status = "Ticket Rejected";
				} else if ($key->status == 1) {
					$status = "Ticket Submited";
				} else if ($key->status == 2) {
					$status = "Category Changed";
				} else if ($key->status == 3) {
					$status = "Technician selected";
				} else if ($key->status == 4) {
					$status = "On Process";
				} else if ($key->status == 5) {
					$status = "Pending";
				} else if ($key->status == 6) {
					$status = "Solve";
				} else if ($key->status == 7) {
					$status = "Late Finished";
				}
				$sheet->setCellValue('A' . $baris, $nomor);
				$sheet->setCellValue('B' . $baris, $key->id_ticket);
				$sheet->setCellValue('C' . $baris, $key->nama);
				$sheet->setCellValue('D' . $baris, $key->tanggal);
				$sheet->setCellValue('E' . $baris, $key->deadline);
				$sheet->setCellValue('F' . $baris, $key->last_update);
				$sheet->setCellValue('G' . $baris, $key->nama_prioritas);
				$sheet->setCellValue('H' . $baris, $status);
				$sheet->setCellValue('I' . $baris, $key->lokasi);
				$sheet->setCellValue('J' . $baris, $key->nama_kategori);
				$sheet->setCellValue('K' . $baris, $key->nama_sub_kategori);
				$sheet->setCellValue('L' . $baris, $key->nama_teknisi);
				$sheet->setCellValue('M' . $baris, $key->problem_detail);
				$sheet->setCellValue('N' . $baris, $key->progress . '%');
				$sheet->setCellValue('O' . $baris, $key->tanggal_proses);
				$sheet->setCellValue('P' . $baris, $key->tanggal_solved);

				$nomor++;
				$baris++;
			}

			$writer = new Xlsx($spreadsheet);

			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="Report.xlsx"');
			header('Cache-Control: max-age=0');

			$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
			$writer->save('php://output');
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan admin
			//Akan dibawa ke Controller Errorpage 
			redirect('Errorpage');
		}
	}

	public function reportPdf()
	{
		if ($this->session->userdata('level') == "Admin") {
			$tgl1 = $this->input->post('tgl1');
			$tgl2 = $this->input->post('tgl2');

			$data['tgl1'] = $tgl1;
			$data['tgl2'] = $tgl2;
			$data['report'] = $this->model->report($tgl1, $tgl2)->result();
			
			$html =$this->load->view('statistik/report_pdf', $data, true);
			$pdfFilePath = "report-" . time() . "-download.pdf";
			// create new PDF document
			$pdf = new \Mpdf\Mpdf([
				'mode' => 'utf-8',
				'format' => 'A4-L',
				'orientation' => 'L'
			]);
			// Print text using writeHTMLCell()
			$pdf->WriteHTML($html);
			header('Content-Type: application/pdf');
			// Close and output PDF document
			// This method has several options, check the source code documentation for more information.
			$pdf->Output($pdfFilePath, 'I');  // display on the browser
		} else {
			//Bagian ini jika role yang mengakses tidak sama dengan admin
			//Akan dibawa ke Controller Errorpage 
			redirect('Errorpage');
		}
	}
}
