<?php
class spkp_personalia_kerjasama_int_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_departemen_int(){
        $query = "SELECT @i:=@i+1 AS urut, a.* FROM mas_departemen a WHERE a.jenis = 'Internasional' ORDER BY ket ASC";
        
        return $this->crud->jqxGrid($query);
    }
    
    function json_upload($departemen){
        $query = "SELECT @i:=@i+1 AS urut, FROM_UNIXTIME(b.id,'%Y/%m/%d %T') AS waktu,
                IF(b.update>1,FROM_UNIXTIME(b.update,'%Y/%m/%d %T'), 'NULL') AS waktu_update,
                 a.id_departemen, a.jenis AS jenis_departemen, a.ket, b.id AS id_file, b.departemen,b.jenis,b.uploader, b.update, 
                b.keterangan AS ket_file, b.filename, b.filesize, b.status, b.ip, c.username FROM mas_departemen a
                INNER JOIN spkp_kegiatan_kerjasama_int_file b ON a.id_departemen = b.departemen                
                INNER JOIN app_users_list c ON b.uploader = c.id WHERE b.departemen ='$departemen' AND b.status = '1'";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_data_row($id){
        $query = $this->db->get_where('mas_departemen', array('id_departemen'=>$id),1);
        
        return $query->row_array();
    }
    
    function get_data_row_file($id){
        $query = $this->db->get_where('spkp_kegiatan_kerjasama_int_file', array('id'=>$id),1);
        
        return $query->row_array();    
    }
    
    function insert_departemen(){
        $data['jenis'] = "Internasional";
        $data['ket'] = $this->input->post('ket');
        
        return $this->db->insert('mas_departemen',$data);
    }
    
    function update_departemen(){
        $data['jenis'] = "Internasional";
        $data['ket'] = $this->input->post('ket');
        
        return $this->db->update('mas_departemen', $data, array('id_departemen'=>$this->input->post('id_departemen')));
    }
    
    function delete_departemen($id){
        $this->db->where('id_departemen',$id);
    
        return $this->db->delete('mas_departemen');
    }
    
    function insert_upload($upload_data){
        $data['id'] = time();
        $data['uploader'] = $this->session->userdata('id');
        $data['update'] = 0;
        $data['departemen'] = $this->input->post('departemen');
        $data['jenis'] = $this->input->post('jenis');
        $data['keterangan'] = $this->input->post('keterangan');
        $data['filename'] = $upload_data['file_name'];
        $data['filesize'] = $upload_data['file_size'];
        $data['status'] = $this->input->post('status');
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
       
        if($this->db->insert('spkp_kegiatan_kerjasama_int_file', $data)){
			return $data['id'];
		}else{
			return false;
		}
    }
    
    function update_upload($id,$upload_data=0){
        $data['uploader'] = $this->session->userdata('id');
        $data['update'] = time();
        $data['departemen'] = $this->input->post('departemen');
        $data['jenis'] = $this->input->post('jenis');
        $data['keterangan'] = $this->input->post('keterangan');
        $data['status'] = $this->input->post('status');
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        
        if($upload_data!=0){
			$data['filename'] = $upload_data['file_name'];
			$data['filesize'] = $upload_data['file_size'];
		}
        
		return $this->db->update('spkp_kegiatan_kerjasama_int_file', $data, array('id'=>$id));
    }
    
    function delete_upload($id){
        $this->db->where('id',$id);
        
        return $this->db->delete('spkp_kegiatan_kerjasama_int_file');
    }
    
    function get_all_departmen_int(){
        $this->db->order_by('id_departemen','asc');
        $query = $this->db->get_where('mas_departemen', array('jenis'=>'Internasional'));
        
        return $query;
    }
    
    function get_departemen($id){
        $query = $this->db->get_where('mas_departemen', array('id_departemen'=>$id),1);
        $data = $query->row_array();
        
        return $data['ket'];
    }
    
    function get_first_departmen(){
		$this->db->where(array('jenis'=>'Internasional'));
        $this->db->order_by('id_departemen','asc');
		$query = $this->db->get('mas_departemen');
        $data = $query->row_array();
        
        return $data['id_departemen'];
        
    }
    
    function get_id_file($departemen){
        $query = $this->db->get_where('spkp_kegiatan_kerjasama_int_file', array('departemen'=>$departemen));
        
        return $query->result();
    }
}
?>