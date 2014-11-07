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
        //$this->models = $this->loadModel('frontend');
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
    	return $this->loadView('user/register_step1');
    }
    
    function register_step2(){
    	return $this->loadView('user/register_step2');
    }
    
    function register_step3(){
    	return $this->loadView('user/register_step3');
    }
    
    function register_step4(){
    	return $this->loadView('user/register_step4');
    }
}

?>
