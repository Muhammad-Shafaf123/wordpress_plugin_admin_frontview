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
    <label for="fname">First name:</label><br>
    <input type="text" id="fname" name="fname" value="John"><br>
    <label for="lname">Last name:</label><br>
    <input type="text" id="lname" name="lname" value="Doe"><br><br>
    <input type="submit" value="Submit">
    <?php
  }
  
}

new CustomTaxomony();

 ?>
