<?php
class Spkp_promotion_subdit extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('spkp_promotion_subdit_model');
        $this->load->helper('html');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
    }
    
    function index($tab="",$thn=""){
        $this->authentication->verify('spkp_promotion_subdit','show');
        
        $data = array();
        $data['title'] = "Kegiatan Subdit Promosi Keamanan Pangan";
        
        if($tab==""){
            $data['tab'] = "1";
        }else if($tab=="1"){
            $data['tab'] = "1";
        }else if($tab=="2"){
            $data['tab'] = "2";    
        }
        
        $data['thn'] = $thn!="" ? $thn : date("Y");
        $data['option_thn'] = "";
        
        for($i=date("Y");$i>=(date("Y")-5);$i--){
			$data['option_thn'] .= "<option value='$i' ".($data['thn']==$i ? "selected" : "").">$i</option>";
		}
        
		$data['add_permission']=$this->authentication->verify_check('spkp_promotion_subdit','add');
        $data['form_kegiatan'] = $this->parser->parse("spkp_promotion_subdit/form_kegiatan",$data,true);
        $data['form_upload'] = $this->parser->parse("spkp_promotion_subdit/form_upload",$data,true);
        $data['content'] = $this->parser->parse("spkp_promotion_subdit/show",$data,true);

		$this->template->show($data,"home");
    }
    
    function json_kegiatan($thn){
        die(json_encode($this->spkp_promotion_subdit_model->json_kegiatan($thn)));
    }
    
    function json_upload($thn){
        die(json_encode($this->spkp_promotion_subdit_model->json_upload($thn)));
    }
    
    function add_kegiatan(){
        $this->authentication->verify('spkp_promotion_subdit','add');
		$data['action']="add";

		echo $this->parser->parse("spkp_promotion_subdit/form_add_kegiatan",$data,true);
    }
    
    function doadd_kegiatan(){
        $this->authentication->verify('spkp_promotion_subdit','add');

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_promotion_subdit_model->insert_kegiatan();
			echo "1"; 
		}
    }
    
    function edit_kegiatan($id){
        $this->authentication->verify('spkp_promotion_subdit','add');

		$data = $this->spkp_promotion_subdit_model->get_data_row($id);
		$data['action']="edit";

		echo $this->parser->parse("spkp_promotion_subdit/form_add_kegiatan",$data,true);
    }
    
    function doedit_kegiatan(){
        $this->authentication->verify('spkp_promotion_subdit','edit');
        
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_promotion_subdit_model->update_kegiatan();
			echo "1";
		}
    }
    
    function dodel_kegiatan($id){
        $this->authentication->verify('spkp_promotion_subdit','del');

		if($this->spkp_promotion_subdit_model->delete_kegiatan($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function html_kegiatan($thn){
        $this->authentication->verify('spkp_promotion_subdit','show');
		
		$data = $this->spkp_promotion_subdit_model->json_kegiatan($thn);

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_promotion_subdit/html_kegiatan",$data);
    }
    
    function excel_kegiatan($thn){
        $this->authentication->verify('spkp_promotion_subdit','show');

		$data = $this->spkp_promotion_subdit_model->json_kegiatan($thn);

		$rows = $data[0]['Rows'];
		$data['title'] = "Daftar Kegiatan Subdit Promosi";
        $data['thn'] = "Tahun ".$thn;
        
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/kegiatan_subdit_promosi.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_kegiatan_subdit_promosi.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
    }
    
    function add_upload($thn){
        $this->authentication->verify('spkp_promotion_subdit','add');
		$data['action']="add";
        $data['thn'] = $thn;
        
		echo $this->parser->parse("spkp_promotion_subdit/form_add_upload",$data,true);
    }
    
    function doadd_upload(){
        $this->authentication->verify('spkp_promotion_subdit','add');
        
        $this->form_validation->set_rules('kegiatan', 'Kegiatan', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(!isset($_FILES['filename']['name']) || $_FILES['filename']['name']==""){
				echo "ERROR_File / Dokumen harus ada.";
			}else{
				if(count($_FILES)>0){
				    $path = './public/files/spkp_promotion_subdit';
                    if(!is_dir($path)){
                        mkdir($path);
                    }
                    
					$path = './public/files/spkp_promotion_subdit/'.$this->session->userdata('id');
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
						$id=$this->spkp_promotion_subdit_model->insert_upload($upload_data);
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
    
    function edit_upload($thn,$id){
        $this->authentication->verify('spkp_promotion_subdit','add');

		$data = $this->spkp_promotion_subdit_model->get_data_row_file($id);
		$data['action']="edit";
        $data['thn'] = $thn;
        
		echo $this->parser->parse("spkp_promotion_subdit/form_add_upload",$data,true);
    }
    
    function doedit_upload($id){
        $this->authentication->verify('spkp_promotion_subdit','edit');
        
        $this->form_validation->set_rules('kegiatan', 'Kegiatan', 'trim|required');
        
        if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(count($_FILES)>0){
			    $path = './public/files/spkp_promotion_subdit';
                if(!is_dir($path)){
                    mkdir($path);
                }
                    
				$path = './public/files/spkp_promotion_subdit/'.$this->session->userdata('id');
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
					if($this->spkp_promotion_subdit_model->update_upload($id,$upload_data)){
						echo "OK_".$id;
					}else{
						echo "ERROR_Database Error";
					}
				}
			}else{
				if($this->spkp_promotion_subdit_model->update_upload($id)){
					echo "OK_".$id;
				}else{
					echo "ERROR_Database Error";
				}
			}
		}
    }
    
    function delete_upload($id){
        $this->authentication->verify('spkp_promotion_subdit','del');
        
		$data = $this->spkp_promotion_subdit_model->get_data_row_file($id);
		$path = './public/files/spkp_promotion_subdit/'.$this->session->userdata('id')."/".$data['filename'];

		if($this->spkp_promotion_subdit_model->delete_upload($id)){
			if(file_exists($path)){
				unlink($path);
			}
			echo "OK_".$id;
		}else{
			echo "ERROR_Database Error";
		}
    }
    
    function html_upload($thn){
        $this->authentication->verify('spkp_promotion_subdit','show');
		
		$data = $this->spkp_promotion_subdit_model->json_upload($thn);

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_promotion_subdit/html_upload",$data);
    }
    
    function excel_upload($thn){
        $this->authentication->verify('spkp_promotion_subdit','show');

		$data = $this->spkp_promotion_subdit_model->json_upload($thn);

		$rows = $data[0]['Rows'];
		$data['title'] = "Daftar File Kegiatan Subdit Promosi";
        $data['thn'] = "Tahun ".$thn;
        
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/kegiatan_subdit_promosi_file.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_kegiatan_subdit_promosi_file.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
    }
    
    function download($id=0){
		$this->authentication->verify('spkp_promotion_subdit','edit');

		$data = $this->spkp_promotion_subdit_model->get_data_row_file($id);
		
        echo $this->parser->parse("spkp_promotion_subdit/download",$data,true);
	}

	function dodownload($id=0){
		$this->authentication->verify('spkp_promotion_subdit','edit');

		$data = $this->spkp_promotion_subdit_model->get_data_row_file($id);
		$path = './public/files/spkp_promotion_subdit/'.$this->session->userdata('id')."/".$data['filename'];

		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Transfer-Encoding: binary");
		header("Content-disposition: attachment; filename=" . $data['filename']);
		header("Content-type: application/octet-stream");
		readfile($path);
	}
    
}
?>