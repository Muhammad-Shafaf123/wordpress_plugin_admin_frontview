<?php
if ( !class_exists( 'ContentClass' ) ) {
  class ContentClass {
    function __construct() {
      add_action('save_post', array($this, 'save_post_datas_qualification'));
      add_action('save_post', array($this, 'save_post_datas_salary'));
      add_filter('the_content', array($this, 'display_post_content_qualification'));
      add_filter('the_content', array($this, 'display_post_content_salary'));
      add_filter('the_content', array($this, 'display_post_content_submit_button'));
      add_action('init',array($this,'ajax_form_scripts'));
    }
    /**
    * update_post_meta, add the field to database.
    */
    public function save_post_datas_qualification($post_id) {
      if (! isset($_POST['nonce_field']) || ! wp_verify_nonce($_POST['nonce_field'],
          'nonce_action')) {
            return $post_id;
      }
      if ( !current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
      }
      if ( isset( $_POST['qualification_select'] ) ) {
        $data_qualification_test = sanitize_text_field( $_POST['qualification_select'] );
        update_post_meta($post_id,'qualification_meta_key', $data_qualification_test);
      }
    }
    /**
    * update_post_meta, add the field to database.
    */
    public function save_post_datas_salary( $post_id ) {
      if ( ! isset( $_POST['nonce_field']) || ! wp_verify_nonce($_POST['nonce_field'],
          'nonce_action' ) ) {
            return $post_id;
      }
      if ( !current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
      }
      if ( isset( $_POST['salary_types'] ) ) {
        $data_salary_types = sanitize_text_field( $_POST['salary_types'] );
        update_post_meta( $post_id,'salary_meta_key',$data_salary_types );
      }
    }
    /**
    *  function for form file connection.
    */
    public function ajax_form_scripts() {
      wp_register_script( "job-action", plugin_dir_url( __FILE__ )."job-action.js",array( "jquery" ) );
      wp_localize_script( 'job-action', 'form_object',array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
      wp_enqueue_script( 'jquery' );
      wp_enqueue_script( 'job-action' );
    }
    /**
    * callback for creating job application form.
    */
    public function display_post_content_submit_button( $content ){
      if( !is_singular('job-manage') ) {
        return $content;
      }
      $job_title = get_the_title();
      /**
      * apply button.
      */
      $form_buttton = "<input class='content' onclick='applay_button()' type='button' value='Apply this job' id='button' >";
      $form_buttton .= "</div>";
      $content .= $form_buttton;
      /**
      * when click apply button, to show the form
      */
      $submit_form = "<div id='fn' hidden><form action='' method='post' class='apply'>";
      $submit_form .= "<label for='name'>name:</label><br>";
      $submit_form .= "<input type='text' placeholder='Enter Your Name' name='name' required class='name'><br>";
      $submit_form .= "<label for='email'>Email:</label><br>";
      $submit_form .= "<input type='email' placeholder='Enter your Email' name='email' required class='email'><br><br>";
      $submit_form .= "<label for='Message'>Message:</label><br>";
      $submit_form .= "<input type='textarea' placeholder='Message' name='message' required class='message'><br><br>";
      $submit_form .= "<input name='job_title'  class='job_title' value='$job_title' hidden><br><br>";
      $submit_form .= "<input type = 'submit' id='show-popup-btn' onclick='togglePopup()' class='submitbtn' value='submit'> </form></div>";
      $submit_form .= "<div class='success_message' style='display: none'>Message Sent Successfully</div><br><br>";
      $sample = "<script>for (let i = 0; i < 11; i++) {
                  console.log('hai')
                  }</script>";
      return $content.$sample.$submit_form;
    }
    /**
    * display the content,qualification.
    */
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

    /**
    * display the content,salary.
    */
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
  }
}else {
    exit();
}
 ?>
