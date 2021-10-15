jQuery(document).ready(function($){
$('form.ajax').on('submit', function(e){
   e.preventDefault();
   var that = $(this),
   url = that.attr('action'),
   type = that.attr('method');
   var name = $('.name').val();
   var email = $('.email').val();
   var message = $('.message').val();
   console.log(name);
   console.log(email);
   console.log(message);
   if (name!="" || email !="" || message!=""){
     alert("Form submitted");
   }else {
     console.log("not")
   }
   $.ajax({
      url: form_object.ajax_url,
      type:"POST",
      dataType:'type',
      data: {
         action:'set_form',
         name:name,
         email:email,
         message:message,
    },   success: function(response){
        $(".success_msg").css("display","block");
     }, error: function(data){
         $(".error_msg").css("display","block");      }
   });
   console.log(name);
$('.ajax')[0].reset();
  });
});

function applay_button(){
  console.log("button clicked..");
  document.getElementById("fn").style.display = "block";

}
