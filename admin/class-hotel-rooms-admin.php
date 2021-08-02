<?php
/**
 * Description document
 *
 * @file
 * @package package
 */

/**
 * Class Hotel_Rooms_Admin
 */
class Hotel_Rooms_Admin {

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
	 * Hotel_Rooms_Admin constructor.
	 *
	 * @param string $plugin_name description.
	 * @param string $version description.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		add_action( 'admin_menu', array( $this, 'addPluginAdminMenu' ), 9 );
		add_action( 'admin_init', array( $this, 'registerAndBuildFields' ) );
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'add_meta_boxes', array( $this, 'hotel_rooms_add_custom_box' ) );
		add_action( 'save_post', array( $this, 'hotel_rooms_save_postdata' ), 1, 2 );
		add_action( 'admin_notices', array( $this, 'hotel_rooms_show_messages' ) );
	}

	/**
	 * Description
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/hotel-rooms-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Description
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/hotel-rooms-admin.js', array( 'jquery' ), $this->version, true );

	}

	/**
	 * Description
	 */
	public function addPluginAdminMenu() {

		add_submenu_page( 'edit.php?post_type=' . HR_PLUGIN_SLUG, 'Settings', 'Settings', 'administrator', 'manage_settings', array(
			$this,
			'displayPluginAdminDashboard'
		) );

	}

	/**
	 * Description
	 */
	public function displayPluginAdminDashboard() {

		require_once 'partials/' . $this->plugin_name . '-admin-settings-display.php';

	}

	/**
	 * Description
	 */
	public function registerAndBuildFields() {
		add_settings_section(
			'hotel_rooms_general_section',
			'',
			array( $this, 'display_general_account' ),
			'hotel_rooms_general_settings'
		);
		unset( $args );
		$args = array(
			'type'       => 'input',
			'subtype'    => 'checkbox',
			'id'         => 'hotel_rooms_remove_data',
			'name'       => 'hotel_rooms_remove_data',
			'required'   => '',
			'value_type' => 'normal'
		);

		add_settings_field(
			'hotel_rooms_remove_data',
			__( 'Remove all data after plugin uninstall', HR_PLUGIN_SLUG ),
			array( $this, 'render_settings_field' ),
			'hotel_rooms_general_settings',
			'hotel_rooms_general_section',
			$args
		);

		register_setting(
			'hotel_rooms_general_settings',
			'hotel_rooms_remove_data'
		);
	}

	/**
	 * Description
	 *
	 * @param array $args description.
	 */
	public function render_settings_field( $args ) {

		$wp_data_value = get_option( $args['name'] );

		switch ( $args['type'] ) {

			case 'input':
				$value = ( $args['value_type'] == 'serialized' ) ? esc_attr( serialize( $wp_data_value ) ) : esc_attr( $wp_data_value );
				if ( $args['subtype'] != 'checkbox' ) {
					$prependStart = ( isset( $args['prepend_value'] ) ) ? '<div class="input-prepend">
 									<span class="add-on">' . $args['prepend_value'] . '</span>' : '';
					$prependEnd   = ( isset( $args['prepend_value'] ) ) ? '</div>' : '';
					$step         = ( isset( $args['step'] ) ) ? 'step="' . $args['step'] . '"' : '';
					$min          = ( isset( $args['min'] ) ) ? 'min="' . $args['min'] . '"' : '';
					$max          = ( isset( $args['max'] ) ) ? 'max="' . $args['max'] . '"' : '';
					if ( isset( $args['disabled'] ) ) {
						echo "{$prependStart}<input type='{$args['subtype']}' id='{$args['id']}_disabled' {$step}
						 {$max} {$min} name='{$args['name']}_disabled' size='40' disabled value=' {$value} '/>
							<input type='hidden' id='{$args['id']}' {$step} {$max} {$min} name='{$args['name']}' 
							size=']40' value=' {$value} '/>{$prependEnd}";
					} else {
						echo "{$prependStart}<input type='{$args['subtype']}' id='{$args['id']}' {$args['required']}
						 {$step} {$max} {$min} name='{$args['name']}' size='40' value='{$value}' />{$prependEnd}";
					}

				} else {
					$checked = ( $value ) ? 'checked' : '';
					echo "<input type='{$args['subtype']}' id='{$args['id']}' {$args['required']} name='{$args['name']}' size='40' value='1' {$checked} />";
				}
				break;
			default:
				break;
		}
	}

	/**
	 * Description
	 */
	public function display_general_account() {

		echo "<p>" . __( 'For using plugin put shortcode [hotel_rooms] somewhere on the page. It is possible to use more than 1 shortcode on the page', HR_PLUGIN_SLUG ) . "</p>";
		echo "<p>" . __( 'Possible attributes', HR_PLUGIN_SLUG ) . ":</p>";
		echo "<p><strong>rooms='1,2'</strong> - " . __( 'which rooms should be selected', HR_PLUGIN_SLUG ) . "</p>";
		echo "<p><strong>numberposts='1'</strong> - " . __( 'count rooms in the list', HR_PLUGIN_SLUG ) . "</p>";
		echo "<p><strong>orderby='date'</strong> - " . __( 'order for the list', HR_PLUGIN_SLUG ) . "</p>";
		echo "<p><strong>order='DESC'</strong> - " . __( 'type order for the list', HR_PLUGIN_SLUG ) . "</p>";
		echo "<p><strong>color='#177245'</strong> - " . __( 'color for the data', HR_PLUGIN_SLUG ) . "</p>";
		echo "<p><strong>title='Special offer'</strong> - " . __( 'title of the list', HR_PLUGIN_SLUG ) . "</p>";

	}

	/**
	 * Description
	 */
	public function register_post_type() {
		register_post_type( HR_PLUGIN_SLUG, array(
			'labels'             => array(
				'name'          => __( 'Hotel rooms', HR_PLUGIN_SLUG ),
				'singular_name' => __( 'Hotel room', HR_PLUGIN_SLUG ),
				'menu_name'     => __( 'Hotel rooms', HR_PLUGIN_SLUG )
			),
			'public'             => false,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'supports'           => array( 'title', 'editor', 'thumbnail' )
		) );
	}

	/**
	 * Description
	 */
	public function hotel_rooms_add_custom_box() {
		$screens = array( HR_PLUGIN_SLUG );
		add_meta_box( HR_PLUGIN_SLUG . '_sectionid', __( 'Room configuration', HR_PLUGIN_SLUG ), array(
			$this,
			'meta_box_callback'
		), $screens );
	}

	/**
	 * Description
	 *
	 * @param object $post post.
	 * @param array $meta meta.
	 */
	public function meta_box_callback( $post, $meta ) {
		$screens = $meta['args'];

		wp_nonce_field( plugin_basename( __FILE__ ), HR_PLUGIN_SLUG . '_nonce' );

		$hr_hotel_name     = get_post_meta( $post->ID, 'hr_hotel_name', 1 );
		$hr_room_name      = get_post_meta( $post->ID, 'hr_room_name', 1 );
		$hr_rate           = get_post_meta( $post->ID, 'hr_rate', 1 );
		$hr_adult          = get_post_meta( $post->ID, 'hr_adult', 1 );
		$hr_child          = get_post_meta( $post->ID, 'hr_child', 1 );
		$hr_cost           = get_post_meta( $post->ID, 'hr_cost', 1 );
		$hr_arrival_date   = get_post_meta( $post->ID, 'hr_arrival_date', 1 );
		$hr_departure_date = get_post_meta( $post->ID, 'hr_departure_date', 1 );

		ob_start();
		require_once 'partials/' . $this->plugin_name . '-admin-display.php';
		$content = ob_get_contents();
		ob_clean();
		echo $content;
	}

	/**
	 * Description
	 *
	 * @param int $post_id description.
	 * @param object $post description.
	 */
	function hotel_rooms_save_postdata( $post_id, $post ) {

		if ( ! isset( $_POST['hotel_rooms'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST[ HR_PLUGIN_SLUG . '_nonce' ], plugin_basename( __FILE__ ) ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( 'revision' === $post->post_type ) {
			return;
		}

		if ( $_POST['hotel_rooms']['hr_arrival_date'] > $_POST['hotel_rooms']['hr_departure_date'] ) {
			$error   = __( 'Arrival date must be less than departure date', HR_PLUGIN_SLUG );
			$user_id = get_current_user_id();
			set_transient( "my_save_post_errors_{$post_id}_{$user_id}", $error, 45 );

			return;
		}

		$hotel_rooms_meta = $_POST['hotel_rooms'];

		foreach ( $hotel_rooms_meta as $key => $value ) :

			$value = sanitize_text_field( $value );

			if ( get_post_meta( $post_id, $key, false ) ) {
				update_post_meta( $post_id, $key, $value );
			} else {
				add_post_meta( $post_id, $key, $value );
			}

			if ( ! $value ) {
				delete_post_meta( $post_id, $key );
			}

		endforeach;
	}

	/**
	 * Description
	 */
	public function get_hotel_rooms_callback() {
		check_ajax_referer( 'hotel-rooms-nonce', 'nonce_code' );
		$rooms       = trim( $_GET['rooms'] );
		$numberposts = trim( $_GET['numberposts'] );
		$orderby     = trim( $_GET['orderby'] );
		$order       = trim( $_GET['order'] );
		$data        = array();
		$posts       = get_posts( array(
			'include'     => $rooms,
			'numberposts' => $numberposts,
			'orderby'     => $orderby,
			'order'       => $order,
			'post_type'   => HR_PLUGIN_SLUG
		) );
		foreach ( $posts as $key => $post ) {
			$data[ $key ]['hr_hotel_name']     = get_post_meta( $post->ID, 'hr_hotel_name', 1 );
			$data[ $key ]['hr_room_name']      = get_post_meta( $post->ID, 'hr_room_name', 1 );
			$data[ $key ]['hr_rate']           = get_post_meta( $post->ID, 'hr_rate', 1 );
			$data[ $key ]['hr_adult']          = get_post_meta( $post->ID, 'hr_adult', 1 );
			$data[ $key ]['hr_child']          = get_post_meta( $post->ID, 'hr_child', 1 );
			$data[ $key ]['hr_cost']           = get_post_meta( $post->ID, 'hr_cost', 1 );
			$data[ $key ]['hr_arrival_date']   = get_post_meta( $post->ID, 'hr_arrival_date', 1 );
			$data[ $key ]['hr_departure_date'] = get_post_meta( $post->ID, 'hr_departure_date', 1 );
			if ( has_post_thumbnail( $post ) ) {
				$data[ $key ]['img'] = wp_get_attachment_image( get_post_thumbnail_id( $post->ID ), 'large', false, array(
					'title' => $data[ $key ]['hr_hotel_name'],
					'class' => 'hotel-room__img'
				) );
			} else {
				$data[ $key ]['img'] = "<img class='hotel-room__img' src='" . HR_URL . "public/images/hotel.jpg' alt='{$data[ $key ]['hr_hotel_name']}'/>";
			}
		}
		ob_start();
		include_once HR_PATH . 'public/partials/' . $this->plugin_name . '-list-public-display.php';
		$content = ob_get_contents();
		ob_clean();
		echo $content;
		wp_die();
	}

	/**
	 * Description
	 */
	public function hotel_rooms_show_messages() {
		global $post;
		$post_id = $post->ID;
		$user_id = get_current_user_id();

		if ( $error = get_transient( "my_save_post_errors_{$post_id}_{$user_id}" ) ) { ?>
            <div class="error">
            <p><?php echo $error ?></p>
            </div><?php

			delete_transient( "my_save_post_errors_{$post_id}_{$user_id}" );
		}
	}
}

