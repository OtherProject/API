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
        $this->mdirectory = $this->loadModel('mdirectory');
        $this->mgallery = $this->loadModel('mgallery');
	}
	
	public function index(){
		
	}
    
    public function listCategory(){
        $this->view->assign('active','active');
		$data = $this->models->get_article(8);
        
        $activity = $this->mdirectory->getActivity(8, 'id, title');
        
		if($data){
            foreach ($data as $key => $val){
                
                $data[$key]['created_date'] = date('d M Y',strtotime($val['created_date']));
    			$data[$key]['posted_date'] = date('d M Y',strtotime($val['posted_date']));
                $data[$key]['expired_date'] = date('d M Y',strtotime($val['expired_date']));

			}
        }
        // pr($data);exit;
        $this->view->assign('listactivity', $activity);
		$this->view->assign('data',$data);
        return $this->loadView('directory/repository/listCategory');
    }
    
    public function repository(){
        $activity = $this->mdirectory->getActivity(8, 'id, title');
        
        $files = $this->mdirectory->get_files(3);
        
        foreach($files as $key => $file){
            
            if($file['n_status'] == '1') {
				$files[$key]['n_status'] = 'Publish';
				$files[$key]['status_color'] = 'green';
			} else {
				$files[$key]['n_status'] = 'Unpublish';
				$files[$key]['status_color'] = 'red'; 
			}
                
            $getType = $this->mdirectory->getActivityFilter('id', $file['otherid']);
            $files[$key]['activity'] = $getType;
        }
        
        $this->view->assign('listactivity', $activity);
        $this->view->assign('data',$files);
        return $this->loadView('directory/repository/repository');
    }
	
	public function addcategory(){
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
        
		return $this->loadView('directory/repository/inputCategory');
	}
	
	public function addfiles(){
        $id = $_GET['id'];
        
        if($id){
            $data = $this->mdirectory->get_files(null, $id);
        }
        
        $activity = $this->mdirectory->getActivity(8, 'id, title');
        
        foreach ($activity as $key => $list){
            $getData = $this->mdirectory->getActivityData(8, $list['title']);
            $activity[$key]['data'] = $getData;
        }
        
        $this->view->assign('listactivity', $activity);
        $this->view->assign('data',$data);
		return $this->loadView('directory/repository/inputFile');
	}
    
    public function inpFile(){

		global $CONFIG;
        
        if(isset($_POST['n_status'])){
			if($_POST['n_status']=='on') $_POST['n_status']=1;
		} else {
			$_POST['n_status']=0;
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
						
						if($x['gallerytype'] == '8'){
							$path_upload = 'repo';
						}else{
							$path_upload = '';
						}
						
                        if($x['action'] == 'update') deleteFile($x['image'],$path_upload);
						$image = uploadFile('file_image',$path_upload);
                        
						$x['image_url'] = $CONFIG['admin']['app_url'].$image['folder_name'].$image['full_name'];
                        $x['title'] = $image['real_name'];
						$x['image'] = $image['full_name'];
						$data = $this->mgallery->gallery_inp($x);
					}
					
		   		}
			   	
		   }catch (Exception $e){}
        
        $redirect = $CONFIG['admin']['base_url'].'home';
        if(isset($x['gallerytype'])){
            if($x['gallerytype']=='8'){
				$redirect = $CONFIG['admin']['base_url'].'direktori/repository';
			}
        }
        
        echo "<script>alert('Data berhasil di simpan');window.location.href='".$redirect."'</script>";
        }
	}
    
    public function imagedel(){

		global $CONFIG;
        $path = 'repo';
        
        foreach($_POST['ids'] as $id){
            $getfile = $this->mdirectory->get_files(null,$id);
            $delImage[] = $getfile['content'];
        }
        
        foreach ($delImage as $image){
            $delete = deleteFile($image,$path);
        }
        
		$data = $this->mdirectory->file_del($_POST['ids']);
		
        $redirect = $CONFIG['admin']['base_url'].'direktori/repository';
        
		echo "<script>alert('Data berhasil dihapus');window.location.href='".$redirect."'</script>";
		
	}
	public function buahpikir(){
		$this->view->assign('active','active');
		$data = $this->models->get_article(6);

		if ($data){
			foreach ($data as $key => $val){

				$data[$key]['created_date'] = dateFormat($val['created_date'],'article');

				$data[$key]['posted_date'] = dateFormat($val['posted_date'],'article');

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

		return $this->loadView('directory/buahPikir/buahpikir');

	}

	public function perundangan(){
		$this->view->assign('active','active');
		$data = $this->models->get_article(7);

		if ($data){
			foreach ($data as $key => $val){

				$data[$key]['created_date'] = dateFormat($val['created_date'],'article');

				$data[$key]['posted_date'] = dateFormat($val['posted_date'],'article');

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

		return $this->loadView('directory/perundangUndang/perundangan');

	}
	public function adddirektori(){
		
		global $CONFIG;

        $redirect = $CONFIG['admin']['base_url'].'home';
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

		if($_GET['page']=="6"){

				return $this->loadView('directory/buahPikir/inputbuahpikir');
		}elseif($_GET['page']=="7"){

				return $this->loadView('directory/perundangUndang/inputperundangan');
		}else{

			echo "<script>alert('Halaman Tidak Ditemukan');window.location.href='".$redirect."'</script>";
	
		}
	}
	public function direktoriinp(){
		global $CONFIG;
		// pr($_POST);exit;
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
                        
                        // pr($x);
                        // exit;
						//upload file
						// pr($_FILES);
						if(!empty($_FILES)){
							if($_FILES['file_image']['name'] != ''){
							
								if($x['categoryid'] == '6'){
									$path_upload = 'buahpikir';
								}else{
									$path_upload = 'perundangan';
								}
							
                                if($x['action'] == 'update') deleteFile($x['image'],$path_upload);
								//if($x['action'] == 'update') deleteFile($x['image']);
								$image = uploadFile('file_image',$path_upload,'image');
								// $uploaddoc = uploadFile('file_pdf',$path_upload, 'doc');
								// pr($image);
								// pr($uploaddoc);
								// exit;
								$x['image_url'] = $CONFIG['admin']['app_url'].$image['folder_name'].$image['full_name'];
								$x['image'] = $image['full_name'];
								// $x['file']= $uploaddoc['full_name'];
								// pr($x);
								// exit;

							}
							if($_FILES['file_pdf']['name'] != ''){
							
								if($x['categoryid'] == '6'){
									$path_upload = 'buahpikir';
								}else{
									$path_upload = 'perundangan';
								}
							
                                if($x['action'] == 'update') deleteFile($x['file'],$path_upload);
								//if($x['action'] == 'update') deleteFile($x['image']);
								// $image = uploadFile('file_image',$path_upload,'image');
								$uploaddoc = uploadFile('file_pdf',$path_upload, 'doc');
								// pr($image);
								// pr($uploaddoc);
								// exit;
								// $x['image_url'] = $CONFIG['admin']['app_url'].$image['folder_name'].$image['full_name'];
								// $x['image'] = $image['full_name'];
								$x['file']= $uploaddoc['full_name'];
								// pr($x);
								// exit;

							}
						}
						$data = $this->mdirectory->directory_inp($x);
			   		}
				   	
			   }catch (Exception $e){}
            
            $redirect = $CONFIG['admin']['base_url'].'home';
            if(isset($x['categoryid'])){
                if($x['categoryid'] == '6'){
                    $redirect = $CONFIG['admin']['base_url'].'direktori/buahpikir';
                }elseif($x['categoryid']=='7'){
                    $redirect = $CONFIG['admin']['base_url'].'direktori/perundangan';
                }
            }
            
            echo "<script>alert('Data berhasil di simpan');window.location.href='".$redirect."'</script>";
            }
	}
	public function direktoridel(){

		global $CONFIG;
		// pr($_POST);exit;
        $post = $_POST;
        
        $action = 'update';
        if($post['action']) $action = $post['action'];
        
        $data = $this->models->article_del($post['ids'], $action);
        
        $redirect = $CONFIG['admin']['base_url'].'home';
        $message  = 'Data dipindahkan ke trash';
        if(isset($post['categoryid'])){
            if($post['categoryid'] == '6'){
                $redirect = $CONFIG['admin']['base_url'].'direktori/buahpikir';
            }elseif($post['categoryid']=='7'){
                $redirect = $CONFIG['admin']['base_url'].'direktori/perundangan';
            }
        }
		echo "<script>alert('".$message."');window.location.href='".$redirect."'</script>";
		
	}
	public function trash(){

		global $CONFIG;

        $redirect = $CONFIG['admin']['base_url'].'home';
        // pr($_GET);
       if(isset($_GET['page'])){
       		if($_GET['page']=="6" || $_GET['page']=="7"){
       			$idget=$_GET['page'];
				$data = $this->models->get_article_trash($idget);
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
				if($_GET['page']=="6"){
					return $this->loadView('directory/buahPikir/viewtrashBP');
				}elseif($_GET['page']=="7"){
					return $this->loadView('directory/perundangUndang/viewtrashPRD');
				}
			}else{
				echo "<script>alert('Halaman Tidak Ditemukan');window.location.href='".$redirect."'</script>";
	
			}

	}else{
		echo "<script>alert('Halaman Tidak Ditemukan');window.location.href='".$redirect."'</script>";
	
	}

	}
	public function direktorirest(){

		global $CONFIG;
		// pr($_POST);exit;
		$data = $this->models->article_restore($_POST['ids']);
        
        $redirect = $CONFIG['admin']['base_url'].'home';
        if(isset($_POST['categoryid'])){
            if($_POST['categoryid'] == '6'){
                $redirect = $CONFIG['admin']['base_url'].'direktori/trash/?page=6';
            }elseif($_POST['categoryid']=='7'){
                $redirect = $CONFIG['admin']['base_url'].'direktori/trash/?page=6';
            }
        }
		
		echo "<script>alert('Data berhasil dikembalikan');window.location.href='".$redirect."'</script>";
		
	}
    
}

?>
