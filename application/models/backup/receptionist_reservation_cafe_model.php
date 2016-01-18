<?php
class Receptionist_reservation_cafe_model extends CI_Model {

    var $tabel    = 'member';
    var $tabel2    = 'membership';
    var $tabel3    = 'tables';

    function __construct() {
        parent::__construct();
		$this->load->library('encrypt');
   }
    
    function get_tables($type="fix",$tgl,$jam)
    {
		$data = array();
		$this->db->where('tipe',$type);
        $query = $this->db->get($this->tabel3);
		if ($query->num_rows() > 0){
			$result = $query->result_array();
			$query->free_result();    

			foreach($result as $x){
				$this->db->select('status');
				$this->db->where('tables_status.kode_table',$x['kode']);
				$this->db->where('tables_reservation.kode_jam',$jam);
				$this->db->where('tables_reservation.tgl_visit_plan',$tgl);
				$this->db->join('tables_status','tables_reservation.kode=tables_status.kode_reservation','right');
			    $query = $this->db->get('tables_reservation');
				if ($query->num_rows() > 0){
					$rsvp = $query->row_array();
					if($rsvp['status']!="cancel") $x['reserved'] = 0;
					else $x['reserved'] = 1;
				}else{
					$x['reserved'] = 1;
				}
				$query->free_result();    
				
				$data[]=$x;
			}
		}
        return $data;
    }

    function get_table($kode)
    {
		$this->db->where('kode_reservation',$kode);
        $query = $this->db->get('tables_status');
        return $query->result();
    }

    function get_table_reservation($kode,$tgl)
    {
		$data = array();
		$this->db->select('status,kode_jam,keterangan,kode_member,cover_plan,kode_reservation');
		$this->db->where('tables_reservation.status <> ','cancel');
		$this->db->where('kode_table',$kode);
		$this->db->where('tgl_visit_plan',$tgl);
		$this->db->join('jam','jam.kode=tables_reservation.kode_jam','right');
		$this->db->join('tables_status','tables_reservation.kode=tables_status.kode_reservation','right');
        $query = $this->db->get('tables_reservation');
		if ($query->num_rows() > 0){
			$data = $query->result_array();
		}
		$query->free_result();    
		return $data;
    }

    function get_data($tgl="",$jam="")
    {
		$data = array();
		$this->db->where('tgl_visit_plan',$tgl);
		$this->db->where('kode_jam',$jam);
		$this->db->join('tables_reservation','tables_reservation.kode_member=member.kode','right');
		$this->db->order_by('tables_reservation.tgl_visit_plan','ASC');
        $query = $this->db->get($this->tabel);
		if ($query->num_rows() > 0){
			$result = $query->result_array();

			
			/*foreach($result as $x){
				$this->db->where('kode_reservation',$x['kode']);
				$this->db->join('jam','jam.kode=schedule_reservation_jam.kode_jam','right');
				$jam = $this->db->get('schedule_reservation_jam');
				$x['jam']= $jam->result_array();
				$jam->free_result();    

				$this->db->select('sport_facility.nama,sport_facility_field.nama as arena');
				$this->db->where('sport_facility.kode',$x['kode_sport']);
				$this->db->where('sport_facility_field.kode',$x['kode_field']);
				$this->db->join('sport_facility_field','sport_facility.kode=sport_facility_field.kode_sport','right');
				$fasilitas = $this->db->get('sport_facility');
				$dt= $fasilitas->row_array();
				$x['fasilitas'] = $dt['nama'];
				$x['arena'] = $dt['arena'];
				$fasilitas->free_result();    

				$tgl = explode("-",$x['tgl']);
				$x['tgl']= $tgl['2']." . ".$tgl['1']." . ".$tgl['0'];
				$data[] = $x;
			}*/
		}
		$query->free_result();    
		return $data;
    }

