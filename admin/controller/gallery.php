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
		$id = $_GET['album'];
		$data = $this->gallery->get_images($id);
		$this->view->assign('data',$data);
		return $this->loadView('gallery/images');
	}
	
	public function gallerydel(){

		global $CONFIG;
		pr($_POST);exit;
		$data = $this->gallery->gallery_del($_POST['ids']);
		
		echo "<script>alert('Data berhasil dihapus');window.location.href='".$CONFIG['admin']['base_url']."gallery'</script>";
		
	}
	
	public function addImages(){
		return $this->loadView('gallery/addImages');
	}
	
	public function inpImages(){
		global $CONFIG;
		pr($_FILES);exit;
	}
}

?>