<?php
class spkp_pjas_f01_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_sebar(){
        $query = "SELECT @i:=@i+1 AS urut, id, tanggal, penanggungjawab_nama, penanggungjawab_nip, tmpt
		FROM spkp_pjas_form_pom06 ORDER BY id ASC";
        
        return $this->crud->jqxGrid($query);
    }
    
    function json_target($id){
        $query = "SELECT @i:=@i+1 AS urut,
                id, id_target, nama, alamat, target, produk, jumlah
				FROM spkp_pjas_form_pom06_target WHERE id=$id ORDER BY id_target ASC";
       
       return $this->crud->jqxGrid($query);         
    }
    
    function get_data_row($id){
        $query = $this->db->query("SELECT @i:=@i+1 AS urut, id, tanggal, penanggungjawab_nama, penanggungjawab_nip, tmpt
		FROM spkp_pjas_form_pom06 WHERE id=$id");
        
        return $query->row_array();
    }
    
    function get_data_row_target($id,$id_target){
        $query = $this->db->get_where('spkp_pjas_form_pom06_target', array('id'=>$id,'id_target'=>$id_target),1);
        
        return $query->row_array();    
    }
    
    function insert_sebar(){
		$data['id'] = $this->input->post('id');
        $data['tanggal'] = $this->input->post('tanggal');
        $data['penanggungjawab_nama'] = $this->input->post('penanggungjawab_nama');
        $data['penanggungjawab_nip'] = $this->input->post('penanggungjawab_nip');
        $data['tmpt'] = $this->input->post('tmpt');
        
        $this->db->insert('spkp_pjas_form_pom06',$data);
		
		echo "1_".$this->input->post('id');
    }
    
    function update_sebar(){
		$data['tanggal'] = $this->input->post('tanggal');
        $data['penanggungjawab_nama'] = $this->input->post('penanggungjawab_nama');
        $data['penanggungjawab_nip'] = $this->input->post('penanggungjawab_nip');
		$data['tmpt'] = $this->input->post('tmpt');
        
        return $this->db->update('spkp_pjas_form_pom06',$data,array('id'=>$this->input->post('id')));
    }
    
    function delete_sebar($id){
        $this->db->where('id',$id);
        $x =  $this->db->delete('spkp_pjas_form_pom06');
        
        $this->db->where('id',$id);
        $x =  $this->db->delete('spkp_pjas_form_pom06_target');
        
        return $x;
    }
    
    function get_all_sebar(){
        $this->db->order_by('id','asc');
        $query = $this->db->get('spkp_pjas_form_pom06');
        
        return $query->result();
    }
    
    function insert_target($id){
		$data['id'] = $id;
        $data['id_target'] = time();
        $data['nama'] = $this->input->post('nama');
        $data['alamat'] = $this->input->post('alamat');
        $data['target'] = $this->input->post('target');
        $data['produk'] = $this->input->post('produk');
        $data['jumlah'] = $this->input->post('jumlah');
       
        return $this->db->insert('spkp_pjas_form_pom06_target', $data);
    }
    
    function update_target($id,$id_target){
        $data['id'] = $id;
        $data['id_target'] = $id_target;
        $data['nama'] = $this->input->post('nama');
        $data['alamat'] = $this->input->post('alamat');
        $data['target'] = $this->input->post('target');
        $data['produk'] = $this->input->post('produk');
        $data['jumlah'] = $this->input->post('jumlah');
        
		return $this->db->update('spkp_pjas_form_pom06_target', $data, array('id'=>$id,'id_target'=>$id_target));
    }
    
    function delete_target($id,$id_target){
        $this->db->where(array('id'=>$id,'id_target'=>$id_target));
        return $this->db->delete('spkp_pjas_form_pom06_target');
    }
    
    function del_all_target($id){
        $this->db->where('id',$id);
        return $this->db->delete('spkp_pjas_form_pom06_target');
    }
    
    function cek_tanggal($id,$tgl){
        $query = $this->db->get_where('spkp_pjas_form_pom06', array('id'=>$id,'tanggal'=>$tgl),1);
        
        return $query->num_rows();
    }
    
    function insert_import($id,$parent){
        $cek = $this->db->get_where('spkp_pjas_form_pom06_target', array('id'=>$id));
        $data_cek = $cek->num_rows();
        
        if($data_cek>0){
            $max = $this->db->query("select max(id_target) as max from spkp_pjas_form_pom06_target where id = '$id'");
            $data_max = $max->row_array();
            
            $data = $parent;
            $data['id'] = $id;
            $data['id_target'] = $data_max['max']+1;
            
            $this->db->insert('spkp_pjas_form_pom06_target',$data);
        }else{
            $data = $parent;
            $data['id'] = $id;
            $data['id_target'] = time();
            
            $this->db->insert('spkp_pjas_form_pom06_target',$data);
        }
    }
}
?>