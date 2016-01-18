<?php
class Admin_monthly_paket_model extends CI_Model {

    var $tabel    = 'paket';

    function __construct() {
        parent::__construct();
		$this->load->library('encrypt');
    }
    
    function get_count($options=array())
    {
		foreach($options as $x=>$y){
			if($y=="-") continue;
			else{
				$this->db->like($x,$y);
			}
		}
        $query = $this->db->get($this->tabel);
		return count($query->result_array());
    }

    function get_data($start,$limit,$options=array())
    {
		foreach($options as $x=>$y){
			if($y=="-") continue;
			else{
				$this->db->like($x,$y);
			}
		}
        $query = $this->db->get($this->tabel,$limit,$start);
        return $query->result();
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
		$data['price']=floatval($this->input->post('price'));
 		$data['status']=$this->input->post('status');
		$data['keterangan']=$this->input->post('keterangan');
		$data['bulan']=intval($this->input->post('bulan'));

		return $this->db->insert($this->tabel, $data);
    }

    function update_entry($kode)
    {
		$data['nama']=$this->input->post('nama');
		$data['price']=floatval($this->input->post('price'));
 		$data['status']=$this->input->post('status');
		$data['keterangan']=$this->input->post('keterangan');
		$data['bulan']=intval($this->input->post('bulan'));
        
		return $this->db->update($this->tabel, $data, array('kode' => $kode));
    }
	

	function delete_entry($kode)
	{
		$this->db->where(array('kode' => $kode));

		return $this->db->delete($this->tabel);
	}

}