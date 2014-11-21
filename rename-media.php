<?php
/*
Plugin Name: Rename Media
Plugin URI: http://urbangiraffe.com/plugins/rename-media/
Description: Rename underlying media files from the WordPress media management interface
Version: 0.1.3
Author: John Godley
Author URI: http://urbangiraffe.com
*/

function rename_media_save( $post, $attachment ) {
	$old = get_attached_file( $post['ID'] );

	$ext = str_replace( 'jpeg', 'jpg', pathinfo( basename( $old ), PATHINFO_EXTENSION ) );
	$new = wp_unique_filename( dirname( $old ), $attachment['post_title'].'.'.$ext );
	$new = dirname( $old ).DIRECTORY_SEPARATOR.strtolower( $new );

	if ( $post['post_name'] != sanitize_title( $attachment['post_title'] ) ) {
		// Ensure attachment page title changes
		$post['post_name'] = sanitize_title( $attachment['post_title'] );

		// Save
		wp_update_post( $post );

		$new_url = get_permalink( $post['ID'] );

		$post['guid'] = $new_url;
		if ( isset( $_REQUEST['_wp_original_http_referer'] ) && strpos( $_REQUEST['_wp_original_http_referer'], '/wp-admin/' ) === false ) {
			$_REQUEST['_wp_original_http_referer'] = $post['guid'];
		}

		$meta = wp_get_attachment_metadata( $post['ID'] );

		// Rename the original file
		$old_filename = basename( $old );
		$new_filename = basename( $new );

		$meta['file'] = str_replace( $old_filename, $new_filename, $meta['file'] );

		// Check if new file exists
		if ( file_exists( $new ) === false ) {
			$original_filename = get_post_meta( $post['ID'], '_original_filename', true );
			if ( empty( $original_filename ) )
				add_post_meta( $post['ID'], '_original_filename', $old_filename );

			rename( $old, $new );

			// Rename the sizes
			$old_filename = pathinfo( basename( $old ), PATHINFO_FILENAME );
			$new_filename = pathinfo( basename( $new ), PATHINFO_FILENAME );

			foreach ( (array)$meta['sizes'] AS $size => $meta_size ) {
				$old_file = dirname( $old ).DIRECTORY_SEPARATOR.$meta['sizes'][$size]['file'];

				$meta['sizes'][$size]['file'] = str_replace( $old_filename, $new_filename, $meta['sizes'][$size]['file'] );

				$new_file = dirname( $old ).DIRECTORY_SEPARATOR.$meta['sizes'][$size]['file'];

				rename( $old_file, $new_file );
			}

			wp_update_attachment_metadata( $post['ID'], $meta );

			update_attached_file( $post['ID'], $new );
		}
	}

	return $post;
}

add_filter( 'attachment_fields_to_save', 'rename_media_save', 10, 2 );
