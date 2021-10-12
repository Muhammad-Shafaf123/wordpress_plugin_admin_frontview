<?php

/**
 *
 */
class ContentClass{
  function __construct(){
    add_action('save_post', array($this,'save_post_datas_qualification'));
    add_action('save_post', array($this,'save_post_datas_salary'));
    add_action('the_content',array($this, 'display_post_content_qualification'));
    add_action('the_content',array($this, 'display_post_content_salary'));
  }

  //update_post_meta, add the field to database.
  public function save_post_datas_qualification($post_id){
    if (! isset( $_POST['nonce_field'] ) || ! wp_verify_nonce( $_POST['nonce_field'], 'nonce_action' )) {
       wp_nonce_ays( 'Invalid user' );
    } else {
      if(isset($_POST['qualification_select'])){
        update_post_meta($post_id,'qualification_meta_key',$_POST['qualification_select']);
      }
    }

  }
  // display the content,qualification.
  public function display_post_content_qualification($content){
    global $post;
    $get_data = get_post_meta ($post->ID, "qualification_meta_key",true);
    if(!empty($get_data)){
      $custom_message = "Qualification : ".$get_data."<br>";
      $content = $custom_message . $content;
    }

    return $content;
  }

  public function save_post_datas_salary($post_id){
    if (! isset( $_POST['nonce_field'] ) || ! wp_verify_nonce( $_POST['nonce_field'], 'nonce_action' )) {
       wp_nonce_ays( 'Invalid user' );
    } else {if(isset($_POST['salary_types'])){
      update_post_meta($post_id,'salary_meta_key',$_POST['salary_types']);
    }
    }
  }

  // display the content,salary.
  public function display_post_content_salary($content){
    global $post;
    $get_data = get_post_meta ($post->ID, "salary_meta_key",true);
    if(!empty($get_data)){
      $custom_message = "Salary : ".$get_data."<br>";
      $content = $custom_message . $content;
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
