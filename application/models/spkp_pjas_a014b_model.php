<?php
class Spkp_pjas_a014b_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_form(){
        $query = "SELECT @i:=@i+1 AS urut, a.*, b.nama_balai FROM spkp_pjas_form_a014b a
                 INNER JOIN mas_balai b ON a.id_balai = b.id_balai";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_form($id){
        $query = $this->db->get_where('spkp_pjas_form_a014b', array('id'=>$id),1);
        
        return $query->row_array();
    }
    
    function check_form($id){
        $query = $this->db->get_where('spkp_pjas_form_a014b', array('id'=>$id),1);
        
        return $query->num_rows();
    }
    
    function insert_form(){
        $id = time();
        $data['id'] = $id;
        $data['id_balai'] = $this->input->post('id_balai');
        $data['tanggal'] = $this->input->post('tanggal');
        $data['tempat'] = $this->input->post('tempat');
        $data['penanggungjawab_nama'] = $this->input->post('penanggungjawab_nama');
        $data['penanggungjawab_nip'] = $this->input->post('penanggungjawab_nip');
        
        $this->db->insert('spkp_pjas_form_a014b',$data);
        echo "1_".$id;
    }
    
    function update_form($id){
        $data['id_balai'] = $this->input->post('id_balai');
        $data['tanggal'] = $this->input->post('tanggal');
        $data['tempat'] = $this->input->post('tempat');
        $data['penanggungjawab_nama'] = $this->input->post('penanggungjawab_nama');
        $data['penanggungjawab_nip'] = $this->input->post('penanggungjawab_nip');
        
        return $this->db->update('spkp_pjas_form_a014b',$data, array('id'=>$id));
    }
    
    function delete_form($id){
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a014b');
        
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a014b_kegiatan');
        
        return $x;
    }
    
    function get_all_balai(){
        $this->db->order_by('id_balai','asc');
        $query = $this->db->get('mas_balai');
        
        return $query->result();
    }
    
    function json_kegiatan($id){
        $query = "SELECT @i:=@i+1 AS urut, a.* FROM spkp_pjas_form_a014b_kegiatan a WHERE a.id = '$id'";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_kegiatan($id,$kegiatan){
        $query = $this->db->get_where('spkp_pjas_form_a014b_kegiatan', array('id'=>$id,'id_kegiatan'=>$kegiatan),1);
        
        return $query->row_array();
    }
    
    function insert_kegiatan($id){
        $data['id'] = $id;
        $data['id_kegiatan'] = time();
        $data['tanggal'] = $this->input->post('tanggal_kegiatan');
        $data['penerima'] = $this->input->post('penerima');
        $data['distribusi'] = $this->input->post('distribusi');
        $data['produk'] = $this->input->post('produk');
        $data['jumlah'] = $this->input->post('jumlah');
        
        return $this->db->insert('spkp_pjas_form_a014b_kegiatan',$data);
    }
    
    function update_kegiatan($id){
        $data['tanggal'] = $this->input->post('tanggal_kegiatan');
        $data['penerima'] = $this->input->post('penerima');
        $data['distribusi'] = $this->input->post('distribusi');
        $data['produk'] = $this->input->post('produk');
        $data['jumlah'] = $this->input->post('jumlah');
        
        return $this->db->update('spkp_pjas_form_a014b_kegiatan',$data, array('id'=>$id,'id_kegiatan'=>$this->input->post('id_kegiatan')));
    }
    
    function delete_kegiatan($id,$kegiatan){
        $this->db->where(array('id'=>$id,'id_kegiatan'=>$kegiatan));
        return $this->db->delete('spkp_pjas_form_a014b_kegiatan');
    }
    
    function get_balai($balai){
        $query = $this->db->get_where('mas_balai', array('id_balai'=>$balai),1);
        $data = $query->row_array();
        
        return $data['nama_balai'];
    }
    
    function get_all_kegiatan($id){
        $this->db->order_by('id_kegiatan','asc');
        $query = $this->db->get_where('spkp_pjas_form_a014b_kegiatan', array('id'=>$id));
        
        return $query->result();
    }
    
    function del_all_kegiatan($id){
        $this->db->where('id',$id);
        return $this->db->delete('spkp_pjas_form_a014b_kegiatan');
    }
    
    function cek_tanggal($id,$tgl){
        $query = $this->db->get_where('spkp_pjas_form_a014b', array('id'=>$id,'tanggal'=>$tgl),1);
        
        return $query->num_rows();
    }
    
    function insert_import($id,$parent){
        $cek = $this->db->get_where('spkp_pjas_form_a014b_kegiatan', array('id'=>$id));
        $data_cek = $cek->num_rows();
        
        if($data_cek>0){
            $max = $this->db->query("select max(id_kegiatan) as max from spkp_pjas_form_a014b_kegiatan where id = '$id'");
            $data_max = $max->row_array();
            
            $data = $parent;
            $data['id'] = $id;
            $data['id_kegiatan'] = $data_max['max']+1;
            
            $this->db->insert('spkp_pjas_form_a014b_kegiatan',$data);
        }else{
            $data = $parent;
            $data['id'] = $id;
            $data['id_kegiatan'] = time();
            
            $this->db->insert('spkp_pjas_form_a014b_kegiatan',$data);
        }
    }
}
?>