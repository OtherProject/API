<?php

class direktori extends Controller {
	
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
    
    function kepakaran(){
    	//return $this->loadView('gallery/image-view');
    }
    
    function buah_pikir(){
    	return $this->loadView('direktori/buah_pikir');
    }
    
    function perundangan(){
    	return $this->loadView('direktori/perundangan');
    }
    
    function repository(){
    	return $this->loadView('direktori/repository');
    }
}

?>
