<?=(($overlay == false) ? '<div class="contentpadding">' : '<div id="OverlayContent">
    <div id="OverlayWindow">')?>
    	<h4 id="UpfrontHeader">Upfront Marketplace</h4>
        <?=(($overlay == false) ? '' : '<a class="closeButton" href="#">Close</a>')?>     
        <div id="VideoWindowLarge">
        	<video id="myVideo" controls preload="none" width="720" height="404" poster="<?=site_url('styles/images/homepage/preview.jpg')?>">
                <source src="<?=site_url('videos/Adaptv_epipheo_compressed.mp4')?>" type='video/mp4'>
                <source src="<?=site_url('videos/Adaptv_epipheo_compressed.ogv')?>" type='video/ogg'>
                <source src="<?=site_url('videos/Adaptv_epipheo_compressed.webm')?>" type='video/webm'>
            </video>
            
            <script type="text/javascript">
              jwplayer("myVideo").setup({
				'image': '<?=site_url('styles/images/homepage/preview.jpg')?>',
				'dock': 'true',
				'plugins': {
				   'tweetit-1': {
					   'tweetit.link': 'http://twitter.com/#!/adaptv'
				   },
				   "gapro-2": {}
				},
                'modes': [
                    { type: 'flash', src: '<?=site_url('js/jwplayer/player.swf')?>' }
                ]
              });
            </script>
            
            
        </div>
	<?=(($overlay == false) ? '</div>' : '</div>   
</div>')?>
<script src="<?=site_url('js/libs/video.min.js')?>"></script>