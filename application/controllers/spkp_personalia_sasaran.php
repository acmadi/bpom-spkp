<?php
class Spkp_personalia_sasaran extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->load->model('spkp_personalia_sasaran_model');
        $this->load->model('admin_users_model');
        $this->load->model('location_model');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
	}
	
	function index(){
		$this->authentication->verify('spkp_personalia_sasaran','show');
        
	    $data = array();
        $data['title'] = "Sasaran Kinerja Pegawai";
		$data['content'] = $this->parser->parse("spkp_personalia_sasaran/show",$data,true);

		$this->template->show($data,"home");
	}
    
    function json_user(){
        die(json_encode($this->spkp_personalia_sasaran_model->json_user()));
    }
    
	function json_sasaran($id){
		die(json_encode($this->spkp_personalia_sasaran_model->json_sasaran($id)));
	}

	function detail($id){
        $this->authentication->verify('spkp_personalia_sasaran','edit');
        
        $data = $this->spkp_personalia_sasaran_model->get_user($id);
		$data['add_permission']=$this->authentication->verify_check('spkp_personalia_sasaran','add');
        $data['title'] = "Sasaran Kinerja Pegawai &raquo; Detail";
 		$data['uid']=$id;
		$nip = $data['nip'];
 		$data['nip']=substr($nip,0,8)." ".substr($nip,8,6)." ".substr($nip,14,1)." ".substr($nip,15,3);
       
        $data['content'] = $this->parser->parse("spkp_personalia_sasaran/form",$data,true);
        
        $this->template->show($data,"home");
    }
    
    function doedit_profile($id){
        $this->authentication->verify('spkp','edit');
        
        $this->form_validation->set_rules('nip','NIP','trim|required');
        $this->form_validation->set_rules('nama','Nama','trim|required');
        $this->form_validation->set_rules('gendre','Gendre','trim|required');
        $this->form_validation->set_rules('birthdate','Tanggal Lahir','trim|required');
        $this->form_validation->set_rules('birthplace','Tempat lahir','trim|required');
        $this->form_validation->set_rules('phone_number','Phone Number','trim');
        $this->form_validation->set_rules('mobile','Mobile','trim');
        $this->form_validation->set_rules('email','Email','trim|valid_email');
        
        $this->form_validation->set_rules('address','Alamat','trim|required');
        $this->form_validation->set_rules('propinsi','Propinsi','trim|required');
        $this->form_validation->set_rules('kota','Kota','trim|required');
        
        $this->form_validation->set_rules('badan_tinggi','Tinggi Badan','trim|required');
        $this->form_validation->set_rules('badan_berat','Berat Badan','trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			if(count($_FILES)>0){
				$path = './media/images/user';
				if (!is_dir($path)) {
					mkdir($path);
				}
                
				$config['upload_path'] = $path;
				$config['allowed_types'] = '*';
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$upload = $this->upload->do_upload('filename');
				if($upload === FALSE) {
					echo $this->upload->display_errors()."<br>";
				}else{
					$upload_data = $this->upload->data();
					$this->spkp_personalia_sasaran_model->update_profile($id,1,$upload_data);
                    
					echo "1";
				}
			}else{
				$this->spkp_personalia_sasaran_model->update_profile($id,2,"");
			    echo "1";
            }
		}
    }
    
    function load_form_profile($id){
       $this->authentication->verify('spkp_personalia_sasaran','edit');

	   $data = $this->spkp_personalia_sasaran_model->get_user($id);
	 
       echo $this->parser->parse("spkp_personalia_sasaran/form",$data,true);        
    }
    
    function add($uid){
		$this->authentication->verify('spkp_personalia_sasaran','add');

		$data['action']="add";
		$data['uid']=$uid;

		echo $this->parser->parse("spkp_personalia_sasaran/form_popup",$data,true);
	}

	function doadd($uid){
		$this->authentication->verify('spkp_personalia_sasaran','add');
        
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
					$path .= "/personalia_sasaran/";
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
						$id=$this->spkp_personalia_sasaran_model->doadd($uid,$upload_data);
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
		$this->authentication->verify('spkp_personalia_sasaran','add');

		$data = $this->spkp_personalia_sasaran_model->get_data_row($id); 
		$data['action']="edit";

		echo $this->parser->parse("spkp_personalia_sasaran/form_popup",$data,true);
	}

	function doedit($uid,$id=0)
	{
		$this->authentication->verify('spkp_personalia_sasaran','edit');

        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(count($_FILES)>0){
				$path = './public/files/personalia_sasaran/'.$uid;
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
					if($this->spkp_personalia_sasaran_model->doedit($id,$upload_data)){
						echo "OK_".$id;
					}else{
						echo "ERROR_Database Error";
					}
				}
			}else{
				if($this->spkp_personalia_sasaran_model->doedit($id)){
					echo "OK_".$id;
				}else{
					echo "ERROR_Database Error";
				}
			}
		}
	}
	
	function download($id=0){
		$this->authentication->verify('spkp_personalia_sasaran','edit');

		$data = $this->spkp_personalia_sasaran_model->get_data_row($id); 

		echo $this->parser->parse("spkp_personalia_sasaran/download",$data,true);
	}

	function dodownload($id=0){
		$this->authentication->verify('spkp_personalia_sasaran','edit');

		$data = $this->spkp_personalia_sasaran_model->get_data_row($id); 
		$path = './public/files/'.$data['uid']."/personalia_sasaran/".$data['filename'];

		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Transfer-Encoding: binary");
		header("Content-disposition: attachment; filename=" . $data['filename']);
		header("Content-type: application/octet-stream");
		readfile($path);
	}

	function dodelete($id=0){
		$this->authentication->verify('spkp_personalia_sasaran','del');
		$data = $this->spkp_personalia_sasaran_model->get_data_row($id); 
		$path = './public/files/'.$data['uid']."/personalia_sasaran/".$data['filename'];

		if($this->spkp_personalia_sasaran_model->dodelete($id)){
			if(file_exists($path)){
				unlink($path);
			}

			echo "OK_".$id;
		}else{
			echo "ERROR_Database Error";
		}
	}

    function html($id){
		$this->authentication->verify('spkp_personalia_sasaran','show');
		
		$data = $this->spkp_personalia_sasaran_model->json_sasaran($id);

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_personalia_sasaran/html",$data);
	}
    
    function excel($id){
		$this->authentication->verify('spkp_personalia_sasaran','show');

		$data = $this->spkp_personalia_sasaran_model->json_sasaran($id);

		$rows = $data[0]['Rows'];
		$data['title'] = "Kinerja Pegawai Sasaran";

		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/personalia_sasaran.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_personalia_sasaran.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		// echo $output_file_name;
		echo '../public/doc_xls_export/report_personalia_sasaran.xlsx';

	}

}
