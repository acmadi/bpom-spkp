<?php

class Admin_master_bentukusaha extends CI_Controller {

	var $limit=10;
	var $page=1;

    public function __construct(){
		parent::__construct();
		$this->load->model('admin_master_bentukusaha_model');
		$this->load->helper('html');
	}
	
	function index(){
		$this->authentication->verify('admin_master_bentukusaha','edit');
		$data['title'] = "Master Data - Bentuk Perusahaan";

		$data['content'] = $this->parser->parse("admin/bentukusaha/show",$data,true);

		$this->template->show($data,"home");
	}

	function json(){
		$page = $this->input->post('page');
		
		$jdata = $this->admin_master_bentukusaha_model->get_list_data();
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
				$jvDelete="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/del.gif' onclick='dodel(".$row->id.");'></a>";
				$jvEdit="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/edt.gif' onclick='edit(".$row->id.");'></a>";
					
				if ($rc) $json .= ",";
				$json .= "\n{";
				$json .= "\"id\":\"".$row->id."\",";
				$json .= "\"cell\":[";
				$json .= " \"".$jvEdit." . ".$jvDelete."\"";
				$json .= ",\"".$row->id."\"";
				$json .= ",\"".$row->nama_bentuk."\"";
				$json .= ",\"".$row->nama_bentuk2."\"";
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
			$json .= "]";
			
			$json .= "}";			
			
		  
			$json .= "]\n";
			$json .= "}";			
		}
		echo $json;
	}

	function add(){
		$this->authentication->verify('admin_master_bentukusaha','add');

		$data['title_form']="Bentuk Perusahaan &raquo; Tambah";
		$data['action']="add";

		echo $this->parser->parse("admin/bentukusaha/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('admin_master_bentukusaha','add');

		$this->form_validation->set_rules('nama_bentuk', 'Kode Bentuk Perusahaan', 'trim|required');
		$this->form_validation->set_rules('nama_bentuk2', 'Nama Bentuk Perusahaan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_bentukusaha_model->insert_entry();
			echo "1";
		}
	
	}
	
	function edit($id=0)
	{
		$this->authentication->verify('admin_master_bentukusaha','add');

		$data = $this->admin_master_bentukusaha_model->get_data_row($id); 
		$data['title_form']="Bentuk Perusahaan &raquo; Ubah";
		$data['action']="edit";

		echo $this->parser->parse("admin/bentukusaha/form",$data,true);
	}

	function doedit($id=0)
	{
		$this->authentication->verify('admin_master_bentukusaha','edit');

		$this->form_validation->set_rules('nama_bentuk', 'Nama Bentuk Perusahaan', 'trim|required');
		$this->form_validation->set_rules('nama_bentuk2', 'Alamat Bentuk Perusahaan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_bentukusaha_model->update_entry($id);
			echo "1";
		}
		
	}
	
	function dodel($id=0){
		$this->authentication->verify('admin_master_bentukusaha','del');

		if($this->admin_master_bentukusaha_model->delete_entry($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}

}
