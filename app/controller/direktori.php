<?php

class direktori extends Controller {
	
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
        //$this->models = $this->loadModel('frontend');
        $this->models = $this->loadModel('modeldirektori');
        $this->contentHelper = $this->loadModel('contentHelper');
        $this->modelmember = $this->loadModel('modelmember');
	}
	
	function index(){
    	//return $this->loadView('gallery/gallery');
    }
    
    function kepakaran(){

        
        $this->view->assign('data_category',$data);

        return $this->loadView('direktori/kepakaran');
    }
    function rumpun(){
        $term = $_GET['term'];
        // pr($_GET);
        $idrumpun = $_GET['rumpunid'];

        if($idrumpun!="") $queryidrumpun = "AND rumpun_id=".$idrumpun; else $queryidrumpun="";

        $data = $this->models->get_rumpun($term,$queryidrumpun);

        echo json_encode($data);

        exit;
    }
    function kepakaranAjax(){
        $limit ='4';
        $adjacent ='2';

        if(isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction']!=''){
        $actionfunction = $_REQUEST['actionfunction'];
          
            $dataShow =  $this->showDataKepakaran($_POST,$limit,$adjacent);
        }
        // pr($_POST['kategori']);exit;
        $this->view->assign('datamember',$dataShow['data']);
        $this->view->assign('alphabet',$dataShow['pageAbjad']);
        $this->view->assign('paging',$dataShow['pagination']);
        $this->view->assign('kategori',$_POST['kategori']);
        $this->view->assign('page',$_POST['page']);

        $data['data']=$this->loadView('direktori/dataKepakaran');

        if ($dataShow){
            print json_encode(array('status'=>true, 'data'=>$data['data']));
        }else{
            print json_encode(array('status'=>false));
        }
        
        exit;
    }
    function showDataKepakaran($data,$limit,$adjacent){

        $page = $data['page']; 
        $kategori = $data['kategori'];
        // $pageAbjad=array('A' => a,'B' => b,'C' => c,'D' => d,'E' => e,'F' => f,'G' => g,'H' => h,'I' => i,'J' => j,'K' => k,'L' => l,'M' => m,'N' => n,'O' => o,'P' => p,'Q' => q,'R' => r,'S' => s,'T' => t,'U' => u,'V' => v,'W' => w,'X' => x,'Y' => y,'Z' => z,);  
          
        if($page==1){
           $start = 0;  
        }
        else{
          $start = ($page-1)*$limit;
        }
        $dataAllmember =  $this->modelmember->Allmemberkepakaran($kategori,"0");
          
        $rows=count($dataAllmember);
          
        $dataKategorimember =  $this->modelmember->Allmemberkepakaran($kategori,"1",$start,$limit);
          
        // $data['pageAbjad']=$pageAbjad;
        $data['data'] = $dataKategorimember; 
        $AddParameter="&kategori=".$kategori;
        $urlpage="direktori/kepakaranAjax/";
        $data['pagination'] =pagination($urlpage,$limit,$adjacent,$rows,$page,$AddParameter);  

        return $data;
    }
    function search_result(){
        pr($_POST);

        return $this->loadView('direktori/search_result');
    }
     function search_buahpikir(){
        pr($_POST);
        
        // return $this->loadView('direktori/search_result');
    }
    
    function result_detail(){

        $id=_g('id');

        $kepakaran = $this->contentHelper->getNews($id=$id,$cat=5,$type=1);
        $this->view->assign('kepakaran',$kepakaran);

        return $this->loadView('direktori/result_detail');
    }
    
    function buah_pikir(){

        // $buah_pikir = $this->contentHelper->getNews($id=false,$cat=6,$type=1,0,30);
        // $this->view->assign('buahpikir',$buah_pikir);
    	return $this->loadView('direktori/buah_pikir');
    }
    
    function perundangan(){

        // $perundangan = $this->contentHelper->getNews($id=false,$cat=7,$type=1,0,30);
        // $this->view->assign('perundangan',$perundangan);
    	return $this->loadView('direktori/perundangan');
    }
    function dataAjax(){

        $limit ='4';
        $adjacent ='2';
        // pr($_POST);
        if(isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction']!=''){
        $actionfunction = $_REQUEST['actionfunction'];
          
            $dataShow =  $this->showDataAjax($_POST,$limit,$adjacent);
        }
        // pr($_POST['kategori']);exit;
        $this->view->assign('data',$dataShow['data']);
        $this->view->assign('jumlahData',$dataShow['jumlahData']);
        $this->view->assign('textpencarian',$dataShow['textpencarian']);
        $this->view->assign('rangeStart',$dataShow['rangeStart']);
        $this->view->assign('rangeEnd',$dataShow['rangeEnd']);
        // $this->view->assign('urldetail',$dataShow['urldetail']);
        $this->view->assign('paging',$dataShow['pagination']);
        $this->view->assign('kategori',$_POST['kategori']);
        $this->view->assign('page',$_POST['page']);
        $this->view->assign('parameter',$_POST['param']);
        $this->view->assign('valueparameter',$_POST['valueparam']);
        $this->view->assign('search',$_POST['search']);
        $this->view->assign('post',$_POST);

        $data['data']=$this->loadView('direktori/dataAjax');

        // pr($_POST);
        if ($dataShow){
            print json_encode(array('status'=>true, 'data'=>$data['data']));
        }else{
            print json_encode(array('status'=>false));
        }
        
        exit;
    }
    function showDataAjax($data,$limit,$adjacent){

        $page = $data['page']; 
        $kategori = $data['kategori'];
        $param = $data['param'];
        $valueparam = $data['valueparam'];

        $search = $data['search'];

        $textpencarian="";
        if($page==1){
           $start = 0;  
        }
        else{
          $start = ($page-1)*$limit;
        }
        $where="";
        $search="";
        if($param==1){
            $textpencarian="Pencarian Berdasarkan <strong><i>Judul</i></strong> dengan kata <strong>&ldquo;".$valueparam."&rdquo;</strong>";
            $where=" AND title LIKE '%{$valueparam}%'";
        }elseif($param==2){
            $where="";
        }elseif($param==3){
            $textpencarian="Pencarian Berdasarkan <strong><i>Kontent</i></strong> dengan kata <strong>&ldquo;".$valueparam."&rdquo;</strong>";
            $where=" AND content LIKE '%{$valueparam}%'";
        }else{
            if($data['search']){
                $search="&search=1";
              $textpencarian="Pencarian Berdasarkan <strong><i>Judul & Kontent</i></strong> dengan kata <strong>&ldquo;".$valueparam."&rdquo;</strong>";
            }else{
                 $textpencarian="";
            }
            $where=" AND (title LIKE '%{$valueparam}%' OR content LIKE '%{$valueparam}%')";
        }

        $dataCount=  $this->models->getCountData($categoryid=$kategori, $type=1,$where);
          
        $rows=count($dataCount);

        if($page==1){
            $rangeStart = 1;  

            if($rangeStart > $rows){
                $rangeStart = $rows;  
            }
            $rangeEnd = $limit;  

            if($rangeEnd > $rows){
                $rangeEnd = $rows;  
            }
        }
        else{
            $rangeStart = (($page-1)*$limit)+1;  
            $rangeEnd = $rangeStart+($limit-1);

            if($rangeEnd > $rows){
                $rangeEnd = $rows;  
            }
        }
       
        $datasql = $this->models->getNews($id=false,$cat=$kategori,$type=1,$start,$limit,$where);  
        // $dataKategorimember =  $this->modelmember->Allmember($kategori,"1",$start,$limit);
          
        // $data['pageAbjad']=$pageAbjad;
        $data['data'] = $datasql; 
        $data['rangeStart']=$rangeStart;
        $data['rangeEnd']=$rangeEnd;
        $data['jumlahData']=$rows;
        $data['textpencarian']=$textpencarian;
        $AddParameter="&kategori=".$kategori."&parameter=".$param."&valueparameter=".$valueparam.$search;
        if($kategori==6){

            $urlpage="direktori/buah_pikir/";
            // $data['urldetail']="detail";

        }elseif($kategori==7){

            $urlpage="direktori/perundangan/";
            // $data['urldetail']="detail";

        }

        $data['pagination'] =pagination($urlpage,$limit,$adjacent,$rows,$page,$AddParameter);  

        return $data;
    }
    function bpDetail(){
        $id = _g('id');
        $berita = $this->contentHelper->getNews($id,$cat=6);
        $this->view->assign('berita',$berita);

        $this->view->assign('path','buahpikir');
        return $this->loadView('direktori/berita_detail');
    }
    function beritaDetail(){
        $id = $_POST['id'];
        $kategori = $_POST['kategori'];

        // $berita = $this->contentHelper->getNews($id,$cat=7);

        if(isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction']!=''){
        $actionfunction = $_REQUEST['actionfunction'];
          
            $dataShow =  $this->contentHelper->getNews($id,$cat=$kategori);
        }
        if($kategori==6){

            $urlpage="direktori/buah_pikir/";
            $data['path']="buahpikir";
            // $data['urldetail']="bp";

        }elseif($kategori==7){

            $urlpage="direktori/perundangan/";
            $data['path']="perundangan";
            // $data['urldetail']="bp";

        }
        
        // pr($_POST['kategori']);exit;
        // $this->view->assign('data',$dataShow['data']);
        // $this->view->assign('jumlahData',$dataShow['jumlahData']);
        // $this->view->assign('textpencarian',$dataShow['textpencarian']);
        // $this->view->assign('rangeStart',$dataShow['rangeStart']);
        // $this->view->assign('rangeEnd',$dataShow['rangeEnd']);
        $this->view->assign('urlpage',$urlpage);
        $this->view->assign('path',$data['path']);
        $this->view->assign('kategori',$_POST['kategori']);
        $this->view->assign('page',$_POST['page']);
        $this->view->assign('parameter',$_POST['param']);
        $this->view->assign('valueparameter',$_POST['valueparam']);
        $this->view->assign('search',$_POST['search']);
        // $this->view->assign('post',$_POST);

        $this->view->assign('berita',$dataShow);
        $this->view->assign('post',$_POST);


        $data['data']=$this->loadView('direktori/berita_detail');

        // pr($_POST);
        if ($dataShow){
            print json_encode(array('status'=>true, 'data'=>$data['data']));
        }else{
            print json_encode(array('status'=>false));
        }
        
        exit;
    }
    
    function repository(){

        $repository = $this->contentHelper->getNews($id=false,$cat=8,$type=1);
        // pr($repository);
        $this->view->assign('repository',$repository);
    	return $this->loadView('direktori/repository');
    }

    function repository_view(){
        
        $id=$_GET['id'];
        $repo = $this->models->get_files($typealbum=false, $id = $id);
        
        $this->view->assign('repo',$repo);
        // pr($repo);
    	return $this->loadView('direktori/repository_view');
    }

/** TEMPORARY DATA INPUTTED **/    
    function repository_view_1(){
    	return $this->loadView('direktori/repository_view_1');
    }
    
    function repository_view_2(){
    	return $this->loadView('direktori/repository_view_2');
    }
}

?>
