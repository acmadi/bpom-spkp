<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * C-R-U-D Model
 *
 * @package		 CodeIgniter
 * @subpackage 	 Model
 * @category	 Create-Retrieve-Update-Delete
 *
 * @author		 ihsan hambali / ihsanhambali27[at]gmail.com
 *
 */
 
class Crud extends CI_Model {

	var $data = array();
	var $returnArray = TRUE;
	var $table;
	var $fields;
	var $__numRows;
	var $__insertID;
	var $__affectedRows;
	var $id;
	var $primaryKey = 'id';

	function __construct() {
        parent::__construct();
		$this->load->library('encrypt');
	}

	/**
	 * Load the associated database table.
	 *
	 */
	function useTable($table)
	{
		$this->table  = $table;
		$this->fields = $this->db->list_fields($table);
	}
  

	/**
	 * Returns a resultset array with specified fields from database matching given conditions.
	 */
	function findAll($conditions = NULL, $fields = '*', $order = NULL, $start = 0, $limit = NULL)
	{
		if ($conditions != NULL) {
			$this->db->where($conditions);
		}

		if ($fields != NULL) {
			$this->db->select($fields);
		}

		if ($order != NULL) {
			$this->db->orderby($order);
		}

		if ($limit != NULL) {
			$this->db->limit($limit, $start);
		}

		$query = $this->db->get($this->table);
		$this->__numRows = $query->num_rows();

		return ($this->returnArray) ? $query->result_array() : $query->result();
	}

	/**
	 * Return a single row as a resultset array with specified fields from database matching given conditions.
	 */
	function find($conditions = NULL, $fields = '*', $order = 'id ASC')
	{
		$data = $this->findAll($conditions, $fields, $order, 0, 1);

		if ($data) {
			return $data[0];
		}
		else {
			return false;
		}
	}
	
	function get_insertid(){
		return $this->__insertID;	
	}
	
	function unsetMe(){
		$this->crud->data = array();
		$this->crud->fields = null;
		$this->crud->id = null;
		$this->crud->primaryKey = null;
	}

	/**
	*  Update Method
	*/
	function save($data = null, $id = null, $pk = null, $stat = null)
	{
		if ($data)
		{
			$this->data = $data;
		}

		foreach ($this->data as $key => $value)
		{
			if (array_search($key, $this->fields) === FALSE)
			{
				unset($this->data[$key]);
			}
		}
		
		foreach ($this->data as $key => $value)
		{
			//echo $value;
			if ($value == '')
			{
				unset($this->data[$key]);
			}
		}

		if ($id != null)
		{
			$this->id = $id;
		}
		if ($pk != null)
		{
			$this->primaryKey = $pk;
		}

		$id = $this->id;

		if ($this->id !== null && $this->id !== false)
		{
			$this->db->where($this->primaryKey, $id);
			$ret = $this->db->update($this->table, $this->data);
			$this->__affectedRows = $this->db->affected_rows();
			//if($stat!=99){
			  //echo $this->id;
			  //return $this->id;
			//}
			//echo $this->db->last_query();
		}
		else
		{
			$ret = $this->db->insert($this->table,$this->data);
			$this->__affectedRows = $this->db->affected_rows();
			$this->__insertID = $this->db->insert_id();
			//if($stat!=99){
			  //echo 1;
			  //return $this->__insertID;
			//}
		}
		return $ret;
	}

	/**
	*  Update Method multiple primary key
	*/
	function save_multipk($data = null, $pk = null){
		if ($data){
			$this->data = $data;
		}
		if ($pk){
			$this->pk = $pk;
		}
		   
		$this->db->select('*');
		foreach($this->pk as $key=> $value){
			$this->db->where($key, $value);
		}
		$query = $this->db->get($this->table);
		
		foreach ($this->data as $key => $value){
			if (array_search($key, $this->fields) === FALSE){
				unset($this->data[$key]);
			}
		}
		   
		$numrows = $query->num_rows();
		
		if ($numrows>0){
			foreach($this->pk as $key=> $value){
			   $this->db->where($key, $value);
			}
			$ret = $this->db->update($this->table, $this->data);
			$this->__affectedRows = $this->db->affected_rows();
		}else{ 
			 $ret = $this->db->insert($this->table,$this->data);
			 $this->__affectedRows = $this->db->affected_rows();
			 $this->__insertID = $this->db->insert_id();
			 //return $this->__insertID;
		}
		return $ret;
	}
	
