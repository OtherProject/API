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
	}
	
	function index(){
    	//return $this->loadView('gallery/gallery');
    }
    
    function kepakaran(){

        $data = $this->models->get_category();
        $this->view->assign('data_category',$data);

        return $this->loadView('direktori/kepakaran');
    }
    
    function search_result(){
        //pr($_POST);
        $type=_p('kategori');
        $teks=_p('teks');
        //pr($type);
        $data = $this->models->get_category();
        $this->view->assign('data_category',$data);

        $kepakaran = $this->models->getKepakaran($cat=5,$kontent=$teks,$type=$type);
        // //pr($kepakaran);
        $this->view->assign('kepakaran',$kepakaran['dataArr']);
        // //pr($kepakaran);
        return $this->loadView('direktori/search_result');
    }
    
    function result_detail(){

        $id=_g('id');

        $kepakaran = $this->contentHelper->getNews($id=$id,$cat=5,$type=1);
        $this->view->assign('kepakaran',$kepakaran);

        return $this->loadView('direktori/result_detail');
    }
    
    function buah_pikir(){

        $kliping = $this->contentHelper->getNews($id=false,$cat=6,$type=1);
        $this->view->assign('buahpikir',$kliping);
    	return $this->loadView('direktori/buah_pikir');
    }
    
    function perundangan(){

        $kliping = $this->contentHelper->getNews($id=false,$cat=7,$type=1);
        $this->view->assign('perundangan',$kliping);
    	return $this->loadView('direktori/perundangan');
    }
    function bpDetail(){
        $id = _g('id');
        $berita = $this->contentHelper->getNews($id,$cat=6);
        $this->view->assign('berita',$berita);

        $this->view->assign('path','buahpikir');
        return $this->loadView('direktori/berita_detail');
    }
    function prdDetail(){
        $id = _g('id');
        $berita = $this->contentHelper->getNews($id,$cat=7);
        $this->view->assign('berita',$berita);
        $this->view->assign('path','perundangan');
        return $this->loadView('direktori/berita_detail');
    }
    
    function repository(){
    	return $this->loadView('direktori/repository');
    }

    function repository_view(){
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
