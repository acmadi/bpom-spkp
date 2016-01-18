<?php
class Admin_master_pendidikan extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('admin_master_pendidikan_model');
        $this->load->helper('html');
    }
    
    function index(){
        $this->authentication->verify('admin_master_pendidikan','edit');
		$data['title'] = "Master Data - Pendidikan";

		$data['content'] = $this->parser->parse("admin/pendidikan/show",$data,true);

		$this->template->show($data,"home");
    }
    
    function json_pendidikan(){
        die(json_encode($this->admin_master_pendidikan_model->json_pendidikan()));
    }
    
    function add(){
		$this->authentication->verify('admin_master_pendidikan','add');

		$data['title_form']="Pendidikan &raquo; Tambah";
		$data['action']="add";

		echo $this->parser->parse("admin/pendidikan/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('admin_master_pendidikan','add');
        
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		$this->form_validation->set_rules('tingkat', 'Tingkat', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_pendidikan_model->insert_entry();
			echo "1";
		}
	
	}
	
	function edit($id_pendidikan=0){
		$this->authentication->verify('admin_master_pendidikan','add');

		$data = $this->admin_master_pendidikan_model->get_data_row($id_pendidikan); 
		$data['title_form']="Pendidikan &raquo; Ubah";
		$data['action']="edit";

		echo $this->parser->parse("admin/pendidikan/form",$data,true);
	}

	function doedit($id_pendidikan=0)
	{
		$this->authentication->verify('admin_master_pendidikan','edit');

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		$this->form_validation->set_rules('tingkat', 'Tingkat', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_pendidikan_model->update_entry($id_pendidikan);
			echo "1";
		}
	}
	
	function dodel($id_pendidikan=0){
		$this->authentication->verify('admin_master_pendidikan','del');

		if($this->admin_master_pendidikan_model->delete_entry($id_pendidikan)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
}
?>