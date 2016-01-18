<?php
class Spkp_org_structure extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('spkp_org_structure_model');
		$this->chart = "";
	}
	
	function index(){
		$this->authentication->verify('spkp_org_structure','show');
        
	    $data = array();
		$data['content'] = $this->parser->parse("spkp_org_structure/tree",$data,true);

		$this->template->show($data,"home");
	}
	
	function charts($id_parent=0){
		$query = $this->db-> query("SELECT * FROM mas_subdit WHERE id_top='".$id_parent."'");

		if($this->chart==""){
			$this->chart .=	"<ul class='tree'>";
		}else{
			$this->chart .=	"<ul>";
		}
		foreach ($query->result() as $row){
			if($id_parent>1){
				$this->chart .="<li style='width:210px;'><div style='border:5px solid #FEFEFE;width:180px;min-height:100px;'>";
			}
			elseif($id_parent>0){
				$this->chart .="<li style='width:300px;'><div class='' style='border:5px solid #BBBBBB;width:180px;min-height:100px;'>";
			}else{
				$this->chart .="<li><div class='current' style='width:180px;min-height:100px;border:5px solid #999999;'>";
			}
                    $attr = $this->spkp_org_structure_model->get_image($row->id_subdit); 
                    if(isset($attr['image'])){
                        $image = base_url()."media/images/user/".$attr['image'];
                    }else{
                        $image = base_url()."media/images/smily-user-icon.jpg";
                    }
                    $this->chart .="<div style='border: 1px solid #000000;height: 65px;margin: 0 auto;position: relative;width: 65px'><img src='".$image."' width='65' height='65' /></div>";
					$this->chart .= $row->ket."</div>";
					$this->charts($row->id_subdit);
					$this->chart .= "
					</li>
					";
		}
		$this->chart .=	"</ul>";

	}
    
	function tree(){
		$this->authentication->verify('spkp_org_structure','show');
        
		$this->charts();
		$data['chart'] =$this->chart;
		echo $this->parser->parse("spkp_org_structure/chart",$data, true);
	}
	
	
	
}
