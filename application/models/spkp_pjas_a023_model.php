<?php
class Spkp_pjas_a023_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
	}
	
	function get_all_propinsi(){
        $this->db->order_by('nama_propinsi','asc');
        $query = $this->db->get('mas_propinsi');
        
        return $query->result();
    }
	
	function get_all_balai(){
        $this->db->order_by('nama_balai','asc');
        $query = $this->db->get('mas_balai');
        
        return $query->result();
    }
	
	function json_rekap(){
		$query="SELECT @i:=@i+1 AS urut, a.id, a.id_provinsi, b.nama_propinsi, 
		a.tanggal, a.id_balai, c.nama_balai, a.penanggungjawab_jabatan, a.penanggungjawab_nama, a.penanggungjawab_nip, a.tmpt
		FROM spkp_pjas_form_a023 a
		INNER JOIN mas_propinsi b ON b.id_propinsi=a.id_provinsi
		INNER JOIN mas_balai c ON c.id_balai=a.id_balai ORDER BY tanggal ASC";
		
		return $this->crud->jqxGrid($query);
	}
	
	function insert_rekap(){
		$data['id']=$this->input->post('id');
		$data['id_provinsi']=$this->input->post('id_provinsi');
		$data['tanggal']=$this->input->post('tanggal');
		$data['id_balai']=$this->input->post('id_balai');
		$data['penanggungjawab_jabatan']=$this->input->post('penanggungjawab_jabatan');
		$data['penanggungjawab_nama']=$this->input->post('penanggungjawab_nama');
		$data['penanggungjawab_nip']=str_replace(" ","",$this->input->post('penanggungjawab_nip'));
		$data['tmpt']=$this->input->post('tmpt');
		
		$this->db->insert('spkp_pjas_form_a023',$data);
		echo "1_".$this->input->post('id');
	}
	
	function get_data_rekap($id){
		$query=$this->db->query("SELECT @i:=@i+1 AS urut, a.id, a.id_provinsi, b.nama_propinsi, 
		a.tanggal, a.id_balai, c.nama_balai, a.penanggungjawab_jabatan, a.penanggungjawab_nama, a.penanggungjawab_nip, a.tmpt
		FROM spkp_pjas_form_a023 a
		INNER JOIN mas_propinsi b ON b.id_propinsi=a.id_provinsi
		INNER JOIN mas_balai c ON c.id_balai=a.id_balai ORDER BY tanggal ASC");
		
        return $query->row_array();
	}
	
	function update_rekap(){
		$data['id_provinsi']=$this->input->post('id_provinsi');
		$data['tanggal']=$this->input->post('tanggal');
		$data['id_balai']=$this->input->post('id_balai');
		$data['penanggungjawab_jabatan']=$this->input->post('penanggungjawab_jabatan');
		$data['penanggungjawab_nama']=$this->input->post('penanggungjawab_nama');
		$data['penanggungjawab_nip']=str_replace(" ","",$this->input->post('penanggungjawab_nip'));
		$data['tmpt']=$this->input->post('tmpt');
		
		return $this->db->update('spkp_pjas_form_a023',$data,array('id'=>$this->input->post('id')));
	}
	
	function delete_rekap($id){
		$this->db->where('id',$id);
		$x=$this->db->delete('spkp_pjas_form_a023');
		
		$this->db->where('id',$id);
		$x=$this->db->delete('spkp_pjas_form_a023_sdmi');
				
		return $x;
	}
	
	function json_sdmi($id){
		$query="SELECT @i:=@i+1 AS urut, id, id_sdmi, nama, nisn, intervensi, petugas, institusi, kegiatan
		FROM spkp_pjas_form_a023_sdmi WHERE id=$id ORDER BY id_sdmi ASC";
		
		return $this->crud->jqxGrid($query);
	}
	
	function insert_sdmi(){
		$data['id']=$this->input->post('id');
		$data['id_sdmi']=$this->input->post('id_sdmi');
		$data['nama']=$this->input->post('nama');
		$data['nisn']=$this->input->post('nisn');
		$data['intervensi']=$this->input->post('intervensi');
		$data['petugas']=$this->input->post('petugas');
		$data['institusi']=$this->input->post('institusi');
		$data['kegiatan']=$this->input->post('kegiatan');
		
		$this->db->insert('spkp_pjas_form_a023_sdmi',$data);
	}
	
	function get_data_sdmi($id_sdmi){
		$query = $this->db->get_where('spkp_pjas_form_a023_sdmi', array('id_sdmi'=>$id_sdmi));
        
        return $query->row_array();
	}
	
	function update_sdmi(){
		$data['nama']=$this->input->post('nama');
		$data['nisn']=$this->input->post('nisn');
		$data['intervensi']=$this->input->post('intervensi');
		$data['petugas']=$this->input->post('petugas');
		$data['institusi']=$this->input->post('institusi');
		$data['kegiatan']=$this->input->post('kegiatan');
		
		return $this->db->update('spkp_pjas_form_a023_sdmi',$data,array('id_sdmi'=>$this->input->post('id_sdmi')));
	}
	
	function delete_sdmi($id_sdmi){
		$this->db->where('id_sdmi',$id_sdmi);
		return $this->db->delete('spkp_pjas_form_a023_sdmi');
	}
	
	function json_excel($id){
		$query="SELECT @i:=@i+1 AS urut, a.id, a.id_provinsi, b.nama_propinsi, a.tanggal, a.id_balai, c.nama_balai, a.penanggungjawab_nama, a.penanggungjawab_nip
		FROM spkp_pjas_form_a023 a
		INNER JOIN mas_propinsi b ON b.id_propinsi=a.id_provinsi
		INNER JOIN mas_balai c ON c.id_balai=a.id_balai 
		WHERE a.id=$id ORDER BY tanggal ASC";
		
		return $this->crud->jqxGrid($query);
	}
    
    function del_all_sdmi($id){
        $this->db->where('id',$id);
        return $this->db->delete('spkp_pjas_form_a023_sdmi');
    }
    
    function cek_tanggal($id,$tgl){
        $query = $this->db->get_where('spkp_pjas_form_a023', array('id'=>$id,'tanggal'=>$tgl),1);
        
        return $query->num_rows();
    }
    
    function insert_import($id,$parent){
        $cek = $this->db->get_where('spkp_pjas_form_a023_sdmi', array('id'=>$id));
        $data_cek = $cek->num_rows();
        
        if($data_cek>0){
            $max = $this->db->query("select max(id_sdmi) as max from spkp_pjas_form_a023_sdmi where id = '$id'");
            $data_max = $max->row_array();
            
            $data = $parent;
            $data['id'] = $id;
            $data['id_sdmi'] = $data_max['max']+1;
            
            $this->db->insert('spkp_pjas_form_a023_sdmi',$data);
        }else{
            $data = $parent;
            $data['id'] = $id;
            $data['id_sdmi'] = time();
            
            $this->db->insert('spkp_pjas_form_a023_sdmi',$data);
        }
    }
	
} 

?>