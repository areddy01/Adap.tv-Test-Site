<div class="ContentHeader openings">
  <h2>Current Openings</h2>
</div>
<div class="openingsWindow"> 
  <!-- BEGIN JOBVITE CODE --> 
  <!--
						NOTE:  We are not specifying a jvresize url at this time.  The requested job is being
						displayed within the same iframe.  Leave jvresize blank.
					-->
  <iframe id="jobviteframe"
	src="//hire.jobvite.com/CompanyJobs/Careers.aspx?k=JobListing&c=qb79Vfw6&v=1&jvresize=<?=site_url('openings/')?>"
	width="100%" height="700px" scrolling="true" frameborder="0" allowtransparency="true">Sorry, iframes are not supported.</iframe>
  <script type="text/javascript">
						var l = location.href;
						var args = '';
						var k = '';
						var iStart = l.indexOf('?jvk=');
						if (iStart == -1) iStart = l.indexOf('&jvk=');
						if (iStart != -1) {
							iStart += 5;
							var iEnd = l.indexOf('&', iStart);
							if (iEnd == -1) iEnd = l.length;
							k = l.substring(iStart, iEnd);
						}
						iStart = l.indexOf('?jvi=');
						if (iStart == -1) iStart = l.indexOf('&jvi=');
						if (iStart != -1) {
							iStart += 5;
							var iEnd = l.indexOf('&', iStart);
							if (iEnd == -1) iEnd = l.length;
							args += '&j=' + l.substring(iStart, iEnd);
							if (!k.length) args += '&k=Job';
							var iStart = l.indexOf('?jvs=');
							if (iStart == -1) iStart = l.indexOf('&jvs=');
							if (iStart != -1){
								iStart += 5;
								var iEnd = l.indexOf('&', iStart);
								if (iEnd == -1) iEnd = l.length;
								args += '&s=' + l.substring(iStart, iEnd);
							}
						}
						
						if (k.length) args += '&k=' + k;
						
						if (args.length) document.getElementById('jobviteframe').src += args;
						function resizeFrame(height, scrollToTop) {
							if (scrollToTop) window.scrollTo(0, 0);
							var oFrame = document.getElementById('jobviteframe');
							if (oFrame) oFrame.height = height;
						};
  </script> 
  <!--END JOBVITE CODE --> 
</div>
