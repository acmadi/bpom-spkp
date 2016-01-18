<?php
class Admin_users_model extends CI_Model {

    var $tabel    = 'app_users_list';
	var $tabel2    = 'app_users_profile';

    function __construct() {
        parent::__construct();
		$this->load->library('encrypt');
    }
    
    function json_admin(){
        $query = "SELECT a.id, a.username, a.nama, IF(a.gendre='L','Male','Female') AS gendre, a.birthdate, a.birthplace, a.address, a.phone_number, a.mobile, a.email,
                  b.level, b.password, b.status_active, b.status_aproved, b.online, FROM_UNIXTIME(b.last_login,'%Y/%m/%d %T') AS last_login,
                  FROM_UNIXTIME(b.last_active,'%Y/%m/%d %T') AS last_active,b.datereg
                  FROM app_users_profile a INNER JOIN app_users_list b ON a.id = b.id";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_count(){
        return $this->db->count_all($this->tabel);
    }

    function get_data($start,$limit,$options=array())
    {
		foreach($options as $x=>$y){
			if($x=="username"){
				$this->db->like($x,$y);
			}else{
				$this->db->where($x,$y);
			}
		}
        $query = $this->db->get($this->tabel,$limit,$start);
        return $query->result();
    }

    function get_data_all()
    {
		$this->db->from($this->tabel);
		$this->db->order_by($this->tabel.'.username','DESC');
		$this->db->join($this->tabel2, $this->tabel.'.id='.$this->tabel2.'.id', 'left');
		$query = $this->db->get();
        return $query->result();
    }

 	function get_data_row($id){
		$options = array('id' => $id);
		$query = $this->db->get_where($this->tabel2,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
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
		$data['password']=$this->encrypt->sha1($new_pass.$this->config->item('encryption_key'));
		return $this->db->update($this->tabel, $data, array('username' => $email));
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

   function insert_entry(){
		$data['username']=$this->input->post('username');
		$data['level']=$this->input->post('level');
		$data['password']=$this->encrypt->sha1($this->input->post('password').$this->config->item('encryption_key'));
		$data['status_active']=$this->input->post('status_active');

        $this->db->insert($this->tabel, $data);
		$id = $this->db->insert_id();
		
        $val['id']=$id;
        $val['username']=$this->input->post('username');
        $val['nip']=str_replace(" ","",$this->input->post('nip'));
        $val['gelar']=$this->input->post('gelar');
        $val['nama']=$this->input->post('nama');
        $val['id_number']=$this->input->post('id_number');
        $val['birthdate']=$this->input->post('birthdate');
        $val['birthplace']=$this->input->post('birthplace');
        $val['gendre']=$this->input->post('gendre');
        $val['agama']=$this->input->post('agama');
        $val['kepercayaan']=$this->input->post('kepercayaan');
        $val['kawin']=$this->input->post('kawin');
        $val['phone_number']=$this->input->post('phone_number');
        $val['mobile']=$this->input->post('mobile');
        $val['email']=$this->input->post('email');
        
        $val['address']=$this->input->post('address');
        $val['propinsi']=$this->input->post('propinsi');
        $val['kota']=$this->input->post('kota');
        $val['kecamatan']=$this->input->post('kecamatan');
        $val['desa']=$this->input->post('desa');
        
        $val['badan_tinggi']=intval($this->input->post('badan_tinggi'));
        $val['badan_berat']=str_replace('_','',$this->input->post('badan_berat'));
        $val['badan_rambut']=$this->input->post('badan_rambut');
        $val['badan_muka']=$this->input->post('badan_muka');
        $val['badan_kulit']=$this->input->post('badan_kulit');
        $val['badan_khas']=$this->input->post('badan_khas');
        $val['badan_cacat']=$this->input->post('badan_cacat');
        $val['kegemaran']=$this->input->post('kegemaran');
        
		$this->db->insert($this->tabel2, $val);
		
		return $id;
    }

    function update_entry($id){
		$data['username']=$this->input->post('username');
		$data['level']=$this->input->post('level');
		if($this->input->post('password')!="password" && $this->input->post('password2')!="password"){
			$data['password']=$this->encrypt->sha1($this->input->post('password').$this->config->item('encryption_key'));
		}
		$data['status_active']=number_format($this->input->post('status_active'));
        $x = $this->db->update($this->tabel, $data, array('id' => $id));
        
        $val['username'] = $this->input->post('username');
        $x = $this->db->update($this->tabel2, $val, array('id'=>$id));
        
        return $x;
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


	function delete_entry($id)
	{
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
    
    function get_user_id($id=0){
        $options = array('id'=>$id);
        $query = $this->db->get_where($this->tabel2,$options,1);
        if($query->num_rows() > 0){
            $data=$query->row_array();
        }
        $query->free_result();
        return $data;
    }
  
    function get_user_list($id){
        $query = $this->db->get_where($this->tabel, array('id'=>$id),1);
        
        return $query->row_array();
    }
    
    function get_user_level(){
        $query=$this->db->get('app_users_level');
        return $query->result();
    }
    
    function update_profile($id){
        $val['nip']=str_replace(" ","",$this->input->post('nip'));
        $val['gelar']=$this->input->post('gelar');
        $val['nama']=$this->input->post('nama');
        $val['id_number']=$this->input->post('id_number');
        $val['birthdate']=$this->input->post('birthdate');
        $val['birthplace']=$this->input->post('birthplace');
        $val['gendre']=$this->input->post('gendre');
        $val['agama']=$this->input->post('agama');
        $val['kepercayaan']=$this->input->post('kepercayaan');
        $val['kawin']=$this->input->post('kawin');
        $val['phone_number']=$this->input->post('phone_number');
        $val['mobile']=$this->input->post('mobile');
        $val['email']=$this->input->post('email');
        
        $val['address']=$this->input->post('address');
        $val['propinsi']=$this->input->post('propinsi');
        $val['kota']=$this->input->post('kota');
        $val['kecamatan']=$this->input->post('kecamatan');
        $val['desa']=$this->input->post('desa');
        
        $val['badan_tinggi']=$this->input->post('badan_tinggi');
        $val['badan_berat']=str_replace('_','',$this->input->post('badan_berat'));
        $val['badan_rambut']=$this->input->post('badan_rambut');
        $val['badan_muka']=$this->input->post('badan_muka');
        $val['badan_kulit']=$this->input->post('badan_kulit');
        $val['badan_khas']=$this->input->post('badan_khas');
        $val['badan_cacat']=$this->input->post('badan_cacat');
        $val['kegemaran']=$this->input->post('kegemaran');
        
        $this->db->update($this->tabel2, $val, array('id'=> $this->input->post('id')));
    }
    
    function update_account($id){
        $val['username']=$this->input->post('username');
        $val['level']=$this->input->post('level');
        if($this->input->post('password')!="password" && $this->input->post('password2')!="password"){
            $val['password']=$this->encrypt->sha1($this->input->post('password').$this->config->item('encryption_key'));
        }
        $val['status_active']=number_format($this->input->post('status_active'));
        
        $this->db->update($this->tabel,$val,array('id'=>$id));
    }
 
    function get_all_gol(){
        $query = $this->db->get('mas_golongan');
        return $query->result();
    }
    
    function get_all_agama(){
        $query = $this->db->get('mas_agama');
        return $query->result();
    }
    
    function get_all_status(){
        $query = $this->db->get('mas_status_kawin');
        return $query->result();
    }
    
    function get_all_propinsi(){
        $query = $this->db->get('mas_propinsi');
        return $query->result();
    }
}