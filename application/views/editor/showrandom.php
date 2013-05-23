<div class="preview">  
    
    <div class="overlayText">   
    	<a href="#" class="overlaycancel iconButton" style="float:right;"><div>Close<div class="crossicon"></div></div></a>
        <div class="clear"></div>
    </div>
    
    <div class="overlayText">    
    	<?PHP
			if (isset($error)) {
			
				echo $error;	
				
			} else {
		
				echo '<h2>'.$result['fname'].' '.$result['lname'].'</h2>Email: '.$result['email'].'<br />Zip: '.$result['zip'].'<br />Birthdate: '.date('F j, Y',strtotime($result['birthdate'])).'<br />';
    		
			}
		?>     
    </div>  
    
</div>