<?php
defined('BASEPATH') or exit('No direct script access allowed');
/*
PT. ITSHOP BISNIS DIGITAL
Toko Online: ITSHOP Purwokerto (Tokopedia.com/itshoppwt, Shopee.co.id/itshoppwt, Bukalapak.com/itshoppwt)
Dibuat oleh: Hari Wicaksono, S.Kom
Created: 12-2022
Modified: 06-2023
*/

class TicketData_model extends CI_Model
{
    var $table = 'ticket';
    var $column_order = array('id_ticket', 'status', 'tanggal', 'problem_summary', 'problem_detail', 'D.nama', 'H.lokasi', 'C.nama_kategori', 'B.nama_sub_kategori');
    var $column_search = array('id_ticket', 'status', 'tanggal', 'problem_summary', 'problem_detail', 'D.nama', 'H.lokasi', 'C.nama_kategori', 'B.nama_sub_kategori');
    var $order = array('tanggal' => 'desc');

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->search = '';
    }

    private function _get_datatables_query()
    {
        $this->db->select("{$this->table}.id_ticket, {$this->table}.status, {$this->table}.tanggal, {$this->table}.last_update, {$this->table}.id_prioritas, {$this->table}.deadline, {$this->table}.teknisi, {$this->table}.problem_summary, {$this->table}.problem_detail,{$this->table}.filefoto, C.nama_kategori, B.nama_sub_kategori, D.nama, F.nama_dept, G.nama_prioritas, G.warna, G.waktu_respon, H.lokasi, I.nama_jabatan, K.nama AS nama_teknisi");
        $this->db->from($this->table);
        $this->db->join("kategori_sub B", "B.id_sub_kategori = {$this->table}.id_sub_kategori", "left");
        $this->db->join("kategori C", "C.id_kategori = B.id_kategori", "left");
        $this->db->join("pegawai D", "D.nik = {$this->table}.reported", "left");
        $this->db->join("departemen_bagian E", "E.id_bagian_dept = D.id_bagian_dept", "left");
        $this->db->join("departemen F", "F.id_dept = E.id_dept", "left");
        $this->db->join("prioritas G", "G.id_prioritas = {$this->table}.id_prioritas", "left");
        $this->db->join("lokasi H", "H.id_lokasi = {$this->table}.id_lokasi", "left");
        $this->db->join("jabatan I", "I.id_jabatan = D.id_jabatan", "left");
        $this->db->join("pegawai K", "K.nik = {$this->table}.teknisi", "left");
        //add custom filter here for status
        if ($this->input->post('status')) {
            if ($this->input->post('status') == 'Ticket Rejected') {
                $status = 0;
            } else if ($this->input->post('status') == 'Ticket Submited') {
                $status = 1;
            } else if ($this->input->post('status') == 'Category Changed') {
                $status = 2;
            } else if ($this->input->post('status') == 'Assigned to Technician') {
                $status = 3;
            } else if ($this->input->post('status') == 'On Process') {
                $status = 4;
            } else if ($this->input->post('status') == 'Pending') {
                $status = 5;
            } else if ($this->input->post('status') == 'Solve') {
                $status = 6;
            } else if ($this->input->post('status') == 'Late Finished') {
                $status = 7;
            }
            $this->db->where("{$this->table}.status", (int)$status);
        }

        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('id_ticket', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
        $this->db->where('id_ticket', $id);
        $this->db->delete($this->table);
    }

    public function get_by_id_view($id)
    {
        $this->db->from($this->table);
        $this->db->where('id_ticket', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $results = $query->result();
        }
        return $results;
    }
}
