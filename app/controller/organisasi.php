<?php

class organisasi extends Controller {
	
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
	
	/**function index(){
    	return $this->loadView('profile');
    }**/
    
    function profile(){
        return $this->loadView('organisasi/profile');
    }
    
    function struktur_organisasi(){
        return $this->loadView('organisasi/struktur_organisasi');
    }
    
    function anggota(){
        return $this->loadView('organisasi/anggota');
    }
    
    function anggota_view(){
        return $this->loadView('organisasi/anggota-view');
    }
    
    function afiliasi(){
        return $this->loadView('organisasi/afiliasi');
    }
}

?>
