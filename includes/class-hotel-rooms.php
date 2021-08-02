<?php
/**
 * Description document
 *
 * @file
 * @package package
 */

/**
 * Class Hotel_Rooms
 */
class Hotel_Rooms {

	/**
	 * Loader
	 *
	 * @var Hotel_Rooms_Loader $loader
	 */
	protected $loader;
	/**
	 * Plugin name
	 *
	 * @var string $plugin_name
	 */
	protected $plugin_name;

	/**
	 * Plugin version
	 *
	 * @var string $version
	 */
	protected $version;

	/**
	 * Hotel_Rooms constructor.
	 */
	public function __construct() {
		if ( defined( 'HR_VERSION' ) ) {
			$this->version = HR_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = HR_PLUGIN_SLUG;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Description
	 */
	private function load_dependencies() {

		require_once HR_PATH . 'includes/class-hotel-rooms-loader.php';

		require_once HR_PATH . 'includes/class-hotel-rooms-i18n.php';

		require_once HR_PATH . 'admin/class-hotel-rooms-admin.php';

		require_once HR_PATH . 'public/class-hotel-rooms-public.php';

		$this->loader = new Hotel_Rooms_Loader();

	}

	/**
	 *  Description
	 */
	private function set_locale() {

		$plugin_i18n = new Hotel_Rooms_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 *  Description
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Hotel_Rooms_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		if ( wp_doing_ajax() ) {
			$this->loader->add_action( 'wp_ajax_get_hotel_rooms', $plugin_admin, 'get_hotel_rooms_callback' );
			$this->loader->add_action( 'wp_ajax_nopriv_get_hotel_rooms', $plugin_admin, 'get_hotel_rooms_callback' );
		}
	}

	/**
	 *  Description
	 */
	private function define_public_hooks() {

		$plugin_public = new Hotel_Rooms_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_shortcode( 'hotel_rooms', $plugin_public, 'hotel_rooms_shortcode_function' );

	}

	/**
	 *  Description
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 *  Description
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 *  Description
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 *  Description
	 */
	public function get_version() {
		return $this->version;
	}
}
