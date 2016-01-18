<?php
class Spkp_aksi_dokumentasi extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');	
		$this->load->model('spkp_aksi_dokumentasi_model');
	}
	
	function index(){
		$this->authentication->verify('spkp_aksi_dokumentasi','show');
		$this->load->model('spkp_aksi_dokumentasi_model');
		
		if($this->input->post('publishing')==''){
			$data['publishing']=1;
		}else{
			$data['publishing']=$this->input->post('publishing');
		}
		
		$data['get_data'] = $this->spkp_aksi_dokumentasi_model->get_data($data['publishing']);
		$data['add_permission']=$this->authentication->verify_check('spkp_aksi_dokumentasi','add');
		$data['add_permission2']=$this->authentication->verify_check('spkp_aksi_dokumentasi','edit');
		$data['title'] = "Dokumentasi";
		$data['status'] = 1;
		$data['content'] = $this->parser->parse('spkp_aksi_dokumentasi/show',$data,true);
		$this->template->show($data,"home");
	}
	
	function show($id){
		$this->authentication->verify('spkp_aksi_dokumentasi','show');
		$data = $this->spkp_aksi_dokumentasi_model->get_info($id);
		
		if($this->input->post('publishing')==''){
			$data['publishing']=1;
		}else{
			$data['publishing']=$this->input->post('publishing');
		}
		
		$data['get_data_list'] = $this->spkp_aksi_dokumentasi_model->get_data_list($id,$data['publishing']);
		$data['add_permission']=$this->authentication->verify_check('spkp_aksi_dokumentasi','add');
		$data['add_permission2']=$this->authentication->verify_check('spkp_aksi_dokumentasi','edit');
		$data['judul'] = "Dokumentasi";
		$data['id'] = $id;
		$data['content'] = $this->parser->parse('spkp_aksi_dokumentasi/detail',$data,true);
		$this->template->show($data,"home");
	}
	
	function add(){
		$this->authentication->verify('spkp_aksi_dokumentasi','add');

		$data['action']="add";
		$data['id']=time();

		echo $this->parser->parse("spkp_aksi_dokumentasi/form",$data,true);
	}
	
	function doadd($id){
		$this->authentication->verify('spkp_aksi_dokumentasi','add');
        
		$this->form_validation->set_rules('judul', 'Judul', 'trim|required');			

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_aksi_dokumentasi_model->insert_entry($id);
		}
	
	}
	
	function edit($id=0){
		$this->authentication->verify('spkp_aksi_dokumentasi','add');

		$data = $this->spkp_aksi_dokumentasi_model->get_info($id); 
		$data['action']="edit";	

		echo $this->parser->parse("spkp_aksi_dokumentasi/form",$data,true);
	}

	function doedit($id=0)
	{
		$this->authentication->verify('spkp_aksi_dokumentasi','edit');
		
		$this->form_validation->set_rules('judul', 'Judul', 'trim|required');	

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_aksi_dokumentasi_model->update_entry($id);
			echo "1";
		}
	}

	function dodel($id=0){
		$this->authentication->verify('spkp_aksi_dokumentasi','del');

		if($this->spkp_aksi_dokumentasi_model->delete_entry($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
	
	function upload($id=0){
		$this->authentication->verify('spkp_aksi_dokumentasi','add');
		
		$data['action']="upload";
		$data['id'] = $id;

		echo $this->parser->parse("spkp_aksi_dokumentasi/form_upload",$data,true);
	}
	
	function doupload($id=0){
		$this->authentication->verify('spkp_aksi_dokumentasi','add');
        
        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(!isset($_FILES['filename']['name']) || $_FILES['filename']['name']==""){
				echo "ERROR_File / Dokumen harus ada.";
			}else{
				if(count($_FILES)>0){
					$path='./public/files/spkp_aksi_dokumentasi/';
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
						$id=$this->spkp_aksi_dokumentasi_model->doupload($upload_data,$id);
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
		$this->authentication->verify('spkp_aksi_dokumentasi','del');

		if($this->spkp_aksi_dokumentasi_model->delete_entry_img($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
}
?>