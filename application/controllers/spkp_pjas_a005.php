<?php
class Spkp_pjas_a005 extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('spkp_pjas_a005_model');
        $this->load->helper('html');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
    }
    
    function index(){
        $this->authentication->verify('spkp_pjas_a005','show');
        
        $data = array();
        $data['title'] = "Bimtek KIE Keamanan PJAS";
        
        $data['add_permission']=$this->authentication->verify_check('spkp_pjas_a005','add');
        $data['content'] = $this->parser->parse("spkp_pjas_a005/show",$data,true);
        $this->template->show($data,"home");
    }
    
    function json_form(){
        die(json_encode($this->spkp_pjas_a005_model->json_form()));
    }
    
    function json_sekolah($id){
        die(json_encode($this->spkp_pjas_a005_model->json_sekolah($id)));
    }
    
    function json_materi($id){
        die(json_encode($this->spkp_pjas_a005_model->json_materi($id)));
    }
    
    function json_jumlah($id){
        die(json_encode($this->spkp_pjas_a005_model->json_jumlah($id)));
    }
    
    function json_peserta($id){
        die(json_encode($this->spkp_pjas_a005_model->json_peserta($id)));
    }
    
    function add_form(){
        $this->authentication->verify('spkp_pjas_a005','add');
		$data['action']="add";

		echo $this->parser->parse("spkp_pjas_a005/form_add",$data,true);
    }
    
    function doadd_form(){
        $this->authentication->verify('spkp_pjas_a005','add');

		$this->form_validation->set_rules('balai', 'Balai', 'trim|required');
        $this->form_validation->set_rules('tempat', 'Tempat', 'trim|required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
       // $this->form_validation->set_rules('penanggungjawab_tempat', 'Tempat Penanggung Jawab', 'trim|required');
      //  $this->form_validation->set_rules('penanggungjawab_tanggal', 'Tanggal Penanggung Jawab', 'trim|required');
     //   $this->form_validation->set_rules('penanggungjawab_nip', 'NIP', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a005_model->insert_form();
		}
    }
    
    function edit($id){
        $this->authentication->verify('spkp_pjas_a005','add');
        
        if($this->spkp_pjas_a005_model->check_form($id)>0){
            
            $data = $this->spkp_pjas_a005_model->get_form($id);
            $data['title'] = "Bimtek KIE Keamanan PJAS &raquo; Edit";
            $data['id'] = $id;
            
            $data['add_permission']=$this->authentication->verify_check('spkp_pjas_a005','add');
            $data['form'] = $this->parser->parse("spkp_pjas_a005/form",$data,true);
            $data['form_sekolah'] = $this->parser->parse("spkp_pjas_a005/form_sekolah",$data,true);
            $data['form_jumlah'] = $this->parser->parse("spkp_pjas_a005/form_jumlah",$data,true);
            $data['form_peserta'] = $this->parser->parse("spkp_pjas_a005/form_peserta",$data,true);
            $data['form_materi'] = $this->parser->parse("spkp_pjas_a005/form_materi",$data,true);
            $data['content'] = $this->parser->parse("spkp_pjas_a005/show_edit",$data,true);
            $this->template->show($data,"home");
            
        }else{
            return false;
        }
        
    }
    
    function dodel_form($id){
        $this->authentication->verify('spkp_pjas_a005','del');

		if($this->spkp_pjas_a005_model->delete_form($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function doedit_form($id){
        $this->authentication->verify('spkp_pjas_a005','edit');

		$this->form_validation->set_rules('balai', 'Balai', 'trim|required');
        $this->form_validation->set_rules('tempat', 'Tempat', 'trim|required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
        $this->form_validation->set_rules('penanggungjawab_tempat', 'Tempat Penanggung Jawab', 'trim|required');
        $this->form_validation->set_rules('penanggungjawab_tanggal', 'Tanggal Penanggung Jawab', 'trim|required');
     //   $this->form_validation->set_rules('penanggungjawab_nip', 'NIP', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a005_model->update_form($id);
			echo "1"; 
		}
    }
    
    function load_form($id){
        $this->authentication->verify('spkp_pjas_a005','edit');
		$data = $this->spkp_pjas_a005_model->get_form($id);
        
		echo $this->parser->parse("spkp_pjas_a005/form",$data,true);
    }
    
    function add_sekolah($id){
        $this->authentication->verify('spkp_pjas_a005','add');
		$data['action']="add";
        $data['id'] = $id;
        
		echo $this->parser->parse("spkp_pjas_a005/form_add_sekolah",$data,true);
    }
    
    function doadd_sekolah($id){
        $this->authentication->verify('spkp_pjas_a005','add');

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        $this->form_validation->set_rules('akreditasi', 'Akreditasi', 'trim|required');
        $this->form_validation->set_rules('kantin', 'Kantin', 'trim|required');
        $this->form_validation->set_rules('internet', 'Internet', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a005_model->insert_sekolah($id);
			echo "1"; 
		}
    }
    
    function edit_sekolah($id,$peserta){
        $this->authentication->verify('spkp_pjas_a005','edit');
        
        $data = $this->spkp_pjas_a005_model->get_data_sekolah($id,$peserta);
		$data['action']="edit";
        $data['id'] = $id;
        
		echo $this->parser->parse("spkp_pjas_a005/form_add_sekolah",$data,true);
    }
    
    function doedit_sekolah($id){
        $this->authentication->verify('spkp_pjas_a005','edit');

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        $this->form_validation->set_rules('akreditasi', 'Akreditasi', 'trim|required');
        $this->form_validation->set_rules('kantin', 'Kantin', 'trim|required');
        $this->form_validation->set_rules('internet', 'Internet', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a005_model->update_sekolah($id);
			echo "1"; 
		}
    }
    
    function dodel_sekolah($id,$peserta){
        $this->authentication->verify('spkp_pjas_a005','del');

		if($this->spkp_pjas_a005_model->delete_sekolah($id,$peserta)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function add_materi($id){
        $this->authentication->verify('spkp_pjas_a005','add');
		$data['action']="add";
        $data['id'] = $id;
        
		echo $this->parser->parse("spkp_pjas_a005/form_add_materi",$data,true);
    }
    
    function doadd_materi($id){
        $this->authentication->verify('spkp_pjas_a005','add');

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
      //  $this->form_validation->set_rules('instansi', 'Instansi', 'trim|required');
        $this->form_validation->set_rules('materi', 'Materi', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a005_model->insert_materi($id);
			echo "1"; 
		}
    }
    
    function edit_materi($id,$narasumber){
        $this->authentication->verify('spkp_pjas_a005','edit');
        
        $data = $this->spkp_pjas_a005_model->get_data_materi($id,$narasumber);
		$data['action']="edit";
        $data['id'] = $id;
        
		echo $this->parser->parse("spkp_pjas_a005/form_add_materi",$data,true);
    }
    
    function doedit_materi($id){
        $this->authentication->verify('spkp_pjas_a005','edit');

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
      //  $this->form_validation->set_rules('instansi', 'Instansi', 'trim|required');
        $this->form_validation->set_rules('materi', 'Materi', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a005_model->update_materi($id);
			echo "1"; 
		}
    }
    
    function dodel_materi($id,$narasumber){
        $this->authentication->verify('spkp_pjas_a005','del');

		if($this->spkp_pjas_a005_model->delete_materi($id,$narasumber)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function add_jumlah($id){
        $this->authentication->verify('spkp_pjas_a005','add');
		$data['action']="add";
        $data['id'] = $id;
        
		echo $this->parser->parse("spkp_pjas_a005/form_add_jumlah",$data,true);
    }
    
    function doadd_jumlah($id){
        $this->authentication->verify('spkp_pjas_a005','add');

		$this->form_validation->set_rules('kepsek', 'Kepsek', 'trim|required');
        $this->form_validation->set_rules('guru_uks', 'Guru UKS', 'trim|required');
        $this->form_validation->set_rules('guru', 'Guru', 'trim|required');
        $this->form_validation->set_rules('kantin', 'Pengelola Kantin', 'trim|required');
        $this->form_validation->set_rules('komite', 'Komite Sekolah', 'trim|required');
        $this->form_validation->set_rules('kelas4', 'Siswa Kelas 4', 'trim|required');
        $this->form_validation->set_rules('kelas5', 'Siswa Kelas 5', 'trim|required');
        $this->form_validation->set_rules('lainnya', 'Lainnya', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a005_model->insert_jumlah_peserta($id);
			echo "1"; 
		}
    }
    
    function edit_jumlah($id,$hari){
        $this->authentication->verify('spkp_pjas_a005','edit');
        
        $data = $this->spkp_pjas_a005_model->get_jumlah_peserta($id,$hari);
		$data['action']="edit";
        $data['id'] = $id;
        
		echo $this->parser->parse("spkp_pjas_a005/form_add_jumlah",$data,true);
    }
    
    function doedit_jumlah($id){
        $this->authentication->verify('spkp_pjas_a005','edit');

		$this->form_validation->set_rules('kepsek', 'Kepsek', 'trim|required');
        $this->form_validation->set_rules('guru_uks', 'Guru UKS', 'trim|required');
        $this->form_validation->set_rules('guru', 'Guru', 'trim|required');
        $this->form_validation->set_rules('kantin', 'Pengelola Kantin', 'trim|required');
        $this->form_validation->set_rules('komite', 'Komite Sekolah', 'trim|required');
        $this->form_validation->set_rules('kelas4', 'Siswa Kelas 4', 'trim|required');
        $this->form_validation->set_rules('kelas5', 'Siswa Kelas 5', 'trim|required');
        $this->form_validation->set_rules('lainnya', 'Lainnya', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a005_model->update_jumlah_peserta($id);
			echo "1"; 
		}
    }
    
    function dodel_jumlah($id,$hari){
        $this->authentication->verify('spkp_pjas_a005','del');

		if($this->spkp_pjas_a005_model->delete_jumlah_peserta($id,$hari)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function add_peserta($id){
        $this->authentication->verify('spkp_pjas_a005','add');
		$data['action']="add";
        $data['id'] = $id;
        
		echo $this->parser->parse("spkp_pjas_a005/form_add_peserta",$data,true);
    }
    
    function doadd_peserta($id){
        $this->authentication->verify('spkp_pjas_a005','add');

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a005_model->insert_peserta($id);
			echo "1"; 
		}
    }
    
    function edit_peserta($id,$peserta){
        $this->authentication->verify('spkp_pjas_a005','edit');
        
        $data = $this->spkp_pjas_a005_model->get_peserta($id,$peserta);
		$data['action']="edit";
        $data['id'] = $id;
        
		echo $this->parser->parse("spkp_pjas_a005/form_add_peserta",$data,true);
    }
    
    function doedit_peserta($id){
        $this->authentication->verify('spkp_pjas_a005','edit');

		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a005_model->update_peserta($id);
			echo "1"; 
		}
    }
    
    function dodel_peserta($id,$peserta){
        $this->authentication->verify('spkp_pjas_a005','del');

		if($this->spkp_pjas_a005_model->delete_peserta($id,$peserta)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function export($id){
        $this->authentication->verify('spkp_pjas_a005','show');

		$data = $this->spkp_pjas_a005_model->get_form($id);
        $hari = $this->spkp_pjas_a005_model->get_max_hari($id);
        $data['title'] = "Form A005. Evaluasi dan pelaporan Bimtek KIE keamanan PJAS";
        $data['balai'] = $this->spkp_pjas_a005_model->get_balai($data['id_balai']);
        $data['tanggal_form'] = $this->authentication->indonesian_date($data['tanggal'],'l, j F Y','');
        $data['tanggal_pj'] = $data['penanggungjawab_tempat'].", ".$this->authentication->indonesian_date($data['penanggungjawab_tanggal'],'j F Y','');
        
        $data_sdmi = $this->spkp_pjas_a005_model->get_peserta_sdmi($id);
        $x=1;
        foreach($data_sdmi as $row_a){
            $sdmi[] = array('no'=>$x,'nama'=>$row_a->nama,'status'=>$row_a->status,'akreditasi'=>$row_a->akreditasi,'kantin'=>$row_a->kantin,'internet'=>$row_a->internet);
            $x++;
        }
        
        $data_komunitas = $this->spkp_pjas_a005_model->get_peserta_komunitas($id);
        $y=1;
        foreach($data_komunitas as $row_b){
            $komunitas[] = array('no'=>$y,'hari'=>"Hari ke - ".$row_b->hari,'kepsek'=>$row_b->kepsek,'guru_uks'=>$row_b->guru_uks,'guru'=>$row_b->guru,'kantin'=>$row_b->kantin,'komite'=>$row_b->komite,'kelas4'=>$row_b->kelas4,'kelas5'=>$row_b->kelas5,'lainnya'=>$row_b->lainnya,'total'=>$row_b->total);
            $y++;
        } 
        
        for($z=1;$z<=$hari['max'];$z++){
            $jml_hari[] = array('jml_hari'=>"H".$z);
        }
        
        $data_peserta = $this->spkp_pjas_a005_model->get_peserta_lintas_sektor($id);
        $a=1;
        foreach($data_peserta as $row_c){
                $peserta_hari = $this->spkp_pjas_a005_model->get_hari_peserta_lintas($id,$row_c->id_peserta);
                $jml_hari_peserta = array();
                foreach($peserta_hari as $row_hari){
                    $jml_hari_peserta[] = "H".$row_hari->hari;
                }
                $peserta[] = array('no'=>$a,'nama'=>$row_c->nama,'jabatan'=>$row_c->jabatan,'hari'=>implode(',',$jml_hari_peserta));
                $a++;
        }
        
        $data_materi = $this->spkp_pjas_a005_model->get_materi_bimtek($id);
        foreach($data_materi as $row_d){
            $materi[] = array('nama'=>$row_d->nama,'instansi'=>$row_d->instansi,'materi'=>$row_d->materi);
        }
        
        //print_r($peserta);
          
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/spkp_pjas_a005.docx';
		$TBS->LoadTemplate($template);
        
        $TBS->MergeBlock('psr', $peserta);
        $TBS->MergeBlock('hari', $jml_hari);
        $TBS->MergeBlock('mtr', $materi);
        $TBS->MergeBlock('kmn', $komunitas);
        $TBS->MergeBlock('sdmi', $sdmi);
		$output_file_name = $path.'export/report_spkp_pjas_a005.docx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
    }
    
    
}
?>