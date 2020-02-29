<?php 
/*
Plugin Name: SOLA custom Dashboard
Plugin URI:  https://github.com/
Description: For adding directions to the dashboard
Version:     1.0
Author:      Tom Woodward
Author URI:  http://bionicteaching.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: sola-custom

*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


add_action('wp_dashboard_setup', 'sola_custom_dashboard_widgets');
 
function sola_custom_dashboard_widgets() {
  global $wp_meta_boxes;
  wp_add_dashboard_widget('custom_sola_widget', '<img style="width:100px; display:block; margin:0 auto;" src="'.plugin_dir_url( __FILE__ ).'/imgs/kau_logo.png"><h1>Sola Guidance</h1>', 'sola_custom_dashboard_posts');
  }

function sola_custom_dashboard_posts() {
    echo '<p>Use the links below to learn more about Sola.</p>';
    //echo network_home_url();
    // WP_Query arguments
    switch_to_blog(1);//switch to the home blog but you could put another source URL here
    $args = array(
      'post_type'              => array( 'post' ),
      'post_status'            => array( 'public' ),
      'order'                  => 'ASC',
      'orderby'                => 'date',
      'category_name'          => 'support',// using the category support slug here
    );

// The Query
$query = new WP_Query( $args );

// The Loop
if ( $query->have_posts() ) {
  while ( $query->have_posts() ) {
    $post = $query->the_post();

    // do something
    echo '<hr/><h2><a href="' . get_the_permalink() .'">'. get_the_title() . '</a></h2>';
    echo '<p>' . get_the_excerpt() . '</p>';

    }
  } else {
    // no posts found
  }

  // Restore original Post Data
  wp_reset_postdata();
  restore_current_blog();
}
/*
  Disable Default Dashboard Widgets
  @ https://digwp.com/2014/02/disable-default-dashboard-widgets/
*/
function disable_default_dashboard_widgets() {
  global $wp_meta_boxes;
  // wp..
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
  // bbpress
  unset($wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now']);
  // yoast seo
  unset($wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget']);
  // gravity forms
  unset($wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard']);
}
add_action('wp_dashboard_setup', 'disable_default_dashboard_widgets', 999);


//LOGGER -- like frogger but more useful

if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}

  //print("<pre>".print_r($a,true)."</pre>");
