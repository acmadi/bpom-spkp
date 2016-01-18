<?php
class Spkp_director_history_model extends CI_Model {
    
    var $tabel = "app_users_profile";
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_director(){
        $query = "SELECT @i:=@i+1 AS urut, a.*, CONCAT(b.tgl_mulai, ' <br>s/d<br> ' ,b.tgl_sampai) as masa_jabatan,b.tgl_mulai, b.tgl_sampai,
                c.jabatan, c.golongan, d.nama AS nama_agama FROM app_users_profile a
                INNER JOIN pegawai_jabatan b ON a.id = b.id
                INNER JOIN mas_golongan c ON b.id_golruang = c.id_golongan                
                INNER JOIN mas_agama d ON a.agama = d.id_agama                             
                WHERE a.nip <> '-' AND b.id_jabatan = '1' ORDER BY a.id asc";
        
        return $this->crud->jqxGrid($query);
    }
    
    function json_jabatan($id){
        $query = "SELECT @i:=@i+1 AS urut, a.*, b.nama_jabatan, c.jabatan, c.golongan, 
                  d.ket AS subdit_ket FROM pegawai_jabatan a INNER JOIN mas_jabatan b
                  ON a.id_jabatan = b.id_jabatan
                  INNER JOIN mas_golongan c ON a.id_golruang = c.id_golongan
                  INNER JOIN mas_subdit d ON a.id_subdit = d.id_subdit WHERE a.id = '$id' ORDER BY a.id ASC";
        
        return $this->crud->jqxGrid($query);
    }
    
    function json_pangkat($id){
        $query = "SELECT @i:=@i+1 AS urut, a.*, b.jabatan, b.golongan, c.ket AS subdit_ket FROM pegawai_pangkat a
                INNER JOIN mas_golongan b ON a.id_golruang = b.id_golongan
                INNER JOIN mas_subdit c ON a.id_subdit = c.id_subdit WHERE a.id = '$id' ORDER BY a.id ASC";
        
        return $this->crud->jqxGrid($query);
    }
    
    function json_file($id){
        $query = "SELECT @i:=@i+1 AS urut, FROM_UNIXTIME(a.id,'%Y/%m/%d %T') AS waktu,IF(a.update>1, 
                FROM_UNIXTIME(a.update,'%Y/%m/%d %T'), 'NULL') AS waktu_update, a.id, a.user, a.uploader, a.update,
                 a.judul, a.keterangan, a.filename, a.filesize, a.status, a.ip, b.username FROM pegawai_direktur_dokumen a
                 INNER JOIN app_users_list b ON a.uploader = b.id  WHERE a.user = '$id'";
        
        return $this->crud->jqxGrid($query);
    }
    
    function update_profile($id,$type,$data){
        $val['nip']=str_replace(" ","",$this->input->post('nip'));
        $val['gelar']=$this->input->post('gelar');
        $val['nama']=$this->input->post('nama');
        $val['id_number']=$this->input->post('id_number');
        $val['birthdate']=$this->input->post('birthdate');
        $val['birthplace']=$this->input->post('birthplace');
        $val['gendre']=$this->input->post('gendre');
        $val['agama']=$this->input->post('agama');
        $val['kepercayaan']=$this->input->post('kepercayaan');
        $val['kawin']=$this->input->post('kawin');
        $val['phone_number']=$this->input->post('phone_number');
        $val['mobile']=$this->input->post('mobile');
        $val['email']=$this->input->post('email');
        
        $val['address']=$this->input->post('address');
        $val['propinsi']=$this->input->post('propinsi');
        $val['kota']=$this->input->post('kota');
        $val['kecamatan']=$this->input->post('kecamatan');
        $val['desa']=$this->input->post('desa');
        
        $val['badan_tinggi']=$this->input->post('badan_tinggi');
        $val['badan_berat']=str_replace('_','',$this->input->post('badan_berat'));
        $val['badan_rambut']=$this->input->post('badan_rambut');
        $val['badan_muka']=$this->input->post('badan_muka');
        $val['badan_kulit']=$this->input->post('badan_kulit');
        $val['badan_khas']=$this->input->post('badan_khas');
        $val['badan_cacat']=$this->input->post('badan_cacat');
        $val['kegemaran']=$this->input->post('kegemaran');
        
        if($type=="1"){
             $val['image'] = $data['file_name'];
        }
       
        return $this->db->update($this->tabel, $val, array('id'=> $id));
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
    
    function get_data_file($id){
		$data = array();

		$this->db->where('id', $id);

		$query = $this->db->get("pegawai_direktur_dokumen");
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

	function doadd_file($upload_data){
		$data['id'] = time();
        $data['user'] = $this->input->post('user');
		$data['uploader'] = $this->session->userdata('id');
		$data['update'] = 0;
		$data['judul'] = $this->input->post('judul');
		$data['keterangan'] = $this->input->post('keterangan');
		$data['status'] = $this->input->post('status');
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		$data['filename'] = $upload_data['file_name'];
		$data['filesize'] = $upload_data['file_size'];
        
		if($this->db->insert('pegawai_direktur_dokumen', $data)){
			return $data['id'];
		}else{
			return false;
		}
	}

	function doedit_file($id,$upload_data=0){
	    $data['user'] = $this->input->post('user');
		$data['uploader'] = $this->session->userdata('id');
		$data['update'] = time();
		$data['judul'] = $this->input->post('judul');
		$data['keterangan'] = $this->input->post('keterangan');
		$data['status'] = $this->input->post('status');
		$data['ip'] = $_SERVER['REMOTE_ADDR'];
		if($upload_data!=0){
			$data['filename'] = $upload_data['file_name'];
			$data['filesize'] = $upload_data['file_size'];
		}
        
		return $this->db->update('pegawai_direktur_dokumen', $data, array('id'=>$id));
	}

	function dodelete_file($id)
	{
		$this->db->where('id', $id);

		return $this->db->delete('pegawai_direktur_dokumen');
	}
}
?>