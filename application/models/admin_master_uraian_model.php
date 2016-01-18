<?php
class Admin_master_uraian_model extends CI_Model {

    var $tabel    = 'mas_uraian_evaluasi';

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
        if (!$sortname) $sortname = 'no_uraian';
        if (!$sortorder) $sortorder = 'asc';
        if (!$qtype) $qtype = 'no_uraian';
        if ($qparam) $swhere = 'WHERE '.$qtype.' LIKE \'%'.$qparam.'%\'';
        $sqlOrder = "ORDER BY $sortname $sortorder";
		$offset = ($page - 1) * $rp;
        
        $sql = "SELECT no_uraian, deskripsi, `group`, head
				FROM mas_uraian_evaluasi " . $swhere . $sqlOrder . "
                LIMIT $offset, $rp ";
        
        $query = $this->db->query($sql);
        $return['records'] = $query;
        
        $sqlc = "SELECT COUNT(no_uraian) AS record_count
				FROM mas_uraian_evaluasi " . $swhere;
				
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


 	function get_data_row($no_uraian){
		$data = array();
		$options = array('no_uraian' => $no_uraian);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

   function insert_entry()
    {
		$data['deskripsi']=$this->input->post('deskripsi');
		$data['group']=$this->input->post('group');
		$data['head']=$this->input->post('head');
		
		return $this->db->insert($this->tabel, $data);
    }

    function update_entry($no_uraian)
    {
		$data['deskripsi']=$this->input->post('deskripsi');
		$data['group']=$this->input->post('group');
		$data['head']=$this->input->post('head');
        
		return $this->db->update($this->tabel, $data, array('no_uraian' => $this->input->post('no_uraian')));
    }
	

	function delete_entry($no_uraian)
	{
		$this->db->where(array('no_uraian' => $no_uraian));

		return $this->db->delete($this->tabel);
	}

}