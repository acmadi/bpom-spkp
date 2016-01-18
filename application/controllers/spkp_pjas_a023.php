<?php
class Spkp_pjas_a023 extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('spkp_pjas_a023_model');
		$this->load->helper('html');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
        require_once(APPPATH.'third_party/excel/oleread.inc');
        require_once(APPPATH.'third_party/excel/reader.php');
	}
	
	function index($id_propinsi=0){
		$this->authentication->verify('spkp_pjas_a023','show');
		
		$data['add_permission']=$this->authentication->verify_check('spkp_pjas_f1','add');
		$data['title']="A023 Rekapitulasi Pengawalan SD/MI";
		$data['content']= $this->parser->parse("spkp_pjas_a023/show",$data,true);
		
		$this->template->show($data,'home');
	}
	
	function json_rekap(){
        die(json_encode($this->spkp_pjas_a023_model->json_rekap()));
    }
    
    function add(){
		$this->authentication->verify('spkp_pjas_a023','add');
		
		$data['option_propinsi'] = "";
		
		$this->db->order_by('id_propinsi','asc');
        $query = $this->db->get('mas_propinsi');
		
		$data['propinsi']="";
		$data['add_permission']=$this->authentication->verify_check('spkp_pjas_a023','add');
		$data['title']="Rekap";
		$data['action']="add";
		$data['form']=$this->parser->parse("spkp_pjas_a023/form",$data);
	}
	
	function doadd(){
		$this->authentication->verify('spkp_pjas_a023','add');
		
		$this->form_validation->set_rules('id','ID','trim|required');
		$this->form_validation->set_rules('id_provinsi','ID Propinsi','trim|required');
		$this->form_validation->set_rules('id_balai','ID Balai','trim|required');
		$this->form_validation->set_rules('tanggal','Tanggal','trim|required');
		
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a023_model->insert_rekap();
		}
	}
	
	function edit($id){
        $this->authentication->verify('spkp_pjas_a023','edit');

		$data = $this->spkp_pjas_a023_model->get_data_rekap($id);
		
		$data['action']="edit";
		$data['add_permission']=$this->authentication->verify_check('spkp_pjas_f01','edit');
		$data['title'] = "Rekapitulasi Pengawalan SD/MI &raquo; Edit";
		$data['id']=$id;
		$data['form_edit'] = $this->parser->parse("spkp_pjas_a023/form_edit",$data,true);
		$data['show_sdmi'] = $this->parser->parse("spkp_pjas_a023/show_sdmi",$data,true);
        $data['content'] = $this->parser->parse("spkp_pjas_a023/show_edit",$data,true);

		$this->template->show($data,"home");
    }
	
	function doedit(){
		$this->authentication->verify('spkp_pjas_a023','edit');
		
		$this->form_validation->set_rules('id','ID','trim|required');
		$this->form_validation->set_rules('id_provinsi','ID Propinsi','trim|required');
		$this->form_validation->set_rules('tanggal','Tanggal','trim|required');
		
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a023_model->update_rekap();
			echo "1";
		}
	}
	
	function dodel($id){
		$this->authentication->verify('spkp_pjas_a023','del');
		
		if($this->spkp_pjas_a023_model->delete_rekap($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
	
	function json_sdmi($id){
        die(json_encode($this->spkp_pjas_a023_model->json_sdmi($id)));
    }
	
	function add_sdmi($id){
		$this->authentication->verify('spkp_pjas_a023','add');
		
		$data['add_permission']=$this->authentication->verify_check('spkp_pjas_a023','add');
		$data['title']="Pembinaan";
		$data['action']="add";
		$data['id']=$id;
		$data['form']=$this->parser->parse("spkp_pjas_a023/form_sdmi",$data);
	}
	
	function doadd_sdmi(){
		$this->authentication->verify('spkp_pjas_a023','add');
		
		$this->form_validation->set_rules('id','ID','trim|required');
		$this->form_validation->set_rules('id_sdmi','ID SD/MI','trim|required');
		$this->form_validation->set_rules('nama','Nama SD/MI','trim|required');
		$this->form_validation->set_rules('kegiatan','Kegiatan','trim|required');
		
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a023_model->insert_sdmi();
			echo "1";
		}
	}
	
	function edit_sdmi($id_sdmi){
		$this->authentication->verify('spkp_pjas_a023','add');
		
		$data = $this->spkp_pjas_a023_model->get_data_sdmi($id_sdmi);
		$data['add_permission']=$this->authentication->verify_check('spkp_pjas_a023','add');
		$data['title']="Pembinaan";
		$data['action']="edit";
		$data['id_sdmi']=$id_sdmi;
		$data['form']=$this->parser->parse("spkp_pjas_a023/form_sdmi",$data);
	}
	
	function doedit_sdmi(){
		$this->authentication->verify('spkp_pjas_a023','edit');
		
		$this->form_validation->set_rules('id','ID','trim|required');
		$this->form_validation->set_rules('id_sdmi','ID SD/MI','trim|required');
		$this->form_validation->set_rules('nama','Nama SD/MI','trim|required');
		$this->form_validation->set_rules('kegiatan','Kegiatan','trim|required');
		
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a023_model->update_sdmi();
			echo "1";
		}
	}
	
	function dodel_sdmi($id_sdmi){
		$this->authentication->verify('spkp_pjas_a023','del');
		
		if($this->spkp_pjas_a023_model->delete_sdmi($id_sdmi)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
	
	function export($id){
        $this->authentication->verify('spkp_pjas_a023','show');
		
		$data = $this->spkp_pjas_a023_model->json_sdmi($id);

		$rows = $data[0]['Rows'];
		$data['title'] = "Daftar Rekapitulasi Pengawasan SD/MI";
		
		$data['tgl'] = substr($this->input->post('tanggal'),8,2);
		$angkabln=array('01','02','03','04','05','06','07','08','09','10','11','12');
		$indobln=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus',
		'September','Oktober','November','Desember');
		$data['bln'] = str_ireplace($angkabln,$indobln,(substr($this->input->post('tanggal'),5,2)));
		$data['thn'] = substr($this->input->post('tanggal'),0,4);
		
		$data['tmpt'] = $this->input->post('tmpt');
		
		$data['jabatan'] = $this->input->post('penanggungjawab_jabatan');
		$data['nama'] = $this->input->post('penanggungjawab_nama');
		$data['nip'] = $this->input->post('penanggungjawab_nip');
		
		$data['propinsi'] = $this->input->post('propinsi');
		$data['balai'] = $this->input->post('balai');
        
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;
		$template = $path.'templates/spkp_pjas_a023.docx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $rows);
		$output_file_name = $path.'export/report_spkp_pjas_a023.docx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
    }
    
    function load_form_import($id){
        $this->authentication->verify('spkp_pjas_a023','edit');
        $data = array();
        $data['id'] = $id;
        
        echo $this->parser->parse("spkp_pjas_a023/form_import",$data,true);
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
		header("Content-disposition: attachment; filename=form_spkp_pjas_a023.xls");
		header("Content-Transfer-Encoding: binary"); 
		readfile(base_url()."public/doc_xls_templates/spkp_pjas_a023_format.xls");
    }
    
    function doimport($id){
        if(count($_FILES)){
            $path = "./public/files/data_spkp_pjas_a023";
            if(!is_dir($path)){
                mkdir($path);
            }
            
            $path = "./public/files/data_spkp_pjas_a023/".time(); 
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
                
                        $this->spkp_pjas_a023_model->del_all_sdmi($id);
                        
                        for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
                            $cek = $this->spkp_pjas_a023_model->cek_tanggal($id,isset($data->sheets[0]['cells'][$i][1]) ? $data->sheets[0]['cells'][$i][1] : "");
                            if($cek>0){
                                    $parent['nama']		    = isset($data->sheets[0]['cells'][$i][2]) ? $data->sheets[0]['cells'][$i][2] : "";
                                    $parent['nisn']	        = isset($data->sheets[0]['cells'][$i][3]) ? $data->sheets[0]['cells'][$i][3] : "";
                                    $parent['intervensi']	= isset($data->sheets[0]['cells'][$i][4]) ? $data->sheets[0]['cells'][$i][4] : "";
                                    $parent['petugas']	    = isset($data->sheets[0]['cells'][$i][5]) ? $data->sheets[0]['cells'][$i][5] : "";
                                    $parent['institusi']	= isset($data->sheets[0]['cells'][$i][6]) ? $data->sheets[0]['cells'][$i][6] : "";
                                    $parent['kegiatan']	    = isset($data->sheets[0]['cells'][$i][7]) ? $data->sheets[0]['cells'][$i][7] : "";
                                    
                                    if($this->spkp_pjas_a023_model->insert_import($id,$parent)){
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
