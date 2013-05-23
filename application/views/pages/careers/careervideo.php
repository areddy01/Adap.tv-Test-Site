<?=(($overlay == false) ? '<div class="contentpadding">' : '<div id="OverlayContent">
    <div id="OverlayWindow">')?>
    	<h4>Why Adap.tv?</h4>
        <?=(($overlay == false) ? '' : '<a class="closeButton" href="#">Close</a>')?>       
        <div id="VideoWindow"> 
        	<video id="myVideo" controls preload="none" width="640" height="360" poster="<?=site_url('styles/images/careers/videoframe.jpg')?>">
            <source src="<?=secure_site_url('videos/adaptv_careers.mp4')?>" type='video/mp4'>
            <source src="<?=secure_site_url('videos/adaptv_careers.webm')?>" type='video/webm'>
            <source src="<?=secure_site_url('videos/adaptv_careers.theora.ogv')?>" type='video/ogg'>
          </video>
        
            <script type="text/javascript">
              jwplayer("myVideo").setup({
				'image': '<?=site_url('styles/images/careers/videoframe.jpg')?>',
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
