<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="description" content="<?=$settings["meta_description"]?>" />
    <meta name="keywords" content="<?=$settings["meta_keywords"]?>" />
    <meta name="copyright" content="<?=$settings["meta_copyright"]?>" />
    <meta name="author" content="<?=$settings["meta_author"]?>" />
    <link href="http://www.lumos-fotografie.nl/lumos/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <meta property="og:title" content="Lumos Fotografie"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="http://www.lumosfotografie.nl"/>
    <meta property="og:site_name" content="Lumos Fotografie"/>
    <meta property="og:description" content="Lumos fotografie - fotografie van jouw kleine ster"/>
    <meta name="robots" content="<?=$settings["meta_robots"]?>" />
    
    <title><?=$settings["head_titel"]?></title>
    <link href="<?=BASE_URL?>css/css.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?=BASE_URL?>js/Fader.js"></script>
    <script type="text/javascript" src="<?=BASE_URL?>js/incl_js.js"></script>
    <script type="text/javascript" src="<?=BASE_URL?>js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="<?=BASE_URL?>js/sliderman.1.3.7.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=BASE_URL?>css/sliderman.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?=BASE_URL?>css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?=BASE_URL?>css/jgallery.min.css?v=1.5.3" />
    <script type="text/javascript" src="<?=BASE_URL?>js/jgallery.min.js?v=1.5.3"></script>

    
	<script type="text/javascript">  
	var _gaq = _gaq || []; 
	_gaq.push(['_setAccount', 'UA-37904626-1']);  
	_gaq.push(['_trackPageview']);  

	(function() {    
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;    
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';    
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);  })();
    </script>
<script type="text/javascript" src="<?=BASE_URL?>js/tabcontent.js"></script> 
    
     <script type="text/javascript">   
                   						 
	 function checkWholeForm(Contact) {                                
	 	var leeg = "";    
		var error;                                                         
			leeg += checkUsername(Contact.name);                                        
			leeg += checkEmail(Contact.email);                                        
			leeg += isEmpty(Contact.textarea);                                       
			//alert(leeg);
			if(leeg != ""){
				document.getElementById('field_input').innerHTML=leeg;
				return false;                               
		 	}
	
			return true;
	}                
	function isEmpty(field) {
		var error = "";
	  
		if (field.value.length == 0) {
			field.style.background = '#fdc1c3';
			field.style.border = '1px solid red'; 
			error = "<tr><td class='fields'><span class='field_error'>- Voer een bericht in. <br /></span></td></tr>";
		} else {
			field.style.background = '#eee';
			field.style.border = '1px solid #cdcdcd'; 
		}
		return error;   
	}       
                     // Naam                        
	  function checkUsername(field2) {                                
			var error = "";                            
			   if (field2.value.length == 0) {   
                               
					field2.style.background = '#fdc1c3';
					field2.style.border = '1px solid red'; 
					error = "<tr><td class='fields'><span class='field_error'>- Voer een naam in.<br /> </span></td></tr>";                               
			   }else{
					field2.style.background = '#eee';
					field2.style.border = '1px solid #cdcdcd';   
			   }
						  
		   return error;                        
	  }                        
			   
	//Email                       
	function checkEmail (strng) {                               
		var error="";                               
		var emailFilter=/^.+@.+\..{2,3,4,5}$/;                               
                                     
			var illegalChars=/[\*\!\#\$\%\^\(\)\<\>\,\\;\:\\\"\[\]]/                                        
			   if (strng.value.match(illegalChars)) {     
			   		strng.style.background = '#fdc1c3';
					strng.style.border = '1px solid red';                                           
					error = "<tr><td class='fields'><span class='field_error'>- Het e-mailadres bevat verboden tekens.<br /> </span></td></tr>";                                       
				} else{
					strng.style.background = '#eee';
					strng.style.border = '1px solid #cdcdcd'; 	
				}                          
			 if (strng.value == "") {           
			 	strng.style.background = '#fdc1c3';	
				strng.style.border = '1px solid red';                             
				error = "<tr><td class='fields'><span class='field_error'>- Voer een e-mailadres in.<br /> </span></td></tr>" ;                             
			} else{
					strng.style.background = '#eee';
					strng.style.border = '1px solid #cdcdcd'; 	
			}                              
			 return error;                        
		}                        //Invoervak      
		                            
       </script>

</head>
<body>
<div class='main_container'>
	<div class='content_holder'>
		<div class='top'><div class='img_container'></div>
        </div>
        
        	<div class='navigation'>
			<?
			if(!isset($_GET['view_album']))
				$content->getMenuItems()?>
               </div>
               
           <div class="main_content">
            