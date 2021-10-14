<?php
class ContentClass {
  function __construct() {
    add_action('save_post', array($this, 'save_post_datas_qualification'));
    add_action('save_post', array($this, 'save_post_datas_salary'));
    add_filter('the_content', array($this, 'display_post_content_qualification'));
    add_filter('the_content', array($this, 'display_post_content_salary'));
    add_filter('the_content', array($this, 'display_post_content_submit_button'));
    add_action('wp_enqueue_scripts',array($this,'javascript_file_callback'));
    add_action('wp_ajax_set_form', 'set_form' );    //execute when wp logged in
    add_action('wp_ajax_nopriv_set_form', 'set_form'); //execute when logged out

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
  public function javascript_file_callback() {
    $translation_array = array(
        'ajax_url' => admin_url( 'admin-ajax.php' )
    );
    wp_localize_script( 'main', 'cpm_object', $translation_array );
      wp_enqueue_script( 'ava-test-js', plugins_url( 'job-action.js', __FILE__ ));
  }

  public function display_post_content_submit_button($content){
    if(!is_single()){
      return $content;
    }

    $form_buttton = "<input onclick='sample()' type='button' value='Apply this job' id='button' >";
    $form_buttton .= "</div>";
    $content .= $form_buttton;

    $submit_form = "<div id='fn' hidden><form action="" method='post' class='ajax' enctype='multipart/form-data'>
                    <label for='first-name'>First name:</label><br>";
    $submit_form .= "<input type='text' id='first-name' name='first-name' placeholder='john' value=''><br>";
    $submit_form .= "<label for='last-name'>Last name:</label><br>";
    $submit_form .= "<input type='text' id='last-name' name='last-name' placeholder='Doe' value=''><br><br>";
    $submit_form .= "<label for='qualifiction'>Qualification:</label><br>";
    $submit_form .= "<input type='text' id='qualifiction' name='qualifiction' placeholder='Degree' value=''><br><br>";
    $submit_form .= "<label for='phone-no'>Phone No:</label><br>";
    $submit_form .= "<input type='text' id='phone-no' name='phone-no' placeholder='7245645323' value=''><br><br>";
    $submit_form .= "<label for='Email-id'>Email Id:</label><br>";
    $submit_form .= "<input type='email' id='email-id' name='email-id' placeholder='example@gmail.com' value=''><br><br>";
    $submit_form .= "<input type='submit' value='Submit'> </form></div>";

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



  function set_form(){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];
	$admin =get_option('admin_email');
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
