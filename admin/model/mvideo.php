<?php
class mvideo extends Database {
	
	var $prefix = "api";
	function video_inp($data)
	{
		
		$date = date('Y-m-d H:i:s');
		$datetime = array();
        
		if(!empty($data['postdate'])){
            $data['postdate'] = date("Y-m-d H:i:s",strtotime($data['postdate'])); 
		}else{
		  $data['postdate'] = $date;
		}
        if(!empty($data['expired_date'])) $data['expired_date'] = date("Y-m-d H:i:s",strtotime($data['expired_date']));
        
		if($data['action'] == 'insert'){
			//pr($data);exit;
			//yang atas nama variabel @ db.
			$query = "INSERT INTO  
			  
						{$this->prefix}_video (
                            video_type,langid,
                            title_bhs,brief_bhs,content_bhs,
                            title_en,brief_en,content_en,
                            title_uzbek,brief_uzbek,content_uzbek,
                            video,file,created_date,
                            posted_date,author_id,n_stats)
					VALUES
						('".$data['video_type']."','".$data['langID']."'
                        ,'".$data['title_bhs']."','".$data['brief_bhs']."','".$data['content_bhs']."'
                        ,'".$data['title_en']."','".$data['brief_en']."','".$data['content_en']."'
                        ,'".$data['title_uzbek']."','".$data['brief_uzbek']."','".$data['content_uzbek']."'
                        ,'".$data['video_name']."','".$data['video_url']."','".$date."'
                        ,'".$data['postdate']."','".$data['authorid']."','".$data['n_stats']."')";
                        
                        //pr($query);exit;

		} else {
            if($data['categoryid']=='1' && $data['articletype']=='2') $date = $data['postdate'];
			$query = "UPDATE {$this->prefix}_video
						SET 
                            video_type = '{$data['video_type']}',
							title_bhs = '{$data['title_bhs']}',
							brief_bhs = '{$data['brief_bhs']}',
							content_bhs = '{$data['content_bhs']}',
                            
                            title_en = '{$data['title_en']}',
							brief_en = '{$data['brief_en']}',
							content_en = '{$data['content_en']}',
                            
                            title_uzbek = '{$data['title_uzbek']}',
							brief_uzbek = '{$data['brief_uzbek']}',
							content_uzbek = '{$data['content_uzbek']}',
                            
							video = '{$data['video_name']}',
							file = '{$data['video_url']}',
							posted_date = '".$date."',
                            expired_date = '{$data['expired_date']}',
							author_id = '{$data['authorid']}',
							n_stats = {$data['n_stats']}
						WHERE
							id = '{$data['id']}'";
		}
// pr($query);
		$result = $this->query($query);
		
		return $result;
	}
	
	function get_video($n_stats=null)
	{
		$query = "SELECT * FROM {$this->prefix}_video WHERE n_stats != '2' ORDER BY posted_date DESC";
		
		$result = $this->fetch($query,1);

 		foreach ($result as $key => $value) {
 			$query = "SELECT username FROM admin_member WHERE id={$value['author_id']} LIMIT 1";
 
 			$username = $this->fetch($query,0);
 
 			$result[$key]['username'] = $username['username'];
 		}
		
		return $result;
	}
    
    function get_video_filter($categoryid=null,$articletype=null,$type=1)
	{
		$query = "SELECT * FROM {$this->prefix}_video WHERE n_stats = '1' AND categoryid = '{$categoryid}' AND articleType = '{$articletype}' OR n_status = '0' AND categoryid = '{$categoryid}' AND articleType = '{$articletype}' ORDER BY created_date DESC";
		
		$result = $this->fetch($query,0);
        
        if($result){
    		$query = "SELECT username FROM admin_member WHERE id={$result['authorid']} LIMIT 1";
    
    		$username = $this->fetch($query,0);
    
    		$result['username'] = $username['username'];
		}
		return $result;
	}
	
	function get_video_trash($categoryid=null)
	{
		$query = "SELECT * FROM {$this->prefix}_video WHERE n_status = '2' AND categoryid = '{$categoryid}' ORDER BY created_date DESC";
		
		$result = $this->fetch($query,1);

		foreach ($result as $key => $value) {
			$query = "SELECT username FROM admin_member WHERE id={$value['authorid']} LIMIT 1";

			$username = $this->fetch($query,0);

			$result[$key]['username'] = $username['username'];
		}
		
		return $result;
	}
	
	function get_video_id($id)
	{
		$query = "SELECT * FROM {$this->prefix}_video WHERE id= {$id}";
		
		$result = $this->fetch($query,0);

		//if($result['posted_date'] != '') $result['posted_date'] = dateFormat($result['posted_date'],'dd-mm-yyyy');
		($result['n_status'] == 1) ? $result['n_status'] = 'checked' : $result['n_status'] = '';

		return $result;
	}
    
    function video_del($id)
	{
		//pr($id);
		foreach ($id as $key => $value) {
			
			$query = "DELETE FROM {$this->prefix}_video WHERE id = '{$value}'";
		
			$result = $this->query($query);
		
		}

		return true;
		
	}
}
?>