<?php
class Admin_master_departemen extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('admin_master_departemen_model');
        $this->load->helper('html');
    }
    
    function index(){
        $this->authentication->verify('admin_master_departemen','edit');
		$data['title'] = "Master Data - Departemen";

		$data['content'] = $this->parser->parse("admin/departemen/show",$data,true);

		$this->template->show($data,"home");
    }
    
    function json_departemen(){
        die(json_encode($this->admin_master_departemen_model->json_departemen()));
    }
    
    function add(){
		$this->authentication->verify('admin_master_departemen','add');

		$data['title_form']="Departemen &raquo; Tambah";
		$data['action']="add";

		echo $this->parser->parse("admin/departemen/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('admin_master_departemen','add');
        
        $this->form_validation->set_rules('jenis', 'Jenis', 'trim|required');
		$this->form_validation->set_rules('ket', 'Keterangan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_departemen_model->insert_entry();
			echo "1";
		}
	
	}
	
	function edit($id_departemen=0){
		$this->authentication->verify('admin_master_departemen','add');

		$data = $this->admin_master_departemen_model->get_data_row($id_departemen); 
		$data['title_form']="Departemen &raquo; Ubah";
		$data['action']="edit";

		echo $this->parser->parse("admin/departemen/form",$data,true);
	}

	function doedit($id_departemen=0)
	{
		$this->authentication->verify('admin_master_departemen','edit');

		$this->form_validation->set_rules('jenis', 'Jenis', 'trim|required');
		$this->form_validation->set_rules('ket', 'Keterangan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_departemen_model->update_entry($id_departemen);
			echo "1";
		}
	}
	
	function dodel($id_departemen=0){
		$this->authentication->verify('admin_master_departemen','del');

		if($this->admin_master_departemen_model->delete_entry($id_departemen)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
}
?>