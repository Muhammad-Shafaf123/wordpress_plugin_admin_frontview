<?php
/*
 * Plugin Name: custom post type Plugin
 * Plugin URI: https://www.google.com
 * Description: It is custom post type Plugin. for add a jobs.
 * Version: 0.1
 * Author: Muhammed Shafaf
 * Author URI: https://www.facebook.com
 */

// root class for creating custom taxomony.
class CustomTaxomony{
  public function __construct(){
    add_action('init',array($this,'create_post_type'));
    add_action('add_meta_boxes',array($this, 'meta_box_callback'));
    add_action('admin_menu',array($this, 'sub_admin_menu'));
    add_action( 'save_post', array($this,'save_post_data'));

  }
  public function create_post_type(){
    register_post_type('job-manage',
                        array($this, 'labels'=>
                        array($this,'name'=>__('Job Manager'),'singular_name' =>__('jobs')),
                        'public' => true,'has_archive' => true, 'rewrite'=>
                        array($this,'slug'=>'job-manage'),
                        )
                      );
  }
  public function meta_box_callback(){
    add_meta_box('meta_1', 'sample field', array($this, 'form_field_callback'));
  }
  public function form_field_callback(){
    ?>
    <form  action="" method="post">
      <label for="job types">job types</label><br />
      <input type="checkbox" name="full_time" value="full_time"/>
      <label for="full_time">full time</label><br />
      <input type="checkbox" name="part_time" value="part_time"/>
      <label for="part_time">part time</label><br />
      <input type="checkbox" name="trainee" value="trainee"/>
      <label for="job types">trainee</label><br />
      <input type="checkbox" name="intership" value="intership" />
      <label for="job types">intership</label><br />
    </form>
    <?php
  }
  public function sub_admin_menu() {
  add_submenu_page('edit.php?post_type=job-manage',
                    'wpautop-control',
                    'Settings',
                    'administrator',
                    'settings',
                    array($this,'call_back'));
  }
  public function call_back(){
    echo "hai";
  }
  public function save_post_data(){
    if (isset($_POST['full_time'])) {
        update_post_meta($post_id,'job_type_meta_key',$_POST['full_time']);
  }
}

new  CustomTaxomony;

 ?>
