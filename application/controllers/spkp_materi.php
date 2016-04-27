<?php
class Spkp_materi extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('spkp_materi_model');
        $this->load->helper('html');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
    }
    
    function index(){
        $this->authentication->verify('spkp_materi','show');
        
        $data = array();
        $data['title'] = "Materi Presentasi";
		$data['type'] = "noindex";
        
		$data['add_permission']=$this->authentication->verify_check('spkp_materi','add');
        $data['form_materi'] = $this->parser->parse("spkp_materi/form_materi",$data,true);
        $data['form_upload'] = $this->parser->parse("spkp_materi/form_upload",$data,true);
        $data['content'] = $this->parser->parse("spkp_materi/show",$data,true);

		$this->template->show($data,"home");
    }
    
    function json_materi(){
        die(json_encode($this->spkp_materi_model->json_materi()));
    }
    
    function json_upload(){
        die(json_encode($this->spkp_materi_model->json_upload()));
    }
    
    function add_materi(){
        $this->authentication->verify('spkp_materi','add');
		$data['action']="add";

		echo $this->parser->parse("spkp_materi/form_add_materi",$data,true);
    }
    
    function doadd_materi(){
        $this->authentication->verify('spkp_materi','add');

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_materi_model->insert_materi();
			echo "1"; 
		}
    }
    
    function edit_materi($id){
        $this->authentication->verify('spkp_materi','add');

		$data = $this->spkp_materi_model->get_data_row($id);
		$data['action']="edit";

		echo $this->parser->parse("spkp_materi/form_add_materi",$data,true);
    }
    
    function doedit_materi(){
        $this->authentication->verify('spkp_materi','edit');
        
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_materi_model->update_materi();
			echo "1";
		}
    }
    
    function dodel_materi($id){
        $this->authentication->verify('spkp_materi','del');

		if($this->spkp_materi_model->delete_materi($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function html_materi(){
        $this->authentication->verify('spkp_materi','show');
		
		$data = $this->spkp_materi_model->json_materi();

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_materi/html_materi",$data);
    }
    
    function excel_materi(){
        $this->authentication->verify('spkp_materi','show');

		$data = $this->spkp_materi_model->json_materi();

		$rows = $data[0]['Rows'];
		$data['title'] = "Daftar Materi Presentasi";

		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/spkp_materi.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_spkp_materi.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		// echo $output_file_name;
		echo '../public/doc_xls_export/report_spkp_materi.xlsx';
		
    }
    
    function add_upload(){
        $this->authentication->verify('spkp_materi','add');
		$data['action']="add";

		echo $this->parser->parse("spkp_materi/form_add_upload",$data,true);
    }
    
    function doadd_upload(){
        $this->authentication->verify('spkp_materi','add');
        
        $this->form_validation->set_rules('materi', 'Materi', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(!isset($_FILES['filename']['name']) || $_FILES['filename']['name']==""){
				echo "ERROR_File / Dokumen harus ada.";
			}else{
				if(count($_FILES)>0){
				    $path = './public/files/spkp_materi';
                    if(!is_dir($path)){
                        mkdir($path);
                    }
                    
					$path = './public/files/spkp_materi/'.$this->session->userdata('id');
					if (!is_dir($path)) {
						mkdir($path);
					}
					@unlink($path."/".$_FILES['filename']['name']);
					$config['upload_path'] = $path;
					$config['allowed_types'] = '*';
					$config['max_size']	= '999999';
					$config['overwrite'] = false;
					$this->load->library('upload', $config);
					$upload = $this->upload->do_upload('filename');
					if($upload === FALSE) {
						echo "ERROR_".$this->upload->display_errors();
					}else{
						$upload_data = $this->upload->data();
						$id=$this->spkp_materi_model->insert_upload($upload_data);
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
        $this->authentication->verify('spkp_materi','add');

		$data = $this->spkp_materi_model->get_data_row_file($id);
		$data['action']="edit";

		echo $this->parser->parse("spkp_materi/form_add_upload",$data,true);
    }
    
    function doedit_upload($id){
        $this->authentication->verify('spkp_materi','edit');
        
        $this->form_validation->set_rules('materi', 'Materi', 'trim|required');
		
        if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(count($_FILES)>0){
			    $path = './public/files/spkp_materi';
                if(!is_dir($path)){
                    mkdir($path);
                }
                    
				$path = './public/files/spkp_materi/'.$this->session->userdata('id');
				if (!is_dir($path)) {
					mkdir($path);
				}
				@unlink($path."/".$_FILES['filename']['name']);
				$config['upload_path'] = $path;
				$config['allowed_types'] = '*';
				$config['max_size']	= '999999';
				$config['overwrite'] = false;
				$this->load->library('upload', $config);
				$upload = $this->upload->do_upload('filename');
				if($upload === FALSE) {
					echo "ERROR_".$this->upload->display_errors();
				}else{
					$upload_data = $this->upload->data();
					if($this->spkp_materi_model->update_upload($id,$upload_data)){
						echo "OK_".$id;
					}else{
						echo "ERROR_Database Error";
					}
				}
			}else{
				if($this->spkp_materi_model->update_upload($id)){
					echo "OK_".$id;
				}else{
					echo "ERROR_Database Error";
				}
			}
		}
    }
    
    function delete_upload($id){
        $this->authentication->verify('spkp_materi','del');
        
		$data = $this->spkp_materi_model->get_data_row_file($id);
		$path = './public/files/spkp_materi/'.$this->session->userdata('id')."/".$data['filename'];

		if($this->spkp_materi_model->delete_upload($id)){
			if(file_exists($path)){
				unlink($path);
			}
			echo "OK_".$id;
		}else{
			echo "ERROR_Database Error";
		}
    }
    
    function html_upload(){
        $this->authentication->verify('spkp_materi','show');
		
		$data = $this->spkp_materi_model->json_upload();

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_materi/html_upload",$data);
    }
    
    function excel_upload(){
        $this->authentication->verify('spkp_materi','show');

		$data = $this->spkp_materi_model->json_upload();

		$rows = $data[0]['Rows'];
		$data['title'] = "Daftar File Materi Presentasi";
        
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/spkp_materi_file.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_spkp_materi_file.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
    }
    
    function download($id=0){
		$this->authentication->verify('spkp_materi','edit');

		$data = $this->spkp_materi_model->get_data_row_file($id);
		
        echo $this->parser->parse("spkp_materi/download",$data,true);
	}

	function dodownload($id=0){
		$this->authentication->verify('spkp_materi','edit');

		$data = $this->spkp_materi_model->get_data_row_file($id);
		$path = './public/files/spkp_budget/'.$this->session->userdata('id')."/".$data['filename'];

		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Transfer-Encoding: binary");
		header("Content-disposition: attachment; filename=" . $data['filename']);
		header("Content-type: application/octet-stream");
		readfile($path);
	}
    
}
?>