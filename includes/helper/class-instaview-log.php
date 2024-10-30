<?php
namespace InstaView\Helper;

/**
 * Log the messages and errors
 *
 * @since      1.0.0
 *
 * @package    InstaView
 * @subpackage InstaView\Helper
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class InstaView_Log {

    /**
     * Create log file
     */
    public static function logmessage($desc) {

        $time = gmdate( "F jS Y, H:i", time() + 25200 );
        $ban = "#$time\r\n$desc\r\n";
        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['basedir'] . '/instaview-logs/errorsfile.txt';

        // Ensure the directory exists, create it if not
        if ( !file_exists( $upload_dir['basedir'] . '/instaview-logs' ) ) {
            wp_mkdir_p( $upload_dir['basedir'] . '/instaview-logs' );
        }

        // Initialize the filesystem
        $wp_filesystem = WP_Filesystem();

        // Check if the filesystem is initialized successfully
        if ( !$wp_filesystem ) {
            return;
        }

        // Use wp_filesystem->put_contents to write the log to the file
        $write = $wp_filesystem->put_contents( $file_path, $ban, FILE_APPEND );

        // Optionally, you can also check if the write was successful
        if ( $write === false ) {
            // Handle write failure if needed
        }
    }
}
