<?php
class Spkp_personalia_kp4 extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->load->model('spkp_personalia_kp4_model');
        $this->load->model('admin_users_model');
        $this->load->model('location_model');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
	}
	
	function index(){
		$this->authentication->verify('spkp_personalia_kp4','show');
        
	    $data = array();
        $data['title'] = "KP4 Pegawai";
		$data['content'] = $this->parser->parse("spkp_personalia_kp4/show",$data,true);

		$this->template->show($data,"home");
	}
    
    function json_user(){
        die(json_encode($this->spkp_personalia_kp4_model->json_user()));
    }
    
	function json_sasaran($id){
		die(json_encode($this->spkp_personalia_kp4_model->json_sasaran($id)));
	}

	function detail($id){
        $this->authentication->verify('spkp_personalia_kp4','edit');
        
        $data = $this->spkp_personalia_kp4_model->get_user($id);
		$data['add_permission']=$this->authentication->verify_check('spkp_personalia_kp4','add');
        $data['title'] = "DP3 &raquo; Detail";
 		$data['uid']=$id;
		$nip = $data['nip'];
 		$data['nip']=substr($nip,0,8)." ".substr($nip,8,6)." ".substr($nip,14,1)." ".substr($nip,15,3);
       
        $data['content'] = $this->parser->parse("spkp_personalia_kp4/form",$data,true);
        
        $this->template->show($data,"home");
    }
    
    function add($uid){
		$this->authentication->verify('spkp_personalia_kp4','add');

		$data['action']="add";
		$data['uid']=$uid;

		echo $this->parser->parse("spkp_personalia_kp4/form_popup",$data,true);
	}

	function doadd($uid){
		$this->authentication->verify('spkp_personalia_kp4','add');
        
        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(!isset($_FILES['filename']['name']) || $_FILES['filename']['name']==""){
				echo "ERROR_File / Dokumen harus ada.";
			}else{
				if(count($_FILES)>0){
					$path = './public/files/'.$uid;
					if (!is_dir($path)) {
						mkdir($path);
					}
					$path .= "/personalia_kp4/";
					if (!is_dir($path)) {
						mkdir($path);
					}
					@unlink($path."/".$_FILES['filename']['name']);
					$config['upload_path'] = $path;
					$config['allowed_types'] = 'xls|xlsx|doc|docx|pdf|zip|rar|jpg|jpeg';
					$config['max_size']	= '999999';
					$config['overwrite'] = false;
					$this->load->library('upload', $config);
					$upload = $this->upload->do_upload('filename');
					if($upload === FALSE) {
						echo "ERROR_".$this->upload->display_errors();
					}else{
						$upload_data = $this->upload->data();
						$id=$this->spkp_personalia_kp4_model->doadd($uid,$upload_data);
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
	
	function edit($id=0){
		$this->authentication->verify('spkp_personalia_kp4','add');

		$data = $this->spkp_personalia_kp4_model->get_data_row($id); 
		$data['action']="edit";

		echo $this->parser->parse("spkp_personalia_kp4/form_popup",$data,true);
	}

	function doedit($uid,$id=0)
	{
		$this->authentication->verify('spkp_personalia_kp4','edit');

        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(count($_FILES)>0){
				$path = './public/files/personalia_kp4/'.$uid;
				if (!is_dir($path)) {
					mkdir($path);
				}
				@unlink($path."/".$_FILES['filename']['name']);
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'xls|xlsx|doc|docx|pdf|zip|rar|jpg|jpeg';
				$config['max_size']	= '999999';
				$config['overwrite'] = false;
				$this->load->library('upload', $config);
				$upload = $this->upload->do_upload('filename');
				if($upload === FALSE) {
					echo "ERROR_".$this->upload->display_errors();
				}else{
					$upload_data = $this->upload->data();
					if($this->spkp_personalia_kp4_model->doedit($id,$upload_data)){
						echo "OK_".$id;
					}else{
						echo "ERROR_Database Error";
					}
				}
			}else{
				if($this->spkp_personalia_kp4_model->doedit($id)){
					echo "OK_".$id;
				}else{
					echo "ERROR_Database Error";
				}
			}
		}
	}
	
	function download($id=0){
		$this->authentication->verify('spkp_personalia_kp4','edit');

		$data = $this->spkp_personalia_kp4_model->get_data_row($id); 

		echo $this->parser->parse("spkp_personalia_kp4/download",$data,true);
	}

	function dodownload($id=0){
		$this->authentication->verify('spkp_personalia_kp4','edit');

		$data = $this->spkp_personalia_kp4_model->get_data_row($id); 
		$path = './public/files/'.$data['uid']."/personalia_kp4/".$data['filename'];

		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Transfer-Encoding: binary");
		header("Content-disposition: attachment; filename=" . $data['filename']);
		header("Content-type: application/octet-stream");
		readfile($path);
	}

	function dodelete($id=0){
		$this->authentication->verify('spkp_personalia_kp4','del');
		$data = $this->spkp_personalia_kp4_model->get_data_row($id); 
		$path = './public/files/'.$data['uid']."/personalia_kp4/".$data['filename'];

		if($this->spkp_personalia_kp4_model->dodelete($id)){
			if(file_exists($path)){
				unlink($path);
			}

			echo "OK_".$id;
		}else{
			echo "ERROR_Database Error";
		}
	}

    function html($id){
		$this->authentication->verify('spkp_personalia_kp4','show');
		
		$data = $this->spkp_personalia_kp4_model->json_sasaran($id);

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_personalia_kp4/html",$data);
	}
    
    function excel($id){
		$this->authentication->verify('spkp_personalia_kp4','show');

		$data = $this->spkp_personalia_kp4_model->json_sasaran($id);

		$rows = $data[0]['Rows'];
		$data['title'] = "KP4 Pegawai";

		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/personalia_kp4.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_personalia_kp4.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		// echo $output_file_name;
		echo '../public/doc_xls_export/report_personalia_kp4.xlsx';
		
	}
}
