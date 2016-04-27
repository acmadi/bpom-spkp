<?php
class Spkp_personalia_cuti extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->load->model('spkp_personalia_cuti_model');
        $this->load->model('admin_users_model');
        $this->load->model('location_model');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
	}
	
	function index(){
		$this->authentication->verify('spkp_personalia_cuti','show');
        
	    $data = array();
        $data['title'] = "Cuti Pegawai";
		$data['content'] = $this->parser->parse("spkp_personalia_cuti/show",$data,true);

		$this->template->show($data,"home");
	}
    
    function json_user(){
        die(json_encode($this->spkp_personalia_cuti_model->json_user()));
    }
    
    function json_cutibersama(){
        die(json_encode($this->spkp_personalia_cuti_model->json_cutibersama()));
    }
    
	function json_sasaran($id){
		die(json_encode($this->spkp_personalia_cuti_model->json_sasaran($id)));
	}

	function detail($id){
        $this->authentication->verify('spkp_personalia_cuti','edit');
        
        $data = $this->spkp_personalia_cuti_model->get_user($id);
		$data['add_permission']=$this->authentication->verify_check('spkp_personalia_cuti','add');
        $data['title'] = "Cuti &raquo; Detail";
 		$data['uid']=$id;
		$nip = $data['nip'];
 		$data['nip']=substr($nip,0,8)." ".substr($nip,8,6)." ".substr($nip,14,1)." ".substr($nip,15,3);
       
        $data['content'] = $this->parser->parse("spkp_personalia_cuti/form",$data,true);
        
        $this->template->show($data,"home");
    }
    
    function add(){
		$this->authentication->verify('spkp_personalia_cuti','add');

		$data['action']="add";
		$data['tgl']=date("Y-m-d");

		echo $this->parser->parse("spkp_personalia_cuti/form_popup",$data,true);
	}

	function doadd(){
		$this->authentication->verify('spkp_personalia_cuti','add');
        
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			$id=$this->spkp_personalia_cuti_model->doadd();
			if($id!=false){
				echo "OK_".$id;
			}else{
				echo "ERROR_Database Error";
			}
		}
	}
	
	function edit($id=0){
		$this->authentication->verify('spkp_personalia_cuti','add');

		$data = $this->spkp_personalia_cuti_model->get_data_row($id); 
		$data['action']="edit";

		echo $this->parser->parse("spkp_personalia_cuti/form_popup",$data,true);
	}

	function doedit($id=0)
	{
		$this->authentication->verify('spkp_personalia_cuti','edit');

        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if($this->spkp_personalia_cuti_model->doedit($id)){
				echo "OK_".$id;
			}else{
				echo "ERROR_Database Error";
			}
		}
	}
	
	function dodelete($id=0){
		$this->authentication->verify('spkp_personalia_cuti','del');
		$data = $this->spkp_personalia_cuti_model->get_data_row($id); 

		if($this->spkp_personalia_cuti_model->dodelete($id)){
			echo "OK_".$id;
		}else{
			echo "ERROR_Database Error";
		}
	}

    function html($id){
		$this->authentication->verify('spkp_personalia_cuti','show');
		
		$data = $this->spkp_personalia_cuti_model->json_sasaran($id);

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_personalia_cuti/html",$data);
	}
    
    function excel(){
		$this->authentication->verify('spkp_personalia_cuti','show');

		$data = $this->spkp_personalia_cuti_model->json_cutibersama();

		$rows = $data[0]['Rows'];
		$data['title'] = "KP4 Pegawai";

		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/personalia_cuti.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_personalia_cuti.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		// echo $output_file_name;
		echo '../public/doc_xls_export/report_personalia_cuti.xlsx';

	}
}
