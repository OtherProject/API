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
    	$start = $_GET['tgl'];
    	if($start){
	    	$addOneDay = strtotime($start.'+ 1 day');
			$end = date('Y-m-d',$addOneDay);
    		$agenda = $this->contentHelper->getAgenda(false,$cat=2, $type=0,$start,$end);
    	}
    	else{
    		$start = date('Y-m-01'); // hard-coded '01' for first day
			$end  = date('Y-m-t');

    		$agenda = $this->contentHelper->getAgenda(false,$cat=2, $type=0,$start,$end);
    	}
    	
    	//pr($agenda);
	 	$this->view->assign('agenda',$agenda);
    	return $this->loadView('news/agenda');
    }
	
	function kliping_kegiatan(){
		$kliping = $this->contentHelper->getNews($id=false,$cat=1,$type=2);
	 	$this->view->assign('kliping',$kliping);
    	return $this->loadView('news/kliping_kegiatan');
    }
    
    function berita(){
    	$berita = $this->contentHelper->getNews($id=false,$cat=1);
    	$this->view->assign('berita',$berita);
    	return $this->loadView('news/berita');
    }
    
    function berita_detail(){
    	$id = _g('id');
    	$berita = $this->contentHelper->getNews($id,$cat=1);
    	$this->view->assign('berita',$berita);
    	return $this->loadView('news/berita_detail');
    }

    function kliping_detail(){

		$id = _g('id');
		$kliping = $this->contentHelper->getNews($id,$cat=1,$type=2);
		$this->view->assign('berita',$kliping);
		return $this->loadView('news/berita_detail');
	}
}

?>
