<?php
/**
 * Performance Enhancement Class
 * -------------------------------------------------------------
 * The Performance class is dedicated to optimizing the performance of the Artemis WordPress theme by modifying
 * WordPress default behaviors that potentially impact speed and resource usage. It adjusts various WordPress
 * settings, such as disabling emojis, removing excess metadata from the header, and turning off XML-RPC services.
 * Furthermore, it enhances site security by removing version numbers and other potentially sensitive information
 * from public-facing parts of the site. This class contributes significantly to the streamlining of the theme,
 * ensuring a faster, more secure user experience and aiding in achieving better metrics on performance assessments.
 *
 * @package    Artemis
 * @version    1.0.0
 * @author     WPArray <hello@wparray.com>
 * @copyright  2024 WPArray
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */

namespace Artemis\Utils;

use Artemis\Core\Registrable;

class Performance implements Registrable {

	/**
	 * Registry
	 * @return void
	 */
	public function register() {

		// ----------------------------------------------------
		// General use Hooks.
		// ----------------------------------------------------
		\add_action( 'init', array( $this, 'hook_init' ) );
		\add_action( 'admin_init', array( $this, 'hook_admin_init' ) );
		\add_filter( 'wp_enqueue_scripts', array( $this, 'hook_scripts' ), 100 );
		\add_filter( 'wp_headers', array( $this, 'hook_wp_headers' ) );

		// ----------------------------------------------------
		// Disable Gutenberg.
		// ----------------------------------------------------
		// \add_filter( 'use_block_editor_for_post', '__return_false' );
		// \add_filter( 'use_block_editor_for_post_type', '__return_false' );
		// \add_filter( 'use_widgets_block_editor', '__return_false' );

		// ----------------------------------------------------
		// Disable XML-RPC.
		// ----------------------------------------------------
		\add_filter( 'xmlrpc_enabled', '__return_false' );
		\add_filter( 'pings_open', '__return_false', 9999 );

		// ----------------------------------------------------
		// Cleanup Header.
		// ----------------------------------------------------
		\remove_action( 'wp_head', 'rsd_link' );
		\remove_action( 'wp_head', 'wlwmanifest_link' );
		\remove_action( 'wp_head', 'wp_generator' );
		\remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
		\remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
		\remove_action( 'wp_head', 'feed_links_extra', 3 );
		\remove_action( 'wp_head', 'feed_links', 2 );

		// ----------------------------------------------------
		// Remove Duotone SVGs.
		// ----------------------------------------------------
		\remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
		\remove_action( 'in_admin_header', 'wp_global_styles_render_svg_filters' );

		// ----------------------------------------------------
		// Disable Version Check.
		// ----------------------------------------------------
		\add_filter( 'the_generator', '__return_false' );
	}

	/**
	 * Init Hook
	 * @return void
	 */
	public function hook_init() {

		// ----------------------------------------------------
		// Remove Emojis.
		// ----------------------------------------------------
		\remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		\remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		\remove_action( 'wp_print_styles', 'print_emoji_styles' );
		\remove_action( 'admin_print_styles', 'print_emoji_styles' );
		\remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		\remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		\remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

		// ----------------------------------------------------
		// Disable Heartbeat
		// Except the posts page
		// ----------------------------------------------------
		global $pagenow;

		if ( 'post.php' != $pagenow && 'post-new.php' != $pagenow )
			wp_deregister_script( 'heartbeat' );
	}

	/**
	 * Admin Hook
	 * @return void
	 */
	public function hook_admin_init() {

		// ----------------------------------------------------
		// Remove Metaboxes
		// ----------------------------------------------------
		\remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		\remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		\remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
		\remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
		\remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		\remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
		\remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		\remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
		\remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
	}

	/**
	 * Enqueue_scripts Hook
	 * @return void
	 */
	public function hook_scripts() {

		// ----------------------------------------------------
		// Disable Gutenberg Styles
		// ----------------------------------------------------
		\wp_deregister_style( 'wp-block-library' );
		\wp_deregister_style( 'wp-block-library-theme' );
		\wp_deregister_style( 'wc-block-style' );
		\wp_deregister_style( 'global-styles' );
		\remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );

		\wp_deregister_style( 'classic-theme-styles' );
		\wp_dequeue_style( 'classic-theme-styles' );
	}

	/**
	 * WP Headers Hook
	 * @param mixed $headers
	 * @return mixed
	 */
	public function hook_wp_headers( $headers ) {

		// ----------------------------------------------------
		// Disable Pingbacks
		// ----------------------------------------------------
		unset( $headers['X-Pingback'], $headers['x-pingback'] );
		return $headers;
	}
}
