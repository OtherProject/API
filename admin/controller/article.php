<?php
// defined ('MICRODATA') or exit ( 'Forbidden Access' );

class article extends Controller {
	
	var $models = FALSE;
	
	public function __construct()
	{
		parent::__construct();
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$sessionAdmin = new Session;
		$this->admin = $sessionAdmin->get_session();
		// $this->validatePage();
	}
	public function loadmodule()
	{
		
		$this->models = $this->loadModel('marticle');
	}
	
	public function index(){
       
		

	}
	
	public function addarticle(){
		
		$this->view->assign('active','active');

		if(isset($_GET['id']))
		{
			$data = $this->models->get_article_id($_GET['id']);
            
            if($data){
                $data['created_date'] = dateFormat($data['created_date'],'dd-mm-yyyy');
                $data['posted_date'] = dateFormat($data['posted_date'],'dd-mm-yyyy');
                $data['expired_date'] = dateFormat($data['expired_date'],'dd-mm-yyyy');
            }
            
			$this->view->assign('data',$data);
		} 

		$this->view->assign('admin',$this->admin['admin']);
		return $this->loadView('article/inputarticle');
	}
    
	public function articleinp(){
		global $CONFIG;
		
		if(isset($_POST['n_status'])){
			if($_POST['n_status']=='on') $_POST['n_status']=1;
		} else {
			$_POST['n_status']=0;
		}
        
		if(isset($_POST['articletype'])){
			if($_POST['articletype']=='on') {
				if($_POST['articleid_old']!=0){
					$_POST['articletype'] = $_POST['articleid_old'];
				} else {
					$_POST['articletype']=1; 
				}
			}
		} else {
			$_POST['articletype']=0;
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
                        
                        //pr($x);exit;
						//upload file
						if(!empty($_FILES)){
							if($_FILES['file_image']['name'] != ''){
							
								if($x['categoryid'] == '9'){
									$path_upload = 'gallery/images';
								}else{
									$path_upload = 'news';
								}
							
                                if($x['action'] == 'update') deleteFile($x['image'],$path_upload);
								//if($x['action'] == 'update') deleteFile($x['image']);
								$image = uploadFile('file_image',$path_upload,'image');
								
								$x['image_url'] = $CONFIG['admin']['app_url'].$image['folder_name'].$image['full_name'];
								$x['image'] = $image['full_name'];
							}
						}
						$data = $this->models->article_inp($x);
			   		}
				   	
			   }catch (Exception $e){}
            
            $redirect = $CONFIG['admin']['base_url'].'home';
            if(isset($x['categoryid'])){
                if($x['categoryid'] == '1'){
                    $redirect = $CONFIG['admin']['base_url'].'home';
                }elseif($x['categoryid']=='2'){
                    $redirect = $CONFIG['admin']['base_url'].'agenda';
                }elseif($x['categoryid']=='3'){
                    if($x['articletype']=='1'){
                        $redirect = $CONFIG['admin']['base_url'].'about/profile';
                    }elseif($x['articletype']=='2'){
                        $redirect = $CONFIG['admin']['base_url'].'about/struktur';
                    }
                }elseif($x['categoryid']=='9'){
					if($x['articletype']=='1'){
                        $redirect = $CONFIG['admin']['base_url'].'gallery';
                    }elseif($x['articletype']=='2'){
                        $redirect = $CONFIG['admin']['base_url'].'gallery';
                    }
				}elseif($x['categoryid']=='8'){
					$redirect = $CONFIG['admin']['base_url'].'direktori/listCategory';
				}
            }
            
