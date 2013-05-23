<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js">
</script>
    <script type="text/javascript">
    (function ($) {
    $.fn.truncatable = function (options) {
        var defaults = {
            limit: 100,
            more: '...',
            less: false,
            hideText: '[read less]'
        };
        options = $.extend(defaults, options);
        return this.each(function (num) {
            var stringLength = $(this).html().length;
            if (stringLength > defaults.limit) {
                var splitText = $(this).html().substr(defaults.limit);
                var splitPoint = splitText.substr(0, 1);
                var whiteSpace = new RegExp(/^\s+$/);
                for (var newLimit = defaults.limit; newLimit < stringLength; newLimit++) {
                    var newSplitText = $(this).html().substr(0, newLimit);
                    var newHiddenText = $(this).html().substr(newLimit);
                    var newSplitPoint = newSplitText.slice(-1);
                    if (whiteSpace.test(newSplitPoint)) {
                        var hiddenText = '<span class="hiddenText_' + num + '" style="display:none">' + newHiddenText + '</span>';
                        var setNewLimit = (newLimit - 1);
                        var trunkLink = $('<a>').attr('class', 'more_' + num + '');
                        $(this).html($(this).html().substr(0, setNewLimit)).append('<a class="more_' + num + '" href="#">' + defaults.more + '<a/> ' + hiddenText);
                        $('a.more_' + num).bind('click', function () {
                            $('span.hiddenText_' + num).show();
                            $('a.more_' + num).hide();
                            if (defaults.less === true) {
                                $('span.hiddenText_' + num).append('<a class="hide_' + num + '" href="" title="' + defaults.hideText + '">' + defaults.hideText + '</a>');
                                $('a.hide_' + num).bind('click', function () {
                                    $('.hiddenText_' + num).hide();
                                    $('.more_' + num).show();
                                    $('.hide_' + num).empty();
                                    return false;
                                });
                            }
                            return false;
                        });
                        newLimit = stringLength;
                    }
                }
            }
        });
    };
})(jQuery);
    
    </script>
    <script type="text/javascript">
$(function(){
     $('.bioText').truncatable({    limit: 200, more: '... <u>Full Bio<\/u>', less: true, hideText: ' <u>Hide</u>' }); 
    });
    </script>
    
    <script type="text/javascript">
$(function(){
     $('.tomBioText').truncatable({    limit: 199, more: '... <u>Full Bio<\/u>', less: true, hideText: ' <u>Hide</u>' }); 
    });
    </script>








<div id="bodyWrapper">

	<div id="leftCol"><img src="../styles/images/rsvp/london-logo.png" width="539" height="537"></div>
	
	<div id="rightCol">
	<div id="rightColInner">
	
	
	
	<h2 class="ucase" style="margin:0px 0 30px;font-size:22px">Speakers</h2>
    
    
<!--     <h3>Our Speaker Committee is finalizing our guest speakers. Please check back often for our latest speaker line-up!</h3>
 -->   

<!-- <table class="bioTableOuter">
    <tr>
        <td>
            <img src="../styles/images/rsvp/terence.jpg" width="113" height="170">
            <table class="bioTable">
        <tr>
            <td width="113"></td>

            <td>
                <h3>Terence Kawaja</h3>

                <p>Founder and CEO<br>
                LUMA Partners </p>
            </td>
            <td><img src="../styles/images/rsvp/amnet-logo.jpg"></td>

            </tr>
        </table>
        <table>
<tr>
    <td colspan="2">
                <p class="bioText" >Terence Kawaja is Founder and CEO of LUMA Partners, a strategic advisory firm focused at the intersection of media and technology. He is a seasoned investment banker with more than 20 years of experience and has advised on over $250 billion of transactions, including some of the most pivotal deals in the media and tech industries. Throughout his career, Terry has leveraged deep industry knowledge to take a strategic approach to deal making rather than chase transactions. The best compliment people say is that he thinks like a principal.

<br/><br/>
At LUMA, Terry advises both established media and technology companies as well as digital growth companies. He is a recognized expert in the Internet and digital media sectors and is a popular speaker at leading industry conferences. Terry has a straightforward style and is never afraid to tell it like it is. He also likes to keep things light by using humor to aid substantive presentations. 
<br/><br/>
Prior to founding LUMA Partners, Terry was Co-head of Digital Media at GCA Savvian; Global Head of Media M&A at Citigroup and CSFB; and CFO of publicly-traded Raindance Communications. He received an MBA from the Schulich School of Business, a JD from Osgoode Hall Law School, and a BA in Economics from the University of Western Ontario.
</p>
                <p>
            </td>
        </tr>
    </table>
</table> -->


