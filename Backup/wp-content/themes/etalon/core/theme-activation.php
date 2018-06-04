<?php
// ------------------------------------------------------------------------
// Include the TGM_Plugin_Activation class
// ------------------------------------------------------------------------

include_once (get_template_directory() . '/core/assets/extra/class-tgm-plugin-activation.php');

// Register the required plugins for this theme.

if (!function_exists('keydesign_register_plugins'))
	{
	function keydesign_register_plugins()
		{
		$plugins = array(
			array(
				'name' => esc_html__('Etalon Framework', 'etalon'),
				'slug' => 'etalon-framework',
				'source' => 'http://www.keydesign-themes.com/etalon/external/etalon-framework.zip',
				'required' => true,
				'force_activation' => false,
				'force_deactivation' => true,
				'external_url' => 'http://www.keydesign-themes.com/etalon/external/etalon-framework.zip',
				'version' => '3.6',
			),
			array(
				'name' => esc_html__('Wordpress Importer', 'etalon'),
				'slug' => 'wordpress-importer',
				'source' => KEYDESIGN_THEME_PLUGINS_DIR . '/wordpress-importer.zip',
				'required' => true,
				'version' => '',
				'force_activation' => false,
				'force_deactivation' => true,
				'external_url' => '',
			),
			array(
				'name' => esc_html__('WPBakery Visual Composer', 'etalon'),
				'slug' => 'js_composer',
				'source' => KEYDESIGN_THEME_PLUGINS_DIR . '/js_composer.zip',
				'required' => true,
				'version' => '5.4.2',
				'force_activation' => false,
				'force_deactivation' => true,
				'external_url' => '',
			),
			array(
				'name' => esc_html__('Slider Revolution', 'etalon'),
				'slug' => 'revslider',
				'source' => KEYDESIGN_THEME_PLUGINS_DIR . '/revslider.zip',
				'required' => true,
				'version' => '5.4.6.3',
				'force_activation' => false,
				'force_deactivation' => true,
				'external_url' => '',
			),
			array(
				'name' => esc_html__('KeyDesign Addon', 'etalon'),
				'slug' => 'keydesign-addon',
				'source' => 'http://www.keydesign-themes.com/etalon/external/keydesign-addon.zip',
				'required' => true,
				'force_activation' => false,
				'force_deactivation' => true,
				'external_url' => 'http://www.keydesign-themes.com/etalon/external/keydesign-addon.zip',
				'version' => '1.9.2',
			),
			array(
				'name' => esc_html__('WooCommerce', 'etalon'),
				'slug' => 'woocommerce',
				'required' => false,
			),
			array(
				'name' => esc_html__('Contact Form 7', 'etalon'),
				'slug' => 'contact-form-7',
				'required' => true,
			),
			array(
				'name' => esc_html__('Breadcrumb NavXT', 'etalon'),
				'slug' => 'breadcrumb-navxt',
				'required' => false,
			),
		);

		// Change this to your theme text domain, used for internationalising strings

		$etalon_theme_text_domain = 'etalon';
		$config = array(
			'domain' => $etalon_theme_text_domain,
			'default_path' => '',
			'parent_slug' => 'themes.php',
			'menu' => 'install-required-plugins',
			'has_notices' => true,
			'is_automatic' => true,
			'message' => '',
			'strings' => array(
				'page_title' => esc_html__('Install Required Plugins', 'etalon'),
				'menu_title' => esc_html__('Install Plugins', 'etalon'),
				'installing' => esc_html__('Installing Plugin: %s', 'etalon'),
				'oops' => esc_html__('Something went wrong with the plugin API.', 'etalon') ,
				'notice_can_install_required' => esc_html__('This theme requires the following plugin: %1$s.', 'etalon'),
				'notice_can_install_recommended' => esc_html__('This theme recommends the following plugin: %1$s.', 'etalon'),
				'notice_cannot_install' => esc_html__('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'etalon'),
				'notice_can_activate_required' => esc_html__('The following required plugin is currently inactive: %1$s.', 'etalon'),
				'notice_can_activate_recommended' => esc_html__('The following recommended plugin is currently inactive: %1$s.', 'etalon'),
				'notice_cannot_activate' => esc_html__('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'etalon'),
				'notice_ask_to_update' => esc_html__('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'etalon'),
				'notice_cannot_update' => esc_html__('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'etalon'),
				'install_link' => esc_html__('Begin installing plugin', 'etalon') ,
				'activate_link' => esc_html__('Activate installed plugin', 'etalon') ,
				'return' => esc_html__('Return to Required Plugins Installer', 'etalon') ,
				'plugin_activated' => esc_html__('Plugin activated successfully.', 'etalon') ,
				'complete' => esc_html__('All plugins installed and activated successfully. %s', 'etalon'),
				'nag_type' => 'updated'
			)
		);
		tgmpa($plugins, $config);
		}
	}

add_action('tgmpa_register', 'keydesign_register_plugins');
?>
