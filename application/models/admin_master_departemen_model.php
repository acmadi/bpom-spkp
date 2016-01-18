<?php
class Admin_master_departemen_model extends CI_Model {
    
    var $tabel    = 'mas_departemen';
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_departemen(){
        $query = "select * from mas_departemen order by id_departemen asc";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_data_row($id_departemen){
		$data = array();
		$options = array('id_departemen' => $id_departemen);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

    function insert_entry(){
		$data['jenis']=$this->input->post('jenis');
		$data['ket']=$this->input->post('ket');
		
		return $this->db->insert($this->tabel, $data);
    }

    function update_entry($id_departemen){
		$data['jenis']=$this->input->post('jenis');
		$data['ket']=$this->input->post('ket');
        
		return $this->db->update($this->tabel, $data, array('id_departemen' => $this->input->post('id_departemen')));
    }
	
	function delete_entry($id_departemen){
		$this->db->where(array('id_departemen' => $id_departemen));

		return $this->db->delete($this->tabel);
	}
}
?>