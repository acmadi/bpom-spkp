<?php
class Spkp_pjas_a020 extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('spkp_pjas_a020_model');
        $this->load->helper('html');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
    }
    
    function index(){
        $this->authentication->verify('spkp_pjas_a020','show');
        
        $data = array();
        $data['title'] = "Form A020. Evaluasi dan Pelaporan Pelatihan Fasilitator Keamanan PJAS";
        
        $data['add_permission']=$this->authentication->verify_check('spkp_pjas_a020','add');
        $data['content'] = $this->parser->parse("spkp_pjas_a020/show",$data,true);
        $this->template->show($data,"home");
    }
    
    function json_form(){
        die(json_encode($this->spkp_pjas_a020_model->json_form()));
    }
    
    function add_form(){
        $this->authentication->verify('spkp_pjas_a020','add');
		$data['action']="add";

		echo $this->parser->parse("spkp_pjas_a020/form_add",$data,true);
    }
    
    function doadd_form(){
        $this->authentication->verify('spkp_pjas_a020','add');

		$this->form_validation->set_rules('penyelenggara', 'Penyelenggara Pelatihan', 'trim|required');
        $this->form_validation->set_rules('tempat', 'Tempat Penyelenggaraan', 'trim|required');
        $this->form_validation->set_rules('tgl', 'Tanggal pelaksanaan', 'trim|required');
        $this->form_validation->set_rules('ttd_tmpt', 'Tempat Penanggung Jawab', 'trim|required');
        $this->form_validation->set_rules('ttd_tgl', 'Tanggal Penanggung Jawab', 'trim|required');
        $this->form_validation->set_rules('ttd_nama', 'Nama Penanggung Jawab', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a020_model->insert_form();
		}
    }
    
    function dodel_form($id){
        $this->authentication->verify('spkp_pjas_a020','del');

		if($this->spkp_pjas_a020_model->delete_form($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function doedit_form($id){
        $this->authentication->verify('spkp_pjas_a020','edit');
        
        $this->form_validation->set_rules('penyelenggara', 'Penyelenggara Pelatihan', 'trim|required');
        $this->form_validation->set_rules('tempat', 'Tempat Penyelenggaraan', 'trim|required');
        $this->form_validation->set_rules('tgl', 'Tanggal pelaksanaan', 'trim|required');
        $this->form_validation->set_rules('ttd_tmpt', 'Tempat Penanggung Jawab', 'trim|required');
        $this->form_validation->set_rules('ttd_tgl', 'Tanggal Penanggung Jawab', 'trim|required');
        $this->form_validation->set_rules('ttd_nama', 'Nama Penanggung Jawab', 'trim|required');
		
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a020_model->update_form($id);
			echo "1"; 
		}
    }
    
    function doedit_form_detail($id){
        $this->authentication->verify('spkp_pjas_a020','edit');
        
        $this->form_validation->set_rules('penyelenggara', 'Penyelenggara Pelatihan', 'trim');
        $this->form_validation->set_rules('tempat', 'Tempat Penyelenggaraan', 'trim');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a020_model->update_detail_narasumber($id);
			echo "1"; 
		}
    }
    
    function load_form($id){
        $this->authentication->verify('spkp_pjas_a020','edit');
		$data = $this->spkp_pjas_a020_model->get_form($id);
        
		echo $this->parser->parse("spkp_pjas_a020/form",$data,true);
    }
    
    function load_form_detail($id){
        $this->authentication->verify('spkp_pjas_a020','edit');
		$data = $this->spkp_pjas_a020_model->get_form($id);
        
		echo $this->parser->parse("spkp_pjas_a020/form_detail",$data,true);
    }
    
    function load_form_count($id){
        $this->authentication->verify('spkp_pjas_a020','edit');
		$data = array();
        $data['count'] = $this->spkp_pjas_a020_model->count_peserta($id);
        
		echo $this->parser->parse("spkp_pjas_a020/form_count_peserta",$data,true);
    }
    
    function edit($id){
        $this->authentication->verify('spkp_pjas_a020','add');
        
        if($this->spkp_pjas_a020_model->check_form($id)>0){
            
            $data = $this->spkp_pjas_a020_model->get_form($id);
            $data['title'] = "Form A020. Evaluasi dan Pelaporan Pelatihan Fasilitator Keamanan PJAS &raquo; Edit";
            $data['id'] = $id;
            $data['count'] = $this->spkp_pjas_a020_model->count_peserta($id);
            $data['count_peserta'] = $this->parser->parse("spkp_pjas_a020/form_count_peserta",$data,true);
            $data['form_detail'] = $this->parser->parse("spkp_pjas_a020/form_detail",$data,true);
            $data['add_permission']=$this->authentication->verify_check('spkp_pjas_a020','add');
            $data['form'] = $this->parser->parse("spkp_pjas_a020/form",$data,true);
            $data['form_narasumber'] = $this->parser->parse("spkp_pjas_a020/form_narasumber",$data,true);
            $data['form_peserta'] = $this->parser->parse("spkp_pjas_a020/form_peserta",$data,true);
            $data['content'] = $this->parser->parse("spkp_pjas_a020/show_edit",$data,true);
            $this->template->show($data,"home");
            
        }else{
            return false;
        }
    }
    
    function json_narasumber($id){
        die(json_encode($this->spkp_pjas_a020_model->json_narasumber($id)));
    }
    
    function add_narasumber($id){
        $this->authentication->verify('spkp_pjas_a020','add');
		$data['action']="add";
        $data['id'] = $id;
        
		echo $this->parser->parse("spkp_pjas_a020/form_add_narasumber",$data,true);
    }
    
    function doadd_narasumber($id){
        $this->authentication->verify('spkp_pjas_a020','add');

		$this->form_validation->set_rules('nama', 'Nama Narasumber', 'trim|required');
        $this->form_validation->set_rules('materi', 'Materi yang disampaikan', 'trim|required');
     
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a020_model->insert_narasumber($id);
			echo "1"; 
		}
    }
    
    function edit_narasumber($id,$nara){
        $this->authentication->verify('spkp_pjas_a020','edit');
        
        $data = $this->spkp_pjas_a020_model->get_narasumber($id,$nara);
		$data['action']="edit";
        $data['id'] = $id;
        
		echo $this->parser->parse("spkp_pjas_a020/form_add_narasumber",$data,true);
    }
    
    function doedit_narasumber($id){
        $this->authentication->verify('spkp_pjas_a020','edit');

		$this->form_validation->set_rules('nama', 'Nama Narasumber', 'trim|required');
        $this->form_validation->set_rules('materi', 'Materi yang disampaikan', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a020_model->update_narasumber($id);
			echo "1"; 
		}
    }
    
    function dodel_narasumber($id,$nara){
        $this->authentication->verify('spkp_pjas_a020','del');

		if($this->spkp_pjas_a020_model->delete_narasumber($id,$nara)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function json_peserta($id){
        die(json_encode($this->spkp_pjas_a020_model->json_peserta($id)));
    }
    
    function add_peserta($id){
        $this->authentication->verify('spkp_pjas_a020','add');
		$data['action']="add";
        $data['id'] = $id;
        
		echo $this->parser->parse("spkp_pjas_a020/form_add_peserta",$data,true);
    }
    
    function doadd_peserta($id){
        $this->authentication->verify('spkp_pjas_a020','add');

		$this->form_validation->set_rules('nama', 'Nama Peserta', 'trim|required');
        $this->form_validation->set_rules('pre_test', 'Pre test', 'trim|required');
        $this->form_validation->set_rules('post_test', 'Post test', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a020_model->insert_peserta($id);
			echo "1"; 
		}
    }
    
    function edit_peserta($id,$peserta){
        $this->authentication->verify('spkp_pjas_a020','edit');
        
        $data = $this->spkp_pjas_a020_model->get_peserta($id,$peserta);
		$data['action']="edit";
        $data['id'] = $id;
        
		echo $this->parser->parse("spkp_pjas_a020/form_add_peserta",$data,true);
    }
    
    function doedit_peserta($id){
        $this->authentication->verify('spkp_pjas_a020','edit');

		$this->form_validation->set_rules('nama', 'Nama Peserta', 'trim|required');
        $this->form_validation->set_rules('pre_test', 'Pre test', 'trim|required');
        $this->form_validation->set_rules('post_test', 'Post test', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a020_model->update_peserta($id);
			echo "1"; 
		}
    }
    
    function dodel_peserta($id,$peserta){
        $this->authentication->verify('spkp_pjas_a020','del');

		if($this->spkp_pjas_a020_model->delete_peserta($id,$peserta)){
			echo "1";
		}else{
			echo "Delete Error";
		}
    }
    
    function export($id){
        $this->authentication->verify('spkp_pjas_a020','show');

		$data = $this->spkp_pjas_a020_model->get_form($id);
        $data['title'] = "Form A020. Evaluasi dan Pelaporan Pelatihan Fasilitator Keamanan PJAS";
        $data['tanggal'] = $this->authentication->indonesian_date($data['ttd_tgl'],'l, j F Y','');
        $data['tanggal_form'] = $data['ttd_tmpt'].", ".$this->authentication->indonesian_date($data['ttd_tgl'],'j F Y','');
        $data['count'] = $this->spkp_pjas_a020_model->count_peserta($id);
        
        $data_nara = $this->spkp_pjas_a020_model->get_all_narasumber($id);
        $x = 1;
        foreach($data_nara as $row_a){
            $nara[] = array('nama'=>$x.". ".$row_a->nama,'materi'=>$row_a->materi);
            $x++;
        } 
        
        $data_pst = $this->spkp_pjas_a020_model->get_all_peserta($id);
        $y = 1;
        foreach($data_pst as $row_b){
            $peserta[] = array('nama'=>$y.". ".$row_b->nama,'institusi'=>$row_b->institusi,'pre_test'=>$row_b->pre_test,'post_test'=>$row_b->post_test);
            $y++;
        } 
          
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/spkp_pjas_a020.docx';
		$TBS->LoadTemplate($template);
        
        $TBS->MergeBlock('peserta', $peserta);
     	$TBS->MergeBlock('nara', $nara);
		$output_file_name = $path.'export/report_spkp_pjas_a020.docx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
    }
}
?>