 	function get_data_row($kode){
		$data = array();
		$options = array('kode' => $kode);
		$query = $this->db->get_where('tables_reservation',$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}
	
    function get_jam_option()
    {
		$data = array();
        $query = $this->db->get('jam');
        foreach($query->result_array() as $key=>$dt){
			$data[$dt['kode']]=$dt['keterangan'];
		}
		return $data;
    }

    function get_jam($sport = "",$field = "",$tgl = "",$kode_reservasi="")
    {
		$data = array();
        $query = $this->db->get('jam');
        foreach($query->result_array() as $key=>$dt){
			if($tgl!="" && $sport!="" && $field!=""){
				if($this->cek_jam($sport,$field,$tgl,$dt['kode'],$kode_reservasi)){
					$data[$dt['kode']]=$dt['keterangan'];
				}
			}else{
				$data[$dt['kode']]=$dt['keterangan'];
			}
		}
		return $data;
    }

    function get_jam_keterangan($jam)
    {
 		$options = array('kode' => $jam);
        $query = $this->db->get_where('jam',$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
			$jam = $data['keterangan'];
		}

		$query->free_result();    
		return $jam;
    }

    function cek_jam($sport,$field,$tgl,$jam,$kode_reservasi="")
	{
		if($kode_reservasi!="") $this->db->where(array('kode <> ' => $kode_reservasi));
 		$this->db->where(array('tgl' => $tgl,'kode_jam' => $jam,'status' => 'reserve','kode_sport' => $sport, 'kode_field'=> $field));
 		$this->db->join('schedule_reservation_jam','schedule_reservation_jam.kode_reservation=schedule_reservation.kode','right');
        $query = $this->db->get('schedule_reservation');
		if($query->num_rows()>0){
			return false;
		}else{
			return true;
		}
	}

    function cek_jam2($sport,$field,$tgl,$jam,$kode_reservasi="")
	{
		if($kode_reservasi!="") $this->db->where(array('kode' => $kode_reservasi));
 		$this->db->where(array('tgl' => $tgl,'kode_jam' => $jam,'kode_sport' => $sport, 'kode_field'=> $field));
 		$this->db->join('schedule_reservation_jam','schedule_reservation_jam.kode_reservation=schedule_reservation.kode','right');
        $query = $this->db->get('schedule_reservation');
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}

    function insert_entry()
    {
		$data['kode']=time();
		$data['tgl_jam_reserved']=$data['kode'];
		$data['kode_member']=$this->input->post('kode_member');
		$data['kode_jam']=$this->input->post('kode_jam');
		$data['tgl_visit_plan']=$this->input->post('tgl_visit_plan');
		$data['cover_plan']=$this->input->post('cover_plan');
		$data['status']=$this->input->post('status');
		$data['cover_visited']=0;
		$data['tgl_jam_visited']=0;
		$data['tgl_jam_leave']=0;
		if($this->db->insert('tables_reservation', $data)){
			$table['kode_reservation']=$data['kode'];
			foreach($this->input->post('table') as $x=>$y){
				$table['kode_table'] = $y;
				$this->db->insert('tables_status', $table);
			}
		}
		return $data['kode'];
    }

	function update_entry($kode)
    {
		$data['cover_plan']=intval($this->input->post('cover_plan'));
		$data['status']=$this->input->post('status');

		return $this->db->update('tables_reservation', $data, array('kode' => $kode));
    }

	function delete_entry($kode)
	{
		$this->db->where(array('kode' => $kode));
		if($this->db->delete('schedule_reservation')){
			$this->db->where(array('kode_reservation' => $kode));
			return $this->db->delete('schedule_reservation_jam');
		}else{
			return false;
		}
	}

    function get_member($kode)
    {
		$data = array();
		$this->db->where("kode",$kode);
        $query = $this->db->get($this->tabel);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}
		return $data;
    }

    function get_membership($kode)
    {
		$data = array();
		$this->db->select('membership.*,member_paket.name AS paket,member_paket.type AS type');
		$this->db->where("membership.status <> ",'expired');
		$this->db->where("kode_member",$kode);
		$this->db->join("member_paket","member_paket.kode=membership.kode_paket","right");
        $query = $this->db->get($this->tabel2);
		if ($query->num_rows() > 0){
			$data = $query->result_array();
		}
		return $data;
    }

}