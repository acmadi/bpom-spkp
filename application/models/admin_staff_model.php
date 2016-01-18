<?php
class Admin_staff_model extends CI_Model {

    var $tabel    = 'staff';

    function __construct() {
        parent::__construct();
		$this->load->library('encrypt');
   }
    
    function get_count($options=array())
    {
		foreach($options as $x=>$y){
			if($x=="kode_division"){
				if($y!="" && $y!=0) $this->db->where($x,$y);
			}else{
				if($y!="" && $y!=0) $this->db->like($x,$y);
			}
		}
        $query = $this->db->get($this->tabel);
		return count($query->result_array());
    }

    function get_data($start,$limit,$options=array())
    {
		$data = array();
		foreach($options as $x=>$y){
			if($x=="kode_division"){
				if($y!="" && $y!="0") $this->db->where($x,$y);
			}else{
				if($y!="" && $y!="0") $this->db->like($x,$y);
			}
		}
        $query = $this->db->get($this->tabel,$limit,$start);
        foreach($query->result_array() as $key=>$val){
			$account = $this->db->get_where("app_users_list",array('id'=>$val['user_id']),1);
			if ($account->num_rows() > 0){
				$account = $account->row_array();
				$val['username']=$account['username'];
			}
			$division = $this->db->get_where("division",array('kode'=>$val['kode_division']),1);
			if ($division->num_rows() > 0){
				$division = $division->row_array();
				$val['division']=$division['keterangan'];
			}
			$data[$key]=$val;
		}
		return $data;
    }

 	function get_data_profile_row($kode){
		$data = array();
		$options = array($this->tabel.'.kode' => $kode);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}
		
		$query->free_result();    
		return $data;
	}

   function insert_entry()
   {
		$data['kode']=$this->input->post('kode');
		$data['user_id']=$this->input->post('user_id');
		$data['kode_division']=$this->input->post('kode_division');
		$data['email']=$this->input->post('email');
		$data['name_display']=$this->input->post('name_display');
		$data['id_number']=$this->input->post('id_number');
		$data['grade']=$this->input->post('grade');
		$data['address']=$this->input->post('address');
		$data['gendre']=$this->input->post('gendre');
		$data['birthdate']=$this->input->post('birthdate');
		$data['birthplace']=$this->input->post('birthplace');
		$data['job_title']=$this->input->post('job_title');
		$data['phone_number']=$this->input->post('phone_number');
		$data['mobile']=$this->input->post('phone_number');
		$data['achievement']=$this->input->post('achievement');
		$data['about']=$this->input->post('about');
		$data['hobbies']=$this->input->post('hobbies');
		$data['facebook']=$this->input->post('facebook');
		$data['twitter']=$this->input->post('twitter');
		$data['wordpress']=$this->input->post('wordpress');
		$data['blogspot']=$this->input->post('blogspot');
		
		
		return $this->db->insert($this->tabel, $data);
		
    }
	
	function update_entry($kode)
    {
		$data['user_id']=$this->input->post('user_id');
		$data['kode_division']=$this->input->post('kode_division');
		$data['email']=$this->input->post('email');
		$data['name_display']=$this->input->post('name_display');
		$data['id_number']=$this->input->post('id_number');
		$data['grade']=$this->input->post('grade');
		$data['avatar']=$this->input->post('avatar');
		$data['address']=$this->input->post('address');
		$data['gendre']=$this->input->post('gendre');
		$data['birthdate']=$this->input->post('birthdate');
		$data['birthplace']=$this->input->post('birthplace');
		$data['job_title']=$this->input->post('job_title');
		$data['phone_number']=$this->input->post('phone_number');
		$data['mobile']=$this->input->post('phone_number');
		$data['achievement']=$this->input->post('achievement');
		$data['about']=$this->input->post('about');
		$data['hobbies']=$this->input->post('hobbies');
		$data['facebook']=$this->input->post('facebook');
		$data['twitter']=$this->input->post('twitter');
		$data['wordpress']=$this->input->post('wordpress');
		$data['blogspot']=$this->input->post('blogspot');

		return $this->db->update($this->tabel, $data, array('kode' => $kode));
    }

	function delete_entry($kode)
	{
		$this->db->where(array('kode' => $kode));

		return $this->db->delete($this->tabel);
	}

    function get_division()
    {
		$data[]="-";
        $query = $this->db->get('division');
        foreach($query->result_array() as $key=>$dt){
			$data[$dt['kode']]=ucfirst($dt['keterangan']);
		}

		$query->free_result();    
		return $data;
    }
    
    function get_username()
    {
		$data[]="-";
 		$this->db->order_by("username","ASC");
        $query = $this->db->get('app_users_list');
        foreach($query->result_array() as $key=>$dt){
			$data[$dt['id']]=$dt['username'];
		}

		$query->free_result();    
		return $data;
    }

 	function get_data_row($kode){
		$data = array();
		$options = array('kode' => $kode);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

}