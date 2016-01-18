<?php
class Spkp_absen_tunjangan_model extends CI_Model {
    
    var $tabel = "app_users_profile";
     
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_user($thn,$bln){
		if($bln<10)$bln="0".$bln;
        $query = "SELECT @i:=@i+1 AS urut, app_users_profile.*,SUM(absen_tukin.potong_total) AS potong_total,COUNT(absen_tukin.tgl) AS jml,SUM(IF(absen_tukin.scan_masuk<>'',1,0)) AS scan_masuk,SUM(IF(absen_tukin.terlambat<>'',1,0)) AS terlambat,SUM(IF(absen_tukin.absen='',0,1)) AS absen FROM app_users_profile 
			LEFT JOIN absen_tukin ON absen_tukin.id=app_users_profile.id  AND absen_tukin.tgl LIKE '".$thn."-".$bln."-%'
			WHERE status=1 GROUP BY id ORDER BY id asc";
        
        return $this->crud->jqxGrid($query);
    }
    
    function json_absen($id,$thn,$bln){
		if($bln<10)$bln="0".$bln;
        $query = "SELECT @i:=@i+1 AS urut, a.nip,a.nama,b.* FROM app_users_profile AS a,absen_tukin AS b WHERE a.id=b.id AND a.id='".$id."' AND b.tgl LIKE '".$thn."-".$bln."-%' ORDER BY tgl ASC";
        
        return $this->crud->jqxGrid($query);
    }
        
    function get_user($id){
        $query = $this->db->get_where($this->tabel, array('id'=>$id),1);
        
        return $query->row_array();
    }
    
    function get_potong($id,$thn,$bln){
		if($bln<10)$bln="0".$bln;
        $query = "SELECT SUM(potong_total) as potong_total FROM absen_tukin WHERE id='".$id."' AND tgl LIKE '".$thn."-".$bln."-%'";
		$query = $this->db->query($query);
        
        return $query->row_array();
    }
    
