<?php
class Spkp_personalia_cuti_model extends CI_Model {
    
    var $tabel = "app_users_profile";
     
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_user(){
        $query = "SELECT @i:=@i+1 AS urut, id, username, nip, gelar, nama, id_number, birthdate, birthplace,
                  gendre, agama,kepercayaan, kawin, phone_number, mobile, email, address, propinsi, kota, kecamatan, 
                  desa, badan_tinggi, badan_berat, badan_rambut, badan_muka, badan_kulit, badan_khas, 
                  badan_cacat, kegemaran, image FROM app_users_profile WHERE status=1 ORDER BY id asc";
        
        return $this->crud->jqxGrid($query);
    }
    
    function json_cutibersama(){
        $query = "SELECT @i:=@i+1 AS urut, spkp_cuti_bersama.* FROM spkp_cuti_bersama ORDER BY tgl DESC";
        
        return $this->crud->jqxGrid($query);
    }
    
	function json_sasaran($id){
		$query="SELECT @i:=@i+1 AS urut,FROM_UNIXTIME(pegawai_kp4.id,'%Y/%m/%d %T') AS waktu,IF(pegawai_kp4.update>1, 
				FROM_UNIXTIME(pegawai_kp4.update,'%Y/%m/%d %T'), 'NULL') AS waktu_update, pegawai_kp4.*, app_users_list.username
				FROM pegawai_kp4 
				INNER JOIN app_users_list ON app_users_list.id=pegawai_kp4.uploader WHERE (pegawai_kp4.uid=".$this->session->userdata("id")." || pegawai_kp4.uploader=".$this->session->userdata("id")." || pegawai_kp4.status=1) AND pegawai_kp4.uid=".$id;
		// $data = $this->crud->jqxGrid($query);
		// return ($data);
        return $this->crud->jqxGrid($query);
		
	}

    function get_user($id){
        $query = $this->db->get_where($this->tabel, array('id'=>$id),1);
        
        return $query->row_array();
    }
    
 	function get_data_row($id){
		$data = array();

		$this->db->where('id', $id);

		$query = $this->db->get("spkp_cuti_bersama");
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

	function doadd(){
		$data['id'] = time();
		$data['keterangan'] = $this->input->post('keterangan');
		$data['tgl'] = $this->input->post('tgl');
		$data['status'] = $this->input->post('status');
        
		if($this->db->insert('spkp_cuti_bersama', $data)){
			return $data['id'];
		}else{
			return false;
		}
	}

	function doedit($id){
		$data['keterangan'] = $this->input->post('keterangan');
		$data['tgl'] = $this->input->post('tgl');
 		$data['status'] = $this->input->post('status');
       
		return $this->db->update('spkp_cuti_bersama', $data, array('id'=>$id));
	}

	function dodelete($id)
	{
		$this->db->where('id', $id);

		return $this->db->delete('spkp_cuti_bersama');
	}

}
?>