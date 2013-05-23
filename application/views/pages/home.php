<div id="Carousel">
	<div id="SlideContainer">   
        <div class="ContainerLayer" id="Backgrounds">
        	<?PHP 
				foreach ($carousel["onlineResults"] as $slide) {
           			echo '<div class="SlideLayer" data-time="'.$slide['displaytime'].'"><img src="'.$slide['bgimage'].'" border="0" /></div>';
				}
			?>  
        </div>
        <div class="ContainerLayer" id="Layer1">
            <?PHP 
				foreach ($carousel["onlineResults"] as $slide) {
           			echo '<div class="SlideLayer">'.((isset($slide['layer1image'])) ? '<img src="'.$slide['layer1image'].'" border="0" />' : '').'</div>';
				}
			?>
        </div>
        <div class="ContainerLayer" id="Layer2">
            <?PHP 
				foreach ($carousel["onlineResults"] as $slide) {
           			echo '<div class="SlideLayer">'.((isset($slide['layer2image'])) ? '<img src="'.$slide['layer2image'].'" border="0" />' : '').'</div>';
				}
			?>
        </div>
        <div class="ContainerLayer" id="Layer3">
            <?PHP 
				foreach ($carousel["onlineResults"] as $slide) {
           			echo '<div class="SlideLayer">'.((isset($slide['layer3image'])) ? '<img src="'.$slide['layer3image'].'" border="0" />' : '').'</div>';
				}
			?>
        </div>
        <div class="ContainerLayer" id="Layer4">
            <?PHP 
				foreach ($carousel["onlineResults"] as $slide) {
           			echo '<div class="SlideLayer">'.((isset($slide['layer4image'])) ? '<img src="'.$slide['layer4image'].'" border="0" />' : '').'</div>';
				}
			?>
        </div>
        <div class="ContainerLayer" id="TextLayer">            
            <?PHP 
				foreach ($carousel["onlineResults"] as $slide) {
					
					if ($slide['videolink']) {
						$rect = explode(',',$slide['videohit']);
					}
					
           			echo '<div class="SlideLayer">
					'.(($slide['title']) ? '<h2>'.nl2br($slide['title']).'<br/><br/><span class="tag">'.nl2br($slide['highlighttext']).'</span></h2>' : '').'
					'.(($slide['ctatext']) ? '<a class="detailArrowButton" target="'.$slide['ctatarget'].'" href="'.$slide['ctalink'].'">'.$slide['ctatext'].'<span class="rightend"></span><span class="redarrow"></span></a>' : '').'
					'.(($slide['videolink']) ? '<a class="OverlayLink" style="left:'.trim($rect[0]).'px;top:'.trim($rect[1]).'px;width:'.trim($rect[2]).'px;height:'.trim($rect[3]).'px;" href="'.$slide['videolink'].'"><img alt="" class="VideoClick" src="http://adap.tv/styles/images/transparent.gif"></a>' : '').'
					</div>';
				}
			?>
        </div>
    </div>
	<a href="#" class="leftCarouselArrow"><span>left</span><span class="over"></span></a>
    <a href="#" class="rightCarouselArrow"><span>right</span><span class="over"></span></a>
    <div id="CarouselNav">
<?PHP 
	$i = 1;
	foreach ($carousel["onlineResults"] as $slide) {
        
    	echo '<div class="dot'.(($i == 1) ? ' selected' : '').'">
				'.$i.'
				<div class="over"></div>
			  	<div class="CarouselButton tooltip">
					<div class="tagline">('.$slide['tooltag'].')</div>
					<div class="label">'.$slide['tooltitle'].'</div>
					<div class="rightend"></div>
					<div class="toolarrow"></div>
				</div>
			  </div>';
		$i++;			
	}
?>
    </div>
