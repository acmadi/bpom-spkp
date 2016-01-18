<?php
class Admin_master_tujuan_model extends CI_Model {

    var $tabel    = 'mas_tujuan_pdb';

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
        if (!$sortname) $sortname = 'id_tujuan';
        if (!$sortorder) $sortorder = 'asc';
        if (!$qtype) $qtype = 'id_tujuan';
        if ($qparam) $swhere = 'WHERE '.$qtype.' LIKE \'%'.$qparam.'%\'';
        $sqlOrder = "ORDER BY $sortname $sortorder";
		$offset = ($page - 1) * $rp;
        
        $sql = "SELECT a.*, b.name FROM mas_tujuan_pdb a INNER JOIN mas_group_industri b
                ON a.grp = b.id " . $swhere . $sqlOrder . "
				LIMIT $offset, $rp ";
        
        $query = $this->db->query($sql);
        $return['records'] = $query;
        
        $sqlc = "SELECT COUNT(a.id_tujuan) AS record_count
				FROM mas_tujuan_pdb a inner join mas_group_industri b on a.grp = b.id " . $swhere;
				
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


 	function get_data_row($id_tujuan){
		$data = array();
		$options = array('id_tujuan' => $id_tujuan);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

   function insert_entry()
    {
		$data['desc_tujuan']=$this->input->post('desc_tujuan');
        $data['grp']=$this->input->post('group');
		
		return $this->db->insert($this->tabel, $data);
    }

    function update_entry($id_tujuan)
    {
		$data['desc_tujuan']=$this->input->post('desc_tujuan');
		$data['grp']=$this->input->post('group');
        
		return $this->db->update($this->tabel, $data, array('id_tujuan' => $this->input->post('id_tujuan')));
    }
	

	function delete_entry($id_tujuan)
	{
		$this->db->where(array('id_tujuan' => $id_tujuan));

		return $this->db->delete($this->tabel);
	}
    
    function get_all_group(){
        $query=$this->db->get('mas_group_industri');
        return $query->result();
    }

}