<?php
class Admin_master_penanggungjawab_model extends CI_Model {

    var $tabel    = 'mas_penanggungjawab';
    var $jabatan = 'mas_jabatan';
    
    function __construct() {
        parent::__construct();
		$this->load->library('encrypt');
    }
    
	function get_list_data(){
		$page = $this->input->post('page');
        $rp = $this->input->post('rp');
        $sortname = $this->input->post('sortname');
        $sortorder = $this->input->post('sortorder');
        $qtype = $this->input->post('qtype');
        $qparam = $this->input->post('query');

        $swhere = '';
        if (!$page) $page = 1;
        if (!$rp) $rp = 10;
        if (!$sortname) $sortname = 'id';
        if (!$sortorder) $sortorder = 'asc';
        if (!$qtype) $qtype = 'id';
        if ($qparam) $swhere = 'WHERE '.$qtype.' LIKE \'%'.$qparam.'%\'';
        $sqlOrder = "ORDER BY $sortname $sortorder";
		$offset = ($page - 1) * $rp;
        
        $sql = "SELECT a.id, b.nama_jabatan, a.nip, a.nama, a.status FROM mas_penanggungjawab a
                INNER JOIN mas_jabatan b ON a.id_jabatan = b.id_jabatan " . $swhere . $sqlOrder . "
				LIMIT $offset, $rp ";
        
        $query = $this->db->query($sql);
        $return['records'] = $query;
        
        $sqlc = "SELECT COUNT(id) AS record_count
				FROM mas_penanggungjawab " . $swhere;
				
		$queryc = $this->db->query($sqlc);
		$row = $queryc->row();        
        $return['record_count'] = $row->record_count;
        
        return $return;
	}
	
    function get_count($options=array())
    {
		$this->db->like($options);
        $query = $this->db->get($this->tabel);
		return count($query->result_array());
    }

    function get_data($start,$limit,$options=array())
    {
		$this->db->like($options);
        $query = $this->db->get($this->tabel,$limit,$start);
        return $query->result();
    }


 	function get_data_row($id){
		$data = array();
		$options = array('id' => $id);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

   function insert_entry()
    {
		$data['id_jabatan']=$this->input->post('id_jabatan');
		$data['nip']=$this->input->post('nip');
		$data['nama']=$this->input->post('nama');
		$data['status']=$this->input->post('status');
		$data['uid']=$this->input->post('uid');
		
		return $this->db->insert($this->tabel, $data);
    }

    function update_entry($id)
    {
		$data['id_jabatan']=$this->input->post('id_jabatan');
		$data['nip']=$this->input->post('nip');
		$data['nama']=$this->input->post('nama');
		$data['status']=$this->input->post('status');
		$data['uid']=$this->input->post('uid');
		
		return $this->db->update($this->tabel, $data, array('id' => $this->input->post('id')));
    }
	

	function delete_entry($id)
	{
		$this->db->where(array('id' => $id));

		return $this->db->delete($this->tabel);
	}
    
    function get_all_jabatan(){
        $query = $this->db->get($this->jabatan);
        return $query->result();
    }

    function get_user(){
        $query = $this->db->get("app_users_profile");
        return $query->result();
    }

}