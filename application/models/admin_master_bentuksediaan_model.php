<?php
class Admin_master_bentuksediaan_model extends CI_Model {

    var $tabel    = 'mas_bentuk_sediaan';

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
        if (!$sortname) $sortname = 'id_sediaan';
        if (!$sortorder) $sortorder = 'asc';
        if (!$qtype) $qtype = 'id_sediaan';
        if ($qtype=='id_jenis') $qtype = 'b.nama_jenis2';
        if ($qparam) $swhere = ' AND '.$qtype.' LIKE \'%'.$qparam.'%\'';
        $sqlOrder = "ORDER BY $sortname $sortorder";
		$offset = ($page - 1) * $rp;
        
        $sql = "SELECT id_sediaan,nama_sediaan,b.nama_jenis2 AS id_jenis
				FROM mas_bentuk_sediaan AS a, mas_jenis AS b WHERE a.id_jenis=b.id_jenis " . $swhere . $sqlOrder . "
				LIMIT $offset, $rp ";
        
        $query = $this->db->query($sql);
        $return['records'] = $query;
        
        $sqlc = "SELECT COUNT(id_sediaan) AS record_count
				FROM mas_bentuk_sediaan AS a, mas_jenis AS b WHERE a.id_jenis=b.id_jenis  " . $swhere;
				
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


 	function get_data_row($id_sediaan){
		$data = array();
		$options = array('id_sediaan' => $id_sediaan);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}

   function insert_entry()
    {
		$data['nama_sediaan']=$this->input->post('nama_sediaan');
		$data['id_jenis']=$this->input->post('id_jenis');
		
		return $this->db->insert($this->tabel, $data);
    }

    function update_entry($id_sediaan)
    {
		$data['nama_sediaan']=$this->input->post('nama_sediaan');
		$data['id_jenis']=$this->input->post('id_jenis');
        
		return $this->db->update($this->tabel, $data, array('id_sediaan' =>  $this->input->post('id_sediaan')));
    }
	

	function delete_entry($id_sediaan)
	{
		$this->db->where(array('id_sediaan' => $id_sediaan));

		return $this->db->delete($this->tabel);
	}

}