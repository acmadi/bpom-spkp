<?php
class Admin_master_industri_model extends CI_Model {

    var $tabel    = 'mas_industri';

    function __construct() {
        parent::__construct();
		$this->load->library('encrypt');
    }
    
    function get_count($options=array())
    {
		$this->db->like($options);
        $query = $this->db->get($this->tabel);
		return count($query->result_array());
    }
	
	function get_max_id($id){
		$query = $this->db->query("SELECT IFNULL(SUBSTR(MAX(id_industri),8),0) AS MAX
									FROM mas_industri
									WHERE id_industri LIKE '%$id%'");
		return $query->row_array();
	}

    function get_data($start,$limit,$options=array())
    {
		$this->db->like($options);
        $query = $this->db->get($this->tabel,$limit,$start);
        return $query->result();
    }


 	function get_data_row($id_industri){
		$data = array();
		$options = array('id_industri' => $id_industri);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

   function insert_entry($id)
    {
		$data['id_industri']=$id;
		$data['nama_industri']=$this->input->post('nama_industri');
		$data['propinsi']=$this->input->post('propinsi');
		$data['pimpinan']=$this->input->post('pimpinan');
		//$data['daftar_direksi']=$this->input->post('daftar_direksi');
		$data['bentuk_usaha']=$this->input->post('bentuk_usaha');
		$data['no_akte_pendirian']=$this->input->post('no_akte_pendirian');
		$data['tgl_akte_pendirian']=$this->input->post('tgl_akte_pendirian');
		$data['npwp']=$this->input->post('npwp');
		$data['status']=$this->input->post('status');
		if($data['status']==1){
			$data['dasar_non_aktif'] = 1;
			$data['surat_non_aktif'] = "";
			$data['sebab_non_aktif'] = "";
		}else{
			$data['dasar_non_aktif'] = $this->input->post('dasar_non_aktif');
			$data['surat_non_aktif'] = $this->input->post('surat_non_aktif');
			$data['sebab_non_aktif'] = $this->input->post('sebab_non_aktif');
		}
		$ins = $this->db->insert($this->tabel, $data);
		if($ins){
			$this->db->where(array('id_industri' => $this->input->post('id_industri')));
			$this->db->delete("mas_industri_direksi");
			
			$jmldireksi = $this->input->post('barisDireksi');
			for($c=1;$c<$jmldireksi;$c++){
				$this->db->insert("mas_industri_direksi", array("id_industri"=>$this->input->post('id_industri'),
																"nama_direksi"=>$this->input->post('nama_direksi'.$c),
																"keterangan"=>$this->input->post('keterangan'.$c)));
			}
		}
		return $ins;
    }

    function update_entry($id_industri)
    {
		$data['nama_industri']=$this->input->post('nama_industri');
		$data['propinsi']=$this->input->post('propinsi');
		$data['pimpinan']=$this->input->post('pimpinan');
		$data['daftar_direksi']=$this->input->post('daftar_direksi');
		$data['bentuk_usaha']=$this->input->post('bentuk_usaha');
		$data['no_akte_pendirian']=$this->input->post('no_akte_pendirian');
		$data['tgl_akte_pendirian']=$this->input->post('tgl_akte_pendirian');
		$data['npwp']=$this->input->post('npwp');
        $data['status']=$this->input->post('status');
		if($data['status']==1){
			$data['dasar_non_aktif'] = 1;
			$data['surat_non_aktif'] = "";
			$data['sebab_non_aktif'] = "";
		}else{
			$data['dasar_non_aktif'] = $this->input->post('dasar_non_aktif');
			$data['surat_non_aktif'] = $this->input->post('surat_non_aktif');
			$data['sebab_non_aktif'] = $this->input->post('sebab_non_aktif');
		}
		$upd = $this->db->update($this->tabel, $data, array('id_industri' => $id_industri));
		if($upd){
			$this->db->where(array('id_industri' => $id_industri));
			$this->db->delete("mas_industri_direksi");
			
			$jmldireksi = $this->input->post('barisDireksi');
			for($c=1;$c<$jmldireksi;$c++){
				$this->db->insert("mas_industri_direksi", array("id_industri"=>$id_industri,
																"nama_direksi"=>$this->input->post('nama_direksi'.$c),
																"keterangan"=>$this->input->post('keterangan'.$c)));
			}
		}
		return $upd;
    }
	

	function delete_entry($id_industri)
	{
		$this->db->where(array('id_industri' => $id_industri));

		return $this->db->delete($this->tabel);
	}
	
	function get_list_pabrik($idindustri){
		$sql = "select * from mas_industri_plant where id_industri='$idindustri'";
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
	
	function get_list_kantor($idindustri){
		$sql = "select * from mas_industri_kantor where id_industri='$idindustri'";
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
	
	function get_pabrik($idindustri,$idplant){
		$sql = "select a.*,b.nama_industri from mas_industri_plant a inner join mas_industri b on a.id_industri=b.id_industri where b.id_industri='$idindustri' and id_plant=$idplant";
		$query = $this->db->query($sql);
		
		return $query->row_array();
	}
	
	function get_kantor($idindustri,$idkantor){
		$sql = "select a.*,b.nama_industri from mas_industri_kantor a inner join mas_industri b on a.id_industri=b.id_industri where b.id_industri='$idindustri' and id_kantor=$idkantor";
		$query = $this->db->query($sql);
		
		return $query->row_array();
	}
	
	function update_pabrik($id_industri,$id_plant)
    {
		$data['alamat_pabrik']=$this->input->post('alamat_pabrik');
		$data['telp_plant']=$this->input->post('telp_plant');
		$data['fax_plant']=$this->input->post('fax_plant');
		//$data['penanggungjawab']=$this->input->post('penanggungjawab');
		//$data['pend_penanggungjawab']=$this->input->post('pend_penanggungjawab');
		//$data['stra_penanggungjawab']=$this->input->post('stra_penanggungjawab');
		$data['lokasi']=$this->input->post('lokasi');
		$data['luas_tanah']=$this->input->post('luas_tanah');
        
		$upd = $this->db->update("mas_industri_plant", $data, array('id_industri' => $id_industri, 'id_plant' => $id_plant));
		if($upd){
			$this->db->where(array('id_industri' => $id_industri, 'id_plant' => $id_plant));
			$this->db->delete("mas_industri_plant_jenis");
			
			$jmlJenis = $this->input->post('barisJenis');
			for($c=1;$c<=$jmlJenis;$c++){
				$inputJenis = array('id_industri'=>$id_industri,
									'id_plant'=>$id_plant,
									'id_jenis'=>$this->input->post('jenis'.$c),
									'penanggungjawab'=>$this->input->post('penanggungjawab'.$c),
									'pend_penanggungjawab'=>$this->input->post('pend_penanggungjawab'.$c),
									'stra_penanggungjawab'=>$this->input->post('stra_penanggungjawab'.$c)
									);
				$this->db->insert("mas_industri_plant_jenis", $inputJenis);
			}
			
			$this->db->where(array('id_industri' => $id_industri, 'id_plant' => $id_plant,'no_pemeriksaan'=>null, 'no_evaluasi'=>null));
			$this->db->delete("mas_industri_sediaan");
			
			$jmlSediaan = $this->input->post('barisSediaan');
			for($c=1;$c<=$jmlSediaan;$c++){
				$inputSediaan = array('id_industri'=>$id_industri,
									'id_plant'=>$id_plant,
									'bentuk_sediaan'=>$this->input->post('sediaan'.$c),
									'kap_prod_pertahun'=>$this->input->post('kapasitas'.$c)
									);
				if ($this->input->post('sediaan'.$c))$this->db->insert("mas_industri_sediaan", $inputSediaan);
			}
		}
		return $upd;
    }
	
	function update_kantor($id_industri,$id_kantor)
    {
		$data['alamat_kantor']=$this->input->post('alamat_kantor');
		$data['telp_kantor']=$this->input->post('telp_kantor');
		$data['fax_kantor']=$this->input->post('fax_kantor');
        
		return $this->db->update("mas_industri_kantor", $data, array('id_industri' => $id_industri, 'id_kantor' => $id_kantor));
    }
	
	function get_sediaan_pabrik($id_industri,$id_plant){
		$sql="select a.id_industri,a.id_plant,a.no_form,b.no_pemeriksaan,d.id_sediaan,
						d.kap_prod_pertahun,e.nama_sediaan
				from pip_permohonan a
					inner join pip_pemeriksaan b
						on a.no_form=b.no_form
					inner join pip_analisis_pemeriksaan c
						on b.no_pemeriksaan=c.no_pemeriksaan
						and c.kesimpulan='Rekomendasi'
					inner join pip_pemeriksaan_hasil_sediaan d
						on c.no_pemeriksaan=d.no_pemeriksaan
					left join mas_bentuk_sediaan e
						on d.id_sediaan=e.id_sediaan
				where a.id_industri='$id_industri'
				and a.id_plant=$id_plant";
				
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
	
	function get_sediaan_pabrik2($id_industri,$id_plant,$id_jenis=""){
		$sql="select a.*,b.id_sediaan,b.nama_sediaan,b.id_jenis,c.nama_jenis2
				from mas_industri_sediaan a
					inner join mas_bentuk_sediaan b
						on a.bentuk_sediaan=b.id_sediaan
					left join mas_jenis c
						on b.id_jenis=c.id_jenis
				where a.id_industri='$id_industri'
				and a.id_plant=$id_plant
				order by a.no_pemeriksaan desc,a.id";
		if($id_jenis!=""){
			$sql="select a.*,b.id_sediaan,b.nama_sediaan,b.id_jenis,
					c.no_spd as no_spd_dnh,d.no_spd as no_spd_rip,e.no_spd as no_spd_ahs
				from mas_industri_sediaan a
					inner join mas_bentuk_sediaan b
						on a.bentuk_sediaan=b.id_sediaan
					left join pdb_evaluasi c
						on a.no_evaluasi_dnh=c.no_evaluasi
					left join pdb_evaluasi d
						on a.no_evaluasi_rip=d.no_evaluasi
					left join pdb_evaluasi e
						on a.no_evaluasi_ahs=e.no_evaluasi
				where a.id_industri='$id_industri'
				and a.id_plant=$id_plant
				and b.id_jenis=$id_jenis
				order by a.no_pemeriksaan desc,a.id";
		}
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
	
	function insert_kantor()
    {
		$data['id_industri']=$this->input->post('id_industri');
		$data['id_kantor']=$this->input->post('id_kantor');
		$data['alamat_kantor']=$this->input->post('alamat_kantor');
		$data['telp_kantor']=$this->input->post('telp_kantor');
		$data['fax_kantor']=$this->input->post('fax_kantor');
		
		return $this->db->insert("mas_industri_kantor", $data);
    }
	
	function insert_pabrik()
    {
		$data['id_industri']=$this->input->post('id_industri');
		$data['id_plant']=$this->input->post('id_plant');
		$data['alamat_pabrik']=$this->input->post('alamat_pabrik');
		$data['id_jenis']=$this->input->post('jenis');
		$data['telp_plant']=$this->input->post('telp_plant');
		$data['fax_plant']=$this->input->post('fax_plant');
		//$data['penanggungjawab']=$this->input->post('penanggungjawab');
		//$data['pend_penanggungjawab']=$this->input->post('pend_penanggungjawab');
		//$data['stra_penanggungjawab']=$this->input->post('stra_penanggungjawab');
		$data['lokasi']=$this->input->post('lokasi');
		$data['luas_tanah']=$this->input->post('luas_tanah');
		
		$ins = $this->db->insert("mas_industri_plant", $data);
		if($ins){
			$this->db->where(array('id_industri' => $this->input->post('id_industri'), 'id_plant' => $this->input->post('id_plant')));
			$this->db->delete("mas_industri_plant_jenis");
			
			$jmlJenis = $this->input->post('barisJenis');
			for($c=1;$c<$jmlJenis;$c++){
				$inputJenis = array('id_industri'=>$this->input->post('id_industri'),
									'id_plant'=>$this->input->post('id_plant'),
									'id_jenis'=>$this->input->post('jenis'.$c),
									'penanggungjawab'=>$this->input->post('penanggungjawab'.$c),
									'pend_penanggungjawab'=>$this->input->post('pend_penanggungjawab'.$c),
									'stra_penanggungjawab'=>$this->input->post('stra_penanggungjawab'.$c)
									);
				$this->db->insert("mas_industri_plant_jenis", $inputJenis);
			}
			
			$this->db->where(array('id_industri' => $this->input->post('id_industri'), 'id_plant' => $this->input->post('id_plant'),'no_pemeriksaan'=>null));
			$this->db->delete("mas_industri_sediaan");
			
			$jmlSediaan = $this->input->post('barisSediaan');
			for($c=1;$c<$jmlSediaan;$c++){
				$inputSediaan = array('id_industri'=>$this->input->post('id_industri'),
									'id_plant'=>$this->input->post('id_plant'),
									'bentuk_sediaan'=>$this->input->post('sediaan'.$c),
									'kap_prod_pertahun'=>$this->input->post('kapasitas'.$c)
									);
				$this->db->insert("mas_industri_sediaan", $inputSediaan);
			}
		}
		return $ins;
    }
	
	function get_max_kantor($id_industri){
		$query = $this->db->query("SELECT max(id_kantor) as MAX from mas_industri_kantor where id_industri='$id_industri'");
		return $query->row_array();
	}
	
	function get_max_pabrik($id_industri){
		$query = $this->db->query("SELECT max(id_plant) as MAX from mas_industri_plant where id_industri='$id_industri'");
		return $query->row_array();
	}
	
	function get_pabrik_jenis($id_industri,$id_plant){
		$sql = "select * from mas_industri_plant_jenis where id_industri='$id_industri' and id_plant=$id_plant";
		
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
	
	function get_pabrik_direksi($id_industri){
		$sql = "select * from mas_industri_direksi where id_industri='$id_industri' order by id";
		
		$query = $this->db->query($sql);
		
		return $query->result_array();
	}
}