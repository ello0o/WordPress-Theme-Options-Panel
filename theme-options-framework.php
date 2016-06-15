<?php if (!defined('FW')) define('FW', true);

if(!function_exists('fw_get_framework_directory')){
	function fw_get_framework_directory( $rel_path = '' ){
		return __dir__.$rel_path;
	}
}

if(!function_exists('fw_get_framework_directory_uri')){
	function fw_get_framework_directory_uri( $rel_path = '' ){
		$fw_dir = get_stylesheet_directory_uri().'/'.basename(__DIR__);

		return $fw_dir.$rel_path;	
	}
}



/**
 * Main framework class that contains everything
 *
 * Convention: All public properties should be only instances of the components (except special property: manifest)
 */
if(!class_exists('_Fw')){
	final class _Fw
	{
		/** @var bool If already loaded */
		private static $loaded = false;

		/** @var FW_Framework_Manifest */
		public $manifest;


		/** @var _FW_Component_Backend */
		public $backend;


		public function __construct()
		{
			if (self::$loaded) {
				trigger_error('Framework already loaded', E_USER_ERROR);
			} else {
				self::$loaded = true;
			}

			// components
			{
				require fw_get_framework_directory('/core/components/theme.php');
				$this->theme = new _FW_Component_Theme();

				require fw_get_framework_directory('/core/components/backend.php');
				$this->backend = new _FW_Component_Backend();

				$this->backend->_init();
			}
		}
	}
}

/**
 * @return _FW Framework instance
 */
if(!function_exists('fw')){
	function fw() {
		static $FW = null; // cache

		if ($FW === null) {
			$FW = new _Fw();
		}

		return $FW;
	}
}

require fw_get_framework_directory('/helpers/general.php');
require fw_get_framework_directory('/helpers/class-fw-request.php');
require fw_get_framework_directory('/helpers/class-fw-session.php');
require fw_get_framework_directory('/helpers/class-fw-flash-messages.php');
require fw_get_framework_directory('/helpers/class-fw-form.php');
require fw_get_framework_directory('/helpers/class-fw-access-key.php');
require fw_get_framework_directory('/helpers/class-fw-cache.php');
require fw_get_framework_directory('/core/extends/class-fw-option-type.php');
require fw_get_framework_directory('/core/extends/class-fw-container-type.php');
require fw_get_framework_directory('/core/extends/interface-fw-option-handler.php'); // option handler )(experimental)
require fw_get_framework_directory('/helpers/class-fw-wp-meta.php');
require fw_get_framework_directory('/helpers/class-fw-wp-option.php');
require fw_get_framework_directory('/helpers/database.php');

require fw_get_framework_directory('/includes/hooks.php');