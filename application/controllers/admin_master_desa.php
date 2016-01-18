<?php
class Admin_master_desa extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('admin_master_desa_model');
		$this->load->helper('html');
	}
	
	function index(){
		$this->authentication->verify('admin_master_desa','edit');
		$data['title'] = "Master Data - Desa";

		$data['content'] = $this->parser->parse("admin/desa/show",$data,true);

		$this->template->show($data,"home");
	}

    function json_desa(){
        die(json_encode($this->admin_master_desa_model->json_desa()));
    }
	
	function add(){
		$this->authentication->verify('admin_master_desa','add');

		$data['title_form']="Desa &raquo; Tambah";
		$data['action']="add";

		echo $this->parser->parse("admin/desa/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('admin_master_desa','add');

		$this->form_validation->set_rules('id_desa', 'ID Desa', 'trim|required');
        $this->form_validation->set_rules('nama_desa', 'Nama Desa', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_desa_model->insert_entry();
			echo "1";
		}
	
	}
	
	function edit($id_desa=0)
	{
		$this->authentication->verify('admin_master_desa','add');

		$data = $this->admin_master_desa_model->get_data_row($id_desa); 
		$data['title_form']="Desa &raquo; Ubah";
		$data['action']="edit";

		echo $this->parser->parse("admin/desa/form",$data,true);
	}

	function doedit($id_desa=0)
	{
		$this->authentication->verify('admin_master_desa','edit');

		$this->form_validation->set_rules('nama_desa', 'Nama Desa', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_desa_model->update_entry($id_desa);
			echo "1";
		}
		
	}
	
	function dodel($id_desa=0){
		$this->authentication->verify('admin_master_desa','del');

		if($this->admin_master_desa_model->delete_entry($id_desa)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}

}
