<?php
class Spkp_aksi_dokumentasi_model extends CI_Model{
	var $table = "spkp_pjas_dokumentasi";
	var $table_file = "spkp_pjas_dokumentasi_file";
	
	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
	}
	
	function get_data($status){
		//$data = array();
		$query = $this->db->query("SELECT a.id, a.judul, a.keterangan, a.status, b.filename 
		FROM spkp_pjas_dokumentasi a LEFT JOIN spkp_pjas_dokumentasi_file b ON a.id = b.id_kegiatan 
		AND b.cover = '1' WHERE a.status=$status GROUP BY a.id ORDER BY a.id DESC");				
		return $query->result();
	}
	
	function get_info($id){
		$query = $this->db->get_where('spkp_pjas_dokumentasi', array('id'=>$id));		
        
        return $query->row_array();
	}
	
	function get_data_list($id,$status){
		$query = $this->db->get_where('spkp_pjas_dokumentasi_file', array('id_kegiatan'=>$id,'status'=>$status));
		return $query->result();
	}
	
	function insert_entry($id){
		$data['id']=$id;
		$data['judul']=$this->input->post('judul');
		$data['keterangan']=$this->input->post('keterangan');
		$data['status']=$this->input->post('status');
		$data['uploader'] = $this->session->userdata('id');
		
		$this->db->insert('spkp_pjas_dokumentasi', $data);
		
		echo "1_".$id;
    }

    function update_entry($id){
		$data['judul']=$this->input->post('judul');
		$data['keterangan']=$this->input->post('keterangan');
		$data['status']=$this->input->post('status');
		$data['uploader'] = $this->session->userdata('id');
        
		return $this->db->update('spkp_pjas_dokumentasi', $data, array('id' => $id));
    }
	
	function delete_entry($id){
		$this->db->where(array('id' => $id));

		return $this->db->delete('spkp_pjas_dokumentasi');
	}
	
	function delete_entry_img($id){
		$this->db->where(array('id' => $id));

		return $this->db->delete('spkp_pjas_dokumentasi_file');
	}
	
	function doupload($upload_data,$id){
		$data['id'] = time();
		$data['id_kegiatan'] = $id;
		$data['uploader'] = $this->session->userdata('id');
		$data['update'] = time();
		$data['judul'] = $this->input->post('judul');
		$data['status'] = $this->input->post('status');	
		$data['cover'] = $this->input->post('cover');
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		$data['filename'] = $upload_data['file_name'];
		$data['filesize'] = $upload_data['file_size'];
        
		if($data['cover']==1){
			if($this->db->update('spkp_pjas_dokumentasi_file',array('cover'=>0),array('id_kegiatan'=>$id,'cover'=>1)) &&
			$this->db->insert('spkp_pjas_dokumentasi_file', $data)){
				return $data['id'];
			}else{
				return false;
			}
		}
		else{
			if($this->db->insert('spkp_pjas_dokumentasi_file', $data)){
				return $data['id'];
			}else{
				return false;
			}
		}
	}
}
?>
