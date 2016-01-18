<?php
class Admin_master_proses_model extends CI_Model {

    var $tabel    = 'mas_proses_monitoring';

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
        if (!$sortname) $sortname = 'id_proses';
        if (!$sortorder) $sortorder = 'asc';
        if (!$qtype) $qtype = 'id_proses';
        if ($qparam) $swhere = 'WHERE '.$qtype.' LIKE \'%'.$qparam.'%\'';
        $sqlOrder = "ORDER BY $sortname $sortorder";
		$offset = ($page - 1) * $rp;
        
        $sql = "SELECT id_proses,deskripsi
				FROM mas_proses_monitoring " . $swhere . $sqlOrder . "
				LIMIT $offset, $rp ";
        
        $query = $this->db->query($sql);
        $return['records'] = $query;
        
        $sqlc = "SELECT COUNT(id_proses) AS record_count
				FROM mas_proses_monitoring " . $swhere;
				
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


 	function get_data_row($id_proses){
		$data = array();
		$options = array('id_proses' => $id_proses);
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
		
		return $this->db->insert($this->tabel, $data);
    }

    function update_entry($id_proses)
    {
		$data['deskripsi']=$this->input->post('deskripsi');
		
		return $this->db->update($this->tabel, $data, array('id_proses' => $this->input->post('id_proses')));
    }
	

	function delete_entry($id_proses)
	{
		$this->db->where(array('id_proses' => $id_proses));

		return $this->db->delete($this->tabel);
	}

}