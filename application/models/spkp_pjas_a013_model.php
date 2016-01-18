<?php
class Spkp_pjas_a013_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_form(){
        $query = "SELECT @i:=@i+1 AS urut, a.*, b.nama_balai FROM spkp_pjas_form_a013 a
                INNER JOIN mas_balai b ON a.id_balai = b.id_balai";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_form($id){
        $query = $this->db->get_where('spkp_pjas_form_a013', array('id'=>$id),1);
        
        return $query->row_array();
    }
    
    function check_form($id){
        $query = $this->db->get_where('spkp_pjas_form_a013', array('id'=>$id),1);
        
        return $query->num_rows();
    }
    
    function insert_form(){
        $id = time();
        $data['id'] = $id;
        $data['ttd_nama'] = $this->input->post('ttd_nama');
        $data['ttd_nip'] = $this->input->post('ttd_nip');
        $data['ttd_tmpt'] = $this->input->post('ttd_tmpt');
        $data['ttd_tgl'] = $this->input->post('ttd_tgl');
        $data['id_balai'] = $this->input->post('id_balai');
        $data['tahun'] = $this->input->post('tahun');
        
        $this->db->insert('spkp_pjas_form_a013',$data);
        echo "1_".$id;
    }
    
    function update_form($id){
        $data['ttd_nama'] = $this->input->post('ttd_nama');
        $data['ttd_nip'] = $this->input->post('ttd_nip');
        $data['ttd_tmpt'] = $this->input->post('ttd_tmpt');
        $data['ttd_tgl'] = $this->input->post('ttd_tgl');
        $data['id_balai'] = $this->input->post('id_balai');
        $data['tahun'] = $this->input->post('tahun');
        
        return $this->db->update('spkp_pjas_form_a013',$data, array('id'=>$id));
    }
    
    function delete_form($id){
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a013');
        
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a013_pelaksanaan');
        
        return $x;
    }
    
    function json_pelaksanaan($id){
        $query = "SELECT @i:=@i+1 AS urut, a.* FROM spkp_pjas_form_a013_pelaksanaan a WHERE a.id = '$id'";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_pelaksanaan($id,$pelaksana){
        $query = $this->db->get_where('spkp_pjas_form_a013_pelaksanaan', array('id'=>$id,'id_pelaksanaan'=>$pelaksana),1);
        
        return $query->row_array();
    }
    
    function insert_pelaksanaan($id){
        $data['id'] = $id;
        $data['id_pelaksanaan'] = time();
        $data['tgl'] = $this->input->post('tgl');
        $data['jenis'] = $this->input->post('jenis');
        $data['media'] = $this->input->post('media');
        $data['kegiatan'] = $this->input->post('kegiatan');
        $data['evaluasi'] = $this->input->post('evaluasi');
        
        return $this->db->insert('spkp_pjas_form_a013_pelaksanaan',$data);
    }
    
    function update_pelaksanaan($id){
        $data['tgl'] = $this->input->post('tgl');
        $data['jenis'] = $this->input->post('jenis');
        $data['media'] = $this->input->post('media');
        $data['kegiatan'] = $this->input->post('kegiatan');
        $data['evaluasi'] = $this->input->post('evaluasi');
        
        return $this->db->update('spkp_pjas_form_a013_pelaksanaan',$data, array('id'=>$id,'id_pelaksanaan'=>$this->input->post('id_pelaksanaan')));
    }
    
    function delete_pelaksanaan($id,$pelaksana){
        $this->db->where(array('id'=>$id,'id_pelaksanaan'=>$pelaksana));
        return $this->db->delete('spkp_pjas_form_a013_pelaksanaan');
    }
    
    function get_balai($balai){
        $query = $this->db->get_where('mas_balai', array('id_balai'=>$balai),1);
        $data = $query->row_array();
        
        return $data['nama_balai'];
    }
    
    function get_all_balai(){
        $this->db->order_by('id_balai','asc');
        $query = $this->db->get('mas_balai');
        
        return $query->result();
    }
    
    function get_all_pelaksanaan($id){
        $this->db->order_by('id_pelaksanaan','asc');
        $query = $this->db->get_where('spkp_pjas_form_a013_pelaksanaan', array('id'=>$id));
        
        return $query->result();
    }
    
    function del_all_pelaksanaan($id){
        $this->db->where('id',$id);
        return $this->db->delete('spkp_pjas_form_a013_pelaksanaan');
    }
    
    function cek_tanggal($id,$tgl){
        $query = $this->db->get_where('spkp_pjas_form_a013', array('id'=>$id,'ttd_tgl'=>$tgl),1);
        
        return $query->num_rows();
    }
    
    function insert_import($id,$parent){
        $cek = $this->db->get_where('spkp_pjas_form_a013_pelaksanaan', array('id'=>$id));
        $data_cek = $cek->num_rows();
        
        if($data_cek>0){
            $max = $this->db->query("select max(id_pelaksanaan) as max from spkp_pjas_form_a013_pelaksanaan where id = '$id'");
            $data_max = $max->row_array();
            
            $data = $parent;
            $data['id'] = $id;
            $data['id_pelaksanaan'] = $data_max['max']+1;
            
            $this->db->insert('spkp_pjas_form_a013_pelaksanaan',$data);
        }else{
            $data = $parent;
            $data['id'] = $id;
            $data['id_pelaksanaan'] = time();
            
            $this->db->insert('spkp_pjas_form_a013_pelaksanaan',$data);
        }
    }
    
    
}
?>