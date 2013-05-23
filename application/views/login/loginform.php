<div id="LoginWindow">
	<div class="siteblock">
        <div id="LoginWrapper">
            <div class="fieldgroup">
                <div class="fieldgrouppadding">
                    <form action="<?=secure_site_url('/cms/login/')?>" method="post" name="Login" id="Login">
                        <label>Username</label>
                        <div class="fieldpadding">  
                            <input type="text" class="textInput<?PHP if ($error == "username") { echo ' error'; } ?>" name="username" value="<?=$username?>" />
                        </div>
                                
                        <label>Password</label>
                        <div class="fieldpadding">  
                            <input type="password" class="textInput<?PHP if ($error == "password") { echo ' error'; } ?>" name="password" value="<?=$password?>" />
                        </div>
                                
                        <div class="loginButtons">
                            <a class="loginhelp" href="mailto:jimb@mhinteractive.com">Need Help?</a>            
                            <a href="#" class="loginButton iconButton"><div>Login<div class="forwardicon"></div></div></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>