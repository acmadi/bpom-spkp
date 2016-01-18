<?php

class Admin_user extends CI_Controller {

	var $limit=20;
	var $page=1;

    public function __construct(){
		parent::__construct();
		$this->load->model('admin_users_model');
        $this->load->model('location_model');
		$this->load->helper('captcha');
		$this->load->helper('html');
	}
	
	function index(){
		$this->authentication->verify('admin_user','edit');
        $data['title'] = "Master Data - User";
        $data['content'] = $this->parser->parse("admin/users/show",$data,true);

		$this->template->show($data,'home');
	}
    
    function json_admin(){
        die(json_encode($this->admin_users_model->json_admin()));
    }
    
	function excel(){
		$this->authentication->verify('admin_user','edit');
		ini_set('zlib.output_compression','Off');
		header("Cache-Control: public");
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: pre-check=0, post-check=0, max-age=0');
		header("Content-Description: File Transfer"); 
		header("Content-type: application/vnd.ms-excel");
		header("Content-type: application/x-msexcel");    
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-disposition: attachment; filename=bpom_userlist_".date("YdmHis").".xls");
		header("Content-Transfer-Encoding: binary"); 
		$data['query'] = $this->admin_users_model->get_data_all(); 
		$this->parser->parse("admin/users/excel",$data);
	}
    
    function add(){
        $this->authentication->verify('admin_user','add');
        $data['action']="add";

		echo $this->parser->parse("admin/users/form_user",$data,true);
    }
    
    function doadd(){
        $this->authentication->verify('admin_user','add');
        
        $this->form_validation->set_rules('username','Username','trim|required');
        $this->form_validation->set_rules('level','Level','trim|required');
        $this->form_validation->set_rules('password','Password','trim|required');
        $this->form_validation->set_rules('password2','Confirm Password','trim|required|matches[password]');
        
        $this->form_validation->set_rules('nip','NIP','trim|required');
        $this->form_validation->set_rules('nama','Nama','trim|required');
        $this->form_validation->set_rules('gendre','Gendre','trim|required');
        $this->form_validation->set_rules('birthdate','Tanggal Lahir','trim|required');
        $this->form_validation->set_rules('birthplace','Tempat lahir','trim|required');
        $this->form_validation->set_rules('phone_number','Phone Number','trim');
        $this->form_validation->set_rules('mobile','Mobile','trim');
        $this->form_validation->set_rules('email','Email','trim|valid_email');
        
        $this->form_validation->set_rules('address','Alamat','trim|required');
        $this->form_validation->set_rules('propinsi','Propinsi','trim|required');
        $this->form_validation->set_rules('kota','Kota','trim|required');
        
        $this->form_validation->set_rules('badan_tinggi','Tinggi Badan','trim|required');
        $this->form_validation->set_rules('badan_berat','Berat Badan','trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_users_model->insert_entry();
			echo "1";
		}
    }
    
    function edit($id){
        $this->authentication->verify('admin_user','edit');

		$data = $this->admin_users_model->get_data_row($id); 
		$data['action']="edit";

		echo $this->parser->parse("admin/users/form_user",$data,true);
    }
    
    function doedit($id=0){
        $this->authentication->verify('admin_user','edit');

		$this->form_validation->set_rules('nip','NIP','trim|required');
        $this->form_validation->set_rules('nama','Nama','trim|required');
        $this->form_validation->set_rules('gendre','Gendre','trim|required');
        $this->form_validation->set_rules('birthdate','Tanggal Lahir','trim|required');
        $this->form_validation->set_rules('birthplace','Tempat lahir','trim|required');
        $this->form_validation->set_rules('phone_number','Phone Number','trim');
        $this->form_validation->set_rules('mobile','Mobile','trim');
        $this->form_validation->set_rules('email','Email','trim|valid_email');
        
        $this->form_validation->set_rules('address','Alamat','trim|required');
        $this->form_validation->set_rules('propinsi','Propinsi','trim|required');
        $this->form_validation->set_rules('kota','Kota','trim|required');
        
        $this->form_validation->set_rules('badan_tinggi','Tinggi Badan','trim|required');
        $this->form_validation->set_rules('badan_berat','Berat Badan','trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->admin_users_model->update_profile($id);
			echo "1";
		}
    }
    
