<?php

class Admin_file extends CI_Controller {

	var $limit=20;
	var $page=1;

    public function __construct(){
		parent::__construct();
		$this->load->model('admin_file_model');

	}
	
	function index($page=1){
		$this->authentication->verify('admin_file','show');
		$data['title'] =  "Master Data - File";
		$data['content'] = $this->parser->parse("admin/files/show",$data,true);

		$this->template->show($data,"home");
	}
    
    function json_file(){
        die(json_encode($this->admin_file_model->json_file()));
    }

	function add(){
	    $this->authentication->verify('admin_file','add');
        $data['action']="add";

		echo $this->parser->parse("admin/files/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('admin_file','add');
		
        $this->form_validation->set_rules('ina','Filename Ina','trim|required');
		$this->form_validation->set_rules('en','Filename English','trim|required');
		$this->form_validation->set_rules('module', 'Module', 'trim|required');
        $this->form_validation->set_rules('id_theme','Theme','trim|required');
        $this->form_validation->set_rules('description','Description','trim');
        $this->form_validation->set_rules('class','class','trim');
        $this->form_validation->set_rules('color','color','trim');
        $this->form_validation->set_rules('size','size','trim');
        
        if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_file_model->insert_entry();
			echo "1";
		}
	}


	function edit($id=0){
		$this->authentication->verify('admin_file','edit');

		$data['ina'] = $this->admin_file_model->get_data_row($id,'ina');
        $data['en'] = $this->admin_file_model->get_data_row($id,'en');
        $data['action']="edit";

		echo $this->parser->parse("admin/files/form",$data,true);
	}

	function doedit($id=0){
		$this->authentication->verify('admin_file','edit');

		$this->form_validation->set_rules('ina','Filename Ina','trim|required');
		$this->form_validation->set_rules('en','Filename English','trim|required');
		$this->form_validation->set_rules('module', 'Module', 'trim|required');
        $this->form_validation->set_rules('id_theme','Theme','trim|required');
        $this->form_validation->set_rules('description','Description','trim');
        $this->form_validation->set_rules('class','class','trim');
        $this->form_validation->set_rules('color','color','trim');
        $this->form_validation->set_rules('size','size','trim');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_file_model->update_entry($id);
			echo "1";
		}
	}
    
    function dodel($id){
        $this->authentication->verify('admin_file','del');

		if($this->admin_file_model->delete_entry($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}    
    }
	
	function show_list(){
		$this->authentication->verify('admin_file','del');
		$data['action'] = 'add';
		
		echo $this->parser->parse("admin/files/list",$data,true);
	}
}
