<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class banner extends Controller {
	
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
		
		$this->models = $this->loadModel('mbanner');
	}
	
	public function index(){
		$this->view->assign('active','active');

		$data = $this->models->get_banner();
        //pr($data);exit;

		if ($data){
			foreach ($data as $key => $val){

				$data[$key]['created_date'] = dateFormat($val['created_date'],'article');

				$data[$key]['posted_date'] = dateFormat($val['posted_date'],'article');

				if($val['n_stats'] == '1') {
					$data[$key]['n_stats'] = 'Publish';
					$data[$key]['status_color'] = 'green';
				} else {
					$data[$key]['n_stats'] = 'Unpublish';
					$data[$key]['status_color'] = 'red'; 
				}
			}
		}
		
		// pr($data);exit;
		$this->view->assign('data',$data);

		return $this->loadView('banner/banner');
	}
    
    public function banneradd(){		
		$this->view->assign('active','active');
	

		if(isset($_GET['id']))
		{

			$data = $this->models->get_banner_id($_GET['id']);
            
            if($data){
                $data['created_date'] = dateFormat($data['created_date'],'dd-mm-yyyy');
                $data['posted_date'] = dateFormat($data['posted_date'],'dd-mm-yyyy');
            }
            
			$this->view->assign('data',$data);
		} 
		
	
        $this->view->assign('admin',$this->admin['admin']);
		return $this->loadView('banner/addbanner');
	}
	
	
	public function bannerinp(){
		global $CONFIG;
		
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
                                
                                $path = 'banner';
                                
								if($x['action'] == 'update') deleteFile($x['image'],$path.'/image');
                                if($x['action'] == 'update') deleteFile($x['icon'],$path.'/icon');
                                
								$image = uploadFile('file_image',$path,'image');
                                
								$x['image_url'] = $CONFIG['admin']['app_url'].$image['folder_name'].$image['full_name'];
								$x['image'] = $image['full_name'];
                                
							}
						}
						$data = $this->models->banner_inp($x);
			   		}
				   	
			   }catch (Exception $e){}
            
            $redirect = $CONFIG['admin']['base_url'].'banner';
            $message = 'Save data succeed';
            
            echo "<script>alert('".$message."');window.location.href='".$redirect."'</script>";
            }
	}
    
    public function bannerdel(){

		global $CONFIG;
        $path = 'banner';
        
        foreach($_POST['ids'] as $id){
            $getfile = $this->models->get_banner_id($id);
            $delImage[] = $getfile['image'];
        }
        
        foreach ($delImage as $image){
            deleteFile($image,$path);
        }              
        
		$data = $this->models->banner_del($_POST['ids']);
		
        $redirect = $CONFIG['admin']['base_url'].'banner';
        $message = 'Data has been deleted';
        
		echo "<script>alert('".$message."');window.location.href='".$redirect."'</script>";
		
	}
}

?>
