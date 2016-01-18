<?php
class Admin_master_subdit_model extends CI_Model {
    
    var $tabel    = 'mas_subdit';
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_subdit(){
        $query = "select a.*,b.ket as top from mas_subdit a
		LEFT JOIN mas_subdit b ON b.id_subdit=a.id_top
		ORDER BY a.id_subdit ASC, a.id_top ASC";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_data_row($id_subdit){
		$data = array();
		$options = array('id_subdit' => $id_subdit);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

    function insert_entry(){
		$data['ket']=$this->input->post('ket');
		$data['status']=$this->input->post('status');
		$data['id_top']=$this->input->post('id_top');
		
		return $this->db->insert($this->tabel, $data);
    }

    function update_entry($id_subdit){
		$data['ket']=$this->input->post('ket');
		$data['status']=$this->input->post('status');
		$data['id_top']=$this->input->post('id_top');
        
		return $this->db->update($this->tabel, $data, array('id_subdit' => $this->input->post('id_subdit')));
    }
	
	function delete_entry($id_subdit){
		$this->db->where(array('id_subdit' => $id_subdit));

		return $this->db->delete($this->tabel);
	}
	
	function get_list_data(){		
		$query=$this->db->get($this->tabel);
		return $query->result();
	}
}	
?>