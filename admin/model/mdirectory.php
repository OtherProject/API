<?php
class mdirectory extends Database {
	
    var $prefix = "api";
    
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