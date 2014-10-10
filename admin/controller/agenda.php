<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class agenda extends Controller {
	
	var $models = FALSE;
    var $active = 'repository';
	
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
		return $this->loadView('agenda/listAgenda');
	}
    
    public function addagenda(){
        return $this->loadView('agenda/inputagenda');
    }
}

?>
