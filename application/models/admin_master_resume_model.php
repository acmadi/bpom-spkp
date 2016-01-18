<?php
class Admin_master_resume_model extends CI_Model {

    var $tabel    = 'mas_resume_pemeriksaan';

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
        if (!$sortname) $sortname = 'id_resume';
        if (!$sortorder) $sortorder = 'asc';
        if (!$qtype) $qtype = 'id_resume';
        if ($qparam) $swhere = 'WHERE '.$qtype.' LIKE \'%'.$qparam.'%\'';
        $sqlOrder = "ORDER BY $sortname $sortorder";
		$offset = ($page - 1) * $rp;
        
        $sql = "SELECT id_resume,desc_resume
				FROM mas_resume_pemeriksaan " . $swhere . $sqlOrder . "
				LIMIT $offset, $rp ";
        
        $query = $this->db->query($sql);
        $return['records'] = $query;
        
        $sqlc = "SELECT COUNT(id_resume) AS record_count
				FROM mas_resume_pemeriksaan " . $swhere;
				
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


 	function get_data_row($id_resume){
		$data = array();
		$options = array('id_resume' => $id_resume);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

   function insert_entry()
    {
		$data['desc_resume']=$this->input->post('desc_resume');
		
		return $this->db->insert($this->tabel, $data);
    }

    function update_entry($id_resume)
    {
		$data['desc_resume']=$this->input->post('desc_resume');
		
		return $this->db->update($this->tabel, $data, array('id_resume' => $this->input->post('id_resume')));
    }
	

	function delete_entry($id_resume)
	{
		$this->db->where(array('id_resume' => $id_resume));

		return $this->db->delete($this->tabel);
	}

}