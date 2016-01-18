<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class WNews {

		function WNews(){
			if ( !isset($this->obj) ) $this->obj =& get_instance();
		}
		
		function wnews_top($id_theme)
		{
			$query = $this->obj->db->query("SELECT * FROM app_files_contents,app_files WHERE app_files_contents.file_id=app_files.id AND app_files.module='news' ORDER BY  app_files.id_theme=".$id_theme." DESC,app_files_contents.dtime DESC");

			return $query->result();

		}

	}	
