<?php
class Admin_master_jenjang_jabatan extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('admin_master_jenjang_jabatan_model');
        $this->load->helper('html');
    }
    
    function index(){
        $this->authentication->verify('admin_master_jenjang_jabatan','edit');
		$data['title'] = "Master Data - Jenjang Jabatan";

		$data['content'] = $this->parser->parse("admin/jenjang_jabatan/show",$data,true);

		$this->template->show($data,"home");
    }
    
    function json_jenjang(){
        die(json_encode($this->admin_master_jenjang_jabatan_model->json_jenjang()));
    }
    
    function add(){
		$this->authentication->verify('admin_master_jenjang_jabatan','add');

		$data['title_form']="Jenjang Jabatan &raquo; Tambah";
		$data['action']="add";

		echo $this->parser->parse("admin/jenjang_jabatan/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('admin_master_jenjang_jabatan','add');
        
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_jenjang_jabatan_model->insert_entry();
			echo "1";
		}
	
	}
	
	function edit($id_jenjang=0){
		$this->authentication->verify('admin_master_jenjang_jabatan','add');

		$data = $this->admin_master_jenjang_jabatan_model->get_data_row($id_jenjang); 
		$data['title_form']="Jenjang Jabatan &raquo; Ubah";
		$data['action']="edit";

		echo $this->parser->parse("admin/jenjang_jabatan/form",$data,true);
	}

	function doedit($id_jenjang=0)
	{
		$this->authentication->verify('admin_master_jenjang_jabatan','edit');

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_jenjang_jabatan_model->update_entry($id_jenjang);
			echo "1";
		}
	}
	
	function dodel($id_jenjang=0){
		$this->authentication->verify('admin_master_jenjang_jabatan','del');

		if($this->admin_master_jenjang_jabatan_model->delete_entry($id_jenjang)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
}
?>