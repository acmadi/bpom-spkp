<?php
class Srikandi_kategori_model extends CI_Model {

    var $tabel    = 'mas_srikandi_kategori';
	var $lang	  = '';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');
    }
    
    function insert_kategori(){
        $data['id_subdit'] = $this->input->post('id_subdit');
        $data['nama'] =  $this->input->post('kategori_parent');
        $data['id_kategori_parent'] =  0;

        if($this->db->insert('mas_srikandi_kategori', $data)){
            $id = mysql_insert_id();
			return $id;
		}else{
			return false;
		}
    }

    function get_data($subdit=1,$id_kategori_parent=0)
    {
		$options['mas_srikandi_kategori.id_subdit'] = $subdit;
		$options['id_kategori_parent'] = $id_kategori_parent;

		$this->db->select('*,mas_subdit.ket');
		$this->db->join('mas_subdit','mas_srikandi_kategori.id_subdit=mas_subdit.id_subdit');
		$this->db->where($options);
		$this->db->order_by("id_kategori", "ASC"); 
		$query = $this->db->get($this->tabel);
        return $query->result_array();
    }

    function getSubdit($id_subdit){
        $this->db->where('status','subdit');
        $query = $this->db->get('mas_subdit');
        $result = $query->result_array();
        $data=array();
        $data="<option value='0'>-</option>";
        foreach($result as $x=>$y){
            $data.="<option value='".$y['id_subdit']."' ".($id_subdit==$y['id_subdit'] ? "selected":"").">".$y['ket']."</option>";
        }
        
        return $data;

    }


    function get_files($id_theme,$position)
    {
 		$this->db->select("file_id");
 		$this->db->where("id_theme" , $id_theme);
 		$this->db->where("position" , $position);
		$query = $this->db->get('app_menus');
		$existed = $query->result_array();
		foreach($existed as $x=>$y){
			$not[] = $y['file_id'];
		}
		$query->free_result();    

		//$this->db->where("id_theme" , $id_theme);
		if(isset($not)) $this->db->where_not_in('id',$not);
 		$this->db->where("id_theme" , $id_theme);
        $query = $this->db->get('app_files');

        foreach($query->result_array() as $key=>$dt){
			$data[$dt['id']]=ucfirst($dt['filename']." | ".$dt['module']);
		}

		$query->free_result();    
		return $data;
    }

 	function check_child($id_subdit,$id_kategori_parent){
		$options['id_subdit'] = $id_subdit;
		$options['id_kategori_parent'] = $id_kategori_parent;
		$this->db->where($options);
		$query = $this->db->get($this->tabel);
		if ($query->num_rows() > 0){
			return true;
		}
		else return false;
    }

	function update_sub($position,$sub_id,$data)
    {
		$data = explode("|",$data);		
		foreach($data as $x=>$y){
			if($y!=""){
				$tmp = explode("__",$y);
				$dt['sort']=$tmp[1];
				$this->db->where('position', $position);
				$this->db->where('id', $tmp[3]);
				$this->db->where('sort', $tmp[2]);
			}
			if(is_array($dt)){
				$this->db->update($this->tabel, $dt); 
			}
			$dt = "";
		}

    }

	function get_last_id($position){
		$this->db->where('position', $position);
		$this->db->select_max('id');
		$query = $this->db->get($this->tabel);
		$data = $query->row_array();
		return $data['id']+1;
	}

	function get_last_sort($position,$sub_id){
		$this->db->where('position', $position);
		$this->db->where('sub_id', $sub_id);
		$this->db->select_max('sort');
		$query = $this->db->get($this->tabel);
		$data = $query->row_array();
		return $data['sort']+1;
	}


    function insert_entry($data)
    {
		if($data['position']==0 || $data['position']==99){
			$this->db->select_max('position');
			$query = $this->db->get($this->tabel);
			$post = $query->row_array();
			$data['position'] = $post['position']+1;
		}
		$data['file_id']=$this->input->post('file_id');
		$data['id']=$this->get_last_id($data['position']);
		$data['sort']=$this->get_last_sort($data['position'],$data['sub_id']);

        if($this->db->insert($this->tabel, $data)){
			return $data['position'];
		}else{
			return false;
		}
    }

	function delete_entry($position,$id)
	{
		$this->db->where('position', $position);
		$this->db->where('id', $id);

		return $this->db->delete($this->tabel);
	}
}