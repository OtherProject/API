<?php

class anggota extends Controller {
	
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
        $this->modelsMember = $this->loadModel('modelmember');
	}
	
	/**function index(){
    	return $this->loadView('profile');
    }**/
    
    
    
    function anggota(){

        $data = $this->modelsMember->get_member();
        pr($data);
        $this->view->assign('data',$data);

        return $this->loadView('organisasi/anggota');
    }
    
    function anggota_view(){
        return $this->loadView('organisasi/anggota-view');
    }
    
}

?>
