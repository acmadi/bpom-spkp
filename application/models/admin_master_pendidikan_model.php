<?php
class Admin_master_pendidikan_model extends CI_Model{

	var $tabel    = 'mas_pendidikan';
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_pendidikan(){
        $query = "select * from mas_pendidikan order by id_pendidikan asc";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_data_row($id_pendidikan){
		$data = array();
		$options = array('id_pendidikan' => $id_pendidikan);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}
	function insert_entry(){
		$data['nama']=$this->input->post('nama');
		$data['tingkat']=$this->input->post('tingkat');
		
		return $this->db->insert($this->tabel, $data);
    }

    function update_entry($id_pendidikan){
		$data['nama']=$this->input->post('nama');
		$data['tingkat']=$this->input->post('tingkat');
        
		return $this->db->update($this->tabel, $data, array('id_pendidikan' => $this->input->post('id_pendidikan')));
    }
	
	function delete_entry($id_pendidikan){
		$this->db->where(array('id_pendidikan' => $id_pendidikan));

		return $this->db->delete($this->tabel);
	}



}