	function delete($id = null, $pk = null)
	{
		if ($id != null)
		{
			$this->id = $id;
		}
		if ($pk != null)
		{
			$this->primaryKey = $pk;
		}

		$id = $this->id;

		if ($this->id !== null && $this->id !== false)
		{
        $this->db->where($this->primaryKey, $id);
        $this->db->delete($this->table);
        $this->__affectedRows = $this->db->affected_rows();
		  //echo $this->id;
        return $this->id;
		}
	}
	
	/**
	*  Get row affected from update
	*/
	function getAffectedRows()
	{
		return $this->__affectedRows;
	}
	
	/**
	*  Get count data using specific condition
	*/
	function getCount($conditions = null)
	{
		$data = $this->findAll($conditions, 'COUNT(*) AS count', null, 0, 1);

		if ($data){
			return $data[0]['count'];
		} else {
			return false;
		}
	}
	
	function bulan($bulan){
		$bln = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
		return $bln[$bulan];
	
	}

	function option_bulan($name="",$value="",$attr=""){
		$html = "<select id='".$name."' name='".$name."' ".$attr.">";
		for($i=1;$i<=12;$i++){
			if($i<10){
				$t = "0".$i;
			}else{
				$t=$i;
			}
			$html .= "<option value='".$i."' ".($i==$value ? "selected" : "" ).">".$i."</option>";
		}
		return $html."</select>";
	
	}

	function option_tahun($name="",$value="",$attr=""){
		$html = "<select id='".$name."' name='".$name."' ".$attr.">";
		for($i=date('Y');$i>=(date('Y')-5);$i--){
			$html .= "<option value='".$i."' ".($i==$value ? "selected" : "" ).">".$i."</option>";
		}
		return $html."</select>";
	
	}

	function option_subdit($id_subdit=0,$attr=""){
		$sql = "SELECT * FROM mas_subdit WHERE status='subdit'";
		$query = $this->db->query($sql);
		$html = "<select id='id_subdit' name='id_subdit' ".$attr."><option value=''>-</option>";
		foreach($query->result() as $row){
			$html .= "<option value=".$row->id_subdit." ".($id_subdit==$row->id_subdit ? "selected" : "" ).">".$row->ket."</option>";
		}
		return $html."</select>";
	}
	
	function option_subdit_top($id_subdit=0,$attr=""){
		$sql = "SELECT * FROM mas_subdit";
		$query = $this->db->query($sql);
		$html = "<select id='id_top' name='id_top' ".$attr."><option value=0>-</option>";
		foreach($query->result() as $row){
			$html .= "<option value=".$row->id_subdit." ".($id_subdit==$row->id_subdit ? "selected" : "" ).">".$row->ket."</option>";
		}
		return $html."</select>";
	}
	
	function jenis_lampiran($jenis_lampiran=""){
		$html = "<select id='jenis_lampiran' name='jenis_lampiran' class='input'>";
			$html .= "<option value='RIP' ".($jenis_lampiran=='RIP' ? "selected" : "" ).">RIP Pabrik</option>";
			$html .= "<option value='Dokumentasi' ".($jenis_lampiran=='Dokumentasi' ? "selected" : "" ).">Dokumentasi CPOTB/CPKB </option>";
		return $html."</select>";
	
	}

	function jenis_sertifikat($jenis_sertifikat=""){
		$html = "<select id='jenis_sertifikat' name='jenis_sertifikat' class='input'>";
			$html .= "<option value='CPOTB' ".($jenis_sertifikat=='CPOTB' ? "selected" : "" ).">CPOTB</option>";
			$html .= "<option value='CPKB' ".($jenis_sertifikat=='CPKB' ? "selected" : "" ).">CPKB</option>";
		return $html."</select>";
	
	}

