<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings{
	
	var $info=array();

	public function __construct() 
	{
		$CI =& get_instance();
		$site = $CI->db->select("s.id, s.group_setting, s.variable_setting, s.value_setting, s.deskripsi_setting")
		->from('settings as s')
		->get();
		
		if($site->num_rows() == 0) {
				echo "You are missing the site settings database row.";
		} else {
			foreach($site->result() as $set){
				$key=$set->variable_setting;
				$value=$set->value_setting;
				$this->info[$key]=$value;
			}
		}
	}

}