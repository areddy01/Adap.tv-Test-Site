<ul id="MainNav">
<?PHP
	if ($section == "editcontent") { echo '<li class="tab selected">Edit Content</li>'; } else { echo '<li class="tab"><a href="'.secure_site_url('cms/editcontent').'">Edit Content</a></li>'; }    
    //if ($section == "datamanager") { echo '<li class="tab selected">Manage Submissions</li>'; } else { echo '<li class="tab"><a href="'.secure_site_url('cms/datamanager').'">Manage Submissions</a></li>'; }   
   // if ($section == "setup") { echo '<li class="tab selected">System Setup</li>'; } else { echo '<li class="tab"><a href="'.secure_site_url('cms/setup').'">System Setup</a></li>'; }   
    //if ($section == "filemanager") { echo '<li class="tab selected">Manage Files</li>'; } else { echo '<li class="tab"><a href="'.secure_site_url('cms/filemanager').'">Manage Files</a></li>'; }
?>
</ul>