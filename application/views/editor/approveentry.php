<div class="preview">
    <div class="overlayText">   
    	<a href="#" class="overlaycancel iconButton" style="position:absolute;right:0px;"><div>Cancel<div class="crossicon"></div></div></a>
    </div>
    
	
    <div class="overlayText">    
    
    			<div class="leftColumn">
                    <div class="photoWindow">
                       <img src="<?=$data['user_image']?>" border="0" />
                    </div>
                </div>
                <div class="rightColumn">
                	<h4><?=$data['fname']?> <?=$data['lname']?></h4>
                	<h5><?=$data['citystate']?>, <?=$data['model']?></h5>
           			<div class="content">
                    	<?=$data['whylove']?>
                    </div>
           	    </div>
      
    </div>    
    
    <div class="overlayText">   
    	<a href="#" class="submitForm iconButton approveEntryLink" style="position:absolute;left:0px;" data-table="<?=$table?>" data-id="<?=$id?>"><div>Approve Entry<div class="checkicon"></div></div></a>
    	<a href="#" class="submitForm iconButton denyEntryLink" style="position:absolute;right:0px;" data-table="<?=$table?>" data-id="<?=$id?>"><div>Deny Entry<div class="crossicon"></div></div></a>
    </div>
    
</div>