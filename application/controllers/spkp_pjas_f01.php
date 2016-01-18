<?php
class spkp_pjas_f01 extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('spkp_pjas_f01_model');
        $this->load->helper('html');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
        require_once(APPPATH.'third_party/excel/oleread.inc');
        require_once(APPPATH.'third_party/excel/reader.php');
    }
    
    function index(){
        $this->authentication->verify('spkp_pjas_f01','show');
        
        $data = array();
        $data['title'] = "F01 Laporan Penyebaran Produk Informasi Keamanan Pangan";
        
		$data['add_permission']=$this->authentication->verify_check('spkp_pjas_f01','add');
        $data['content'] = $this->parser->parse("spkp_pjas_f01/show",$data,true);

		$this->template->show($data,"home");
    }
    
    function json_sebar(){
        die(json_encode($this->spkp_pjas_f01_model->json_sebar()));
    }
    
    function json_target($id){
        die(json_encode($this->spkp_pjas_f01_model->json_target($id)));
    }
    
    function add_sebar(){
        $this->authentication->verify('spkp_pjas_f01','add');
		$data['action']="add";

		echo $this->parser->parse("spkp_pjas_f01/form_add_sebar",$data,true);
    }
    
    function doadd_sebar(){
        $this->authentication->verify('spkp_pjas_f01','add');

		$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
		$this->form_validation->set_rules('penanggungjawab_nama', 'Penanggung Jawab', 'trim|required');
		$this->form_validation->set_rules('penanggungjawab_nip', 'NIP-Penanggung Jawab', 'trim|required');
		
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_f01_model->insert_sebar();
		}
    }
    
    function edit_sebar($id){
        $this->authentication->verify('spkp_pjas_f01','add');

		$data = $this->spkp_pjas_f01_model->get_data_row($id);
		$data['action']="edit";
		$data['add_permission']=$this->authentication->verify_check('spkp_pjas_f01','edit');
		$data['title'] = "Laporan Penyebaran Produk Informasi Keamanan Pangan &raquo; Edit";
		$data['form_edit'] = $this->parser->parse("spkp_pjas_f01/form_edit",$data,true);
		$data['form_target'] = $this->parser->parse("spkp_pjas_f01/form_target",$data,true);
        $data['content'] = $this->parser->parse("spkp_pjas_f01/show_edit",$data,true);

		$this->template->show($data,"home");
    }
    
    function doedit_sebar(){
        $this->authentication->verify('spkp_pjas_f01','edit');
		
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
        $this->form_validation->set_rules('penanggungjawab_nama', 'Penanggung Jawab', 'trim|required');
        $this->form_validation->set_rules('penanggungjawab_nip', 'NIP-Penanggung Jawab', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_f01_model->update_sebar();
			echo "1";
		}
    }
	
	function load_form_edit($id){
	   $this->authentication->verify('spkp_pjas_f01','add');

	   $data = $this->spkp_pjas_f01_model->get_data_row($id);
	   $data['action']='edit';
	   
       echo $this->parser->parse("spkp_pjas_f01/form_edit",$data,true);
	}
    
    function dodel_sebar($id){
        $this->authentication->verify('spkp_pjas_f01','del');

		if($this->spkp_pjas_f01_model->delete_sebar($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function add_target($id){
        $this->authentication->verify('spkp_pjas_f01','add');
		
		$data['id']=$id;
		$data['action']="add";

		echo $this->parser->parse("spkp_pjas_f01/form_add_target",$data,true);
    }
    
    function doadd_target($id){
        $this->authentication->verify('spkp_pjas_f01','add');

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
		
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_f01_model->insert_target($id);
			echo "1"; 
		}
    }
    
    function edit_target($id,$id_target){
        $this->authentication->verify('spkp_pjas_f01','add');

		$data = $this->spkp_pjas_f01_model->get_data_row_target($id,$id_target);
		$data['action']="edit";

		echo $this->parser->parse("spkp_pjas_f01/form_add_target",$data,true);
    }
    
    function doedit_target($id,$id_target){
        $this->authentication->verify('spkp_pjas_f01','edit');
		
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_f01_model->update_target($id,$id_target);
			echo "1";
		}
    }
    
    function dodel_target($id,$id_target){
        $this->authentication->verify('spkp_pjas_f01','del');

		if($this->spkp_pjas_f01_model->delete_target($id,$id_target)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function html_target($id){
        $this->authentication->verify('spkp_pjas_f01','show');
		
		$data = $this->spkp_pjas_f01_model->json_target($id);

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_pjas_f01/html_target",$data);
    }
    
    function export($id){
        $this->authentication->verify('spkp_pjas_f01','show');
		
		$data = $this->spkp_pjas_f01_model->json_target($id);

		$rows = $data[0]['Rows'];
		
		$data['tmpt'] = $this->input->post('tmpt');
		
		$data['tgl'] = substr($this->input->post('tanggal'),8,2);
		$angkabln=array('01','02','03','04','05','06','07','08','09','10','11','12');
		$indobln=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus',
		'September','Oktober','November','Desember');
		$data['bln'] = str_ireplace($angkabln,$indobln,(substr($this->input->post('tanggal'),5,2)));
		$data['thn'] = substr($this->input->post('tanggal'),0,4);
		
		$data['nama'] = $this->input->post('penanggungjawab_nama');
		$data['nip'] = $this->input->post('penanggungjawab_nip');
		
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;
		$template = $path.'templates/spkp_pjas_f01.docx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_spkp_pjas_f01.docx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
    }
    
    function load_form_import($id){
        $this->authentication->verify('spkp_pjas_f01','edit');
        $data = array();
        $data['id'] = $id;
        
        echo $this->parser->parse("spkp_pjas_f01/form_import",$data,true);
    }
    
    function dodownload(){
        ini_set('zlib.output_compression','Off');
		header("Cache-Control: public");
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: pre-check=0, post-check=0, max-age=0');
		header("Content-Description: File Transfer"); 
		header("Content-type: application/vnd.ms-excel");
		header("Content-type: application/x-msexcel");    
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-disposition: attachment; filename=form_spkp_pjas_f01.xls");
		header("Content-Transfer-Encoding: binary"); 
		readfile(base_url()."public/doc_xls_templates/spkp_pjas_f01_format.xls");
    }
    
    function doimport($id){
        if(count($_FILES)){
            $path = "./public/files/data_spkp_pjas_f01";
            if(!is_dir($path)){
                mkdir($path);
            }
            
            $path = "./public/files/data_spkp_pjas_f01/".time(); 
            if(!is_dir($path)){
               mkdir($path); 
            }
            
            $config['upload_path'] = $path;
            $config['allowed_types'] = '*';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $upload = $this->upload->do_upload('filename');
            
            if($upload==FALSE){
                echo $this->upload->display_errors()."<br>";
            }else{
                $OLERead	= new OLERead();
    			$data		= new Spreadsheet_Excel_Reader($OLERead);
    			$data->setOutputEncoding('CP1251');
    		    $data->read($path."/".$_FILES['filename']['name']);
                $sukses = 0;
                $gagal = 0;
                $nonvalid = 0;
                
                        $this->spkp_pjas_f01_model->del_all_target($id);
                        
                        for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
                            $cek = $this->spkp_pjas_f01_model->cek_tanggal($id,isset($data->sheets[0]['cells'][$i][1]) ? $data->sheets[0]['cells'][$i][1] : "");
                            if($cek>0){
                                    $parent['nama']		= isset($data->sheets[0]['cells'][$i][2]) ? $data->sheets[0]['cells'][$i][2] : "";
                                    $parent['alamat']	= isset($data->sheets[0]['cells'][$i][3]) ? $data->sheets[0]['cells'][$i][3] : "";
                                    $parent['target']	= isset($data->sheets[0]['cells'][$i][4]) ? $data->sheets[0]['cells'][$i][4] : "";
                                    $parent['produk']	= isset($data->sheets[0]['cells'][$i][5]) ? $data->sheets[0]['cells'][$i][5] : "";
                                    $parent['jumlah']	= isset($data->sheets[0]['cells'][$i][6]) ? $data->sheets[0]['cells'][$i][6] : "";
                                    
                                    if($this->spkp_pjas_f01_model->insert_import($id,$parent)){
                                        $sukses++;
                                    }else{
                                        $gagal++;
                                    }
                            }else{
                                $nonvalid++;
                                
                            }
                        }
                        
                        echo "<span style='color: green'>Sukses menambahkan $gagal data(s) item</span>";
                        echo "</br>";
                        if($sukses>0){
                            echo "<span style='color: red'>$sukses data(s) gagal ditambahkan</span>";
                            echo "</br>";   
                        }
                        if($nonvalid>0){
                            echo "<span style='color: red'>$nonvalid data(s) yang anda import tidak sesuai dengan Tanggal Laporan</span>";
                        }
            }
        }else{
            echo "<span style='color: red'>Silahkan pilih file excel</span>";
        }
    }
    
}
?>