<?php

class user extends Controller {
	
	var $models = FALSE;
	var $view;
    var $user;
	
	function __construct()
	{
		global $basedomain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$this->view->assign('basedomain',$basedomain);
        $this->loadSession = new Session;
        $getUserLogin = $this->isUserOnline();
        $this->user = $getUserLogin['default'];
        // pr($this->user);
    }
	
	function loadmodule()
	{
        $this->contentHelper = $this->loadModel('contentHelper');
        $this->loginHelper = $this->loadModel('loginHelper');
        $this->userHelper = $this->loadModel('userHelper');
	}
	
	function index(){
    	//return $this->loadView('gallery/gallery');
    }
    
    function local()
    {
        
        if (isset($_POST['token'])){

            $validateData = $this->loginHelper->local($_POST);
            if ($validateData){
                // $_SESSION['user'] = $validateData;
                $setSession = $this->loadSession->set_session($validateData);
                print json_encode(array('status'=>true));
            }else{
                print json_encode(array('status'=>false));
            }

        }

        exit;
    }

    function login(){

        global $basedomain;

        

    	return $this->loadView('user/login');
    }
    
    function register(){
    	return $this->loadView('user/register');
    }
    
    function register_step1(){
        global $basedomain;
        if ($_POST){
            // pr($_POST);

            $save = $this->contentHelper->createAccount($_POST);
            if ($save){
                
                redirect($basedomain.'user/register_step2');
            }
        }
    	return $this->loadView('user/register_step1');
    }
    
    function register_step2(){
        global $basedomain;

        
        $isUserSet = $_SESSION['newuser']['email'];
        if ($isUserSet=="") {redirect($basedomain.'user/register_step1');exit;}

        $getNomenklatur = $this->contentHelper->getNomenklatur();
        // pr($getNomenklatur);
        if ($_POST){
            // pr($_POST);

            $save = $this->contentHelper->updateBiodata($_POST);
            if ($save){
                
                redirect($basedomain.'user/register_step3');
            }else{
                redirect($basedomain.'user/register_step2');exit;
            }
        }

        $this->view->assign('rumpun',$getNomenklatur);
    	return $this->loadView('user/register_step2');
    }
    
    function register_step3(){

        global $basedomain;

        $isUserSet = $_SESSION['newuser']['email'];
        if ($isUserSet=="") {redirect($basedomain.'user/register_step1');exit;}


        if ($_POST){
            // pr($_POST);

            $save = $this->contentHelper->updateRiwayat($_POST);
            // pr($save);
            if ($save){
                $keberhasilan = $this->contentHelper->updateKeberhasilan($_POST);
                if ($keberhasilan){
                    redirect($basedomain.'user/register_step4');
                }else{
                    redirect($basedomain.'user/register_step3');exit;
                } 
            }else{
                redirect($basedomain.'user/register_step3');exit;
            }
        }

    	return $this->loadView('user/register_step3');
    }
    
    function register_step4(){

        
        global $basedomain;
        $isUserSet = $_SESSION['newuser']['email'];
        if ($isUserSet=="") {redirect($basedomain.'user/register_step1');exit;}

        if ($_POST){
            // pr($_POST);

            if(!empty($_FILES)){
                if($_FILES['file_image']['name'] != ''){
                    
                    $image = uploadFile('file_image',null,'image');
                    $x['image'] = $image['full_name'];

                    if ($image){
                        $save = $this->contentHelper->updatePersetujuan($image);
                        if ($save){
                            
                            $insertData = $this->userHelper->getUserData('email',$isUserSet);
                            // pr($insertData);
                            if ($insertData[0]['usertype']!=2){
                                // echo 'ada';
                                $this->view->assign('email', $insertData[0]['email']);
                                $this->view->assign('name', $insertData[0]['name']);
                                $this->view->assign('encode', $insertData[0]['encode']);
                                
                                $html = $this->loadView('user/emailTemplate');

                                logFile($msg);
                                // $html = "klik link berikut ini {$basedomain}register/validate/?ref={$msg}";
                                $send = sendGlobalMail($insertData[0]['email'],false,$html);
                            }
                            
                            // exit;
                            redirect($basedomain.'user/register_step5');
                        }
                    }else{
                        redirect($basedomain.'user/register_step4');exit;
                    }

                }

                
                
            }else{
                redirect($basedomain.'user/register_step4');exit;
            }

            exit;
            
        }
    	return $this->loadView('user/register_step4');
    }

