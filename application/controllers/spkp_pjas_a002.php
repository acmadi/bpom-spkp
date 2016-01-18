<?php
class Spkp_pjas_a002 extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->load->model('spkp_pjas_a002_model');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
	}
	
	function index(){
		$this->authentication->verify('spkp_pjas_a002','show');
        
	    $data = array();
		$data['add_permission']=$this->authentication->verify_check('spkp_pjas_a002','add');
        $data['title'] = "Form A002 Evaluasi dan Pelaporan Pertemuan 'Penguatan Komitmen Lintas Sektor Strategis dalam Rangka Aksi Nasional PJAS di Daerah'";
		$data['content'] = $this->parser->parse("spkp_pjas_a002/show",$data,true);

		$this->template->show($data,"home");
	}
    
    function json_judul(){
        die(json_encode($this->spkp_pjas_a002_model->json_judul()));
    }
	
	function json_narasumber($id){
		die(json_encode($this->spkp_pjas_a002_model->json_narasumber($id)));
	}
	
	function json_peserta($id){
		die(json_encode($this->spkp_pjas_a002_model->json_peserta($id)));
    }
	
    function add(){
        $this->authentication->verify('spkp_pjas_a002','add');
		$data['action']="add";
		$data['title'] = "Pelaporan judul";
        echo $this->parser->parse("spkp_pjas_a002/form_judul",$data,true);
    }
	
	function edit($id){
        $this->authentication->verify('spkp_pjas_a002','edit');
		
        $data = $this->spkp_pjas_a002_model->get_judul($id);
		$data['action']="edit";
        $data['title'] = "Evaluasi dan Pelaporan &raquo; Edit";
		$data['id'] = $id;
		$data['add_permission']=$this->authentication->verify_check('spkp_pjas_a002','edit');
		
		$data['form_edit'] = $this->parser->parse("spkp_pjas_a002/form_edit",$data,true);
        $data['show_narasumber'] = $this->parser->parse("spkp_pjas_a002/show_narasumber",$data,true);
        $data['show_peserta'] = $this->parser->parse("spkp_pjas_a002/show_peserta",$data,true);
        $data['content'] = $this->parser->parse("spkp_pjas_a002/show_edit",$data,true);
        
        $this->template->show($data,"home");
    }
	
	function doadd(){
        $this->authentication->verify('spkp_pjas_a002','add');
        
		$this->form_validation->set_rules('id','ID','trim|required');
        $this->form_validation->set_rules('judul','Judul','trim|required');
        $this->form_validation->set_rules('tempat','Tanggal','trim|required');
		
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a002_model->insert_judul();
        }
    }
	
    function doedit_judul($id){
        $this->authentication->verify('spkp_pjas_a002','edit');
		
        $this->form_validation->set_rules('id','ID','trim|required');
        $this->form_validation->set_rules('judul','Judul','trim|required');
        $this->form_validation->set_rules('tempat','Tanggal','trim|required');
		
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a002_model->update_judul($id);
			echo "1";
        }
    }
	
	function load_form_edit($id){
	   $this->authentication->verify('spkp_pjas_a002','add');

	   $data = $this->spkp_pjas_a002_model->get_judul($id);
	   $data['action']='edit';
	   
       echo $this->parser->parse("spkp_pjas_a002/form_edit",$data,true);
	}
	
	function del($id){
		$this->authentication->verify('spkp_pjas_a002','del');

		if($this->spkp_pjas_a002_model->delete_judul($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
    
    function load_show_edit(){
       $this->authentication->verify('spkp_pjas_a002','add');

	   $data = $this->spkp_pjas_a002_model->get_judul();
	 
       echo $this->parser->parse("spkp_pjas_a002/form",$data,true);
    }
    
	function add_narasumber(){
		$this->authentication->verify('spkp_pjas_a002','add');

		$data['action']="add";

		echo $this->parser->parse("spkp_pjas_a002/form_narasumber",$data,true);
	}
    
    function doadd_narasumber($id){
        $this->authentication->verify('spkp_pjas_a002','add');

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('materi', 'Materi', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a002_model->insert_narasumber($id);
			echo "1";
		}
    }
    
    function edit_narasumber($id,$id_narasumber){
        $this->authentication->verify('spkp_pjas_a002','add');

		$data = $this->spkp_pjas_a002_model->get_narasumber($id,$id_narasumber);
		$data['action']="edit";

		echo $this->parser->parse("spkp_pjas_a002/form_narasumber",$data,true);
    }
    
    function doedit_narasumber(){
        $this->authentication->verify('spkp_pjas_a002','edit');
        
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('materi', 'Materi', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a002_model->update_narasumber();
			echo "1";
		}
    }
    
    function dodel_narasumber($id,$id_narasumber){
        $this->authentication->verify('spkp_pjas_a002','del');

		if($this->spkp_pjas_a002_model->delete_narasumber($id,$id_narasumber)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
       
    function add_peserta(){
		$this->authentication->verify('spkp_pjas_a002','add');

		$data['action']="add";

		echo $this->parser->parse("spkp_pjas_a002/form_peserta",$data,true);
	}
    
    function doadd_peserta($id){
        $this->authentication->verify('spkp_pjas_a002','add');

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('instansi', 'Instansi', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a002_model->insert_peserta($id);
			echo "1"; 
		}
    }
    
    function edit_peserta($id,$id_peserta){
        $this->authentication->verify('spkp_pjas_a002','add');

		$data = $this->spkp_pjas_a002_model->get_peserta($id,$id_peserta);
		$data['action']="edit";

		echo $this->parser->parse("spkp_pjas_a002/form_peserta",$data,true);
    }
    
    function doedit_peserta(){
        $this->authentication->verify('spkp_pjas_a002','edit');
        
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('instansi', 'Instansi', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a002_model->update_peserta();
			echo "1";
		}
    }
    
    function dodel_peserta($id,$id_peserta){
        $this->authentication->verify('spkp_pjas_a002','del');

		if($this->spkp_pjas_a002_model->delete_peserta($id,$id_peserta)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
	
	function export($id){
        $this->authentication->verify('spkp_pjas_a002','show');
		
		$data = $this->spkp_pjas_a002_model->json_narasumber($id);
		$data2 = $this->spkp_pjas_a002_model->json_peserta($id);

		$rows = $data[0]['Rows'];
		$rows2 = $data2[0]['Rows'];
		$data['title'] = "Form A002. Evaluasi dan Pelaporan judul 'Penguatan Komitmen Lintas Sektor Strategis dalam Rangka Aksi Nasional PJAS di Daerah'";
		
		$data['judul'] = $this->input->post('judul');
		$data['tempat'] = $this->input->post('tempat');
		
		$data['tgl'] = substr($this->input->post('tanggal'),8,2);
		$angkabln=array('01','02','03','04','05','06','07','08','09','10','11','12');
		$indobln=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus',
		'September','Oktober','November','Desember');
		$data['bln'] = str_ireplace($angkabln,$indobln,(substr($this->input->post('tanggal'),5,2)));
		$data['thn'] = substr($this->input->post('tanggal'),0,4);
		
		$data['hasil'] = $this->input->post('hasil');
		
		$val= $this->spkp_pjas_a002_model->count_peserta($id);
		
		foreach($val as $value){
			$data['jumlah']=$value->jumlah;
		}
		
		$data['nama'] = $this->input->post('penanggungjawab_nama');
		$data['nip'] = $this->input->post('penanggungjawab_nip');
		$data['tmpt'] = $this->input->post('tmpt');
		
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data &$data2;
		$template = $path.'templates/spkp_pjas_a002.docx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data',$rows);
		$TBS->MergeBlock('data2',$rows2);
		$output_file_name = $path.'export/report_spkp_pjas_a002.docx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
    }
	
}
