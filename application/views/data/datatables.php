

<a href="#" style="float:right;" class="iconButton randomButton" data-tablename="<?=$tablename?>" data-subid="<?=$subid?>"><div>Pick Random <div class="checkicon"></div></div></a>
<a href="#" style="float:right; margin-right:15px;" class="iconButton csvButton" data-tablename="<?=$tablename?>" data-subid="<?=$subid?>"><div>Download CSV <div class="downicon"></div></div></a>


<table id="listings" class="display" cellpadding=0 cellspacing=0 border=0 data-tablename="<?=$tablename?>" data-subid="<?=$subid?>">
	<thead>
		<tr>
        <?PHP
				
		foreach ($fields->field as $field) {
           if (isset($field['datadisplay']) && $field['datadisplay'] != "none") {
											
					echo '<th>'.$field['name'].'</th>
					';
					
			}
		}
		if ($fields['crop'] == "true" || $fields['approval'] == "true") { echo '<th></th>'; }
		?>
		</tr>
	</thead>
	<tbody>
						
	
	<?PHP
			
		foreach ($data as $row) {
				
				echo '<tr>';
				
				foreach ($fields->field as $field) {
				   if (isset($field['datadisplay']) && $field['datadisplay'] != "none") {
													
													
								$db =  (string)$field['dbfield'];
													
								$list = explode("=",$field['datadisplay']);
													
								switch ($list[0]) {
															
									case "full":
									echo '<td>'.$row[$db].'</td>';
									break;
												
									case "image":
									$image = $row[$db];
									echo '<td><div class="tableimage"><img src="'.$row[$db].'" border="0" /></div></td>';
									break;				
															
									case "truncate":
									$string = (string)$row[$db];												
									if (strlen($string) > $list[1]) {									
										$string = preg_replace('/\s+?(\S+)?$/', '', substr(	$string , 0, $list[1]));
									}
									echo '<td>'.$string.'</td>';
									break;
									
									
									case "yesno":
									echo '<td>'.(((int)$row[$db] == 0) ? 'No' : 'Yes').'</td>';
									break;
														
								}						
					}
				}
				
					if ($fields['crop'] == "true") {
					
						echo '<td><a data-image="'.$image.'" data-id="'.$row['id'].'" href="#" class="cropLink">Crop and Add to Site</a></td>';				
						
					}
					
					if ($fields['approval'] == "true") {
					
						echo '<td><a data-id="'.$row['id'].'" data-table="'.$fields['name'].'" href="#" class="approveLink">Review</a></td>';				
						
					}
				
				
				echo '</tr>
				';
		}
	?>
    
    
    </tbody>
	<tfoot>
		<tr>
			<?PHP
				
		foreach ($fields->field as $field) {
           if (isset($field['datadisplay']) && $field['datadisplay'] != "none") {
											
					echo '<th></th>
					';
					
					
			}
		}
		if ($fields['crop'] == "true" || $fields['approval'] == "true") { echo '<th></th>'; }
		?>			
		</tr>
	</tfoot>
</table>