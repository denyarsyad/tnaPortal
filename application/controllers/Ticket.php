<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


class Ticket extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Meload model
        $this->load->model('Main_model', 'model');
        $this->load->model('TicketData_model', 'ticket');
        //Jika session tidak ditemukan
        if (!$this->session->userdata('id_user')) {
            //Kembali ke halaman Login
            $this->session->set_flashdata('status1', 'expired');
            redirect('login');
        }
    }

    //Bagian List Ticket
    public function index()
    {
        //User harus admin, tidak boleh role user lain
        if ($this->session->userdata('level') == "Admin") {
            //Menyusun template List Ticket
            $data['title']    = "Daftar Semua Tiket";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticket/allticket";

            //Session
            $id_dept = $this->session->userdata('id_dept');
            $id_user = $this->session->userdata('id_user');

            //Daftar semua tiket, get dari model (all_ticket), data akan ditampung dalam parameter 'listticket'
            $data['listticket'] = $this->model->all_ticket()->result();

            //Load template
            $this->load->view('template', $data);
        } else {
            //Bagian ini jika role yang mengakses tidak sama dengan admin
            //Akan dibawa ke Controller Errorpage
            redirect('Errorpage');
        }
    }

    public function ticket_list()
    {
        $list = $this->ticket->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $value) {
            //Status
            if ($value->status == 0) {
                $status = '<strong style="color: #F36F13;">Ticket Rejected</strong>';
            } else if ($value->status == 1) {
                $status = '<strong style="color: #946038;">Ticket Submited</strong>';
            } else if ($value->status == 2) {
                $status = '<strong style="color: #FFB701;">Category Changed</strong>';
            } else if ($value->status == 3) {
                $status = '<strong style="color: #A2B969;">Assigned to Technician</strong>';
            } else if ($value->status == 4) {
                $status = '<strong style="color: #F36F13;">On Process</strong>';
            } else if ($value->status == 5) {
                $status = '<strong style="color: #023047;">Pending</strong>';
            } else if ($value->status == 6) {
                $status = ' <strong style="color: #2E6095;">Solve</strong>';
            } else if ($value->status == 7) {
                $status = '<strong style="color: #C13018;">Late Finished</strong>';
            }

            if ($value->status == 0) {
                $prioritas = '<span style="text-align: center">Rejected</span>';
            } else {
                if ($value->id_prioritas == 0) {
                    $prioritas = '<span style="text-align: center">Not set yet</span>';
                } else {
                    $prioritas  = '<span class="font-weight-bold" style="color: ' . $value->warna . '; text-align: center">' . $value->nama_prioritas . '</span>';
                }
            }

            if ($value->status == 0) {
                $teknisi = "Rejected";
            } else {
                if ($value->teknisi == null) {
                    $teknisi = "Not set yet";
                } else {
                    $teknisi = "$value->nama_teknisi";
                }
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<a href="' . site_url('ticket/detail_ticket/' . $value->id_ticket) . '" class="font-weight-bold" title="Detail Tiket">' . $value->id_ticket . '</a>';
            $row[] = $status;
            $row[] = $prioritas;
            $row[] = $value->tanggal;
            $row[] = $value->deadline;
            $row[] = $value->nama;
            $row[] = $value->nama_kategori . '(' . $value->nama_sub_kategori . ')';
            $row[] = $value->lokasi;
			$row[] = $value->due_date;
            $row[] = $value->problem_summary;
            $row[] = $value->last_update;
            $row[] = $teknisi;

            //add html for action
            $row[] = '<a href="' . site_url('ticket/detail_ticket/' . $value->id_ticket) . '" class="btn btn-primary btn-circle btn-sm" title="Detail">
            <i class="fas fa-search"></i>
            </a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->ticket->count_all(),
            "recordsFiltered" => $this->ticket->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function detail_ticket($id)
    {
        //User harus admin, tidak boleh role user lain
        if ($this->session->userdata('level') == "Admin") {
            //Menyusun template Detail Ticket
            $data['title']    = "Detail Tiket";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticket/detail";

            //Session
            $id_dept = $this->session->userdata('id_dept');
            $id_user = $this->session->userdata('id_user');

            //Detail setiap tiket, get dari model (detail_ticket) berdasarkan id_ticket, data akan ditampung dalam parameter 'detail'
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
            if ($this->session->userdata('level') == "Admin") {
                //Menyusun template Buat ticket
                $data['title']    = "Detail Tiket";
                $data['navbar']   = "navbar";
                $data['sidebar']  = "sidebar";
                $data['body']     = "ticket/detail";

                //Session
                $id_dept     = $this->session->userdata('id_dept');
                $id_user     = $this->session->userdata('id_user');

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
            $id_user     = $this->session->userdata('id_user');

            //Tanggal
            $date       = date("Y-m-d H:i:s");

            //Konfigurasi Upload Gambar
            $config['upload_path']      = './uploads/';        //Folder untuk menyimpan gambar
            $config['allowed_types']    = 'gif|jpg|jpeg|png';    //Tipe file yang diizinkan
            $config['max_size']         = '25600';            //Ukuran maksimum file gambar yang diizinkan
            $config['max_width']        = '0';                //Ukuran lebar maks. 0 menandakan ga ada batas
            $config['max_height']       = '0';                //Ukuran tinggi maks. 0 menandakan ga ada batas

            //Memanggil library upload pada codeigniter dan menyimpan konfirguasi
            $this->load->library('upload', $config);

            if ($_FILES['filefoto']['name'] != "") {
                //Jika upload gambar tidak sesuai dengan konfigurasi di atas, maka upload gambar gagal, dan kembali ke halaman Create ticket
                if (!$this->upload->do_upload('filefoto')) {
                    $this->session->set_flashdata('status', 'Error');
                    redirect('ticket/detail_ticket/' . $id);
                } else {
                    //Bagian ini jika file gambar sesuai dengan konfirgurasi di atas
                    //Menampung file gambar ke variable 'gambar'
                    $gambar = $this->upload->data();

                    //Data message ditampung dalam bentuk array
                    $datamessage = array(
                        'id_ticket'  => $id,
                        'tanggal'    => $date,
                        'status'     => 1,
                        'message'    => htmlspecialchars($this->input->post('message')),
                        'id_user'    => $id_user,
                        'filefoto'   => $gambar['file_name'],
                    );

                    //Query insert data ticket_message yang ditampung ke dalam database. tersimpan ditabel ticket_message
                    $this->db->insert('ticket_message', $datamessage);

                    //Memanggil fungsi kirim email dari user ke admin
                    $this->model->emailmessageticket($id);

                    //Set pemberitahuan bahwa data tiket berhasil dibuat
                    $this->session->set_flashdata('status', 'Success');
                    //Dialihkan ke halaman my ticket
                    redirect('ticket/detail_ticket/' . $id);
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
                    'message'    => htmlspecialchars($this->input->post('message')),
                    'id_user'    => $id_user,
                );

                //Query insert data ticket_message yang ditampung ke dalam database. tersimpan ditabel ticket_message
                $this->db->insert('ticket_message', $datamessage);

                //Memanggil fungsi kirim email dari user ke admin
                $this->model->emailmessageticket($id);

                //Set pemberitahuan bahwa data tiket berhasil dibuat
                $this->session->set_flashdata('status', 'Success');
                //Dialihkan ke halaman my ticket
                redirect('ticket/detail_ticket/' . $id);
            }
        }
    }

    //Bagian Ticket Recieved
    public function list_approve()
    {
        //User harus admin, tidak boleh role user lain
        if ($this->session->userdata('level') == "Admin") {
            //Menyusun template List Approval Ticket
            $data['title']    = "Tiket Baru";
            $data['desc'] = "Tiket Baru yang menunggu persetujuan Admin (Approval oleh Admin)";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticket/listapprove";

            //Session
            $id_dept = $this->session->userdata('id_dept');
            $id_user = $this->session->userdata('id_user');

            //Daftar semua tiket yang dalam approval, get dari model (approve_ticket) dengan parameter id_user, karena hanya id_user dengan level admin yang dapat melihat daftar ini, data akan ditampung dalam parameter 'approve'
            $data['approve'] = $this->model->approve_ticket($id_user)->result();
            //Jumlah tiket yang butuh persetujuan Admin
            $jmlnew = $this->db->query("SELECT COUNT(id_ticket) AS jml_new FROM ticket WHERE status IN (1,2)")->row();
            $data['jml_new']           = $jmlnew->jml_new;

            //Load template
            $this->load->view('template', $data);
        } else {
            //Bagian ini jika role yang mengakses tidak sama dengan admin
            //Akan dibawa ke Controller Errorpage
            redirect('Errorpage');
        }
    }

    public function detail_approve($id)
    {
        //User harus admin, tidak boleh role user lain
        if ($this->session->userdata('level') == "Admin") {
            //Menyusun template Detail Ticket yang belum di-approve
            $data['title']    = "Detail Tiket";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticket/detailapprove";

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

    public function set_prioritas($id)
    {
        if ($this->session->userdata('level') == "Admin") {
            //Menyusun template Detail Ticket yang belum di-approve
            $data['title']    = "Set Prioritas dan Teknisi";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticket/setprioritas";

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

    public function approve($id)
    {
        //Form validasi untuk prioritas dengan nama validasi = id_prioritas
        $this->form_validation->set_rules(
            'id_prioritas',
            'Id_prioritas',
            'required',
            array(
                'required' => '<strong>Failed!</strong> Prioritas Harus dipilih.'
            )
        );

        $this->form_validation->set_rules(
            'id_teknisi',
            'Id_teknisi',
            'required',
            array(
                'required' => '<strong>Failed!</strong> Teknisi Harus dipilih.'
            )
        );

        if ($this->form_validation->run() == FALSE) {
            if ($this->session->userdata('level') == "Admin") {
                //Menyusun template Detail Ticket yang belum di-approve
                $data['title']    = "Set Prioritas dan Teknisi";
                $data['navbar']   = "navbar";
                $data['sidebar']  = "sidebar";
                $data['body']     = "ticket/setprioritas";

                //Session
                $id_dept = $this->session->userdata('id_dept');
                $id_user = $this->session->userdata('id_user');

                $nama   = $this->input->post('nama');
                $email  = $this->input->post('email');

                //Detail setiap tiket yang belum di-approve, get dari model (detail_ticket) dengan parameter id_ticket, data akan ditampung dalam parameter 'detail'
                $data['detail'] = $this->model->detail_ticket($id)->row_array();

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
        } else {
            //User harus admin, tidak boleh role user lain
            if ($this->session->userdata('level') == "Admin") {
                //Proses me-approve ticket, menggunakan model (approve) dengan parameter id_ticket yang akan di-approve
                $this->model->approve($id);
                //Memanggil fungsi kirim email dari admin ke user
                $this->model->emailapprove($id);
                //Memanggil fungsi kirim email dari admin ke teknisi
                $this->model->emailtugas($id);
                //Set pemberitahuan bahwa tiket berhasil ditugaskan ke teknisi
                $this->session->set_flashdata('status', 'Ditugaskan');
                //Kembali ke halaman List approvel ticket (list_approve)
                redirect('ticket/list_approve');
            } else {
                //Bagian ini jika role yang mengakses tidak sama dengan admin
                //Akan dibawa ke Controller Errorpage
                redirect('Errorpage');
            }
        }
    }

    public function detail_reject($id)
    {
        //User harus admin, tidak boleh role user lain
        if ($this->session->userdata('level') == "Admin") {
            //Menyusun template Detail Ticket yang akan di-reject
            $data['title']    = "Tolak Tiket";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticket/detailreject";

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
            //User harus admin, tidak boleh role user lain
            if ($this->session->userdata('level') == "Admin") {
                //Menyusun template Detail Ticket yang akan di-reject
                $data['title']    = "Tolak Tiket";
                $data['navbar']   = "navbar";
                $data['sidebar']  = "sidebar";
                $data['body']     = "ticket/detailreject";

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
            //User harus admin, tidak boleh role user lain
            if ($this->session->userdata('level') == "Admin") {
                //Proses me-reject ticket, menggunakan model (reject) dengan parameter id_ticket yang akan di-reject
                $this->model->reject($id, $alasan);
                //Memanggil fungsi kirim email dari admin ke user
                $this->model->emailreject($id);
                //Set pemberitahuan bahwa ticket berhasil di-reject
                $this->session->set_flashdata('status', 'Ditolak');
                //Kembali ke halaman List approvel ticket (list_approve)
                redirect('ticket/list_approve');
            } else {
                //Bagian ini jika role yang mengakses tidak sama dengan admin
                //Akan dibawa ke Controller Errorpage
                redirect('Errorpage');
            }
        }
    }

    public function pilih_teknisi()
    {
        //User harus admin, tidak boleh role user lain
        if ($this->session->userdata('level') == "Admin") {
            //Menyusun template Assign Ticket (Daftar ticket yang akan ditugaskan ke teknisi)
            $data['title']    = "Pilih Teknisi";
            $data['header']   = "header";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticket/pilihteknisi";

            //Session
            $id_dept = $this->session->userdata('id_dept');
            $id_user = $this->session->userdata('id_user');

            //Daftar semua tiket yang akan ditugaskan ke teknisi, get dari model (pilih_teknisi), data akan ditampung dalam parameter 'pilihteknisi'
            $data['pilihteknisi'] = $this->model->pilih_teknisi()->result();

            //Load template
            $this->load->view('template', $data);
        } else {
            //Bagian ini jika role yang mengakses tidak sama dengan admin
            //Akan dibawa ke Controller Errorpage
            redirect('Errorpage');
        }
    }

    public function detail_pilih_teknisi($id)
    {
        $nama   = $this->input->post('nama');
        $email  = $this->input->post('email');

        //User harus admin, tidak boleh role user lain
        if ($this->session->userdata('level') == "Admin") {
            //Menyusun template Detail Ticket yang akan ditugaskan ke teknisi
            $data['title']    = "Pilih Teknisi";
            $data['navbar']   = "navbar";
            $data['sidebar']  = "sidebar";
            $data['body']     = "ticket/detailpilihteknisi";

            //Session
            $id_dept = $this->session->userdata('id_dept');
            $id_user = $this->session->userdata('id_user');

            //Detail setiap tiket yang akan ditugaskan ke teknisi, get dari model (detail_ticket) dengan parameter id_ticket, data akan ditampung dalam parameter 'detail'
            $data['detail'] = $this->model->detail_ticket($id)->row_array();

            //Tracking setiap tiket, get dari model (tracking_ticket) berdasarkan id_ticket, data akan ditampung dalam parameter 'tracking'
            $data['tracking'] = $this->model->tracking_ticket($id)->result();

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

    public function tugas($id)
    {
        //Form validasi untuk id_user dengan level teknisi dengan nama validasi = id_teknisi
        $this->form_validation->set_rules(
            'id_teknisi',
            'Id_teknisi',
            'required',
            array(
                'required' => '<strong>Failed!</strong> Teknisi Harus dipilih.'
            )
        );

        //Kondisi jika saat proses penugasan tidak memenuhi syarat validasi akan dikembalikan ke halaman detail ticket yang akan ditugaskan
        if ($this->form_validation->run() == FALSE) {
            //User harus admin, tidak boleh role user lain
            if ($this->session->userdata('level') == "Admin") {
                //Menyusun template Detail Ticket yang akan ditugaskan ke teknisi
                $data['title']    = "Pilih Teknisi";
                $data['navbar']   = "navbar";
                $data['sidebar']  = "sidebar";
                $data['body']     = "ticket/detailpilihteknisi";

                //Session
                $id_dept = $this->session->userdata('id_dept');
                $id_user = $this->session->userdata('id_user');

                //Detail setiap tiket yang akan ditugaskan ke teknisi, get dari model (detailticket) dengan parameter id_ticket, data akan ditampung dalam parameter 'detail'
                $data['detail'] = $this->model->detail_ticket($id)->row_array();

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
        } else {
            //Bagian ini jika validasi terpenuhi
            //User harus admin, tidak boleh role user lain
            if ($this->session->userdata('level') == "Admin") {
                //Proses menugaskan ticket ke teknisi, menggunakan model (input_tugas) dengan parameter id_ticket yang akan di-tugaskan
                $this->model->input_tugas($id);

                $this->model->emailtugas($id);
                //Set pemberitahuan bahwa tiket berhasil ditugaskan ke teknisi
                $this->session->set_flashdata('status', 'Ditugaskan');
                //Kembali ke halaman Assign Ticket (indexpilih)
                redirect('ticket/list_approve');
            } else {
                //Bagian ini jika role yang mengakses tidak sama dengan admin
                //Akan dibawa ke Controller Errorpage
                redirect('Errorpage');
            }
        }
    }

    /*
    public function update($id)
    {
        //Session
        $id_dept = $this->session->userdata('id_dept');
        $id_user = $this->session->userdata('id_user');
        //Data
        $kondisi = $this->input->post('id_kondisi');
        $row     = $this->model->getkondisi($kondisi)->row();

        //Form validasi untuk kondisi dengan nama validasi = id_kondisi
        $this->form_validation->set_rules('id_kondisi', 'Id_kondisi', 'required',
            array(
                'required' => '<strong>Failed!</strong> Please Choose the Priority.'
            )
        );

        //Kondisi jika proses buat tiket tidak memenuhi syarat validasi akan dikembalikan ke form buat tiket
        if($this->form_validation->run() == FALSE){
            if($this->session->userdata('level') == "Admin"){
                //Menyusun template Detail Ticket yang belum di-approve
                $data['title']    = "Detail Ticket";
                $data['header']   = "header";
                $data['navbar']   = "navbar";
                $data['sidebar']  = "sidebar";
                $data['body']     = "ticket/edit";

                //Detail setiap tiket yang belum di-approve, get dari model (detail_ticket) dengan parameter id_ticket, data akan ditampung dalam parameter 'detail'
                $data['detail'] = $this->model->detail_ticket($id)->row_array();

                $row = $this->model->detail_ticket($id)->row();
                //Dropdown pilih kondisi, menggunakan model (dropdown_kondisi), nama kondisi ditampung pada 'dd_kondisi', data yang akan di simpan adalah id_kondisi dan akan ditampung pada 'id_kondisi'
                $data['dd_kondisi'] = $this->model->dropdown_kondisi();
                $data['id_kondisi'] = $row->id_kondisi;
                
                //Load template
                $this->load->view('template', $data);
            } else {
                //Bagian ini jika role yang mengakses tidak sama dengan admin
                //Akan dibawa ke Controller Errorpage
                redirect('Errorpage');
            }
        } else {
            if($this->session->userdata('level') == "Admin"){
                $date       = date("Y-m-d  H:i:s");
                $date2      = $this->input->post('waktu_respon');
                $data = array(
                    'id_kondisi' => $kondisi,
                    'deadline'   => date('Y-m-d H:i:s', strtotime($date. ' + '.$date2.' days')),
                    'last_update'=> date("Y-m-d  H:i:s")
                );

                //Melakukan insert data tracking ticket sedang dikerjakan oleh teknisi, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
                $datatracking = array(
                  'id_ticket'  => $id,
                  'tanggal'    => date("Y-m-d  H:i:s"),
                  'status'     => "Priority Changed",
                  'deskripsi'  => "Priority is set to ".$row->nama_kondisi,
                  'id_user'    => $id_user
              );

                $this->db->where('id_ticket', $id);
                $this->db->update('ticket', $data);

                $this->db->insert('tracking', $datatracking);

                //Set pemberitahuan bahwa data pegawai berhasil diupdate
                $this->session->set_flashdata('status', 'Changed');
                //Kembali ke halaman detail ticket
                redirect('ticket/list_approve');
            } else {
                //Bagian ini jika role yang mengakses tidak sama dengan admin
                //Akan dibawa ke Controller Errorpage
                redirect('Errorpage');
            }
        }
    }
    */

    public function reopen($id)
    {
        //User harus admin, tidak boleh role user lain
        if ($this->session->userdata('level') == "Admin") {
            //Proses reopen ticket, menggunakan model (reopen) dengan parameter id_ticket yang akan di-reopen
            $this->model->reopen($id);
            //Set pemberitahuan bahwa ticket berhasil di-reopen
            $this->session->set_flashdata('respon', '1');
            //Kembali ke halaman List approvel ticket (list_approve)
            redirect('ticket/list_approve');
        } else {
            //Bagian ini jika role yang mengakses tidak sama dengan admin
            //Akan dibawa ke Controller Errorpage
            redirect('Errorpage');
        }
    }
}