	function select_plant($id_industri,$id=""){
		$sql = "select a.id_plant,a.alamat_pabrik,b.nama_propinsi from mas_industri_plant AS a,mas_propinsi AS b WHERE a.propinsi=b.id_propinsi AND a.id_industri='".$id_industri."'";
		$query = $this->db->query($sql);
		$html = "<select id='id_plant' name='id_plant' class='input' style='width:300px'>
			<option>-</option>";
		foreach($query->result() as $row){
			$html .= "<option value=".$row->id_plant." ".($id==$row->id_plant ? "selected" : "" ).">".$row->alamat_pabrik.", ".$row->nama_propinsi."</option>";
		}
		return $html."</select>";
	}
	
	function select_izin($id=""){
		$sql = "select * from mas_izin ORDER BY jenis ASC, nama ASC";
		$query = $this->db->query($sql);
		$html = "<select id='id_izin' name='id_izin' class='input'>
			<option>-</option>";
		foreach($query->result() as $row){
			$html .= "<option value=".$row->id_izin." ".($id==$row->id_izin ? "selected" : "" ).">".$row->jenis.": ".$row->nama."</option>";
		}
		return $html."</select>";
	}
	
	function select_lokasi($id=""){
		$sql = "select * from mas_lokasi_industri";
		$query = $this->db->query($sql);
		$html = "<select id='lokasi' name='lokasi'>
			<option>-</option>";
		foreach($query->result() as $row){
			$html .= "<option value=".$row->id_lokasi." ".($id==$row->id_lokasi ? "selected" : "" ).">".$row->nama_lokasi."</option>";
		}
		return $html."</select>";
	}
	
	function get_lokasi_pabrik($id=""){
		$sql = "select * from mas_lokasi_industri";
		$query = $this->db->query($sql);
		$html = "<select id='lokasi' name='lokasi' class='input'>";
		foreach($query->result() as $row){
			if($id==$row->id_lokasi)
				$html .= "<option value=".$row->id_lokasi." selected>".$row->nama_lokasi."</option>";
			else
				$html .= "<option value=".$row->id_lokasi.">".$row->nama_lokasi."</option>";
		}
		return $html."</select>";
	}
	
	function get_fasilitas_pabrik($id="",$iterat=""){
		$sql = "select * from mas_fasilitas";
		$query = $this->db->query($sql);
		$html = "<select id='fasilitas$iterat' name='fasilitas$iterat' class='input'>";
		foreach($query->result() as $row){
			if($id==$row->id_fasilitas)
				$html .= "<option value=".$row->id_fasilitas." selected>".$row->nama_fasilitas."</option>";
			else
				$html .= "<option value=".$row->id_fasilitas.">".$row->nama_fasilitas."</option>";
		}
		return $html."</select>";
	}
	
	function get_sediaan_pabrik($id_jenis="",$id="",$iterat="",$attr=""){
		$sql = "select * from mas_bentuk_sediaan WHERE id_jenis='".$id_jenis."' ORDER BY nama_sediaan ASC";
		$query = $this->db->query($sql);
		$html = "<select id='sediaan$iterat' name='sediaan$iterat' $attr class='input'><option>-</option>";
		foreach($query->result() as $row){
			$html .= "<option ".($id==$row->id_sediaan ? "selected" : "")." value=".$row->id_sediaan." >".$row->nama_sediaan."</option>";
		}
		return $html."</select>";
	}
	
	/*function get_sediaan_pabrik($id="",$iterat="",$attr=""){
		$sql = "select * from mas_bentuk_sediaan ORDER BY nama_sediaan ASC";
		$query = $this->db->query($sql);
		$html = "<select id='sediaan$iterat' name='sediaan$iterat' $attr class='input'>
			<option>-</option>";
		foreach($query->result() as $row){
			if($id==$row->id_sediaan)
				$html .= "<option id_jenis=".$row->id_jenis." value=".$row->id_sediaan." selected>".$row->nama_sediaan."</option>";
			else
				$html .= "<option id_jenis=".$row->id_jenis." value=".$row->id_sediaan.">".$row->nama_sediaan."</option>";
		}
		return $html."</select>";
	}*/
	
