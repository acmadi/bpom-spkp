<?php 

Class Spkp_gallery_video_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
		$this->load->library('encrypt');
		$this->lang	= $this->config->item('language');
	}
	
	function get_file_id($mod){
		$query=$this->db->query("SELECT id, filename FROM app_files WHERE module='$mod' && lang='ina'");
		
		return $query->result();
	}
	
	function get_id($file_id){
		$query=$this->db->query("SELECT MAX(id) AS maks FROM app_files_contents WHERE file_id=$file_id ORDER BY id DESC");
		
		return $query->result();
	}
	
	function find_id($file_id, $id){
		$query=$this->db->query("SELECT id FROM app_files_contents WHERE file_id=$file_id AND id=$id");
		
		return $query->result();
	}
	
	function json_content($file_id){
		$query="SELECT @i:=@i+1 AS urut, file_id, id, IF(lang='ina',1,2)AS lang, title_content, dtime AS waktu_kegiatan,
		IF(published=1,'yes','no') AS publish, author, FROM_UNIXTIME(dtime,'%Y/%m/%d %T') AS waktu, headline, 
		content, links, hits, IF(dtime_end='','',FROM_UNIXTIME(dtime_end,'%Y/%m/%d %T')) AS waktu_update
		FROM app_files_contents WHERE file_id=$file_id and lang='ina' ORDER BY id ASC";
		
		return $this->crud->jqxGrid($query);
	}
	
	function show_video($file_id,$param,$begin){
		$query=$this->db->query("SELECT @i:=@i+1 AS urut, id, lang, title_content, author, 
		FROM_UNIXTIME(dtime,'%Y/%m/%d %T') AS waktu, headline, published, links, hits, 
		FROM_UNIXTIME(dtime_end,'%Y/%m/%d %T') AS waktu_update, content 
		FROM app_files_contents WHERE file_id=$file_id and lang='ina' and published=1 $param ORDER BY id DESC LIMIT $begin, 6");
		
		return $query->result_array();
	}
	
	function get_content($file_id){
		$this->db->where(array('file_id'=>$file_id, 'lang'=>'ina', 'published'=>1));
		$this->db->order_by('dtime','DESC');
		$query = $this->db->get('app_files_contents',5,0);
		
		return $query->result_array();
	}
	
	function count_content($file_id,$param){
		$query=$this->db->query("SELECT COUNT(id) AS jumlah FROM app_files_contents 
		WHERE file_id=$file_id and lang='ina' and published=1 $param");
		
		return $query->result();
	}
	
	function get_detail_content($file_id,$id){
		$this->db->where(array('file_id'=>$file_id, 'id'=>$id, 'lang'=>'ina'));
		$query = $this->db->get('app_files_contents');
		
		return $query->result_array();
	}
	
	function get_lang(){
		$this->db->order_by('kode', 'DESC');
        $query = $this->db->get('app_lang');
		
        return $query->result_array();
    }
	
	function insert_content_en($type,$file){
		$data['title_content']=$this->input->post('title_content_en');
		
		if($data['title_content']!=""){
			$data['id']=$this->input->post('id');
			$data['file_id']=$this->input->post('file_id');
			$data['lang']="en";
			$data['published']=$this->input->post('published');
			$data['author']=$this->session->userdata('username');
			$data['headline']=$this->input->post('headline_en');
			$data['content']=$this->input->post('content_en');
			$data['hits']=0;
			$data['dtime']=time();
			$data['dtime_end']=time();
			
			if($type==2 && $data['title_content']!=""){
				$data['links']=$file['file_name'];
				return $this->db->insert('app_files_contents',$data);
			}
			else{
				return $this->db->insert('app_files_contents',$data);
			}
		}
	}
	
	function insert_content_ina($type,$file){
		$val['file_id']=$this->input->post('file_id');
		$val['id']=$this->input->post('id');
		$val['lang']="ina";
		$val['title_content']=$this->input->post('title_content_ina');
		$val['published']=$this->input->post('published');
		$val['author']=$this->session->userdata('username');
		$val['headline']=$this->input->post('headline_ina');
		$val['content']=$this->input->post('content_ina');
		$val['hits']=0;
		$val['dtime']=time();
		$val['dtime_end']=time();
	
		if($type==2){
			$val['links']=$file['file_name'];
			return $this->db->insert('app_files_contents',$val);
		}
		else{
			return $this->db->insert('app_files_contents',$val);
		}
	}
	
	function get_data_content($file_id,$id){
		$query=$this->db->query("SELECT @i:=@i+1 AS urut, file_id, id, lang, 
		title_content, published, author, headline, content, links, hits, 
		FROM_UNIXTIME(dtime,'%T, %d %M %Y') AS waktu, FROM_UNIXTIME(dtime_end,'%T, %d %M %Y') AS waktu_update
		FROM app_files_contents WHERE file_id=$file_id && id=$id");
		
		if ($query->num_rows() > 0){
			foreach($query->result_array() as $key=>$dt){
				$data['file_id']=$dt['file_id'];
				$data['id']=$dt['id'];
				$data['lang']=$dt['lang'];
				$data['published']=$dt['published'];
				$data['author']=$dt['author'];
				$data['links']=$dt['links'];
				$data['hits']=$dt['hits'];
				$data['published']=$dt['published'];
				$data['title_content_'.$dt['lang']]=$dt['title_content'];
				$data['headline_'.$dt['lang']]=$dt['headline'];
				$data['tempat']=$dt['headline'];
				$data['waktu']=$dt['waktu'];
				$data['waktu_update']=$dt['waktu_update'];
				$data['content_'.$dt['lang']]=$dt['content'];
			}
		}

		$query->free_result();
		return $data;
	}
	
	function update_content_en($type,$file){
		$data['lang']="en";
		$data['title_content']=$this->input->post('title_content_en');
		$data['published']=$this->input->post('published');
		$data['headline']=$this->input->post('headline_en');
		$data['content']=$this->input->post('content_en');
		$data['dtime_end']=time();
		
		if($type==2){
			$data['links']=$file['file_name'];
			return $this->db->update('app_files_contents',$data,array('file_id'=>$this->input->post('file_id'),'id'=>$this->input->post('id'),'lang'=>'en'));
		}
		else{			
			return $this->db->update('app_files_contents',$data,array('file_id'=>$this->input->post('file_id'),'id'=>$this->input->post('id'),'lang'=>'en'));
		}
	}
	
	function update_content_ina($type,$file){
		$val['lang']="ina";
		$val['title_content']=$this->input->post('title_content_ina');
		$val['published']=$this->input->post('published');
		$val['headline']=$this->input->post('headline_ina');
		$val['content']=$this->input->post('content_ina');
		$val['dtime_end']=time();
		
		if($type==2){
			$val['links']=$file['file_name'];
			return $this->db->update('app_files_contents',$val,array('file_id'=>$this->input->post('file_id'),'id'=>$this->input->post('id'),'lang'=>'ina'));
		}
		else{
			return $this->db->update('app_files_contents',$val,array('file_id'=>$this->input->post('file_id'),'id'=>$this->input->post('id'),'lang'=>'ina'));
		}
	}
	
	function delete_content($file_id, $id){
		$this->db->where(array('file_id'=>$file_id, 'id'=>$id));
		return $this->db->delete('app_files_contents');
	}
	
	function hits($file_id, $id, $hits){
		return $this->db->update('app_files_contents',array('hits'=>$hits),array('file_id'=>$file_id,'id'=>$id));
	}
	
}

?>