<?php
//User  Role
function addUserRole() {
       add_role( 'store-manager', 'Store Manager', array( 'read' => true, 'level_7' => true ) );
   }
add_action( 'init', 'addUserRole', 0 );

//capability set
function add_theme_caps() {
    $role = get_role( 'store-manager' );
    $role->add_cap( '' ); 
}
add_action( 'admin_init', 'add_theme_caps');

//hidding menu all from other users except admin
function currentAuthor($query) {
	global $pagenow;
	if( 'edit.php' != $pagenow || !$query->is_admin )
	    return $query;

	if( !current_user_can( 'manage_options' ) ) {
		global $user_ID;
		$query->set('author', $user_ID );
	}
	return $query;
}
add_filter('pre_get_posts', 'currentAuthor');



add_action( 'admin_init', 'removeMenuPages' );
function removeMenuPages() {
    global $user_ID;
    if ( current_user_can( 'store-manager' ) ) {
    remove_menu_page( 'edit.php' );
    remove_menu_page( 'tools.php' );
    remove_menu_page( 'edit-comments.php' );
    remove_menu_page( 'edit.php?post_type=services' );
    remove_menu_page( 'edit.php?post_type=testimonial' );
    remove_menu_page( 'edit.php?post_type=faq' );
    remove_menu_page( 'edit.php?post_type=logo' );
    remove_menu_page( 'edit.php?post_type=featurestab' );
    remove_menu_page( 'edit.php?post_type=portfolios' );
    remove_menu_page( 'edit.php?post_type=sliders' );
    remove_menu_page( 'edit.php?post_type=easymediagallery' );
    remove_menu_page("admin.php?page=wpcf7");
    }
}


//hiding contact menu
function remove_contact_menu () {
	if(current_user_can( 'store-manager' ) ) {
global $menu;
	$restricted = array(__('Contact'));
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
	}
}
add_action('admin_menu', 'remove_contact_menu');
