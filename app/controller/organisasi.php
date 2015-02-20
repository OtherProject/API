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
	
	/**function index(){
    	return $this->loadView('profile');
    }**/
    
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

        $limit ='1';
        $adjacent ='3';

        if(isset($_REQUEST['actionfunction']) && $_REQUEST['actionfunction']!=''){
        $actionfunction = $_REQUEST['actionfunction'];
          
            $dataShow =  $this->showData($_POST,$limit,$adjacent);
        }
        // pr($_POST['kategori']);exit;
        $this->view->assign('datamember',$dataShow['data']);
        $this->view->assign('alphabet',$dataShow['pageAbjad']);
        $this->view->assign('paging',$dataShow['pagination']);
        $this->view->assign('kategori',$_POST['kategori']);

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
        
        
        return $this->loadView('organisasi/anggota-view');
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
        $data['pagination'] =  $this->pagination($limit,$adjacent,$rows,$page,$kategori);  

        return $data;
    }

function pagination($limit,$adjacents,$rows,$page,$kategori){   
    global $basedomain;
    $pagination='';
    if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
    $prev = $page - 1;                          //previous page is page - 1
    $next = $page + 1;                          //next page is page + 1
    $prev_='';
    $first='';
    $lastpage = ceil($rows/$limit); 
    $next_='';
    $last='';
    $url=$basedomain."organisasi/anggota/";
    if($lastpage > 1)
    {   
        
        //previous button
        if ($page > 1) 
            $prev_.= "<li><a class='page-numbers' href=\"$url?page=$prev&kategori=$kategori\">&laquo;</a></li>";
        else{
            //$pagination.= "<span class=\"disabled\">previous</span>"; 
            }
        
        //pages 
        if ($lastpage < 5 + ($adjacents * 2))   //not enough pages to bother breaking it up
        {   
        $first='';
            for ($counter = 1; $counter <= $lastpage; $counter++)
            {
                if ($counter == $page)
                    $pagination.= "<li class=\"active\"><span class=\"current\">$counter</span></li>";
                else
                    $pagination.= "<li><a class='page-numbers' href=\"$url?page=$counter&kategori=$kategori\">$counter</a></li>";                    
            }
            $last='';
        }
        elseif($lastpage > 3 + ($adjacents * 2))    //enough pages to hide some
        {
            //close to beginning; only hide later pages
            $first='';
            if($page < 1 + ($adjacents * 2))        
            {
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<li class=\"active\"><span class=\"current\">$counter</span></li>";
                    else
                        $pagination.= "<li><a class='page-numbers' href=\"$url?page=$counter&kategori=$kategori\">$counter</a></li>";                    
                }
            $last.= "<li><a class='page-numbers' href=\"$url?page=$lastpage&kategori=$kategori\">Last</a></li>";            
            }
            
            //in middle; hide some front and some back
            elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
            {
               $first.= "<li><a class='page-numbers' href=\"$url?page=1&kategori=$kategori\">First</a></li>";   
            for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<li class=\"active\"><span class=\"current\">$counter</span></li>";
                    else
                        $pagination.= "<li><a class='page-numbers' href=\"$url?page=$counter&kategori=$kategori\">$counter</a></li>";                    
                }
                $last.= "<li><a class='page-numbers' href=\"$url?page=$lastpage&kategori=$kategori\">Last</a><li>";            
            }
            //close to end; only hide early pages
            else
            {
                $first.= "<li><a class='page-numbers' href=\"$url?page=1\">First</a></li>";  
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
                {
                    if ($counter == $page)
                        $pagination.= "<li class=\"active\"><span class=\"current\">$counter</span></li>";
                    else
                        $pagination.= "<li><a class='page-numbers' href=\"$url?page=$counter&kategori=$kategori\">$counter</a></li>";                    
                }
                $last='';
            }
            
            }
        if ($page < $counter - 1) 
            $next_.= "<li><a class='page-numbers' href=\"$url?page=$next&kategori=$kategori\">&raquo;</a></li>";
        else{
            //$pagination.= "<span class=\"disabled\">next</span>";
            }
        $pagination = "<ul class=\"pagination\">".$first.$prev_.$pagination.$next_.$last;
        //next button
        
        $pagination.= "</ul>\n";       
    }

   return $pagination;  
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
