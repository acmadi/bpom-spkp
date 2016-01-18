<?php
class Spkp_absen_bulanan extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->load->model('spkp_absen_bulanan_model');
		$this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
	}
	
	function index(){
		$this->authentication->verify('spkp_absen_bulanan','show');
        
	    $data = array();
		$data['add_permission']=$this->authentication->verify_check('spkp_absen_bulanan','add');
		$data['content'] = $this->parser->parse("spkp_absen_bulanan/show",$data,true);

		$this->template->show($data,"home");
	}
	
	function json(){
		$data = $this->spkp_absen_bulanan_model->json();

		die(json_encode($data));
	}

    function add(){
		$this->authentication->verify('spkp_absen_bulanan','add');

		$data['action']="add";
		$data['option_bulan']=$this->crud->option_bulan('bulan',date('m'),'style="width:60px"');
		$data['option_tahun']=$this->crud->option_tahun('tahun',date('Y'),'style="width:80px"');
		$data['option_subdit']=$this->crud->option_subdit('','style="width:500px"');

		echo $this->parser->parse("spkp_absen_bulanan/form",$data,true);
	}

	function doadd(){
		$this->authentication->verify('spkp_absen_bulanan','add');
        
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(!isset($_FILES['filename']['name']) || $_FILES['filename']['name']==""){
				echo "ERROR_File / Dokumen harus ada.";
			}else{
				if(count($_FILES)>0){
					$path = './public/files/spkp_absen_bulanan/';
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
					$path .= $this->input->post('id_subdit')."/";
					if (!is_dir($path)) {
						mkdir($path);
					}
					@unlink($path."/".$_FILES['filename']['name']);
					$config['upload_path'] = $path;
					$config['allowed_types'] = 'pdf';
					$config['max_size']	= '999999';
					$config['overwrite'] = false;
					$this->load->library('upload', $config);
					$upload = $this->upload->do_upload('filename');
					if($upload === FALSE) {
						echo "ERROR_".$this->upload->display_errors();
					}else{
						$upload_data = $this->upload->data();
						$id=$this->spkp_absen_bulanan_model->doadd($upload_data);
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
	
	function edit($id=0){
		$this->authentication->verify('spkp_absen_bulanan','add');

		$data = $this->spkp_absen_bulanan_model->get_data_row($id); 
		$data['option_bulan']=$this->crud->option_bulan('bulan',$data['bulan'],'style="width:60px"');
		$data['option_tahun']=$this->crud->option_tahun('tahun',$data['tahun'],'style="width:80px"');
		$data['option_subdit']=$this->crud->option_subdit($data['id_subdit'],'style="width:500px"');
		$data['action']="edit";

		echo $this->parser->parse("spkp_absen_bulanan/form",$data,true);
	}

	function doedit($id=0)
	{
		$this->authentication->verify('spkp_absen_bulanan','edit');

        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(count($_FILES)>0){
				$path = './public/files/spkp_absen_bulanan/';
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
				$path .= $this->input->post('id_subdit')."/";
				if (!is_dir($path)) {
					mkdir($path);
				}
				@unlink($path."/".$_FILES['filename']['name']);
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'pdf';
				$config['max_size']	= '999999';
				$config['overwrite'] = false;
				$this->load->library('upload', $config);
				$upload = $this->upload->do_upload('filename');
				if($upload === FALSE) {
					echo "ERROR_".$this->upload->display_errors();
				}else{
					$upload_data = $this->upload->data();
					if($this->spkp_absen_bulanan_model->doedit($id,$upload_data)){
						echo "OK_".$id;
					}else{
						echo "ERROR_Database Error";
					}
				}
			}else{
				if($this->spkp_absen_bulanan_model->doedit($id)){
					echo "OK_".$id;
				}else{
					echo "ERROR_Database Error";
				}
			}
		}
	}
	
	function download($id=0){
		$this->authentication->verify('spkp_absen_bulanan','edit');

		$data = $this->spkp_absen_bulanan_model->get_data_row($id); 
		$data['bulan'] = $this->crud->bulan($data['bulan']);

		echo $this->parser->parse("spkp_absen_bulanan/download",$data,true);
	}

	function dodownload($id=0){
		$this->authentication->verify('spkp_absen_bulanan','edit');

		$data = $this->spkp_absen_bulanan_model->get_data_row($id); 
		$path = './public/files/spkp_absen_bulanan/'.$data['tahun']."/".$data['bulan']."/".$data['filename'];

		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Transfer-Encoding: binary");
		header("Content-disposition: attachment; filename=" . $data['filename']);
		header("Content-type: application/octet-stream");
		readfile($path);
	}

	function dodelete($id=0){
		$this->authentication->verify('spkp_absen_bulanan','del');
		$data = $this->spkp_absen_bulanan_model->get_data_row($id); 
		$path = './public/files/spkp_absen_bulanan/'.$data['tahun']."/".$data['bulan']."/".$data['filename'];

		if($this->spkp_absen_bulanan_model->dodelete($id)){
			if(file_exists($path)){
				unlink($path);
			}

			echo "OK_".$id;
		}else{
			echo "ERROR_Database Error";
		}
	}

	function html(){
		$this->authentication->verify('spkp_absen_bulanan','show');
		
		$data = $this->spkp_absen_bulanan_model->json();

		$rows = array();
		$dt = isset($data[0]['Rows']) ? $data[0]['Rows'] : array();
		foreach($dt as $r){
			$r['bulan'] = $this->crud->bulan($r['bulan']);
			$rows[]=$r;
		}

		$data['Rows'] = $dt;
		$this->parser->parse("spkp_absen_bulanan/html",$data);
	}

	function excel(){
		$this->authentication->verify('spkp_absen_bulanan','show');

		$data = $this->spkp_absen_bulanan_model->json();

		$rows = array();
		$dt = isset($data[0]['Rows']) ? $data[0]['Rows'] : array();
		foreach($dt as $r){
			$r['bulan'] = $this->crud->bulan($r['bulan']);
			$rows[]=$r;
		}
		$data['title'] = "Absensi Bulanan";

		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/absensi_bulanan.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_absensi_bulanan.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
	}
}
