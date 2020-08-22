<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
		
  	<link href="<?=BASE_URL?>css/css.css" rel="stylesheet" type="text/css" />
	<link href="<?=BASE_URL?>css/mobile.css" rel="stylesheet" type="text/css" />
		
	<!-- meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?=$settings["meta_description"]?>" />
    <meta name="keywords" content="<?=$settings["meta_keywords"]?>" />
    <meta name="copyright" content="<?=$settings["meta_copyright"]?>" />
    <meta name="author" content="<?=$settings["meta_author"]?>" />
	<meta name="robots" content="<?=$settings["meta_robots"]?>" />
		
    <link href="http://www.lachekiekjes.nl/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		
    <title><?=$settings["head_title"]?></title>

<script
			  src="https://code.jquery.com/jquery-3.5.1.js"
			  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
			  crossorigin="anonymous"></script>
        <link rel="stylesheet" href="<?=BASE_URL;?>/css/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
		<script src="<?=BASE_URL;?>blog/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
		<link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet' type='text/css'>

    
    <!-- Start Google Analytics -->
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-93536920-1', 'auto');
  ga('send', 'pageview');

	</script>
			
  <script type="text/javascript">    

$(document).ready(function () {      
  	 $("a[rel^='prettyPhoto']").prettyPhoto();
     $('#album_item span').click(function (event) {
          var id = ($(this).attr('id')); //trying to alert id of the clicked row     

		  if($("#copy_" + id).length == 0) {
			  $('#selected_list').append('<table id="table_'+id+'"><tr><td><input type="hidden" name="selection[]" value="'+id+'" /></td></tr></table>');
			  $('#selected_list').append('<table class="copy_image" id="copy_image_'+id+'"><tr><td><span id='+id+'><img src="https://www.ronald-designs.nl/development/projects/lachekiekjes/images/cross.gif" style="border:none; padding:0px; margin:5px;" alt="Verwijder foto" /></span><br /><img id="copy_'+id+'" src="" /></td></tr></table>');
        	  $("#copy_" + id).attr("src", $('#original_' + id).attr('src'));
		  }
	 });
		 
	 $('#selected_list span').click(function (event) {
          var id = ($(this).attr('id'));	
		  
		  if($("#copy_" + id).length != 0) {
			   $("#copy_image_" + id).remove();
			   $("#table_" + id).remove();
		  }
     });
 });

    </script>

</head>
<body>

<img src='../images/bg_pattern.png' style='display:none' />
<img src='../images/bg_layout.png' style='display:none' />
<div class='main_container_user'>
	<div class='album_holder'>