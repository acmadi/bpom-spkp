<?php
class Users_model extends CI_Model  {

    var $tabel    = 'app_users_list';
	var $tabel2    = 'app_users_profile';

    function __construct() {
        parent::__construct();
		$this->load->library('encrypt');
   }
    
    function get_count($options=array())
    {
		foreach($options as $x=>$y){
			if($y=="-" || $y=="" || $y=="0"){
				continue;
			}
			else{
				if($x=="username"){
					$this->db->like("app_users_list.username",$y);
				}else{
					$this->db->like($x,$y);
				}
			}
		}

        $query = $this->db->get($this->tabel);
        return $query->num_rows();
    }

    function get_data($start,$limit,$options=array())
    {
		foreach($options as $x=>$y){
			if($y=="-" || $y=="" || $y=="0"){
				continue;
			}
			else{
				if($x=="username"){
					$this->db->like("app_users_list.username",$y);
				}else{
					$this->db->like($x,$y);
				}
			}
		}
		$this->db->join($this->tabel2,"app_users_profile.id=app_users_list.id","right");
        $query = $this->db->get($this->tabel,$limit,$start);
        return $query->result();
    }

    function get_data_all()
    {
		$this->db->select("app_users_list.*,app_users_profile.*,prm_kota.daerah AS city_id,prm_location.nama AS location_id");
		$this->db->from($this->tabel);
		$this->db->order_by($this->tabel.'.id','ASC');
		$this->db->join($this->tabel2, $this->tabel.'.id='.$this->tabel2.'.id', 'left');
		$this->db->join("prm_kota", "prm_kota.kode=app_users_profile.city_id", 'left');
		$this->db->join("prm_location", "prm_location.id=app_users_profile.location_id", 'left');
		$query = $this->db->get();
        return $query->result();
    }

 	function get_data_row($id){
		$options = array('id' => $id);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}
	
    function get_city($location_id=0)
    {
		$data = array();
		
 		$this->db->where("kode LIKE '".$location_id."%'");
        $this->db->order_by("daerah","ASC");
        $query = $this->db->get("prm_kota");
		$data["0"]= "-";
        foreach($query->result_array() as $key=>$dt){
			$data[$dt['kode']]=$dt['daerah'];
		}
		return $data;
    }

	function get_data_prof(){
		$data = array();
		$username= $this->session->userdata('username');
		$options = array('username' => $username);
		
		$query = $this->db->get_where($this->tabel2,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

	function get_validasi_username($username){
		$data = array();
		$options = array('username' => $username);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result(); 
		return $data;
	}

	function get_data_pass($email,$new_pass){
		$data['password']=$this->encrypt->sha1($new_pass);

		$options = array('email' => $email);
		$query = $this->db->get_where($this->tabel2,$options,1);
		if ($query->num_rows() > 0){
			$dt = $query->row_array();
			return $this->db->update($this->tabel, $data, array('id' => $dt['id']));
		}else{
			return false;
		}
	}

 	function get_data_profile_row($id){
		$data = array();
		$options = array($this->tabel.'.id' => $id);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$this->db->where($options);
		$this->db->select('app_users_list.username,app_users_list.level,app_users_list.status_active,app_users_list.online,app_users_list.last_login,app_users_profile.*');
		$this->db->from($this->tabel);
		$this->db->join('app_users_profile', 'app_users_list.id=app_users_profile.id', 'left');
		$this->db->group_by('app_users_list.id');
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}
		
		$query->free_result();    
		return $data;
	}
	
	function get_data_profile_email($email){
		$data = array();
		$options = array($this->tabel.'.username' => $email);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$this->db->where($options);
		$this->db->select('app_users_list.username,app_users_list.level,app_users_list.status_active,app_users_list.online,app_users_list.last_login,app_users_profile.*');
		$this->db->from($this->tabel);
		$this->db->join('app_users_profile', 'app_users_list.id=app_users_profile.id', 'left');
		$this->db->group_by('app_users_list.id');
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}
		
		$query->free_result();    
		return $data;
	}

   function insert_entry()
    {
		$data['username']=$this->input->post('username');
		$data['level']='member';
		$data['password']=$this->encrypt->sha1($this->input->post('password'));
		$data['status_active']='0';

        $this->db->insert($this->tabel, $data);
		return $this->db->insert_id();
    }

   function insert_entry_outside($username)
    {
		$data['username']=$username;
		$data['level']='member';
		$data['password']=$this->encrypt->sha1('member');
		$data['status_active']='0';

        $this->db->insert($this->tabel, $data);
		return $this->db->insert_id();
    }

	
    function update_entry($id)
    {
		$data['username']=$this->input->post('username');
		$data['level']=$this->input->post('level');
		if($this->input->post('password')!="password" && $this->input->post('password2')!="password"){
			$data['password']=$this->encrypt->sha1($this->input->post('password'));
		}
		$data['status_active']=number_format($this->input->post('status_active'));
        
		return $this->db->update($this->tabel, $data, array('id' => $id));
    }
	
	function update_aktivasi($id,$mail)
    {
    	$this->db->where('id', $id);
    	$this->db->where('username', $mail);
    	$q = $this->db->get('app_users_list');
    	if($q->num_rows()==1){
    		$data['status_active']='1';	
    		if($this->db->update($this->tabel, $data, array('id' => $id))){
    			return true;
    		}else{
    			return false;
    		}
    	}else{  		
    		return false;
    	}
    }

