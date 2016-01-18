<?php
class Spkp_director_history extends CI_Controller {
     
    function __construct(){
        parent::__construct();
        $this->load->model('spkp_director_history_model');
        $this->load->model('spkp_personnel_model');
        $this->load->model('admin_users_model');
        $this->load->model('location_model');
        $this->load->helper('html');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
    }
    
    function index(){
        $this->authentication->verify('spkp_director_history','show');
        
	    $data = array();
        $data['title'] = "Riwayat Direktur";
		$data['content'] = $this->parser->parse("spkp_director_history/show",$data,true);

		$this->template->show($data,"home");
    }
    
    function edit($id){
        $this->authentication->verify('spkp_director_history','edit');
        
        $data = $this->spkp_personnel_model->get_user($id);
        $data['title'] = "Riwayat Direktur &raquo; Edit";
        $data['id'] = $id;
        $data['add_permission']=$this->authentication->verify_check('spkp_director_history','add');
        
        if($this->session->userdata('level')=="super administrator" || $this->session->userdata('id')==$id){
            $data['form_profile'] = $this->parser->parse("spkp_director_history/form",$data,true);
        }else{
            $data['form_profile'] = $this->parser->parse("spkp_director_history/form_lock",$data,true);
        }
        $data['form_jabatan'] = $this->parser->parse("spkp_director_history/form_jabatan",$data,true);
        $data['form_pangkat'] = $this->parser->parse("spkp_director_history/form_pangkat",$data,true);
        $data['form_dokumen'] = $this->parser->parse("spkp_director_history/form_dokumen",$data,true);
        $data['content'] = $this->parser->parse("spkp_director_history/show_edit",$data,true);
        
        $this->template->show($data,"home");
    }
    
    function json_director(){
        die(json_encode($this->spkp_director_history_model->json_director()));
    }
    
    function json_jabatan($id){
        die(json_encode($this->spkp_director_history_model->json_jabatan($id)));
    }
    
    function json_pangkat($id){
        die(json_encode($this->spkp_director_history_model->json_pangkat($id)));
    }
    
    function json_file($id){
        die(json_encode($this->spkp_director_history_model->json_file($id)));
    }
    
    function html(){
		$this->authentication->verify('spkp_director_history','show');
		
		$data = $this->spkp_director_history_model->json_director();

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_director_history/html",$data);
	}
    
    function html_jabatan($id){
		$this->authentication->verify('spkp_director_history','show');
		
		$data = $this->spkp_director_history_model->json_jabatan($id);

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_director_history/html_jabatan",$data);
	}
    
    function html_pangkat($id){
		$this->authentication->verify('spkp_director_history','show');
		
		$data = $this->spkp_director_history_model->json_pangkat($id);

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_director_history/html_pangkat",$data);
	}
    
    function excel(){
		$this->authentication->verify('spkp_director_history','show');

		$data = $this->spkp_director_history_model->json_director();

        $rows = $data[0]['Rows'];
		$data['title'] = "Daftar Direktur";

		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/profile_direktur.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_profile_direktur.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
	}
    
    function excel_jabatan($id){
		$this->authentication->verify('spkp_director_history','show');

		$data = $this->spkp_director_history_model->json_jabatan($id);

		$rows = $data[0]['Rows'];
		$data['title'] = "Daftar Jabatan Pegawai";

		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/profile_direktur_jabatan.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_profile_direktur_jabatan.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
	}
    
    function excel_pangkat($id){
		$this->authentication->verify('spkp_director_history','show');

		$data = $this->spkp_director_history_model->json_pangkat($id);

		$rows = $data[0]['Rows'];
		$data['title'] = "Daftar Pangkat Pegawai";

		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/profile_direktur_pangkat.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_profile_direktur_pangkat.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
	}
    
