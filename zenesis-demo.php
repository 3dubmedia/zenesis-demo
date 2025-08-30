<?php
/**
 * Plugin Name:       Zenesis Demo
 * Description:       Demo plugin for Qodo + PR review: adds [zenesis_demo name="World"] shortcode, a simple settings page, and a greeting option on the General settings screen.
 * Version:           0.2.0
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
 * Usage: [zenesis_demo name="World"]
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

	$name     = sanitize_text_field( $atts['name'] );
	$greeting = get_option( 'zenesis_demo_greeting', 'Hello' );

	return sprintf(
		'<div class="zenesis-demo">%s</div>',
		esc_html( $greeting . ', ' . $name . '!' )
	);
}

/**
 * Admin menu (simple placeholder page).
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
 * Render admin page content.
 */
function zenesis_demo_admin_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	echo '<div class="wrap"><h1>' . esc_html__( 'Zenesis Demo', 'zenesis-demo' ) . '</h1><p>' . esc_html__( 'Settings go here.', 'zenesis-demo' ) . '</p></div>';
}

/**
 * Register a greeting setting and add a field to the General settings page.
 */
function zenesis_demo_register_setting(): void {
	register_setting(
		'general',
		'zenesis_demo_greeting',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Hello',
			'show_in_rest'      => false,
		)
	);

	add_settings_field(
		'zenesis_demo_greeting',
		__( 'Zenesis Greeting', 'zenesis-demo' ),
		'zenesis_demo_render_field',
		'general',
		'default'
	);
}
add_action( 'admin_init', 'zenesis_demo_register_setting' );

/**
 * Render the greeting input field.
 */
function zenesis_demo_render_field(): void {
	$value = get_option( 'zenesis_demo_greeting', 'Hello' );

	echo '<input type="text" id="zenesis_demo_greeting" name="zenesis_demo_greeting" value="' . esc_attr( $value ) . '" class="regular-text" />';
	echo '<p class="description">' . esc_html__( 'This greeting will be used by the [zenesis_demo] shortcode.', 'zenesis-demo' ) . '</p>';
}
