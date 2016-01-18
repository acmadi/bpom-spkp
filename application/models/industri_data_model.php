<?php
class Industri_data_model extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->tabel = "mas_industri";
	}
	
 	function get_industri(){
		$data = array();
		$data['id_industri']="";
		$data['nama_industri']="";

		$this->db->join("app_users_profile","app_users_profile.id_industri=mas_industri.id_industri AND app_users_profile.id='".$this->session->userdata('id')."'","right");
		$query = $this->db->get("mas_industri");
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}


   function insert_entry()
    {
		$data['id_industri']=$this->generate_id();
		$data['nama_industri']=$this->input->post('nama_industri');
		$data['id_status']=$this->input->post('id_status');
		$data['id_jenis']=$this->input->post('id_jenis');
		$data['pimpinan']=$this->input->post('pimpinan');
		$data['jumlah_karyawan']=$this->input->post('jumlah_karyawan');
		$data['investasi']=$this->input->post('investasi');
		$data['mulai_produksi']=$this->input->post('mulai_produksi');
		$data['bidang_usaha']=$this->input->post('bidang_usaha');
		$data['bentuk_usaha']=$this->input->post('bentuk_usaha');
		$data['no_akte_pendirian']=$this->input->post('no_akte_pendirian');
		$data['tgl_akte_pendirian']=$this->input->post('tgl_akte_pendirian');
		$data['npwp']=$this->input->post('npwp');
		$data['no_iui']=$this->input->post('no_iui');
		$data['status']=$this->input->post('status');
		$data['dasar_non_aktif']=$this->input->post('dasar_non_aktif');
		$data['surat_non_aktif']=$this->input->post('surat_non_aktif');
		$data['sebab_non_aktif']=$this->input->post('sebab_non_aktif');
		$data['aset_selain_tanah']=$this->input->post('aset_selain_tanah');
		$data['aset_tanah']=$this->input->post('aset_tanah');
		$data['aset_seluruh']=$this->input->post('aset_seluruh');
		
		if($this->db->insert($this->tabel, $data)){
			$profile['id_industri'] = $data['id_industri'];
			$this->db->update('app_users_profile', $profile, array('id'=>$this->session->userdata('id')));

			return $data['id_industri'];
		}else{
			return 0;
		}
    }

	function generate_id(){
		$id = "I".date('ymd');
		$qid = $this->get_max_id($id);
		$seq = intval($qid["MAX"])+1;
		if($seq<10)
			$id .= "00".$seq;
		else if($seq<100)
			$id .= "0".$seq;
		else if($seq<1000)
			$id .= $seq;
		else
			$id .= "FFF";
			
		return $id;
	}

	function get_max_id($id){
		$query = $this->db->query("SELECT IFNULL(SUBSTR(MAX(id_industri),8),0) AS MAX
									FROM mas_industri
									WHERE id_industri LIKE '%$id%'");
		return $query->row_array();
	}
}