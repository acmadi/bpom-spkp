<?php
class users_model extends CI_Model {

    var $tabel    = 'mas_balai';

    function __construct() {
        parent::__construct();
		$this->load->library('encrypt');
    }
    
	function get_list_calon(){
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
        if ($qparam) $swhere = 'AND '.$qtype.' LIKE \'%'.$qparam.'%\'';
        $sqlOrder = "ORDER BY $sortname $sortorder";
		$offset = ($page - 1) * $rp;
        
        $sql = "SELECT app_users_list.id,app_users_list.level,app_users_list.status_active,app_users_list.status_aproved,app_users_list.kode_balai,app_users_profile.*,app_users_industri.nama_perusahaan
				FROM app_users_list 
				INNER JOIN app_users_profile ON app_users_list.id=app_users_profile.id 
				INNER JOIN app_users_industri ON app_users_list.id=app_users_industri.id WHERE status_aproved=0 AND app_users_list.id>1 AND level='member'
				" . $swhere . $sqlOrder . "
				LIMIT $offset, $rp ";
        
        $query = $this->db->query($sql);
        $return['records'] = $query;
        
        $sqlc = "SELECT COUNT(app_users_list.id) AS record_count
				FROM app_users_list
				INNER JOIN app_users_profile ON app_users_list.id=app_users_profile.id
				INNER JOIN app_users_industri ON app_users_list.id=app_users_industri.id WHERE status_aproved=0 AND app_users_list.id>1 AND level='member' " . $swhere;
				
		$queryc = $this->db->query($sqlc);
		$row = $queryc->row();        
        $return['record_count'] = $row->record_count;
        
        return $return;
	}
	
	function get_list_pelanggan(){
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
        if ($qparam) $swhere = 'AND '.$qtype.' LIKE \'%'.$qparam.'%\'';
        $sqlOrder = "ORDER BY $sortname $sortorder";
		$offset = ($page - 1) * $rp;
        
        $sql = "SELECT app_users_list.id,app_users_list.level,app_users_list.status_active,app_users_list.status_aproved,app_users_list.kode_balai,app_users_profile.*,app_users_industri.nama_perusahaan
				FROM app_users_list 
				INNER JOIN app_users_profile ON app_users_list.id=app_users_profile.id 
				INNER JOIN app_users_industri ON app_users_list.id=app_users_industri.id WHERE status_aproved=1 AND status_active=0 AND app_users_list.id>1 AND level='member'
				" . $swhere . $sqlOrder . "
				LIMIT $offset, $rp ";
        
        $query = $this->db->query($sql);
        $return['records'] = $query;
        
        $sqlc = "SELECT COUNT(app_users_list.id) AS record_count
				FROM app_users_list
				INNER JOIN app_users_profile ON app_users_list.id=app_users_profile.id
				INNER JOIN app_users_industri ON app_users_list.id=app_users_industri.id WHERE status_aproved=1 AND status_active=0 AND app_users_list.id>1 AND level='member' " . $swhere;
				
		$queryc = $this->db->query($sqlc);
		$row = $queryc->row();        
        $return['record_count'] = $row->record_count;
        
        return $return;
	}
	
	function get_list_pengguna(){
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
        if ($qparam) $swhere = 'AND '.$qtype.' LIKE \'%'.$qparam.'%\'';
        $sqlOrder = "ORDER BY $sortname $sortorder";
		$offset = ($page - 1) * $rp;
        
        $sql = "SELECT app_users_list.id,app_users_list.level,app_users_list.status_active,app_users_list.status_aproved,app_users_list.kode_balai,app_users_profile.*,app_users_industri.nama_perusahaan
				FROM app_users_list 
				INNER JOIN app_users_profile ON app_users_list.id=app_users_profile.id 
				INNER JOIN app_users_industri ON app_users_list.id=app_users_industri.id WHERE status_aproved=1 AND status_active=1 AND app_users_list.id>1 AND level='member'
				" . $swhere . $sqlOrder . "
				LIMIT $offset, $rp ";
        
        $query = $this->db->query($sql);
        $return['records'] = $query;
        
        $sqlc = "SELECT COUNT(app_users_list.id) AS record_count
				FROM app_users_list
				INNER JOIN app_users_profile ON app_users_list.id=app_users_profile.id
				INNER JOIN app_users_industri ON app_users_list.id=app_users_industri.id WHERE status_aproved=1 AND status_active=1 AND app_users_list.id>1 AND level='member' " . $swhere;
				
		$queryc = $this->db->query($sqlc);
		$row = $queryc->row();        
        $return['record_count'] = $row->record_count;
        
        return $return;
	}
	
 	function get_data_row($id_balai){
		$data = array();
		$options = array('id_balai' => $id_balai);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

    function update_entry($id_balai)
    {
		$data['nama_balai']=$this->input->post('nama_balai');
		$data['alamat']=$this->input->post('alamat');
		$data['propinsi']=$this->input->post('propinsi');
		$data['kd_pos']=$this->input->post('kd_pos');
		$data['telp']=$this->input->post('telp');
		$data['fax']=$this->input->post('fax');
		$data['email']=$this->input->post('email');
		$data['nip_kepala']=$this->input->post('nip_kepala');
		$data['nama_kepala']=$this->input->post('nama_kepala');
        
		return $this->db->update($this->tabel, $data, array('id_balai' => $this->input->post('id_balai')));
    }
	

	function delete_entry($id_balai)
	{
		$this->db->where(array('id_balai' => $id_balai));

		return $this->db->delete($this->tabel);
	}

}