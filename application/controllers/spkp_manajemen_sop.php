<?php
class Spkp_manajemen_sop extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('spkp_manajemen_sop_model');
        $this->load->helper('html');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
    }
    
    function index(){
        $this->authentication->verify('spkp_manajemen_sop','show');
        
        $data = array();
        $data['title'] = "SOP";
        
        $data['add_permission']=$this->authentication->verify_check('spkp_manajemen_sop','add');
        $data['form_kegiatan'] = $this->parser->parse("spkp_manajemen_sop/form_kegiatan",$data,true);
        $data['form_upload'] = $this->parser->parse("spkp_manajemen_sop/form_upload",$data,true);
        $data['content'] = $this->parser->parse("spkp_manajemen_sop/show",$data,true);

		$this->template->show($data,"home");
    }
    
    function json_upload(){
        die(json_encode($this->spkp_manajemen_sop_model->json_upload()));
    }
    
    function add_upload(){
        $this->authentication->verify('spkp_manajemen_sop','add');
		$data['action']="add";
        
		echo $this->parser->parse("spkp_manajemen_sop/form_add_upload",$data,true);
    }
    
    function doadd_upload(){
        $this->authentication->verify('spkp_manajemen_sop','add');
        
        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(!isset($_FILES['filename']['name']) || $_FILES['filename']['name']==""){
				echo "ERROR_File / Dokumen harus ada.";
			}else{
				if(count($_FILES)>0){
				    $path = './public/files/spkp_manajemen_sop';
                    if(!is_dir($path)){
                        mkdir($path);
                    }
                    
					$path = './public/files/spkp_manajemen_sop/'.$this->session->userdata('id');
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
						$id=$this->spkp_manajemen_sop_model->insert_upload($upload_data);
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
    
    function edit_upload($id){
        $this->authentication->verify('spkp_manajemen_sop','add');

		$data = $this->spkp_manajemen_sop_model->get_data_row_file($id);
		$data['action']="edit";
        
		echo $this->parser->parse("spkp_manajemen_sop/form_add_upload",$data,true);
    }
    
    function doedit_upload($id){
        $this->authentication->verify('spkp_manajemen_sop','edit');
        
        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');
        
        if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(count($_FILES)>0){
			    $path = './public/files/spkp_manajemen_sop';
                if(!is_dir($path)){
                    mkdir($path);
                }
                    
				$path = './public/files/spkp_manajemen_sop/'.$this->session->userdata('id');
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
					if($this->spkp_manajemen_sop_model->update_upload($id,$upload_data)){
						echo "OK_".$id;
					}else{
						echo "ERROR_Database Error";
					}
				}
			}else{
				if($this->spkp_manajemen_sop_model->update_upload($id)){
					echo "OK_".$id;
				}else{
					echo "ERROR_Database Error";
				}
			}
		}
    }
    
    function delete_upload($id){
        $this->authentication->verify('spkp_manajemen_sop','del');
        
		$data = $this->spkp_manajemen_sop_model->get_data_row_file($id);
		$path = './public/files/spkp_manajemen_sop/'.$this->session->userdata('id')."/".$data['filename'];

		if($this->spkp_manajemen_sop_model->delete_upload($id)){
			if(file_exists($path)){
				unlink($path);
			}
			echo "OK_".$id;
		}else{
			echo "ERROR_Database Error";
		}
    }
    
    function html_upload(){
        $this->authentication->verify('spkp_manajemen_sop','show');
		
		$data = $this->spkp_manajemen_sop_model->json_upload();

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_manajemen_sop/html_upload",$data);
    }
    
    function excel_upload(){
        $this->authentication->verify('spkp_manajemen_sop','show');

		$data = $this->spkp_manajemen_sop_model->json_upload();

		$rows = $data[0]['Rows'];
		$data['title'] = "Daftar File Manajemen Mutu SOP";
        
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/manajemen_mutu_sop_file.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_manajemen_mutu_sop_file.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
    }
    
    function download($id=0){
		$this->authentication->verify('spkp_manajemen_sop','edit');

		$data = $this->spkp_manajemen_sop_model->get_data_row_file($id);
		
        echo $this->parser->parse("spkp_manajemen_sop/download",$data,true);
	}

	function dodownload($id=0){
		$this->authentication->verify('spkp_manajemen_sop','edit');

		$data = $this->spkp_manajemen_sop_model->get_data_row_file($id);
		$path = './public/files/spkp_manajemen_sop/'.$this->session->userdata('id')."/".$data['filename'];

		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Transfer-Encoding: binary");
		header("Content-disposition: attachment; filename=" . $data['filename']);
		header("Content-type: application/octet-stream");
		readfile($path);
	}
}
?>