<?php
class Admin_file_model extends CI_Model {

    var $tabel    = 'app_files';
	var $lang	  = '';

    function __construct() {
        parent::__construct();
		$this->lang	  = $this->config->item('language');
    }
    
    function json_file(){
        $query = "SELECT a.*, b.name FROM app_files a INNER JOIN app_theme b
                  ON a.id_theme = b.id_theme WHERE lang='ina' GROUP BY id ORDER BY a.id ASC";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_all_theme(){
        $this->db->order_by('id_theme','asc');
        $query = $this->db->get('app_theme');
        
        return $query->result();    
    }
    
    function get_count($options)
    {
		if(count($options)<1) $options = array('id_theme' => $this->session->userdata('id_theme'));
		$this->db->where($options);
		$this->db->where(array('lang' => $this->lang));
        return $this->db->count_all_results($this->tabel);
    }

    function get_data($options,$start,$limit)
    {
		if(count($options)<1) $options = array('id_theme' => $this->session->userdata('id_theme'));
		$this->db->order_by('filename','asc');
		$this->db->where($options);
		$this->db->where(array('lang' => $this->lang));
        $query = $this->db->get($this->tabel,$limit,$start);
        return $query->result();
    }

    function get_lang()
    {
		$this->db->order_by('kode', 'DESC');
        $query = $this->db->get('app_lang');
        return $query->result_array();
    }

 	function get_data_row($id,$lang){
		$options = array('id' => $id, 'lang'=>$lang);
		$query = $this->db->get_where($this->tabel,$options,1);
		
        return $query->row_array();
	}

    function get_theme($blank=0)
    {
        $query = $this->db->get('app_theme');
		if($blank==1) $data[""]= "-";
        foreach($query->result_array() as $key=>$dt){
			$data[$dt['id_theme']]=ucfirst($dt['name']);
		}
		$query->free_result();    
		return $data;
    }

   function insert_entry(){
        $ina['lang'] = "ina";
        $ina['filename'] = $this->input->post('ina');
        $ina['module'] = $this->input->post('module');
        $ina['id_theme'] = $this->input->post('id_theme');
        $ina['description'] = $this->input->post('description');
        $ina['class'] = $this->input->post('class');
        $ina['color'] = $this->input->post('color');
        $ina['size'] = $this->input->post('size');
        
        $this->db->insert($this->tabel, $ina);
        $id = $this->db->insert_id();
        
        $en['id'] = $id;
        $en['lang'] = "en";
        $en['filename'] = $this->input->post('en');
        $en['module'] = $this->input->post('module');
        $en['id_theme'] = $this->input->post('id_theme');
        $ina['description'] = $this->input->post('description');
        $ina['class'] = $this->input->post('class');
        $ina['color'] = $this->input->post('color');
        $ina['size'] = $this->input->post('size');
        
        $this->db->insert($this->tabel, $en);
        
        return $id;
    }

    function update_entry($id){
        $ina['filename'] = $this->input->post('ina');
        $ina['module'] = $this->input->post('module');
        $ina['id_theme'] = $this->input->post('id_theme');
        $ina['description'] = $this->input->post('description');
        $ina['class'] = $this->input->post('class');
        $ina['color'] = $this->input->post('color');
        $ina['size'] = $this->input->post('size');
        
        $x = $this->db->update($this->tabel, $ina, array('id'=>$this->input->post('id'), 'lang'=>'ina'));
        
        $en['filename'] = $this->input->post('en');
        $en['module'] = $this->input->post('module');
        $en['id_theme'] = $this->input->post('id_theme');
        $ina['description'] = $this->input->post('description');
        $ina['class'] = $this->input->post('class');
        $ina['color'] = $this->input->post('color');
        $ina['size'] = $this->input->post('size');
        
        $x = $this->db->update($this->tabel, $en, array('id'=>$this->input->post('id'), 'lang'=>'en'));
        
        return $x;
	}

	function delete_entry($id)
	{
		$this->db->where(array('id' => $id));

		return $this->db->delete($this->tabel);
	}
}