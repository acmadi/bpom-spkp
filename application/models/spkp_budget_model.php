<?php
class Spkp_budget_model extends CI_Model {
    
    var $table = "spkp_sumberdaya_anggaran";
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_budget(){
        $query = "SELECT @i:=@i+1 AS urut, FROM_UNIXTIME(a.id,'%Y/%m/%d %T') AS waktu,IF(a.update>1, 
                FROM_UNIXTIME(a.update,'%Y/%m/%d %T'), 'NULL') AS waktu_update, a.*, b.nama, c.username
                FROM spkp_sumberdaya_anggaran a INNER JOIN mas_jenis b ON a.jenis = b.id_jenis
                INNER JOIN app_users_list c ON a.uploader = c.id WHERE a.status = 1 ORDER BY a.id ASC";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_data_row($id){
        $query = $this->db->get_where($this->table, array('id'=>$id),1);
        
        return $query->row_array();
    }
    
    function insert_entry($upload_data){
        $data['id'] = time();
        $data['uploader'] = $this->session->userdata('id');
        $data['update'] = 0;
        $data['judul'] = $this->input->post('judul');
        $data['jenis'] = $this->input->post('jenis');
        $data['tahun'] = $this->input->post('tahun');
        $data['keterangan'] = $this->input->post('keterangan');
        $data['filename'] = $upload_data['file_name'];
        $data['filesize'] = $upload_data['file_size'];
        $data['status'] = $this->input->post('status');
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
       
        if($this->db->insert($this->table, $data)){
			return $data['id'];
		}else{
			return false;
		}
    }
    
    function update_entry($id,$upload_data=0){
        $data['uploader'] = $this->session->userdata('id');
        $data['update'] = time();
        $data['judul'] = $this->input->post('judul');
        $data['jenis'] = $this->input->post('jenis');
        $data['tahun'] = $this->input->post('tahun');
        $data['keterangan'] = $this->input->post('keterangan');
        $data['status'] = $this->input->post('status');
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        
        if($upload_data!=0){
			$data['filename'] = $upload_data['file_name'];
			$data['filesize'] = $upload_data['file_size'];
		}
        
		return $this->db->update($this->table, $data, array('id'=>$id));
    }
    
    function delete_entry($id){
        $this->db->where('id',$id);
        
        return $this->db->delete($this->table);
    }
    
    function get_all_jenis(){
        $query = $this->db->get('mas_jenis');
        
        return $query->result();
    }
    
    function get_jenis($id_jenis){
        $this->db->select('nama');
        $query = $this->db->get_where('mas_jenis', array('id_jenis'=>$id_jenis),1);
        $data = $query->row_array();
        
        return $data['nama'];
    }
}
?>