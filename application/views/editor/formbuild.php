<div class="padding50_0">
<form name="<?=(($subform==NULL) ? '' : 'Sub')?>Content" id="<?=(($subform==NULL) ? '' : 'Sub')?>Content" method="POST" action="<?=secure_site_url('/preview/createpreview/').$fields['preview']?>" target="previewContent">
<input type="hidden" name="pagename" value="<?PHP echo $pagename; ?>" />
<input type="hidden" name="sectionname" value="<?PHP echo $sectionname; ?>" />
<input type="hidden" name="tablename" value="<?PHP echo $tablename; ?>" />
<input type="hidden" name="id" value="<?PHP echo $id; ?>" />

<?PHP
	foreach ($fields->field as $field) {		
	
		if ($field['name']) {			
?>                
                <div class="fieldgroup">
            		<div class="fieldgrouppadding">
                    	<label><?PHP echo $field['name']; ?></label>
                        <div class="fieldpadding">                            
                      
                      <?PHP
                            							
							$type = explode("=",$field['fieldtype']);							
							$db = (string)$field['dbfield'];
							
							$default = (string)$field->default;
							
							
                            switch ($type[0]) {
								
								case "text":
                          		echo '<input'.(($field['required'] == "true") ? ' class="required"' : '').' type="text" name="'.$field['dbfield'].'" maxlength="'.(($field['length']) ? $field['length'] : '255').'" value="'.form_prep(((isset($data[0][$db])) ? $data[0][$db] : $default)).'" />';					
									break;  
									
								case "date":
                          		echo '<input class="date'.(($field['required'] == "true") ? ' required' : '').'" type="text" name="'.$field['dbfield'].'" maxlength="'.(($field['length']) ? $field['length'] : '255').'" value="'.form_prep((($data[0][$db]) ? $data[0][$db] : $default)).'" />';					
									break;
									
								case "datetime":
                          		echo '<input class="datetime'.(($field['required'] == "true") ? ' required' : '').'" type="text" name="'.$field['dbfield'].'" maxlength="'.(($field['length']) ? $field['length'] : '255').'" value="'.form_prep((($data[0][$db]) ? $data[0][$db] : $default)).'" />';					
									break;  
							          	
								
								case "multiline":
                          		echo '<textarea class="'.(($field['required'] == "true") ? 'required' : '').''.(($field['max-length']) ? ' limit' : '').'"'.(($field['max-length']) ? ' data-charlimit="'.$field['max-length'].'"' : '').' name="'.$field['dbfield'].'" rows="'.(($field['length']) ? $field['length'] : '2').'">'.(($data[0][$db]) ? $data[0][$db] : $default).'</textarea>'.(($field['max-length']) ? '<strong>Characters remaining:</strong> <span class="charsLeft_'.$field['dbfield'].'"></span>' : '');					
									break;
									
								case "html":
                          		echo '<textarea class="tinymce'.(($field['required'] == "true") ? ' required' : '').'" name="'.$field['dbfield'].'" rows="'.(($field['length']) ? $field['length'] : '2').'">'.(($data[0][$db]) ? $data[0][$db] : $default).'</textarea>';					
									break;
								
								case "file":
                          		echo '<div class="imageUpload"> 
										<input type="hidden" name="'.$field['dbfield'].'" value="'.(($data[0][$db]) ? $data[0][$db] : $default).'">                     	
										<div class="uploadButton"></div>
										<div class="thumbnail"><img src="'.(($data[0][$db]) ? $data[0][$db] : $default).'" border="0" /></div>
									 </div>';					
									break;
								
								case "checkbox":
                          		echo '<input type="checkbox" name="'.$field['dbfield'].'" '.(($data[0][$db]) ? ' checked' : '').' value="1" />';					
									break;
									
								case "select":
                          		echo '<select'.(($field['required'] == "true") ? ' class="required"' : '').' name="'.$field['dbfield'].'">';
								
										foreach ($field->option as $option) {											
											echo '<option value="'.$option['value'].'"'.(($data[0][$db] == '') ? (($option['default'] == "true") ? ' selected' : '') : (($option['value'] == $data[0][$db]) ? ' selected' : '')).'>'.(string)$option.'</option>';
										}
								
								
										if (count($field->optionstable) > 0) {		
																			
											$name = (string)$field->optionstable['table'];
											
											foreach ($options[$name] as $row) {
												
												$val = (string)$field->optionstable['valuefield'];
												$label = (string)$field->optionstable['labelfield'];
												
												echo '<option value="'.$row[$val].'"'.(($row[$val] == $data[0][$db]) ? ' selected' : '').'>'.$row[$label].'</option>';
											}					
											
										}
								
								echo '</select>';					
									break;
									
                                           
							}
							
					   ?>
                            
                        </div>
                    </div>
            	</div>
                
<?PHP }

 } ?>

	<div class="formDivider"></div>
    
    
<?PHP 
	if (count($fields->subtypes)) {
		foreach ($subdata as $subtype) {	
		
			echo '<div class="subArchive" data-parentid="'.$id.'" data-tablename="'.$subtype['name'].'"></div>
			<div class="formDivider"></div>';
		
		}
	}
?>						
							
	
    <a href="#" class="<?=(($subform==NULL) ? 'previewButton' : 'subSaveButton')?> iconButton" data-sectionname="<?PHP echo $sectionname; ?>" data-pagename="<?PHP echo $pagename; ?>"><div><?=(($subform==NULL) ? 'Preview' : 'Save')?><div class="<?=(($subform==NULL) ? 'checkicon' : 'plusicon')?>"></div></div></a>
</form>
</div>