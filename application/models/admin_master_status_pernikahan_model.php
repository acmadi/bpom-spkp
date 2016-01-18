<?php
class Admin_master_status_pernikahan_model extends CI_Model {
    
    var $tabel    = 'mas_status_kawin';
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_pernikahan(){
        $query = "select * from mas_status_kawin order by id_status asc";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_data_row($id){
		$data = array();
		$options = array('id_status' => $id);
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
        
		return $this->db->update($this->tabel, $data, array('id_status' => $this->input->post('id_status')));
    }
	
	function delete_entry($id){
		$this->db->where(array('id_status' => $id));

		return $this->db->delete($this->tabel);
	}
}
?>