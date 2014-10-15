<?php

class gallery extends Controller {
	
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
    	return $this->loadView('gallery/gallery');
    }
    
    function view(){
    	return $this->loadView('gallery/image-view');
    }
    
    /* TEMP DATA */
    function view_ACIKITA(){
    	return $this->loadView('gallery/image-view-acikita');
    }
    
    function view_RAKORLOK(){
    	return $this->loadView('gallery/image-view-rakorlok');
    }
}

?>
