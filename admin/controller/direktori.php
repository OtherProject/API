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
		$this->models = $this->loadModel('marticle');
	}
	
	public function index(){
		
	}
    
    public function listCategory(){
        $this->view->assign('active','active');
		$data = $this->models->get_article(8);
		
		// pr($data);exit;
		$this->view->assign('data',$data);
        return $this->loadView('directory/repository/listCategory');
    }
    
    public function repository(){
        return $this->loadView('directory/repository/repository');
    }
	
	public function addcategory(){
		return $this->loadView('directory/repository/inputCategory');
	}
	
	public function addfiles(){
		return $this->loadView('directory/repository/inputFile');
	}
}

?>
