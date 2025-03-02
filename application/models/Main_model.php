<?php
/*
PT. ITSHOP BISNIS DIGITAL
Toko Online: ITSHOP Purwokerto (Tokopedia.com/itshoppwt, Shopee.co.id/itshoppwt, Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
Created: 12-2022
Modified: 06-2023
*/

class Main_model extends CI_Model
{
  function __construct()
  {
    parent::__construct();

    $this->load->library('email');
    $config = array(
      'protocol'  => $this->settings->info['protocol'], // 'mail', 'sendmail', or 'smtp'
      'smtp_host' => $this->settings->info['smtp_host'], // 'mail.domain.com'
      'smtp_port' => $this->settings->info['smtp_port'], // '465', '587'
      'smtp_user' => $this->settings->info['smtp_user'], // 'your@email.com
      'smtp_pass' => $this->settings->info['smtp_pass'], // 'password'
      'mailtype'  => 'html', //plaintext 'text' mails or 'html'
      'starttls'  => true,
      'newline'   => "\r\n",
      'smtp_timeout' => '4', //in seconds
      'charset' => 'iso-8859-1',
      'wordwrap' => TRUE,
    );

    $this->email->initialize($config);
  }


  //Function Global Crud
  function all($table)
  {
    return $this->db->get($table);
  }

  function get($table, $id)
  {
    return $this->db->get_where($table, $id);
  }

  function insert($table, $query = [])
  {
    return $this->db->insert($table, $query);
  }

  function delete($table, $column, $id)
  {
    $this->db->where($column, $id);
    return $this->db->delete($table);
  }

  function update($table, $query, $column, $id)
  {
    $this->db->where($column, $id);
    return $this->db->update($table, $query);
  }

  function count_table($table)
  {
    return $this->db->count_all($table);
  }
  //

  //Bagian Admin

  //Bagian Menu Ticket
  //Method untuk mendapatkan semua ticket
  public function all_ticket()
  {
    //Query untuk mendapatkan semua ticket dengan diurutkan berdasarkan tanggal tiket dibuat
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.tanggal, A.last_update, A.id_prioritas, A.deadline, A.teknisi, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama_dept, G.nama_prioritas, G.warna, G.waktu_respon, H.lokasi, I.nama_jabatan, K.nama AS nama_teknisi FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported
    LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept
    LEFT JOIN departemen F ON F.id_dept = E.id_dept 
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
    LEFT JOIN pegawai K ON K.nik = A.teknisi
    ORDER BY A.tanggal DESC");
    return $query;
  }

  //Method untuk mendapatkan semua ticket yang belum dilakukan approval
  public function approve_ticket()
  {
    //Query untuk mendapatkan semua ticket dengan status 1 (submitted) atau 2 (Belum di approve) dengan diurutkan berdasarkan tanggal ticket dibuat
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama_dept, G.nama_prioritas, G.warna, H.lokasi, I.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori 
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen F ON F.id_dept = E.id_dept
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
    WHERE A.status IN (1,2)
    ORDER BY A.tanggal DESC");
    return $query;
  }

  //Method untuk mendapatkan semua ticket yang belum dilakukan approval by LIMIT
  public function new_ticket($limit)
  {
    //Query untuk mendapatkan semua ticket dengan status 1 (submitted) atau 2 (Belum di approve) dengan diurutkan berdasarkan tanggal ticket dibuat
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama_dept, G.nama_prioritas, G.warna, H.lokasi, I.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori 
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen F ON F.id_dept = E.id_dept
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
    WHERE A.status IN (1,2)
    ORDER BY A.tanggal DESC
    LIMIT $limit");
    return $query;
  }

  //Method yang digunakan untuk proses reject ticket dengan parameter id_ticket
  public function reject($id, $alasan = null)
  {
    //Mengambil session admin
    $id_user    = $this->session->userdata('id_user');

    //Melakukan update data ticket dengan mengubah status ticket menjadi 0, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      'status'     => 0,
      'last_update' => date("Y-m-d  H:i:s")
    );

