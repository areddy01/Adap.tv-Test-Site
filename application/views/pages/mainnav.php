		<ul id="MainNav">
        	<li class="first<?=(($section == 'products') ? ' selected' : '')?>"><a class="main" href="<?=site_url('products/')?>">Products<div class="redArrow"></div><div class="rightSide"></div></a>
            	<ul>
                	<li<?=(($section == 'products' && $page == 'overview') ? ' class="selected"' : '')?>><a href="<?=site_url('products/overview/')?>"><div class="headerShadow"></div>Overview</a></li>
                    <li<?=(($section == 'products' && $page == 'platform') ? ' class="selected"' : '')?>><a href="<?=site_url('products/platform/')?>">Platform</a></li>
                    <li<?=(($section == 'products' && $page == 'marketplace') ? ' class="selected"' : '')?>><a href="<?=site_url('products/marketplace/')?>">Marketplace</a></li>
                </ul>
            </li>
            <li<?=(($section == 'solutions') ? ' class="selected"' : '')?>><a class="main" href="<?=site_url('solutions/')?>">Solutions<div class="redArrow"></div><div class="rightSide"></div></a>
            	<ul>
                	<li<?=(($section == 'solutions' && $page == 'overview') ? ' class="selected"' : '')?>><a href="<?=site_url('solutions/overview/')?>"><div class="headerShadow"></div>Overview</a></li>
                    <li<?=(($section == 'solutions' && $page == 'agencies') ? ' class="selected"' : '')?>><a href="<?=site_url('solutions/agencies/')?>">Agencies</a></li>
                    <li<?=(($section == 'solutions' && $page == 'tradingdesks') ? ' class="selected"' : '')?>><a href="<?=site_url('solutions/tradingdesks/')?>">Trading Desks</a></li>
                    <li<?=(($section == 'solutions' && $page == 'publishers') ? ' class="selected"' : '')?>><a href="<?=site_url('solutions/publishers/')?>">Publishers</a></li>
                    <li<?=(($section == 'solutions' && $page == 'adnetworks') ? ' class="selected"' : '')?>><a href="<?=site_url('solutions/adnetworks/')?>">Ad Networks</a></li>
                </ul>
            </li>
            <li<?=(($section == 'company') ? ' class="selected"' : '')?>><a class="main" href="<?=site_url('company/')?>">Company<div class="redArrow"></div><div class="rightSide"></div></a>
            	<ul>
                	<li<?=(($section == 'company' && $page == 'overview') ? ' class="selected"' : '')?>><a href="<?=site_url('company')?>"><div class="headerShadow"></div>Leadership</a></li>
                    <li<?=(($section == 'company' && $page == 'news') ? ' class="selected"' : '')?>><a href="<?=site_url('news/')?>">News</a></li>
                </ul>
            </li>
            <li<?=(($section == 'careers') ? ' class="selected"' : '')?>><a class="main" href="<?=site_url('careers/')?>">Careers<div class="redArrow"></div><div class="rightSide"></div></a>
            	<ul>
                	<li<?=(($section == 'careers' && $page == 'overview') ? ' class="selected"' : '')?>><a href="<?=site_url('careers/overview/')?>"><div class="headerShadow"></div>Overview</a></li>
                    <li<?=(($section == 'careers' && $page == 'engineering') ? ' class="selected"' : '')?>><a href="<?=site_url('careers/engineering/')?>">Engineering</a></li>
                    <li<?=(($section == 'careers' && $page == 'openings') ? ' class="selected"' : '')?>><a href="<?=site_url('careers/openings/')?>">Openings</a></li>
                </ul>
            </li>      
            <li<?=(($section == 'contact') ? ' class="selected"' : '')?>><a class="main" href="<?=site_url('contact/')?>">Contact<div class="rightSide"></div></a></li>
            <li class="last"><a class="main" target="_blank" href="http://blog.adap.tv/">Blog<div class="rightSide"></div></a></li>        
        </ul>