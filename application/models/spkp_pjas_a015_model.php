<?php
class Spkp_pjas_a015_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_form(){
        $query = "SELECT @i:=@i+1 AS urut, a.*, b.nama_propinsi FROM spkp_pjas_form_a015 a
                 INNER JOIN mas_propinsi b ON a.id_provinsi = b.id_propinsi";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_form($id){
        $query = $this->db->get_where('spkp_pjas_form_a015', array('id'=>$id),1);
        
        return $query->row_array();
    }
    
    function check_form($id){
        $query = $this->db->get_where('spkp_pjas_form_a015', array('id'=>$id),1);
        
        return $query->num_rows();
    }
    
    function insert_form(){
        $id = time();
        $data['id'] = $id;
        $data['id_provinsi'] = $this->input->post('id_provinsi');
        $data['tahun'] = $this->input->post('tahun');
        $data['tanggal'] = $this->input->post('tanggal');
        $data['tempat'] = $this->input->post('tempat');
        $data['penanggungjawab_nama'] = $this->input->post('penanggungjawab_nama');
        $data['penanggungjawab_nip'] = $this->input->post('penanggungjawab_nip');
        
        $this->db->insert('spkp_pjas_form_a015',$data);
        echo "1_".$id;
    }
    
    function update_form($id){
        $data['id_provinsi'] = $this->input->post('id_provinsi');
        $data['tahun'] = $this->input->post('tahun');
        $data['tanggal'] = $this->input->post('tanggal');
        $data['tempat'] = $this->input->post('tempat');
        $data['penanggungjawab_nama'] = $this->input->post('penanggungjawab_nama');
        $data['penanggungjawab_nip'] = $this->input->post('penanggungjawab_nip');
        
        return $this->db->update('spkp_pjas_form_a015',$data, array('id'=>$id));
    }
    
    function delete_form($id){
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a015');
        
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a015_sdmi');
        
        return $x;
    }
    
    function get_all_propinsi(){
        $this->db->order_by('id_propinsi','asc');
        $query = $this->db->get('mas_propinsi');
        
        return $query->result();
    }
    
    function json_sdmi($id){
        $query = "SELECT @i:=@i+1 AS urut, a.* FROM spkp_pjas_form_a015_sdmi a WHERE a.id = '$id'";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_sdmi($id,$sdmi){
        $query = $this->db->get_where('spkp_pjas_form_a015_sdmi', array('id'=>$id,'id_sdmi'=>$sdmi),1);
        
        return $query->row_array();
    }
    
    function insert_sdmi($id){
        $data['id'] = $id;
        $data['id_sdmi'] = time();
        $data['nama'] = $this->input->post('nama');
        $data['status'] = $this->input->post('status');
        $data['akreditasi'] = $this->input->post('akreditasi');
        $data['intervensi'] = $this->input->post('intervensi');
        $data['instansi'] = $this->input->post('instansi');
        
        return $this->db->insert('spkp_pjas_form_a015_sdmi',$data);
    }
    
    function update_sdmi($id){
        $data['nama'] = $this->input->post('nama');
        $data['status'] = $this->input->post('status');
        $data['akreditasi'] = $this->input->post('akreditasi');
        $data['intervensi'] = $this->input->post('intervensi');
        $data['instansi'] = $this->input->post('instansi');
        
        return $this->db->update('spkp_pjas_form_a015_sdmi',$data, array('id'=>$id,'id_sdmi'=>$this->input->post('id_sdmi')));
    }
    
    function delete_sdmi($id,$sdmi){
        $this->db->where(array('id'=>$id,'id_sdmi'=>$sdmi));
        return $this->db->delete('spkp_pjas_form_a015_sdmi');
    }
    
    function get_propinsi($id){
        $query = $this->db->get_where('mas_propinsi', array('id_propinsi'=>$id),1);
        $data = $query->row_array();
        
        return $data['nama_propinsi'];
    }
    
    function get_all_sdmi($id){
        $this->db->order_by('id_sdmi','asc');
        $query = $this->db->get_where('spkp_pjas_form_a015_sdmi', array('id'=>$id));
        
        return $query->result();
    }
    
    function del_all_sdmi($id){
        $this->db->where('id',$id);
        return $this->db->delete('spkp_pjas_form_a015_sdmi');
    }
    
    function cek_tanggal($id,$tgl){
        $query = $this->db->get_where('spkp_pjas_form_a015', array('id'=>$id,'tanggal'=>$tgl),1);
        
        return $query->num_rows();
    }
    
    function insert_import($id,$parent){
        $cek = $this->db->get_where('spkp_pjas_form_a015_sdmi', array('id'=>$id));
        $data_cek = $cek->num_rows();
        
        if($data_cek>0){
            $max = $this->db->query("select max(id_sdmi) as max from spkp_pjas_form_a015_sdmi where id = '$id'");
            $data_max = $max->row_array();
            
            $data = $parent;
            $data['id'] = $id;
            $data['id_sdmi'] = $data_max['max']+1;
            
            $this->db->insert('spkp_pjas_form_a015_sdmi',$data);
        }else{
            $data = $parent;
            $data['id'] = $id;
            $data['id_sdmi'] = time();
            
            $this->db->insert('spkp_pjas_form_a015_sdmi',$data);
        }
    }
}
?>