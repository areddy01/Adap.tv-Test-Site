
        </div>
    	<div id="Footer">
        	<div id="FooterNav">
            	<a href="<?=site_url('products/')?>">Products</a> &nbsp;&nbsp; | &nbsp;&nbsp;
                <a href="<?=site_url('solutions/')?>">Solutions</a> &nbsp;&nbsp; | &nbsp;&nbsp;
                <a href="<?=site_url('company/')?>">Company</a> &nbsp;&nbsp; | &nbsp;&nbsp;
                <a href="<?=site_url('careers/')?>">Careers</a> &nbsp;&nbsp; | &nbsp;&nbsp;
                <a href="<?=site_url('news/')?>">News</a> &nbsp;&nbsp; | &nbsp;&nbsp;
                <a href="<?=site_url('contact/')?>">Contact</a> &nbsp;&nbsp; | &nbsp;&nbsp;
                <a href="http://blog.adap.tv/" target="_blank">Blog</a> &nbsp;&nbsp; | &nbsp;&nbsp;
                <a href="http://engineering.adap.tv/" target="_blank">Engineering Blog</a>
            </div>
        	<div id="Copyright">&copy;Adap.tv &nbsp;&nbsp; | &nbsp;&nbsp; All Rights Reserved.</div>
        </div>
        <div class="leftShadow"></div>
        <div class="rightShadow"></div>
    </div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?PHP echo site_url('js/libs/jquery-1.7.1.min.js'); ?>"><\/script>')</script>
<script src="<?PHP echo site_url('js/libs/jquery.easing.js'); ?>"></script>
<script src="<?PHP echo site_url('js/pages_plugins.js'); ?>"></script>
<script src="<?PHP echo site_url('js/pages_script.js'); ?>"></script>
<?PHP if ($section == 'internal') { echo '<script type="text/javascript" src="'.site_url('js/libs/jQuery.validity.min.js').'"></script>'; } ?>

 <script type="text/javascript">
  var pageTracker;
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-4966855-1']);
  _gaq.push(['_trackPageview']);
  _gaq.push(function() {
  		pageTracker = _gat._getTrackerByName();
	});
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>


</body>
</html>
