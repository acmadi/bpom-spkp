<?php

class Admin_staff extends CI_Controller {

	var $limit=20;
	var $page=1;

    public function __construct(){
		parent::__construct();
		$this->load->model('admin_staff_model');
		$this->load->helper('captcha');
		$this->load->helper('html');
	}
	
	function index()
	{
		$this->authentication->verify('admin_staff','edit');

		$_SEGS = $this->uri->ruri_to_assoc();

		$this->page		= isset($_SEGS['page']) ? !ctype_digit($_SEGS['page']) ? 1 : intval($_SEGS['page']) : 1;
		$this->start	= ($this->page-1) * $this->limit;

		unset($_SEGS['page']);
		$data['segments']='';
		foreach($_SEGS as $a=>$b){
			$data['segments'] .=$a.'/'.$b.'/';
		}

		$data['query'] = $this->admin_staff_model->get_data($this->start,$this->limit,$_SEGS); 
		$data['start'] = $this->start + 1; 
		$data['end'] = $this->start + count($data['query']); 
		$data['count'] = $this->admin_staff_model->get_count($_SEGS); 
		$data['page_count'] = ceil($data['count']/$this->limit); 
		$data['page'] = $this->page; 

		$data['kode']=(!isset($_SEGS['kode'])) ? $this->session->flashdata('kode') : $_SEGS['kode'];
		$data['name_display']=(!isset($_SEGS['name_display'])) ? $this->session->flashdata('name_display') : $_SEGS['name_display'];
		$data['kode_division']=(!isset($_SEGS['kode_division'])) ? $this->session->flashdata('kode_division') : $_SEGS['kode_division'];
		$data['division_option']=$this->admin_staff_model->get_division();
		$data['searchbox'] = $this->parser->parse("admin_staff/admin_staff/search",$data,true);

		$data['content'] = $this->parser->parse("admin_staff/admin_staff/show",$data,true);

		$this->template->show($data,'home');
	}


	function add()
	{
		$this->authentication->verify('admin_staff','add');

		$data['title_form']="Staff &raquo; Tambah";
		$data['action']="add";
		$data['division_option']=$this->admin_staff_model->get_division();
		$data['username_option']=$this->admin_staff_model->get_username();

		$this->form_validation->set_rules('kode', 'Kode Staff', 'trim|required|callback_kode_check');
		$this->form_validation->set_rules('name_display', 'Name', 'trim|required');
		$this->form_validation->set_rules('kode_division', 'Division', 'trim|required|callback_option_check');
		$this->form_validation->set_rules('email', 'email', 'trim');
		$this->form_validation->set_rules('gendre', 'gendre', 'trim');
		$this->form_validation->set_rules('birthdate', 'birthdate', 'trim');
		$this->form_validation->set_rules('birthplace', 'birthplace', 'trim');
		$this->form_validation->set_rules('id_number', 'id_number', 'trim');
		$this->form_validation->set_rules('address', 'address', 'trim');
		$this->form_validation->set_rules('grade', 'grade', 'trim');
		$this->form_validation->set_rules('job_title', 'job_title', 'trim');
		$this->form_validation->set_rules('phone_number', 'phone_number', 'trim');
		$this->form_validation->set_rules('mobile', 'mobile', 'trim');
		$this->form_validation->set_rules('achievement', 'achievement', 'trim');
		$this->form_validation->set_rules('about', 'about', 'trim');
		$this->form_validation->set_rules('hobbies', 'hobbies', 'trim');
		$this->form_validation->set_rules('facebook', 'facebook', 'trim');
		$this->form_validation->set_rules('twitter', 'twitter', 'trim');
		$this->form_validation->set_rules('wordpress', 'wordpress', 'trim');
		$this->form_validation->set_rules('blogspot', 'blogspot', 'trim');
		if($this->form_validation->run()== FALSE){
			$this->session->keep_flashdata('alert_form');
			foreach($data as $key=>$val){
				$this->session->keep_flashdata($key);
			}
			$vals = array (
			'img_path' => './captcha/', 
			'img_url' => base_url().'captcha/', 
			'font_path' => './system/fonts/BERNHC.TTF',
			'img_width'	 => '200',
			'img_height' => 60,
			'expiration' => 60 // one hour
			);
			$cap = create_captcha($vals);
			
			$capdb = array(
			'captcha_time' => $cap['time'],
			'ip_address' => $this->input->ip_address(),
			'word' => $cap['word']
			);
			
			$query = $this->db->insert_string('captcha', $capdb);
			$this->db->query($query);
			
			$data['cap'] = $cap;
			$data['content'] = $this->parser->parse("admin_staff/admin_staff/profile",$data,true);
			$this->template->show($data,"home");
		}elseif($this->admin_staff_model->insert_entry()){
			$this->session->set_flashdata('alert_form', 'Save data successful...');
			redirect(base_url()."index.php/admin_staff");
		}else{
			$this->session->keep_flashdata('alert_form');
			foreach($data as $key=>$val){
				$this->session->keep_flashdata($key);
			}

			$data['content'] = $this->parser->parse("admin_staff/admin_staff/profile",$data,true);
			$this->template->show($data,"home");
		}
	}
	
