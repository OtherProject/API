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
            if ($save){
                
                redirect($basedomain.'user/register_step4');
            }
        }

    	return $this->loadView('user/register_step3');
    }
    
    function register_step4(){

        
        global $basedomain;
        if ($_POST){
            // pr($_POST);

            $save = $this->contentHelper->updateKeberhasilan($_POST);
            if ($save){
                
                redirect($basedomain);
            }
        }
    	return $this->loadView('user/register_step4');
    }
}

?>
