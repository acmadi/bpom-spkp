<?php
class Spkp_gallery extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');	
		$this->load->model('spkp_gallery_model');
	}
	
	function index(){
		$this->authentication->verify('spkp_gallery','show');
		
		if($this->input->post('publishing')==''){
			$data['publishing']=1;
		}else{
			$data['publishing']=$this->input->post('publishing');
		}
		
		$data['get_data'] = $this->spkp_gallery_model->get_data($data['publishing']);
		$data['add_permission']=$this->authentication->verify_check('spkp_gallery','add');
		$data['add_permission2']=$this->authentication->verify_check('spkp_gallery','edit');
		$data['title'] = "Galeri";
		$data['status'] = 1;
		$data['content'] = $this->parser->parse('spkp_gallery/show',$data,true);
		
		$this->template->show($data,"home");
	}
	
	function show($id){
		$this->authentication->verify('spkp_gallery','show');
		
		$data = $this->spkp_gallery_model->get_info($id);
		
		if($this->input->post('publishing')==''){
			$data['publishing']=1;
		}else{
			$data['publishing']=$this->input->post('publishing');
		}
		
		$data['add_permission']=$this->authentication->verify_check('spkp_gallery','add');
		$data['add_permission2']=$this->authentication->verify_check('spkp_gallery','edit');
		$data['title'] = "Gallery";
		$data['id'] = $id;
		$data['get_data_list'] = $this->spkp_gallery_model->get_data_list($id,$data['publishing']);
		$data['content'] = $this->parser->parse('spkp_gallery/detail',$data,true);
		$this->template->show($data,"home");
	}
	
	function add(){
		$this->authentication->verify('spkp_gallery','add');

		$data['action']="add";
		$data['id']=time();

		echo $this->parser->parse("spkp_gallery/form",$data,true);
	}
	
	function doadd($id){
		$this->authentication->verify('spkp_gallery','add');
        
		$this->form_validation->set_rules('judul', 'Judul', 'trim|required');			

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_gallery_model->insert_entry($id);
		}
	}
	
	function edit($id=0){
		$this->authentication->verify('spkp_gallery','add');

		$data = $this->spkp_gallery_model->get_info($id); 
		$data['action']="edit";	
		$data['id']=$id;	

		echo $this->parser->parse("spkp_gallery/form",$data,true);
	}

	function doedit($id)
	{
		$this->authentication->verify('spkp_gallery','edit');
		
		$this->form_validation->set_rules('judul', 'Judul', 'trim|required');	

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_gallery_model->update_entry($id);
			echo "1_".$id;
		}
	}

	function dodel($id){
		$this->authentication->verify('spkp_gallery','del');

		if($this->spkp_gallery_model->delete_entry($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
	
	function upload($id){
		$this->authentication->verify('spkp_gallery','add');
		
		$data['action']="upload";
		$data['id'] = $id;

		echo $this->parser->parse("spkp_gallery/form_upload",$data,true);
	}
	
	function doupload($id){
		$this->authentication->verify('spkp_gallery','add');
        
        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(!isset($_FILES['filename']['name']) || $_FILES['filename']['name']==""){
				echo "ERROR_File / Dokumen harus ada.";
			}else{
				if(count($_FILES)>0){
					$path='./public/files/spkp_gallery/';
					if (!is_dir($path)){
						mkdir($path);
					}
					
					$path .=$id;
					if (!is_dir($path)) {
						mkdir($path);
					}
					
					@unlink($path."/".$_FILES['filename']['name']);
					$config['upload_path'] = $path;
					$config['allowed_types'] = 'xls|xlsx|doc|docx|pdf|zip|rar|jpg|jpeg|png';
					$config['max_size']	= '999999';
					$config['overwrite'] = false;
					$this->load->library('upload', $config);
					$upload = $this->upload->do_upload('filename');
					if($upload === FALSE) {
						echo "ERROR_".$this->upload->display_errors();
					}else{
						$upload_data = $this->upload->data();
						$id=$this->spkp_gallery_model->doupload($upload_data,$id);
						if($id!=false){
							echo "OK_".$id;
						}else{
							echo "ERROR_Database Error";
						}
					}
				}else{
					echo "ERROR_Upload failed";
				}
			}
		}
	}
	
	function dodelimg($id=0){
		$this->authentication->verify('spkp_gallery','del');

		if($this->spkp_gallery_model->delete_entry_img($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
}
?>