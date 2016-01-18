<?php
class Spkp_pjas_a008 extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('spkp_pjas_a008_model');
        $this->load->helper('html');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
    }
    
    function index(){
        $this->authentication->verify('spkp_pjas_a008','show');
        
        $data = array();
        $data['title'] = "Pelaporan Pelaksanaan Audit PBKP-KS";
        
        $data['add_permission']=$this->authentication->verify_check('spkp_pjas_a008','add');
        $data['content'] = $this->parser->parse("spkp_pjas_a008/show",$data,true);
        $this->template->show($data,"home");
    }
    
    function json_form(){
        die(json_encode($this->spkp_pjas_a008_model->json_form()));
    }
    
    function add_form(){
        $this->authentication->verify('spkp_pjas_a008','add');
		$data['action']="add";

		echo $this->parser->parse("spkp_pjas_a008/form_add",$data,true);
    }
    
    function doadd_form(){
        $this->authentication->verify('spkp_pjas_a008','add');

		$this->form_validation->set_rules('mengetahui_nama', 'Mengetahui Nama', 'trim|required');
        $this->form_validation->set_rules('pelapor_nama', 'Pelapor Nama', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a008_model->insert_form();
		}
    }
    
    function dodel_form($id){
        $this->authentication->verify('spkp_pjas_a008','del');

		if($this->spkp_pjas_a008_model->delete_form($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function doedit_form($id){
        $this->authentication->verify('spkp_pjas_a008','edit');
        
        $this->form_validation->set_rules('mengetahui_nama', 'Mengetahui Nama', 'trim|required');
        $this->form_validation->set_rules('pelapor_nama', 'Pelapor Nama', 'trim|required');
		
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a008_model->update_form($id);
			echo "1"; 
		}
    }
    
    function load_form($id){
        $this->authentication->verify('spkp_pjas_a008','edit');
		$data = $this->spkp_pjas_a008_model->get_form($id);
        
		echo $this->parser->parse("spkp_pjas_a008/form",$data,true);
    }
    
    function edit($id){
        $this->authentication->verify('spkp_pjas_a008','add');
        
        if($this->spkp_pjas_a008_model->check_form($id)>0){
            
            $data = $this->spkp_pjas_a008_model->get_form($id);
            $data['title'] = "Pelaporan Pelaksanaan Audit PBKP-KS &raquo; Edit";
            $data['id'] = $id;
            
            $data['add_permission']=$this->authentication->verify_check('spkp_pjas_a008','add');
            $data['form'] = $this->parser->parse("spkp_pjas_a008/form",$data,true);
            $data['form_auditor'] = $this->parser->parse("spkp_pjas_a008/form_auditor",$data,true);
            $data['form_sdmi'] = $this->parser->parse("spkp_pjas_a008/form_sdmi",$data,true);
            $data['content'] = $this->parser->parse("spkp_pjas_a008/show_edit",$data,true);
            $this->template->show($data,"home");
            
        }else{
            return false;
        }
    }
    
    function json_auditor($id){
        die(json_encode($this->spkp_pjas_a008_model->json_auditor($id)));
    }
    
    function add_auditor($id){
        $this->authentication->verify('spkp_pjas_a008','add');
		$data['action']="add";
        $data['id'] = $id;
        
		echo $this->parser->parse("spkp_pjas_a008/form_add_auditor",$data,true);
    }
    
    function doadd_auditor($id){
        $this->authentication->verify('spkp_pjas_a008','add');

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('nip', 'NIP', 'trim|required');
        $this->form_validation->set_rules('gol', 'Golongan', 'trim|required');
     //   $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a008_model->insert_auditor($id);
			echo "1"; 
		}
    }
    
    function edit_auditor($id,$auditor){
        $this->authentication->verify('spkp_pjas_a008','edit');
        
        $data = $this->spkp_pjas_a008_model->get_auditor($id,$auditor);
		$data['action']="edit";
        $data['id'] = $id;
        
		echo $this->parser->parse("spkp_pjas_a008/form_add_auditor",$data,true);
    }
    
    function doedit_auditor($id){
        $this->authentication->verify('spkp_pjas_a008','edit');

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('nip', 'NIP', 'trim|required');
        $this->form_validation->set_rules('gol', 'Golongan', 'trim|required');
       // $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a008_model->update_auditor($id);
			echo "1"; 
		}
    }
    
    function dodel_auditor($id,$auditor){
        $this->authentication->verify('spkp_pjas_a008','del');

		if($this->spkp_pjas_a008_model->delete_auditor($id,$auditor)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function json_sdmi($id){
        die(json_encode($this->spkp_pjas_a008_model->json_sdmi($id)));
    }
    
    function add_sdmi($id){
        $this->authentication->verify('spkp_pjas_a008','add');
		$data['action']="add";
        $data['id'] = $id;
        
		echo $this->parser->parse("spkp_pjas_a008/form_add_sdmi",$data,true);
    }
    
    function doadd_sdmi($id){
        $this->authentication->verify('spkp_pjas_a008','add');

		$this->form_validation->set_rules('nama_sekolah', 'Nama Sekolah', 'trim|required');
        $this->form_validation->set_rules('kepsek_nama', 'Nama Kepala Sekolah', 'trim|required');
        $this->form_validation->set_rules('kepsek_nip', 'NIP Kepala Sekolah', 'trim|required');
        $this->form_validation->set_rules('kode_pbkpks', 'Kode PBKP-KS', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a008_model->insert_sdmi($id);
			echo "1"; 
		}
    }
    
    function edit_sdmi($id,$sdmi){
        $this->authentication->verify('spkp_pjas_a008','edit');
        
        $data = $this->spkp_pjas_a008_model->get_sdmi($id,$sdmi);
		$data['action']="edit";
        $data['id'] = $id;
        
		echo $this->parser->parse("spkp_pjas_a008/form_add_sdmi",$data,true);
    }
    
    function doedit_sdmi($id){
        $this->authentication->verify('spkp_pjas_a008','edit');

		$this->form_validation->set_rules('nama_sekolah', 'Nama Sekolah', 'trim|required');
        $this->form_validation->set_rules('kepsek_nama', 'Nama Kepala Sekolah', 'trim|required');
        $this->form_validation->set_rules('kepsek_nip', 'NIP Kepala Sekolah', 'trim|required');
        $this->form_validation->set_rules('kode_pbkpks', 'Kode PBKP-KS', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a008_model->update_sdmi($id);
			echo "1"; 
		}
    }
    
    function dodel_sdmi($id,$sdmi){
        $this->authentication->verify('spkp_pjas_a008','del');

		if($this->spkp_pjas_a008_model->delete_sdmi($id,$sdmi)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function export($id){
        $this->authentication->verify('spkp_pjas_a008','show');

		$data = $this->spkp_pjas_a008_model->get_form($id);
        $data['title'] = "Form A008. Pelaporan Pelaksanaan Audit PBKP-KS";
        $data['title_up'] = "FORMAT PELAPORAN *)";
        $data['title_down'] = "PELAKSANAAN AUDIT PBKP-KS";
        $data['tanggal_form'] = $this->authentication->indonesian_date($data['tanggal'],'l, j F Y','');
        
        $data_audit = $this->spkp_pjas_a008_model->get_all_auditor($id);
        $x=1;
        foreach($data_audit as $row_a){
            $audit[] = array('no'=>$x,'tanggal'=>$row_a->tanggal,'nama'=>$row_a->nama,'nip'=>$row_a->nip,'gol'=>$row_a->gol,'jabatan'=>$row_a->jabatan,'instansi'=>$row_a->instansi);
            $x++;
        }
        
        
        $data_sdmi = $this->spkp_pjas_a008_model->get_all_sdmi($id);
        $y=1;
        foreach($data_sdmi as $row){
            $sdmi[] = array('no'=>$y,'nama_sekolah'=>$row->nama_sekolah,'kepsek_nama'=>$row->kepsek_nama,'kepsek_nip'=>$row->kepsek_nip,'alamat'=>$row->alamat,'nilai'=>$row->nilai,'temuan'=>$row->temuan,'kode_pbkpks'=>$row->kode_pbkpks);
            $y++;
        }
        
        //print_r($audit);
        //print_r($sdmi);
          
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/spkp_pjas_a008.docx';
		$TBS->LoadTemplate($template);
        
        $TBS->MergeBlock('audit', $audit);
     	$TBS->MergeBlock('sdmi', $sdmi);
		$output_file_name = $path.'export/report_spkp_pjas_a008.docx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
    }
}
?>