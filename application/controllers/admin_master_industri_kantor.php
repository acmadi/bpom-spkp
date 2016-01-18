<?php

class Admin_master_industri_kantor extends CI_Controller {

	var $limit=10;
	var $page=1;

    public function __construct(){
		parent::__construct();
		$this->load->model('admin_master_industri_model');
		$this->load->helper('html');
	}
	
	function index(){
		$this->authentication->verify('admin_master_industri_kantor','edit');
		$_SEGS = $this->uri->ruri_to_assoc();

		$this->page		= isset($_SEGS['page']) ? !ctype_digit($_SEGS['page']) ? 1 : intval($_SEGS['page']) : 1;
		$this->start	= ($this->page-1) * $this->limit;

		unset($_SEGS['page']);
		$data['segments']='';
		foreach($_SEGS as $a=>$b){
			$data['segments'] .=$a.'/'.$b.'/';
		}

		$data['query'] = $this->admin_master_industri_model->get_data($this->start,$this->limit,$_SEGS); 
		$data['start'] = $this->start + 1; 
		$data['end'] = $this->start + count($data['query']); 
		$data['count'] = $this->admin_master_industri_model->get_count($_SEGS); 
		$data['page_count'] = ceil($data['count']/$this->limit); 
		$data['page'] = $this->page; 

		$data['id_industri']=(!isset($_SEGS['id_industri'])) ? $this->session->flashdata('id_industri') : $_SEGS['id_industri'];
		$data['nama_industri']=(!isset($_SEGS['nama_industri'])) ? $this->session->flashdata('nama_industri') : $_SEGS['nama_industri'];
		$data['searchbox'] = $this->parser->parse("admin/industri/search",$data,true);
		$data['content'] = $this->parser->parse("admin/industri/show",$data,true);

		$this->template->show($data,"home");
	}

	function add($id_industri){
		$this->authentication->verify('admin_master_industri_kantor','add');

		$data['title_form']="Kantor &raquo; Tambah";
		$data['action']="add";
		$data['id_industri'] = $id_industri;
		$data['id_kantor'] = $this->generate_id($id_industri);

		$this->form_validation->set_rules('id_industri', 'Id Industri', 'trim|required|callback_kode_check');
		$this->form_validation->set_rules('id_kantor', 'Id Kantor', 'trim|required');
		$this->form_validation->set_rules('alamat_kantor', 'Alamat Kantor', 'trim|required');
		
		if($this->form_validation->run()== FALSE){
			$this->session->keep_flashdata('alert_form');
			foreach($data as $key=>$val){
				$this->session->keep_flashdata($key);
			}
			$data['content'] = $this->parser->parse("admin/industri/form_kantor",$data,true);
			$this->template->show($data,"home");
		}elseif($this->admin_master_industri_model->insert_kantor()){
			$this->session->set_flashdata('alert_form', 'Save data successful...');
			redirect(base_url()."index.php/admin_master_industri/edit/$id_industri");
		}else{
			$this->session->keep_flashdata('alert_form');
			foreach($data as $key=>$val){
				$this->session->keep_flashdata($key);
			}

			$data['content'] = $this->parser->parse("admin/industri/form_kantor",$data,true);
			$this->template->show($data,"home");
		}
	}
	
	function edit($id_industri="",$id_kantor=1)
	{
		$this->authentication->verify('admin_master_industri_kantor','edit');

		$data = $this->admin_master_industri_model->get_kantor($id_industri,$id_kantor); 
		$this->form_validation->set_rules('alamat_kantor', 'Alamat Kantor', 'trim|required');
		
		if($this->form_validation->run()== FALSE){
			$data['id_industri'] = $id_industri;
			$data['id_kantor'] = $id_kantor;
			$data['title_form']="Kantor &raquo; Ubah";
			$data['action']="edit";
	
			$data['content'] = $this->parser->parse("admin/industri/form_kantor",$data,true);
			$this->template->show($data,"home");
		}elseif($this->admin_master_industri_model->update_kantor($id_industri,$id_kantor)){
			$this->session->set_flashdata('alert_form', 'Save data successful...');
			redirect(base_url()."index.php/admin_master_industri/edit/$id_industri");
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
			redirect(base_url()."index.php/admin_master_industri_kantor/edit/".$id_industri."/".$id_kantor);
		}
		
	}
	
	function generate_id($id){
		$qid = $this->admin_master_industri_model->get_max_kantor($id);
		$id = intval($qid["MAX"])+1;
		
		return $id;
	}
	
	function dodel($id_industri=0){
		$this->authentication->verify('admin_master_industri','del');

		if($this->admin_master_industri_model->delete_entry($id_industri)){
			$this->session->set_flashdata('alert_form', 'Delete data successful...');
		}else{
			$this->session->set_flashdata('alert_form', 'Delete data failed...');
		}
		redirect(base_url()."index.php/admin_master_industri");
	}

	function dodel_multi(){
		$this->authentication->verify('admin_master_industri','del');

		if(is_array($this->input->post('id_industri'))){
			foreach($this->input->post('id_industri') as $data){
				$this->admin_master_industri_model->delete_entry($data);
			}
			$this->session->set_flashdata('alert_form', 'Delete ('.count($this->input->post('id_industri')).') data successful...');
		}else{
			$this->session->set_flashdata('alert_form', 'Nothing to delete.');
		}

		redirect(base_url()."index.php/admin_master_industri");
	}
	
	function douploadimages($kode){
		$module='menus_cat';
		$config['upload_path'] = 'media/images/'.$module.'/'.$kode;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '200';
		$config['max_width']  = '200';
		$config['max_height']  = '200';

		$this->load->library('upload', $config);
		if(!file_exists($config['upload_path'])) {
			mkdir($config['upload_path']);
		}
	
		if (!$this->upload->do_upload('uploadfile'))
		{
			echo "failed|".$this->upload->display_errors();
		}	
		else
		{
			$data = array('upload_data' => $this->upload->data());
			echo "success|".$data['upload_data']['file_name'];
		}
		
	}

}
