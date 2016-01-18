<?php 
Class Spkp_pjas_a007b_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
	}
	
	function get_all_balai(){
        $this->db->order_by('nama_balai','asc');
        $query = $this->db->get('mas_balai');
        
        return $query->result();
    }
	
	function json_kegiatan(){
		$query="SELECT @i:=@i+1 AS urut, a.id, a.ttd_nama, a.ttd_nip, a.ttd_tmpt, a.ttd_tgl,
		a.id_balai, b.nama_balai, a.kegiatan_nama, a.kegiatan_tgl, a.kegiatan_tmpt, a.kegiatan_penyelenggara
		FROM spkp_pjas_form_a007 a INNER JOIN mas_balai b ON b.id_balai=a.id_balai ORDER BY a.id ASC";
		
		return $this->crud->jqxgrid($query);
	}
	
	function insert_kegiatan(){
		$data['id']=$this->input->post('id');
		$data['id_balai']=$this->input->post('id_balai');
		$data['ttd_nama']=$this->input->post('ttd_nama');
		$data['ttd_nip']=str_replace(" ","",$this->input->post('ttd_nip'));
		$data['ttd_tmpt']=$this->input->post('ttd_tmpt');
		$data['ttd_tgl']=$this->input->post('ttd_tgl');
		$data['kegiatan_nama']=$this->input->post('kegiatan_nama');
		$data['kegiatan_tmpt']=$this->input->post('kegiatan_tmpt');
		$data['kegiatan_tgl']=$this->input->post('kegiatan_tgl');
		$data['kegiatan_penyelenggara']=$this->input->post('kegiatan_penyelenggara');
		
		$this->db->insert('spkp_pjas_form_a007',$data);
		echo "1_".$this->input->post('id');
	}
	
	function get_data_kegiatan($id){
		$query=$this->db->query("SELECT @i:=@i+1 AS urut, a.id, a.ttd_nama, a.ttd_nip, a.ttd_tmpt, a.ttd_tgl,
		a.id_balai, b.nama_balai, a.kegiatan_nama, a.kegiatan_tgl, a.kegiatan_tmpt, a.kegiatan_penyelenggara,
		a.jml_kepsek, a.jml_guru, a.jml_kantin, a.jml_pedagang, a.jml_komite, a.jml_siswa
		FROM spkp_pjas_form_a007 a INNER JOIN mas_balai b ON b.id_balai=a.id_balai 
		WHERE a.id=$id ORDER BY a.id ASC");
		
		return $query->row_array();
	}
	
	function update_kegiatan(){
		$data['id']=$this->input->post('id');
		$data['id_balai']=$this->input->post('id_balai');
		$data['ttd_nama']=$this->input->post('ttd_nama');
		$data['ttd_nip']=str_replace(" ","",$this->input->post('ttd_nip'));
		$data['ttd_tmpt']=$this->input->post('ttd_tmpt');
		$data['ttd_tgl']=$this->input->post('ttd_tgl');
		$data['kegiatan_nama']=$this->input->post('kegiatan_nama');
		$data['kegiatan_tmpt']=$this->input->post('kegiatan_tmpt');
		$data['kegiatan_tgl']=$this->input->post('kegiatan_tgl');
		$data['kegiatan_penyelenggara']=$this->input->post('kegiatan_penyelenggara');
		
		$this->db->update('spkp_pjas_form_a007',$data,array('id'=>$this->input->post('id')));
	}
	
	function delete_kegiatan($id){
		$this->db->where('id',$id);
		$x=$this->db->delete('spkp_pjas_form_a007');
		
		$this->db->where('id',$id);
		$x=$this->db->delete('spkp_pjas_form_a007_materi');
		
		$this->db->where('id',$id);
		$x=$this->db->delete('spkp_pjas_form_a007_peserta');
		
		$this->db->where('id',$id);
		$x=$this->db->delete('spkp_pjas_form_a007_pesertalintas');
		
		$this->db->where('id',$id);
		$x=$this->db->delete('spkp_pjas_form_a007_petugas');
		
		return $x;
	}
	
	function json_petugas($id){
		$query="SELECT @i:=@i+1 AS urut, id, id_petugas, nama FROM spkp_pjas_form_a007_petugas
		 WHERE id=$id ORDER BY id_petugas ASC";
		
		return $this->crud->jqxgrid($query);
	}
	
	function insert_petugas(){
		$data['id']=$this->input->post('id');
		$data['id_petugas']=$this->input->post('id_petugas');
		$data['nama']=$this->input->post('nama');
		
		return $this->db->insert('spkp_pjas_form_a007_petugas',$data);
	}
	
	function delete_petugas($id_petugas){
		$this->db->where('id_petugas',$id_petugas);
		return $this->db->delete('spkp_pjas_form_a007_petugas');
	}
	
	function json_materi($id){
		$query="SELECT @i:=@i+1 AS urut, id, id_materi, materi FROM spkp_pjas_form_a007_materi
		 WHERE id=$id ORDER BY id_materi ASC";
		
		return $this->crud->jqxgrid($query);
	}
	
	function insert_materi(){
		$data['id']=$this->input->post('id');
		$data['id_materi']=$this->input->post('id_materi');
		$data['materi']=$this->input->post('materi');
		
		return $this->db->insert('spkp_pjas_form_a007_materi',$data);
	}
	
	function delete_materi($id_materi){
		$this->db->where('id_materi',$id_materi);
		return $this->db->delete('spkp_pjas_form_a007_materi');
	}
	
	function json_peserta($id){
		$query="SELECT @i:=@i+1 AS urut, id, id_peserta, nama, status, akreditasi, keterangan
		FROM spkp_pjas_form_a007_peserta WHERE id=$id ORDER BY id_peserta ASC";
		
		return $this->crud->jqxgrid($query);
	}
	
	function count_peserta($id){
		$query= $this->db->query("SELECT COUNT(*) AS jml_peserta FROM spkp_pjas_form_a007_peserta WHERE id=$id ");
		
		return $query->result();
	}
	
	function insert_peserta(){
		$data['id']=$this->input->post('id');
		$data['id_peserta']=$this->input->post('id_peserta');
		$data['nama']=$this->input->post('nama');
		$data['status']=$this->input->post('status');
		$data['akreditasi']=$this->input->post('akreditasi');
		$data['keterangan']=$this->input->post('keterangan');
		
		return $this->db->insert('spkp_pjas_form_a007_peserta',$data);
	}
	
	function update_peserta(){
		$data['id']=$this->input->post('id');
		$data['id_peserta']=$this->input->post('id_peserta');
		$data['nama']=$this->input->post('nama');
		$data['status']=$this->input->post('status');
		$data['akreditasi']=$this->input->post('akreditasi');
		$data['keterangan']=$this->input->post('keterangan');
		
		return $this->db->update('spkp_pjas_form_a007_peserta',$data,array('id_peserta'=>$this->input->post('id_peserta')));
	}
	
	function get_data_peserta($id_peserta){
		$query=$this->db->query("SELECT @i:=@i+1 AS urut, id, id_peserta, nama, status, akreditasi, keterangan
		FROM spkp_pjas_form_a007_peserta WHERE id_peserta=$id_peserta ORDER BY id_peserta ASC");
		
		return $query->row_array();
	}
	
	function delete_peserta($id_peserta){
		$this->db->where('id_peserta',$id_peserta);
		return $this->db->delete('spkp_pjas_form_a007_peserta');
	}
	
	function json_komposisi($id){
		$query="SELECT @i:=@i+1 AS urut, id, jml_kepsek, jml_guru, jml_kantin, jml_pedagang, jml_komite, jml_siswa,
		(jml_kepsek+jml_guru+jml_kantin+jml_pedagang+jml_komite+jml_siswa) AS jml_total
		FROM spkp_pjas_form_a007 WHERE id=$id";
		
		return $this->crud->jqxgrid($query);
	}
	
	function update_komposisi(){
		$data['id']=$this->input->post('id');
		$data['jml_kepsek']=$this->input->post('jml_kepsek');
		$data['jml_guru']=$this->input->post('jml_guru');
		$data['jml_kantin']=$this->input->post('jml_kantin');
		$data['jml_pedagang']=$this->input->post('jml_pedagang');
		$data['jml_komite']=$this->input->post('jml_komite');
		$data['jml_siswa']=$this->input->post('jml_siswa');
		
		return $this->db->update('spkp_pjas_form_a007',$data,array('id'=>$this->input->post('id')));
	}
	
	function get_data_komposisi($id){
		$query=$this->db->query("SELECT @i:=@i+1 AS urut, id, jml_kepsek, jml_guru, jml_kantin, jml_pedagang, jml_komite, jml_siswa
		FROM spkp_pjas_form_a007 WHERE id=$id ");
		
		return $query->row_array();
	}
	
	function json_pesertalintas($id){
		$query="SELECT @i:=@i+1 AS urut, id, id_peserta, nama, instansi
		FROM spkp_pjas_form_a007_pesertalintas WHERE id=$id ORDER BY id_peserta ASC";
		
		return $this->crud->jqxgrid($query);
	}
	
	function insert_pesertalintas(){
		$data['id']=$this->input->post('id');
		$data['id_peserta']=$this->input->post('id_peserta');
		$data['nama']=$this->input->post('nama');
		$data['instansi']=$this->input->post('instansi');
		
		return $this->db->insert('spkp_pjas_form_a007_pesertalintas',$data);
	}
	
	function update_pesertalintas(){
		$data['id']=$this->input->post('id');
		$data['id_peserta']=$this->input->post('id_peserta');
		$data['nama']=$this->input->post('nama');
		$data['instansi']=$this->input->post('instansi');
		
		return $this->db->update('spkp_pjas_form_a007_pesertalintas',$data,array('id_peserta'=>$this->input->post('id_peserta')));
	}
	
	function get_data_pesertalintas($id_peserta){
		$query=$this->db->query("SELECT @i:=@i+1 AS urut, id, id_peserta, nama, instansi
		FROM spkp_pjas_form_a007_pesertalintas WHERE id_peserta=$id_peserta ORDER BY id_peserta ASC");
		
		return $query->row_array();
	}
	
	function delete_pesertalintas($id_peserta){
		$this->db->where('id_peserta',$id_peserta);
		return $this->db->delete('spkp_pjas_form_a007_pesertalintas');
	}
	
}
?>