<?php

	class User {
		
		var $id = 0;
		var $logged_in = false;
		var $username = '';
		var $table = 'app_users_list';
		var $table_profile = 'app_users_profile';
		var $level = array();
		var $groups = array();
		
		function User()
		{
			$this->obj =& get_instance();
			$this->obj->load->library('encrypt');
			if($this->obj->session->userdata('id') != ""){
				$data = array('last_active' => time());
				$where = "id = '".$this->obj->session->userdata('id')."'"; 
				if($str=$this->obj->db->update_string('app_users_list', $data, $where)){
					$this->obj->db->query($str);
				}
			}

			$data = array('online' => '0');
			$where = "last_active < '".(time()-60)."'"; 
			if($str=$this->obj->db->update_string('app_users_list', $data, $where)){
				$this->obj->db->query($str);
			}

		}

		function login($type=""){
			$this->obj->db-> where('app_users_list.username',$this->obj->input->post('email'));
			$this->obj->db-> where('password', $this->_prep_password($this->obj->input->post('password')));
			$this->obj->db-> where('status_active', '1');
			$this->obj->db-> join('app_users_profile', 'app_users_profile.id=app_users_list.id','right');
			$this->obj->db-> limit(1);
			$Q = $this->obj->db-> get($this->table);
			if ($Q-> num_rows() > 0){
				$user = $Q->row();
				$this->_start_session($user);

				$this->obj->db-> where('id',$this->obj->session->userdata('id'));
				$p = $this->obj->db-> get($this->table_profile);
				$profile = $p->row();
				if($profile->avatar!="" && @GetImageSize($profile->avatar)){
					$profile->avatar = $profile->avatar;
				}else{
					$profile->avatar = base_url()."media/images/profile.jpeg";
				}
				$profile = array(
						'avatar' 		=> $profile->avatar,
						'name_display'	=> $profile->name_display
					);
				$this->obj->session->set_userdata($profile);
					

				$this->obj->db->update('app_users_list', array('online' => 1,'last_login' => time()), array('id' => $user->id));
				$this->_log($type.' Login successful...');
				$this->obj->session->set_flashdata('notification', 'Login successful...');

				return true;
			}else{
				$this->_destroy_session();
				$this->_log($type.' Login failed...');
				$this->obj->session->set_flashdata('notification', 'Login failed...');
				
				return false;
			}
		}
		
		function get_user_id($dtime){
			$options['dtime']= $dtime;
			$options['username']= $this->obj->session->userdata('username');
			$query = $this->obj->db->getwhere('karya',$options,1);
			$data_user=array();
			if ($query->num_rows() > 0){
				$data = $query->row_array();
				$option_user = array('username' => $data['username']);
				$query_user = $this->obj->db->getwhere('app_users_list',$option_user,1);
				if ($query_user->num_rows() > 0){
					$data_user = $query_user->row();
				}
			}

			return $data_user;    
		}
				
		function logout($type="")
		{
			$this->obj->db->update('app_users_list', array('online' => 0), array('id' => $this->obj->session->userdata('id')));
			$this->update($this->username, array('online' => 0));
			$this->_log('Logout successful...');
			$this->_destroy_session();
			$this->obj->session->set_flashdata('notification', 'You are now logged out');
			redirect(base_url().$type);
		}
		
		function update($username, $data)
		{
			
			if (isset($data['password']))
			{
				$data['password'] = $this->_prep_password($data['password']);
			}
			
			$this->obj->db->where('username', $username);
			$this->obj->db->set($data);
			$this->obj->db->update($this->table);
			
		}
		
		function _log($message,$icon=1){
			if($this->obj->session->userdata('username') =="" ){
				$this->obj->session->set_userdata(array('username' => $_SERVER['REMOTE_ADDR']));
			}
			$data = array('username' => $this->obj->session->userdata('username'), 
				'dtime' => time(), 
				'icon' => $icon, 
				'activity' => $message
			);
			$str = $this->obj->db->insert_string('app_users_activity',$data);
			$this->obj->db->query($str);
		}
		
		function _destroy_session()
		{
			$data = array(
						'id' 		=> '',
						'email' 		=> '',
						'avatar' 		=> '',
						'username' 		=> '',
						'level' 		=> '',
						'status_active' => '',
						'logged_in'		=> false
					);
					
			$this->obj->session->set_userdata($data);
			
			foreach ($data as $key => $value)
			{
				$this->$key = $value;
			}
		}

		function _start_session($user)
		{
			$data = array(
						'id' 			=> $user->id,
						'username' 		=> $user->username,
						'email'			=> $user->username, 
						'level'			=> $user->level, 
						'status_active'	=> '', 
						//'status_active'	=> ($user->status_active==0 ? anchor(base_url().'users/profile','Unverified') : 'Verified'), 
						'logged_in'		=> true
					);
					
			$this->obj->session->set_userdata($data);
			
		}

		function _prep_password($password)
		{
			return $this->obj->encrypt->sha1($password.$this->obj->config->item('encryption_key'));
		}
		
	}	
