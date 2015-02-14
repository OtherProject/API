<?php
class userHelper extends Database {
	
    function __construct()
    {
        $session = new Session;
        $getSessi = $session->get_session();
        $this->user = $getSessi['ses_user']['login'];
        $this->prefix = "api";
    }

    function editProfile($data=false){
        if($data==false) return false;
        
        if (empty($data['twitter'])){
            $dataTwitter = 'NULL';
        }else{
            $dataTwitter = "'".$data['twitter']."'";
        }
        
        if (empty($data['website'])){
            $dataWeb = 'NULL';
        }else{
            $dataWeb = "'".$data['website']."'";
        }
        
        if (empty($data['phone'])){
            $dataPhone = 'NULL';
        }else{
            $dataPhone = "'".$data['phone']."'";
        }
        
        $session = new Session;
        $ses_user = $session->get_session();
        $user = $ses_user['ses_user'];                
             
        $sql = "UPDATE `person` SET `name` = '".$data['name']."', `email` = '".$data['email']."', `project` = '".$data['project']."', `institutions` = '".$data['institutions']."', `twitter` = $dataTwitter, `website` = $dataWeb, `phone` = $dataPhone WHERE `id` = '".$user['login']['id']."' ";
        $res = $this->query($sql,0);
        $sql2 = "UPDATE `florakb_person` SET `username` = '".$data['username']."' WHERE `id` = '".$user['login']['id']."' ";
        $res2 = $this->query($sql2,1);
        if($res && $res2){return true;}
    }
    
    function editPassword($data=false){
        if($data==false) return false;
        
        global $CONFIG;
		$salt = $CONFIG['default']['salt'];
		$password = sha1($data['newPassword'].$salt);
        
        $session = new Session;
        $ses_user = $session->get_session();
        $user = $ses_user['ses_user'];
        
        $sql = "UPDATE `florakb_person` SET `password` = '".$password."', `salt` = '".$salt."' WHERE `id` = '".$user['login']['id']."' ";
        $res = $this->query($sql,1);
        if($res){return true;}
    }
    
    /**
     * @todo get data user/person
     * 
     * @param $data = 
     * @param $field =  field name
     */
    function getUserData($field,$data){
        if($data==false) return false;
        $sql = "SELECT * FROM `person` WHERE `$field` = '".$data."' ";
        $res = $this->fetch($sql,0);  
        if(empty($res)){return false;}
        return $res; 
    }
    
    /**
     * @todo get data user/person app
     * 
     * @param $data = 
     * @param $field =  field name
     */
    function getUserappData($field,$data){
        if($data==false) return false;
        $sql = "SELECT * FROM `florakb_person` WHERE `$field` = '".$data."' ";
        $res = $this->fetch($sql,0,1);  
        if(empty($res)){return false;}
        return $res; 
    }

    function storeUserUploadLog($data=null, $filename=null)
    {

        $userid = $this->user['id'];
        $date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO `florakb_upload_log` (userid, filename, `desc`, upload_date) 
                VALUES ({$userid}, '{$filename}', '{$data}', '{$date}')";
        // pr($sql);
        $res = $this->query($sql,1);  
        if ($res) return true;
        return false;
    }

    function getUserAccount($data=array(), $debug=false, $detail=false)
    {

        $filter = "";
        $id = $data['id'];
        if ($id) $filter .= " AND sm.id = {$id}";

        if (!$detail){

            $sql = array(
                    'table'=>"social_member AS sm",
                    'field'=>"sm.id, sm.name, sm.email, sm.last_name, sm.pendidikan, sm.kepakaran, sm.n_status" ,
                    'condition'=>" sm.name !='' {$filter}",
                    );
            $res = $this->lazyQuery($sql,$debug);
        }else{

            $sql = array(
                    'table'=>"social_member AS sm",
                    'field'=>"sm.*" ,
                    'condition'=>" sm.name !='' {$filter}",
                    );
            $res = $this->lazyQuery($sql,$debug);
            if ($res){
                foreach ($res as $key => $value) {

                    $sql1 = array(
                            'table'=>"{$this->prefix}_riwayat_pendidikan AS rp",
                            'field'=>"rp.*" ,
                            'condition'=>" rp.userID = {$value['id']} AND rp.tahun != ''",
                            );
                    $res[$key]['riwayat_pendidikan'] = $this->lazyQuery($sql1,$debug);
                }
            }
        }
       

        if ($res) return $res;
        return false;
    }
}
?>