    function edit_password($id){
       $this->authentication->verify('admin_user','edit');

	   $data = $this->admin_users_model->get_user_list($id); 
	   $data['action']="edit_password";
       $data['password']="password";
       $data['password2']="password";
        
        $vals = array (
		'img_path' => './captcha/', 
		'img_url' => base_url().'captcha/', 
		'font_path' => './system/fonts/BERNHC.TTF',
		'img_width'	 => '200',
		'img_height' => 60,
		'expiration' => 60 
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
         
	   echo $this->parser->parse("admin/users/form_user_password",$data,true);        
    }
    
    function doedit_password($id){
        $this->authentication->verify('admin_user','add');

		$this->form_validation->set_rules('captcha', 'Captcha', 'callback_valid_captcha');
		
		if($this->input->post('password')!="password" && $this->input->post('password2')!="password"){
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('password2', 'Confirm Password', 'trim|required|matches[password]|md5');
		}

		if($this->form_validation->run()== FALSE){
		    echo validation_errors();
		}elseif($this->admin_users_model->update_entry($id)){
			echo "1";
		}
    }
    
    function dodel($id){
        $this->authentication->verify('admin_user','del');

		if($this->admin_users_model->delete_entry($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}    
    }
    
    function select_kota($propinsi,$kotakab=0){
		$data = $this->location_model->select_kotakab($propinsi,$kotakab);

		header('Content-type: text/X-JSON');
		echo json_encode($data);
		exit;
	}

	function select_kecamatan($kotakab,$kecamatan=0){
		$data = $this->location_model->select_kecamatan($kotakab,$kecamatan);

		header('Content-type: text/X-JSON');
		echo json_encode($data);
		exit;
	}

	function select_desa($kecamatan,$desa=0){
		$data = $this->location_model->select_desa($kecamatan,$desa);

		header('Content-type: text/X-JSON');
		echo json_encode($data);
		exit;
	}

    /*
	function add(){
		$this->authentication->verify('admin_user','add');

		$this->session->set_flashdata($_POST);
		
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('password2', 'Confirm Password', 'trim|required|matches[password]');
      
        $this->form_validation->set_rules('name','Full Name','trim|required');
        $this->form_validation->set_rules('name_display','Name Display','trim|required');
        $this->form_validation->set_rules('grade','Grade','trim|required');
        $this->form_validation->set_rules('gendre','Gendre','trim|required');
        $this->form_validation->set_rules('birthdate','Birthdate','trim');
        $this->form_validation->set_rules('birthplace','Place Of Birth','trim');
        $this->form_validation->set_rules('id_number','ID/KTP/SIM','trim');
        $this->form_validation->set_rules('address','Address','trim');
        $this->form_validation->set_rules('phone_number','Phone Number','trim');
        $this->form_validation->set_rules('mobile','Mobile','trim');
        $this->form_validation->set_rules('email','Email','trim|valid_email');
        
        
		if($this->form_validation->run()== FALSE){
			$this->session->set_flashdata('alert_form', validation_errors());

			$data['level_option']=$this->admin_users_model->get_level();
			$data['title_form']="Users &raquo; Tambah";
			$data['action']="add";

			$data['id']="";
			$data['username']=$this->session->flashdata('username');
			$data['level']=$this->session->flashdata('level');
			$data['password']=$this->session->flashdata('password');
			$data['password2']=$this->session->flashdata('password2');
			$data['status_active']=$this->session->flashdata('status_active');
            $data['user']="";
            $data['pwd']="";
            $data['cpwd']="";
            $data['name']="";
            $data['name_display']="";
            $data['birthdate']="";
            $data['place']="";
            $data['id_number']="";
            $data['address']="";
            $data['phone_number']="";
            $data['mobile']="";
            $data['email']="";
            
			$this->session->keep_flashdata('alert_form');
			foreach($data as $key=>$val){
				$this->session->keep_flashdata($key);
			}

			$data['grade']		= $this->admin_users_model->get_all_grade();
			$data['content'] = $this->parser->parse("admin/users/form",$data,true);
			$this->template->show($data,"home");

		}elseif($id=$this->admin_users_model->insert_entry()){
			$this->session->set_flashdata('alert_form', 'Save data successful...');
			redirect(base_url()."index.php/admin_user/");
		}else{
			$this->session->set_flashdata('alert_form', 'Save data failed...');
			redirect(base_url()."index.php/admin_user/add");
		}
	}
	*/
    
    function update_password($id=0){
        $this->authentication->verify('admin_user','edit');
        $data = $this->admin_users_model->get_user_id($id);
        $data['id']=$id;
        $data['title_form']="Users &raquo; Ubah";
        $data['password']="password";
        $data['password2']="password";
        
        $vals = array (
		'img_path' => './captcha/', //path image
		'img_url' => base_url().'captcha/', //path url untk nampilin img
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
        
        $data['content'] = $this->parser->parse("admin/users/user_account",$data,true);
        $this->template->show($data,"home");
    }
    
    function detail_profile($id=0){
        $this->authentication->verify('admin_user','add');
        $data = $this->admin_users_model->get_user_id($id);
        $data['id'] = $id;
        $data['title_form'] = "Users &raquo; Detail Account";
		$data['position']	= $this->admin_users_model->get_all_position();
        $data['gol']		= $this->admin_users_model->get_all_gol();
        $data['grade']		= $this->admin_users_model->get_all_grade();
        $data['balai']		= $this->admin_users_model->get_all_balai();
        
        $data['content'] = $this->parser->parse("admin/users/user_profile",$data,true);
        $this->template->show($data,"home");
    }
    

	function valid_captcha($str){
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
	  	
	function reg_resend_email(){
		$prof = $this->admin_users_model->get_data_prof();
		if($prof['email']!=""){
			$email= $prof['email'];
			$subject='Pendaftaran Fellowship Plasaindigo 2010';
			$message= 'Account : '.$email.'<br>';
			$message.='Untuk melakukan aktivasi keanggotaa, silahkan anda klik link di bawah ini:<br><br>';
			$message.=anchor(base_url()."index.php/users/aktivasi/".$this->session->userdata('id')."/".$this->session->userdata('username'),"Lakukan aktivasi sekarang!");
			$this->send_smtp($email,$subject,$message); 
			
			$this->session->set_flashdata('alert', 'Email verifikasi berhasil dikirim ulang.<br>Silahan periksa email anda.');
		}else{
			$this->session->set_flashdata('alert', 'Email anda masih salah.<br>Silahkan perbaiki alamat email anda.');
		}
		redirect(base_url()."index.php/admin_user/profile");
	}
	
	function reg_ok() {
		$data['username'] = $this->session->userdata('username');

		$data['content'] = $this->parser->parse("admin/users/reg_ok",$data,true);
		$this->template->show($data);
	}

	/*
	function doedit($id=0){
		$this->authentication->verify('admin_user','add');

		$this->form_validation->set_rules('captcha', 'Captcha', 'callback_valid_captcha');
		
		if($this->input->post('password')!="password" && $this->input->post('password2')!="password"){
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('password2', 'Confirm Password', 'trim|required|matches[password]|md5');
		}

		if($this->form_validation->run()== FALSE){
			$this->session->set_flashdata('alert', validation_errors());
			redirect(base_url()."index.php/admin_user/edit_account/".$id);
		}elseif($this->admin_users_model->update_entry($id)){
			$this->session->set_flashdata('alert', 'Save data successful...');
			redirect(base_url()."index.php/admin_user/edit_account/".$id);
		}else{
			$this->session->set_flashdata('alert', 'Save data failed...');
			redirect(base_url()."index.php/admin_user/edit_account/".$id);
		}
	}
   
	function doeditprofile_member(){
		$this->authentication->verify('admin_user','add');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('captcha', 'Captcha', 'callback_valid_captcha');
		$id=$this->input->post('id');
		if($this->form_validation->run()== FALSE){
			$this->session->set_flashdata('alert', validation_errors());
			redirect(base_url()."index.php/admin_user/profile");
		}elseif($this->admin_users_model->update_entry_profile($id)){
			$this->session->set_flashdata('alert', 'Save data successful...');
			redirect(base_url()."index.php/admin_user/profile");
		}else{
			$this->session->set_flashdata('alert', 'Save data failed...');
			redirect(base_url()."index.php/admin_user/profile");
		}
	}

	
	
	function dodel($id=0){
		$this->authentication->verify('admin_user','del');

		if($this->admin_users_model->delete_entry($id)){
			$this->session->set_flashdata('alert', 'Delete data successful...');
		}else{
			$this->session->set_flashdata('alert', 'Delete data failed...');
		}
		redirect(base_url()."index.php/admin_user");
	}
    
	function dodel_multi(){
		$this->authentication->verify('admin_user','del');

		if(is_array($this->input->post('id'))){
			foreach($this->input->post('id') as $data){
				$this->admin_users_model->delete_entry($data);
			}
			$this->session->set_flashdata('alert', 'Delete ('.count($this->input->post('id')).') data successful...');
		}else{
			$this->session->set_flashdata('alert', 'Nothing to delete.');
		}

		redirect(base_url()."index.php/admin_user");
	}
	
	 */
     	
	function forgot_pass()
	{

		$data['title_form']="Member &raquo; Lupa Kata Kunci";
		$data['email']=$this->session->flashdata('email');
		
		$data['action']="dogetpas";

		$vals = array (
		'img_path' => './captcha/', //path image
		'img_url' => base_url().'captcha/', //path url untk nampilin img
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


		$data['content'] = $this->parser->parse("admin/users/get_pas",$data,true);
		$this->template->show($data,"home");
	}
	
	function dogetpas(){
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('captcha', 'Captcha', 'callback_valid_captcha');
		$this->load->helper('string');
		$new_pass=random_string('alnum', 10);
		
		$email=$this->input->post('email');
		$subject='New Account Password';
		$message='Password Baru Anda : '.$new_pass;	

		if($this->form_validation->run()== FALSE){
			$this->session->set_flashdata('alert', validation_errors());
			redirect(base_url()."index.php/admin_user/forgot_pass/");
		}elseif($this->admin_users_model->get_data_pass($email,$new_pass)){
			$this->send_smtp($email,$subject,$message);
			$this->session->set_flashdata('alert', 'Perubahan password berhasil dilakukan.<br>Kami sudah mengirimkan password baru anda melalui email.<br>Silahkan periksa email anda');
			redirect(base_url()."index.php/admin_user/forgot_pass/");
		}else{
			$this->session->set_flashdata('alert', 'Maaf perubahan password gagal, anda salah memasukkan email.');
			redirect(base_url()."index.php/admin_user/forgot_pass/");
		}
		
		
	}

	function aktivation()
	{
		$data['title_form']="Aktivasi";
		
		$data['content'] = $this->parser->parse("admin/users/aktivasi",$data,true);
		$this->template->show($data);
	}
	
	function aktivatioff()
	{
		$data['title_form']="Aktivasi";
		
		$data['content'] = $this->parser->parse("admin/users/aktivasi_failed",$data,true);
		$this->template->show($data);
	}
	
	function aktivasi($id=0,$mail=""){		
		if($this->admin_users_model->update_aktivasi($id,$mail)){
			$this->session->set_flashdata('alert', 'Email anda berhasil di verivikasi.');
			redirect(base_url()."index.php/admin_user/aktivation/");
		}else{
			$this->session->set_flashdata('alert', 'Email anda gagal di verivikasi.');
			redirect(base_url()."index.php/admin_user/aktivatioff/");
		}
	}
	
	function send_smtp($email,$subject,$message)
	{
		$this->load->library('email');
		//error_reporting(0);
		$data=$this->admin_users_model->get_mail_config();
		$data['message'] = $message;
		$data['signature'] = $data['mail_signature'];
		
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = $data['mail_server'];
		$config['smtp_port'] = $data['mail_port'];
		$config['smtp_user'] = $data['mail_user'];
		$config['smtp_pass'] = $data['mail_password'];
		$config['smtp_timeout'] = 5;
		$config['validate'] = TRUE;
		$config['priority'] = 1;
		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['useragent'] = "plasaindigo";

		$this->email->initialize($config);

		$this->email->from($data['mail_user'], 'Admin Fellowship');
		$this->email->to($email);
		$this->email->subject($subject);
		$this->email->message($this->parser->parse('users/email',$data)); 
		$this->email->send();
		//echo $this->email->print_debugger();*/
	}
	
	function send_smtp2($email,$subject,$message)
	{
		$this->load->library('email');
		//error_reporting(0);
		$data=$this->admin_users_model->get_mail_config();
		$data['message'] = $message;
		$data['signature'] = $data['mail_signature'];
		
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = $data['mail_server'];
		$config['smtp_port'] = $data['mail_port'];
		$config['smtp_user'] = $data['mail_user'];
		$config['smtp_pass'] = $data['mail_password'];
		$config['smtp_timeout'] = 5;
		$config['validate'] = TRUE;
		$config['priority'] = 1;
		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['useragent'] = "plasaindigo";

		$this->email->initialize($config);

		$this->email->from('no-reply@fellowship.plasaindigo.com', 'Admin Fellowship');
		$this->email->to($email);
		$this->email->subject($subject);
		$this->email->message($this->parser->parse('users/email',$data)); 
		$this->email->send();
		echo $this->email->print_debugger();
	}
	
	function douploadimages($id){
		$module='users';
		$config['upload_path'] = 'media/images/'.$module.'/'.$id;
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
