<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class about extends Controller {
	
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
    
    public function profile(){
        $this->view->assign('active','active');

		$data = $this->models->get_article_filter(3,1);
            
        if($data){
            $data['created_date'] = dateFormat($data['created_date'],'dd-mm-yyyy');
            $data['posted_date'] = dateFormat($data['posted_date'],'dd-mm-yyyy');
            $data['expired_date'] = dateFormat($data['expired_date'],'dd-mm-yyyy');
        }
        
		$this->view->assign('data',$data);

		$this->view->assign('admin',$this->admin['admin']);
        return $this->loadView('about/inputprofile');
    }
    
    public function struktur(){
        $this->view->assign('active','active');

		$data = $this->models->get_article_filter(3,2);
            
        if($data){
            $data['created_date'] = dateFormat($data['created_date'],'dd-mm-yyyy');
            $data['posted_date'] = dateFormat($data['posted_date'],'dd-mm-yyyy');
            $data['expired_date'] = dateFormat($data['expired_date'],'dd-mm-yyyy');
        }
        
		$this->view->assign('data',$data);

		$this->view->assign('admin',$this->admin['admin']);
        return $this->loadView('about/inputstruktur');
    }
}

?>
