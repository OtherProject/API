<?php
class mdirectory extends Database {
	
    var $prefix = "api";
    function directory_inp($data)
	{
		
		$date = date('Y-m-d H:i:s');
		$datetime = array();
        
		if(!empty($data['postdate'])) $data['postdate'] = date("Y-m-d H:i:s",strtotime($data['postdate']));
        if(!empty($data['expired_date'])) $data['expired_date'] = date("Y-m-d H:i:s",strtotime($data['expired_date']));
        else $data['expired_date'] = '0000-00-00';
        
        $data['title'] = mysql_escape_string($data['title']);
        $data['brief'] = mysql_escape_string($data['brief']);
        $data['content'] = mysql_escape_string($data['content']);

		if($data['action'] == 'insert'){
			
			$query = "INSERT INTO  
						{$this->prefix}_news_content (title,brief,content,image,file,categoryid,articletype,
												created_date,posted_date,expired_date,authorid,n_status)
					VALUES
						('".$data['title']."','".$data['brief']."','".$data['content']."','".$data['image']."'
                        ,'".$data['file']."','".$data['categoryid']."','".$data['articletype']."','".$date."'
                        ,'".$data['postdate']."','".$data['expired_date']."','".$data['authorid']."','".$data['n_status']."')";
                        //pr($query);exit;

		} else {
            if($data['categoryid']=='1' && $data['articletype']=='2' || $data['categoryid']=='8') $date = $data['postdate'];
			$query = "UPDATE {$this->prefix}_news_content
						SET 
							title = '{$data['title']}',
							brief = '{$data['brief']}',
							content = '{$data['content']}',
							image = '{$data['image']}',
							file = '{$data['file']}',
                            articletype = '{$data['articletype']}',
							posted_date = '".$date."',
                            expired_date = '{$data['expired_date']}',
							authorid = '{$data['authorid']}',
							n_status = {$data['n_status']}
						WHERE
							id = '{$data['id']}'";
		}
// pr($query);
		$result = $this->query($query);
		
		return $result;
	}
	function getActivity($categoryid=null, $select='*', $group = true)
	{
        if($group){
            $query = "SELECT {$select} FROM {$this->prefix}_news_content WHERE n_status !='2' AND categoryid = '{$categoryid}' GROUP BY title ORDER BY created_date DESC";
        }else{
            $query = "SELECT {$select} FROM {$this->prefix}_news_content WHERE n_status !='2' AND categoryid = '{$categoryid}' ORDER BY created_date DESC";
        }
		
        //pr($query);exit;
		$result = $this->fetch($query,1);

		foreach ($result as $key => $value) {
		  
            if($query['authorid'] != 0){
    			$query = "SELECT username FROM admin_member WHERE id={$value['authorid']} LIMIT 1";
    
    			$username = $this->fetch($query,0);
    
    			$result[$key]['username'] = $username['username'];
            }
		}
		
		return $result;
	}
    
    function getActivityFilter($key, $value, $loop = false){
        $query = "SELECT * FROM {$this->prefix}_news_content WHERE n_status !='2' AND {$key} = '{$value}' ORDER BY created_date DESC";
		
        //pr($query);exit;
		$result = $this->fetch($query,$loop);

		foreach ($result as $key => $value) {
		  
            if($query['authorid'] != 0){
    			$query = "SELECT username FROM admin_member WHERE id={$value['authorid']} LIMIT 1";
    
    			$username = $this->fetch($query,0);
    
    			$result[$key]['username'] = $username['username'];
            }
		}
		
		return $result;
    }
    
    function getActivityData($categoryid=null, $activity_type = false){
        if(!$activity_type) return false;
        
        $query = "SELECT * FROM {$this->prefix}_news_content WHERE n_status !='2' AND categoryid = '{$categoryid}' AND title = '{$activity_type}' ORDER BY created_date DESC";
		
        //pr($query);exit;
		$result = $this->fetch($query,1);

		foreach ($result as $key => $value) {
		  
            if($query['authorid'] != 0){
    			$query = "SELECT username FROM admin_member WHERE id={$value['authorid']} LIMIT 1";
    
    			$username = $this->fetch($query,0);
    
    			$result[$key]['username'] = $username['username'];
            }
		}
		
		return $result;
    }
    
    function get_files($typealbum=null, $id = null)
	{
        if($id){
            $query = "SELECT * FROM {$this->prefix}_news_content_repo WHERE id = '{$id}'";
		
            $result = $this->fetch($query,0);
        }else{
            $query = "SELECT * FROM {$this->prefix}_news_content_repo WHERE n_status != '2' AND typealbum = '{$typealbum}' ORDER BY created_date DESC";
		
            $result = $this->fetch($query,1);
        }
		
		return $result;
	}
    
    function file_del($id)
	{
		//pr($id);
		foreach ($id as $key => $value) {
			
			$query = "DELETE FROM {$this->prefix}_news_content_repo WHERE id = '{$value}'";
		
			$result = $this->query($query);
		
		}

		return true;
		
	}
}
?>