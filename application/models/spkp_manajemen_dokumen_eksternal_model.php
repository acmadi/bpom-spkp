<?php
class Spkp_manajemen_dokumen_eksternal_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_dokumen(){
        $query = "SELECT @i:=@i+1 AS urut, a.id, a.no AS NO, a.tipe, a.judul, a.tentang, a.pengarang,
                 a.penerbit, a.ket, a.tahun_terbit, a.tempat, a.tempat_simpan, a.lama FROM spkp_manajemen_dokumen_eksternal a";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_data($id,$no){
        $query = $this->db->get_where('spkp_manajemen_dokumen_eksternal',array('id'=>$id,'no'=>$no),1);
        
        return $query->row_array();
    }
    
    function get_max_no($no){
        $query = $this->db->query("SELECT MAX(NO) AS max FROM spkp_manajemen_dokumen_eksternal WHERE id = '$no'");
        $data = $query->row_array();
        
        if(intval($data['max'])>0){
            $max = intval($data['max'])+1;
            
            if($max<10){
                $frmt = "000".$max;
            }else if($max<100){
                $frmt = "00".$max;
            }else if($max<1000){
                $frmt = "0".$max;
            }else if($max>=1000){
                $frmt = $max;
            }
            
            return $frmt;
        }else{
            return "0001";
        }
    }
    
    function insert(){
        $var = explode(" ",$this->input->post('id'));
        
        $data['id'] = $var[0];
        $data['no'] = $var[1];
        $data['tipe'] = $this->input->post('tipe');
        $data['judul'] = $this->input->post('judul');
        $data['tentang'] = $this->input->post('tentang');
        $data['pengarang'] = $this->input->post('pengarang');
        $data['penerbit'] = $this->input->post('penerbit');
        $data['ket'] = $this->input->post('ket');
        $data['tahun_terbit'] = $this->input->post('tahun_terbit');
        $data['tempat'] = $this->input->post('tempat');
        $data['tempat_simpan'] = $this->input->post('tempat_simpan');
        $data['lama'] = $this->input->post('lama');
        
        return $this->db->insert('spkp_manajemen_dokumen_eksternal',$data);
    }
    
    function update($id,$no){
        $data['judul'] = $this->input->post('judul');
        $data['tentang'] = $this->input->post('tentang');
        $data['pengarang'] = $this->input->post('pengarang');
        $data['penerbit'] = $this->input->post('penerbit');
        $data['ket'] = $this->input->post('ket');
        $data['tahun_terbit'] = $this->input->post('tahun_terbit');
        $data['tempat'] = $this->input->post('tempat');
        $data['tempat_simpan'] = $this->input->post('tempat_simpan');
        $data['lama'] = $this->input->post('lama');
        
        return $this->db->update('spkp_manajemen_dokumen_eksternal',$data,array('id'=>$id,'no'=>$no),1);
    }
    
    function delete($id,$no){
        $this->db->where(array('id'=>$id,'no'=>$no));
        return $this->db->delete('spkp_manajemen_dokumen_eksternal');
    }
    
    function cek_id(){
        $var = explode(" ",$this->input->post('id'));
        
        $id = $var[0];
        $no = $var[1];
        $tipe = $this->input->post('tipe');
        
        $query = $this->db->get_where('spkp_manajemen_dokumen_eksternal', array('id'=>$id,'no'=>$no,'tipe'=>$tipe),1);
        
        return $query->num_rows();
    }
}
?>