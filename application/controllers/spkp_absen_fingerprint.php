<?php
class Spkp_absen_fingerprint extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->load->model('spkp_absen_fingerprint_model');
		$this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
		require_once(APPPATH.'third_party/excel/oleread.inc');
		require_once(APPPATH.'third_party/excel/reader.php');
	}
	
	function index(){
		$this->authentication->verify('spkp_absen_fingerprint','show');
        
	    $data = array();
		$data['add_permission']=$this->authentication->verify_check('spkp_absen_fingerprint','add');
		$data['content'] = $this->parser->parse("spkp_absen_fingerprint/show",$data,true);

		$this->template->show($data,"home");
	}
	
	function json(){
		$data = $this->spkp_absen_fingerprint_model->json();

		die(json_encode($data));
	}

    function add(){
		$this->authentication->verify('spkp_absen_fingerprint','add');

		$data['action']="add";
		$data['option_bulan']=$this->crud->option_bulan('bulan',date('m'),'style="width:60px"');
		$data['option_tahun']=$this->crud->option_tahun('tahun',date('Y'),'style="width:80px"');
		$data['result']="";

		echo $this->parser->parse("spkp_absen_fingerprint/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('spkp_absen_fingerprint','add');
        
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(!isset($_FILES['filename']['name']) || $_FILES['filename']['name']==""){
				echo "ERROR_File / Dokumen harus ada.";
			}else{
				if(count($_FILES)>0){
					$path = './public/files/spkp_absen_fingerprint/';
					if (!is_dir($path)) {
						mkdir($path);
					}
					$path .= $this->input->post('tahun')."/";
					if (!is_dir($path)) {
						mkdir($path);
					}
					$path .= $this->input->post('bulan')."/";
					if (!is_dir($path)) {
						mkdir($path);
					}
					@unlink($path."/".$_FILES['filename']['name']);
					$config['upload_path'] = $path;
					$config['allowed_types'] = 'xls|xlsx';
					$config['max_size']	= '999999';
					$config['overwrite'] = false;
					$this->load->library('upload', $config);
					$upload = $this->upload->do_upload('filename');
					if($upload === FALSE) {
						echo "ERROR_".$this->upload->display_errors();
					}else{
						$upload_data = $this->upload->data();
						$id=$this->spkp_absen_fingerprint_model->doadd($upload_data);
						if($id!=false){
							$OLERead	= new OLERead();
							$data		= new Spreadsheet_Excel_Reader($OLERead);
							$data->setOutputEncoding('CP1251');
							$data->read($path."/".$upload_data['file_name']);

							$item = array();
							for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
								if($i==1){
									for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
										$col[$j]=str_replace(".","",str_replace(" ","_",strtolower($data->sheets[0]['cells'][$i][$j])));
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
							echo "OK_".$this->spkp_absen_fingerprint_model->doimport($id,$item);
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

	function edit($id=0){
		$this->authentication->verify('spkp_absen_fingerprint','add');

		$data = $this->spkp_absen_fingerprint_model->get_data_row($id); 
		$data['option_bulan']=$this->crud->option_bulan('bulan',$data['bulan'],'style="width:60px"');
		$data['option_tahun']=$this->crud->option_tahun('tahun',$data['tahun'],'style="width:80px"');
		$data['action']="edit";

		echo $this->parser->parse("spkp_absen_fingerprint/form",$data,true);
	}

	function doedit($id=0)
	{
		$this->authentication->verify('spkp_absen_fingerprint','edit');

        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(count($_FILES)>0){
				$path = './public/files/spkp_absen_fingerprint/';
				if (!is_dir($path)) {
					mkdir($path);
				}
				$path .= $this->input->post('tahun')."/";
				if (!is_dir($path)) {
					mkdir($path);
				}
				$path .= $this->input->post('bulan')."/";
				if (!is_dir($path)) {
					mkdir($path);
				}
				@unlink($path."/".$_FILES['filename']['name']);
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'xls|xlsx';
				$config['max_size']	= '999999';
				$config['overwrite'] = false;
				$this->load->library('upload', $config);
				$upload = $this->upload->do_upload('filename');
				if($upload === FALSE) {
					echo "ERROR_".$this->upload->display_errors();
				}else{
					$upload_data = $this->upload->data();
					if($this->spkp_absen_fingerprint_model->doedit($id,$upload_data)){
						$OLERead	= new OLERead();
						$data		= new Spreadsheet_Excel_Reader($OLERead);
						$data->setOutputEncoding('CP1251');
						$data->read($path."/".$upload_data['file_name']);

						$item = array();
						for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
							if($i==1){
								for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
									$col[$j]=str_replace(".","",str_replace(" ","_",strtolower($data->sheets[0]['cells'][$i][$j])));
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
						echo "OK_".$this->spkp_absen_fingerprint_model->doimport($id,$item);
					}else{
						echo "ERROR_Database Error";
					}
				}
			}else{
				if($this->spkp_absen_fingerprint_model->doedit($id)){
					echo "OK_".$id;
				}else{
					echo "ERROR_Database Error";
				}
			}
		}
	}
	
	function download($id=0){
		$this->authentication->verify('spkp_absen_fingerprint','edit');

		$data = $this->spkp_absen_fingerprint_model->get_data_row($id); 
		$data['bulan'] = $this->crud->bulan($data['bulan']);

		echo $this->parser->parse("spkp_absen_fingerprint/download",$data,true);
	}

	function dodownload($id=0){
		$this->authentication->verify('spkp_absen_fingerprint','edit');

		$data = $this->spkp_absen_fingerprint_model->get_data_row($id); 
		$path = './public/files/spkp_absen_fingerprint/'.$data['tahun']."/".$data['bulan']."/".$data['filename'];

		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Transfer-Encoding: binary");
		header("Content-disposition: attachment; filename=" . $data['filename']);
		header("Content-type: application/octet-stream");
		readfile($path);
	}

	function dodelete($id=0){
		$this->authentication->verify('spkp_absen_fingerprint','del');
		$data = $this->spkp_absen_fingerprint_model->get_data_row($id); 
		$path = './public/files/spkp_absen_fingerprint/'.$data['tahun']."/".$data['bulan']."/".$data['filename'];

		if($this->spkp_absen_fingerprint_model->dodelete($id)){
			if(file_exists($path)){
				unlink($path);
			}

			echo "OK_".$id;
		}else{
			echo "ERROR_Database Error";
		}
	}

	function html(){
		$this->authentication->verify('spkp_absen_fingerprint','show');
		
		$data = $this->spkp_absen_fingerprint_model->json();

		$rows = array();
		$dt = isset($data[0]['Rows']) ? $data[0]['Rows'] : array();
		foreach($dt as $r){
			$r['bulan'] = $this->crud->bulan($r['bulan']);
			$rows[]=$r;
		}

		$data['Rows'] = $dt;
		$this->parser->parse("spkp_absen_fingerprint/html",$data);
	}

	function excel(){
		$this->authentication->verify('spkp_absen_fingerprint','show');

		$data = $this->spkp_absen_fingerprint_model->json();

		$rows = array();
		$dt = isset($data[0]['Rows']) ? $data[0]['Rows'] : array();
		foreach($dt as $r){
			$r['bulan'] = $this->crud->bulan($r['bulan']);
			$rows[]=$r;
		}
		$data['title'] = "Absensi Fingerprint";

		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/absensi_fingerprint.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_absensi_fingerprint.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		//echo $output_file_name;
		echo '../public/doc_xls_export/report_absensi_fingerprint.xlsx';
	}
}
