<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Preview extends CI_Controller {

	var $liked;
	var $setup;
	
	function __construct()
	{
		parent::__construct();
		
		
		$this->load->database();
		
		$this->load->helper(array('form','url','file','number'));
		$this->load->library('form_validation');			
		
		
		if (!$signed_request = $this->input->post('signed_request', TRUE)) {
			if (!$signed_request = $this->input->get('signed_request', TRUE)) {		
				//show_error('No like information');
			}
		}
		
		 
		if($signed_request = $this->parsePageSignedRequest($signed_request)) {
			if($signed_request->page->liked) {
			  $this->liked = true;
			} else {
			  $this->liked = false;
			}
		}
		
		$this->LoadSetup();
		
	}
	
	
	function createpreview() {
		
		
		switch ($this->input->post('sectionname')) {
			
			
			case "homepage":
				$this->index();
				break;
				
			case "articles":
				$this->articles();
				break;
		
		
		}
	}
	
	
	function articles($pagenum=null) {
		
		
		//$articledb = $this->db->query("select * from `articles` where id = '".$this->input->post('id')."'");
		//$articledata = $articledb->row_array();
		
		if ($this->input->post('link') != '') {			
			
			$content = $this->loadActive('articles');		
			$results = $content['onlineResults'];
			
			$key = array_search($_POST,$results);			
			$pagenum = ceil($key/8);			
			
			$this->load->view('pages/header', array('section'=>'news'));		
			$this->load->view('pages/news',array('newsdata'=>array_slice($results,(($pagenum-1) * 8), 8),'pagenum'=>$pagenum,'totalpages'=>$totalpages));
			$this->load->view('pages/footer');
			
			
		} else {
		
			$articledata = $_POST;
			
			$this->load->view('pages/header', array('section'=>'news'));		
			$this->load->view('pages/articles',array('articledata'=>$articledata));
			$this->load->view('pages/footer');
		
		}
		
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
				
				$found = false;			
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
				
				$content = array_slice($onlineResults[0],0,3);				
				$found = false;
				foreach ($content as $key => $row) {
					if ($row['tablename'] == $_POST['tablename'] && $row['id'] == $_POST['id']) {
						$content[$key] = $_POST;
						$found = true;
					}				
				}				
				if (!$found) {					
					$content[0] = $_POST;					
				}
				
			}	
		
		
			
		$carousel = $this->getPage('homepage','carousel');
		
		$this->load->view('pages/header');		
		$this->load->view('pages/home',array('newsdata'=>array_slice($results,0, 2),'content'=> $content, 'carousel'=>$carousel ));
		$this->load->view('pages/footer');
	}
	
	
	function LoadSetup() {
		/*if ($xmlstr = read_file(STARTPATH.'/setup.xml')) {
			$this->setup = new SimpleXMLElement($xmlstr);
			if (!$this->CheckDatabase($this->setup)) {
				show_error('Database tables missing and cannot be created. '.mysql_error());	
			}
		}*/	
		include STARTPATH.'/setup.php';	
		$this->setup = new SimpleXMLElement($xmlstr);
		
		/*if (!$this->setup) {
			echo "Failed loading XML\n";
			foreach(libxml_get_errors() as $error) {
				echo "\t", $error->message;
			}
		}*/
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
				
					$online = $this->db->query('select * from `'.$fields['tablename'].'` where section = "'.$sectionname.'" and page = "'.$pagename.'" and `active` = "1"'.$orderstring);
					
					$onlinearray = $online->result_array();
					
					//print_r($onlinearray);
					
					if ($this->input->post('tablename') == $fields['tablename']) {
						if ($fields['displaytype'] == "publish") {
							if ($_POST['pagename'] != "NULL" && $_POST['pagename'] == $pagename) {
								$onlinearray[0] = $_POST;
							} else if ($_POST['sectionname'] != "NULL" && $_POST['sectionname'] == $sectionname) {
								$onlinearray[0] = $_POST;
							}
						} else {
							$active = false;
							$i = 0;
							foreach ($onlinearray as $row) {
								if ($row['id'] == $this->input->post('id')) {
									$onlinearray[$i] = $_POST;
									$active = true;
								}
								$i++;
							}
							
							if (!$active) {	
								array_push($onlinearray,$_POST);						
							}
						}
					}
					
					array_push($onlineResults,(($online) ? $onlinearray : array()));				
					
					array_push($fieldinfo,$fields);
				}
				
				
				return array('fieldinfo' => $fieldinfo, 'onlineResults' => $onlineResults[0],'options'=>$contentoption);
			
			} else {
				//show_error('Page not found.');
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
	
	
	function activate($sectionname=NULL,$pagename=NULL,$tablename=NULL,$id=NULL,$parentid=NULL) {
		
		
	
					if ($fields = $this->GetFieldsByTable($tablename)) {				
						if ($fields['displaytype'] == "publish") {					
							$this->db->query('UPDATE `'.$tablename.'` SET active = "0" where active = "1" and section = "'.$sectionname.'" and page = "'.((isset($pagename) && $pagename != 'NULL') ? $pagename : '').'"');
							
							if (!$this->db->query('UPDATE `'.$tablename.'` SET active = "1" where id = "'.$id.'" and section = "'.$sectionname.'" and page = "'.((isset($pagename) && $pagename != 'NULL') ? $pagename : '').'"')) {
								show_error('Activate could not be completed. Database could not be updated');
							}
						} else {
							
							if ($fields['sorttype'] == "manual") {
								$sort = (string)$fields['sortfield'];
										
								$orderstring =  (($sort) ? ' order by '.$sort.' desc limit 1' : '');
										
								if ($last = $this->db->query('select * from `'.$tablename.'` where active = "1" and section = "'.$sectionname.'" and page = "'.((isset($pagename) && $pagename != 'NULL') ? $pagename : '').'" order by sortorder desc limit 1')) {
									$lastresult = $last->row_array();
									$next = $lastresult[$sort]+1;
								} else {
									$next = 1;
								}
										
								$this->db->query('UPDATE `'.$tablename.'` SET '.$sort.' = "'.$next.'", active = "1" where id = "'.$id.'" and section = "'.$sectionname.'" and page = "'.((isset($pagename) && $pagename != 'NULL') ? $pagename : '').'"');
								
								
							} else {
								
								$this->db->query('UPDATE `'.$tablename.'` SET active = "1" where id = "'.$id.'" and section = "'.$sectionname.'" and page = "'.((isset($pagename) && $pagename != 'NULL') ? $pagename : '').'"');
							}
						}
					}
					
				
			
		
	}
	
	function FindSection($sectionname) {
		
		
			foreach ($this->setup->sections->content as $section) {
				if ($section['label'] == $sectionname) {
					
					return $section;
						
				}
			}
		
		
	}
	
	
	function createMetaTags($tagData) {
		
		$tagstring = '<meta property="og:title" content="'.$tagData['title'].'" />
		<meta property="og:url" content="'.$tagData['url'].'" />
		<meta property="og:image" content="'.$tagData['image'].'" />
		<meta property="og:site_name" content="Toyota Fan zone" />
		<meta property="og:description" content="'.$tagData['description'].'"/>
		<meta property="fb:admins" content="1747269206"/>
		<meta property="fb:app_id" content="'.$tagData['appid'].'"/>
		<meta property="og:type" content="'.$tagData['type'].'" />';
		
		if ($tagData['video']) {
	
			$tagstring .= '<meta property="og:video" content="https://www.youtube.com/v/'.$tagData['video'].'?version=3&amp;autohide=1"/>
			<meta property="og:video:type" content="application/x-shockwave-flash" />
			<meta property="og:video:width" content="398">
       	 <meta property="og:video:height" content="224">';
			
		
		}
		
		return $tagstring;
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
	
	function parsePageSignedRequest($signed_request) {
		if (isset($signed_request)) {
		  $encoded_sig = null;
		  $payload = null;
		  list($encoded_sig, $payload) = explode('.',$signed_request, 2);
		  $sig = base64_decode(strtr($encoded_sig, '-_', '+/'));
		  $data = json_decode(base64_decode(strtr($payload, '-_', '+/'), true));
		  return $data;
		} 
		return false;
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */