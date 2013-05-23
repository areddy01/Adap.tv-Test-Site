<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  
  	<meta name="keywords" content=" video,video advertising,online video marketplace, open platform, video ad serving, ad campaign managment" />
	<meta name="description" content="Adap.tv Powering Video Advertising" />
	<meta name="author" content="Adap.tv" />
	<meta name="robots" content="all" />
	<meta name="geo.region" content="US-CA" />
	<meta name="geo.placename" content="San Mateo" />
	<meta name="geo.position" content="37.551441;-122.291435" />
	<meta name="ICBM" content="37.551441, -122.291435" />
  
  <title>Adap.TV</title>
  <link rel="icon" type="image/png" href="<?=site_url('favicon.ico')?>">
  <script type="text/javascript" src="//fast.fonts.com/jsapi/e905bca5-ade6-4347-b44e-b5369ce702b2.js"></script>
  <script src="<?PHP echo site_url('js/libs/modernizr.custom.69805.js'); ?>"></script>
  <link rel="stylesheet" type="text/css" href="<?PHP echo site_url('/styles/css/internalpage.css'); ?>" />
  <?PHP if ($section == 'internal') { echo '<link rel="stylesheet" type="text/css" href="'.site_url('/styles/css/internal.css').'" />
  <link type="text/css" rel="Stylesheet" href="'.site_url('/styles/css/jquery.validity.css').'" />'; } ?>
  <script src="<?=site_url('js/libs/swfobject.js')?>"></script>
  <script src="<?=site_url('js/jwplayer/jwplayer.js')?>"></script>
</head>
<body>
<div id="Header">
    <div class="headerShadow"></div>
	<div id="HeaderMain">
		<a id="MainLogo" href="<?=site_url()?>"><h1>Adapt.TV</h1></a>
        <ul id="TopNav">
        	<li class="divider"><a class="OverlayLink" href="<?=site_url('privacy')?>">Privacy Policy</a></li>
            <li><a class="OverlayLink" href="<?=site_url('optout')?>">Opt-out</a></li>
        </ul>        
        <a id="LoginButton" target="_blank" href="https://my.adap.tv/osclient/">Login</a>
        <?PHP $this->load->view('pages/mainnav',array('section'=>$section,'page'=>$page)); ?>
	</div>
</div>
<div id="Main">
	<div id="ContentWrapper">    	
        <?PHP if (isset($crumbs)) { 
			echo '<ul id="crumbs">';
			foreach ($crumbs as $key => $value) {				
				if ($value) {
				echo '<li><a href="'.site_url($value).'">'.$key.'</a></li>';
				} else {
				echo '<li class="selected"><span>'.$key.'</span></li>';
				}
			}
			echo '</ul>';		
		 } ?>
        <div id="Content">
