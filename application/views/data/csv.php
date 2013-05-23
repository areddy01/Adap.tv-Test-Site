<?PHP			
$csvrow = array();
foreach ($fields->field as $field) {
	if (isset($field['datadisplay']) && $field['datadisplay'] != "none") {
		$csvrow[] = "\"".$field['name']."\"";
	}
}    
$info = implode(",",$csvrow)."\n";	
foreach ($data as $row) {
	$csvrow = array();
	foreach ($fields->field as $field) {
	   if (isset($field['datadisplay']) && $field['datadisplay'] != "none") {							
			$db =  (string)$field['dbfield'];	
			
			$list = explode("=",$field['datadisplay']);
													
			switch ($list[0]) {
				
				case "yesno":
				$csvrow[] = "\"".(((int)$row[$db] == 0) ? 'No' : 'Yes')."\"";
				break;
												
				default:
				$csvrow[] = "\"".str_replace('"', '""', $row[$db])."\"";
				break;									
			}									
		}
	}			
	$info .= implode(",",$csvrow)."\n";
}
echo $info;