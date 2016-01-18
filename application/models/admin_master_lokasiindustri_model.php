<?php
class Admin_master_lokasiindustri_model extends CI_Model {

    var $tabel    = 'mas_lokasi_industri';

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
        if (!$sortname) $sortname = 'id_lokasi';
        if (!$sortorder) $sortorder = 'asc';
        if (!$qtype) $qtype = 'id_lokasi';
        if ($qparam) $swhere = 'WHERE '.$qtype.' LIKE \'%'.$qparam.'%\'';
        $sqlOrder = "ORDER BY $sortname $sortorder";
		$offset = ($page - 1) * $rp;
        
        $sql = "SELECT id_lokasi,nama_lokasi
				FROM mas_lokasi_industri " . $swhere . $sqlOrder . "
				LIMIT $offset, $rp ";
        
        $query = $this->db->query($sql);
        $return['records'] = $query;
        
        $sqlc = "SELECT COUNT(id_lokasi) AS record_count
				FROM mas_lokasi_industri " . $swhere;
				
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


 	function get_data_row($id_lokasi){
		$data = array();
		$options = array('id_lokasi' => $id_lokasi);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

   function insert_entry()
    {
		$data['nama_lokasi']=$this->input->post('nama_lokasi');
		
		return $this->db->insert($this->tabel, $data);
    }

    function update_entry($id_lokasi)
    {
		$data['nama_lokasi']=$this->input->post('nama_lokasi');
		
		return $this->db->update($this->tabel, $data, array('id_lokasi' => $this->input->post('id_lokasi')));
    }
	

	function delete_entry($id_lokasi)
	{
		$this->db->where(array('id_lokasi' => $id_lokasi));

		return $this->db->delete($this->tabel);
	}

}