<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		
		$this->load->database();		
		$this->load->helper(array('form','url','file','number'));
		$this->load->library('form_validation','image_lib');	
				
		
	
		
		$this->LoadSetup();
	}
	
	function LoadSetup() {
		include STARTPATH.'/setup.php';	
		$this->setup = new SimpleXMLElement($xmlstr);
	}
	
	function redirect() {
		header("location: ".site_url());
	}
	
	function index() {	
	
		if (!$pagenum) {
			$pagenum = 1;
		}		
		
		if ($articledb = $this->db->query("select * from `articles` order by date desc")) {
			$articles = $articledb->result_array();
		}
		$results = $articles;
	
		//$content = $this->loadActive('homepage');
	
	
			if ($pageInfo = $this->FindPage('homepage','homepage')) {	
					
				$onlineResults = array();
				$fieldinfo = array();
						
				$contentoption = $pageInfo->options->contentoption;			
				$sortType = $pageInfo->options['sorttype'];
				$contentType = 'content';
				
									
				foreach ($contentoption as $content) {						
					$fields = $this->GetFields($content['sectionType']);					
					$orderstring =  (($fields['sortfield']) ? ' order by `'.$fields['sortfield'].'` '.(($fields['sorttype'] != "manual" && $fields['sorttype'] != "publish") ? $fields['sorttype'] : 'asc').'' : '');
				
					$online = $this->db->query('select * from `'.(string)$fields['tablename'].'` where section = "homepage" and page = "homepage" and active = "1" '.$orderstring);
										
					$onlineArray = (($online) ? $online->result_array() : array());					
					foreach ($onlineArray as $key => $row) {
						$onlineArray[$key]['tablename'] = (string)$fields['tablename'];
					}
					
					$onlineResults[0] = array_merge((array)$onlineResults[0],(array)$onlineArray);						
					$fieldinfo[(string)$fields['tablename']] = $fields;
				}
							
				if ($sortType == 'manual') {
					function onlinesort($a,$b) {						
						if ($a['sortorder'] == $b['sortorder']) {
							return 0;
						}
						return ($a['sortorder'] < $b['sortorder']) ? -1 : 1;
					}									
					uasort($onlineResults[0], 'onlinesort');					
				}
			}	
			
			
		$carousel = $this->getPage('homepage','carousel');
			
		
		$this->load->view('pages/header');		
		$this->load->view('pages/home',array('newsdata'=>array_slice($results,0, 2),'content'=>array_slice($onlineResults[0],0,3), 'carousel'=>$carousel ));
		$this->load->view('pages/footer');
	}
	
	
	function solutions($page=NULL) {	
		if (!$page) {
			$page = "overview";
		}
		switch ($page) {
			case 'overview':
				$title = 'Overview';
				break;
			
			case 'agencies':
				$title = 'Agencies';
				break;
				
			case 'tradingdesks':
				$title = 'Trading Desks';
				break;
			
			case 'publishers':
				$title = 'Publishers';
				break;
				
			case 'adnetworks':
				$title = 'Ad Networks';
				break;
		}		
		$crumbs = array('Solutions'=>'solutions/overview/',$title=>'');
		$this->load->view('pages/header', array('section'=>'solutions','page'=>$page,'crumbs'=>$crumbs));	
		$this->load->view('pages/solutions/'.$page);
		$this->load->view('pages/footer');
	}	
	
	function solutionsagencies($page=NULL) {	
		if (!$page) {
			$page = "overview";
		}
		switch ($page) {
			case 'platform':
				$title = 'Platform';
				break;
			
			case 'marketplace':
				$title = 'Marketplace';
				break;
		}		
		$crumbs = array('Solutions'=>'solutions/overview/','Agencies'=>'solutions/agencies/',$title=>'');
		$this->load->view('pages/header', array('section'=>'solutions','page'=>$page,'crumbs'=>$crumbs));	
		$this->load->view('pages/solutions/agencies/'.$page);
		$this->load->view('pages/footer');
	}
	
	function solutionspublishers($page=NULL) {	
		if (!$page) {
			$page = "overview";
		}
		switch ($page) {
			case 'platform':
				$title = 'Platform';
				break;
			
			case 'marketplace':
				$title = 'Marketplace';
				break;
			
			
			case 'privatemarketplace':
				$title = 'Private Marketplace';
				break;
		}		
		$crumbs = array('Solutions'=>'solutions/overview/','Publishers'=>'solutions/publishers/',$title=>'');
		$this->load->view('pages/header', array('section'=>'solutions','page'=>$page,'crumbs'=>$crumbs));	
		$this->load->view('pages/solutions/publishers/'.$page);
		$this->load->view('pages/footer');
	}	
	
	function products($page=NULL) {	
		if (!$page) {
			$page = "overview";
		}
		switch ($page) {
			case 'overview':
				$title = 'Overview';
				break;
			
			case 'platform':
				$title = 'Platform';
				break;
				
			case 'marketplace':
				$title = 'Marketplace';
				break;
			
			case 'appcenter':
				$title = 'App Center';
				break;
		}		
		$crumbs = array('Products'=>'products/overview/',$title=>'');		
		$this->load->view('pages/header', array('section'=>'products','page'=>$page,'crumbs'=>$crumbs));		
		$this->load->view('pages/products/'.$page);
		$this->load->view('pages/footer');
	}
	
	function careers($page=NULL) {	
		if (!$page) {
			$page = "overview";
		}
		switch ($page) {
			case 'overview':
				$title = 'Overview';
				break;
			
			case 'engineering':
				$title = 'Engineering';
				break;
				
			case 'openings':
				$title = 'Openings';
				break;
		}		
		$crumbs = array('Careers'=>'careers/overview/',$title=>'');
		$this->load->view('pages/header', array('section'=>'careers','page'=>$page,'crumbs'=>$crumbs));		
		$this->load->view('pages/careers/'.$page);
		$this->load->view('pages/footer');
	}
	
	function privacy() {	
		$this->load->view('pages/privacy');
	}
	
	function optout() {	
		$this->load->view('pages/optout');
	}
	function careervideo() {	
		$this->load->view('pages/careers/careervideo',array('overlay'=>true));
	}
	function upfrontvideo() {	
		$this->load->view('pages/upfrontvideo',array('overlay'=>true));
	}
	
	
	
	function careervideodirect() {	
		$this->load->view('pages/header', array('section'=>'careers'));	
		$this->load->view('pages/careers/careervideo',array('overlay'=>false));
		$this->load->view('pages/footer');
	}
	function upfrontvideodirect() {	
		$this->load->view('pages/header');	
		$this->load->view('pages/upfrontvideo',array('overlay'=>false));
		$this->load->view('pages/footer');
	}
	
	function company() {	
		$crumbs = array('Company'=>'company/','Leadership'=>'');
		
		$this->load->view('pages/header', array('section'=>'company','page'=>'overview','crumbs'=>$crumbs));	
		$this->load->view('pages/company');
		$this->load->view('pages/footer');
	}
	
	function articles($pagenum=null) {
		
		if ($articledb = $this->db->query("select * from `articles` where id = '".$pagenum."'")) {
			if ($articledb->num_rows() > 0) {
				$articledata = $articledb->row_array();
			} else {
				$articledata['title'] = "Article not found.";
				$articledata['date'] = "0000-00-00";
			}
		}
		
		$crumbs = array('Company'=>'company/','News'=>'news/');
		
		$this->load->view('pages/header', array('section'=>'company','page'=>'news','crumbs'=>$crumbs));
		$this->load->view('pages/articles',array('articledata'=>$articledata));
		$this->load->view('pages/footer');
		
	}
	
	
	function news($pagenum=null) {
		if (!$pagenum) {
			$pagenum = 1;
		}		
		/*if ($xmlstr = fopen("http://blog.adap.tv/feed/",'r')) {			
			$contents = stream_get_contents($xmlstr);			
			fclose($xmlstr);
			$blog = new SimpleXMLElement($contents);
			
			$i = 0;
			foreach ($blog->channel->item as $item) {			
				$blogitems[$i]['date'] = date('Y-m-d',strtotime((string)$item->pubDate));
				$blogitems[$i]['title'] = (string)$item->title;
				$blogitems[$i]['author'] = 'From our blog The Video Wire';
				$blogitems[$i]['link'] = (string)$item->link;				
				$i++;
			}			
			$articledb = $this->db->query("select * from `articles` order by date desc");
			$articles = $articledb->result_array();
		}*/
		if ($articledb = $this->db->query("select * from `articles` where active = '1' order by date desc")) {
			$articles = $articledb->result_array();
		}
		
		$results = $articles;//array_merge($articles,$blogitems);
		
		/*foreach ($results as $key => $row) {
		   $date[$key]  = $row['date'];
		   $title[$key]  = $row['title'];
		   $author[$key] = $row['author'];
		}	
		array_multisort($date, SORT_DESC, $title, SORT_ASC, $author, SORT_ASC, $results);
		*/
		
		$totalpages = ceil(count($results)/8);
		
		$crumbs = array('Company'=>'company/','News'=>'');
		
		$this->load->view('pages/header', array('section'=>'company','page'=>'news','crumbs'=>$crumbs));		
		$this->load->view('pages/news',array('newsdata'=>array_slice($results,(($pagenum-1) * 8), 8),'pagenum'=>$pagenum,'totalpages'=>$totalpages));
		$this->load->view('pages/footer');
	}
	
	function contact() {
		$this->load->view('pages/header', array('section'=>'contact'));		
		$this->load->view('pages/contact');
		$this->load->view('pages/footer');
	}
	
	
	function loadActive($sectionname) {
	
		//$sectioninfo = array();
	
		if ($sectionInfo = $this->FindSection($sectionname)) {	
			
			if (count($sectionInfo->subsections->content) > 0) {
				foreach ($sectionInfo->subsections->content as $page) {
				
					$pagename = (string)$page['label'];
					$sectioninfo[$pagename] = $this->getPage($sectionname,$pagename);
				
				}
			} else {
			
				$sectioninfo = $this->getPage($sectionname,'');
				
			}
			
		}
		return $sectioninfo;
	}

	function getPage($sectionname,$pagename) {

			if ($pageInfo = $this->FindPage($sectionname,$pagename)) {	
					
				$onlineResults = array();
				$fieldinfo = array();
						
				if (count($pageInfo->contentoption) == 1) {
					$contentoption = $pageInfo->contentoption;	
					$fields = $this->GetFields($contentoption['sectionType']);
					$sortType = $fields['sorttype'];
					$contentType = $contentoption['type'];
				} else {	
					$contentoption = $pageInfo->options->contentoption;				
					$sortType = 'publish';
					$contentType = 'content';
				}
									
				foreach ($contentoption as $content) {						
					$fields = $this->GetFields($content['sectionType']);					
					$orderstring =  (($fields['sortfield']) ? ' order by `'.$fields['sortfield'].'` '.(($fields['sorttype'] != "manual" && $fields['sorttype'] != "publish") ? $fields['sorttype'] : 'asc').'' : '');
				
					if ($online = $this->db->query('select * from `'.$fields['tablename'].'` where section = "'.$sectionname.'" and page = "'.$pagename.'" and `active` = "1"'.$orderstring)) {
					
						$onlinearray = $online->result_array();
					
						array_push($onlineResults,(($online) ? $onlinearray : array()));					
					
						array_push($fieldinfo,$fields);
					}
				}
				
				return array('fieldinfo' => $fieldinfo, 'onlineResults' => $onlineResults[0],'options'=>$contentoption);
			
			} else {
				//show_error('Page not found.');
			}

	}
	
	
	function FindSection($sectionname) {
		
		
			foreach ($this->setup->sections->content as $section) {
				if ($section['label'] == $sectionname) {
					
					return $section;
						
				}
			}
		
		
	}
	
	
	function FindPage($sectionname,$pagename) {
		foreach ($this->setup->sections->content as $section) {
			if ($section['label'] == $sectionname) {
				
				if ($pagename == '' || $pagename == 'NULL') {
					return $section;
				} elseif (count($section->subsections->content)) {				
					foreach ($section->subsections->content as $subsection) {
						if ($pagename == $subsection['label']) {
							return $subsection;
						}
					}
				}
			}
		}	
	}
	
	
	function GetFields($sectionType) {
		foreach ($this->setup->sectiontypes->type as $type) {
			//echo ((string)$type['name'].", ".$sectionType."<br>");
			if ((string)$type['name'] == $sectionType) {
				//echo ('type found');
				return $type;
			}
		}		
		show_error('Fields not found.');
		return FALSE;
	}
	function GetFieldsByTable($tablename) {
		foreach ($this->setup->sectiontypes->type as $type) {
			//echo ((string)$type['name'].", ".$sectionType."<br>");
			if ((string)$type['tablename'] == $tablename) {
				//echo ('type found');
				return $type;
			}
		}		
		show_error('Fields not found.');
		return FALSE;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */