<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class video extends Controller {
	
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
		
		$this->models = $this->loadModel('mvideo');
	}
	
	public function index(){
		$this->view->assign('active','active');

		$data = $this->models->get_video();
        //pr($data);exit;

		if ($data){
			foreach ($data as $key => $val){

				$data[$key]['created_date'] = dateFormat($val['created_date'],'article');

				$data[$key]['posted_date'] = dateFormat($val['posted_date'],'article');
                $data[$key]['content_en'] = html_entity_decode($val['content_en'], ENT_QUOTES, 'UTF-8');

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

		return $this->loadView('video/video');
	}
    
    public function videoadd(){		
		$this->view->assign('active','active');
	

		if(isset($_GET['id']))
		{

			$data = $this->models->get_video_id($_GET['id']);
            
            if($data){
                $data['created_date'] = dateFormat($data['created_date'],'dd-mm-yyyy');
                $data['posted_date'] = dateFormat($data['posted_date'],'dd-mm-yyyy');
            }
            
			$this->view->assign('data',$data);
		} 
		
	
        $this->view->assign('admin',$this->admin['admin']);
		return $this->loadView('video/addvideo');
	}
	
	
	public function videoinp(){
		global $CONFIG;
        
        $redirect = $CONFIG['admin']['base_url'].'video';
        
        if(intval($_SERVER['CONTENT_LENGTH'])>0 && count($_POST)===0){
            $message = 'Upload file failed. Max size is '.ini_get('post_max_size');
            echo "<script>alert('".$message."');window.location.href='".$redirect."'</script>";
        }else{
        
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
							if($_FILES['file_video']['name'] != ''){
                                
                                $path = 'video';
                                
								if($x['action'] == 'update') deleteFile($x['video_name'],$path);
                                
								$image = uploadFile('file_video',$path, 'video_ext');
                                
								$x['video_url'] = $CONFIG['admin']['app_url'].$image['folder_name'].$image['full_name'];
								$x['video_name'] = $image['full_name'];
                                
							}
						}
                        
                        
						$data = $this->models->video_inp($x);
                        
			   		}
				   	
			   }catch (Exception $e){}
            
                $message = 'Save data succeed';            
                
                echo "<script>alert('".$message."');window.location.href='".$redirect."'</script>";
            }
        }
	}
    
    public function videodel(){

		global $CONFIG;
        $path = 'video';
        
        foreach($_POST['ids'] as $id){
            $getfile = $this->models->get_video_id($id);
            $delImage[] = $getfile['image'];
        }
        
        foreach ($delImage as $image){
            deleteFile($image,$path);
        }              
        
		$data = $this->models->video_del($_POST['ids']);
		
        $redirect = $CONFIG['admin']['base_url'].'video';
        $message = 'Data has been deleted';
        
		echo "<script>alert('".$message."');window.location.href='".$redirect."'</script>";
		
	}
}

?>
