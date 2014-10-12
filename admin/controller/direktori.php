<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class direktori extends Controller {
	
	var $models = FALSE;
	
	public function __construct()
	{
		parent::__construct();

		global $app_domain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$sessionAdmin = new Session;
		$this->admin = $sessionAdmin->get_session();
		$this->view->assign('app_domain',$app_domain);
	}
	public function loadmodule()
	{
		
	}
	
	public function index(){
		
	}
    
    public function repository(){
        return $this->loadView('directory/repository');
    }
}

?>
