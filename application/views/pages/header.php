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
  <link rel="stylesheet" type="text/css" href="<?PHP echo site_url('/styles/css/page.css'); ?>" />
  <?PHP if ($section == 'internal') { echo '<link rel="stylesheet" type="text/css" href="'.site_url('/styles/css/internal.css').'" />
  <link type="text/css" rel="Stylesheet" href="'.site_url('/styles/css/jquery.validity.css').'" />'; } ?>
  <script src="<?=site_url('js/libs/swfobject.js')?>"></script>
  <script src="<?=site_url('js/jwplayer/jwplayer.js')?>"></script>
  <!-- SLIDER ASSETS -->

<link rel="stylesheet" href="<?PHP echo site_url('/styles/css/layerslider/layerslider.css'); ?>" type="text/css">
		<!-- <link rel="stylesheet" href="../assets/css/style.css" type="text/css"> -->

<script src="<?=site_url()?>/js/layerslider/jQuery/jquery.js" type="text/javascript"></script>
		<script src="<?=site_url()?>/js/layerslider/jQuery/jquery-easing-1.3.js" type="text/javascript"></script>
		<script src="<?=site_url()?>/js/layerslider/jQuery/jquery-transit-modified.js" type="text/javascript"></script>
		<script src="<?=site_url()?>/js/layerslider/js/layerslider.transitions.js" type="text/javascript"></script>
		<script src="<?=site_url()?>/js/layerslider/js/layerslider.kreaturamedia.jquery.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$.noConflict();
				$('#layerslider').layerSlider({
					skinsPath : 'styles/css/layerslider/skins/',
					skin : 'fullwidth',
					thumbnailNavigation : 'hover',
					hoverPrevNext : false,
					responsive : false,
					responsiveUnder : 960,
					sublayerContainer : 960,
					navPrevNext : false,
					navStartStop : false,
					thumbnailNavigation : 'disabled',
					showBarTimer : false,
					showCircleTimer : false,
					autoStart : false,
					// globalBGImage : 'http://hk-test2.com/uploads/13681192884.jpg'

				});
			});		
		</script>
		<style type="text/css">
			

			#logogallerywrapper {
				/*background-color: #fff;*/
				/*border-top: 1px solid #ccc;*/
				width: 100%;
				height: 220px;
				
				position: relative;
				left: 0;
				top: 50%;
			}
			#logogallerycarousel {
				margin-top: 130px;
			}
			#logogallerycarousel div {
				text-align: center;
				width: 200px;
				height: 250px;
				float: left;
				position: relative;
			}
			#logogallerycarousel div img {
				border: none;
			}
			#logogallerycarousel div span {
				display: none;
			}
			#logogallerycarousel div:hover span {
				background-color: #333;
				color: #fff;
				font-family: Arial, Geneva, SunSans-Regular, sans-serif;
				font-size: 14px;
				line-height: 22px;
				display: inline-block;
				width: 100px;
				padding: 2px 0;
				margin: 0 0 0 -50px;
				position: absolute;
				bottom: 30px;
				left: 50%;
				border-radius: 3px;
			}
			
			#logogallerydonate-spacer {
				height: 100%;
			}
			#logogallerydonate {
				width: 750px;
				padding: 50px 75px;
				margin: 0 auto;
				overflow: hidden;
			}
			#logogallerydonate p, #donate form {
				margin: 0;
				float: left;
			}
			#logogallerydonate p {
				width: 650px;
			}
			#logogallerydonate form {
				width: 100px;
			}
		</style>
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


<!-- BREADCRUMBS -->
<div id="CrumbWrapperOuter">
<div id="CrumbWrapper">
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
		</div>
		</div>



<!-- START SLIDER -->

<!-- <div id="layerslider-container-fw">
	<div id="layerslider" style="width: 100%; height: 327px; margin: 0px auto; ">
		<div class="ls-layer"  style="slidedirection: right;'">
			<img src="/uploads/13681192884.jpg" border="0" class="ls-bg" alt="Slide background" />';
			<img src="/uploads/1367393443slider4_text.png" border="0" class="ls-s-1 text" style=" top:0px; left: 0px; slidedirection : fade; slideoutdirection : fade; durationin : 750; durationout : 750; easingin : easeOutQuint; fadein : 90; "/>
			<img src="/uploads/1367395985learn-more.png" border="0" class="ls-s-1 text" style=" top:335px; left: 65px; slidedirection : fade; slideoutdirection : fade; durationin : 750; durationout : 750; easingin : easeOutQuint; fadein : 90; " />
		</div>
		
	</div>

</div> -->

<!-- END SLIDER -->











	<div id="ContentWrapper">    	
        <div id="Content">
