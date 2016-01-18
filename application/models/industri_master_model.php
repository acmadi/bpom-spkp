<?php
class Industri_master_model extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->library('encrypt');
		$this->tabel = "mas_industri";
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
			return $data['id_industri'];
		}else{
			return 0;
		}
    }

    function update_entry($id)
    {
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
		$data['aset_selain_tanah']=$this->input->post('aset_selain_tanah');
		$data['aset_tanah']=$this->input->post('aset_tanah');
		$data['aset_seluruh']=$this->input->post('aset_seluruh');
		if($data['status']==1){
			$data['dasar_non_aktif']="";
			$data['surat_non_aktif']="";
			$data['sebab_non_aktif']="";
		}else{
			$data['dasar_non_aktif']=$this->input->post('dasar_non_aktif');
			$data['surat_non_aktif']=$this->input->post('surat_non_aktif');
			$data['sebab_non_aktif']=$this->input->post('sebab_non_aktif');
		}
		
		return $this->db->update($this->tabel, $data, array('id_industri' => $id));
    }
	
	function delete_entry($id)
	{
		$option = array('id_industri' => $id);

		$this->db->where($option);
        $x = $this->db->delete($this->tabel);
        
        $this->db->where($option);
        $x= $this->db->delete('mas_industri_kantor');
        
        $this->db->where($option);
        $x= $this->db->delete('mas_industri_plant');
        
        $this->db->where($option);
        $x= $this->db->delete('mas_industri_plant_jenis');
        
        $this->db->where($option);
        $x= $this->db->delete('mas_industri_sdm');
        
        $this->db->where($option);
        $x= $this->db->delete('mas_industri_sediaan');
        
        $this->db->where($option);
        $x= $this->db->delete('mas_industri_direksi');
        
        $this->db->where($option);
        $x= $this->db->delete('mas_industri_izin');
        
        $this->db->where($option);
        $x= $this->db->delete('mas_industri_fasilitas');
        return $x;
	}

	function delete_entry_pabrik($id,$id_plant)
	{
		$this->db->where(array('id_industri' => $id,'id_plant' => $id_plant));
		$this->db->delete('mas_industri_plant_jenis');

		$this->db->where(array('id_industri' => $id,'id_plant' => $id_plant));
		$this->db->delete('mas_industri_sediaan');

		$this->db->where(array('id_industri' => $id,'id_plant' => $id_plant));

		return $this->db->delete('mas_industri_plant');
	}

	function delete_entry_kantor($id,$id_kantor)
	{
		$this->db->where(array('id_industri' => $id,'id_kantor' => $id_kantor));

		return $this->db->delete('mas_industri_kantor');
	}

	function delete_entry_direksi($id,$id_direksi)
	{
		$this->db->where(array('id_industri' => $id,'id' => $id_direksi));

		return $this->db->delete('mas_industri_direksi');
	}

	function delete_entry_izin($id,$id_izin)
	{
		$this->db->where(array('id_industri' => $id,'id_izin' => $id_izin));

		return $this->db->delete('mas_industri_izin');
	}

	function delete_entry_fasilitas($id_industri,$id_plant,$id_fasilitas)
	{
		$this->db->where(array('id_industri' => $id_industri,'id_fasilitas' => $id_fasilitas,'id_plant' => $id_plant));

		return $this->db->delete('mas_industri_fasilitas');
	}

	function delete_entry_bentuksediaan($id_industri,$id_bentuksediaan,$id_plant)
	{
		$this->db->where(array('id_industri' => $id_industri,'bentuk_sediaan' => $id_bentuksediaan,'id_plant' => $id_plant));

		return $this->db->delete('mas_industri_sediaan');
	}

	function delete_entry_jenis($id_industri,$id_plant,$id_jenis)
	{
		$this->db->where(array('id_industri' => $id_industri,'id_plant' => $id_plant,'id_jenis' => $id_jenis));

		return $this->db->delete('mas_industri_plant_jenis');
	}

	function insert_entry_kantor($id_industri){
		$query = $this->db->query("SELECT MAX(id_kantor) as id_kantor FROM mas_industri_kantor WHERE id_industri='".$id_industri."'");
		if($query->num_rows>0){
			$data = $query->row_array();
			$data['id_kantor']= $data['id_kantor']+1;
		}else{
			$data['id_kantor']=1;
		}


		$data['id_industri']=$id_industri;
		$data['alamat_kantor']=$this->input->post('alamat_kantor');
		$data['telp_kantor']=$this->input->post('telp_kantor');
		$data['fax_kantor']=$this->input->post('fax_kantor');
		$data['jenis_kantor']=$this->input->post('jenis_kantor');
		$data['kodepos']=$this->input->post('kodepos');
		$data['propinsi']=$this->input->post('propinsi');
		$data['kotakab']=$this->input->post('kotakab');
		$data['kecamatan']=$this->input->post('kecamatan');
		$data['desa']=$this->input->post('desa');
		
		if($this->db->insert('mas_industri_kantor', $data)){
			return $data['id_kantor'];
		}else{
			return 0;
		}
	}


	function insert_entry_pabrik($id_industri){
		$query = $this->db->query("SELECT MAX(id_plant) as id_plant FROM mas_industri_plant WHERE id_industri='".$id_industri."'");
		if($query->num_rows>0){
			$data = $query->row_array();
			$data['id_plant']= $data['id_plant']+1;
		}else{
			$data['id_plant']=1;
		}


		$data['id_industri']=$id_industri;
		$data['alamat_pabrik']=$this->input->post('alamat_pabrik');
		$data['telp_plant']=$this->input->post('telp_plant');
		$data['fax_plant']=$this->input->post('fax_plant');
		$data['lokasi']=$this->input->post('lokasi');
		$data['luas_tanah']=$this->input->post('luas_tanah');
		$data['kodepos']=$this->input->post('kodepos');
		$data['propinsi']=$this->input->post('propinsi');
		$data['kotakab']=$this->input->post('kotakab');
		$data['kecamatan']=$this->input->post('kecamatan');
		$data['desa']=$this->input->post('desa');
		
		if($this->db->insert('mas_industri_plant', $data)){
			return $data['id_plant'];
		}else{
			return 0;
		}
	}

	function insert_entry_direksi($id_industri){
		$query = $this->db->query("SELECT MAX(id) as id FROM mas_industri_direksi WHERE id_industri='".$id_industri."'");
		if($query->num_rows>0){
			$data = $query->row_array();
			$data['id']= $data['id']+1;
		}else{
			$data['id']=1;
		}


		$data['id_industri']=$id_industri;
		$data['nama_direksi']=$this->input->post('nama_direksi');
		$data['pendidikan']=$this->input->post('pendidikan');
		$data['keterangan']=$this->input->post('keterangan');
		
		if($this->db->insert('mas_industri_direksi', $data)){
			return $data['id'];
		}else{
			return 0;
		}
	}

	function insert_entry_izin($id_industri){
		$data['id_industri']=$id_industri;
		$data['id_izin']=$this->input->post('id_izin');
		$data['tgl_izin']=$this->input->post('tgl_izin');
		$data['tgl_permohonan']=$this->input->post('tgl_permohonan');
		$data['nomor']=$this->input->post('nomor');
		
		if($this->db->insert('mas_industri_izin', $data)){
			return $data['id_izin'];
		}else{
			return 0;
		}
	}

	function insert_entry_fasilitas($id_industri,$id_plant){
		$data['id_industri']=$id_industri;
		$data['id_plant']=$id_plant;
		$data['id_fasilitas']=$this->input->post('id_fasilitas');
		$data['status']=$this->input->post('status');
		
		if($this->db->insert('mas_industri_fasilitas', $data)){
			return $data['id_fasilitas'];
		}else{
			return 0;
		}
	}
	
	function insert_entry_bentuksediaan($id_industri,$id_plant){
		$data['id_industri']=$id_industri;
		$data['id_plant']=$id_plant;
		$data['bentuk_sediaan']=$this->input->post('bentuk_sediaan');
		$data['kap_prod_pertahun']=$this->input->post('kap_prod_pertahun');
		$data['mesin_peralatan']=$this->input->post('mesin_peralatan');
		$data['rencana_prod']=$this->input->post('rencana_prod');
		$data['no_pemeriksaan']=$this->input->post('no_pemeriksaan');
		$data['no_evaluasi_dnh']=$this->input->post('no_evaluasi_dnh');
		$data['no_evaluasi_rip']=$this->input->post('no_evaluasi_rip');
		$data['no_evaluasi_ahs']=$this->input->post('no_evaluasi_ahs');
		
		if($this->db->insert('mas_industri_sediaan', $data)){
			return $data['bentuk_sediaan'];
		}else{
			return 0;
		}
	}

	function insert_entry_jenis($id_industri,$id_plant){
		$data['id_industri']=$id_industri;
		$data['id_plant']=$id_plant;
		$data['id_jenis']=$this->input->post('id_jenis');
		$data['penanggungjawab']=$this->input->post('penanggungjawab');
		$data['pend_penanggungjawab']=$this->input->post('pend_penanggungjawab');
		$data['stra_penanggungjawab']=$this->input->post('stra_penanggungjawab');
		$data['nomor_sik']=$this->input->post('nomor_sik');
		$data['tgl_sik']=$this->input->post('tgl_sik');
		
		if($this->db->insert('mas_industri_plant_jenis', $data)){
			return 1;
		}else{
			return 0;
		}
	}

	function get_list_industri(){
		$page = $this->input->post('page');
        $rp = $this->input->post('rp');
        $sortname = $this->input->post('sortname');
        $sortorder = $this->input->post('sortorder');
        $qtype = $this->input->post('qtype');
        $qparam = $this->input->post('query');
        $swhere = '';
        if (!$page) $page = 1;
        if (!$rp) $rp = 10;
        if (!$sortname) $sortname = 'id_industri';
        if (!$sortorder) $sortorder = 'asc';
        if (!$qtype) $qtype = 'id_industri';
        if ($qparam) $swhere = ' AND '.$qtype.' LIKE \'%'.$qparam.'%\'';
        $sqlOrder = "ORDER BY $sortname $sortorder";
		$offset = ($page - 1) * $rp;
        
        $sql = "SELECT a.id_industri,a.nama_industri,a.pimpinan,b.nama_bentuk as bentuk_usaha,
					a.no_akte_pendirian,a.tgl_akte_pendirian, c.nama_jenis as id_jenis
				FROM mas_industri a, mas_bentuk_perusahaan b,mas_jenis c WHERE a.bentuk_usaha=b.id AND a.id_jenis=c.id_jenis " . $swhere . $sqlOrder . "
				LIMIT $offset, $rp ";
        
        $query = $this->db->query($sql);
        $return['records'] = $query;
        
        $sqlc = "SELECT COUNT(a.id_industri) AS record_count
				FROM mas_industri a, mas_bentuk_perusahaan b WHERE a.bentuk_usaha=b.id " . $swhere;
				
		$queryc = $this->db->query($sqlc);
		$row = $queryc->row();        
        $return['record_count'] = $row->record_count;
        
        return $return;
	}
	
	function get_list_industri_pabrik($idindustri=0){
		$page = $this->input->post('page');
        $rp = $this->input->post('rp');
        $sortname = $this->input->post('sortname');
        $sortorder = $this->input->post('sortorder');
        $qtype = $this->input->post('qtype');
        $qparam = $this->input->post('query');
        $swhere = '';
        if (!$page) $page = 1;
        if (!$rp) $rp = 10;
        if (!$sortname) $sortname = 'id_plant';
        if (!$sortorder) $sortorder = 'asc';
        if (!$qtype) $qtype = 'id_plant';
        if ($qparam) $swhere = ' AND '.$qtype.' LIKE \'%'.$qparam.'%\'';
        $sqlOrder = "ORDER BY $sortname $sortorder";
		$offset = ($page - 1) * $rp;
        
        $sql = "SELECT * FROM mas_industri_plant WHERE id_industri='".$idindustri."' " . $swhere . $sqlOrder . "
				LIMIT $offset, $rp ";
        
        $query = $this->db->query($sql);
        $return['records'] = $query;
        
        $sqlc = "SELECT COUNT(id_plant) AS record_count
				FROM mas_industri_plant WHERE id_industri='".$idindustri."' " . $swhere;
				
		$queryc = $this->db->query($sqlc);
		$row = $queryc->row();        
        $return['record_count'] = $row->record_count;
        
        return $return;
	}
	
	function get_list_industri_pabrik_jenis($idindustri=0,$id_plant=0){
		$page = $this->input->post('page');
        $rp = $this->input->post('rp');
        $sortname = $this->input->post('sortname');
        $sortorder = $this->input->post('sortorder');
        $qtype = $this->input->post('qtype');
        $qparam = $this->input->post('query');
        $swhere = '';
        if (!$page) $page = 1;
        if (!$rp) $rp = 10;
        if (!$sortname) $sortname = 'id_jenis';
        if (!$sortorder) $sortorder = 'asc';
        if (!$qtype) $qtype = 'id_jenis';
        if ($qparam) $swhere = ' AND '.$qtype.' LIKE \'%'.$qparam.'%\'';
        $sqlOrder = "ORDER BY $sortname $sortorder";
		$offset = ($page - 1) * $rp;
        
        $sql = "SELECT A.*,b.nama_jenis2 AS jenis FROM mas_industri_plant_jenis AS A,mas_jenis AS B WHERE A.id_jenis=B.id_jenis AND A.id_industri='".$idindustri."' AND A.id_plant='".$id_plant."' " . $swhere . $sqlOrder . "
				LIMIT $offset, $rp ";
        
        $query = $this->db->query($sql);
        $return['records'] = $query;
        
        $sqlc = "SELECT COUNT(id_plant) AS record_count
				FROM mas_industri_plant_jenis AS A,mas_jenis AS B WHERE A.id_jenis=B.id_jenis AND A.id_industri='".$idindustri."' AND A.id_plant='".$id_plant."' " . $swhere;
				
		$queryc = $this->db->query($sqlc);
		$row = $queryc->row();        
        $return['record_count'] = $row->record_count;
        
        return $return;
	}
	
	function get_list_industri_pabrik_bentuksediaan($idindustri=0){
		$page = $this->input->post('page');
        $rp = $this->input->post('rp');
        $sortname = $this->input->post('sortname');
        $sortorder = $this->input->post('sortorder');
        $qtype = $this->input->post('qtype');
        $qparam = $this->input->post('query');
        $swhere = '';
        if (!$page) $page = 1;
        if (!$rp) $rp = 10;
        if (!$sortname) $sortname = 'a.id_plant';
        if (!$sortorder) $sortorder = 'asc';
        if (!$qtype) $qtype = 'a.id_plant';
        if ($qparam) $swhere = ' AND '.$qtype.' LIKE \'%'.$qparam.'%\'';
        $sqlOrder = "ORDER BY $sortname $sortorder";
		$offset = ($page - 1) * $rp;
        
        $sql = "SELECT @i:=0";
        $query = $this->db->query($sql);

        $sql = "SELECT @i:=@i+1 AS id, a.id_plant as id_plant,a.alamat_pabrik,b.id_jenis,b.penanggungjawab,c.nama_jenis2 AS jenis FROM mas_industri_plant AS a, mas_industri_plant_jenis AS b,mas_jenis AS c 
				WHERE a.id_industri=b.id_industri AND a.id_plant=b.id_plant AND b.id_jenis=c.id_jenis AND a.id_industri='".$idindustri."' " . $swhere . $sqlOrder . "
				LIMIT $offset, $rp ";
        
        $query = $this->db->query($sql);
        $return['records'] = $query;
        
        $sqlc = "SELECT COUNT(a.id_plant) AS record_count
				FROM mas_industri_plant AS a, mas_industri_plant_jenis AS b,mas_jenis AS c 
				WHERE a.id_industri=b.id_industri AND a.id_plant=b.id_plant AND b.id_jenis=c.id_jenis AND a.id_industri='".$idindustri."' " . $swhere;
				
		$queryc = $this->db->query($sqlc);
		$row = $queryc->row();        
        $return['record_count'] = $row->record_count;
        
        return $return;
	}

	function get_industri_pabrik_bentuksediaan($id_industri,$id_plant,$id_jenis){
		$data = array();
		$this->db->select('`mas_bentuk_sediaan`.`nama_sediaan`');
		$this->db->where('id_industri' , $id_industri);
		$this->db->where('id_plant' , $id_plant);
		$this->db->join('mas_bentuk_sediaan' , "mas_bentuk_sediaan.id_sediaan=mas_industri_sediaan.bentuk_sediaan AND mas_bentuk_sediaan.id_jenis='".$id_jenis."'","right");
		$query = $this->db->get('mas_industri_sediaan');
		if ($query->num_rows() > 0){
			$data['sediaan']="";
			$data['jml']=0;
			$row = $query->result_array();
			foreach($row as $dt){
				if($data['jml']==0){
					$data['sediaan'].= $dt['nama_sediaan'];
				}else{
					$data['sediaan'].= ", ".$dt['nama_sediaan'];
				}
				$data['jml']++;
			}
		}

		$query->free_result();    
		return $data;
	
	}
	
	function get_list_industri_kantor($idindustri=0){
		$page = $this->input->post('page');
        $rp = $this->input->post('rp');
        $sortname = $this->input->post('sortname');
        $sortorder = $this->input->post('sortorder');
        $qtype = $this->input->post('qtype');
        $qparam = $this->input->post('query');
        $swhere = '';
        if (!$page) $page = 1;
        if (!$rp) $rp = 10;
        if (!$sortname) $sortname = 'id_kantor';
        if (!$sortorder) $sortorder = 'asc';
        if (!$qtype) $qtype = 'id_kantor';
        if ($qparam) $swhere = ' AND '.$qtype.' LIKE \'%'.$qparam.'%\'';
        $sqlOrder = "ORDER BY $sortname $sortorder";
		$offset = ($page - 1) * $rp;
        
        $sql = "SELECT * FROM mas_industri_kantor WHERE id_industri='".$idindustri."' " . $swhere . $sqlOrder . "
				LIMIT $offset, $rp ";
        
        $query = $this->db->query($sql);
        $return['records'] = $query;
        
        $sqlc = "SELECT COUNT(id_kantor) AS record_count
				FROM mas_industri_kantor WHERE id_industri='".$idindustri."' " . $swhere;
				
		$queryc = $this->db->query($sqlc);
		$row = $queryc->row();        
        $return['record_count'] = $row->record_count;
        
        return $return;
	}

	function get_list_industri_direksi($idindustri=0){
		$page = $this->input->post('page');
        $rp = $this->input->post('rp');
        $sortname = $this->input->post('sortname');
        $sortorder = $this->input->post('sortorder');
        $qtype = $this->input->post('qtype');
        $qparam = $this->input->post('query');
        $swhere = '';
        if (!$page) $page = 1;
        if (!$rp) $rp = 10;
        if (!$sortname) $sortname = 'id';
        if (!$sortorder) $sortorder = 'asc';
        if (!$qtype) $qtype = 'id';
        if ($qparam) $swhere = ' AND '.$qtype.' LIKE \'%'.$qparam.'%\'';
        $sqlOrder = "ORDER BY $sortname $sortorder";
		$offset = ($page - 1) * $rp;
        
        $sql = "SELECT * FROM mas_industri_direksi WHERE id_industri='".$idindustri."' " . $swhere . $sqlOrder . "
				LIMIT $offset, $rp ";
        
        $query = $this->db->query($sql);
        $return['records'] = $query;
        
        $sqlc = "SELECT COUNT(id) AS record_count
				FROM mas_industri_direksi WHERE id_industri='".$idindustri."' " . $swhere;
				
		$queryc = $this->db->query($sqlc);
		$row = $queryc->row();        
        $return['record_count'] = $row->record_count;
        
        return $return;
	
	}

	function get_list_industri_bentuksediaan($idindustri=0,$id_plant,$id_jenis){
		$page = $this->input->post('page');
        $rp = $this->input->post('rp');
        $sortname = $this->input->post('sortname');
        $sortorder = $this->input->post('sortorder');
        $qtype = $this->input->post('qtype');
        $qparam = $this->input->post('query');
        $swhere = '';
        if (!$page) $page = 1;
        if (!$rp) $rp = 10;
        if (!$sortname) $sortname = 'bentuk_sediaan';
        if (!$sortorder) $sortorder = 'asc';
        if (!$qtype) $qtype = 'bentuk_sediaan';
        if ($qparam) $swhere = ' AND '.$qtype.' LIKE \'%'.$qparam.'%\'';
        $sqlOrder = "ORDER BY $sortname $sortorder";
		$offset = ($page - 1) * $rp;
        
        $sql = "SELECT a.*,b.nama_sediaan AS nama_sediaan,c.alamat_pabrik FROM mas_industri_sediaan AS a, mas_bentuk_sediaan AS b, mas_industri_plant AS c, mas_jenis AS d WHERE a.bentuk_sediaan=b.id_sediaan AND a.id_plant=c.id_plant AND a.id_industri=c.id_industri AND d.id_jenis=b.id_jenis AND a.id_industri='".$idindustri."' AND a.id_plant='".$id_plant."' AND d.id_jenis='".$id_jenis."' " . $swhere . $sqlOrder . "
				LIMIT $offset, $rp ";
        
        $query = $this->db->query($sql);
        $return['records'] = $query;
        
        $sqlc = "SELECT COUNT(bentuk_sediaan) AS record_count
				FROM mas_industri_sediaan AS a, mas_bentuk_sediaan AS b, mas_industri_plant AS c, mas_jenis AS d WHERE a.bentuk_sediaan=b.id_sediaan AND a.id_plant=c.id_plant AND a.id_industri=c.id_industri AND d.id_jenis=b.id_jenis AND a.id_industri='".$idindustri."' AND a.id_plant='".$id_plant."' AND d.id_jenis='".$id_jenis."' " . $swhere;
				
		$queryc = $this->db->query($sqlc);
		$row = $queryc->row();        
        $return['record_count'] = $row->record_count;
        
        return $return;
	
	}

	function get_list_industri_izin($idindustri=0){
		$page = $this->input->post('page');
        $rp = $this->input->post('rp');
        $sortname = $this->input->post('sortname');
        $sortorder = $this->input->post('sortorder');
        $qtype = $this->input->post('qtype');
        $qparam = $this->input->post('query');
        $swhere = '';
        if (!$page) $page = 1;
        if (!$rp) $rp = 10;
        if (!$sortname) $sortname = 'id_izin';
        if (!$sortorder) $sortorder = 'asc';
        if (!$qtype) $qtype = 'id_izin';
        if ($qparam) $swhere = ' AND '.$qtype.' LIKE \'%'.$qparam.'%\'';
        $sqlOrder = "ORDER BY $sortname $sortorder";
		$offset = ($page - 1) * $rp;
        
        $sql = "SELECT a.*,CONCAT(b.jenis,': ',b.nama) AS nama_izin FROM mas_industri_izin AS a,mas_izin AS b WHERE a.id_izin=b.id_izin AND a.id_industri='".$idindustri."' " . $swhere . $sqlOrder . "
				LIMIT $offset, $rp ";
        
        $query = $this->db->query($sql);
        $return['records'] = $query;
        
        $sqlc = "SELECT COUNT(a.id_izin) AS record_count
				FROM mas_industri_izin AS a,mas_izin AS b WHERE a.id_izin=b.id_izin AND a.id_industri='".$idindustri."' " . $swhere;
				
		$queryc = $this->db->query($sqlc);
		$row = $queryc->row();        
        $return['record_count'] = $row->record_count;
        
        return $return;
	
	}

	function get_list_industri_pabrik_fasilitas($idindustri=0,$idplant=0){
		$page = $this->input->post('page');
        $rp = $this->input->post('rp');
        $sortname = $this->input->post('sortname');
        $sortorder = $this->input->post('sortorder');
        $qtype = $this->input->post('qtype');
        $qparam = $this->input->post('query');
        $swhere = '';
        if (!$page) $page = 1;
        if (!$rp) $rp = 10;
        if (!$sortname) $sortname = 'id_fasilitas';
        if (!$sortorder) $sortorder = 'asc';
        if (!$qtype) $qtype = 'id_fasilitas';
        if ($qparam) $swhere = ' AND '.$qtype.' LIKE \'%'.$qparam.'%\'';
        $sqlOrder = "ORDER BY $sortname $sortorder";
		$offset = ($page - 1) * $rp;
        
        $sql = "SELECT a.id_industri,a.id_plant,a.id_fasilitas,if(a.status=1,'Ada','Tidak Ada') as status,b.nama_fasilitas FROM mas_industri_fasilitas AS a,mas_fasilitas AS b WHERE a.id_fasilitas=b.id_fasilitas AND a.id_industri='".$idindustri."' AND a.id_plant='".$idplant."' " . $swhere . $sqlOrder . "
				LIMIT $offset, $rp ";
        
        $query = $this->db->query($sql);
        $return['records'] = $query;
        
        $sqlc = "SELECT COUNT(a.id_fasilitas) AS record_count
				FROM mas_industri_fasilitas AS a,mas_fasilitas AS b WHERE a.id_fasilitas=b.id_fasilitas AND a.id_industri='".$idindustri."' AND a.id_plant='".$idplant."' " . $swhere;
				
		$queryc = $this->db->query($sqlc);
		$row = $queryc->row();        
        $return['record_count'] = $row->record_count;
        
        return $return;
	
	}

	function get_daftar_industri_cetak(){
		$sql = "SELECT a.id_industri,a.nama_industri,a.pimpinan,b.nama_bentuk as bentuk_usaha,
					a.no_akte_pendirian,a.tgl_akte_pendirian, c.nama_jenis as id_jenis
				FROM mas_industri a, mas_bentuk_perusahaan b,mas_jenis c WHERE a.bentuk_usaha=b.id AND a.id_jenis=c.id_jenis";
        
        $query = $this->db->query($sql);
        return $query;
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
		$sql = "select a.*,b.nama_industri,mas_propinsi.nama_propinsi,mas_kota.nama_kota from mas_industri_plant a 
			inner join mas_industri b on a.id_industri=b.id_industri 
			LEFT JOIN mas_kota ON mas_kota.id_kota=a.kotakab
			LEFT JOIN mas_propinsi ON mas_propinsi.id_propinsi=a.propinsi
			where b.id_industri='$idindustri' and id_plant=$idplant";
		$query = $this->db->query($sql);
		
		return $query->row_array();
	}

	function get_mas_jenis($id_jenis){
		$this->db->where(array('id_jenis' => $id_jenis));
		$query = $this->db->get('mas_jenis');
		return $query->row_array();
	}

	function get_fasilitas($id_industri,$id_plant,$id_fasilitas){
		$sql = "SELECT * FROM mas_industri_fasilitas WHERE id_industri='".$id_industri."' AND id_plant='".$id_plant."' AND id_fasilitas='".$id_fasilitas."'";
		$query = $this->db->query($sql);
		
		return $query->row_array();
	}

	function get_jenis($id_industri,$id_plant,$id_jenis){
		$sql = "SELECT * FROM mas_industri_plant_jenis WHERE id_industri='".$id_industri."' AND id_plant='".$id_plant."' AND id_jenis='".$id_jenis."'";
		$query = $this->db->query($sql);
		
		return $query->row_array();
	}

	function get_kantor($idindustri,$idkantor){
		$sql = "select a.*,b.nama_industri from mas_industri_kantor a inner join mas_industri b on a.id_industri=b.id_industri where b.id_industri='$idindustri' and id_kantor=$idkantor";
		$query = $this->db->query($sql);
		
		return $query->row_array();
	}

	function get_direksi($idindustri,$id){
		$sql = "select *,id as id_direksi FROM mas_industri_direksi where id_industri='$idindustri' and id=$id";
		$query = $this->db->query($sql);
		
		return $query->row_array();
	}
	
	function get_bentuksediaan($idindustri,$bentuk_sediaan,$id_plant){
		$sql = "select * FROM mas_industri_sediaan where id_industri='".$idindustri."' AND bentuk_sediaan='".$bentuk_sediaan."' AND id_plant='".$id_plant."'";
		$query = $this->db->query($sql);
		
		return $query->row_array();
	}
	
	function get_izin($idindustri,$id){
		$sql = "select * FROM mas_industri_izin where id_industri='$idindustri' and id_izin=$id";
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
	
	function update_entry_kantor($id_industri,$id_kantor)
    {
		$data['alamat_kantor']=$this->input->post('alamat_kantor');
		$data['telp_kantor']=$this->input->post('telp_kantor');
		$data['fax_kantor']=$this->input->post('fax_kantor');
		$data['jenis_kantor']=$this->input->post('jenis_kantor');
		$data['kodepos']=$this->input->post('kodepos');
		$data['propinsi']=$this->input->post('propinsi');
		$data['kotakab']=$this->input->post('kotakab');
		$data['kecamatan']=$this->input->post('kecamatan');
		$data['desa']=$this->input->post('desa');
        
		return $this->db->update("mas_industri_kantor", $data, array('id_industri' => $id_industri, 'id_kantor' => $id_kantor));
    }
	
	function update_entry_pabrik($id_industri,$id_plant)
	{
		$data['alamat_pabrik']=$this->input->post('alamat_pabrik');
		$data['telp_plant']=$this->input->post('telp_plant');
		$data['fax_plant']=$this->input->post('fax_plant');
		$data['lokasi']=$this->input->post('lokasi');
		$data['luas_tanah']=$this->input->post('luas_tanah');
		$data['kodepos']=$this->input->post('kodepos');
		$data['propinsi']=$this->input->post('propinsi');
		$data['kotakab']=$this->input->post('kotakab');
		$data['kecamatan']=$this->input->post('kecamatan');
		$data['desa']=$this->input->post('desa');
		return $this->db->update("mas_industri_plant", $data, array('id_industri' => $id_industri, 'id_plant' => $id_plant));
    }

	function update_entry_direksi($id_industri,$id)
	{
		$data['nama_direksi']=$this->input->post('nama_direksi');
		$data['pendidikan']=$this->input->post('pendidikan');
		$data['keterangan']=$this->input->post('keterangan');
		return $this->db->update("mas_industri_direksi", $data, array('id_industri' => $id_industri, 'id' => $id));
    }

	function update_entry_bentuksediaan($id_industri,$id_plant,$bentuksediaan)
	{
		$data['bentuk_sediaan']=$this->input->post('bentuk_sediaan');
		$data['kap_prod_pertahun']=$this->input->post('kap_prod_pertahun');
		$data['mesin_peralatan']=$this->input->post('mesin_peralatan');
		$data['rencana_prod']=$this->input->post('rencana_prod');
		$data['no_pemeriksaan']=$this->input->post('no_pemeriksaan');
		$data['no_evaluasi_dnh']=$this->input->post('no_evaluasi_dnh');
		$data['no_evaluasi_rip']=$this->input->post('no_evaluasi_rip');
		$data['no_evaluasi_ahs']=$this->input->post('no_evaluasi_ahs');
		
		return $this->db->update("mas_industri_sediaan", $data, array('id_industri' => $id_industri, 'bentuk_sediaan' => $bentuksediaan, 'id_plant' => $id_plant));
	}

	function update_entry_izin($id_industri,$id)
	{
		$data['id_izin']=$this->input->post('id_izin');
		$data['tgl_izin']=$this->input->post('tgl_izin');
		$data['tgl_permohonan']=$this->input->post('tgl_permohonan');
		$data['nomor']=$this->input->post('nomor');
		return $this->db->update("mas_industri_izin", $data, array('id_industri' => $id_industri, 'id_izin' => $id));
    }

	function update_entry_jenis($id_industri,$id_plant,$id_jenis)
	{
		$data['id_jenis']=$this->input->post('id_jenis');
		$data['penanggungjawab']=$this->input->post('penanggungjawab');
		$data['pend_penanggungjawab']=$this->input->post('pend_penanggungjawab');
		$data['stra_penanggungjawab']=$this->input->post('stra_penanggungjawab');
		$data['nomor_sik']=$this->input->post('nomor_sik');
		$data['tgl_sik']=$this->input->post('tgl_sik');

		return $this->db->update("mas_industri_plant_jenis", $data, array('id_industri' => $id_industri, 'id_plant' => $id_plant, 'id_jenis' => $id_jenis));
    }

	function update_entry_fasilitas($id_industri,$id_plant,$id_fasilitas)
	{
		$data['id_fasilitas']=$this->input->post('id_fasilitas');
		$data['status']=$this->input->post('status');

		return $this->db->update("mas_industri_fasilitas", $data, array('id_industri' => $id_industri, 'id_plant' => $id_plant, 'id_fasilitas' => $id_fasilitas));
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
				order by a.no_pemeriksaan desc,a.bentuk_sediaan";
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
				order by a.no_pemeriksaan desc,a.bentuk_sediaan";
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