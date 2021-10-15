jQuery(document).ready(function($){
$('form.ajax').on('submit', function(e){
   e.preventDefault();
   var that = $(this),
   url = that.attr('action'),
   type = that.attr('method');
   var name = $('.name').val();
   var email = $('.email').val();
   var message = $('.message').val();
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
        $('.success_message').css('display','block');
     }, error: function(data){
         $('.success_message').css('display','block').append("<h6>name :"+name+"</h6><h6>email :"+email+"</h6><h6>massage : "+message+"</h6>");     }
   });
$('.ajax')[0].reset();
  });
});

function applay_button(){
  console.log("button clicked..");
  document.getElementById("fn").style.display = "block";

}
