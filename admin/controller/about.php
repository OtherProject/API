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

    public function addafiliasi(){
        $this->view->assign('active','active');

        $id = _g('id');
        if ($id){
        	$data = $this->models->getData(3,3,1,$id);
	        // pr($data);
	        if($data[0]){
	            $data[0]['created_date'] = dateFormat($data[0]['created_date'],'dd-mm-yyyy');
	            $data[0]['posted_date'] = dateFormat($data[0]['posted_date'],'dd-mm-yyyy');
	            $data[0]['expired_date'] = dateFormat($data[0]['expired_date'],'dd-mm-yyyy');
	        }
	        
			$this->view->assign('data',$data[0]);
        }
		

		$this->view->assign('admin',$this->admin['admin']);
        return $this->loadView('about/inputafiliasi');
    }

    public function afiliasi(){

        $this->view->assign('active','active');
		$data = $this->models->getData(3,3);

		// pr($data);
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
		return $this->loadView('about/listafiliasi');
	}
}

?>
