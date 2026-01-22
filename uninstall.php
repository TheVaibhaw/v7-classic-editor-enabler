<?php
/**
 * @package V7_Classic_Editor_Enabler
 * @since   1.0.0
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

delete_option( 'v7_classic_editor_posts' );
delete_option( 'v7_classic_editor_pages' );
delete_option( 'v7_classic_editor_redirect' );

if ( is_multisite() ) {
    $sites = get_sites();
    foreach ( $sites as $site ) {
        switch_to_blog( $site->blog_id );
        delete_option( 'v7_classic_editor_posts' );
        delete_option( 'v7_classic_editor_pages' );
        delete_option( 'v7_classic_editor_redirect' );
        restore_current_blog();
    }
}
