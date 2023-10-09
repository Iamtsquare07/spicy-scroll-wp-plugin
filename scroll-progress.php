<?php

/*
Plugin Name: Spicy Scroll Bar
Author: Tyavbee Victor
Version: 1.0.0
Description: The Scroll Progress Bar plugin is designed to enhance the reading experience for your visitors. With this plugin, you can effortlessly incorporate a dynamic scroll progress bar on your single post and article pages. As users scroll through your content, the progress bar provides a visual indicator of how far they've progressed in reading the page.
Author URI: https://www.iamtsquare07.com
License: GPLv3 or later
Text Domain: spicy-scroll-bar
*/
// Enqueue the necessary scripts and styles
function scroll_progress_bar_enqueue_scripts() {
    if (is_single()) { // Only load on single post
        wp_enqueue_script('scroll-progress-bar', plugin_dir_url(__FILE__) . 'scrollProgress.js', array('jquery'), '1.0', true);
        wp_enqueue_style('scroll-progress-bar-style', plugin_dir_url(__FILE__) . 'scroll-styles.css');
    }
}
add_action('wp_enqueue_scripts', 'scroll_progress_bar_enqueue_scripts');

// Add the HTML for the scroll progress bar
function scroll_progress_bar_display() {
    if (is_single()) {
        echo '<div id="scroll-progress-bar"><div id="scroll-progress"></div></div>';
    }
}
add_action('wp_footer', 'scroll_progress_bar_display');

// Cleanup the plugin files on plugin deletion
function spicy_scroll_delete_plugin() {
    // Check if the deletion is being triggered by WordPress, not directly
    if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'delete-selected') {
        // Get the plugin directory path
        $plugin_dir = plugin_dir_path(__FILE__);

        // List of allowed files within the plugin directory
        $allowed_files = array(
            'scroll-progress.php', 
            'scrollProgress.js',
            'scroll-styles.php', 
        );

        // Get the file path to be deleted
        $file_to_delete = sanitize_text_field($_REQUEST['plugin']);

        // Ensure the file path is valid and allowed
        if (in_array($file_to_delete, $allowed_files) && strpos($file_to_delete, $plugin_dir) === 0) {
            // Log the file deletion for auditing
            error_log("Plugin file deleted: $file_to_delete");

            // Delete the file
            if (file_exists($file_to_delete)) {
                unlink($file_to_delete);
            }
        } else {
            // Log unauthorized file deletion attempt for auditing
            error_log("Unauthorized file deletion attempt: $file_to_delete");
        }
    }
}
add_action('delete_plugin', 'spicy_scroll_delete_plugin');