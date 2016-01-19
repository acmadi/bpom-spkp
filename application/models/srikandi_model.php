<?php
class Srikandi_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_judul(){
        $query = "SELECT @i:=@i+1 AS urut,  IF(a.update>1,FROM_UNIXTIME(a.update,'%Y/%m/%d %T'), 'NULL') AS waktu_update,
                a.id_srikandi AS id_file, a.judul, a.deskripsi, a.prioritas, a.uploader, a.update, a.filename, a.ip, b.username , c.nama as kategori
                FROM srikandi a 
                JOIN app_users_list b ON a.uploader = b.id
                JOIN mas_srikandi_kategori c ON a.id_kategori = c.id_kategori";

                if($this->session->userdata('searchsubdit')!=""){
                    $query .= " WHERE a.id_subdit='".$this->session->userdata('searchsubdit')."'";
                }
       
       return $this->crud->jqxGrid($query);         
    }

    function komentar(){
        $data['komentar'] = $this->input->post('komentar_detail');
        $data['id_srikandi'] = $this->input->post('id_srikandi');
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
       
        if($this->db->insert('srikandi_comment', $data)){
            return mysql_insert_id();
        }else{
            return false;
        }
    }
    function get_data_row($id){
        $query = $this->db->get_where('srikandi', array('id_srikandi'=>$id),1);
        $data = $query->row_array(); 

        $query = $this->db->get_where('mas_srikandi_kategori', array('id_kategori'=>$data['id_kategori']),1);
        $ket = $query->row_array(); 
        if($ket['id_kategori_parent'] > 0){
            $data['id_kategori_parent'] = $ket['id_kategori_parent'];
        }else{
            $data['id_kategori_parent'] = $data['id_kategori'];
            $data['id_kategori'] = 0;
        }

        return $data;
    }
    function getSubdit_detail($id_subdit){
        $data = array();

        $options = array('id_srikandi' => $id_subdit);
        $query = $this->db->query("SELECT @i:=@i+1 AS urut,  IF(a.update>1,FROM_UNIXTIME(a.update,'%Y/%m/%d %T'), 'NULL') AS waktu_update,
                a.id_srikandi AS id_file, a.judul, a.deskripsi, a.prioritas, a.uploader, a.update, a.filename, a.ip, b.username , c.nama AS kategori
                FROM srikandi a 
                JOIN app_users_list b ON a.uploader = b.id
                JOIN mas_srikandi_kategori c ON a.id_kategori = c.id_kategori where id_srikandi=$id_subdit");
        if ($query->num_rows() > 0){
            $data = $query->result();
        }
        $query->free_result();    
        return $data;
    }
    function upload_detail($id_subdit){
        $where = '(id_srikandi="$id_subdit" OR id_srikandi_ref="$id_subdit")';
        $this->db->where($where);
        $this->db->select('*');     
        $this->db->order_by('id_srikandi','asc');
        $query = $this->db->get('srikandi'); 
        return $query->result();    
    }

    function getSubdit($id_subdit){
        $this->db->where('status','subdit');
        $query = $this->db->get('mas_subdit');
        $result = $query->result_array();
        $data=array();
        $data="<option value='0'>-</option>";
        foreach($result as $x=>$y){
            $data.="<option value='".$y['id_subdit']."' ".($id_subdit==$y['id_subdit'] ? "selected":"").">".$y['ket']."</option>";
        }
        
        return $data;

    }
    function insert_upload_detail($id){
        $data=array(
            'kd_barang'=>$this->input->post('kd_barang'),
            'nm_barang'=>$this->input->post('nm_barang'),
            'stok'=>$this->input->post('stok'),
            'harga'=>$this->input->post('harga'),
        );
        $this->model_app->insertData('srikandi',$data);
        redirect("srikandi/detail/$id");
    }
    function getKategoriParent($id_subdit,$kategori=0)
    {
        $sql = "SELECT * FROM mas_srikandi_kategori WHERE id_kategori_parent='0' AND id_subdit='".$id_subdit."'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $data=array();
        $data['kategori']="<option></option>";
        foreach($result as $x=>$y){
            $data['kategori'].="<option value='".$y['id_kategori']."' ".($kategori==$y['id_kategori'] ? "selected":"").">".$y['nama']."</option>";
        }
        
        return $data;
    }
    
    function getKategori($id_kategori_parent,$kategori=0)
    {
        $data=array();
        if($id_kategori_parent!=""){
            $sql = "SELECT * FROM mas_srikandi_kategori WHERE id_kategori_parent='".$id_kategori_parent."'";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            $data['kategori']="";
            foreach($result as $x=>$y){
                $data['kategori'].="<option value='".$y['id_kategori']."' ".($kategori==$y['id_kategori'] ? "selected":"").">".$y['nama']."</option>";
            }
        }else{
            $data['kategori']="";
        }

        return $data;
    }

    function insert_upload($upload_data){
        $data['uploader'] = $this->session->userdata('id');
        $data['update'] = time();
        $data['deskripsi'] = $this->input->post('deskripsi');
        $data['judul'] = $this->input->post('judul');
        $data['id_subdit'] = $this->input->post('id_subdit');
		$data['id_kategori'] = $this->input->post('id_kategori') !="" ? $this->input->post('id_kategori') : $this->input->post('id_kategori_parent');
        $data['prioritas'] = $this->input->post('prioritas');
        $data['filename'] = $upload_data['file_name'];
        $data['filesize'] = $upload_data['file_size'];
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
       
        if($this->db->insert('srikandi', $data)){
			return mysql_insert_id();
		}else{
			return false;
		}
    }
    
    function update_upload($id,$upload_data=0){
        $data['uploader'] = $this->session->userdata('id');
        $data['update'] = time();
        $data['deskripsi'] = $this->input->post('deskripsi');
        $data['judul'] = $this->input->post('judul');
        $data['id_subdit'] = $this->input->post('id_subdit');
        $data['id_kategori'] = $this->input->post('id_kategori') !="" ? $this->input->post('id_kategori') : $this->input->post('id_kategori_parent');
        $data['prioritas'] = $this->input->post('prioritas');
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        
        if($upload_data!=0){
			$data['filename'] = $upload_data['file_name'];
			$data['filesize'] = $upload_data['file_size'];
		}
        
		return $this->db->update('srikandi', $data, array('id_srikandi'=>$id));
    }
    
    function delete_upload($id){
        $this->db->where('id_srikandi',$id);
        return $this->db->delete('srikandi');
    }
}
?>