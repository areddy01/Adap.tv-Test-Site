<div id="InfoBar" class="sitewidth"></div>
<div id="BodyWrapper" class="siteblock">
	<div id="ContentNavigation">
       	<?PHP $this->load->view('navigation/contentnav',array('content' => $content,'sectionname' => ((isset($sectionname)) ? $sectionname : ''),'pagename' => ((isset($pagename)) ? $pagename : ''))); ?>
    </div>
    <div id="EditorWrapper">
        <div id="ArchiveWrapper" class="hidden"></div>
      	<div id="FormWrapper">
          	<?PHP $this->load->view('instructions/welcome'); ?>
        </div>
        <div id="SubFormWrapper"></div>
        
        <div id="EditorOverlay"></div>
        <div id="OverlayContent"></div>       
    </div>
</div>