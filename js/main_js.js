                    						 
	 function checkWholeForm(Contact) {                                
	 	var leeg = "";    
		var error;                                                         
			leeg += checkUsername(Contact.name);                                        
			leeg += checkEmail(Contact.email);                                        
			leeg += isEmpty(Contact.textarea);                                       
			//alert(leeg);
			if(leeg !== ""){
				document.getElementById('field_input').innerHTML=leeg;
				return false;                               
		 	}
	
			return true;
	}                
	function isEmpty(field) {
		var error = "";
	  
		if (field.value.length === 0) {
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
			   if (field2.value.length === 0) {   
                               
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
			 if (strng.value === "") {           
			 	strng.style.background = '#fdc1c3';	
				strng.style.border = '1px solid red';                             
				error = "<tr><td class='fields'><span class='field_error'>- Voer een e-mailadres in.<br /> </span></td></tr>" ;                             
			} else{
					strng.style.background = '#eee';
					strng.style.border = '1px solid #cdcdcd'; 	
			}                              
			 return error;                        
		}                        //Invoervak      