	function insert_entry_popup($id)
    {
		$data['id']=$id;
		$data['username']=$this->input->post('username');
		$data['email']=$this->input->post('username');
		$data['name_middle']=$this->input->post('name_middle');
		$data['name_display']=$this->input->post('name_middle');
		
		return $this->db->insert($this->tabel2, $data);
		
    }
	

	function insert_entry_profile($id)
    {
		$data['id']=$id;
		$data['username']=$this->input->post('username');
		$data['email']=$this->input->post('username');
		$data['name_first']=$this->input->post('name_first');
		$data['name_middle']=$this->input->post('name_middle');
		$data['name_end']=$this->input->post('name_end');
   		if(!$this->agent->is_mobile()){
			$data['avatar']=$this->input->post('avatar');
		}
		$data['name_display']=$this->input->post('name_display');
		$data['id_number']=$this->input->post('id_number');
		$data['grade']=$this->input->post('grade');
		$data['birthplace']=$this->input->post('birthplace');
		$data['phone_number']=$this->input->post('phone_number');
		$data['job_title']=$this->input->post('job_title');
		$data['company']=$this->input->post('company');
		$data['blogspot']=$this->input->post('blogspot');
		$data['location_id']=$this->input->post('location_id');
		$data['city_id']=$this->input->post('city_id');
		$data['address']=$this->input->post('address');
		$data['grade']=$this->input->post('grade');
   		if($this->agent->is_mobile()){
			$data['birthdate']=$this->input->post('birthdate').'-'.$this->input->post('bln').'-'.$this->input->post('thn');
		}else{
			$data['birthdate']=$this->input->post('birthdate');
		}
		$data['gendre']=$this->input->post('gendre');
		
		$data['mobile']=$this->input->post('mobile');
		$data['achievement']=$this->input->post('achievement');
		$data['about']=$this->input->post('about');
		$data['hobbies']=$this->input->post('hobbies');
		$data['affiliates']=$this->input->post('affiliates');
		$data['facebook']=$this->input->post('facebook');
		$data['twitter']=$this->input->post('twitter');
		$data['wordpress']=$this->input->post('wordpress');
		$data['occupation']=$this->input->post('occupation');
		
		
		return $this->db->insert($this->tabel2, $data);
		
    }
	
	function insert_entry_profile_outside($data)
    {
		return $this->db->insert($this->tabel2, $data);
    }
	
	function update_entry_profile_outside($id,$data)
    {
		if($this->db->update($this->tabel2, $data, array('id' => $id))){
			return TRUE;
		}else{
			$data['id'] = $id;
			return $this->db->insert($this->tabel2, $data);
		}
    }

	function update_entry_profile($id)
    {
		$data['username']=$this->input->post('username');
		$data['email']=$this->input->post('email');
		$data['name_first']=$this->input->post('name_first');
		$data['name_middle']=$this->input->post('name_middle');
		$data['name_end']=$this->input->post('name_end');
   		if(!$this->agent->is_mobile()){
			$data['avatar']=$this->input->post('avatar');
		}
		$data['name_display']=$this->input->post('name_display');
		$data['id_number']=$this->input->post('id_number');
		$data['grade']=$this->input->post('grade');
		$data['birthplace']=$this->input->post('birthplace');
		$data['phone_number']=$this->input->post('phone_number');
		$data['job_title']=$this->input->post('job_title');
		$data['company']=$this->input->post('company');
		$data['blogspot']=$this->input->post('blogspot');
		$data['location_id']=$this->input->post('location_id');
		$data['city_id']=$this->input->post('city_id');
		$data['address']=$this->input->post('address');
		$data['grade']=$this->input->post('grade');
   		if($this->agent->is_mobile()){
			$data['birthdate']=$this->input->post('birthdate').'-'.$this->input->post('bln').'-'.$this->input->post('thn');
		}else{
			$data['birthdate']=$this->input->post('birthdate');
		}
		
		$data['gendre']=$this->input->post('gendre');
		
		$data['mobile']=$this->input->post('mobile');
		$data['achievement']=$this->input->post('achievement');
		$data['about']=$this->input->post('about');
		$data['hobbies']=$this->input->post('hobbies');
		$data['affiliates']=$this->input->post('affiliates');
		$data['facebook']=$this->input->post('facebook');
		$data['twitter']=$this->input->post('twitter');
		$data['wordpress']=$this->input->post('wordpress');
		$data['occupation']=$this->input->post('occupation');

		$check = $this->db->get_where($this->tabel2, array('id' => $id));
		$check = $check->num_rows();
		
		if($check>0){
			return $this->db->update($this->tabel2, $data, array('id' => $id));
		}else{
			$data['id'] = $id;
			$data['username']=$this->input->post('username');
			return $this->db->insert($this->tabel2, $data);
		}

    }

	function delete_entry($id)
	{
		$this->db->where(array('id' => $id));
		$this->db->delete('app_users_profile');

		$this->db->where(array('id' => $id));
		return $this->db->delete($this->tabel);
	}

    function get_level($blank=0)
    {
        $query = $this->db->get('app_users_level');
		if($blank==1) $data[""]= "-";
        foreach($query->result_array() as $key=>$dt){
			$data[$dt['level']]=ucfirst($dt['level']);
		}
		$query->free_result();    
		return $data;
    }
    
    function get_mail_config(){
		$this->db->like('key', 'mail');
		$query=$this->db->get('app_config');
        foreach($query->result_array() as $key=>$dt){
			$data[$dt['key']]=$dt['value'];
		}

		return $data;
    }

    function get_location(){
        $this->db->order_by("nama","ASC");
    	$q=$this->db->get('prm_location');
    	return $q->result_array();
    }	
}