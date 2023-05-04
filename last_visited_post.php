<?php
/*
Plugin Name: Last Visited Post
Description: Displays the title and a link to the last visited post for a user.
Version: 1.0
Author: Rasmus Midjord
Author URI: https://www.lidtmeget.dk
License: GPL2
*/

// Save the last visited post ID for the current user
function save_last_visited_post() {
    global $post;
    if (is_singular('post')) { // Check if the current post type is "post"
        $user_id = get_current_user_id();
        $post_id = $post->ID;
        update_user_meta($user_id, 'last_visited_post_id', $post_id);
    }
}
add_action('wp', 'save_last_visited_post');

// Display a link to the last visited post for the current user via shortcode
function last_visited_post_shortcode($atts) {
    $user_id = get_current_user_id();
    $post_id = get_user_meta($user_id, 'last_visited_post_id', true);
    $link = get_permalink($post_id);
    $post_title = get_the_title($post_id);
    $post_excerpt = wp_trim_words(get_the_excerpt($post_id), 20, '...'); // change the number (20) to change the quantity of words in the excerpt.
    return '<div class="last_visited_post"><a href="' . $link . '"><h3>' . $post_title . '</h3>' . $post_excerpt . '</a></div>';
}
add_shortcode('last_visited_post', 'last_visited_post_shortcode');
