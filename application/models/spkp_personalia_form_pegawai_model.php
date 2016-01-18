<?php
class Spkp_personalia_form_pegawai_model extends CI_Model {
    
    var $tabel = "app_users_profile";
     
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_user(){
        $back = date('Y')-1;
        $now = date('Y');
        
        $query = "SELECT DISTINCT(a.id), @i:=@i+1 AS urut, a.nama, a.nip,

                (SELECT SUM(jml) FROM pegawai_izincuti WHERE hitungan = 'hari' AND status_approve = '1'
                AND status_kirim = '1' AND tipe = 'cuti' AND kode = 'ct' AND uid = a.id AND SUBSTR(stat_tgl,1,4) = '$back') AS hari_back,
                
		        (SELECT COUNT(id) FROM spkp_cuti_bersama WHERE SUBSTR(tgl,1,4) = '$back' AND STATUS = 'Cuti Bersama') AS cb_back,		
                
                (SELECT SUM(jml) FROM pegawai_izincuti WHERE hitungan = 'hari' AND status_approve = '1'
                AND status_kirim = '1' AND tipe = 'cuti' AND kode = 'ct' AND uid = a.id AND SUBSTR(stat_tgl,1,4) = '$now') AS hari_now,
                
                (SELECT COUNT(id) FROM spkp_cuti_bersama WHERE SUBSTR(tgl,1,4) = '$now' AND STATUS = 'Cuti Bersama') AS cb_now
                
                FROM app_users_profile a LEFT JOIN pegawai_izincuti b ON a.id = b.uid
                WHERE a.status=1";
        
        return $this->crud->jqxGrid($query);
    }
    
    function json_cutibersama(){
        $query = "SELECT @i:=@i+1 AS urut, spkp_cuti_bersama.* FROM spkp_cuti_bersama ORDER BY tgl DESC";
        
        return $this->crud->jqxGrid($query);
    }
    
	function json_izincuti($id,$thn){
		$query="SELECT @i:=@i+1 AS urut, a.id, a.kode, a.tgl, a.uid AS user_id, a.stat_tgl, a.jml, a.hitungan, a.alasan, a.status_approve, a.status_kirim, b.keterangan,
                IF(a.status_approve='0','Tidak','Ya') AS approve, IF(a.status_kirim='0','Tidak','Ya') AS STATUS
                FROM pegawai_izincuti a INNER JOIN mas_izincuti b ON a.kode = b.kode
                WHERE a.uid = '$id' AND SUBSTR(a.tgl,1,4) = '$thn'";
		$data = $this->crud->jqxGrid($query);
		return ($data);
	}
    
    function json_cuti_dokumen($id){
        $query = "SELECT @i:=@i+1 AS urut, FROM_UNIXTIME(a.id_doc,'%Y/%m/%d %T') AS waktu, a.* FROM pegawai_izincuti_dokumen a WHERE a.id = '$id'";
        
        $data = $this->crud->jqxGrid($query);
		return ($data);
    }

    function get_user($id){
        $query = $this->db->get_where($this->tabel, array('id'=>$id),1);
        
        return $query->row_array();
    }

	function get_izincuti($kode=""){
		$data = array();
		$this->db->order_by("keterangan","asc");
		$query = $this->db->get("mas_izincuti");

		$html = "<select id='kode' name='kode' style='width:250px'>";
		foreach($query->result() as $row){
			$html .= "<option value=".$row->kode." ".($kode==$row->kode ? "selected" : "" ).">".$row->keterangan."</option>";
		}
		return $html."</select>";
	}
    
