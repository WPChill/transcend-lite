<?php

class CPO_Theme {

	private $path;
	private $plugins;
	private $actions;

	function __construct() {

		$this->path = get_template_directory() . '/includes/';
		$this->load_dependencies();

		// Recomended Plugins
		$this->plugins = array(
			'kali-forms'                 => array( 'recommended' => true ),
			'modula-best-grid-gallery'   => array( 'recommended' => true ),
			'strong-testimonials'        => array( 'recommended' => true ),
			'kb-support'                 => array( 'recommended' => true ),
			'rsvp'                       => array( 'recommended' => true )
		);

		// Recomendeed Actions
		$this->actions = array(
			$actions[] = array(
				'id'          => 'transcend-req-ac-import-demo-content',
				'title'       => esc_html__( 'Import Demo Content', 'transcend' ),
				'description' => esc_html__( 'Clicking the button below will add content, widgets and set static front page to your WordPress installation. Click advanced to customize the import process. This procces might take up to 1 min. Please don\'t close the window.', 'transcend' ),
				'help'        => $this->generate_action_html(),
				'check'       => CPOTheme_Notify_System::check_content_import(),
			),
			array(
				"id"          => 'transcend-req-ac-install-cpo-companion',
				"title"       => CPOTheme_Notify_System::create_plugin_requirement_title( __( 'Install: CPO Companion', 'transcend' ), __( 'Activate: CPO Companion', 'transcend' ), 'cpo-companion' ),
				"description" => __( 'It is highly recommended that you install the CPO Content Types plugin. It will help you manage all the special content types that this theme supports.', 'transcend' ),
				"check"       => CPOTheme_Notify_System::has_plugin( 'cpo-companion' ),
				"plugin_slug" => 'cpo-companion',
			),
			array(
				"id"          => 'transcend-req-ac-install-modula',
				"title"       => CPOTheme_Notify_System::create_plugin_requirement_title( __( 'Install: Modula', 'transcend' ), __( 'Activate: Modula', 'transcend' ), 'modula-best-grid-gallery' ),
				"description" => __( 'It is highly recommended that you install the Modula plugin.', 'transcend' ),
				"check"       => CPOTheme_Notify_System::has_plugin( 'modula-best-grid-gallery' ),
				"plugin_slug" => 'modula-best-grid-gallery',
			),
			array(
				'id'          => 'transcend-req-ac-install-kali-forms',
				'title'       => CPOTheme_Notify_System::create_plugin_requirement_title( __( 'Install: Kali Forms', 'transcend' ), __( 'Activate: Kali Forms', 'transcend' ), 'kali-forms' ),
				'description' => __( 'It is highly recommended that you install the Kali Forms plugin.', 'transcend' ),
				'check'       => CPOTheme_Notify_System::has_plugin( 'kali-forms' ),
				'plugin_slug' => 'kali-forms',
			),
		);

		$this->init_epsilon();
		$this->init_welcome_screen();


		add_filter( 'cpo_theme_have_content', '__return_true' );
		add_filter( 'cpo_theme_have_widgets', '__return_true' );
		add_filter( 'cpo_companion_import_option', array( $this, 'import_option' ), 99 );

		add_action( 'customize_register', array( $this, 'customizer' ) );

	}

	private function load_dependencies() {

		require_once $this->path . 'libraries/epsilon-framework/class-epsilon-framework.php';
		require_once $this->path . 'notify-system-checks.php';
		require_once $this->path . 'libraries/welcome-screen/class-epsilon-welcome-screen.php';

	}

	private function init_epsilon() {

		$args = array(
			'controls' => array( 'toggle', 'upsell' ), // array of controls to load
			'sections' => array( 'recommended-actions', 'pro' ), // array of sections to load
			'path'     => '/includes/libraries',
			'backup'   => false,
		);

		new Epsilon_Framework( $args );

	}

