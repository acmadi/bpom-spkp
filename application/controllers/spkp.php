<?php
class Spkp extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('spkp_model');
        $this->load->model('admin_users_model');
		$this->load->model('content_model');
        $this->load->model('location_model');
		$this->load->helper('html');
		$this->load->helper('captcha');
	}
	
	function index($page=1){
		$this->authentication->verify('spkp','show');
        
	    $data = $this->spkp_model->get_page($page);
	    $data['subs'] = $this->spkp_model->get_page_subs($page);
		$data['pagetab'] = strtolower(str_replace(" ","",$data['filename']));
		$data['dashboard'] = $this->parser->parse("spkp/dashboard",$data,true);
		
		$dt_a = $this->content_model->get_file_id('announcement');
		foreach($dt_a as $get){
			$val_a['file_id'] = $get->id;
		}
		$val_a['konten'] = $this->spkp_model->get_content($val_a['file_id']);
		$data['announcement'] = $this->parser->parse("spkp/announcement",$val_a,true);
		
		$dt = $this->content_model->get_file_id('news');
		foreach($dt as $get){
			$val['file_id'] = $get->id;
		}
		$val['konten'] = $this->spkp_model->get_content($val['file_id']);
		$data['news'] = $this->parser->parse("spkp/news",$val,true);
		
		$data['calendar'] = $this->parser->parse("spkp/calendar",$data,true);
		
		$dt_e = $this->content_model->get_file_id('event');
		foreach($dt_e as $get){
			$val_e['file_id'] = $get->id;
		}
		$val_e['konten'] = $this->spkp_model->get_content($val_e['file_id']);
		$data['event'] = $this->parser->parse("spkp/event",$val_e,true);
		
		$data['content']= $this->parser->parse("spkp/show",$data,true);
		
		$this->template->show($data,'home');
	}
    
	function detail($mod,$file_id,$id){
		$this->authentication->verify('spkp','show');
		$data['hits']=$this->spkp_model->get_detail_content($file_id,$id);
		foreach($data['hits'] as $get){
			$hits=$get['hits']+1;
		}
		$this->content_model->hits($file_id,$id,$hits);
		$page = 1;
		$data = $this->spkp_model->get_page($page);
		$sub = $this->content_model->get_file_id($mod);
		foreach($sub as $get){
			$sub = $get->filename;
		}
		$data['mod']=$mod;
		$data['add_permission'] = $this->authentication->verify_check($mod,'show');
	    $data['subs'] = $this->spkp_model->get_page_subs($page);
		$data['pagetab'] = strtolower(str_replace(" ","",$data['filename']));
		$data['dashboard'] = $this->parser->parse("spkp/dashboard",$data,true);
		
		$dt_a = $this->content_model->get_file_id('announcement');
		foreach($dt_a as $get){
			$val_a['file_id'] = $get->id;
		}
		$val_a['konten'] = $this->spkp_model->get_content($val_a['file_id']);
		$data['announcement'] = $this->parser->parse("spkp/announcement",$val_a,true);
		
		$dt = $this->content_model->get_file_id('news');
		foreach($dt as $get){
			$val['file_id'] = $get->id;
		}
		$val['konten'] = $this->spkp_model->get_content($val['file_id']);
		$data['news'] = $this->parser->parse("spkp/news",$val,true);
		
		$data['calendar'] = $this->parser->parse("spkp/calendar",$data,true);
		
		$dt_e = $this->content_model->get_file_id('event');
		foreach($dt_e as $get){
			$val_e['file_id'] = $get->id;
		}
		$val_e['konten'] = $this->spkp_model->get_content($val_e['file_id']);
		$data['event'] = $this->parser->parse("spkp/event",$val_e,true);
		
		$data['detail'] = $this->spkp_model->get_detail_content($file_id, $id);
		$data['content'] = $this->parser->parse("spkp/detail",$data,true);
		
		$this->template->show($data,'home');
	}
	
	function calendar(){
		$data = $this->content_model->get_file_id('event');
		foreach($data as $get){
			$file_id = $get->id;
		}
		die(json_encode($this->spkp_model->get_all_cuti($file_id)));
	}
	
    function edit_profile(){
        $this->authentication->verify('spkp','edit');
        
        $data = $this->spkp_model->get_user_profile();
        $data['list'] = $this->admin_users_model->get_user_list($this->session->userdata('id'));
        
        $data['title'] = "User Profile";
        $data['password']="password";
        $data['password2']="password";
        
        $vals = array (
		'img_path' => './captcha/', 
		'img_url' => base_url().'captcha/', 
		'font_path' => './system/fonts/BERNHC.TTF',
		'img_width'	 => '150',
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
       
        $data['form_profile'] = $this->parser->parse("spkp/profile/profile",$data,true);
        $data['form_password'] = $this->parser->parse("spkp/profile/password",$data,true);
        $data['content'] = $this->parser->parse("spkp/profile/show",$data,true);
        
        $this->template->show($data,"home");
    }
    
    function doedit_profile(){
        $this->authentication->verify('spkp','edit');
        
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
			if(count($_FILES)>0){
				$path = './media/images/user';
				if (!is_dir($path)) {
					mkdir($path);
				}
                
				$config['upload_path'] = $path;
				$config['allowed_types'] = '*';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$upload = $this->upload->do_upload('filename');
				if($upload === FALSE) {
					echo $this->upload->display_errors()."<br>";
				}else{
					$upload_data = $this->upload->data();
					$this->spkp_model->update_profile(1,$upload_data);
                    
					echo "1";
				}
			}else{
				$this->spkp_model->update_profile(2,"");
			    echo "1";
            }
		}
    }
    
     function load_form_password(){
       $this->authentication->verify('spkp','edit');

	   $data = $this->spkp_model->get_user_profile(); 
	   $data['list'] = $this->admin_users_model->get_user_list($this->session->userdata('id'));
       
       $data['password']="password";
       $data['password2']="password";
        
        $vals = array (
		'img_path' => './captcha/', 
		'img_url' => base_url().'captcha/', 
		'font_path' => './system/fonts/BERNHC.TTF',
		'img_width'	 => '150',
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
         
	   echo $this->parser->parse("spkp/profile/password",$data,true);        
    }
    
    function load_form_profile(){
       $this->authentication->verify('spkp','edit');

	   $data = $this->spkp_model->get_user_profile(); 
	 
       echo $this->parser->parse("spkp/profile/profile",$data,true);        
    }
    
    function doedit_password($id){
        $this->authentication->verify('spkp','add');

		$this->form_validation->set_rules('captcha', 'Captcha', 'callback_valid_captcha');
		
		if($this->input->post('password')!="password" && $this->input->post('password2')!="password"){
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('password2', 'Confirm Password', 'trim|required|matches[password]|md5');
		}

		if($this->form_validation->run()== FALSE){
		    echo validation_errors();
		}else{
		    $this->spkp_model->update_password($id);
			echo "1";
		}
    }
    
    function get_small_profile(){
        $data = $this->spkp_model->get_user_profile();
        
        if($data['image']==""){
            $filename = base_url()."media/images/smily-user-icon.jpg";
        }else{
            $filename = base_url()."media/images/user/".$data['image'];
        }
        
         header('Content-Type: image/jpeg');
         
         list($width, $height) = getimagesize($filename);
         $newwidth = 29;
         $newheight = 29;
        
         $thumb = imagecreatetruecolor($newwidth, $newheight);
         $source = imagecreatefromjpeg($filename);
        
         imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
         $small = imagecreatetruecolor(29, 29);
		 imagecopy($small,$thumb,0, 0, 0, 0, 29, 29);
		 Imagejpeg($small);
		 ImageDestroy($small);
    }
    
    function get_image_profile_big($id){
        header('Content-Type: image/jpeg');
		$config['width'] = 220; 

        $data = $this->spkp_model->get_user_profile($id);
		$filename = getcwd()."/media/images/user/".$data['image'];
		if(!file_exists($filename) || $data['image']==""){
            $filename = getcwd()."/media/images/smily-user-icon.jpg";
		}
         
        list($width, $height) = getimagesize($filename);
		$percent=$config['width']/$width;
		$newwidth=$width*$percent;
		$newheight=$height*$percent;
        
         $thumb = imagecreatetruecolor($newwidth, $newheight);
         $source = imagecreatefromjpeg($filename);
        
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		 Imagejpeg($thumb);
		 ImageDestroy($thumb);
    }
    
    function get_image_profile($id){
        header('Content-Type: image/jpeg');
		$config['width'] = 140; 

        $data = $this->spkp_model->get_user_profile($id);
		$filename = getcwd()."/media/images/user/".$data['image'];
		if(!file_exists($filename) || $data['image']==""){
            $filename = getcwd()."/media/images/smily-user-icon.jpg";
		}
        
         
        list($width, $height) = getimagesize($filename);
		$percent=$config['width']/$width;
		$newwidth=$width*$percent;
		$newheight=$height*$percent;
        
         $thumb = imagecreatetruecolor($newwidth, $newheight);
         $source = imagecreatefromjpeg($filename);
        
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		 Imagejpeg($thumb);
		 ImageDestroy($thumb);
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
		  $this->form_validation->set_message('valid_captcha', 'Captcha did not match');
		  return FALSE;
	  }else{
		  return TRUE;
	  }
	}
	

	function login()
	{
		$this->form_validation->set_rules('email', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');

		if($this->form_validation->run()){
			if($this->user->login()){
				$this->session->set_flashdata('notification', 'Login successful...');			
				redirect(base_url());
			}else{
				$this->session->set_flashdata('notification', 'Login failed...');
			}
		}

		$data['title_form']="&raquo; Login";
		$data['panel']= "";

		$data['content'] = $this->parser->parse("spkp/login/login",$data,true);
		$this->template->show($data,'home');
	}

	function logout()
	{
		$this->user->logout();
	}
}
