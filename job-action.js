jQuery(document).ready(function($){
$('form.apply').on('submit', function(e){
   e.preventDefault();
   var that = $(this),
   url = that.attr('action'),
   type = that.attr('method');
   var name = $('.name').val();
   var email = $('.email').val();
   var job_title = $('.job_title').val();
   var message = $('.message').val();
   $.ajax({
      url: form_object.ajax_url,
      type:"POST",
      dataType:'text',
      data: {
         action:'validate_form',
         name:name,
         email:email,
         job_title:job_title,
         message:message,
    },   success: function(response){
        $('.success_message').css('display','block').append("<h6>name :"+name+"</h6><h6>email :"+email+"</h6><h6>massage : "+message+"</h6>");
     }, error: function(data){
         $('.success_message').css('display','block');     }
   });
$('.apply')[0].reset();
  });
  
});








function applay_button(){
  document.getElementById("fn").style.display = "block";
}
