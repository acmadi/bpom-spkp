<?php
class Receptionist_cafe_list_model extends CI_Model {

    var $tabel    = 'tables_reservation';
    var $tabel2    = 'tables_status';
    var $tabel3    = 'tables';
    var $tabel4    = 'member';
    var $tabel5    = 'jam';

    function __construct() {
        parent::__construct();
		$this->load->library('encrypt');
   }
    
    function get_count($options=array())
    {
		foreach($options as $x=>$y){
			if($y=="-" || $y=="" || $y=="0"){
				continue;
			}
			else{
				if($x=="nama"){
					$this->db->like($x,$y);
				}else{
					if($x=="status") $x="tables_reservation.status";
					if($x=="tgl_jam_reserved_start") {
						$x="tables_reservation.tgl_jam_reserved >= ";
						$y=explode("-",$y);
						$y=mktime(0,0,0,$y[1],$y[2],$y[0]);
					}
					if($x=="tgl_jam_reserved_end"){
						$x="tables_reservation.tgl_jam_reserved <= ";
						$y=explode("-",$y);
						$y=mktime(0,0,0,$y[1],$y[2],$y[0]);
					}
					if($x=="tgl_visit_plan_start") $x="tables_reservation.tgl_visit_plan >= ";
					if($x=="tgl_visit_plan_end") $x="tables_reservation.tgl_visit_plan <= ";

					$this->db->where($x,$y);
				}
			}
		}
		$this->db->join($this->tabel5,'jam.kode=tables_reservation.kode_jam','right');
		$this->db->join($this->tabel4,'member.kode=tables_reservation.kode_member','right');
        $query = $this->db->get($this->tabel);
		return count($query->result_array());
    }

    function get_data($start,$limit,$options=array())
    {
		$data = array();
		$this->db->select('tables_reservation.*,jam.keterangan,member.nama,member.hp,member.email');
		foreach($options as $x=>$y){
			if($y=="-" || $y=="" || $y=="0"){
				continue;
			}
			else{
				if($x=="nama"){
					$this->db->like($x,$y);
				}else{
					if($x=="status") $x="tables_reservation.status";
					if($x=="tgl_jam_reserved_start") {
						$x="tables_reservation.tgl_jam_reserved >= ";
						$y=explode("-",$y);
						$y=mktime(0,0,0,$y[1],$y[2],$y[0]);
					}
					if($x=="tgl_jam_reserved_end"){
						$x="tables_reservation.tgl_jam_reserved <= ";
						$y=explode("-",$y);
						$y=mktime(0,0,0,$y[1],$y[2],$y[0]);
					}
					if($x=="tgl_visit_plan_start") $x="tables_reservation.tgl_visit_plan >= ";
					if($x=="tgl_visit_plan_end") $x="tables_reservation.tgl_visit_plan <= ";

					$this->db->where($x,$y);
				}
			}
		}
		$this->db->join($this->tabel5,'jam.kode=tables_reservation.kode_jam','right');
		$this->db->join($this->tabel4,'member.kode=tables_reservation.kode_member','right');
        $query = $this->db->get($this->tabel);
		if ($query->num_rows() > 0){
			$result = $query->result_array();
			$query->free_result();    

			foreach($result as $x){
				$this->db->select('keterangan');
				$this->db->where('tables_status.kode_reservation',$x['kode']);
				$this->db->join('tables_status','tables_status.kode_table=tables.kode','right');
			    $query = $this->db->get('tables');
				if ($query->num_rows() > 0){
					foreach($query->result_array() as $key=>$val){
						$x['table'][]=$val['keterangan'];
					}
				}else{
					$x['table'] = array();
				}
				$query->free_result();    
				
				$data[]=$x;
			}
		}
		return $data;
    }

    function get_jam_option()
    {
		$data = array();
		$data[]="-";
        $query = $this->db->get('jam');
        foreach($query->result_array() as $key=>$dt){
			$data[$dt['kode']]=$dt['keterangan'];
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
	
}