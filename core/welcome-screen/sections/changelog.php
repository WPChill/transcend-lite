<?php
/**
 * Changelog
 */

$transcend = wp_get_theme( 'transcend' );

?>
<div class="featured-section changelog">
	

	<?php
	WP_Filesystem();
	global $wp_filesystem;
	$transcend_changelog       = $wp_filesystem->get_contents( get_template_directory() . '/changelog.txt' );
	$transcend_changelog_lines = explode( PHP_EOL, $transcend_changelog );
	foreach ( $transcend_changelog_lines as $transcend_changelog_line ) {
		if ( substr( $transcend_changelog_line, 0, 3 ) === "###" ) {
			echo '<h4>' . substr( $transcend_changelog_line, 3 ) . '</h4>';
		} else {
			echo $transcend_changelog_line, '<br/>';
		}


	}

	echo '<hr />';


	?>

</div>