<?php
class Admin_master_keluarga extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('admin_master_keluarga_model');
        $this->load->helper('html');
    }
    
    function index(){
        $this->authentication->verify('admin_master_keluarga','edit');
		$data['title'] = "Master Data - Keluarga";

		$data['content'] = $this->parser->parse("admin/keluarga/show",$data,true);

		$this->template->show($data,"home");
    }
    
    function json_keluarga(){
        die(json_encode($this->admin_master_keluarga_model->json_keluarga()));
    }
    
    function add(){
		$this->authentication->verify('admin_master_keluarga','add');

		$data['title_form']="Keluarga &raquo; Tambah";
		$data['action']="add";

		echo $this->parser->parse("admin/keluarga/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('admin_master_keluarga','add');
        
        $this->form_validation->set_rules('nama', 'nama', 'trim|required');
		

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_keluarga_model->insert_entry();
			echo "1";
		}
	
	}
	
	function edit($id=0){
		$this->authentication->verify('admin_master_keluarga','add');

		$data = $this->admin_master_keluarga_model->get_data_row($id); 
		$data['title_form']="Keluarga &raquo; Ubah";
		$data['action']="edit";

		echo $this->parser->parse("admin/keluarga/form",$data,true);
	}

	function doedit($id=0){
		$this->authentication->verify('admin_master_keluarga','edit');

		$this->form_validation->set_rules('nama', 'nama', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_keluarga_model->update_entry($id);
			echo "1";
		}
	}
	
	function dodel($id=0){
		$this->authentication->verify('admin_master_keluarga','del');

		if($this->admin_master_keluarga_model->delete_entry($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
}
?>