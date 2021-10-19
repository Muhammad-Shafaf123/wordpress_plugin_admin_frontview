<?php
if ( !class_exists( 'ClassJobRecords' ) ) {
  class ClassJobRecords{
    public function __construct() {
      add_action( 'init', array( $this,'create_post_type_job_list' ) );
      add_action( 'wp_ajax_validate_form', array( $this,'validate_form' ) );
      add_action( 'wp_ajax_nopriv_validate_form', array($this,'validate_form'));
    }

    /**
    * create custom post type.
    */
    public function create_post_type_job_list() {
        register_post_type('job-list',
                           array($this, 'labels'=>
                           array($this, 'name'=>__('Job List'), 'singular_name' =>__('job')),
                           'public' => true, 'has_archive' => true,
                           'rewrite'=> array($this, 'slug'=>'job-list'),
                           )
                         );
    }
    /**
    * get ajax data.
    */
    public function validate_form(){
  	     $name = $_POST['name'];
  	     $email = $_POST['email'];
  	     $message = $_POST['message'];
         $job_title = $_POST['job_title'];
         $job_title = "Category : ".$job_title." <br>Email Address : ".$email."<br>";
         $insert_data = array(
           'post_title'=>$name,
           'post_content'=>$job_title.$message,
           'post_status'=>'draft',
           'post_type'=> 'job-list'
        );
        $post_id = wp_insert_post($insert_data);
        $email_field = sanitize_email($email);
        update_post_meta($post_id, 'email_key', $email_field);
    }
  }
}else {
    exit();
}
 ?>
