<?php
// If uninstall is not called from WordPress, exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

if ( get_option( 'hotel_rooms_remove_data' ) ) {
	delete_option( 'hotel_rooms_remove_data' );
	$posts = get_posts(
		array(
			'numberposts' => - 1,
			'post_type'   => 'hotel-rooms',
			'post_status' => 'any',
		)
	);

	foreach ( $posts as $post ) {
		wp_delete_post( $post->ID, true );
	}

}


