<?php
class Spkp_renstra_bpom extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('spkp_renstra_bpom_model');
        $this->load->helper('html');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
    }
    
    function index(){
        $this->authentication->verify('spkp_renstra_bpom','show');
        
	    $data = array();
        $data['add_permission']=$this->authentication->verify_check('spkp_renstra_bpom','add');
		$data['content'] = $this->parser->parse("spkp_renstra_bpom/show",$data,true);

		$this->template->show($data,"home");
    }
    
    function json_renstra_bpom(){
		die(json_encode($this->spkp_renstra_bpom_model->json_renstra_bpom()));
	}

    function add(){
		$this->authentication->verify('spkp_renstra_bpom','add');

		$data['action']="add";

		echo $this->parser->parse("spkp_renstra_bpom/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('spkp_renstra_bpom','add');
        
        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(!isset($_FILES['filename']['name']) || $_FILES['filename']['name']==""){
				echo "ERROR_File / Dokumen harus ada.";
			}else{
				if(count($_FILES)>0){
					$path = './public/files/spkp_renstra_bpom/';
					if (!is_dir($path)) {
						mkdir($path);
					}
					$path .= $this->session->userdata('id');
					if (!is_dir($path)) {
						mkdir($path);
					}
					@unlink($path."/".$_FILES['filename']['name']);
					$config['upload_path'] = $path;
					$config['allowed_types'] = 'pdf';
					$config['max_size']	= '999999';
					$config['overwrite'] = false;
					$this->load->library('upload', $config);
					$upload = $this->upload->do_upload('filename');
					if($upload === FALSE) {
						echo "ERROR_".$this->upload->display_errors();
					}else{
						$upload_data = $this->upload->data();
						$id=$this->spkp_renstra_bpom_model->doadd($upload_data);
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
		$this->authentication->verify('spkp_renstra_bpom','add');

		$data = $this->spkp_renstra_bpom_model->get_data_row($id); 
		$data['action']="edit";

		echo $this->parser->parse("spkp_renstra_bpom/form",$data,true);
	}

	function doedit($id=0)
	{
		$this->authentication->verify('spkp_renstra_bpom','edit');

        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(count($_FILES)>0){
				$path = './public/files/spkp_renstra_bpom/'.$this->session->userdata('id');
				if (!is_dir($path)) {
					mkdir($path);
				}
				@unlink($path."/".$_FILES['filename']['name']);
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'pdf';
				$config['max_size']	= '999999';
				$config['overwrite'] = false;
				$this->load->library('upload', $config);
				$upload = $this->upload->do_upload('filename');
				if($upload === FALSE) {
					echo "ERROR_".$this->upload->display_errors();
				}else{
					$upload_data = $this->upload->data();
					if($this->spkp_renstra_bpom_model->doedit($id,$upload_data)){
						echo "OK_".$id;
					}else{
						echo "ERROR_Database Error";
					}
				}
			}else{
				if($this->spkp_renstra_bpom_model->doedit($id)){
					echo "OK_".$id;
				}else{
					echo "ERROR_Database Error";
				}
			}
		}
	}
	
	function download($id=0){
		$this->authentication->verify('spkp_renstra_bpom','edit');

		$data = $this->spkp_renstra_bpom_model->get_data_row($id); 

		echo $this->parser->parse("spkp_renstra_bpom/download",$data,true);
	}

	function dodownload($id=0){
		$this->authentication->verify('spkp_renstra_bpom','edit');

		$data = $this->spkp_renstra_bpom_model->get_data_row($id); 
		$path = './public/files/spkp_renstra_bpom/'.$this->session->userdata('id')."/".$data['filename'];

		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Transfer-Encoding: binary");
		header("Content-disposition: attachment; filename=" . $data['filename']);
		header("Content-type: application/octet-stream");
		readfile($path);
	}

	function dodelete($id=0){
		$this->authentication->verify('spkp_renstra_bpom','del');
		$data = $this->spkp_renstra_bpom_model->get_data_row($id); 
		$path = './public/files/spkp_renstra_bpom/'.$this->session->userdata('id')."/".$data['filename'];

		if($this->spkp_renstra_bpom_model->dodelete($id)){
			if(file_exists($path)){
				unlink($path);
			}

			echo "OK_".$id;
		}else{
			echo "ERROR_Database Error";
		}
	}

	function html(){
		$this->authentication->verify('spkp_renstra_bpom','show');
		
		$data = $this->spkp_renstra_bpom_model->json_renstra_bpom();

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_renstra_bpom/html",$data);
	}

	function excel(){
		$this->authentication->verify('spkp_renstra_bpom','show');

		$data = $this->spkp_renstra_bpom_model->json_renstra_bpom();

		$rows = $data[0]['Rows'];
		$data['title'] = "Rencana Strategis Badan POM";

		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/renstra_bpom.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_renstra_bpom.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		//echo $output_file_name;
		echo '../public/doc_xls_export/report_renstra_bpom.xlsx';
	}

}

?>