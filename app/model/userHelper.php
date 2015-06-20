<?php
class userHelper extends Database {
	
    function __construct()
    {
        $session = new Session;
        $getSessi = $session->get_session();
        $this->user = $getSessi['login'];
        $this->salt = "ovancop1234";
        $this->token = str_shuffle('cmsaj23y4ywdni237yeisa');
        $this->date = date('Y-m-d H:i:s');
    }
    
    /**
     * @todo edit user profile, update user data from inputed data
     */
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
        $user = $ses_user;                
             
        $sql = "UPDATE `person` SET `name` = '".$data['name']."', `email` = '".$data['email']."', `project` = '".$data['project']."', `institutions` = '".$data['institutions']."', `twitter` = $dataTwitter, `website` = $dataWeb, `phone` = $dataPhone WHERE `id` = '".$user['login']['id']."' ";
        $res = $this->query($sql,0);
        //$sql2 = "UPDATE `florakb_person` SET `username` = '".$data['username']."' WHERE `id` = '".$user['login']['id']."' ";
        //$res2 = $this->query($sql2,1);
        //if($res && $res2){return true;}
        if($res){return true;}
    }
    
    /**
     * @todo edit user password
     */
    function editPassword($data=false){
        if($data==false) return false;
        
        global $CONFIG;
		$salt = $CONFIG['default']['salt'];
		$password = sha1($data['newPassword'].$salt);
        
        $session = new Session;
        $ses_user = $session->get_session();
        $user = $ses_user;
        
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
        $sql = "SELECT * FROM `social_member` WHERE `$field` = '".$data."' ";
        $res = $this->fetch($sql,1);
        if ($res){
            
            

            $dataencode = array('email'=>$res[0]['email'], 'token'=>$res[0]['email_token']);
            $msg = encode(serialize($dataencode));

            $res[0]['encode'] = $msg;

            
            return $res;
        }

        return false;
    }
    
    /**
     * @todo get data user/person app
     * 
     * @param $data = 
     * @param $field =  field name
     */
    function getUserappData($field,$data,$n_status=0){
        if($data==false) return false;
        $filter = "";
        if ($n_status) $filter = " AND n_status = {$n_status}";

        $sql = "SELECT * FROM `florakb_person` WHERE `$field` = '".$data."' {$filter}";
        $res = $this->fetch($sql,0,1);  
        if(empty($res)){return false;}
        return $res; 
    }

    function updateStatusUser($email=false)
    {

        $sql = array(
                'table'=>'social_member',
                'field'=>"n_status = 1",
                'condition' => "email = '{$email}'",
                );

        $res = $this->lazyQuery($sql,$debug,2);
        if ($res) return true;
        return false;

    }

    function validateEmail($email, $debug=false)
    {

        $sql = array(
                'table'=>'social_member',
                'field'=>"COUNT(email) AS total",
                'condition' => "email = '{$email}'",
                );

        $res = $this->lazyQuery($sql,$debug);
        if ($res[0]['total']>0) return true;
        return false;

    } 

    function emailBlast($data)
    {

        global $basedomain;

        $field = array('email', 'name'); 

        foreach ($data as $key => $value) {
            
            if (in_array($key, $field)){
                $tmpF[] = $key;
                $tmpV[] = "'".$value."'";
            }
        }

        $tmpF[] = "register_date";
        $tmpF[] = "usertype";
        $tmpF[] = "email_token";
        $tmpF[] = "salt";
        $tmpF[] = "password";

        $pass = sha1($this->salt.$data['password']);
        $tmpV[] = "'".$this->date."'";
        $tmpV[] = 2;
        $tmpV[] = "'".$this->token."'";
        $tmpV[] = "'".$this->salt."'";
        $tmpV[] = "'{$pass}'";


        // pr($tmpV);
        $impField = implode(',', $tmpF);
        $impData = implode(',', $tmpV);

        // $sql = "INSERT IGNORE INTO social_member ({$impField}) VALUES ({$impData})";
        $sql = array(
                'table'=>'social_member',
                'field'=>"{$impField}",
                'value' => "{$impData}",
                );

        $res = $this->lazyQuery($sql,$debug,1);

        if ($res){

            $dataencode = array('email'=>$data['email'], 'token'=>$this->token);
            $msg = encode(serialize($dataencode));

            $dataArr['encode'] = $msg;
            $dataArr['email'] = $data['email'];
            $dataArr['name'] = $data['name'];

            
            // logFile($msg);
            // $html = "klik link berikut ini {$basedomain}register/validate/?ref={$msg}";
            // $send = sendGlobalMail($data['email'],false,$html);
            return $dataArr;
        } 

        
        return false;
    }

    function getEmailToken($email=false, $all=false)
    {

        $filter = "";

        if($email==false) return false;
        
        if($all) $filter = " * ";
        else $filter = " email_token ";

        $sql = "SELECT {$filter} FROM social_member WHERE `email` = '".$email."' LIMIT 1";
        // logFile($sql);
        $res = $this->fetch($sql);
        if ($res) return $res;
        return false;
    }

    function updateRegisterStep($data, $debug=false)
    {

        $pass = sha1($this->salt.$data['password']);

        $sql = array(
                'table'=>'social_member',
                'field'=>"register_step = '0', username = '{$data['username']}', n_status = 1, password = '{$pass}', usertype = 2",
                'condition' => "email = '{$data['email']}'",
                );

        $res = $this->lazyQuery($sql,$debug,2);

        if ($res){

            $sql = array(
                'table'=>'social_member',
                'field'=>"*",
                'condition' => "email = '{$data['email']}' LIMIT 1",
                );

            $result = $this->lazyQuery($sql,$debug);
            return $result;
        }
        return false;
    }
}
?>