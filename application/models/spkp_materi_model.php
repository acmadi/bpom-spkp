<?php
class Spkp_materi_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_materi(){
        $query = "SELECT @i:=@i+1 AS urut, FROM_UNIXTIME(a.waktu,'%Y/%m/%d %T') AS waktu,
                 a.id, a.nama, a.keterangan FROM spkp_materi a ORDER BY a.id ASC";
        
        return $this->crud->jqxGrid($query);
    }
    
    function json_upload(){
        $query = "SELECT @i:=@i+1 AS urut, FROM_UNIXTIME(b.id,'%Y/%m/%d %T') AS waktu,
                IF(b.update>1,FROM_UNIXTIME(b.update,'%Y/%m/%d %T'), 'NULL') AS waktu_update,
                a.id, a.nama, a.keterangan, b.id AS id_file, b.materi, b.uploader, b.update, 
                b.keterangan as ket_file, b.filename, b.filesize, b.status, b.ip, c.username FROM spkp_materi a
                INNER JOIN spkp_materi_file b ON a.id = b.materi
                INNER JOIN app_users_list c ON b.uploader = c.id WHERE b.status = '1'";
       
       return $this->crud->jqxGrid($query);         
    }
    
    function get_data_row($id){
        $query = $this->db->get_where('spkp_materi', array('id'=>$id),1);
        
        return $query->row_array();    
    }
    
    function get_data_row_file($id){
        $query = $this->db->get_where('spkp_materi_file', array('id'=>$id),1);
        
        return $query->row_array();    
    }
    
    function insert_materi(){
        $data['nama'] = $this->input->post('nama');
        $data['keterangan'] = $this->input->post('keterangan');
        $data['waktu'] = time();
        
        return $this->db->insert('spkp_materi',$data);
    }
    
    function update_materi(){
        $data['nama'] = $this->input->post('nama');
        $data['keterangan'] = $this->input->post('keterangan');
        
        return $this->db->update('spkp_materi',$data,array('id'=>$this->input->post('id')));
    }
    
    function delete_materi($id){
        $this->db->where('id',$id);
        $x =  $this->db->delete('spkp_materi');
        
        $this->db->where('materi',$id);
        $x =  $this->db->delete('spkp_materi_file');
        
        return $x;
    }
    
    function get_all_materi(){
        $this->db->order_by('id','asc');
        $query = $this->db->get('spkp_materi');
        
        return $query->result();
    }
    
    function insert_upload($upload_data){
        $data['id'] = time();
        $data['uploader'] = $this->session->userdata('id');
        $data['update'] = 0;
        $data['keterangan'] = $this->input->post('keterangan');
        $data['materi'] = $this->input->post('materi');
        //$data['tahun'] = $this->input->post('tahun');
        $data['filename'] = $upload_data['file_name'];
        $data['filesize'] = $upload_data['file_size'];
        $data['status'] = $this->input->post('status');
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
       
        if($this->db->insert('spkp_materi_file', $data)){
			return $data['id'];
		}else{
			return false;
		}
    }
    
    function update_upload($id,$upload_data=0){
        $data['uploader'] = $this->session->userdata('id');
        $data['update'] = time();
        $data['keterangan'] = $this->input->post('keterangan');
        $data['materi'] = $this->input->post('materi');
        $data['status'] = $this->input->post('status');
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        
        if($upload_data!=0){
			$data['filename'] = $upload_data['file_name'];
			$data['filesize'] = $upload_data['file_size'];
		}
        
		return $this->db->update('spkp_materi_file', $data, array('id'=>$id));
    }
    
    function delete_upload($id){
        $this->db->where('id',$id);
        return $this->db->delete('spkp_materi_file');
    }
}
?>