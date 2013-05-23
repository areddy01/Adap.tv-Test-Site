<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Particle Matter CMS</title>

<link rel="stylesheet" type="text/css" href="<?PHP echo site_url('styles/css/site.css'); ?>" />

<script type="text/javascript" src="<?PHP echo site_url('js/jquery.min.js'); ?>"></script>


<script type="text/javascript">

	$(document).ready(function() {		
		$("#AccountTab").click(function () {
		  $("#AccountInfo").slideToggle("slow");
		});

	});

</script>

</head>

<body>



<div id="MainWrapper">
	<div id="AccountInfo">
    	<div class="padding10">
        	<h2>Account Information</h2>
    	</div>
    </div>
    <div id="Header">                
        <h1 id="CMSLogo">Particle Matter CMS</h1>        
    
    
    	<div id="NavBar">
            <?PHP $this->load->view('navigation/mainnav'); ?>
            <div id="NavRight">
            	<a href="">Logout</a> | <a href="">Help</a> | <a href="">Support</a>
            </div>
        </div>
        
        
    	<div id="AccountBottom"></div>
        <div id="AccountTab">
            Account Information
        </div>
	</div>
    
    <div id="InfoBar">
    
    </div>

	<div id="BodyWrapper">
    
    	
    
    	
    
    
    
    </div>
</div>


</body>
</html>
