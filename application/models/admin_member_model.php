<?php
class Admin_member_model extends CI_Model {

    var $tabel    = 'member';
    var $tabel2    = 'membership';
    var $tabel3    = 'member_paket';

    function __construct() {
        parent::__construct();
		$this->load->library('encrypt');
   }
    
    function get_count($options=array())
    {
		foreach($options as $x=>$y){
			if($x=="kelamin" && $y=="-") continue;
			if($x=="status" && $y=="-") continue;
			$this->db->like($x,$y);
		}
        $query = $this->db->get($this->tabel);
		return count($query->result_array());
    }

    function member_code()
    {
		$data = array();
		$code = date("Ymd");
		$this->db->like('kode',$code);
		$this->db->order_by('kode','DESC');
        $query = $this->db->get($this->tabel);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
			$tmp = explode("-",$data['kode']);
			$tmp = intval($tmp[1])+1;
			$code .= "-".str_repeat("0",3-strlen($tmp)).$tmp;
		}else{
			$code .= "-001";
		}
		return $code;
    }

    function get_data_all()
    {
		$data = array();
        $query = $this->db->get($this->tabel);
		if ($query->num_rows() > 0){
			$data = $query->result();
		}
		return $data;
    }

    function get_data($start,$limit,$options=array())
    {
		$data = array();
		foreach($options as $x=>$y){
			if($x=="kelamin" && $y=="-") continue;
			if($x=="status" && $y=="-") continue;
			$this->db->like($x,$y);
		}
        $query = $this->db->get($this->tabel,$limit,$start);
		if ($query->num_rows() > 0){
			$data = $query->result_array();
		}
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
	
   function insert_entry()
    {
		$data['kode']=$this->input->post('kode');
		$data['nama']=$this->input->post('nama');
		$data['alamat']=$this->input->post('alamat');
		$data['hp']=$this->input->post('hp');
		$data['email']=$this->input->post('email');
		$data['tgl_lhr']=$this->input->post('tgl_lhr');
		$data['tmp_lhr']=$this->input->post('tmp_lhr');
		$data['kelamin']=$this->input->post('kelamin');
		$data['status']="guest";
		$data['id_number']=$this->input->post('id_number');
		$data['pekerjaan']=$this->input->post('pekerjaan');

        return $this->db->insert($this->tabel, $data);
    }

	function update_entry($kode)
    {
		$data['nama']=$this->input->post('nama');
		$data['alamat']=$this->input->post('alamat');
		$data['hp']=$this->input->post('hp');
		$data['email']=$this->input->post('email');
		$data['tgl_lhr']=$this->input->post('tgl_lhr');
		$data['tmp_lhr']=$this->input->post('tmp_lhr');
		$data['kelamin']=$this->input->post('kelamin');
		$data['id_number']=$this->input->post('id_number');
		$data['pekerjaan']=$this->input->post('pekerjaan');
		$data['photo']=$this->input->post('photo');

		return $this->db->update($this->tabel, $data, array('kode' => $kode));
    }

	function delete_entry($kode)
	{
		$this->db->where(array('kode' => $kode));

		return $this->db->delete($this->tabel);
	}

    function get_membership($kode)
    {
		$data = array();
		$this->db->select('membership.*,member_paket.name AS paket,member_paket.type AS type');
		$this->db->where("kode_member",$kode);
		$this->db->join("member_paket","member_paket.kode=membership.kode_paket","right");
        $query = $this->db->get($this->tabel2);
		if ($query->num_rows() > 0){
			$data = $query->result_array();
		}
		return $data;
    }

    function get_membership_detail($kode_membership)
    {
		$data = array();
		$this->db->select('membership.*,member_paket.name AS paket,member_paket.type AS type');
		$this->db->where("membership.kode",$kode_membership);
		$this->db->join("member_paket","member_paket.kode=membership.kode_paket","right");
        $query = $this->db->get($this->tabel2);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}
		return $data;
    }

    function get_paket()
    {
		$data = array();
		
		$this->db->where(array('status' => 1));
        $query = $this->db->get($this->tabel3);
		$data[""]= "-";
        foreach($query->result_array() as $key=>$dt){
			$data[$dt['kode']]=$dt['name']." [".strtoupper($dt['type'])."]";
		}
		return $data;
    }

    function get_paket_detail($kode)
    {
		$data = array();
		$options = array('kode' => $kode);
		$query = $this->db->get_where($this->tabel3,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
    }

   function insert_entry_membership($kode_member)
    {
		$data['kode']=$this->input->post('kode_paket')."-".date("YmdHis");
		$data['kode_member']=$kode_member;
		$data['kode_paket']=$this->input->post('kode_paket');
		$data['tgl_start']=$this->input->post('tgl_start');
		$data['tgl_end']=$this->input->post('tgl_end');
		$data['status']='pending';
		$data['biaya']=$this->input->post('biaya');

        if($this->db->insert($this->tabel2, $data)){
			return $data['kode'];
		}else{
			return false;
		}
    }

   function update_entry_membership($kode,$kode_membership)
    {
		if($this->input->post('status')=="active"){
			$data['status']='member';
		}else{
			$data['status']='guest';
		}
		$this->db->update($this->tabel, $data, array('kode' => $kode));

		$data['status']=$this->input->post('status');
		return $this->db->update($this->tabel2, $data, array('kode' => $kode_membership));
    }

}