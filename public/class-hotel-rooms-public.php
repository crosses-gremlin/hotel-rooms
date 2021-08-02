<?php
/**
 * Description document
 *
 * @file
 * @package package
 */

/**
 * Class Hotel_Rooms_Public
 */
class Hotel_Rooms_Public {

	/**
	 * Description
	 *
	 * @var string $plugin_name
	 */
	private $plugin_name;

	/**
	 * Description
	 *
	 * @var string $version
	 */
	private $version;

	/**
	 * Hotel_Rooms_Public constructor.
	 *
	 * @param string $plugin_name description.
	 * @param string $version description.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Description
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/hotel-rooms-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Description
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/hotel-rooms-public.js', array( 'jquery' ), $this->version, true );
		$params = array(
			'l18n' => array(),
			'vars' => array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'hotel-rooms-nonce' ),
				'error'   => __( 'Error', HR_PLUGIN_SLUG ),
			)
		);
		wp_localize_script( $this->plugin_name, 'hotel_rooms', $params );

	}

	/**
	 * Description
	 */
	public function hotel_rooms_shortcode_function( $atts ) {
		$atts = shortcode_atts( array(
			'rooms'       => '',
			'numberposts' => '',
			'orderby'     => '',
			'order'       => '',
			'color'       => '#177245',
			'title'       => __( 'Special offer', HR_PLUGIN_SLUG ),
		), $atts );

		$content = "<div class='hotel-rooms' data-rooms='{$atts['rooms']}' data-numberposts='{$atts['numberposts']}'";
		$content .= " data-orderby='{$atts['orderby']}' data-order='{$atts['order']}' style='--hotel-rooms-color: {$atts['color']}'>";

		if ( $atts['title'] != '' ):
			$content .= "<div class='hotel-rooms__header'>{$atts['title']}</div>";
		endif;
		$content .= "<div class='hotel-rooms-list'></div>";
		$content .= "</div>";

		return $content;
	}
}
