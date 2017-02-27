<?php

add_action( 'customize_register', 'a_customize_register' );

function a_customize_register($wp_customize){

	require_once get_template_directory() . '/core/welcome-screen/custom-recommend-action-section.php';
		$wp_customize->register_section_type( 'Transcend_Customize_Section_Recommend' );

		// Recomended Actions
		$wp_customize->add_section(
			new Transcend_Customize_Section_Recommend(
				$wp_customize,
				'transcend_recomended-section',
				array(
					'title'    => esc_html__( 'Recomended Actions', 'transcend' ),
					'social_text'	=> esc_html__( 'We are social :', 'transcend' ),
					'plugin_text'	=> esc_html__( 'Recomended Plugins :', 'transcend' ),
					'facebook' => 'https://www.facebook.com/cpothemes',
					'twitter' => 'https://twitter.com/cpothemes',
					'wp_review' => true,
					'priority' => 0
				)
			)
		);

}

add_action( 'customize_controls_enqueue_scripts', 'transcend_welcome_scripts_for_customizer', 0 );

function transcend_welcome_scripts_for_customizer(){
	wp_enqueue_style( 'cpotheme-welcome-screen-customizer-css', get_template_directory_uri() . '/core/welcome-screen/css/welcome_customizer.css' );
	wp_enqueue_style( 'plugin-install' );
	wp_enqueue_script( 'plugin-install' );
	wp_enqueue_script( 'updates' );
	wp_add_inline_script( 'plugin-install', 'var pagenow = "customizer";' );
	wp_enqueue_script( 'cpotheme-welcome-screen-customizer-js', get_template_directory_uri() . '/core/welcome-screen/js/welcome_customizer.js', array( 'customize-controls' ), '1.0', true );

	wp_localize_script( 'cpotheme-welcome-screen-customizer-js', 'transcendWelcomeScreenObject', array(
		'ajaxurl'                  => admin_url( 'admin-ajax.php' ),
		'template_directory'       => get_template_directory_uri(),
	) );

}

// Load the system checks ( used for notifications )
require get_template_directory() . '/core/welcome-screen/notify-system-checks.php';

// Welcome screen
if ( is_admin() ) {
	global $transcend_required_actions, $transcend_recommended_plugins;
	$transcend_recommended_plugins = array(
		'kiwi-social-share' 		=> array( 'recommended' => true ),
		'uber-nocaptcha-recaptcha'	=> array( 'recommended' => false ),
		'cpo-shortcodes' 			=> array( 'recommended' => false ),
		'wp-product-review'       	=> array( 'recommended' => false ),
		'pirate-forms'           	=> array( 'recommended' => true ),
		'visualizer'             	=> array( 'recommended' => false )
	);
	/*
	 * id - unique id; required
	 * title
	 * description
	 * check - check for plugins (if installed)
	 * plugin_slug - the plugin's slug (used for installing the plugin)
	 *
	 */


	$transcend_required_actions = array(
		array(
			"id"          => 'transcend-req-ac-install-cpo-content-types',
			"title"       => MT_Notify_System::create_plugin_requirement_title( __( 'Install: CPO Content Types', 'transcend' ), __( 'Activate: CPO Content Types', 'transcend' ), 'cpo-content-types' ),
			"description" => __( 'It is highly recommended that you install the CPO Content Types plugin. It will help you manage all the special content types that this theme supports.', 'transcend' ),
			"check"       => MT_Notify_System::has_import_plugin( 'cpo-content-types' ),
			"plugin_slug" => 'cpo-content-types'
		),
		array(
			"id"          => 'transcend-req-ac-install-cpo-widgets',
			"title"       => MT_Notify_System::create_plugin_requirement_title( __( 'Install: CPO Widgets', 'transcend' ), __( 'Activate: CPO Widgets', 'transcend' ), 'cpo-widgets' ),
			"description" => __( 'It is highly recommended that you install the CPO Widgets plugin. It will help you manage all the special widgets that this theme supports.', 'transcend' ),
			"check"       => MT_Notify_System::has_import_plugin( 'cpo-widgets' ),
			"plugin_slug" => 'cpo-widgets'
		),
		array(
			"id"          => 'transcend-req-ac-install-wp-import-plugin',
			"title"       => MT_Notify_System::wordpress_importer_title(),
			"description" => MT_Notify_System::wordpress_importer_description(),
			"check"       => MT_Notify_System::has_import_plugin( 'wordpress-importer' ),
			"plugin_slug" => 'wordpress-importer'
		),
		array(
			"id"          => 'transcend-req-ac-install-wp-import-widget-plugin',
			"title"       => MT_Notify_System::widget_importer_exporter_title(),
			'description' => MT_Notify_System::widget_importer_exporter_description(),
			"check"       => MT_Notify_System::has_import_plugin( 'widget-importer-exporter' ),
			"plugin_slug" => 'widget-importer-exporter'
		),
		array(
			"id"          => 'transcend-req-ac-download-data',
			"title"       => esc_html__( 'Download theme sample data', 'transcend' ),
			"description" => esc_html__( 'Head over to our website and download the sample content data.', 'transcend' ),
			"help"        => '<a target="_blank"  href="https://www.cpothemes.com/sample-data/transcend-pro-posts.xml">' . __( 'Posts', 'transcend' ) . '</a>, 
							   <a target="_blank"  href="https://www.cpothemes.com/sample-data/transcend-pro-widgets.wie">' . __( 'Widgets', 'transcend' ) . '</a>',
			"check"       => MT_Notify_System::has_content(),
		),
		array(
			"id"    => 'transcend-req-ac-install-data',
			"title" => esc_html__( 'Import Sample Data', 'transcend' ),
			"help"  => '<a class="button button-primary" target="_blank"  href="' . self_admin_url( 'admin.php?import=wordpress' ) . '">' . __( 'Import Posts', 'transcend' ) . '</a> 
									   <a class="button button-primary" target="_blank"  href="' . self_admin_url( 'tools.php?page=widget-importer-exporter' ) . '">' . __( 'Import Widgets', 'transcend' ) . '</a>',
			"check" => MT_Notify_System::has_import_content(),
		),
		array(
			"id"          => 'transcend-req-ac-static-latest-news',
			"title"       => esc_html__( 'Set front page to static', 'transcend' ),
			"description" => esc_html__( 'If you just installed Affleunt, and are not able to see the front-page demo, you need to go to Settings -> Reading , Front page displays and select "Static Page".', 'transcend' ),
			"help"        => 'If you need more help understanding how this works, check out the following <a target="_blank"  href="https://codex.wordpress.org/Creating_a_Static_Front_Page#WordPress_Static_Front_Page_Process">link</a>. <br/> <br/><a class="button button-secondary" target="_blank"  href="' . self_admin_url( 'options-reading.php' ) . '">' . __( 'Set manually', 'transcend' ) . '</a> <a class="button button-primary" id="set_page_automatic"  href="#">' . __( 'Set automatically', 'transcend' ) . '</a>',
			"check"       => MT_Notify_System::is_not_static_page()
		),
	);
	require get_template_directory() . '/core/welcome-screen/welcome-screen.php';
}