    function doedit_profile($id){
        $this->authentication->verify('spkp_director_history','edit');
        
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
				$path = './media/images/director';
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
					$this->spkp_director_history_model->update_profile($id,1,$upload_data);
                    echo "1";
				}
			}else{
				$this->spkp_director_history_model->update_profile($id,2,"");
			    echo "1";
            }
		}
    }
    
    function load_form_profile($id){
       $this->authentication->verify('spkp_director_history','edit');

	   $data = $this->spkp_personnel_model->get_user($id);
	 
       echo $this->parser->parse("spkp_director_history/form",$data,true);        
    }
    
    function add_jabatan(){
		$this->authentication->verify('spkp_director_history','add');

		$data['action']="add";

		echo $this->parser->parse("spkp_director_history/form_add_jabatan",$data,true);
	}
    
    function doadd_jabatan($id){
        $this->authentication->verify('spkp_director_history','add');

		$this->form_validation->set_rules('id_subdit', 'Subdit', 'trim|required');
        $this->form_validation->set_rules('id_jabatan', 'Jabatan', 'trim|required');
        $this->form_validation->set_rules('id_golruang', 'Golongan', 'trim|required');
        $this->form_validation->set_rules('sk_jb_tgl', 'Tanggal SK', 'trim|required');
        $this->form_validation->set_rules('sk_jb_nomor', 'Nomor SK', 'trim|required');
        $this->form_validation->set_rules('sk_jb_pejabat', 'Pejabat', 'trim|required');
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('tgl_sampai', 'Tanggal Akhir', 'trim|required');
        

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_director_history_model->insert_jabatan($id);
			echo "1"; 
		}
    }
    
    function edit_jabatan($id,$id_jabatan){
        $this->authentication->verify('spkp_director_history','add');

		$data = $this->spkp_director_history_model->get_jabatan($id,$id_jabatan);
		$data['action']="edit";

		echo $this->parser->parse("spkp_director_history/form_add_jabatan",$data,true);
    }
    
    function doedit_jabatan(){
        $this->authentication->verify('spkp_director_history','edit');
        
        $this->form_validation->set_rules('id_subdit', 'Subdit', 'trim|required');
        $this->form_validation->set_rules('id_jabatan', 'Jabatan', 'trim|required');
        $this->form_validation->set_rules('id_golruang', 'Golongan', 'trim|required');
        $this->form_validation->set_rules('sk_jb_tgl', 'Tanggal SK', 'trim|required');
        $this->form_validation->set_rules('sk_jb_nomor', 'Nomor SK', 'trim|required');
        $this->form_validation->set_rules('sk_jb_pejabat', 'Pejabat', 'trim|required');
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('tgl_sampai', 'Tanggal Akhir', 'trim|required');
        
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_director_history_model->update_jabatan();
			echo "1";
		}
    }
    
    function dodel_jabatan($id,$id_jabatan){
        $this->authentication->verify('spkp_director_history','del');

		if($this->spkp_director_history_model->delete_jabatan($id,$id_jabatan)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function select_jabatan($subdit,$jabatan=0){
		$data = $this->location_model->select_jabatan($subdit,$jabatan);

		header('Content-type: text/X-JSON');
		echo json_encode($data);
		exit;
	}
    
    function add_pangkat(){
		$this->authentication->verify('spkp_director_history','add');

		$data['action']="add";

		echo $this->parser->parse("spkp_director_history/form_add_pangkat",$data,true);
	}
    
    function doadd_pangkat($id){
        $this->authentication->verify('spkp_director_history','add');

		$this->form_validation->set_rules('id_subdit_pangkat', 'Subdit', 'trim|required');
        $this->form_validation->set_rules('id_golruang', 'Golongan', 'trim|required');
        $this->form_validation->set_rules('sk_jb_tgl_pangkat', 'Tanggal SK', 'trim|required');
        $this->form_validation->set_rules('sk_jb_nomor', 'Nomor SK', 'trim|required');
        $this->form_validation->set_rules('sk_jb_pejabat', 'Pejabat', 'trim|required');
      //  $this->form_validation->set_rules('nomor_persetujuan', 'No Persetujuan', 'trim|required');
        $this->form_validation->set_rules('pddk_tertinggi', 'Pendidikan Tertinggi', 'trim|required');
        $this->form_validation->set_rules('tgl_mulai_pangkat', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('tgl_sampai_pangkat', 'Tanggal Akhir', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_director_history_model->insert_pangkat($id);
			echo "1"; 
		}
    }
    
    function edit_pangkat($id,$id_golruang){
        $this->authentication->verify('spkp_director_history','add');

		$data = $this->spkp_director_history_model->get_pangkat($id,$id_golruang);
		$data['action']="edit";

		echo $this->parser->parse("spkp_director_history/form_add_pangkat",$data,true);
    }
    
    function doedit_pangkat(){
        $this->authentication->verify('spkp_director_history','edit');
        
        $this->form_validation->set_rules('id_subdit_pangkat', 'Subdit', 'trim|required');
        $this->form_validation->set_rules('id_golruang', 'Golongan', 'trim|required');
        $this->form_validation->set_rules('sk_jb_tgl_pangkat', 'Tanggal SK', 'trim|required');
        $this->form_validation->set_rules('sk_jb_nomor', 'Nomor SK', 'trim|required');
        $this->form_validation->set_rules('sk_jb_pejabat', 'Pejabat', 'trim|required');
      //  $this->form_validation->set_rules('nomor_persetujuan', 'No Persetujuan', 'trim|required');
        $this->form_validation->set_rules('pddk_tertinggi', 'Pendidikan Tertinggi', 'trim|required');
        $this->form_validation->set_rules('tgl_mulai_pangkat', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('tgl_sampai_pangkat', 'Tanggal Akhir', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_director_history_model->update_pangkat();
			echo "1";
		}
    }
    
    function dodel_pangkat($id,$id_golruang){
        $this->authentication->verify('spkp_director_history','del');

		if($this->spkp_director_history_model->delete_pangkat($id,$id_golruang)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    // begin here
    
    function add_file($id){
		$this->authentication->verify('spkp_director_history','add');
        $data['id'] = $id;
		$data['action']="add";

		echo $this->parser->parse("spkp_director_history/form_add_dokumen",$data,true);
	}

	function doadd_file(){
		$this->authentication->verify('spkp_director_history','add');
        
        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(!isset($_FILES['filename']['name']) || $_FILES['filename']['name']==""){
				echo "ERROR_File / Dokumen harus ada.";
			}else{
				if(count($_FILES)>0){
					$path = './public/files/spkp_director_history/';
					if (!is_dir($path)) {
						mkdir($path);
					}
					$path .= $this->session->userdata('id');
					if (!is_dir($path)) {
						mkdir($path);
					}
					@unlink($path."/".$_FILES['filename']['name']);
					$config['upload_path'] = $path;
					$config['allowed_types'] = 'xls|xlsx|doc|docx|pdf';
					$config['max_size']	= '999999';
					$config['overwrite'] = false;
					$this->load->library('upload', $config);
					$upload = $this->upload->do_upload('filename');
					if($upload === FALSE) {
						echo "ERROR_".$this->upload->display_errors();
					}else{
						$upload_data = $this->upload->data();
						$id=$this->spkp_director_history_model->doadd_file($upload_data);
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
	
	function edit_file($id=0){
		$this->authentication->verify('spkp_director_history','add');

		$data = $this->spkp_director_history_model->get_data_file($id); 
		$data['action']="edit";

		echo $this->parser->parse("spkp_director_history/form_add_dokumen",$data,true);
	}

	function doedit_file($id=0){
		$this->authentication->verify('spkp_director_history','edit');

        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(count($_FILES)>0){
				$path = './public/files/spkp_director_history/';
				if (!is_dir($path)) {
					mkdir($path);
				}
				$path .= $this->session->userdata('id');
				if (!is_dir($path)) {
					mkdir($path);
				}
				@unlink($path."/".$_FILES['filename']['name']);
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'xls|xlsx|doc|docx|pdf';
				$config['max_size']	= '999999';
				$config['overwrite'] = false;
				$this->load->library('upload', $config);
				$upload = $this->upload->do_upload('filename');
				if($upload === FALSE) {
					echo "ERROR_".$this->upload->display_errors();
				}else{
					$upload_data = $this->upload->data();
					if($this->spkp_director_history_model->doedit_file($id,$upload_data)){
						echo "OK_".$id;
					}else{
						echo "ERROR_Database Error";
					}
				}
			}else{
				if($this->spkp_director_history_model->doedit_file($id)){
					echo "OK_".$id;
				}else{
					echo "ERROR_Database Error";
				}
			}
		}
	}
	
	function download_file($id=0){
		$this->authentication->verify('spkp_director_history','edit');

		$data = $this->spkp_director_history_model->get_data_file($id); 

		echo $this->parser->parse("spkp_director_history/download_file",$data,true);
	}

	function dodownload_file($id=0){
		$this->authentication->verify('spkp_director_history','edit');

		$data = $this->spkp_director_history_model->get_data_file($id); 
		$path = './public/files/spkp_director_history/'.$this->session->userdata('id')."/".$data['filename'];

		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Transfer-Encoding: binary");
		header("Content-disposition: attachment; filename=" . $data['filename']);
		header("Content-type: application/octet-stream");
		readfile($path);
	}

	function dodelete_file($id=0){
		$this->authentication->verify('spkp_director_history','del');
		$data = $this->spkp_director_history_model->get_data_file($id); 
		$path = './public/files/spkp_director_history/'.$this->session->userdata('id')."/".$data['filename'];

		if($this->spkp_director_history_model->dodelete_file($id)){
			if(file_exists($path)){
				unlink($path);
			}

			echo "OK_".$id;
		}else{
			echo "ERROR_Database Error";
		}
	}

	function html_file($id){
		$this->authentication->verify('spkp_director_history','show');
		
		$data = $this->spkp_director_history_model->json_file($id);

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_director_history/html_file",$data);
	}

	function excel_file($id){
		$this->authentication->verify('spkp_director_history','show');

		$data = $this->spkp_director_history_model->json_file($id);

		$rows = $data[0]['Rows'];
		$data['title'] = "Daftar File Dokumen Direktur";

		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/profile_director_file.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_profile_director_file.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
	}

    // end
    
}

?>