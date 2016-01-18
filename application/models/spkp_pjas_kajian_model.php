<?php
class Spkp_pjas_kajian_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
    }


	function json_judul(){
		$query="SELECT @i:=@i+1 AS urut,FROM_UNIXTIME(spkp_pjas_kajian.id,'%Y/%m/%d %T') AS waktu,IF(spkp_pjas_kajian.update>1, 
				FROM_UNIXTIME(spkp_pjas_kajian.update,'%Y/%m/%d %T'), 'NULL') AS waktu_update, spkp_pjas_kajian.*, app_users_list.username
				FROM spkp_pjas_kajian 
				INNER JOIN app_users_list ON app_users_list.id=spkp_pjas_kajian.uploader WHERE spkp_pjas_kajian.uploader=".$this->session->userdata("id")." || spkp_pjas_kajian.status=1";
		$data = $this->crud->jqxGrid($query);
		return ($data);
	}

 	function get_data_row($id){
		$data = array();

		$this->db->where('id', $id);

		$query = $this->db->get("spkp_pjas_kajian");
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

	function doadd($upload_data){
		$data['id'] = time();
		$data['uploader'] = $this->session->userdata('id');
		$data['update'] = 0;
		$data['judul'] = $this->input->post('judul');
		$data['keterangan'] = $this->input->post('keterangan');
		$data['status'] = $this->input->post('status');
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		$data['filename'] = $upload_data['file_name'];
		$data['filesize'] = $upload_data['file_size'];
        
		if($this->db->insert('spkp_pjas_kajian', $data)){
			return $data['id'];
		}else{
			return false;
		}
	}

	function doedit($id,$upload_data=0){
		$data['uploader'] = $this->session->userdata('id');
		$data['update'] = time();
		$data['judul'] = $this->input->post('judul');
		$data['keterangan'] = $this->input->post('keterangan');
		$data['status'] = $this->input->post('status');
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		if($upload_data!=0){
			$data['filename'] = $upload_data['file_name'];
			$data['filesize'] = $upload_data['file_size'];
		}
        
		return $this->db->update('spkp_pjas_kajian', $data, array('id'=>$id));
	}

	function dodelete($id)
	{
		$this->db->where('id', $id);

		return $this->db->delete('spkp_pjas_kajian');
	}
}
?>