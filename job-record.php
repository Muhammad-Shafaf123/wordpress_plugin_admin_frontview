<?php
class ClassJobRecords{
  public function __construct(){
    add_action('init', array($this,'create_post_type_job_list'));
    add_action('wp_ajax_set_form', array($this,'set_form' ));    //execute when wp logged in
    add_action('wp_ajax_nopriv_set_form', array($this,'set_form')); //execute when logged out
  }

  //create custom post type.
  public function create_post_type_job_list() {
      register_post_type('job-list',
                         array($this, 'labels'=>
                         array($this, 'name'=>__('Job List'), 'singular_name' =>__('job')),
                         'public' => true, 'has_archive' => true,
                         'rewrite'=> array($this, 'slug'=>'job-manage'),
                         )
                       );
  }

  // get ajax data.
  public function set_form(){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];


  $insert_data = array(
   'post_title'=>$name,
   'post_content'=>$message,
   'post_status'=>'draft',
   'post_type'=> 'job-list'
  );
  
  $post_id = wp_insert_post($insert_data);
  sanitize_text_field($message);
  update_post_meta($post_id, 'email_key', $email);
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
}

 ?>
