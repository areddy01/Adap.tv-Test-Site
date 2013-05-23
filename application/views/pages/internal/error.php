<script type="text/javascript">
  function getURLParam(strParamName){
    var strReturn = " ";
    var strHref = window.location.href;

    if ( strHref.indexOf("?") > -1 ){
      var strQueryString = strHref.substr(strHref.indexOf("?")).toLowerCase();
      var aQueryString = strQueryString.split("&");
      for ( var iParam = 0; iParam < aQueryString.length; iParam++ ){
        if (
  		aQueryString[iParam].indexOf(strParamName.toLowerCase() + "=") > -1 ){
          var aParam = aQueryString[iParam].split("=");
          strReturn = aParam[1];
          break;
        }
      }
    }
    return unescape(strReturn);
  }
  	
	window.onload = function() {

		var sErr = getURLParam("error");
		if (sErr.length > 0)
		{
			if(sErr=="err1"){
		        document.getElementById('topPara').innerHTML = 'There was an error.';
		        
		        document.getElementById('bottomPara').innerHTML = 'The sign-up was not successful because there is already an account matching the information that you entered. Please contact <a href="mailto:support@adap.tv">support@adap.tv</a> for help.';
		        
		    }else if(sErr=="err2"){
		     document.getElementById('topPara').innerHTML = 'There was an error.';
		        
		        document.getElementById('bottomPara').innerHTML = 'The sign-up was not successful because there is already an account matching the information that you entered. Please contact <a href="mailto:support@adap.tv">support@adap.tv</a> for help.';
		    }else{
		    		   
		    		     document.getElementById('topPara').innerHTML = 'There was an error.';
		    		     
		    		     document.getElementById('bottomPara').innerHTML = 'There\'s been an error processing your application. Please return to the previous page and re-submit your application.';
		    		     
		    		    
		    }
		}
	}
</script>
<div class="ContentHeader"> 
	<h2 id="topPara"></h2>
    <h3 id="bottomPara"></h3>
</div>