	function get_sediaan_pabrik2($id,$id_plant,$id_jenis,$bentuk_sediaan=0,$iterat="",$attr=""){
		$sql = "select * from mas_bentuk_sediaan WHERE id_jenis='".$id_jenis."' ORDER BY nama_sediaan ASC";
		$query = $this->db->query($sql);
		$html = "<select id='bentuk_sediaan$iterat' name='bentuk_sediaan$iterat' $attr class='input'>
			<option value=''>-</option>";
			foreach($query->result() as $row){
				if($this->cek_sediaan_pabrik($id,$id_plant,$row->id_sediaan) || $bentuk_sediaan==$row->id_sediaan){
					if($bentuk_sediaan==$row->id_sediaan)
						$html .= "<option id_jenis=".$row->id_jenis." value=".$row->id_sediaan." selected>".$row->nama_sediaan."</option>";
					else
						$html .= "<option id_jenis=".$row->id_jenis." value=".$row->id_sediaan.">".$row->nama_sediaan."</option>";
				}
			}
		return $html."</select>";
	}
	
	function cek_sediaan_pabrik($id,$id_plant,$bentuk_sediaan){
		$sql = "select * FROM mas_industri_sediaan WHERE id_industri='".$id."' AND id_plant='".$id_plant."' AND bentuk_sediaan='".$bentuk_sediaan."'";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return false;
		}else{
			return true;	
		}
	}
	
	function get_balai($id="",$iterat="",$etc=""){
		$this->db->order_by("id_balai","ASC");
		$query = $this->db->get("mas_balai");
		$html = "<select id='kode_balai$iterat' name='kode_balai$iterat' class='input' ".$etc.">";
		foreach($query->result() as $row){
			if($id==$row->id_balai)
				$html .= "<option value=".$row->id_balai." selected>".$row->nama_balai."</option>";
			else
				$html .= "<option value=".$row->id_balai.">".$row->nama_balai."</option>";
		}
		return $html."</select>";
	}
	
	function get_jenis_industri($id="",$iterat="",$attr=""){
		$sql = "select * from mas_jenis";
		$query = $this->db->query($sql);
		$html = "<select class=input id='kode_jenisusaha$iterat' name='kode_jenisusaha$iterat' $attr>";
		foreach($query->result() as $row){
			if($id==$row->id_jenis)
				$html .= "<option value=".$row->id_jenis." selected>".$row->nama_jenis." - ".$row->nama_jenis2."</option>";
			else
				$html .= "<option value=".$row->id_jenis.">".$row->nama_jenis." - ".$row->nama_jenis2."</option>";
		}
		return $html."</select>";
	}
	
	function get_jenis_industri2($id,$id_plant,$id_jenis="",$iterat="",$attr=""){
		$sql = "select * from mas_jenis";
		$query = $this->db->query($sql);
		$html = "<select class=input id='id_jenis$iterat' name='id_jenis$iterat' $attr>";
		foreach($query->result() as $row){
			if($this->cek_jenis_industri($id,$id_plant,$row->id_jenis) || $id_jenis==$row->id_jenis){
				if($id_jenis==$row->id_jenis)
					$html .= "<option value=".$row->id_jenis." selected>".$row->nama_jenis." - ".$row->nama_jenis2."</option>";
				else
					$html .= "<option value=".$row->id_jenis.">".$row->nama_jenis." - ".$row->nama_jenis2."</option>";
			}
		}
		return $html."</select>";
	}
	
	function cek_jenis_industri($id,$id_plant,$id_jenis){
		$sql = "select * FROM mas_industri_plant_jenis WHERE id_industri='".$id."' AND id_plant='".$id_plant."' AND id_jenis='".$id_jenis."'";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return false;
		}else{
			return true;	
		}
	}
	
	function get_fasilitas_industri2($id,$id_plant,$id_fasilitas="",$iterat="",$attr=""){
		$sql = "select * from mas_fasilitas";
		$query = $this->db->query($sql);
		$html = "<select class=input id='id_fasilitas$iterat' name='id_fasilitas$iterat' $attr style='width:200px'>";
		foreach($query->result() as $row){
			if($this->cek_fasilitas_industri($id,$id_plant,$row->id_fasilitas) || $id_fasilitas==$row->id_fasilitas){
				if($id_fasilitas==$row->id_fasilitas)
					$html .= "<option value=".$row->id_fasilitas." selected>".$row->nama_fasilitas."</option>";
				else
					$html .= "<option value=".$row->id_fasilitas.">".$row->nama_fasilitas."</option>";
			}
		}
		return $html."</select>";
	}
	
	function cek_fasilitas_industri($id,$id_plant,$id_fasilitas){
		$sql = "select * FROM mas_industri_fasilitas WHERE id_industri='".$id."' AND id_plant='".$id_plant."' AND id_fasilitas='".$id_fasilitas."'";
		$query = $this->db->query($sql);
		if($query->num_rows()>0){
			return false;
		}else{
			return true;	
		}
	}
	
	function get_jenis_status($id="",$iterat="",$attr=""){
		$sql = "select * from mas_status_industri";
		$query = $this->db->query($sql);
		$html = "<select class=input id='id_status$iterat' name='id_status$iterat' $attr>";
		foreach($query->result() as $row){
			if($id==$row->id_status)
				$html .= "<option value=".$row->id_status." selected>".$row->nama."</option>";
			else
				$html .= "<option value=".$row->id_status.">".$row->nama."</option>";
		}
		return $html."</select>";
	}
	
	function get_status_industri($id="",$iterat="",$attr=""){
		$html = "<select class=input id='status$iterat' name='status$iterat' $attr>";
		$html .= "<option value=1 ".($id=="1" ? "selected" : "").">Aktif</option>";
		$html .= "<option value=2 ".($id=="2" ? "selected" : "").">Non Aktif</option>";
		return $html."</select>";
	}
	
	function get_propinsi($id="",$iterat="",$class="input"){
		$sql = "select * from mas_propinsi";
		$query = $this->db->query($sql);
		$html = "<select id='kode_provinsi$iterat' name='kode_provinsi$iterat' class=".$class."><option value=''>-</option>";
		foreach($query->result() as $row){
			if($id==$row->id_propinsi)
				$html .= "<option value=".$row->id_propinsi." selected>".$row->nama_propinsi."</option>";
			else
				$html .= "<option value=".$row->id_propinsi.">".$row->nama_propinsi."</option>";
		}
		return $html."</select>";
	}
	
	function get_kota($kode_provinsi, $id="",$iterat="",$class="input"){
		$sql = "select * from mas_kota where id_kota like '".$kode_provinsi."%' ";
		$query = $this->db->query($sql);
		foreach($query->result() as $row){
			$data[$row->id_kota] = $row->nama_kota;
		}

		return $data;
	}
	
	function get_plant($idindustri, $idplant="", $attr=""){
		$sql = "select id_plant from mas_industri_plant where id_industri='$idindustri'";
		
		$query = $this->db->query($sql);
		$html = "<select id='plant' name='plant' $attr>";
		foreach($query->result() as $row){
			if($idplant==$row->id_plant)
				$html .= "<option value=".$row->id_plant." selected>".$row->id_plant."</option>";
			else
				$html .= "<option value=".$row->id_plant.">".$row->id_plant."</option>";
		}
		return $html."</select>";
	}
	
	function get_attr_balai($id){
		$sql = "select * from mas_balai where id_balai='$id'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	function get_attr_sediaan($id,$col="nama_sediaan"){
		$sql = "select $col from mas_bentuk_sediaan where id_sediaan=$id";
		$query = $this->db->query($sql);
		$rs =  $query->row_array();
		return $rs[$col];
	}
	
	function get_kantor($idindustri, $idkantor="", $attr=""){
		$sql = "select id_kantor from mas_industri_kantor where id_industri='$idindustri'";
		
		$query = $this->db->query($sql);
		$html = "<select id='kantor' name='kantor' $attr>";
		foreach($query->result() as $row){
			if($idkantor==$row->id_kantor)
				$html .= "<option value=".$row->id_kantor." selected>Kantor ".$row->id_kantor."</option>";
			else
				$html .= "<option value=".$row->id_kantor.">Kantor ".$row->id_kantor."</option>";
		}
		return $html."</select>";
	}
	
	function get_col($col,$tbl,$where=""){
		$sql = "select $col from $tbl $where";
		$query = $this->db->query($sql);
		$rs =  $query->row_array();
		return $rs[$col];
	}
	
	function get_bentuk_usaha($id="",$iterat=""){
		$sql = "select * from mas_bentuk_perusahaan";
		$query = $this->db->query($sql);
		$html = "<select class=input id='bentuk_usaha$iterat' name='bentuk_usaha$iterat'>";
		foreach($query->result() as $row){
			if($id==$row->id)
				$html .= "<option value=".$row->id." selected>".$row->nama_bentuk." - ".$row->nama_bentuk2."</option>";
			else
				$html .= "<option value=".$row->id.">".$row->nama_bentuk." - ".$row->nama_bentuk2."</option>";
		}
		return $html."</select>";
	}
	
	function select_propinsi($id="",$iterat="",$name="propinsi",$etc=""){
		$sql = "select * from mas_propinsi";
		$query = $this->db->query($sql);
		$html = "<select class=input id='propinsi' name='".$name."' ".$etc.">";
		$html .= "<option value=0>-</option>";
		foreach($query->result() as $row){
			if($id==$row->id_propinsi)
				$html .= "<option value=".$row->id_propinsi." selected>".$row->id_propinsi." - ".$row->nama_propinsi."</option>";
			else
				$html .= "<option value=".$row->id_propinsi.">".$row->id_propinsi." - ".$row->nama_propinsi."</option>";
		}
		return $html."</select>";
	}
	
	function get_penanggungjawab($jabatan=0,$col="id"){
		$query = $this->db->query("select * from mas_penanggungjawab where status=1 and id_jabatan=$jabatan");
		$r = $query->row();
		return $r->$col;
	}
    
    function jqxGrid($query){
		$tabel="(".$query.") as ROWS ";
		$pagenum = $_POST['pagenum'];
		$pagesize = $_POST['pagesize'];
		$start = $pagenum * $pagesize;
		$query = "SELECT SQL_CALC_FOUND_ROWS * FROM $tabel LIMIT $start, $pagesize";
		$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
		$sql = "SELECT FOUND_ROWS() AS `found_rows`;";
		$rows = mysql_query($sql);
		$rows = mysql_fetch_assoc($rows);
		$total_rows = $rows['found_rows'];
		$filterquery = "";
		
		if (isset($_POST['filterscount']))
		{
			$filterscount = $_POST['filterscount'];
			
			if ($filterscount > 0)
			{
				$where = " WHERE (";
				$tmpdatafield = "";
				$tmpfilteroperator = "";
				for ($i=0; $i < $filterscount; $i++)
				{
					$filtervalue		= $_POST["filtervalue" . $i];
					$filtercondition	= $_POST["filtercondition" . $i];
					$filterdatafield	= $_POST["filterdatafield" . $i];
					$filteroperator		= $_POST["filteroperator" . $i];
					
					if ($tmpdatafield == "")
					{
						$tmpdatafield = $filterdatafield;			
					}
					else if ($tmpdatafield <> $filterdatafield)
					{
						$where .= ")AND(";
					}
					else if ($tmpdatafield == $filterdatafield)
					{
						if ($tmpfilteroperator == 0)
						{
							$where .= " AND ";
						}
						else $where .= " OR ";	
					}
					
					// build the "WHERE" clause depending on the filter's condition, value and datafield.
					switch($filtercondition)
					{
						case "NOT_EMPTY":
						case "NOT_NULL":
							$where .= " " . $filterdatafield . " NOT LIKE '" . "" ."'";
							break;
						case "EMPTY":
						case "NULL":
							$where .= " " . $filterdatafield . " LIKE '" . "" ."'";
							break;
						case "CONTAINS_CASE_SENSITIVE":
							$where .= " BINARY  " . $filterdatafield . " LIKE '%" . $filtervalue ."%'";
							break;
						case "CONTAINS":
							$where .= " " . $filterdatafield . " LIKE '%" . $filtervalue ."%'";
							break;
						case "DOES_NOT_CONTAIN_CASE_SENSITIVE":
							$where .= " BINARY " . $filterdatafield . " NOT LIKE '%" . $filtervalue ."%'";
							break;
						case "DOES_NOT_CONTAIN":
							$where .= " " . $filterdatafield . " NOT LIKE '%" . $filtervalue ."%'";
							break;
						case "EQUAL_CASE_SENSITIVE":
							$where .= " BINARY " . $filterdatafield . " = '" . $filtervalue ."'";
							break;
						case "EQUAL":
							$where .= " " . $filterdatafield . " = '" . $filtervalue ."'";
							break;
						case "NOT_EQUAL_CASE_SENSITIVE":
							$where .= " BINARY " . $filterdatafield . " <> '" . $filtervalue ."'";
							break;
						case "NOT_EQUAL":
							$where .= " " . $filterdatafield . " <> '" . $filtervalue ."'";
							break;
						case "GREATER_THAN":
							$where .= " " . $filterdatafield . " > '" . $filtervalue ."'";
							break;
						case "LESS_THAN":
							$where .= " " . $filterdatafield . " < '" . $filtervalue ."'";
							break;
						case "GREATER_THAN_OR_EQUAL":
							$where .= " " . $filterdatafield . " >= '" . $filtervalue ."'";
							break;
						case "LESS_THAN_OR_EQUAL":
							$where .= " " . $filterdatafield . " <= '" . $filtervalue ."'";
							break;
						case "STARTS_WITH_CASE_SENSITIVE":
							$where .= " BINARY " . $filterdatafield . " LIKE '" . $filtervalue ."%'";
							break;
						case "STARTS_WITH":
							$where .= " " . $filterdatafield . " LIKE '" . $filtervalue ."%'";
							break;
						case "ENDS_WITH_CASE_SENSITIVE":
							$where .= " BINARY " . $filterdatafield . " LIKE '%" . $filtervalue ."'";
							break;
						case "ENDS_WITH":
							$where .= " " . $filterdatafield . " LIKE '%" . $filtervalue ."'";
							break;
					}
									
					if ($i == $filterscount - 1)
					{
						$where .= ")";
					}
					
					$tmpfilteroperator = $filteroperator;
					$tmpdatafield = $filterdatafield;			
				}
				// build the query.
				$query = "SELECT * FROM $tabel ".$where;
				$filterquery = $query;
				$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
				$sql = "SELECT FOUND_ROWS() AS `found_rows`;";
				$rows = mysql_query($sql);
				$rows = mysql_fetch_assoc($rows);
				$new_total_rows = $rows['found_rows'];		
				$query = "SELECT * FROM $tabel ".$where." LIMIT $start, $pagesize";	
				$total_rows = $new_total_rows;	
			}
		}
		
		if (isset($_POST['sortdatafield']))
		{
		
			$sortfield = $_POST['sortdatafield'];
			$sortorder = $_POST['sortorder'];
			
			if ($sortorder != '')
			{
				if ($_POST['filterscount'] == 0)
				{
					if ($sortorder == "desc")
					{
						$query = "SELECT * FROM $tabel ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";
					}
					else if ($sortorder == "asc")
					{
						$query = "SELECT * FROM $tabel ORDER BY" . " " . $sortfield . " ASC LIMIT $start, $pagesize";
					}
				}
				else
				{
					if ($sortorder == "desc")
					{
						$filterquery .= " ORDER BY" . " " . $sortfield . " DESC LIMIT $start, $pagesize";
					}
					else if ($sortorder == "asc")	
					{
						$filterquery .= " ORDER BY" . " " . $sortfield . " ASC LIMIT $start, $pagesize";
					}
					$query = $filterquery;
				}		
			}
		}
		
		$sql = "SELECT @i:=0";
        mysql_query($sql);

		$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());

		$orders = null;
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$orders[] = $row;
		}
		  $data[] = array(
		   'TotalRows' => $total_rows,
		   'Rows' => $orders
		);

		return $data;

		}
}
/* End of file crud.php */
/* Location: ./application/model/crud.php */
?>