<table style="border-collapse:collapse; width:575px;">
    <tr valign="top">
        <td><img src="../styles/images/rsvp/dirk.jpg" width="113" height="170"></td>
        <td style="padding:0px;">

            <table class="bioTable" style="border-collapse:collapse;">
                <tr>
                    <td style="display:block;"><h3>Dirk Fiebig</h3>

                        <p>Operations Director<br>
                            AMNET EMEA</p></td>
                            <td align="right" style="padding:0px";><img src="../styles/images/rsvp/amnet-logo.jpg"></td>
                        </tr>
                        <tr>

                            <td colspan="2">


                                <p class="bioText" style="padding:0px;">
                                    Dirk Fiebig is the Operations Director for AMNET EMEA.  An industry veteran, he is an expert and thought leader in programmatic trading. With over 13 years experience in ad technology and operations, his passion for technology and innovation brought him to AMNET, the Aegis Trading Desk, driving better performance and value across display, video and mobile. Dirk started trading on ad exchanges in early 2008 and has since specialised in automated data driven media buying. Today he's responsible for AMNET's technology stack, trading teams and workflow management.
                                </p>
                                
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>

      <div class="thinHrule"></div>


 <table style="border-collapse:collapse; width:575px;">
    <tr valign="top">
        <td><img src="../styles/images/rsvp/tom-b.jpg" width="113" height="170"></td>
        <td style="padding:0px;">

            <table class="bioTable" style="border-collapse:collapse;">
                <tr>
                    <td style="display:block;"><h3>Tom Bowman</h3>

                        <p>Vice President, Strategy & Operations, Global Advertising Sales
<br>
                            BBC Worldwide</p></td>
                            <td align="right" style="padding:0px";><img src="../styles/images/rsvp/bbc-logo.jpg"></td>
                        </tr>
                        <tr>

                            <td colspan="2">


                                <p class="bioText" style="padding:0px;">
                                    Tom heads up a globally based team responsible for Sales Operations, Branded Content and Custom Solutions across the BBC's international Television and Digital media services.  
 <br/><br/>
Prior to joining BBC Worldwide in 2007, Tom held a number of commercial roles at MSN including global sales strategy and heading up the EMEA, LATAM and Asian sales teams.  Before this, Tom was the launch sales director for both Yahoo! UK and Commercial Director of ZD Net UK. He has also worked on the agency side and held a number of non-executive directorships. 
 <br/><br/>
He is currently an elected Board member of IAB Europe. Tom is also a mentor on the BBC Worldwide Labs programme assisting emerging UK digital and technology companies.

                                </p>
                                
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>

      <div class="thinHrule"></div>

      <table style="border-collapse:collapse; width:575px;">
    <tr valign="top">
        <td><img src="../styles/images/rsvp/anna.jpg" width="113" height="170"></td>
        <td style="padding:0px;">

            <table class="bioTable" style="border-collapse:collapse;">
                <tr>
                    <td style="display:block;"><h3>Anna Tracey</h3>

                        <p>COO and co-founder
<br>
                            Brainient</p></td>
                            <td align="right" style="padding:0px";><img src="../styles/images/rsvp/brainient-logo.jpg"></td>
                        </tr>
                        <tr>

                            <td colspan="2">


                                <p class="bioText" style="padding:0px;">
                                    Anna is COO and co-founder of Brainient - a cross platform creative solution enabling standard video to be interactive and more engaging therefore making the most of today's connected devices.  For examples of our work, visit the Gallery
<br/><br/>
Prior to Brainient Anna worked at in-text pioneer and global leader, Vibrant Media in their offices in London, New York and Paris as Commercial VP and Sales Leader.
<br/><br/>
She is currently an active IAB member, especially within the Video Council. She recently spoke at the inaugural AdWeek EU about Brainient focusing on interactive videos within Connected TVs.
</p>
                                
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>

      <div class="thinHrule"></div>

      <table style="border-collapse:collapse; width:575px;">
    <tr valign="top">
        <td><img src="../styles/images/rsvp/ciaran.jpg" width="113" height="170"></td>
        <td style="padding:0px;">

            <table class="bioTable" style="border-collapse:collapse;">
                <tr>
                    <td style="display:block;"><h3>Ciaran O'Kane</h3>

                        <p>CEO & Founder
<br>
                            ExchangeWire</p></td>
                            <td align="right" style="padding:0px";><img src="../styles/images/rsvp/exchangewire-logo.jpg"></td>
                        </tr>
                        <tr>

                            <td colspan="2">


                                <p class="bioText" style="padding:0px;">
                                    Ciaran founded ExchangeWire, which tracks data-driven display, media buying trends and the ad tech space in the EMEA, APAC and LATAM regions, in 2009. Delving deep into the business of automated media trading and the technology that underpins it across multi-channels (online display, video, mobile and social), the site aims to keep readers upto date on all the latest news and developments.
                                    </p>
                                
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>

      <div class="thinHrule"></div>


      <table style="border-collapse:collapse; width:575px;">
    <tr valign="top">
        <td><img src="../styles/images/rsvp/fabien.jpg" width="113" height="170"></td>
        <td style="padding:0px;">

            <table class="bioTable" style="border-collapse:collapse;">
                <tr>
                    <td style="display:block;"><h3>Fabien Magalon</h3>

                        <p>Managing Director
