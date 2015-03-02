<?php
class modelmember extends Database {
	
	var $prefix = "api";	
	function get_category($type=1)
	{
		$query = "SELECT * FROM {$this->prefix}_category WHERE n_status = '1' ORDER BY create_date DESC";
		
		$result = $this->fetch($query,1);

		// foreach ($result as $key => $value) {
		// 	$query = "SELECT username FROM admin_member WHERE id=1 LIMIT 1";
		// 	// $query = "SELECT username FROM admin_member WHERE id={$value['authorid']} LIMIT 1";

		// 	$username = $this->fetch($query,0);

		// 	$result[$key]['username'] = $username['username'];
		// }
		
		return $result;
	}

	function Allmember($kategori,$fleg,$start=false,$limit=false)
	{
		if($fleg==0){
			$query = "SELECT * FROM social_member WHERE name LIKE '".$kategori."%' AND n_status = '1' ORDER BY name ASC";
		}else{
			$query = "SELECT * FROM social_member WHERE name LIKE '".$kategori."%' AND n_status = '1' ORDER BY name ASC limit $start,$limit";
		
		}
		$result = $this->fetch($query,1);
		
		return $result;
	}

	function detailmember($id)
	{
		
		$query = "SELECT * FROM social_member WHERE id='{$id}'AND n_status = '1'";
		
		$result = $this->fetch($query,1);
		
		return $result;
	}
	function getRiwayat($userid,$type)
	{
		
		$query = "SELECT * FROM api_riwayat_pendidikan WHERE userID='{$userid}'AND type = '{$type}' AND tahun != ''";
		
		$result = $this->fetch($query,1);
		
		return $result;
	}
	
}
?>