	private function init_welcome_screen() {

		Epsilon_Welcome_Screen::get_instance(
			$config = array(
				'theme-name' => 'Transcend',
				'theme-slug' => 'transcend',
				'actions'    => $this->actions,
				'plugins'    => $this->plugins,
			)
		);

	}

	public function customizer( $wp_customize ) {

		$wp_customize->add_section(
		  new Epsilon_Section_Recommended_Actions(
		    $wp_customize,
		    'cpo_recomended_section',
		    array(
		      'title'                        => esc_html__( 'Recomended Actions', 'transcend' ),
		      'social_text'                  => esc_html__( 'We are social', 'transcend' ),
		      'plugin_text'                  => esc_html__( 'Recomended Plugins', 'transcend' ),
		      'actions'                      => $this->actions,
		      'plugins'                      => $this->plugins,
		      'theme_specific_option'        => 'transcend_show_required_actions',
		      'theme_specific_plugin_option' => 'transcend_show_recommended_plugins',
		      'facebook'                     => 'https://www.facebook.com/cpothemes',
		      'twitter'                      => 'https://twitter.com/cpothemes',
		      'wp_review'                    => true,
		      'priority'                     => 0
		    )
		  )
		);

	}

	private function generate_action_html(){

		$import_actions = array(
		    'import_content'       => esc_html__( 'Import Content', 'transcend' ),
			'import_widgets'       => esc_html__( 'Import Widgets', 'transcend' ),
		);

		$import_plugins = array(
			'cpo-companion'            => esc_html__( 'CPO Companion', 'transcend' ),
			'modula-best-grid-gallery' => esc_html__( 'Modula Gallery', 'transcend' ),
			'kali-forms'               => esc_html__( 'Kali Forms', 'transcend' ),
		);

		$plugins_html = '';

		if ( is_customize_preview() ) {
			$url  = 'themes.php?page=%1$s-welcome&tab=%2$s';
			$html = '<a class="button button-primary" id="" href="' . esc_url( admin_url( sprintf( $url, 'transcend', 'recommended-actions' ) ) ) . '">' . __( 'Import Demo Content', 'transcend' ) . '</a>';
		} else {
			$html  = '<p><a class="button button-primary cpo-import-button epsilon-ajax-button" data-action="import_demo" id="add_default_sections" href="#">' . __( 'Import Demo Content', 'transcend' ) . '</a>';
			$html .= '<a class="button epsilon-hidden-content-toggler" href="#welcome-hidden-content">' . __( 'Advanced', 'transcend' ) . '</a></p>';
			$html .= '<div class="import-content-container" id="welcome-hidden-content">';

			foreach ( $import_plugins as $id => $label ) {
				if ( ! CPOTheme_Notify_System::has_plugin( $id ) ) {
					$plugins_html .= $this->generate_checkbox( $id, $label, 'plugins', true );
				}
			}

			if ( '' != $plugins_html ) {
				$html .= '<div class="plugins-container">';
				$html .= '<h4>' . __( 'Plugins', 'transcend' ) . '</h4>';
				$html .= '<div class="checkbox-group">';
				$html .= $plugins_html;
				$html .= '</div>';
				$html .= '</div>';
			}

			$html .= '<div class="demo-content-container">';
			$html .= '<h4>' . __( 'Demo Content', 'transcend' ) . '</h4>';
			$html .= '<div class="checkbox-group">';
			foreach ( $import_actions as $id => $label ) {
				$html .= $this->generate_checkbox( $id, $label );
			}
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
		}

		return $html;

	}

	private function generate_checkbox( $id, $label, $name = 'options', $block = false ) {
		$string = '<label><input checked type="checkbox" name="%1$s" class="demo-checkboxes"' . ( $block ? ' disabled ' : ' ' ) . 'value="%2$s">%3$s</label>';
		return sprintf( $string, $name, $id, $label );
	}

	public function import_option() {
		return 'transcend_content_imported';
	}

}

new CPO_Theme();