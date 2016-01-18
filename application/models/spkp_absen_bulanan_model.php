<?php
class Spkp_absen_bulanan_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
    }


	function json(){
		$query="SELECT @i:=@i+1 AS urut,FROM_UNIXTIME(absen_bulanan.id,'%Y/%m/%d %T') AS waktu,IF(absen_bulanan.update>1, 
				FROM_UNIXTIME(absen_bulanan.update,'%Y/%m/%d %T'), 'NULL') AS waktu_update, absen_bulanan.*, app_users_list.username, mas_subdit.ket
				FROM absen_bulanan 
				INNER JOIN mas_subdit ON mas_subdit.id_subdit=absen_bulanan.id_subdit
				INNER JOIN app_users_list ON app_users_list.id=absen_bulanan.uploader WHERE absen_bulanan.uploader=".$this->session->userdata("id")." || absen_bulanan.status=1";
		$data = $this->crud->jqxGrid($query);
		return ($data);
	}

 	function get_data_row($id){
		$data = array();

		$this->db->where('id', $id);

		$query = $this->db->get("absen_bulanan");
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
		$data['bulan'] = $this->input->post('bulan');
		$data['tahun'] = $this->input->post('tahun');
		$data['id_subdit'] = $this->input->post('id_subdit');
		$data['keterangan'] = $this->input->post('keterangan');
		$data['status'] = $this->input->post('status');
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		$data['filename'] = $upload_data['file_name'];
		$data['filesize'] = $upload_data['file_size'];
        
		if($this->db->insert('absen_bulanan', $data)){
			return $data['id'];
		}else{
			return false;
		}
	}

	function doedit($id,$upload_data=0){
		$data['uploader'] = $this->session->userdata('id');
		$data['update'] = time();
		$data['bulan'] = $this->input->post('bulan');
		$data['tahun'] = $this->input->post('tahun');
		$data['id_subdit'] = $this->input->post('id_subdit');
		$data['keterangan'] = $this->input->post('keterangan');
		$data['status'] = $this->input->post('status');
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		if($upload_data!=0){
			$data['filename'] = $upload_data['file_name'];
			$data['filesize'] = $upload_data['file_size'];
		}
        
		return $this->db->update('absen_bulanan', $data, array('id'=>$id));
	}

	function dodelete($id)
	{
		$this->db->where('id', $id);

		return $this->db->delete('absen_bulanan');
	}
}
?>