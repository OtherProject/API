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
			$query = "SELECT sm.*, nmkl.nmps_lama ,nmkl.internasional_term,nmkl.rumpun_txt FROM social_member as sm left join api_nomenklatur as nmkl on sm.kepakaran=nmkl.id  WHERE sm.name LIKE '".$kategori."%' AND sm.n_status = '1' ORDER BY sm.name ASC limit $start,$limit";
		
		}
		$result = $this->fetch($query,1);
		
		return $result;
	}
	function Allmemberkepakaran($kategori,$fleg,$start=false,$limit=false)
	{	
		$queryKepakaran="";
		if($kategori){
			$queryKepakaran=" AND sm.kepakaran={$kategori} ";
		}
		if($fleg==0){
			$query = "SELECT * FROM social_member as sm WHERE sm.n_status = '1' {$queryKepakaran} ORDER BY sm.name ASC";
		}else{

			$query = "SELECT sm.*, nmkl.nmps_lama ,nmkl.internasional_term,nmkl.rumpun_txt FROM social_member as sm left join api_nomenklatur as nmkl on sm.kepakaran=nmkl.id  WHERE sm.n_status = '1' {$queryKepakaran} ORDER BY sm.name ASC limit $start,$limit";
		
		}
		$result = $this->fetch($query,1);
		
		return $result;
	}

	function detailmember($id)
	{
		// $query="select K.noKontrak,K.tglKontrak,K.keterangan, S.nosp2d, S.tglsp2d from kontrak K "
                  // . " left join sp2d S on K.id=S.idKontrak where K.noKontrak='$noKontrak'";

		$query = "SELECT sm.*, nmkl.nmps_lama ,nmkl.internasional_term,nmkl.rumpun_txt FROM social_member as sm left join api_nomenklatur as nmkl on sm.kepakaran=nmkl.id WHERE sm.id='{$id}' AND sm.n_status = '1'";
		
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