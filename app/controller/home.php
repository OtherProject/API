<?php

class home extends Controller {
	
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
		
		//$berita = $this->contentHelper->getNews($id=false,$cat=1);
		$berita = $this->contentHelper->getNews($id=false,$cat=1,$type=1, 0, 3);
    	$this->view->assign('berita',$berita);

    	return $this->loadView('home');
    }
}

?>
