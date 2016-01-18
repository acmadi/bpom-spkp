<?php
class Spkp_absen_fingerprint_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
    }


	function json(){
		$query="SELECT @i:=@i+1 AS urut,FROM_UNIXTIME(absen_fingerprint.id,'%Y/%m/%d %T') AS waktu,IF(absen_fingerprint.update>1, 
				FROM_UNIXTIME(absen_fingerprint.update,'%Y/%m/%d %T'), 'NULL') AS waktu_update, absen_fingerprint.*, app_users_list.username
				FROM absen_fingerprint 
				INNER JOIN app_users_list ON app_users_list.id=absen_fingerprint.uploader WHERE absen_fingerprint.uploader=".$this->session->userdata("id")." || absen_fingerprint.status=1";
		$data = $this->crud->jqxGrid($query);
		return ($data);
	}

 	function get_data_row($id){
		$data = array();

		$this->db->where('id', $id);

		$query = $this->db->get("absen_fingerprint");
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

	function doadd($upload_data){
		$data['id'] = time();
		$data['uploader'] = $this->session->userdata('id');
		$data['update'] = 0;
		$data['bulan'] = $this->input->post('bulan');
		$data['tahun'] = $this->input->post('tahun');
		$data['keterangan'] = $this->input->post('keterangan');
		$data['status'] = $this->input->post('status');
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		$data['filename'] = $upload_data['file_name'];
		$data['filesize'] = $upload_data['file_size'];
        
		if($this->db->insert('absen_fingerprint', $data)){
			return $data['id'];
		}else{
			return false;
		}
	}

	function doedit($id,$upload_data=0){
		$data['uploader'] = $this->session->userdata('id');
		$data['update'] = time();
		$data['bulan'] = $this->input->post('bulan');
		$data['tahun'] = $this->input->post('tahun');
		$data['keterangan'] = $this->input->post('keterangan');
		$data['status'] = $this->input->post('status');
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		if($upload_data!=0){
			$data['filename'] = $upload_data['file_name'];
			$data['filesize'] = $upload_data['file_size'];
		}
        
		return $this->db->update('absen_fingerprint', $data, array('id'=>$id));
	}

	function dodelete($id)
	{
		$this->db->where('id', $id);

		return $this->db->delete('absen_fingerprint');
	}

 	function collect_nip(){
		$data = array();

		$this->db->group_by('id');
		$query = $this->db->get("app_users_profile");
		if ($query->num_rows() > 0){
			$dt = $query->result_array();
			foreach($dt as $x){
				if($x['nip']!="000000000000000000" && $x['nip']!="-") $data[$x['nip']] = $x['id'];
			}
		}

		$query->free_result();    
		return $data;
	}



    function doimport($id,$item){
		$BLN = $this->input->post('bulan');
		$THN = $this->input->post('tahun');
		$NIP = $this->collect_nip();

		$err_db=array();
		$err_tgl=array();
		$err_nip=array();
		$ok=0;
		$counter=0;
		foreach($item as $x=>$y){
			$counter++;
			$data = array();
			if(isset($NIP[$y['no']])){
				$tgl="";
				$tanggal = explode("/",$y['tanggal']);
				if(count($tanggal)==3){
					$tanggal = explode("/",$y['tanggal']);
				}else{
					$tanggal = explode("-",$y['tanggal']);
				}

				if($tanggal[2]==$THN){
					if($BLN==$tanggal[1]) $tgl = $tanggal[2]."-".$tanggal[1]."-".$tanggal[0];
				}

				if($tanggal[0]==$THN){
					if($BLN==$tanggal[1]) $tgl = $tanggal[0]."-".$tanggal[1]."-".$tanggal[2];
				}

				if($tgl!=""){
					$data['id'] = $NIP[$y['no']];
					$data['tgl'] = $tgl;
					$data['jadwal_kerja'] = str_replace("'","`",$y['jadwal_kerja']);
					$data['jam_masuk'] = $y['jam_masuk'];
					$data['jam_pulang'] = $y['jam_pulang'];
					$data['scan_masuk'] = $y['scan_masuk'];
					$data['scan_pulang'] = $y['scan_pulang'];
					$data['terlambat'] = $y['terlambat'];
					$data['pulang_cepat'] = $y['pulang_cepat'];
					$data['absen'] = $y['absen'];
					$data['lembur'] = $y['lembur'];
					$data['exception'] = $y['exception'];
					if($this->db->replace('absen_tukin', $data)){
						$ok++;
					}else{
						$err_db[]=$counter;
					}
				}else{
					$err_tgl[]=$counter;
				}
			}else{
				$err_nip[]=$counter;
			}
		}
		
		$result = "Good: ".$ok." <br>Error Database: ".count($err_db)."<br>Error Tgl: ".count($err_tgl)."<br>Error NIP: ".count($err_nip)."<br>";
		$this->db->update('absen_fingerprint', array('result'=>$result), array('id'=>$id));
		return $result;
    }
	
}
?>