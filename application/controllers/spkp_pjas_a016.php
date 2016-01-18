<?php
class Spkp_pjas_a016 extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('spkp_pjas_a016_model');
        $this->load->model('location_model');
        $this->load->helper('html');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
        require_once(APPPATH.'third_party/excel/oleread.inc');
        require_once(APPPATH.'third_party/excel/reader.php');
    }
    
    function index(){
        $this->authentication->verify('spkp_pjas_a016','show');
        
        $data = array();
        $data['title'] = "Laporan Hasil Pengawasan Pangan Dalam Rangka Mobil Keliling";
        
        $data['add_permission']=$this->authentication->verify_check('spkp_pjas_a016','add');
        $data['content'] = $this->parser->parse("spkp_pjas_a016/show",$data,true);
        $this->template->show($data,"home");
    }
    
    function json_form(){
        die(json_encode($this->spkp_pjas_a016_model->json_form()));
    }
    
    function add_form(){
        $this->authentication->verify('spkp_pjas_a016','add');
		$data['action']="add";

		echo $this->parser->parse("spkp_pjas_a016/form_add",$data,true);
    }
    
    function doadd_form(){
        $this->authentication->verify('spkp_pjas_a016','add');

		$this->form_validation->set_rules('bulan', 'Bulan', 'trim|required');
        $this->form_validation->set_rules('id_balai', 'Balai', 'trim|required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
        $this->form_validation->set_rules('penanggungjawab_nama', 'Nama Penanggung Jawab', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a016_model->insert_form();
		}
    }
    
    function dodel_form($id){
        $this->authentication->verify('spkp_pjas_a016','del');

		if($this->spkp_pjas_a016_model->delete_form($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function doedit_form($id){
        $this->authentication->verify('spkp_pjas_a016','edit');
        
        $this->form_validation->set_rules('bulan', 'Bulan', 'trim|required');
        $this->form_validation->set_rules('id_balai', 'Balai', 'trim|required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
        $this->form_validation->set_rules('penanggungjawab_nama', 'Nama Penanggung Jawab', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a016_model->update_form($id);
			echo "1"; 
		}
    }
    
    function load_form($id){
        $this->authentication->verify('spkp_pjas_a016','edit');
		$data = $this->spkp_pjas_a016_model->get_form($id);
        
		echo $this->parser->parse("spkp_pjas_a016/form",$data,true);
    }
    
    function edit($id){
        $this->authentication->verify('spkp_pjas_a016','add');
        
        if($this->spkp_pjas_a016_model->check_form($id)>0){
            
            $data = $this->spkp_pjas_a016_model->get_form($id);
            $data['title'] = "Laporan Hasil Pengawasan Pangan Dalam Rangka Mobil Keliling &raquo; Edit";
            $data['id'] = $id;
            
            $data['add_permission']=$this->authentication->verify_check('spkp_pjas_a016','add');
            $data['form'] = $this->parser->parse("spkp_pjas_a016/form",$data,true);
            $data['form_hasil'] = $this->parser->parse("spkp_pjas_a016/form_hasil",$data,true);
            $data['content'] = $this->parser->parse("spkp_pjas_a016/show_edit",$data,true);
            $this->template->show($data,"home");
            
        }else{
            return false;
        }
    }
    
    function json_hasil($id){
        die(json_encode($this->spkp_pjas_a016_model->json_hasil($id)));
    }
    
    function add_hasil($id){
        $this->authentication->verify('spkp_pjas_a016','add');
		$data['action']="add";
        $data['id'] = $id;
        
		echo $this->parser->parse("spkp_pjas_a016/form_add_hasil",$data,true);
    }
    
    function doadd_hasil($id){
        $this->authentication->verify('spkp_pjas_a016','add');

		$this->form_validation->set_rules('lokasi', 'Lokasi', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('propinsi', 'Propinsi', 'trim|required');
        $this->form_validation->set_rules('kota', 'Kota', 'trim|required');
        $this->form_validation->set_rules('kode_sampel', 'Kode Sampel', 'trim|required');
        $this->form_validation->set_rules('produk', 'Nama Produk', 'trim|required');
        $this->form_validation->set_rules('pedagang', 'Nama Pedagang', 'trim|required');
        $this->form_validation->set_rules('no_pendaftaran', 'No. Pendaftaran', 'trim|required');
        $this->form_validation->set_rules('kesimpulan_akhir', 'Kesimpulan Akhir', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a016_model->insert_hasil($id);
			echo "1"; 
		}
    }
    
    function edit_hasil($id,$hasil){
        $this->authentication->verify('spkp_pjas_a016','edit');
        
        $data = $this->spkp_pjas_a016_model->get_hasil($id,$hasil);
		$data['action']="edit";
        $data['id'] = $id;
        $data['propinsi'] = substr($data['kabkota'],0,2);
        
		echo $this->parser->parse("spkp_pjas_a016/form_add_hasil",$data,true);
    }
    
    function doedit_hasil($id){
        $this->authentication->verify('spkp_pjas_a016','edit');

        $this->form_validation->set_rules('lokasi', 'Lokasi', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('propinsi', 'Propinsi', 'trim|required');
        $this->form_validation->set_rules('kota', 'Kota', 'trim|required');
        $this->form_validation->set_rules('kode_sampel', 'Kode Sampel', 'trim|required');
        $this->form_validation->set_rules('produk', 'Nama Produk', 'trim|required');
        $this->form_validation->set_rules('pedagang', 'Nama Pedagang', 'trim|required');
        $this->form_validation->set_rules('no_pendaftaran', 'No. Pendaftaran', 'trim|required');
        $this->form_validation->set_rules('kesimpulan_akhir', 'Kesimpulan Akhir', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a016_model->update_hasil($id);
			echo "1"; 
		}
    }
    
    function dodel_hasil($id,$hasil){
        $this->authentication->verify('spkp_pjas_a016','del');

		if($this->spkp_pjas_a016_model->delete_hasil($id,$hasil)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function load_uji($id,$hasil){
        $data = $this->spkp_pjas_a016_model->get_hasil($id,$hasil);
		$data['id'] = $id;
        $data['id_hasil'] = $hasil;
        $data['add_permission']=$this->authentication->verify_check('spkp_pjas_a016','add');
        $data['title_uji'] = "Hasil Pengawasan Pangan Dalam Rangka Mobil Keliling";
        
		echo $this->parser->parse("spkp_pjas_a016/show_uji",$data,true);        
    }
    
    function json_uji($id,$hasil){
        die(json_encode($this->spkp_pjas_a016_model->json_uji($id,$hasil)));
    }
    
    function add_uji($id,$hasil){
        $this->authentication->verify('spkp_pjas_a016','add');
		$data['action']="add";
        $data['id'] = $id;
        $data['id_hasil'] = $hasil;
        
		echo $this->parser->parse("spkp_pjas_a016/form_add_uji",$data,true);
    }
    
    function doadd_uji($id,$hasil){
        $this->authentication->verify('spkp_pjas_a016','add');

		$this->form_validation->set_rules('parameter', 'Parameter', 'trim|required');
        $this->form_validation->set_rules('hasil', 'Hasil', 'trim|required');
        $this->form_validation->set_rules('kesimpulan', 'Kesimpulan', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a016_model->insert_uji($id,$hasil);
			echo "1"; 
		}
    }
    
    function edit_uji($id,$hasil,$param){
        $this->authentication->verify('spkp_pjas_a016','edit');
        
        $data = $this->spkp_pjas_a016_model->get_uji($id,$hasil,$param);
		$data['action']="edit";
        $data['id'] = $id;
        $data['id_hasil'] = $hasil;
        
		echo $this->parser->parse("spkp_pjas_a016/form_add_uji",$data,true);
    }
    
    function doedit_uji($id,$hasil){
        $this->authentication->verify('spkp_pjas_a016','edit');

        $this->form_validation->set_rules('parameter', 'Parameter', 'trim|required');
        $this->form_validation->set_rules('hasil', 'Hasil', 'trim|required');
        $this->form_validation->set_rules('kesimpulan', 'Kesimpulan', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a016_model->update_uji($id,$hasil);
			echo "1"; 
		}
    }
    
    function dodel_uji($id,$hasil,$param){
        $this->authentication->verify('spkp_pjas_a016','del');

		if($this->spkp_pjas_a016_model->delete_uji($id,$hasil,$param)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function export_kota(){
        $this->authentication->verify('spkp_pjas_a016','show');
        
        $data = array();
        $data['title'] = "Daftar Kota";
        $data_kota = $this->spkp_pjas_a016_model->get_all_kota();
        $x=1;
        foreach($data_kota as $row){
            $kota[] = array('no'=>$x,'id_kota'=>$row->id_kota,'nama_kota'=>$row->nama_kota);
            $x++;
        }
        
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/mas_kota.xlsx';
		$TBS->LoadTemplate($template);
        
        $TBS->MergeBlock('kota', $kota);
		$output_file_name = $path.'export/report_mas_kota.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
    }
    
    function export($id){
        $this->authentication->verify('spkp_pjas_a016','show');
        
        $arr_bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        $data = $this->spkp_pjas_a016_model->get_form($id);
        $data['title_form'] = "Form A016. Laporan Hasil Pengawasan Pangan dalam rangka Mobil Keliling";
        $data['title_a'] = "LAPORAN HASIL PENGAWASAN PANGAN DALAM RANGKA MOBIL KELILING";
        $data['title_b'] = "BULAN                   : ".$arr_bulan[$data['bulan']];
        $data['title_c'] = "BBPOM/ BPOM             : ".$this->spkp_pjas_a016_model->get_balai($data['id_balai']);
        $data['tanggal_form'] = $this->authentication->indonesian_date($data['tanggal'],'l, j F Y','');
        
        $data_hasil = $this->spkp_pjas_a016_model->get_hasil_pengawasan($id);
        $x=1;
        foreach($data_hasil as $row_hasil){
            $hasil_uji = $this->spkp_pjas_a016_model->get_hasil_uji($id,$row_hasil->id_hasil);
            $param = array();
            $hasil_test = array();
            $kesimpulan = array();
            $y = 1;
            foreach($hasil_uji as $row_uji){
                $param[] = $y.". ".$row_uji->parameter;
                $hasil_test[] = $y.". ".$row_uji->hasil;
                $kesimpulan[] = $y.". ".$row_uji->kesimpulan;
                $y++;
            }
            $hasil[] = array('no'=>$x,'lokasi'=>$row_hasil->lokasi,'alamat'=>$row_hasil->alamat,'kabkota'=>ucwords(strtolower($this->spkp_pjas_a016_model->get_kota($row_hasil->kabkota))),
                        'kode_sampel'=>$row_hasil->kode_sampel,'produk'=>$row_hasil->produk,'pedagang'=>$row_hasil->pedagang,
                        'pengolah'=>$row_hasil->pengolah,'jenis'=>$row_hasil->jenis,'no_pendaftaran'=>$row_hasil->no_pendaftaran,
                        'kesimpulan_akhir'=>$row_hasil->kesimpulan_akhir,'tindaklanjut'=>$row_hasil->tindaklanjut,
                        'parameter'=>implode(', ',$param),'hasil'=>implode(', ',$hasil_test),'kesimpulan'=>implode(', ',$kesimpulan));
            $x++;
        }
        
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/spkp_pjas_a016.xlsx';
		$TBS->LoadTemplate($template);
        
        $TBS->MergeBlock('hasil', $hasil);
		$output_file_name = $path.'export/report_spkp_pjas_a016.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
    }
    
    function load_form_import($id){
        $this->authentication->verify('spkp_pjas_a016','edit');
        $data = array();
        $data['id'] = $id;
        
        echo $this->parser->parse("spkp_pjas_a016/form_import",$data,true);
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
		header("Content-disposition: attachment; filename=form_spkp_pjas_a016.xls");
		header("Content-Transfer-Encoding: binary"); 
		readfile(base_url()."public/doc_xls_templates/spkp_pjas_a016_format.xls");
    }
    
    function doimport($id){
        if(count($_FILES)){
            $path = "./public/files/data_spkp_pjas_a016";
            if(!is_dir($path)){
                mkdir($path);
            }
            
            $path = "./public/files/data_spkp_pjas_a016/".time(); 
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
                $parent = array();
                $child = array();
                $var = "";
                $param = "";
                        $this->spkp_pjas_a016_model->del_hasil_uji($id);
                        
                        for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
                            $cek = $this->spkp_pjas_a016_model->cek_tanggal($id,$data->sheets[0]['cells'][$i][1]);
                            if($cek>0){
                                    $parent['lokasi']		= isset($data->sheets[0]['cells'][$i][2]) ? $data->sheets[0]['cells'][$i][2] : "";
                                    $parent['alamat']		= isset($data->sheets[0]['cells'][$i][3]) ? $data->sheets[0]['cells'][$i][3] : "";
                                    $parent['kabkota']		= isset($data->sheets[0]['cells'][$i][4]) ? $data->sheets[0]['cells'][$i][4] : "";
                                    $parent['kode_sampel']	= isset($data->sheets[0]['cells'][$i][5]) ? $data->sheets[0]['cells'][$i][5] : "";;
                                    $parent['produk']		= isset($data->sheets[0]['cells'][$i][6]) ? $data->sheets[0]['cells'][$i][6] : "";
                                    $parent['pedagang']		= isset($data->sheets[0]['cells'][$i][7]) ? $data->sheets[0]['cells'][$i][7] : "";
                                    $parent['pengolah']		= isset($data->sheets[0]['cells'][$i][8]) ? $data->sheets[0]['cells'][$i][8] : "";
                                    $parent['jenis']		= isset($data->sheets[0]['cells'][$i][9]) ? $data->sheets[0]['cells'][$i][9] : "";
                                    $parent['no_pendaftaran']	= isset($data->sheets[0]['cells'][$i][10]) ? $data->sheets[0]['cells'][$i][10] : "";
                                    $parent['kesimpulan_akhir'] = isset($data->sheets[0]['cells'][$i][14]) ? $data->sheets[0]['cells'][$i][14] : "";
                                    $parent['tindaklanjut'] = isset($data->sheets[0]['cells'][$i][15]) ? $data->sheets[0]['cells'][$i][15] : "";
                                    
                                    $child['parameter']		= isset($data->sheets[0]['cells'][$i][11]) ? $data->sheets[0]['cells'][$i][11] : "";
                                    $child['hasil']			= isset($data->sheets[0]['cells'][$i][12]) ? $data->sheets[0]['cells'][$i][12] : "";
                                    $child['kesimpulan']	= isset($data->sheets[0]['cells'][$i][13]) ? $data->sheets[0]['cells'][$i][13] : "";
                                    
                                    $var	= isset($data->sheets[0]['cells'][$i][2]) ? $data->sheets[0]['cells'][$i][2] : "";
                                    $param	= isset($data->sheets[0]['cells'][$i][11]) ? $data->sheets[0]['cells'][$i][11] : "";
                                    
                                    if($this->spkp_pjas_a016_model->insert_import($id,$var,$param,$parent,$child)){
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