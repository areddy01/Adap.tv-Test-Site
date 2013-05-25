
<div class="contentpadding">

	<div class="paginate">
    	<?PHP		
				
				if ($totalpages > 1) {					
					if ($pagenum > 1) {
						echo '<a href="'.site_url('news/'.($pagenum-1)).'" class="prevlink">Prev</a> ';
					}
					$pagestart = (($pagenum - 2 < 1) ? 1 : $pagenum - 2);					
					
					$navs = (($pagestart + 5 <= $totalpages) ? $pagestart + 5 : $totalpages);
					
					for ($i = $pagestart; $i <= $navs; $i++) {
						
						if ($i == $pagenum) {
							echo '<span class="selected">'.$i.'</span> ';
						} else {					
							echo '<a href="'.site_url('news/'.$i).'">'.$i.'</a> ';
						}
					}
					
					if ($navs < $totalpages) {						
						echo '... <a href="'.site_url('news/'.$totalpages).'">'.$totalpages.'</a> ';
					}
					
					if ($pagenum < $totalpages) {
						echo '<a href="'.site_url('news/'.($pagenum+1)).'" class="nextLink">Next</a>';
					}
				}
			?>
    
    </div>

	<div id="NewsBox">
    	<?PHP
            
			
	foreach ($newsdata as $news) {	
      
	  echo  '<div class="newsitem">
				<div class="dateBox">
					<div class="month">'.date('F',strtotime($news['date'])).'</div>
					<div class="day">'.date('j',strtotime($news['date'])).'</div>
					<div class="year">'.date('Y',strtotime($news['date'])).'</div>
				</div>
				<div class="titlebox">
					<h5 class="type">'.$news['author'].'</h5>
					<a target="_blank" href="'.(($news['link']) ? $news['link'] : site_url('articles/'.$news['id'])).'">'.$news['title'].'</a>
				</div>
        	</div>  ';
		
			}
	?>
	</div>    
    
    <div class="paginate">
    	<?PHP		
				
				if ($totalpages > 1) {					
					if ($pagenum > 1) {
						echo '<a href="'.site_url('news/'.($pagenum-1)).'" class="prevlink">Prev</a> ';
					}
					$pagestart = (($pagenum - 2 < 1) ? 1 : $pagenum - 2);					
					
					$navs = (($pagestart + 5 <= $totalpages) ? $pagestart + 5 : $totalpages);
					
					for ($i = $pagestart; $i <= $navs; $i++) {
						
						if ($i == $pagenum) {
							echo '<span class="selected">'.$i.'</span> ';
						} else {					
							echo '<a href="'.site_url('news/'.$i).'">'.$i.'</a> ';
						}
					}
					
					if ($navs < $totalpages) {						
						echo '... <a href="'.site_url('news/'.$totalpages).'">'.$totalpages.'</a> ';
					}
					
					if ($pagenum < $totalpages) {
						echo '<a href="'.site_url('news/'.($pagenum+1)).'" class="nextLink">Next</a>';
					}
				}
			?>
    
    </div>
    
    
    <div class="clear"></div>

</div>