    //Melakukan insert data tracking ticket bahwa ticket di-reject oleh admin, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "Ticket Rejected",
      'deskripsi'  => $alasan,
      'id_user'    => $id_user
    );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_ticket', $id);
    $this->db->update('ticket', $data);

    //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    $this->db->insert('tracking', $datatracking);
  }

  //Method yang digunakan untuk proses approve ticket dengan parameter (id_ticket)
  public function approve($id)
  {
    $prioritas    = $this->input->post('id_prioritas');
    $sql        = $this->db->query("SELECT tanggal FROM ticket WHERE id_ticket = '$id'")->row();
    $sql2       = $this->db->query("SELECT nama_prioritas FROM prioritas WHERE id_prioritas = '$prioritas'")->row();
    //Data
    $prio       = $sql2->nama_prioritas;
    $date       = $sql->tanggal;
    $date2      = $this->input->post('waktu_respon');
    //Mengambil session admin
    $id_user    = $this->session->userdata('id_user');

    //Melakukan update data ticket dengan mengubah status ticket menjadi 2, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      'id_prioritas' => $prioritas,
      'deadline'   => date('Y-m-d H:i:s', strtotime($date . ' + ' . $date2 . ' days')),
      'status'     => 3,
      'last_update' => date("Y-m-d  H:i:s"),
      'teknisi'    => $this->input->post('id_teknisi')
    );

    //Melakukan insert data tracking ticket bahwa ticket di-approve oleh admin, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "Ticket Received",
      'deskripsi'  => "Priority of the ticket is set to " . $prio . " and assigned to technician.",
      'id_user'    => $id_user
    );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_ticket', $id);
    $this->db->update('ticket', $data);

    //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    $this->db->insert('tracking', $datatracking);
  }

  //Method untuk menaruh data user teknisi sesuai dengan kategori yang dipilih pada dropdown
  function dropdown_teknisi()
  {
    //Query untuk mengambil data user yang memiliki level 'Technician'
    $query = $this->db->query("SELECT A.username, B.nama FROM user A LEFT JOIN pegawai B ON B.nik = A.username WHERE A.level = 'Technician'");

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data user teknisi ke dalam dropdown, value yang akan diambil adalah value id_user yang memiliki level 'Technician'
    foreach ($query->result() as $row) {
      $value[$row->username] = $row->nama;
    }
    return $value;
  }

  //Method yang digunakan untuk proses memilih teknisi untuk ticket dengan parameter (id_ticket)
  public function input_tugas($id)
  {
    //Mengambil session admin
    $id_user    = $this->session->userdata('id_user');

    //Melakukan update data ticket dengan mengubah status ticket menjadi 3 dan memasukkan teknisi yang telah diinput, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      'teknisi'    => $this->input->post('id_teknisi'),
      'status'     => 3,
      'last_update' => date("Y-m-d  H:i:s")
    );

    //Melakukan insert data tracking ticket bahwa ticket sudah ditugaskan kepada teknisi, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "Ticket is assigned to technician",
      'deskripsi'  => "",
      'id_user'    => $id_user
    );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_ticket', $id);
    $this->db->update('ticket', $data);

    //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    $this->db->insert('tracking', $datatracking);
  }

  //Bagian Menu Office
  //Method untuk mengambil semua data departemen
  public function departemen()
  {
    //Query untuk mengambil semua data departemen dan diurutkan berdasarkan nama_dept
    $query = $this->db->query("SELECT * FROM departemen ORDER BY nama_dept");
    return $query;
  }

  //Method untuk mengambil data departemen yang akan diedit dengan parameter id_dept
  public function getdepartemen($id)
  {
    //Query untuk mengambil data departemen berdasarkan id_dept untuk dilakukan edit
    $query = $this->db->query("SELECT * FROM departemen WHERE id_dept = '$id'");
    return $query;
  }

  //Method untuk mengambil semua data sub departemen
  public function subdepartemen()
  {
    //Query untuk mengambil semua data sub departemen dan diurutkan berdasarkan nama_bagian_dept
    $query = $this->db->query("SELECT * FROM departemen_bagian A LEFT JOIN departemen B ON B.id_dept = A.id_dept ORDER BY nama_bagian_dept");
    return $query;
  }

  //Method untuk mengambil semua data jabatan
  public function jabatan()
  {
    //Query untuk mengambil semua data jabatan dan diurutkan berdasarkan nama_jabatan
    $query = $this->db->query("SELECT * FROM jabatan ORDER BY nama_jabatan");
    return $query;
  }

  //Method untuk mengambil data jabatan yang akan diedit dengan parameter id_jabatan
  public function getjabatan($id)
  {
    //Query untuk mengambil data jabtan berdasarkan id_jabatan untuk dilakukan edit
    $query = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan = '$id'");
    return $query;
  }

  //Method untuk mengambil semua data pegawai
  public function pegawai()
  {
    //Query untuk mengambil semua data pegawai dan diurutkan berdasarkan nik
    $query = $this->db->query("SELECT A.nama, A.email, A.telp, A.nik, B.nama_jabatan, C.nama_bagian_dept, D.nama_dept FROM pegawai A 
    LEFT JOIN jabatan B ON B.id_jabatan = A.id_jabatan
    LEFT JOIN departemen_bagian C ON C.id_bagian_dept = A.id_bagian_dept
    LEFT JOIN departemen D ON D.id_dept = C.id_dept ORDER BY A.nik");
    return $query;
  }

  //Method untuk mengambil semua data lokasi
  public function lokasi()
  {
    //Query untuk mengambil semua data lokasi dengan diurutkan berdasarkan lokasi
    $query = $this->db->query("SELECT * FROM lokasi ORDER BY lokasi");
    return $query;
  }

  //Method untuk mengambil data lokasi yang akan diedit dengan parameter id_lokasi
  public function getlokasi($id)
  {
    //Query untuk mengambil data lokasi berdasarkan id_lokasi untuk dilakukan edit
    $query = $this->db->query("SELECT * FROM lokasi WHERE id_lokasi = '$id'");
    return $query;
  }

  //Method untuk menaruh data departemen pada dropdown
  public function dropdown_departemen()
  {
    //Query untuk mengambil data departemen dan diurutkan berdasarkan nama departemen
    $sql = "SELECT * FROM departemen ORDER BY nama_dept";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data departemen ke dalam dropdown, value yang akan diambil adalah value id_dept
    foreach ($query->result() as $row) {
      $value[$row->id_dept] = $row->nama_dept;
    }
    return $value;
  }

  //Method untuk menaruh data jabatan pada dropdown
  public function dropdown_jabatan()
  {
    //Query untuk mengambil data jabatan dan diurutkan berdasarkan nama jabatan
    $sql = "SELECT * FROM jabatan ORDER BY nama_jabatan";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data jabatan ke dalam dropdown, value yang akan diambil adalah value id_jabatan
    foreach ($query->result() as $row) {
      $value[$row->id_jabatan] = $row->nama_jabatan;
    }
    return $value;
  }

  //Method untuk menaruh data sub departemen sesuai dengan departemen yang dipilih pada dropdown
  public function dropdown_bagian_departemen($id_departemen)
  {
    //Query untuk mengambil data sub departemen dan diurutkan berdasarkan nama sub departemen
    $sql = "SELECT * FROM departemen_bagian where id_dept ='$id_departemen' ORDER BY nama_bagian_dept";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data sub departemen ke dalam dropdown, value yang akan diambil adalah value id_bagian_dept
    foreach ($query->result() as $row) {
      $value[$row->id_bagian_dept] = $row->nama_bagian_dept;
    }
    return $value;
  }

  //Bagian Menu Configuration
  //Method untuk mengambil semua data user 
  public function user()
  {
    //Query untuk mengambil semua data user dan diurutkan berdasarkan level user
    $query = $this->db->query("SELECT A.username, A.level, A.id_user, A.password, B.nik, B.nama, B.email, C.nama_bagian_dept, C.id_dept, D.nama_dept FROM user A 
    LEFT JOIN pegawai B ON B.nik = A.username 
    LEFT JOIN departemen_bagian C ON C.id_bagian_dept = B.id_bagian_dept 
    LEFT JOIN departemen D ON D.id_dept = C.id_dept ORDER BY A.level");
    return $query;
  }

  //Method yang digunakan untuk membuat kode user secara otomatis
  public function getkodeuser()
  {
    //Query untuk mengembalikan value terbesar yang ada di kolom id_user
    $query = $this->db->query("SELECT max(id_user) AS max_code FROM user");

    //Menampung fungsi yang akan mengembalikan hasil 1 baris dari query ke dalam variabel $row
    $row = $query->row_array();

    //Menampung hasil kode user terbesar dari query
    $max_id = $row['max_code'];

    //Membuat format kode user dengan dengan memulai kode dari posisi 1 dan panjang kode 4
    $max_fix = (int) substr($max_id, 1, 4);

    //Hasil dari kode terbesar yang sudah didapatkan ditambah dengan 1, hasil dari penjumlahan ini akan digunakan sebagai kode user terbaru
    $max_id_user = $max_fix + 1;

    //Membuat id_user dengan format U + kode user terbaru
    $id_user = "U" . sprintf("%04s", $max_id_user);
    return $id_user;
  }

  //Method untuk menaruh data pegawai pada dropdown
  public function dropdown_pegawai()
  {
    //Query untuk mengambil data pegawai dan diurutkan berdasarkan nama
    $sql = "SELECT A.nama, A.nik FROM pegawai A 
        LEFT JOIN departemen_bagian B ON B.id_bagian_dept = A.id_bagian_dept
        LEFT JOIN departemen C ON C.id_dept = B.id_dept 
        ORDER BY nama";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data pegawai ke dalam dropdown, value yang akan diambil adalah value nik
    foreach ($query->result() as $row) {
      $value[$row->nik] = $row->nama;
    }
    return $value;
  }

  //Method untuk membuat level user
  public function dropdown_level()
  {
    //Menyusun value pada dropdown
    $value[''] = '--Pilih--';
    $value['Admin'] = 'Admin';
    $value['Technician'] = 'Technician';
    $value['User'] = 'User';
    $value['SPV'] = 'Supervisor Dept';

    return $value;
  }

  //Method untuk mengambil semua data prioritas 
  public function prioritas()
  {
    //Query untuk mengambil semua data prioritas dengan diurutkan berdasarkan waktu respon
    $query = $this->db->query("SELECT * FROM prioritas ORDER BY waktu_respon");
    return $query;
  }

  //Method untuk mengambil data prioritas yang akan diedit dengan parameter id_prioritas
  public function getprioritas($id)
  {
    //Query untuk mengambil data prioritas berdasarkan id_prioritas untuk dilakukan edit
    $query = $this->db->query("SELECT * FROM prioritas WHERE id_prioritas = '$id'");
    return $query;
  }

  //Method untuk menaruh data prioritas pada dropdown
  public function dropdown_prioritas()
  {
    //Query untuk mengambil data prioritas dan diurutkan berdasarkan nama prioritas
    $sql = "SELECT * FROM prioritas ORDER BY waktu_respon";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data prioritas ke dalam dropdown, value yang akan diambil adalah value id_prioritas
    foreach ($query->result() as $row) {
      $value[$row->id_prioritas] = $row->nama_prioritas . "  -  (Process Target " . $row->waktu_respon . " " . "Day)";
    }
    return $value;
  }

  //Method untuk mengambil semua data kategori
  public function kategori()
  {
    //Query untuk mengambil semua data kategori dengan diurutkan berdasarkan nama kategori
    $query = $this->db->query("SELECT * FROM kategori ORDER BY nama_kategori");
    return $query;
  }

  //Method untuk mengambil data kategori yang akan diedit dengan parameter id_kategori
  public function getkategori($id)
  {
    //Query untuk mengambil data kategori berdasarkan id_kategori untuk dilakukan edit
    $query = $this->db->query("SELECT * FROM kategori WHERE id_kategori = '$id'");
    return $query;
  }

  //Method untuk mengambil semua data sub kategori
  public function subkategori()
  {
    //Query untuk mengambil semua data sub kategori yang di-join dengan tabel kategori berdasarkan id_kategori dan diurutkan berdasarkan nama_kategori
    $query = $this->db->query("SELECT * FROM kategori_sub A LEFT JOIN kategori B ON B.id_kategori = A.id_kategori ORDER BY B.nama_kategori");
    return $query;
  }

  //Method untuk mengambil semua data informasi
  public function informasi()
  {
    //Query untuk mengambil semua data informasi yang diuurutkan berdasarkan tanggal
    $query = $this->db->query("SELECT A.tanggal, A.subject, A.pesan, A.id_informasi, C.nama FROM informasi A 
    LEFT JOIN pegawai C ON C.nik =  A.id_user
    ORDER BY A.tanggal DESC");
    return $query;
  }

  //Method untuk mengambil data informasi yang akan diedit dengan parameter id_informasi
  public function getinformasi($id)
  {
    //Query untuk mengambil data informasi berdasarkan id_informasi untuk dilakukan edit
    $query = $this->db->query("SELECT * FROM informasi WHERE id_informasi = '$id'");
    return $query;
  }

  //Method untuk mengambil semua data settings
  public function setting()
  {
    //Query untuk mengambil semua data settings dengan diurutkan berdasarkan settings
    $query = $this->db->query("SELECT * FROM settings ORDER BY id");
    return $query;
  }

  //Method untuk mengambil data setting yang akan diedit dengan parameter id
  public function getsetting($id)
  {
    //Query untuk mengambil data setting berdasarkan id untuk dilakukan edit
    $query = $this->db->query("SELECT * FROM settings WHERE id = '$id'");
    return $query;
  }
  //Selesai Bagian Admin


  //Bagian Teknisi

  //Method untuk mendapatkan semua ticket yang ditugaskan kepada teknisi dan belum dilakukan approval oleh teknisi
  public function approve_tugas($id)
  {
    //Query untuk mendapatkan semua ticket dengan status 3 (Technician selected) atau 5 (Pending) dengan diurutkan berdasarkan tanggal ticket dibuat
    $query = $this->db->query("SELECT A.id_ticket, A.progress, A.status, A.reported, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, G.nama_prioritas, G.warna, H.lokasi, J.nama_dept FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian I ON I.id_bagian_dept = D.id_bagian_dept
    LEFT JOIN departemen J ON J.id_dept = I.id_dept
    WHERE F.nik = '$id' AND A.status IN (3,5) ORDER BY A.deadline ASC");
    return $query;
  }

  //Method untuk mendapatkan semua ticket yang ditugaskan kepada teknisi dan sudah dilakukan approval oleh teknisi
  public function daftar_tugas($id)
  {
    //Query untuk mendapatkan semua ticket dengan status 4 (On Process) atau 6 (Solve) dengan diurutkan berdasarkan tanggal tiket dibuat
    $query = $this->db->query("SELECT A.id_ticket, A.progress, A.status, A.reported, A.tanggal, A.tanggal_solved, A.id_prioritas, A.deadline, A.problem_detail, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, G.nama_prioritas, G.warna, H.lokasi, J.nama_dept, K.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian I ON I.id_bagian_dept = D.id_bagian_dept
    LEFT JOIN departemen J ON J.id_dept = I.id_dept
    LEFT JOIN jabatan K ON K.id_jabatan = D.nik
    WHERE F.nik = '$id' AND A.status IN (4,6,7) ORDER BY G.waktu_respon ASC");
    return $query;
  }

  //Method yang digunakan untuk melakukan approval ticket oleh teknisi
  public function approve_tiket($id)
  {
    //Mengambil session teknisi
    $id_user = $this->session->userdata('id_user');

    //Melakukan update data ticket dengan mengubah status ticket menjadi 4 dan memasukkan tanggal tiket mulai diproses, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      'status'         => 4,
      'tanggal_proses' => date("Y-m-d  H:i:s"),
      'last_update'    => date("Y-m-d  H:i:s")
    );

    //Melakukan insert data tracking ticket sedang dikerjakan oleh teknisi, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "On Process",
      'deskripsi'  => "",
      'id_user'    => $id_user
    );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_ticket', $id);
    $this->db->update('ticket', $data);

    //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    $this->db->insert('tracking', $datatracking);
  }

  //Method yang digunakan untuk melakukan pending ticket oleh teknisi
  public function pending_tugas($id)
  {
    //Mengambil session teknisi
    $id_user = $this->session->userdata('id_user');

    //Melakukan update data ticket dengan mengubah status ticket menjadi 5, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      'status'     => 5,
      'last_update' => date("Y-m-d  H:i:s")
    );

    //Melakukan insert data tracking ticket di-pending oleh teknisi, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "Pending",
      'deskripsi'  => "",
      'id_user'    => $id_user
    );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_ticket', $id);
    $this->db->update('ticket', $data);

    //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    $this->db->insert('tracking', $datatracking);
  }

  //Method yang digunakan untuk melakukan update progress ticket oleh teknisi
  public function update_progress($id)
  {
    //Mengambil session teknisi
    $id_user  = $this->session->userdata('id_user');

    //Mengambil data progress dan deskripsi untuk update system tracking ticket
    $progress = $this->input->post('progress');
    $date     = date("Y-m-d  H:i:s");
    $sql      = $this->db->query("SELECT deadline FROM ticket WHERE id_ticket='$id'")->row();

    //Konfigurasi Upload Gambar
    $config['upload_path']    = './files/teknisi/';   //Folder untuk menyimpan gambar
    $config['allowed_types']  = 'gif|jpg|jpeg|png|pdf'; //Tipe file yang diizinkan
    $config['max_size']       = '25600';     //Ukuran maksimum file gambar yang diizinkan
    $config['max_width']      = '0';        //Ukuran lebar maks. 0 menandakan ga ada batas
    $config['max_height']     = '0';        //Ukuran tinggi maks. 0 menandakan ga ada batas

    //Memanggil library upload pada codeigniter dan menyimpan konfirguasi
    $this->load->library('upload', $config);

    //Jika upload gambar tidak sesuai dengan konfigurasi di atas, maka upload gambar gagal, dan kembali ke halaman Create ticket
    if (!$this->upload->do_upload('fileupdate')) {
      $this->session->set_flashdata('status', 'Something went wrong! File lampiran lebih dari 25MB atau format tidak didukung.');
      redirect('ticket_teknisi/detail_update/' . $id);
    } else {
      //Bagian ini jika file gambar sesuai dengan konfirgurasi di atas
      //Menampung file gambar ke variable 'gambar'
      $gambar   = $this->upload->data();

      //Signature pad
      $folderPath = './files/teknisi/signature/';
      $image_parts = explode(";base64,", $this->input->post('signed'));
      $image_type_aux = explode("image/", $image_parts[0]);
      $image_type = $image_type_aux[1];
      $image_base64 = base64_decode($image_parts[1]);
      $fileName = uniqid() . '.' . $image_type;
      $file = $folderPath . $fileName;
      file_put_contents($file, $image_base64);

      //prioritas jika progress yang sudah selesai, maka status ticket pada system tracking ticket menjadi ticket closed dengan keterangan progress ticketnya juga
      if ($progress == 100) {
        if (date("Y-m-d  H:i:s") > $sql->deadline) {
          //Melakukan update data ticket dengan mengubah status ticket menjadi 6, memasukkan tanggal proses selesai, dan memasukkan progress dari ticket, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
          $data = array(
            'status'         => 7,
            'last_update'    => $date,
            'tanggal_solved' => $date,
            'progress'       => $progress
          );

          //Melakukan insert data tracking ticket closed oleh teknisi, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
          $datatracking = array(
            'id_ticket'  => $id,
            'tanggal'    => $date,
            'status'     => "Ticket Closed. Progress: " . $progress . " %",
            'deskripsi'  => ucfirst($this->input->post('desk')),
            'id_user'    => $id_user,
            'filefoto'   => $gambar['file_name'],
            'signature'  => $fileName
          );
        } else {
          //Melakukan update data ticket dengan mengubah status ticket menjadi 6, memasukkan tanggal proses selesai, dan memasukkan progress dari ticket, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
          $data = array(
            'status'         => 6,
            'last_update'    => $date,
            'tanggal_solved' => $date,
            'progress'       => $progress
          );

          //Melakukan insert data tracking ticket closed oleh teknisi, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
          $datatracking = array(
            'id_ticket'  => $id,
            'tanggal'    => $date,
            'status'     => "Ticket Closed. Progress: " . $progress . " %",
            'deskripsi'  => ucfirst($this->input->post('desk')),
            'id_user'    => $id_user,
            'filefoto'   => $gambar['file_name'],
            'signature'  => $fileName
          );
        }
      } else {
        //Bagian ini jika prioritasnya progress ticket belum selesai dikerjakan, maka data yang diupdate hanya status dan progress
        //Melakukan update data ticket dengan mengubah status ticket menjadi 4, dan memasukkan progress dari ticket, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
        $data = array(
          'status'       => 4,
          'last_update'  => date("Y-m-d  H:i:s"),
          'progress'     => $progress
        );

        //Melakukan insert data tracking ticket progress oleh teknisi, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
        $datatracking = array(
          'id_ticket'  => $id,
          'tanggal'    => date("Y-m-d  H:i:s"),
          'status'     => "Progress: " . $progress . " %",
          'deskripsi'  => ucfirst($this->input->post('desk')),
          'id_user'    => $id_user,
          'filefoto'   => $gambar['file_name'],
          'signature'  => $fileName
        );
      }
      //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
      $this->db->where('id_ticket', $id);
      $this->db->update('ticket', $data);

      //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
      $this->db->insert('tracking', $datatracking);
    }
  }

  public function changekategori($id)
  {
    $kat      = $this->input->post('id_kategori');
    $subkat   = $this->input->post('id_sub_kategori');
    $row      = $this->db->query("SELECT * FROM kategori WHERE id_kategori = '$kat'")->row();
    $key      = $this->db->query("SELECT * FROM kategori_sub WHERE id_sub_kategori = '$subkat'")->row();
    $sql      = $this->db->query("SELECT id_sub_kategori FROM ticket WHERE id_ticket = '$id'")->row();
    $id_user  = $this->session->userdata('id_user');

    if ($subkat == $sql->id_sub_kategori) {
      $this->session->set_flashdata('status1', 'Sub Kategori tidak diubah atau masih sama!');
      redirect('ticket_teknisi/change/' . $id);
    } else {
      //Konfigurasi Upload Gambar
      $config['upload_path']    = './files/teknisi/';   //Folder untuk menyimpan gambar
      $config['allowed_types']  = 'gif|jpg|jpeg|png|pdf'; //Tipe file yang diizinkan
      $config['max_size']       = '25600';     //Ukuran maksimum file gambar yang diizinkan
      $config['max_width']      = '0';        //Ukuran lebar maks. 0 menandakan ga ada batas
      $config['max_height']     = '0';        //Ukuran tinggi maks. 0 menandakan ga ada batas

      //Memanggil library upload pada codeigniter dan menyimpan konfirguasi
      $this->load->library('upload', $config);
      //Jika upload gambar tidak sesuai dengan konfigurasi di atas, maka upload gambar gagal, dan kembali ke halaman Create ticket
      if (!$this->upload->do_upload('filediagnosa')) {
        $this->session->set_flashdata('status', 'Something went wrong! File lampiran lebih dari 25MB atau format tidak didukung.');
        redirect('ticket_teknisi/change/' . $id);
      } else {
        $gambar = $this->upload->data();
        $data = array(
          'id_sub_kategori'   => $subkat,
          'last_update'       => date("Y-m-d  H:i:s"),
          'status'            => 2,
          'teknisi'           => NULL,
          'problem_detail'    => ucfirst($this->input->post('diagnos'))
        );

        $datatracking = array(
          'id_ticket'  => $id,
          'tanggal'    => date("Y-m-d  H:i:s"),
          'status'     => "Kategori diubah menjadi " . $row->nama_kategori . "(" . $key->nama_sub_kategori . ")",
          'deskripsi'  => ucfirst($this->input->post('diagnos')),
          'id_user'    => $id_user,
          'filefoto'   => $gambar['file_name']
        );
        $this->db->where('id_ticket', $id);
        $this->db->update('ticket', $data);

        $this->db->insert('tracking', $datatracking);
      }
    }
  }
  //Selesai Bagian Teknisi

  //
  //Bagian User

  //Method yang digunakan untuk membuat kode ticket secara otomatis
  public function getkodeticket()
  {
    //Query untuk mengembalikan value terbesar yang ada di kolom id_ticket
    $query = $this->db->query("SELECT max(id_ticket) AS max_code FROM ticket");

    //Menampung fungsi yang akan mengembalikan hasil 1 baris dari query ke dalam variabel $row
    $row = $query->row_array();

    //Menampung hasil kode ticket terbesar dari query
    $max_id = $row['max_code'];
    //Mengambil kode ticket pada database posisi 9 dan panjang kode 4
    $max_fix = (int) substr($max_id, 9, 4);

    //Hasil dari kode terbesar yang sudah didapatkan ditambah dengan 1, hasil dari penjumlahan ini akan digunakan sebagai kode ticket terbaru
    $max_ticket = $max_fix + 1;

    //Mengambil tanggal sekarang
    $tanggal = date("d");
    //Mengambil bulan sekarang
    $bulan = date("m");
    //Mengambil tahun sekarang
    $tahun = date("Y");

    //Membuat id_ticket dengan format T + tahun + bulan + tanggal + kode user terbaru (%04s merupakan fungsi untuk menentukan lebar minimum yang dimiliki nilai variable serta mengubah int menjadi string, %04s menandakan lebar minimum dari tiket yaitu 4 dengan padding berupa angka 0)
    $ticket = "T" . $tahun . $bulan . $tanggal . sprintf("%04s", $max_ticket);
    return $ticket;
  }

  //Membuat id_ticket dengan format Random
  public function getkodeticketnew()
  {
    $this->load->helper('string');
    $ticket = random_string('alnum', 9);
    return $ticket;
  }

  //Method untuk mengambil semua ticket yang dimiliki user dengan parameter id_user
  public function myticket($id)
  {
    //Query untuk mendapatkan semua ticket yang dimiliki user dengan diurutkan berdasarkan tanggal
    $query = $this->db->query("SELECT A.id_ticket, A.progress, A.status, A.reported, A.tanggal, A.id_prioritas, A.deadline, A.last_update, A.problem_detail, A.problem_summary, A.filefoto, B.nama_sub_kategori, A.teknisi, C.nama_kategori, D.nama, D.email, D.telp, G.nama_prioritas, G.warna, H.lokasi, J.nama_dept, K.nama AS nama_teknisi FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported
    LEFT JOIN user E ON E.id_user = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian I ON I.id_bagian_dept = D.id_bagian_dept
    LEFT JOIN departemen J ON J.id_dept = I.id_dept
    LEFT JOIN pegawai K ON K.nik = A.teknisi
    WHERE A.reported = '$id' ORDER BY A.tanggal DESC");
    return $query;
  }

  //Method untuk mengambil data detail dari setiap ticket dengan parameter id_ticket
  public function detail_ticket($id)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.id_prioritas, A.deadline, A.problem_summary, A.problem_detail, A.filefoto, A.id_prioritas, A.id_sub_kategori, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas, J.warna, J.waktu_respon, K.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = A.teknisi
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    LEFT JOIN jabatan K ON K.id_jabatan = D.id_jabatan
    WHERE A.id_ticket = '$id'");
    return $query;
  }

  //Method untuk mengambil data tracking dari setiap ticket dengan parameter id_ticket
  public function tracking_ticket($id)
  {
    //Query untuk mendapatkan data tracking dari setiap ticket
    $query = $this->db->query("SELECT A.tanggal, A.status, A.deskripsi, A.filefoto, A.signature, B.nama FROM tracking A 
    LEFT JOIN pegawai B ON B.nik = A.id_user
    WHERE A.id_ticket ='$id'
    ORDER BY A.tanggal DESC");
    return $query;
  }

  //Method untuk mengambil data tracking dari setiap ticket_message dengan parameter id_ticket
  public function message_ticket($id)
  {
    //Query untuk mendapatkan data tracking dari setiap ticket
    $query = $this->db->query("SELECT A.tanggal, A.status, A.message, A.filefoto, B.nama, C.level FROM ticket_message A 
    LEFT JOIN pegawai B ON B.nik = A.id_user
    LEFT JOIN user C ON C.username = A.id_user
    WHERE A.id_ticket ='$id'
    ORDER BY A.tanggal DESC");
    return $query;
  }

  //Method untuk mengambil profile dari setiap user
  public function profile($id)
  {
    //Query untuk mengambil data profile dari setiap user
    $query = $this->db->query("SELECT A.nik, A.nama, A.email, A.telp, A.id_jabatan, A.id_bagian_dept, B.level, C.nama_jabatan, D.id_dept, D.nama_bagian_dept, E.nama_dept FROM pegawai A 
    LEFT JOIN user B ON B.username = A.nik 
    LEFT JOIN jabatan C ON C.id_jabatan = A.id_jabatan 
    LEFT JOIN departemen_bagian D ON D.id_bagian_dept = A.id_bagian_dept 
    LEFT JOIN departemen E ON E.id_dept = D.id_dept WHERE A.nik ='$id'");
    return $query;
  }

  //Method untuk menaruh data kategori pada dropdown
  public function dropdown_kategori()
  {
    //Query untuk mengambil data kategori dan diurutkan berdasarkan nama kategori
    $sql = "SELECT * FROM kategori ORDER BY nama_kategori";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data kategori ke dalam dropdown, value yang akan diambil adalah value id_kategori
    foreach ($query->result() as $row) {
      $value[$row->id_kategori] = $row->nama_kategori;
    }
    return $value;
  }

  //Method untuk menaruh data lokasi pada dropdown
  public function dropdown_lokasi()
  {
    //Query untuk mengambil data lokasi dan diurutkan berdasarkan nama lokasi
    $sql = "SELECT * FROM lokasi ORDER BY lokasi";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data lokasi ke dalam dropdown, value yang akan diambil adalah value id_lokasi
    foreach ($query->result() as $row) {
      $value[$row->id_lokasi] = $row->lokasi;
    }
    return $value;
  }

  //Method untuk menaruh data sub ketegori sesuai dengan kategori yang dipilih pada dropdown
  public function dropdown_sub_kategori($id_kategori)
  {
    //Query untuk mengambil data sub kategori dan diurutkan berdasarkan nama sub kategori
    $sql = "SELECT * FROM kategori_sub where id_kategori ='$id_kategori' ORDER BY nama_sub_kategori";
    $query = $this->db->query($sql);

    //Value default pada dropdown
    $value[''] = '-- Pilih --';
    //Menaruh data sub kategori ke dalam dropdown, value yang akan diambil adalah value id_sub_kategori
    foreach ($query->result() as $row) {
      $value[$row->id_sub_kategori] = $row->nama_sub_kategori;
    }
    return $value;
  }
  //Selesai Bagian User


  //Bagian Dashboard

  //Method untuk mengambil data semua ticket
  public function getTicket()
  {
    //Query untuk mengambil data semua ticket
    return $this->db->get('ticket');
  }

  //Method untuk mengambil data teknisi dan jumlah tugasnya
  public function getTek()
  {
    $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
    $query = $this->db->query("SELECT A.id_user, B.nama, SUM(C.status NOT IN (1,2,6,7)) as total FROM user A 
    LEFT JOIN pegawai B ON B.nik = A.username 
    LEFT JOIN ticket C ON C.teknisi = B.nik 
    WHERE A.level = 'technician' GROUP BY B.nama ");
    return $query;
  }

  public function allassignment($id)
  {
    $query = $this->db->query("SELECT A.id_ticket, A.progress, A.status, A.reported, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, G.nama_prioritas, G.warna, H.lokasi, J.nama_dept FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian I ON I.id_bagian_dept = D.id_bagian_dept
    LEFT JOIN departemen J ON J.id_dept = I.id_dept
    WHERE A.teknisi = '$id' AND A.status IN (3,4,5) ORDER BY A.tanggal DESC");
    return $query;
  }

  //Method untuk mengambil data semua ticket berdasarkan statusnya
  public function getStatusTicket($status)
  {
    //Query untuk mengambil data semua ticket berdasarkan status
    $this->db->where('status', $status);
    return $this->db->get('ticket');
  }

  //Method untuk mengambil data semua user dengan level 'Technician'
  public function getTeknisi()
  {
    //Query untuk mengambil data semua user dengan level 'Technician'
    $this->db->where('level', 'Technician');
    return $this->db->get('user');
  }

  //Method untuk mengambil data semua user dengan level 'User'
  public function getUser()
  {
    //Query untuk mengambil data semua user dengan level 'User'
    $this->db->where('level', 'User');
    return $this->db->get('user');
  }

  public function Bar_Ticket()
  {
    $query = $this->db->query("SELECT B.nama_sub_kategori, COUNT(*) AS total FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    WHERE YEAR(A.tanggal)=YEAR(NOW()) AND A.status NOT IN (0)
    GROUP BY A.id_sub_kategori");
    return $query;
  }

  public function pie_prioritas()
  {
    $query = $this->db->query("SELECT B.nama_prioritas, B.warna, A.id_prioritas, COUNT(*) AS jumprioritas FROM ticket A 
    LEFT JOIN prioritas B ON B.id_prioritas = A.id_prioritas 
    WHERE YEAR(A.tanggal)=YEAR(NOW()) AND A.status NOT IN (0)
    GROUP BY A.id_prioritas ORDER BY A.id_prioritas ASC");
    return $query;
  }

  public function line_bulan()
  {
    $query = $this->db->query("SELECT MONTHNAME(tanggal) AS bulan, COUNT(*) AS jumbulan FROM ticket 
    WHERE YEAR(tanggal)=YEAR(NOW())
    GROUP BY MONTHNAME(tanggal) 
    ORDER BY MONTH(tanggal) ASC");

    return $query;
  }

  public function pie_status()
  {
    $query = $this->db->query("SELECT status, COUNT(*) AS jumstat FROM ticket 
    WHERE YEAR(tanggal)=YEAR(NOW()) 
    GROUP BY status ORDER BY status ASC");
    return $query;
  }
  //Selesai Bagian Dashboard


  //Bagian Statistik
  public function Stat_Tahun()
  {
    $query = $this->db->query("SELECT YEAR(tanggal) AS tahun, COUNT(*) AS jumtahun FROM ticket 
    GROUP BY YEAR(tanggal)");
    return $query;
  }

  public function pilih_tahun()
  {
    $query = $this->db->query("SELECT YEAR(tanggal) AS tahun FROM ticket ORDER BY YEAR(tanggal) ASC ");

    $value[''] = '-- Pilih Tahun --';
    foreach ($query->result() as $row) {
      $value[$row->tahun] = $row->tahun;
    }
    return $value;
  }

  public function pilih_bulan($id_tahun)
  {
    $query = $this->db->query("SELECT DATE_FORMAT(tanggal, '%Y/ %M') AS bulan FROM ticket WHERE DATE_FORMAT(tanggal, '%Y') = '$id_tahun'  ORDER BY MONTH(tanggal) ASC ");

    $value[''] = '-- Pilih Bulan --';
    foreach ($query->result() as $row) {
      $value[$row->bulan] = $row->bulan;
    }
    return $value;
  }

  public function report($tgl1, $tgl2)
  {
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.last_update, A.tanggal_proses, A.tanggal_solved, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, A.id_prioritas, A.deadline, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE DATE(A.tanggal) BETWEEN '$tgl1' AND '$tgl2'");
    return $query;
  }

  //Bagian Notifikasi Email
  public function emailbuatticket($id)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.id_prioritas, A.deadline, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>New Ticket (" . $query->id_ticket . ") Has Been Submited</h1>";
    $isiEmail .= "<div>Ticket with Number " . $query->id_ticket . " has been submited by " . $query->nama . "</div>";
    $isiEmail .= "<div>Please response and set the priority of the ticket in <b>Helpdesk Web Application</b></div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Ticket</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>Submited</td>
                            </tr>
                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
    $to = $this->settings->info['email'];

    $this->email->set_newline("\r\n");
    $this->email->from($from, $query->nama);
    $this->email->to($to);
    $this->email->subject('New Ticket (' . $query->id_ticket . ') Has Been Submited');
    $this->email->attach('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);

    if (!$this->email->send()) {
      //show_error($this->email->print_debugger());
      //Set pemberitahuan bahwa data tiket berhasil dibuat
      $this->session->set_flashdata('status', 'Dikirim');
      //Dialihkan ke halaman my ticket
      redirect('ticket_user');
    } else {
      echo 'Success to send email';
    }
  }

  public function emailapprove($id)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>Your Ticket (" . $query->id_ticket . ") Has Been Received</h1>";
    $isiEmail .= "<div>Dear " . $query->nama . "</div>";
    $isiEmail .= "<div>Your ticket will be processed according to predetermined priorities. You can track your ticket in <b>Helpdesk Web Application</b></div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Ticket</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Priority</td>
                              <td>:</td>
                              <td>' . $query->nama_prioritas . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>Received</td>
                            </tr>
                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
    $name = $this->settings->info['perusahaan'];
    $to = $query->email;
    $this->email->set_newline("\r\n");
    $this->email->from($from, $name);
    $this->email->to($to);
    $this->email->subject('Your Ticket (' . $query->id_ticket . ') Has Been Received');
    $this->email->attach('uploads/' . $query->filefoto);
    $cid = $this->email->attachment_cid('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);
    if (!$this->email->send()) {
      //Set pemberitahuan bahwa tiket berhasil ditugaskan ke teknisi
      $this->session->set_flashdata('status', 'Ditugaskan');
      //Kembali ke halaman List approvel ticket (list_approve)
      redirect('ticket/list_approve');
    } else {
      echo 'Success to send email';
    }
  }

  public function emailreject($id)
  {
    $message  = $this->input->post('message');
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>Sorry, Your Ticket (" . $query->id_ticket . ") Has Been Rejected</h1>";
    $isiEmail .= "<div>Dear " . $query->nama . "</div>";
    $isiEmail .= "<div>" . $message . "</div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Ticket</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Priority</td>
                              <td>:</td>
                              <td>' . $query->nama_prioritas . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>Rejected</td>
                            </tr>
                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
    $name = $this->settings->info['perusahaan'];
    $to = $query->email;
    $this->email->set_newline("\r\n");
    $this->email->from($from, $name);
    $this->email->to($to);
    $this->email->subject('Your Ticket (' . $query->id_ticket . ') Has Been Rejected');
    $this->email->attach('uploads/' . $query->filefoto);
    $cid = $this->email->attachment_cid('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);
    if (!$this->email->send()) {
      //Set pemberitahuan bahwa ticket berhasil di-reject
      $this->session->set_flashdata('status', 'Ditolak');
      //Kembali ke halaman List approvel ticket (list_approve)
      redirect('ticket/list_approve');
    } else {
      echo 'Success to send email';
    }
  }

  public function emailtugas($id)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>You Are Assigned To The Ticket (" . $query->id_ticket . ")</h1>";
    $isiEmail .= "<div>Dear " . $query->nama_teknisi . "</div>";
    $isiEmail .= "<div>Please check your <code>Ticket Assigned</code> menu on <b>ITS Web Application</b></div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Ticket</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Priority</td>
                              <td>:</td>
                              <td>' . $query->nama_prioritas . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>Assigned to you</td>
                            </tr>
                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
    $name = $this->settings->info['perusahaan'];
    $to = $this->input->post('email');
    $this->email->set_newline("\r\n");
    $this->email->from($from, $name);
    $this->email->to($to);
    $this->email->subject('Your Are Assigned To The Ticket (' . $query->id_ticket . ')');
    $this->email->attach('uploads/' . $query->filefoto);
    $cid = $this->email->attachment_cid('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);
    if (!$this->email->send()) {
      //Set pemberitahuan bahwa tiket berhasil ditugaskan ke teknisi
      $this->session->set_flashdata('status', 'Ditugaskan');
      //Kembali ke halaman List approvel ticket (list_approve)
      redirect('ticket/list_approve');
    } else {
      echo 'Success to send email';
    }
  }

  public function emaildiproses($id)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>Your Ticket (" . $query->id_ticket . ") being processed</h1>";
    $isiEmail .= "<div>Dear " . $query->nama . "</div>";
    $isiEmail .= "<div>You can track your ticket in <b>Helpdesk Web Application</b></div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Ticket</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Priority</td>
                              <td>:</td>
                              <td>' . $query->nama_prioritas . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>processed by ' . $query->nama_teknisi . '</td>
                            </tr>
                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
    $name = $this->settings->info['perusahaan'];
    $to = $query->email;
    $this->email->set_newline("\r\n");
    $this->email->from($from, $name);
    $this->email->to($to);
    $this->email->subject('Your Ticket (' . $query->id_ticket . ') being processed by technician');
    $this->email->attach('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);
    if (!$this->email->send()) {
      //Set pemberitahuan bahwa ticket berhasil di-approve
      $this->session->set_flashdata('status', 'Process');
      //Kembali ke halaman List approval ticket (Ticket Assigned)
      redirect('ticket_teknisi/index_approve');
    } else {
      echo 'Success to send email';
    }
  }

  public function emaildipending($id)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>Your Ticket (" . $query->id_ticket . ") is pending</h1>";
    $isiEmail .= "<div>Dear " . $query->nama . "</div>";
    $isiEmail .= "<div>Your ticket will be handled soon</div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Ticket</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Priority</td>
                              <td>:</td>
                              <td>' . $query->nama_prioritas . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>Pending by ' . $query->nama_teknisi . '</td>
                            </tr>
                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
    $name = $this->settings->info['perusahaan'];
    $to = $query->email;
    $this->email->set_newline("\r\n");
    $this->email->from($from, $name);
    $this->email->to($to);
    $this->email->subject('Your Ticket (' . $query->id_ticket . ') is pending by technician');
    $this->email->attach('uploads/' . $query->filefoto);
    $cid = $this->email->attachment_cid('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);
    if (!$this->email->send()) {
      //Set pemberitahuan bahwa ticket berhasil di-pending
      $this->session->set_flashdata('status', 'Hold');
      //Kembali ke halaman List approval ticket (Ticket Assigned)
      redirect('ticket_teknisi/index_approve');
    } else {
      echo 'Success to send email';
    }
  }

  public function emailselesai($id)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();
    if ($query->progress > 0 || $query->progress < 100) {
      $isiEmail  = "<h1>Your Ticket (" . $query->id_ticket . ") is On Process</h1>";
      $isiEmail  .= "<div>Dear " . $query->nama . "</div>";
      $isiEmail .= "<div>Your ticket is On Process by Technician. You can track your ticket in <b>Helpdesk Web Application</b></div>";
      $isiEmail .= "<div>Thank You.</div>";
      $isiEmail .= '<div>
                         <table>
                           <tbody>
                             <tr>
                               <td>ID Ticket</td>
                               <td>:</td>
                               <td>' . $query->id_ticket . '</td>
                             </tr>
                             <tr>
                               <td>Nama</td>
                               <td>:</td>
                               <td>' . $query->nama . '</td>
                             </tr>
                             <tr>
                               <td>Email</td>
                               <td>:</td>
                               <td>' . $query->email . '</td>
                             </tr>
                             <tr>
                               <td>Category</td>
                               <td>:</td>
                               <td>' . $query->nama_kategori . '</td>
                             </tr>
                             <tr>
                               <td>Sub Category</td>
                               <td>:</td>
                               <td>' . $query->nama_sub_kategori . '</td>
                             </tr>
                             <tr>
                               <td>Priority</td>
                               <td>:</td>
                               <td>' . $query->nama_prioritas . '</td>
                             </tr>
                             <tr>
                               <td>Location</td>
                               <td>:</td>
                               <td>' . $query->lokasi . '</td>
                             </tr>
                             <tr>
                               <td>Status</td>
                               <td>:</td>
                               <td>On Process</td>
                             </tr>
                             <tr>
                               <td>Problem</td>
                               <td>:</td>
                               <td>' . $query->problem_summary . '</td>
                             </tr>
                             <tr>
                               <td>Detail</td>
                               <td>:</td>
                               <td>' . nl2br($query->problem_detail) . '</td>
                             </tr>
                          </tbody>
                         </table>
                       </div>';
      $from = $this->settings->info['smtp_user'];
      $name = $this->settings->info['perusahaan'];
      $to = $query->email;
      $this->email->set_newline("\r\n");
      $this->email->from($from, $name);
      $this->email->to($to);
      $this->email->subject('Your Ticket (' . $query->id_ticket . ') is On Process');
      $this->email->attach('uploads/' . $query->filefoto);
      $cid = $this->email->attachment_cid('uploads/' . $query->filefoto);
      $this->email->message($isiEmail);
      if (!$this->email->send()) {
        //Set pemberitahuan bahwa ticket berhasil di-update
        $this->session->set_flashdata('status', 'Updated');
        //Kembali ke halaman List ticket (Assignment Ticket)
        redirect('ticket_teknisi/index_tugas');
      } else {
        echo 'Success to send email';
      }
    } else if ($query->progress == 100) {
      $isiEmail  = "<h1>Your Ticket (" . $query->id_ticket . ") is Done</h1>";
      $isiEmail  .= "<div>Dear " . $query->nama . "</div>";
      $isiEmail .= "<div>Your ticket is done of progress. The ticket will be closed.</div>";
      $isiEmail .= "<div>Thank You.</div>";
      $isiEmail .= '<div>
                            <table>
                              <tbody>
                                <tr>
                                  <td>ID Ticket</td>
                                  <td>:</td>
                                  <td>' . $query->id_ticket . '</td>
                                </tr>
                                <tr>
                                  <td>Nama</td>
                                  <td>:</td>
                                  <td>' . $query->nama . '</td>
                                </tr>
                                <tr>
                                  <td>Email</td>
                                  <td>:</td>
                                  <td>' . $query->email . '</td>
                                </tr>
                                <tr>
                                  <td>Category</td>
                                  <td>:</td>
                                  <td>' . $query->nama_kategori . '</td>
                                </tr>
                                <tr>
                                  <td>Sub Category</td>
                                  <td>:</td>
                                  <td>' . $query->nama_sub_kategori . '</td>
                                </tr>
                                <tr>
                                  <td>Priority</td>
                                  <td>:</td>
                                  <td>' . $query->nama_prioritas . '</td>
                                </tr>
                                <tr>
                                  <td>Location</td>
                                  <td>:</td>
                                  <td>' . $query->lokasi . '</td>
                                </tr>
                                <tr>
                                  <td>Status</td>
                                  <td>:</td>
                                  <td>Ticket Closed</td>
                                </tr>
                                <tr>
                                  <td>Problem</td>
                                  <td>:</td>
                                  <td>' . $query->problem_summary . '</td>
                                </tr>
                                <tr>
                                  <td>Detail</td>
                                  <td>:</td>
                                  <td>' . nl2br($query->problem_detail) . '</td>
                                </tr>
                             </tbody>
                            </table>
                          </div>';

      $from = $this->settings->info['smtp_user'];
      $name = $this->settings->info['perusahaan'];
      $to = $query->email;
      $this->email->set_newline("\r\n");
      $this->email->from($from, $name);
      $this->email->to($to);
      $this->email->subject('Your Ticket (' . $query->id_ticket . ') is Done');
      $this->email->attach('uploads/' . $query->filefoto);
      $cid = $this->email->attachment_cid('uploads/' . $query->filefoto);
      $this->email->message($isiEmail);
      if (!$this->email->send()) {
        //Set pemberitahuan bahwa ticket berhasil di-update
        $this->session->set_flashdata('status', 'Updated');
        //Kembali ke halaman List ticket (Assignment Ticket)
        redirect('ticket_teknisi/index_tugas');
      } else {
        echo 'Success to send email';
      }
    }
  }

  public function emailubah($id)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>Category of Ticket (" . $query->id_ticket . ") Has Been Changed</h1>";
    $isiEmail .= "<div>Please assign the technician after you check the detail to resolve the ticket</div>";
    $isiEmail .= '<div>
                        <table>
                          <tbody>
                            <tr>
                              <td>ID Ticket</td>
                              <td>:</td>
                              <td>' . $query->id_ticket . '</td>
                            </tr>
                            <tr>
                              <td>Nama</td>
                              <td>:</td>
                              <td>' . $query->nama . '</td>
                            </tr>
                            <tr>
                              <td>Email</td>
                              <td>:</td>
                              <td>' . $query->email . '</td>
                            </tr>
                            <tr>
                              <td>Category</td>
                              <td>:</td>
                              <td>' . $query->nama_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Sub Category</td>
                              <td>:</td>
                              <td>' . $query->nama_sub_kategori . '</td>
                            </tr>
                            <tr>
                              <td>Priority</td>
                              <td>:</td>
                              <td>' . $query->nama_prioritas . '</td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>:</td>
                              <td>' . $query->lokasi . '</td>
                            </tr>
                            <tr>
                              <td>Status</td>
                              <td>:</td>
                              <td>Category Changed</td>
                            </tr>
                            <tr>
                              <td>Problem</td>
                              <td>:</td>
                              <td>' . $query->problem_summary . '</td>
                            </tr>
                            <tr>
                              <td>Detail</td>
                              <td>:</td>
                              <td>' . nl2br($query->problem_detail) . '</td>
                            </tr>
                         </tbody>
                        </table>
                      </div>';

    $from = $this->settings->info['smtp_user'];
    $name = $query->nama_teknisi;
    $to = $this->settings->info['email'];
    $this->email->set_newline("\r\n");
    $this->email->from($from, $name);
    $this->email->to($to);
    $this->email->subject('Category of Ticket (' . $query->id_ticket . ') Has Been Changed');
    $this->email->attach('uploads/' . $query->filefoto);
    $cid = $this->email->attachment_cid('uploads/' . $query->filefoto);
    $this->email->message($isiEmail);
    if (!$this->email->send()) {
      $this->session->set_flashdata('status', 'Returned');
      //Kembali ke halaman List ticket (Assignment Ticket)
      redirect('ticket_teknisi/index_tugas');
    } else {
      echo 'Success to send email';
    }
  }
  //Selesai Bagian Notifikasi Email


  //Method yang digunakan untuk proses reopen ticket dengan parameter (id_ticket)
  public function reopen($id)
  {
    //Mengambil session admin
    $id_user    = $this->session->userdata('id_user');

    //Melakukan update data ticket dengan mengubah status ticket menjadi 1, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      'status'     => 1
    );

    //Melakukan insert data tracking ticket bahwa ticket di-reopen oleh admin, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "Ticket Reopened",
      'deskripsi'  => "Tiket Dibuka Kembali",
      'id_user'    => $id_user
    );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_ticket', $id);
    $this->db->update('ticket', $data);

    //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    $this->db->insert('tracking', $datatracking);
  }


  //Method untuk mendapatkan semua ticket yang akan ditugaskan ke teknisi
  public function pilih_teknisi()
  {
    //Query untuk mendapatkan semua ticket dengan status 2 (Ticket Received) dengan diurutkan berdasarkan tanggal ticket dibuat
    $query = $this->db->query("SELECT A.id_ticket, D.nama, D.email, D.telp, F.nama_dept, A.status, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, G.nama_prioritas, G.warna, H.lokasi, I.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported
    LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept
    LEFT JOIN departemen F ON F.id_dept = E.id_dept
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
    WHERE A.status IN (1) ORDER BY A.tanggal DESC");
    return $query;
  }

  //Bagian Notifikasi Email dari Message
  public function emailmessageticket($id)
  {
    //Query untuk mendapatkan data detail dari setiap ticket
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.progress, A.tanggal, A.tanggal_proses, A.tanggal_solved, A.id_prioritas, A.deadline, A.problem_summary, A.problem_detail, A.filefoto, B.nama_sub_kategori, C.id_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama AS nama_teknisi, G.lokasi, H.nama_bagian_dept, I.nama_dept, J.nama_prioritas, K.tanggal AS tanggal_message, K.status, K.message, K.id_user, K.filefoto AS filefoto_message FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN user E ON E.username = A.teknisi
    LEFT JOIN pegawai F ON F.nik = E.username 
    LEFT JOIN lokasi G ON G.id_lokasi = A.id_lokasi
    LEFT JOIN departemen_bagian H ON H.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen I ON I.id_dept = H.id_dept
    LEFT JOIN prioritas J ON J.id_prioritas = A.id_prioritas
    LEFT JOIN ticket_message K on K.id_ticket = A.id_ticket
    WHERE A.id_ticket = '$id'")->row();

    $isiEmail  = "<h1>New Message Ticket (" . $query->id_ticket . ")</h1>";
    $isiEmail .= "<div>New Message for Ticket with Number " . $query->id_ticket . " has been submited by " . $query->nama . "</div>";
    $isiEmail .= "<div>Please response and reply of the ticket message in <b>Helpdesk Web Application</b></div><br/>";

    $isiEmail .= "<div>Date: " . $query->tanggal . "</div><br/>";
    $isiEmail .= "<div>Message: " . $query->message . "</div><br/>";

    $from = $this->settings->info['smtp_user'];
    $name = $this->settings->info['perusahaan'];
    if ($this->session->userdata('level') == 'Admin') {
      $to = $query->email;
    } else if ($this->session->userdata('level') == 'Technician') {
      $to = $query->email;
    } else if ($this->session->userdata('level') == 'User') {
      $to = $this->settings->info['email'];
    }
    $this->email->set_newline("\r\n");
    $this->email->from($from, $name);
    $this->email->to($to);
    $this->email->subject('New Message Ticket (' . $query->id_ticket . ')');
    $this->email->attach('uploads/' . $query->filefoto_message);
    $this->email->message($isiEmail);

    if (!$this->email->send()) {
      //show_error($this->email->print_debugger());
    } else {
      echo 'Success to send email';
    }
  }

  //NEW ONE
  //Method untuk mendapatkan semua ticket pada dept masing-masing yang belum dilakukan approval 2025-02-20
  public function deptTicket($id)
  {
    //Query untuk mendapatkan semua ticket dengan status 1 (submitted) atau 2 (Belum di approve) dengan diurutkan berdasarkan tanggal ticket dibuat
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama_dept, G.nama_prioritas, G.warna, H.lokasi, I.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori 
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen F ON F.id_dept = E.id_dept
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
    INNER JOIN (SELECT db.id_dept 
                FROM pegawai p 
                INNER JOIN jabatan j ON P.id_jabatan = J.id_jabatan 
                INNER JOIN departemen_bagian db ON P.id_bagian_dept = DB.id_bagian_dept 
                INNER JOIN departemen d ON DB.id_dept = D.id_dept 
                WHERE nik  = '$id') as Z ON F.id_dept = Z.id_dept
    WHERE A.status IN (1,2)
    ORDER BY A.tanggal DESC");
    // $query = $this->db->query($sql, array($id));
    return $query;
  }

  //Method untuk mendapatkan semua ticket dari user dept masing-masing berdasarkan id dept
  public function getTicketSpvDept($id)
  {
    $query = $this->db->query("SELECT count(*) AS total
    FROM ticket t 
    INNER JOIN pegawai p ON t.reported = p.nik 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    INNER JOIN 
    (select d.id_dept AS dept_cd from pegawai p 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    WHERE p.nik = '$id') AS x ON d.id_dept = x.dept_cd");
    return $query->row();
  }

  //Method untuk mendapatkan ticket baru submitterd (1) dan belum di approve (2) dari user dept masing-masing berdasarkan id dept
  public function getNewTicketSpvDept($id)
  {
    $query = $this->db->query("SELECT count(*) AS total
    FROM ticket t 
    INNER JOIN pegawai p ON t.reported = p.nik 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    INNER JOIN 
    (select d.id_dept AS dept_cd from pegawai p 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    WHERE p.nik = '$id') AS x ON d.id_dept = x.dept_cd
    WHERE t.status IN (1,2)");
    return $query->row();
  }

  //Method untuk mendapatkan ticket reject (0) dari user dept masing-masing berdasarkan id dept
  public function getRejectTicketSpvDept($id) 
  {
    $query = $this->db->query("SELECT count(*) AS total
    FROM ticket t 
    INNER JOIN pegawai p ON t.reported = p.nik 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    INNER JOIN 
    (select d.id_dept AS dept_cd from pegawai p 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept
    INNER JOIN departemen d ON db.id_dept = d.id_dept
    WHERE p.nik = '$id') AS x ON d.id_dept = x.dept_cd
    WHERE t.status = 0");
    return $query->row();
  }

  public function getDept($id)
  {
    //Query untuk mendapatkan dept
    $query = $this->db->query("SELECT nama_dept FROM pegawai p 
    INNER JOIN departemen_bagian db ON p.id_bagian_dept = db.id_bagian_dept 
    INNER JOIN departemen d ON d.id_dept = db.id_bagian_dept 
    WHERE p.nik = '$id'");
    return $query->row();
  }


  //list daftar ticket spv dept
  public function list_ticket_spv($id)
  {
    $query = $this->db->query("SELECT A.id_ticket, A.status, A.tanggal, A.id_prioritas, A.deadline, A.problem_detail, A.problem_summary, A.filefoto, B.nama_sub_kategori, C.nama_kategori, D.nama, D.email, D.telp, F.nama_dept, G.nama_prioritas, G.warna, H.lokasi, I.nama_jabatan FROM ticket A 
    LEFT JOIN kategori_sub B ON B.id_sub_kategori = A.id_sub_kategori 
    LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
    LEFT JOIN pegawai D ON D.nik = A.reported 
    LEFT JOIN departemen_bagian E ON E.id_bagian_dept = D.id_bagian_dept 
    LEFT JOIN departemen F ON F.id_dept = E.id_dept
    LEFT JOIN prioritas G ON G.id_prioritas = A.id_prioritas
    LEFT JOIN lokasi H ON H.id_lokasi = A.id_lokasi
    LEFT JOIN jabatan I ON I.id_jabatan = D.id_jabatan
    INNER JOIN (SELECT db.id_dept 
                FROM pegawai p 
                INNER JOIN jabatan j ON P.id_jabatan = J.id_jabatan 
                INNER JOIN departemen_bagian db ON P.id_bagian_dept = DB.id_bagian_dept 
                INNER JOIN departemen d ON DB.id_dept = D.id_dept 
                WHERE nik  = '$id') as Z ON F.id_dept = Z.id_dept
    ORDER BY A.tanggal DESC");
    return $query;
  }


  //Method yang digunakan untuk proses approve ticket dengan parameter (id_ticket)
  public function approveSpv($id)
  {
    //Mengambil session SPV
    $id_user    = $this->session->userdata('id_user');

    //Melakukan update data ticket dengan mengubah status ticket menjadi 2, data ditampung ke dalam array '$data' yang nanti akan diupdate dengan query
    $data = array(
      //'deadline'   => date('Y-m-d H:i:s', strtotime($date . ' + ' . $date2 . ' days')),
      'status'     => 8,
      'last_update' => date("Y-m-d  H:i:s"),
    );

    //Melakukan insert data tracking ticket bahwa ticket di-approve oleh SPV, data tracking ke dalam array '$datatracking' yang nanti akan di-insert dengan query
    $datatracking = array(
      'id_ticket'  => $id,
      'tanggal'    => date("Y-m-d  H:i:s"),
      'status'     => "Ticket Approved",
      'deskripsi'  => "Approved by Supervisor Dept",
      'id_user'    => $id_user
    );

    //Query untuk melakukan update data ticket sesuai dengan array '$data' ke tabel ticket
    $this->db->where('id_ticket', $id);
    $this->db->update('ticket', $data);

    //Query untuk melakukan insert data tracking ticket sesuai dengan array '$datatracking' ke tabel tracking
    $this->db->insert('tracking', $datatracking);
  }

}
