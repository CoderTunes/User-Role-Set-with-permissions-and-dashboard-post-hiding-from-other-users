//User  Role
function addUserRole() {
       add_role( 'morder-maker', 'Shop Order Maker', array( 'read' => true, 'level_7' => true ) );
   }
add_action( 'init', 'addUserRole', 0 );

//capability set
function add_theme_caps() {
    $role = get_role( 'morder-maker' );
    $role->add_cap( '' ); 
}
add_action( 'admin_init', 'add_theme_caps');

//hidding all from other users except admin
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
