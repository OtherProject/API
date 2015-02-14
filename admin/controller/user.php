<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class user extends Controller {
	
	var $models = FALSE;
	
	public function __construct()
	{
		global $app_domain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$sessionAdmin = new Session;
		$this->admin = $sessionAdmin->get_session();
		$this->view->assign('app_domain',$app_domain);
		
	}
	public function loadmodule()
	{
		
		$this->userHelper = $this->loadModel('userHelper');
	}
	
	public function index(){
       
		
		$data = $this->userHelper->getUserAccount();
		
		// pr($data);
		$this->view->assign('data',$data);

		return $this->loadView('member/user-member'); 

	}
    
	
	function show(){
       
		// $data = $this->contentHelper->getData();
		// pr($data);
		return $this->loadView('home');

	}
	
	function detail()
	{
		global $basedomain;

		$data['id'] = _g('id');

		$getData = $this->userHelper->getUserAccount($data,$debug=false,$getall=true);
		// pr($getData);
		$this->view->assign('data',$getData[0]);
		return $this->loadView('member/user-member-detail');

	}

	function add(){
       
		global $basedomain;
		
		if (_p('token')){
			
			// upload image 
			$uploadImage['status'] = false;
			if ($_FILES['image']['name']!="")$uploadImage = uploadFile('image','user');
			
			
			$addUser = $this->userHelper->addUser();
			if ($uploadImage['status']){
				
				$updateUser = $this->userHelper->updateUserImage($uploadImage['filename'],$addUser);
			}
			
			if ($addUser) redirect($basedomain.'user');
			exit;
		}
		
		
		return $this->loadView('user/user-input');

	}
	
	
	function edit()
	{
		global $basedomain, $app_domain;;
		$userid = intval(_g('id'));
		$data['listuser'] = $this->userHelper->getListUser($userid);
		
		if (_p('token')){
			
			// upload image 
			
			$uploadImage['status'] = false;
			if ($_FILES['image']['name']!="")$uploadImage = uploadFile('image','user');
			
			
			$dataarr = array();
			$userid = intval(_p('id'));
			$addUser = $this->userHelper->updateUserProfile($dataarr,$userid);
			if ($uploadImage['status']){
				
				$updateUser = $this->userHelper->updateUserImage($uploadImage['filename'],$addUser);
			}
			
			if ($addUser) redirect($basedomain.'user');
			exit;
		}
		
		return $this->loadView('user/user-edit',$data);
	}
	
	function delete()
	{
		$id = intval(_p('id'));
		if ($id>0){
			$del = $this->userHelper->deleteUser($id);
			if ($del){
				print json_encode(array('status'=>true));
			}else{
				print json_encode(array('status'=>false));
			}
		}
		
		exit;
	}
	
	function register_admin()
	{
		global $CONFIG;
		pr($_POST);exit;
		if(!empty($_POST)){
			$x = form_validation($_POST);

			   try
			   {
			   		if(isset($x) && count($x) != 0)
			   		{
						pr($_POST);exit;
						$data = $this->models->upd_pass($pass);
			   		}
			}catch (Exception $e){}
			
		}
			echo "<script>window.location.href='".$CONFIG['admin']['base_url']."'</script>";
		
	}
}

?>
