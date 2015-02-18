<?php
// defined ('MICRODATA') or exit ( 'Forbidden Access' );

class headlines extends Controller {
	
	var $models = FALSE;
	
	public function __construct()
	{
		parent::__construct();
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$sessionAdmin = new Session;
		$this->admin = $sessionAdmin->get_session();
	}
	public function loadmodule()
	{
		
		$this->models = $this->loadModel('mheadlines');
	
	}
	public function index(){
        global $CONFIG;
        $check = $this->models->getheadline();
        
        if($check){
            redirect($CONFIG['admin']['base_url']."headlines/content/?id=".$check['id']);
        }
        return $this->loadView('headlines/headlineinp');
	}
	
	public function content(){
	$menuId = $_GET['menuid'];
    $id = $_GET['id'];
    		
		$this->view->assign('active','active');

		if($id)
		{
		//ini utk edit
			$data = $this->models->get_headlines_id($id);
            
            if($data){
                //$data['dateCreate'] = dateFormat($data['dateCreate'],'dd-mm-yyyy');
                $data['posted_date'] = dateFormat($data['posted_date'],'dd-mm-yyyy');
                //$data['expired_date'] = dateFormat($data['expired_date'],'dd-mm-yyyy');
            }
            
			$this->view->assign('data',$data);
		} 
		
	
      	$this->view->assign('admin',$this->admin['admin']);
      	$this->view->assign('menuid',$menuId);
		return $this->loadView('headlines/headlineinp');
	}
	
	
	public function headlineinp(){
		global $CONFIG;
        $menuId = $_POST['menuId'];
		
		if(isset($_POST['n_stats'])){
			if($_POST['n_stats']=='on') $_POST['n_stats']=1;
		} else {
			$_POST['n_stats']=0;
		}
 		
		if(isset($_POST)){
                // validasi value yang masuk
               $x = form_validation($_POST);
			   try
			   {
			   		if(isset($x) && count($x) != 0)
			   		{
						//update or insert
						$x['action'] = 'insert';
						if($x['id'] != ''){
							$x['action'] = 'update';
						}
                        
						//upload file
						if(!empty($_FILES)){
							if($_FILES['file_image']['name'] != ''){
                                $delete = deleteFile($x['image'],'news');
								if($x['action'] == 'update') deleteFile($x['image']);
								$image = uploadFile('file_image','news','image');
								
								$x['image_url'] = $CONFIG['admin']['app_url'].$image['folder_name'].$image['full_name'];
								$x['image'] = $image['full_name'];
							}
						}
						$data = $this->models->headlines_inp($x);
			   		}
				   	
			   }catch (Exception $e){}
            
            $redirect = $CONFIG['admin']['base_url'].'headlines';
            $message = 'Save data succeed';
            
            echo "<script>alert('".$message."');window.location.href='".$redirect."'</script>";
            }
	}

}

?>
