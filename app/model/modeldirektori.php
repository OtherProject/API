<?php
class modeldirektori extends Database {
	
	var $prefix = "api";	
	function get_category($type=1)
	{
		$query = "SELECT * FROM {$this->prefix}_category WHERE n_status = '1' ORDER BY create_date DESC";
		
		$result = $this->fetch($query,1);

		
		return $result;
	}
	
}
?>