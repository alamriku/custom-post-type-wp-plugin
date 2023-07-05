<?php
/**
 * Trigger this file on plugin uinstall
 *
 * @package My-Project
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

//$projects = get_post(array('post_type' => 'project', 'numberposts' => -1));
//
//foreach ($projects as $project) {
//    wp_delete_post($project->ID, true);
//}
global $wpdb;
$wpdb->query( 'DELETE FROM wp_posts WHERE post_type = "project"' );
$wpdb->query( 'DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id from wp_posts)' );
$wpdb->query( 'DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)' );