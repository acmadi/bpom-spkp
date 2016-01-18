<?php
class Admin_master_golongan extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('admin_master_golongan_model');
        $this->load->helper('html');
    }
    
    function index(){
        $this->authentication->verify('admin_master_golongan','edit');
		$data['title'] = "Master Data - Golongan";

		$data['content'] = $this->parser->parse("admin/golongan/show",$data,true);

		$this->template->show($data,"home");
    }
    
    function json_golongan(){
        die(json_encode($this->admin_master_golongan_model->json_golongan()));
    }
    
    function add(){
		$this->authentication->verify('admin_master_golongan','add');

		$data['title_form']="Golongan &raquo; Tambah";
		$data['action']="add";

		echo $this->parser->parse("admin/golongan/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('admin_master_golongan','add');
        
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
		$this->form_validation->set_rules('golongan', 'Golongan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_golongan_model->insert_entry();
			echo "1";
		}
	
	}
	
	function edit($id_golongan=0){
		$this->authentication->verify('admin_master_golongan','add');

		$data = $this->admin_master_golongan_model->get_data_row($id_golongan); 
		$data['title_form']="Golongan &raquo; Ubah";
		$data['action']="edit";

		echo $this->parser->parse("admin/golongan/form",$data,true);
	}

	function doedit($id_golongan=0)
	{
		$this->authentication->verify('admin_master_golongan','edit');

		$this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
		$this->form_validation->set_rules('golongan', 'Golongan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_golongan_model->update_entry($id_golongan);
			echo "1";
		}
	}
	
	function dodel($id_golongan=0){
		$this->authentication->verify('admin_master_golongan','del');

		if($this->admin_master_golongan_model->delete_entry($id_golongan)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
}
?>