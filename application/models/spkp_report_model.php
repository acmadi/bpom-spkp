<?php
class Spkp_report_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_judul($thn){
        $query = "SELECT @i:=@i+1 AS urut, FROM_UNIXTIME(a.id,'%Y/%m/%d %T') AS waktu,
                IF(a.update>1,FROM_UNIXTIME(a.update,'%Y/%m/%d %T'), 'NULL') AS waktu_update,
                a.id AS id_file, a.judul, a.tipe, a.tahun, a.uploader, a.update, 
                a.keterangan as ket_file, a.filename, a.filesize, a.status, a.ip, b.username FROM spkp_report a
                INNER JOIN app_users_list b ON a.uploader = b.id WHERE a.tahun = '$thn' AND a.status = '1'";
       
       return $this->crud->jqxGrid($query);         
    }
    
    function get_data_row($id){
        $query = $this->db->get_where('spkp_report', array('id'=>$id),1);
        
        return $query->row_array();    
    }
    
    function insert_upload($upload_data){
        $data['id'] = time();
        $data['uploader'] = $this->session->userdata('id');
        $data['update'] = 0;
        $data['keterangan'] = $this->input->post('keterangan');
        $data['judul'] = $this->input->post('judul');
		$data['tipe'] = $this->input->post('tipe');
        $data['tahun'] = $this->input->post('tahun');
        $data['filename'] = $upload_data['file_name'];
        $data['filesize'] = $upload_data['file_size'];
        $data['status'] = $this->input->post('status');
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
       
        if($this->db->insert('spkp_report', $data)){
			return $data['id'];
		}else{
			return false;
		}
    }
    
    function update_upload($id,$upload_data=0){
        $data['uploader'] = $this->session->userdata('id');
        $data['update'] = time();
        $data['keterangan'] = $this->input->post('keterangan');
        $data['judul'] = $this->input->post('judul');
		$data['tipe'] = $this->input->post('tipe');
        $data['tahun'] = $this->input->post('tahun');
        $data['status'] = $this->input->post('status');
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        
        if($upload_data!=0){
			$data['filename'] = $upload_data['file_name'];
			$data['filesize'] = $upload_data['file_size'];
		}
        
		return $this->db->update('spkp_report', $data, array('id'=>$id));
    }
    
    function delete_upload($id){
        $this->db->where('id',$id);
        return $this->db->delete('spkp_report');
    }
}
?>