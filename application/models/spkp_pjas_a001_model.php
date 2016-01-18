<?php
class Spkp_pjas_a001_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_program(){
        $query = "SELECT @i:=@i+1 AS urut, a.*, b.nama AS nama_strategi FROM spkp_pjas_form_a001_lintas a
                INNER JOIN mas_strategi_pjas b ON a.strategi = b.id_strategi";
        
        return $this->crud->jqxGrid($query);
    }
    
    function json_kegiatan($propinsi,$thn){
        $query = "SELECT @i:=@i+1 AS urut, a.*, b.strategi, b.nama AS nama_program, c.nama_propinsi
                FROM spkp_pjas_form_a001 a INNER JOIN spkp_pjas_form_a001_lintas b
                ON a.program = b.id_program INNER JOIN mas_propinsi c 
                ON a.propinsi = c.id_propinsi WHERE a.propinsi = '$propinsi' and a.tahun = '$thn'";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_data_row($id){
        $query = $this->db->get_where('spkp_pjas_form_a001_lintas', array('id_program'=>$id),1);
        
        return $query->row_array();    
    }
    
    function get_data_kegiatan($id){
        $query = $this->db->get_where('spkp_pjas_form_a001', array('id_kegiatan'=>$id),1);
        
        return $query->row_array();
    }
    
    function insert_program(){
        $data['strategi'] = $this->input->post('strategi');
        $data['nama'] = $this->input->post('nama');
        
        return $this->db->insert('spkp_pjas_form_a001_lintas',$data);
    }
    
    function insert_kegiatan(){
        $data['propinsi'] = $this->input->post('propinsi');
        $data['tahun'] = $this->input->post('tahun');
        $data['program'] = $this->input->post('program');
        $data['nama'] = $this->input->post('nama');
        $data['instansi'] = $this->input->post('instansi');
        $data['indikator'] = $this->input->post('indikator');
        $data['target'] = $this->input->post('target');
        $data['waktu'] = $this->input->post('waktu');
        $data['sumber_dana'] = $this->input->post('sumber_dana');
        
        return $this->db->insert('spkp_pjas_form_a001',$data);
    }
    
    function update_program(){
        $data['strategi'] = $this->input->post('strategi');
        $data['nama'] = $this->input->post('nama');
        
        return $this->db->update('spkp_pjas_form_a001_lintas',$data,array('id_program'=>$this->input->post('id_program')));
    }
    
    function update_kegiatan(){
        $data['propinsi'] = $this->input->post('propinsi');
        $data['tahun'] = $this->input->post('tahun');
        $data['program'] = $this->input->post('program');
        $data['nama'] = $this->input->post('nama');
        $data['instansi'] = $this->input->post('instansi');
        $data['indikator'] = $this->input->post('indikator');
        $data['target'] = $this->input->post('target');
        $data['waktu'] = $this->input->post('waktu');
        $data['sumber_dana'] = $this->input->post('sumber_dana');
        
        return $this->db->update('spkp_pjas_form_a001',$data,array('id_kegiatan'=>$this->input->post('id_kegiatan')));
    }
    
    function delete_program($id){
        $this->db->where('id_program',$id);
        $x = $this->db->delete('spkp_pjas_form_a001_lintas');
        
        $this->db->where('program',$id);
        $x = $this->db->delete('spkp_pjas_form_a001');
        
        return $x;
    }
    
    function delete_kegiatan($id){
        $this->db->where('id_kegiatan',$id);
        return  $this->db->delete('spkp_pjas_form_a001');
    }
    
    function get_all_strategi(){
        $this->db->order_by('id_strategi','asc');
        $query = $this->db->get('mas_strategi_pjas');
        
        return $query->result();
    }
    
    function get_all_program(){
        $this->db->order_by('id_program','asc');
        $query = $this->db->get('spkp_pjas_form_a001_lintas');
        
        return $query->result();
    }
    
    function get_all_propinsi(){
        $this->db->order_by('id_propinsi','asc');
        $query = $this->db->get('mas_propinsi');
        
        return $query->result();
    }
    
    function get_load_propinsi(){
        $query = $this->db->query("SELECT a.* FROM mas_propinsi a INNER JOIN spkp_pjas_form_a001 b
                                ON a.id_propinsi = b.propinsi GROUP BY a.id_propinsi");
        
        return $query->result();
    }
    
    function get_program($startegi){
        $query = $this->db->get_where('spkp_pjas_form_a001_lintas', array('strategi'=>$startegi));
        
        return $query->result();
    }
    
    function get_kegiatan($program,$propinsi,$thn){
        $query = $this->db->get_where('spkp_pjas_form_a001', array('program'=>$program,'propinsi'=>$propinsi,'tahun'=>$thn));
        
        return $query;
    }
    
    function get_propinsi($id){
        $query = $this->db->get_where('mas_propinsi', array('id_propinsi'=>$id),1);
        $data = $query->row_array();
        
        return $data['nama_propinsi'];
    }
    
    function get_strategi(){
        $query = $this->db->query("SELECT a.*, b.id_program, b.strategi, b.nama AS nama_program
                                FROM mas_strategi_pjas a INNER JOIN spkp_pjas_form_a001_lintas b
                                ON a.id_strategi = b.strategi GROUP BY b.strategi");
                                
        return $query->result();
    }
    
    function get_export_data($thn,$propinsi){
        $query = $this->db->query("SELECT a.nama AS nama_strategi, b.id_program, b.strategi, b.nama AS nama_program,
                                c.nama,c.instansi,c.indikator,c.target,c.waktu,c.sumber_dana
                                FROM mas_strategi_pjas a 
                                	LEFT JOIN spkp_pjas_form_a001_lintas b
                                	ON a.id_strategi = b.strategi
                                	LEFT JOIN spkp_pjas_form_a001 c
                                	ON b.id_program = c.program WHERE c.tahun = '$thn' AND c.propinsi = '$propinsi'
                                    ORDER BY b.id_program ASC,c.id_kegiatan ASC");
                                    
    
        return $query->result();
    }
}
?>