<?php
class Admin_master_golongan_model extends CI_Model {
    
    var $tabel    = 'mas_golongan';
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_golongan(){
        $query = "select * from mas_golongan order by id_golongan asc";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_data_row($id_golongan){
		$data = array();
		$options = array('id_golongan' => $id_golongan);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

    function insert_entry(){
		$data['jabatan']=$this->input->post('jabatan');
		$data['golongan']=$this->input->post('golongan');
		
		return $this->db->insert($this->tabel, $data);
    }

    function update_entry($id_golongan){
		$data['jabatan']=$this->input->post('jabatan');
		$data['golongan']=$this->input->post('golongan');
        
		return $this->db->update($this->tabel, $data, array('id_golongan' => $this->input->post('id_golongan')));
    }
	
	function delete_entry($id_golongan){
		$this->db->where(array('id_golongan' => $id_golongan));

		return $this->db->delete($this->tabel);
	}
}
?>