<?php
class Spkp_promotion_subdit_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_kegiatan($thn){
        $query = "SELECT @i:=@i+1 AS urut, FROM_UNIXTIME(a.waktu,'%Y/%m/%d %T') AS waktu,
                  a.id, a.nama, a.tahun, a.keterangan FROM spkp_kegiatan_promosi a WHERE a.tahun = '$thn' ORDER BY a.id ASC";
        
        return $this->crud->jqxGrid($query);
    }
    
    function json_upload($thn){
        $query = "SELECT @i:=@i+1 AS urut, FROM_UNIXTIME(b.id,'%Y/%m/%d %T') AS waktu,
                IF(b.update>1,FROM_UNIXTIME(b.update,'%Y/%m/%d %T'), 'NULL') AS waktu_update,
                 a.id, a.nama, a.tahun ,a.keterangan, b.id AS id_file, b.kegiatan,b.uploader, b.update, 
                b.keterangan as ket_file, b.filename, b.filesize, b.status, b.ip, c.username FROM spkp_kegiatan_promosi a
                INNER JOIN spkp_kegiatan_promosi_file b ON a.id = b.kegiatan
                INNER JOIN app_users_list c ON b.uploader = c.id WHERE a.tahun = '$thn' AND b.status = '1'";
       
       return $this->crud->jqxGrid($query);         
    }
    
    function get_data_row($id){
        $query = $this->db->get_where('spkp_kegiatan_promosi', array('id'=>$id),1);
        
        return $query->row_array();    
    }
    
    function get_data_row_file($id){
        $query = $this->db->get_where('spkp_kegiatan_promosi_file', array('id'=>$id),1);
        
        return $query->row_array();    
    }
    
    function insert_kegiatan(){
        $data['nama'] = $this->input->post('nama');
        $data['tahun'] = $this->input->post('tahun');
        $data['keterangan'] = $this->input->post('keterangan');
        $data['waktu'] = time();
        
        return $this->db->insert('spkp_kegiatan_promosi',$data);
    }
    
    function update_kegiatan(){
        $data['nama'] = $this->input->post('nama');
        $data['tahun'] = $this->input->post('tahun');
        $data['keterangan'] = $this->input->post('keterangan');
        
        return $this->db->update('spkp_kegiatan_promosi',$data,array('id'=>$this->input->post('id')));
    }
    
    function delete_kegiatan($id){
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_kegiatan_promosi');
        
        $this->db->where('kegiatan',$id);
        $x = $this->db->delete('spkp_kegiatan_promosi_file');
        
        return $x;
    }
    
    function get_all_kegiatan(){
        $this->db->order_by('id','asc');
        $query = $this->db->get('spkp_kegiatan_promosi');
        
        return $query->result();
    }
    
    function get_kegiatan($thn){
        $query = $this->db->get_where('spkp_kegiatan_promosi', array('tahun'=>$thn));
        
        return $query;
    }
    
    function insert_upload($upload_data){
        $data['id'] = time();
        $data['uploader'] = $this->session->userdata('id');
        $data['update'] = 0;
        $data['keterangan'] = $this->input->post('keterangan');
        $data['kegiatan'] = $this->input->post('kegiatan');
        $data['filename'] = $upload_data['file_name'];
        $data['filesize'] = $upload_data['file_size'];
        $data['status'] = $this->input->post('status');
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
       
        if($this->db->insert('spkp_kegiatan_promosi_file', $data)){
			return $data['id'];
		}else{
			return false;
		}
    }
    
    function update_upload($id,$upload_data=0){
        $data['uploader'] = $this->session->userdata('id');
        $data['update'] = time();
        $data['keterangan'] = $this->input->post('keterangan');
        $data['kegiatan'] = $this->input->post('kegiatan');
        $data['status'] = $this->input->post('status');
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        
        if($upload_data!=0){
			$data['filename'] = $upload_data['file_name'];
			$data['filesize'] = $upload_data['file_size'];
		}
        
		return $this->db->update('spkp_kegiatan_promosi_file', $data, array('id'=>$id));
    }
    
    function delete_upload($id){
        $this->db->where('id',$id);
        
        return $this->db->delete('spkp_kegiatan_promosi_file');
    }
}
?>