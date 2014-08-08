<?php
/*
Plugin Name: WP Teapot
Plugin URI: http://www.stevenword.com/wp-teapot/
Description: I'm a teapot
Text Domain: wp-teapot
Version: 1.0.0
Author: Steven Word
Author URI: http://stevenword.com/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright 2014 Steven K. Word

GNU General Public License, Free Software Foundation <http://creativecommons.org/licenses/GPL/2.0/>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/**
 * WP Teapot
 */
class WP_Teapot {

	const VERSION        = '1.0.0';
	const REVISION       = '20140725';
	const METAKEY        = 'wp_teapot';
	const NONCE          = 'wp_teapot_nonce';
	const NONCE_FAIL_MSG = 'Cheatin&#8217; huh?';
	const TEXT_DOMAIN    = 'wp-teapot';


	private static $is_active = false;

	/* Define and register singleton */
	private static $instance = false;
	public static function instance() {
		if( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Clone
	 *
	 * @since 1.0.0
	 */
	private function __clone() { }

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	private function __construct() {
		$plugin_dir = basename( dirname( __FILE__ ) );
		load_plugin_textdomain( self::TEXT_DOMAIN, false, $plugin_dir . '/languages/' );
		self::init();
	}

	/**
	 * WP Init
	 *
	 * @return [type] [description]
	 */
	public function init() {
		// Actions
		add_action( 'send_headers', array( $this, 'action_send_headers' ) );
		add_action( 'parse_request', array( $this, 'action_parse_request' ) );
	}

	/**
	 * Check to see is we are looking at the web root and if so, note it for later
	 *
	 * @return null
	 */
	public function action_parse_request( $request ) {

		if( isset( $request->request ) && '' == $request->request ) {
			$this->is_active = true;
		}

	}

	/**
	 * Send em' headers, like they've never been sent before!
	 * @return null
	 */
	public function action_send_headers() {

		if( ! $this->is_active )
			return;

		$code = 418; // Short and stout
		status_header( $code ); // Here is my handle
		$code_desc = get_status_header_desc( $code ); // Here is my spout

		echo esc_html( $code_desc ); // Tell me all about it
		exit();
	}

}
WP_Teapot::instance();
