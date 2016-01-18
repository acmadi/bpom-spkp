<?php

class Users extends CI_Controller {

	var $limit=10;
	var $page=1;

    public function __construct(){
		parent::__construct();
		$this->load->model('users_model');
		$this->load->helper('html');
	}
	
	function calon(){
		$this->authentication->verify('user','edit');
		$data['title'] = "Calon Pelanggan";

		$data['content'] = $this->parser->parse("users/calon",$data,true);

		$this->template->show($data,"home");
	}

	function pelanggan(){
		$this->authentication->verify('user','edit');
		$data['title'] = "Daftar Pelanggan";

		$data['content'] = $this->parser->parse("users/pelanggan",$data,true);

		$this->template->show($data,"home");
	}
	
	function pengguna(){
		$this->authentication->verify('user','edit');
		$data['title'] = "Daftar Pengguna";

		$data['content'] = $this->parser->parse("users/pengguna",$data,true);

		$this->template->show($data,"home");
	}

	function json_calon(){
		$page = $this->input->post('page');
		
		$jdata = $this->users_model->get_list_calon();
		$numrows = $jdata['record_count'];
		
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
				$jvDelete="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/del.gif' onclick='dodel(".$row->id.");'></a>";
				$jvEdit="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/edt.gif' onclick='edit(".$row->id.");'></a>";
					
				if ($rc) $json .= ",";
				$json .= "\n{";
				$json .= "\"id\":\"".$row->id."\",";
				$json .= "\"cell\":[";
				$json .= " \"".$jvEdit." . ".$jvDelete."\"";
				$json .= ",\"".$row->id."\"";
				$json .= ",\"".$row->username."\"";
				$json .= ",\"".$row->nama."\"";
				$json .= ",\"".$row->nama_perusahaan."\"";
				$json .= ",\"".$row->email."\"";
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
			$json .= "\"cell\":[";
			$json .= " \"\"";
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

	function json_pelanggan(){
		$page = $this->input->post('page');
		
		$jdata = $this->users_model->get_list_pelanggan();
		$numrows = $jdata['record_count'];
		
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
				$jvDelete="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/del.gif' onclick='dodel(".$row->id.");'></a>";
				$jvEdit="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/edt.gif' onclick='edit(".$row->id.");'></a>";
					
				if ($rc) $json .= ",";
				$json .= "\n{";
				$json .= "\"id\":\"".$row->id."\",";
				$json .= "\"cell\":[";
				$json .= " \"".$jvEdit." . ".$jvDelete."\"";
				$json .= ",\"".$row->id."\"";
				$json .= ",\"".$row->username."\"";
				$json .= ",\"".$row->nama."\"";
				$json .= ",\"".$row->nama_perusahaan."\"";
				$json .= ",\"".$row->email."\"";
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
			$json .= "\"cell\":[";
			$json .= " \"\"";
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

	function json_pengguna(){
		$page = $this->input->post('page');
		
		$jdata = $this->users_model->get_list_pengguna();
		$numrows = $jdata['record_count'];
		
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
				$jvDelete="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/del.gif' onclick='dodel(".$row->id.");'></a>";
				$jvEdit="<a href='javascript:void(0);'><img border=0 src='".base_url()."public/images/edt.gif' onclick='edit(".$row->id.");'></a>";
					
				if ($rc) $json .= ",";
				$json .= "\n{";
				$json .= "\"id\":\"".$row->id."\",";
				$json .= "\"cell\":[";
				$json .= " \"".$jvEdit." . ".$jvDelete."\"";
				$json .= ",\"".$row->id."\"";
				$json .= ",\"".$row->username."\"";
				$json .= ",\"".$row->nama."\"";
				$json .= ",\"".$row->nama_perusahaan."\"";
				$json .= ",\"".$row->email."\"";
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
			$json .= "\"cell\":[";
			$json .= " \"\"";
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

	function doadd(){
		$this->authentication->verify('user','add');

		$this->form_validation->set_rules('nama_balai', 'Nama Balai', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Alamat Balai', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->users_model->insert_entry();
			echo "1";
		}
	
	}
	
	function edit($id_balai=0)
	{
		$this->authentication->verify('user','add');

		$data = $this->users_model->get_data_row($id_balai); 
		$data['title_form']="Balai &raquo; Ubah";
		$data['action']="edit";

		echo $this->parser->parse("users/form",$data,true);
	}

	function doedit($id_balai=0)
	{
		$this->authentication->verify('user','edit');

		$this->form_validation->set_rules('nama_balai', 'Nama Balai', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Alamat Balai', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->users_model->update_entry($id_balai);
			echo "1";
		}
		
	}
	
	function dodel($id_balai=0){
		$this->authentication->verify('user','del');

		if($this->users_model->delete_entry($id_balai)){
			echo "1";
		}else{
			echo "Delete Error";
		}
	}

}
