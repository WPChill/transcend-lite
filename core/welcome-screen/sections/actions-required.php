<?php
/**
 * Actions required
 */
wp_enqueue_style( 'plugin-install' );
wp_enqueue_script( 'plugin-install' );
wp_enqueue_script( 'updates' );
?>

<div class="feature-section action-required demo-import-boxed" id="plugin-filter">

	<?php
	global $transcend_required_actions;
	if ( ! empty( $transcend_required_actions ) ):
		/* transcend_show_required_actions is an array of true/false for each required action that was dismissed */
		$transcend_show_required_actions = get_option( "transcend_show_required_actions" );
		foreach ( $transcend_required_actions as $transcend_required_action_key => $transcend_required_action_value ):
			if ( @$transcend_show_required_actions[ $transcend_required_action_value['id'] ] === false ) {
				continue;
			}
			if ( @$transcend_required_action_value['check'] ) {
				continue;
			}
			?>
			<div class="transcend-action-required-box">
				<span class="dashicons dashicons-no-alt transcend-dismiss-required-action"
				      id="<?php echo $transcend_required_action_value['id']; ?>"></span>
				<h3><?php if ( ! empty( $transcend_required_action_value['title'] ) ): echo $transcend_required_action_value['title']; endif; ?></h3>
				<p>
					<?php if ( ! empty( $transcend_required_action_value['description'] ) ): echo $transcend_required_action_value['description']; endif; ?>
					<?php if ( ! empty( $transcend_required_action_value['help'] ) ): echo '<br/>' . $transcend_required_action_value['help']; endif; ?>
				</p>
				<?php
				if ( ! empty( $transcend_required_action_value['plugin_slug'] ) ) {
					$active = $this->check_active( $transcend_required_action_value['plugin_slug'] );
					$url    = $this->create_action_link( $active['needs'], $transcend_required_action_value['plugin_slug'] );
					$label  = '';
					switch ( $active['needs'] ) {
						case 'install':
							$class = 'install-now button';
							$label = __( 'Install', 'transcend' );
							break;
						case 'activate':
							$class = 'activate-now button button-primary';
							$label = __( 'Activate', 'transcend' );
							break;
						case 'deactivate':
							$class = 'deactivate-now button';
							$label = __( 'Deactivate', 'transcend' );
							break;
					}
					?>
					<p class="plugin-card-<?php echo esc_attr( $transcend_required_action_value['plugin_slug'] ) ?> action_button <?php echo ( $active['needs'] !== 'install' && $active['status'] ) ? 'active' : '' ?>">
						<a data-slug="<?php echo esc_attr( $transcend_required_action_value['plugin_slug'] ) ?>"
						   class="<?php echo $class; ?>"
						   href="<?php echo esc_url( $url ) ?>"> <?php echo $label ?> </a>
					</p>
					<?php
				};
				?>
			</div>
			<?php
		endforeach;
	endif;
	$nr_actions_required = 0;
	/* get number of required actions */
	if ( get_option( 'transcend_show_required_actions' ) ):
		$transcend_show_required_actions = get_option( 'transcend_show_required_actions' );
	else:
		$transcend_show_required_actions = array();
	endif;
	if ( ! empty( $transcend_required_actions ) ):
		foreach ( $transcend_required_actions as $transcend_required_action_value ):
			if ( ( ! isset( $transcend_required_action_value['check'] ) || ( isset( $transcend_required_action_value['check'] ) && ( $transcend_required_action_value['check'] == false ) ) ) && ( ( isset( $transcend_show_required_actions[ $transcend_required_action_value['id'] ] ) && ( $transcend_show_required_actions[ $transcend_required_action_value['id'] ] == true ) ) || ! isset( $transcend_show_required_actions[ $transcend_required_action_value['id'] ] ) ) ) :
				$nr_actions_required ++;
			endif;
		endforeach;
	endif;
	if ( $nr_actions_required == 0 ):
		echo '<span class="hooray">' . __( 'Hooray! There are no required actions for you right now.', 'transcend' ) . '</span>';
	endif;
	?>

</div>