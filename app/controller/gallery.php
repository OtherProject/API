<?php

class gallery extends Controller {
	
	var $models = FALSE;
	var $view;

	
	function __construct()
	{
		global $basedomain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$this->view->assign('basedomain',$basedomain);
    }
	
	function loadmodule()
	{
        $this->models = $this->loadModel('modelgallery');
	}
	
	function foto(){
		// $data = $this->models->get_article(9);
		// $this->view->assign('data',$data);
    	return $this->loadView('gallery/foto');
    }

    function getfoto(){

		$limit ='8';
        $adjacent ='2';
        // pr($_POST);
        if(isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction']!=''){
        $actionfunction = $_REQUEST['actionfunction'];
          
            $dataShow =  $this->showData($_POST,$limit,$adjacent);
        }
        // pr($dataShow);
        $this->view->assign('data',$dataShow['data']);
        // $this->view->assign('titleNews',$dataShow['titleNews']);
        $this->view->assign('paging',$dataShow['pagination']);
        $this->view->assign('kategori',$_POST['kategori']);
        $this->view->assign('page',$_POST['page']);
        $this->view->assign('post',$_POST);

        $data['data']=$this->loadView('gallery/dataFoto');

        if ($dataShow){
            print json_encode(array('status'=>true, 'data'=>$data['data']));
        }else{
            print json_encode(array('status'=>false));
        }
        
        exit;
    }

    function showData($data,$limit,$adjacent){
    	// pr($data);
        $page = $data['page']; 
        $kategori = $data['kategori'];

        if($page==1){
           $start = 0;  
        }
        else{
          $start = ($page-1)*$limit;
        }
        // if($kategori==1){
        //     $data['titleNews']="Berita";
        // }elseif ($kategori==2) {
        //     $data['titleNews']="Kliping Berita";
            
        // }
        $dataCountFoto=  $this->models->getCountDatafoto($kategori);
          
         // pr($dataCountFoto);
        $rows=count($dataCountFoto);
         // pr($rows);
        $dataFoto = $this->models->get_article($kategori,$type=1,$start,$limit);
           // pr($dataFoto);
        $data['data'] = $dataFoto; 
        $data['rows'] = $rows; 
        $AddParameter="&kategori=".$kategori;
        $urlpage="gallery/getfoto/";
        $data['pagination'] =pagination($urlpage,$limit,$adjacent,$rows,$page,$AddParameter);  

        return $data;
    }
    function view_foto(){

        $kategori=$_POST['kategori'];

    	$albumId=$_POST['id'];
    	// pr($_POST);

    	if(isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction']!=''){
        $actionfunction = $_REQUEST['actionfunction'];
          
			$data = $this->models->get_images($albumId);
			$data_album = $this->models->get_article_id($albumId);
        }
        // pr($data_album);
		$this->view->assign('data',$data);
		$this->view->assign('data_album',$data_album);

        $this->view->assign('kategori',$_POST['kategori']);
        $this->view->assign('page',$_POST['page']);

        $data['data']=$this->loadView('gallery/image-view');;

        if ($data_album){
            print json_encode(array('status'=>true, 'data'=>$data['data']));
        }else{
            print json_encode(array('status'=>false, 'data'=>$data['data']));
        }
        
        exit;

    }
    
    function video(){
		return $this->loadView('gallery/video');
    }
    
    /* TEMP DATA */
    function view_ACIKITA(){
    	return $this->loadView('gallery/image-view-acikita');
    }
    
    function view_RAKORLOK(){
    	return $this->loadView('gallery/image-view-rakorlok');
    }
}

?>
