<?php

class ClassAdminSettings {
  function __construct() {
    add_action('admin_menu', array($this, 'sub_admin_menu'));
    add_action('admin_init', array($this, 'setup_sections'));
    add_action('admin_init', array($this, 'setup_fields'));
  }
  //create section
  public function setup_sections() {
    add_settings_section('first_section', 'General Settings',
                        array($this, 'section_callback'), 'jobs');

  }
  public function section_callback($arguments) {
    if($arguments['id']){
      echo "section details.";
    }
  }
  public function setup_fields() {
      add_settings_field('first_field_id', 'Common Link :',
      array($this, 'common_link_field_callback'), 'jobs', 'first_section');
      add_settings_field('second_field_id', 'Company Name',
      array($this, 'text_area_field_callback'), 'jobs', 'first_section');
      add_settings_field('third_field_id', 'Job Type',
      array($this, 'job_type_field_callback'), 'jobs', 'first_section');
      add_settings_field('fourth_field_id', 'Instructions',
      array($this, 'instruction_area_field_callback'), 'jobs', 'first_section');
      register_setting('sample', 'first_field_id');
      register_setting('sample', 'second_field_id');
      register_setting('sample', 'third_field_id');
      register_setting('sample', 'fourth_field_id');


  }
  public function common_link_field_callback($arguments) {
      ?>
      <input name="common_link_name" id="common_link_name"
             type="text" placeholder="www.companyname.com"  value="<?php get_option('first_field_id') ?>"/>'
      <?php
  }
  public function text_area_field_callback($arguments) {
      ?>
      <input name="common_link_name" id="common_link_name"
             type="text" placeholder="Conpany Name"  value="<?php get_option('second_field_id') ?>"/>'
      <?php
  }
  public function instruction_area_field_callback($arguments) {
      ?>
      <textarea id="instructio_text" name="instructio_text" rows="4" cols="50">
     </textarea>
      <?php
  }
  public function job_type_field_callback($arguments) {
      ?>
      <input type="radio" name="job-full-checked" value="<?php get_option('four_field_id') ?>">full time
      <input type="radio" name="job-part-checked" value="">part time
      <?php
  }
  //create submenu.
  function sub_admin_menu() {
  add_submenu_page('edit.php?post_type=job-manage',
                    'wpautop-control',
                    'Settings',
                    'administrator',
                    'settings',
                    array($this,'call_back'));
  }
  //call back function for settings.
    public function call_back() { ?>
       <div class="wrap">
          <h2>My Awesome Settings Page</h2>
          <form method="post" action="options.php">
            <?php
                settings_fields('sample');
                do_settings_sections('jobs');
                submit_button();
            ?>
          </form>
      </div> <?php
  }


  function write_log($log) {
		if(true === WP_DEBUG) {
			if(is_array($log) || is_object($log)) {
				error_log(print_r($log, true));
			}else {
				error_log($log);
			}
		}
	}
}
 ?>