<br>
                            La Place Media</p></td>
                            <td align="right" style="padding:0px";><img src="../styles/images/rsvp/laplacemedia-logo.jpg"></td>
                        </tr>
                        <tr>

                            <td colspan="2">


                                <p class="bioText" style="padding:0px;">Fabien Magalon has over twelve years' experience in online advertising and began his career in 2001 as Media Buyer for the UK subsidiary of the US advertising company Advertising.com. He worked from London on the creation and expansion of the French subsidiary in 2002. In November 2003 he was promoted to Media Director for Advertising.com France, based in Paris. He joined TradeDoubler France in August 2006 as Director of the Publisher Unit tasked with strengthening and developing the network of publisher partners. A year later, he was named Operations Director, France, Germany, Italy, Spain and the Netherlands, for the DRIVEpm advertising network (now part of Microsoft Media Network). In 2008 he took over as head of the EMEA Region for the Microsoft Media Network business unit. Since 2010, Fabien was Publisher Development Director at Rubicon Project in France. Fabien launched La Place Media on August 2012. Fabien, 34, is a graduate of Ecole Sup&eacute;rieure de Commerce et de Management in Bordeaux.
</p>
                                
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>

      <div class="thinHrule"></div>


<table style="border-collapse:collapse; width:575px;">
    <tr valign="top">
        <td><img src="../styles/images/rsvp/ken.jpg" width="113" height="170"></td>
        <td style="padding:0px;">

            <table class="bioTable" style="border-collapse:collapse;">
                <tr>
                    <td style="display:block;"><h3>Ken Nugent</h3>

                        <p>Sales and Business Development Manager
<br>
                            RT&Eacute; Digital</p></td>
                            <td align="right" style="padding:0px";><img src="../styles/images/rsvp/rte-logo.jpg"></td>
                        </tr>
                        <tr>

                            <td colspan="2">


                                <p class="bioText" style="padding:0px;">Ken Nugent is the Sales and Business Development Manager of RT&Eacute; Digital, part of Ireland's National Broadcaster.  RT&Eacute; Digital is responsible for delivering RT&Eacute; content on-demand to national and international audiences.
<br><br>
Ken has over 20 years commercial experience, 10 of which were in the print and online market. He has commercial responsibility for the development of RT&Eacute;.ie, RT&Eacute; Aertel, RT&Eacute; Player, RT&Eacute; Mobile and RT&Eacute; Guide.  He joined RT&Eacute; in 2003, having previously worked for Standard Life Fund Managers and Tribune Newspapers.  
 <br><br>
He is a founding member and former Chair of the Mobile Council of IAB Ireland.

</p>
                                
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>

      <div class="thinHrule"></div>
	
	
    <table style="border-collapse:collapse; width:575px;">
    <tr valign="top">
        <td><img src="../styles/images/rsvp/marco.jpg" width="113" height="170"></td>
        <td style="padding:0px;">

            <table class="bioTable" style="border-collapse:collapse;">
                <tr>
                    <td style="display:block;"><h3>Marco Bertozzi</h3>

                        <p>Executive Managing Director, EMEA
<br>
                            VivaKi</p></td>
                            <td align="right" style="padding:0px";><img src="../styles/images/rsvp/vivaki-logo.jpg"></td>
                        </tr>
                        <tr>

                            <td colspan="2">


                                <p class="bioText" style="padding:0px;">Marco started his career in TV advertising before moving into digital in 2000. A founding member of Zenith Interactive Solutions, Zenith's then digital arm, he enjoyed the highs and lows of the digital revolution, leaving Zed in 2005 as Commercial Director. After a couple of years as Marketing Director for ZenithOptimedia, Marco moved to Head of Digital for the agency in 2007.  A change of scene in 2008 saw him heading off to run media, web development, digital and Creative at TMP Worldwide. 
<br><br>
As Executive Managing Director, Marco runs VivaKi across the entire EMEA region, working alongside the VivaKi leadership team to shape and drive the future direction of the organisation. Since joining VivaKi in 2010, Marco has launched and continues to lead the EMEA strategy for addressability and has been responsible for driving the phenomenal growth of Audience on Demand, VivaKi's market-leading addressable media buying practice, across the region, ensuring it is the first, best and most secure solution of its kind in the world. Marco also leads VivaKi's Partnerships practice across EMEA and heads up The Pool in the UK, the first of its kind global innovation project to create industry alignment on advertising solutions. He is a leading authority on digital strategy and a regular conference speaker on the subject. 
<br><br>
Outside of work, his son Alexander takes up most of his time. When not running around after a very energetic Alexander, Marco likes to run, play squash and golf, ski and spend time with his wife and friends. 


</p>
                                
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>

      <div class="thinHrule"></div>

	</div>
	</div>
</div>





























    
















