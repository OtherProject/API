<?php

class demo extends Controller {
	
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
        //$this->contentHelper = $this->loadModel('contentHelper');
	}
	
	function V2(){
		return $this->loadView('demo/v2');
    }

    function V2_1(){
		return $this->loadView('demo/v2');
    }
}

?>