            echo "<script>alert('Data berhasil di simpan');window.location.href='".$redirect."'</script>";
            }
	}
	
	public function articledel(){

		global $CONFIG;
		// pr($_POST);exit;
        $post = $_POST;
        
        $action = 'delete';
        if($post['action']) $action = $post['action'];
        
        $data = $this->models->article_del($post['ids'], $action);
        
        $redirect = $CONFIG['admin']['base_url'].'home';
        $message  = 'Data dipindahkan ke trash';
        if(isset($post['categoryid'])){
            if($post['categoryid'] == '1'){
                $redirect = $CONFIG['admin']['base_url'].'home';
            }elseif($post['categoryid']=='2'){
                $redirect = $CONFIG['admin']['base_url'].'agenda';
            }elseif($post['categoryid']=='9'){
				$redirect = $CONFIG['admin']['base_url'].'gallery';
                $message  = 'Data berhasil dihapus';
			}elseif($post['categoryid']=='8'){
				$redirect = $CONFIG['admin']['base_url'].'direktori/listCategory';
                $message  = 'Data berhasil dihapus';
			}
        }
		echo "<script>alert('".$message."');window.location.href='".$redirect."'</script>";
		
	}
	
	public function trash(){
       
		$data = $this->models->get_article_trash(1);
		if ($data){
			foreach ($data as $key => $val){
				$data[$key]['created_date'] = dateFormat($val['created_date'],'article');

				$data[$key]['posted_date'] = dateFormat($val['posted_date'],'article');

				if($val['n_status'] == '2') {
					$data[$key]['n_status'] = 'Deleted';
					$data[$key]['status_color'] = 'red';
				} 
			}
		}

		$this->view->assign('active','active');
		$this->view->assign('data',$data);

		return $this->loadView('article/viewtrash');

	}
	
	
	public function articlerest(){

		global $CONFIG;
		
		$data = $this->models->article_restore($_POST['ids']);
        
        $redirect = $CONFIG['admin']['base_url'].'home';
        if(isset($_POST['categoryid'])){
            if($_POST['categoryid'] == '1'){
                $redirect = $CONFIG['admin']['base_url'].'article';
            }elseif($_POST['categoryid']=='2'){
                $redirect = $CONFIG['admin']['base_url'].'agenda';
            }
        }
		
		echo "<script>alert('Data berhasil dikembalikan');window.location.href='".$redirect."/trash'</script>";
		
	}
	
	public function articledelp(){

		global $CONFIG;
		
		$id = $_GET['id'];

		$data = $this->models->article_delpermanent($id);
		
		echo "<script>alert('Data berhasil di hapus secara permanen');window.location.href='".$CONFIG['admin']['base_url']."article/trash'</script>";
		
	}

	public function upload(){

		return $this->loadView('article/uploadFrame');

	}

	public function uploadtwt(){

		return $this->loadView('article/uploadFrameTwt');

	}

	public function uplFrame(){
		global $CONFIG;

		//upload file
		if(!empty($_FILES)){
			if($_FILES['file_frame']['name'] != ''){
				$image = uploadFile('file_frame','frame','image');

				$data[0]['title'] = $_POST['title'];
				$data[0]['typealbum'] = $_POST['typealbum'];
				$data[0]['gallerytype'] = 1;
				$data[0]['content'] = $image['full_name'];
				$data[0]['files'] = $image['full_name'];
				$data[0]['created_date'] = date("Y-m-d H:i:s");
				$data[0]['n_status'] = 1;

			} else {
				echo "<script>alert('You have to choose frame file');window.location.href='".$CONFIG['admin']['base_url']."article/upload'</script>";
			}

			if($_FILES['file_cover']['name'] != ''){
				$image = uploadFile('file_cover','cover','image');

				$data[1]['title'] = $_POST['title'];
				$data[1]['typealbum'] = $_POST['typealbum'];
				$data[1]['gallerytype'] = 2;
				$data[1]['content'] = $image['full_name'];
				$data[1]['files'] = $image['full_name'];
				$data[1]['created_date'] = date("Y-m-d H:i:s");
				$data[1]['n_status'] = 1;

			} else {
				echo "<script>alert('You have to choose cover file');window.location.href='".$CONFIG['admin']['base_url']."article/upload'</script>";
			}

				$data = $this->models->frame_inp($data);

				echo "<script>alert('Files has been uploaded');window.location.href='".$CONFIG['admin']['base_url']."home/frame'</script>";
		} else {

			echo "<script>alert('No file has been selected');window.location.href='".$CONFIG['admin']['base_url']."article/upload'</script>";

		}
	}

}

?>
