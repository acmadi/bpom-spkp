<?php
class Admin_mapping_model extends CI_Model {

    var $tabel		= 'mapping_madani';
    var $tabel2		= 'mapping_swasta';
    var $tabel3		= 'provinsi';
	var $tabel4		= 'mapping_provinsi';

    function __construct() {
        parent::__construct();
		$this->load->library('encrypt');
   }
    
    function get_count_madani($options=array())
    {
		foreach($options as $x=>$y){
			$this->db->like($x,$y);
		}
        return $this->db->count_all_results($this->tabel);
    }

    function get_data_madani($start,$limit,$options=array())
    {
		foreach($options as $x=>$y){
			$this->db->like($x,$y);
		}
		$this->db->order_by($this->tabel.'.perusahaan','ASC');
        $query = $this->db->get($this->tabel,$limit,$start);
        return $query->result();
    }

    function get_data_all_madani()
    {
		$this->db->from($this->tabel);
		$this->db->order_by($this->tabel.'.perusahaan','DESC');
		$query = $this->db->get();
        return $query->result();
    }

 	function get_data_row_madani($kode){
		$options = array('kode' => $kode);
		$query = $this->db->get_where($this->tabel,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}
	

   function insert_entry_madani()
    {
		$data['perusahaan']=$this->input->post('perusahaan');
		$data['nama_program']=$this->input->post('nama_program');
		$data['lokasi_program']=$this->input->post('lokasi_program');
		$data['fokus_1']=$this->input->post('fokus_1');
		$data['fokus_2']=$this->input->post('fokus_2');
		$data['fokus_3']=$this->input->post('fokus_3');
		$data['fokus_4']=$this->input->post('fokus_4');
		$data['fokus_5']=$this->input->post('fokus_5');
		$data['fokus_6']=$this->input->post('fokus_6');
		$data['fokus_7']=$this->input->post('fokus_7');
		$data['fokus_8']=$this->input->post('fokus_8');
		$data['keterangan']=$this->input->post('keterangan');

        $this->db->insert($this->tabel, $data);
		return $this->db->insert_id();
    }
	
    function update_entry_madani($kode)
    {
		$data['perusahaan']=$this->input->post('perusahaan');
		$data['nama_program']=$this->input->post('nama_program');
		$data['lokasi_program']=$this->input->post('lokasi_program');
		$data['fokus_1']=$this->input->post('fokus_1');
		$data['fokus_2']=$this->input->post('fokus_2');
		$data['fokus_3']=$this->input->post('fokus_3');
		$data['fokus_4']=$this->input->post('fokus_4');
		$data['fokus_5']=$this->input->post('fokus_5');
		$data['fokus_6']=$this->input->post('fokus_6');
		$data['fokus_7']=$this->input->post('fokus_7');
		$data['fokus_8']=$this->input->post('fokus_8');
  		$data['keterangan']=$this->input->post('keterangan');
      
		return $this->db->update($this->tabel, $data, array('kode' => $kode));
    }
	

	function delete_entry_madani($kode)
	{
		$this->db->where(array('kode' => $kode));

		return $this->db->delete($this->tabel);
	}

    function get_count_swasta($options=array())
    {
		foreach($options as $x=>$y){
			$this->db->like($x,$y);
		}
        return $this->db->count_all_results($this->tabel2);
    }

    function get_data_swasta($start,$limit,$options=array())
    {
		foreach($options as $x=>$y){
			$this->db->like($x,$y);
		}
		$this->db->order_by($this->tabel2.'.perusahaan','ASC');
        $query = $this->db->get($this->tabel2,$limit,$start);
        return $query->result();
    }

    function get_data_all_swasta()
    {
		$this->db->from($this->tabel2);
		$this->db->order_by($this->tabel2.'.perusahaan','DESC');
		$query = $this->db->get();
        return $query->result();
    }

 	function get_data_row_swasta($kode){
		$options = array('kode' => $kode);
		$query = $this->db->get_where($this->tabel2,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}
	

   function insert_entry_swasta()
    {
		$data['perusahaan']=$this->input->post('perusahaan');
		$data['nama_program']=$this->input->post('nama_program');
		$data['lokasi_program']=$this->input->post('lokasi_program');
		$data['waktu']=$this->input->post('waktu');
		$data['fokus_1']=$this->input->post('fokus_1');
		$data['fokus_2']=$this->input->post('fokus_2');
		$data['fokus_3']=$this->input->post('fokus_3');
		$data['fokus_4']=$this->input->post('fokus_4');
		$data['fokus_5']=$this->input->post('fokus_5');
		$data['fokus_6']=$this->input->post('fokus_6');
		$data['fokus_7']=$this->input->post('fokus_7');
		$data['fokus_8']=$this->input->post('fokus_8');
		$data['keterangan']=$this->input->post('keterangan');

        $this->db->insert($this->tabel2, $data);
		return $this->db->insert_id();
    }
	
    function update_entry_swasta($kode)
    {
		$data['perusahaan']=$this->input->post('perusahaan');
		$data['nama_program']=$this->input->post('nama_program');
		$data['waktu']=$this->input->post('waktu');
		$data['lokasi_program']=$this->input->post('lokasi_program');
		$data['fokus_1']=$this->input->post('fokus_1');
		$data['fokus_2']=$this->input->post('fokus_2');
		$data['fokus_3']=$this->input->post('fokus_3');
		$data['fokus_4']=$this->input->post('fokus_4');
		$data['fokus_5']=$this->input->post('fokus_5');
		$data['fokus_6']=$this->input->post('fokus_6');
		$data['fokus_7']=$this->input->post('fokus_7');
		$data['fokus_8']=$this->input->post('fokus_8');
		$data['keterangan']=$this->input->post('keterangan');
        
		return $this->db->update($this->tabel2, $data, array('kode' => $kode));
    }
	

	function delete_entry_swasta($kode)
	{
		$this->db->where(array('kode' => $kode));

		return $this->db->delete($this->tabel2);
	}

    function get_count_provinsi($options=array())
    {
		foreach($options as $x=>$y){
			$this->db->like($x,$y);
		}
        return $this->db->count_all_results($this->tabel3);
    }

    function get_data_provinsi($start,$limit,$options=array())
    {
		foreach($options as $x=>$y){
			$this->db->like($x,$y);
		}
		$this->db->order_by($this->tabel3.'.kode','ASC');
        $query = $this->db->get($this->tabel3,$limit,$start);
        return $query->result();
    }

    function get_data_all_provinsi()
    {
		$this->db->from($this->tabel3);
		$this->db->order_by($this->tabel3.'.kode','DESC');
		$query = $this->db->get();
        return $query->result();
    }

 	function get_data_row_provinsi($kode){
		$data = array();
		$options = array('kode' => $kode);
		$query = $this->db->get_where($this->tabel3,$options,1);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}

		$query->free_result();    
		return $data;
	}
	
 	function cek_data_row_provinsi($kode){
		$data = array();
		$options = array('kode' => $kode);
		$query = $this->db->get_where($this->tabel3,$options,1);
		return $query->num_rows();
	}
	
   function insert_entry_provinsi()
    {
		$data['kode']=$this->input->post('kode');
		$data['nama']=$this->input->post('nama');

		return $this->db->insert($this->tabel3, $data);
    }
	
    function update_entry_provinsi($kode)
    {
		$dt_kon['kode']=$this->input->post('kode');
		$this->db->where(array('kode' => $dt_kon['kode']));
		$this->db->delete($this->tabel4);

		if(is_array($this->input->post('kondisi'))){
			foreach($this->input->post('kondisi') as $x=>$y){
				$dt_kon['id']=$y;
				$this->db->insert($this->tabel4, $dt_kon);
			}
		}

		$data['kode']=$this->input->post('kode');
		$data['nama']=$this->input->post('nama');
        
		return $this->db->update($this->tabel3, $data, array('kode' => $kode));
    }
	

	function delete_entry_provinsi($kode)
	{
		$this->db->where(array('kode' => $kode));
		$this->db->delete($this->tabel4);

		$this->db->where(array('kode' => $kode));
		return $this->db->delete($this->tabel3);
	}

    function get_data_kondisi()
    {
		$this->db->order_by('prm_kondis.kondisi','ASC');
        $query = $this->db->get('prm_kondis');
        return $query->result();
    }

    function get_data_kondisi_mapping($kode)
    {
		$dt = array();
		$this->db->where(array('kode' => $kode));
        $query = $this->db->get($this->tabel4);
        $data = $query->result_array();
		foreach($data as $x=>$y){
			$dt[]=$y['id'];
		}
        return $dt;
    }
}