<?php

class news extends Controller {
	
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
    
    function agenda(){
    	return $this->loadView('news/agenda');
    }
	
	function kliping_kegiatan(){
    	return $this->loadView('news/kliping_kegiatan');
    }
    
    function berita(){
    	return $this->loadView('news/berita');
    }
    
    function berita_detail(){
    	return $this->loadView('news/berita_detail');
    }
}

?>
