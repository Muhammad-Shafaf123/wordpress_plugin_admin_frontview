jQuery(document).ready(function($){
$('form.ajax').on('submit', function(e){
   e.preventDefault();
   var that = $(this),
   url = that.attr('action'),
   type = that.attr('method');
   var firstname = $('.first-name').val();
   var lastname = $('.last-name').val();
   var qualifiction = $('.qualifiction').val();
   var phone = $('.phone-no').val();
   var email = $('.email-id').val();
   $.ajax({
      url: cpm_object.ajax_url,
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
$('.ajax')[0].reset();
  });
});

function sample(){
  console.log("hello..!");
  document.getElementById("fn").style.display = "block";

}
