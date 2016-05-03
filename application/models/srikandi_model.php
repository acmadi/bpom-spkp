<?php
class Srikandi_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
        $this->load->library('encrypt');
    }
    
    function json_judul(){
        $query = "SELECT @i:=@i+1 AS urut,IF(a.update>1,FROM_UNIXTIME(a.update,'%Y/%m/%d %T'), 'NULL') AS waktu_update,
                a.id_srikandi_ref AS id_file, a.judul, a.deskripsi, a.prioritas, a.uploader, a.update, a.filename, a.ip, b.username , c.nama AS kategori,
                (SELECT COUNT(*) FROM srikandi_comment WHERE id_srikandi = a.id_srikandi_ref) AS jumlahkomen,
                (SELECT COUNT(*) FROM srikandi WHERE id_srikandi_ref = a.id_srikandi_ref) AS jumlahrevisi,
                srikandi_log.status
                FROM srikandi a 
                JOIN app_users_list b ON a.uploader = b.id
                JOIN mas_srikandi_kategori c ON a.id_kategori = c.id_kategori
                LEFT JOIN srikandi_log ON srikandi_log.id_srikandi=a.id_srikandi_ref AND srikandi_log.user_id='".$this->session->userdata('id')."'
                WHERE a.status=1 ";

                if($this->session->userdata('searchsubdit')!=""){
                    if($this->session->userdata('searchsubdit')!="0"){
                    $query .= " AND a.id_subdit='".$this->session->userdata('searchsubdit')."' ";
                    }
                }
        
                $query .= " GROUP BY a.id_srikandi_ref ORDER BY srikandi_log.status ASC,a.update DESC";

       return $this->crud->jqxGrid($query);         
    }

    function komentar(){
        $data['komentar'] = $this->input->post('komentar_detail');
        $data['id_srikandi'] = $this->input->post('id_srikandi');
        $data['uploader'] = $this->session->userdata('id');
        $data['update'] = time();
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
       
        if($this->db->insert('srikandi_comment', $data)){
            $id = mysql_insert_id();;

            $this->db->where('id_srikandi',$data['id_srikandi']);
            $this->db->delete('srikandi_log');

            return $id;
        }else{
            return false;
        }
    }

    function get_comment($id){
        
        $this->db->where('id_srikandi',$id);
        $this->db->select("srikandi_comment.*,app_users_profile.username,app_users_profile.image");
        $this->db->join('app_users_profile', "srikandi_comment.uploader = app_users_profile.id",'inner');
        $this->db->order_by('id_comment','desc');
        $query = $this->db->get('srikandi_comment');
        $data = $query->result(); 

        return $data;
    }

    function get_data_row($id){
        $this->db->where('id_srikandi',$id);
        $this->db->select("srikandi.*,mas_subdit.ket as nama_subdit,mas_srikandi_kategori.nama as kategori,mas_srikandi_kategori.id_kategori_parent");
        $this->db->join('mas_subdit', "srikandi.id_subdit = mas_subdit.id_subdit",'inner');
        $this->db->join('mas_srikandi_kategori', "srikandi.id_kategori = mas_srikandi_kategori.id_kategori",'inner');
        $query = $this->db->get('srikandi',1);
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

    function log($id){
        $this->db->where('id_srikandi',$id);
        $this->db->where('user_id',$this->session->userdata('id'));
        $query = $this->db->get('srikandi_log');
        $data = $query->row(); 

        if(empty($data->id_srikandi)){
            $log = array();
            $log['id_srikandi'] = $id;
            $log['user_id'] = $this->session->userdata('id');
            $log['status'] = 1;
            $this->db->insert('srikandi_log',$log);
        }
    }

    function getSubdit_detail($id_subdit){
        $data = array();

        $options = array('id_srikandi' => $id_subdit);
        $query = $this->db->query("SELECT @i:=@i+1 AS urut,  IF(a.update>1,FROM_UNIXTIME(a.update,'%Y/%m/%d %T'), 'NULL') AS waktu_update,
                a.id_srikandi AS id_file, a.judul, a.id_subdit,a.id_kategori, c.id_kategori_parent,a.prioritas,a.deskripsi, a.prioritas, a.uploader, a.update, a.filename, a.ip, b.username , c.nama AS kategori, d.ket as nama_subdit
                FROM srikandi a 
                JOIN app_users_list b ON a.uploader = b.id
                JOIN `mas_subdit` d ON d.id_subdit = a.id_subdit
                JOIN mas_srikandi_kategori c ON a.id_kategori = c.id_kategori where id_srikandi=$id_subdit");
        if ($query->num_rows() > 0){
            $data = $query->row_array();

        }
        $query->free_result();    
        return $data;
    }

    function upload_detail($id_subdit){
        $where = '(srikandi.id_srikandi="'.$id_subdit.'" OR srikandi.id_srikandi_ref="'.$id_subdit.'")';
        $this->db->where($where);
        $this->db->select('srikandi.*,app_users_list.username,srikandi_log.status as status_log');     
        $this->db->join('app_users_list','app_users_list.id=srikandi.uploader');
        $this->db->join('srikandi_log','srikandi_log.id_srikandi=srikandi.id_srikandi AND srikandi_log.user_id="'.$this->session->userdata('id').'"','left');
        $this->db->order_by('srikandi.id_srikandi','desc');
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
        $data['id_kategori'] = ($this->input->post('id_kategori') !="" && $this->input->post('id_kategori') !="null") ? $this->input->post('id_kategori') : $this->input->post('id_kategori_parent');
        $data['prioritas'] = $this->input->post('prioritas');
        $data['filename'] = $upload_data['file_name'];
        $data['filesize'] = $upload_data['file_size'];
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        $data['status'] = 1;
        $id_srikandi_ref = $this->input->post('id_srikandi_ref');
        if(isset($id_srikandi_ref)){
            $data['id_srikandi_ref'] = $id_srikandi_ref;
        }else{
            $data['id_srikandi_ref'] = '0';
        }

        if($this->db->insert('srikandi', $data)){
            $id = mysql_insert_id();

            if($data['id_srikandi_ref']=='0'){
                //jika data baru, jadikan id ref
                $this->db->where('id_srikandi',$id);
                $this->db->update('srikandi',array('id_srikandi_ref'=>$id));
            }else{
                //me non aktifkan data
                $this->db->where('id_srikandi_ref',$id_srikandi_ref);
                $this->db->update('srikandi',array('status'=>0));
            }

            //menjadikan data baru aktif
            $this->db->where('id_srikandi',$id);
            $this->db->update('srikandi',array('status'=>1));

            //me reset log
            $this->db->where('id_srikandi',$id_srikandi_ref);
            $this->db->delete('srikandi_log');

			return $id;
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
        $data['id_kategori'] = ($this->input->post('id_kategori') !="" && $this->input->post('id_kategori') !="null") ? $this->input->post('id_kategori') : $this->input->post('id_kategori_parent');
        $data['prioritas'] = $this->input->post('prioritas');
        $data['ip'] = $_SERVER['REMOTE_ADDR'];
        
        if($upload_data!=0){
			$data['filename'] = $upload_data['file_name'];
			$data['filesize'] = $upload_data['file_size'];
		}

        $this->db->where('id_srikandi',$id);
        $this->db->delete('srikandi_log');

		return $this->db->update('srikandi', $data, array('id_srikandi'=>$id));
    }
    
    function delete_upload($id){
        $this->db->where('id_srikandi',$id);
        return $this->db->delete('srikandi');
    }
    function cekdata($id,$user){
        $this->db->where('id_srikandi',$id);
        $this->db->where('app_users_list.username',$user);
        $this->db->join('app_users_list',"srikandi.uploader = app_users_list.id");
        $query = $this->db->get('srikandi');
        if ($query->num_rows() > 0) {
            return '1';
        }else{
            return '0';
        }
    }
    function cekdatakomen($id,$user){
        $this->db->where('id_comment',$id);
        $this->db->where('app_users_list.username',$user);
        $this->db->join('app_users_list',"srikandi_comment.uploader = app_users_list.id");
        $query = $this->db->get('srikandi_comment');
        if ($query->num_rows() > 0) {
            return '1';
        }else{
            return '0';
        }
    }

    function delete_ref($id){
        $this->db->where('id_srikandi_ref',$id);
        return $this->db->delete('srikandi');
    }

}
?>