<?php
class Spkp_gallery_video extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->load->model('spkp_gallery_video_model');
	}
	
	function index(){
		$this->authentication->verify('spkp_gallery_video','show');
		$data['title'] = "Gallery Video";
		$data['display']="none";
		
		$get_file_id = $this->spkp_gallery_video_model->get_file_id('video');
		foreach($get_file_id as $get){
			$data['file_id'] = $get->id;
		}
		$data['param']="";
		$data['begin']=1;
		$data['add_permission']=$this->authentication->verify_check('spkp_gallery_video','add');
		$data['konten']=$this->spkp_gallery_video_model->show_video($data['file_id'],'',0,6);
		$data['content'] = $this->parser->parse("spkp_gallery_video/show",$data,true);
		
		$this->template->show($data,'home');
	}
	
	function search($begin){
		$this->authentication->verify('spkp_gallery_video','show');
		$data['title'] = "Gallery Video";
		$data['display']="block";
		$param=$this->input->post('param');
		$dt = $this->spkp_gallery_video_model->get_file_id('video');
		foreach($dt as $get){
			$data['file_id'] = $get->id;
		}
		$count=$this->spkp_gallery_video_model->count_content($data['file_id'],"and title_content like '%$param%'");
		foreach($count as $get){
			$data['count']=$get->jumlah;
		}
		$data['param']=$param;
		$data['begin']=$begin;
		$data['konten']=$this->spkp_gallery_video_model->show_video($data['file_id'],"and title_content like '%$param%'",(($begin-1)*6));
		$data['content'] = $this->parser->parse("spkp_gallery_video/show",$data,true);
		
		$this->template->show($data,'home');
	}
	
	function page_search($param,$begin){
		$this->authentication->verify('spkp_gallery_video','show');
		$data['title'] = "Gallery Video";
		$data['display']="block";
		$dt = $this->spkp_gallery_video_model->get_file_id('video');
		foreach($dt as $get){
			$data['file_id'] = $get->id;
		}
		$count=$this->spkp_gallery_video_model->count_content($data['file_id'],"and title_content like '%$param%'");
		foreach($count as $get){
			$data['count']=$get->jumlah;
		}
		$data['param']=$param;
		$data['begin']=$begin;
		$data['konten']=$this->spkp_gallery_video_model->show_video($data['file_id'],"and title_content like '%$param%'",(($begin-1)*6));
		$data['content'] = $this->parser->parse("spkp_gallery_video/show",$data,true);
		
		$this->template->show($data,'home');
	}
	
	function play($id){
		$this->authentication->verify('spkp_gallery_video','show');
		$dt = $this->spkp_gallery_video_model->get_file_id('video');
		$id = $id;
		$data['title'] = "Gallery Video &raquo; ";
		foreach($dt as $get){
			$data['file_id'] = $get->id;
			$data['detail'] = $this->spkp_gallery_video_model->get_detail_content($data['file_id'],$id);
			foreach($data['detail'] as $get){
				$data['links'] = $get['links'];
				$data['title'].=$get['title_content'];
				$data['hits']=$get['hits']+1;
			}
		}
		$this->spkp_gallery_video_model->hits($data['file_id'],$id,$data['hits']);
		$data['konten']=$this->spkp_gallery_video_model->show_video($data['file_id'],'',0,6);
		$data['content'] = $this->parser->parse('spkp_gallery_video/detail',$data,true);
		
		$this->template->show($data,"home");
	}
	
	function json_content($file_id){
        die(json_encode($this->spkp_gallery_video_model->json_content($file_id)));
    }
	
	function show_list(){
		$mod='video';
		$this->authentication->verify($mod,'show');
		
		$dt = $this->spkp_gallery_video_model->get_file_id($mod);
		foreach($dt as $get){
			$data['file_id'] = $get->id;
			$data['title'] = $get->filename;
			$val = $this->spkp_gallery_video_model->get_id($data['file_id']);
			foreach($val as $get){
				$data['get_id'] = $get->maks;
			}
		}
		$data['id'] = $data['get_id']+1;
		$data['published'] = '';
		$data['waktu']='';
		$data['add_permission']=$this->authentication->verify_check($mod,'add');
		$data['mod'] = $mod;
		$data['lang'] = $this->spkp_gallery_video_model->get_lang();
		$data['action']="add";
		$data['links'] = "No File Uploaded";
		$data['form'] = $this->parser->parse("spkp_gallery_video/form",$data,true);
		$data['content'] = $this->parser->parse("spkp_gallery_video/show_list",$data,true);
		
		$this->template->show($data,'home');
	}
	
	function doadd($mod,$file_id,$id){
		$id=$this->input->post('id');
		$find_id=$this->spkp_gallery_video_model->find_id($file_id, $id);
		$get_id='';
		foreach ($find_id as $id_found){
			$get_id=$id_found->id;
		}
		$this->authentication->verify($mod,'add');
		$this->form_validation->set_rules('title_content_ina','Judul','trim|required');
		$this->form_validation->set_rules('content_ina','Isi','trim|required');
		
		if($this->form_validation->run()==false){
			echo validation_errors();
		}
		
		else{
			if(count($_FILES)>0){
				$path = './media/video';
				if(!is_dir($path)){
					mkdir($path);
				}
				$config['upload_path'] = $path;
				$config['allowed_types'] = '*';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				
				if(file_exists($path.'/'.$this->input->post('getlink'))){
					unlink($path.'/'.$this->input->post('getlink'));
					$upload = $this->upload->do_upload('links');
				}
				else{
					$upload = $this->upload->do_upload('links');
				}
				if($upload === FALSE) {
					echo $this->upload->display_errors()."<br>";
				}else{
					$upload_data = $this->upload->data();
					if($get_id!=$id){
						$this->spkp_gallery_video_model->insert_content_en(2,$upload_data);
						$this->spkp_gallery_video_model->insert_content_ina(2,$upload_data);
						
						echo "1";
					}else{
						$this->spkp_gallery_video_model->update_content_en(2,$upload_data);
						$this->spkp_gallery_video_model->update_content_ina(2,$upload_data);
						
						echo "1";
					}
				}
			}else{
				if($get_id!=$id){
					$this->spkp_gallery_video_model->insert_content_en(1,"");
					$this->spkp_gallery_video_model->insert_content_ina(1,"");
					
					echo "1";
				}else{
					$this->spkp_gallery_video_model->update_content_en(1,"");
					$this->spkp_gallery_video_model->update_content_ina(1,"");
					
					echo "1";
				}
			}
		}
	}
	
	function load_form($mod,$file_id,$id){
       $this->authentication->verify($mod,'edit');

	   $data = $this->spkp_gallery_video_model->get_data_content($file_id,$id);
		$data['add_permission']=$this->authentication->verify_check($mod,'edit');
		
		$dt = $this->spkp_gallery_video_model->get_file_id($mod);
		foreach($dt as $get){
			$data['title'] = $get->filename;
		}
		$data['title'] .=" &raquo; Edit";
		$data['lang'] = $this->spkp_gallery_video_model->get_lang();
		
		$data['file_id'] = $file_id;
		$data['id'] = $id;
		$data['mod'] = $mod;
		$data['action'] = 'edit';
		
		echo $this->parser->parse("spkp_gallery_video/form",$data,true);        
    }
	
	function edit($mod,$file_id,$id){
		$this->authentication->verify($mod,'edit');
		
		$data=$this->spkp_gallery_video_model->get_data_content($file_id,$id);
		$data['add_permission']=$this->authentication->verify_check($mod,'edit');
		
		$dt = $this->spkp_gallery_video_model->get_file_id($mod);
		foreach($dt as $get){
			$data['title'] = $get->filename;
		}
		$data['title'] .=" &raquo; Edit";
		$data['lang'] = $this->spkp_gallery_video_model->get_lang();
		
		$data['file_id'] = $file_id;
		$data['id'] = $id;
		$data['mod'] = $mod;
		$data['action']="edit";
		$data['content'] = $this->parser->parse("spkp_gallery_video/form",$data,true);
		
		$this->template->show($data,'home');
	}
	
	function doedit($mod,$file_id,$id){
		$this->authentication->verify($mod,'edit');
		$this->form_validation->set_rules('title_content_ina','Judul','trim|required');
		$this->form_validation->set_rules('content_ina','Isi','trim|required');
		
		if($this->form_validation->run()==false){
			echo validation_errors();
		}
		
		else{
			if(count($_FILES)>0){
				$path = './media/video';
				if(!is_dir($path)){
					mkdir($path);
				}
				$config['upload_path'] = $path;
				$config['allowed_types'] = '*';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if(file_exists($path.'/'.$this->input->post('getlink'))){
					unlink($path.'/'.$this->input->post('getlink'));
					$upload = $this->upload->do_upload('links');
				}
				else{
					$upload = $this->upload->do_upload('links');
				}
				if($upload === FALSE) {
					echo $this->upload->display_errors()."<br>";
				}else{
					$upload_data = $this->upload->data();
					$this->spkp_gallery_video_model->update_content_en(2,$upload_data);
					$this->spkp_gallery_video_model->update_content_ina(2,$upload_data);
					echo "1";
				}
			}
			else{
				$this->spkp_gallery_video_model->update_content_en(1,"");
				$this->spkp_gallery_video_model->update_content_ina(1,"");
				echo "1";
			}
		}
	}
	
	function dodel($mod,$file_id,$id){
		$this->authentication->verify($mod,'del');
		$get_detail_content=$this->spkp_gallery_video_model->get_detail_content($file_id,$id);
		foreach($get_detail_content as $get){
			$links=$get['links'];
			if($this->spkp_gallery_video_model->delete_content($file_id,$id)){
				unlink('./media/video/'.$links);
				echo "1";
			}else{
				echo "Delete Error";
			}
		}
		
	}
	
}
?>