	function kode_check($str){
		if(count($this->admin_staff_model->get_data_row($str))){
			$this->form_validation->set_message('kode_check', 'Duplicate Kode');
			return false;
		}else{
			return true;
		}
	}

	function option_check($str){
		if($str=="0" || $str==""){
			$this->form_validation->set_message('option_check', 'The Division is required.');
			return false;
		}else{
			return true;
		}
	}

	function edit($kode=0)
	{
		$this->authentication->verify('admin_staff','edit');

		$data = $this->admin_staff_model->get_data_profile_row($kode); 
		$data['division_option']=$this->admin_staff_model->get_division();
		$data['username_option']=$this->admin_staff_model->get_username();

		$this->form_validation->set_rules('captcha', 'Captcha', 'callback_valid_captcha');
		$this->form_validation->set_rules('name_display', 'Name', 'trim|required');
		$this->form_validation->set_rules('kode_division', 'Division', 'trim|required|callback_option_check');
		$this->form_validation->set_rules('email', 'email', 'trim');
		$this->form_validation->set_rules('gendre', 'gendre', 'trim');
		$this->form_validation->set_rules('birthdate', 'birthdate', 'trim');
		$this->form_validation->set_rules('birthplace', 'birthplace', 'trim');
		$this->form_validation->set_rules('id_number', 'id_number', 'trim');
		$this->form_validation->set_rules('address', 'address', 'trim');
		$this->form_validation->set_rules('grade', 'grade', 'trim');
		$this->form_validation->set_rules('avatar', 'avatar', 'trim');
		$this->form_validation->set_rules('job_title', 'job_title', 'trim');
		$this->form_validation->set_rules('phone_number', 'phone_number', 'trim');
		$this->form_validation->set_rules('mobile', 'mobile', 'trim');
		$this->form_validation->set_rules('achievement', 'achievement', 'trim');
		$this->form_validation->set_rules('about', 'about', 'trim');
		$this->form_validation->set_rules('hobbies', 'hobbies', 'trim');
		$this->form_validation->set_rules('facebook', 'facebook', 'trim');
		$this->form_validation->set_rules('twitter', 'twitter', 'trim');
		$this->form_validation->set_rules('wordpress', 'wordpress', 'trim');
		$this->form_validation->set_rules('blogspot', 'blogspot', 'trim');
		
		if($this->form_validation->run()== FALSE){
			$data['kode'] = $kode;
			$data['title_form']="Staff &raquo; Ubah";
			$data['action']="edit";
	
			$vals = array (
			'img_path' => './captcha/', 
			'img_url' => base_url().'captcha/', 
			'font_path' => './system/fonts/BERNHC.TTF',
			'img_width'	 => '200',
			'img_height' => 60,
			'expiration' => 10 
			);
			$cap = create_captcha($vals);
			
			$capdb = array(
			'captcha_time' => $cap['time'],
			'ip_address' => $this->input->ip_address(),
			'word' => $cap['word']
			);
			
			$query = $this->db->insert_string('captcha', $capdb);
			$this->db->query($query);
			
			$data['cap'] = $cap;
	
			$data['content'] = $this->parser->parse("admin_staff/admin_staff/profile",$data,true);
			$this->template->show($data,"home");
		}elseif($this->admin_staff_model->update_entry($kode)){
			$this->session->set_flashdata('alert', 'Save data successful...');
			redirect(base_url()."index.php/admin_staff/");
		}else{
			$this->session->set_flashdata('alert', 'Save data failed...');
			redirect(base_url()."index.php/admin_staff/edit/".$kode);
		}
		
	}
	

      function valid_captcha($str)
      {
      	$expiration = time()-3600;
      	$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
      	$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ?
      	AND ip_address = ? AND captcha_time > ?";
      	$binds = array($str, $this->input->ip_address(), $expiration);
      	$query = $this->db->query($sql, $binds);
      	$row = $query->row();
		if ($row->count == 0)
      	{
			$this->form_validation->set_message('valid_captcha', 'Captcha salah');
      		return FALSE;
      	}else{
      		return TRUE;
      	}
      }
	
	function dodel($id=0){
		$this->authentication->verify('admin_staff','del');

		if($this->admin_staff_model->delete_entry($id)){
			$this->session->set_flashdata('alert', 'Delete data successful...');
		}else{
			$this->session->set_flashdata('alert', 'Delete data failed...');
		}
		redirect(base_url()."index.php/admin_staff");
	}

	function dodel_multi(){
		$this->authentication->verify('admin_staff','del');

		if(is_array($this->input->post('id'))){
			foreach($this->input->post('id') as $data){
				$this->admin_staff_model->delete_entry($data);
			}
			$this->session->set_flashdata('alert', 'Delete ('.count($this->input->post('id')).') data successful...');
		}else{
			$this->session->set_flashdata('alert', 'Nothing to delete.');
		}

		redirect(base_url()."index.php/admin_staff");
	}

	function douploadimages($kode){
		$module='staff';
		$config['upload_path'] = 'media/images/'.$module.'/'.$kode;
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '100';
		$config['max_width']  = '800';
		$config['max_height']  = '500';

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
