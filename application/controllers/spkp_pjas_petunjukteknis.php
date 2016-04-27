<?php
class Spkp_pjas_petunjukteknis extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('spkp_pjas_petunjukteknis_model');
        $this->load->helper('html');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
    }
    
    function index($thn=""){
        $this->authentication->verify('spkp_pjas_petunjukteknis','show');
        
        $data = array();
        $data['title'] = "Petunjuk Teknis";
        $data['thn'] = $thn!="" ? $thn : date("Y");
        $data['option_thn'] = "";
        
        for($i=date("Y");$i>=(date("Y")-5);$i--){
			$data['option_thn'] .= "<option value='$i' ".($data['thn']==$i ? "selected" : "").">$i</option>";
		}
        
		$data['add_permission']=$this->authentication->verify_check('spkp_pjas_petunjukteknis','add');
        $data['form'] = $this->parser->parse("spkp_pjas_petunjukteknis/form",$data,true);
        $data['content'] = $this->parser->parse("spkp_pjas_petunjukteknis/show",$data,true);

		$this->template->show($data,"home");
    }
    
    function json_judul($thn){
        die(json_encode($this->spkp_pjas_petunjukteknis_model->json_judul($thn)));
    }
    
    function add_upload(){
        $this->authentication->verify('spkp_pjas_petunjukteknis','add');
		$data['action']="add";

		echo $this->parser->parse("spkp_pjas_petunjukteknis/form",$data,true);
    }
    
    function doadd_upload(){
        $this->authentication->verify('spkp_pjas_petunjukteknis','add');
        
        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(!isset($_FILES['filename']['name']) || $_FILES['filename']['name']==""){
				echo "ERROR_File / Dokumen harus ada.";
			}else{
				if(count($_FILES)>0){
				    $path = './public/files/spkp_pjas_petunjukteknis';
                    if(!is_dir($path)){
                        mkdir($path);
                    }
                    
					$path .=$this->session->userdata('id');
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
						$id=$this->spkp_pjas_petunjukteknis_model->insert_upload($upload_data);
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
        $this->authentication->verify('spkp_pjas_petunjukteknis','add');

		$data = $this->spkp_pjas_petunjukteknis_model->get_data_row($id);
		$data['action']="edit";

		echo $this->parser->parse("spkp_pjas_petunjukteknis/form",$data,true);
    }
    
    function doedit_upload($id){
        $this->authentication->verify('spkp_pjas_petunjukteknis','edit');
        
        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');
		
        if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(count($_FILES)>0){
			    $path = './public/files/spkp_pjas_petunjukteknis';
                if(!is_dir($path)){
                    mkdir($path);
                }
                    
				$path = './public/files/spkp_pjas_petunjukteknis/'.$this->session->userdata('id');
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
					if($this->spkp_pjas_petunjukteknis_model->update_upload($id,$upload_data)){
						echo "OK_".$id;
					}else{
						echo "ERROR_Database Error";
					}
				}
			}else{
				if($this->spkp_pjas_petunjukteknis_model->update_upload($id)){
					echo "OK_".$id;
				}else{
					echo "ERROR_Database Error";
				}
			}
		}
    }
    
    function delete_upload($id){
        $this->authentication->verify('spkp_pjas_petunjukteknis','del');
        
		$data = $this->spkp_pjas_petunjukteknis_model->get_data_row($id);
		$path = './public/files/spkp_pjas_petunjukteknis/'.$this->session->userdata('id')."/".$data['filename'];

		if($this->spkp_pjas_petunjukteknis_model->delete_upload($id)){
			if(file_exists($path)){
				unlink($path);
			}
			echo "OK_".$id;
		}else{
			echo "ERROR_Database Error";
		}
    }
    
    function html_upload($thn){
        $this->authentication->verify('spkp_pjas_petunjukteknis','show');
		
		$data = $this->spkp_pjas_petunjukteknis_model->json_judul($thn);

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_pjas_petunjukteknis/html",$data);
    }
    
    function excel_upload($thn){
        $this->authentication->verify('spkp_pjas_petunjukteknis','show');

		$data = $this->spkp_pjas_petunjukteknis_model->json_judul($thn);

		$rows = $data[0]['Rows'];
		$data['title'] = "Daftar File Petunjuk Teknis";
        $data['thn'] = "Tahun ".$thn;
        
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/pjas_petunjukteknis_file.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_pjas_petunjukteknis_file.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		// echo $output_file_name;
        echo '../public/doc_xls_export/report_pjas_petunjukteknis_file.xlsx';
		
    }
    
    function download($id=0){
		$this->authentication->verify('spkp_pjas_petunjukteknis','edit');

		$data = $this->spkp_pjas_petunjukteknis_model->get_data_row($id);
		
        echo $this->parser->parse("spkp_pjas_petunjukteknis/download",$data,true);
	}

	function dodownload($id=0){
		$this->authentication->verify('spkp_pjas_petunjukteknis','edit');

		$data = $this->spkp_pjas_petunjukteknis_model->get_data_row($id);
		$path = './public/files/spkp_pjas_petunjukteknis/'.$this->session->userdata('id')."/".$data['filename'];

		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Transfer-Encoding: binary");
		header("Content-disposition: attachment; filename=" . $data['filename']);
		header("Content-type: application/octet-stream");
		readfile($path);
	}
}
?>