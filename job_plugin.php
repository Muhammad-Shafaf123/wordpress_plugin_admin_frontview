<?php
/**
 * Plugin Name: custom post type Plugin
 * Plugin URI: https://www.example.com
 * Description: It is custom post type Plugin. for add the jobs.
 * Version: 0.1
 * Author: Muhammed Shafaf
 * Author URI: https://muhammad-shafaf123.github.io/personal/
 */

/**
* Exit if accessed directly
*/
if ( !defined( 'ABSPATH' ) ) {
       exit;
}
/**
* connect to pages.
*/
require_once( 'job-settings.php' );
require_once( 'job-content.php' );
require_once( 'job-record.php' );
if ( !class_exists( 'RootPluginClass' ) ) {
  /**
  *root class for creating custom taxomony.
  */
  class RootPluginClass {
    public function __construct() {
      add_action( 'init', array( $this, 'create_post_type_job' ) );
      add_action( 'add_meta_boxes', array( $this, 'meta_box_callback_qualification' ) );
      add_action( 'add_meta_boxes', array( $this, 'meta_box_callback_salary' ) );
      add_shortcode( 'display', array( $this, 'display_shortcode_post_type' ) );
    }
    /**
    * create custom post type.
    */
    public function create_post_type_job() {
      register_post_type('job-manage',
                          array($this, 'labels'=>
                          array($this,  'name'                  => 'Job Manage',
                                        'singular_name'         => 'jobs',
                                        'menu_name'             => 'Job Manage',
                                        'name_admin_bar'        => 'Jobs',
                                        'archives'              => 'ajfashionArchives',
                                        'attributes'            => 'Item Attributes',
                                        'parent_item_colon'     => 'Parent Item:',
                                        'all_items'             => 'All Items',
                                        'add_new_item'          => 'Add New Item',
                                        'add_new'               => 'Add New',
                                        'new_item'              => 'New Item',
                                        'edit_item'             => 'Edit Item',
                                        'update_item'           => 'Update Item',
                                        'view_item'             => 'View Item',
                                        'view_items'            => 'View Items',
                                        'search_items'          => 'Search Item',
                                        'not_found'             => 'Not found',
                                        'not_found_in_trash'    => 'Not found in Trash',
                                        'featured_image'        => 'Featured Image',
                                        'set_featured_image'    => 'Set featured image',
                                        'remove_featured_image' => 'Remove featured image',
                                        'use_featured_image'    => 'Use as featured image',
                                        'insert_into_item'      => 'Insert into item',
                                        'uploaded_to_this_item' => 'Uploaded to this item',
                                        'items_list'            => 'Items list',
                                        'items_list_navigation' => 'Items list navigation',
                                        'filter_items_list'     => 'Filter items list',),
                          'public' => true, 'has_archive' => true,
                          'taxonomies' => array( 'category', 'post_tag' ),
                          'rewrite'=> array($this, 'slug'=>'job-manage'),
                          )
                        );
    }
    /**
    * meta box for qualification
    */
    public function meta_box_callback_qualification() {
      add_meta_box('meta_1', 'Field', array($this, 'form_field_callback'),'job-manage');
    }
    /**
    * meta box for adding salary.
    */
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
    /**
    * function for creating field.
    */
    public function form_field_callback() {
      ?>
      <label for="Qualification">Qualification :</label><br />
      <input type="text" name="qualification_select" placeholder="Enter the qualification"/>
      <?php wp_nonce_field( 'nonce_action', 'nonce_field' );
    }
    /**
    * create shortcode function.
    */
    function display_shortcode_post_type(){
      $args = array(
                      'post_type'      => 'job-manage',
                      'posts_per_page' => '5',
                      'publish_status' => 'published',
                   );

      $query = new WP_Query($args);
      if($query->have_posts()) {
        $result = "";
        $link = get_option('first_field_id');
        $color = get_option('color_picker');
          while($query->have_posts()) {
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
          }
          wp_reset_postdata();
      }
      return $result;
    }
  }
}else {
    exit();
}
new RootPluginClass;
new ClassAdminSettings;
new ContentClass;
new ClassJobRecords;

 ?>
