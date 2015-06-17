<?php
class modeldirektori extends Database {
	
	var $prefix = "api";	
	function get_rumpun($term=false,$queryidrumpun=false)
	{

		$query = "SELECT * FROM api_nomenklatur WHERE nmps_lama LIKE '%{$term}%' {$queryidrumpun}";

		// $result = $link->query($query); 
		// $query = "SELECT * FROM {$this->prefix}_category WHERE n_status = '1' ORDER BY create_date DESC";
		
		$result = $this->fetch($query,1);

		
		return $result;

	}
	function get_rumpunid($id)
	{	
		// pr($id);
		// $id="";
		// if($id)	$queryidrumpun=" WHERE id={$id} ";

		$query = "SELECT * FROM api_nomenklatur WHERE id={$id}  LIMIT 1";
		// pr($query);
		// $result = $link->query($query); 
		// $query = "SELECT * FROM {$this->prefix}_category WHERE n_status = '1' ORDER BY create_date DESC";
		
		$result = $this->fetch($query,1);

		
		return $result;
	}

	function getKepakaran($categoryid=1, $content=false, $type=1, $start=0, $limit=5)
	{
		
		$filter = "";
		if ($content) $filter = " AND content LIKE '%{$content}%' ";

		$sql = "SELECT * FROM {$this->prefix}_news_content WHERE n_status = 1 AND categoryid = {$categoryid}
				AND articleType = {$type} {$filter} LIMIT {$start},{$limit}";
		// pr($sql);

		$res = $this->fetch($sql,1);

		$sqlC = "SELECT * FROM {$this->prefix}_news_content WHERE n_status = 1 AND categoryid = {$categoryid}
				AND articleType = {$type} {$filter}";
		// pr($sql);

		$resC = $this->fetch($sqlC,1);

		$dataCount['countData']=count($resC);
		$dataCount['limit']=$limit;

		if ($res) return array('dataArr'=>$res, 'dataCount'=>$dataCount);;
		return false;
	}
	function getCountData($categoryid=1, $type=1,$where=false)
	{

		$filter = "";
		if ($where) $filter =$where;
		$sql = "SELECT id FROM {$this->prefix}_news_content WHERE n_status = 1 AND categoryid = {$categoryid}
				AND articleType = {$type} {$filter}";
		// pr($sql);
		$res = $this->fetch($sql,1);
		
		return $res;
	}
	function get_files($typealbum=null, $id = null)
	{
        // if($id){
            $query = "SELECT * FROM {$this->prefix}_news_content_repo WHERE otherid = '{$id}' ";
		
            $result = $this->fetch($query,1);
        // }else{
        //     $query = "SELECT * FROM {$this->prefix}_news_content_repo WHERE n_status != '2' AND typealbum = '{$typealbum}' ORDER BY created_date DESC";
		
        //     $result = $this->fetch($query,1);
        // }
		
		return $result;
	}
	function getNews($id=false, $categoryid=1, $type=1, $start=0, $limit=5,$where=false)
	{
		
		$filter = "";
		if ($id) $filter = " AND id = {$id} ";
		if ($where) $filter .=$where;
		$sql = "SELECT * FROM {$this->prefix}_news_content WHERE n_status = 1 AND categoryid = {$categoryid}
				AND articleType = {$type} {$filter} ORDER BY posted_date DESC LIMIT {$start},{$limit}";
		// pr($sql);
		$res = $this->fetch($sql,1);
		if ($res){

            
            foreach ($res as $key => $value) {
                $res[$key]['changeDate'] = changeDate($value['posted_date']);
            }

            // pr($res);
            return $res;

        } 
		return false;
	}
}
?>