 	function get_data_row($id){
		$data = array();

		$this->db->where('id', $id);

		$query = $this->db->get("pegawai_izincuti");
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

	function doadd($uid){
		$kode = $this->input->post('kode');
        
        $data['id'] = time();
		$data['uid'] = $uid;
		$data['alasan'] = $this->input->post('alasan');
		$data['tgl'] = $this->input->post('tgl');
		$data['kode'] = $kode;
		$data['tahun'] = substr($this->input->post('tgl'),0,4);
        
        $arr_kode = array("cp","cl","ct","sk");
        if(in_array($kode,$arr_kode)){
            $data['tipe'] = "cuti";
        }else{
            $data['tipe'] = "izin";
        }
        
		if($this->db->insert('pegawai_izincuti', $data)){
			return $data['id'];
		}else{
			return false;
		}
	}

	function doedit($id){
		$data['alasan'] = $this->input->post('alasan');
		$data['tgl'] = $this->input->post('tgl');
		$data['kode'] = $this->input->post('kode');
 		$data['tahun'] = substr($this->input->post('tgl'),0,4);
      
		return $this->db->update('pegawai_izincuti', $data, array('id'=>$id));
	}

	function dodelete($id){
		$this->db->where('id', $id);
        return $this->db->delete('pegawai_izincuti');
	}
    
    function cek_user($uid){
        $query = $this->db->get_where('app_users_profile', array('id'=>$uid),1);
        
        return $query->num_rows();
    }
    
    function cek_izin($id){
        $query = $this->db->get_where('pegawai_izincuti', array('id'=>$id),1);
        
        return $query->num_rows();
    }
    
    function get_posisi($uid){
        $query = $this->db->query("SELECT a.id, a.id_golruang, b.jabatan, b.golongan, c.nama_jabatan, d.ket
                                    FROM pegawai_jabatan a INNER JOIN mas_golongan b
                                    ON a.id_golruang = b.id_golongan INNER JOIN mas_jabatan c
                                    ON a.id_jabatan = c.id_jabatan INNER JOIN mas_subdit d
                                    ON a.id_subdit = d.id_subdit WHERE a.id = '$uid'");
        
        return $query->row_array();
    }
    
    function get_count_bln_thn($id){
        $query = $this->db->query("SELECT COUNT(*) AS jml FROM pegawai_izincuti_tgl WHERE id = '$id'");
        $data = $query->row_array();
        
        return $data['jml'];
    }
    
    function update_jml_bln_thn($id,$count){
        $data['jml_bln_thn'] = $count;
        return $this->db->update('pegawai_izincuti', $data, array('id'=>$id));
    }
    
    function save_form($id,$kode){
        if($kode=="cl"){
            $data['jml'] = $this->input->post('jml');
            $data['hitungan'] = $this->input->post('hitungan');
            $data['stat_tgl'] = $this->input->post('stat_tgl');
            $data['alasan_tambahan'] = $this->input->post('alasan_tambahan');
            $data['alamat'] = $this->input->post('alamat');
            
            if($this->input->post('hitungan')=='bulan' || $this->input->post('hitungan')=='tahun'){
                $data['jml_bln_thn'] = 0;
            }
        }else if($kode=="cp"){
            $data['jml'] = $this->input->post('jml');
            $data['stat_tgl'] = $this->input->post('stat_tgl');
            $data['alasan_tambahan'] = $this->input->post('alasan_tambahan');
            $data['alamat'] = $this->input->post('alamat');
        }else if($kode=="sk"){
            $data['jml'] = $this->input->post('jml');
            $data['stat_tgl'] = $this->input->post('stat_tgl');
            $data['hitungan'] = $this->input->post('hitungan');
            $data['stat_sakit'] = $this->input->post('stat_sakit');
            $data['stat_lampiran'] = $this->input->post('stat_lampiran');
            
            if($this->input->post('hitungan')=='bulan' || $this->input->post('hitungan')=='tahun'){
                $data['jml_bln_thn'] = 0;
            }
        }else if($kode=="ct"){
            $data['stat_thnkerja'] = $this->input->post('stat_thnkerja');
            $data['jml'] = $this->input->post('jml');
            $data['stat_tgl'] = $this->input->post('stat_tgl');
            $data['alamat'] = $this->input->post('alamat');
        }else if($kode=="icb"){
            $data['jml'] = $this->input->post('jml');
            $data['hitungan'] = $this->input->post('hitungan');
            $data['stat_thnkerja'] = $this->input->post('stat_thnkerja');
            $data['stat_tgl'] = $this->input->post('stat_tgl');
            $data['alamat'] = $this->input->post('alamat');
            
            if($this->input->post('hitungan')=='bulan' || $this->input->post('hitungan')=='tahun'){
                $data['jml_bln_thn'] = 0;
            }
        }else if($kode=="itm"){
            $data['stat_tm'] = $this->input->post('stat_tm');
            $data['stat_tgl'] = $this->input->post('stat_tgl');
            $data['stat_tm_jam'] = $this->input->post('stat_tm_jam');
            $data['stat_tm_alasan_kondisi'] = $this->input->post('stat_tm_alasan_kondisi');
            $data['stat_tm_alasan_perlu']   = $this->input->post('stat_tm_alasan_perlu');
        }else if($kode=="itk"){
            $data['jml'] = $this->input->post('jml');
            $data['stat_tgl'] = $this->input->post('stat_tgl');
        }
        
        return $this->db->update('pegawai_izincuti', $data, array('id'=>$id));
    }
    
    function update_status_kirim($id){
        $data['status_kirim'] = 1;
        return $this->db->update('pegawai_izincuti', $data, array('id'=>$id));
    }
    
    function get_all_holiday(){
        $this->db->order_by('tgl','asc');
        $query = $this->db->get('spkp_cuti_bersama');
        
        return $query->result();
    }
    
    function insert_tgl_cuti($id,$tgl){
        $data['id'] = $id;
        $data['tgl'] = $tgl;
        
        return $this->db->insert('pegawai_izincuti_tgl',$data);
    }
    
    function get_max_tgl($id){
        $this->db->order_by('tgl','desc');
        $query = $this->db->get_where('pegawai_izincuti_tgl', array('id'=>$id),1);
        
        return $query->row_array();
    }
    
    function get_form_cuti($id){
        $query = $this->db->query("SELECT b.keterangan FROM pegawai_izincuti a
                                    INNER JOIN mas_izincuti b ON a.kode = b.kode
                                    WHERE a.id = '$id'");
        
        return $query->row_array();
    }
    
    function get_data_dokumen($id,$doc){
        $query = $this->db->get_where('pegawai_izincuti_dokumen', array('id'=>$id,'id_doc'=>$doc));
        
        return $query->row_array();
    }
    
    function doadd_dokumen($id,$upload_data){
		$data['id'] = $id;
        $data['id_doc'] = time();
		$data['uploader'] = $this->session->userdata('id');
		$data['update'] = 0;
		$data['judul'] = $this->input->post('judul');
		$data['ket'] = $this->input->post('ket');
		$data['filename'] = $upload_data['file_name'];
		$data['filesize'] = $upload_data['file_size'];
        
		if($this->db->insert('pegawai_izincuti_dokumen', $data)){
			return $data['id_doc'];
		}else{
			return false;
		}
	}

	function doedit_dokumen($id,$id_doc,$upload_data=0){
		$data['uploader'] = $this->session->userdata('id');
		$data['update'] = time();
		$data['judul'] = $this->input->post('judul');
		$data['ket'] = $this->input->post('ket');
		if($upload_data!=0){
			$data['filename'] = $upload_data['file_name'];
			$data['filesize'] = $upload_data['file_size'];
		}
        
		return $this->db->update('pegawai_izincuti_dokumen', $data, array('id'=>$id,'id_doc'=>$id_doc));
	}

	function dodelete_dokumen($id,$id_doc)
	{
		$this->db->where(array('id'=>$id,'id_doc'=>$id_doc));

		return $this->db->delete('pegawai_izincuti_dokumen');
	}
    
    function approve_status($id,$status){
        $data['status_approve'] = $status;
        
        return $this->db->update('pegawai_izincuti', $data, array('id'=>$id));
    }
    
    function cek_cuti_back($id,$thn){       
        $query = $this->db->query("SELECT SUM(jml) AS jml FROM pegawai_izincuti WHERE hitungan = 'hari' AND status_approve = '1'
                                   AND status_kirim = '1' AND tipe = 'cuti' AND uid = '$id' AND SUBSTR(stat_tgl,1,4) = '$thn'");
        $data = $query->row_array();
        
        return $data['jml'];
    }
    
    function insert_cuti_bersama(){
        $data['id'] = time();
        $data['tgl'] = $this->input->post('tgl');
        $data['status'] = $this->input->post('status');
        $data['keterangan'] = $this->input->post('keterangan');
        
        return $this->db->insert('spkp_cuti_bersama',$data); 
    }
    
    function update_cuti_bersama($id){
        $data['tgl'] = $this->input->post('tgl');
        $data['status'] = $this->input->post('status');
        $data['keterangan'] = $this->input->post('keterangan');
        
        return $this->db->update('spkp_cuti_bersama',$data, array('id'=>$id)); 
    }
    
    function delete_cuti_bersama($id){
        $this->db->where('id',$id);
        return $this->db->delete('spkp_cuti_bersama');
    }
    
    function get_cuti_bersama($id){
        $query = $this->db->get_where('spkp_cuti_bersama', array('id'=>$id),1);
        
        return $query->row_array();
    }
    
    function get_taken_cuti($uid,$thn){
        $query = $this->db->query("SELECT SUM(jml) AS jml FROM pegawai_izincuti WHERE kode = 'ct' AND SUBSTR(stat_tgl,1,4) = '$thn'
                                   AND hitungan = 'hari' AND status_approve = '1' AND status_kirim = '1' AND tipe = 'cuti' and uid='$uid'");
        $data = $query->row_array();
        
        return $data['jml'];
    }
    
    function get_sisa_cuti($uid,$thn){
        $query = $this->db->query("SELECT SUM(jml) AS jml,
                                (SELECT COUNT(id) FROM spkp_cuti_bersama WHERE SUBSTR(tgl,1,4) = '$thn' AND STATUS = 'Cuti Bersama') AS cb_back		
                                FROM pegawai_izincuti WHERE kode = 'ct' AND SUBSTR(stat_tgl,1,4) = '$thn'
                                AND hitungan = 'hari' AND status_approve = '1' AND status_kirim = '1' AND tipe = 'cuti' AND uid = '$uid'");
                                
        return $query->row_array();
    }
}
?>