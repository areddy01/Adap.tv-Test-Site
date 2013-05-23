<?php 

/********* CMS Copyright @2012  MHI Inc. ***************/

// Contact matth@mhinteractive.com for more information //

/*******************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends CI_Controller {

	var $setup;

	function __construct()
	{
		parent::__construct();		
		parse_str($_SERVER['QUERY_STRING'],$_GET);		
		$this->load->library('session');
		$this->load->database();		
		$this->load->helper(array('form','url','file','number','xml'));
		
		/*if ($_SERVER['https'] != 1) {
			header('location: '.secure_site_url(uri_string()));			
		}*/
		$this->load->library('form_validation');		
		define("UPLOADS_PATH",STARTPATH.'/'.$this->config->item('uploads_path'));		
		$this->LoadSetup();
	}
	
	function login() {		
		if ($this->input->post('username') == "adapt") {		
			if ($this->input->post('password') == "TVAdapt25#") {
				$this->session->set_userdata('LOGGED_IN',true);
				$this->editcontent();			
			} else {
				$this->load->view('header',array("hidenav"=>true));
				$this->load->view('login/loginform',array('error'=>'password','username'=>$this->input->post('username'),'password'=>'Invalid password'));	
				$this->load->view('footer');				
			}			
		} else {		
			$this->load->view('header',array("hidenav"=>true));
			$this->load->view('login/loginform',array('error'=>'username','username'=>'Invalid username'));	
			$this->load->view('footer');	
		}		
	}
	
	
	
	function LoadSetup() {
		include STARTPATH.'/setup.php';	
		$this->setup = new SimpleXMLElement($xmlstr);
		
		if (!$this->setup) {
			echo "Failed loading XML\n";
			foreach(libxml_get_errors() as $error) {
				echo "\t", $error->message;
			}
		} else {
			if (!$this->CheckDatabase($this->setup)) {
				show_error('Database tables missing and cannot be created. '.mysql_error());	
			}
		}
		
	}
	
		
	function logout() {
		$this->session->set_userdata('LOGGED_IN',false);
		$this->index();
	}
	function index() {		
		if ($this->session->userdata('LOGGED_IN') === true) {			
			$this->editcontent();		
		}  else {			
			$this->load->view('header',array("hidenav"=>true));
			$this->load->view('login/loginform');	
			$this->load->view('footer');	
		}
	}
	function datamanager() {
		if ($this->session->userdata('LOGGED_IN') !== true) {
			$this->index();
		}  else {
			$this->load->view('header',array('section' => 'datamanager'));
			$this->load->view('dataManagement', array('content' => $this->setup->datasections));
			$this->load->view('footer');
		}
	}
	
	function loaddata($sectionname=NULL,$pagename=NULL,$subid=NULL) {
		
		
		$pageInfo = $this->FindDataPage($sectionname,$pagename);
		$contentoption = $pageInfo->contentoption;	
			
		
		if (isset($subid)) {
			$fields = $this->GetFields($contentoption->subdata['sectionType']);			
			$tablename = (string)$fields['tablename'];	
			
			$query = $this->db->query('select * from `'.$tablename.'`'.(($contentoption['subdbfield']) ? ' where '.$contentoption['subdbfield'].' = "'.$subid.'"' : '').' order by datetime asc');
			
		} else {
			
			$fields = $this->GetFields($contentoption['sectionType']);
			$tablename = (string)$fields['tablename'];		
			$query = $this->db->query('select * from `'.$tablename.'` order by datetime asc');
			
			//print_r($fields);
			//print_r($query->result_array());
		}
		
		$this->load->view('data/datatables',array('fields' =>$fields,'data'=>$query->result_array(),'tablename'=>$tablename,'subid'=>$subid));
		
	}
	
	function loaddataarchive($sectionname=NULL,$pagename=NULL) {
		if ($this->session->userdata('LOGGED_IN') !== true) {			
			show_error('Access denied.');		
		}  else {
				
			if ($pageInfo = $this->FindDataPage($sectionname,$pagename)) {	
					
					
				
				$onlineResults = array();
				$offlineResults = array();
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
				
					$online = $this->db->query('select * from `'.$fields['tablename'].'` where active = "1" '.$orderstring);
					$offline = $this->db->query('select * from `'.$fields['tablename'].'` where active = "0" '.$orderstring);
					
					array_push($onlineResults,(($online) ? $online->result_array() : array()));					
					array_push($offlineResults,(($offline) ? $offline->result_array() : array()));
					
					array_push($fieldinfo,$fields);
				}
				
				$this->load->view('editor/dataarchive', array('sectionname' => ((isset($sectionname)) ? $sectionname : ''),'pagename' => ((isset($pagename) && $pagename != 'NULL') ? $pagename : ''),'pageTitle' => $pageInfo->name, 'contentType' => $contentType, 'sortType' => $sortType, 'fieldinfo' => $fieldinfo, 'onlineResults' => $onlineResults, 'offlineResults' => $offlineResults,'options'=>$contentoption));
			
			} else {
				show_error('Page not found.');
			}
		}
	}
	
	
	
	function previewwindow($sectionname=NULL,$pagename=NULL) {	
		//$this->session->
		if ($pagename == 'NULL') {
			$pagename = '';
		}
		$this->load->view('editor/preview',array('pagename'=>$pagename,'sectionname'=>$sectionname));
	}
	
	
	function upload($info=NULL) {	
		//$directory = './uploads/images/';	
		$directory = UPLOADS_PATH;	
		if ($filename = $this->input->get('qqfile')) {
			$filename = time().$filename;
			$input = fopen("php://input", "r");
			$temp = tmpfile();
			$realSize = stream_copy_to_stream($input, $temp);
			fclose($input);
			if ($realSize != (int)$_SERVER["CONTENT_LENGTH"]){      
				$result = array("error"=>"File size incorrect.");
			}	
			if (!$target = fopen($directory.$filename, "w")) {	
				echo 'File could not be created';
			}
			fseek($temp, 0, SEEK_SET);
			stream_copy_to_stream($temp, $target);
			fclose($target);
			$result = array('success'=>true,'file'=>$filename);
        } elseif (isset($_FILES['qqfile'])) {
         
			$filename = $_FILES['qqfile']['name'];	
			$filename = time().$filename;	 
		 	if (!move_uploaded_file($_FILES['qqfile']['tmp_name'], $directory.$filename)) {				
				$result = array("error"=>"File upload failed.");
			} else {
				$result = array('success'=>true,'file'=>$filename);
			}
		 
        } else {
            $result = array("error"=>"File not sent.");
        }
		echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
	}
	
	function delete($sectionname=NULL,$pagename=NULL,$tablename=NULL,$id=NULL) {
		if ($this->session->userdata('LOGGED_IN') !== true) {			
			show_error('Access denied.');		
		}  else {	
			if ($query = $this->db->query('delete from `'.$tablename.'` where id = "'.$id.'"')) {
				echo 'deleted';	
			} else {
				show_error('Delete Failed.');	
			}
			echo 'deleted';	
		}
	}
	
	
	function add($sectionname=NULL,$pagename=NULL,$tablename=NULL,$parentid=NULL) {
		if ($this->session->userdata('LOGGED_IN') !== true) {			
			show_error('Access denied.');		
		}  else {	
			
			if (!$sectionname || !$pagename || !$tablename) {	
			
				show_error('Add could not be completed.');	
			
			} else {
			
				$fields = $this->GetFieldsByTable($tablename);
				
				if ($pagename == 'NULL') {
					$pagename = '';
				}
			
				if ($add = $this->db->query('insert into `'.$tablename.'` (`id`,`section`,`page`,`active`'.(($fields['parentdbfield'] && isset($parentid)) ? ',`'.$fields['parentdbfield'].'`' : '').') values ("","'.$sectionname.'","'.$pagename.'","0"'.(($fields['parentdbfield'] && isset($parentid)) ? ',"'.$parentid.'"' : '').')')) {					
					
					$query = $this->db->query('select * from `'.$tablename.'` where `id` = "'.$this->db->insert_id().'"');
					$row = $query->result_array();
					
					list($offlineResults,$fieldinfo) = $this->GetOffline($sectionname,$pagename);					
					$this->load->view('editor/offline', array('row' => $row[0],'fieldinfo' => $fieldinfo[$tablename]) );
					
					
				} else {
					show_error('Add failed.');	
				}				
				
			}
			/*	if ($query = $this->db->query('delete from `'.$tablename.'` where id = "'.$id.'"')) {
					echo 'deleted';	
				} else {
					show_error('Delete Failed.');	
				}*/	
		}
	}
	
	function pickrandom($tablename=NULL,$parentid=NULL) {
		if ($this->session->userdata('LOGGED_IN') !== true) {			
			show_error('Access denied.');		
		}  else {	
			if (!$tablename) {			
				show_error('Pick could not be completed.');
			} else {
				
				$fields = $this->GetFieldsByTable($tablename);
				
				$query = $this->db->query('select * from `'.$tablename.'`'.((isset($parentid) && $parentid != 'NULL') ? ' where prizeid = "'.$parentid.'"' : ''));
				
				$total = $query->num_rows();
				
				if ($total > 0) {
					
					$random = rand(0,($total-1));
					
					$resultarray = $query->result_array();
					
					$result = $resultarray[$random];
					
					$this->load->view('editor/showrandom', array('result' => $result));
				} else {
				
				
					$this->load->view('editor/showrandom', array('error' => 'No results available.'));
					
				}
				
			}
		}		
	}
	function downloadcsv($tablename=NULL,$parentid=NULL) {
		if ($this->session->userdata('LOGGED_IN') !== true) {			
			show_error('Access denied.');		
		}  else {	
			if (!$tablename) {			
				show_error('Pick could not be completed.');
			} else {
				
				$fields = $this->GetFieldsByTable($tablename);				
				$query = $this->db->query('select * from `'.$tablename.'`'.((isset($parentid) && $parentid != 'NULL') ? ' where prizeid = "'.$parentid.'"' : ''));
				
				//echo 'select * from `'.$tablename.'`'.((isset($parentid) || $parentid != 'NULL') ? ' where prizeid = "'.$parentid.'"' : '');
				
				header('Content-type: text/csv');
				header('Content-Disposition: attachment; filename="'.date('Y-m-d').'_'.$tablename.'.csv"');
				
				$this->load->view('data/csv', array('fields' =>$fields,'data' => $query->result_array()));
				
				
			}
		}		
	}
	
	
	function activate($sectionname=NULL,$pagename=NULL,$tablename=NULL,$id=NULL,$parentid=NULL) {
		if ($this->session->userdata('LOGGED_IN') !== true) {			
			show_error('Access denied.');		
		}  else {	
		
			if ($parentid == NULL) {
				
				if (!$sectionname || !$tablename || !$id) {			
					show_error('Activate could not be completed.');
				} else {
				
					if ($fields = $this->GetFieldsByTable($tablename)) {				
						if ($fields['displaytype'] == "publish") {					
							$this->db->query('UPDATE `'.$tablename.'` SET active = "0" where active = "1" and section = "'.$sectionname.'" and page = "'.((isset($pagename) && $pagename != 'NULL') ? $pagename : '').'"');
							
							if (!$this->db->query('UPDATE `'.$tablename.'` SET active = "1" where id = "'.$id.'" and section = "'.$sectionname.'" and page = "'.((isset($pagename) && $pagename != 'NULL') ? $pagename : '').'"')) {
								show_error('Activate could not be completed. Database could not be updated');
							}
						} else {
							
							if ($fields['sorttype'] == "manual") {
								$sort = (string)$fields['sortfield'];
								
								list($onlineResults,$fieldinfo) = $this->GetOnline($sectionname,$pagename);								
								$next = count($onlineResults[0])+1;
									
								$this->db->query('UPDATE `'.$tablename.'` SET '.$sort.' = "'.$next.'", active = "1" where id = "'.$id.'" and section = "'.$sectionname.'" and page = "'.((isset($pagename) && $pagename != 'NULL') ? $pagename : '').'"');								
								
							} else {								
								$this->db->query('UPDATE `'.$tablename.'` SET active = "1" where id = "'.$id.'" and section = "'.$sectionname.'" and page = "'.((isset($pagename) && $pagename != 'NULL') ? $pagename : '').'"');
							}
						}
						
						$this->reorder($sectionname,$pagename,$tablename);		
						echo "success";
					}
					
				}
			} else {
			
					if ($fields = $this->GetFieldsByTable($tablename)) {				
						if ($fields['displaytype'] == "publish") {					
							$this->db->query('UPDATE `'.$tablename.'` SET active = "0" where '.$fields['parentdbfield'].' = "'.$parentid.'" and active = "1"');
							if (!$this->db->query('UPDATE `'.$tablename.'` SET active = "1" where id = "'.$id.'" and '.$fields['parentdbfield'].' = "'.$parentid.'"')) {
								show_error('Activate could not be completed. Database could not be updated');
							}
						} else {
							
							if ($fields['sorttype'] == "manual") {
								$sort = (string)$fields['sortfield'];
										
								$orderstring =  (($sort) ? ' order by '.$sort.' desc limit 1' : '');
										
								$last = $this->db->query('select * from `'.$tablename.'` where active = "1" and '.$fields['parentdbfield'].' = "'.$parentid.'" order by sortorder desc limit 1');
								$lastresult = $last->row_array();
								
										
								$this->db->query('UPDATE `'.$tablename.'` SET '.$sort.' = "'.($lastresult[$sort]+1).'", active = "1" where id = "'.$id.'" and '.$fields['parentdbfield'].' = "'.$parentid.'"');
							} else {
								
								$this->db->query('UPDATE `'.$tablename.'` SET active = "1" where id = "'.$id.'" and '.$fields['parentdbfield'].' = "'.$parentid.'"');
							}
						}
						
						$this->reordersub($tablename,$parentid);				
						echo "success";
					}
				
				
				
			}
		}
	}
	
	function reorder($sectionname=NULL,$pagename=NULL,$tablename=NULL,$neworder=NULL) {
		if ($this->session->userdata('LOGGED_IN') !== true) {			
			show_error('Access denied.');		
		}  else {
		
			//if ($tablename) {			
				//show_error('Reorder could not be completed.');
					
					if ($neworder) {
						$orderarray = explode("|",urldecode($neworder));					
						//print_r($orderarray);
				
						$i = 1;
						foreach ($orderarray as $order) {						
							$info = explode("_",$order);	
							
							$fields = $this->GetFieldsByTable($tablename);
							$sort = (string)$fields['sortfield'];
												
							$this->db->query('UPDATE `'.$info[0].'` SET '.$sort.' = "'.$i.'" where id = "'.$info[1].'" and section = "'.$sectionname.'" and page = "'.((isset($pagename) && $pagename != 'NULL') ? $pagename : '').'"');							
							
							echo 'UPDATE `'.$info[0].'` SET '.$sort.' = "'.$i.'" where id = "'.$info[1].'" and section = "'.$sectionname.'" and page = "'.((isset($pagename) && $pagename != 'NULL') ? $pagename : '').'"';		
							$i++;
						}
						
					} else {
						
						
						
						if ($pageInfo = $this->FindPage($sectionname,$pagename)) {	
					
							if (count($pageInfo->contentoption) == 1) {
								
								$contentoption = $pageInfo->contentoption;	
								$fields = $this->GetFields($contentoption['sectionType']);
								$sortType = $fields['sorttype'];
								$contentType = $contentoption['type'];
								
									$sort = (string)$fields['sortfield'];
									if ($order = $this->db->query('select * from `'.$tablename.'` where active = "1" and section = "'.$sectionname.'" and page = "'.((isset($pagename) && $pagename != 'NULL') ? $pagename : '').'" order by sortorder asc')) {						
										if ($order->num_rows() >= 1) {
											$i = 1;
											foreach ($order->result_array() as $row) {								
												$this->db->query('UPDATE `'.$tablename.'` SET '.$sort.' = "'.$i.'", active = "1" where id = "'.$row['id'].'"');									
												$i++;
											}
										}
									}
								
							} else {	
							
								$contentoption = $pageInfo->options->contentoption;				
								$sortType = $pageInfo->options['sorttype'];
								$contentType = 'content';
																
								list($onlineResults,$fieldinfo) = $this->GetOnline($sectionname,$pagename);
																
								$i = 1;
								foreach ($onlineResults[0] as $row) {
									$sort = $fieldinfo[$row['tablename']]['sortfield'];
									$this->db->query('UPDATE `'.$row['tablename'].'` SET '.$sort.' = "'.$i.'", active = "1" where id = "'.$row['id'].'"');									
									$i++;
								}
							}
						}
						
						
					}
				
		}
	}
	
	function sizeimage($newsize=NULL,$id=NULL) {
		if ($this->session->userdata('LOGGED_IN') !== true) {			
			show_error('Access denied.');		
		}  else {	
			$directory = '/uploads/userimages/';
		
			if ($query = $this->db->query("select * from `norcalrideregistration` where id = '".$id."'")) {
				
				$imagedata = $query->row_array();
				$image = $imagedata['user_image'];
				
				list($width, $height) = getimagesize(STARTPATH.$image);	
				if ($width > 600) {
					$scale = 600/$width;
				} else {
					$scale = 1;
				}
			
			
				$type = explode(".",$image);
				$ftype = strtolower($type[count($type)-1]);
					
					
				$imagetype = exif_imagetype(STARTPATH.$image);
				
				$size = explode("|",urldecode($newsize));
													
															
				switch ($imagetype) {
				
					case 2:
						$source = imagecreatefromjpeg(STARTPATH.$image);
						break;
						
					case 1:
						$source = imagecreatefromgif(STARTPATH.$image);
						break;
							
					case 3:
						$source = imagecreatefrompng(STARTPATH.$image);
						break;
				}
						
				$small = imagecreatetruecolor(217,155);
				
				
				$base = basename(STARTPATH.$image,".".$ftype);
				
				imagecopyresampled($small, $source, 0, 0, round($size[0]/$scale), round($size[1]/$scale), 217, 155, round($size[2]/$scale), round($size[3]/$scale));
				imagejpeg($small, STARTPATH.$directory.time().".jpg", 90);
				
				$name = $imagedata['fname']." ".substr($imagedata['lname'],0,1).".";
				
				if (!$this->db->query("INSERT `norcalridewinners` (section,page,thumbimage,name,city,active) VALUES ('ownerscircle','norcalridewinnersgallery','".$directory.time().".jpg','".$name."','','0')")) {
				
					show_error("Could not add to database.");
				
				} else {
				
					$this->load->view('editor/cropimagesuccess');	
				
				}
		
			} else {
			
			
				show_error("Image not found.");
			
			}
		
		
		}
	}
	
	
	function reordersub($tablename=NULL,$parentid=NULL,$neworder=NULL) {
		if ($this->session->userdata('LOGGED_IN') !== true) {			
			show_error('Access denied.');		
		}  else {	
		
			if (!$tablename) {			
				show_error('Reorder could not be completed.');
			}
			if ($fields = $this->GetFieldsByTable($tablename)) {	
				if ($parentid) {
				
					if ($neworder) {
						$orderarray = explode("|",urldecode($neworder));
						
						$sort = (string)$fields['sortfield'];
						
						print_r($orderarray);
				
						$i = 1;
						foreach ($orderarray as $order) {							
							$info = explode("_",$order);							
							$this->db->query('UPDATE `'.$tablename.'` SET '.$sort.' = "'.$i.'" where id = "'.$info[1].'"');	
							$i++;
						}
						
						
					} else {
						
						$sort = (string)$fields['sortfield'];
						if ($order = $this->db->query('select * from `'.$tablename.'` where active = "1" and '.$fields['parentdbfield'].' = "'.$parentid.'" order by sortorder asc')) {
						
							if ($order->num_rows() >= 1) {
								$i = 1;
								foreach ($order->result_array() as $row) {
								
									$this->db->query('UPDATE `'.$tablename.'` SET '.$sort.' = "'.$i.'", active = "1" where id = "'.$row['id'].'"');			
									
									$i++;
								}
							}
						}
					}
					
				} else {			
					show_error('Reorder could not be completed.');
				}
			}
		}
	}
	
	
	function deactivate($sectionname=NULL,$pagename=NULL,$tablename=NULL,$id=NULL) {
		if ($this->session->userdata('LOGGED_IN') !== true) {			
			show_error('Access denied.');		
		}  else {		
			if ($parentid == NULL) {		
				if (!$sectionname || !$tablename || !$id) {			
					show_error('Activate could not be completed.');
				} else {				
					if (!$this->db->query('UPDATE `'.$tablename.'` SET active = "0" where id = "'.$id.'" and section = "'.$sectionname.'" and page = "'.((isset($pagename) && $pagename != 'NULL') ? $pagename : '').'"')) {
						show_error('Activate could not be completed. Database could not be updated');
					}					
					$this->reorder($sectionname,$pagename,$tablename);						
					echo "success";
				}
			} else {
				if (!$this->db->query('UPDATE `'.$tablename.'` SET active = "0" where id = "'.$id.'" and '.$fields['parentdbfield'].' = "'.$parentid.'"')) {
					show_error('Activate could not be completed. Database could not be updated');
				}
				$this->reordersub($tablename,$parentid);						
				echo "success";	
			}
		}
	}
	
	
	
	function deletewindow($contentType) {
		if ($this->session->userdata('LOGGED_IN') !== true) {			
			show_error('Access denied.');		
		}  else {	
			$this->load->view('editor/delete', array('contentType' => ((isset($contentType)) ? $contentType : 'content') ));
		}
	}
	
	function formbuild($sectionname=NULL,$pagename=NULL,$tablename=NULL,$id=NULL,$subform=NULL) {
		
		//echo $tablename.",".$id;
		
		if ($this->session->userdata('LOGGED_IN') !== true) {			
			show_error('Access denied.');		
		}  else {				
			if ($pageInfo = $this->FindPage($sectionname,$pagename)) {
				if (!$id || !$tablename) {	
					if (file_exists(APPPATH.'views/instructions/'.$pagename.'.php')) {						
						$this->load->view('instructions/'.$pagename, array('sectionname' => ((isset($sectionname)) ? $sectionname : ''),'pagename' => ((isset($pagename) && $pagename != 'NULL') ? $pagename : '')));						
					} else {
						$this->load->view('instructions/instructions', array('sectionname' => ((isset($sectionname)) ? $sectionname : ''),'pagename' => ((isset($pagename) && $pagename != 'NULL') ? $pagename : '')));
					}
				} else {					
					if ($fields = $this->GetFieldsByTable($tablename)) {					
						$query = $this->db->query('select * from `'.$tablename.'` where id = "'.$id.'"');
						
						
						$subdata = array();
						foreach ($fields->subtypes->type as $subtype) {
								
							$sub = $this->GetFields($subtype['name']);
							array_push($subdata,$sub);
						}		
						
						$options = $this->getAllOptions();			
						
						$this->load->view('editor/formbuild', array('fields' => $fields,'data' => (($query) ? $query->result_array() : array()), 'sectionname'=>$sectionname,'pagename'=>$pagename,'tablename'=>$tablename,'id'=>$id,'subdata'=>$subdata,'options'=>$options,'subform'=>$subform));					
					} else {
						show_error('Section type not found.');	
					}
				}
			} else {
				show_error('Page not found.');
			}
		}
	}
	
	
	function getAllOptions() {
	
		$optionarray = array();	
		foreach ($this->setup->xpath('//optionstable') as $option) {		
			$tablename = (string)$option['table'];	
			
			$fields = $this->GetFieldsByTable($tablename);
			
			$orderstring =  (($fields['sortfield']) ? ' order by `'.$fields['sortfield'].'` '.(($fields['sorttype'] != "manual" && $fields['sorttype'] != "publish") ? $fields['sorttype'] : 'asc').'' : '');
				
			
			if ($query = $this->db->query('select * from `'.$tablename.'` where active = "1"'.$orderstring)) {
				$optionarray[$tablename] = $query->result_array();
			}
		}		
		return $optionarray;
		
	}	
	
	function updatecontent() {
		
	
		if (!$fields = $this->GetFieldsByTable($this->input->post('tablename'))) {			
			echo("Table not found");			
		} else {			
			$updateArray = array();
			foreach ($fields->field as $field) {
				$dbfield = (string)$field['dbfield'];
				if ($data =  $this->input->post($dbfield)) {					
					array_push($updateArray, " ".$dbfield." = ".$this->db->escape($data)."");
				} else {
					if ($data === 0) {
						array_push($updateArray, " ".$dbfield." = ".$this->db->escape($data)."");
					}
				}
			}
			
			$query = 'UPDATE `'.$this->input->post('tablename').'` set '.implode(",",$updateArray).' where id = "'.$this->input->post('id').'"';
			if (!$this->db->query($query)) {	
				echo("Update failed ".$query);
			} else {			
				$this->formbuild($this->input->post('sectionname'),$this->input->post('pagename'));
			}
		}		
	}
	
	function loadarchive($sectionname=NULL,$pagename=NULL) {
		if ($this->session->userdata('LOGGED_IN') !== true) {			
			show_error('Access denied.');		
		}  else {
				
			if ($pageInfo = $this->FindPage($sectionname,$pagename)) {	
					
				if (count($pageInfo->contentoption) == 1) {
					$contentoption = $pageInfo->contentoption;	
					$fields = $this->GetFields($contentoption['sectionType']);
					$sortType = $fields['sorttype'];
					$contentType = $contentoption['type'];
					$tablename = (string)$fields['tablename'];
				} else {	
					$contentoption = $pageInfo->options->contentoption;				
					$sortType = $pageInfo->options['sorttype'];
					$contentType = 'content';
				}
					
				list($onlineResults,$fieldinfo) = $this->GetOnline($sectionname,$pagename);
				list($offlineResults,$offlineFieldinfo) = $this->GetOffline($sectionname,$pagename);
				
				$fieldinfo = array_merge($fieldinfo,$offlineFieldinfo);
				
				
				$this->load->view('editor/archive', array('sectionname' => ((isset($sectionname)) ? $sectionname : ''),'pagename' => ((isset($pagename) && $pagename != 'NULL') ? $pagename : ''),'pageTitle' => $pageInfo->name, 'contentType' => $contentType, 'sortType' => $sortType,'fieldinfo' => $fieldinfo, 'onlineResults' => $onlineResults, 'offlineResults' => $offlineResults,'options'=>$contentoption,'tablename'=>((isset($tablename)) ? $tablename : "NA") ));
			
			} else {
				show_error('Page not found.');
			}
		}
	}
	
	function GetOffline($sectionname,$pagename) {	
	
		if ($pageInfo = $this->FindPage($sectionname,$pagename)) {	
	
				$offlineResults = array();
				$fieldinfo = array();
						
				if (count($pageInfo->contentoption) == 1) {
					$contentoption = $pageInfo->contentoption;	
					$fields = $this->GetFields($contentoption['sectionType']);
					$sortType = $fields['sorttype'];
					$contentType = $contentoption['type'];
				} else {	
					$contentoption = $pageInfo->options->contentoption;				
					$sortType = $pageInfo->options['sorttype'];
					$contentType = 'content';					
				}
									
				foreach ($contentoption as $content) {						
					$fields = $this->GetFields($content['sectionType']);					
					$orderstring =  (($fields['sortfield']) ? ' order by `'.$fields['sortfield'].'` '.(($fields['sorttype'] != "manual" && $fields['sorttype'] != "publish") ? $fields['sorttype'] : 'asc').'' : '');
				
					$offline = $this->db->query('select * from `'.(string)$fields['tablename'].'` where section = "'.$sectionname.'" and page = "'.((isset($pagename) && $pagename != 'NULL') ? $pagename : '').'" and active = "0" '.$orderstring);
					
					$offlineArray = (($offline) ? $offline->result_array() : array());
					
					foreach ($offlineArray as $key => $row) {
						$offlineArray[$key]['tablename'] = (string)$fields['tablename'];
					}
									
					$offlineResults[0] = array_merge((array)$offlineResults[0],(array)$offlineArray);					
					$fieldinfo[(string)$fields['tablename']] = $fields;
				}
			return array($offlineResults,$fieldinfo);
		} else {	
			return false;
		}
	}
	
	function GetOnline($sectionname,$pagename) {	
	
		
	
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
					$sortType = $pageInfo->options['sorttype'];
					$contentType = 'content';
					
				}
									
				foreach ($contentoption as $content) {						
					$fields = $this->GetFields($content['sectionType']);					
					$orderstring =  (($fields['sortfield']) ? ' order by `'.$fields['sortfield'].'` '.(($fields['sorttype'] != "manual" && $fields['sorttype'] != "publish") ? $fields['sorttype'] : 'asc').'' : '');
				
					$online = $this->db->query('select * from `'.(string)$fields['tablename'].'` where section = "'.$sectionname.'" and page = "'.((isset($pagename) && $pagename != 'NULL') ? $pagename : '').'" and active = "1" '.$orderstring);
					
					$onlineArray = (($online) ? $online->result_array() : array());
					
					foreach ($onlineArray as $key => $row) {
						$onlineArray[$key]['tablename'] = (string)$fields['tablename'];
					}
					
					$onlineResults[0] = array_merge((array)$onlineResults[0],(array)$onlineArray);			
					$fieldinfo[(string)$fields['tablename']] = $fields;
				}
				if ($sortType == 'manual') {
					uasort($onlineResults[0], array($this, 'onlinesort'));		
				}	
				
			return array($onlineResults,$fieldinfo);
		} else {	
			return false;
		}
	}
	
	
	function onlinesort($a,$b) {						
		if ($a['sortorder'] == $b['sortorder']) {
			return 0;
		}
		return ($a['sortorder'] < $b['sortorder']) ? -1 : 1;
	}
	
	
	function loadarchivefromtable($tablename=NULL,$parentid=NULL) {
		if ($this->session->userdata('LOGGED_IN') !== true) {			
			show_error('Access denied.');		
		}  else {
				
						
			$fields = $this->GetFieldsByTable($tablename);	
				
			$sortType = (string)$fields['sorttype'];
			$contentType = (string)$fields['type'];		
			
			
			//print_r($fields);		
					
			$onlineResults = array();
			$offlineResults = array();
			$fieldinfo = array();
				
			$orderstring =  (($fields['sortfield']) ? ' order by `'.$fields['sortfield'].'` '.(($fields['sorttype'] != "manual" && $fields['sorttype'] != "publish") ? $fields['sorttype'] : 'asc').'' : '');
				
			$online = $this->db->query('select * from `'.$fields['tablename'].'` where active = "1" '.((isset($parentid)) ? ' and '.$fields['parentdbfield'].' = "'.$parentid.'"' : '').$orderstring);
			$offline = $this->db->query('select * from `'.$fields['tablename'].'` where active = "0" '.((isset($parentid)) ? ' and '.$fields['parentdbfield'].' = "'.$parentid.'"' : '').$orderstring);
					
			array_push($onlineResults,(($online) ? $online->result_array() : array()));					
			array_push($offlineResults,(($offline) ? $offline->result_array() : array()));
					
			array_push($fieldinfo,$fields);
				
				
			$this->load->view('editor/archive', array('contentType' => $contentType, 'sortType' => $sortType, 'fieldinfo' => $fieldinfo, 'onlineResults' => $onlineResults, 'offlineResults' => $offlineResults,'options'=>$contentoption,'parentid'=>$parentid));
			
			
		}
	}
	
	
	function FindDataPage($sectionname,$pagename) {
		foreach ($this->setup->datasections->content as $section) {
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
	
	function FindSection($sectionname) {
		
		
			foreach ($this->setup->sections->content as $section) {
				if ($section['label'] == $sectionname) {
					
					return $section;
						
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
		show_error('Table fields not found.');
		return FALSE;
	}
	function editcontent($sectionname=NULL,$pagename=NULL) {
		
		//echo $pagename;
		
		if ($this->session->userdata('LOGGED_IN') !== true) {
			
			$this->index();
		
		}  else {
				
			$this->load->view('header',array('section' => 'editcontent','sectionname' => ((isset($sectionname)) ? $sectionname : ''),'pagename' => ((isset($pagename) && $pagename != 'NULL') ? $pagename : '')));
			$this->load->view('contentEditor', array('content' => $this->setup->sections));
			$this->load->view('footer');
		
		}
	}
	
	function filemanager() {
		if ($this->session->userdata('LOGGED_IN') !== true) {
			
			$this->index();
		
		} else {
						
			//$this->loadfilelist('images|icons|16px/columns');
			
			$headerLoad = '<link rel="stylesheet" type="text/css" href="'.site_url('styles/css/files.css').'" />';
			
							
			$this->load->view('header',array('section' => 'filemanager', 'headerLoad' => $headerLoad));
			$this->load->view('filemanager');
			$this->load->view('footer');
		
		}
	}
	
	function loadfileinfo($filepath) {
		
		//echo UPLOADS_PATH.implode('/',explode('+',$filepath));
		
		$path = implode('/',explode('+',$filepath));
		
		$fullpath = UPLOADS_PATH.$path;
		
		$fileinfo = get_file_info($fullpath);
		
		$size = byte_format($fileinfo['size']);
		
		$this->load->view('files/fileinfo',array('fileinfo' => $fileinfo, 'fullpath' => $fullpath, 'path' => $path, 'linkpath' => $filepath, 'name' => $fileinfo['name'], 'size' => $size, 'date' => $fileinfo['date'], 'mime' => get_mime_by_extension($fullpath)));		
	}
	
	
	function loadfilelist($path='') {
		
		if ($path != '') {
			$dirnames = explode('+',$path);
			$path = implode('/',$dirnames).'/';
		} else {
			$dirnames = explode('/',$this->config->item('uploads_path'));
		}
		
		$folderName = $dirnames[count($dirnames)-1];
		
		$filepath = UPLOADS_PATH.$path;
	
		$fileList = scandir($filepath);
				
		$this->load->view('files/columns',array('fileList' => $fileList, 'folderName' => $folderName, 'fullpath' => $filepath, 'path' => $path));		
		
		
		/*foreach ($fileList as $file) {
			if ($file!='.' && $file!='..') {
				
				$class = str_replace('.png','',$file);
				
echo $class.'16 {
	background:url(../images/icons/16px/'.$class.'.png) 4px 4px no-repeat;
}
				
';
			}
		} */
	}
	
	function deletefile($filepath) {
		$path = implode('/',explode('+',$filepath));		
		$fullpath = UPLOADS_PATH.$path;
		if (unlink($fullpath)) {
			
			$path = pathinfo($path,PATHINFO_DIRNAME).'/';
			$dirnames = explode('/',$path);
			$folderName = $dirnames[count($dirnames)-1];
			
			$filepath = pathinfo($fullpath,PATHINFO_DIRNAME).'/';
	
			$fileList = scandir($filepath);
			$this->load->view('files/columns',array('fileList' => $fileList, 'folderName' => $folderName, 'fullpath' => $filepath, 'path' => $path));		
										
		} else {
			echo "false";
		}
	}	
	function checkoverwrite($filepath,$dirpath='') {
		$path = implode('/',explode('+',$filepath));	
		$dirpath = implode('/',explode('+',$dirpath));	
		
		$extension = explode('.',$path);
		
		$fullpath = UPLOADS_PATH.$path;
		$newFullPath = UPLOADS_PATH.$dirpath.basename($path);
		
	
		if (file_exists($newFullPath)) {	
			echo "exists";
		} else {	
			echo "none";			
		}
		
	}
	
	
	function movefile($filepath,$dirpath='') {
		$path = implode('/',explode('+',$filepath));	
		$dirpath = implode('/',explode('+',$dirpath));	
		
		$extension = explode('.',$path);
		
		$fullpath = UPLOADS_PATH.$path;
		$newFullPath = UPLOADS_PATH.$dirpath.basename($path);
		
		if (copy($fullpath,$newFullPath)) {		
			
			if (unlink($fullpath)) {
				
				$this->loadfilelist($dirpath);
											
			} else {
				echo "false";
			}
		} else {
			echo "false";	
		}
	}	
	
	function download($filepath) {
		
		$path = implode('/',explode('+',$filepath));		
		$fullpath = UPLOADS_PATH.$path;
		
		header('Content-type: '.get_mime_by_extension($fullpath));
		header('Content-Disposition: attachment; filename="'.pathinfo($fullpath,PATHINFO_BASENAME).'"');
		@readfile($fullpath);
	}	
	
	function loadform($type) {
	
		$this->load->view('forms/'.$type);
	
	}
	
	function CheckDatabase($setup) {
		
		foreach ($setup->sectiontypes->type as $table) {		
			if ($describe = $this->db->query('DESCRIBE `'.$table['tablename'].'`')) {
						
				foreach ($table->field as $field) {
					$found = FALSE;
					foreach ($describe->result_array() as $column) {	
					
						//print_r($column);
										
						if ($column['Field'] == (string)$field['dbfield']) {
							$found = TRUE;
						}
					}
					
					if (!$found) {						
						$this->AddField($table['tablename'],$field);						
					}
				}			
				
				
			} else {
				if (!$this->CreateTable($table)) {
					return false;
				} else {
				
					if ($table['tablename'] == "carousel") {
					
						$this->db->query("UPDATE `articleplaceholder` set page = 'homepage' where section = 'homepage' and page = ''");
						$this->db->query("UPDATE `leadershipbanner` set page = 'homepage' where section = 'homepage' and page = ''");
						$this->db->query("UPDATE `solutionsspotlight` set page = 'homepage' where section = 'homepage' and page = ''");
						$this->db->query("UPDATE `careerbanner` set page = 'homepage' where section = 'homepage' and page = ''");
						
					}
					if ($table['tablename'] == "articleplaceholder") {
					
						$this->db->query("INSERT INTO `articleplaceholder` (id,section,page,sortorder,title,active) VALUES(1,'homepage','homepage','3','News: edit in articles','1')");
						
					}
					
				}
			}
		}
		return true;
	}
	
	function CreateTable($table) {
		
		//CREATE TABLE `testdatabase` (`id` INT( 11 ) NOT NULL , `var` VARCHAR( 255 ) NOT NULL , `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 	`active` TINYINT( 4 ) NOT NULL , `text` TEXT NOT NULL , 	PRIMARY KEY ( `id` ) ) ENGINE = MYISAM 
	
		//`id` INT( 11 ) NOT NULL , `var` VARCHAR( 255 ) NOT NULL , `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 	`active` TINYINT( 4 ) NOT NULL , `text` TEXT NOT NULL 
	
		$fieldText = array();		
		
		array_push($fieldText,'`id` INT(11) NOT NULL AUTO_INCREMENT');
		array_push($fieldText,'`section` VARCHAR(255) NOT NULL');
		array_push($fieldText,'`page` VARCHAR(255) NOT NULL');
		
		
		foreach ($table->field as $field) {	
			//<field name="Special Title" dbfield="specialtitle" datatype="varchar" fieldtype="text" length="255" required="true" />
			
			if (!$field['datatype']) {
			
				show_error($field['dbfield'].' missing data type.');
				
			}
			
			//$defaultText = ((isset($field['default'])) ? ' DEFAULT "'.$field['default'].'"' : '');  
			
			switch ($field['datatype']) {
				
				case "int":					
					array_push($fieldText,'`'.$field['dbfield'].'` INT('.$field['length'].') NOT NULL');
					break;
					
				case "tinyint":					
					array_push($fieldText,'`'.$field['dbfield'].'` TINYINT('.$field['length'].') NOT NULL');
					break;
					
				case "varchar":					
					array_push($fieldText,'`'.$field['dbfield'].'` VARCHAR('.$field['length'].') NOT NULL');
					break;
					
				case "date":					
					array_push($fieldText,'`'.$field['dbfield'].'` DATE NOT NULL DEFAULT "0000-00-00"');
					break;
					
				case "datetime":					
					array_push($fieldText,'`'.$field['dbfield'].'` DATETIME NOT NULL DEFAULT "0000-00-00 00:00:00"');
					break;
					
					
				case "timestamp":					
					array_push($fieldText,'`'.$field['dbfield'].'` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
					break;
					
				case "text":					
					array_push($fieldText,'`'.$field['dbfield'].'` TEXT NOT NULL');
					break;
				
			}
			
		}
		
		array_push($fieldText,'`active` TINYINT(4) NOT NULL');
		
		
		$mysqlText = 'CREATE TABLE `'.$table['tablename'].'` ('.implode(",",$fieldText).' , PRIMARY KEY (`id`) ) ENGINE = MYISAM';
		
		//echo $mysqlText;
		
		return $this->db->query($mysqlText);
	
	}
	
	function AddField($name,$field) {
		
			print_r($field);
			
			switch ($field['datatype']) {
				
				case "int":					
					$fieldText = '`'.$field['dbfield'].'` INT('.$field['length'].') NOT NULL';
					break;
					
				case "tinyint":					
					$fieldText = '`'.$field['dbfield'].'` TINYINT('.$field['length'].') NOT NULL';
					break;
					
				case "varchar":					
					$fieldText = '`'.$field['dbfield'].'` VARCHAR('.$field['length'].') NOT NULL';
					break;
					
				case "timestamp":					
					$fieldText = '`'.$field['dbfield'].'` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP';
					break;
					
				case "date":					
					$fieldText = '`'.$field['dbfield'].'` DATE NOT NULL DEFAULT "0000-00-00"';
					break;
					
				case "datetime":					
					$fieldText = '`'.$field['dbfield'].'` DATETIME NOT NULL DEFAULT "0000-00-00 00:00:00"';
					break;
					
				case "text":					
					$fieldText = '`'.$field['dbfield'].'` TEXT NOT NULL';
					break;
				
			}
		
		
		$mysqlText = 'ALTER TABLE `'.$name.'` ADD '.$fieldText.'';
		
		return $this->db->query($mysqlText);
		
		
	}
	
}

/* End of file cms.php */
/* Location: ./application/controllers/cms.php */