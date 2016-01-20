<?php

class kepakaran extends Controller {
	
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
        $this->modelsKepakaran = $this->loadModel('modelkepakaran');
	}
	
	function index(){
    	//return $this->loadView('gallery/gallery');
    }
    function Dirkepakaran(){
        
        $data = $this->modelsKepakaran->get_category();
        $this->view->assign('data',$data);
        return $this->loadView('direktori/kepakaran');
    }
    
}

?>
