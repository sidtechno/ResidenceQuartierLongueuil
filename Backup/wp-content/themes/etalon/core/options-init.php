<?php
/**
ReduxFramework Sample Config File
For full documentation, please visit: https://docs.reduxframework.com
* */
if (!class_exists('keydesign_Redux_Framework_config')) {
    class keydesign_Redux_Framework_config
    {
        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;
        public function __construct()
        {
            if (!class_exists('ReduxFramework')) {
                return;
            }
            // This is needed. Bah WordPress bugs.  ;)
            if (true == Redux_Helpers::isTheme(__FILE__)) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array(
                    $this,
                    'initSettings'
                ), 10);
            }
        }
        public function initSettings()
        {
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();
            // Set the default arguments
            $this->setArguments();
            // Set a few help tabs so you can see how it's done
            $this->setSections();
            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }
            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action('redux/loaded', array(
                $this,
                'remove_demo'
            ));
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            add_filter('redux/options/' . $this->args['opt_name'] . '/compiler', array(
                $this,
                'compiler_action'
            ), 10, 2);
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));
            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }
        /**

        This is a test function that will let you see when the compiler hook occurs.
        It only runs if a field   set with compiler=>true is changed.

        * */
        function compiler_action($options, $css)
        {
            $keydesign_site_title = get_bloginfo( 'name' );
            $keydesign_site_title = preg_replace('/\s+/', '', $keydesign_site_title);
            $filename  = get_template_directory() . '/core/assets/css/dynamic-keydesign-'. $keydesign_site_title .'.css';
            global $wp_filesystem;
            if (empty($wp_filesystem)) {
                require_once(ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }
            if ($wp_filesystem) {
                $wp_filesystem->put_contents($filename, $css, FS_CHMOD_FILE // predefined mode settings for WP files
                    );
            }
        }
        /**

        Custom function for filtering the sections array. Good for child themes to override or add to the sections.
        Simply include this function in the child themes functions.php file.

        NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
        so you must use get_template_directory_uri() if you want to use any of the built in icons

        * */
        function dynamic_section($sections)
        {
            //$sections = array();
            $sections[] = array(
                'title' => esc_html__('Section via hook', 'etalon'),
                'desc' => esc_html__('This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.', 'etalon'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );
            return $sections;
        }
        /**

        Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

        * */
        function change_arguments($args)
        {
            //$args['dev_mode'] = true;
            return $args;
        }
        /**

        Filter hook for filtering the default value of any given field. Very useful in development mode.

        * */
        function change_defaults($defaults)
        {
            $defaults['str_replace'] = 'Testing filter hook!';
            return $defaults;
        }
        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo()
        {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2);
                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(
                    ReduxFrameworkPlugin::instance(),
                    'admin_notices'
                ));
            }
        }
        public function setSections()
        {
            /**
            Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
            * */
            // Background Patterns Reader
            $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns      = array();
            ob_start();
            $ct              = wp_get_theme();
            $this->theme     = $ct;
            $item_name       = $this->theme->get('Name');
            $tags            = $this->theme->Tags;
            $screenshot      = $this->theme->get_screenshot();
            $class           = $screenshot ? 'has-screenshot' : '';
            $customize_title = sprintf(esc_html__('Customize &#8220;%s&#8221;', 'etalon'), $this->theme->display('Name'));
?>
    <div id="current-theme" class="<?php
            echo esc_attr($class);
?>
        ">
        <?php
            if ($screenshot):
?>
        <?php
                if (current_user_can('edit_theme_options')):
?>
        <a href="<?php
                    echo esc_url(wp_customize_url());
?>
            " class="load-customize hide-if-no-customize" title="
            <?php
                    echo esc_attr($customize_title);
?>
            ">
            <img src="<?php
                    echo esc_url($screenshot);
?>
            " alt="
            <?php
                    esc_attr_e('Current theme preview','etalon');
?>" /></a>
        <?php
                endif;
?>
        <img class="hide-if-customize" src="<?php
                echo esc_url($screenshot);
?>
        " alt="
        <?php
                esc_attr_e('Current theme preview','etalon');
?>
        " />
        <?php
            endif;
?>

        <h4>
            <?php
            echo esc_attr($this->theme->display('Name'));
?></h4>

        <div>
            <ul class="theme-info">
                <li>
                    <?php
            printf(esc_html__('By %s', 'etalon'), $this->theme->display('Author'));
?></li>
                <li>
                    <?php
            printf(esc_html__('Version %s', 'etalon'), $this->theme->display('Version'));
?></li>
                <li>
                    <?php
            echo '<strong>' . esc_html__('Tags', 'etalon') . ':</strong>
                ';
?>
                <?php
            printf($this->theme->display('Tags'));
?></li>
        </ul>
        <p class="theme-description">
            <?php
            echo esc_attr($this->theme->display('Description'));
?></p>

    </div>
</div>

<?php
            $item_info = ob_get_contents();
            ob_end_clean();
            $sampleHTML = '';
            // ACTUAL DECLARATION OF SECTIONS

            $this->sections[] = array(
                'icon' => 'el-icon-bookmark',
                'title' => esc_html__('Business info', 'etalon'),
                'compiler' => 'true',
                'fields' => array(
                    array(
                        'id' => 'tek-business-address',
                        'type' => 'text',
                        'title' => esc_html__('Business address', 'etalon'),
                        'default' => '49 Grand Street, Los Angeles'
                    ),
                    array(
                        'id' => 'tek-business-phone',
                        'type' => 'text',
                        'title' => esc_html__('Business phone', 'etalon'),
                        'default' => '(222) 400-630'
                    ),
                    array(
                        'id' => 'tek-business-email',
                        'type' => 'text',
                        'title' => esc_html__('Business email', 'etalon'),
                        'default' => 'contact@etalon-theme.com'
                    ),
                    array(
                        'id' => 'tek-social-icons',
                        'type' => 'checkbox',
                        'title' => esc_html__('Social Icons', 'etalon'),
                        'subtitle' => esc_html__('Select visible social icons', 'etalon'),
                        //Must provide key => value pairs for multi checkbox options
                        'options' => array(
                            '1' => 'Facebook',
                            '2' => 'Twitter',
                            '3' => 'Google+',
                            '4' => 'Pinterest',
                            '5' => 'Youtube',
                            '6' => 'Linkedin',
                            '7' => 'Instagram'
                        ),
                        //See how std has changed? you also don't need to specify opts that are 0.
                        'default' => array(
                            '1' => '1',
                            '2' => '1',
                            '3' => '1',
                            '4' => '0',
                            '5' => '0',
                            '6' => '1',
                            '7' => '0',
                        )
                    ),
                    array(
                        'id' => 'tek-facebook-url',
                        'type' => 'text',
                        'title' => esc_html__('Facebook Link', 'etalon'),
                        'subtitle' => esc_html__('Enter Facebook URL', 'etalon'),
                        'default' => 'http://www.facebook.com/'
                    ),

                    array(
                        'id' => 'tek-twitter-url',
                        'type' => 'text',
                        'title' => esc_html__('Twitter Link', 'etalon'),
                        'subtitle' => esc_html__('Enter Twitter URL', 'etalon'),
                        'default' => 'http://www.twitter.com/'
                    ),

                    array(
                        'id' => 'tek-google-url',
                        'type' => 'text',
                        'title' => esc_html__('Google+ Link', 'etalon'),
                        'subtitle' => esc_html__('Enter Google+ URL', 'etalon'),
                        'default' => 'http://plus.google.com/'
                    ),
                    array(
                        'id' => 'tek-pinterest-url',
                        'type' => 'text',
                        'title' => esc_html__('Pinterest Link', 'etalon'),
                        'subtitle' => esc_html__('Enter Pinterest URL', 'etalon'),
                        'default' => 'http://www.pinterest.com/'
                    ),

                    array(
                        'id' => 'tek-youtube-url',
                        'type' => 'text',
                        'title' => esc_html__('Youtube Link', 'etalon'),
                        'subtitle' => esc_html__('Enter Youtube URL', 'etalon'),
                        'default' => 'http://www.youtube.com/'
                    ),
                    array(
                        'id' => 'tek-linkedin-url',
                        'type' => 'text',
                        'title' => esc_html__('Linkedin Link', 'etalon'),
                        'subtitle' => esc_html__('Enter Linkedin URL', 'etalon'),
                        'default' => 'http://www.linkedin.com/'
                    ),
                    array(
                        'id' => 'tek-instagram-url',
                        'type' => 'text',
                        'title' => esc_html__('Instagram Link', 'etalon'),
                        'subtitle' => esc_html__('Enter Instagram URL', 'etalon'),
                        'default' => 'http://www.instagram.com/'
                    ),
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-globe',
                'title' => esc_html__('Global Options', 'etalon'),
                'compiler' => 'true',
                'fields' => array(
                    array(
                        'id' => 'tek-main-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Main theme color', 'etalon'),
                        'default' => '#3f9df3',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-logo-style',
                        'type' => 'select',
                        'title' => esc_html__('Logo style', 'etalon'),
                        'options'  => array(
                            '1' => 'Image logo',
                            '2' => 'Text logo'
                        ),
                        'default' => '2'
                    ),
                    array(
                        'id' => 'tek-logo',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('Image logo', 'etalon'),
                        'subtitle' => esc_html__('Upload logo image. Recommended image size: 195x64px', 'etalon'),
                        'required' => array('tek-logo-style','equals','1'),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/logo.png'
                        )
                    ),
                    array(
                        'id' => 'tek-logo2',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('Secondary image logo', 'etalon'),
                        'subtitle' => esc_html__('Upload logo image for sticky navigation. Recommended image size: 195x64px', 'etalon'),
                        'required' => array('tek-logo-style','equals','1'),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/logo-2.png'
                        )
                    ),
                    array(
                        'id' => 'tek-logo-size',
                        'type' => 'dimensions',
                        'height' => false,
                        'units'    => array('px'),
                        'url' => true,
                        'title' => esc_html__('Image Logo Size', 'etalon'),
                        'subtitle' => esc_html__('Choose logo width - the image will constrain proportions', 'etalon'),
                        'required' => array('tek-logo-style','equals','1'),
                    ),
                    array(
                        'id' => 'tek-text-logo',
                        'type' => 'text',
                        'title' => esc_html__('Text logo', 'etalon'),
                        'required' => array('tek-logo-style','equals','2'),
                        'default' => 'ETALON'
                    ),
                    array(
                        'id' => 'tek-main-logo-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Main logo text color', 'etalon'),
                        'required' => array('tek-logo-style','equals','2'),
                        'default' => '#2f2f2f',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-secondary-logo-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Secondary logo text color', 'etalon'),
                        'subtitle' => esc_html__('Logo text color for sticky navigation', 'etalon'),
                        'required' => array('tek-logo-style','equals','2'),
                        'default' => '#2f2f2f',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-favicon',
                        'type' => 'media',
                        'preview' => false,
                        'url' => true,
                        'title' => esc_html__('Favicon', 'etalon'),
                        'subtitle' => esc_html__('Upload favicon image', 'etalon'),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/favicon.png'
                        )
                    ),
                    array(
                        'id' => 'tek-disable-animations',
                        'type' => 'switch',
                        'title' => esc_html__('Disable animations on mobile', 'etalon'),
                        'subtitle' => esc_html__('Globally turn on/off element animations on mobile', 'etalon'),
                        'default' => false
                    ),
                    array(
                        'id' => 'tek-preloader',
                        'type' => 'switch',
                        'title' => esc_html__('Preloader', 'etalon'),
                        'subtitle' => esc_html__('Activate to enable theme preloader', 'etalon'),
                        'default' => true
                    ),
                    array(
                        'id' => 'tek-coming-soon',
                        'type' => 'switch',
                        'title' => __('Coming Soon Mode <a href="http://keydesign-themes.com/etalon/documentation#ops-coming-soon" target="_blank" class="el-icon-question-sign"></a>', 'etalon'),
                        'subtitle' => esc_html__('Activate to enable maintenance mode', 'etalon'),
                        'default' => false
                    ),
                    array(
                        'id' => 'tek-coming-soon-page',
                        'type' => 'select',
                        'title' => esc_html__('Coming Soon Page', 'etalon'),
                        'required' => array('tek-coming-soon','equals', true),
                        'subtitle' => esc_html__('Choose coming soon page', 'etalon'),
                        'data' => 'pages'
                    ),
                    array(
                        'id' => 'tek-google-api',
                        'type' => 'text',
                        'title' => __('Google Map API Key <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank" class="el-icon-question-sign"></a>', 'etalon'),
                        'default' => '',
                        'subtitle' => esc_html__('Generate, copy and paste here Google Maps API Key', 'etalon'),
                    ),
                    array(
                        'id' => 'tek-css',
                        'type' => 'ace_editor',
                        'title' => esc_html__('Custom CSS', 'etalon'),
                        'subtitle' => esc_html__('Paste your CSS code here.', 'etalon'),
                        'mode' => 'css',
                        'theme' => 'chrome'
                    )
                )
            );


            $this->sections[] = array(
                'icon' => 'el-icon-screen',
                'title' => esc_html__('Header', 'etalon'),
                'compiler' => 'true',
                'fields' => array(
                    array(
                        'id' => 'tek-menu-style',
                        'type' => 'button_set',
                        'title' => esc_html__('Select main navigation style', 'etalon'),
                        'subtitle' => esc_html__('You can choose between full width and contained.', 'etalon'),
                        'options' => array(
                            '1' => 'Full width',
                            '2' => 'Contained'
                         ),
                        'default' => '1'
                    ),
                    array(
                        'id' => 'tek-menu-behaviour',
                        'type' => 'button_set',
                        'title' => esc_html__('Select main navigation behaviour', 'etalon'),
                        'subtitle' => esc_html__('You can choose between a sticky or a fixed top menu.', 'etalon'),
                        'options' => array(
                            '1' => 'Sticky',
                            '2' => 'Fixed'
                         ),
                        'default' => '1'
                    ),
                    array(
                        'id' => 'tek-header-menu-bg',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Navigation background color', 'etalon'),
                        'default' => '',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-header-menu-bg-sticky',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Sticky navigation background color', 'etalon'),
                        'default' => '',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-header-menu-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Navigation text color', 'etalon'),
                        'default' => '',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-header-menu-color-sticky',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Sticky navigation text color', 'etalon'),
                        'default' => '',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-header-menu-color-hover',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Navigation text color on mouse over', 'etalon'),
                        'default' => '',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-header-menu-color-sticky-hover',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Sticky navigation text color on mouse over', 'etalon'),
                        'default' => '',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-topbar',
                        'type' => 'switch',
                        'title' => esc_html__('Topbar', 'etalon'),
                        'subtitle' => esc_html__('Activate to display topbar.', 'etalon'),
                        'default' => true
                    ),
                    array(
                        'id' => 'tek-topbar-template',
                        'type' => 'select',
                        'title' => esc_html__('Topbar template', 'etalon'),
                        'required' => array('tek-topbar','equals', true),
                        'options'  => array(
                            '1' => 'Business info (left) + Social icons (right)',
                            '2' => 'Social icons (left) + Business info (right)',
                        ),
                        'default' => '1'
                    ),
                    array(
                        'id' => 'tek-topbar-bg-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Topbar background color', 'etalon'),
                        'default' => '#3f9df3',
                        'validate' => 'color',
                        'required' => array('tek-topbar','equals', true),
                    ),
                    array(
                        'id' => 'tek-topbar-text-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Topbar text color', 'etalon'),
                        'default' => '#ffffff',
                        'validate' => 'color',
                        'required' => array('tek-topbar','equals', true),
                    ),
                    array(
                        'id' => 'tek-topbar-hover-text-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Topbar text color on mouse over', 'etalon'),
                        'default' => '#dddddd',
                        'validate' => 'color',
                        'required' => array('tek-topbar','equals', true),
                    ),
                     array(
                        'id' => 'tek-transparent-homepage-menu',
                        'type' => 'switch',
                        'title' => esc_html__('Homepage transparent navigation', 'etalon'),
                        'subtitle' => esc_html__('Enable/disable Homepage transparent navigation', 'etalon'),
                        'default' => false
                    ),
                    array(
                        'id' => 'tek-transparent-homepage-menu-colors',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Navigation text color', 'etalon'),
                        'subtitle' => esc_html__('Homepage navigation color when transparent background', 'etalon'),
                        'default' => '',
                        'validate' => 'color',
                        'required' => array('tek-transparent-homepage-menu','equals', true),
                    ),
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-certificate',
                'title' => esc_html__('Header button', 'etalon'),
                'compiler' => 'true',
                'fields' => array(
                    array(
                        'id' => 'tek-header-button',
                        'type' => 'switch',
                        'title' => esc_html__('Show button in header', 'etalon'),
                        'default' => true
                    ),
                    array(
                        'id' => 'tek-header-button-text',
                        'type' => 'text',
                        'title' => esc_html__('Button text', 'etalon'),
                        'required' => array('tek-header-button','equals', true),
                        'default' => 'Get a quote'
                    ),
                    array(
                        'id' => 'tek-header-button-action',
                        'type' => 'select',
                        'title' => esc_html__('Button action', 'etalon'),
                        'required' => array('tek-header-button','equals', true),
                        'options'  => array(
                            '1' => 'Open modal window with contact form',
                            '2' => 'Scroll to section',
                            '3' => 'Open a new page'
                        ),
                        'default' => '3'
                    ),
                    array(
                        'id' => 'tek-modal-title',
                        'type' => 'text',
                        'title' => esc_html__('Modal title', 'etalon'),
                        'required' => array('tek-header-button-action','equals','1'),
                        'default' => 'Lets get in touch'
                    ),
                    array(
                        'id' => 'tek-modal-subtitle',
                        'type' => 'text',
                        'title' => esc_html__('Modal subtitle', 'etalon'),
                        'required' => array('tek-header-button-action','equals','1'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-modal-form-select',
                        'type' => 'select',
                        'title' => esc_html__('Contact form plugin', 'etalon'),
                        'required' => array('tek-header-button-action','equals','1'),
                        'options'  => array(
                            '1' => 'Contact Form 7',
                            '2' => 'Ninja Forms'
                        ),
                        'default' => '1'
                    ),
                    array(
                        'id' => 'tek-modal-contactf7-formid',
                        'type' => 'select',
                        'data' => 'posts',
                        'args' => array( 'post_type' => 'wpcf7_contact_form', ),
                        'title' => esc_html__('Contact Form 7 Title', 'etalon'),
                        'required' => array('tek-modal-form-select','equals','1'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-modal-ninja-formid',
                        'type' => 'text',
                        'title' => esc_html__('Ninja Form ID', 'etalon'),
                        'required' => array('tek-modal-form-select','equals','2'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-scroll-id',
                        'type' => 'text',
                        'title' => esc_html__('Scroll to section ID', 'etalon'),
                        'required' => array('tek-header-button-action','equals','2'),
                        'default' => '#download-etalon'
                    ),

                    array(
                        'id' => 'tek-button-new-page',
                        'type' => 'text',
                        'title' => esc_html__('New page full link', 'etalon'),
                        'required' => array('tek-header-button-action','equals','3'),
                        'default' => '#'
                    ),
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-website',
                'title' => esc_html__('Home Slider', 'etalon'),
                'compiler' => 'true',
                'fields' => array(
                    array(
                        'id' => 'tek-slider',
                        'type' => 'text',
                        'title' => esc_html__('Revolution Slider alias', 'etalon'),
                        'subtitle' => esc_html__('Insert Revolution Slider Alias here', 'etalon'),
                        'default' => ''
                    )
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-fontsize',
                'title' => esc_html__('Typography', 'etalon'),
                'compiler' => true,
                'fields' => array(
                    array(
                        'id' => 'tek-default-typo',
                        'type' => 'typography',
                        'title' => esc_html__('Body font settings', 'etalon'),
                        //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                        'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
                        // 'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style' => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'       => false, // Only appears if google is true and subsets not set to false
                        'font-size' => true,
                        'line-height' => true,
                        //'word-spacing'  => true,  // Defaults to false
                        //'letter-spacing'=> true,  // Defaults to false
                        'color' => true,
                        'text-align' => true,
                        'preview' => true, // Disable the previewer
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'units' => 'px', // Defaults to px
                        'default' => array(
                            'color' => '#828282',
                            'font-weight' => '400',
                            'font-family' => 'Raleway',
                            'google' => true,
                            'font-size' => '14px',
                            'text-align' => 'left',
                            'line-height' => '24px'
                        ),
                        'preview' => array(
                            'text' => 'Sample Text'
                        )
                    ),
                    array(
                        'id' => 'tek-heading-typo',
                        'type' => 'typography',
                        'title' => esc_html__('Headings font settings', 'etalon'),
                        //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                        'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
                        // 'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style' => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'       => false, // Only appears if google is true and subsets not set to false
                        'font-size' => true,
                        'line-height' => true,
                        'text-transform' => true,
                        //'word-spacing'  => true,  // Defaults to false
                        //'letter-spacing'=> true,  // Defaults to false
                        'color' => true,
                        'text-align' => true,
                        'preview' => true, // Disable the previewer
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'units' => 'px', // Defaults to px
                        'default' => array(
                            'color' => '#2f2f2f',
                            'font-weight' => '700',
                            'font-family' => 'Montserrat',
                            'google' => true,
                            'font-size' => '34px',
                            'text-transform' => 'inherit',
                            'text-align' => 'center',
                            'line-height' => '45px'
                        ),
                        'preview' => array(
                            'text' => 'etalon Sample Text'
                        )
                    ),
                    array(
                        'id' => 'tek-menu-typo',
                        'type' => 'typography',
                        'title' => esc_html__('Menu font settings', 'etalon'),
                        //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                        'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
                        // 'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style' => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'       => false, // Only appears if google is true and subsets not set to false
                        'font-size' => true,
                        'line-height' => false,
                        'text-transform' => true,
                        //'word-spacing'  => true,  // Defaults to false
                        //'letter-spacing'=> true,  // Defaults to false
                        'color' => false,
                        'text-align' => false,
                        'preview' => true, // Disable the previewer
                        'all_styles' => false, // Enable all Google Font style/weight variations to be added to the page
                        'default' => array(
                            'font-weight' => '700',
                            'font-family' => 'Montserrat',
                            'font-size' => '13px',
                            'text-transform' => 'uppercase',
                        ),
                        'units' => 'px', // Defaults to px
                        'preview' => array(
                            'text' => 'Menu Item'
                        )
                    ),
                    array(
                        'id' => 'tek-topbar-typo',
                        'type' => 'typography',
                        'title' => esc_html__('Topbar font settings', 'etalon'),
                        //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                        'google' => false, // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-family' => false, // Disable google fonts. Won't work if you haven't defined your google api key
                        // 'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style' => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'       => false, // Only appears if google is true and subsets not set to false
                        'font-size' => true,
                        'line-height' => false,
                        //'word-spacing'  => true,  // Defaults to false
                        //'letter-spacing'=> true,  // Defaults to false
                        'color' => false,
                        'text-align' => false,
                        'preview' => false, // Disable the previewer
                        'all_styles' => false, // Enable all Google Font style/weight variations to be added to the page
                        'units' => 'px', // Defaults to px
                    ),
                    array(
                        'id' => 'tek-typekit',
                        'type' => 'text',
                        'title' => __('Typekit ID <a href="http://keydesign-themes.com/etalon/documentation#ops-typekit" target="_blank" class="el-icon-question-sign"></a>', 'etalon'),
                        'subtitle' => esc_html__('Paste here Typekit Kit ID', 'etalon'),
                        'mode' => 'text',
                        'theme' => 'chrome'
                    ),
                    array(
                        'id' => 'tek-body-typekit-selector',
                        'type' => 'text',
                        'title' => __('Typekit Body Font Selector <a href="https://helpx.adobe.com/typekit/using/css-selectors.html" target="_blank" class="el-icon-question-sign"></a>', 'etalon'),
                        'subtitle' => esc_html__('Copy paste the font family from typekit website', 'etalon'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-heading-typekit-selector',
                        'type' => 'text',
                        'title' => __('Typekit Headings Font Selector <a href="https://helpx.adobe.com/typekit/using/css-selectors.html" target="_blank" class="el-icon-question-sign"></a>', 'etalon'),
                        'subtitle' => esc_html__('Copy paste the font family from typekit website', 'etalon'),
                        'default' => ''
                    ),
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-th-list',
                'title' => esc_html__('Portfolio', 'etalon'),
                'compiler' => 'true',
                'fields' => array(
                    array(
                                'id' => 'tek-portfolio-title',
                                'type' => 'switch',
                                'title' => esc_html__('Show title', 'etalon'),
                                'subtitle' => esc_html__('Activate to display the portfolio item title in the content area.', 'etalon'),
                                'default' => '1',
                                'on' => 'Yes',
                                'off' => 'No',
                        ),
                    array(
                                'id' => 'tek-portfolio-social',
                                'type' => 'switch',
                                'title' => esc_html__('Social media section', 'etalon'),
                                'subtitle' => esc_html__('Activate to display the share on social media buttons.', 'etalon'),
                                'default' => '1',
                                'on' => 'Yes',
                                'off' => 'No',
                        ),
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-shopping-cart',
                'title' => esc_html__('Shop', 'etalon'),
                'compiler' => 'true',
                'fields' => array(
                    array(
                        'id' => 'tek-woo-single-sidebar',
                        'type' => 'switch',
                        'title' => esc_html__('WooCommerce Single Product Sidebar', 'etalon'),
                        'subtitle' => esc_html__('Enable/Disable Shop sidebar on single product page.', 'etalon'),
                        'default' => '0',
                        '1' => 'Yes',
                        '0' => 'No',
                    ),
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-pencil-alt',
                'title' => esc_html__('Blog', 'etalon'),
                'fields' => array(
                    array(
                        'id' => 'tek-blog-sidebar',
                        'type' => 'switch',
                        'title' => esc_html__('Display sidebar', 'etalon'),
                        'subtitle' => esc_html__('Turn on/off blog sidebar', 'etalon'),
                        'default' => true
                    ),
                    array(
                        'id' => 'tek-blog-minimal',
                        'type' => 'switch',
                        'title' => esc_html__('Grid View Blog', 'etalon'),
                        'subtitle' => esc_html__('Change blog layout to minimal grid view style', 'etalon'),
                        'default' => false
                    )
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-error-alt',
                'title' => esc_html__('404 Page', 'etalon'),
                'fields' => array(
                    array(
                        'id' => 'tek-404-title',
                        'type' => 'text',
                        'title' => esc_html__('Title', 'etalon'),
                        'default' => 'Error 404'
                        //
                    ),
                    array(
                        'id' => 'tek-404-subtitle',
                        'type' => 'text',
                        'title' => esc_html__('Subtitle', 'etalon'),
                        'default' => 'This page could not be found!'
                        //
                    ),
                    array(
                        'id' => 'tek-404-back',
                        'type' => 'text',
                        'title' => esc_html__('Back to homepage text', 'etalon'),
                        'default' => 'Back to homepage'
                        //
                    )
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-thumbs-up',
                'title' => esc_html__('Footer', 'etalon'),
                'fields' => array(

                    array(
                        'id' => 'tek-footer-fixed',
                        'type' => 'switch',
                        'title' => esc_html__('Set footer fixed to bottom', 'etalon'),
                        'subtitle' => esc_html__('Enable to activate this feature.', 'etalon'),
                        'default' => true
                    ),
                    array(
                        'id' => 'tek-backtotop',
                        'type' => 'switch',
                        'title' => esc_html__('Show back to top button', 'etalon'),
                        'subtitle' => esc_html__('Enable to display the back to top button.', 'etalon'),
                        'default' => true
                    ),
                    array(
                        'id' => 'tek-footer-business-info',
                        'type' => 'switch',
                        'title' => esc_html__('Display footer panel', 'etalon'),
                        'subtitle' => esc_html__('Enable to display a business info panel.', 'etalon'),
                        'default' => true
                    ),
                    array(
                        'id' => 'tek-footer-bussiness-template',
                        'type' => 'select',
                        'title' => esc_html__('Footer panel template', 'etalon'),
                        'required' => array('tek-footer-business-info','equals', true),
                        'options'  => array(
                            '1' => 'Business info (address, phone, email)',
                            '2' => 'Social icons + Newsletter form',
                        ),
                        'default' => '1'
                    ),
                    array(
                        'id' => 'tek-footer-panel-formid',
                        'type' => 'select',
                        'data' => 'posts',
                        'args' => array( 'post_type' => 'wpcf7_contact_form', ),
                        'title' => esc_html__('Newsletter Form', 'etalon'),
                        'required' => array('tek-footer-bussiness-template','equals','2'),
                        'default' => ''
                    ),
                    array(
                        'id' => 'tek-upper-footer-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Upper Footer Background', 'etalon'),
                        'default' => '',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-lower-footer-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Lower Footer Background', 'etalon'),
                        'default' => '',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-footer-heading-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Footer Headings Color', 'etalon'),
                        'default' => '',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-footer-text-color',
                        'type' => 'color',
                        'transparent' => false,
                        'title' => esc_html__('Footer Text Color', 'etalon'),
                        'default' => '',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-footer-text',
                        'type' => 'text',
                        'title' => esc_html__('Copyright Text', 'etalon'),
                        'subtitle' => esc_html__('Enter footer bottom copyright text', 'etalon'),
                        'default' => 'Copyright 2017 - Etalon by KeyDesign. All rights reserved.'
                    ),

                )
            );
            $this->sections[] = array(
                'title' => esc_html__('Import Demo ', 'etalon'),
                'desc' => __('Import Demo Content <a href="http://keydesign-themes.com/etalon/documentation#gs-importing-demo-content" target="_blank" class="el-icon-question-sign"></a>', 'etalon'),
                'icon' => 'el-icon-magic',
                'fields' => array(
                    array(
                        'id' => 'opt-import-export',
                        'type' => 'import_export',
                        'title' => __('Import Demo Content <a href="http://keydesign-themes.com/etalon/documentation#gs-importing-demo-content" target="_blank" class="el-icon-question-sign"></a>', 'etalon'),
                        'subtitle' => '',
                        'full_width' => false
                    )
                )
            );
        }
        /**

        All the possible arguments for Redux.
        For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

        * */
        public function setArguments()
        {
            $theme                         = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args                    = array(
                'opt_name' => 'redux_ThemeTek',
                'page_slug' => 'options_themetek',
                'page_title' => 'Theme Options',
                'dev_mode' => '0',
                'update_notice' => '1',
                'admin_bar' => '1',
                'menu_type' => 'submenu',
                'page_parent' => 'themes.php',
                'menu_title' => 'Theme Options',
                'allow_sub_menu' => '1',
                'page_parent_post_type' => 'your_post_type',
                'customizer' => false,
                'class' => '',
                'hints' => array(
                    'icon' => 'el-icon-question-sign',
                    'icon_position' => 'right',
                    'icon_size' => 'normal',
                    'tip_style' => array(
                        'color' => 'light'
                    ),
                    'tip_position' => array(
                        'my' => 'top left',
                        'at' => 'bottom right'
                    ),
                    'tip_effect' => array(
                        'show' => array(
                            'duration' => '500',
                            'event' => 'mouseover'
                        ),
                        'hide' => array(
                            'duration' => '500',
                            'event' => 'mouseleave unfocus'
                        )
                    )
                ),
                'output' => '1',
                'output_tag' => '1',
                'compiler' => '1',
                'page_icon' => 'icon-themes',
                'page_permissions' => 'manage_options',
                'save_defaults' => '1',
                'show_import_export' => '1',
                'transient_time' => '3600',
                'network_sites' => '1'
            );
            $theme                         = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args["display_name"]    = $theme->get("Name");
            $this->args["display_version"] = $theme->get("Version");

        }
    }
    global $reduxConfig;
    $reduxConfig = new keydesign_Redux_Framework_config();
}
/**
Custom function for the callback referenced above
*/
if (!function_exists('keydesign_my_custom_field')):
    function keydesign_my_custom_field($field, $value)
    {
        print_r($field);
        echo '
<br/>
';
        print_r($value);
    }
endif;
/**
Custom function for the callback validation referenced above
* */
if (!function_exists('keydesign_validate_callback_function')):
    function keydesign_validate_callback_function($field, $value, $existing_value)
    {
        $error           = false;
        $value           = 'just testing';
        /*
        do your validation

        if(something) {
        $value = $value;
        } elseif(something else) {
        $error = true;
        $value = $existing_value;
        $field['msg'] = 'your custom error message';
        }
        */
        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
