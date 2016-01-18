<?php
class Spkp_task_function_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
    }


	function json_tugasfungsi(){
		$query="SELECT @i:=@i+1 AS urut,FROM_UNIXTIME(spkp_tugasfungsi.id,'%Y/%m/%d %T') AS waktu,IF(spkp_tugasfungsi.update>1, 
				FROM_UNIXTIME(spkp_tugasfungsi.update,'%Y/%m/%d %T'), 'NULL') AS waktu_update, spkp_tugasfungsi.*, app_users_list.username
				FROM spkp_tugasfungsi 
				INNER JOIN app_users_list ON app_users_list.id=spkp_tugasfungsi.uploader WHERE spkp_tugasfungsi.uploader=".$this->session->userdata("id")." || spkp_tugasfungsi.status=1";
		$data = $this->crud->jqxGrid($query);
		return ($data);
	}

 	function get_data_row($id){
		$data = array();

		$this->db->where('id', $id);

		$query = $this->db->get("spkp_tugasfungsi");
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
        
		if($this->db->insert('spkp_tugasfungsi', $data)){
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
        
		return $this->db->update('spkp_tugasfungsi', $data, array('id'=>$id));
	}

	function dodelete($id)
	{
		$this->db->where('id', $id);

		return $this->db->delete('spkp_tugasfungsi');
	}
}
?>