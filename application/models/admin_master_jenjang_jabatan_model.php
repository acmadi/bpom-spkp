<?php
class Admin_master_jenjang_jabatan_model extends CI_Model{

	var $tabel    = 'mas_jenjang_jabatan';
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_jenjang(){
        $query = "select * from mas_jenjang_jabatan order by id_jenjang asc";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_data_row($id_jenjang){
		$data = array();
		$options = array('id_jenjang' => $id_jenjang);
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

    function update_entry($id_jenjang){
		$data['nama']=$this->input->post('nama');
        
		return $this->db->update($this->tabel, $data, array('id_jenjang' => $this->input->post('id_jenjang')));
    }
	
	function delete_entry($id_jenjang){
		$this->db->where(array('id_jenjang' => $id_jenjang));

		return $this->db->delete($this->tabel);
	}



}
