<?php
class Admin_master_kota extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('admin_master_kota_model');
		$this->load->helper('html');
	}
	
	function index(){
		$this->authentication->verify('admin_master_kota','edit');
		$data['title'] = "Master Data - Kota";

		$data['content'] = $this->parser->parse("admin/kota/show",$data,true);

		$this->template->show($data,"home");
	}
    
    function json_kota(){
        die(json_encode($this->admin_master_kota_model->json_kota()));
    }

	function add(){
		$this->authentication->verify('admin_master_kota','add');

		$data['title_form']="Kota &raquo; Tambah";
		$data['action']="add";

		echo $this->parser->parse("admin/kota/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('admin_master_kota','add');
        
        $this->form_validation->set_rules('id_kota', 'ID Kota', 'trim|required');
		$this->form_validation->set_rules('nama_kota', 'Nama Kota', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_kota_model->insert_entry();
			echo "1";
		}
	
	}
	
	function edit($id_kota=0)
	{
		$this->authentication->verify('admin_master_kota','add');

		$data = $this->admin_master_kota_model->get_data_row($id_kota); 
		$data['title_form']="kota &raquo; Ubah";
		$data['action']="edit";

		echo $this->parser->parse("admin/kota/form",$data,true);
	}

	function doedit($id_kota=0)
	{
		$this->authentication->verify('admin_master_kota','edit');

		$this->form_validation->set_rules('nama_kota', 'Nama Kota', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_kota_model->update_entry($id_kota);
			echo "1";
		}
		
	}
	
	function dodel($id_kota=0){
		$this->authentication->verify('admin_master_kota','del');

		if($this->admin_master_kota_model->delete_entry($id_kota)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}

}
