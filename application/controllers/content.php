<?php
class Content extends CI_Controller {

    function __construct(){
		parent::__construct();
		$this->load->model('content_model');
		$this->load->helper('html');
	}
	
	function index($mod){
		$this->authentication->verify($mod,'show');
		
		$dt = $this->content_model->get_file_id($mod);
		foreach($dt as $get){
			$data['file_id'] = $get->id;
			$data['title'] = $get->filename;
			$val = $this->content_model->get_id($data['file_id']);
			foreach($val as $get){
				$data['get_id'] = $get->maks;
			}
		}
		$data['id'] = $data['get_id']+1;
		$data['published'] = '';
		$data['add_permission']=$this->authentication->verify_check($mod,'add');
		$data['mod'] = $mod;
		$data['lang'] = $this->content_model->get_lang();
		$data['action']="add";
		$data['links'] = "none";
		$data['form'] = $this->parser->parse("content/form",$data,true);
		$data['content'] = $this->parser->parse("content/show",$data,true);
		
		$this->template->show($data,'home');
	}
	
	function json_content($file_id){
        die(json_encode($this->content_model->json_content($file_id)));
    }
	
	function doadd($mod,$file_id,$id){
		$id=$this->input->post('id');
		$find_id=$this->content_model->find_id($file_id, $id);
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
				$path = './media/images/'.$mod.'/'.$id;
				if(!is_dir($path)){
					mkdir($path);
				}
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'jpeg|jpg|png|bmp';
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
						$this->content_model->insert_content_en(2,$upload_data);
						$this->content_model->insert_content_ina(2,$upload_data);
						
						echo "1";
					}else{
						$this->content_model->update_content_en(2,$upload_data);
						$this->content_model->update_content_ina(2,$upload_data);
						
						echo "1";
					}
				}
			}else{
				if($get_id!=$id){
					$this->content_model->insert_content_en(1,"");
					$this->content_model->insert_content_ina(1,"");
					
					echo "1";
				}else{
					$this->content_model->update_content_en(1,"");
					$this->content_model->update_content_ina(1,"");
					
					echo "1";
				}
			}
		}
	}
	
	function load_form($mod,$file_id,$id){
       $this->authentication->verify($mod,'edit');

	   $data = $this->content_model->get_data_content($file_id,$id);
		$data['add_permission']=$this->authentication->verify_check($mod,'edit');
		
		$dt = $this->content_model->get_file_id($mod);
		foreach($dt as $get){
			$data['title'] = $get->filename;
		}
		$data['title'] .=" &raquo; Edit";
		$data['lang'] = $this->content_model->get_lang();
		
		$data['file_id'] = $file_id;
		$data['id'] = $id;
		$data['mod'] = $mod;
		$data['action'] = 'edit';
		
		echo $this->parser->parse("content/form",$data,true);        
    }
	
	function edit($mod,$file_id,$id){
		$this->authentication->verify($mod,'edit');
		
		$data=$this->content_model->get_data_content($file_id,$id);
		$data['add_permission']=$this->authentication->verify_check($mod,'edit');
		
		$dt = $this->content_model->get_file_id($mod);
		foreach($dt as $get){
			$data['title'] = $get->filename;
		}
		$data['title'] .=" &raquo; Edit";
		$data['lang'] = $this->content_model->get_lang();
		
		$data['file_id'] = $file_id;
		$data['id'] = $id;
		$data['mod'] = $mod;
		$data['action']="edit";
		$data['content'] = $this->parser->parse("content/form",$data,true);
		
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
				$path = './media/images/'.$mod.'/'.$id;
				if(!is_dir($path)){
					mkdir($path);
				}
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'jpeg|jpg|png|bmp';
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
					$this->content_model->update_content_en(2,$upload_data);
					$this->content_model->update_content_ina(2,$upload_data);
					echo "1";
				}
			}
			else{
				$this->content_model->update_content_en(1,"");
				$this->content_model->update_content_ina(1,"");
				echo "1";
			}
		}
	}
	
	function dodel($mod,$file_id,$id){
		$this->authentication->verify($mod,'del');
		$get_detail_content=$this->content_model->get_detail_content($file_id,$id);
		foreach($get_detail_content as $get){
			$links=$get['links'];
		}
		if($this->content_model->delete_content($file_id,$id)){
			unlink('./media/images/'.$mod.'/'.$id.'/'.$links);
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
	
}
