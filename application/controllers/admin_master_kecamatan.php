<?php
class Admin_master_kecamatan extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('admin_master_kecamatan_model');
		$this->load->helper('html');
	}
	
	function index(){
		$this->authentication->verify('admin_master_kecamatan','edit');
		$data['title'] = "Master Data - Kecamatan";

		$data['content'] = $this->parser->parse("admin/kecamatan/show",$data,true);

		$this->template->show($data,"home");
	}

	function json_kecamatan(){
	   die(json_encode($this->admin_master_kecamatan_model->json_kecamatan()));   
	}
    
    function add(){
		$this->authentication->verify('admin_master_kecamatan','add');

		$data['title_form']="kecamatan &raquo; Tambah";
		$data['action']="add";

		echo $this->parser->parse("admin/kecamatan/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('admin_master_kecamatan','add');

		$this->form_validation->set_rules('id_kecamatan', 'ID Kecamatan', 'trim|required');
        $this->form_validation->set_rules('nama_kecamatan', 'Nama Kecamatan', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_kecamatan_model->insert_entry();
			echo "1";
		}
	
	}
	
	function edit($id_kecamatan=0)
	{
		$this->authentication->verify('admin_master_kecamatan','add');

		$data = $this->admin_master_kecamatan_model->get_data_row($id_kecamatan); 
		$data['title_form']="kecamatan &raquo; Ubah";
		$data['action']="edit";

		echo $this->parser->parse("admin/kecamatan/form",$data,true);
	}

	function doedit($id_kecamatan=0)
	{
		$this->authentication->verify('admin_master_kecamatan','edit');

		$this->form_validation->set_rules('nama_kecamatan', 'Nama Kecamatan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_kecamatan_model->update_entry($id_kecamatan);
			echo "1";
		}
		
	}
	
	function dodel($id_kecamatan=0){
		$this->authentication->verify('admin_master_kecamatan','del');

		if($this->admin_master_kecamatan_model->delete_entry($id_kecamatan)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}

}
