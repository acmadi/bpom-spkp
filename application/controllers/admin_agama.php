<?php
class Admin_agama extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('admin_agama_model');
        $this->load->helper('html');
    }
    
    function index(){
        $this->authentication->verify('admin_agama','edit');
		$data['title'] = "Master Data - Agama";

		$data['content'] = $this->parser->parse("admin/agama/show",$data,true);

		$this->template->show($data,"home");
    }
    
    function json_agama(){
        die(json_encode($this->admin_agama_model->json_agama()));
    }
    
    function add(){
		$this->authentication->verify('admin_agama','add');

		$data['title_form']="Agama &raquo; Tambah";
		$data['action']="add";

		echo $this->parser->parse("admin/agama/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('admin_agama','add');
        
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_agama_model->insert_entry();
			echo "1";
		}
	
	}
	
	function edit($id_agama=0){
		$this->authentication->verify('admin_agama','add');

		$data = $this->admin_agama_model->get_data_row($id_agama); 
		$data['title_form']="Agama &raquo; Ubah";
		$data['action']="edit";

		echo $this->parser->parse("admin/agama/form",$data,true);
	}

	function doedit($id_agama=0)
	{
		$this->authentication->verify('admin_agama','edit');

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_agama_model->update_entry($id_agama);
			echo "1";
		}
	}
	
	function dodel($id_agama=0){
		$this->authentication->verify('admin_agama','del');

		if($this->admin_agama_model->delete_entry($id_agama)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
}
?>