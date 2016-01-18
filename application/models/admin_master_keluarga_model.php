<?php
class Admin_master_keluarga_model extends CI_Model{

	var $tabel    = 'mas_keluarga';
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_keluarga(){
        $query = "select * from mas_keluarga order by id asc";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_data_row($id){
		$data = array();
		$options = array('id' => $id);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}
	function insert_entry(){
		$data['nama']=$this->input->post('nama');
		
		return $this->db->insert($this->tabel, $data);
    }

    function update_entry($id){
		$data['nama']=$this->input->post('nama');
        
		return $this->db->update($this->tabel, $data, array('id' => $this->input->post('id')));
    }
	
	function delete_entry($id){
		$this->db->where(array('id' => $id));

		return $this->db->delete($this->tabel);
	}



}
