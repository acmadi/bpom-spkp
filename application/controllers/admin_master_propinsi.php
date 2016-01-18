<?php
class Admin_master_propinsi extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('admin_master_propinsi_model');
		$this->load->helper('html');
	}
	
	function index(){
		$this->authentication->verify('admin_master_propinsi','edit');
		$data['title'] = "Master Data - Propinsi";

		$data['content'] = $this->parser->parse("admin/propinsi/show",$data,true);

		$this->template->show($data,"home");
	}
    
    function json_propinsi(){
        die(json_encode($this->admin_master_propinsi_model->json_propinsi()));    
    }

	function add(){
		$this->authentication->verify('admin_master_propinsi','add');

		$data['title_form']="propinsi &raquo; Tambah";
		$data['action']="add";

		echo $this->parser->parse("admin/propinsi/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('admin_master_propinsi','add');
        
        $this->form_validation->set_rules('id_propinsi', 'ID propinsi', 'trim|required');
		$this->form_validation->set_rules('nama_propinsi', 'Nama propinsi', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_propinsi_model->insert_entry();
			echo "1";
		}
	
	}
	
	function edit($id_propinsi=0)
	{
		$this->authentication->verify('admin_master_propinsi','add');

		$data = $this->admin_master_propinsi_model->get_data_row($id_propinsi); 
		$data['title_form']="Propinsi &raquo; Ubah";
		$data['action']="edit";

		echo $this->parser->parse("admin/propinsi/form",$data,true);
	}

	function doedit($id_propinsi=0)
	{
		$this->authentication->verify('admin_master_propinsi','edit');

		$this->form_validation->set_rules('nama_propinsi', 'Nama propinsi', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_propinsi_model->update_entry($id_propinsi);
			echo "1";
		}
		
	}
	
	function dodel($id_propinsi=0){
		$this->authentication->verify('admin_master_propinsi','del');

		if($this->admin_master_propinsi_model->delete_entry($id_propinsi)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}

}
