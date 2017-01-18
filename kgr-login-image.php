<?php
/*
 * Plugin Name: KGR Login Image
 * Plugin URI: https://github.com/constracti/kgr-login-image
 * Description: The login screen image is a link to your blog's Home, with the blog's Name as a title. Background is a randomly selected from your Media Library file which has its title set to 'kgr-login-image'.
 * Author: constracti
 * Version: 1.0
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( !defined( 'ABSPATH' ) )
	exit;

add_filter( 'login_headerurl', function() {
	return home_url( '/' );
} );

add_filter( 'login_headertitle', function() {
	return esc_attr( get_bloginfo( 'name' ) );
} );

add_action( 'login_enqueue_scripts', function() {
	$posts = get_posts( [
		'title' => 'kgr-login-image',
		'post_type' => 'attachment',
		'post_status' => 'inherit',
		'posts_per_page' => 1,
		'orderby' => 'rand',
		'fields' => 'ids',
	] );
	if ( empty( $posts ) )
		return;
	$id = $posts[0];
	$metadata = wp_get_attachment_metadata( $id );
	$url = content_url( 'uploads/' . $metadata['file'] );
	$height = sprintf( '%dpx', $metadata['height'] );
	$width = sprintf( '%dpx', $metadata['width'] );
?>
<style>
.login h1 a {
	background-image: url( <?= $url ?> ) !important;
	background-size: initial !important;
	-webkit-background-size: initial !important;
	height: <?= $height ?> !important;
	width: <?= $width ?> !important;
}
</style>
<?php
} );
