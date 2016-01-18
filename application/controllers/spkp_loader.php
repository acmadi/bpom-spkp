<?php
class Spkp_loader extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
	}
	
	function index($path){
		readfile($path);
	}
	
}
