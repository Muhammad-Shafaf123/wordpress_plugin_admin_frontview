<?php

class ClassAdminSettings{
  function __construct(){
    add_action('admin_menu',array($this, 'sub_admin_menu'));
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
  public function call_back(){
    echo "hello";
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
