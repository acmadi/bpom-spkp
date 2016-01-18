<?php
class Spkp_pjas_a007b extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('spkp_pjas_a007b_model');
		$this->load->helper('html');
		$this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
	}
	
	function index($id_propinsi=0){
		$this->authentication->verify('spkp_pjas_a007b','show');
		
		$data['add_permission']=$this->authentication->verify_check('spkp_pjas_a007b','add');
		$data['title']="A007b Narasumber Pembinaan Keamanan Pangan Komunitas Sekolah pada Lintas Sektor";
		$data['content']= $this->parser->parse("spkp_pjas_a007b/show",$data,true);
		
		$this->template->show($data,'home');
	}
	
	function json_kegiatan(){
        die(json_encode($this->spkp_pjas_a007b_model->json_kegiatan()));
    }
    
    function add(){
		$this->authentication->verify('spkp_pjas_a007b','add');
		
		$data['option_balai'] = "";
		
		$data['balai']="";
		$data['add_permission']=$this->authentication->verify_check('spkp_pjas_a007b','add');
		$data['title']="Rekap";
		$data['action']="add";
		$data['form']=$this->parser->parse("spkp_pjas_a007b/form",$data);
	}
	
	function doadd(){
		$this->authentication->verify('spkp_pjas_a007b','add');
		
		$this->form_validation->set_rules('id','ID','trim|required');
		$this->form_validation->set_rules('ttd_nama','Nama Penanggung Jawab','trim|required');
		$this->form_validation->set_rules('id_balai','ID Balai','trim|required');
		$this->form_validation->set_rules('kegiatan_nama','Nama Kegiatan','trim|required');
		$this->form_validation->set_rules('kegiatan_tgl','Tanggal Kegiatan','trim|required');
		$this->form_validation->set_rules('kegiatan_tmpt','Tempat Kegiatan','trim|required');
		$this->form_validation->set_rules('kegiatan_penyelenggara','Penyelenggara Kegiatan','trim|required');
		
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a007b_model->insert_kegiatan();
		}
	}
	
	function edit($id){
        $this->authentication->verify('spkp_pjas_a007b','edit');

		$data = $this->spkp_pjas_a007b_model->get_data_kegiatan($id);
		$data['action']="edit";
		$data['add_permission']=$this->authentication->verify_check('spkp_pjas_a007b','edit');
		$data['title'] = "Narasumber Pembinaan Keamanan Pangan Komunitas Sekolah pada Lintas Sektor &raquo; Edit";
		$data['id']=$id;
		$data['form_edit'] = $this->parser->parse("spkp_pjas_a007b/form_edit",$data,true);
		$data['show_petugas'] = $this->parser->parse("spkp_pjas_a007b/show_petugas",$data,true);
		$data['show_materi'] = $this->parser->parse("spkp_pjas_a007b/show_materi",$data,true);
		$data['show_peserta'] = $this->parser->parse("spkp_pjas_a007b/show_peserta",$data,true);
		$data['show_komposisi'] = $this->parser->parse("spkp_pjas_a007b/show_komposisi",$data,true);
		$data['show_pesertalintas'] = $this->parser->parse("spkp_pjas_a007b/show_pesertalintas",$data,true);
        $data['content'] = $this->parser->parse("spkp_pjas_a007b/show_edit",$data,true);

		$this->template->show($data,"home");
    }
	
	function doedit(){
		$this->authentication->verify('spkp_pjas_a007b','edit');
		
		$this->form_validation->set_rules('id','ID','trim|required');
		$this->form_validation->set_rules('ttd_nama','Nama Penanggung Jawab','trim|required');
		$this->form_validation->set_rules('id_balai','ID Balai','trim|required');
		$this->form_validation->set_rules('kegiatan_nama','Nama Kegiatan','trim|required');
		$this->form_validation->set_rules('kegiatan_tgl','Tanggal Kegiatan','trim|required');
		$this->form_validation->set_rules('kegiatan_tmpt','Tempat Kegiatan','trim|required');
		$this->form_validation->set_rules('kegiatan_penyelenggara','Penyelenggara Kegiatan','trim|required');
		
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a007b_model->update_kegiatan();
			echo "1";
		}
	}
	
	function dodel($id){
		$this->authentication->verify('spkp_pjas_a007b','del');
		
		if($this->spkp_pjas_a007b_model->delete_kegiatan($id)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
	
	function json_petugas($id){
        die(json_encode($this->spkp_pjas_a007b_model->json_petugas($id)));
    }
	
	function add_petugas($id){
		$this->authentication->verify('spkp_pjas_a007b','add');
		
		$data['add_permission']=$this->authentication->verify_check('spkp_pjas_a007b','add');
		$data['action']="add";
		$data['id']=$id;
		$data['form']=$this->parser->parse("spkp_pjas_a007b/form_petugas",$data);
	}
	
	function doadd_petugas(){
		$this->authentication->verify('spkp_pjas_a007b','add');
		
		$this->form_validation->set_rules('id','ID','trim|required');
		$this->form_validation->set_rules('id_petugas','ID Petugas','trim|required');
		$this->form_validation->set_rules('nama','Nama Petugas','trim|required');
		
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a007b_model->insert_petugas();
			echo "1";
		}
	}
	
	function dodel_petugas($id_petugas){
		$this->authentication->verify('spkp_pjas_a007b','del');
		
		if($this->spkp_pjas_a007b_model->delete_petugas($id_petugas)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
	
	function json_materi($id){
        die(json_encode($this->spkp_pjas_a007b_model->json_materi($id)));
    }
	
	function add_materi($id){
		$this->authentication->verify('spkp_pjas_a007b','add');
		
		$data['add_permission']=$this->authentication->verify_check('spkp_pjas_a007b','add');
		$data['action']="add";
		$data['id']=$id;
		$data['form']=$this->parser->parse("spkp_pjas_a007b/form_materi",$data);
	}
	
	function doadd_materi(){
		$this->authentication->verify('spkp_pjas_a007b','add');
		
		$this->form_validation->set_rules('id','ID','trim|required');
		$this->form_validation->set_rules('id_materi','ID Peserta','trim|required');
		$this->form_validation->set_rules('materi','Materi','trim|required');
		
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a007b_model->insert_materi();
			echo "1";
		}
	}
	
	function dodel_materi($id_materi){
		$this->authentication->verify('spkp_pjas_a007b','del');
		
		if($this->spkp_pjas_a007b_model->delete_materi($id_materi)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
	
	function json_peserta($id){
        die(json_encode($this->spkp_pjas_a007b_model->json_peserta($id)));
    }
	
	function add_peserta($id){
		$this->authentication->verify('spkp_pjas_a007b','add');
		
		$data['add_permission']=$this->authentication->verify_check('spkp_pjas_a007b','add');
		$data['action']="add";
		$data['id']=$id;
		$data['form']=$this->parser->parse("spkp_pjas_a007b/form_peserta",$data);
	}
	
	function doadd_peserta(){
		$this->authentication->verify('spkp_pjas_a007b','add');
		
		$this->form_validation->set_rules('id','ID','trim|required');
		$this->form_validation->set_rules('id_peserta','ID Peserta','trim|required');
		$this->form_validation->set_rules('nama','Nama SD/MI','trim|required');
		
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a007b_model->insert_peserta();
			echo "1";
		}
	}
	
	function edit_peserta($id_peserta){
		$this->authentication->verify('spkp_pjas_a007b','edit');
		
		$data = $this->spkp_pjas_a007b_model->get_data_peserta($id_peserta);
		$data['add_permission']=$this->authentication->verify_check('spkp_pjas_a007b','edit');
		$data['action']="edit";
		$data['id_peserta']=$id_peserta;
		$data['form']=$this->parser->parse("spkp_pjas_a007b/form_peserta",$data);
	}
	
	function doedit_peserta(){
		$this->authentication->verify('spkp_pjas_a007b','edit');
		
		$this->form_validation->set_rules('id','ID','trim|required');
		$this->form_validation->set_rules('id_peserta','ID Peserta','trim|required');
		$this->form_validation->set_rules('nama','Nama SD/MI','trim|required');
		
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a007b_model->update_peserta();
			echo "1";
		}
	}
	
	function dodel_peserta($id_peserta){
		$this->authentication->verify('spkp_pjas_a007b','del');
		
		if($this->spkp_pjas_a007b_model->delete_peserta($id_peserta)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
	
	function json_komposisi($id){
        die(json_encode($this->spkp_pjas_a007b_model->json_komposisi($id)));
    }
	
	function edit_komposisi($id){
		$this->authentication->verify('spkp_pjas_a007b','edit');
		
		$data = $this->spkp_pjas_a007b_model->get_data_komposisi($id);
		$data['add_permission']=$this->authentication->verify_check('spkp_pjas_a007b','edit');
		$data['action']="edit";
		$data['id']=$id;
		$data['form']=$this->parser->parse("spkp_pjas_a007b/form_komposisi",$data);
	}
	
	function doedit_komposisi(){
		$this->authentication->verify('spkp_pjas_a007b','edit');
		
		$this->form_validation->set_rules('id','ID','trim|required');
		$this->form_validation->set_rules('jml_kepsek','Jumlah Kepsek','trim|required');
		$this->form_validation->set_rules('jml_guru','Jumlah Guru','trim|required');
		$this->form_validation->set_rules('jml_kantin','Jumlah Pengelola Kantin','trim|required');
		$this->form_validation->set_rules('jml_pedagang','Jumlah Pedagang PJAS','trim|required');
		$this->form_validation->set_rules('jml_komite','Jumlah Komite Sekolah','trim|required');
		$this->form_validation->set_rules('jml_siswa','Jumlah Siswa','trim|required');
		
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a007b_model->update_komposisi();
			echo "1";
		}
	}
	
	function json_pesertalintas($id){
        die(json_encode($this->spkp_pjas_a007b_model->json_pesertalintas($id)));
    }
	
	function add_pesertalintas($id){
		$this->authentication->verify('spkp_pjas_a007b','add');
		
		$data['add_permission']=$this->authentication->verify_check('spkp_pjas_a007b','add');
		$data['action']="add";
		$data['id']=$id;
		$data['form']=$this->parser->parse("spkp_pjas_a007b/form_pesertalintas",$data);
	}
	
	function doadd_pesertalintas(){
		$this->authentication->verify('spkp_pjas_a007b','add');
		
		$this->form_validation->set_rules('id','ID','trim|required');
		$this->form_validation->set_rules('id_peserta','ID Peserta','trim|required');
		$this->form_validation->set_rules('nama','Nama','trim|required');
		$this->form_validation->set_rules('instansi','Instansi','trim|required');
		
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a007b_model->insert_pesertalintas();
			echo "1";
		}
	}
	
	function edit_pesertalintas($id_peserta){
		$this->authentication->verify('spkp_pjas_a007b','edit');
		
		$data = $this->spkp_pjas_a007b_model->get_data_pesertalintas($id_peserta);
		$data['add_permission']=$this->authentication->verify_check('spkp_pjas_a007b','edit');
		$data['action']="edit";
		$data['id_peserta']=$id_peserta;
		$data['form']=$this->parser->parse("spkp_pjas_a007b/form_pesertalintas",$data);
	}
	
	function doedit_pesertalintas(){
		$this->authentication->verify('spkp_pjas_a007b','edit');
		
		$this->form_validation->set_rules('id','ID','trim|required');
		$this->form_validation->set_rules('id_peserta','ID Peserta','trim|required');
		$this->form_validation->set_rules('nama','Nama','trim|required');
		$this->form_validation->set_rules('instansi','Instansi','trim|required');
		
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_pjas_a007b_model->update_pesertalintas();
			echo "1";
		}
	}
	
	function dodel_pesertalintas($id_peserta){
		$this->authentication->verify('spkp_pjas_a007b','del');
		
		if($this->spkp_pjas_a007b_model->delete_pesertalintas($id_peserta)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}
	
	function export($id){
        $this->authentication->verify('spkp_pjas_a007b','show');
		
		$data = $this->spkp_pjas_a007b_model->json_petugas($id);
		$data2 = $this->spkp_pjas_a007b_model->json_materi($id);
		$data3 = $this->spkp_pjas_a007b_model->json_peserta($id);
		$data4 = $this->spkp_pjas_a007b_model->json_pesertalintas($id);
		$data5 = $this->spkp_pjas_a007b_model->json_komposisi($id);

		$rows = $data[0]['Rows'];
		$rows2 = $data2[0]['Rows'];
		$rows3 = $data3[0]['Rows'];
		$rows4 = $data4[0]['Rows'];
		$rows5 = $data5[0]['Rows'];
		
		$val= $this->spkp_pjas_a007b_model->count_peserta($id);
		
		foreach($val as $value){
			$data['jml_peserta']=$value->jml_peserta;
		}
		
		$data['balai'] = $this->input->post('balai');
		$data['kegiatan_nama'] = $this->input->post('kegiatan_nama');
		
		$angkabln=array('01','02','03','04','05','06','07','08','09','10','11','12');
		$indobln=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus',
		'September','Oktober','November','Desember');
		
		$data['kegiatan_tgl'] = substr($this->input->post('kegiatan_tgl'),8,2);
		$data['kegiatan_tgl'] .= " "+str_ireplace($angkabln,$indobln,(substr($this->input->post('kegiatan_tgl'),5,2)));
		$data['kegiatan_tgl'] .= " "+substr($this->input->post('kegiatan_tgl'),0,4);
		
		$data['kegiatan_tmpt'] = $this->input->post('kegiatan_tmpt');
		$data['kegiatan_penyelenggara'] = $this->input->post('kegiatan_penyelenggara');
		
		$data['ttd_tmpt'] = $this->input->post('ttd_tmpt');
		
		$data['ttd_tgl'] = substr($this->input->post('ttd_tgl'),8,2);
		$data['ttd_tgl'] .= " "+str_ireplace($angkabln,$indobln,(substr($this->input->post('ttd_tgl'),5,2)));
		$data['ttd_tgl'] .= " "+substr($this->input->post('ttd_tgl'),0,4);
		
		$data['ttd_nama'] = $this->input->post('ttd_nama');
		$data['ttd_nip'] = $this->input->post('ttd_nip');
		
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data &$data2 &$data3 &$data4 &$data5;
		$template = $path.'templates/spkp_pjas_a007b.docx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data',$rows);
		$TBS->MergeBlock('data2',$rows2);
		$TBS->MergeBlock('data3',$rows3);
		$TBS->MergeBlock('data4',$rows4);
		$TBS->MergeBlock('data5',$rows5);
		$output_file_name = $path.'export/report_spkp_pjas_a007b.docx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
    }
	
}