    function register_step5(){

        global $basedomain;

        $isUserSet = $_SESSION['newuser']['email'];
        $insertData = $this->userHelper->getUserData('email',$isUserSet);
        
        if ($insertData[0]['usertype']==1){
            $this->view->assign('usertype', 1);
        }else{
            $this->view->assign('usertype', 2);
        }
        
        if ($isUserSet=="") {redirect($basedomain.'user/register_step1');exit;}

        return $this->loadView('user/register_step5');
    }

    function ajax()
    {
        $email = _p('email');

        $validate = $this->userHelper->validateEmail($email);
        if ($validate){

            print json_encode(array('status'=>true));
        }else{
            print json_encode(array('status'=>false));
        }

        exit;
    }

    function setting(){

        global $basedomain;

        $email = $this->user['email'];

        
        if (isset($_POST['submitakun'])){
            $save = $this->userHelper->updateAkun($_POST);
            if ($save){
                echo "<script>alert('Password berhasil diubah')</script>";
                redirect($basedomain.'user/setting');
            }
        }

        if (isset($_POST['submitbiodata'])){
            $save = $this->contentHelper->updateBiodata($_POST, true);
        }

        if (isset($_POST['submitriwayat'])){
            $save = $this->contentHelper->updateRiwayat($_POST, true);
            if ($save) $keberhasilan = $this->contentHelper->updateKeberhasilan($_POST, true);
        }

        if (isset($_POST['submitpersetujuan'])){
            if(!empty($_FILES)){
                if($_FILES['file_image']['name'] != ''){
                    
                    $image = uploadFile('file_image',null,'image');
                    $x['image'] = $image['full_name'];

                    $image['userID'] = $_POST['userID'];
                    if ($image){
                        $save = $this->contentHelper->updatePersetujuan($image, true);
                    }
                }
            }
        }
        

        $getUserData = $this->userHelper->getUserData('email',$email);
        if ($getUserData){
            // pr($getUserData);
            $this->view->assign('user', $getUserData[0]);
        }
        return $this->loadView('user/setting');
    }

    function emailblast()
    {
        if (isset($_POST['submit'])){

            $insertData = $this->userHelper->emailBlast($_POST);
            
            $this->view->assign('email', $insertData['email']);
            $this->view->assign('name', $insertData['name']);
            $this->view->assign('encode', $insertData['encode']);
            
            $html = $this->loadView('user/emailTemplate');

            logFile($msg);
            // $html = "klik link berikut ini {$basedomain}register/validate/?ref={$msg}";
            $send = sendGlobalMail($insertData['email'],false,$html);
            
        }
        return $this->loadView('user/emailblast');
    }

    function validate()
    {

        $data = _g('ref');
        
        // exit;
        logFile($data);
        if ($data){

            $decode = unserialize(decode($data));
            // pr($decode);
            // check if token is valid
           
            $salt = "register";
            $userMail = $decode['email'];
            $origToken = sha1($salt.$userMail);

            // pr($decode);
            $getToken = $this->userHelper->getEmailToken($decode['email'], true);

            if ($getToken['usertype']==1){
                $this->view->assign('userType',1);
            }else{
                $this->view->assign('userType',2);
            }

            // db($getToken);
            if ($getToken['email_token']==$decode['token']){

                $updateStatusUser = $this->userHelper->updateStatusUser($decode['email']);

                // is valid, then create account and set status to validate
                $this->view->assign('validate','Validate account Success');
                $this->view->assign('status',true);
                $this->view->assign('email',$userMail);

            }else{

                // invalid token
                $this->view->assign('validate','Validate account error');
                $this->view->assign('status',false);
                logFile('token mismatch');
            }

            

        }
        

        return $this->loadView('user/activate-account');
        
    }

    function activate()
    {
        global $basedomain;
        if (isset($_POST['token'])){

            
            $updateUser = $this->userHelper->updateRegisterStep($_POST);
            if ($updateUser){
                $_SESSION['newuser']['email'] = $updateUser[0]['email'];
                $_SESSION['newuser']['id'] = $updateUser[0]['id'];

                redirect($basedomain.'user/register_step2');exit;
            }
            /*
            if ($updateUser){
                $newData = array();
                foreach ($updateUser[0] as $key => $value) {
                    $newData[$key] = $value;
                }
                // pr($newData);
                // exit;
                // $setSession = $this->loadSession->set_session($newData);
                $_SESSION['newuser']['email'] = $data['email'];
                $_SESSION['newuser']['id'] = $this->insert_id();
            }
            redirect($basedomain);
            
            */

        }
        
        redirect($basedomain);
    }
}

?>
