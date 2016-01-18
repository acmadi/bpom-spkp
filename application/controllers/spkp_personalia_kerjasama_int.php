<?php
class Spkp_personalia_kerjasama_int extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('spkp_personalia_kerjasama_int_model');
        $this->load->helper('html');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
    }
    
    function index($departemen=""){
        $this->authentication->verify('spkp_personalia_kerjasama_int','show');
        
        $data = array();
        $data['title'] = "Kerjasama Internasional";
        
        if($departemen==""){
            $data['tab'] = "index";
        }else{
            $data['tab'] = "nonindex";
        }
        
        $data['departemen'] = $departemen!="" ? $departemen : $this->spkp_personalia_kerjasama_int_model->get_first_departmen();
        $data['option_departemen'] = "";
        
        $data_departemen = $this->spkp_personalia_kerjasama_int_model->get_all_departmen_int();
        foreach($data_departemen->result() as $row){
             $data['option_departemen'] .= "<option value=".$row->id_departemen." ".($row->id_departemen==$departemen ? "Selected" : "").">".$row->ket."</option>";
        }
        
        $data['add_permission']=$this->authentication->verify_check('spkp_personalia_kerjasama_int','add');
        $data['form_departemen'] = $this->parser->parse("spkp_personalia_kerjasama_int/form_departemen",$data,true);
        $data['form_upload'] = $this->parser->parse("spkp_personalia_kerjasama_int/form_upload",$data,true);
        $data['content'] = $this->parser->parse("spkp_personalia_kerjasama_int/show",$data,true);

		$this->template->show($data,"home");
    }
    
    function json_departemen_int(){
        die(json_encode($this->spkp_personalia_kerjasama_int_model->json_departemen_int()));
    }
    
    function json_upload($departemen){
        die(json_encode($this->spkp_personalia_kerjasama_int_model->json_upload($departemen)));
    }
    
    function add_departemen(){
        $this->authentication->verify('spkp_personalia_kerjasama_int','add');
		$data['action']="add";

		echo $this->parser->parse("spkp_personalia_kerjasama_int/form_add_departemen",$data,true);
    }
    
    function doadd_departemen(){
        $this->authentication->verify('spkp_personalia_kerjasama_int','add');

		$this->form_validation->set_rules('ket', 'Keterangan', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_personalia_kerjasama_int_model->insert_departemen();
			echo "1"; 
		}
    }
    
    function edit_departemen($id){
        $this->authentication->verify('spkp_personalia_kerjasama_int','add');

		$data = $this->spkp_personalia_kerjasama_int_model->get_data_row($id);
		$data['action']="edit";

		echo $this->parser->parse("spkp_personalia_kerjasama_int/form_add_departemen",$data,true);
    }
    
    function doedit_departemen(){
        $this->authentication->verify('spkp_personalia_kerjasama_int','edit');
        
        $this->form_validation->set_rules('ket', 'Keterangan', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_personalia_kerjasama_int_model->update_departemen();
			echo "1";
		}
    }
    
    function dodel_departemen($id){
        $this->authentication->verify('spkp_personalia_kerjasama_int','del');

		if($this->spkp_personalia_kerjasama_int_model->delete_departemen($id)){
			$data_file = $this->spkp_personalia_kerjasama_int_model->get_id_file($id);
            foreach($data_file as $row_file){
                $data = $this->spkp_personalia_kerjasama_int_model->get_data_row_file($row_file->id);
        		$path = './public/files/spkp_personalia_kerjasama_int/'.$this->session->userdata('id')."/".$row_file->filename;
        
        		if($this->spkp_personalia_kerjasama_int_model->delete_upload($row_file->id)){
        			if(file_exists($path)){
        				unlink($path);
        			}
        		}
            } 
            echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function html_departemen(){
        $this->authentication->verify('spkp_personalia_kerjasama_int','show');
		
		$data = $this->spkp_personalia_kerjasama_int_model->json_departemen_int();

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_personalia_kerjasama_int/html_departemen",$data);
    }
    
    function excel_departemen(){
        $this->authentication->verify('spkp_personalia_kerjasama_int','show');

		$data = $this->spkp_personalia_kerjasama_int_model->json_departemen_int();

		$rows = $data[0]['Rows'];
		$data['title'] = "Daftar Kerjasama Internasional";
        
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/kegiatan_kerjasama_int.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_kegiatan_kerjasama_int.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
    }
    
    function add_upload($departemen){
        $this->authentication->verify('spkp_personalia_kerjasama_int','add');
		$data['action']="add";
        $data['departemen'] = $departemen;
        
		echo $this->parser->parse("spkp_personalia_kerjasama_int/form_add_upload",$data,true);
    }
    
    function doadd_upload(){
        $this->authentication->verify('spkp_personalia_kerjasama_int','add');
        
        $this->form_validation->set_rules('departemen', 'Departemen', 'trim|required');
        $this->form_validation->set_rules('jenis', 'Jenis', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(!isset($_FILES['filename']['name']) || $_FILES['filename']['name']==""){
				echo "ERROR_File / Dokumen harus ada.";
			}else{
				if(count($_FILES)>0){
				    $path = './public/files/spkp_personalia_kerjasama_int';
                    if(!is_dir($path)){
                        mkdir($path);
                    }
                    
					$path = './public/files/spkp_personalia_kerjasama_int/'.$this->session->userdata('id');
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
						$id=$this->spkp_personalia_kerjasama_int_model->insert_upload($upload_data);
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
    
    function edit_upload($departemen,$id){
        $this->authentication->verify('spkp_personalia_kerjasama_int','add');

		$data = $this->spkp_personalia_kerjasama_int_model->get_data_row_file($id);
		$data['action']="edit";
        
		echo $this->parser->parse("spkp_personalia_kerjasama_int/form_add_upload",$data,true);
    }
    
    function doedit_upload($id){
        $this->authentication->verify('spkp_personalia_kerjasama_int','edit');
        
        $this->form_validation->set_rules('departemen', 'Departemen', 'trim|required');
        $this->form_validation->set_rules('jenis', 'Jenis', 'trim|required');
        
        if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(count($_FILES)>0){
			    $path = './public/files/spkp_personalia_kerjasama_int';
                if(!is_dir($path)){
                    mkdir($path);
                }
                    
				$path = './public/files/spkp_personalia_kerjasama_int/'.$this->session->userdata('id');
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
					if($this->spkp_personalia_kerjasama_int_model->update_upload($id,$upload_data)){
						echo "OK_".$id;
					}else{
						echo "ERROR_Database Error";
					}
				}
			}else{
				if($this->spkp_personalia_kerjasama_int_model->update_upload($id)){
					echo "OK_".$id;
				}else{
					echo "ERROR_Database Error";
				}
			}
		}
    }
    
    function delete_upload($id){
        $this->authentication->verify('spkp_personalia_kerjasama_int','del');
        
		$data = $this->spkp_personalia_kerjasama_int_model->get_data_row_file($id);
		$path = './public/files/spkp_personalia_kerjasama_int/'.$this->session->userdata('id')."/".$data['filename'];

		if($this->spkp_personalia_kerjasama_int_model->delete_upload($id)){
			if(file_exists($path)){
				unlink($path);
			}
			echo "OK_".$id;
		}else{
			echo "ERROR_Database Error";
		}
    }
    
    function html_upload($departemen){
        $this->authentication->verify('spkp_personalia_kerjasama_int','show');
		
		$data = $this->spkp_personalia_kerjasama_int_model->json_upload($departemen);

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_personalia_kerjasama_int/html_upload",$data);
    }
    
    function excel_upload($departemen){
        $this->authentication->verify('spkp_personalia_kerjasama_int','show');

		$data = $this->spkp_personalia_kerjasama_int_model->json_upload($departemen);

		$rows = $data[0]['Rows'];
		$data['title'] = "Daftar File Kerjasama Internasional";
        $data['departemen'] = "Departemen ".$this->spkp_personalia_kerjasama_int_model->get_departemen($departemen);
        
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/kegiatan_kerjasama_int_file.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_kegiatan_kerjasama_int_file.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
    }
    
    function download($id=0){
		$this->authentication->verify('spkp_personalia_kerjasama_int','edit');

		$data = $this->spkp_personalia_kerjasama_int_model->get_data_row_file($id);
		
        echo $this->parser->parse("spkp_personalia_kerjasama_int/download",$data,true);
	}

	function dodownload($id=0){
		$this->authentication->verify('spkp_personalia_kerjasama_int','edit');

		$data = $this->spkp_personalia_kerjasama_int_model->get_data_row_file($id);
		$path = './public/files/spkp_personalia_kerjasama_int/'.$this->session->userdata('id')."/".$data['filename'];

		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Transfer-Encoding: binary");
		header("Content-disposition: attachment; filename=" . $data['filename']);
		header("Content-type: application/octet-stream");
		readfile($path);
	}
}
?>