</div>
<div id="HomeModules">
<?PHP
	
	$links = array();
	$targets = array();
	$ctas = array();	
	$types = array();	
							
		foreach ($content as $row) {

			if ($row['tablename'] == "articleplaceholder") {				
				array_push($links,"/news");
				array_push($targets,"_self");
				array_push($ctas,"Read More");
				array_push($types,"articleplaceholder");				
			} else {
				array_push($links,$row['ctalink']);
				array_push($targets,$row['ctatarget']);
				array_push($ctas,$row['ctatext']);
				array_push($types,$row['tablename']);
			}
			
		switch ($row['tablename']) {			
			
			case "solutionsspotlight":

				echo '<div class="homeColumn">
					<h4><a target="'.$row['ctatarget'].'" href="'.$row['ctalink'].'">'.$row['title'].'</a></h4>
					<div class="Thumb">
						<a target="_self" href="'.$row['ctalink'].'"><img alt="" src="'.$row['bgimage'].'"></a>
						<h5 class="product">'.$row['name'].'</h5>
						'.$row['position'].'
					</div>
					<div class="description">
						<p>'.$row['bio'].'</p>
					</div>
				</div>';
			break;
			
			
			case "careerbanner":
				echo '<div class="homeColumn">
						<h4><a target="'.$row['ctatarget'].'" href="'.$row['ctalink'].'">'.$row['title'].'</a></h4>    
						<div class="Thumb">
							'.((isset($row['bgimage'])) ? '<a target="'.$row['ctatarget'].'" href="'.$row['ctalink'].'"><img alt="" src="'.$row['bgimage'].'" /></a>' : '').'
						</div>
						<div class="description">
							<h5>'.$row['jobtitle'].'</h5>
							<p class="spacebottom">'.$row['description'].'</p>
							'.((isset($row['citystate'])) ? '<p>'.$row['citystate'].((isset($row['country'])) ? ',' : '').'</p>' : '').'
							'.((isset($row['country'])) ? '<p>'.$row['country'].'</p>' : '').'
						</div>
					</div>';
				break;
				
			case "leadershipbanner":

				echo '<div class="homeColumn">
					<h4><a target="'.$row['ctatarget'].'" href="'.$row['ctalink'].'">'.$row['title'].'</a></h4>
					<div class="Thumb">
						<a target="_self" href="'.$row['ctalink'].'"><img alt="" src="'.$row['bgimage'].'"></a>
						<h5>'.$row['name'].'</h5>
						'.$row['position'].'
					</div>
					<div class="description">
						<p>'.$row['bio'].'</p>
					</div>
				</div>';
			break;
			
				
			case "articleplaceholder":				
					
				echo '<div class="homeColumn last">
					<h4><a href="'.site_url('news/').'">News</a></h4>';     
				
				foreach ($newsdata as $news) {	
				  
				  echo  '<div class="homeNewsItem">
							<div class="newsDate">
								<div class="month">'.date('M',strtotime($news['date'])).'</div>
								<div class="day">'.date('j',strtotime($news['date'])).'</div>
							</div>
							<div class="newsInfo">
								<p>'.$news['title'].'</p>
								<a class="newsLink" target="_blank" href="'.(($news['link']) ? $news['link'] : site_url('articles/'.$news['id'])).'">Read More on '.$news['author'].' ></a>
							</div>
						</div>';
		
				}
				
				echo '</div>';
				
				break;
		}
	}

	?>
    <div class="clear"></div>
    <a id="leftBoxButton" class="arrowButton<?=(($types[0] == "articleplaceholder") ? ' news' : '')?>" target="<?=$targets[0]?>" href="<?=$links[0]?>"><?=$ctas[0]?></a>
    <a id="centerBoxButton" class="arrowButton<?=(($types[1] == "articleplaceholder") ? ' news' : '')?>" target="<?=$targets[1]?>" href="<?=$links[1]?>"><?=$ctas[1]?></a>
    <a id="rightBoxButton" class="arrowButton<?=(($types[2] == "articleplaceholder") ? ' news' : '')?>" target="<?=$targets[2]?>" href="<?=$links[2]?>"><?=$ctas[2]?></a>
</div>
