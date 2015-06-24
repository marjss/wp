<?php

/**
* Plugin Name: Amazing Effect
* Plugin URI: http://adalbadall.com
* Description: This plugin adds some products to our single posts.
* Version: 1.0.0
* Author: Sudhanshu
* Author URI: http://adalbadall.com
* License: GPL2

require_once ( ABSPATH . 'wp-admin/includes/image.php' );
$post = array(
  'ID'             => "320", // Are you updating an existing post?
  'post_content'   => "Gazabbbb",//[ <string> ] // The full text of the post.
  'post_name'      => "name on the roast",//[ <string> ] // The name (slug) for your post
  'post_title'     => "Some titme",//[ <string> ] // The title of your post.
  'post_status'    => "publish",//[ 'draft' | 'publish' | 'pending'| 'future' | 'private' | custom registered status ] // Default 'draft'.
  'post_type'      => "post",//[ 'post' | 'page' | 'link' | 'nav_menu_item' | custom post type ] // Default 'post'.
  'post_author'    => "",//[ <user ID> ] // The user ID number of the author. Default is the current user ID.
  'ping_status'    => "closed",//[ 'closed' | 'open' ] // Pingbacks or trackbacks allowed. Default is the option 'default_ping_status'.
  'post_parent'    => "",//[ <post ID> ] // Sets the parent of the new post, if any. Default 0.
  'menu_order'     => "",//[ <order> ] // If new post is a page, sets the order in which it should appear in supported menus. Default 0.
  'to_ping'        => "",// Space or carriage return-separated list of URLs to ping. Default empty string.
  'pinged'         => "",// Space or carriage return-separated list of URLs that have been pinged. Default empty string.
  'post_password'  => "",//[ <string> ] // Password for post, if any. Default empty string.
  'guid'           => "",// Skip this and let Wordpress handle it, usually.
  'post_content_filtered' => "",// Skip this and let Wordpress handle it, usually.
  'post_excerpt'   => "",//[ <string> ] // For all your post excerpt needs.
  'post_date'      => "",//[ Y-m-d H:i:s ] // The time post was made.
  'post_date_gmt'  => "",//[ Y-m-d H:i:s ] // The time post was made, in GMT.
  'comment_status' => "",//[ 'closed' | 'open' ] // Default is the option 'default_comment_status', or 'closed'.
  'post_category'  => "",//[ array(<category id>, ...) ] // Default empty.
  'tags_input'     => "",//[ '<tag>, <tag>, ...' | array ] // Default empty.
  'tax_input'      => "",//[ array( <taxonomy> => <array | string>, <taxonomy_other> => <array | string> ) ] // For custom taxonomies. Default empty.
  'page_template'  => ""//[ <string> ] // Requires name of template file, eg template.php. Default empty.
);  
$new_post_id  = wp_insert_post( $post );
$tag = 'post-format-gallery';
$taxonomy = 'post_format';
    wp_set_post_terms( $new_post_id, $tag, $taxonomy );
    $post_id = $new_post_id; // this value is retrived with '$post_id = wp_insert_post(....)'
    $image = imagecreatefromjpeg("http://ecx.images-amazon.com/images/I/41DpteuwlOL.jpg");
        imagejpeg($image, ABSPATH . 'wp-content/uploads/41DpteuwlOL.jpg');
        $filename = ABSPATH . 'wp-content/uploads/41DpteuwlOL.jpg';
        $wp_filetype = wp_check_filetype(basename($filename), null );
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
            'post_content' => '',
            'post_status' => 'inherit'
        );
  $attach_id = wp_insert_attachment( $attachment, $filename, $post_id );
  $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
  wp_update_attachment_metadata( $attach_id, $attach_data );
  set_post_thumbnail( $post_id, $attach_id );*/