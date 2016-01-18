<?php
class Spkp_pjas_a020_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_form(){
        $query = "SELECT @i:=@i+1 AS urut, a.* FROM spkp_pjas_form_a020 a";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_form($id){
        $query = $this->db->get_where('spkp_pjas_form_a020', array('id'=>$id),1);
        
        return $query->row_array();
    }
    
    function check_form($id){
        $query = $this->db->get_where('spkp_pjas_form_a020', array('id'=>$id),1);
        
        return $query->num_rows();
    }
    
    function insert_form(){
        $id = time();
        $data['id'] = $id;
        $data['ttd_nama'] = $this->input->post('ttd_nama');
        $data['ttd_nip'] = $this->input->post('ttd_nip');
        $data['ttd_tmpt'] = $this->input->post('ttd_tmpt');
        $data['ttd_tgl'] = $this->input->post('ttd_tgl');
        $data['penyelenggara'] = $this->input->post('penyelenggara');
        $data['tempat'] = $this->input->post('tempat');
        $data['tgl'] = $this->input->post('tgl');
        $data['lokasi'] = "";
        $data['hasil_diskusi'] = "";
        
        $this->db->insert('spkp_pjas_form_a020',$data);
        echo "1_".$id;
    }
    
    function update_form($id){
        $data['ttd_nama'] = $this->input->post('ttd_nama');
        $data['ttd_nip'] = $this->input->post('ttd_nip');
        $data['ttd_tmpt'] = $this->input->post('ttd_tmpt');
        $data['ttd_tgl'] = $this->input->post('ttd_tgl');
        $data['penyelenggara'] = $this->input->post('penyelenggara');
        $data['tempat'] = $this->input->post('tempat');
        $data['tgl'] = $this->input->post('tgl');
        $data['lokasi'] = $this->input->post('lokasi');
        $data['hasil_diskusi'] = $this->input->post('hasil_diskusi');
        
        return $this->db->update('spkp_pjas_form_a020',$data, array('id'=>$id));
    }
    
    function update_detail_narasumber($id){
        $data['lokasi'] = $this->input->post('lokasi');
        $data['hasil_diskusi'] = $this->input->post('hasil_diskusi');
        
        return $this->db->update('spkp_pjas_form_a020',$data, array('id'=>$id));
    }
    
    function delete_form($id){
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a020');
        
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a020_narasumber');
        
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a020_peserta');
        
        return $x;
    }
    
    function json_narasumber($id){
        $query = "SELECT @i:=@i+1 AS urut, a.* FROM spkp_pjas_form_a020_narasumber a WHERE a.id = '$id'";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_narasumber($id,$nara){
        $query = $this->db->get_where('spkp_pjas_form_a020_narasumber', array('id'=>$id,'id_narasumber'=>$nara),1);
        
        return $query->row_array();
    }
    
    function insert_narasumber($id){
        $data['id'] = $id;
        $data['id_narasumber'] = time();
        $data['nama'] = $this->input->post('nama');
        $data['materi'] = $this->input->post('materi');
        
        return $this->db->insert('spkp_pjas_form_a020_narasumber',$data);
    }
    
    function update_narasumber($id){
        $data['nama'] = $this->input->post('nama');
        $data['materi'] = $this->input->post('materi');
        
        return $this->db->update('spkp_pjas_form_a020_narasumber',$data, array('id'=>$id,'id_narasumber'=>$this->input->post('id_narasumber')));
    }
    
    function delete_narasumber($id,$nara){
        $this->db->where(array('id'=>$id,'id_narasumber'=>$nara));
        return $this->db->delete('spkp_pjas_form_a020_narasumber');
    }
    
    function json_peserta($id){
        $query = "SELECT @i:=@i+1 AS urut, a.* FROM spkp_pjas_form_a020_peserta a WHERE a.id = '$id'";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_peserta($id,$peserta){
        $query = $this->db->get_where('spkp_pjas_form_a020_peserta', array('id'=>$id,'id_peserta'=>$peserta),1);
        
        return $query->row_array();
    }
    
    function insert_peserta($id){
        $data['id'] = $id;
        $data['id_peserta'] = time();
        $data['nama'] = $this->input->post('nama');
        $data['institusi'] = $this->input->post('institusi');
        $data['pre_test'] = $this->input->post('pre_test');
        $data['post_test'] = $this->input->post('post_test');
        
        return $this->db->insert('spkp_pjas_form_a020_peserta',$data);
    }
    
    function update_peserta($id){
        $data['nama'] = $this->input->post('nama');
        $data['institusi'] = $this->input->post('institusi');
        $data['pre_test'] = $this->input->post('pre_test');
        $data['post_test'] = $this->input->post('post_test');
        
        return $this->db->update('spkp_pjas_form_a020_peserta',$data, array('id'=>$id,'id_peserta'=>$this->input->post('id_peserta')));
    }
    
    function delete_peserta($id,$peserta){
        $this->db->where(array('id'=>$id,'id_peserta'=>$peserta));
        return $this->db->delete('spkp_pjas_form_a020_peserta');
    }
    
    function count_peserta($id){
        $query = $this->db->get_where('spkp_pjas_form_a020_peserta', array('id'=>$id));
        
        return $query->num_rows();
    }
    
    function get_all_narasumber($id){
        $this->db->order_by('id_narasumber','asc');
        $query = $this->db->get_where('spkp_pjas_form_a020_narasumber', array('id'=>$id));
        
        return $query->result();
    }
    
    function get_all_peserta($id){
        $this->db->order_by('id_peserta','asc');
        $query = $this->db->get_where('spkp_pjas_form_a020_peserta', array('id'=>$id));
        
        return $query->result();
    }
}
?>