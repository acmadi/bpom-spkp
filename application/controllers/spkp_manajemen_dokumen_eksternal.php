<?php
class Spkp_manajemen_dokumen_eksternal extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->helper('html');
        $this->load->model('spkp_manajemen_dokumen_eksternal_model');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
    }
    
    function index(){
        $this->authentication->verify('spkp_manajemen_dokumen_eksternal','show');
        
	    $data = array();
        $data['add_permission']=$this->authentication->verify_check('spkp_manajemen_dokumen_eksternal','add');
        $data['content'] = $this->parser->parse("spkp_manajemen_dokumen_eksternal/show",$data,true);
        
		$this->template->show($data,"home");
    }
    
    function json_dokumen(){
        die(json_encode($this->spkp_manajemen_dokumen_eksternal_model->json_dokumen()));
    }
    
    function add(){
        $this->authentication->verify('spkp_manajemen_dokumen_eksternal','add');
        
        $data = array();
 		$data['action']="add";

		echo $this->parser->parse("spkp_manajemen_dokumen_eksternal/form",$data,true);
    }
    
    function doadd(){
        $this->authentication->verify('spkp_manajemen_dokumen_eksternal','add');
        
        $this->form_validation->set_rules('idb', 'Nomor Buku', 'trim|required');
        $this->form_validation->set_rules('tipe', 'No Tipe', 'trim|required');
        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');
        $this->form_validation->set_rules('pengarang', 'Pengarang', 'trim|required');
        $this->form_validation->set_rules('penerbit', 'Penerbit', 'trim|required');
        $this->form_validation->set_rules('tempat', 'Tempat', 'trim');
        $this->form_validation->set_rules('lama', 'Lama', 'trim');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
		    if($this->spkp_manajemen_dokumen_eksternal_model->cek_id()>0){
		      echo "0";
		    }else{
		      $this->spkp_manajemen_dokumen_eksternal_model->insert();
              echo "1";
		    } 
		}
    }
    
    function edit($id,$no){
        $this->authentication->verify('spkp_manajemen_dokumen_eksternal','edit');
        
        $data = $this->spkp_manajemen_dokumen_eksternal_model->get_data($id,$this->get_no_format($no));
        $data['action'] = "edit";
        
		echo $this->parser->parse("spkp_manajemen_dokumen_eksternal/form",$data,true);
    }
    
    function doedit($id,$no){
        $this->authentication->verify('spkp_manajemen_dokumen_eksternal','edit');
        
        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');
        $this->form_validation->set_rules('pengarang', 'Pengarang', 'trim|required');
        $this->form_validation->set_rules('penerbit', 'Penerbit', 'trim|required');
        $this->form_validation->set_rules('tempat', 'Tempat', 'trim');
        $this->form_validation->set_rules('lama', 'Lama', 'trim');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_manajemen_dokumen_eksternal_model->update($id,$no);
            echo "1";
		}
    }
    
    function dodelete($id,$no){
        $this->authentication->verify('spkp_manajemen_dokumen_eksternal','del');

		if($this->spkp_manajemen_dokumen_eksternal_model->delete($id,$this->get_no_format($no))){
			echo "1";
		}else{
			echo "0";
		}
    }
    
    function get_no_format($no){
        if($no<10){
            $frmt = "000".$no;
        }else if($no<100){
            $frmt = "00".$no;
        }else if($no<1000){
            $frmt = "0".$no;
        }else if($no>=1000){
            $frmt = $no;
        }
        
        return $frmt;
    }
    
    function html(){
		$this->authentication->verify('spkp_manajemen_dokumen_eksternal','show');
		
		$data = $this->spkp_manajemen_dokumen_eksternal_model->json_dokumen();

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_manajemen_dokumen_eksternal/html",$data);
	}
    
    function excel(){
        $this->authentication->verify('spkp_manajemen_dokumen_eksternal','show');

		$data = $this->spkp_manajemen_dokumen_eksternal_model->json_dokumen();

		$rows = $data[0]['Rows'];
		$data['title'] = "QMS DOKUMEN EKSTERNAL";
        $data['title_down'] = "DIREKTORAT SURVEILAN DAN PENYULUHAN KEAMANAN PANGAN";
        
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/qms_manajemen_dokumen_eksternal.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_qms_manajemen_dokumen_eksternal.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		// echo $output_file_name;
        echo '../public/doc_xls_export/report_qms_manajemen_dokumen_eksternal.xlsx';
        
    }
}
?>