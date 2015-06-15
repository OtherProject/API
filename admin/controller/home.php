<?php
// defined ('TATARUANG') or exit ( 'Forbidden Access' );

class home extends Controller {
	
	var $models = FALSE;
	
	public function __construct()
	{
		parent::__construct();

		global $app_domain;
		$this->loadmodule();
		$this->view = $this->setSmarty();
		$sessionAdmin = new Session;
		$this->admin = $sessionAdmin->get_session();
		// $this->validatePage();
		$this->view->assign('app_domain',$app_domain);
	}
	public function loadmodule()
	{
		
		$this->models = $this->loadModel('marticle');
		$this->excelHelper = $this->loadModel('excelHelper');
	}
	
	function parseExcel()
	{
		/*
		New scenario !
		1. Parse data xls 
		2. Validate data before upload
		3. Store data to tmp table
		3. Try to move data from tmp table to real table
		4. Done
		
		*/
		
		global $EXCEL, $basedomain;
		
		// $username = $this->user['login']['username'];
		

		// pr($_FILES);exit;
		logFile(serialize($_FILES));

		if ($_FILES){
			
			$numberOfSheet = 1;
			$startRowData = 1;
			$startColData = 2;
			$formNametmp = array_keys($_FILES);
			$formName = $formNametmp[0];
			
			if (empty($formName)) die;
			
			$startTime = microtime(true);
			/* parse data excel */
			
			logFile('load excel begin');

			// empty log file
			

			$parseExcel = $this->excelHelper->fetchExcel($formName, $numberOfSheet,$startRowData,$startColData);
			// pr($parseExcel);exit;
			
			if ($parseExcel){
				// logFile('Extract File ', $username);
				/*
				foreach ($parseExcel as $key => $val){
					
					$field = implode(',',$val['field_name']);
					
					$data = array();

					if ($val['data']){

						foreach ($val['data'] as $keys => $value){
						
							foreach ($value as $k => $v){
								$data[$val['field_name'][$k]] = $v;
							}
							
							$newData[$val['sheet']]['data'][] = $data; 
							
						}
					}else{
						print json_encode(array('status'=>false, 'msg'=>'Data tidak tersedia'));
						exit;
					}
					
					
				}
				*/

				$this->models->insertNomenklatur($parseExcel);
				exit;
				// pr($newData);
				/* here begin process */
				if ($newData){
					
					$emptyTmptable = $this->importHelper->insertTmpData($newData[0]['data']);
					
					if ($emptyTmptable) redirect($basedomain.'import/previewData');
					exit;
					
					

				}else{
					print json_encode(array('status'=>false, 'msg'=>'Tidak ada data yang tersedia'));
					exit;
				}
			}else{
				print json_encode(array('status'=>false, 'msg'=>'Ekstrak gagal'));
				exit;
			}
		}else{
			logFile('File xls empty');
			// echo "File is empty";
			print json_encode(array('status'=>true, 'msg'=>'File kosong'));
		}
		
		
		exit;
	}

	public function index(){


		if (isset($_POST['submit2'])){

			$this->parseExcel();
			
			pr($_FILES);
			exit;
		}


		$this->view->assign('active','active');
		$data = $this->models->get_article(1);

		if ($data){
			foreach ($data as $key => $val){

				$data[$key]['created_date'] = dateFormat($val['created_date'],'article');

				$data[$key]['posted_date'] = dateFormat($val['posted_date'],'article');

				if($val['n_status'] == '1') {
					$data[$key]['n_status'] = 'Publish';
					$data[$key]['status_color'] = 'green';
				} else {
					$data[$key]['n_status'] = 'Unpublish';
					$data[$key]['status_color'] = 'red'; 
				}
			}
		}
		
		// pr($data);exit;
		$this->view->assign('data',$data);

		return $this->loadView('home');

	}

	public function frame(){

		$data = $this->models->get_frameList();
		// pr($data);
		$this->view->assign('data',$data);

		return $this->loadView('listFrame');
	}
	
	function ajax()
	{
		
		$id = _p('id');
		$n_status = _p('n_status');
		
		$data = $this->models->updateStatusFrame($id, $n_status);
		if ($data){
			print json_encode(array('status'=>true));
		}else{
			print json_encode(array('status'=>false));
		}

		exit;
	}
}

?>
