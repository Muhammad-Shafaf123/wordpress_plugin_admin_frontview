<?php
class ContentClass {
  function __construct() {
    add_action('save_post', array($this, 'save_post_datas_qualification'));
    add_action('save_post', array($this, 'save_post_datas_salary'));
    add_filter('the_content', array($this, 'display_post_content_qualification'));
    add_filter('the_content', array($this, 'display_post_content_salary'));
    add_filter('the_content', array($this, 'display_post_content_submit_button'));
    add_action('init',array($this,'ajax_form_scripts'));
    add_action('wp_ajax_set_form', array($this,'set_form' ));    //execute when wp logged in
    add_action('wp_ajax_nopriv_set_form', array($this,'set_form')); //execute when logged out

  }
  //update_post_meta, add the field to database.
  public function save_post_datas_qualification($post_id) {
    if (! isset($_POST['nonce_field']) || ! wp_verify_nonce($_POST['nonce_field'],
        'nonce_action')) {
          return $post_id;
    }
    if(isset($_POST['qualification_select'])) {
        update_post_meta($post_id,'qualification_meta_key', $_POST['qualification_select']);
    }
  }

  // update_post_meta, add the field to database.
  public function save_post_datas_salary($post_id) {
    if (! isset( $_POST['nonce_field']) || ! wp_verify_nonce($_POST['nonce_field'],
        'nonce_action')) {
          return $post_id;
    }
    if(isset($_POST['salary_types'])) {
        update_post_meta($post_id,'salary_meta_key',$_POST['salary_types']);
    }
  }

  //  function for form file connection.$this->write_log();
  public function ajax_form_scripts() {
    wp_register_script( "job-action", plugin_dir_url( __FILE__ )."job-action.js",array("jquery"));
    wp_localize_script( 'job-action', 'form_object',array('ajax_url' => admin_url( 'admin-ajax.php')));

    wp_enqueue_script( 'jquery');
    wp_enqueue_script('job-action');

  }
  // callback for creating form.
  public function display_post_content_submit_button($content){
    if(!is_single()){
      return $content;
    }
    //apply button.
    $form_buttton = "<input onclick='applay_button()' type='button' value='Apply this job' id='button' >";
    $form_buttton .= "</div>";
    $content .= $form_buttton;
    // html form.
    $submit_form = "<div id='fn' hidden><form action='' method='post' class='ajax'>";
    $submit_form .= "<label for='name'>name:</label><br>";
    $submit_form .= "<input type='text' placeholder='Enter Your Name' name='name' required class='name'><br>";
    $submit_form .= "<label for='email'>Email:</label><br>";
    $submit_form .= "<input type='email' placeholder='Enter your Email' name='email' required class='email'><br><br>";
    $submit_form .= "<label for='Message'>Message:</label><br>";
    $submit_form .= "<input type='textarea' placeholder='Message' name='message' required class='message'><br><br>";
    $submit_form .= "<div class='success' placeholder='Message' name='message' required class='message'><br><br>";
    $submit_form .= "<input type = 'submit' class='submitbtn' value='submit'> </form></div>";

    return $content.$submit_form;
  }


  // display the content,qualification.
  public function display_post_content_qualification($content) {
    if(!is_single()){
      return $content;
    }
    global $post;
    $get_data = get_post_meta($post->ID, "qualification_meta_key", true);
    if(!empty($get_data)) {
      $custom_message = "Qualification : ".$get_data."<br>";
      $content =  $content . $custom_message ;
    }
    return $content;
  }

  // display the content,salary.
  public function display_post_content_salary($content) {
    if(!is_single()){
      return $content;
    }
    global $post;
    $get_data = get_post_meta($post->ID, "salary_meta_key", true);
    if(!empty($get_data)){
      $custom_message = "Salary : ".$get_data."<br>";
      $content .= $custom_message;
    }
    return $content;
  }


  // write log function.
	public function write_log ( $log )  {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}



  public function set_form(){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];
	$admin =get_option('admin_email');
  $this->write_log($email);
	// wp_mail($email,$name,$message);  main sent to admin and the user
	if(wp_mail($email, $name, $message)  &&  wp_mail($admin, $name, $message) )
       {
           echo "mail sent";
   } else {
          echo "mail not sent";
   }
	die();

}
}



 ?>
