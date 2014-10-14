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
		$this->models = $this->loadModel('marticle');
	}
	
	public function index(){
        $this->view->assign('active','active');
		$data = $this->models->get_article(2);

		if ($data){
			foreach ($data as $key => $val){
                
                $data[$key]['created_date'] = date('d M Y H:i',strtotime($val['created_date']));
    			$data[$key]['posted_date'] = date('d M Y H:i',strtotime($val['posted_date']));
                $data[$key]['expired_date'] = date('d M Y H:i',strtotime($val['expired_date']));

				if($val['n_status'] == '1') {
					$data[$key]['n_status'] = 'Publish';
					$data[$key]['status_color'] = 'green';
				} else {
					$data[$key]['n_status'] = 'Unpublish';
					$data[$key]['status_color'] = 'red'; 
				}
			}
		}
		
		// pr($data);exit;
		$this->view->assign('data',$data);
		return $this->loadView('agenda/listAgenda');
	}
    
    public function addagenda(){
        $this->view->assign('active','active');

		if(isset($_GET['id']))
		{
			$data = $this->models->get_article_id($_GET['id']);
            
            $data['created_date'] = date('d-m-Y H:i',strtotime($data['created_date']));
			$data['posted_date'] = date('d-m-Y H:i',strtotime($data['posted_date']));
            $data['expired_date'] = date('d-m-Y H:i',strtotime($data['expired_date']));
            	
			$this->view->assign('data',$data);
		} 

		$this->view->assign('admin',$this->admin['admin']);
        
        return $this->loadView('agenda/inputagenda');
    }
    
    public function trash(){
       
		$data = $this->models->get_article_trash(2);
		if ($data){
			foreach ($data as $key => $val){
                
                $data[$key]['created_date'] = date('d M Y H:i',strtotime($val['created_date']));
    			$data[$key]['posted_date'] = date('d M Y H:i',strtotime($val['posted_date']));
                $data[$key]['expired_date'] = date('d M Y H:i',strtotime($val['expired_date']));

				if($val['n_status'] == '2') {
					$data[$key]['n_status'] = 'Deleted';
					$data[$key]['status_color'] = 'red';
				} 
			}
		}

		$this->view->assign('active','active');
		$this->view->assign('data',$data);

		return $this->loadView('agenda/viewtrash');

	}
}

?>
