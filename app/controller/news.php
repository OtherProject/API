<?php

class news extends Controller {
	
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
        $this->contentHelper = $this->loadModel('contentHelper');
        $this->models = $this->loadModel('modeldirektori');
	}
    
    function agenda(){
    	$start = $_GET['tgl'];
    	if($start){
	    	$addOneDay = strtotime($start.'+ 1 day');
			$end = date('Y-m-d',$addOneDay);
    		$agenda = $this->contentHelper->getAgenda(false,$cat=2, $type=0,$start,$end);
            $title = date("d F Y", strtotime($start));
    	}
    	else{
    		$start = date('Y-m-01'); // hard-coded '01' for first day
			$end  = date('Y-m-t');
            $agenda = $this->contentHelper->getAgenda(false,$cat=2, $type=0,$start,$end);
            $title = date("F Y", strtotime("now"));
    	}
    	
    	//pr($agenda);
        
        $this->view->assign('title',$title);
	 	$this->view->assign('agenda',$agenda);
    	return $this->loadView('news/agenda');
    }
	
	function kliping_kegiatan(){
		// $kliping = $this->contentHelper->getNews($id=false,$cat=1,$type=2);
	 // 	$this->view->assign('kliping',$kliping);
    	return $this->loadView('news/kliping_kegiatan');
    }
    
    function berita(){
    	// $berita = $this->contentHelper->getNews($id=false,$cat=1,$type=1);
    	// $this->view->assign('berita',$berita);

    	return $this->loadView('news/berita');
    }
    function get_news(){
        $limit ='4';
        $adjacent ='2';

        if(isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction']!=''){
        $actionfunction = $_REQUEST['actionfunction'];
          
            $dataShow =  $this->showData($_POST,$limit,$adjacent);
        }
        // pr($_POST['kategori']);exit;
        $this->view->assign('datanews',$dataShow['data']);
        $this->view->assign('titleNews',$dataShow['titleNews']);
        $this->view->assign('paging',$dataShow['pagination']);
        $this->view->assign('kategori',$_POST['kategori']);
        $this->view->assign('page',$_POST['page']);
        $this->view->assign('post',$_POST);

        $data['data']=$this->loadView('news/dataNews');

        if ($dataShow){
            print json_encode(array('status'=>true, 'data'=>$data['data']));
        }else{
            print json_encode(array('status'=>false));
        }
        
        exit;

    }
    function get_newsDetail(){
        // $limit ='2';
        // $adjacent ='3';

        $id=$_POST['id'];
        $kategori=$_POST['kategori'];
        // pr($_POST);
        if(isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction']!=''){
        $actionfunction = $_REQUEST['actionfunction'];
          
            // $dataShow =  $this->showData($_POST,$limit,$adjacent);
            $dataShow = $this->contentHelper->getNews($id,$cat=1,$type=$kategori);
        }
        // pr($dataShow);
        if($kategori==1){

            $urlpage="news/berita/";
            // $data['path']="buahpikir";
            // $data['urldetail']="bp";

        }elseif($kategori==2){

            $urlpage="news/kliping_kegiatan/";
            // $data['path']="perundangan";
            // $data['urldetail']="bp";

        }
        // pr($_POST['kategori']);exit;
        $this->view->assign('berita',$dataShow);
        $this->view->assign('urlpage',$urlpage);
        // $this->view->assign('paging',$dataShow['pagination']);
        $this->view->assign('kategori',$_POST['kategori']);
        $this->view->assign('page',$_POST['page']);
        // $this->view->assign('post',$_POST);

        $data['data']=$this->loadView('news/berita_detail');

        if ($dataShow){
            print json_encode(array('status'=>true, 'data'=>$data['data']));
        }else{
            print json_encode(array('status'=>false, 'data'=>$data['data']));
        }
        
        exit;

    }

    function showData($data,$limit,$adjacent){

        $page = $data['page']; 
        $kategori = $data['kategori'];

        if($page==1){
           $start = 0;  
        }
        else{
          $start = ($page-1)*$limit;
        }
        if($kategori==1){
            $data['titleNews']="Berita";
        }elseif ($kategori==2) {
            $data['titleNews']="Kliping Berita";
            
        }
        $dataCountNews=  $this->models->getCountData($categoryid=1, $type=$kategori);
          
        $rows=count($dataCountNews);
          
        $dataNews = $this->contentHelper->getNews($id=false,$cat=1,$type=$kategori,$start,$limit);
          
        $data['data'] = $dataNews; 
        $data['rows'] = $rows; 
        $AddParameter="&kategori=".$kategori;
        $urlpage="news/get_news/";
        $data['pagination'] =pagination($urlpage,$limit,$adjacent,$rows,$page,$AddParameter);  

        return $data;
    }
    function berita_detail(){
    	$id = _g('id');
    	$berita = $this->contentHelper->getNews($id,$cat=1);
    	$this->view->assign('berita',$berita);
    	return $this->loadView('news/berita_detail');
    }

    function kliping_detail(){

		$id = _g('id');
		$kliping = $this->contentHelper->getNews($id,$cat=1,$type=2);
		$this->view->assign('berita',$kliping);
		return $this->loadView('news/berita_detail');
	}
}

?>
