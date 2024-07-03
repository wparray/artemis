<?php
/**
 * Security Enhancements Class
 * -------------------------------------------------------------
 * This class focuses on bolstering the security of the WordPress theme by disabling various features that could
 * potentially be exploited by attackers. It proactively removes unnecessary WordPress metadata from the head tag,
 * disables the XML RPC protocol, disables the Windows Live Writer manifest link, and removes WP version numbers
 * from all public areas to obscure potential vulnerabilities. Additionally, it disables the Rest API link in the
 * header and impedes standard WordPress feeds to further secure the WordPress installation. These measures are
 * designed to minimize the attack surface and safeguard the site, providing a more secure environment for users
 * and administrators alike.
 *
 * @package    Artemis
 * @version    1.0.0
 * @author     WPArray <hello@wparray.com>
 * @copyright  2024 WPArray
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */

namespace Artemis\Utils;

use Artemis\Core\Registrable;

class Security implements Registrable {
	/**
	 * Constructor
	 */
	public function register() {
		$this->disable_xml_rpc();
		$this->disable_wlw_manifest_link();
		$this->hide_wp_version();
		$this->disable_shortlink();
		$this->disable_feed_links();
		$this->disable_api_links();
	}

	/**
	 * Hide WordPress Version
	 *
	 * @since 1.0.5
	 * @return void
	 * -----------------------------------------------------------------------------
	 * -----------------------------------------------------------------------------
	 */
	public function hide_wp_version() {
		\remove_action( 'wp_head', '__return_false' );
		\add_filter( 'the_generator', '__return_false' );
	}

	/**
	 * Disable XMLRPC
	 *
	 * @since 1.0.5
	 * @return void
	 * -----------------------------------------------------------------------------
	 * -----------------------------------------------------------------------------
	 */
	public function disable_xml_rpc() {
		\add_filter( 'xmlrpc_enabled', '__return_false' );
		\remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
		\remove_action( 'wp_head', 'rsd_link' );
	}

	/**
	 * Disable WLWManifest Link
	 *
	 * @since 1.0.5
	 * @return void
	 * -----------------------------------------------------------------------------
	 * -----------------------------------------------------------------------------
	 */
	public function disable_wlw_manifest_link() {
		\remove_action( 'wp_head', 'wlwmanifest_link' );
	}

	/**
	 * Disable Shortlink
	 *
	 * @since 1.0.5
	 * @return void
	 * -----------------------------------------------------------------------------
	 * -----------------------------------------------------------------------------
	 */
	public function disable_shortlink() {
		\remove_action( 'wp_head', 'wp_shortlink_wp_head' );
		\remove_action( 'template_redirect', 'wp_shortlink_header', 11, 0 );
	}

	/**
	 * Disable Feeds Links
	 *
	 * @since 1.0.5
	 * @return void
	 * -----------------------------------------------------------------------------
	 * -----------------------------------------------------------------------------
	 */
	public function disable_feed_links() {
		\remove_action( 'wp_head', 'feed_links_extra', 3 );
		\remove_action( 'wp_head', 'feed_links', 2 );
	}

	/**
	 * Disable API Links
	 *
	 * @since 1.0.0
	 * @return void
	 * -----------------------------------------------------------------------------
	 * -----------------------------------------------------------------------------
	 */
	public function disable_api_links() {
		\remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
		\remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
	}
}
