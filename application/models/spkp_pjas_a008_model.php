<?php
class Spkp_pjas_a008_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_form(){
        $query = "SELECT @i:=@i+1 AS urut, a.* FROM spkp_pjas_form_a008 a";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_form($id){
        $query = $this->db->get_where('spkp_pjas_form_a008', array('id'=>$id),1);
        
        return $query->row_array();
    }
    
    function check_form($id){
        $query = $this->db->get_where('spkp_pjas_form_a008', array('id'=>$id),1);
        
        return $query->num_rows();
    }
    
    function insert_form(){
        $id = time();
        $data['id'] = $id;
        $data['mengetahui_nama'] = $this->input->post('mengetahui_nama');
        $data['mengetahui_nip'] = $this->input->post('mengetahui_nip');
        $data['pelapor_nama'] = $this->input->post('pelapor_nama');
        $data['pelapor_nip'] = $this->input->post('pelapor_nip');
        $data['tanggal'] = $this->input->post('tanggal');
        
        $this->db->insert('spkp_pjas_form_a008',$data);
        echo "1_".$id;
    }
    
    function update_form($id){
        $data['mengetahui_nama'] = $this->input->post('mengetahui_nama');
        $data['mengetahui_nip'] = $this->input->post('mengetahui_nip');
        $data['pelapor_nama'] = $this->input->post('pelapor_nama');
        $data['pelapor_nip'] = $this->input->post('pelapor_nip');
        $data['tanggal'] = $this->input->post('tanggal');
        
        return $this->db->update('spkp_pjas_form_a008',$data, array('id'=>$id));
    }
    
    function delete_form($id){
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a008');
        
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a008_auditor');
        
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a008_sdmi');
        
        return $x;
    }
    
    function json_auditor($id){
        $query = "SELECT @i:=@i+1 AS urut, a.* FROM spkp_pjas_form_a008_auditor a WHERE a.id = '$id'";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_auditor($id,$auditor){
        $query = $this->db->get_where('spkp_pjas_form_a008_auditor', array('id'=>$id,'id_auditor'=>$auditor),1);
        
        return $query->row_array();
    }
    
    function insert_auditor($id){
        $data['id'] = $id;
        $data['id_auditor'] = time();
        $data['tanggal'] = $this->input->post('tanggal_auditor');
        $data['nama'] = $this->input->post('nama');
        $data['nip'] = $this->input->post('nip');
        $data['gol'] = $this->input->post('gol');
        $data['jabatan'] = $this->input->post('jabatan');
        $data['instansi'] = $this->input->post('instansi');
        
        return $this->db->insert('spkp_pjas_form_a008_auditor',$data);
    }
    
    function update_auditor($id){
        $data['tanggal'] = $this->input->post('tanggal_auditor');
        $data['nama'] = $this->input->post('nama');
        $data['nip'] = $this->input->post('nip');
        $data['gol'] = $this->input->post('gol');
        $data['jabatan'] = $this->input->post('jabatan');
        $data['instansi'] = $this->input->post('instansi');
        
        return $this->db->update('spkp_pjas_form_a008_auditor',$data, array('id'=>$id,'id_auditor'=>$this->input->post('id_auditor')));
    }
    
    function delete_auditor($id,$auditor){
        $this->db->where(array('id'=>$id,'id_auditor'=>$auditor));
        return $this->db->delete('spkp_pjas_form_a008_auditor');
    }
    
    function json_sdmi($id){
        $query = "SELECT @i:=@i+1 AS urut, a.* FROM spkp_pjas_form_a008_sdmi a WHERE a.id = '$id'";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_sdmi($id,$id_sdmi){
        $query = $this->db->get_where('spkp_pjas_form_a008_sdmi', array('id'=>$id,'id_sdmi'=>$id_sdmi),1);
        
        return $query->row_array();
    }
    
    function insert_sdmi($id){
        $data['id'] = $id;
        $data['id_sdmi'] = time();
        $data['tahun'] = date('Y');
        $data['kode_pbkpks'] = $this->input->post('kode_pbkpks');
        $data['nama_sekolah'] = $this->input->post('nama_sekolah');
        $data['kepsek_nama'] = $this->input->post('kepsek_nama');
        $data['kepsek_nip'] = $this->input->post('kepsek_nip');
        $data['alamat'] = $this->input->post('alamat');
        $data['nilai'] = $this->input->post('nilai');
        $data['temuan'] = $this->input->post('temuan');
        
        return $this->db->insert('spkp_pjas_form_a008_sdmi',$data);
    }
    
    function update_sdmi($id){
      //  $data['tahun'] = $this->input->post('tahun');
        $data['kode_pbkpks'] = $this->input->post('kode_pbkpks');
        $data['nama_sekolah'] = $this->input->post('nama_sekolah');
        $data['kepsek_nama'] = $this->input->post('kepsek_nama');
        $data['kepsek_nip'] = $this->input->post('kepsek_nip');
        $data['alamat'] = $this->input->post('alamat');
        $data['nilai'] = $this->input->post('nilai');
        $data['temuan'] = $this->input->post('temuan');
        
        return $this->db->update('spkp_pjas_form_a008_sdmi',$data, array('id'=>$id,'id_sdmi'=>$this->input->post('id_sdmi')));
    }
    
    function delete_sdmi($id,$id_sdmi){
        $this->db->where(array('id'=>$id,'id_sdmi'=>$id_sdmi));
        return $this->db->delete('spkp_pjas_form_a008_sdmi');
    }
    
    function get_all_auditor($id){
        $this->db->order_by('id_auditor','asc');
        $query = $this->db->get_where('spkp_pjas_form_a008_auditor', array('id'=>$id));
        
        return $query->result();
    }
    
    function get_all_sdmi($id){
        $this->db->order_by('id_sdmi','asc');
        $query = $this->db->get_where('spkp_pjas_form_a008_sdmi', array('id'=>$id));
        
        return $query->result();
    }
}
?>