		<ul id="SubNav" class="products">
        	<li class="first<?=(($page == 'overview') ? ' selected' : '')?>"><a href="<?=site_url('products/')?>">Overview</a><div class="selectedArrow"></div></li>
            <li<?=(($page == 'platform') ? ' class="selected"' : '')?>><a href="<?=site_url('products/platform/')?>">Platform</a><div class="selectedArrow"></div></li>
            <li<?=(($page == 'marketplace') ? ' class="selected"' : '')?>><a href="<?=site_url('products/marketplace/')?>">Marketplace</a><div class="selectedArrow"></div></li>
        </ul>