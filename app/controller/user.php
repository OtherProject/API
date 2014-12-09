<?php

class user extends Controller {
	
	var $models = FALSE;
	var $view;

	
	function __construct()
	{
		global $basedomain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$this->view->assign('basedomain',$basedomain);
    }
	
	function loadmodule()
	{
        $this->contentHelper = $this->loadModel('contentHelper');
	}
	
	function index(){
    	//return $this->loadView('gallery/gallery');
    }
    
    function login(){
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

        // pr($_SESSION);
        if ($_POST){
            // pr($_POST);

            $save = $this->contentHelper->updateBiodata($_POST);
            if ($save){
                
                redirect($basedomain.'user/register_step3');
            }
        }
    	return $this->loadView('user/register_step2');
    }
    
    function register_step3(){

        global $basedomain;
        if ($_POST){
            // pr($_POST);

            $save = $this->contentHelper->updateRiwayat($_POST);
            // pr($save);
            if ($save){
                $keberhasilan = $this->contentHelper->updateKeberhasilan($_POST);
                if ($keberhasilan) redirect($basedomain.'user/register_step4');
            }
        }

    	return $this->loadView('user/register_step3');
    }
    
    function register_step4(){

        
        global $basedomain;
        pr($_POST);
        if ($_POST){
            pr($_POST);

            if(!empty($_FILES)){
                if($_FILES['file_image']['name'] != ''){
                    if($x['action'] == 'update') deleteFile($x['image']);
                    $image = uploadFile('file_image',null,'image');
                    $x['image'] = $image['full_name'];
                }

                if ($image){
                    $save = $this->contentHelper->updatePersetujuan($image);
                    if ($save){
                        
                        redirect($basedomain);
                    }
                }
                
            }

            exit;
            
        }
    	return $this->loadView('user/register_step4');
    }
}

?>
