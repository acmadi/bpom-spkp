<?php
class Spkp_pjas_a013 extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('spkp_pjas_a013_model');
        $this->load->helper('html');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
        require_once(APPPATH.'third_party/excel/oleread.inc');
        require_once(APPPATH.'third_party/excel/reader.php');
    }
    
    function index(){
        $this->authentication->verify('spkp_pjas_a013','show');
        
        $data = array();
        $data['title'] = "Lembar Kendali Kegiatan KIE Keamanan Pangan";
        
        $data['add_permission']=$this->authentication->verify_check('spkp_pjas_a013','add');
        $data['content'] = $this->parser->parse("spkp_pjas_a013/show",$data,true);
        $this->template->show($data,"home");
    }
    
    function json_form(){
        die(json_encode($this->spkp_pjas_a013_model->json_form()));
    }
    
    function add_form(){
        $this->authentication->verify('spkp_pjas_a013','add');
		$data['action']="add";

		echo $this->parser->parse("spkp_pjas_a013/form_add",$data,true);
    }
    
    function doadd_form(){
        $this->authentication->verify('spkp_pjas_a013','add');

		$this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');
        $this->form_validation->set_rules('id_balai', 'Balai Besar/ Balai POM', 'trim|required');
        $this->form_validation->set_rules('ttd_tmpt', 'Tempat Penanggung Jawab', 'trim|required');
        $this->form_validation->set_rules('ttd_tgl', 'Tanggal Penanggung Jawab', 'trim|required');
        $this->form_validation->set_rules('ttd_nama', 'Nama Penanggung Jawab', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a013_model->insert_form();
		}
    }
    
    function dodel_form($id){
        $this->authentication->verify('spkp_pjas_a013','del');

		if($this->spkp_pjas_a013_model->delete_form($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function doedit_form($id){
        $this->authentication->verify('spkp_pjas_a013','edit');
        
        $this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');
        $this->form_validation->set_rules('id_balai', 'Balai Besar/ Balai POM', 'trim|required');
        $this->form_validation->set_rules('ttd_tmpt', 'Tempat Penanggung Jawab', 'trim|required');
        $this->form_validation->set_rules('ttd_tgl', 'Tanggal Penanggung Jawab', 'trim|required');
        $this->form_validation->set_rules('ttd_nama', 'Nama Penanggung Jawab', 'trim|required');
		
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a013_model->update_form($id);
			echo "1"; 
		}
    }
    
    function load_form($id){
        $this->authentication->verify('spkp_pjas_a013','edit');
		$data = $this->spkp_pjas_a013_model->get_form($id);
        
		echo $this->parser->parse("spkp_pjas_a013/form",$data,true);
    }
    
    function edit($id){
        $this->authentication->verify('spkp_pjas_a013','add');
        
        if($this->spkp_pjas_a013_model->check_form($id)>0){
            
            $data = $this->spkp_pjas_a013_model->get_form($id);
            $data['title'] = "Lembar Kendali Kegiatan KIE Keamanan Pangan &raquo; Edit";
            $data['id'] = $id;
            
            $data['add_permission']=$this->authentication->verify_check('spkp_pjas_a013','add');
            $data['form'] = $this->parser->parse("spkp_pjas_a013/form",$data,true);
            $data['form_pelaksanaan'] = $this->parser->parse("spkp_pjas_a013/form_pelaksanaan",$data,true);
            $data['content'] = $this->parser->parse("spkp_pjas_a013/show_edit",$data,true);
            $this->template->show($data,"home");
            
        }else{
            return false;
        }
    }
    
    function json_pelaksanaan($id){
        die(json_encode($this->spkp_pjas_a013_model->json_pelaksanaan($id)));
    }
    
    function add_pelaksanaan($id){
        $this->authentication->verify('spkp_pjas_a013','add');
		$data['action']="add";
        $data['id'] = $id;
        
		echo $this->parser->parse("spkp_pjas_a013/form_add_pelaksanaan",$data,true);
    }
    
    function doadd_pelaksanaan($id){
        $this->authentication->verify('spkp_pjas_a013','add');

		$this->form_validation->set_rules('tgl', 'Tanggal', 'trim|required');
        $this->form_validation->set_rules('jenis', 'Jenis KIE', 'trim|required');
        $this->form_validation->set_rules('kegiatan', 'Nama Kegiatan', 'trim|required');
     
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a013_model->insert_pelaksanaan($id);
			echo "1"; 
		}
    }
    
    function edit_pelaksanaan($id,$pelaksana){
        $this->authentication->verify('spkp_pjas_a013','edit');
        
        $data = $this->spkp_pjas_a013_model->get_pelaksanaan($id,$pelaksana);
		$data['action']="edit";
        $data['id'] = $id;
        
		echo $this->parser->parse("spkp_pjas_a013/form_add_pelaksanaan",$data,true);
    }
    
    function doedit_pelaksanaan($id){
        $this->authentication->verify('spkp_pjas_a013','edit');

		$this->form_validation->set_rules('tgl', 'Tanggal', 'trim|required');
        $this->form_validation->set_rules('jenis', 'Jenis KIE', 'trim|required');
        $this->form_validation->set_rules('kegiatan', 'Nama Kegiatan', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a013_model->update_pelaksanaan($id);
			echo "1"; 
		}
    }
    
    function dodel_pelaksanaan($id,$pelaksana){
        $this->authentication->verify('spkp_pjas_a013','del');

		if($this->spkp_pjas_a013_model->delete_pelaksanaan($id,$pelaksana)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function export($id){
        $this->authentication->verify('spkp_pjas_a013','show');

		$data = $this->spkp_pjas_a013_model->get_form($id);
        $data['title'] = "Form A013. Lembar Kendali Kegiatan KIE Keamanan Pangan Melalui Media Massa Elektronik (Talkshow di TV, radio) dan Pameran Keamanan PJAS di Daerah tahun ".$data['tahun'];
        $data['balai'] = $this->spkp_pjas_a013_model->get_balai($data['id_balai']);
        $data['tanggal_form'] = $data['ttd_tmpt'].", ".$this->authentication->indonesian_date($data['ttd_tgl'],'j F Y','');
        
        $data_plk = $this->spkp_pjas_a013_model->get_all_pelaksanaan($id);
        $x = 1;
        foreach($data_plk as $row_plk){
            $plk[] = array('no'=>$x,'tgl'=>$row_plk->tgl,'jenis'=>$row_plk->jenis,'media'=>$row_plk->media,'kegiatan'=>$row_plk->kegiatan,'evaluasi'=>$row_plk->evaluasi);
            $x++;
        }
         
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/spkp_pjas_a013.docx';
		$TBS->LoadTemplate($template);
        
     	$TBS->MergeBlock('plk', $plk);
		$output_file_name = $path.'export/report_spkp_pjas_a013.docx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
    }
    
    function load_form_import($id){
        $this->authentication->verify('spkp_pjas_a013','edit');
        $data = array();
        $data['id'] = $id;
        
        echo $this->parser->parse("spkp_pjas_a013/form_import",$data,true);
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
		header("Content-disposition: attachment; filename=form_spkp_pjas_a013.xls");
		header("Content-Transfer-Encoding: binary"); 
		readfile(base_url()."public/doc_xls_templates/spkp_pjas_a013_format.xls");
    }
    
    function doimport($id){
        if(count($_FILES)){
            $path = "./public/files/data_spkp_pjas_a013";
            if(!is_dir($path)){
                mkdir($path);
            }
            
            $path = "./public/files/data_spkp_pjas_a013/".time(); 
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
                
                        $this->spkp_pjas_a013_model->del_all_pelaksanaan($id);
                        
                        for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
                            $cek = $this->spkp_pjas_a013_model->cek_tanggal($id,isset($data->sheets[0]['cells'][$i][1]) ? $data->sheets[0]['cells'][$i][1] : "");
                            if($cek>0){
                                    $parent['tgl']		= isset($data->sheets[0]['cells'][$i][2]) ? $data->sheets[0]['cells'][$i][2] : "";
                                    $parent['jenis']	= isset($data->sheets[0]['cells'][$i][3]) ? $data->sheets[0]['cells'][$i][3] : "";
                                    $parent['media']	= isset($data->sheets[0]['cells'][$i][4]) ? $data->sheets[0]['cells'][$i][4] : "";
                                    $parent['kegiatan']	= isset($data->sheets[0]['cells'][$i][5]) ? $data->sheets[0]['cells'][$i][5] : "";;
                                    $parent['evaluasi']	= isset($data->sheets[0]['cells'][$i][6]) ? $data->sheets[0]['cells'][$i][6] : "";
                                    
                                    if($this->spkp_pjas_a013_model->insert_import($id,$parent)){
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