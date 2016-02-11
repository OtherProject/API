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

    function V2_1_1(){
		return $this->loadView('demo/v2');
    }

    function V2_2(){
		return $this->loadView('demo/v2');
    }

    function V2_2_1(){
		return $this->loadView('demo/v2');
    }

    function V2_3(){
		return $this->loadView('demo/v2');
    }

    function V2_4(){
		return $this->loadView('demo/v2');
    }

    function V2_4_1(){
		return $this->loadView('demo/v2');
    }

    function V2_4_2(){
		return $this->loadView('demo/v2');
    }

    function V3(){
		return $this->loadView('demo/v3');
    }

    function V4(){
		return $this->loadView('demo/v3');
    }
    function V4_1(){
		return $this->loadView('demo/v3');
    }
    function V4_1_1(){
		return $this->loadView('demo/v3');
    }
    function V4_1_2(){
		return $this->loadView('demo/v3');
    }
     function V4_1_3(){
		return $this->loadView('demo/v3');
    }
     function V4_1_4(){
		return $this->loadView('demo/v3');
    }
     function V4_1_5(){
		return $this->loadView('demo/v3');
    }

    function V5(){
		return $this->loadView('demo/v3');
    }
    function V5_1(){
		return $this->loadView('demo/v3');
    }
    function V5_2(){
        return $this->loadView('demo/v3');
    }

    function V6(){
        return $this->loadView('demo/v3');
    }
    function V6_1_1(){
        return $this->loadView('demo/v3');
    }
    function V6_1_2(){
        return $this->loadView('demo/v3');
    }  
    function V6_1_3(){
        return $this->loadView('demo/v3');
    }  
    function V6_1_4(){
        return $this->loadView('demo/v3');
    }
    function V6_1_5(){
        return $this->loadView('demo/v3');
    }
}

?>
