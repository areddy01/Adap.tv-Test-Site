 			<div class="padding20 archivePadding">
            		<?PHP if (isset($pageTitle)) { ?>            
                    <h3 class="archiveHeader" data-sectionname="<?=$sectionname?>" data-pagename="<?=$pagename?>" data-type="<?=$contentType?>"><?=$pageTitle?></h3>
                    <div class="archiveDivider"></div>
                    <div id="archiveAdd"></div>
                    <?PHP } ?>
                    
                    <a href="#" class="iconButton addButton<?PHP echo ((count($fieldinfo) == 1) ? ' nodrop' : ' typesdrop'); ?>"<?PHP echo ((isset($parentid)) ? ' data-parentid="'.$parentid.'"' : '').((count($fieldinfo) == 1) ? ' data-tablename="'.$tablename.'"' : ' data-dropdown="#typesDrop"'); ?> data-sectionname="<?=$sectionname?>" data-pagename="<?=$pagename?>">
                    	<div>Add <?=$contentType?><div class="plusicon"></div></div>                    
                    </a>
                    <div id="typesDrop" class="dropWrapper">
                    	<div class="dropTop">Add <?=$contentType?><div class="plusicon"></div></div>
                        <ul class="buttonDrop">
                        <?PHP
						
						$i = 0;
						foreach ($fieldinfo as $info) {
						
							if ($options[$i]['display'] != "hidden") {
                            	echo '<li><a href="#" class="addButton" data-tablename="'.$info['tablename'].'" data-sectionname="'.$sectionname.'" data-pagename="'.$pagename.'">'.$options[$i]['type'].'</a></li>';
							}
							$i++;
						}
						?>
                        </ul> 
                    </div>        	
                                    
                    <h4 class="onlineHeader">online <?=$contentType?></h4>
                    <div id="MainListWrapper">
						<div class="page_navigation"></div>
                                
                    <ul class="MainContentList content <?=$sortType?>sort">                    
                    <?PHP					
						$i = 1;
						foreach ($onlineResults as $result) {
							
							foreach ($result as $row) {
                    		
								echo '<li data-tablename="'.$row['tablename'].'" data-id="'.$row['id'].'" id="'.$row['tablename'].'_'.$row['id'].'"'.(($fieldinfo[$row['tablename']]['static'] == "true") ? ' class="static"' : '').'>
									'.(($sortType == "manual") ? '<div class="grab"></div>' : '<div class="live"></div>').'
									';
									
									if ($pagename == 'homepage') {
										
										switch ($row['sortorder']) {
											
											case 1:
											$label = "Visible: left";
											break;
											
											case 2:
											$label = "Visible: center";
											break;
											
											case 3:
											$label = "Visible: right";
											break;
											
											default:
											$label = "Invisible: drag into top 3 to make live";
											break;
										}
										
										echo '<div class="datelabel">'.$label.'</div>';
									}
									
									foreach ($fieldinfo[$row['tablename']]->field as $field) {									
										if (isset($field['listdisplay']) && $field['listdisplay'] != "none") {
											
											
											$db = (string)$field['dbfield'];
											
											$list = explode("=",$field['listdisplay']);
											
											switch ($list[0]) {
												
												case "datelabel":
												echo '<div class="datelabel">'.date('F j, Y', strtotime($row[$db])).'</div>';
													break;
													
												case "image":
												echo '<div class="image"><img src="'.$row[$db].'" border="0" /></div>';
													break;
													
												case "order":
												echo '<div class="order">'.$row[$db].'</div>';
													break;
													
													
												case "full":
												echo '<div class="full">'.$row[$db].'</div>';
													break;
													
													
												case "truncate":
												$string = (string)$row[$db];												
												if (strlen($string) > $list[1]) {									
													$string = preg_replace('/\s+?(\S+)?$/', '', substr(	$string , 0, $list[1])).'...';
												}
												echo '<div class="full">'.$string.'</div>';
													break;
												
											}
											
										}
									}
									
									echo (($row['tablename'] == 'articleplaceholder') ? '' : '<div class="OffSwitch"></div>').'									
									<div class="selectedArrow"><div class="innerArrow"><div class="innerRedArrow"></div></div></div>
								</li>';
						
								
							
							}
							$i++;
						}
				    ?>     	
                    </ul>
                    </div>
                    <?PHP 
						if ($i == 1) {
                    
							echo '<div class="empty">Online content is currently empty.</div>';
					
						}
					?>                    
                    <div class="archiveDivider clear"></div>
                    <h4 class="offlineHeader">offline <?=$contentType?></h4>
                  	
                    <div id="OfflineListWrapper">  
                    	
						<div class="page_navigation"></div>
                    <ul class="OfflineContentList content">   
                    <?PHP					
						$i = 1;
						foreach ($offlineResults as $result) {
							
							foreach ($result as $row) {
								
								$this->load->view('editor/offline',array('row' => $row,'fieldinfo' => $fieldinfo[$row['tablename']]) );
							
							}
							$i ++;
						}
				    ?>   	
                    </ul>
                    <?PHP 
						if ($i == 1) {
                    
							echo '<div class="empty">Offline content is currently empty.</div>';
					
						}
					?> 
                    </div>
                    
                    <div class="clear"></div>
               </div> 