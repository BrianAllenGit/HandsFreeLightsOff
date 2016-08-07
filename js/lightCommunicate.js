$(document).ready(function(){
  console.log("ready!");
  //On initial page load, get states of lights and set button class accordingly
  $.ajax({
          url: 'initialSetup.php',
          data: {},
          method: 'POST',
          dataType: 'json',
          success: function(data) {
             var i;
             for(i = 0; i < data.length; i++){
               if(data[i] == 0){
                 $(".b"+i).addClass("btn-danger-outline").removeClass("btn-success-outline").html('Off');
               }else{
                 $(".b"+i).addClass("btn-success-outline").removeClass("btn-danger-outline").html('On');
               }   
             } 
          },
          error: function(jqXHR, textStatus, errorThrown, data) {
             console.log(textStatus, errorThrown);
          }
  });//EO of ajax


  //attach event listener to each button
  $( "button" ).each(function( index ) {  
  
    $(this).click(function(){
       console.log($(this).html());
      $.ajax({
          url: 'lightController.php',
          data: { lightNum: index },//send index of light
          method: 'POST',
          dataType: 'json',
          success: function(data) {
             //if state of light is "off" set class to "btn-danger-outline" and make inner text "off"
             if(data["state"] == 0){
               $(".b"+index).addClass("btn-danger-outline").removeClass("btn-success-outline").html('Off');  
             }
             //if state of light is "on" set class to "btn-success-outline" and make inner text "On"
             else{
               $(".b"+index).addClass("btn-success-outline").removeClass("btn-danger-outline").html('On');  
             }

          },
          error: function(jqXHR, textStatus, errorThrown, data) {
             console.log(textStatus, errorThrown);
          }
       });//EO of ajax
           
     });//EO click
  });//EO each

});//EO doc ready
