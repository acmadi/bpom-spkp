<?php
class Spkp_pjas_a001 extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('spkp_pjas_a001_model');
        $this->load->helper('html');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
    }
    
    function index($propinsi="",$thn=""){
        $this->authentication->verify('spkp_pjas_a001','show');
        
        $data = array();
        $data['title'] = "Kegiatan Lintas Sektor dalam Rangka Aksi Nasional PJAS";
        
        if($propinsi=="" && $thn==""){
            $data['tab'] = "index";
        }else{
            $data['tab'] = "nonindex";
        }
        
        $data['propinsi'] = $propinsi!="" ? $propinsi : "31";
        $data['option_propinsi'] = "";
        
        $data_propinsi = $this->spkp_pjas_a001_model->get_load_propinsi();
        foreach($data_propinsi as $row){
            $data['option_propinsi'] .="<option value=".$row->id_propinsi." ".($row->id_propinsi==$data['propinsi'] ? "Selected" : "").">".ucwords(strtolower($row->nama_propinsi))."</option>";
        }
        
        $data['thn'] = $thn!="" ? $thn : date("Y");
        $data['option_thn'] = "";
        
        for($i=date("Y");$i>=(date("Y")-5);$i--){
			$data['option_thn'] .= "<option value='$i' ".($data['thn']==$i ? "selected" : "").">$i</option>";
		}
        
        $data['add_permission']=$this->authentication->verify_check('spkp_pjas_a001','add');
        $data['form_program'] = $this->parser->parse("spkp_pjas_a001/form_program",$data,true);
        $data['form_kegiatan'] = $this->parser->parse("spkp_pjas_a001/form_kegiatan",$data,true);
        $data['content'] = $this->parser->parse("spkp_pjas_a001/show",$data,true);

		$this->template->show($data,"home");
    }
    
    function json_program(){
        die(json_encode($this->spkp_pjas_a001_model->json_program()));
    }
    
    function json_kegiatan($propinsi,$thn){
        die(json_encode($this->spkp_pjas_a001_model->json_kegiatan($propinsi,$thn)));
    }
    
    function add_program(){
        $this->authentication->verify('spkp_pjas_a001','add');
		$data['action']="add";

		echo $this->parser->parse("spkp_pjas_a001/form_add_program",$data,true);
    }
    
    function add_kegiatan(){
        $this->authentication->verify('spkp_pjas_a001','add');
		$data['action']="add";

		echo $this->parser->parse("spkp_pjas_a001/form_add_kegiatan",$data,true);
    }
    
    function doadd_program(){
        $this->authentication->verify('spkp_pjas_a001','add');

		$this->form_validation->set_rules('strategi', 'Strategi', 'trim|required');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a001_model->insert_program();
			echo "1"; 
		}
    }
    
    function doadd_kegiatan(){
        $this->authentication->verify('spkp_pjas_a001','add');
        
        $this->form_validation->set_rules('propinsi', 'Propinsi', 'trim|required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');
		$this->form_validation->set_rules('program', 'Program', 'trim|required');
        $this->form_validation->set_rules('nama', 'Kegiatan', 'trim|required');
        $this->form_validation->set_rules('instansi', 'Instansi', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a001_model->insert_kegiatan();
			echo "1"; 
		}
    }
    
    function edit_program($id){
        $this->authentication->verify('spkp_pjas_a001','add');

		$data = $this->spkp_pjas_a001_model->get_data_row($id);
		$data['action']="edit";

		echo $this->parser->parse("spkp_pjas_a001/form_add_program",$data,true);
    }
    
    function edit_kegiatan($id){
        $this->authentication->verify('spkp_pjas_a001','add');

		$data = $this->spkp_pjas_a001_model->get_data_kegiatan($id);
		$data['action']="edit";

		echo $this->parser->parse("spkp_pjas_a001/form_add_kegiatan",$data,true);
    }
    
    function doedit_program(){
        $this->authentication->verify('spkp_pjas_a001','edit');
        
        $this->form_validation->set_rules('strategi', 'Strategi', 'trim|required');
        $this->form_validation->set_rules('nama', 'Kegiatan', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a001_model->update_program();
			echo "1";
		}
    }
    
    function doedit_kegiatan(){
        $this->authentication->verify('spkp_pjas_a001','edit');
        
        $this->form_validation->set_rules('propinsi', 'Propinsi', 'trim|required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');
        $this->form_validation->set_rules('program', 'Program', 'trim|required');
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('instansi', 'Instansi', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a001_model->update_kegiatan();
			echo "1";
		}
    }
    
    function dodel_program($id){
        $this->authentication->verify('spkp_pjas_a001','del');

		if($this->spkp_pjas_a001_model->delete_program($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function dodel_kegiatan($id){
        $this->authentication->verify('spkp_pjas_a001','del');

		if($this->spkp_pjas_a001_model->delete_kegiatan($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function html_program(){
        $this->authentication->verify('spkp_pjas_a001','show');
		
		$data = $this->spkp_pjas_a001_model->json_program();

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_pjas_a001/html_program",$data);
    }
    
    function html_kegiatan($propinsi,$thn){
        $this->authentication->verify('spkp_pjas_a001','show');
		
		$data = $this->spkp_pjas_a001_model->json_kegiatan($propinsi,$thn);

		$data['Rows'] = $data[0]['Rows'];
        $data['propinsi'] = $propinsi;
        $data['nama_propinsi'] = $this->spkp_pjas_a001_model->get_propinsi($propinsi);
        $data['tahun'] = $thn;
        
		$this->parser->parse("spkp_pjas_a001/html_kegiatan",$data);
    }
    
    function excel_program(){
        $this->authentication->verify('spkp_pjas_a001','show');

		$data = $this->spkp_pjas_a001_model->json_program();

		$rows = $data[0]['Rows'];
		$data['title'] = "Daftar Program Lintas Sektor Aksi Nasional";

		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/spkp_pjas_program_a001.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_spkp_pjas_program_a001.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		// echo $output_file_name;
        echo '../public/doc_xls_export/report_spkp_pjas_program_a001.xlsx';

    }
    
    function word_kegiatan($propinsi,$thn){
        $this->authentication->verify('spkp_pjas_a001','show');

		$data = array();
        $strategi = $this->spkp_pjas_a001_model->get_export_data($thn,$propinsi);
       
        $data['title'] = "Form  A001. Matriks kegiatan Lintas Sektor dalam Rangka Aksi Nasional PJAS Tahun ".$thn." di Provinsi ".$this->spkp_pjas_a001_model->get_propinsi($propinsi);
        $arr_abjad = array("","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
        $x = 1;
        foreach($strategi as $row_strategi){
            $strategi = ($row_strategi->nama_strategi!="" ? $row_strategi->nama_strategi : "-");
            $program = ($row_strategi->nama_program!="" ? $row_strategi->nama_program : "-");
            $kegiatan = ($row_strategi->nama !="" ? $row_strategi->nama : "-");
            $instansi = ($row_strategi->instansi!="" ? $row_strategi->instansi : "-");
            $indikator = ($row_strategi->indikator!="" ? $row_strategi->indikator : "-");
            $target = ($row_strategi->target!="" ? $row_strategi->target : "-");
            $waktu = ($row_strategi->waktu!="" ? $row_strategi->waktu : "-");
            $dana = ($row_strategi->sumber_dana!="" ? $row_strategi->sumber_dana :"-");
            
            $main[] = array('strategi'=>$strategi,'program'=>$program,'kegiatan'=>$kegiatan,'instansi'=>$instansi,'indikator'=>$indikator,'target'=>$target,'waktu'=>$waktu,'sumber_dana'=>$dana);
            $x++;
        }
        
        //print_r($main);
            
		$path = dirname(__FILE__).'/../../public/doc_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/spkp_pjas_kegiatan_a001_b.docx';
		$TBS->LoadTemplate($template);
        
     	$TBS->MergeBlock('main', $main);
		$output_file_name = $path.'export/report_spkp_pjas_kegiatan_a001.docx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		// echo $output_file_name;
        echo '../public/doc_xls_export/report_spkp_pjas_kegiatan_a001.docx';
        
    }
    
    
}
?>