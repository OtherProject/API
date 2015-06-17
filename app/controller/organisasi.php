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
        $this->modelmember = $this->loadModel('modelmember');
	}
	
	// function index(){

 //        return $this->profil();
 //    }
    
    function profil(){
        
        $profil =  $this->contentHelper->getNews(false,3);
        // pr($profil);
        
        $this->view->assign('profil',$profil);
        return $this->loadView('organisasi/profile');
    }
    
    function struktur_organisasi(){
        $type = $_GET['type'];
        $kabid = $_GET['kabid'];
        $perwakilan = $_GET['perwakilan'];
        //$struktur =  $this->contentHelper->getNews($id=false,$cat=3,$type=2,$start=0,$limit=1);
        
        if($type == 'dewan_kehormatan'){
            return $this->loadView('organisasi/so-dewan_kehormatan');
        }
        else if($type == 'dewan_penasihat'){
            return $this->loadView('organisasi/so-dewan_penasihat');
        }
        else if($type == 'dewan_pengurus_umum'){
            return $this->loadView('organisasi/so-dewan_pengurus_umum');
        }
        else if($type == 'kabid'){
            return $this->loadView('organisasi/so-kabid_'.$kabid);
        }
        else if($type == 'perwakilan'){
            return $this->loadView('organisasi/so-perwakilan_'.$perwakilan);
        }

        //$this->view->assign('struktur',$struktur);
        //return $this->loadView('organisasi/struktur_organisasi');
    }
    
    function anggotaAjax(){

        $limit ='6';
        $adjacent ='2';

        if(isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction']!=''){
        $actionfunction = $_REQUEST['actionfunction'];
          
            $dataShow =  $this->showData($_POST,$limit,$adjacent);
        }
        // pr($_POST['kategori']);exit;
        $this->view->assign('datamember',$dataShow['data']);
        $this->view->assign('alphabet',$dataShow['pageAbjad']);
        $this->view->assign('paging',$dataShow['pagination']);
        $this->view->assign('kategori',$_POST['kategori']);
        $this->view->assign('page',$_POST['page']);

        $data['data']=$this->loadView('organisasi/anggota_Ajax');

        if ($dataShow){
            print json_encode(array('status'=>true, 'data'=>$data['data']));
        }else{
            print json_encode(array('status'=>false));
        }
        
        exit;
    }
    
    function anggota(){

        
        return $this->loadView('organisasi/anggota');

    }
    function anggota_view(){
        
        // pr($_GET);

         if(isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction']!=''){
        $actionfunction = $_REQUEST['actionfunction'];
          
            $dataShow =  $this->showDataDetail($_POST);
        }
       // pr($dataShow);
        // pr($matkul);
        // pr($publikasi);
        // pr($riwayatpekerjaan);
        $this->view->assign('detailmember',$dataShow['data'][0]);
        $this->view->assign('matkul',$dataShow['matkul']);
        $this->view->assign('publikasi',$dataShow['publikasi']);
        $this->view->assign('riwayatpekerjaan',$dataShow['riwayatpekerjaan']);
        $this->view->assign('kategori',$_POST['kategori']);
        $this->view->assign('page',$_POST['page']);

        $data['data']=$this->loadView('organisasi/anggota-view');

        if ($dataShow){
            print json_encode(array('status'=>true, 'data'=>$data['data']));
        }else{
            print json_encode(array('status'=>false));
        }
        
        exit;
    }

    function showData($data,$limit,$adjacent){

        $page = $data['page']; 
        $kategori = $data['kategori'];
        $pageAbjad=array('A' => a,'B' => b,'C' => c,'D' => d,'E' => e,'F' => f,'G' => g,'H' => h,'I' => i,'J' => j,'K' => k,'L' => l,'M' => m,'N' => n,'O' => o,'P' => p,'Q' => q,'R' => r,'S' => s,'T' => t,'U' => u,'V' => v,'W' => w,'X' => x,'Y' => y,'Z' => z,);  
          
        if($page==1){
           $start = 0;  
        }
        else{
          $start = ($page-1)*$limit;
        }
        $dataAllmember =  $this->modelmember->Allmember($kategori,"0");
          
        $rows=count($dataAllmember);
          
        $dataKategorimember =  $this->modelmember->Allmember($kategori,"1",$start,$limit);
          
        $data['pageAbjad']=$pageAbjad;
        $data['data'] = $dataKategorimember; 
        $AddParameter="&kategori=".$kategori;
        $urlpage="organisasi/anggota/";
        $data['pagination'] =pagination($urlpage,$limit,$adjacent,$rows,$page,$AddParameter);  

        return $data;
    }

    function showDataDetail($data){
        // pr($data);
        $id=$data['id'];
        $page = $data['page']; 
        $kategori = $data['kategori'];
        
        $detailmember =  $this->modelmember->detailmember($id);

        $matkul=$this->modelmember->getRiwayat($id,0);
        $publikasi=$this->modelmember->getRiwayat($id,1);
        $riwayatpekerjaan=$this->modelmember->getRiwayat($id,2);

        $data['data'] = $detailmember; 
        $data['matkul'] = $matkul; 
        $data['publikasi'] = $publikasi; 
        $data['riwayatpekerjaan'] = $riwayatpekerjaan; 

        return $data;
    }

    function afiliasi(){

        
        $data = $this->contentHelper->getData(3,3);
        // pr($data);
        if($data){
            foreach ($data as $key => $value) {
                $data[$key]['created_date'] = dateFormat($data[$key]['created_date'],'dd-mm-yyyy');
                $data[$key]['posted_date'] = dateFormat($data[$key]['posted_date'],'dd-mm-yyyy');
                $data[$key]['expired_date'] = dateFormat($data[$key]['expired_date'],'dd-mm-yyyy');
            }
            
        }
        
        $this->view->assign('data',$data);
        
        return $this->loadView('organisasi/afiliasi');
    }
}

?>
