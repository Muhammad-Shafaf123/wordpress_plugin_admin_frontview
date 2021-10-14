<?php
/*
 * Plugin Name: custom post type Plugin
 * Plugin URI: https://www.google.com
 * Description: It is custom post type Plugin. for add a jobs.
 * Version: 0.1
 * Author: Muhammed Shafaf
 * Author URI: https://www.facebook.com
 */

// connect to pages.
require_once('job-settings.php');
require_once('job-content.php');
// root class for creating custom taxomony.
class RootPluginClass {
  public function __construct() {
    add_action('init', array($this,'create_post_type'));
    add_action('add_meta_boxes', array($this, 'meta_box_callback_qualification'));
    add_action('add_meta_boxes' ,array($this, 'meta_box_callback_salary'));
    add_shortcode( 'display', array($this, 'display_shortcode_post_type'));
  }
  // create custom post type.
  public function create_post_type() {
    register_post_type('job-manage',
                        array($this, 'labels'=>
                        array($this, 'name'=>__('Job Manager'), 'singular_name' =>__('jobs')),
                        'public' => true, 'has_archive' => true,
                        'taxonomies' => array( 'category', 'post_tag' ),
                        'rewrite'=> array($this, 'slug'=>'job-manage'),
                        )
                      );
  }
  // meta box for qualification
  public function meta_box_callback_qualification() {
    add_meta_box('meta_1', 'Field', array($this, 'form_field_callback'),'job-manage');
  }
  // meta box for adding salary.
  public function meta_box_callback_salary() {
    add_meta_box('meta_id', 'Drop down', array($this, 'drop_down_meta_callback'),'job-manage');
  }
  public function drop_down_meta_callback() {
    ?>
      <label for="salary_type">Choose salary:</label>
      <select name="salary_types" id="salary_type">
      <option value="below - 10000">below 10000</option>
      <option value="10000 - 20000">10000 - 20000</option>
      <option value="30000 - 40000">30000 - 40000</option>
      <option value="above 40000">above 40000</option>
      <?php wp_nonce_field( 'nonce_action', 'nonce_field' ); ?>
      </select>
    <?php
  }
  // function for creating field.
  public function form_field_callback() {
    ?>
      <label for="Qualification">Qualification :</label><br />
      <input type="text" name="qualification_select" placeholder="Enter the qualification"/>
      <?php wp_nonce_field( 'nonce_action', 'nonce_field' );
  }


  function display_shortcode_post_type(){

    $args = array(
                    'post_type'      => 'job-manage',
                    'posts_per_page' => '5',
                    'publish_status' => 'published',
                 );

    $query = new WP_Query($args);

    if($query->have_posts()) :
      $result = "";
      $link = get_option('first_field_id');
      $color = get_option('color_picker');


        while($query->have_posts()) :

            $query->the_post() ;
            $permalink=get_permalink();

        $result .= '<div class="job-item">';
        $result .= '<style>span{color:red;}.job-name{font-weight: bold;}.link-permalink{color: '.$color.';} </style>';
        $result .= "<span>Name of the Company :".get_option('second_field_id')."</span><br>";
        $result .= '<div class="job-name"><a class="link-permalink" href='.$permalink.'>' . get_the_title() . '</a><br></div>';
        $result .= "Vist us : '<a href='.$link.'>".$link."</a><br>";
        $result .= "Job type :".get_option('job_type_radio_button')."<br>";
        $result .= "Description :".get_option('third_field_id')."<br><br>";

        $result .= '</div>';

        endwhile;

        wp_reset_postdata();

    endif;

    return $result;
}




}

new RootPluginClass;
new ClassAdminSettings;
new ContentClass;

 ?>
