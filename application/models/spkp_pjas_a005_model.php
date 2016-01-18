<?php
class Spkp_pjas_a005_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_form(){
        $query = "SELECT @i:=@i+1 AS urut, a.*, b.nama_balai FROM spkp_pjas_form_a005 a
                  INNER JOIN mas_balai b ON a.id_balai = b.id_balai";
        
        return $this->crud->jqxGrid($query);
    }
    
    function json_sekolah($id){
        $query = "SELECT @i:=@i+1 AS urut, a.* FROM spkp_pjas_form_a005_peserta a WHERE a.id = $id";
        
        return $this->crud->jqxGrid($query);
    }
    
    function json_materi($id){
        $query = "SELECT @i:=@i+1 AS urut, a.* FROM spkp_pjas_form_a005_peserta_bimtek_narasumber a WHERE a.id = $id";
        
        return $this->crud->jqxGrid($query);
    }
    
    function json_jumlah($id){
        $query = "SELECT @i:=@i+1 AS urut, a.* FROM spkp_pjas_form_a005_peserta_komunitas a WHERE a.id = $id";
        
        return $this->crud->jqxGrid($query);
    }
    
    function json_peserta($id){
        $query = "SELECT @i:=@i+1 AS urut, a.* FROM spkp_pjas_form_a005_peserta_bimtek a WHERE a.id = '$id'";
        
        return $this->crud->jqxGrid($query);         
    }
    
    function get_all_balai(){
        $this->db->order_by('id_balai','asc');
        $query = $this->db->get('mas_balai');
        
        return $query->result();
    }
    
    function insert_form(){
        $id = time();
        $data['id'] = $id;
        $data['id_balai'] = $this->input->post('balai');
        $data['tempat'] = $this->input->post('tempat');
        $data['tanggal'] = $this->input->post('tanggal');
        $data['penanggungjawab_tempat'] = $this->input->post('penanggungjawab_tempat');
        $data['penanggungjawab_tanggal'] = $this->input->post('penanggungjawab_tanggal');
        $data['hasil'] = $this->input->post('hasil');
        $data['penanggungjawab_nama'] = $this->input->post('penanggungjawab_nama');
        $data['penanggungjawab_nip'] = $this->input->post('penanggungjawab_nip');
        
        $this->db->insert('spkp_pjas_form_a005',$data);
        echo "1_".$id;
    }
    
    function update_form($id){
        $data['id_balai'] = $this->input->post('balai');
        $data['tempat'] = $this->input->post('tempat');
        $data['tanggal'] = $this->input->post('tanggal');
        $data['penanggungjawab_tempat'] = $this->input->post('penanggungjawab_tempat');
        $data['penanggungjawab_tanggal'] = $this->input->post('penanggungjawab_tanggal');
        $data['hasil'] = $this->input->post('hasil');
        $data['penanggungjawab_nama'] = $this->input->post('penanggungjawab_nama');
        $data['penanggungjawab_nip'] = $this->input->post('penanggungjawab_nip');
        
        return $this->db->update('spkp_pjas_form_a005',$data, array('id'=>$id));
    }
    
    function delete_form($id){
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a005');
        
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a005_peserta');
        
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a005_peserta_bimtek');
        
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a005_peserta_bimtek_hari');
        
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a005_peserta_bimtek_narasumber');
        
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a005_peserta_komunitas');
        
        return $x;
    }
    
    function check_form($id){
        $query = $this->db->get_where('spkp_pjas_form_a005', array('id'=>$id),1);
        
        return $query->num_rows();
    }
    
    function get_form($id){
        $query = $this->db->get_where('spkp_pjas_form_a005', array('id'=>$id),1);
        
        return $query->row_array();
    }
    
    function insert_sekolah($id){
        $data['id'] = $id;
        $data['id_peserta'] = time();
        $data['nama'] = $this->input->post('nama');
        $data['STATUS'] = $this->input->post('status');
        $data['akreditasi'] = $this->input->post('akreditasi');
        $data['kantin'] = $this->input->post('kantin');
        $data['internet'] = $this->input->post('internet');
        
        return $this->db->insert('spkp_pjas_form_a005_peserta', $data);
    }
    
    function update_sekolah($id){
        $data['nama'] = $this->input->post('nama');
        $data['STATUS'] = $this->input->post('status');
        $data['akreditasi'] = $this->input->post('akreditasi');
        $data['kantin'] = $this->input->post('kantin');
        $data['internet'] = $this->input->post('internet');
        
        return $this->db->update('spkp_pjas_form_a005_peserta', $data, array('id'=>$id,'id_peserta'=>$this->input->post('id_peserta')));
    }
    
    function delete_sekolah($id,$peserta){
        $this->db->where(array('id'=>$id,'id_peserta'=>$peserta));
        
        return $this->db->delete('spkp_pjas_form_a005_peserta');
    }
    
    function get_data_sekolah($id,$peserta){
        $query = $this->db->get_where('spkp_pjas_form_a005_peserta', array('id'=>$id,'id_peserta'=>$peserta),1);
        
        return $query->row_array();
    }
    
    function insert_materi($id){
        $data['id'] = $id;
        $data['id_narasumber'] = time();
        $data['nama'] = $this->input->post('nama');
        $data['instansi'] = $this->input->post('instansi');
        $data['materi'] = $this->input->post('materi');
        
        return $this->db->insert('spkp_pjas_form_a005_peserta_bimtek_narasumber', $data);
    }
    
    function update_materi($id){
        $data['nama'] = $this->input->post('nama');
        $data['instansi'] = $this->input->post('instansi');
        $data['materi'] = $this->input->post('materi');
        
        return $this->db->update('spkp_pjas_form_a005_peserta_bimtek_narasumber', $data, array('id'=>$id,'id_narasumber'=>$this->input->post('id_narasumber')));
    }
    
    function delete_materi($id,$narasumber){
        $this->db->where(array('id'=>$id,'id_narasumber'=>$narasumber));
        
        return $this->db->delete('spkp_pjas_form_a005_peserta_bimtek_narasumber');
    }
    
    function get_data_materi($id,$narasumber){
        $query = $this->db->get_where('spkp_pjas_form_a005_peserta_bimtek_narasumber', array('id'=>$id,'id_narasumber'=>$narasumber),1);
        
        return $query->row_array();
    }
    
    function check_hari_jumlah_peserta($id){
        $query = $this->db->get_where('spkp_pjas_form_a005_peserta_komunitas', array('id'=>$id));
        $data = $query->num_rows();  
        
        if($data>0){
            $query_max = $this->db->query("SELECT MAX(hari) AS max FROM spkp_pjas_form_a005_peserta_komunitas WHERE id = '$id'");
            $data_max = $query_max->row_array();
            
            return intval($data_max['max']+1);
        }else{
            return "1";
        }  
    }
    
    function insert_jumlah_peserta($id){
        $kepsek = $this->input->post('kepsek');
        $guru_uks = $this->input->post('guru_uks');
        $guru = $this->input->post('guru');
        $kantin = $this->input->post('kantin');
        $komite = $this->input->post('komite');
        $kelas4 = $this->input->post('kelas4');
        $kelas5 = $this->input->post('kelas5');
        $lainnya = $this->input->post('lainnya');
        
        $data['id'] = $id;
        $data['hari'] = $this->check_hari_jumlah_peserta($id);
        $data['kepsek'] = $kepsek;
        $data['guru_uks'] = $guru_uks;
        $data['guru'] = $guru;
        $data['kantin'] = $kantin;
        $data['komite'] = $komite;
        $data['kelas4'] = $kelas4;
        $data['kelas5'] = $kelas5;
        $data['lainnya'] =$lainnya;
        $data['total'] = intval($kepsek+$guru_uks+$guru+$kantin+$komite+$kelas4+$kelas5+$lainnya);
        
        return $this->db->insert('spkp_pjas_form_a005_peserta_komunitas', $data);
    }
    
    function update_jumlah_peserta($id){
        $kepsek = $this->input->post('kepsek');
        $guru_uks = $this->input->post('guru_uks');
        $guru = $this->input->post('guru');
        $kantin = $this->input->post('kantin');
        $komite = $this->input->post('komite');
        $kelas4 = $this->input->post('kelas4');
        $kelas5 = $this->input->post('kelas5');
        $lainnya = $this->input->post('lainnya');
        
        $data['kepsek'] = $kepsek;
        $data['guru_uks'] = $guru_uks;
        $data['guru'] = $guru;
        $data['kantin'] = $kantin;
        $data['komite'] = $komite;
        $data['kelas4'] = $kelas4;
        $data['kelas5'] = $kelas5;
        $data['lainnya'] =$lainnya;
        $data['total'] = intval($kepsek+$guru_uks+$guru+$kantin+$komite+$kelas4+$kelas5+$lainnya);
        
        return $this->db->update('spkp_pjas_form_a005_peserta_komunitas', $data, array('id'=>$id,'hari'=>$this->input->post('hari')));
    }
    
    function get_jumlah_peserta($id,$hari){
        $query = $this->db->get_where('spkp_pjas_form_a005_peserta_komunitas', array('id'=>$id,'hari'=>$hari),1);
        
        return $query->row_array();
    }
    
    function delete_jumlah_peserta($id,$hari){
        $this->db->where(array('id'=>$id,'hari'=>$hari));
        
        return $this->db->delete('spkp_pjas_form_a005_peserta_komunitas');
    }
    
    function insert_peserta($id){
        $time = time();
        
        $data['id'] = $id;
        $data['id_peserta'] = $time;
        $data['nama'] = $this->input->post('nama');
        $data['jabatan'] = $this->input->post('jabatan');
        
        $y = $this->db->insert('spkp_pjas_form_a005_peserta_bimtek', $data);
        
        foreach($_POST as $var=>$val){
            $value="";
            if(substr($var,0,6)=="check_"){
                $value = explode("_", $val);
                
                $hari['id'] = $id;
                $hari['id_peserta'] = $time;
                $hari['hari'] = $val;
                
                $y = $this->db->insert('spkp_pjas_form_a005_peserta_bimtek_hari', $hari);
            }
        }
        
        return $y;
    }
    
    function update_peserta($id){
        $data['nama'] = $this->input->post('nama');
        $data['jabatan'] = $this->input->post('jabatan');
        
        $y = $this->db->update('spkp_pjas_form_a005_peserta_bimtek', $data, array('id'=>$id,'id_peserta'=>$this->input->post('id_peserta')));
        
        $this->delete_hari($id,$this->input->post('id_peserta'));
        
        foreach($_POST as $var=>$val){
            $value="";
            if(substr($var,0,6)=="check_"){
                $value = explode("_", $val);
                
                $hari['id'] = $id;
                $hari['id_peserta'] = $this->input->post('id_peserta');
                $hari['hari'] = $val;
                
                $y = $this->db->insert('spkp_pjas_form_a005_peserta_bimtek_hari', $hari);
            }
        }
        
        return $y;
    }
    
    function get_peserta($id,$peserta){
        $query = $this->db->get_where('spkp_pjas_form_a005_peserta_bimtek', array('id'=>$id,'id_peserta'=>$peserta),1);
        
        return $query->row_array();
    }
    
    function delete_peserta($id,$peserta){
        $this->db->where(array('id'=>$id,'id_peserta'=>$peserta));
        $x = $this->db->delete('spkp_pjas_form_a005_peserta_bimtek');
        
        $this->db->where(array('id'=>$id,'id_peserta'=>$peserta));
        $x = $this->db->delete('spkp_pjas_form_a005_peserta_bimtek_hari');
        
        return $x;
    }
    
    function delete_hari($id,$peserta){
        $this->db->where(array('id'=>$id,'id_peserta'=>$peserta));
        return  $this->db->delete('spkp_pjas_form_a005_peserta_bimtek_hari');
    }
    
    function get_max_hari($id){
        $query = $this->db->query("SELECT MAX(hari) AS max FROM spkp_pjas_form_a005_peserta_komunitas WHERE id = '$id'");
        
        return  $query->row_array();
    }
    
    function get_hari($id,$peserta,$hari){
        $query = $this->db->get_where('spkp_pjas_form_a005_peserta_bimtek_hari', array('id'=>$id,'id_peserta'=>$peserta,'hari'=>$hari));
        
        return $query->num_rows();
    }
    
    function get_balai($balai){
        $query = $this->db->get_where('mas_balai', array('id_balai'=>$balai),1);
        $data = $query->row_array();
        
        return $data['nama_balai'];
    }
    
    function get_peserta_sdmi($id){
        $this->db->order_by('id_peserta','asc');
        $query = $this->db->get_where('spkp_pjas_form_a005_peserta', array('id'=>$id));
        
        return $query->result();
    }
    
    function get_peserta_komunitas($id){
        $this->db->order_by('hari','asc');
        $query = $this->db->get_where('spkp_pjas_form_a005_peserta_komunitas', array('id'=>$id));
        
        return $query->result();
    }
    
    function get_materi_bimtek($id){
        $this->db->order_by('id_narasumber','asc');
        $query = $this->db->get_where('spkp_pjas_form_a005_peserta_bimtek_narasumber', array('id'=>$id));
        
        return $query->result();
    }
    
    function get_peserta_lintas_sektor($id){
        $this->db->order_by('id_peserta','asc');
        $query = $this->db->get_where('spkp_pjas_form_a005_peserta_bimtek', array('id'=>$id));
        
        return $query->result();
    }
    
    function get_hari_peserta_lintas($id,$peserta){
        $this->db->order_by('hari','asc');
        $query = $this->db->get_where('spkp_pjas_form_a005_peserta_bimtek_hari', array('id'=>$id,'id_peserta'=>$peserta));
        
        return $query->result();
    }
    
}
?>