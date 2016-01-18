<?php

class Admin_master_uraian extends CI_Controller {

	var $limit=10;
	var $page=1;

    public function __construct(){
		parent::__construct();
		$this->load->model('admin_master_uraian_model');
		$this->load->helper('html');
	}
	
	function index(){
		$this->authentication->verify('admin_master_uraian','edit');
		$data['title'] = "Master Data - Uraian";

		$data['content'] = $this->parser->parse("admin/uraian/show",$data,true);

		$this->template->show($data,"home");
	}

	function json(){
		$page = $this->input->post('page');
		
		$jdata = $this->admin_master_uraian_model->get_list_data();
		$numrows = $jdata['record_count'];
		
		header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
		header("Cache-Control: no-cache, must-revalidate" );
		header("Pragma: no-cache" );
		header("Content-type: text/x-json");
		if($numrows<>0)
		{			
			$json = "";
			$json .= "{\n";
			$json .= "\"page\": $page,\n";
			$json .= "\"total\": " . $numrows . ",\n";
			$json .= "\"rows\": [";
			$rc = false;
			foreach ($jdata['records']->result() as $row){
				$jvDelete="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/del.gif' onclick='dodel(".$row->no_uraian.");'></a>";
				$jvEdit="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/edt.gif' onclick='edit(".$row->no_uraian.");'></a>";
					
				if ($rc) $json .= ",";
				$json .= "\n{";
				$json .= "\"id\":\"".$row->no_uraian."\",";
				$json .= "\"cell\":[";
				$json .= " \"".$jvEdit." . ".$jvDelete."\"";
				$json .= ",\"".$row->no_uraian."\"";
				$json .= ",\"".$row->deskripsi."\"";
				$json .= ",\"".$row->group."\"";
				$json .= ",\"".$row->head."\"";
				$json .= "]";
				
				$json .= "}";
				$rc = true;
			}
		  
			$json .= "]\n";
			$json .= "}";		  
		}else{
			$json = "";
			$json .= "{\n";
			$json .= "\"page\": $page,\n";
			$json .= "\"total\": " . $numrows . ",\n";
			$json .= "\"rows\": [";
			
			$json .= "\n{";
			$json .= "\"id\":\"\",";
			$json .= "\"cell\":[";
			$json .= " \"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= "]";
			
			$json .= "}";			
			
		  
			$json .= "]\n";
			$json .= "}";			
		}
		echo $json;
	}

	function add(){
		$this->authentication->verify('admin_master_uraian','add');

		$data['title_form']="uraian &raquo; Tambah";
		$data['action']="add";

		echo $this->parser->parse("admin/uraian/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('admin_master_uraian','add');

		$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|required');
		$this->form_validation->set_rules('group', 'Group', 'trim|required');
        $this->form_validation->set_rules('head', 'Head', 'trim|required');
        

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_uraian_model->insert_entry();
			echo "1";
		}
	
	}
	
	function edit($no_uraian=0)
	{
		$this->authentication->verify('admin_master_uraian','add');

		$data = $this->admin_master_uraian_model->get_data_row($no_uraian); 
		$data['title_form']="uraian &raquo; Ubah";
		$data['action']="edit";

		echo $this->parser->parse("admin/uraian/form",$data,true);
	}

	function doedit($no_uraian=0)
	{
		$this->authentication->verify('admin_master_uraian','edit');

	    $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|required');
		$this->form_validation->set_rules('group', 'Group', 'trim|required');
        $this->form_validation->set_rules('head', 'Head', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_uraian_model->update_entry($no_uraian);
			echo "1";
		}
		
	}
	
	function dodel($no_uraian=0){
		$this->authentication->verify('admin_master_uraian','del');

		if($this->admin_master_uraian_model->delete_entry($no_uraian)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}

}
