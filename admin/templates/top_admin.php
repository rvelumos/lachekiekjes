<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="copyright" content="lumosfotografie.nl" />
    <meta name="author" content="ronald van eijsden" />
    <meta name="robots" content="INDEX, NOFOLLOW" />
    
    <title><?=$title;?></title>
    <link href="<?=ROOT_URL?>css/admin.css" rel="stylesheet" type="text/css" />
	 <script type="text/javascript" src="<?=ROOT_URL?>js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script> 
      <script type="text/javascript" src="<?=ROOT_URL?>js/tabcontent.js"></script> 
     <script language="javascript" type="text/javascript">
			var fields = 0;
			function add() {
				if (fields < 9) {
					document.getElementById('image_input').innerHTML += "<table><tr><td class='fields'>Afbeelding: </td></tr><td class='fields'><input type='file' class='file' name='afbeeldingen[]' value='' /></td></tr></table>";
					fields += 1;
				} else {
					
					document.getElementById('last_field').innerHTML = "<br />Het maximum aantal velden is bereikt.";
					//document.form.add.disabled=true;
				}
			}
		</script>
         <script src="http://www.google.com/jsapi" type="text/javascript"></script>
		<script type="text/javascript" charset="utf-8">
			google.load("jquery", "1.6");
		</script>
        <script src="<?=ROOT_URL?>js/jquery.js" type="text/javascript" charset="utf-8"></script>
        <link rel="stylesheet" href="<?=ROOT_URL?>css/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
		<script src="<?=ROOT_URL?>js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
		
        <script type="text/javascript" charset="utf-8">
	  $(document).ready(function(){
		$("a[rel^='prettyPhoto']").prettyPhoto();
	  });
  </script>
  
  <? if(isset($_GET['section']) && $_GET['section']=="content" && $settings['use_tiny_mce']=="1"){?>
     <script type="text/javascript"> 
tinyMCE.init({ 
        // General options 
        mode : "textareas", 
        theme : "advanced", 
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template", 
 
        // Theme options 
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect", 
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,preview,|,forecolor,backcolor", 
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen", 
        //theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage", 
        theme_advanced_toolbar_location : "top", 
        theme_advanced_toolbar_align : "left", 
        theme_advanced_statusbar_location : "bottom", 
        theme_advanced_resizing : true, 
		theme_advanced_resizing_max_width :800,
		//theme_advanced_resize_horizontal : false,

 
        // Skin options 
        skin : "o2k7", 
        skin_variant : "silver", 
 
        // Example content CSS (should be your site CSS) 
        content_css : "css/example.css", 
 
        // Drop lists for link/image/media/template dialogs 
        template_external_list_url : "js/template_list.js", 
        external_link_list_url : "js/link_list.js", 
        external_image_list_url : "js/image_list.js", 
        media_external_list_url : "js/media_list.js", 
 
        // Replace values for the template plugin 
        template_replace_values : { 
                username : "Some User", 
                staffid : "991234" 
        } 
}); 
</script> 

<?}?>

<link rel="stylesheet" type="text/css" href="<?=ROOT_URL?>js/codebase/dhtmlxcalendar.css"/>

	<script src="<?=ROOT_URL?>js/codebase/dhtmlxcalendar.js"></script>

	<script>
		var myCalendar;
		function doOnLoad() {
			myCalendar = new dhtmlXCalendarObject(["calendar","calendar2","calendar3"]);
		}
	</script>
	
</head>
<body onload="doOnLoad();">
<div class='main_container'>
	<div class='content_holder'>
		<div class='top'><div class='img_container'></div>
        </div>
<? if (isset($_SESSION['auth_lachekiekjes_login']))$admin->getMenuItems();?>
        <div class='content'>