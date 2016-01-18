<?php
class Admin_master_jabatan extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('admin_master_jabatan_model');
        $this->load->helper('html');
    }
    
    function index(){
        $this->authentication->verify('admin_master_jabatan','edit');
		$data['title'] = "Master Data - Jabatan";

		$data['content'] = $this->parser->parse("admin/jabatan/show",$data,true);

		$this->template->show($data,"home");
    }
    
    function json_jabatan(){
        die(json_encode($this->admin_master_jabatan_model->json_jabatan()));
    }
    
    function add(){
		$this->authentication->verify('admin_master_jabatan','add');
		$this->load->model('admin_master_subdit_model');
		//$data = $this->admin_master_jabatan_model->get_list_data_atasan();
		$data['title_form']="Jabatan &raquo; Tambah";
		$data['action']="add";

		echo $this->parser->parse("admin/jabatan/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('admin_master_jabatan','add');
        
		$this->form_validation->set_rules('id_subdit', 'Subdit', 'trim|required');
		$this->form_validation->set_rules('nama_jabatan', 'Jabatan', 'trim|required');	

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_jabatan_model->insert_entry();
			echo "1";
		}
	
	}
	
	function edit($id=0){
		$this->authentication->verify('admin_master_jabatan','add');
		
		$this->load->model('admin_master_subdit_model');	
		$data = $this->admin_master_jabatan_model->get_data_row($id); 
		$data['title_form']="Jabatan &raquo; Ubah";
		$data['action']="edit";

		echo $this->parser->parse("admin/jabatan/form",$data,true);
	}

	function doedit($id=0)
	{
		$this->authentication->verify('admin_master_jabatan','edit');
		
		$this->form_validation->set_rules('id_subdit', 'Subdit', 'trim|required');
		$this->form_validation->set_rules('nama_jabatan', 'Jabatan', 'trim|required');	

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_jabatan_model->update_entry($id);
			echo "1";
		}
	}
	
	function dodel($id=0){
		$this->authentication->verify('admin_master_persyaratan','del');

		if($this->admin_master_jabatan_model->delete_entry($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
	
	 function select_subdit($subdit,$id_parent=0){
		$data = $this->admin_master_jabatan_model->select_subdit($subdit,$id_parent);

		header('Content-type: text/X-JSON');
		echo json_encode($data);
		exit;
	}
		
}
?>