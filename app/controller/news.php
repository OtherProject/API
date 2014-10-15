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
        $this->contentHelper = $this->loadModel('contentHelper');
	}
    
    function agenda(){
    	return $this->loadView('news/agenda');
    }
	
	function kliping_kegiatan(){

		$kliping =  $this->contentHelper->getNews($id=false,$cat=1,$type=2);
        
        $this->view->assign('kliping',$kliping);
    	return $this->loadView('news/kliping_kegiatan');
    }
    
    function berita(){
    	$berita =  $this->contentHelper->getNews($id=false,$cat=1);
        
        $this->view->assign('berita',$berita);
    	return $this->loadView('news/berita');
    }
    
    function berita_detail(){

    	$id = _g('id');
    	$berita =  $this->contentHelper->getNews($id,$cat=1);
        // pr($berita);
        $this->view->assign('berita',$berita);
    	return $this->loadView('news/berita_detail');
    }

    function kliping_detail(){

    	$id = _g('id');
		$kliping =  $this->contentHelper->getNews($id,$cat=1,$type=2);
        
        $this->view->assign('berita',$kliping);
    	return $this->loadView('news/berita_detail');
    }
}

?>