    function doimport_tukin($id,$thn,$bln,$item){
		$BLN = $bln;
		$THN = $thn;
		$err_db=array();
		$err_tgl=array();
		$err_nip=array();
		$ok=0;
		foreach($item as $x=>$y){
	        $dt = $this->get_user($id);
			$data = array();
			$nip = str_replace(" ","",$y['nip']);
			if($dt['nip']==$y['nip']){
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
					$data['potong_terlambat'] = $y['potong_terlambat'];
					$data['potong_pc'] = $y['potong_pc'];
					$data['ket'] = $y['ket'];
					$data['potong_sic'] = $y['potong_sic'];
					$data['potong_total'] = $y['total_potong'];
					if($this->db->update('absen_tukin', $data, array('id'=>$id,'tgl'=>$tgl))){
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
		return $result;
    }
    
    function get_all_jabatan(){
        $this->db->order_by('id_jabatan','asc');
        $query = $this->db->get('mas_jabatan');
        
        return $query->result();
    }
    
    function get_all_gol(){
        $this->db->order_by('id_golongan','asc');
        $query = $this->db->get('mas_golongan');
        
        return $query->result();
    }
    
    function get_all_subdit(){
        $this->db->order_by('id_subdit','asc');
        $query = $this->db->get('mas_subdit');
        
        return $query->result();
    }
    
    function get_agama($id){
        $query = $this->db->get_where('mas_agama', array('id_agama'=>$id),1);
        
        return $query->row_array();
    }
    
    function get_kawin($id){
        $query = $this->db->get_where('mas_status_kawin', array('id_status'=>$id),1);
        
        return $query->row_array();
    }
    
    function get_propinsi($id){
        $query = $this->db->get_where('mas_propinsi', array('id_propinsi'=>$id),1);
        
        return $query->row_array();
    }
    
    function get_kota($id){
        $query = $this->db->get_where('mas_kota', array('id_kota'=>$id),1);
        
        return $query->row_array();
    }
    
    function get_kecamatan($id){
        $query = $this->db->get_where('mas_kecamatan', array('id_kecamatan'=>$id),1);
        
        return $query->row_array();
    }
    
    function get_desa($id){
        $query = $this->db->get_where('mas_desa', array('id_desa'=>$id),1);
        
        return $query->row_array();
    }
    
    function delete_jabatan($id,$id_jabatan){
		$this->db->where(array('id' => $id, 'id_jabatan'=>$id_jabatan));

		return $this->db->delete('pegawai_jabatan');
	}
    
    function get_jabatan($id,$id_jabatan){
        $query = $this->db->get_where('pegawai_jabatan', array('id'=>$id ,'id_jabatan'=>$id_jabatan));
        
        return $query->row_array();
    }
    
    function insert_jabatan($id){
        $data['id'] = $id;
        $data['id_jabatan'] = $this->input->post('id_jabatan');
        $data['id_golruang'] = $this->input->post('id_golruang');
        $data['id_subdit'] = $this->input->post('id_subdit');
        $data['sk_jb_tgl'] = $this->input->post('sk_jb_tgl');
        $data['sk_jb_nomor'] = $this->input->post('sk_jb_nomor');
        $data['sk_jb_pejabat'] = $this->input->post('sk_jb_pejabat');
        $data['uraian'] = $this->input->post('uraian');
        $data['tgl_mulai'] = $this->input->post('tgl_mulai');
        $data['tgl_sampai'] = $this->input->post('tgl_sampai');
        $data['bidang_pakar'] = $this->input->post('bidang_pakar');
        $data['ket'] = $this->input->post('ket');
        
        return $this->db->insert('pegawai_jabatan', $data);
    }
    
    function update_jabatan(){
        $data['id_jabatan'] = $this->input->post('id_jabatan');
        $data['id_golruang'] = $this->input->post('id_golruang');
        $data['id_subdit'] = $this->input->post('id_subdit');
        $data['sk_jb_tgl'] = $this->input->post('sk_jb_tgl');
        $data['sk_jb_nomor'] = $this->input->post('sk_jb_nomor');
        $data['sk_jb_pejabat'] = $this->input->post('sk_jb_pejabat');
        $data['uraian'] = $this->input->post('uraian');
        $data['tgl_mulai'] = $this->input->post('tgl_mulai');
        $data['tgl_sampai'] = $this->input->post('tgl_sampai');
        $data['bidang_pakar'] = $this->input->post('bidang_pakar');
        $data['ket'] = $this->input->post('ket');
        
        return $this->db->update('pegawai_jabatan', $data, array('id'=>$this->input->post('id'),'id_jabatan'=>$this->input->post('id_jabatan_hide')));
    }
    
    function get_pangkat($id,$id_golruang){
        $query = $this->db->get_where('pegawai_pangkat', array('id'=>$id ,'id_golruang'=>$id_golruang));
        
        return $query->row_array();
    }
    
    function delete_pangkat($id,$id_golruang){
		$this->db->where(array('id' => $id, 'id_golruang'=>$id_golruang));

		return $this->db->delete('pegawai_pangkat');
	}
    
    function insert_pangkat($id){
        $data['id'] = $id;
        $data['id_golruang'] = $this->input->post('id_golruang');
        $data['id_subdit'] = $this->input->post('id_subdit_pangkat');
        $data['status'] = $this->input->post('status');
        $data['sk_jb_tgl'] = $this->input->post('sk_jb_tgl_pangkat');
        $data['sk_jb_nomor'] = $this->input->post('sk_jb_nomor');
        $data['sk_jb_pejabat'] = $this->input->post('sk_jb_pejabat');
        $data['nomor_persetujuan'] = $this->input->post('nomor_persetujuan');
        $data['pddk_tertinggi'] = $this->input->post('pddk_tertinggi');
        $data['uraian'] = $this->input->post('uraian');
        $data['tgl_mulai'] = $this->input->post('tgl_mulai_pangkat');
        $data['tgl_sampai'] = $this->input->post('tgl_sampai_pangkat');
        $data['gapok_bulanan'] = $this->input->post('gapok_bulanan');
        $data['ket'] = $this->input->post('ket');
        
        return $this->db->insert('pegawai_pangkat', $data);
    }
    
    function update_pangkat(){
        $data['id_golruang'] = $this->input->post('id_golruang');
        $data['id_subdit'] = $this->input->post('id_subdit_pangkat');
        $data['status'] = $this->input->post('status');
        $data['sk_jb_tgl'] = $this->input->post('sk_jb_tgl_pangkat');
        $data['sk_jb_nomor'] = $this->input->post('sk_jb_nomor');
        $data['sk_jb_pejabat'] = $this->input->post('sk_jb_pejabat');
        $data['nomor_persetujuan'] = $this->input->post('nomor_persetujuan');
        $data['pddk_tertinggi'] = $this->input->post('pddk_tertinggi');
        $data['uraian'] = $this->input->post('uraian');
        $data['tgl_mulai'] = $this->input->post('tgl_mulai_pangkat');
        $data['tgl_sampai'] = $this->input->post('tgl_sampai_pangkat');
        $data['gapok_bulanan'] = $this->input->post('gapok_bulanan');
        $data['ket'] = $this->input->post('ket');
        
        return $this->db->update('pegawai_pangkat', $data, array('id'=>$this->input->post('id'),'id_golruang'=>$this->input->post('id_golruang_hide')));
    }
    
    
}
?>