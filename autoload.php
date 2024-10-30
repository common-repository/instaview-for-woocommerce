<?php 

if( ! function_exists( 'instaview_autoloader' ) ) {
	function instaview_autoloader( $class_name ) {
		$parent_namespace = 'InstaView';
		$classes_subfolder = 'includes';
		if ( false !== strpos( $class_name, $parent_namespace ) ) {
			$classes_dir = realpath( INSTAVIEW_ABSPATH ) . DIRECTORY_SEPARATOR . $classes_subfolder . DIRECTORY_SEPARATOR;
			$project_namespace = $parent_namespace . '\\';
			$length = strlen( $project_namespace );
			$class_file = substr( $class_name, $length );
			$class_file = str_replace( '_', '-', strtolower( $class_file ) );
			$class_parts = explode( '\\', $class_file );
			$last_index = count( $class_parts ) - 1;
			$class_parts[ $last_index ] = 'class-' . $class_parts[ $last_index ];
			$class_file = implode( DIRECTORY_SEPARATOR, $class_parts ) . '.php';
			$location = $classes_dir . $class_file;
			if ( ! is_file( $location ) ) {
				return;
			}
			require_once $location;
		}
	}
	spl_autoload_register( 'instaview_autoloader' );
}
