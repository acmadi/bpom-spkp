<?php

class Admin_master_proses extends CI_Controller {

	var $limit=10;
	var $page=1;

    public function __construct(){
		parent::__construct();
		$this->load->model('admin_master_proses_model');
		$this->load->helper('html');
	}
	
	function index(){
		$this->authentication->verify('admin_master_proses','edit');
		$data['title'] = "Master Data - Proses Monitoring";

		$data['content'] = $this->parser->parse("admin/proses/show",$data,true);

		$this->template->show($data,"home");
	}

	function json(){
		$page = $this->input->post('page');
		
		$jdata = $this->admin_master_proses_model->get_list_data();
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
				$jvDelete="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/del.gif' onclick='dodel(".$row->id_proses.");'></a>";
				$jvEdit="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/edt.gif' onclick='edit(".$row->id_proses.");'></a>";
					
				if ($rc) $json .= ",";
				$json .= "\n{";
				$json .= "\"id\":\"".$row->id_proses."\",";
				$json .= "\"cell\":[";
				$json .= " \"".$jvEdit." . ".$jvDelete."\"";
				$json .= ",\"".$row->id_proses."\"";
				$json .= ",\"".$row->deskripsi."\"";
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
			$json .= "]";
			
			$json .= "}";			
			
		  
			$json .= "]\n";
			$json .= "}";			
		}
		echo $json;
	}

	function add(){
		$this->authentication->verify('admin_master_proses','add');

		$data['title_form']="Proses Monitoring &raquo; Tambah";
		$data['action']="add";

		echo $this->parser->parse("admin/proses/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('admin_master_proses','add');

		$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_proses_model->insert_entry();
			echo "1";
		}
	
	}
	
	function edit($id_proses=0)
	{
		$this->authentication->verify('admin_master_proses','add');

		$data = $this->admin_master_proses_model->get_data_row($id_proses); 
		$data['title_form']="Proses Monitoring &raquo; Ubah";
		$data['action']="edit";

		echo $this->parser->parse("admin/proses/form",$data,true);
	}

	function doedit($id_proses=0)
	{
		$this->authentication->verify('admin_master_proses','edit');

		$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_proses_model->update_entry($id_proses);
			echo "1";
		}
		
	}
	
	function dodel($id_proses=0){
		$this->authentication->verify('admin_master_proses','del');

		if($this->admin_master_proses_model->delete_entry($id_proses)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}

}
