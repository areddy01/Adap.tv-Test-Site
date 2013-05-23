<div class="padding20">

	<div class="imagePrview">
    <?PHP
	
	$imageinfo = getimagesize($fullpath);
	
    if ($imageinfo[2]) {
    	echo '<img src="'.secure_site_url($this->config->item('uploads_path').$path).'" '.(($imageinfo[0] > $imageinfo[1]) ? 'width' : 'height').'="200" border="0">';
	} else {
 		echo '<img src="'.secure_site_url('styles/cmsimages/icons/512px/'.pathinfo($fullpath,PATHINFO_EXTENSION).'.png').'" width="200" border="0">';
	}
    ?>
    </div>
	
    <div class="fileinfovalue">
    	<h2><?PHP echo $name; ?></h2>
    </div>
    <div class="fileinfovalue">
    	<b>Size:</b> <?PHP echo $size; ?><br>

    	<b>Kind:</b> <?PHP echo $mime; ?><br>

    	<b>Date Modified:</b> <?PHP echo date('n/d/Y g:ia', $date); ?>
    </div>
    <?PHP
	/*
    <div class="fileinfovalue">
    
		if ($imageinfo[2]) {
	?>
    	<a href="cms/cropimage/<?PHP echo $linkpath; ?>">Crop Image &raquo;</a><br>
        <a href="cms/createthumb/<?PHP echo $linkpath; ?>">Create Thumbnail &raquo;</a><br>
    <?PHP } ?>
    	<a href="cms/rename/<?PHP echo $linkpath; ?>">Rename File &raquo;</a><br>
        <a href="cms/copy/<?PHP echo $linkpath; ?>">Copy File &raquo;</a><br>
    </div>
    */?>
    
	<div class="filedownload">
    	<a href="#" class="iconButton DeleteButton" title="<?PHP echo $path; ?>"><div>Delete<div class="crossicon"></div></div></a> &nbsp;&nbsp; 
    
    	<a href="#" class="iconButton DownloadButton" title="<?PHP echo $path; ?>"><div>Download<div class="downicon"></div></div></a>
    </div>
    
</div>
