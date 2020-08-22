/* ------------------------------------------------------------------------
	Algemene JS file
	Copyright Ronald-designs
------------------------------------------------------------------------- */
<!--
function hideYear(id,img_id){
	 var div = document.getElementById(id);
	 var img = document.getElementById(img_id);

     if ( div.style.display != 'none' ) {
           div.style.display = 'none';
           img.src = "images/arrow_right.gif";
     }
     else {
          div.style.display = 'block';
          img.src = "images/arrow.gif";
     }
}

$(function() {
  $( "#edit div" ).draggable({ 
    stack: "#set div",
      stop: function(event, ui) {
          var pos_x = ui.offset.left;
          var pos_y = ui.offset.top;
          var need = ui.helper.data("need");
          
          console.log(pos_x);
          console.log(pos_y);
          console.log(need);
          
          //Do the ajax call to the server
          $.ajax({
              type: "POST",
              url: "save_position.php",
              data: { x: pos_x, y: pos_y, need_id: need}
            }).done(function( msg ) {
              alert( "Data Saved: " + msg );
            }); 
      }
  });
});


-->
