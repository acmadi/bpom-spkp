<?php
class Admin_master_status_pernikahan extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('admin_master_status_pernikahan_model');
        $this->load->helper('html');
    }
    
    function index(){
        $this->authentication->verify('admin_master_status_pernikahan','edit');
		$data['title'] = "Master Data - Status Pernikahan";

		$data['content'] = $this->parser->parse("admin/pernikahan/show",$data,true);

		$this->template->show($data,"home");
    }
    
    function json_pernikahan(){
        die(json_encode($this->admin_master_status_pernikahan_model->json_pernikahan()));
    }
    
    function add(){
		$this->authentication->verify('admin_master_status_pernikahan','add');

		$data['title_form']="Status Pernikahan &raquo; Tambah";
		$data['action']="add";

		echo $this->parser->parse("admin/pernikahan/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('admin_master_status_pernikahan','add');
        
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_status_pernikahan_model->insert_entry();
			echo "1";
		}
	}
	
	function edit($id=0){
		$this->authentication->verify('admin_master_status_pernikahan','add');

		$data = $this->admin_master_status_pernikahan_model->get_data_row($id); 
		$data['title_form']="Status Pernikahan &raquo; Ubah";
		$data['action']="edit";

		echo $this->parser->parse("admin/pernikahan/form",$data,true);
	}

	function doedit($id=0){
		$this->authentication->verify('admin_master_status_pernikahan','edit');

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_status_pernikahan_model->update_entry($id);
			echo "1";
		}
	}
	
	function dodel($id=0){
		$this->authentication->verify('admin_master_status_pernikahan','del');

		if($this->admin_master_status_pernikahan_model->delete_entry($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
}
?>