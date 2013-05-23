<div class="FIleList columns" title="<?PHP echo $path; ?>">   
<?PHP

	foreach ($fileList as $file) {
			if ($file!='.' && $file!='..') {								
				if (is_dir($fullpath.$file)) {
					echo '<div class="filecolumn dir16 directory" title="'.$path.$file.'">'.$file.'</div>';
				} else {
					echo '<div class="filecolumn '.pathinfo($file,PATHINFO_EXTENSION).'16" title="'.$path.$file.'">'.$file.'</div>';
				}
			}
		}
?>
</div>