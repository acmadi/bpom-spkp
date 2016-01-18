<?php
class Admin_master_subdit extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('admin_master_subdit_model');
        $this->load->helper('html');
    }
    
    function index(){
        $this->authentication->verify('admin_master_subdit','edit');
		$data['title'] = "Master Data - Subdit";

		$data['content'] = $this->parser->parse("admin/subdit/show",$data,true);

		$this->template->show($data,"home");
    }
    
    function json_subdit(){
        die(json_encode($this->admin_master_subdit_model->json_subdit()));
    }
    
    function add(){
		$this->authentication->verify('admin_master_subdit','add');

		$data['title_form']="Subdit &raquo; Tambah";
		$data['action']="add";
		$data['option_subdit']=$this->crud->option_subdit_top(1,"style='height:25px'");

		$data['option_status']= "<select id='status' name='status' style='height:25px'>";
		$data['option_status'] .= "<option value='direktur'>Direktur</option>";
		$data['option_status'] .= "<option value='subdit'>Subdit</option>";
		$data['option_status'] .= "<option value='seksi'>Seksi</option>";
		$data['option_status']."</select>";
		

		echo $this->parser->parse("admin/subdit/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('admin_master_subdit','add');

		$this->form_validation->set_rules('ket', 'Keterangan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_subdit_model->insert_entry();
			echo "1";
		}
	
	}
	
	function edit($id_subdit=0){
		$this->authentication->verify('admin_master_subdit','add');

		$data = $this->admin_master_subdit_model->get_data_row($id_subdit); 
		$data['title_form']="Subdit &raquo; Ubah";
		$data['action']="edit";
		$data['option_subdit']=$this->crud->option_subdit_top($data['id_top'],"style='height:25px'");

		$data['option_status']= "<select id='status' name='status' style='height:25px'>";
		$data['option_status'] .= "<option value='direktur' ".($data['status']=="direktur" ? "selected":"").">Direktur</option>";
		$data['option_status'] .= "<option value='subdit' ".($data['status']=="subdit" ? "selected":"").">Subdit</option>";
		$data['option_status'] .= "<option value='seksi' ".($data['status']=="seksi" ? "selected":"").">Seksi</option>";
		$data['option_status']."</select>";

		echo $this->parser->parse("admin/subdit/form",$data,true);
	}

	function doedit($id_subdit=0)
	{
		$this->authentication->verify('admin_master_subdit','edit');

		$this->form_validation->set_rules('ket', 'Keterangan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_subdit_model->update_entry($id_subdit);
			echo "1";
		}
	}
	
	function dodel($id_subdit=0){
		$this->authentication->verify('admin_master_subdit','del');

		if($this->admin_master_subdit_model->delete_entry($id_subdit)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
}
?>