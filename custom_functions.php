<?php
/**
 * Created by PhpStorm.
 * User: imransayed
 * Date: 6/3/18
 * Time: 12:35 AM
 */

if ( ! function_exists( 'ihs_enqueue_scripts' ) ) {
	function ihs_enqueue_scripts() {
		if ( is_product() ) {
			wp_enqueue_style( 'ihs_boot_css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css' );
			wp_enqueue_script( 'ihs_boot_js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', array( 'jquery' ), '', true );
		}
	}
	add_action( 'wp_enqueue_scripts', 'ihs_enqueue_scripts' );
}