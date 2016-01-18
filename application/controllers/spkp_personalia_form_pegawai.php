<?php
class Spkp_personalia_form_pegawai extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('html');
		$this->load->model('spkp_personalia_form_pegawai_model');
        $this->load->model('admin_users_model');
        $this->load->model('location_model');
        $this->load->add_package_path(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/demo/tbs_class.php');
		require_once(APPPATH.'third_party/tbs_plugin_opentbs_1.8.0/tbs_plugin_opentbs.php');
	}
	
	function index(){
		$this->authentication->verify('spkp_personalia_form_pegawai','show');
        
	    $data = array();
        $data['title'] = "Form Kepegawaian ";
        $data['form_cuti']         = $this->parser->parse("spkp_personalia_form_pegawai/show_cuti",$data,true);
        $data['form_cuti_bersama'] = $this->parser->parse("spkp_personalia_form_pegawai/show_cuti_bersama",$data,true);
        $data['content']           = $this->parser->parse("spkp_personalia_form_pegawai/show",$data,true);
        
		$this->template->show($data,"home");
	}
    
    function json_user(){
        die(json_encode($this->spkp_personalia_form_pegawai_model->json_user()));
    }
    
    function json_cutibersama(){
        die(json_encode($this->spkp_personalia_form_pegawai_model->json_cutibersama()));
    }
    
	function json_izincuti($id,$thn){
		die(json_encode($this->spkp_personalia_form_pegawai_model->json_izincuti($id,$thn)));
	}
    
    function json_cuti_dokumen($id){
        die(json_encode($this->spkp_personalia_form_pegawai_model->json_cuti_dokumen($id)));
    }

	function detail($id,$thn=""){
        $this->authentication->verify('spkp_personalia_form_pegawai','edit');
        
        $data = $this->spkp_personalia_form_pegawai_model->get_user($id);
		$data['add_permission']=$this->authentication->verify_check('spkp_personalia_form_pegawai','add');
        $data['title'] = "Form Kepegawaian &raquo; Detail";
 		$data['uid']=$id;
		$nip = $data['nip'];
 		$data['nip']=substr($nip,0,8)." ".substr($nip,8,6)." ".substr($nip,14,1)." ".substr($nip,15,3);
		$data['thn'] = $thn!="" ? $thn : date("Y");
        $data['option_thn'] = "";

		for($i=date("Y")+1;$i>=(date("Y")-4);$i--){
			$data['option_thn'] .= "<option value='$i' ".($data['thn']==$i ? "selected" : "").">$i</option>";
		}
        
        $sisa_back = $this->spkp_personalia_form_pegawai_model->get_sisa_cuti($id,date('Y')-1);
        $sisa_now  = $this->spkp_personalia_form_pegawai_model->get_sisa_cuti($id,date('Y'));
        
        $data['taken_back'] = intval($this->spkp_personalia_form_pegawai_model->get_taken_cuti($id,date('Y')-1));
        $data['taken_now'] = intval($this->spkp_personalia_form_pegawai_model->get_taken_cuti($id,date('Y')));
        $data['sisa_back'] = intval((12-$sisa_back['cb_back'])-$sisa_back['jml']);
        $data['sisa_now']  = intval((12-$sisa_now['cb_back'])-$sisa_now['jml']);
        $data['sisa_join'] = intval((12-$sisa_back['cb_back'])-$sisa_back['jml']) + intval((12-$sisa_now['cb_back'])-$sisa_now['jml']);
        
        $data['content'] = $this->parser->parse("spkp_personalia_form_pegawai/form",$data,true);
        
        $this->template->show($data,"home");
    }
    
    function add_cuti_bersama(){
        $this->authentication->verify('spkp_personalia_form_pegawai','add');
        
        $data = array();
 		$data['action']="add";

		echo $this->parser->parse("spkp_personalia_form_pegawai/form_add_cuti_bersama",$data,true);
    }
    
    function doadd_cuti_bersama(){
        $this->authentication->verify('spkp_personalia_form_pegawai','add');
        
        $this->form_validation->set_rules('tgl', 'Tanggal', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_personalia_form_pegawai_model->insert_cuti_bersama();
            echo "1";
		}
    }
    
    function edit_cuti_bersama($id){
        $this->authentication->verify('spkp_personalia_form_pegawai','edit');
        
        $data = $this->spkp_personalia_form_pegawai_model->get_cuti_bersama($id);
        $data['action'] = "edit";
        
		echo $this->parser->parse("spkp_personalia_form_pegawai/form_add_cuti_bersama",$data,true);
    }
    
    function doedit_cuti_bersama($id){
        $this->authentication->verify('spkp_personalia_form_pegawai','edit');
        
        $this->form_validation->set_rules('tgl', 'Tanggal', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			$this->spkp_personalia_form_pegawai_model->update_cuti_bersama($id);
            echo "1";
		}
    }
    
    function dodelete_cuti_bersama($id){
        $this->authentication->verify('spkp_personalia_form_pegawai','del');

		if($this->spkp_personalia_form_pegawai_model->delete_cuti_bersama($id)){
			echo "1";
		}else{
			echo "0";
		}
    }
    
    function add($uid){
		$this->authentication->verify('spkp_personalia_form_pegawai','add');

 		$data['uid']=$uid;
		$data['action']="add";
		$data['tgl']=date("Y-m-d");
		$data['option_izincuti']=$this->spkp_personalia_form_pegawai_model->get_izincuti();

		echo $this->parser->parse("spkp_personalia_form_pegawai/form_popup",$data,true);
	}
    
    function add_upload($id){
        $this->authentication->verify('spkp_personalia_form_pegawai','add');
        
        $form_cuti = $this->spkp_personalia_form_pegawai_model->get_form_cuti($id);
 		$izincuti = $this->spkp_personalia_form_pegawai_model->get_data_row($id); 
        $data = array_merge($izincuti,$form_cuti);
		$data['add_permission']=$this->authentication->verify_check('spkp_personalia_form_pegawai','add');
        
		echo $this->parser->parse("spkp_personalia_form_pegawai/form_upload",$data,true);
    }
    
    function add_dokumen($id){
        $this->authentication->verify('spkp_personalia_form_pegawai','add');
        
        $data['id'] = $id;
		$data['action']="add";

		echo $this->parser->parse("spkp_personalia_form_pegawai/form_add_upload",$data,true);
    }
    
    function doadd_dokumen($id){
        $this->authentication->verify('spkp_personalia_form_pegawai','add');
        
        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(!isset($_FILES['filename']['name']) || $_FILES['filename']['name']==""){
				echo "ERROR_File / Dokumen harus ada.";
			}else{
				if(count($_FILES)>0){
					$path = './public/files/spkp_personalia_form_pegawai/';
					if (!is_dir($path)) {
						mkdir($path);
					}
                    $path = './public/files/spkp_personalia_form_pegawai/dokumen_cuti/';
					if (!is_dir($path)) {
						mkdir($path);
					}
					$path .= $this->session->userdata('id');
					if (!is_dir($path)) {
						mkdir($path);
					}
					@unlink($path."/".$_FILES['filename']['name']);
					$config['upload_path'] = $path;
					$config['allowed_types'] = 'jpg||jpeg||png';
					$config['max_size']	= '999999';
					$config['overwrite'] = false;
					$this->load->library('upload', $config);
					$upload = $this->upload->do_upload('filename');
					if($upload === FALSE) {
						echo "ERROR_".$this->upload->display_errors();
					}else{
						$upload_data = $this->upload->data();
						$id=$this->spkp_personalia_form_pegawai_model->doadd_dokumen($id,$upload_data);
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
    
    function edit_dokumen($id,$doc){
        $this->authentication->verify('spkp_personalia_form_pegawai','add');
        
        $data = $this->spkp_personalia_form_pegawai_model->get_data_dokumen($id,$doc);
        $data['action'] = "edit";
        
		echo $this->parser->parse("spkp_personalia_form_pegawai/form_add_upload",$data,true);
    }
    
    function doedit_dokumen($id,$id_doc){
        $this->authentication->verify('spkp_personalia_form_pegawai','edit');

        $this->form_validation->set_rules('judul', 'Judul', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if(count($_FILES)>0){
				$path = './public/files/spkp_personalia_form_pegawai/dokumen_cuti/'.$this->session->userdata('id');
				if (!is_dir($path)) {
					mkdir($path);
				}
				@unlink($path."/".$_FILES['filename']['name']);
				$config['upload_path'] = $path;
				$config['allowed_types'] = 'jpg||jpeg||png';
				$config['max_size']	= '999999';
				$config['overwrite'] = false;
				$this->load->library('upload', $config);
				$upload = $this->upload->do_upload('filename');
				if($upload === FALSE) {
					echo "ERROR_".$this->upload->display_errors();
				}else{
					$upload_data = $this->upload->data();
					if($this->spkp_personalia_form_pegawai_model->doedit_dokumen($id,$id_doc,$upload_data)){
						echo "OK_".$id;
					}else{
						echo "ERROR_Database Error";
					}
				}
			}else{
				if($this->spkp_personalia_form_pegawai_model->doedit_dokumen($id,$id_doc)){
					echo "OK_".$id;
				}else{
					echo "ERROR_Database Error";
				}
			}
		}
    }
    
    function download($id,$id_doc=0){
		$this->authentication->verify('spkp_personalia_form_pegawai','edit');

		$data = $this->spkp_personalia_form_pegawai_model->get_data_dokumen($id,$id_doc); 

		echo $this->parser->parse("spkp_personalia_form_pegawai/download",$data,true);
	}

	function dodownload($id,$id_doc){
		$this->authentication->verify('spkp_personalia_form_pegawai','edit');

		$data = $this->spkp_personalia_form_pegawai_model->get_data_dokumen($id,$id_doc); 
		$path = './public/files/spkp_personalia_form_pegawai/dokumen_cuti/'.$this->session->userdata('id')."/".$data['filename'];

		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Transfer-Encoding: binary");
		header("Content-disposition: attachment; filename=" . $data['filename']);
		header("Content-type: application/octet-stream");
		readfile($path);
	}

	function dodelete_dokumen($id,$id_doc){
		$this->authentication->verify('spkp_personalia_form_pegawai','del');
		$data = $this->spkp_personalia_form_pegawai_model->get_data_dokumen($id,$id_doc); 
		$path = './public/files/spkp_personalia_form_pegawai/dokumen_cuti/'.$this->session->userdata('id')."/".$data['filename'];

		if($this->spkp_personalia_form_pegawai_model->dodelete_dokumen($id,$id_doc)){
			if(file_exists($path)){
				unlink($path);
			}
			echo "OK_".$id;
		}else{
			echo "ERROR_Database Error";
		}
	}

	function doadd($uid){
		$this->authentication->verify('spkp_personalia_form_pegawai','add');
        
        $this->form_validation->set_rules('alasan', 'Keperluan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			$id=$this->spkp_personalia_form_pegawai_model->doadd($uid);
			if($id!=false){
				echo "OK_".$id;
			}else{
				echo "ERROR_Database Error";
			}
		}
	}
	
	function edit($uid,$id=0){
		$this->authentication->verify('spkp_personalia_form_pegawai','add');
        
        if($this->spkp_personalia_form_pegawai_model->cek_user($uid)>0){
            if($this->spkp_personalia_form_pegawai_model->cek_izin($id)){
                $data = $this->spkp_personalia_form_pegawai_model->get_user($uid);
        		$izincuti = $this->spkp_personalia_form_pegawai_model->get_data_row($id); 
                $posisi = $this->spkp_personalia_form_pegawai_model->get_posisi($uid);
        		$data = array_merge($data,$izincuti,$posisi);
                $data['add_permission']=$this->authentication->verify_check('spkp_personalia_form_pegawai','add');
                $data['title'] = "Form Kepegawaian &raquo; Izin/Cuti";
         		$data['uid']=$uid;
                $data['id']=$id;
        		$data['action']="edit";
                $data['nip']=substr($data['nip'],0,8)." ".substr($data['nip'],8,6)." ".substr($data['nip'],14,1)." ".substr($data['nip'],15,3);
                
                if($izincuti['status_approve']=='1'){
                    $data['status'] = "Telah Disetujui";
                }else{
                    $data['status'] = "Belum Disetujui";
                }
                
                $sisa_back = $this->spkp_personalia_form_pegawai_model->get_sisa_cuti($uid,date('Y')-1);
                $sisa_now  = $this->spkp_personalia_form_pegawai_model->get_sisa_cuti($uid,date('Y'));
                
                $data['taken_back'] = intval($this->spkp_personalia_form_pegawai_model->get_taken_cuti($uid,date('Y')-1));
                $data['taken_now'] = intval($this->spkp_personalia_form_pegawai_model->get_taken_cuti($uid,date('Y')));
                $data['sisa_back'] = intval((12-$sisa_back['cb_back'])-$sisa_back['jml']);
                $data['sisa_now']  = intval((12-$sisa_now['cb_back'])-$sisa_now['jml']);
                $data['sisa_join'] = intval((12-$sisa_back['cb_back'])-$sisa_back['jml']) + intval((12-$sisa_now['cb_back'])-$sisa_now['jml']);
        
                if($izincuti['kode']=='cl'){
                    $data['prm_hitungan']        = $izincuti['hitungan'];
                    $data['prm_jml']             = $izincuti['jml']=="" ? "" : $izincuti['jml'];
                    $data['prm_stat_tgl']        = $izincuti['stat_tgl']=="" ? "" : $izincuti['stat_tgl'];
                    $data['prm_alasan_tambahan'] = $izincuti['alasan_tambahan']=="" ? "" : $izincuti['alasan_tambahan'];
                    $data['prm_alamat']          = $izincuti['alamat']=="" ? "" : $izincuti['alamat'];
                }else if($izincuti['kode']=='cp'){
                    $data['prm_jml']             = $izincuti['jml']=="" ? "" : $izincuti['jml'];
                    $data['prm_stat_tgl']        = $izincuti['stat_tgl']=="" ? "" : $izincuti['stat_tgl'];
                    $data['prm_alasan_tambahan'] = $izincuti['alasan_tambahan']=="" ? "" : $izincuti['alasan_tambahan'];
                    $data['prm_alamat']          = $izincuti['alamat']=="" ? "" : $izincuti['alamat'];
                }else if($izincuti['kode']=='sk'){
                    $data['prm_hitungan']        = $izincuti['hitungan'];
                    $data['prm_jml']             = $izincuti['jml']=="" ? "" : $izincuti['jml'];
                    $data['prm_stat_sakit']      = $izincuti['stat_sakit'];
                    $data['prm_stat_lampiran']   = $izincuti['stat_lampiran'];
                }else if($izincuti['kode']=='ct'){
                    $data['prm_stat_thnkerja']   = $izincuti['stat_thnkerja']=="" ? "" : $izincuti['stat_thnkerja'];
                    $data['prm_jml']             = $izincuti['jml']=="" ? "" : $izincuti['jml'];
                    $data['prm_stat_tgl']        = $izincuti['stat_tgl']=="" ? "" : $izincuti['stat_tgl'];
                    $data['prm_alamat']          = $izincuti['alamat']=="" ? "" : $izincuti['alamat'];
                }else if($izincuti['kode']=='icb'){
                    $data['prm_hitungan']        = $izincuti['hitungan'];
                    $data['prm_jml']             = $izincuti['jml']=="" ? "" : $izincuti['jml'];
                    $data['prm_stat_thnkerja']   = $izincuti['stat_thnkerja']=="" ? "" : $izincuti['stat_thnkerja'];
                    $data['prm_alamat']          = $izincuti['alamat']=="" ? "" : $izincuti['alamat'];
                }else if($izincuti['kode']=='itm'){
                    $data['prm_stat_tm']         = $izincuti['stat_tm']=="" ? "" : $izincuti['stat_tm'];
                    $data['prm_stat_tgl']        = $izincuti['stat_tgl']=="" ? "" : $izincuti['stat_tgl'];
                    $data['prm_stat_tm_jam']     = $izincuti['stat_tm_jam']=="" ? "" : $izincuti['stat_tm_jam'];
                    $data['prm_tgl']             = "Jakarta, ".$this->authentication->indonesian_date($izincuti['tgl'],'j F Y','');
                    $data['prm_stat_tm_alasan_kondisi'] = $izincuti['stat_tm_alasan_kondisi']=="" ? "" : $izincuti['stat_tm_alasan_kondisi'];
                    $data['prm_stat_tm_alasan_perlu'] = $izincuti['stat_tm_alasan_perlu']=="" ? "" : $izincuti['stat_tm_alasan_perlu'];
                }else if($izincuti['kode']=='itk'){
                    $data['prm_jml']             = $izincuti['jml']=="" ? "" : $izincuti['jml'];
                    $data['prm_stat_tgl']        = $izincuti['stat_tgl']=="" ? "" : $izincuti['stat_tgl'];
                    $data['prm_tgl']             = "Jakarta, ".$this->authentication->indonesian_date($izincuti['tgl'],'j F Y','');
                }
                
                $data['form'] = $this->parser->parse("spkp_personalia_form_pegawai/form_".$izincuti['kode'],$data,true);
                $data['form_profile'] = $this->parser->parse("spkp_personalia_form_pegawai/form_profile",$data,true);
                $data['content'] = $this->parser->parse("spkp_personalia_form_pegawai/form_edit",$data,true);
                
                $this->template->show($data,"home");
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    function load_form_profile($uid,$id=0){
        $data = $this->spkp_personalia_form_pegawai_model->get_user($uid);
        $izincuti = $this->spkp_personalia_form_pegawai_model->get_data_row($id); 
        $sisa_back = $this->spkp_personalia_form_pegawai_model->get_sisa_cuti($uid,date('Y')-1);
        $sisa_now  = $this->spkp_personalia_form_pegawai_model->get_sisa_cuti($uid,date('Y'));
        $data = array_merge($data,$izincuti);
        
        $data['nip']=substr($data['nip'],0,8)." ".substr($data['nip'],8,6)." ".substr($data['nip'],14,1)." ".substr($data['nip'],15,3);
                        
        $data['taken_back'] = intval($this->spkp_personalia_form_pegawai_model->get_taken_cuti($uid,date('Y')-1));
        $data['taken_now'] = intval($this->spkp_personalia_form_pegawai_model->get_taken_cuti($uid,date('Y')));
        $data['sisa_back'] = intval((12-$sisa_back['cb_back'])-$sisa_back['jml']);
        $data['sisa_now']  = intval((12-$sisa_now['cb_back'])-$sisa_now['jml']);
        $data['sisa_join'] = intval((12-$sisa_back['cb_back'])-$sisa_back['jml']) + intval((12-$sisa_now['cb_back'])-$sisa_now['jml']);
        
        echo $this->parser->parse("spkp_personalia_form_pegawai/form_profile",$data,true);
    }

	function doedit($id=0)
	{
		$this->authentication->verify('spkp_personalia_form_pegawai','edit');

        $this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

		if($this->form_validation->run()== FALSE){
			echo "ERROR_".validation_errors();
		}else{
			if($this->spkp_personalia_form_pegawai_model->doedit($id)){
				echo "OK_".$id;
			}else{
				echo "ERROR_Database Error";
			}
		}
	}
	
	function dodelete($id=0){
		$this->authentication->verify('spkp_personalia_form_pegawai','del');

		if($this->spkp_personalia_form_pegawai_model->dodelete($id)){
			echo "1";
		}else{
			echo "0";
		}
	}

    function html($id,$thn){
		$this->authentication->verify('spkp_personalia_form_pegawai','show');
		
		$data = $this->spkp_personalia_form_pegawai_model->json_izincuti($id,$thn);

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_personalia_form_pegawai/html",$data);
	}
    
    function html_cuti(){
        $this->authentication->verify('spkp_personalia_form_pegawai','show');
		
		$data = $this->spkp_personalia_form_pegawai_model->json_user();

		$data['Rows'] = $data[0]['Rows'];
		$this->parser->parse("spkp_personalia_form_pegawai/html_cuti",$data);
    }
    
    function excel($id,$thn){
		$this->authentication->verify('spkp_personalia_form_pegawai','show');

		$data = $this->spkp_personalia_form_pegawai_model->json_izincuti($id,$thn);

		$rows = $data[0]['Rows'];
		$data['title'] = "Daftar Cuti dan Izin";
        $data['thn'] = "Tahun ".$thn;
        
        $x=1;
        foreach($rows as $key=>$val){
            if($val['kode']=='itm'){
                $lama = "-";
            }else{
                $lama = $val['jml']." ".$val['hitungan'];
            }
            $main[] = array('urut'=>$x,'tgl'=>$val['stat_tgl'],'keterangan'=>$val['keterangan'],'alasan'=>$val['alasan'],'lama'=>$lama,'approve'=>$val['approve'],'status'=>$val['STATUS']);
            $x++;
        }
        
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/personalia_cuti.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $main);
		$output_file_name = $path.'export/report_personalia_cuti.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
	}
    
    function excel_cuti(){
        $this->authentication->verify('spkp_personalia_form_pegawai','show');

		$data = $this->spkp_personalia_form_pegawai_model->json_user();
        $rows = $data[0]['Rows'];
		
        $x=1;
        foreach($rows as $key=>$val){
            $frmt1 = substr($val['nip'],0,8);
            $frmt2 = substr($val['nip'],8,6);
            $frmt3 = substr($val['nip'],14,1);
            $frmt4 = substr($val['nip'],15,3);
            
            $hari_back = $val['hari_back'];
            $cb_back   = $val['cb_back'];
                
            $sum_back = (12-$cb_back)-$hari_back;
            
            $hari_now = $val['hari_now'];
            $cb_now   = $val['cb_now'];
                
            $sum_now = (12-$cb_now)-$hari_now;
                    
            $main[]=array('urut'=>$x,'nama'=>$val['nama'],'nip'=>$frmt1." ".$frmt2." ".$frmt3." ".$frmt4,
            'back'=>$sum_back,'now'=>$sum_now,'join'=>$sum_back+$sum_now);
            
            $x++;
        }    
        
        $data['title'] = "Daftar Sisa Cuti Pegawai";
        $data['sisa'] = "Sisa Cuti";
        $data['thn_back'] = date('Y')-1;
        $data['thn_now']  = "Sisa Cuti ".date('Y');
        
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		$template = $path.'templates/personalia_sisa_cuti.xlsx';
		$TBS->LoadTemplate($template);

		$TBS->MergeBlock('data', $main);
		$output_file_name = $path.'export/report_personalia_sisa_cuti.xlsx';
		$TBS->Show(OPENTBS_FILE, $output_file_name);
		echo $output_file_name;
    }
    
    function save_form($id,$kode){
        $this->authentication->verify('spkp_personalia_form_pegawai','edit');
        
        if($kode=="cl"){
            $this->form_validation->set_rules('jml', 'Jumlah', 'trim|required');
            $this->form_validation->set_rules('hitungan', 'Lama Cuti', 'trim|required');
            $this->form_validation->set_rules('stat_tgl', 'Tanggal Mulai', 'trim|required');
            $this->form_validation->set_rules('alasan_tambahan', 'Alasan', 'trim|required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        }else if($kode=="cp"){
            $this->form_validation->set_rules('jml', 'Jumlah', 'trim|required');
            $this->form_validation->set_rules('stat_tgl', 'Tanggal Mulai', 'trim|required');
            $this->form_validation->set_rules('alasan_tambahan', 'Alasan', 'trim|required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        }else if($kode=="sk"){
            $this->form_validation->set_rules('jml', 'Jumlah', 'trim|required');
            $this->form_validation->set_rules('hitungan', 'Lama Cuti', 'trim|required');
            $this->form_validation->set_rules('stat_sakit', 'Sakit', 'trim|required');
            $this->form_validation->set_rules('stat_lampiran', 'Lampiran', 'trim|required');
        }else if($kode=="ct"){
            $this->form_validation->set_rules('stat_thnkerja', 'Tahun', 'trim|required');
            $this->form_validation->set_rules('jml', 'Jumlah', 'trim|required');
            $this->form_validation->set_rules('stat_tgl', 'Tanggal Mulai', 'trim|required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        }else if($kode=="icb"){
            $this->form_validation->set_rules('jml', 'Jumlah', 'trim|required');
            $this->form_validation->set_rules('hitungan', 'Lama Cuti', 'trim|required');
            $this->form_validation->set_rules('stat_thnkerja', 'Tahun', 'trim|required');
            $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        }else if($kode=="itm"){
            $this->form_validation->set_rules('stat_tm', 'Keterangan Terlambat', 'trim|required');
            $this->form_validation->set_rules('stat_tgl', 'Tanggal Mulai', 'trim|required');
            $this->form_validation->set_rules('stat_tm_jam', 'Keterangan Jam', 'trim|required');
            $this->form_validation->set_rules('stat_tm_alasan_kondisi', 'Alasan Kondisi', 'trim|required');
            $this->form_validation->set_rules('stat_tm_alasan_perlu', 'Alasan Perlu', 'trim|required');
        }else if($kode=="itk"){
            $this->form_validation->set_rules('jml', 'Jumlah', 'trim|required');
            $this->form_validation->set_rules('stat_tgl', 'Tanggal Mulai', 'trim|required');
        }
        
		if($this->form_validation->run()== FALSE){
			echo validation_errors();
		}else{
			if($this->spkp_personalia_form_pegawai_model->save_form($id,$kode)){
                echo "1";
            }else{
                echo "0";
            }
		}
    }
    
    function get_hitungan($prm){
        $data = array();
        $data['prm'] = $prm;
        
        echo $this->parser->parse("spkp_personalia_form_pegawai/form_hitungan",$data,true);
    }
    
    function doinsert_jml_bln_thn($id,$kode){
        if($kode=="cl" || $kode=="sk" || $kode=="icb"){
            $count = $this->spkp_personalia_form_pegawai_model->get_count_bln_thn($id);
            $this->spkp_personalia_form_pegawai_model->update_jml_bln_thn($id,$count);
        }
    }
    
    function dosend_cuti($id,$kode){
        if($this->spkp_personalia_form_pegawai_model->update_status_kirim($id)){
            if($kode!="itm"){
                $this->doinsert_tgl_cuti($id);
                $this->doinsert_jml_bln_thn($id,$kode);
            }
            echo "1";
        }else{
            echo "0";
        }
    }
    
    function doinsert_tgl_cuti($id){
        $data = $this->spkp_personalia_form_pegawai_model->get_data_row($id); 
        $tgl_awal = $data['stat_tgl'];
        $arr_tgl_awal = explode("-",$data['stat_tgl']);
        
        if($data['hitungan']=='hari'){
            $tmbh_tgl = mktime(0,0,0,$arr_tgl_awal[1],$arr_tgl_awal[2]+$data['jml'],$arr_tgl_awal[0]);
        }else if($data['hitungan']=='bulan'){
            $tmbh_tgl = mktime(0,0,0,$arr_tgl_awal[1]+$data['jml'],$arr_tgl_awal[2],$arr_tgl_awal[0]);
        }else if($data['hitungan']=='tahun'){
            $tmbh_tgl = mktime(0,0,0,$arr_tgl_awal[1],$arr_tgl_awal[2],$arr_tgl_awal[0]+$data['jml']);
        }
        
        $tgl_akhir = date('Y-m-d',$tmbh_tgl);
        $pecah_akhir = explode("-",$tgl_akhir);
        
        $libur = $this->spkp_personalia_form_pegawai_model->get_all_holiday();
        $arr_libur = array();
        foreach($libur as $row_libur){
            $arr_libur[] = $row_libur->tgl;
        }
        
        $imp_libur = implode(",",$arr_libur);
        //print_r($arr_libur);
        
        $tgla = gregoriantojd($arr_tgl_awal[1],$arr_tgl_awal[2],$arr_tgl_awal[0]);
        $tglb = gregoriantojd($pecah_akhir[1],$pecah_akhir[2],$pecah_akhir[0]);
        
        $selisih = $tglb-$tgla;
        $sukses=0;
        $gagal=0;
        
        if($data['hitungan']=='hari'){
            $arr_hari = $arr_tgl_awal[2]-1;    
            for($i=1;$i<=$selisih;$i++){
                $tgl = mktime(0,0,0,$arr_tgl_awal[1],$arr_hari+$i,$arr_tgl_awal[0]);
                $str_tgl = date('Y-m-d',$tgl);
                
                if(in_array($str_tgl,$arr_libur)){
                    $gagal++;
                    $selisih++;
                }else{
                    if(date('N',$tgl)==6 || date('N',$tgl)==7){
                        $gagal++;
                        $selisih++;
                    }else{
                        $this->spkp_personalia_form_pegawai_model->insert_tgl_cuti($id,$str_tgl);
                        $sukses++;
                    }
                }
            }
        }else if($data['hitungan']=='bulan'){
            $arr_hari = $arr_tgl_awal[2]-1;   
            for($i=1;$i<=$selisih;$i++){
                $tgl = mktime(0,0,0,$arr_tgl_awal[1],$arr_hari+$i,$arr_tgl_awal[0]);
                $str_tgl = date('Y-m-d',$tgl);
                
                if(in_array($str_tgl,$arr_libur)){
                    $gagal++;
                }else{
                    if(date('N',$tgl)==6 || date('N',$tgl)==7){
                        $gagal++;
                    }else{
                        $this->spkp_personalia_form_pegawai_model->insert_tgl_cuti($id,$str_tgl);
                        $sukses++;
                    }
                }
            }
        }else if($data['hitungan']=='tahun'){
            $arr_hari = $arr_tgl_awal[2]-1;   
            for($i=1;$i<=$selisih;$i++){
                $tgl = mktime(0,0,0,$arr_tgl_awal[1],$arr_hari+$i,$arr_tgl_awal[0]);
                $str_tgl = date('Y-m-d',$tgl);
                
                if(in_array($str_tgl,$arr_libur)){
                    $gagal++;
                }else{
                    if(date('N',$tgl)==6 || date('N',$tgl)==7){
                        $gagal++;
                    }else{
                        $this->spkp_personalia_form_pegawai_model->insert_tgl_cuti($id,$str_tgl);
                        $sukses++;
                    }
                }
            }
        }
    }
    
    function load_form_cuti($uid,$id){
        $data = $this->spkp_personalia_form_pegawai_model->get_user($uid);
        $izincuti = $this->spkp_personalia_form_pegawai_model->get_data_row($id); 
        $posisi = $this->spkp_personalia_form_pegawai_model->get_posisi($uid);
        $data = array_merge($data,$izincuti,$posisi);
        $data['add_permission']=$this->authentication->verify_check('spkp_personalia_form_pegawai','add');
        $data['uid']=$uid;
        $data['id']=$id;
        $data['nip']=substr($data['nip'],0,8)." ".substr($data['nip'],8,6)." ".substr($data['nip'],14,1)." ".substr($data['nip'],15,3);
                
        if($izincuti['status_approve']=='1'){
            $data['status'] = "Telah Disetujui";
        }else{
            $data['status'] = "Belum Disetujui";
        }
         
        if($izincuti['kode']=='cl'){
             $data['prm_hitungan']        = $izincuti['hitungan'];
             $data['prm_jml']             = $izincuti['jml']=="" ? "" : $izincuti['jml'];
             $data['prm_stat_tgl']        = $izincuti['stat_tgl']=="" ? "" : $izincuti['stat_tgl'];
             $data['prm_alasan_tambahan'] = $izincuti['alasan_tambahan']=="" ? "" : $izincuti['alasan_tambahan'];
             $data['prm_alamat']          = $izincuti['alamat']=="" ? "" : $izincuti['alamat'];
         }else if($izincuti['kode']=='cp'){
             $data['prm_jml']             = $izincuti['jml']=="" ? "" : $izincuti['jml'];
             $data['prm_stat_tgl']        = $izincuti['stat_tgl']=="" ? "" : $izincuti['stat_tgl'];
             $data['prm_alasan_tambahan'] = $izincuti['alasan_tambahan']=="" ? "" : $izincuti['alasan_tambahan'];
             $data['prm_alamat']          = $izincuti['alamat']=="" ? "" : $izincuti['alamat'];
         }else if($izincuti['kode']=='sk'){
             $data['prm_hitungan']        = $izincuti['hitungan'];
             $data['prm_jml']             = $izincuti['jml']=="" ? "" : $izincuti['jml'];
             $data['prm_stat_sakit']      = $izincuti['stat_sakit'];
             $data['prm_stat_lampiran']   = $izincuti['stat_lampiran'];
         }else if($izincuti['kode']=='ct'){
             $data['prm_stat_thnkerja']   = $izincuti['stat_thnkerja']=="" ? "" : $izincuti['stat_thnkerja'];
             $data['prm_jml']             = $izincuti['jml']=="" ? "" : $izincuti['jml'];
             $data['prm_stat_tgl']        = $izincuti['stat_tgl']=="" ? "" : $izincuti['stat_tgl'];
             $data['prm_alamat']          = $izincuti['alamat']=="" ? "" : $izincuti['alamat'];
         }else if($izincuti['kode']=='icb'){
             $data['prm_hitungan']        = $izincuti['hitungan'];
             $data['prm_jml']             = $izincuti['jml']=="" ? "" : $izincuti['jml'];
             $data['prm_stat_thnkerja']   = $izincuti['stat_thnkerja']=="" ? "" : $izincuti['stat_thnkerja'];
             $data['prm_alamat']          = $izincuti['alamat']=="" ? "" : $izincuti['alamat'];
         }else if($izincuti['kode']=='itm'){
             $data['prm_stat_tm']         = $izincuti['stat_tm']=="" ? "" : $izincuti['stat_tm'];
             $data['prm_stat_tgl']        = $izincuti['stat_tgl']=="" ? "" : $izincuti['stat_tgl'];
             $data['prm_stat_tm_jam']     = $izincuti['stat_tm_jam']=="" ? "" : $izincuti['stat_tm_jam'];
             $data['prm_tgl']             = "Jakarta, ".$this->authentication->indonesian_date($izincuti['tgl'],'j F Y','');
             $data['prm_stat_tm_alasan_kondisi'] = $izincuti['stat_tm_alasan_kondisi']=="" ? "" : $izincuti['stat_tm_alasan_kondisi'];
             $data['prm_stat_tm_alasan_perlu']   = $izincuti['stat_tm_alasan_perlu']=="" ? "" : $izincuti['stat_tm_alasan_perlu'];
         }else if($izincuti['kode']=='itk'){
            $data['prm_jml']              = $izincuti['jml']=="" ? "" : $izincuti['jml'];
            $data['prm_stat_tgl']         = $izincuti['stat_tgl']=="" ? "" : $izincuti['stat_tgl'];
            $data['prm_tgl']              = "Jakarta, ".$this->authentication->indonesian_date($izincuti['tgl'],'j F Y','');
         }
                
        echo $this->parser->parse("spkp_personalia_form_pegawai/form_".$izincuti['kode'],$data,true);
    }
    
    function export($uid,$id,$kode){
        $this->authentication->verify('spkp_personalia_form_pegawai','show');

		$data = $this->spkp_personalia_form_pegawai_model->get_user($uid);
        $izincuti = $this->spkp_personalia_form_pegawai_model->get_data_row($id); 
        $posisi = $this->spkp_personalia_form_pegawai_model->get_posisi($uid);
        $data = array_merge($data,$izincuti,$posisi);
        
        if($kode=="itm"){
            $data['frm_izin']     = $izincuti['stat_tm']=="masuk" ? "terlambat masuk" : "pulang sebelum waktunya";
            $data['frm_tgl_izin'] = "pada hari ".$this->authentication->indonesian_date($izincuti['stat_tgl'],'l','')." tanggal ".$this->authentication->indonesian_date($izincuti['stat_tgl'],'j F Y','');
            $data['frm_tgl']      = "Jakarta, ".$this->authentication->indonesian_date($izincuti['tgl'],'j F Y','');
        }else if($kode=="itk"){
            $data['frm_tgl_izin'] = $this->authentication->indonesian_date($izincuti['stat_tgl'],'j F Y','');
            $data['frm_tgl']      = "Jakarta, ".$this->authentication->indonesian_date($izincuti['tgl'],'j F Y','');
        }else{
            $data['frm_tgl_izin'] = $this->authentication->indonesian_date($izincuti['stat_tgl'],'j F Y','');
        }
        
        $main = array();
         
		$path = dirname(__FILE__).'/../../public/doc_xls_';
		$TBS = new clsTinyButStrong;
		$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
		$TBS->ResetVarRef(false);
		$TBS->VarRef =  &$data;		
		
        if($kode=="cl"){
            $doc_temp = $path.'templates/personalia_cuti_cl.docx';
            $doc_output = $path.'export/report_personalia_cuti_cl.docx';
        }else if($kode=="cp"){
            $doc_temp = $path.'templates/personalia_cuti_cp.docx';
            $doc_output = $path.'export/report_personalia_cuti_cp.docx';
        }else if($kode=="sk"){
            $doc_temp = $path.'templates/personalia_cuti_sk.docx';
            $doc_output = $path.'export/report_personalia_cuti_sk.docx';
        }else if($kode=="ct"){
            $doc_temp = $path.'templates/personalia_cuti_ct.docx';
            $doc_output = $path.'export/report_personalia_cuti_ct.docx';
        }else if($kode=="icb"){
            $doc_temp = $path.'templates/personalia_cuti_icb.docx';
            $doc_output = $path.'export/report_personalia_cuti_icb.docx';
        }else if($kode=="itm"){
            $doc_temp = $path.'templates/personalia_cuti_itm.docx';
            $doc_output = $path.'export/report_personalia_cuti_itm.docx';
        }else if($kode=="itk"){
            $doc_temp = $path.'templates/personalia_cuti_itk.docx';
            $doc_output = $path.'export/report_personalia_cuti_itk.docx';
        }
        
        $TBS->LoadTemplate($doc_temp);
        $TBS->MergeBlock('main', $main);
		
		$TBS->Show(OPENTBS_FILE, $doc_output);
		echo $doc_output;
    }
    
    function doapprove_status($id,$status){
        
        $approve = $status=="0" ? "1" : "0";
        if($this->spkp_personalia_form_pegawai_model->approve_status($id,$approve)){
            echo "1";
        }else{
            echo "0";
        }
    }
}
