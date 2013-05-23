<div class="ContentHeader"> 
	<h2 class="icon">News and Press<div class="newsicon"></div></h2>
    
    <div id="FollowUs">Follow Us</div>
    <ul id="FollowLinks">
    	<li><a href="https://twitter.com/#!/adaptv" target="_blank" class="twitterLink">Twitter</a></li>
    	<li><a href="http://www.linkedin.com/company/adap-tv" target="_blank" class="linkedLink">Linked-in</a></li>
    	<li class="last"><div class="ourblog">Our Blog</div>
        <a href="http://blog.adap.tv/" target="_blank" class="blogLink">The Video Wire</a></li>
    </ul>    
</div>
<div class="contentpadding">
    <a href="<?=site_url('news/')?>" class="arrowButton newsback">Back to Archive</a>
    <h5 class="articleTitle"><?=$articledata['title']?></h5>
    
    <div class="article">
        <h6><?=(($articledata['location']) ? ''.$articledata['location'].' - ' : '').(($articledata['date'] != '0000-00-00') ? date('F j, Y',strtotime($articledata['date'])) : '')?></h6>
        
        <?=$articledata['text']?>
    </div>    
</div>