<?php
if ( !class_exists( 'ClassAdminSettings' ) ) {
  class ClassAdminSettings {
    function __construct() {
      add_action('admin_menu', array($this, 'sub_admin_menu'));
      add_action('admin_init', array($this, 'setup_sections'));
      add_action('admin_init', array($this, 'setup_fields'));
    }
    /**
    * create section
    */
    public function setup_sections() {
      add_settings_section('first_section', 'General Settings',
                          array($this, 'section_callback'), 'settings');

    }
    public function section_callback($arguments) {
      if($arguments['id']){
        echo "section details.";
      }
    }
    public function setup_fields() {
        add_settings_field('first_field_id', 'Common Link :',
        array($this, 'common_link_field_callback'), 'settings', 'first_section');
        add_settings_field('second_field_id', 'Company Name',
        array($this, 'text_area_field_callback'), 'settings', 'first_section');
        add_settings_field('third_field_id', 'Job Type',
        array($this, 'job_type_field_callback'), 'settings', 'first_section');
        add_settings_field('job_type_radio_button', 'Instructions',
        array($this, 'instruction_area_field_callback'), 'settings', 'first_section');
        add_settings_field('color_picker', 'Select Color :',
        array($this, 'color_picker_callback'), 'settings', 'first_section');
        register_setting('settings', 'first_field_id');
        register_setting('settings', 'second_field_id');
        register_setting('settings', 'third_field_id');
        register_setting('settings', 'job_type_radio_button');
        register_setting('settings', 'color_picker');
    }
    public function common_link_field_callback($arguments) {

        ?>
        <input name="first_field_id" id="common_link_name"
               type="text" placeholder="www.companyname.com"
               value="<?php $display_company_name= get_option('first_field_id'); echo $display_company_name;?>"/>
        <?php
    }
    public function text_area_field_callback($arguments) {
        ?>
        <input name="second_field_id" id="common_link_name"
               type="text" placeholder="Conpany Name"
                value="<?php $display_company_link = get_option('second_field_id'); echo $display_company_link;?>"/>'
        <?php
    }
    public function instruction_area_field_callback($arguments) {
        ?>
        <textarea id="instructio_text" name="third_field_id" rows="4" cols="50">
       </textarea>
        <?php
    }
    public function job_type_field_callback($arguments) {
      $get_field_id1 =  get_option('job_type_radio_button');
      $get_field_id2 = get_option('job_type_radio_button');
        ?>
        <input type="radio" name="job_type_radio_button" value="full time"><?php
        $get_field_id1 =  checked('full time',$get_field_id1); ?>full time
        <input type="radio" name="job_type_radio_button" value="part time"><?php
        $get_field_id2 = checked('part time',$get_field_id2); ?>part time
        <?php
    }
    public function color_picker_callback(){
      ?>
      <label for="favcolor">Select your favorite color:</label>
      <input type="color" id="color_picker" name="color_picker"
      value="<?php $color_value = get_option('color_picker'); echo $color_value; ?>">
      <?php
    }
    /**
    * create submenu.
    */
    function sub_admin_menu() {
    add_submenu_page('edit.php?post_type=job-manage',
                      'wpautop-control',
                      'Settings',
                      'administrator',
                      'settings',
                      array($this,'call_back'));
    }
    /**
    * call back function for settings.
    */
      public function call_back() { ?>
         <div class="wrap">
            <h2>My Awesome Settings Page</h2>
            <form method="post" action="options.php">
              <?php
                  settings_fields('settings');
                  do_settings_sections('settings');
                  submit_button();
              ?>
            </form>
        </div> <?php
    }
  }
}else {
    exit();
}
 ?>
