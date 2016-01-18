<?php
class Spkp_org_structure_model extends CI_Model {
    
    function __construct(){
        parent::__construct();
	}

 	function orgchart($id=0){
		$data = array();

		$sql= "SELECT `mas_jabatan`.*, CONCAT(`nama_jabatan`, ' ', `mas_subdit`.`ket`) AS jabatan FROM (`mas_jabatan`) 
		INNER JOIN `mas_subdit` ON `mas_subdit`.`id_subdit`=`mas_jabatan`.`id_subdit` WHERE `id_parent` = 0";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
			$data = $query->row_array();
		}
		return $data;
	}
    
    function get_image($subdit){
        $query = $this->db->query("SELECT a.id, b.* FROM pegawai_jabatan a INNER JOIN app_users_profile b 
                                    ON a.id = b.id WHERE a.id_subdit = '$subdit'");
        return $query->row_array();
    }

}
?>