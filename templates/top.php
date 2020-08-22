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

	<!-- Facebook properties -->
	<meta property="og:title" content="Lumos Fotografie"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="http://www.lachekiekjes.nl"/>
    <meta property="og:site_name" content="Lachekiekjes Fotografie"/>
    <meta property="og:description" content="Lachekiekjes fotografie - fotografie van jouw kleine ster"/>
	
	<link href="http://www.lachekiekjes.nl/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <script type="text/javascript" src="<?=BASE_URL?>js/jquery-2.0.3.min.js"></script>
    <!-- jGallery -->

<!--
    <link rel="stylesheet" type="text/css" media="all" href="<?=BASE_URL?>css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?=BASE_URL?>css/jgallery.min.css?v=1.6.1" />
    <script type="text/javascript" src="<?=BASE_URL?>js/jgallery.min.js?v=1.6.1"></script>
-->
    
    <script src="<?=BASE_URL?>js/lightbox.js"></script>
		<link href="<?=BASE_URL?>css/lightbox.css" rel="stylesheet" type="text/css" />

    
    <link href='https://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet' type='text/css'>
		
    <title><?=$settings["head_title"]?></title>
			
			<!-- Google analytics -->
			<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-93536920-1', 'auto');
  ga('send', 'pageview');

</script>
</head>
<body>

<img src='http://www.lachekiekjes.nl/images/bg_layout.png' style='display:none' />
<div class='main_container'>
	<div class='content_holder'>
		<div class='top'><div class='img_container'></div>
        </div>
        
        	<div class='navigation'>
			<?
			if(!isset($_GET['view_album']))
				echo $content->getMenuItems()?>
               </div>
         <div class="main_content"><div class='left_container'>
					 					 
					 <?=$content->getLeftImage()?>
					 
					 <!-- static contact information -->
					<div class='contact_info'><? echo $content->getContactInfo() ?>
						</div><div class='action'>
							<table class='contact_table'>
						
							</table>
						</p>
						</div>
					</div>	
					 
					 </div><div class='right_container'>
					 
	