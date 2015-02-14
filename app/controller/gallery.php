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
        $this->models = $this->loadModel('modelgallery');
	}
	
	function foto(){
		$data = $this->models->get_article(9);
		$this->view->assign('data',$data);
    	return $this->loadView('gallery/foto');
    }
    
    function view_foto(){
    	$albumId=$_GET['album'];

		$data = $this->models->get_images($albumId);
		$data_album = $this->models->get_article_id($albumId);
		$this->view->assign('data',$data);
		$this->view->assign('data_album',$data_album);
    	return $this->loadView('gallery/image-view');
    }

    function video(){
		return $this->loadView('gallery/video');
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
