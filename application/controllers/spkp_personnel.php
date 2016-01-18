<?php
class Spkp_personnel extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->load->model('spkp_personnel_model');
        $this->load->model('admin_users_model');
        $this->load->model('location_model');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
	}
	
	function index(){
		$this->authentication->verify('spkp_personnel','show');
        
	    $data = array();
        $data['title'] = "Personalia";
		$data['content'] = $this->parser->parse("spkp_personnel/show",$data,true);

		$this->template->show($data,"home");
	}
    
    function json_user(){
        die(json_encode($this->spkp_personnel_model->json_user()));
    }
    
    function json_jabatan($id){
        die(json_encode($this->spkp_personnel_model->json_jabatan($id)));
    }
    
    function json_pangkat($id){
        die(json_encode($this->spkp_personnel_model->json_pangkat($id)));
    }
    
    function edit($id){
        $this->authentication->verify('spkp_personnel','edit');
        
        $data = $this->spkp_personnel_model->get_user($id);
        $data['title'] = "Personalia &raquo; Edit";
        $data['id'] = $id;
        $data['add_permission']=$this->authentication->verify_check('spkp_personnel','add');
        
        if($this->session->userdata('level')=="super administrator" || $this->session->userdata('id')==$id){
            $data['form_profile'] = $this->parser->parse("spkp_personnel/form",$data,true);
        }else{
            $data['form_profile'] = $this->parser->parse("spkp_personnel/form_lock",$data,true);
        }
        $data['form_jabatan'] = $this->parser->parse("spkp_personnel/form_jabatan",$data,true);
        $data['form_pangkat'] = $this->parser->parse("spkp_personnel/form_pangkat",$data,true);
        $data['form_pendidikan'] = $this->parser->parse("spkp_personnel/form_pendidikan",$data,true);
        $data['content'] = $this->parser->parse("spkp_personnel/show_edit",$data,true);
        
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
					$this->spkp_personnel_model->update_profile($id,1,$upload_data);
                    
					echo "1";
				}
			}else{
				$this->spkp_personnel_model->update_profile($id,2,"");
			    echo "1";
            }
		}
    }
    
    function load_form_profile($id){
       $this->authentication->verify('spkp_personnel','edit');

	   $data = $this->spkp_personnel_model->get_user($id);
	 
       echo $this->parser->parse("spkp_personnel/form",$data,true);        
    }
    
    function html(){
		$this->authentication->verify('spkp_personnel','show');
		
		$data = $this->spkp_personnel_model->json_user();

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_personnel/html",$data);
	}
    
    function html_jabatan($id){
		$this->authentication->verify('spkp_personnel','show');
		
		$data = $this->spkp_personnel_model->json_jabatan($id);

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_personnel/html_jabatan",$data);
	}
    
    function html_pangkat($id){
		$this->authentication->verify('spkp_personnel','show');
		
		$data = $this->spkp_personnel_model->json_pangkat($id);

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_personnel/html_pangkat",$data);
	}
    
    function excel(){
		$this->authentication->verify('spkp_personnel','show');

		$data = $this->spkp_personnel_model->json_user();
        
        $rows = $data[0]['Rows'];
		$data['title'] = "Daftar Sumber Daya Personalia";

		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/sumberdaya_personalia.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_sumberdaya_personalia.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
	}
    
    function excel_jabatan($id){
		$this->authentication->verify('spkp_personnel','show');

		$data = $this->spkp_personnel_model->json_jabatan($id);

		$rows = $data[0]['Rows'];
		$data['title'] = "Daftar Jabatan Pegawai";

		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/personalia_pegawai_jabatan.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_personalia_pegawai_jabatan.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
	}
    
    function excel_pangkat($id){
		$this->authentication->verify('spkp_personnel','show');

		$data = $this->spkp_personnel_model->json_pangkat($id);

		$rows = $data[0]['Rows'];
		$data['title'] = "Daftar Pangkat Pegawai";

		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/personalia_pegawai_pangkat.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_personalia_pegawai_pangkat.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
	}
    
    function add_jabatan(){
		$this->authentication->verify('spkp_personnel','add');

		$data['action']="add";

		echo $this->parser->parse("spkp_personnel/form_add_jabatan",$data,true);
	}
    
    function doadd_jabatan($id){
        $this->authentication->verify('spkp_personnel','add');

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
			$this->spkp_personnel_model->insert_jabatan($id);
			echo "1"; 
		}
    }
    
    function edit_jabatan($id,$id_jabatan){
        $this->authentication->verify('spkp_personnel','add');

		$data = $this->spkp_personnel_model->get_jabatan($id,$id_jabatan);
		$data['action']="edit";

		echo $this->parser->parse("spkp_personnel/form_add_jabatan",$data,true);
    }
    
    function doedit_jabatan(){
        $this->authentication->verify('spkp_personnel','edit');
        
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
			$this->spkp_personnel_model->update_jabatan();
			echo "1";
		}
    }
    
    function dodel_jabatan($id,$id_jabatan){
        $this->authentication->verify('spkp_personnel','del');

		if($this->spkp_personnel_model->delete_jabatan($id,$id_jabatan)){
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
		$this->authentication->verify('spkp_personnel','add');

		$data['action']="add";

		echo $this->parser->parse("spkp_personnel/form_add_pangkat",$data,true);
	}
    
    function doadd_pangkat($id){
        $this->authentication->verify('spkp_personnel','add');

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
			$this->spkp_personnel_model->insert_pangkat($id);
			echo "1"; 
		}
    }
    
    function edit_pangkat($id,$id_golruang){
        $this->authentication->verify('spkp_personnel','add');

		$data = $this->spkp_personnel_model->get_pangkat($id,$id_golruang);
		$data['action']="edit";

		echo $this->parser->parse("spkp_personnel/form_add_pangkat",$data,true);
    }
    
    function doedit_pangkat(){
        $this->authentication->verify('spkp_personnel','edit');
        
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
			$this->spkp_personnel_model->update_pangkat();
			echo "1";
		}
    }
    
    function dodel_pangkat($id,$id_golruang){
        $this->authentication->verify('spkp_personnel','del');

		if($this->spkp_personnel_model->delete_pangkat($id,$id_golruang)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
}
