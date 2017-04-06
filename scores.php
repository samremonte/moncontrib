<?php
/*
Plugin Name: Check Contributors
Description: Ranking of astronauts and cosmonauts registered as a writer at YuneOh 
Author: Sam Remonte
Author URI: https://www.facebook.com/rossoleg
Version: 1.0
License: GPL2
================================================================
*/
if ( ! defined( 'ABSPATH' ) ) exit; 


//=====================LOAD MENU OPTION with icon
function add_writer_scores_menu(){
	$menuLabel = __( 'Contributors' );
	$slugLabel = __( 'writer-list' );

	global $writer_scores;
    $writer_scores = add_menu_page( $menuLabel, $menuLabel, 'manage_options', $slugLabel, 'writer_scores_ui', plugins_url('img/cons.ico', __FILE__ ), 10 );


    // ADD PREMIUM AUTHOR USER ROLE
	add_role('premium_author', 'Premium Author', array(
	    'read' => true, 
	    'edit_posts' => true,
	    'delete_posts' => true, 
	    'level_1' => true,
	));
}
add_action( 'admin_menu', 'add_writer_scores_menu' );



//=====================LOAD PLUGIN PAGE
function writer_scores_ui(){
?>
<div class="wrap">
<h2><?php _e('Leaderboard', 'Writer Scores'); ?></h2>
    
    <?php settings_errors(); ?>
    <?php
    // SET CONTRIBUTORS AS DEFAULT TAB
    isset( $_GET[ 'tab' ] ) ? $active_tab = $_GET[ 'tab' ] : $active_tab = 'contributors';

	?>
	<?php // WORDPRESS DEFAULT CLASS nav-tab-wrapper, nav-tab, nav-tab-active ?>
	<h2 class="nav-tab-wrapper">
    	<a href="?page=writer-list&tab=contributors" class="nav-tab <?php echo $active_tab == 'contributors' ? 'nav-tab-active' : ''; ?>">Contributors</a>
    	<a href="?page=writer-list&tab=authors" class="nav-tab <?php echo $active_tab == 'authors' ? 'nav-tab-active' : ''; ?>">Authors</a>
    	<a href="?page=writer-list&tab=premium-authors" class="nav-tab <?php echo $active_tab == 'premium-authors' ? 'nav-tab-active' : ''; ?>">Premium Authors</a>
	</h2>

	<div class="highest">

	<!-- EXCERPT OF USERS POSTS -->

	</div>
	
	<?php
	if( $active_tab == 'contributors' ){
		require('contributors.php');
	}
	if( $active_tab == 'authors' ){
		require('authors.php');
	}
	if( $active_tab == 'premium-authors' ){
		require('premium-authors.php');
	}
	?>

</div>
<?php
}

//=====================LOAD AJAX SCRIPT
function writer_scores_load_script( $hook ){
	global $writer_scores;
	if( $hook != $writer_scores )
	return;
	
	wp_enqueue_style( 'writer_scores_style', plugin_dir_url( __FILE__ ). 'css/writer-scores.css' );
	wp_enqueue_script( 'writer_scores_ajax', plugin_dir_url( __FILE__ ). 'js/writer-scores-ajax.js', array('jquery') ); 

}
add_action( 'admin_enqueue_scripts', 'writer_scores_load_script' );



//=====================AJAX RESPONSE
function writer_scores_response(){

	require('fetch-user-info.php');

}
add_action( 'wp_ajax_writer_scores', 'writer_scores_response' ); // writer_score ACTION AT JS FILE