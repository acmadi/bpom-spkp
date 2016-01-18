<?php
class Spkp_pjas_a002_model extends CI_Model {
    
    var $tabel = "spkp_pjas_form_a002";
	var $tabel_narasumber ="spkp_pjas_form_a002_narasumber";
	var $tabel_peserta="spkp_pjas_form_a002_peserta";
	
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_judul(){
        $query = "SELECT @i:=@i+1 AS urut, id, judul, tempat, tanggal, hasil, penanggungjawab_nama, penanggungjawab_nip, tmpt
		FROM spkp_pjas_form_a002 ORDER BY id asc";
        
        return $this->crud->jqxGrid($query);
    }
	
	function get_judul($id){
        $query = $this->db->query("SELECT @i:=@i+1 AS urut, id, judul, tempat, tanggal, hasil, penanggungjawab_nama, penanggungjawab_nip, tmpt
		FROM spkp_pjas_form_a002 WHERE id=$id ORDER BY id asc");
        
        return $query->row_array();
    }
	
	function insert_judul(){
		$val['id']=$this->input->post('id');
		$val['judul']=$this->input->post('judul');
        $val['tempat']=$this->input->post('tempat');
        $val['tanggal']=$this->input->post('tanggal');
		$val['hasil']=$this->input->post('hasil');
        $val['penanggungjawab_nip']=str_replace(" ","",$this->input->post('penanggungjawab_nip'));
        $val['penanggungjawab_nama']=$this->input->post('penanggungjawab_nama');
        $val['tmpt']=$this->input->post('tmpt');
		
        $this->db->insert('spkp_pjas_form_a002', $val);
		echo "1_".$this->input->post('id');
	}
	
    function update_judul($id){
        $val['judul']=$this->input->post('judul');
        $val['tempat']=$this->input->post('tempat');
        $val['tanggal']=$this->input->post('tanggal');
		$val['hasil']=$this->input->post('hasil');
		$val['penanggungjawab_nip']=str_replace(" ","",$this->input->post('penanggungjawab_nip'));
        $val['penanggungjawab_nama']=$this->input->post('penanggungjawab_nama');
        $val['tmpt']=$this->input->post('tmpt');
		
        return $this->db->update('spkp_pjas_form_a002', $val, array('id'=> $id));
    }
	
	function delete_judul($id){
		$this->db->where('id',$id);
		$x = $this->db->delete('spkp_pjas_form_a002');
		
		$this->db->where('id',$id);
		$x = $this->db->delete('spkp_pjas_form_a002_narasumber');
		
		$this->db->where('id',$id);
		$x = $this->db->delete('spkp_pjas_form_a002_peserta');
		
		return $x;
	}
	
	function select_tanggal($id){
        $sql = "SELECT * FROM mas_jabatan WHERE id_subdit = '".$subdit."'";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$data=array();
		$data['judul']="<option></option>";
        foreach($result as $x=>$y){
			$data['jabatan'].="<option value='".$y['id_jabatan']."' ".($jabatan==$y['id_jabatan'] ? "selected":"").">".$y['nama_jabatan']."</option>";
		}
		
		return $data;
    }
	
    function json_narasumber($id){
        $query = "SELECT @i:=@i+1 AS urut, id, id_narasumber, nama, materi  FROM spkp_pjas_form_a002_narasumber
		WHERE id = '$id' ORDER BY id_narasumber ASC";
        
        return $this->crud->jqxGrid($query);
    }
	
    function get_narasumber($id,$id_narasumber){
        $query = $this->db->get_where('spkp_pjas_form_a002_narasumber', array('id'=>$id,'id_narasumber'=>$id_narasumber),1);
        
        return $query->row_array();
    }
	
	function insert_narasumber($id){
		$val['id']=$id;
		$val['id_narasumber']=time();
        $val['nama']=$this->input->post('nama');
        $val['materi']=$this->input->post('materi');
		
        return $this->db->insert('spkp_pjas_form_a002_narasumber', $val);
	}
	
	function update_narasumber(){
		$id=$this->input->post('id');
		$id_narasumber=$this->input->post('id_narasumber');
        $val['nama']=$this->input->post('nama');
        $val['materi']=$this->input->post('materi');
       
        return $this->db->update('spkp_pjas_form_a002_narasumber', $val, array('id'=> $id,'id_narasumber'=>$id_narasumber));
    }
	
	function delete_narasumber($id,$id_narasumber){
		$this->db->where(array('id'=>$id,'id_narasumber'=>$id_narasumber));
		
		return $this->db->delete('spkp_pjas_form_a002_narasumber');
	}
	
    function json_peserta($id){
        $query = "SELECT @i:=@i+1 AS urut, id, id_peserta, nama, instansi  FROM spkp_pjas_form_a002_peserta
		WHERE id = '$id' ORDER BY id_peserta ASC";
        
        return $this->crud->jqxGrid($query);
    }
    
	function get_peserta($id,$id_peserta){
        $query = $this->db->get_where('spkp_pjas_form_a002_peserta', array('id'=>$id,'id_peserta'=>$id_peserta),1);
        
        return $query->row_array();
    }
	
    function insert_peserta($id){
		$val['id']=$id;
		$val['id_peserta']=time();
        $val['nama']=$this->input->post('nama');
        $val['instansi']=$this->input->post('instansi');
		
        return $this->db->insert('spkp_pjas_form_a002_peserta', $val);
	}
	
	function update_peserta(){
		$id=$this->input->post('id');
		$id_peserta=$this->input->post('id_peserta');
        $val['nama']=$this->input->post('nama');
        $val['instansi']=$this->input->post('instansi');
       
        return $this->db->update('spkp_pjas_form_a002_peserta', $val, array('id'=> $id,'id_peserta'=>$id_peserta));
    }
    
    function delete_peserta($id,$id_peserta){
		$this->db->where(array('id'=>$id, 'id_peserta'=>$id_peserta));

		return $this->db->delete('spkp_pjas_form_a002_peserta');
	}
	
	function count_peserta($id){
		$query= $this->db->query("SELECT COUNT(*) AS jumlah FROM spkp_pjas_form_a002_peserta WHERE id=$id ");
		
		return $query->result();
	}
	
}
?>