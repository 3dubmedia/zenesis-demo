<?php
/**
 * Plugin Name:       Zenesis Demo
 * Description:       Demo plugin for Qodo + PR review: adds [zenesis_demo name="World"] shortcode and a simple settings page.
 * Version:           0.1.0
 * Requires PHP:      8.1
 * Author:            Your Name
 * Text Domain:       zenesis-demo
 *
 * @package ZenesisDemo
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register shortcode.
 */
function zenesis_demo_register_shortcode(): void {
	add_shortcode( 'zenesis_demo', 'zenesis_demo_shortcode' );
}
add_action( 'init', 'zenesis_demo_register_shortcode' );

/**
 * Shortcode callback.
 *
 * @param array|string $atts Shortcode attributes.
 * @return string
 */
function zenesis_demo_shortcode( $atts = array() ): string {
	$atts = shortcode_atts(
		array(
			'name' => 'World',
		),
		(array) $atts,
		'zenesis_demo'
	);

	$name = sanitize_text_field( $atts['name'] );

	return sprintf(
		'<div class="zenesis-demo">%s</div>',
		esc_html( "Hello, {$name}!" )
	);
}

/**
 * Admin menu.
 */
function zenesis_demo_admin_menu(): void {
	add_options_page(
		__( 'Zenesis Demo', 'zenesis-demo' ),
		__( 'Zenesis Demo', 'zenesis-demo' ),
		'manage_options',
		'zenesis-demo',
		'zenesis_demo_admin_page'
	);
}
add_action( 'admin_menu', 'zenesis_demo_admin_menu' );

/**
 * Render admin page.
 */
function zenesis_demo_admin_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	echo '<div class="wrap"><h1>' . esc_html__( 'Zenesis Demo', 'zenesis-demo' ) . '</h1><p>' . esc_html__( 'Settings go here.', 'zenesis-demo' ) . '</p></div>';
}
