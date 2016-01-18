<?php

class Admin_role extends CI_Controller {

	var $limit=20;
	var $page=1;

    public function __construct(){
		parent::__construct();
		$this->load->model('admin_role_model');

	}
	
	function index($page=1)
	{
		$this->authentication->verify('admin_role','show');

		$data['query'] = $this->admin_role_model->get_data_all(); 
		$data['start'] = 1; 

		$data['content'] = $this->parser->parse("admin/group_roles/show",$data,true);

		$this->template->show($data,"home");
	}

	function detail($id=0)
	{
		$this->authentication->verify('admin_role','edit');

		$this->form_validation->set_rules('level', 'Level', 'required');

		$data = $this->admin_role_model->get_data_row($id); 
		$data['query'] = $this->admin_role_model->get_privilege($id); 
		$data['title_form']="Group Roles &raquo; Ubah";
		$data['action']="doedit";

		$data['content'] = $this->parser->parse("admin/group_roles/form",$data,true);
		$this->template->show($data,"home");
	}

	function doedit($id=0){
		$this->authentication->verify('admin_role','edit');
		$this->admin_role_model->clear_privilege($this->uri->segment(3)); 
		foreach($_POST as $key=>$val){
			if($val==1){
				$tmp = explode("__",$key);
				$this->admin_role_model->save_privilege($this->uri->segment(3),$tmp[0],$tmp[1]); 
			}
		}
		$this->session->set_flashdata('alert_form', 'Update privilege successful...');
		redirect(base_url()."index.php/admin_role/detail/".$this->uri->segment(3));

	}


}
