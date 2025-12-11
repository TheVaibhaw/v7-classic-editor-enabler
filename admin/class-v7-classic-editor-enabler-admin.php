<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://vaibhawkumarparashar.in
 * @since      1.0.0
 *
 * @package    V7_Classic_Editor_Enabler
 * @subpackage V7_Classic_Editor_Enabler/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    V7_Classic_Editor_Enabler
 * @subpackage V7_Classic_Editor_Enabler/admin
 * @author     Vaibhaw Kumar <imvaibhaw@gmail.com>
 */
class V7_Classic_Editor_Enabler_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in V7_Classic_Editor_Enabler_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The V7_Classic_Editor_Enabler_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/v7-classic-editor-enabler-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in V7_Classic_Editor_Enabler_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The V7_Classic_Editor_Enabler_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/v7-classic-editor-enabler-admin.js', array('jquery'), $this->version, false);
    }

    /**
     * Add settings page under Settings menu.
     *
     * @since    1.0.0
     */
    public function add_settings_page()
    {
        add_options_page(
            __('V7 Classic Editor Enabler', 'v7-classic-editor-enabler'),
            __('V7 Classic Editor', 'v7-classic-editor-enabler'),
            'manage_options',
            'v7-classic-editor-enabler',
            array($this, 'display_settings_page')
        );
    }

    /**
     * Register settings.
     *
     * @since    1.0.0
     */
    public function register_settings()
    {
        // Check for redirect after activation
        if (get_option('v7_classic_editor_redirect')) {
            delete_option('v7_classic_editor_redirect');
            wp_redirect(admin_url('options-general.php?page=v7-classic-editor-enabler'));
            exit;
        }

        register_setting('v7_classic_editor_options', 'v7_classic_editor_posts', array('sanitize_callback' => 'sanitize_text_field'));
        register_setting('v7_classic_editor_options', 'v7_classic_editor_pages', array('sanitize_callback' => 'sanitize_text_field'));

        add_settings_section(
            'v7_classic_editor_section',
            __('Classic Editor Settings', 'v7-classic-editor-enabler'),
            array($this, 'settings_section_callback'),
            'v7_classic_editor_options'
        );

        add_settings_field(
            'v7_classic_editor_posts',
            __('Enable for Posts', 'v7-classic-editor-enabler'),
            array($this, 'posts_checkbox_callback'),
            'v7_classic_editor_options',
            'v7_classic_editor_section'
        );

        add_settings_field(
            'v7_classic_editor_pages',
            __('Enable for Pages', 'v7-classic-editor-enabler'),
            array($this, 'pages_checkbox_callback'),
            'v7_classic_editor_options',
            'v7_classic_editor_section'
        );
    }

    /**
     * Display the settings page.
     *
     * @since    1.0.0
     */
    public function display_settings_page()
    {
?>
        <div class="wrap">
            <h1><?php _e('V7 Classic Editor Enabler Settings', 'v7-classic-editor-enabler'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('v7_classic_editor_options');
                do_settings_sections('v7_classic_editor_options');
                submit_button();
                ?>
            </form>
        </div>
<?php
    }

    /**
     * Settings section callback.
     *
     * @since    1.0.0
     */
    public function settings_section_callback()
    {
        echo __('Select the post types for which you want to enable the Classic Editor.', 'v7-classic-editor-enabler');
    }

    /**
     * Posts checkbox callback.
     *
     * @since    1.0.0
     */
    public function posts_checkbox_callback()
    {
        $value = get_option('v7_classic_editor_posts', '1');
        echo '<input type="checkbox" name="v7_classic_editor_posts" value="1" ' . checked(1, $value, false) . ' />';
    }

    /**
     * Pages checkbox callback.
     *
     * @since    1.0.0
     */
    public function pages_checkbox_callback()
    {
        $value = get_option('v7_classic_editor_pages', '1');
        echo '<input type="checkbox" name="v7_classic_editor_pages" value="1" ' . checked(1, $value, false) . ' />';
    }
}
