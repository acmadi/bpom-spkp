<?php
class Spkp_personalia_jadwal_kegiatan_model extends CI_Model {
    
    var $tabel = "app_users_profile";
     
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_jadwal($thn="",$bln=""){
		if($bln<10)$bln="0".$bln;
		$tgl = $thn."-".$bln;

        $query = "SELECT @i:=@i+1 AS urut, app_users_profile.id, nama,
			GROUP_CONCAT(CONCAT(pegawai_jadwal.tgl,'__',IF(pegawai_jadwal.tempat='','-',pegawai_jadwal.tempat),'__',IF(spkp_kegiatan.kode='','-',spkp_kegiatan.kode),'__#',spkp_kegiatan.bgcolor,'__#',spkp_kegiatan.fontcolor)) as JADWAL
		FROM app_users_profile 
		LEFT JOIN pegawai_jadwal ON  pegawai_jadwal.id=app_users_profile.id AND pegawai_jadwal.tgl LIKE '".$tgl."-%'
		LEFT JOIN spkp_kegiatan ON  pegawai_jadwal.id_kegiatan=spkp_kegiatan.id
		WHERE app_users_profile.status=1 
		GROUP BY app_users_profile.id
		ORDER BY id asc";

		return $this->crud->jqxGrid($query);
    }
    
    function json_kegiatan_jadwal($id,$bln=""){
        $bln = $bln!="" ? $bln : date("Y-m");
        $query = "SELECT @i:=@i+1 AS urut, pegawai_jadwal.uid as uploader, pegawai_jadwal.*, pegawai_jadwal.tgl as tglstring, spkp_kegiatan.kegiatan,spkp_kegiatan.kode,app_users_profile.username FROM pegawai_jadwal
		INNER JOIN spkp_kegiatan ON spkp_kegiatan.id=pegawai_jadwal.id_kegiatan
		INNER JOIN app_users_profile ON app_users_profile.id=pegawai_jadwal.uid
		WHERE pegawai_jadwal.id='".$id."' AND tgl LIKE '".$bln."%' ORDER BY id DESC";
        
        return $this->crud->jqxGrid($query);
    }
    
    function json_kegiatan($thn=""){
        $thn = $thn!="" ? $thn : date("Y");
        $query = "SELECT @i:=@i+1 AS urut, spkp_kegiatan.*, IF(spkp_kegiatan.status=1,'Show','Hide') as status_show FROM spkp_kegiatan WHERE thn='".$thn."' ORDER BY id DESC";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_user($id){
        $query = $this->db->get_where($this->tabel, array('id'=>$id),1);
        
        return $query->row_array();
    }
    
 	function get_data_row($id){
		$data = array();

		$this->db->where('id', $id);

		$query = $this->db->get("spkp_kegiatan");
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

	function chek_cutibersama($tgl){
		$this->db->where('tgl', $tgl);
		$query = $this->db->get("spkp_cuti_bersama");
		if ($query->num_rows() > 0){
			$data = $query->row_array();
			$status = $data['status']=="Cuti Bersama" ? "cb" : "#";
			return $status;
		}else{
			return "";
		}
	}

	function option_kegiatan($thn,$id_kegiatan=""){
		$this->db->where("thn",$thn);
		$this->db->where("status","1");
		$query = $this->db->get("spkp_kegiatan");
		$html = "<select id='id_kegiatan' name='id_kegiatan' style='width:450px'>";
		foreach($query->result() as $row){
			if($id_kegiatan==$row->id)
				$html .= "<option value=".$row->id." selected>".$row->kegiatan." - ".$row->keterangan."</option>";
			else
				$html .= "<option value=".$row->id.">".$row->kegiatan." - ".$row->keterangan."</option>";
		}
		return $html."</select>";
	}
	
 	function get_data_kegiatan($id){
		$data = array();

		$this->db->where('id', $id);

		$query = $this->db->get("spkp_kegiatan");
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

 	function get_data_jadwal($id,$tgl){
		$data = array();

		$this->db->where('id', $id);
		$this->db->where('tgl', $tgl);

		$query = $this->db->get("pegawai_jadwal");
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

	function doadd_kegiatan(){
		$data['thn'] = $this->input->post('thn');
		$data['kegiatan'] = $this->input->post('kegiatan');
		$data['keterangan'] = $this->input->post('keterangan');
		$data['kode'] = $this->input->post('kode');
		$data['bgcolor'] = $this->input->post('bgcolor');
		$data['fontcolor'] = $this->input->post('fontcolor');
		$data['status'] = $this->input->post('status');
        
		if($id=$this->db->insert('spkp_kegiatan', $data)){
			return $id;
		}else{
			return false;
		}
	}

	function doedit_kegiatan($id){
		$data['thn'] = $this->input->post('thn');
		$data['kegiatan'] = $this->input->post('kegiatan');
		$data['keterangan'] = $this->input->post('keterangan');
		$data['kode'] = $this->input->post('kode');
		$data['bgcolor'] = $this->input->post('bgcolor');
		$data['fontcolor'] = $this->input->post('fontcolor');
		$data['status'] = $this->input->post('status');
        
		return $this->db->update('spkp_kegiatan', $data, array('id'=>$id));
	}

	function dodelete_kegiatan($id)
	{
		$this->db->where('id', $id);

		return $this->db->delete('spkp_kegiatan');
	}

	function doadd_jadwal($id){
		$data['id'] = $id;
		$data['tgl'] = $this->input->post('tgl');
		$this->db->where('id',	$data['id']);
		$this->db->where('tgl', $data['tgl']);
		$query = $this->db->get("pegawai_jadwal");

		if ($query->num_rows() > 0){
			return "Tanggal sudah digunakan";
		}else{
			$data['uid'] = $this->session->userdata('id');
			$data['id_kegiatan'] = $this->input->post('id_kegiatan');
			$data['keterangan'] = $this->input->post('keterangan');
			$data['tempat'] = $this->input->post('tempat');
			$data['status'] = $this->input->post('status');

			if($this->db->insert('pegawai_jadwal', $data)){
				return true;
			}else{
				return false;
			}
		}
	}

	function doedit_jadwal($id,$tgl){
		$data['uid'] = $this->session->userdata('id');
		$data['id_kegiatan'] = $this->input->post('id_kegiatan');
		$data['keterangan'] = $this->input->post('keterangan');
		$data['tempat'] = $this->input->post('tempat');
		$data['status'] = $this->input->post('status');
        
		return $this->db->update('pegawai_jadwal', $data, array('id'=>$id,'tgl'=>$tgl));
	}

	function dodel_jadwal($id,$tgl)
	{
		$this->db->where('id', $id);
		$this->db->where('tgl', $tgl);

		return $this->db->delete('pegawai_jadwal');
	}

}
?>