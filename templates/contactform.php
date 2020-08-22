<!-- static contact form -->
<h1><?=$page;?></h1>
<div class='contact_content'>
<form id="contact" action="" onSubmit="return checkWholeForm(this);" method="post">                        
    <div id='field_input'></div>
    <table cellpadding="3" width="98%">  <tr><td>
        <input type='hidden' value='bla' name='send_info' /> 
       </td></tr>
        <!-- onclick="this.value='';" onfocus="this.select()" onblur="this.value=!this.value?'Naam':this.value;" -->                    
        <tr><td>Naam:  <? if(isset($error['name'])) echo $error['name'];?></td></tr>
        <tr><td><input type="text" class='field' name="name"  value="<? if(isset($_POST['name'])) echo $_POST['name']?>" /> </td></tr>
        <tr><td>E-mail: <? if(isset($error['email'])) echo $error['email'];?></td></tr> 
        <tr><td><input type="text" class='field' name="email" value="<? if(isset($_POST['email'])) echo $_POST['email']?>" /></td></tr>  
        <tr><td>Bericht: <? if(isset($error['message'])) echo $error['message'];?></td></tr>                              
        <tr><td><textarea class='area' name="message" id="textarea" rows="4" cols="20"><? if(isset($_POST['message'])) echo $_POST['message']?></textarea></td></tr>
        <tr><td><input type="submit" name="submit" id="submit" value="Versturen" /> </td></tr>
    </table>                
</form>
</div>

