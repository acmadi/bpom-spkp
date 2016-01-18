<?php
class Spkp_personalia_jadwal_kegiatan extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->load->model('spkp_personalia_jadwal_kegiatan_model');
        $this->load->model('admin_users_model');
        $this->load->model('location_model');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
	}
	
	function index($thn="",$bln=""){
		$this->authentication->verify('spkp_personalia_jadwal_kegiatan','show');
        
	    $data = array();
	    $holiday = array();
	    $cutibersama = array();
	    $liburnasional = array();
        $data['title'] = "Jadwal Kegiatan Pegawai";
        $data['thn'] = $thn!="" ? $thn : date("Y");
        $data['bln'] = $bln!="" ? $bln : date("m");
        $data['option_thn'] = "";
        $data['option_bln'] = "";
		for($i=(date("Y")+1);$i>=(date("Y")-10);$i--){
			$data['option_thn'] .= "<option value='$i' ".($data['thn']==$i ? "selected" : "").">$i</option>";
		}
		for($i=1;$i<=12;$i++){
			$data['option_bln'] .= "<option value='$i' ".($data['bln']==$i ? "selected" : "").">$i</option>";
		}
		for($i=1;$i<=31;$i++){
			$d = date("D",mktime(0,0,0,$data['bln'],$i,$data['thn']));

			if($data['bln']<10) $cbln="0".$data['bln'];
			else $cbln=$data['bln'];
			if($i<10) $ctgl="0".$i;
			else $ctgl=$i;
			
			$cb = $this->spkp_personalia_jadwal_kegiatan_model->chek_cutibersama($data['thn']."-".$cbln."-".$ctgl);
			if($cb!=""){
				if($cb=="cb") $cutibersama[] = "'".$i."'";
				else $liburnasional[] = "'".$i."'";
			}
			elseif($d=="Sun" || $d=="Sat"){
				$holiday[] = "'".$i."'";
			}
			if(checkdate($data['bln'],$i,$data['thn'])){
				$data['tgl_limit'] = $i;
			}
		}

		$data['cutibersama'] = implode($cutibersama,",");
		$data['liburnasional'] = implode($liburnasional,",");
		$data['holiday'] = implode($holiday,",");
		$data['tgl_width'] = floor(930/$data['tgl_limit']);
		$data['content'] = $this->parser->parse("spkp_personalia_jadwal_kegiatan/show",$data,true);

		$this->template->show($data,"home");
	}
    
    function json_jadwal($thn="",$bln=""){
        die(json_encode($this->spkp_personalia_jadwal_kegiatan_model->json_jadwal($thn,$bln)));
    }
    
    function json_kegiatan_jadwal($id="",$bln=""){
        die(json_encode($this->spkp_personalia_jadwal_kegiatan_model->json_kegiatan_jadwal($id,$bln)));
    }
    
    function json_kegiatan($thn=""){
        die(json_encode($this->spkp_personalia_jadwal_kegiatan_model->json_kegiatan($thn)));
    }
    
	function detail($thn="",$bln="",$id){
        $this->authentication->verify('spkp_personalia_jadwal_kegiatan','edit');
        
        $data = $this->spkp_personalia_jadwal_kegiatan_model->get_user($id);
		if(strlen($bln)<2)$bln="0".$bln;
		$data['add_permission']=$this->authentication->verify_check('spkp_personalia_jadwal_kegiatan','add');
        $data['title'] = "Cuti &raquo; Detail";
 		$data['uid']=$id;
 		$data['bulan']=$thn."-".$bln;
 		$data['thn']=$thn;
		$nip = $data['nip'];
 		$data['nip']=substr($nip,0,8)." ".substr($nip,8,6)." ".substr($nip,14,1)." ".substr($nip,15,3);
       
        echo $this->parser->parse("spkp_personalia_jadwal_kegiatan/form",$data,true);
    }
    

    function add_kegiatan($thn=""){
		$this->authentication->verify('spkp_personalia_jadwal_kegiatan','add');

		$data['action']	= "add_kegiatan";
		$data['bgcolor']	= "6699ff";
		$data['fontcolor']	= "ffffff";
		$data['thn']	= $thn!="" ? $thn : date("Y");

		echo $this->parser->parse("spkp_personalia_jadwal_kegiatan/form_kegiatan",$data,true);
	}

	function doadd_kegiatan(){
		$this->authentication->verify('spkp_personalia_jadwal_kegiatan','add');
        
        $this->form_validation->set_rules('kegiatan', 'Kegiatan', 'trim|required');
        $this->form_validation->set_rules('bgcolor', 'Warna Kotak', 'trim|required');
        $this->form_validation->set_rules('fontcolor', 'Warna Huruf', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			$id=$this->spkp_personalia_jadwal_kegiatan_model->doadd_kegiatan();
			if($id!=false){
				echo "OK_".$id;
			}else{
				echo "ERROR_Database Error";
			}
		}
	}
	
	function edit_kegiatan($id=0){
		$this->authentication->verify('spkp_personalia_jadwal_kegiatan','add');

		$data = $this->spkp_personalia_jadwal_kegiatan_model->get_data_kegiatan($id); 
		$data['action']="edit_kegiatan";

		echo $this->parser->parse("spkp_personalia_jadwal_kegiatan/form_kegiatan",$data,true);
	}

	function doedit_kegiatan($id=0)
	{
		$this->authentication->verify('spkp_personalia_jadwal_kegiatan','edit');

        $this->form_validation->set_rules('kegiatan', 'Kegiatan', 'trim|required');
        $this->form_validation->set_rules('bgcolor', 'Warna Kotak', 'trim|required');
        $this->form_validation->set_rules('fontcolor', 'Warna Huruf', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if($this->spkp_personalia_jadwal_kegiatan_model->doedit_kegiatan($id)){
				echo "OK_".$id;
			}else{
				echo "ERROR_Database Error";
			}
		}
	}
	
	function dodelete_kegiatan($id=0){
		$this->authentication->verify('spkp_personalia_jadwal_kegiatan','del');
		$data = $this->spkp_personalia_jadwal_kegiatan_model->get_data_row($id); 

		if($this->spkp_personalia_jadwal_kegiatan_model->dodelete_kegiatan($id)){
			echo "OK_".$id;
		}else{
			echo "ERROR_Database Error";
		}
	}

    function html_kegiatan(){
		$this->authentication->verify('spkp_personalia_jadwal_kegiatan','show');
		
		$data = $this->spkp_personalia_jadwal_kegiatan_model->json_kegiatan($id);

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_personalia_jadwal_kegiatan/html",$data);
	}
    
    function excel_kegiatan(){
		$this->authentication->verify('spkp_personalia_jadwal_kegiatan','show');

		$data = $this->spkp_personalia_jadwal_kegiatan_model->json_kegiatan($id);

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
		echo $output_file_name;
	}


    function add_jadwal($id="",$thn){
		$this->authentication->verify('spkp_personalia_jadwal_kegiatan','add');

		$data['action']	= "add_jadwal";
		$data['tgl']=date("Y-m-d");
		$data['id']=$id;
		$data['option_kegiatan'] = $this->spkp_personalia_jadwal_kegiatan_model->option_kegiatan($thn);
		echo $this->parser->parse("spkp_personalia_jadwal_kegiatan/form_jadwal",$data,true);
	}

	function doadd_jadwal($id){
		$this->authentication->verify('spkp_personalia_jadwal_kegiatan','add');
        
        $this->form_validation->set_rules('id_kegiatan', 'Kegiatan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			$res=$this->spkp_personalia_jadwal_kegiatan_model->doadd_jadwal($id);
			if($res==="Tanggal sudah digunakan"){
				echo "ERROR_".$res;
			}
			elseif($res){
				echo "OK_".$res;
			}
			else{
				echo "ERROR_Database Error";
			}
		}
	}
	
	function edit_jadwal($id=0,$tgl=""){
		$this->authentication->verify('spkp_personalia_jadwal_kegiatan','edit');

		$data = $this->spkp_personalia_jadwal_kegiatan_model->get_data_jadwal($id,$tgl); 
		$data['action']="edit_jadwal";
 		$data['id']=$id;
		$thn = explode("-",$tgl);
		$data['tanggal'] = $thn[2]."-".$thn[1]."-".$thn[0];

		$data['option_kegiatan'] = $this->spkp_personalia_jadwal_kegiatan_model->option_kegiatan($thn[0],$data['id_kegiatan']);

		echo $this->parser->parse("spkp_personalia_jadwal_kegiatan/form_jadwal",$data,true);
	}

	function doedit_jadwal($id=0,$tgl="")
	{
		$this->authentication->verify('spkp_personalia_jadwal_kegiatan','edit');

        $this->form_validation->set_rules('id_kegiatan', 'Kegiatan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if($this->spkp_personalia_jadwal_kegiatan_model->doedit_jadwal($id,$tgl)){
				echo "OK_".$id;
			}else{
				echo "ERROR_Database Error";
			}
		}
	}
	
	function dodel_jadwal($id=0,$tgl=""){
		$this->authentication->verify('spkp_personalia_jadwal_kegiatan','del');
		if($this->spkp_personalia_jadwal_kegiatan_model->dodel_jadwal($id,$tgl)){
			echo 1;
		}else{
			echo "Database Error";
		}
	}

    function html(){
		$this->authentication->verify('spkp_personalia_jadwal_kegiatan','show');
		
		$data = $this->spkp_personalia_jadwal_kegiatan_model->json_kegiatan($id);

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_personalia_jadwal_kegiatan/html",$data);
	}
    
    function excel(){
		$this->authentication->verify('spkp_personalia_jadwal_kegiatan','show');

		$data = $this->spkp_personalia_jadwal_kegiatan_model->json_kegiatan($id);

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
		echo $output_file_name;
	}}
