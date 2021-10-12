<?php

class ClassAdminSettings{
  function __construct(){
    add_action('admin_menu',array($this, 'sub_admin_menu'));
    add_action( 'admin_init', array( $this, 'setup_sections' ) );
    add_action( 'admin_init', array( $this, 'setup_fields' ) );
  }

  public function setup_sections() {
    add_settings_section( 'our_first_section', 'My First Section Title',
                        array( $this, 'section_callback' ), 'smashing_fields' );
    add_settings_section( 'our_second_section', 'My Second Section Title',
                        array( $this, 'section_callback' ), 'smashing_fields' );
    add_settings_section( 'our_third_section', 'My Third Section Title',
                        array( $this, 'section_callback' ), 'smashing_fields' );
  }

  public function section_callback( $arguments ) {
    switch( $arguments['id'] ){
        case 'our_first_section':
            echo 'This is the first description here!';
            break;
        case 'our_second_section':
            echo 'This one is number two';
            break;
        case 'our_third_section':
            echo 'Third time is the charm!';
            break;
    }
}

public function setup_fields() {
    add_settings_field( 'our_first_field', 'Field Name',
      array( $this, 'field_callback' ), 'smashing_fields', 'our_first_section' );
}
public function field_callback( $arguments ) {
    echo '<input name="our_first_field" id="our_first_field"
          type="text" value="' . get_option( 'our_first_field' ) . '" />';
    register_setting( 'smashing_fields', 'our_first_field' );
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
      <div class="wrap" action="options.php">
          <h2>My Awesome Settings Page</h2>
          <form method="post">
            <?php
                settings_fields( 'smashing_fields' );
                do_settings_sections( 'smashing_fields' );
                submit_button();
            ?>
          </form>
      </div> <?php
  }


  function write_log ( $log )  {
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
