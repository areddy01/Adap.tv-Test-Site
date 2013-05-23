 			<div class="padding20">
            		<?PHP if (isset($pageTitle)) { ?>            
                    <h3 class="archiveHeader" data-sectionname="<?=$sectionname?>" data-pagename="<?=$pagename?>" data-type="<?=$contentType?>"><?=$pageTitle?></h3>
                    <div class="archiveDivider"></div>
                    <div id="archiveAdd"></div>
                    <?PHP } ?>
                      
                    <h4 class="onlineHeader">online <?=$contentType?></h4>                    
                    <ul class="MainContentList <?=$sortType?>sort">                    
                    <?PHP					
						$i = 1;
						foreach ($onlineResults as $result) {
							
							foreach ($result as $row) {
                    		
								echo '<li data-tablename="'.$fieldinfo[$i-1]['tablename'].'" data-id="'.$row['id'].'" id="'.$fieldinfo[$i-1]['tablename'].'_'.$row['id'].'">
									'.(($sortType == "manual") ? '<div class="grab"></div>' : '<div class="live"></div>').'
									';
									
									
									foreach ($fieldinfo[$i-1]->field as $field) {									
										if (isset($field['listdisplay']) && $field['listdisplay'] != "none") {
											
											
											$db =  (string)$field['dbfield'];
											
											$list = explode("=",$field['listdisplay']);
											
											switch ($list[0]) {
												
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
													$string = preg_replace('/\s+?(\S+)?$/', '', substr(	$string , 0, $list[1]));
												}
												echo '<div class="full">'.$string.'</div>';
													break;
												
											}
											
										}
									}
									
									echo ''.((count($result) > 1) ? '<div class="OffSwitch"></div>' : '').'									
									<div class="selectedArrow"><div class="innerArrow"><div class="innerRedArrow"></div></div></div>
								</li>';
						
								
							
							}
							$i++;
						}
				    ?>     	
                    </ul>
                    <?PHP 
						if ($i == 1) {
                    
							echo '<div class="empty">Online content is currently empty.</div>';
					
						}
					?>                    
                    <div class="archiveDivider clear"></div>
                    <h4 class="offlineHeader">offline <?=$contentType?></h4>
                    
                    <ul class="OfflineContentList">   
                    <?PHP					
						$i = 1;
						foreach ($offlineResults as $result) {
							
							foreach ($result as $row) {
								
								echo '<li data-tablename="'.$fieldinfo[$i-1]['tablename'].'" data-id="'.$row['id'].'">';
									$displayfield = FALSE;
                    				foreach ($fieldinfo[$i-1]->field as $field) {									
										if (isset($field['listdisplay']) && $field['listdisplay'] != "none") {
													
											$db =  (string)$field['dbfield'];
											$list = explode("=",$field['listdisplay']);
											
											switch ($list[0]) {
																								
												case "image":
												echo '<div class="image"><img src="'.$row[$db].'" border="0" /></div>';
													break;
													
												case "order":
													break;
													
												case "full":
												$displayfield = TRUE;
												echo '<div class="full">'.$row[$db].'</div>';
													break;
													
												case "truncate":
												$displayfield = TRUE;
												$string = (string)$row[$db];												
												if (strlen($string) > $list[1]) {									
													$string = preg_replace('/\s+?(\S+)?$/', '', substr(	$string , 0, $list[1]));
												}
												echo '<div class="full">'.$string.'</div>';
													break;
												
											}											
										}
										if ($displayfield) {
											break;	
										}
									}
									
									echo '<div class="OnSwitch"><input type="checkbox" checked="checked" name="active" value="1" /></div>
									<div class="selectedArrow"><div class="innerArrow"><div class="innerRedArrow"></div></div></div>
								</li>';
							
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
                    
                    <div class="clear"></div>
               </div> 