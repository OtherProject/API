<?php

class organisasi extends Controller {
	
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
	}
	
	/**function index(){
    	return $this->loadView('profile');
    }**/
    
    function profile(){
        
		$profil =  $this->contentHelper->getNews(false,3);
        // pr($profil);
        
        $this->view->assign('profil',$profil);
        return $this->loadView('organisasi/profile');
    }
    
    function struktur_organisasi(){
        $struktur =  $this->contentHelper->getNews($id=false,$cat=3,$type=2,$start=0,$limit=1);
        // pr($profil);
        
        $this->view->assign('struktur',$struktur);
        return $this->loadView('organisasi/struktur_organisasi');
    }
    
    function anggota(){
        return $this->loadView('organisasi/anggota');
    }
    
    function anggota_view(){
        return $this->loadView('organisasi/anggota-view');
    }
    
    function afiliasi(){
        return $this->loadView('organisasi/afiliasi');
    }
}

?>
