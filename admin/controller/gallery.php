<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class gallery extends Controller {
	
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
		$this->gallery = $this->loadModel('mgallery');
	}
	
	public function index(){
		$this->view->assign('active','active');
		$data = $this->models->get_article(9);
		//pr($data);exit;
		$this->view->assign('data',$data);
		return $this->loadView('gallery/album');
	}
	
	public function add(){
		return $this->loadView('gallery/inputAlbum');
	}
	
	public function album(){
		$albumId = $_GET['album'];
		$data = $this->gallery->get_images($albumId);
		
		$this->view->assign('data',$data);
		$this->view->assign('albumId',$albumId);
		return $this->loadView('gallery/images');
	}
	
	public function gallerydel(){

		global $CONFIG;

		$data = $this->gallery->gallery_del($_POST['ids']);
		
		echo "<script>alert('Data berhasil dihapus');window.location.href='".$CONFIG['admin']['base_url']."gallery'</script>";
		
	}
	public function imagedel(){

		global $CONFIG;
		$albumid=$_POST['album'];
        
		$data = $this->gallery->image_del($_POST['ids']);
		
		echo "<script>alert('Data berhasil dihapus');window.location.href='".$CONFIG['admin']['base_url']."gallery/album/?album=".$albumid."'</script>";
		
	}
	public function addImages(){
		$albumId = $_GET['album'];
		$this->view->assign('albumId',$albumId);
		return $this->loadView('gallery/addImages');
	}
	
	public function inpGallery(){
		global $CONFIG;
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
						
						if($x['gallerytype'] == '9'){
							$path_upload = 'gallery/images';
						}else{
							$path_upload = '';
						}
						
						$image = uploadFileMultiple('file_image',$path_upload,'image');
						foreach ($_FILES['file_image']['name'] as $filekey => $file){
							$x['image_url'] = $CONFIG['admin']['app_url'].$image[$filekey]['folder_name'].$image[$filekey]['full_name'];
							$x['image'] = $image[$filekey]['full_name'];
							$data = $this->gallery->gallery_inp($x);
						}
					}
					
		   		}
			   	
		   }catch (Exception $e){}
        
        $redirect = $CONFIG['admin']['base_url'].'home';
        if(isset($x['gallerytype'])){
            if($x['gallerytype']=='9'){
				$redirect = $CONFIG['admin']['base_url'].'gallery/album/?album='.$x['otherid'];
			}
        }
        
        echo "<script>alert('Data berhasil di simpan');window.location.href='".$redirect."'</script>";
        }
	}
}

?>