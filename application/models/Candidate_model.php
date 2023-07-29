<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Candidate_model extends CI_Model
{
	private $_table = "candidate";
    private $column = array('nama','jabatan','jenis_kelamin','alamat');
    private $order = array('id' => 'desc'); // default order

	public function __construct()
    {
        $this->load->database();
        $this->load->helper('url');
    }
    
	/*
        Get all the records from the database
    */
    public function _get_datatables_query()
    {
        $candidate = $this->db->get("candidate")->result();
        $i = 0;
        foreach ($this->column as $item)
        {
            if($_POST['search']['value']) //  for search
            {
                if($i===0) // first loop
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $column[$i] = $item; 
            $i++;
        }
        if(isset($_POST['order'])) // sorting
        {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }

        return $candidate;
    }
 
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('candidate');
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get('candidate');
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }

    public function get_by_id($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->get('candidate');

        return $query->row();
    }

    public function save($data)
    {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data)
    {
        $this->db->update($this->_table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->_table);
    }

    public function get_rows()
    {
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('candidate');

        return $query->result();
    }
}

