<?php
/*
Plugin Name: Bootstrap Dual Listbox for WordPress
Plugin URI: http://wordpress.org/extend/plugins/bootstrap-duallistbox/
Description: Bootstrap Dual Listbox is a responsive dual listbox widget optimized for Twitter Bootstrap. Works on all modern browsers and on touch devices.
Author: Sazzad Hossain Khan
Version: 0.1
Author URI: http://bd.linkedin.com/in/itsazzad
License: GPLv2 or later
*/

WP_BootstrapDuallistbox::init();

class WP_BootstrapDuallistbox {

	/**
	 * URL to the directory housing Bootstrap Dual Listbox Javascript files.
	 */
	public static $bootstrap_duallistbox_url;

	/**
	 * URL to the directory of this plugin
	 */
	public static $wp_bootstrap_duallistbox_url;


	/**
	 * Setup the class variables & hook functions.
	 */
	public static function init() {
		
		self::$wp_bootstrap_duallistbox_url = plugins_url( '', __FILE__ );
		self::$bootstrap_duallistbox_url    = plugins_url( 'bootstrap_duallistbox', __FILE__ );

		add_action( 'wp_print_scripts', __CLASS__ . '::maybe_enqueue_scripts' );

		add_shortcode( 'bootstrap_duallistbox', __CLASS__ . '::shortcode_handler' );
	}


	/**
	 * If the post/page contains a select element, enqueue the bootstrap_duallistbox & jquery scripts.
	 */
	public static function maybe_enqueue_scripts() {

		//if( self::contains_select() && ! is_admin() ) {
			wp_enqueue_style(  'bootstrap_css', '//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css' );
			wp_enqueue_style(  'bootstrap_duallistbox_css', self::$bootstrap_duallistbox_url . '/bootstrap-duallistbox.css' );
			wp_enqueue_script( 'bootstrap_js', '//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js', array( 'jquery' ), false, true );
			wp_enqueue_script( 'bootstrap_duallistbox_js', self::$bootstrap_duallistbox_url . '/jquery.bootstrap-duallistbox.js', array( 'bootstrap_js', 'jquery' ), false, true );
			wp_enqueue_script( 'wp_bootstrap_duallistbox', self::$wp_bootstrap_duallistbox_url . '/wp-bootstrap-duallistbox.js', array( 'bootstrap_duallistbox_js' ), false, true );
		//}
	}


	/**
	 * Checks the post content to see if it contains a select element. 
	 */
	private static function contains_select( $content = '' ){
		global $post;

		if( empty( $content ) && is_object( $post ) )
			$content = $post->post_content;

		// Contains a vanilla select element
		if( strpos( $content, '<select' ) !== false )
			return true;
		// Contains Grunion Contact Form
		elseif( strpos( $content, '[contact-form' ) !== false )
			return true;
		// Brute force load
		elseif( strpos( $content, '[bootstrap_duallistbox' ) !== false )
			return true;
		else
			return false;
	}


	/**
	 * Return an empty string in place of the [bootstrap_duallistbox] shortcode. It's simply a flag to 
	 * enqueue the appropriate scripts & styles.
	 */
	public static function shortcode_handler( $atts, $content = null ) {
		return '';
	}

}
