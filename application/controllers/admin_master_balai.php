<?php

class Admin_master_balai extends CI_Controller {

	var $limit=10;
	var $page=1;

    public function __construct(){
		parent::__construct();
		$this->load->model('admin_master_balai_model');
		$this->load->helper('html');
	}
	
	function index(){
		$this->authentication->verify('admin_master_balai','edit');
		$data['title'] = "Master Data - Balai";

		$data['content'] = $this->parser->parse("admin/balai/show",$data,true);

		$this->template->show($data,"home");
	}

	function json(){
		$page = $this->input->post('page');
		
		$jdata = $this->admin_master_balai_model->get_list_data();
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
				$jvDelete="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/del.gif' onclick='dodel(".$row->id_balai.");'></a>";
				$jvEdit="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/edt.gif' onclick='edit(".$row->id_balai.");'></a>";
					
				if ($rc) $json .= ",";
				$json .= "\n{";
				$json .= "\"id\":\"".$row->id_balai."\",";
				$json .= "\"cell\":[";
				$json .= " \"".$jvEdit." . ".$jvDelete."\"";
				$json .= ",\"".$row->id_balai."\"";
				$json .= ",\"".$row->nama_balai."\"";
				$json .= ",\"".$row->alamat."\"";
				$json .= ",\"".$row->kd_pos."\"";
				$json .= ",\"".$row->email."\"";
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
			$json .= ",\"\"";
			$json .= "]";
			
			$json .= "}";			
			
		  
			$json .= "]\n";
			$json .= "}";			
		}
		echo $json;
	}

	function add(){
		$this->authentication->verify('admin_master_balai','add');

		$data['title_form']="Balai &raquo; Tambah";
		$data['action']="add";

		echo $this->parser->parse("admin/balai/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('admin_master_balai','add');

		$this->form_validation->set_rules('nama_balai', 'Nama Balai', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Alamat Balai', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_balai_model->insert_entry();
			echo "1";
		}
	
	}
	
	function edit($id_balai=0)
	{
		$this->authentication->verify('admin_master_balai','add');

		$data = $this->admin_master_balai_model->get_data_row($id_balai); 
		$data['title_form']="Balai &raquo; Ubah";
		$data['action']="edit";

		echo $this->parser->parse("admin/balai/form",$data,true);
	}

	function doedit($id_balai=0)
	{
		$this->authentication->verify('admin_master_balai','edit');

		$this->form_validation->set_rules('nama_balai', 'Nama Balai', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Alamat Balai', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_balai_model->update_entry($id_balai);
			echo "1";
		}
		
	}
	
	function dodel($id_balai=0){
		$this->authentication->verify('admin_master_balai','del');

		if($this->admin_master_balai_model->delete_entry($id_balai)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}

}
