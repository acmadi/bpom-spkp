<?php
class Spkp_pjas_a016_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_form(){
        $query = "SELECT @i:=@i+1 AS urut, a.*, b.nama_balai FROM spkp_pjas_form_a016 a
                 INNER JOIN mas_balai b ON a.id_balai = b.id_balai";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_form($id){
        $query = $this->db->get_where('spkp_pjas_form_a016', array('id'=>$id),1);
        
        return $query->row_array();
    }
    
    function check_form($id){
        $query = $this->db->get_where('spkp_pjas_form_a016', array('id'=>$id),1);
        
        return $query->num_rows();
    }
    
    function insert_form(){
        $id = time();
        $data['id'] = $id;
        $data['bulan'] = $this->input->post('bulan');
        $data['id_balai'] = $this->input->post('id_balai');
        $data['tanggal'] = $this->input->post('tanggal');
        $data['penanggungjawab_jabatan'] = $this->input->post('penanggungjawab_jabatan');
        $data['penanggungjawab_nama'] = $this->input->post('penanggungjawab_nama');
        $data['penanggungjawab_nip'] = $this->input->post('penanggungjawab_nip');
        
        $this->db->insert('spkp_pjas_form_a016',$data);
        echo "1_".$id;
    }
    
    function update_form($id){
        $data['bulan'] = $this->input->post('bulan');
        $data['id_balai'] = $this->input->post('id_balai');
        $data['tanggal'] = $this->input->post('tanggal');
        $data['penanggungjawab_jabatan'] = $this->input->post('penanggungjawab_jabatan');
        $data['penanggungjawab_nama'] = $this->input->post('penanggungjawab_nama');
        $data['penanggungjawab_nip'] = $this->input->post('penanggungjawab_nip');
        
        return $this->db->update('spkp_pjas_form_a016',$data, array('id'=>$id));
    }
    
    function delete_form($id){
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a016');
        
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a016_hasil');
        
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a016_uji');
        
        return $x;
    }
    
    function get_all_balai(){
        $this->db->order_by('id_balai','asc');
        $query = $this->db->get('mas_balai');
        
        return $query->result();
    }
    
    function json_hasil($id){
        $query = "SELECT @i:=@i+1 AS urut, a.* FROM spkp_pjas_form_a016_hasil a WHERE a.id = '$id'";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_hasil($id,$hasil){
        $query = $this->db->get_where('spkp_pjas_form_a016_hasil', array('id'=>$id,'id_hasil'=>$hasil),1);
        
        return $query->row_array();
    }
    
    function insert_hasil($id){
        $data['id'] = $id;
        $data['id_hasil'] = time();
        $data['lokasi'] = $this->input->post('lokasi');
        $data['alamat'] = $this->input->post('alamat');
        $data['kabkota'] = $this->input->post('kota');
        $data['kode_sampel'] = $this->input->post('kode_sampel');
        $data['produk'] = $this->input->post('produk');
        $data['pedagang'] = $this->input->post('pedagang');
        $data['pengolah'] = $this->input->post('pengolah');
        $data['jenis'] = $this->input->post('jenis');
        $data['no_pendaftaran'] = $this->input->post('no_pendaftaran');
        $data['kesimpulan_akhir'] = $this->input->post('kesimpulan_akhir');
        $data['tindaklanjut'] = $this->input->post('tindaklanjut');
        
        return $this->db->insert('spkp_pjas_form_a016_hasil',$data);
    }
    
    function update_hasil($id){
        $data['lokasi'] = $this->input->post('lokasi');
        $data['alamat'] = $this->input->post('alamat');
        $data['kabkota'] = $this->input->post('kota');
        $data['kode_sampel'] = $this->input->post('kode_sampel');
        $data['produk'] = $this->input->post('produk');
        $data['pedagang'] = $this->input->post('pedagang');
        $data['pengolah'] = $this->input->post('pengolah');
        $data['jenis'] = $this->input->post('jenis');
        $data['no_pendaftaran'] = $this->input->post('no_pendaftaran');
        $data['kesimpulan_akhir'] = $this->input->post('kesimpulan_akhir');
        $data['tindaklanjut'] = $this->input->post('tindaklanjut');
        
        return $this->db->update('spkp_pjas_form_a016_hasil',$data, array('id'=>$id,'id_hasil'=>$this->input->post('id_hasil')));
    }
    
    function delete_hasil($id,$hasil){
        $this->db->where(array('id'=>$id,'id_hasil'=>$hasil));
        $x = $this->db->delete('spkp_pjas_form_a016_hasil');
        
        $this->db->where(array('id'=>$id,'id_hasil'=>$hasil));
        $x = $this->db->delete('spkp_pjas_form_a016_uji');
        
        return $x;
    }
    
    function json_uji($id,$hasil){
        $query = "SELECT @i:=@i+1 AS urut, a.* FROM spkp_pjas_form_a016_uji a WHERE a.id = '$id' and a.id_hasil = '$hasil'";
        
        return $this->crud->jqxGrid($query);
    }
    
    function get_uji($id,$hasil,$param){
        $query = $this->db->get_where('spkp_pjas_form_a016_uji', array('id'=>$id,'id_hasil'=>$hasil,'id_parameter'=>$param),1);
        
        return $query->row_array();
    }
    
    function insert_uji($id,$hasil){
        $data['id'] = $id;
        $data['id_hasil'] = $hasil;
        $data['id_parameter'] = time();
        $data['parameter'] = $this->input->post('parameter');
        $data['hasil'] = $this->input->post('hasil');
        $data['kesimpulan'] = $this->input->post('kesimpulan');
        
        return $this->db->insert('spkp_pjas_form_a016_uji',$data);
    }
    
    function update_uji($id,$hasil){
        $data['parameter'] = $this->input->post('parameter');
        $data['hasil'] = $this->input->post('hasil');
        $data['kesimpulan'] = $this->input->post('kesimpulan');
        
        return $this->db->update('spkp_pjas_form_a016_uji',$data, array('id'=>$id,'id_hasil'=>$hasil,'id_parameter'=>$this->input->post('id_parameter')));
    }
    
    function delete_uji($id,$hasil,$param){
        $this->db->where(array('id'=>$id,'id_hasil'=>$hasil,'id_parameter'=>$param));
        return $this->db->delete('spkp_pjas_form_a016_uji');
    }
    
    function get_all_propinsi(){
        $this->db->order_by('id_propinsi','asc');
        $query = $this->db->get('mas_propinsi');
        
        return $query->result();
    }
    
    function get_balai($balai){
        $query = $this->db->get_where('mas_balai', array('id_balai'=>$balai),1);
        $data = $query->row_array();
        
        return $data['nama_balai'];
    }
    
    function get_hasil_pengawasan($id){
        $this->db->order_by('id_hasil','asc');
        $query = $this->db->get_where('spkp_pjas_form_a016_hasil', array('id'=>$id));
        
        return $query->result();
    } 
    /*
    function get_hasil_pengawasan($id){
        $query = $this->db->query("SELECT a.*, b.parameter, b.hasil, b.kesimpulan
                                    FROM spkp_pjas_form_a016_hasil a RIGHT JOIN spkp_pjas_form_a016_uji b
                                    ON a.id_hasil = b.id_hasil WHERE a.id = '$id' ORDER BY a.id_hasil asc");
        
        return $query->result();
    } */
    
    function get_hasil_uji($id,$hasil){
        $this->db->order_by('id_parameter','asc');
        $query = $this->db->get_where('spkp_pjas_form_a016_uji', array('id'=>$id,'id_hasil'=>$hasil));    
        
        return $query->result();    
    }
    
    function get_kota($id){
        $query = $this->db->get_where('mas_kota', array('id_kota'=>$id),1);
        $data = $query->row_array();
        
        return $data['nama_kota'];
    }
    
    function insert_import($id,$var,$param,$parent,$child){
        $sukses=0;
        $gagal=0;
        $query_cek = $this->db->get_where('spkp_pjas_form_a016_hasil', array('lokasi'=>$var));
        $data_cek = $query_cek->num_rows();
        
        if($data_cek>0){
            $data_cek_rows = $query_cek->row_array();
            
            $query_cek_child = $this->db->get_where('spkp_pjas_form_a016_uji', $child);
            $data_cek_child = $query_cek_child->num_rows();
            
                $query_count_uji = $this->db->get_where('spkp_pjas_form_a016_uji', array('id'=>$id,'id_hasil'=>$data_cek_rows['id_hasil']));
                if($query_count_uji->num_rows()>0){
                    $query_max = $this->db->query("SELECT MAX(id_parameter) AS max FROM spkp_pjas_form_a016_uji WHERE id = '$id' AND id_hasil = '".$data_cek_rows['id_hasil']."'");
                    $data_max = $query_max->row_array();
                    
                    if($param!="" && $param!="."){
                        $data_child = $child;
                        $data_child['id'] = $id;
                        $data_child['id_hasil'] = $data_cek_rows['id_hasil'];
                        $data_child['id_parameter'] = $data_max['max'] + 1;
                        
                        $this->db->insert('spkp_pjas_form_a016_uji', $data_child);
                        $sukses++;
                    }
                }else{
                    if($param!="" && $param!="."){
                        $data_child = $child;
                        $data_child['id'] = $id;
                        $data_child['id_hasil'] = $data_cek_rows['id_hasil'];
                        $data_child['id_parameter'] = time();
                        
                        $this->db->insert('spkp_pjas_form_a016_uji', $data_child);
                        $sukses++;
                    }
                }
                
            
            
        }else{
            $query_count = $this->db->get_where('spkp_pjas_form_a016_hasil', array('id'=>$id));
            if($query_count->num_rows>0){
                $query_max_hasil = $this->db->query("SELECT MAX(id_hasil) AS max FROM spkp_pjas_form_a016_hasil WHERE id = '$id'");
                $data_max_hasil = $query_max_hasil->row_array();
                
                if($var!=""){
                    $id_hasil = $data_max_hasil['max']+1;
                    $data_parent = $parent;
                    $data_parent['id'] = $id;
                    $data_parent['id_hasil'] = $id_hasil;
                    
                    $this->db->insert('spkp_pjas_form_a016_hasil', $data_parent);
                    $sukses++;
                }
            }else{
                if($var!=""){
                    $id_hasil = time();
                    $data_parent = $parent;
                    $data_parent['id'] = $id;
                    $data_parent['id_hasil'] = $id_hasil;
                    
                    $this->db->insert('spkp_pjas_form_a016_hasil', $data_parent);
                    $sukses++;
                }
            }
            
            if($param!="" && $param!="."){
                $data_child = $child;
                $data_child['id'] = $id;
                $data_child['id_hasil'] = $id_hasil;
                $data_child['id_parameter'] = time();
                
                $this->db->insert('spkp_pjas_form_a016_uji', $data_child);
                $sukses++;
            }
        }
    }
    
    function get_all_kota(){
        $query = $this->db->query("SELECT * from mas_kota order by id_kota asc");
        
        return $query->result();
    }
    
    function cek_tanggal($id,$tgl){
        $query = $this->db->get_where('spkp_pjas_form_a016', array('id'=>$id,'tanggal'=>$tgl),1);
        
        return $query->num_rows();
    }
    
    function del_hasil_uji($id){
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a016_hasil');
        
        $this->db->where('id',$id);
        $x = $this->db->delete('spkp_pjas_form_a016_uji');
        
        return $x;
    }
}
?>