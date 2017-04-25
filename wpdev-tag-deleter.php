<?php
/*
Plugin Name: WP Developers | Tag Deletion
Plugin URI: http://wpdevelopers.com
Description: Easily and quickly delete uneccessary tags. Read the documentation here: https://github.com/LibertyAllianceGit/wpdev-tag-deleter.
Version: 1.0.5
Author: Tyler Johnson
Author URI: http://tylerjohnsondesign.com/
Copyright: Tyler Johnson
Text Domain: wpdevtagdel
Copyright 2017 WP Developers. All Rights Reserved.
*/

/**
Plugin Updater
**/
require 'plugin-update-checker-master/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/LibertyAllianceGit/wpdev-tag-deleter',
	__FILE__,
	'wpdev-tag-deleter'
);

/**
Tag Deleter Shortcode
**/
function wpdev_tag_deletion($atts) {
    
    // Get shortcode attributes
    $atts = shortcode_atts(
        array(
            'number'   => '500',
            'offset'   => '200',
            'auto'     => '1',
            'optimize' => 'no'
        ), $atts
    );
    
    // Query least used tags
    $args = array(
        'orderby' => 'count',
        'order' => 'DESC',
        'number' => $atts['number'],
        'offset' => $atts['offset'],
        'hide_empty' => false,
    );
    
    // Get the tags
    $tags = get_tags( $args );
    
    // Run loop if the query isn't empty
    if(!empty($tags)) {
        // Header statement
        echo 'We\'re running.<br>';
        // Message that we're refreshing if auto on or to refresh if it's not on
        if($atts['auto'] == '1') {
            echo 'Starting next batch in 5 seconds.<hr>';
        } else {
            echo 'Please refresh this page to start the next batch.<hr>';
        }
        // Looping through each tag in the query
        foreach($tags as $tag) {
            wp_delete_term($tag->term_id, 'post_tag');
            // Use correct terms
            if($tag->count == '1') {
                $postout = ' post';
            } else {
                $postout = ' posts';
            }
            // Letting us know which posts were deleted.
            echo '&mdash; Deleted ' . $tag->name . ', which had ' . $tag->count . $postout . '.<br>';
        }
        // If auto refresh is on, auto refresh
        if($atts['auto'] == '1') {
            header('Refresh: 5; URL=' . get_permalink());
        }
    } else {
        if($atts['optimize'] == 'yes') {
            // Global WordPress Database
            global $wpdb;
            $tables = array('wp_terms', 'wp_term_relationships', 'wp_term_taxonomy');
            foreach($tables as $table) {
                // Optimize wp_terms tables
                $wpdb->query( "OPTIMIZE TABLE $table" );
            }
            echo 'Completed. All unused tags are gone and the database has been optimized.<hr>';
        } else {
            // All tags in query are deleted
            echo 'Completed. All unused tags are gone.<hr>';
        }
    }
    
}
add_shortcode('wpdevtags', 'wpdev_tag_deletion');