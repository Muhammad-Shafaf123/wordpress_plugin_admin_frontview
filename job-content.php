<?php
class ContentClass {
  function __construct() {
    add_action('save_post', array($this, 'save_post_datas_qualification'));
    add_action('save_post', array($this, 'save_post_datas_salary'));
    add_filter('the_content', array($this, 'display_post_content_qualification'));
    add_filter('the_content', array($this, 'display_post_content_salary'));
    add_filter('the_content', array($this, 'display_post_content_submit_button'));
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


  public function display_post_content_submit_button($content){
    if(!is_single()){
      return $content;
    }

    $form_buttton = "<input type='button' value='Apply this job' id='button' >";
    $form_buttton .= "</div>";
    $content .= $form_buttton;

    return $content;
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
}



 ?>
