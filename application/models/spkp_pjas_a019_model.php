<?php
class Spkp_pjas_a019_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_form(){
        $query = "SELECT @i:=@i+1 AS urut, a.*, b.nama_balai FROM spkp_pjas_form_a019 a
                 INNER JOIN mas_balai b ON a.id_balai = b.id_balai";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_form($id){
        $query = $this->db->get_where('spkp_pjas_form_a019', array('id'=>$id),1);
        
        return $query->row_array();
    }
    
    function check_form($id){
        $query = $this->db->get_where('spkp_pjas_form_a019', array('id'=>$id),1);
        
        return $query->num_rows();
    }
    
    function insert_form(){
        $id = time();
        $data['id'] = $id;
        $data['id_balai'] = $this->input->post('id_balai');
        $data['tanggal'] = $this->input->post('tanggal');
        $data['tempat'] = $this->input->post('tempat');
        $data['penanggungjawab_jabatan'] = $this->input->post('penanggungjawab_jabatan');
        $data['penanggungjawab_nama'] = $this->input->post('penanggungjawab_nama');
        $data['penanggungjawab_nip'] = $this->input->post('penanggungjawab_nip');
        
        $this->db->insert('spkp_pjas_form_a019',$data);
        echo "1_".$id;
    }
    
    function update_form($id){
        $data['id_balai'] = $this->input->post('id_balai');
        $data['tanggal'] = $this->input->post('tanggal');
        $data['tempat'] = $this->input->post('tempat');
        $data['penanggungjawab_jabatan'] = $this->input->post('penanggungjawab_jabatan');
        $data['penanggungjawab_nama'] = $this->input->post('penanggungjawab_nama');
        $data['penanggungjawab_nip'] = $this->input->post('penanggungjawab_nip');
        
        return $this->db->update('spkp_pjas_form_a019',$data, array('id'=>$id));
    }
    
    function delete_form($id){
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a019');
        
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a019_sdmi');
        
        return $x;
    }
    
    function get_all_balai(){
        $this->db->order_by('id_balai','asc');
        $query = $this->db->get('mas_balai');
        
        return $query->result();
    }
    
    function json_sdmi($id){
        $query = "SELECT @i:=@i+1 AS urut, a.* FROM spkp_pjas_form_a019_sdmi a WHERE a.id = '$id'";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_sdmi($id,$sdmi){
        $query = $this->db->get_where('spkp_pjas_form_a019_sdmi', array('id'=>$id,'id_sdmi'=>$sdmi),1);
        
        return $query->row_array();
    }
    
    function insert_sdmi($id){
        $data['id'] = $id;
        $data['id_sdmi'] = time();
        $data['tanggal'] = $this->input->post('tanggal_sdmi');
        $data['nama'] = $this->input->post('nama');
        $data['npsn'] = $this->input->post('npsn');
        $data['alamat'] = $this->input->post('alamat');
        $data['kabkota'] = $this->input->post('kota');
        $data['komunitas'] = $this->input->post('komunitas');
        $data['jenis'] = $this->input->post('jenis');
        $data['kie_peserta'] = $this->input->post('kie_peserta');
        $data['kie_materi'] = $this->input->post('kie_materi');
        $data['dokumentasi'] = $this->input->post('dokumentasi');
        $data['evaluasi'] = $this->input->post('evaluasi');
        
        return $this->db->insert('spkp_pjas_form_a019_sdmi',$data);
    }
    
    function update_sdmi($id){
        $data['tanggal'] = $this->input->post('tanggal_sdmi');
        $data['nama'] = $this->input->post('nama');
        $data['npsn'] = $this->input->post('npsn');
        $data['alamat'] = $this->input->post('alamat');
        $data['kabkota'] = $this->input->post('kota');
        $data['komunitas'] = $this->input->post('komunitas');
        $data['jenis'] = $this->input->post('jenis');
        $data['kie_peserta'] = $this->input->post('kie_peserta');
        $data['kie_materi'] = $this->input->post('kie_materi');
        $data['dokumentasi'] = $this->input->post('dokumentasi');
        $data['evaluasi'] = $this->input->post('evaluasi');
        
        return $this->db->update('spkp_pjas_form_a019_sdmi',$data, array('id'=>$id,'id_sdmi'=>$this->input->post('id_sdmi')));
    }
    
    function delete_sdmi($id,$sdmi){
        $this->db->where(array('id'=>$id,'id_sdmi'=>$sdmi));
        return $this->db->delete('spkp_pjas_form_a019_sdmi');
    }
    
    function get_all_propinsi(){
        $this->db->order_by('id_propinsi','asc');
        $query = $this->db->get('mas_propinsi');
        
        return $query->result();
    }
    
    function get_balai($balai){
        $query = $this->db->get_where('mas_balai', array('id_balai'=>$balai),1);
        $data = $query->row_array();
        
        return $data['nama_balai'];
    }
    
    function get_all_sdmi($id){
        $this->db->order_by('a.id_sdmi','asc');
        $query = $this->db->query("SELECT a.*, b.nama_kota FROM spkp_pjas_form_a019_sdmi a INNER JOIN mas_kota b
                ON a.kabkota = b.id_kota WHERE a.id = '$id'");
        
        return $query->result();
    }
    
    function del_all_sdmi($id){
        $this->db->where('id',$id);
        return $this->db->delete('spkp_pjas_form_a019_sdmi');
    }
    
    function cek_tanggal($id,$tgl){
        $query = $this->db->get_where('spkp_pjas_form_a019', array('id'=>$id,'tanggal'=>$tgl),1);
        
        return $query->num_rows();
    }
    
    function insert_import($id,$parent){
        $cek = $this->db->get_where('spkp_pjas_form_a019_sdmi', array('id'=>$id));
        $data_cek = $cek->num_rows();
        
        if($data_cek>0){
            $max = $this->db->query("select max(id_sdmi) as max from spkp_pjas_form_a019_sdmi where id = '$id'");
            $data_max = $max->row_array();
            
            $data = $parent;
            $data['id'] = $id;
            $data['id_sdmi'] = $data_max['max']+1;
            
            $this->db->insert('spkp_pjas_form_a019_sdmi',$data);
        }else{
            $data = $parent;
            $data['id'] = $id;
            $data['id_sdmi'] = time();
            
            $this->db->insert('spkp_pjas_form_a019_sdmi',$data);
        }
    }
}
?>