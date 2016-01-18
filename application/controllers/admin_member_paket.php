<?php

class Admin_member_paket extends CI_Controller {

	var $limit=10;
	var $page=1;

    public function __construct(){
		parent::__construct();
		$this->load->model('admin_member_paket_model');
		$this->load->helper('html');
	}
	
	function index(){
		$this->authentication->verify('admin_member_paket','edit');

		$_SEGS = $this->uri->ruri_to_assoc();

		$this->page		= isset($_SEGS['page']) ? !ctype_digit($_SEGS['page']) ? 1 : intval($_SEGS['page']) : 1;
		$this->start	= ($this->page-1) * $this->limit;

		unset($_SEGS['page']);
		$data['segments']='';
		foreach($_SEGS as $a=>$b){
			$data['segments'] .=$a.'/'.trim($b).'/';
		}

		$data['query'] = $this->admin_member_paket_model->get_data($this->start,$this->limit,$_SEGS); 
		$data['start'] = $this->start + 1; 
		$data['end'] = $this->start + count($data['query']); 
		$data['count'] = $this->admin_member_paket_model->get_count($_SEGS); 
		$data['page_count'] = ceil($data['count']/$this->limit); 
		$data['page'] = $this->page; 

		$data['paket_option'] = array('-'=>'-','regular'=>'Regular GSC Member','sport'=>'Sport Member','student'=>'Student Member');
		$data['kode']=(!isset($_SEGS['kode'])) ? $this->session->flashdata('kode') : $_SEGS['kode'];
		$data['name']=(!isset($_SEGS['name'])) ? $this->session->flashdata('name') : $_SEGS['name'];
		$data['status']=(!isset($_SEGS['status'])) ? "-" : $_SEGS['status'];
		$data['type']=(!isset($_SEGS['type'])) ? "-" : $_SEGS['type'];
		$data['searchbox'] = $this->parser->parse("admin_member/admin_member_paket/search",$data,true);

		$data['content'] = $this->parser->parse("admin_member/admin_member_paket/show",$data,true);

		$this->template->show($data,"home");
	}

	function add(){
		$this->authentication->verify('admin_member_paket','add');

		$data['title_form']="Member Paket &raquo; Tambah";
		$data['action']="add";

		$this->form_validation->set_rules('kode', 'Kode', 'trim|required|callback_kode_check');
		$this->form_validation->set_rules('name', 'Nama', 'trim|required');
		$this->form_validation->set_rules('price', 'price', 'trim');
		$this->form_validation->set_rules('type', 'type', 'trim');
		$this->form_validation->set_rules('status', 'status', 'trim');
		$this->form_validation->set_rules('bulan', 'bulan', 'trim');
		$this->form_validation->set_rules('keterangan', 'keterangan', 'trim');
		if($this->form_validation->run()== FALSE){
			$this->session->keep_flashdata('alert_form');
			foreach($data as $key=>$val){
				$this->session->keep_flashdata($key);
			}
			$data['paket_option'] = array('-'=>'-','regular'=>'Regular GSC Member','sport'=>'Sport Member','student'=>'Student Member');
			$data['content'] = $this->parser->parse("admin_member/admin_member_paket/form",$data,true);
			$this->template->show($data,"home");
		}elseif($this->admin_member_paket_model->insert_entry()){
			$this->session->set_flashdata('alert_form', 'Save data successful...');
			redirect(base_url()."index.php/admin_member_paket");
		}else{
			$this->session->keep_flashdata('alert_form');
			foreach($data as $key=>$val){
				$this->session->keep_flashdata($key);
			}

			$data['content'] = $this->parser->parse("admin_member/admin_member_paket/form",$data,true);
			$this->template->show($data,"home");
		}
	}
	
	function edit($kode=0)
	{
		$this->authentication->verify('admin_member_paket','edit');

		$data = $this->admin_member_paket_model->get_data_row($kode); 
		
		$this->form_validation->set_rules('name', 'Nama', 'trim|required');
		$this->form_validation->set_rules('price', 'price', 'trim');
		$this->form_validation->set_rules('type', 'type', 'trim');
		$this->form_validation->set_rules('status', 'status', 'trim');
		$this->form_validation->set_rules('bulan', 'bulan', 'trim');
		$this->form_validation->set_rules('keterangan', 'keterangan', 'trim');
		
		if($this->form_validation->run()== FALSE){
			$data['kode'] = $kode;
			$data['title_form']="Member Paket &raquo; Ubah";
			$data['action']="edit";
	
			$data['paket_option'] = array('-'=>'-','regular'=>'Regular GSC Member','sport'=>'Sport Member','student'=>'Student Member');
			$data['content'] = $this->parser->parse("admin_member/admin_member_paket/form",$data,true);
			$this->template->show($data,"home");
		}elseif($this->admin_member_paket_model->update_entry($kode)){
			$this->session->set_flashdata('alert_form', 'Save data successful...');
			redirect(base_url()."index.php/admin_member_paket");
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
			redirect(base_url()."index.php/admin_member_paket/edit/".$kode);
		}
		
	}
	
	function kode_check($str){
		if(count($this->admin_member_paket_model->get_data_row($str))){
			$this->form_validation->set_message('kode_check', 'Duplicate Kode');
			return false;
		}else{
			return true;
		}
	}

	function dodel($kode=0){
		$this->authentication->verify('admin_member_paket','del');

		if($this->admin_member_paket_model->delete_entry($kode)){
			$this->session->set_flashdata('alert_form', 'Delete data successful...');
		}else{
			$this->session->set_flashdata('alert_form', 'Delete data failed...');
		}
		redirect(base_url()."index.php/admin_member_paket");
	}

	function dodel_multi(){
		$this->authentication->verify('admin_member_paket','del');

		if(is_array($this->input->post('kode'))){
			foreach($this->input->post('kode') as $data){
				$this->admin_member_paket_model->delete_entry($data);
			}
			$this->session->set_flashdata('alert_form', 'Delete ('.count($this->input->post('kode')).') data successful...');
		}else{
			$this->session->set_flashdata('alert_form', 'Nothing to delete.');
		}

		redirect(base_url()."index.php/admin_member_paket");
	}
	
		
}
