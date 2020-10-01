<?php
/**
* Plugin Name: Radiology Teaching Files
* Description: This plugin adds the teaching files content type
* Version: 0.0.1
* Updated: 4/6/2017
* Author: Zachary Eagle
*/


if ( ! function_exists('teaching_files') ) {

// Register Custom Post Type
function teaching_files() {

	$labels = array(
		'name'                => _x( 'Breast Imaging Teaching Files Entries', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Breast Imaging Teaching Files Entry', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Breast Imaging Teaching Files', 'text_domain' ),
		'name_admin_bar'      => __( 'Breast Imaging Teaching Files', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
		'all_items'           => __( 'All Items', 'text_domain' ),
		'add_new_item'        => __( 'Add New Item', 'text_domain' ),
		'add_new'             => __( 'Add New', 'text_domain' ),
		'new_item'            => __( 'New Item', 'text_domain' ),
		'edit_item'           => __( 'Edit Item', 'text_domain' ),
		'update_item'         => __( 'Update Item', 'text_domain' ),
		'view_item'           => __( 'View Item', 'text_domain' ),
		'search_items'        => __( 'Search Item', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'breast-imaging-teaching-files', 'text_domain' ),
		'description'         => __( 'Breast Imaging Teaching Files', 'text_domain' ),
		'labels'              => $labels,
		'menu_icon'	      => 'dashicons-welcome-learn-more',
		'supports'            => array( 'title', 'custom-fields', 'thumbnail' ),
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,		
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		'rewrite' => array('slug' => 'teaching-files', 'with_front' => false),
	);
	register_post_type( 'teaching-files', $args );
	#flush_rewrite_rules();

}
add_action( 'init', 'teaching_files', 0 );

}

//Add the archive teaching_files template
function get_radiology_teaching_files_archive_template($archive_template) {
     global $post;

     if ($post->post_type == 'teaching-files') {
          $archive_template = dirname( __FILE__ ) . '/archive-teaching-files.php';
     }
     return $archive_template;
}
add_filter( 'archive_template', 'get_radiology_teaching_files_archive_template' );


//Add the single teaching_files template
function get_radiology_teaching_files_single_template($single_template) {
     global $post;

     if ($post->post_type == 'teaching-files') {
          $single_template = dirname( __FILE__ ) . '/single-teaching-files.php';
     }
     return $single_template;
}
add_filter( 'single_template', 'get_radiology_teaching_files_single_template' );


// Register and Enqueue Scripts
function teaching_files_scripts() {
	if ( is_singular( 'teaching-files' ) ) {
		wp_register_script( 'teaching-files-scripts', '/wp-content/themes/boundless-rad/js/teaching-files-scripts.js', array( 'jquery' ), NULL, false );
		wp_enqueue_script( 'teaching-files-scripts' );
	}
}

// Implement enqueued scripts
add_action( 'wp_enqueue_scripts', 'teaching_files_scripts' );
//Sidebar for Teaching Files
if ( ! function_exists('uw_teaching_files_sidebar_menu') ) :
  function uw_teaching_files_sidebar_menu()
  {
    echo sprintf( '<nav id="desktop-relative" role="navigation" aria-label="relative">%s</nav>', uw_list_teaching_files() ) ;
  }
endif;

//Sidebar for Teaching Files
if ( ! function_exists( 'uw_list_teaching_files') ) :
  function uw_list_teaching_files( $mobile = false )
  {
    global $UW;
    global $post;
    $parent = get_post( $post->post_parent );
    //if ( ! $mobile && ! get_children( array('post_parent' => $post->ID, 'post_status' => 'publish' ) ) && $parent->ID == $post->ID ) return;
    $toggle = $mobile ? '<button class="uw-mobile-menu-toggle">Menu</button>' : '';
    $class  = $mobile ? 'uw-mobile-menu' : 'uw-sidebar-menu';
    $siblings = get_pages( array (
      'parent'    => $parent->post_parent,
      'post_type' => 'teaching-files',
      'exclude'   => $parent->ID
    ) );
	$archive = get_pages( array (
      'parent'    => $parent->post_parent,
      'post_type' => 'teaching-files',
      'meta_query' => array(
				'relation' => 'OR',
				array(
				   'key' => 'archived',
				   'compare' => '!=',
					'value' => '1',
				),
				array(
					'key' => 'archived',
					'compare' => 'NOT EXISTS',
				),
				),
    ) );
    $ids = !is_front_page() ? array_map( function($sibling) { return $sibling->ID; }, $siblings ) : array();
	$ids += $archive;
    $pages = wp_list_pages(array(
      'title_li'     => '<a href="'.get_bloginfo('url').'" title="Home" class="homelink">Home</a>',
      'child_of'     => $parent->post_parent,
      'exclude_tree' => $archive,
      'depth'        => 0,
      'echo'         => 0,
      'walker'       => $UW->SidebarMenuWalker
    ));
    $bool = strpos($pages , 'child-page-existance-tester');
    return  $bool && !is_search() ? sprintf( '%s<ul class="%s first-level">%s</ul>', $toggle, $class, $pages ) : '';
  }
endif;