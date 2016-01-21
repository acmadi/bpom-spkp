<?php
class Srikandi extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('spkp_model');
        $this->load->model('srikandi_model');
        $this->load->helper('html');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
    }
    
    function index($subdit=""){
        $this->authentication->verify('srikandi','show');
        
        $data = array();
        $data['title'] = "Informasi dan Kajian";
        $data['subdit'] = $subdit!="" ? $subdit : 0;
        $data['option_subdit'] =  $this->srikandi_model->getSubdit($subdit);
        
		$data['add_permission']=$this->authentication->verify_check('srikandi','add');
        $data['form'] = $this->parser->parse("srikandi/form",$data,true);
        $data['content'] = $this->parser->parse("srikandi/show",$data,true);

		$this->template->show($data,"home");
    }

    function detail($id=""){
        $this->authentication->verify('srikandi','show');
        
        $data = array();
        $data['title'] = "Detail Informasi dan Kajian";
		$data['konten'] = $this->spkp_model->get_content(5);
        
		$data['add_permission']		= $this->authentication->verify_check('srikandi','show');
       	$data['detail_upload'] 		= $this->srikandi_model->getSubdit_detail($id);
       	$data['id_srikandi'] 		= $id;
        $data['content'] 			= $this->parser->parse("srikandi/detail",$data,true);

		$this->template->show($data,"home");
    }

    public function komentar(){
            $this->form_validation->set_rules('komentar_detail', 'Komentar', 'required');
            if ($this->form_validation->run() == FALSE){
               echo'<div class="alert alert-danger">'.validation_errors().'</div>';
               exit;
            }
            else{
                $this->srikandi_model->komentar();
            }
  	}

  	public function timeline_comment($id_srikandi = 0){
  		$data = array();
       	$data['data_comment'] 	= $this->srikandi_model->get_comment($id_srikandi);
  		echo $this->parser->parse("srikandi/komentar",$data);


  		die();
  	}

  	public function timeline_file($id_srikandi = 0){
  		$data = array();
       	$data['data_file'] 	= $this->srikandi_model->upload_detail($id_srikandi);

  		echo $this->parser->parse("srikandi/file",$data);

  		die();
  	}

    function filter(){
		if($_POST) {
			$this->session->set_userdata('searchsubdit', $this->input->post('subdit'));
		}
		
    }

    function json_judul(){
        die(json_encode($this->srikandi_model->json_judul()));
    }

	function getKategoriParent($id_subdit=0,$kategori=0){
		$data = $this->srikandi_model->getKategoriParent($id_subdit,$kategori);

		header('Content-type: text/X-JSON');
		echo json_encode($data);
		exit;
	}

	function getKategori($id_kategori_parent=0,$kategori=0){
		$data = $this->srikandi_model->getKategori($id_kategori_parent,$kategori);

		header('Content-type: text/X-JSON');
		echo json_encode($data);
		exit;
	}

    function add_upload_rev($id_srikandi=0){
        $this->authentication->verify('srikandi','add');

		$data['action']="add";
		$data['option_subdit']=$this->crud->option_subdit('','style="height:25px;padding:2px;margin: 0;"');
		$data['detail_upload']  = $this->srikandi_model->getSubdit_detail($id_srikandi);
		$data['id_srikandi_ref'] = $id_srikandi;


		echo $this->parser->parse("srikandi/form_rev",$data,true);
    }
    function add_upload(){
        $this->authentication->verify('srikandi','add');
		$data['action']="add";
		$data['option_subdit']=$this->crud->option_subdit('','style="height:25px;padding:2px;margin: 0;width:92%"');

		echo $this->parser->parse("srikandi/form",$data,true);
    }
    
    function doadd_upload(){
        $this->authentication->verify('srikandi','add');
        
        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');
		$this->form_validation->set_rules('id_subdit', 'Sub Dit', 'trim|required');
		$this->form_validation->set_rules('id_kategori_parent', 'Kategori', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(!isset($_FILES['filename']['name']) || $_FILES['filename']['name']==""){
				echo "ERROR_File / Dokumen harus ada.";
			}else{
				if(count($_FILES)>0){
				    $path = './public/files/srikandi';
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
						$id=$this->srikandi_model->insert_upload($upload_data);
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
        $this->authentication->verify('srikandi','add');

		$data = $this->srikandi_model->get_data_row($id);
		$data['action']="edit";
		$data['option_subdit']=$this->crud->option_subdit($data['id_subdit'],'style="height:25px;padding:2px;margin: 0;width:92%"');

		echo $this->parser->parse("srikandi/form",$data,true);
    }
    
    function doedit_upload($id){
        $this->authentication->verify('srikandi','edit');
        
        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');
		$this->form_validation->set_rules('id_subdit', 'Sub Dit', 'trim|required');
		$this->form_validation->set_rules('id_kategori_parent', 'Kategori', 'trim|required');
		
        if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(count($_FILES)>0){
			    $path = './public/files/srikandi';
                if(!is_dir($path)){
                    mkdir($path);
                }
                    
				$path = './public/files/srikandi/'.$this->session->userdata('id');
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
					if($this->srikandi_model->update_upload($id,$upload_data)){
						echo "OK_".$id;
					}else{
						echo "ERROR_Database Error";
					}
				}
			}else{
				if($this->srikandi_model->update_upload($id)){
					echo "OK_".$id;
				}else{
					echo "ERROR_Database Error";
				}
			}
		}
    }
    
    function delete_upload($id){
        $this->authentication->verify('srikandi','del');
        
		$data = $this->srikandi_model->get_data_row($id);
		$path = './public/files/srikandi/'.$this->session->userdata('id')."/".$data['filename'];

		if($this->srikandi_model->delete_upload($id)){
			if(file_exists($path)){
				unlink($path);
			}
			echo "OK_".$id;
		}else{
			echo "ERROR_Database Error";
		}
    }
    
    function html_upload($thn){
        $this->authentication->verify('srikandi','show');
		
		$data = $this->srikandi_model->json_judul($thn);

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("srikandi/html",$data);
    }
    
    function excel_upload($thn){
        $this->authentication->verify('srikandi','show');

		$data = $this->srikandi_model->json_judul($thn);

		$rows = $data[0]['Rows'];
		$data['title'] = "Informasi dan Kajian";
        $data['thn'] = "Tahun ".$thn;
        
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;
		$template = $path.'templates/srikandi.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_srikandi.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
    }
    
    function download($id=0){
		$this->authentication->verify('srikandi','edit');

		$data = $this->srikandi_model->get_data_row($id);
		
        echo $this->parser->parse("srikandi/download",$data,true);
	}

	function dodownload($id=0){
		$this->authentication->verify('srikandi','edit');

		$data = $this->srikandi_model->get_data_row($id);
		$path = './public/files/srikandi/'.$this->session->userdata('id')."/".$data['filename'];

		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Transfer-Encoding: binary");
		header("Content-disposition: attachment; filename=" . $data['filename']);
		header("Content-type: application/octet-stream");
		readfile($path);
	}
}
?>