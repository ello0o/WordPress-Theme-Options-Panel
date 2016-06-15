<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * Backend functionality
 */
final class _FW_Component_Theme {
	private static $cache_key = 'fw_theme';

	final public function get_config($key = null, $default_value = null)
	{
		$cache_key = self::$cache_key .'/config';

		try {
			$config = FW_Cache::get($cache_key);
		} catch (FW_Cache_Not_Found_Exception $e) {
			// default values
			$config = array(
				/** Toggle Theme Settings form ajax submit */
				'settings_form_ajax_submit' => true,
				/** Toggle Theme Settings side tabs */
				'settings_form_side_tabs' => false,
				/** Toggle Tabs rendered all at once, or initialized only on open/display */
				'lazy_tabs' => true,
			);
		}

		return $key === null ? $config : fw_akg($key, $config, $default_value);
	}

	/**
	 * Search relative path in: child theme -> parent "theme" directory and return full path
	 * @param string $rel_path
	 * @return false|string
	 */
	public function locate_path($rel_path)
	{
		if( file_exists( fw_get_framework_directory( $rel_path ) ) ){
			return fw_get_framework_directory( $rel_path );
		}
		return false;
	}

	/**
	 * Return array with options from specified name/path
	 * @param string $name '{theme}/framework-customizations/theme/options/{$name}.php'
	 * @param array $variables These will be available in options file (like variables for view)
	 * @return array
	 */
	public function get_options($name, array $variables = array())
	{
		$path = $this->locate_path('/options/'. $name .'.php');

		if (!$path) {
			return array();
		}

		$variables = fw_get_variables_from_file($path, array('options' => array()), $variables);

		return $variables['options'];
	}

	public function get_settings_options()
	{
		$cache_key = self::$cache_key .'/options/settings';

		try {
			return FW_Cache::get($cache_key);
		} catch (FW_Cache_Not_Found_Exception $e) {
			$options = apply_filters('fw_settings_options', $this->get_options('settings'));

			FW_Cache::set($cache_key, $options);

			return $options;
		}
	}

	public function get_customizer_options()
	{
		$cache_key = self::$cache_key .'/options/customizer';

		try {
			return FW_Cache::get($cache_key);
		} catch (FW_Cache_Not_Found_Exception $e) {
			$options = apply_filters('fw_customizer_options', $this->get_options('customizer'));

			FW_Cache::set($cache_key, $options);

			return $options;
		}
	}

	public function get_post_options($post_type)
	{
		$cache_key = self::$cache_key .'/options/posts/'. $post_type;

		try {
			return FW_Cache::get($cache_key);
		} catch (FW_Cache_Not_Found_Exception $e) {
			$options = apply_filters('fw_post_options', $this->get_options('posts/'. $post_type), $post_type);

			FW_Cache::set($cache_key, $options);

			return $options;
		}
	}

	public function get_taxonomy_options($taxonomy)
	{
		$cache_key = self::$cache_key .'/options/taxonomies/'. $taxonomy;

		try {
			return FW_Cache::get($cache_key);
		} catch (FW_Cache_Not_Found_Exception $e) {
			$options = apply_filters('fw_taxonomy_options',
				$this->get_options('taxonomies/'. $taxonomy),
				$taxonomy
			);

			FW_Cache::set($cache_key, $options);

			return $options;
		}
	}

}
