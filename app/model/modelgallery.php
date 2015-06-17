<?php
class modelgallery extends Database {
	
	var $prefix = "api";
	
	function get_images($albumid=null,$type=1)
	{
		$query = "SELECT * FROM {$this->prefix}_news_content_repo WHERE n_status = '1' AND otherid = '{$albumid}' ORDER BY created_date DESC";
		
		$result = $this->fetch($query,1);
		
		return $result;
	}

    function get_article($categoryid=false,$type=1,$start=0, $limit=5)
	{
		
		$query = "SELECT * FROM {$this->prefix}_news_content WHERE categoryid = '{$categoryid}' ORDER BY created_date DESC LIMIT {$start},{$limit}";
		
		$result = $this->fetch($query,1);
		// pr($result);
		$i=0;
		foreach($result as $value){
			$query_count = "SELECT count(*) FROM {$this->prefix}_news_content_repo WHERE n_status = '1' AND otherid = '{$value['id']}' ORDER BY created_date DESC";
			
			$result_count = $this->fetch($query_count,0);
			// pr($result_count);
			$result[$i]['count']=$result_count['count(*)'];
			$i++;
		}
		// pr($result);
		return $result;
	}

	 function get_article_id($articleid=null,$type=1)
	{
		$query = "SELECT * FROM {$this->prefix}_news_content WHERE (n_status = '1' OR n_status = '0') AND id = '{$articleid}' ORDER BY created_date DESC";
		
		$result = $this->fetch($query,0);
		
		return $result;
	}
	function getCountDatafoto($categoryid=1, $type=1,$where=false)
	{

		$filter = "";
		if ($where) $filter =$where;
		$sql = "SELECT id FROM {$this->prefix}_news_content WHERE categoryid = {$categoryid}
				AND articleType = {$type} {$filter}";
		// pr($sql);
		$res = $this->fetch($sql,1);
		
		return $res;
	}
	
	


}
?>