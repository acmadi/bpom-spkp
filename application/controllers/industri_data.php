<?php
class Industri_data extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model('industri_data_model');
		$this->load->model('industri_master_model');
		$this->load->model('location_model');
		$this->load->helper('html');
	}
	
	function index()
	{
		$this->authentication->verify('industri_data','edit');
		$industri = $this->industri_data_model->get_industri();

		$data = $this->industri_master_model->get_data_row($industri['id_industri']); 
		$data["id"]		= $industri['id_industri'];
		$data['title']	= "Master Data Industri &raquo; ".(isset($data['nama_industri']) ? $data['nama_industri'] : "Silahkan Lengkapi Data Industri Anda");
		$data["act"]	= "edit";
		$data["tab"]	= 1;
		$data["pabrik"] = $this->industri_master_model->get_list_pabrik($industri['id_industri']);
		$data["kantor"] = $this->industri_master_model->get_list_kantor($industri['id_industri']); 
		$data['content'] = $this->parser->parse("ske/industri_data/form_industri",$data,true);
		$this->template->show($data,"home");
	}

	function tab($id_industri,$tab = "tab2")
	{
		$this->authentication->verify('industri_data','add');
		$data = $this->industri_master_model->get_data_row($id_industri); 
		$data["act"]	= "edit";
		$data["id"]		= $id_industri;
		$data["pabrik"] = $this->industri_master_model->get_list_pabrik($id_industri);
		$data["kantor"] = $this->industri_master_model->get_list_kantor($id_industri); 
		$data['content'] = $this->parser->parse("ske/industri_data/form_industri_".$tab,$data,true);
		die($data['content']);
	}

	function add_pabrik($id_industri="")
	{
		$this->authentication->verify('industri_data','edit');
		$data = array(); 
		$data['title']	= "Master Data Industri &raquo; Tambah Pabrik";
		$data["act"]	= "add_pabrik";
		$data["id"]		= $id_industri;
		die($this->parser->parse("ske/industri_data/form_industri_pabrik",$data));
	}

	function edit_pabrik($id_industri="",$id_plant=0)
	{
		$this->authentication->verify('industri_data','edit');
		$data = $this->industri_master_model->get_pabrik($id_industri,$id_plant); 
		$data['title']		= "Master Data Industri &raquo; Ubah Pabrik";
		$data["act"]		= "edit_pabrik";
		$data["id"]			= $id_industri;
		$data["id_plant"]	= $id_plant;
		die($this->parser->parse("ske/industri_data/form_industri_pabrik",$data));
	}

	function edit_pabrik_jenis($id_industri="",$id_plant=0)
	{
		$this->authentication->verify('industri_data','edit');
		$data = $this->industri_master_model->get_pabrik($id_industri,$id_plant); 
		$data['title']		= "Master Data Industri &raquo; Jenis Pabrik";
		$data["act"]		= "edit_pabrik";
		$data["id"]			= $id_industri;
		$data["id_plant"]	= $id_plant;
		die($this->parser->parse("ske/industri_data/form_industri_pabrik_jenis",$data));
	}

	function edit_pabrik_fasilitas($id_industri="",$id_plant=0)
	{
		$this->authentication->verify('industri_data','edit');
		$data = $this->industri_master_model->get_pabrik($id_industri,$id_plant); 
		$data['title']		= "Master Data Industri &raquo; Fasilitas Pabrik";
		$data["act"]		= "edit_pabrik";
		$data["id"]			= $id_industri;
		$data["id_plant"]	= $id_plant;
		die($this->parser->parse("ske/industri_data/form_industri_pabrik_fasilitas",$data));
	}

	function doadd_pabrik($id_industri="")
	{
		$this->authentication->verify('industri_data','add');

		$this->form_validation->set_rules('alamat_pabrik', 'Alamat Pabrik', 'trim|required');
        

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->industri_master_model->insert_entry_pabrik($id_industri);
			echo "1";
		}
	}

	function dodel_pabrik($id_industri=0,$id_pabrik){
		$this->authentication->verify('industri_data','del');

		if($this->industri_master_model->delete_entry_pabrik($id_industri,$id_pabrik)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}

	function add_jenis($id_industri="",$id_plant=0)
	{
		$this->authentication->verify('industri_data','edit');
		$data = array(); 
		$data['title']	= "Master Data Industri &raquo; Tambah Jenis Pabrik";
		$data["act"]	= "add_jenis";
		$data["id"]		= $id_industri;
		$data["id_plant"]	= $id_plant;
		$data["timestamp"]	= time();
		die($this->parser->parse("ske/industri_data/form_industri_jenis",$data));
	}

	function edit_jenis($id_industri="",$id_plant=0,$id_jenis=0)
	{
		$this->authentication->verify('industri_data','edit');
		$data = $this->industri_master_model->get_jenis($id_industri,$id_plant,$id_jenis); 
		$data['title']		= "Master Data Industri &raquo; Ubah Jenis Pabrik";
		$data["act"]		= "edit_jenis";
		$data["id"]			= $id_industri;
		$data["id_plant"]	= $id_plant;
		$data["id_jenis"]	= $id_jenis;
		$data["timestamp"]	= time();
		die($this->parser->parse("ske/industri_data/form_industri_jenis",$data));
	}

	function doadd_jenis($id_industri="",$id_plant=0)
	{
		$this->authentication->verify('industri_data','add');

		$this->form_validation->set_rules('id_jenis', 'Jenis', 'trim|required');
		$this->form_validation->set_rules('penanggungjawab', 'Penanggung Jawab', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->industri_master_model->insert_entry_jenis($id_industri,$id_plant);
			echo "1";
		}
	}
	
	function dodel_jenis($id_industri=0,$id_plant,$id_jenis){
		$this->authentication->verify('industri_data','del');

		if($this->industri_master_model->delete_entry_jenis($id_industri,$id_plant,$id_jenis)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}

	function add_fasilitas($id_industri="",$id_plant=0)
	{
		$this->authentication->verify('industri_data','edit');
		$data = array(); 
		$data['title']	= "Master Data Industri &raquo; Tambah Fasilitas Pabrik";
		$data["act"]	= "add_fasilitas";
		$data["id"]		= $id_industri;
		$data["id_plant"]	= $id_plant;
		$data["timestamp"]	= time();
		die($this->parser->parse("ske/industri_data/form_industri_fasilitas",$data));
	}

	function edit_fasilitas($id_industri="",$id_plant=0,$id_fasilitas=0)
	{
		$this->authentication->verify('industri_data','edit');
		$data = $this->industri_master_model->get_fasilitas($id_industri,$id_plant,$id_fasilitas); 
		$data['title']		= "Master Data Industri &raquo; Ubah Fasilitas Pabrik";
		$data["act"]		= "edit_fasilitas";
		$data["id"]			= $id_industri;
		$data["id_plant"]	= $id_plant;
		$data["id_fasilitas"]	= $id_fasilitas;
		$data["timestamp"]	= time();
		die($this->parser->parse("ske/industri_data/form_industri_fasilitas",$data));
	}

	function doadd_fasilitas($id_industri="",$id_plant=0)
	{
		$this->authentication->verify('industri_data','add');

		$this->form_validation->set_rules('id_fasilitas', 'Fasilitas', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->industri_master_model->insert_entry_fasilitas($id_industri,$id_plant);
			echo "1";
		}
	}
	
	function dodel_fasilitas($id_industri=0,$id_plant,$id_fasilitas){
		$this->authentication->verify('industri_data','del');

		if($this->industri_master_model->delete_entry_fasilitas($id_industri,$id_plant,$id_fasilitas)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}

	function edit_jenissediaan($id_industri="",$id_plant=0,$id_jenis=0)
	{
		$this->authentication->verify('industri_data','edit');
		$data = $this->industri_master_model->get_jenis($id_industri,$id_plant,$id_jenis); 
		$data['pabrik']		= $this->industri_master_model->get_pabrik($id_industri,$id_plant); 
		$data['jenis']		= $this->industri_master_model->get_mas_jenis($id_jenis); 
		$data['title']		= "Master Data Industri &raquo; Daftar Bentuk Sediaan";
		$data["id"]			= $id_industri;
		$data["id_plant"]	= $id_plant;
		$data["id_jenis"]	= $id_jenis;
		$data["timestamp"]	= time();
		die($this->parser->parse("ske/industri_data/form_industri_bentuksediaan",$data));
	}

	function add_kantor($id_industri="")
	{
		$this->authentication->verify('industri_data','edit');
		$data = array(); 
		$data['title']	= "Master Data Industri &raquo; Tambah Kantor";
		$data["act"]	= "add_kantor";
		$data["id"]		= $id_industri;
		die($this->parser->parse("ske/industri_data/form_industri_kantor",$data));
	}

	function edit_kantor($id_industri="",$id_kantor=0)
	{
		$this->authentication->verify('industri_data','edit');
		$data = $this->industri_master_model->get_kantor($id_industri,$id_kantor); 
		$data['title']		= "Master Data Industri &raquo; Ubah Kantor";
		$data["act"]		= "edit_kantor";
		$data["id"]			= $id_industri;
		$data["id_kantor"]	= $id_kantor;
		die($this->parser->parse("ske/industri_data/form_industri_kantor",$data));
	}

	function doadd_kantor($id_industri="")
	{
		$this->authentication->verify('industri_data','add');

		$this->form_validation->set_rules('alamat_kantor', 'Alamat Kantor', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->industri_master_model->insert_entry_kantor($id_industri);
			echo "1";
		}
	}

	function dodel_kantor($id_industri=0,$id_kantor=0){
		$this->authentication->verify('industri_data','del');

		if($this->industri_master_model->delete_entry_kantor($id_industri,$id_kantor)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}

	function add_direksi($id_industri="")
	{
		$this->authentication->verify('industri_data','edit');
		$data = array(); 
		$data['title']	= "Master Data Industri &raquo; Tambah Karyawan / Direksi";
		$data["act"]	= "add_direksi";
		$data["id"]		= $id_industri;
		die($this->parser->parse("ske/industri_data/form_industri_direksi",$data));
	}

	function edit_direksi($id_industri="",$id_direksi=0)
	{
		$this->authentication->verify('industri_data','edit');
		$data = $this->industri_master_model->get_direksi($id_industri,$id_direksi); 
		$data['title']		= "Master Data Industri &raquo; Ubah Karyawan / Direksi";
		$data["act"]		= "edit_direksi";
		$data["id"]			= $id_industri;
		$data["id_direksi"]	= $id_direksi;
		die($this->parser->parse("ske/industri_data/form_industri_direksi",$data));
	}

	function doadd_direksi($id_industri="")
	{
		$this->authentication->verify('industri_data','add');

		$this->form_validation->set_rules('nama_direksi', 'Nama Karyawan / Direksi', 'trim|required');
        

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->industri_master_model->insert_entry_direksi($id_industri);
			echo "1";
		}
	}

	function dodel_direksi($id_industri=0,$id_direksi){
		$this->authentication->verify('industri_data','del');

		if($this->industri_master_model->delete_entry_direksi($id_industri,$id_direksi)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}

	function add_bentuksediaan($id_industri="",$id_plant=0,$id_jenis=0)
	{
		$this->authentication->verify('industri_data','edit');
		$data = array(); 
		$data['title']	= "Master Data Industri &raquo; Tambah Bentuk Sediaan";
		$data["act"]	= "add_bentuksediaan";
		$data["id"]			= $id_industri;
		$data["id_plant"]	= $id_plant;
		$data["id_jenis"]	= $id_jenis;
		$data["timestamp"]	= time();
		die($this->parser->parse("ske/industri_data/form_industri_bentuksediaan_form",$data));
	}

	function edit_bentuksediaan($id_industri="",$id_bentuksediaan=0,$id_plant=0,$id_jenis=0)
	{
		$this->authentication->verify('industri_data','edit');
		$data = $this->industri_master_model->get_bentuksediaan($id_industri,$id_bentuksediaan,$id_plant); 
		$data['title']		= "Master Data Industri &raquo; Ubah Bentuk Sediaan";
		$data["act"]		= "edit_bentuksediaan";
		$data["id"]			= $id_industri;
		$data["bentuksediaan"]	= $id_bentuksediaan;
		$data["id_plant"]		= $id_plant;
		$data["id_jenis"]		= $id_jenis;
		$data["timestamp"]	= time();
		die($this->parser->parse("ske/industri_data/form_industri_bentuksediaan_form",$data));
	}

	function doadd_bentuksediaan($id_industri="",$id_plant=0,$id_bentuksediaan=0,$id_jenis=0)
	{
		$this->authentication->verify('industri_data','add');

		$this->form_validation->set_rules('bentuk_sediaan', 'Bentuk Sediaan', 'trim|required');
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->industri_master_model->insert_entry_bentuksediaan($id_industri,$id_plant);
			echo "1";
		}
	}

	function dodel_bentuksediaan($id_industri=0,$id_bentuksediaan,$id_plant){
		$this->authentication->verify('industri_data','del');

		if($this->industri_master_model->delete_entry_bentuksediaan($id_industri,$id_bentuksediaan,$id_plant)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}

	function add_izin($id_industri="")
	{
		$this->authentication->verify('industri_data','edit');
		$data = array(); 
		$data['title']	= "Master Data Industri &raquo; Tambah Izin / SK";
		$data["act"]	= "add_izin";
		$data["id"]		= $id_industri;
		die($this->parser->parse("ske/industri_data/form_industri_izin",$data));
	}

	function edit_izin($id_industri="",$id_izin=0)
	{
		$this->authentication->verify('industri_data','edit');
		$data = $this->industri_master_model->get_izin($id_industri,$id_izin); 
		$data['title']		= "Master Data Industri &raquo; Ubah Izin / SK";
		$data["act"]		= "edit_izin";
		$data["id"]			= $id_industri;
		$data["id_izin"]	= $id_izin;
		die($this->parser->parse("ske/industri_data/form_industri_izin",$data));
	}

	function doadd_izin($id_industri="")
	{
		$this->authentication->verify('industri_data','add');

		$this->form_validation->set_rules('id_izin', 'Nama Izin / SK', 'trim|required');
		$this->form_validation->set_rules('nomor', 'Nomor Izin', 'trim|required');        

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->industri_master_model->insert_entry_izin($id_industri);
			echo "1";
		}
	}

	function dodel_izin($id_industri=0,$id_izin){
		$this->authentication->verify('industri_data','del');

		if($this->industri_master_model->delete_entry_izin($id_industri,$id_izin)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}

	function doedit($id_industri="")
	{
		$this->authentication->verify('industri_data','add');

		$this->form_validation->set_rules('nama_industri', 'Nama Industri', 'trim|required');
		$this->form_validation->set_rules('id_status', 'Status Industri', 'trim|required');
        $this->form_validation->set_rules('id_jenis', 'Jenis Industri', 'trim|required');
        $this->form_validation->set_rules('bentuk_usaha', 'Bentuk Usaha', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			if($id_industri==""){
				$this->industri_data_model->insert_entry();
			}else{
				$this->industri_master_model->update_entry($id_industri);
			}
			echo "1";
		}
	}

	function doedit_kantor($id_industri,$id_kantor)
	{
		$this->authentication->verify('industri_data','add');

		$this->form_validation->set_rules('alamat_kantor', 'Alamat Kantor', 'trim|required');
        

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->industri_master_model->update_entry_kantor($id_industri,$id_kantor);
			echo "1";
		}
	}

	function doedit_pabrik($id_industri,$id_plant)
	{
		$this->authentication->verify('industri_data','add');

		$this->form_validation->set_rules('alamat_pabrik', 'Alamat Pabrik', 'trim|required');
        

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->industri_master_model->update_entry_pabrik($id_industri,$id_plant);
			echo "1";
		}
	}

	function doedit_direksi($id_industri,$id_direksi)
	{
		$this->authentication->verify('industri_data','add');

		$this->form_validation->set_rules('nama_direksi', 'Nama Karyawan / Direksi', 'trim|required');
        

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->industri_master_model->update_entry_direksi($id_industri,$id_direksi);
			echo "1";
		}
	}

	function doedit_bentuksediaan($id_industri,$id_plant,$bentuksediaan)
	{
		$this->authentication->verify('industri_data','add');

		$this->form_validation->set_rules('bentuk_sediaan', 'Bentuk Sediaan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->industri_master_model->update_entry_bentuksediaan($id_industri,$id_plant,$bentuksediaan);
			echo "1";
		}
	}

	function doedit_izin($id_industri,$id_izin)
	{
		$this->authentication->verify('industri_data','add');

		$this->form_validation->set_rules('id_izin', 'Nama Izin', 'trim|required');
		$this->form_validation->set_rules('nomor', 'Nomor Izin', 'trim|required');        

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->industri_master_model->update_entry_izin($id_industri,$id_izin);
			echo "1";
		}
	}


	function doedit_jenis($id_industri,$id_plant,$id_jenis)
	{
		$this->authentication->verify('industri_data','add');

		$this->form_validation->set_rules('id_jenis', 'Jenis', 'trim|required');
		$this->form_validation->set_rules('penanggungjawab', 'Penanggung Jawab', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->industri_master_model->update_entry_jenis($id_industri,$id_plant,$id_jenis);
			echo "1";
		}
	}

	function doedit_fasilitas($id_industri,$id_plant,$id_fasilitas)
	{
		$this->authentication->verify('industri_data','add');

		$this->form_validation->set_rules('id_fasilitas', 'Fasilitas', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->industri_master_model->update_entry_fasilitas($id_industri,$id_plant,$id_fasilitas);
			echo "1";
		}
	}


	function select_kotakab($propinsi,$kotakab=0){
		$data = $this->location_model->select_kotakab($propinsi,$kotakab);

		header('Content-type: text/X-JSON');
		echo json_encode($data);
		exit;
	}

	function select_kecamatan($kotakab,$kecamatan=0){
		$data = $this->location_model->select_kecamatan($kotakab,$kecamatan);

		header('Content-type: text/X-JSON');
		echo json_encode($data);
		exit;
	}

	function select_desa($kecamatan,$desa=0){
		$data = $this->location_model->select_desa($kecamatan,$desa);

		header('Content-type: text/X-JSON');
		echo json_encode($data);
		exit;
	}

	function get_detail_cetak($data,$pabrik,$kantor){
		$html = "";
		$html .= '<table border="0" cellpadding="0" cellspacing="8" class="panel" width="100%" style="font-family:Arial;font-size:12px;">
			<tr>
				<td>
					<table border="0" cellpadding="3" cellspacing="2" width="100%">
					<tr>
						<td>Id Industri</td>
						<td>:</td>
						<td>'.$data["id_industri"].'</td>
					</tr>
					<tr>
						<td>Nama Industri</td>
						<td>:</td>
						<td>'.$data["nama_industri"].'</td>
					</tr>
					<tr>
						<td valign="top">Pimpinan</td>
						<td valign="top">:</td>
						<td>'.$data["pimpinan"].'</td>
					</tr>
					<tr>
						<td>Bentuk Perusahaan</td>
						<td>:</td>
						<td>'.$data["bentuk_usaha"].'</td>
					</tr>
					<tr>
						<td>No Akte Pendirian</td>
						<td>:</td>
						<td>'.$data["no_akte_pendirian"].'</td>
					</tr>
					<tr>
						<td>Tgl Akte Pendirian</td>
						<td>:</td>
						<td>'.$data["tgl_akte_pendirian"].'</td>
					</tr>
					<tr>
						<td>NPWP</td>
						<td>:</td>
						<td>'.$data["npwp"].'</td>
					</tr>
					</table>
				</td>
			</tr>
			</table>
			<table style="font-family:Arial;font-size:11px;" width="100%">
			<tr>
			<td>
					<div id="tabs-1">
						<table border="1" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
							<tr>
								<td align="center" width="50" height="30" style="background-color:black;color:white;">No</td>
								<td align="center" width="100" height="30" style="background-color:black;color:white;">Kantor</td>
								<td align="center" width="200" height="30" style="background-color:black;color:white;">Alamat</td>
								<td align="center" width="100" height="30" style="background-color:black;color:white;">Telp</td>
								<td align="center" width="100" height="30" style="background-color:black;color:white;">Fax</td>
							</tr>';
						$ct = 0;
						foreach($kantor as $reval){
							$ct++;
							$html.='<tr>
									<td align="center" valign="top">'.$ct.'</td>
									<td align="center" valign="top">Kantor '.$reval["id_kantor"].'</td>
									<td align="left" valign="top">'.$reval["alamat_kantor"].'</td>
									<td align="left" valign="top">'.$reval["telp_kantor"].'</td>
									<td align="left" valign="top">'.$reval["fax_kantor"].'</td>
								</tr>';
						}
			$html .= '	</table>
					</div><br>
					<div id="tabs-2">
						<table border="1" cellpadding="0" width="100%" cellspacing="0" style="border-collapse:collapse;">
							<tr>
								<td align="center" width="50" height="30" style="background-color:black;color:white;">No</td>
								<td align="center" width="100" height="30" style="background-color:black;color:white;">Pabrik</td>
								<td align="center" width="200" height="30" style="background-color:black;color:white;">Alamat</td>
								<td align="center" width="100" height="30" style="background-color:black;color:white;">Telp</td>
								<td align="center" width="100" height="30" style="background-color:black;color:white;">Fax</td>
							</tr>';
						$ct = 0;
						foreach($pabrik as $reval){
							$ct++;
						
							$html.='<tr>
								<td align="center" valign="top">'.$ct.'</td>
								<td align="center" valign="top">Pabrik '.$reval["id_plant"].'</td>
								<td align="left" valign="top">'.$reval["alamat_pabrik"].'</td>
								<td align="left" valign="top">'.$reval["telp_plant"].'</td>
								<td align="left" valign="top">'.$reval["fax_plant"].'</td>
							</tr>
							<tr>
								<td colspan="8" align="left" style="padding-left:50px;padding-bottom:50px;padding-top:10px;">
									<table cellspacing="0" border="1" style="border-collapse:collapse;">
										<tr>
											<td align="center" width="50" height="30" style="background-color:black;color:white;">No</td>
											<td align="center" width="200" height="30" style="background-color:black;color:white;">Bentuk Sediaan</td>
											<td align="center" width="150" height="30" style="background-color:black;color:white;">Kapasitas Produksi/tahun</td>
											<td align="center" width="300" height="30" style="background-color:black;color:white;">Jenis</td>
										</tr>';
										
										$sediaan = $this->industri_master_model->get_sediaan_pabrik2($data["id_industri"],$reval["id_plant"]);
										$cs = 0;
										foreach($sediaan as $rsed){
											$cs++;
										
											$html.='<tr>
												<td align="center">'.$cs.'</td>
												<td align="left">'.$rsed["nama_sediaan"].'</td>
												<td align="center">'.$rsed["kap_prod_pertahun"].'</td>
												<td align="left">'.$rsed["nama_jenis2"].'</td>
											</tr>';
										
										}
										
							$html .= '</table>
								</td>
							</tr>';
						}
				$html.='</table>
					</div>
				</div>
			</td>
		</tr>
		</table>';
		return $html;
	}
	
	function get_daftar_cetak(){
		$html = "";
		$qcetak = $this->industri_master_model->get_daftar_industri_cetak();
		$html .= '<table border="0" cellpadding="2" cellspacing="0" width=800 style="font-family:Arial;font-size:12px;border-style:solid;border-collapse:collapse;">';
		$html .= "<tr>
					<td height='50' style='text-align:center;font-size:14px'><b>DAFTAR INDUSTRI</b></td>
				</tr></table><br>";
		$html .= '<table border="1" cellpadding="2" cellspacing="0" width=800 style="font-family:Arial;font-size:12px;border-style:solid;border-collapse:collapse;">';
		$html .= "<tr>
					<td width='20' style='text-align:center;font-weight:bold'>No</td>
					<td width='80' style='text-align:center;font-weight:bold'>Id Industri</td>
					<td width='120' style='text-align:center;font-weight:bold'>Nama Industri</td>
					<td width='100' style='text-align:center;font-weight:bold'>Pimpinan</td>
					<td width='60' style='text-align:center;font-weight:bold'>Bentuk Usaha</td>
					<td width='80' style='text-align:center;font-weight:bold'>Akte Pendirian</td>
					<td width='60' style='text-align:center;font-weight:bold'>Tgl. Akte</td>
				</tr>";
		$loop = 1;
		foreach ($qcetak->result() as $row){
			$html .= "<tr>
				<td valign='top'align='center'>".$loop."</td>
				<td valign='top' align='center'>".$row->id_industri."</td>
				<td valign='top'>".$row->nama_industri."</td>
				<td valign='top'>".$row->pimpinan."</td>
				<td valign='top' align='center'>".$row->bentuk_usaha."</td>
				<td valign='top'>".$row->no_akte_pendirian."</td>
				<td valign='top' align='center'>".$row->tgl_akte_pendirian."</td>
			</tr>";
			$loop ++;
		}
		$html .= "</table>";
		return $html;
	}
	
	function json(){
		$page = $this->input->post('page');
		
		$jdata = $this->industri_master_model->get_list_industri();
		$numrows = $jdata['record_count'];
		
		header("Expires: Mon, 26 Jul 2020 05:00:00 GMT" );
		header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
		header("Cache-Control: no-cache, must-revalidate" );
		header("Pragma: no-cache" );
		header("Content-type: text/x-json");
		if($numrows<>0)
		{			
			$json = "";
			$json .= "{\n";
			$json .= "\"page\": $page,\n";
			$json .= "\"total\": " . $numrows . ",\n";
			$json .= "\"rows\": [";
			$rc = false;
			foreach ($jdata['records']->result() as $row){
				$jvDelete="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/del.gif' onclick='dodel(".str_replace("I","",$row->id_industri).");'></a>";
				$jvEdit="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/edt.gif' onclick=document.location='ske/industri_data/view/".$row->id_industri."'> </a>";
					
				if ($rc) $json .= ",";
				$json .= "\n{";
				$json .= "\"id\":\"".$row->id_industri."\",";
				$json .= "\"cell\":[";
				$json .= " \"".$jvEdit." . ".$jvDelete."\"";
				$json .= ",\"".$row->id_industri."\"";
				$json .= ",\"".$row->nama_industri."\"";
				$json .= ",\"".$row->pimpinan."\"";
				$json .= ",\"".$row->bentuk_usaha."\"";
				$json .= ",\"".$row->id_jenis."\"";
				$json .= ",\"".$row->no_akte_pendirian."\"";
				$json .= ",\"".$row->tgl_akte_pendirian."\"";
				$json .= "]";
				
				$json .= "}";
				$rc = true;
			}
		  
			$json .= "]\n";
			$json .= "}";		  
		}else{
			$json = "";
			$json .= "{\n";
			$json .= "\"page\": $page,\n";
			$json .= "\"total\": " . $numrows . ",\n";
			$json .= "\"rows\": [";
			
			$json .= "\n{";
			$json .= "\"id\":\"\",";
			$json .= "\"cell\":[\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= "]";
			
			$json .= "}";			
			
		  
			$json .= "]\n";
			$json .= "}";			
		}
		echo $json;
	}
	
	function json_pabrik($id_industri){
		$page = $this->input->post('page');
		
		$jdata = $this->industri_master_model->get_list_industri_pabrik($id_industri);
		$numrows = $jdata['record_count'];
		
		header("Expires: Mon, 26 Jul 2020 05:00:00 GMT" );
		header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
		header("Cache-Control: no-cache, must-revalidate" );
		header("Pragma: no-cache" );
		header("Content-type: text/x-json");
		if($numrows<>0)
		{			
			$json = "";
			$json .= "{\n";
			$json .= "\"page\": $page,\n";
			$json .= "\"total\": " . $numrows . ",\n";
			$json .= "\"rows\": [";
			$rc = false;
			foreach ($jdata['records']->result() as $row){
				$jvDelete="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/del.gif' onclick='dodel_pabrik(".$row->id_plant.");'></a>";
				$jvEdit="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/edt.gif' onclick='edit_pabrik(".$row->id_plant.");'> </a>";
				$jvJenis="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/file_png.png' onclick='edit_pabrik_jenis(".$row->id_plant.");'> </a>";
				$jvFasilitas="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/file_jpg.png' onclick='edit_pabrik_fasilitas(".$row->id_plant.");'> </a>";
					
				if ($rc) $json .= ",";
				$json .= "\n{";
				$json .= "\"id\":\"".$row->id_plant."\",";
				$json .= "\"cell\":[";
				$json .= " \"".$jvEdit." . ".$jvDelete."\"";
				$json .= ",\"".$jvJenis."\"";
				$json .= ",\"".$jvFasilitas."\"";
				$json .= ",\"".$row->id_plant."\"";
				$json .= ",\"".$row->alamat_pabrik."\"";
				$json .= ",\"".$row->telp_plant."\"";
				$json .= ",\"".$row->fax_plant."\"";
				$json .= ",\"".$row->kodepos."\"";
				$json .= "]";
				
				$json .= "}";
				$rc = true;
			}
		  
			$json .= "]\n";
			$json .= "}";		  
		}else{
			$json = "";
			$json .= "{\n";
			$json .= "\"page\": $page,\n";
			$json .= "\"total\": " . $numrows . ",\n";
			$json .= "\"rows\": [";
			
			$json .= "\n{";
			$json .= "\"id\":\"\",";
			$json .= "\"cell\":[\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= "]";
			
			$json .= "}";			
			
		  
			$json .= "]\n";
			$json .= "}";			
		}
		echo $json;
	}

	function json_pabrik_jenis($id_industri,$id_plant){
		$page = $this->input->post('page');
		
		$jdata = $this->industri_master_model->get_list_industri_pabrik_jenis($id_industri,$id_plant);
		$numrows = $jdata['record_count'];
		
		header("Expires: Mon, 26 Jul 2020 05:00:00 GMT" );
		header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
		header("Cache-Control: no-cache, must-revalidate" );
		header("Pragma: no-cache" );
		header("Content-type: text/x-json");
		if($numrows<>0)
		{			
			$json = "";
			$json .= "{\n";
			$json .= "\"page\": $page,\n";
			$json .= "\"total\": " . $numrows . ",\n";
			$json .= "\"rows\": [";
			$rc = false;
			foreach ($jdata['records']->result() as $row){
				$jvDelete="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/del.gif' onclick='dodel_jenis(".$row->id_plant.",".$row->id_jenis.");'></a>";
				$jvEdit="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/edt.gif' onclick='edit_jenis(".$row->id_plant.",".$row->id_jenis.");'> </a>";
					
				if ($rc) $json .= ",";
				$json .= "\n{";
				$json .= "\"id\":\"".$row->id_jenis."\",";
				$json .= "\"cell\":[";
				$json .= " \"".$jvEdit." . ".$jvDelete."\"";
				$json .= ",\"".$row->id_jenis."\"";
				$json .= ",\"".$row->jenis."\"";
				$json .= ",\"".$row->penanggungjawab."\"";
				$json .= ",\"".$row->pend_penanggungjawab."\"";
				$json .= ",\"".$row->stra_penanggungjawab."\"";
				$json .= "]";
				
				$json .= "}";
				$rc = true;
			}
		  
			$json .= "]\n";
			$json .= "}";		  
		}else{
			$json = "";
			$json .= "{\n";
			$json .= "\"page\": $page,\n";
			$json .= "\"total\": " . $numrows . ",\n";
			$json .= "\"rows\": [";
			
			$json .= "\n{";
			$json .= "\"id\":\"\",";
			$json .= "\"cell\":[\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= "]";
			
			$json .= "}";			
			
		  
			$json .= "]\n";
			$json .= "}";			
		}
		echo $json;
	}

	function json_kantor($id_industri){
		$page = $this->input->post('page');
		
		$jdata = $this->industri_master_model->get_list_industri_kantor($id_industri);
		$numrows = $jdata['record_count'];
		
		header("Expires: Mon, 26 Jul 2020 05:00:00 GMT" );
		header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
		header("Cache-Control: no-cache, must-revalidate" );
		header("Pragma: no-cache" );
		header("Content-type: text/x-json");
		if($numrows<>0)
		{			
			$json = "";
			$json .= "{\n";
			$json .= "\"page\": $page,\n";
			$json .= "\"total\": " . $numrows . ",\n";
			$json .= "\"rows\": [";
			$rc = false;
			foreach ($jdata['records']->result() as $row){
				$jvDelete="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/del.gif' onclick='dodel_kantor(".$row->id_kantor.");'></a>";
				$jvEdit="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/edt.gif' onclick='edit_kantor(".$row->id_kantor.");'> </a>";
					
				if ($rc) $json .= ",";
				$json .= "\n{";
				$json .= "\"id\":\"".$row->id_kantor."\",";
				$json .= "\"cell\":[";
				$json .= " \"".$jvEdit." . ".$jvDelete."\"";
				$json .= ",\"".$row->id_kantor."\"";
				$json .= ",\"".$row->alamat_kantor."\"";
				$json .= ",\"".$row->telp_kantor."\"";
				$json .= ",\"".$row->fax_kantor."\"";
				$json .= ",\"".$row->kodepos."\"";
				$json .= "]";
				
				$json .= "}";
				$rc = true;
			}
		  
			$json .= "]\n";
			$json .= "}";		  
		}else{
			$json = "";
			$json .= "{\n";
			$json .= "\"page\": $page,\n";
			$json .= "\"total\": " . $numrows . ",\n";
			$json .= "\"rows\": [";
			
			$json .= "\n{";
			$json .= "\"id\":\"\",";
			$json .= "\"cell\":[\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= "]";
			
			$json .= "}";			
			
		  
			$json .= "]\n";
			$json .= "}";			
		}
		echo $json;
	}
	
	function json_direksi($id_industri){
		$page = $this->input->post('page');
		
		$jdata = $this->industri_master_model->get_list_industri_direksi($id_industri);
		$numrows = $jdata['record_count'];
		
		header("Expires: Mon, 26 Jul 2020 05:00:00 GMT" );
		header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
		header("Cache-Control: no-cache, must-revalidate" );
		header("Pragma: no-cache" );
		header("Content-type: text/x-json");
		if($numrows<>0)
		{			
			$json = "";
			$json .= "{\n";
			$json .= "\"page\": $page,\n";
			$json .= "\"total\": " . $numrows . ",\n";
			$json .= "\"rows\": [";
			$rc = false;
			foreach ($jdata['records']->result() as $row){
				$jvDelete="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/del.gif' onclick='dodel_direksi(".$row->id.");'></a>";
				$jvEdit="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/edt.gif' onclick='edit_direksi(".$row->id.");'> </a>";
					
				if ($rc) $json .= ",";
				$json .= "\n{";
				$json .= "\"id\":\"".$row->id."\",";
				$json .= "\"cell\":[";
				$json .= " \"".$jvEdit." . ".$jvDelete."\"";
				$json .= ",\"".$row->id."\"";
				$json .= ",\"".$row->nama_direksi."\"";
				$json .= ",\"".$row->pendidikan."\"";
				$json .= ",\"".$row->keterangan."\"";
				$json .= "]";
				
				$json .= "}";
				$rc = true;
			}
		  
			$json .= "]\n";
			$json .= "}";		  
		}else{
			$json = "";
			$json .= "{\n";
			$json .= "\"page\": $page,\n";
			$json .= "\"total\": " . $numrows . ",\n";
			$json .= "\"rows\": [";
			
			$json .= "\n{";
			$json .= "\"id\":\"\",";
			$json .= "\"cell\":[\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= "]";
			
			$json .= "}";			
			
		  
			$json .= "]\n";
			$json .= "}";			
		}
		echo $json;
	}
		
	function json_pabrik_bentuksediaan($id_industri){
		$page = $this->input->post('page');
		
		$jdata = $this->industri_master_model->get_list_industri_pabrik_bentuksediaan($id_industri);
		$numrows = $jdata['record_count'];
		
		header("Expires: Mon, 26 Jul 2020 05:00:00 GMT" );
		header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
		header("Cache-Control: no-cache, must-revalidate" );
		header("Pragma: no-cache" );
		header("Content-type: text/x-json");
		if($numrows<>0)
		{			
			$json = "";
			$json .= "{\n";
			$json .= "\"page\": $page,\n";
			$json .= "\"total\": " . $numrows . ",\n";
			$json .= "\"rows\": [";
			$rc = false;
			foreach ($jdata['records']->result() as $row){
				$sediaan = $this->industri_master_model->get_industri_pabrik_bentuksediaan($id_industri,$row->id_plant,$row->id_jenis);
				$jvEdit="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/edt.gif' onclick='edit_jenis(".$row->id_plant.",".$row->id_jenis.");'> </a>";
					
				if ($rc) $json .= ",";
				$json .= "\n{";
				$json .= "\"id\":\"".$row->id_plant."\",";
				$json .= "\"cell\":[";
				$json .= " \"".$jvEdit."\"";
				$json .= ",\"".$row->id."\"";
				$json .= ",\"".$row->alamat_pabrik."\"";
				$json .= ",\"".$row->jenis."\"";
				$json .= ",\"".(isset($sediaan['sediaan']) ? $sediaan['sediaan'] : "-")."\"";
				$json .= ",\"".(isset($sediaan['jml']) ? $sediaan['jml'] : "0")."\"";
				$json .= "]";
				
				$json .= "}";
				$rc = true;
			}
		  
			$json .= "]\n";
			$json .= "}";		  
		}else{
			$json = "";
			$json .= "{\n";
			$json .= "\"page\": $page,\n";
			$json .= "\"total\": " . $numrows . ",\n";
			$json .= "\"rows\": [";
			
			$json .= "\n{";
			$json .= "\"id\":\"\",";
			$json .= "\"cell\":[\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= "]";
			
			$json .= "}";			
			
		  
			$json .= "]\n";
			$json .= "}";			
		}
		echo $json;
	}

	function json_bentuksediaan($id_industri,$id_plant,$id_jenis){
		$page = $this->input->post('page');
		
		$jdata = $this->industri_master_model->get_list_industri_bentuksediaan($id_industri,$id_plant,$id_jenis);
		$numrows = $jdata['record_count'];
		
		header("Expires: Mon, 26 Jul 2020 05:00:00 GMT" );
		header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
		header("Cache-Control: no-cache, must-revalidate" );
		header("Pragma: no-cache" );
		header("Content-type: text/x-json");
		if($numrows<>0)
		{			
			$json = "";
			$json .= "{\n";
			$json .= "\"page\": $page,\n";
			$json .= "\"total\": " . $numrows . ",\n";
			$json .= "\"rows\": [";
			$rc = false;
			$i=1;
			foreach ($jdata['records']->result() as $row){
				$jvDelete="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/del.gif' onclick='dodel_bentuksediaan(".$row->bentuk_sediaan.",".$row->id_plant.",".$id_jenis.");'></a>";
				$jvEdit="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/edt.gif' onclick='edit_bentuksediaan(".$row->bentuk_sediaan.",".$row->id_plant.",".$id_jenis.");'> </a>";
					
				if ($rc) $json .= ",";
				$json .= "\n{";
				$json .= "\"id\":\"".$row->bentuk_sediaan."\",";
				$json .= "\"cell\":[";
				$json .= " \"".$jvEdit." . ".$jvDelete."\"";
				$json .= ",\"".$i."\"";
				$json .= ",\"".$row->nama_sediaan."\"";
				$json .= ",\"".$row->kap_prod_pertahun."\"";
                $json .= ",\"".$row->nama_satuan."\"";
                $json .= ",\"".$row->mesin_peralatan."\"";
				$json .= ",\"".$row->rencana_prod."\"";
				$json .= "]";
				
				$json .= "}";
				$rc = true;
				$i++;
			}
		  
			$json .= "]\n";
			$json .= "}";		  
		}else{
			$json = "";
			$json .= "{\n";
			$json .= "\"page\": $page,\n";
			$json .= "\"total\": " . $numrows . ",\n";
			$json .= "\"rows\": [";
			
			$json .= "\n{";
			$json .= "\"id\":\"\",";
			$json .= "\"cell\":[\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
            $json .= ",\"\"";
            $json .= ",\"\"";
            $json .= ",\"\"";
            $json .= "]";
			
			$json .= "}";			
			
		  
			$json .= "]\n";
			$json .= "}";			
		}
		echo $json;
	}
		
	function json_izin($id_industri){
		$page = $this->input->post('page');
		
		$jdata = $this->industri_master_model->get_list_industri_izin($id_industri);
		$numrows = $jdata['record_count'];
		
		header("Expires: Mon, 26 Jul 2020 05:00:00 GMT" );
		header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
		header("Cache-Control: no-cache, must-revalidate" );
		header("Pragma: no-cache" );
		header("Content-type: text/x-json");
		if($numrows<>0)
		{			
			$json = "";
			$json .= "{\n";
			$json .= "\"page\": $page,\n";
			$json .= "\"total\": " . $numrows . ",\n";
			$json .= "\"rows\": [";
			$rc = false;
			$i=1;
			foreach ($jdata['records']->result() as $row){
				$jvDelete="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/del.gif' onclick='dodel_izin(".$row->id_izin.");'></a>";
				$jvEdit="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/edt.gif' onclick='edit_izin(".$row->id_izin.");'> </a>";
					
				if ($rc) $json .= ",";
				$json .= "\n{";
				$json .= "\"id\":\"".$row->id_izin."\",";
				$json .= "\"cell\":[";
				$json .= " \"".$jvEdit." . ".$jvDelete."\"";
				$json .= ",\"".$i."\"";
				$json .= ",\"".$row->nama_izin."\"";
				$json .= ",\"".$row->tgl_izin."\"";
				$json .= ",\"".$row->tgl_permohonan."\"";
				$json .= ",\"".$row->nomor."\"";
				$json .= "]";
				
				$json .= "}";
				$rc = true;
				$i++;
			}
		  
			$json .= "]\n";
			$json .= "}";		  
		}else{
			$json = "";
			$json .= "{\n";
			$json .= "\"page\": $page,\n";
			$json .= "\"total\": " . $numrows . ",\n";
			$json .= "\"rows\": [";
			
			$json .= "\n{";
			$json .= "\"id\":\"\",";
			$json .= "\"cell\":[\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= "]";
			
			$json .= "}";			
			
		  
			$json .= "]\n";
			$json .= "}";			
		}
		echo $json;
	}
	
	function json_pabrik_fasilitas($id_industri,$id_plant){
		$page = $this->input->post('page');
		
		$jdata = $this->industri_master_model->get_list_industri_pabrik_fasilitas($id_industri,$id_plant);
		$numrows = $jdata['record_count'];
		
		header("Expires: Mon, 26 Jul 2020 05:00:00 GMT" );
		header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" );
		header("Cache-Control: no-cache, must-revalidate" );
		header("Pragma: no-cache" );
		header("Content-type: text/x-json");
		if($numrows<>0)
		{			
			$json = "";
			$json .= "{\n";
			$json .= "\"page\": $page,\n";
			$json .= "\"total\": " . $numrows . ",\n";
			$json .= "\"rows\": [";
			$rc = false;
			foreach ($jdata['records']->result() as $row){
				$jvDelete="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/del.gif' onclick='dodel_fasilitas(".$row->id_plant.",".$row->id_fasilitas.");'></a>";
				$jvEdit="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/edt.gif' onclick='edit_fasilitas(".$row->id_plant.",".$row->id_fasilitas.");'> </a>";
					
				if ($rc) $json .= ",";
				$json .= "\n{";
				$json .= "\"id\":\"".$row->id_fasilitas."\",";
				$json .= "\"cell\":[";
				$json .= " \"".$jvEdit." . ".$jvDelete."\"";
				$json .= ",\"".$row->id_fasilitas."\"";
				$json .= ",\"".$row->nama_fasilitas."\"";
				$json .= ",\"".$row->status."\"";
				$json .= "]";
				
				$json .= "}";
				$rc = true;
			}
		  
			$json .= "]\n";
			$json .= "}";		  
		}else{
			$json = "";
			$json .= "{\n";
			$json .= "\"page\": $page,\n";
			$json .= "\"total\": " . $numrows . ",\n";
			$json .= "\"rows\": [";
			
			$json .= "\n{";
			$json .= "\"id\":\"\",";
			$json .= "\"cell\":[\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= ",\"\"";
			$json .= "]";
			
			$json .= "}";			
			
		  
			$json .= "]\n";
			$json .= "}";			
		}
		echo $json;
	}
	
	function print_pdf_daftar(){
		$html = $this->get_daftar_cetak();
		$this->load->library('mpdf');
        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output();
	}
	
	function print_pdf($id_industri){
		$this->load->model('industri_master_model');
		$data = $this->industri_master_model->get_data_row($id_industri); 
		$data["pabrik"] = $this->industri_master_model->get_list_pabrik($id_industri);
		$data["kantor"] = $this->industri_master_model->get_list_kantor($id_industri); 
		$html = $this->get_detail_cetak($data,$data['pabrik'],$data['kantor']);
		$this->load->library('mpdf');
        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output();
	}
}
