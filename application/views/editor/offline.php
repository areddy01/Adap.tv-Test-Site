<?PHP 
							echo '<li data-tablename="'.$fieldinfo['tablename'].'" data-id="'.$row['id'].'">
									<a href="#" class="circleDeleteButton"><div>Delete</div></a>';
									$displayfield = FALSE;
                    				foreach ($fieldinfo->field as $field) {									
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
													$string = preg_replace('/\s+?(\S+)?$/', '', substr(	$string , 0, $list[1]))."...";
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
								
