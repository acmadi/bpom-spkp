<?php
class Admin_master_jenis_anggaran extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('admin_master_jenis_anggaran_model');
        $this->load->helper('html');
    }
    
    function index(){
        $this->authentication->verify('admin_master_jenis_anggaran','edit');
		$data['title'] = "Master Data - Jenis Anggaran";

		$data['content'] = $this->parser->parse("admin/jnsanggaran/show",$data,true);

		$this->template->show($data,"home");
    }
    
    function json_jenis(){
        die(json_encode($this->admin_master_jenis_anggaran_model->json_jenis()));
    }
    
    function add(){
		$this->authentication->verify('admin_master_jenis_anggaran','add');

		$data['title_form']="Jenis Anggaran &raquo; Tambah";
		$data['action']="add";

		echo $this->parser->parse("admin/jnsanggaran/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('admin_master_jenis_anggaran','add');
        
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_jenis_anggaran_model->insert_entry();
			echo "1";
		}
	}
	
	function edit($id=0){
		$this->authentication->verify('admin_master_jenis_anggaran','add');

		$data = $this->admin_master_jenis_anggaran_model->get_data_row($id); 
		$data['title_form']="Jenis Anggaran &raquo; Ubah";
		$data['action']="edit";

		echo $this->parser->parse("admin/jnsanggaran/form",$data,true);
	}

	function doedit($id=0){
		$this->authentication->verify('admin_master_jenis_anggaran','edit');

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_master_jenis_anggaran_model->update_entry($id);
			echo "1";
		}
	}
	
	function dodel($id=0){
		$this->authentication->verify('admin_master_jenis_anggaran','del');

		if($this->admin_master_jenis_anggaran_model->delete_entry($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
}
?>