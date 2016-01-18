<?php
class Spkp_absen_tunjangan extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->load->model('spkp_absen_tunjangan_model');
        $this->load->model('admin_users_model');
        $this->load->model('location_model');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
		require_once(APPPATH.'third_party/excel/oleread.inc');
		require_once(APPPATH.'third_party/excel/reader.php');
	}
	
	function index($thn="",$bln=""){
		$this->authentication->verify('spkp_absen_tunjangan','show');
        
	    $data = array();
        $data['title'] = "Absensi - Tunjangan Kinerja";
		$data['thn'] = $thn!="" ? $thn : date("Y");
		$data['bln'] = $bln!="" ? $bln : date("m");
        $data['option_thn'] = "";
        $data['option_bln'] = "";

		for($i=date("Y");$i>=(date("Y")-5);$i--){
			$data['option_thn'] .= "<option value='$i' ".($data['thn']==$i ? "selected" : "").">$i</option>";
		}
		for($i=1;$i<=12;$i++){
			$data['option_bln'] .= "<option value='$i' ".($data['bln']==$i ? "selected" : "").">$i</option>";
		}

		$data['content'] = $this->parser->parse("spkp_absen_tunjangan/show",$data,true);

		$this->template->show($data,"home");
	}
    
    function json_user($thn="",$bln=""){
        die(json_encode($this->spkp_absen_tunjangan_model->json_user($thn,$bln)));
    }
    
    function json_absen($id,$thn="",$bln=""){
        die(json_encode($this->spkp_absen_tunjangan_model->json_absen($id,$thn,$bln)));
    }
    
    function edit($id,$thn="",$bln=""){
        $this->authentication->verify('spkp_absen_tunjangan','edit');
        
        $data = $this->spkp_absen_tunjangan_model->get_user($id);
        $data['title'] = "Tunjangan Kinerja &raquo; Detail";
        $data['id'] = $id;
        $data['add_permission']=$this->authentication->verify_check('spkp_absen_tunjangan','add');
		$data['thn'] = $thn!="" ? $thn : date("Y");
		$data['bln'] = $bln!="" ? $bln : date("m");
        $data['potong'] = $this->spkp_absen_tunjangan_model->get_potong($id,$data['thn'],$data['bln']);
        $data['option_thn'] = "";
        $data['option_bln'] = "";

		for($i=date("Y");$i>=(date("Y")-5);$i--){
			$data['option_thn'] .= "<option value='$i' ".($data['thn']==$i ? "selected" : "").">$i</option>";
		}
		for($i=1;$i<=12;$i++){
			$data['option_bln'] .= "<option value='$i' ".($data['bln']==$i ? "selected" : "").">$i</option>";
		}
        
        if($this->session->userdata('level')=="super administrator" || $this->session->userdata('id')==$id){
            $data['form'] = $this->parser->parse("spkp_absen_tunjangan/form",$data,true);
        }else{
            $data['form'] = $this->parser->parse("spkp_absen_tunjangan/form_lock",$data,true);
        }

		$data['content'] = $this->parser->parse("spkp_absen_tunjangan/show_edit",$data,true);
        
        $this->template->show($data,"home");
    }
    
    
    function html($thn="",$bln=""){
		$this->authentication->verify('spkp_absen_tunjangan','show');
		
		$data = $this->spkp_absen_tunjangan_model->json_user($thn,$bln);

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_absen_tunjangan/html",$data);
	}
    
    function excel($thn="",$bln=""){
		$this->authentication->verify('spkp_absen_tunjangan','show');

		$data = $this->spkp_absen_tunjangan_model->json_user($thn,$bln);
        
        $rows = $data[0]['Rows'];
		$data['title'] = "Absensi - Tunjangan Kinerja ".$thn."-".$bln;

		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/absensi_tukin_rekap.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_absensi_tukin_rekap.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
	}
    
    function excel_tukin($id,$thn="",$bln=""){
		$this->authentication->verify('spkp_absen_tunjangan','show');

		$data = $this->spkp_absen_tunjangan_model->json_absen($id,$thn,$bln);
        
        $rows = $data[0]['Rows'];
		$data['title'] = "Absensi - Tunjangan Kinerja ".$thn."-".$bln;

		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/absensi_tukin.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_absensi_tukin.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
	}
    
    
    function add($id,$thn="",$bln=""){
		$this->authentication->verify('spkp_absen_tunjangan','add');

        $data = $this->spkp_absen_tunjangan_model->get_user($id);
		$data['action']="add";
		$data['thn'] = $thn!="" ? $thn : date("Y");
		$data['bln'] = $bln!="" ? $bln : date("m");

		echo $this->parser->parse("spkp_absen_tunjangan/form",$data,true);
	}
    
    function doadd($id,$thn="",$bln=""){
        $this->authentication->verify('spkp_absen_tunjangan','add');

		if(count($_FILES)>0){
			$path = './public/files/spkp_absen_tunjangan';
			if (!is_dir($path)) {
				mkdir($path);
			}
			$path .= '/'.$id;
			if (!is_dir($path)) {
				mkdir($path);
			}
			$path .= '/'.$thn;
			if (!is_dir($path)) {
				mkdir($path);
			}
			$path .= '/'.$bln;
			if (!is_dir($path)) {
				mkdir($path);
			}
			@unlink($path."/".$_FILES['filename']['name']);
			$config['upload_path'] = $path;
			$config['allowed_types'] = '*';
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$upload = $this->upload->do_upload('filename');
			$upload_data = $this->upload->data();
			if($upload === FALSE) {
				echo $this->upload->display_errors()."<br>";
			}else{
				$OLERead	= new OLERead();
				$data		= new Spreadsheet_Excel_Reader($OLERead);
				$data->setOutputEncoding('CP1251');
				$data->read($path."/".$upload_data['file_name']);

				$item = array();
				for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
					if($i==1){
						for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
							$col[$j]=str_replace(" ","_",str_replace("sakit/cuti/ijin","sic",strtolower($data->sheets[0]['cells'][$i][$j])));
						}
					}else{
						$vals = array();
						for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
							if($col[$j]=="status"){
								$vals[$col[$j]] = $data->sheets[0]['cells'][$i][$j]=="open" ? 0 : 1;
							}else{
								$vals[$col[$j]] = isset($data->sheets[0]['cells'][$i][$j]) ? $data->sheets[0]['cells'][$i][$j] : "-" ;
							}
						}
						$item[]=$vals;
					}
				}

				echo "OK_".$this->spkp_absen_tunjangan_model->doimport_tukin($id,$thn,$bln,$item);
			}
		}else{
			echo "ERROR_Upload failed";
		}
    }
    
    function edit_jabatan($id,$id_jabatan){
        $this->authentication->verify('spkp_absen_tunjangan','add');

		$data = $this->spkp_absen_tunjangan_model->get_jabatan($id,$id_jabatan);
		$data['action']="edit";

		echo $this->parser->parse("spkp_absen_tunjangan/form_add_jabatan",$data,true);
    }
    
    function doedit_jabatan(){
        $this->authentication->verify('spkp_absen_tunjangan','edit');
        
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
			$this->spkp_absen_tunjangan_model->update_jabatan();
			echo "1";
		}
    }
    
    function dodel_jabatan($id,$id_jabatan){
        $this->authentication->verify('spkp_absen_tunjangan','del');

		if($this->spkp_absen_tunjangan_model->delete_jabatan($id,$id_jabatan)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
}
