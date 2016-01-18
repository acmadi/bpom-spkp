<?php
class Admin_kondisi_model extends CI_Model {

    var $tabel		= 'prm_kondis';

    function __construct() {
        parent::__construct();
		$this->load->library('encrypt');
   }
    
    function get_count($options=array())
    {
		foreach($options as $x=>$y){
			$this->db->like($x,$y);
		}
        return $this->db->count_all_results($this->tabel);
    }

    function get_data($start,$limit,$options=array())
    {
		foreach($options as $x=>$y){
			$this->db->like($x,$y);
		}
		$this->db->order_by($this->tabel.'.kondisi','ASC');
        $query = $this->db->get($this->tabel,$limit,$start);
        return $query->result();
    }

    function get_data_all()
    {
		$this->db->from($this->tabel);
		$this->db->order_by($this->tabel.'.kondisi','DESC');
		$query = $this->db->get();
        return $query->result();
    }

 	function get_data_row($id){
		$options = array('id' => $id);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}
	

   function insert_entry()
    {
		$data['kondisi']=$this->input->post('kondisi');

        $this->db->insert($this->tabel, $data);
		return $this->db->insert_id();
    }
	
    function update_entry($id)
    {
		$data['kondisi']=$this->input->post('kondisi');
        
		return $this->db->update($this->tabel, $data, array('id' => $id));
    }
	

	function delete_entry($id)
	{
		$this->db->where(array('id' => $id));

		return $this->db->delete($this->tabel);
	}
}