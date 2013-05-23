/* Author:

*/
	var CurrentFolder = '/uploads/';
	
	function LoadDirectory(path) {
		CurrentFolder = path;
		CreateDirectoryBreadcrumbs(path);
		
		var Info = $("#FileWrapper").find("div.FileInfo:last");
		if (Info.length != 0) {
			Info.remove();
		}		
		
		$("#FileWrapper").append('<div class="FileBox loading"></div>');
		WrapperSize();
		AddClicks();
		
		
		WrapperSize();

		path = path.split("/").join("+");
		
		$.ajax({
		  url: basefolder+"cms/loadfilelist/"+path,
		  success: function(html){
			var ListWrapper = $("#FileWrapper").find("div.FileBox:last");
			ListWrapper.removeClass("loading");
			ListWrapper.append(html);
					
				CreateDraggables();
					
					
			//AddClicks();
		  }
		});		
	}
	
	var Overlay = false;
	var dataTable;
	
	function CreateDraggables() {
		$(".filecolumn").draggable("destroy");
					$(".columns").droppable("destroy");
					
					
					$(".filecolumn").draggable({
						addClasses:false,
						scroll: false,
						revert:'invalid',
						zIndex: 500,
						appendTo: '#BodyWrapper',
						helper:'clone',
						delay: 125,
						start: function(event, ui) { ui.helper.addClass("dragging"); },
						stop: function(event, ui) { ui.helper.removeClass("dragging"); }
					});					
					$(".columns").droppable({
						drop: function(event, ui) {
							
							
							if ($(this) != ui.draggable.closest('.columns')) {
								
								var filepath = ui.draggable.attr('title');
								filepath = filepath.split("/").join("+");
								
								var path = $(this).attr('title');
								path = path.split("/").join("+");
								
								var dirCont = $(this);
								
								
								
								$.ajax({
								  url: basefolder+"cms/checkoverwrite/"+filepath+"/"+path,
								  success: function(result){	
								  
								  	if (result == "none" || confirm("File already exists in that location.  Overwrite the file?")) {
										$.ajax({
										  url: basefolder+"cms/movefile/"+filepath+"/"+path,
										  success: function(html){	
											
											 ui.draggable.css({left:0,top:0}).detach();
											 dirCont.closest(".FileBox").append(html);								 
											 dirCont.remove();								 
											
											 CreateDraggables();				
										  }
										});
									} 
									
									
									}
								});
										
										
										
							}
							
						}
					});
					
					
	}
	
	function CreateDirectoryBreadcrumbs(filepath) {
		
		var paths = filepath.split("/");
		var pathString = '<span class="DirectoryLink" title="">uploads</span>';
		var pathLink = '';
		for (var i = 0; i < paths.length; i++) {
			if (paths[i] != '') {
				var pathLink = ((pathLink != '') ? '/' : '')+paths[i];
				var pathString = ((pathString != '') ? pathString+' &raquo; ' : '')+'<span class="DirectoryLink" title="'+pathLink+'">'+paths[i]+'</span>';
			}
		}
		$("#DirectoryPath").html('<b>Directory Path:</b> '+pathString);
		$("span.DirectoryLink").unbind().click(function() {
			var path = $(this).attr("title");
			var ind;
			if (path == '') {
				ind = 0;
			} else {
				ind = path.split("/").length;
			}
			$("#FileWrapper").find("div.FileBox:gt("+ind+")").remove();
			$("#FileWrapper").find("div.FileBox:last").find(".SelectedFile").removeClass("SelectedFile");
			CreateDirectoryBreadcrumbs(path);
			WrapperSize();
		});
	}
	
	function LoadFileInfo(filepath) {
		var Info = $("#FileWrapper").find("div.FileInfo:last");
		if (Info.length == 0) {
			$("#FileWrapper").append('<div class="FileBox FileInfo loading"></div>');
			WrapperSize();
		}
		filepath = filepath.split("/").join("+");
		
		$.ajax({
		  url: basefolder+"cms/loadfileinfo/"+filepath,
		  success: function(html){
			Info = $("#FileWrapper").find("div.FileInfo");
			Info.removeClass("loading");
			Info.html(html);
			//AddClicks();
		  }
		});		
	}
	
	function AddClicks() {
		
	}
	
	function WrapperSize() {
		var Count = $("#FileWrapper").find("div.FileBox").length;	
		var newWidth = Count*300;
		$("#FileWrapper").width(newWidth);
		if (newWidth > $("#BodyWrapper").width()) {
			$("#BodyWrapper").animate({scrollLeft: (newWidth - $("#BodyWrapper").width())}, 'slow'); 
		} else {
			$("#BodyWrapper").animate({scrollLeft: 0}, 'slow'); 
		}
	}
	
	function DownloadFile(path) {
		path = path.split("/").join("+");
		$("#DownloadTrigger").attr("src",basefolder+"cms/download/"+path);
	}
	
	function DeleteFile(path,index) {
		path = path.split("/").join("+");
		$.ajax({
		  url: basefolder+"cms/deletefile/"+path,
		  success: function(result){
			if (result == "false") {
				alert("File could not be deleted.");
			} else {
				$("#FileWrapper").find("div.FileInfo").remove();
				$("#FileWrapper").find("div.FileBox:last").html(result);
				//AddClicks();
			}
		  }
		});	
	}

	$(document).ready(function() {
		
			
		function loadSubArchive() {
			if ($(".subArchive").length) {
				var parentid = $(".subArchive").data('parentid');			
				var tablename = $(".subArchive").data('tablename');
				
				$(".subArchive").addClass('loading').html('');
				$.ajax({
				  url: basefolder+"cms/loadarchivefromtable/"+tablename+"/"+parentid,
				  success: function(html){
					$(".subArchive").html(html).removeClass('loading'); 
					
					UpdateActions();
				  }
				});	
			}
		}
	
	
		$("#MainContentNav li.closed>a").live("click",function() {
			$("#MainContentNav li.open>a").click();
			$(this).closest("li").find("ul").slideDown(250);
			$(this).closest("li").find("span.plus").html("-");
			$(this).closest("li").removeClass("closed").addClass("open");
			return false;	
		});
	
		$("#MainContentNav li.open>a").live("click",function() {
			$(this).closest("li").find("ul").slideUp(250);
			$(this).closest("li").find("span.plus").html("+");
			$(this).closest("li").removeClass("open").addClass("closed");	
			return false;	
		});
		
		
		$("#ContentNavigation #MainContentNav li a").live("click",function() {			
			if (!$(this).closest("li").hasClass('closed') && !$(this).closest("li").hasClass('open') && Overlay == false) {				
				$("#MainContentNav li a.selected").removeClass('selected').find('div.selectedArrow').remove();
				//$("#MainContentNav li a.selected");			
				$(this).addClass('selected').append('<div class="selectedArrow"><div class="innerArrow"></div></div>');			
				$("#ArchiveWrapper").removeClass('hidden').addClass('loading').html('');			
				$("#FormWrapper").addClass('loading').html('');
				
				
				$("#SubFormWrapper").css({"display":"none"}).html('');
				$(".siteblock").animate({"width":"1105px"},250);
					
				$(".sitewidth").animate({"min-width":"1105px"},250);
				
				
				var pagelink = $(this).attr("href");
				var linkArray = pagelink.split("/");
				linkArray.splice(0,3);
				$.ajax({
				  url: basefolder+"cms/loadarchive/"+linkArray.join("/"),
				  success: function(html){
					$("#ArchiveWrapper").html(html).removeClass('loading');				
					UpdateActions();
				  }
				});					
				$.ajax({
				  url: basefolder+"cms/formbuild/"+linkArray.join("/"),
				  success: function(html){
					$("#FormWrapper").html(html).removeClass('loading'); 
					UpdateActions();					
				  }
				});	
			}
			return false;	
		});
		
		
		$("#DataContentNavigation #MainContentNav li a").live("click",function() {			
			if (!$(this).closest("li").hasClass('closed') && !$(this).closest("li").hasClass('open') && Overlay == false) {				
				$("#MainContentNav li a.selected").removeClass('selected').find('div.selectedArrow').remove();
				//$("#MainContentNav li a.selected");			
				$(this).addClass('selected').append('<div class="selectedArrow"><div class="innerArrow"></div></div>');		
				
				if ($(this).data('subdata')) {
					
					$("#DataWrapper").html('');
					
					$("#DataArchiveWrapper").removeClass('hidden').addClass('loading').html('');
					var pagelink = $(this).attr("href");
					var linkArray = pagelink.split("/");
					linkArray.splice(0,3);					
					$.ajax({
					  url: basefolder+"cms/loaddataarchive/"+linkArray.join("/"),
					  success: function(html){						
						$("#DataArchiveWrapper").html(html).removeClass('loading');
						UpdateActions();								
					  }
					});	
					
				} else {
				
					$(".siteblock").animate({"width":"1105px"},250);	
					
					
					$(".sitewidth").animate({"min-width":"1105px"},250);
				
					$("#DataArchiveWrapper").addClass('hidden');	
					$("#DataWrapper").addClass('loading').html('');
					var pagelink = $(this).attr("href");
					var linkArray = pagelink.split("/");
					linkArray.splice(0,3);					
					$.ajax({
					  url: basefolder+"cms/loaddata/"+linkArray.join("/"),
					  success: function(html){
						$("#DataWrapper").html(html).removeClass('loading'); 
						UpdateActions();				
					  }
					});	
				
				}
			}
			return false;	
		});
		
		
		$("#DataArchiveWrapper .MainContentList li,#DataArchiveWrapper .OfflineContentList li").live("click",function() {				
			if (!$(this).closest("li").hasClass('selected')) {
				$("#DataArchiveWrapper .MainContentList li.selected,#DataArchiveWrapper .OfflineContentList li.selected").removeClass('selected');
				
				$(this).addClass('selected');				
				
				var pagename = $(".archiveHeader").data('pagename');
				if (pagename == '') {
					pagename = 'NULL';
				}
				var sectionname = $(".archiveHeader").data('sectionname');			
				var subid = $(this).data('id');
				
				
					$("#DataWrapper").addClass('loading').html('');				
					$.ajax({
					  url: basefolder+"cms/loaddata/"+sectionname+"/"+pagename+"/"+subid,
					  success: function(html){
						  
						$(".siteblock").animate({"width":"1611px"},250, function() {
							$("#DataWrapper").html(html).removeClass('loading'); 
							UpdateActions();	
						});	
						  
						$(".sitewidth").animate({"min-width":"1611px"},250);	
					  }
				});	
				
			}
			return false;
		});
		
		
		
		
		$("#ArchiveWrapper .OfflineContentList li div.OnSwitch,#DataArchiveWrapper .OfflineContentList li div.OnSwitch").live("click",function(e) {				
			e.stopPropagation();			
			var parent = $(this).closest("li");
			var id = parent.data('id');
			var tablename = parent.data('tablename');			
			var pagename = $(".archiveHeader").data('pagename');
			if (pagename == '') {
				pagename = 'NULL';
			}
			var sectionname = $(".archiveHeader").data('sectionname');	
			parent.detach();
			$.ajax({
				url: basefolder+"cms/activate/"+sectionname+"/"+pagename+"/"+tablename+"/"+id+"/",
				success: function(result){
					
					if (result == "success") {						
						$.ajax({
						  url: basefolder+"cms/loadarchive/"+sectionname+"/"+pagename+"/",
						  success: function(html){
							$("#ArchiveWrapper").html(html).removeClass('loading');				
							UpdateActions();
						  }
						});							
					} else {
						$("#OfflineContentList").append(parent);	
					}
				}				
			});	
		});
		
		$("#ArchiveWrapper .MainContentList li div.OffSwitch,#DataArchiveWrapper .MainContentList li div.OffSwitch").live("click",function(e) {	
			e.stopPropagation();			
			var parent = $(this).closest("li");
			var id = parent.data('id');
			var tablename = parent.data('tablename');
			
			var pagename = $(".archiveHeader").data('pagename');
			if (pagename == '') {
				pagename = 'NULL';
			}
			var sectionname = $(".archiveHeader").data('sectionname');			
			parent.detach();			
			$.ajax({
				url: basefolder+"cms/deactivate/"+sectionname+"/"+pagename+"/"+tablename+"/"+id+"/",
				success: function(result){
					if (result == "success") {
						$.ajax({
						  url: basefolder+"cms/loadarchive/"+sectionname+"/"+pagename+"/",
						  success: function(html){
							$("#ArchiveWrapper").html(html).removeClass('loading');				
							UpdateActions();
						  }
						});	
					} else {
						$("#OfflineContentList").append(parent);	
					}
				}
			});	
		});
		
		
		
		$(".subArchive .OfflineContentList li div.OnSwitch").live("click",function(e) {				
			e.stopPropagation();			
			var parent = $(this).closest("li");
			var id = parent.data('id');
			var tablename = $(".subArchive").data('tablename');			
			var parentid = $(".subArchive").data('parentid');
			
			parent.detach();
			$.ajax({
				url: basefolder+"cms/activate/NULL/NULL/"+tablename+"/"+id+"/"+parentid+"/",
				success: function(result){
					
					if (result == "success") {
						loadSubArchive();						
					} else {
						$("#OfflineContentList").append(parent);	
					}
				}				
			});	
		});
		
		$(".subArchive .MainContentList li div.OffSwitch").live("click",function(e) {	
			e.stopPropagation();			
			var parent = $(this).closest("li");
			var id = parent.data('id');
			var tablename = $(".subArchive").data('tablename');			
			var parentid = $(".subArchive").data('parentid');
							
			parent.detach();			
			$.ajax({
				url: basefolder+"cms/deactivate/NULL/NULL/"+tablename+"/"+id+"/"+parentid+"/",
				success: function(result){
					if (result == "success") {						
						loadSubArchive();
					} else {
						$("#OfflineContentList").append(parent);	
					}
				}
			});	
		});
		
		
		
		
		
		
		$("#ArchiveWrapper .MainContentList li,#ArchiveWrapper .OfflineContentList li").live("click",function() {				
			if (!$(this).closest("li").hasClass('selected') && !$(this).closest("li").hasClass('static')) {
				$("#ArchiveWrapper .MainContentList li.selected,#ArchiveWrapper .OfflineContentList li.selected").removeClass('selected');
				
				$(this).addClass('selected');				
				
				var pagename = $(".archiveHeader").data('pagename');
				if (pagename == '') {
					pagename = 'NULL';
				}
				var sectionname = $(".archiveHeader").data('sectionname');			
				var id = $(this).data('id');
				var tablename = $(this).data('tablename');
				
				
				$("#SubFormWrapper").css({"display":"none"}).html('');
				$(".siteblock").animate({"width":"1105px"},250);
				
				$(".sitewidth").animate({"min-width":"1105px"},250);
				
				$("#FormWrapper").addClass('loading').html('');
				$.ajax({
				  url: basefolder+"cms/formbuild/"+sectionname+"/"+pagename+"/"+tablename+"/"+id+"/",
				  success: function(html){
					$("#FormWrapper").html(html).removeClass('loading'); 
					
					UpdateActions();
					loadSubArchive();
				  }
				});	
			}
			return false;
		});
		
		$(".subArchive .MainContentList li,.subArchive .OfflineContentList li").live("click",function() {				
			if (!$(this).closest("li").hasClass('selected')) {
				$(".subArchive .MainContentList li.selected,.subArchive .OfflineContentList li.selected").removeClass('selected');
				
				$(this).addClass('selected');				
				
				var pagename = $(".archiveHeader").data('pagename');
				if (pagename == '') {
					pagename = 'NULL';
				}
				var sectionname = $(".archiveHeader").data('sectionname');			
				var id = $(this).data('id');
				var tablename = $(this).data('tablename');
				
				$("#SubFormWrapper").addClass('loading').html('');
				$.ajax({
				  url: basefolder+"cms/formbuild/"+sectionname+"/"+pagename+"/"+tablename+"/"+id+"/true/",
				  success: function(html){					  
					$(".siteblock").animate({"width":"1611px"},250, function() {
						$("#SubFormWrapper").css({"display":"block"}).html(html).removeClass('loading'); 						
						UpdateActions();
					});
					$(".sitewidth").animate({"min-width":"1611px"},250);
				  }
				});	
			}
			return false;
		});
		
		
		$(".overlaycancel").live("click",function() {			
			//$(this).closest('li').remove();
			
			
			$("#OverlayContent").fadeOut(500);
			$("#EditorOverlay").fadeOut(500, function() {
				$("#OverlayContent").html('');
				$("#BodyWrapper").css({height:"auto"});
				Overlay = false;		
			});
			return false;			
		});
		$(".deleteConfirmed").live("click",function() {	
			var pagename = $(".archiveHeader").data('pagename');
			if (pagename == '') {
					pagename = 'NULL';
				}
			var sectionname = $(".archiveHeader").data('sectionname');			
			var id = $(this).data('id');
			var tablename = $(this).data('tablename');
			
			$.ajax({
				  url: basefolder+"cms/delete/"+sectionname+"/"+pagename+"/"+tablename+"/"+id+"/",
				  success: function(html){
					$("#OverlayContent").fadeOut(500);
					$("#EditorOverlay").fadeOut(500, function() {
						Overlay = false;
						$("#OverlayContent").html('');	
						$("#BodyWrapper").css({height:"auto"});		
					});
					
					if ($('li[data-tablename="'+tablename+'"][data-id="'+id+'"]').hasClass("selected")) {
						$("#FormWrapper").html('');
					}
					$('li[data-tablename="'+tablename+'"][data-id="'+id+'"]').remove();
					
				  }
			});
			return false;	
		});
		
		$(".OfflineContentList li a.circleDeleteButton").live("click",function(e) {			
			//$(this).closest('li').remove();
			
			 e.stopPropagation();
			
			var type = $(".archiveHeader").data('type');
			
			var pagename = $(".archiveHeader").data('pagename');
			if (pagename == '') {
					pagename = 'NULL';
				}
			var sectionname = $(".archiveHeader").data('sectionname');			
			var id = $(this).closest('li').data('id');
			var tablename = $(this).closest('li').data('tablename');
			
			$.ajax({
				  url:basefolder+"cms/deletewindow/",
				  success: function(html){
					Overlay = true;
					$("#OverlayContent").html(html); 
					$(".deleteConfirmed").data("tablename",tablename);
					$(".deleteConfirmed").data("id",id);
					$("#EditorOverlay").fadeIn(500);
					$("#OverlayContent").fadeIn(500);
					if (($("#OverlayContent").height()+200) > $("#BodyWrapper").height()) {
						$("#BodyWrapper").css({height:$("#OverlayContent").height()+200+"px"});
					}
				  }
			});	
			return false;
		});
		
		$(".dropTop").live("click",function() {
			$(this).closest(".dropWrapper").slideUp(50);			
		});
		
		$(".addButton").live("click",function() {	
			var pagename = $(this).data('pagename');
			if (pagename == '') {
				pagename = 'NULL';
			}
			var sectionname = $(this).data('sectionname');
			if (sectionname == '') {
				sectionname = 'NULL';
			}
			var tablename = $(this).data('tablename');			
			var parentid = $(this).data('parentid');			
			var clicked = $(this);			
			if (tablename) {
				$.ajax({
					url:basefolder+"cms/add/"+sectionname+"/"+pagename+"/"+tablename+"/"+((parentid) ? parentid+"/" : ""),
					success: function(html){
						clicked.closest(".archivePadding").find(".OfflineContentList").append(html);
					}
				});
				$("#typesDrop").hide();
			}
			return false;
		});
		
		
		$(".addButton.typesdrop").live("mouseenter",function() {	
			var p = $(this).position();
			$("#typesDrop").css({left:p.left+"px",top:(p.top+25)+"px"}).show();				
		}).live("mouseleave",function() {	
			$("#typesDrop").hide();
		});
		$("#typesDrop").live("mouseenter",function() {	
			$("#typesDrop").show();				
		}).live("mouseleave",function() {	
			$("#typesDrop").hide();
		});
		
		
		
		var newSize;
		var sizing = false;
		function SetupCrop() {		
			$('#cropbox').Jcrop({
				aspectRatio:1.4,
				onSelect:function(c) {
				
					newSize = c.x+"|"+c.y+"|"+c.w+"|"+c.h;	
					
				}
			});				
		}
		$(".cropImage").live("click",function(e) {	
		
			if (newSize && sizing == false) {
				var id = $(this).data('id');
				sizing = true;
				$.ajax({
				  url:basefolder+"cms/sizeimage/"+newSize+"/"+id+"/",
				  success: function(html){
					sizing = false;					
					$("#OverlayContent").html(html);
				  }
				});	
			}
		});
		
		$(".approveEntryLink").live("click",function(e) {			
			 e.stopPropagation();					
			var id = $(this).data('id');
			var table = $(this).data('table');		
			$.ajax({
				  url:basefolder+"cms/entryapproved/"+table+"/"+id+"/",
				  success: function(html){
					Overlay = true;
					$("#OverlayContent").html(html);
					if ($("#listings").data("subid") != 2) {
						var ind = $('.approveLink[data-id="'+id+'"]').closest("tr").index();
						dataTable.fnDeleteRow(ind);
					}
				  }
			});	
			return false;
		});
		$(".denyEntryLink").live("click",function(e) {			
			 e.stopPropagation();					
			var id = $(this).data('id');
			var table = $(this).data('table');			
			$.ajax({
				  url:basefolder+"cms/entrydenied/"+table+"/"+id+"/",
				  success: function(html){
					Overlay = true;
					$("#OverlayContent").html(html);
					if ($("#listings").data("subid") != 3) {
						var ind = $('.approveLink[data-id="'+id+'"]').closest("tr").index();
						dataTable.fnDeleteRow(ind);
					}
				  }
			});	
			return false;
		});
		
		
		$(".cropLink").live("click",function(e) {			
			 e.stopPropagation();
					
			var id = $(this).data('id');
			
			$.ajax({
				  url:basefolder+"cms/cropnorcalimage/"+id+"/",
				  success: function(html){
					Overlay = true;
					$("#OverlayContent").html(html); 
					$("#EditorOverlay").fadeIn(500);
					
					$("#OverlayContent").fadeIn(500);
					if (($("#OverlayContent").height()+200) > $("#BodyWrapper").height()) {
						$("#BodyWrapper").css({height:$("#OverlayContent").height()+200+"px"});
					}
					
					SetupCrop()
					
				  }
			});	
			return false;
		});
		
		$(".approveLink").live("click",function(e) {			
			 e.stopPropagation();
					
			var id = $(this).data('id');
			var table = $(this).data('table');
			
			$.ajax({
				  url:basefolder+"cms/approveentry/"+table+"/"+id+"/",
				  success: function(html){
					Overlay = true;
					$("#OverlayContent").html(html); 
					$("#EditorOverlay").fadeIn(500);
					
					$("#OverlayContent").fadeIn(500);
					if (($("#OverlayContent").height()+200) > $("#BodyWrapper").height()) {
						$("#BodyWrapper").css({height:$("#OverlayContent").height()+200+"px"});
					}
				  }
			});	
			return false;
		});
		
		$(".previewButton").live("click",function(e) {			
			//$(this).closest('li').remove();
			var pagename = $(this).data('pagename');
			if (pagename == '') {
					pagename = 'NULL';
				}
			var sectionname = $(this).data('sectionname');
			$("html, body").animate({scrollTop: 0 }, 500);
			
			
			$.ajax({
				  url:basefolder+"cms/previewwindow/"+sectionname+"/"+pagename+"/",
				  success: function(html){
					Overlay = true;
					$("#OverlayContent").html(html);					
					$("#EditorOverlay").fadeIn(500);
					
					$("#OverlayContent").fadeIn(500);
					if (($("#OverlayContent").height()+200) > $("#BodyWrapper").height()) {
						$("#BodyWrapper").css({height:$("#OverlayContent").height()+200+"px"});
					}
					
					
					$("#Content").submit();
					 
				  }
			});	
			return false;
		});
		
		$(".randomButton").live("click",function(e) {			
			//$(this).closest('li').remove();
			var tablename = $(this).data('tablename');
			var subid = $(this).data('subid');
			
			if (subid == '') {
				subid = 'NULL';
			}
			
			$.ajax({
				  url:basefolder+"cms/pickrandom/"+tablename+"/"+subid+"/",
				  success: function(html){
					Overlay = true;
					$("#OverlayContent").html(html);					
					$("#EditorOverlay").fadeIn(500);
					
					$("#OverlayContent").fadeIn(500);
					if (($("#OverlayContent").height()+200) > $("#BodyWrapper").height()) {
						$("#BodyWrapper").css({height:$("#OverlayContent").height()+200+"px"});
					}
					
					
					$("#Content").submit();
					 
				  }
			});	
			return false;
		});
		
		
		$(".csvButton").live("click",function(e) {			
			//$(this).closest('li').remove();
			var tablename = $(this).data('tablename');
			var subid = $(this).data('subid');
			
			if (subid == '') {
				subid = 'NULL';
			}
			
			$("#DownloadTrigger").attr("src",basefolder+"cms/downloadcsv/"+tablename+"/"+subid+"/");
			
			return false;
		});
		
		CreateDraggables();
		
		
		$("#AccountTab").click(function () {
		  $("#AccountInfo").slideToggle("slow");
		});		
		
	
		$("#AccountInfo").resize(function () { 
			var offset = $("#BodyWrapper").offset();
			//$("#BodyWrapper").height($(window).height()-offset.top);
		});
		
		if ($("#FileWrapper").length > 0) {
			var offset = $("#BodyWrapper").offset();
			$("#BodyWrapper").height($(window).height()-offset.top);
			
			$(window).resize(function () { 
				var offset = $("#BodyWrapper").offset();
				$("#BodyWrapper").height($(window).height()-offset.top);
			});
			
			
			LoadDirectory('');
		}
		
		
		
		
		$("#FileWrapper div.filecolumn, #FileWrapper div.columns, #FileWrapper div.FileBox").live("click",function(e) {
			e.stopPropagation();
			var ind;		
			if ($(this).hasClass("filecolumn")) {
				ind = $(this).parent().parent().index();
				$("#FileWrapper").find("div.FileBox:gt("+ind+")").remove();
				WrapperSize();				
				
				$(this).parent().find(".SelectedFile").removeClass("SelectedFile");
				$(this).addClass("SelectedFile");
								
				var path = $(this).attr("title");
				if ($(this).hasClass("directory")) {
					LoadDirectory(path);
				} else {
					LoadFileInfo(path);
				}
			} else {
				
				if ($(e.target).hasClass("FileBox")) {
					$(this).index().nextAll().remove();
				} else {
					$(this).parents("div.FileBox").nextAll().remove();
				}			
				$(this).find(".SelectedFile").removeClass("SelectedFile");
				
				var lastBox = $("div.FIleList:last");
				var newPath = lastBox.attr("title");
				CreateDirectoryBreadcrumbs(newPath);
				WrapperSize();				
			}
		});
	
		$("a.DownloadButton").live("click",function() {
			var path = $(this).attr("title");
			DownloadFile(path);
			return false;
		});
		
		
		$("a.DeleteButton").live("click",function() {
			var path = $(this).attr("title");
			var ind = $(this).parents(".FIleList").index();
			var agree=confirm('Delete file '+path+'? This cannot be undone.');
			if (agree) {
				DeleteFile(path,ind);
			}
			return false;
		});
		
		
		$(".submitForm").live("click",function() {
			var publish = false;			
			if ($(this).hasClass("publishButton")) {
				publish = true;
			}
			$('#Content').ajaxSubmit({
				url:basefolder+"cms/updatecontent/",
				success: function() {
					//$(".MainContentList li.selected, .OfflineContentList li.selected").removeClass('selected');
					
					
					var pagename = $(".archiveHeader").data('pagename');
					if (pagename == '') {
						pagename = 'NULL';
					}
					var sectionname = $(".archiveHeader").data('sectionname');
					
					$("#OverlayContent").fadeOut(500);
					$("#EditorOverlay").fadeOut(500, function() {
						Overlay = false;
						$("#OverlayContent").html('');		
						$("#BodyWrapper").css({height:"auto"});		
					});
					
					if (publish && $("#ArchiveWrapper li.selected div.OnSwitch").length > 0) {						
						$("#ArchiveWrapper li.selected div.OnSwitch").click();						
					} else {					
						$.ajax({
						  url: basefolder+"cms/loadarchive/"+sectionname+"/"+pagename+"/",
						  success: function(html){
							$("#ArchiveWrapper").html(html).removeClass('loading');				
							UpdateActions();
						  }
						});	
					}
				},
				target: '#FormWrapper'				
			}); 
			return false;
		});
		
		
		$(".subSaveButton").live("click",function() {
			$('#SubContent').ajaxSubmit({
				url:basefolder+"cms/updatecontent/",
				success: function() {
					
					$("#SubFormWrapper").css({"display":"none"}).html('');
					$(".siteblock").animate({"width":"1105px"},250);
					
					$(".sitewidth").animate({"min-width":"1105px"},250);	
				
					loadSubArchive();
				}			
			}); 
			return false;
		});
		
		function UpdateActions() {
			
			
			$("textarea.limit").each(function(index) {			
				$(this).limit($(this).data("charlimit"),'.charsLeft_'+$(this).attr("name"));			
			});
			
			
			var startpage = 0;
			var selected = $("ul.MainContentList li.selected").index();
			if (selected > 0) {
				startpage = Math.ceil((selected+1)/5) - 1;
			}
			$('#MainListWrapper').pajinate({
				num_page_links_to_display : 4,
				items_per_page : 5,
				nav_label_first : '<<',
				nav_label_last : '>>',
				nav_label_prev : '<',
				nav_label_next : '>',
                abort_on_small_lists: true,
				start_page:startpage
			});
			
			startpage = 0;
			selected = $("ul.OfflineContentList li.selected").index();
			if (selected > 0) {
				startpage = Math.ceil((selected+1)/5) - 1;
			}			
			$('#OfflineListWrapper').pajinate({
				num_page_links_to_display : 4,
				items_per_page : 5,
				nav_label_first : '<<',
				nav_label_last : '>>',
				nav_label_prev : '<',
				nav_label_next : '>',
                abort_on_small_lists: true,
				start_page:startpage		
			});	
			var uploader = new Array();
			for (var i = 0; i < $(".uploadButton").length; i++) {
				 uploader[i] = new qq.FileUploader({
					debug: true,
					element: $(".uploadButton:eq("+i+")")[0],
					listElement: $(".uploadButton:eq("+i+")").closest(".imageUpload").find(".thumbnail")[0],
					action: basefolder+'cms/upload/',
					allowedExtensions: ['jpg','jpeg','png','gif'],
					template: '<div class="qq-uploader">' + 
					'<div class="qq-upload-drop-area"><span>Drop files here to upload</span></div>' +
					'<div class="qq-upload-button iconButton"><div>Upload<div class="upicon"></div></div></div>' +
					'<ul class="qq-upload-list"></ul>' + 
				 '</div>',
					onComplete: function(id, fileName, responseJSON){
						
						//alert(this.element);
						$(this.element).closest(".imageUpload").find("input").val(basefolder+'uploads/'+responseJSON.file);	
						
						$(this.element).closest(".imageUpload").find(".thumbnail").html('<img src="'+basefolder+'uploads/'+responseJSON.file+'" border="0" />');	
					}
				});
			}
			
			
			$('.datetime').datetimepicker({
				dateFormat: 'yy-mm-dd',
				showSecond: false,
				timeFormat: 'hh:mm:00'		
			});
			
			$('.date').datepicker({
				dateFormat: 'yy-mm-dd'	
			});
			
		
			
			
					$("#ArchiveWrapper .manualsort").sortable( "destroy" );
					$("#ArchiveWrapper .manualsort").sortable({
						handle: 'div.grab',
						stop: function(event, ui) { 
						
							var result = $(this).sortable('toArray');
							var neworder = result.join('|');
							var tablename = ui.item.data('tablename');
							var pagename = $("#ArchiveWrapper .archiveHeader").data('pagename');
							if (pagename == '') {
								pagename = 'NULL';
							}
							var sectionname = $("#ArchiveWrapper .archiveHeader").data('sectionname');
							if (sectionname == '') {
								sectionname = 'NULL';
							}
							if (!tablename) {
								tablename = 'contentoptions';
							}
							$.ajax({
							  url: basefolder+"cms/reorder/"+sectionname+"/"+pagename+"/"+tablename+"/"+neworder+"/",
							  success: function(result){
								$.ajax({
								  url: basefolder+"cms/loadarchive/"+sectionname+"/"+pagename+"/",
								  success: function(html){
									$("#ArchiveWrapper").html(html).removeClass('loading');
									
									UpdateActions();
								  }
								});	
							  }
							});	
						}
					});
					
					$(".subArchive .manualsort").sortable( "destroy" );
					$(".subArchive .manualsort").sortable({
						handle: 'div.grab',
						stop: function(event, ui) { 
						
							var result = $(this).sortable('toArray');
							var neworder = result.join('|');
							
							
							var parentid = $(".subArchive").data('parentid');			
							var tablename = $(".subArchive").data('tablename');
							
							$.ajax({
							  url: basefolder+"cms/reordersub/"+tablename+"/"+parentid+"/"+neworder+"/",
							  success: function(result){
								  
								$.ajax({
								  url: basefolder+"cms/loadarchivefromtable/"+tablename+"/"+parentid+"/",
								  success: function(html){
									$(".subArchive").html(html).removeClass('loading');
									
									UpdateActions();
								  }
								});	
							  }
							});	
						}
					});
					
		dataTable = $("#listings").dataTable({
			"aaSorting": [[ 0, "asc" ]],
			"bFilter": false,
			"sPaginationType": "full_numbers",
			"aLengthMenu": [[50, 100, 250], [50, 100, 250]],
			"iDisplayLength":100
		 } );
	
		$('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : basefolder+'js/jscripts/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,searchreplace,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,pastetext,pasteword,|,search,replace",
			theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup",
			theme_advanced_buttons3 : "forecolor,backcolor,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,advhr,|,formatselect",
			theme_advanced_buttons4 : "styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,|,fullscreen,code,help",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Drop /js/lists for link/image/media/template dialogs
			template_external_list_url : basefolder+"js/lists/template_list.js",
			external_link_list_url : basefolder+"js/lists/link_list.js",
			external_image_list_url : basefolder+"js/lists/image_list.js",
			media_external_list_url : basefolder+"js/lists/media_list.js"
		});
	}
		
		
	
	$(".loginButton").click(function() {
		$("#Login").submit();
	});
		
	
	
		
		
});