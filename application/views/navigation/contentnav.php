<ul id="MainContentNav">
<?PHP

	

	foreach ($content->content as $section) {
		
			$substring = '';
			$selected = false;	
			
		if (!isset($section['hidden']) || $section['hidden'] != "true") {
			
			if (count($section->subsections->content)) {
			
			
				foreach ($section->subsections->content as $subsection) {
			
					if (!isset($subsection['hidden']) || $subsection['hidden'] != "true") {
			
						if ($pagename == $subsection['label']) {
							$selected = true;
							$substring .= '<li><a href="/cms/editcontent/'.$section['label'].'/'.$subsection['label'].'/" class="selected">'.$subsection->name.'<div class="selectedArrow"><div class="innerArrow"></div></div></a></li>
							';
						} else {
							
							$substring .= '<li><a href="/cms/editcontent/'.$section['label'].'/'.$subsection['label'].'/">'.$subsection->name.'</a></li>
							';
						}
					
					}
				}
				
				if ($sectionname == $section['label']) {
					$selected = true;	
				}
			
				echo '<li class="'.(($selected) ? 'selected' : 'closed').'"><a href="/cms/editcontent/'.$section['label'].'/"><span class="plus">'.(($selected) ? '' : '+').'</span> '.$section->name.'</a>
						<ul>
							'.$substring.'
						</ul>
					</li>';
			
		  } else {
			  
			  		  
				echo '<li><a'.((count($section->contentoption->subdata) > 0) ? ' data-subdata="'.$section->contentoption['sectionType'].'"' : '').' href="/cms/editcontent/'.$section['label'].'/"><span class="plus"></span> '.$section->name.'</a></li>';
		
		  }
		}
		
	}
?>
</ul>