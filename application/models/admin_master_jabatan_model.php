<?php
class Admin_master_jabatan_model extends CI_Model{

	var $tabel    = 'mas_jabatan';
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_jabatan(){
        $query = "
SELECT a.id_jabatan, a.id_parent, a.nama_jabatan, a.eselon,
CASE WHEN a.personil='1' THEN 'kepala' ELSE 'staff' END AS personil, c.ket AS subdit
FROM mas_jabatan a 
LEFT JOIN mas_subdit c
ON a.id_subdit = c.id_subdit ORDER BY a.id_jabatan ASC";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_data_row($id){
		$data = array();
		$query = $this->db->query("
SELECT a.id_jabatan, a.id_parent,a.id_subdit, a.nama_jabatan, a.eselon,a.personil, c.ket AS subdit
FROM mas_jabatan a 
LEFT JOIN mas_subdit c
ON a.id_subdit = c.id_subdit WHERE a.id_jabatan='".$id."'");
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}
	function insert_entry(){
		$data['id_subdit']=$this->input->post('id_subdit');
		$data['id_parent']=$this->input->post('id_parent');
		$data['nama_jabatan']=$this->input->post('nama_jabatan');
		$data['eselon']=$this->input->post('eselon');
		$data['personil']=$this->input->post('personil');
		
		return $this->db->insert($this->tabel, $data);
    }

    function update_entry($id){
		$data['id_subdit']=$this->input->post('id_subdit');
		$data['id_parent']=$this->input->post('id_parent');
		$data['nama_jabatan']=$this->input->post('nama_jabatan');
		$data['eselon']=$this->input->post('eselon');
		$data['personil']=$this->input->post('personil');
        
		return $this->db->update($this->tabel, $data, array('id_jabatan' => $this->input->post('id_jabatan')));
    }
	
	function delete_entry($id){
		$this->db->where(array('id_jabatan' => $id));

		return $this->db->delete($this->tabel);
	}
	
	function get_list_data_atasan(){	
		$query=$this->db->query("SELECT id_jabatan, nama_jabatan FROM mas_jabatan");		
		return $query->result();
	}
	
	function select_subdit($subdit,$id_parent=0)
	{
		$sql = "SELECT * FROM mas_jabatan WHERE id_subdit LIKE '".$subdit."%'";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$data=array();
		$data['atasan']="<option>-</option>";
        foreach($result as $x=>$y){
			$data['atasan'].="<option value='".$y['id_parent']."' ".($id_parent==$y['id_parent'] ? "selected":"").">".$y['nama_jabatan']."</option>";
		}
		
		return $data;
	}


}
